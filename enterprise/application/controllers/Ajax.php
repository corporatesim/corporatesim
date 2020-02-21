<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
  private $loginDataLocal;
  public function __construct()
  {
    parent::__construct();
    $this->loginDataLocal = $this->session->userdata('loginData');
    if($this->session->userdata('loginData') == NULL)
    {
     $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
     redirect('Login/login');
   }
 }

 public function fetchAssignedGames($gameFor=NULL,$id=NULL)
 {
  if($gameFor == 'enterpriseUsers')
  {
    $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_ENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.EG_GameID WHERE gg.Game_Delete=0 AND ge.EG_EnterpriseID=".$id." ORDER BY gg.Game_Name";
  }
  if($gameFor == 'subEnterpriseUsers')
  {
    $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_SUBENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.SG_GameID WHERE Game_Delete=0 AND ge.SG_SubEnterpriseID=".$id." ORDER BY gg.Game_Name";
  }
  $gameData = $this->Common_Model->executeQuery($gameQuery);
  if(count($gameData)>0)
  {
    echo json_encode($gameData);
  }
  else
  {
    echo 'No game found';
  }
}

public function fetchAssignedGroups($groupFor=NULL,$entId=NULL, $subEntId=NULL)
{
  if($groupFor == 'enterpriseUsers')
  {
    $groupWhere = array(
      'Group_Delete'      => 0,
      'Group_ParentId'    => $entId,
      'Group_SubParentId' => -2,
      'Group_CreatedBy'   => $entId,
    );
  }
  if($groupFor == 'subEnterpriseUsers')
  {
    $groupWhere = array(
      'Group_Delete'      => 0,
      'Group_ParentId'    => $entId,
      'Group_SubParentId' => $subEntId,
      'Group_CreatedBy'   => $subEntId,
    );
  }
  $groupData = $this->Common_Model->fetchRecords('GAME_COLLABORATION', $groupWhere, 'Group_Id, Group_Name, Group_Info', 'Group_Name');

  // print_r($this->input->post());  print_r($this->db->last_query()); print_r($groupData);

  if(count($groupData)>0)
  {
    echo json_encode($groupData);
  }
  else
  {
    echo 'No Group found';
  }
}

public function getGroupData()
{
  // this is the collaboration/group report data function
  // print_r($this->input->post());
  $loggedInAs        = $this->input->post('loggedInAs');
  $filtertype        = $this->input->post('filtertype');
  $Group_ParentId    = $this->input->post('Enterprise');
  $Group_SubParentId = $this->input->post('SubEnterprise');
  $Group_Id          = $this->input->post('selectGroup');
  $gameId            = $this->input->post('selectGame');
  $title             = 'Error';
  $returnData        = array();

  switch($filtertype)
  {
    case 'superadminUsers':
    if(empty($Group_Id))
    {
      die(json_encode(["status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration selected']));
    }
    break;

    case 'enterpriseUsers':
    if(empty($Group_Id) || empty($Group_ParentId))
    {
      die(json_encode(["status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration or enterprise selected']));
    }
    break;

    case 'subEnterpriseUsers':
    if(empty($Group_Id) || empty($Group_ParentId) || empty($Group_SubParentId))
    {
      die(json_encode(["status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration, enterprise or subEnterprise selected']));
    }
    break;
  }

  if(!empty($Group_Id))
  {
    // creating sql to find the data for making pie/donut chart for groups
    $graphSql = "SELECT gcol.Group_Id, gcol.Group_Name, gcol.Group_Info, gcum.Map_Id, gcum.Map_GameId, gg.Game_Name, gl.Lead_Id, gl.Lead_ScenId, gl.Lead_CompId, gc.Comp_Name, gc.Comp_NameAlias, gl.Lead_Order, gcum.Map_UserId FROM GAME_COLLABORATION gcol LEFT JOIN GAME_COLLABORATION_USERS_MAPPING gcum ON gcum.Map_GroupId = gcol.Group_Id AND gcum.Map_GameId=".$gameId." LEFT JOIN GAME_GAME gg ON gg.Game_ID = gcum.Map_GameId AND gg.Game_ID=".$gameId." LEFT JOIN GAME_LEADERBOARD gl ON gl.Lead_GameId = gcum.Map_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 1 AND gl.Lead_Status = 0 AND Map_UserId IS NOT NULL AND gcol.Group_Id=".$Group_Id;
    // print_r($this->input->post()); die($graphSql);
    $graphSqlResult = $this->Common_Model->executeQuery($graphSql);
    $message        = 'No data found for the selected group/collaboration.';
    $icon           = 'error';

    if(count($graphSqlResult) > 0)
    {
      $message                      = 'Please wait while loading...';
      $icon                         = 'success';
      $title                        = 'Success';
      $returnData['Group_Name']     = $graphSqlResult[0]->Group_Name ;
      $returnData['Group_Info']     = $graphSqlResult[0]->Group_Info ;
      $returnData['Game_Name']      = $graphSqlResult[0]->Game_Name ;
      $returnData['Comp_Name']      = $graphSqlResult[0]->Comp_Name ;
      $returnData['Comp_NameAlias'] = $graphSqlResult[0]->Comp_NameAlias ;

      foreach ($graphSqlResult as $graphSqlResultRow)
      {
        $users = json_decode($graphSqlResultRow->Map_UserId);
        for($i=0; $i<count($users); $i++)
        {
          // find the users(this is nothing but team o/p) o/p data from game input table, Lead_ScenId
          $inputSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS fullName, gsu.User_username, gsu.User_email, gi.input_current FROM GAME_SITE_USERS gsu LEFT JOIN GAME_INPUT gi ON gsu.User_Id = gi.input_user AND gi.input_user=".$users[$i]." AND gi.input_sublinkid =( SELECT SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_CompID=".$graphSqlResult[0]->Lead_CompId." AND gls.SubLink_SubCompID < 1 AND gls.SubLink_LinkID =( SELECT Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID=".$graphSqlResult[0]->Map_GameId." AND gl.Link_Status = 1 AND gl.Link_ScenarioID=".$graphSqlResult[0]->Lead_ScenId." ) ) WHERE gsu.User_id=".$users[$i]." ORDER BY gi.input_caretedOn DESC";
          // echo $inputSql.'<br><br>';
          $inputSqlResult             = $this->Common_Model->executeQuery($inputSql);
          $outputValue                = ($inputSqlResult[0]->input_current)?$inputSqlResult[0]->input_current:0;
          $returnData['userData'][]   = array(
            'User_id'       => $inputSqlResult[0]->User_id,
            'fullName'      => $inputSqlResult[0]->fullName,
            'User_username' => $inputSqlResult[0]->User_username,
            'User_email'    => $inputSqlResult[0]->User_email,
            'input_current' => $outputValue,
            'chartColor'    => '#'.$this->random_color(),
          );
        }
      }
      die(json_encode(["status" => "200", 'title' => $title, 'icon' => $icon, 'message' => $message, 'data' => $returnData]));
    }
    else
    {
      // foreach ($graphSqlResult as $graphSqlResultRow)
      // {
      //   $users = json_decode($graphSqlResultRow->Map_UserId);
      // }
      // print_r($users);
      // print_r($returnData);
      die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Collaboration output not set for selected game.']));
    }

  }
  else
  {
    die(json_encode(["status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'Something went wrong. Please try later.']));
  }

}

public function getCollaborationGames($Map_GroupId=NULL)
{
  if(empty($Map_GroupId))
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Please select collaboration.']));
  }
  else
  {
    $findCollaborationGames = "SELECT gg.Game_ID,gg.Game_Name FROM GAME_COLLABORATION_USERS_MAPPING gum LEFT JOIN GAME_GAME gg ON gg.Game_ID=gum.Map_GameId WHERE gum.Map_GroupId=".$Map_GroupId;

    $collaborationGames = $this->Common_Model->executeQuery($findCollaborationGames);

    if(count($collaborationGames)>0)
    {
      die(json_encode(["status" => "200", 'title' => 'success', 'icon' => 'success', 'message' => 'Fetched Associated Games.', 'gameData' => $collaborationGames]));
    }
    else
    {
      die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This collaboration is not associated with any game.']));
    }
  }
}

// generate random html color hex value, for chart data or multipurpose

private function random_color() {
  return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
}

private function random_color_part() {
  return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

public function showPerformanceChart($userid=NULL, $gameid=NULL)
{
  $performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn, IF((SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId) > (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1)), (SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId), (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1))) AS max_value FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =".$gameid." AND gp.Performance_Delete = 0 AND gp.Performance_UserId =".$userid." ORDER BY gp.Performance_CreatedOn";

  $performanceData = $this->Common_Model->executeQuery($performanceSql);
  if(count($performanceData) > 1)
  {
    $chartData             = [];
    $chartLabels           = [];
    $overAllBenchmark      = [];
    $performanceGraphTitle = ($performanceData[0]->Comp_NameAlias)?$performanceData[0]->Comp_NameAlias:$performanceData[0]->Comp_Name;
    foreach ($performanceData as $performanceDataRow)
    {
      $chartData[]        = $performanceDataRow->Performance_Value;
      $chartLabels[]      = $performanceDataRow->Performance_CreatedOn;
      $overAllBenchmark[] = $performanceDataRow->max_value;
    }

    die(json_encode(['chartData' => $chartData, 'chartLabels' => $chartLabels, 'graphTitle' => $performanceGraphTitle, 'overAllBenchmark' => $overAllBenchmark, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Performance Graph Data.']));
  }
  else
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'User has either not completed the game or not played more than once.']));
  }
}

public function downloadGameReport($userid=NULL, $game_id=NULL, $returnUrl=NULL)
{
  $linkid = $this->Common_Model->executeQuery("SELECT Link_ID FROM `GAME_LINKAGE` WHERE Link_ScenarioID= (SELECT US_ScenID FROM `GAME_USERSTATUS` WHERE US_UserID=".$userid." and US_GameID=".$game_id." ) AND Link_GameID=".$game_id."")[0]->Link_ID;

  $gameDataSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS FullName, gsu.User_email AS Email, gsu.User_mobile AS Mobile, gsu.User_profile_pic AS ProfileImage, gg.Game_Name, gg.Game_ReportFirstPage, gg.Game_ReportSecondPage, gsu.User_ParentId, gsu.User_SubParentId, ge.Enterprise_Name, ge.Enterprise_Logo, gse.SubEnterprise_Name, gse.SubEnterprise_Logo FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gsu.User_id = gug.UG_UserID AND gug.UG_GameID =".$game_id." LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gsu.User_ParentId AND ge.Enterprise_Status=0 LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsu.User_SubParentId AND gse.SubEnterprise_Status=0 WHERE gsu.User_id=".$userid;
  $gameData = $this->Common_Model->executeQuery($gameDataSql)[0];
  // echo "<pre>"; print_r($gameData); exit(); // Game_ReportFirstPage Game_ReportSecondPage
  $sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor, gas.Sequence_Order AS Area_Sequencing
  FROM GAME_LINKAGE l 
  INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
  INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
  INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
  INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
  INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
  LEFT JOIN GAME_AREA_SEQUENCE gas on a.Area_ID=gas.Sequence_AreaId
  LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
  WHERE ls.SubLink_Type=1 AND gas.Sequence_LinkId=".$linkid." AND l.Link_ID=".$linkid." ORDER BY gas.Sequence_Order DESC";
  // echo $sqlarea; exit();
  $area = $this->Common_Model->executeQuery($sqlarea);
  if(count($area) > 0)
  {
    $printPdfFlag = TRUE;
    // echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();

    foreach ($area as $areaRow)
    {
      // to check that this area comp are visible or hide by admin, if visible then only show area to user else not
      $checkVisibleCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=".$userid." WHERE gls.SubLink_LinkID =".$linkid." AND gls.SubLink_AreaID =".$areaRow->AreaID." AND gls.SubLink_ShowHide = 0 AND gls.SubLink_SubCompID<1 ORDER BY gls.SubLink_Order";
      $visibleComponents   = $this->Common_Model->executeQuery($checkVisibleCompSql);
      // echo $checkVisibleCompSql.'<br>';

      if(count($visibleComponents) > 0)
      {
        // this means this area has some comp or subcomp that is visible, take this area data and break the loop
        $printPdfFlag = FALSE;
        break;
      }
    }

    // if nothing to visible then redirect to result page, showing the alert message
    if($printPdfFlag)
    {
      // die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This game output not available/visible. Please contact admin.']));
      $this->session->set_flashdata('er_msg', 'This game output not available/visible. Please contact admin.');
      redirect(base_url('OnlineReport/viewReport//'.$returnUrl));
    }

    // finding the game completion date
    $gameCompletDate = $this->Common_Model->executeQuery("SELECT US_CompletedOn FROM GAME_USERSTATUS WHERE US_GameID=$game_id AND US_UserID=$userid")[0];

    // echo count($visibleComponents)."<pre><br>".$checkVisibleCompSql.'<br>'; print_r($visibleComponents); exit();
    $pageHeader = '<table align="left" cellspacing="0" cellpadding="1" style"font-weight:bold;"><tr><td colspan="2" align="center" style="background-color:#f0f0f0;"><b>Participant Details</b></td></tr><tr style="background-color:#c4daec;"><td><b>Name</b>: </td><td>'.$gameData->FullName.'</td></tr> <tr style="background-color:#c4daec;"><td><b>Email</b>: </td><td>'.$gameData->Email.'</td></tr> <tr style="background-color:#c4daec;"><td><b>Mobile</b>: </td><td>'.'XXXXXX'.substr($gameData->Mobile, -4).'</td></tr> <tr style="background-color:#c4daec;"><td><b>Simulation/Game</b>: </td><td>'.$gameData->Game_Name.' ('.date('d-m-Y',strtotime($gameCompletDate->US_CompletedOn)).')</td></tr></table><br>'.$gameData->Game_ReportFirstPage;

    $printData = '';
    foreach ($visibleComponents as $visibleComponentsRow)
    {
      // $printData .= $visibleComponentsRow->SubLink_CompName.$visibleComponentsRow->input_current;
      $printData .= '<div style="width:100%; display:inline-block;" class="componentDiv">';

      // adding ckEditor/chart div
      $printData .= '<div class="componentDivCkeditor" style="width:50%; display:inline-block;">';
      if(empty($visibleComponentsRow->SubLink_ChartID))
      {
        $printData .= $visibleComponentsRow->SubLink_Details;
      }
      else
      {
        // $printData .= $visibleComponentsRow->SubLink_ChartID;
        $printData .= '<img src="'.site_root.'chart/'.$visibleComponentsRow->SubLink_ChartType.'.php?gameid='.$game_id.'&userid='.$userid.'&ChartID='.$visibleComponentsRow->SubLink_ChartID.'">';
      }

      $printData .= '</div>';
      // end of ckEditor/chart div

      // adding the inputField/PersonalizeOutcome div GAME_PERSONALIZE_OUTCOME
      $printData .= '<div style="width:50%; display:inline-block;" class="componentDivInputField">';

      $personalizeOutcomeSql = "SELECT * FROM GAME_PERSONALIZE_OUTCOME gpo WHERE gpo.Outcome_LinkId=".$visibleComponentsRow->SubLink_LinkID." AND gpo.Outcome_CompId=".$visibleComponentsRow->SubLink_CompID." AND gpo.Outcome_IsActive=0 ORDER BY gpo.Outcome_Order ASC";
      $personalizeOutcomeResult = $this->Common_Model->executeQuery($personalizeOutcomeSql);
      if(count($personalizeOutcomeResult) > 0)
      {
        $foundInRangeFlag = TRUE;
        foreach ($personalizeOutcomeResult as $personalizeOutcomeResultRow)
        {
          if($objectResult->Outcome_FileType !=3 && ($value>=$objectResult->Outcome_MinVal AND $value<=$objectResult->Outcome_MaxVal))
          {
            $printData .= '<img src="'.doc_root.'ux-admin/upload/Badges/'.str_replace(' ', '%20', $personalizeOutcomeResultRow->Outcome_FileName).'"><br><br><br><div>'.$personalizeOutcomeResultRow->Outcome_Description.'</div>';
            $foundInRangeFlag = FALSE;
            break;
          } 
        }
        if($foundInRangeFlag)
        {
          // if there is no condition matched, i.e. gap in range so so the value as it is
          $printData .= "Gap in range for personalizeOutcomeResult and the actual value is:- ".$visibleComponentsRow->input_current;
        }
      }
      else
      {
        $printData .= $visibleComponentsRow->input_current;
      }

      $printData .= '</div>';
      // end of adding inputField/PersonalizeOutcome div

      // after coming out from the loop check that component has subcomponent or not
      $checkVisibleSubCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=".$userid." WHERE gls.SubLink_LinkID =".$linkid." AND gls.SubLink_AreaID =".$visibleComponentsRow->SubLink_AreaID." AND gls.SubLink_ShowHide = 0 AND gls.SubLink_CompID=".$visibleComponentsRow->SubLink_CompID." AND gls.SubLink_SubCompID>1 ORDER BY gls.SubLink_Order";
      $visibleSubComponents   = $this->Common_Model->executeQuery($checkVisibleSubCompSql);

      if(count($visibleSubComponents) > 0)
      {
        foreach ($visibleSubComponents as $visibleSubComponentsRow)
        {
          $printData .= '<div class="subComponentDiv" style="width:100%; display:inline-block;">';

          // adding ckEditor/chart div
          $printData .= '<div class="subComponentDivCkeditor" style="width:50%; display:inline-block;">';
          if(empty($visibleSubComponentsRow->SubLink_ChartID))
          {
            $printData .= $visibleSubComponentsRow->SubLink_Details;
          }
          else
          {
            // $printData .= $visibleSubComponentsRow->SubLink_ChartID;
            $printData .= '<img src="'.site_root.'chart/'.$visibleSubComponentsRow->SubLink_ChartType.'.php?gameid='.$game_id.'&userid='.$userid.'&ChartID='.$visibleSubComponentsRow->SubLink_ChartID.'">';
          }

          $printData .= '</div>';
          // end of ckEditor/chart div

          // adding the inputField div
          $printData .= '<div class="subComponentDivInputField" style="width:50%; display:inline-block;">'.$visibleSubComponentsRow->input_current.'</div>';
          // end of adding inputField div

          $printData .= '</div>';
          // end of subComponentDiv
        }
      }

      $printData .= "</div>";
      // end of componentDiv
    }

    // echo $printData; exit();

    define('Enterprise_Name', ($gameData->Enterprise_Name)?$gameData->Enterprise_Name:'noVal');
    define('Enterprise_Logo', ($gameData->Enterprise_Logo)?str_replace(' ', '%20', $gameData->Enterprise_Logo):'noVal');
    define('SubEnterprise_Name', ($gameData->SubEnterprise_Name)?$gameData->SubEnterprise_Name:'noVal');
    define('SubEnterprise_Logo', ($gameData->SubEnterprise_Logo)?str_replace(' ', '%20', $gameData->SubEnterprise_Logo):'noVal');

    $this->load->library('MYPDF');
    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->Header();
    $pdf->SetFont('helvetica', '', 12);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Humanlinks');
    $pdf->SetTitle($gameData->Game_Name.' Report');
    $pdf->SetSubject('Simulation Output Report');
    $pdf->SetKeywords('Simulation, Report, Output, Result, Simulation Report');
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(0);
    $pdf->SetFooterMargin(0);

    // remove default footer
    $pdf->setPrintFooter(true);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
      require_once(dirname(__FILE__).'/lang/eng.php');
      $pdf->setLanguageArray($l);
    }

    // adding first page to show header and user data
    $pdf->AddPage();
    // ---------------------------------------------------------
    $pdf->writeHTML($pageHeader, true, false, false, false, '');

    // adding a second page for game report
    $pdf->AddPage();
    $secondPage = $gameData->Game_ReportSecondPage;
    $pdf->writeHTML($secondPage, true, false, false, false, '');

    // finally adding page to print game result
    $pdf->AddPage();
    $pdf->writeHTML($printData, true, false, false, false, '');
    $outputFileName = $gameData->FullName.'-'.$gameData->Game_Name.'_'.date('d-m-Y').'.pdf';
    // to show this pdf in browser
    // $pdf->Output($outputFileName,'I');
    // to download this pdf with the given name
    $pdf->Output($outputFileName,'D');
    // echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();
  }
  else
  {
    // die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This game output not available/visible. Please contact admin.']));
    $this->session->set_flashdata('er_msg', 'This game output not available/visible. Please contact admin.');
    redirect(base_url('OnlineReport/viewReport//'.$returnUrl));
  }

}

// get completed games and create dialog for checkboxes
public function getCompletedGames($userid=NULL)
{
  $userid = base64_decode($userid);
  $completedGameSql = "SELECT gg.Game_ID, gg.Game_Name, gus.US_ScenID, gl.Link_ID FROM GAME_GAME gg LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gg.Game_ID LEFT JOIN GAME_LINKAGE gl ON gl.Link_GameID = gg.Game_ID AND gl.Link_ScenarioID = gus.US_ScenID WHERE gus.US_UserID =".$userid." ORDER BY gg.Game_Name";
  $completedGames = $this->Common_Model->executeQuery($completedGameSql);
  // echo $completedGameSql; print_r($completedGames);
  if(count($completedGames) < 1)
  {
    // no game allocated or complted
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Selected user has not completed any game till now.']));
  }
  else
  {
    $data = '<form id="completedGamesForm"><input type="hidden" name="userid" value="'.$userid.'"><div class="row col-md-12">';
    foreach ($completedGames as $completedGamesRow)
    {
      $data .= '<div class="custom-control custom-checkbox col-md-12"><input required type="checkbox" class="custom-control-input" name="completedGameLinkId[]" id="'.$completedGamesRow->Link_ID.'" value="'.$completedGamesRow->Link_ID.'"><label class="custom-control-label" for="'.$completedGamesRow->Link_ID.'">'.$completedGamesRow->Game_Name.'</label></div>';
    }
    $data .= "</div><br><button class='btn btn-success' onclick='getCompleteReport(this,event);'>Download Report</button></form>";
    die(json_encode(["status" => "200", 'title' => 'Please select games(completed) to download consolidated report', 'icon' => 'success', 'message' => $data]));
  }
}

public function downloadCompletedGamesReport($userid=NULL,$linkid=NULL)
{
  // print_r($this->input->post());
  $userid              = $this->input->post('userid');
  $completedGameLinkId = $this->input->post('completedGameLinkId');
  if(count($completedGameLinkId) < 1)
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Please select at least one game to get report']));
  }
  else
  {
    $reportSql  = "SELECT gg.Game_Name AS gameName, gls.SubLink_LinkID, IF(IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias) IS NULL OR IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias) = ' ', IF(gc.Comp_NameAlias IS NULL OR gc.Comp_NameAlias = ' ', gc.Comp_Name, gc.Comp_NameAlias), concat(IF(gc.Comp_NameAlias IS NULL OR gc.Comp_NameAlias = ' ', gc.Comp_Name, gc.Comp_NameAlias),' / ',IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias))) AS comp_subcomp, IF(gi.input_current IS NULL OR gi.input_current = ' ',0,gi.input_current) AS inputValue FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid = gls.SubLink_ID AND gi.input_user=".$userid." LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID WHERE gls.SubLink_LinkID IN(".implode(',', $completedGameLinkId).") AND gls.SubLink_ShowHide=0 AND gls.SubLink_Type=1 ORDER BY gls.SubLink_LinkID";
    $reportData = $this->Common_Model->executeQuery($reportSql);
    // add one row to csv, for showing col name
    $rowArr = (object)array(
      'gameName'       => 'Game Name',
      'SubLink_LinkID' => 'Link Id',
      'comp_subcomp'   => 'Comp / Subcomp',
      'inputValue'     => 'Value',
    );
    array_unshift($reportData, $rowArr);

    // print_r($reportData);
    die(json_encode(["status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Please wait while downloading report.', 'data' => $reportData]));
  }
}

// to get the list of users associated with the games
public function getAgents()
{
  // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
  $loggedInAs      = $this->input->post('loggedInAs');
  $filterValue     = $this->input->post('filterValue');
  $enterpriseId    = $this->input->post('enterpriseId');
  $subEnterpriseId = $this->input->post('subEnterpriseId');
  $gameId          = $this->input->post('gameId');
  $searchFilter    = trim($this->input->post('searchFilter'));
  // creating subquery 
  $userDataQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu
  INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$gameId WHERE gsu.User_Delete=0";
  // adding filters here
  if($filterValue == 'superadminUsers')
  {
    $userDataQuery .= " AND gsu.User_MasterParentId=21 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
  }

  if($filterValue == 'enterpriseUsers')
  {
    $userDataQuery .= " AND gsu.User_ParentId=".$enterpriseId;
  }

  if($filterValue == 'subEnterpriseUsers')
  {
    $userDataQuery .= " AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=".$subEnterpriseId;
  }

  if(isset($searchFilter) && !empty($searchFilter))
  {
    $userDataQuery .= " AND (gsu.User_email LIKE '%".$searchFilter."%' OR gsu.User_username LIKE '%".$searchFilter."%') ";
  }

  // adding the above subquery to main query
  $agentsSql = "SELECT
  ud.User_id AS User_id,
  ud.User_fname AS User_fname,
  ud.User_lname AS User_lname,
  ud.User_email AS User_email,
  ud.US_LinkID
  FROM
  GAME_SITE_USER_REPORT_NEW gr
  INNER JOIN($userDataQuery) ud
  ON
  ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
  WHERE
  gr.linkid IN(
  SELECT
  Link_ID
  FROM
  GAME_LINKAGE
  WHERE
  Link_GameID = $gameId
)
ORDER BY `ud`.`US_LinkID` DESC";

$agentsResult = $this->Common_Model->executeQuery($agentsSql);
// die($agentsSql);
echo json_encode($agentsResult);
}

// to get the agents for creating the collabration
public function getAgentsForCollaboration()
{
  // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
  $loggedInAs      = $this->input->post('loggedInAs');
  $filterValue     = $this->input->post('filterValue'); // superadminUsers, enterpriseUsers, subEnterpriseUsers
  $enterpriseId    = $this->input->post('enterpriseId');
  $subEnterpriseId = $this->input->post('subEnterpriseId');
  $gameId          = $this->input->post('gameId');
  $Group_Id        = $this->input->post('Group_Id');
  $searchFilter    = trim($this->input->post('searchFilter'));
  // if filterValue is blank or not defined then show error
  if(empty($filterValue))
  {
    die(json_encode(["status" => "201", "message" => 'Please select user type to create collabration.', 'title' => 'show this title', 'icon' => 'error']));
  }
  else
  {
    $collabrationAgentsSql = "SELECT gsu.User_id, CONCAT(gsu.User_fname,' ',gsu.User_lname) AS fullName, gsu.User_username, gsu.User_email, gum.Map_UserId FROM GAME_SITE_USERS gsu JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID=".$gameId." LEFT JOIN GAME_COLLABORATION_USERS_MAPPING gum ON gum.Map_GroupId=".$Group_Id." AND gum.Map_GameId=".$gameId." WHERE gsu.User_Delete=0 ";
    // getting all agents for team mapping
    $allAgentsSql = "SELECT * FROM GAME_SITE_USERS gsu WHERE gsu.User_Delete=0 ";
    switch ($filterValue)
    {
      case 'superadminUsers':
      $collabrationAgentsSql .= " AND gsu.User_Role=0 AND gug.UG_ParentId=-1 AND gug.UG_SubParentId=-2 ";
      $allAgentsSql          .= " AND gsu.User_Role=0 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
      break;

      case 'enterpriseUsers':
      $collabrationAgentsSql .= " AND gsu.User_Role=1 AND gug.UG_ParentId=".$enterpriseId." AND gug.UG_SubParentId=-2 ";
      $allAgentsSql          .= " AND gsu.User_Role=1 AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=-2 ";
      break;

      case 'subEnterpriseUsers':
      $collabrationAgentsSql .= " AND gsu.User_Role=2 AND gug.UG_ParentId=".$enterpriseId." AND gug.UG_SubParentId=".$subEnterpriseId;
      $allAgentsSql          .= " AND gsu.User_Role=2 AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=".$subEnterpriseId;
      break;
    }

    if(!empty($searchFilter))
    {
      $collabrationAgentsSql .= " AND (gsu.User_fname LIKE '%".$searchFilter."%' OR gsu.User_lname LIKE '%".$searchFilter."%' OR gsu.User_username LIKE '%".$searchFilter."%' OR gsu.User_email LIKE '%".$searchFilter."%') ";
    }
  }

  $collabrationAgentsSql .= " ORDER BY gsu.User_fname ASC ";
  $allAgentsSql          .= " ORDER BY gsu.User_fname ASC ";
  // die($collabrationAgentsSql);
  $collabrationAgentsData = $this->Common_Model->executeQuery($collabrationAgentsSql);
  $collabrationTeamData   = $this->Common_Model->executeQuery($allAgentsSql);

  die(json_encode(["status" => "200", "userdata" => $collabrationAgentsData, 'title' => 'show this title', 'icon' => 'success', 'mappedUser' => json_decode($collabrationAgentsData[0]->Map_UserId), 'message' => count($collabrationAgentsData).' Users Found.', 'teamUsersData' => $collabrationTeamData]));
}

// to get the all data of users with team mapping
public function getAllUsersWithTeamMapping()
{
  // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
  $loggedInAs      = $this->input->post('loggedInAs');
  $filterValue     = $this->input->post('filterValue'); // superadminUsers, enterpriseUsers, subEnterpriseUsers
  $enterpriseId    = $this->input->post('enterpriseId');
  $subEnterpriseId = $this->input->post('subEnterpriseId');
  $Team_UserId     = $this->input->post('teamUserId');
  // if filterValue is blank or not defined then show error
  if(empty($filterValue))
  {
    die(json_encode(["status" => "201", "message" => 'Please select filter accordingly.', 'title' => 'show this title', 'icon' => 'error']));
  }
  elseif(empty($Team_UserId))
  {
    die(json_encode(["status" => "201", "message" => 'Please select at least one team.', 'title' => 'show this title', 'icon' => 'error']));
  }
  else
  {
    // getting all agents for team mapping
    $teamAgentsSql = "SELECT User_id, User_fname, User_lname, User_email FROM GAME_SITE_USERS gsu WHERE gsu.User_Delete=0 ";
    switch ($filterValue)
    {
      case 'superadminUsers':
      $teamAgentsSql .= " AND gsu.User_Role=0 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
      break;

      case 'enterpriseUsers':
      $teamAgentsSql .= " AND gsu.User_Role=1 AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=-2 ";
      break;

      case 'subEnterpriseUsers':
      $teamAgentsSql .= " AND gsu.User_Role=2 AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=".$subEnterpriseId;
      break;
    }
  }

  $teamAgentsSql .= " ORDER BY gsu.User_fname ASC ";
  // these are all the users
  $allUsersdata   = $this->Common_Model->executeQuery($teamAgentsSql);
  // these are mapped users
  $mappedUserData = $this->Common_Model->fetchRecords('GAME_TEAM_MAPPING',array('Team_UserId' => $Team_UserId));

  // echo "<pre>"; print_r($mappedUserData); echo "<br><br>"; print_r($allUsersdata);

  if(count($mappedUserData) < 1)
  {
    // is there is no mapping
    // echo "<pre>"; print_r($mappedUserData); echo "<br><br>"; print_r($allUsersdata);
    $collabrationTeamData = $allUsersdata;
  }
  else
  {
    // echo "<pre>"; print_r(json_decode($mappedUserData[0]->Team_Users)); echo "<br><br>"; print_r($allUsersdata);
    $mappedUserIds = json_decode($mappedUserData[0]->Team_Users);
    foreach ($allUsersdata as $allUsersdataRow)
    {
      if(in_array($allUsersdataRow->User_id, $mappedUserIds))
      {
        // echo 'exist_'.$allUsersdataRow->User_id.'<br>';
        $allUsersdataRow->exist = 'checked';
      }
      else
      {
        $allUsersdataRow->exist = '';
      }
    }
    $collabrationTeamData = $allUsersdata;
  }

  die(json_encode(["status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => 'show this message', 'teamUsersData' => $collabrationTeamData]));
}

public function getTeamMembers($Team_UserId=NULL)
{
  if(empty($Team_UserId))
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'No Team Selected']));
  }
  else
  {
    $teamData = $this->Common_Model->fetchRecords('GAME_TEAM_MAPPING',array('Team_UserId' => $Team_UserId));
    if(count($teamData) < 1)
    {
      // is there is no mapping
      die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'No User Mapped.']));
    }
    else
    {
      $mappedUserIds = implode(',', json_decode($teamData[0]->Team_Users));
      // print_r($mappedUserIds); echo implode(',', $mappedUserIds);
      $userDetails = $this->Common_Model->fetchRecords('GAME_SITE_USERS',"User_id IN ($mappedUserIds)",'User_id, CONCAT(User_fname," ",User_lname) AS fullName, User_mobile, User_email, User_username');
      die(json_encode(["status" => "200", 'title' => 'Associated Team Members', 'icon' => 'success', 'message' => 'Associated Team Members', 'teamUsersData' => $userDetails]));
    }
  }
}

public function addEditDeleteFetchCollaboration($modification=NULL,$Group_Id=NULL)
{
  // print_r($_SESSION); print_r($this->input->post()); echo $modification.' and '.$Group_Id; exit(); enterpriseUsers subEnterpriseUsers superadminUsers
  $Enterprise_ID    = $this->input->post('Enterprise_ID');
  $SubEnterprise_ID = $this->input->post('SubEnterprise_ID');
  $fetchFor         = $this->input->post('fetchFor');

  if(isset($this->loginDataLocal['User_ParentId']) && !empty($this->loginDataLocal['User_ParentId']))
  {
    // it means this is either enterprise or subenterprise login, and login user will be creator
    if($this->loginDataLocal['User_SubParentId'] == $this->loginDataLocal['User_ParentId'])
    {
      // this is enterprise login
      $ParentId    = $this->loginDataLocal['User_ParentId'];
      $SubParentId = -2;
      $CreatedBy   = $this->loginDataLocal['User_ParentId'];
      if(!empty($SubEnterprise_ID))
      {
        // it means enterprise is looking for subenterprise
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='".$ParentId."' AND Group_SubParentId='".$SubEnterprise_ID."' AND Group_CreatedBy='".$SubEnterprise_ID."' AND Group_Delete=0 ";
      }
      else
      {
        // it means enterprise is looking for itself
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='".$ParentId."' AND Group_SubParentId='".$SubParentId."' AND Group_CreatedBy='".$ParentId."' AND Group_Delete=0 ";
      }
    }
    else
    {
      // this is subenterprise login
     $ParentId    = $this->loginDataLocal['User_ParentId'];
     $SubParentId = $this->loginDataLocal['User_SubParentId'];
     $CreatedBy   = $this->loginDataLocal['User_SubParentId'];
     $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='".$ParentId."' AND Group_SubParentId='".$SubParentId."' AND Group_CreatedBy='".$SubParentId."' AND Group_Delete=0 ";
   }
 }
 else
 {
    // it means this is superadmin login, and login user will be creator
   $ParentId    = -1;
   $SubParentId = -2;
   $CreatedBy   = 1;
   if(!empty($Enterprise_ID) && $fetchFor=='enterpriseUsers')
   {
      // it means superadmin is looking for enterprise
    $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='".$Enterprise_ID."' AND Group_CreatedBy='".$Enterprise_ID."' AND Group_Delete=0 ";
  }
  elseif(!empty($SubEnterprise_ID) && $fetchFor=='subEnterpriseUsers')
  {
    // it means superadmin is looking for subenterprise
    $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='".$Enterprise_ID."' AND Group_SubParentId='".$SubEnterprise_ID."' AND Group_CreatedBy='".$SubEnterprise_ID."' AND Group_Delete=0 ";
  }
  else
  {
    // it means superadmin is looking for itself
    $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId=-1 AND Group_SubParentId=-2 AND Group_CreatedBy=1 AND Group_Delete=0 ";
  }
}

if(empty($modification))
{
  die(json_encode(["status" => "201", "message" => 'Send proper information.']));
}
else
{
  $Group_Name   = trim($this->input->post('Group_Name'));
  $Group_Info   = trim($this->input->post('Group_Info'));
  $searchFilter = ($this->input->post('searchFilter'))?trim($this->input->post('searchFilter')):'';
  $where        = array('Group_Id' => $Group_Id,);
  // check if group name is empty or not
  if(empty($Group_Name) && ($modification != 'fetch' && $modification != 'delete'))
  {
    die(json_encode(["status" => "201", 'title' => 'show this title', 'icon' => 'error', 'message' => 'Name/Info field can not be empty.']));
  }

  switch ($modification)
  {
    case 'add':
    $insertArray = array(
      'Group_Name'           => $Group_Name,
      'Group_Info'           => $Group_Info,
      'Group_MasterParentId' => -21,
      'Group_ParentId'       => $ParentId,
      'Group_SubParentId'    => $SubParentId,
      'Group_CreatedBy'      => $CreatedBy,
    );

    $retData = $this->Common_Model->insert('GAME_COLLABORATION',$insertArray);
    $message = 'Record Added Successfully.';
    break;

    case 'edit':
    $updateArray = array('Group_Name' => $Group_Name, 'Group_Info' => $Group_Info, 'Group_UpdatedBy' => $this->loginDataLocal['User_Id'], 'Group_UpdatedOn' => date('Y-m-d H:i:s'));
    $retData     = $this->Common_Model->updateRecords('GAME_COLLABORATION',$updateArray,$where);
    $message     = 'Record Updated Successfully.';
    break;

    case 'delete':
    $updateArray   = array('Group_Delete ' => 1);
    $deleteMapping = $this->Common_Model->deleteRecords('GAME_COLLABORATION_USERS_MAPPING',array('Map_GroupId'=>$Group_Id,));
    $retData       = $this->Common_Model->softDelete('GAME_COLLABORATION',$updateArray,$where);
    $message       = 'Record Deleted Successfully.';
    break;

    case 'fetch':
    if(!empty($searchFilter))
    {
      $fetch_where .= " AND(Group_Name LIKE '%".$searchFilter."%' OR Group_Info LIKE '%".$searchFilter."%') ";
    }
    $retData = $this->Common_Model->fetchRecords('GAME_COLLABORATION',$fetch_where,'','Group_Name','',0);
    // print_r($this->input->post());
    $message = 'Record Fetched Successfully.';
    die(json_encode(["status" => "200", 'title' => 'show this title', 'icon' => 'success', 'groupData' => $retData]));
    break;
  }
  die(json_encode(["status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => $message]));
}

}

public function teamUserMapping()
{
  // print_r($this->input->post());
  // team id is nothing but user id
  $teamId    = $this->input->post('teamDropdown');
  // users will be of array type
  $teamUsers = $this->input->post('teamUsers');
  if(empty($teamId))
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Select Team.']));
  }

  elseif(empty($teamUsers))
  {
    die(json_encode(["status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Select at least one user.']));
  }

  else
  {
    // deleting existing user mapping and createing new mapping
    $deleteWhere        = array('Team_UserId' => $teamId);
    $deleteExistingData = $this->Common_Model->deleteRecords('GAME_TEAM_MAPPING',$deleteWhere);

    $insertMapArray     = array(
      'Team_UserId'    => $teamId,
      'Team_Users'     => json_encode($teamUsers),
      'Team_CreatedBy' => $this->loginDataLocal['User_Id'],
    );
    $teamMapping        = $this->Common_Model->insert('GAME_TEAM_MAPPING',$insertMapArray);

    die(json_encode(["status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => 'Users Mapped Successfully']));
  }

}

public function get_states($Country_Id=NULL)
{
  if(!empty($Country_Id))
  {
    $whereState  = array(
      'State_Status'    => 0,
      'State_CountryId' => $Country_Id,
    );
    $resultState = $this->Common_Model->fetchRecords('GAME_STATE',$whereState);
    if(count($resultState) > 0)
    {
      echo json_encode($resultState);
    }
    else
    {
      echo 'nos';
    }
  }
  else
  {
    echo 'no';
  }
}

public function get_subenterprise($SubEnterprise_EnterpriseID=NULL)
{
  $whereState  = array(
   'SubEnterprise_Status'       => 0,
   'SubEnterprise_EnterpriseID' => $SubEnterprise_EnterpriseID,
 );
  $resultSubEnterprise = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$whereState);
  echo json_encode($resultSubEnterprise);
}

public function get_dateRange($id=NULL)
{
  $this->db->select('Enterprise_StartDate,Enterprise_EndDate');
  $this->db->where(array('Enterprise_ID' => $id));
  $result                       = $this->db->get('GAME_ENTERPRISE')->result();
  // print_r($this->db->last_query()); die(' here ');    // print_r($result[0]);
  $result                       = $result[0];
  $result->Enterprise_StartDate = strtotime($result->Enterprise_StartDate);
  $result->Enterprise_EndDate   = strtotime($result->Enterprise_EndDate);
  echo json_encode($result);
}

//csv upload for enterprise...
public function enterprisecsv()
{
  if(strpos(base_url(),'localhost') !== FALSE)
  {
    $sendEmail = FALSE;
  }
  else
  {
    $sendEmail = TRUE;
  }

  $maxFileSize = 2097152; 
  // Set max upload file size [2MB]
  $validext    = array ('xls', 'xlsx', 'csv');  

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $not_inserted_data = array();
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag)
          {
            $flag = false; continue; 
          }

          if( !empty($filesop) )
          {
            $date      = $filesop[6];
            $StartDate = date("Y-m-d", strtotime($date));
            $newdate   = $filesop[7];
            $EndDate   = date("Y-m-d", strtotime($newdate));
            $password  = $filesop[5];

            $email     = $filesop[2];
            $mobile    = $filesop[1];

            $where     = array(
              "Enterprise_Number" => $mobile,
              "Enterprise_Email"  => $email
            );
            // die(print_r($where));
            $object  = $this->Common_Model->findCount('GAME_ENTERPRISE',$where,0,0,0);
            //print_r($object);exit;
            //print_r($this->db->last_query()); exit();
            if($object > 0)
            {
              array_push($not_inserted_data,$filesop[2]);
              //echo "abcd";exit;
              //$result  = "email and mobile already registered";
            }
            else
            {
              if($password != '')
              {
                $password = $filesop[5];
              }
              else
              {
                $password = $this->Common_Model->random_password();
              }

              $array = array(
                "Enterprise_Name"      => $filesop[0],
                "Enterprise_Number"    => $filesop[1],
                "Enterprise_Email"     => $filesop[2],
                "Enterprise_Address1"  => $filesop[3],
                "Enterprise_Address2"  => $filesop[4],
                "Enterprise_Password"  => $password,
                "Enterprise_StartDate" => $StartDate,
                "Enterprise_EndDate"   => $EndDate,
              );

              /*print_r($array);exit();*/
              $insertResult = $this->Common_Model->insert("GAME_ENTERPRISE", $array, 0, 0);
              /*print_r($this->db->last_query());exit;*/
              $c++;
              if($insertResult && $sendEmail)
              {
                // send mail only if in live server, not in local
                $EnterpriseName = $filesop[0];
                $password1      = $password;
                $to             = $filesop[2];
                $from           = "support@corporatesim.com";
                $subject        = "New Account created..";
                $message        = "Dear User Your Account has been created";
                $message       .= "<p>Enterprise Name : ".$EnterpriseName;
                $message       .= "<p>Email : ".$filesop[2];
                $message       .= "<p>Password : ".$password1;
                $header         = "From:" . $from . "\r\n";
                $header        .= "MIME-Version: 1.0\r\n";
                $header        .= "Content-type: text/html; charset: utf8\r\n";
                mail($to,$from,$subject,$message,$header);
              }
            }
          }
        }
        if (!empty($not_inserted_data))
        {
          $msg = "</br>Email id not imported -> ".implode(" , ",$not_inserted_data);
        }

        $result = array(
          "msg"    => "Import successfull",
          "status" => 1
        );

      }
      catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error:",
          "status" => 0
        );
      }
    }
  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}


//csv functionality for enterprise Users
public function EnterpriseUsersCSV($Enterpriseid=NULL)
{
  // Set max upload file size [2MB]
  $maxFileSize    = 2097152;
  $User_UploadCsv = time();
  // Allowed Extensions
  $validext       = array ('xls', 'xlsx', 'csv');

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    //echo $explode_filename[0];
    //exit();
    $ext = strtolower( end($explode_filename) );
    //echo $ext."\n";
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $not_inserted_data = array();
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;
        $duplicate         = array();

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag)
          {
            // to skip the 1st row that is title/header in file
            $flag = false;
            continue;
          }

          if( !empty($filesop) )
          {
            //convert the date format 
            $dateDoesNotAccept = array('.','-');
            $startDate         = str_replace($dateDoesNotAccept, '/', $filesop[6]);
            $endDate           = str_replace($dateDoesNotAccept, '/', $filesop[7]);
            $userStartDate     = date("Y-m-d", strtotime($startDate));
            $userEndDate       = date("Y-m-d", strtotime($endDate));
            $email             = $filesop[4];
            $mobile            = $filesop[3];
            $where             = array(
              "User_mobile" => $mobile,
              "User_email"  => $email
            );
            // echo $filesop[7].' csvSD '.$startDate.' sD '.$userStartDate. ' csvED '.$endDate.' eD '.$userEndDate; exit();

            $object = $this->Common_Model->findCount('GAME_SITE_USERS',$where);
            if($object > 0)
            {
              // echo "details already registered";
              $duplicate[] = $email;
              continue;
              // exit();
            }

            if($Enterpriseid == 0)
            {
              $entid = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $entid = $Enterpriseid;
            }
            $insertArray = array(
              "User_fname"         => $filesop[0],
              "User_lname"         => $filesop[1],
              "User_username"      => $filesop[2],
              "User_mobile"        => $filesop[3],
              "User_email"         => $filesop[4],
              "User_companyid"     => $filesop[5],
              "User_Role"          => 1,
              "User_ParentId"      => $entid,
              "User_GameStartDate" => $userStartDate,
              "User_GameEndDate"   => $userEndDate,
              "User_datetime"      => date("Y-m-d H:i:s"),
              'User_UploadCsv'     => $User_UploadCsv,
            );
            // print_r($filesop); echo $userStartDate. ' and '.$userEndDate; print_r($insertArray);exit();
            $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
            // print_r($this->db->last_query());exit;
            $c++;
            if($result)
            {
              $uid           = $result;
              $password      = $this->Common_Model->random_password(); 
              $login_details = array(
                'Auth_userid'    => $uid,
                'Auth_username'  => $filesop[2],
                'Auth_password'  => $password,
                'Auth_date_time' => date('Y-m-d H:i:s')
              );
              $result1 = $this->Common_Model->insert('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
            }
          }
        }

        if(count($duplicate) > 0)
        {
          $shoMsg = $c." Record Import successful and the below email id's are duplicate so not inserted:-<br>".implode('<br>',$duplicate);
        }
        else
        {
          $shoMsg = $c." Record Import successful";
        }

        $result = array(
          "msg"    => $shoMsg,
          "status" => 1
        );
      }
      catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error: ".$e,
          "status" => 0
        );
      }
    }
    else
    {
      $result = array(
        "msg"    => "Please select CSV or Excel file only",
        "status" => 0
      );
    }
  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}

//csv upload for subenterprise...
public function subenterprisecsv($enterpriseid=NULL)
{
  if(strpos(base_url(),'localhost') !== FALSE)
  {
    $sendEmail = FALSE;
  }
  else
  {
    $sendEmail = TRUE;
  }

  // Set max upload file size [2MB]
  $maxFileSize = 2097152;
  // Allowed Extensions
  $validext    = array ('xls', 'xlsx', 'csv'); 

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file   = $_FILES['upload_csv']['tmp_name'];
        $handle = fopen($file, "r");
        $flag   = true;
        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag) { $flag = false; continue; }
          if( !empty($filesop) )
          {
           // convert the date format 
            $date      = $filesop[6];
            $StartDate = date("Y-m-d", strtotime($date));
            $newdate   = $filesop[7];
            $EndDate   = date("Y-m-d", strtotime($newdate));
            $mobile    = $filesop[1];
            $email     = $filesop[2];
            $where     = array(
              "SubEnterprise_Number" => $mobile,
              "SubEnterprise_Email"  => $email
            );
            $object = $this->Common_Model->findCount('GAME_SUBENTERPRISE',$where);
            if($object > 0)
            {
              echo "details already registered";
              exit;
            }

            if($enterpriseid == 0)
            {
              $enterprise = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $enterprise = $enterpriseid;
            }

            $password = $filesop[5];
            if($password != '')
            {
              $password = $filesop[5];
            }
            else
            {
              $password = $this->Common_Model->random_password();
            }

            $array = array(
              "SubEnterprise_Name"         => $filesop[0],
              "SubEnterprise_Number"       => $filesop[1],
              "SubEnterprise_Email"        => $filesop[2],
              "SubEnterprise_Address1"     => $filesop[3],
              "SubEnterprise_Address2"     => $filesop[4],
              "SubEnterprise_Password"     => $password,
              "SubEnterprise_EnterpriseID" => $enterprise,
              "SubEnterprise_StartDate"    => $StartDate,
              "SubEnterprise_EndDate"      => $EndDate,
            );
            // print_r($array);exit();
            $insertResult = $this->Common_Model->insert("GAME_SUBENTERPRISE", $array, 0, 0);
            if($insertResult && $sendEmail)
            {
              $SubEnterpriseName = $filesop[0];
              $password1         = $password;
              $to                = $filesop[2];
              $from              = "support@corporatesim.com";
              $subject           = "New Account created..";
              $message           = "Dear User Your Account has been created";
              $message          .= "<p>Enterprise Name : ".$SubEnterpriseName;
              $message          .= "<p>Email : ".$filesop[2];
              $message          .= "<p>Password : ".$password1;
              $header            = "From:" . $from . "\r\n";
              $header           .= "MIME-Version: 1.0\r\n";
              $header           .= "Content-type: text/html; charset: utf8\r\n";
              // mail($to,$from,$subject,$message,$header);
            }
          }

        }
        $result = array(
          "msg"    => "Import successful",
          "status" => 1
        );

      } catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error:",
          "status" => 0
        );
      }
    }
    else
    {
      $result = array(
        "msg"    => "Please select CSV or Excel file only",
        "status" => 0
      );
    }

  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}

//csv upload for subenterprise users
public function SubEnterpriseUsersCSV($Enterpriseid=NULL,$SubEnterpriseid=NULL)
{
  // Set max upload file size [2MB]
  $maxFileSize    = 2097152;
  $User_UploadCsv = time();
  // Allowed Extensions
  $validext       = array ('xls', 'xlsx', 'csv'); 

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      {
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;
        $duplicate         = array();

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag) { $flag = false; continue; }

          if( !empty($filesop) )
          {
            //convert the date format 
            $startDate     = $filesop[6];
            $endDate       = $filesop[7];
            $userStartDate = date("Y-m-d", strtotime($startDate));
            $userEndDate   = date("Y-m-d", strtotime($endDate));
            $mobile        = $filesop[3];
            $email         = $filesop[4];
            $where         = array(
              "User_mobile" => $mobile,
              "User_email"  => $email
            );

            $object = $this->Common_Model->findCount('GAME_SITE_USERS',$where);
            if($object > 0)
            {
              // echo "details already registered";
              $duplicate[] = $email;
              continue;
              // exit;
            }
            //enterpriseid for admin and enterprise login
            if($Enterpriseid == 0)
            {
              $entid = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $entid = $Enterpriseid;
            }

            if($SubEnterpriseid == 0)
            {
              $subentid = $this->session->userdata('loginData')['User_SubParentId'];
            }
            else
            {
              $subentid = $SubEnterpriseid;
            }

            $insertArray = array(
              "User_fname"         => $filesop[0],
              "User_lname"         => $filesop[1],
              "User_username"      => $filesop[2],
              "User_mobile"        => $filesop[3],
              "User_email"         => $filesop[4],
              "User_companyid"     => $filesop[5],
              "User_Role"          => 2,
              "User_ParentId"      => $entid,
              "User_SubParentId"   => $subentid,
              "User_GameStartDate" => $userStartDate,
              "User_GameEndDate"   => $userEndDate,
              "User_datetime"      => date("Y-m-d H:i:s"),
              'User_UploadCsv'     => $User_UploadCsv,
            );
            $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
            $c++;
            if($result)
            {
              $uid           = $result;
              $password      = $this->Common_Model->random_password(); 
              $login_details = array(
                'Auth_userid'    => $uid,
                'Auth_username'  => $filesop[2],
                'Auth_password'  => $password,
                'Auth_date_time' => date('Y-m-d H:i:s')
              );

              $result1 = $this->Common_Model->insert('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
            }
          }
        }
        if(count($duplicate) > 0)
        {
          $shoMsg = $c." Record Import successful and the below email id's are duplicate so not inserted:-<br>".implode('<br>',$duplicate);
        }
        else
        {
          $shoMsg = $c." Record Import successful";
        }

        $result = array(
          "msg"    => $shoMsg,
          "status" => 1
        );

      } catch (Exception $e) {
        $result = array(
          "msg"    => "Error: ".$e,
          "status" => 0
        );
      }
    }
    else
    {
      $result = array(
        "msg"    => "Please select CSV or Excel file only",
        "status" => 0
      );
    }

  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }

  echo json_encode($result);
}

public function getDomainName($Domain_Name=NULL)
{
  $Domain_Name = $Domain_Name;
  $where       = array(
    'Domain_Status' => 0,
    'Domain_Name'   => trim("http://".$Domain_Name.".corporatesim.com"),
  );
  $resultDomain_Name = $this->Common_Model->findCount('GAME_DOMAIN',$where);
  if($resultDomain_Name > 0)
  {
    // for duplicate
    echo 'no';
  }
  else
  {
    echo 'success';
  }
}

public function userReportData()
{
  print_r($this->input->post());
}

}

