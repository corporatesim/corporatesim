<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AllocateGame extends MY_Controller {

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

    // Setting Enterprize List
    // Enterprise_Status -> 0-Active, 1-Deactive  
    $queryEnterprizeList = "SELECT ge.Enterprise_ID, ge.Enterprise_Name
      FROM GAME_ENTERPRISE ge
      WHERE ge.Enterprise_Status = 0
      ORDER BY ge.Enterprise_ID DESC";
    $enterprizeList = $this->Common_Model->executeQuery($queryEnterprizeList);
    // print_r($enterprizeList); print_r($enterprizeList[0]->Enterprise_ID); exit();
    $content['enterprizeList'] = $enterprizeList;

    $content['subview']  = 'allocateGame';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function getUserListData() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      // setting form data
      $enterprizeID   = $this->input->post('enterprizeID');
      $cardID         = $this->input->post('cardID');
      $searchUsername = $this->input->post('searchUsername');
      // print_r($searchUsername); exit();

      $userCreationDateStart = date('Y-m-d H:i:s', strtotime($this->input->post('userCreationDateStart').' 00:00:00'));
      $userCreationDateEnd   = date('Y-m-d H:i:s', strtotime($this->input->post('userCreationDateEnd').' 23:59:59'));

      // $userCreationDateStart = date('Y-m-d', strtotime($this->input->post('userCreationDateStart')));
      // $userCreationDateEnd   = date('Y-m-d', strtotime($this->input->post('userCreationDateEnd')));

      if (empty($enterprizeID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please Select Enterprize.', 'button' => 'btn btn-danger']));
      }
      else if (empty($cardID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please Select Card.', 'button' => 'btn btn-danger']));
      }
      else {
        // checking selected game is present for enterprize or not
        $gameWhere = array(
          'EG_EnterpriseID' => $enterprizeID,
          'EG_GameID'       => $cardID,
        );
        $checkGame = $this->Common_Model->findCount('GAME_ENTERPRISE_GAME', $gameWhere);

        if ($checkGame > 0) {
          // if enterprize have selected card

          // checking user is searching by username or not
          if (empty($searchUsername)) {
            // searching by date
            $userCreationDateStartTimeStamp = strtotime(date($userCreationDateStart));
            $userCreationDateEndTimeStamp   = strtotime(date($userCreationDateEnd));
            // print_r($userCreationDateStartTimeStamp); exit();

            if ($userCreationDateStartTimeStamp == 0 && $userCreationDateEndTimeStamp == 0) {
              die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please select Date.', 'button' => 'btn btn-danger']));
            }
            else if ($userCreationDateStartTimeStamp == 0) {
              die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Start Date not set.', 'button' => 'btn btn-danger']));
            }
            else if ($userCreationDateEndTimeStamp == 0) {
              die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'End Date not set.', 'button' => 'btn btn-danger']));
            }
            else if ($userCreationDateEndTimeStamp <= $userCreationDateStartTimeStamp) {
              die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please make sure End Date is greater then Start Date.', 'button' => 'btn btn-danger']));
            }
            else {
              // query by date
              $getUsersQuery = "SELECT DISTINCT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gsu.User_GameStartDate, gsu.User_GameEndDate, gug.UG_UserID, gug.UG_GameID, gug.UG_GameStartDate, gug.UG_GameEndDate, gug.UG_ReplayCount
              FROM GAME_SITE_USERS gsu 
              LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID = $cardID AND gug.UG_ParentId = $enterprizeID 
              WHERE gsu.User_ParentId = $enterprizeID AND gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_GameStartDate BETWEEN '$userCreationDateStart' AND '$userCreationDateEnd'
              ORDER BY gug.UG_UserID DESC";
            }
          }
          else {
            // query by username
            $getUsersQuery = "SELECT DISTINCT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gsu.User_GameStartDate, gsu.User_GameEndDate, gug.UG_UserID, gug.UG_GameID, gug.UG_GameStartDate, gug.UG_GameEndDate, gug.UG_ReplayCount
              FROM GAME_SITE_USERS gsu 
              LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID = $cardID AND gug.UG_ParentId = $enterprizeID 
              WHERE gsu.User_ParentId = $enterprizeID AND gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_username LIKE '%".$searchUsername."%'
              ORDER BY gug.UG_UserID DESC";
          }

          // $getUsersQuery = "SELECT DISTINCT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gsu.User_GameStartDate, gsu.User_GameEndDate, gug.UG_UserID, gug.UG_GameID, gug.UG_GameStartDate, gug.UG_GameEndDate, gug.UG_ReplayCount
          // FROM GAME_SITE_USERS gsu 
          // LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID = $cardID AND gug.UG_ParentId = $enterprizeID 
          // WHERE gsu.User_ParentId = $enterprizeID AND gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_datetime BETWEEN '$userCreationDateStart' AND '$userCreationDateEnd' 
          // ORDER BY gug.UG_UserID DESC"; 

          // die($getUsersQuery);
          $userListData = $this->Common_Model->executeQuery($getUsersQuery);
          // print_r($userListData); exit();
          
          // Making Users List one datatable
          
          // $returnTableHTML = '<table class="stripe hover multiple-select-row data-table-export"> <thead> <tr> <th>Select</th> <th>Sl.No.</th> <th>Name</th> <th>Username</th> <th>Email ID</th> <th>User Start Date</th> <th>User End Date</th> </tr> </thead> <tbody>';
          $returnTableHTML = '<table class="table table-striped table-bordered table-hover table-sm table-responsive-md"> <thead> <tr> <th>Select</th> <th>Sl.No.</th> <th>Name</th> <th>Username</th> <th>Email ID</th> <th>User Account Date</th> <th>User Card Duration</th> <th>Replay</th></tr> </thead> <tbody>';

          $slno = 0; // setting variable for table serial Number
          $tableRow = '';
          foreach ($userListData as $detailsRow) {
            $slno++; // incrementing serial number

            if ($detailsRow->UG_UserID) {
              $makeDuration = date('d-m-Y, ', strtotime($detailsRow->UG_GameStartDate)).'<span class="text-danger">'.date('g:i:s A', strtotime($detailsRow->UG_GameStartDate)).'</span> to '.date('d-m-Y, ', strtotime($detailsRow->UG_GameEndDate)).'<span class="text-danger">'.date('g:i:s A', strtotime($detailsRow->UG_GameEndDate)).'</span>';
              $setReplay = $detailsRow->UG_ReplayCount;
              $checked = 'checked';

              // it helps to delete user record
              $alreadyPresentUserList = '<input type="hidden" value="'.$detailsRow->User_id.'" id="'.$detailsRow->User_id.'" name="alreadyPresentUserList[]">';
            }
            else {
              $makeDuration = '';
              $setReplay = '';
              $checked = '';

              $alreadyPresentUserList = '';
            }

            $tableRow .= '<tr> <!-- Select --><td><!-- bootstrap checkbox --> <div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" value="'.$detailsRow->User_id.'" id="'.$detailsRow->User_id.'" name="selectUser[]" '.$checked.'> <label class="custom-control-label" for="'.$detailsRow->User_id.'"></label> </div> '.$alreadyPresentUserList.' </td> <!-- Sl.No. --><td>'.$slno.'</td> <!-- Name --><td>'.$detailsRow->User_fname.' '.$detailsRow->User_lname.'</td> <!-- Username --><td>'.$detailsRow->User_username.'</td> <!-- email --><td>'.$detailsRow->User_email.'</td> <!-- User Account Date --><td>'.date('d-m-Y', strtotime($detailsRow->User_GameStartDate)).' to '.date('d-m-Y', strtotime($detailsRow->User_GameEndDate)).'</td> <!-- User Card Duration --><td>'.$makeDuration.'</td> <!-- Replay --><td>'.$setReplay.'</td></tr>';
          }
          $returnTableHTML .= $tableRow .'</tbody></table>';

          if ($slno == 0) {
            // no user present 
            die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No users present between selected dates', 'button' => 'btn btn-danger']));
          }
          else {
            // sending back data
            die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'User list data table', 'button' => 'btn btn-success', 'data' => $returnTableHTML]));
          }

        }
        else {
          die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Enterprize doesn\'t have selected card', 'button' => 'btn btn-danger']));
        }
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Not get any users.', 'button' => 'btn btn-danger']));
    }
  } // end of getUserListData function

  public function allocateCard() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      $enterprizeID = $this->input->post('enterprizeID');
      $cardID       = $this->input->post('cardID');
      $replayCount  = $this->input->post('replayCount');
      
      $allocateDateStart = date('Y-m-d H:i:s', strtotime($this->input->post('allocateDateStart')));
      $allocateDateEnd   = date('Y-m-d H:i:s', strtotime($this->input->post('allocateDateEnd')));

      $allocateStartDateTimeStamp = strtotime(date($allocateDateStart));
      $allocateEndDateTimeStamp   = strtotime(date($allocateDateEnd));
      // print_r(strtotime(date($allocateDateStart))); exit();

      if (empty($enterprizeID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please Select Enterprize.', 'button' => 'btn btn-danger']));
      }
      else if (empty($cardID)) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please Select Card.', 'button' => 'btn btn-danger']));
      }
      else if (!isset($replayCount) || $replayCount == "") {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Replay Count not set.', 'button' => 'btn btn-danger']));
      }
      else if ($allocateStartDateTimeStamp == 0 && $allocateEndDateTimeStamp == 0) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please select Date.', 'button' => 'btn btn-danger']));
      }
      else if ($allocateStartDateTimeStamp == 0) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Start Date not set.', 'button' => 'btn btn-danger']));
      }
      else if ($allocateEndDateTimeStamp == 0) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'End Date not set.', 'button' => 'btn btn-danger']));
      }
      else if ($allocateEndDateTimeStamp <= $allocateStartDateTimeStamp) {
        die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please make sure End Date is greater then Start Date.', 'button' => 'btn btn-danger']));
      } 
      else {
        // Deleting Previous present records and inserting new selected records

        // setting already present users
        $alreadyPresentUserList      = $this->input->post('alreadyPresentUserList'); // Array type
        // print_r($alreadyPresentUserList); exit();

        // if (count($alreadyPresentUserList) > 0) {
        if (!empty($alreadyPresentUserList)) {
          // loop and delete already present users
          for ($i=0; $i<count($alreadyPresentUserList); $i++) {
            // deleting previous present record
            $deleteWhere = array(
              'UG_UserID'      => $alreadyPresentUserList[$i],
              'UG_GameID'      => $cardID,
              'UG_ParentId'    => $enterprizeID,
              'UG_SubParentId' => -2,
            );

            $resultDelete = $this->Common_Model->deleteRecords("GAME_USERGAMES", $deleteWhere);
          }
        }


        // Setting Selected users
        $selectUser = $this->input->post('selectUser'); // Array type

        // if (count($selectUser) > 0) {
        if (!empty($selectUser)) {
          // looping to each users selected
          for ($i=0; $i<count($selectUser); $i++) {
            // inserting new records
            $insertArray = array(
              'UG_UserID'        => $selectUser[$i],
              'UG_GameID'        => $cardID,
              'UG_ParentId'      => $enterprizeID,
              'UG_SubParentId'   => -2,
              'UG_GameStartDate' => $allocateDateStart,
              'UG_GameEndDate'   => $allocateDateEnd,
              'UG_ReplayCount'   => $replayCount,
              'UG_CratedOn'      => date('Y-m-d H:i:s', time()),
            );

            $resultInsert = $this->Common_Model->insert("GAME_USERGAMES", $insertArray, '');
          }
        }

        // Sending success message
        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Card Allocate/De-Allocate to users Successfully.', 'button' => 'btn btn-success']));
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Card not allocated to users.', 'button' => 'btn btn-danger']));
    }
  } // end of allocateCard function
} // end of AllocateGame class 
