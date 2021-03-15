<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AjaxNew extends MY_Controller{

  private $loginDataLocal;
  public function __construct(){
    parent::__construct();
    $this->loginDataLocal = $this->session->userdata('loginData');
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      // redirect('Login/login');
    }
  }

  public function dashboardCardRunChartData() {
    $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

    // fetching all game ID and Name list for loged in enterprise
    $gameQuery = "SELECT geg.EG_GameID, gg.Game_Name FROM GAME_ENTERPRISE_GAME geg LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID WHERE geg.EG_EnterpriseID = $enterprise_ID ORDER BY gg.Game_Name";
    $gameDetails = $this->Common_Model->executeQuery($gameQuery);
    //print_r($gameDetails); print_r($gameDetails[0]->Game_Name); exit();

    if (count($gameDetails) < 1 || $gameDetails == '') {
      // no game/card available for this enterprise
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Card Assigned.']));
    }
    else {
      // making array to hold all values for chart
      $card_ID              = [];
      $card_Name            = [];
      $card_User_Total      = [];
      $card_User_Started    = [];
      $card_User_Completed  = [];
      $card_User_NotStarted = [];

      foreach ($gameDetails as $gameDetailsRow) {
        $cardID   = $gameDetailsRow->EG_GameID;
        $cardName = $gameDetailsRow->Game_Name;
        // pushing data into array
        $card_ID[]    = (int)$cardID;
        $card_Name[]  = $cardName;

        //==================================================

        // counting total number of users have this game
        //$totalUserQuery = "SELECT gsu.User_id FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id WHERE gsu.User_gameStatus = 0 AND gsu.User_Delete = 0 AND gsu.User_ParentId = ".$enterprise_ID." AND gug.UG_ParentId= ".$enterprise_ID." AND gug.UG_GameID = ".$cardID;

        //$totalUserQuery = "SELECT gsu.User_id FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_ParentId = gsu.User_ParentId WHERE gsu.User_gameStatus = 0 AND gsu.User_Delete = 0 AND gsu.User_ParentId = ".$enterprise_ID." AND gug.UG_ParentId = ".$enterprise_ID." AND gug.UG_GameID = ".$cardID."";

        $totalUserQuery = "SELECT gsu.User_id AS total FROM GAME_SITE_USERS gsu WHERE gsu.User_gameStatus=0 AND gsu.User_Role=1 AND gsu.User_ParentId = ".$enterprise_ID." AND gsu.User_games = ".$cardID."";

        $totalUser = $this->Common_Model->executeQuery($totalUserQuery);
        //print_r($totalUserQuery); exit();
        $totalUserCount = count($totalUser) ? count($totalUser) : 0;

        //==================================================
        //==================================================

        // counting total number of users have Not Started this game
        $totalUserNotStartedQuery = "SELECT gsu.User_id FROM GAME_USERGAMES gug LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gug.UG_UserID WHERE gug.UG_GameID = ".$cardID." AND gsu.User_ParentId = ".$enterprise_ID." AND gsu.User_id NOT IN( SELECT gus.US_UserID FROM GAME_USERSTATUS gus JOIN GAME_SITE_USERS gs ON gs.User_id = gus.US_UserID AND gs.User_ParentId = ".$enterprise_ID." AND gus.US_GameID = ".$cardID." )";

        $totalUserNotStarted = $this->Common_Model->executeQuery($totalUserNotStartedQuery);
        //print_r($totalUserQuery); exit();
        $totalUserNotStartedCount = count($totalUserNotStarted) ? count($totalUserNotStarted) : 0;

        //==================================================
        //==================================================

        // counting total number of users Started this game
        $totalUserStartedQuery = "SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

        // adding the above subquery to main query
        $totalUserStartedSql = "SELECT
            ud.User_id AS User_id,
            ud.User_fname AS User_fname,
            ud.User_lname AS User_lname,
            ud.User_email AS User_email,
            ud.US_LinkID
          FROM GAME_SITE_USER_REPORT_NEW gr
          INNER JOIN($totalUserStartedQuery) ud ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
          WHERE gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=0 ORDER BY ud.US_LinkID DESC";

        $totalUserStarted = $this->Common_Model->executeQuery($totalUserStartedSql);
        $totalUserStartedCount = count($totalUserStarted) ? count($totalUserStarted) : 0;

        //==================================================
        //==================================================

        // counting total number of users Completed this game
        $totalUserCompletedQuery   = "SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

        // adding the above subquery to main query
        $totalUserCompletedSql = "SELECT
            ud.User_id AS User_id,
            ud.User_fname AS User_fname,
            ud.User_lname AS User_lname,
            ud.User_email AS User_email,
            ud.US_LinkID
          FROM GAME_SITE_USER_REPORT_NEW gr
          INNER JOIN($totalUserCompletedQuery) ud ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
          WHERE gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=1 ORDER BY ud.US_LinkID DESC";

        $totalUserCompleted = $this->Common_Model->executeQuery($totalUserCompletedSql);
        $totalUserCompletedCount = count($totalUserCompleted) ? count($totalUserCompleted) : 0;

        //==================================================
        //==================================================

        // counting total number of users Not Completed this game
        //$totalUserNotStartedCount = $totalUserCount - ($totalUserStartedCount + $totalUserCompletedCount);

        //print_r('Total-'.$totalUserCount.' Started-'.$totalUserStartedCount.' Completed-'.$totalUserCompletedCount.' Not Started-'.$totalUserNotStartedCount);
        //echo '<br />';
        $card_User_Total[]      = (int)$totalUserCount;
        $card_User_Started[]    = (int)$totalUserStartedCount;
        $card_User_Completed[]  = (int)$totalUserCompletedCount;
        $card_User_NotStarted[] = (int)$totalUserNotStartedCount;
      }
      //print_r($totalUserQuery); exit();
      //print_r($card_Name);
      //exit();

      die(json_encode(['card_ID' => $card_ID, 'card_Name' => $card_Name, 'card_User_Total' => $card_User_Total, 'card_User_Started' => $card_User_Started, 'card_User_Completed' => $card_User_Completed, 'card_User_NotStarted' => $card_User_NotStarted, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Card Run Data.']));
    }
  }

  public function getCardUserDetailsData($cardID=NULL, $type=NULL) {
    $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

    $returnTableHtml = '<table class="stripe hover data-table-export"><thead><tr> <th>ID</th> <th>Name</th> <th>Username</th> <th>Email</th> </tr></thead><tbody>';
    // setting table data accourding to condition
    if ($type == 'totalUser') {
      // counting total number of users have this game
      //==================================================
       //$totalUserQuery = "SELECT gsu.User_id AS User_id, CONCAT(gsu.User_fname,' ',gsu.User_lname) AS user_Full_Name, gsu.User_username AS User_username, gsu.User_mobile AS User_mobile, gsu.User_email AS User_email FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id WHERE gsu.User_gameStatus = 0 AND gsu.User_Delete = 0 AND gsu.User_ParentId = ".$enterprise_ID." AND gug.UG_ParentId= ".$enterprise_ID." AND gug.UG_GameID = ".$cardID;

      $totalUserQuery = "SELECT gsu.User_id AS User_id, CONCAT(gsu.User_fname,' ',gsu.User_lname) AS user_Full_Name, gsu.User_username AS User_username, gsu.User_mobile AS User_mobile, gsu.User_email AS User_email AS total FROM GAME_SITE_USERS gsu WHERE gsu.User_gameStatus=0 AND gsu.User_Role=1 AND gsu.User_ParentId = ".$enterprise_ID." AND gsu.User_games = ".$cardID."";

      $totalUserDetails = $this->Common_Model->executeQuery($totalUserQuery);
      //================================================== 
    }
    else if ($type == 'notStartes') {
      // counting total number of users have this game
      //==================================================
      $totalUserNotStartedQuery = "SELECT gsu.User_id AS User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS user_Full_Name, gsu.User_username AS User_username, gsu.User_mobile AS User_mobile, gsu.User_email AS User_email FROM GAME_USERGAMES gug LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gug.UG_UserID WHERE gug.UG_GameID = ".$cardID." AND gsu.User_ParentId = ".$enterprise_ID." AND gsu.User_id NOT IN( SELECT gus.US_UserID FROM GAME_USERSTATUS gus JOIN GAME_SITE_USERS gs ON gs.User_id = gus.US_UserID AND gs.User_ParentId = ".$enterprise_ID." AND gus.US_GameID = ".$cardID." )";

      $totalUserDetails = $this->Common_Model->executeQuery($totalUserNotStartedQuery);
      //==================================================
    }
    else if ($type == 'started') {
      // counting total number of users Started this game
      //==================================================
      $totalUserStartedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_mobile, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

      // adding the above subquery to main query
      $totalUserStartedSql = "SELECT
              ud.User_id AS User_id,
              CONCAT(ud.User_fname,' ',ud.User_lname) AS user_Full_Name,
              ud.User_username AS User_username,
              ud.User_mobile AS User_mobile,
              ud.User_email AS User_email,
              ud.US_LinkID
              FROM GAME_SITE_USER_REPORT_NEW gr
              INNER JOIN($totalUserStartedQuery) ud
              ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
              WHERE
              gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=0 ORDER BY ud.US_LinkID DESC";

      $totalUserDetails = $this->Common_Model->executeQuery($totalUserStartedSql);
      //==================================================
    }
    else if ($type == 'completed') {
      // counting total number of users Completed this game
      //==================================================
      $totalUserCompletedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_mobile, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

      // adding the above subquery to main query
      $totalUserCompletedSql = "SELECT
              ud.User_id AS User_id,
              CONCAT(ud.User_fname,' ',ud.User_lname) AS user_Full_Name,
              ud.User_username AS User_username,
              ud.User_mobile AS User_mobile,
              ud.User_email AS User_email,
              ud.US_LinkID
              FROM GAME_SITE_USER_REPORT_NEW gr
              INNER JOIN($totalUserCompletedQuery) ud
              ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
              WHERE
              gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=1 ORDER BY ud.US_LinkID DESC";

      $totalUserDetails = $this->Common_Model->executeQuery($totalUserCompletedSql);
      //==================================================
    } // end of selected card type filter

    //==================================================
    //==================================================
    // start of making table
    if (count($totalUserDetails) < 1 || $totalUserDetails == '') {
      // start of setting if no user present msg
      if ($type == 'totalUser')
        $returnTableHtml = '<tr> <td>No User Available for This Card</td> </tr>';
      else if ($type == 'notStartes')
        $returnTableHtml = '<tr> <td>All User Started Playing or Completed This Card</td> </tr>';
      else if ($type == 'started')
        $returnTableHtml = '<tr> <td>No User Started Playing This Card</td>';
      else if ($type == 'completed')
        $returnTableHtml = '<tr> <td>No User Completed for This Card</td> </tr>';
      // end of setting if no user present msg
    }
    else {
      $slNo = 0;
      foreach ($totalUserDetails as $totalUserRow) {
        $slNo++;
        // $totalUserRow->User_mobile
        $returnTableHtml .= '<tr> <td>'.$slNo.'</td> <td>'.$totalUserRow->user_Full_Name.'</td> <td>'.$totalUserRow->User_username.'</td> <td>'.$totalUserRow->User_email.'</td> </tr>';
      }
    }
    // end of making table
    //==================================================

    $returnTableHtml .= '</tbody></table>';

    // sending result
    die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => '', 'cardUserData' => $returnTableHtml]));
  }

  public function getEmailDetails($ESD_ID=NULL) {
    // checking ESD_ID is set or not
    if ($ESD_ID) {
      // query to get data
      $query = "SELECT esd.ESD_To, esd.ESD_Content, esd.ESD_DateTime, esd.ESD_Comment, esd.ESD_Status, ent.Enterprise_Name
      FROM GAME_EMAIL_SEND_DETAILS esd 
      LEFT JOIN GAME_ENTERPRISE ent ON ent.Enterprise_ID = esd.ESD_EnterprizeID
      WHERE esd.ESD_ID = ".$ESD_ID." LIMIT 1";
      $details = $this->Common_Model->executeQuery($query);
      //print_r($this->db->last_query()); exit();

      $description  = '<b>Email ID:</b> '.$details[0]->ESD_To.'<br />';
      $description .= '<b>Enterprize:</b> '.$details[0]->Enterprise_Name.'<br />';
      $description .= '<b>Date, Day, Time:</b> '.date('d-m-Y, l, g:i:s A', strtotime($details[0]->ESD_DateTime)).'<br /><hr />';
      if (!empty($details[0]->ESD_Content))
        $description .= '<b>Email Body:</b><br />'.$details[0]->ESD_Content.'<br /><br />';
      if (!empty($details[0]->ESD_Comment))
        $description .= '<b>Error Message:</b><br />'.$details[0]->ESD_Comment;
    }
    else {
      // ESD_ID is not set send
      $description = 'No Record Selected.';
    }

    // sending result
    die(json_encode(["status" => "200", 'description' => $description]));
  } // end of getEmailDetails function

  // it process downloading csv file in Excel sheet
  public function downloadFeedbackCsvFile() {
    $csv_file = fopen('php://output', 'w');
    header('Content-type: application/csv');
    // it(ob_clean()) using downloade time remove empty row on excelsheet
    // ob_clean();

    $gameFeedback = $this->Common_Model->fetchRecords('GAME_FEEDBACK', NULL, NULL, 'Feedback_id DESC', NULL);
    // print_r($gameFeedback); exit();

    if (count($gameFeedback) > 0) {
      $header_row = array("User ID", "Name", "Email", "Mobile", "Title", "Message", "Time");
      fputcsv($csv_file, $header_row, ',', '"');

      foreach ($gameFeedback as $gameFeedbackRow) {
        $Feedback_userData = json_decode($gameFeedbackRow->Feedback_userData);

        $rowData = array($gameFeedbackRow->Feedback_userid, $Feedback_userData->fullName, $Feedback_userData->Email, $Feedback_userData->Mobile, $gameFeedbackRow->Feedback_title, $gameFeedbackRow->Feedback_message, date('d-M-y H:i',strtotime($gameFeedbackRow->Feedback_createdOn)));
        fputcsv($csv_file, $rowData, ',', '"');
      }
    }
    else {
      $noFeedbacks = array('No Feedbacks Available');
      fputcsv($csv_file, $noFeedbacks, ',', '"');
    }
    fclose($csv_file);
  } // end of downloading csv file in Excel sheet


  public function getJSGameDetails($ID=NULL) {
    // checking ID is set or not
    if ($ID) {
      // query to get data
      $query = "SELECT ujsgd.JSDATA_GameData
      FROM GAME_USER_JSGAME_DATA ujsgd 
      WHERE ujsgd.JSDATA_Id = ".$ID." LIMIT 1";
      $details = $this->Common_Model->executeQuery($query);
      //print_r($this->db->last_query()); exit();

      $json_OBJ = $details[0]->JSDATA_GameData;
      $details_JSON = json_decode($json_OBJ, true);

      // // Setting Variables
      // Started On
      if (isset($details_JSON->startedOn))
        $StartedOn = date('d-m-Y, g:i:s A', strtotime($details_JSON->startedOn));
      else
        $StartedOn = '';

      // Completed On
      if (isset($details_JSON->completedOn))
        $CompletedOn = date('d-m-Y, g:i:s A', strtotime($details_JSON->completedOn));
      else
        $CompletedOn = '';

      // Difference In Time
      if (isset($details_JSON->differenceInTime))
        $DifferenceInTime = $details_JSON->differenceInTime;
      else
        $DifferenceInTime = '';

      // // Total Moves
      // if (isset($details_JSON->totalMoves))
      //   $TotalMoves = $details_JSON->totalMoves;
      // else
      //   $TotalMoves = '';

      // // Total Clicks
      // if (isset($details_JSON->totalClicks))
      //   $TotalClicks = $details_JSON->totalClicks;
      // else
      //   $TotalClicks = '';

      // // Clicked On Hound
      // if (isset($details_JSON->clickedOnHound))
      //   $ClickedOnHound = $details_JSON->clickedOnHound;
      // else
      //   $ClickedOnHound = '';

      // // Clicked On Image
      // if (isset($details_JSON->clickedOnImage))
      //   $ClickedOnImage = $details_JSON->clickedOnImage;
      // else
      //   $ClickedOnImage = '';

      // making Table
      // ========================================================
      $description = '<table class="table table-bordered"><tbody>';
      foreach($details_JSON as $key => $value) {
        if ($key == 'winLoss') {
          // hare -> 0-win, 1-loss
          $winLoss = $value == 0 ? 'Win' : 'Loss';
          $description .= '<tr> <th scope="row">'.$key.'</th><td>'.$winLoss.'</td> </tr>';
        }
        else {
          $description .= '<tr> <th scope="row">'.$key.'</th><td>'.$value.'</td> </tr>';
        }
      }
      $description .= '</tbody></table>';
      // ========================================================

      // $description = '<table class="table table-bordered"><tbody>';
      // $description .= '<tr> <th scope="row">Started On</th><td>'.$StartedOn.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Completed On</th><td>'.$CompletedOn.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Difference In Time</th><td>'.$DifferenceInTime.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Total Moves</th><td>'.$TotalMoves.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Total Clicks</th><td>'.$TotalClicks.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Clicked On Hound</th><td>'.$ClickedOnHound.'</td> </tr>';
      // $description .= '<tr> <th scope="row">Clicked On Image</th><td>'.$ClickedOnImage.'</td> </tr>';
      // $description .= '</tbody></table>';
      // ========================================================
    }
    else {
      // ID is not set send
      $description = 'No Record Selected.';
    }

    // sending result
    die(json_encode(["status" => "200", 'description' => $description]));
  } // end of getJSGameDetails function

  public function getReportTwoDataTable() {
    prd($this->input->post('formData')); exit();

    // [Enterprise] => 8
    // [selectCard] => 73
    // [gamestartdate] => 01-01-2020
    // [gameenddate] => 06-11-2020

    $enterpriseID = $this->input->post('Enterprise');
    $cardID       = $this->input->post('selectCard');

    $report_startDate =  date('Y-m-d H:i:s', strtotime($this->input->post('gamestartdate') . ' 00:00:00'));
    $report_endDate   =  date('Y-m-d H:i:s', strtotime($this->input->post('gameenddate') . ' 23:59:59'));

    if (empty($enterpriseID)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Enterprize To View Report.']));
    }
    else if (empty($cardID)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Card To View Report.']));
    }
    else {
      // getting record data

      $returnTableHtml = '<table class="stripe hover data-table-export"><thead><tr> <th>ID</th> <th>Name (email)</th>';

      if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') {
        //if superadmin login then show Company/Institute Name
        $returnTableHtml .= '<th>Company/Institute</th>';
      }
      $returnTableHtml .= '<th>Formula Value</th> <th>Report</th> </tr></thead><tbody>';

      // ==========================================================
      // if item__id is used in formula, and $itemCompSubcompJson doesn't contain the array[item__id], this means this item id need to be mapped with comp-subcomp
      $gameCardID = [];
      $gameCard_SublinkID = [];
      $slNo = 0;
      $gameCompSubcomp = json_decode($formulaData[0]->Items_Formula_Json, true);
      foreach ($gameCompSubcomp as $gameCompSubcompRow => $gameCompSubcompValue) {
        // pr($gameCompSubcompRow); pr($gameCompSubcompValue); $averageJson[$gameCompSubcompRow]
        for ($l = 0; $l < count($gameCompSubcompValue); $l++) {
          // this contains sublinkId, gameid. So check for game existance, palyed status and then pick value
          $sublink_gameid    = explode(',', $gameCompSubcompValue[$l]);
          $sublinkid         = $sublink_gameid[0];
          $gameid            = $sublink_gameid[1];
          $gameCardID[$slNo] = $gameid;
          $gameCard_SublinkID[$slNo] = $sublinkid;

          $slNo++;
        }
      }
      // print_r($gameCardID); echo '<br />'; print_r($gameCard_SublinkID); exit();
      // ==========================================================

      // finding the user details according filter type
      // $userQuery = "SELECT gsu.User_id, CONCAT(gsu.User_fname, ' ', gsu.User_lname) AS User_fullName, gsu.User_username, gsu.User_email, ge.Enterprise_ID, ge.Enterprise_Name 
      // FROM GAME_SITE_USERS gsu 
      // LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId WHERE gsu.User_Role = 1 AND gsu.User_Delete = 0 AND ge.Enterprise_ID = $enterpriseId AND gsu.User_datetime BETWEEN '$report_startDate' AND '$report_endDate' ";

      $userQuery = "SELECT DISTINCT gi.input_user, gsu.User_id, CONCAT(gsu.User_fname, ' ', gsu.User_lname) AS User_fullName, gsu.User_username, gsu.User_email, ge.Enterprise_ID, ge.Enterprise_Name 
      FROM GAME_SITE_USERS gsu 
      LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId 
      LEFT JOIN GAME_INPUT gi ON gi.input_user = gsu.User_id
      WHERE gsu.User_Role = 1 AND gsu.User_Delete = 0 AND ge.Enterprise_ID = $enterpriseId AND gi.input_caretedOn BETWEEN '$report_startDate' AND '$report_endDate' AND gi.input_sublinkid IN (" . implode(',', $gameCard_SublinkID) . ") ";

      // $userQuery = "SELECT DISTINCT gug.UG_UserID, gsu.User_id, CONCAT(gsu.User_fname, ' ', gsu.User_lname) AS User_fullName, gsu.User_username, gsu.User_email, ge.Enterprise_ID, ge.Enterprise_Name 
      // FROM GAME_SITE_USERS gsu 
      // LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId 
      // LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id
      // LEFT JOIN GAME_INPUT gi ON gi.input_user = gsu.User_id
      // WHERE gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_ParentId = $enterpriseId AND gug.UG_GameStartDate >= '$report_startDate' AND gug.UG_GameEndDate <= '$report_endDate' AND gi.input_caretedOn BETWEEN '$report_startDate' AND '$report_endDate'";

      switch ($filtertype) {
        case 'oneByOneItemUsers':
          //when one enterprise selected some specific user to generate report
          $usersId = implode(',', $usersId);
          //print_r($usersId); exit();
          $userQuery .= " AND gsu.User_id IN ($usersId) AND ge.Enterprise_ID = ". $enterpriseId." ";
          break;
        case 'myItemUsers':
          //when one enterprise all users selecte to generate report
          $userQuery .= " AND ge.Enterprise_ID = ". $enterpriseId." ";
          break;
        case 'allItemUsers':
          //when all enterprise all users selecte to generate report
          break;
        default:
      }

      $userQuery .= " ORDER BY gsu.User_fname, gsu.User_lname ASC ";
      //print_r($userQuery); exit();
      $userList = $this->Common_Model->executeQuery($userQuery);

      if (count($userList) < 1) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No User Found Between Selected Date']));
      } else {
        $tableRow = '';
        $slNo = 1;
        $overall_Scatter_Chart = [];
        foreach ($userList as $userListRow) {
          // $tableRow .= '<tr> <td>' . $slNo . '</td> <td title="' . $userListRow->User_username . '"><a href="javascript:void(0);" data-user_id='.$userListRow->User_id.' data-enterprise_id='.$userListRow->Enterprise_ID.' data-formula_expression="'.$formulaData[0]->Items_Formula_Expression.'" data-formula_Json="'.$formulaData[0]->Items_Formula_Json.'" data-toggle="tooltip" title="View Report Chart" onclick="showReportChart(this)">' . $userListRow->User_fullName . ' (' . $userListRow->User_email . ')</a></td>';

          $tableRow .= '<tr> <td>' . $slNo . '</td> <td title="' . $userListRow->User_username . '"><a href="javascript:void(0);" data-user_id=' . $userListRow->User_id . ' data-enterprise_id=' . $userListRow->Enterprise_ID . ' data-toggle="tooltip" title="View Sub-factor Chart" onclick="showReportChart(this)">' . $userListRow->User_fullName . ' (' . $userListRow->User_email . ')</a></td>';

          if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') {
            //if superadmin login then show Company/Institute Name
            // $tableRow .= '<td>' . $userListRow->Enterprise_Name . '</td> <td></td>';
            $tableRow .= '<td>' . $userListRow->Enterprise_Name . '</td>';
          }
          // fetching user over all data according to formula
          // $tableRow .= "<td>" . $this->overallValue($userListRow->User_id, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json) . "</td>";

          $returned_Value = $this->overallValue($userListRow->User_id, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
          $returned_Value = json_decode($returned_Value);

          $user_Input_Date       = $returned_Value->input_Date ? $returned_Value->input_Date : 0;
          //setting cap for overall value at 200
          $user_Overall_Value    = $returned_Value->overall_Value >= 200 ? 200 :  round($returned_Value->overall_Value, 2);
          $overall_Scatter_Chart[$slNo - 1][0] = array($user_Input_Date);
          $overall_Scatter_Chart[$slNo - 1][1] = array($user_Overall_Value);

          $tableRow .= '<td>' . $user_Overall_Value . '</td> <td><a href="javascript:void(0);" data-user_id=' . $userListRow->User_id . ' data-enterprise_id=' . $userListRow->Enterprise_ID . ' data-toggle="tooltip" title="Download Report" onclick="downloadReport(this)"><i class="fa fa-download"></i></a></td>';

          $tableRow .= '</tr>';
          $slNo++;
        }
        // prd($overall_Scatter_Chart);
      }
      //print_r($returned_Value->averageJson);
      $returnTableHtml .= $tableRow . '</tbody></table>';
      // die($returnTableHtml);
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Table Created Successfully.', 'data' => $returnTableHtml, 'overallScatterChart' => $overall_Scatter_Chart]));
    }
  } // end of getReportTwoDataTable function

  public function downloadReportTwoTableData($formData=NULL) {
    // prd($formData); exit();
    $this->load->library('PHPExcel');

    $reportData    = explode('/', trim(base64_decode($formData))); 
    $selectedGame  = (isset($reportData[0])) ? $reportData[0] : NULL;
    $gamestartdate = (isset($reportData[1])) ? date('Y-m-d', $reportData[1]) : NULL;
    $gameenddate   = (isset($reportData[2])) ? date('Y-m-d', $reportData[2]) : NULL;
    $Enterprise    = (isset($reportData[3])) ? $reportData[3] : NULL;
    $SubEnterprise = (isset($reportData[4])) ? $reportData[4] : NULL;
    //==================================

    // $siteUsers     = $this->input->post('siteUsers'); // this will be of array type
    // $userId        = array();

    // // if no user is selected then show error
    // if (count($siteUsers)<1) {
    //   $this->session->set_flashdata('er_msg', 'Please select at least one user');
    //   redirect(current_url());
    // }
    // else {
    //   for ($i=0; $i<count($siteUsers); $i++) {
    //     $userId[] = $siteUsers[$i];
    //   }
    // }
    // $userId    = implode(',', $userId);

    // $reportSql = 'SELECT gi.input_current, CONCAT( IF(gc.Comp_NameAlias != "" AND gc.Comp_NameAlias IS NOT NULL,gc.Comp_NameAlias,gc.Comp_Name), "/", IF( gs.SubComp_NameAlias != "" AND gs.SubComp_NameAlias IS NOT NULL, gs.SubComp_NameAlias, IF(gs.SubComp_Name IS NOT NULL,gs.SubComp_Name,"") ) ) AS Comp_SubComp, CONCAT( gu.User_fname, " ", gu.User_lname) AS fullName, gu.User_username AS userName, gu.User_email AS userEmail 
    // FROM GAME_INPUT gi 
    // INNER JOIN GAME_SITE_USERS gu ON gu.User_id = gi.input_user 
    // INNER JOIN GAME_LINKAGE_SUB gls ON gi.input_sublinkid = gls.SubLink_ID AND gls.SubLink_ShowHide=0 AND gls.SubLink_InputMode !="none" 
    // LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID 
    // LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID 
    // WHERE ( gls.SubLink_LinkID IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = '.$selectedGame.' ) AND gls.SubLink_Type = 1 ) AND gi.input_user IN('.$userId.')';

     $reportSql = 'SELECT gi.input_current, CONCAT( IF(gc.Comp_NameAlias != "" AND gc.Comp_NameAlias IS NOT NULL,gc.Comp_NameAlias,gc.Comp_Name), "/", IF( gs.SubComp_NameAlias != "" AND gs.SubComp_NameAlias IS NOT NULL, gs.SubComp_NameAlias, IF(gs.SubComp_Name IS NOT NULL,gs.SubComp_Name,"") ) ) AS Comp_SubComp, CONCAT( gu.User_fname, " ", gu.User_lname) AS fullName, gu.User_username AS userName, gu.User_email AS userEmail 
    FROM GAME_INPUT gi 
    INNER JOIN GAME_SITE_USERS gu ON gu.User_id = gi.input_user 
    INNER JOIN GAME_LINKAGE_SUB gls ON gi.input_sublinkid = gls.SubLink_ID AND gls.SubLink_ShowHide=0 AND gls.SubLink_InputMode !="none" 
    LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID 
    LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID 
    WHERE ( gls.SubLink_LinkID IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = '.$selectedGame.' ) AND gls.SubLink_Type = 1 ) ';
    $reportData = $this->Common_Model->executeQuery($reportSql);

    $gameRes = $this->Common_Model->fetchRecords('GAME_GAME',array('Game_ID' => $selectedGame),'Game_Name');
    if(count($gameRes)>0) {
      $gameName = $gameRes[0]->Game_Name;
    }
    else {
      $gameName = 'No Game';
    }
    $objPHPExcel = new PHPExcel;
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
    $objWriter      = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
    // ob_end_clean();
    $currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
    $numberFormat   = '#,#0.##;[Red]-#,#0.##';  
    $objSheet       = $objPHPExcel->getActiveSheet();

    $objSheet->setTitle('Simulation Report');
    $objSheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);
    $objSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(16);

    $objSheet->getCell('A1')->setValue('Game:'.$gameName);
    $objSheet->getCell('A2')->setValue('Name');
    $objSheet->getCell('B2')->setValue('UserName');
    $objSheet->getCell('C2')->setValue('UserEmail');

    $putUser      = 'A';
    $putUserName  = 'B';
    $putUserEmail = 'C';
    $numUserData  = 3;
    $putComp      = 'D';
    $numComp      = '2';
    $tempUser     = array();
    $compSubComp  = array();
    $filename     = 'UserReport_'.date('d-m-Y').'.xlsx';

    // echo "<pre>"; print_r($reportData); exit();
    // colName will be like B2,C2,D2,E2 like this, and fullName will be like A3, A4, A5, A6 like this
    foreach ($reportData as $userGameData) {
      if (!in_array($userGameData->fullName, $tempUser)) {
        $tempUser[] = $userGameData->fullName;
        $objSheet->getCell($putUser.$numUserData)->setValue($userGameData->fullName);
        $objSheet->getCell($putUserName.$numUserData)->setValue($userGameData->userName);
        $objSheet->getCell($putUserEmail.$numUserData)->setValue($userGameData->userEmail);
        $numUserData++;
      }
      if (!in_array($userGameData->Comp_SubComp, $compSubComp)) {
        $compSubComp[$putComp] = $userGameData->Comp_SubComp;
        $objSheet->getCell($putComp.$numComp)->setValue($userGameData->Comp_SubComp);
        $putComp++;
      }
    }

    foreach ($reportData as $row) {
      $col = array_search($row->Comp_SubComp,$compSubComp);
      $val = array_search($row->fullName,$tempUser)+3; // so that we can start from the *3, where * is A,B,C...
      $objSheet->getCell($col.$val)->setValue($row->input_current);
      // echo $col.$val.' : '.$row->input_current.'<br>';
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename='.$filename);
    header('Cache-Control: max-age=0');
    $objWriter->save('php://output');
    // exit();
  
  } // end of downloadReportTwoTableData function

  // to get the list of users associated with the games
  public function getReportOneTableData() {
    // print_r($this->input->post());
    $loggedInAs      = $this->input->post('loggedInAs');
    $filterValue     = $this->input->post('filterValue');
    $enterpriseId    = $this->input->post('enterpriseId');
    $subEnterpriseId = $this->input->post('subEnterpriseId');
    $cardID          = $this->input->post('gameId');

    $startDate = date('Y-m-d H:i:s', strtotime($this->input->post('gamestartdate').' 00:00:00'));
    $endDate = date('Y-m-d H:i:s', strtotime($this->input->post('gameenddate').' 23:59:59'));

    // getting total users
    $totalUserSql = "SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gug.UG_CratedOn, ge.Enterprise_ID, ge.Enterprise_Name 
    FROM GAME_SITE_USERS gsu 
    LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId
    LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id
    WHERE gsu.User_Delete = 0 AND gug.UG_GameID = $cardID ";

    // adding filters here
    switch ($filterValue) {
      case 'superadminUsers':
        //$totalUserSql .= " AND gsu.User_MasterParentId = 21 AND gsu.User_ParentId = -1 AND gsu.User_SubParentId = -2 ";
        break;
      case 'enterpriseUsers':
        $totalUserSql .= " AND gsu.User_ParentId = ".$enterpriseId;
        break;
      case 'subEnterpriseUsers':
        $totalUserSql .= " AND gsu.User_ParentId = ".$enterpriseId." AND gsu.User_SubParentId = ".$subEnterpriseId;
        break;
    }

    // Total users
    $totalUser = $this->Common_Model->executeQuery($totalUserSql);
    // print_r($totalUser); exit();

    // =====================================================
    // Setting Data for graph
    $countTotalUsers = count($totalUser) ? count($totalUser) : 0;
    $countYetToStart = 0;
    $countPlaying    = 0;
    $countCompleted  = 0;
    // =====================================================

    // Making Report one datatable 
    $returnTableHTML = '<table class="stripe hover multiple-select-row data-table-export"> <thead> <tr> <th>Sl.No.</th> <th>Name</th> <th>Username</th> <th>Email</th> <th>Registration Date</th> ';

    if ($filterValue == 'superadminUsers') {
      // if superadmin login then show Company/Institute Name
      // $returnTableHTML .= '<th>Company/Institute</th>';
    }

    $returnTableHTML .= '<th>Assigned</th> <th>LoggedIn</th> <th>Completed</th> </tr> </thead> <tbody>';

    $slno = 0; // setting variable for table serial Number
    $tableRow = '';
    foreach ($totalUser as $detailsRow) {
    // foreach ($details as $detailsRow) {
      $slno++; // incrementing serial number

      // Setting User ID
      $userID = $detailsRow->User_id;

      // creating subquery 
      $userDataQuery = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_email, gus.US_LinkID, gug.UG_CratedOn, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId, gsu.User_ParentId, ge.Enterprise_ID, ge.Enterprise_Name  
      FROM GAME_SITE_USERS gsu
      LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id
      LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId
      INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID = $cardID
      WHERE gsu.User_Delete = 0 AND gug.UG_GameID = $cardID AND gsu.User_id = $userID ";

      // adding filters here
      switch ($filterValue) {
        case 'superadminUsers':
          //$userDataQuery .= " AND gsu.User_MasterParentId = 21 AND gsu.User_ParentId = -1 AND gsu.User_SubParentId = -2 ";
          break;
        case 'enterpriseUsers':
          $userDataQuery .= " AND gsu.User_ParentId = ".$enterpriseId;
          break;
        case 'subEnterpriseUsers':
          $userDataQuery .= " AND gsu.User_ParentId = ".$enterpriseId." AND gsu.User_SubParentId = ".$subEnterpriseId;
          break;
      }

      // die($userDataQuery);
      // $userDataDetails = $this->Common_Model->executeQuery($userDataQuery);
      // print_r($userDataDetails); exit();

      // adding the above subquery to main query
      $agentsSql = "SELECT ud.User_id, ud.User_fname, ud.User_lname, ud.User_username, ud.User_email, ud.US_LinkID, ud.UG_CratedOn, ud.Enterprise_ID, ud.Enterprise_Name 
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
        $Login        = 'Yes';
        $makeUsersColor = '';

        // Setting Complete Status
        if ($details[0]->US_LinkID > 0) {
          $Complete     = 'Yes';
          $makeUsersColor = "style='color:#28a745;'";
          $countCompleted++;
        }
        else {
          $Complete     = 'No';
          $makeUsersColor = "style='color:#fec400;'";
          $countPlaying++;
        }
      }
      else {
        $Login        = 'No';
        $Complete     = 'No';
        $makeUsersColor = "style='color:#d50000;'";
        $countYetToStart++;
      }

      // Making table row
      if (isset($details[0]->US_LinkID)) {
        $tableRow .= '<tr '.$makeUsersColor.'><!-- Sl.No. --><td>'.$slno.'</td> <!-- Name --><td>'.$details[0]->User_fname.' '.$details[0]->User_lname.'</td> <!-- Username --><td>'.$details[0]->User_username.'</td> <!-- email --><td>'.$details[0]->User_email.'</td> <!-- Registration Date (Date, Time) --><td>'.date('d-m-Y, g:i:s A', strtotime($details[0]->UG_CratedOn)).'</td>';

        if ($filterValue == 'superadminUsers') {
          // $tableRow .= '<!-- Company/Institute --><td>1'.$details[0]->Enterprise_Name.'</td>';
        }

        $tableRow .= '<!-- Assigned --><td>Yes</td> <!-- Login --><td>'.$Login.'</td> <!-- Complete --><td>'.$Complete.'</td> </tr>';
      }
      else {
        $tableRow .= '<tr '.$makeUsersColor.'><!-- Sl.No. --><td>'.$slno.'</td> <!-- Name --><td>'.$detailsRow->User_fname.' '.$detailsRow->User_lname.'</td> <!-- Username --><td>'.$detailsRow->User_username.'</td> <!-- email --><td>'.$detailsRow->User_email.'</td> <!-- Registration Date (Date, Time) --><td>'.date('d-m-Y, g:i:s A', strtotime($detailsRow->UG_CratedOn)).'</td>';

        if ($filterValue == 'superadminUsers') {
          // $tableRow .= '<!-- Company/Institute --><td>2'.$detailsRow->Enterprise_Name.'</td>';
        }

        $tableRow .= '<!-- Assigned --><td>Yes</td> <!-- Login --><td>'.$Login.'</td> <!-- Complete --><td>'.$Complete.'</td> </tr>';
      }
    }
    $returnTableHTML .= $tableRow .'</tbody></table>';
    // =====================================================

    die(json_encode(["status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Report One Data.', 'data' => $returnTableHTML, 'countTotalUsers' => $countTotalUsers, 'countYetToStart' => $countYetToStart, 'countPlaying' => $countPlaying, 'countCompleted' => $countCompleted]));
  } // end of getReportOneTableData function

  // Saving report Five
  public function saveReportFiveData() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      $enterpriseID = $this->input->post('Cmap_Enterprise_ID');
      $formulaId    = $this->input->post('Cmap_Formula_ID'); // formula ID
      $action_ID    = $this->input->post('action_ID'); // Action ID

      $selectUser   = $this->input->post('selectActionUser'); // Array type
      $userCount    = count($selectUser);

      if (empty($formulaId)) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Formula To View Report.']));
      }
      else if (empty($action_ID)) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Action To View Report.']));
      }
      else {
          // setting all selected Users  0 (not selected)
          $updateWhere = array(
            'RF_Enterprize_ID' => $enterpriseID,
            'RF_Formula_ID'    => $formulaId,
            'RF_Action_ID'     => $action_ID // 1-> Shortlist, 2-> IDP, 3-> ehire
          );
          $updateArray = array(
            'RF_Status'          => 0, // 0-> Not Selected, 1-> Selected
            'RF_Update_DateTime' => date('Y-m-d H:i:s')
          );
          $result      = $this->Common_Model->updateRecords('GAME_REPORT_FIVE', $updateArray, $updateWhere);

        if ($userCount > 0) { 
          // Insert New Selected Users
          for ($i=0; $i<$userCount; $i++) {
            //selecting campuses data
            $query = "SELECT rf.RF_ID, rf.RF_User_ID 
            FROM GAME_REPORT_FIVE rf 
            WHERE rf.RF_User_ID = $selectUser[$i] AND rf.RF_Enterprize_ID = $enterpriseID AND rf.RF_Formula_ID = $formulaId AND rf.RF_Action_ID = $action_ID";
            $userData = $this->Common_Model->executeQuery($query);
            // print_r($userData[0]->RF_ID); exit();

            // if user found then update else insert new record
            if (!empty($userData[0]->RF_ID)) {
              $updateWhere = array(
                'RF_Enterprize_ID'   => $enterpriseID,
                'RF_Formula_ID'      => $formulaId,
                'RF_Action_ID'       => $action_ID, // 1-> Shortlist, 2-> IDP, 3-> ehire
                'RF_User_ID'         => $userData[0]->RF_User_ID,
              );
              $updateArray = array(
                'RF_Status' => 1, // 0-> Not Selected, 1-> Selected
                'RF_Update_DateTime' => date('Y-m-d H:i:s')
              );
              $result = $this->Common_Model->updateRecords('GAME_REPORT_FIVE', $updateArray, $updateWhere);
            }
            else {
              $insertArray = array(
                'RF_Enterprize_ID'   => $enterpriseID,
                'RF_Formula_ID'      => $formulaId,
                'RF_Action_ID'       => $action_ID, // 1-> Shortlist, 2-> IDP, 3-> ehire
                'RF_User_ID'         => $selectUser[$i],
                'RF_Status'          => 1, // 0-> Not Selected, 1-> Selected
                'RF_DateTime'        => date('Y-m-d H:i:s'),
                'RF_Update_DateTime' => date('Y-m-d H:i:s'),
              );
              // print_r($insertArray); exit();
              $result = $this->Common_Model->insert('GAME_REPORT_FIVE', $insertArray);
            }
          } // end of loop

          // 1-> Shortlist, 2-> IDP, 3-> ehire
          if ($action_ID == 1) {
            die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Saved Shortlist Users', 'data' => '']));
          }
          else if ($action_ID == 2) {
            die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Saved IDP Users', 'data' => '']));
          }
          else if ($action_ID == 3) {
            die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Saved ehire Users', 'data' => '']));
          }
          else {
            die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Saved Users', 'data' => '']));
          }
          
        }
        else {
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'All Users Removed Successfully.']));
        }
      }
    }
  } // end of getReportOneTableData function
}
