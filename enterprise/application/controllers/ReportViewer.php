<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportViewer extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    // Setting Login user Role
    // superadmin, 1 = Enterprize, 2 = SubEnterprize, 3 = Report Viewer
    $userRole = $this->session->userdata('loginData')['User_Role'];

    if ($userRole == 1 || $userRole == 2 || $userRole == 3) {
      // if Subenterprize and report viewer accessing this page
      $this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>' . $this->uri->segment(2) . '</b> page');
      redirect('Dashboard');
    }

    if ($userRole == 'superadmin') {
      // Setting Enterprize List
      // Enterprise_Status -> 0-Active, 1-Deactive  
      $queryEnterprizeList = "SELECT ge.Enterprise_ID, ge.Enterprise_Name
        FROM GAME_ENTERPRISE ge
        WHERE ge.Enterprise_Status = 0
        ORDER BY ge.Enterprise_ID DESC";
      $enterprizeList = $this->Common_Model->executeQuery($queryEnterprizeList);
      // print_r($enterprizeList); print_r($enterprizeList[0]->Enterprise_ID); exit();
      $content['enterprizeList'] = $enterprizeList;
    }

    // Setting Report Viewer List
    $query = "SELECT rv.*, ge.Enterprise_ID, ge.Enterprise_Name, ( SELECT DISTINCT Count(*) FROM GAME_REPORT_VIEWER_CARD_ACCESS rvca WHERE rvca.RVCA_EnterpriseID = rv.RV_EnterpriseID AND rvca.RVCA_RV_ID = rv.RV_ID ) AS cardCount
    FROM GAME_REPORT_VIEWER rv 
    LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = rv.RV_EnterpriseID";

    if ($userRole == 1) {
      // if enterprize is login
      $enterprizeID = $this->session->userdata('loginData')['User_Id'];
      $query .= " WHERE rv.RV_EnterpriseID = ".$enterprizeID;
    }
    $query .= " ORDER BY rv.RV_ID DESC";

    // print_r($query); exit();
    $details = $this->Common_Model->executeQuery($query);
    // print_r($details); print_r($details[0]->RV_ID); exit();

    $content['details'] = $details;

    $content['subview']  = 'reportViewer';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function AddReportViewer() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      // setting rules for checking submitted form
      $this->form_validation->set_rules('enterprizeID', 'Enterprize', 'trim|required|is_natural_no_zero');
      $this->form_validation->set_rules('reportViewerName', 'Name', 'trim|required');
      $this->form_validation->set_rules('reportViewerPassword', 'Password', 'trim|required');

      // Setting Email ID for Verification
      $checkEmailID = $this->input->post('reportViewerEmailID');
      
      $whereAdminUser    = array('email' => $checkEmailID);
      $whereEnterprise   = array('Enterprise_Email' => $checkEmailID);
      $whereReportViewer = array('RV_Email_ID' => $checkEmailID);

      $detailsAdminUser    = $this->Common_Model->fetchRecords('GAME_ADMINUSERS', $whereAdminUser, 'email', '');
      $detailsEnterprise   = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $whereEnterprise, 'Enterprise_Email', '');
      $detailsReportViewer = $this->Common_Model->fetchRecords('GAME_REPORT_VIEWER', $whereReportViewer, 'RV_Email_ID', '');

      if (isset($detailsAdminUser[0]->email)) {
        $verifyEmailID = '|is_unique[GAME_ADMINUSERS.email]';
      }
      else if (isset($detailsEnterprise[0]->Enterprise_Email)) {
        $verifyEmailID = '|is_unique[GAME_ENTERPRISE.Enterprise_Email]';
      }
      else if (isset($detailsReportViewer[0]->RV_Email_ID)) {
        $verifyEmailID = '|is_unique[GAME_REPORT_VIEWER.RV_Email_ID]';
      }
      else {
        $verifyEmailID = '';
      }
      $this->form_validation->set_rules('reportViewerEmailID', 'Email ID already present,', 'trim|required|valid_email|valid_emails'.$verifyEmailID);

      // sending error message if any
      if ($this->form_validation->run() == false) {
        $response = array(
          'status'  => 'error',
          'message' => array(
            'enterprizeIDError'         => form_error('enterprizeID'),
            'reportViewerNameError'     => form_error('reportViewerName'),
            'reportViewerEmailIDError'  => form_error('reportViewerEmailID'),
            'reportViewerPasswordError' => form_error('reportViewerPassword'),
          )
        );
        // print_r($response); exit();

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
        // die(json_encode($response));
      }
      else {
        // RV_Status -> 0->Active, 1->Deactive
        $insertArray = array(
          'RV_EnterpriseID' => $this->input->post('enterprizeID'),
          'RV_Name'         => $this->input->post('reportViewerName'),
          'RV_Email_ID'     => $this->input->post('reportViewerEmailID'),
          'RV_Password'     => $this->input->post('reportViewerPassword'),
          'RV_Created_On'   => date('Y-m-d H:i:s', time()),
          'RV_Status'       => 0,
        );
        
        // inserting new Record
        $result = $this->Common_Model->insert("GAME_REPORT_VIEWER", $insertArray, '');

        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Report Viewer Added Successfully.', 'button' => 'btn btn-success']));
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Report Viewer can not be Added.', 'button' => 'btn btn-danger']));
    }
  } // end of AddReportViewer function

  public function reportViewerCardAccess($reportViewerID=NULL) {
    $reportViewerID = base64_decode($reportViewerID);
    // print_r($reportViewerID);

    if ($reportViewerID) {
      // Setting Report Viewer Details
      $query = "SELECT rv.*, ge.Enterprise_ID, ge.Enterprise_Name
      FROM GAME_REPORT_VIEWER rv 
      LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = rv.RV_EnterpriseID 
      WHERE rv.RV_ID = $reportViewerID 
      LIMIT 1";

      $details = $this->Common_Model->executeQuery($query);
      // print_r($details); print_r($details[0]->RV_ID); exit();
      $content['details'] = $details;

      // Setting report viewer Enterprize ID
      $enterprizeID = $details[0]->Enterprise_ID;

      // Query to get game list
      $query = "SELECT DISTINCT gg.Game_ID, gg.Game_Name, gg.Game_Category, gg.Game_Header, gg.Game_Image, gg.Game_Comments, geg.EG_ID, geg.EG_EnterpriseID, geg.EG_GameID, rvca.RVCA_ID, rvca.RVCA_EnterpriseID, rvca.RVCA_RV_ID, rvca.RVCA_Game_ID
      FROM GAME_ENTERPRISE_GAME geg
      LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID
      LEFT JOIN GAME_REPORT_VIEWER_CARD_ACCESS rvca ON rvca.RVCA_Game_ID = geg.EG_GameID AND rvca.RVCA_RV_ID = $reportViewerID
      WHERE gg.Game_Delete = 0 AND geg.EG_EnterpriseID = $enterprizeID
      ORDER BY rvca.RVCA_ID DESC, gg.Game_Name ASC";

      // print_r($query); exit();
      $gameList = $this->Common_Model->executeQuery($query);
      // print_r($gameList); print_r($gameList[0]->Game_Name); exit();
      $content['gameList'] = $gameList;

      $content['subview']  = 'reportViewerCardAccess';
      $this->load->view('main_layout', $content);
    }
    else {
      redirect('reportViewer');
    }
  } // end of reportViewerCardAccess function

  public function giveCardAccess($enterprizeID=NULL, $reportViewerID=NULL) {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // if enterprize id is not set
      if (empty($enterprizeID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Card Access not given to Report Viewer.', 'button' => 'btn btn-danger']));
      }
      // if report viewer id is not set
      else if (empty($reportViewerID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Card Access not given to Report Viewer.', 'button' => 'btn btn-danger']));
      }
      else {
        // deleting all previous present record
        $deleteWhere = array(
          'RVCA_EnterpriseID' => $enterprizeID,
          'RVCA_RV_ID'        => $reportViewerID,
        );

        $resultDelete = $this->Common_Model->deleteRecords("GAME_REPORT_VIEWER_CARD_ACCESS", $deleteWhere);

        $message = 'Card De-Allocate to report viewer Successfully.';

        // setting Card (game) ID
        $selectedGamesList = $this->input->post('selectedGames'); // Array type
        // print_r($selectedGamesList); exit();

        // checking any card is selected or not
        if (!empty($selectedGamesList)) {
          // looping to each selected game
          for ($i=0; $i<count($selectedGamesList); $i++) {
            // inserting new records
            $insertArray = array(
              'RVCA_EnterpriseID' => $enterprizeID,
              'RVCA_RV_ID'        => $reportViewerID,
              'RVCA_Game_ID'      => $selectedGamesList[$i],
              'RVCA_Created_On'   => date('Y-m-d H:i:s', time()),
            );

            $resultInsert = $this->Common_Model->insert("GAME_REPORT_VIEWER_CARD_ACCESS", $insertArray, '');
          }

          $message = 'Card Allocate to report viewer Successfully.';
        }

        // Sending success message
        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => $message, 'button' => 'btn btn-success']));

      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Card Access not given to Report Viewer.', 'button' => 'btn btn-danger']));
    }
  } // end of giveCardAccess function
} // end of ReportViewer class 
