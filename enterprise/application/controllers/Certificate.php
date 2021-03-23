<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    // echo "<pre>"; print_r($this->session->userdata('loginData'));
    $loginId = $this->session->userdata('loginData')['User_Id'];

    // Setting Login user Role
    // superadmin, 1 = Enterprize, 2 = SubEnterprize, 3 = Report Viewer
    $userRole = $this->session->userdata('loginData')['User_Role'];

    if ($userRole == 1 || $userRole == 2 || $userRole == 3) {
      // if Subenterprize and report viewer accessing this page
      $this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>' . $this->uri->segment(2) . '</b> page');
      redirect('Dashboard');
    }
    // ========================================================

    // user is supperadmin
    $where = array(
      'Enterprise_Status' => 0,
    );

    $content['EnterpriseName'] = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $where, '', 'Enterprise_Name');

    $content['subview']  = 'certificate';
    $this->load->view('main_layout', $content);
  } // end of index function

  // to get the list of users associated with the games
  public function getCertificateTableData() {
    // print_r($this->input->post());
    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      $enterpriseId    = $this->input->post('enterpriseId');
      $cardID          = $this->input->post('gameId');

      $startDate = date('Y-m-d H:i:s', strtotime($this->input->post('gamestartdate').' 00:00:00'));
      $endDate = date('Y-m-d H:i:s', strtotime($this->input->post('gameenddate').' 23:59:59'));

      $startDateTimeStamp = strtotime(date($startDate));
      $endDateTimeStamp   = strtotime(date($endDate));
      // print_r(strtotime(date($endDateTimeStamp))); exit();

      if ($endDateTimeStamp <= $startDateTimeStamp) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please make sure End Date is greater then Start Date.', 'button' => 'btn btn-danger']));
      }
      else {
        // getting total users
        $totalUserSql = "SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gug.UG_CratedOn, ge.Enterprise_ID, ge.Enterprise_Name, gg.Game_Name 
        FROM GAME_SITE_USERS gsu 
        LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId
        LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id
        LEFT JOIN GAME_GAME gg ON gg.Game_ID = $cardID
        WHERE gsu.User_Delete = 0 AND gug.UG_GameID = $cardID AND gsu.User_ParentId = ".$enterpriseId;

        // Total users
        $totalUser = $this->Common_Model->executeQuery($totalUserSql);
        // print_r($totalUser); exit();
        // print_r($totalUser[0]->Game_Name); exit();
        // =====================================================

        // Making Report one datatable 
        $returnTableHTML = '<table class="stripe hover multiple-select-row data-table-export"> <thead> <tr> <th>Sl.No.</th> <th>Name</th> <th>Username</th> <th>Email</th> <th>Completion Date</th> <th>Send Certificate</th> </tr> </thead> <tbody>';

        $slno = 0; // setting variable for table serial Number
        $tableRow = '';
        foreach ($totalUser as $detailsRow) {
        // foreach ($details as $detailsRow) {
          $slno++; // incrementing serial number

          // Setting User ID
          $userID = $detailsRow->User_id;
          // Setting User Game name
          $cardName = $detailsRow->Game_Name;

          // creating subquery 
          $userDataQuery = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gus.US_LinkID, gus.US_CreatedOn, gug.UG_CratedOn, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId, gsu.User_ParentId, ge.Enterprise_ID, ge.Enterprise_Name  
          FROM GAME_SITE_USERS gsu
          LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id
          LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId
          INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID = $cardID
          WHERE gsu.User_Delete = 0 AND gug.UG_GameID = $cardID AND gsu.User_id = $userID AND gsu.User_ParentId = ".$enterpriseId;

          // die($userDataQuery);
          // $userDataDetails = $this->Common_Model->executeQuery($userDataQuery);
          // print_r($userDataDetails); exit();

          // adding the above subquery to main query
          $agentsSql = "SELECT ud.User_id, ud.User_fname, ud.User_lname, ud.User_username, ud.User_email, ud.US_LinkID, ud.US_CreatedOn, ud.UG_CratedOn, ud.Enterprise_ID, ud.Enterprise_Name 
          FROM GAME_SITE_USER_REPORT_NEW gr
          INNER JOIN ($userDataQuery) ud ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
          LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = ud.User_ParentId
          WHERE gr.linkid IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID ) AND gr.date_time BETWEEN '$startDate' AND '$endDate' 
          ORDER BY ud.US_LinkID DESC";

          $details = $this->Common_Model->executeQuery($agentsSql);
          // die($agentsSql);
          // print_r($details[0]->User_id); exit();

          // Setting Login Status
          if (isset($details[0]->US_LinkID)) {
            // Setting Complete Users
            // US_LinkID -> 1-user completed game
            if ($details[0]->US_LinkID == 1) {
              // Making table row
              $CompletionDate = date('d-m-Y', strtotime($details[0]->US_CreatedOn));
              $userFullName = $details[0]->User_fname.' '.$details[0]->User_lname;
              $userEmailID = $details[0]->User_email;

              $tableRow .= '<tr><!-- Sl.No. --><td>'.$slno.'</td> <!-- Name --><td>'.$userFullName.'</td> <!-- Username --><td>'.$details[0]->User_username.'</td> <!-- email --><td>'.$userEmailID.'</td> <!-- Completion Date --><td>'.$CompletionDate.'</td> <!-- Download Certificate --><td><button type="button" class="btn btn-link" title="" data-toggle="tooltip" data-original-title="Send Certificate" data-name="'.$userFullName.'" data-gamename="'.$cardName.'" data-completiondate="'.$CompletionDate.'" data-emailid="'.$userEmailID.'" onclick="downloadCertificate(this)"><i class="fa fa-envelope text-info fa-1x"></i></button></td></tr>'; 
            }
          }
        }
        $returnTableHTML .= $tableRow .'</tbody></table>';
      }

      die(json_encode(["status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'User Certificate Data.', 'data' => $returnTableHTML]));
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Error Occured', 'button' => 'btn btn-danger']));
    }
  } // end of getCertificateTableData function

  // Sending email withpdf
  public function send_mail_pdf() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // $emailID     = $this->input->post('emailID');
      $emailID     = 'rajeevoffice1@gmail.com';
      // $emailID     = 'debasish@humanlinks.in';
      $userName    = $this->input->post('userName');

      // $pdffile = $this->input->post('pdffile');
      // print_r($pdffile); exit();

      // =======================================
      if (!empty($_POST['pdffile'])) {
        $data = base64_decode($this->input->post('pdffile'));

        $fileName = "simulation certificate.pdf";

        // $filepath = "/var/www/html/develop/enterprise/certificates/".$fileName;
        $filepath = "/var/www/html/corp_simulation/enterprise/certificates/".$fileName;
        
        $file = fopen($filepath, 'r+');
        $fwrite = fwrite($file, $data); //save data 

        fclose($file);

        // print_r('success'); exit(); 
      }
      else {
        // print_r('No Data Sent'); exit();
        die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'certificate pdf not created.']));
      }
      // =======================================

      // if file saved in server or not
      if (!empty($fileName)) {
        // saved
        $subject  = 'Certificate of Simulation Completion';

        $message  = "Ms/Mr ".$userName."<br>";
        $message  .= "Certificate for successful completion of / participation in, the simulation session conducted by us is attached for your future reference.<br><br>";
        $message  .= "Best Wishes!<br><br>Regards,<br>Admin<br>Humanlinks Learning";
        
      
        $pdfdirectory = 'certificates/'.$fileName;

        $result = $this->Common_Model->send_mail_pdf($emailID, $subject, $message, 'support@corpsim.in', $pdfdirectory);

        // 0-> not sent, 1-> sent
        if ($result == 0) {
          die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Email not Sent.']));
        }
        else {
          die(json_encode(["status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Email Sent Successfully.']));
        }
      }
      else {
        // not saved
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Error Occured', 'button' => 'btn btn-danger']));
    }
  } // end of send_mail_pdf function

} // end of Certificate class 
