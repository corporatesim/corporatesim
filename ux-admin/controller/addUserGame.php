<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();
$url          = site_root."ux-admin/siteusers";

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	var_dump($_POST);
	exit();	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	// echo "<pre>"; print_r($_POST); exit();	
	//$uid = $_POST['id'];
	//var_dump($_POST['usergame']);
	$User_GameStartDate = $_POST['User_GameStartDate'];
	$User_GameEndDate   = $_POST['User_GameEndDate'];
	$userid             = base64_decode($_GET['edit']);
	$usergame           = $_POST['usergame']; // selected game array
	$User_ParentId      = $_POST['User_ParentId'];
	$User_SubParentId   = $_POST['User_SubParentId'];
	$gameid             = '';
	$result             = $functionsObj->DeleteData('GAME_USERGAMES','UG_UserID',$userid,0);
	
	for($i=0;$i<count($usergame);$i++)
	{
		$gameid .= $usergame[$i].',';
		// if 'game start date' is less than 'user account start date' then 'game start date' == 'user account start date'
		$startdate = (strtotime($_POST[$usergame[$i].'_startdate']) < strtotime($User_GameStartDate))?$User_GameStartDate:$_POST[$usergame[$i].'_startdate'];
		// if 'game end date' is greater than 'user account end date' then 'game end date' == 'user account end date'
		$enddate   = (strtotime($_POST[$usergame[$i].'_enddate']) > strtotime($User_GameEndDate))?$User_GameEndDate:$_POST[$usergame[$i].'_enddate'];

		$gamedetails = (object) array(
			'UG_UserID'        => $userid,
			'UG_GameID'        => $usergame[$i],
			'UG_ParentId'      => $User_ParentId,
			'UG_SubParentId'   => $User_SubParentId,
			'UG_GameStartDate' => $startdate,
			'UG_GameEndDate'   => $enddate,
			'UG_ReplayCount'   => $_POST[$usergame[$i].'_replayCount'],
		);
		// echo 'accountStartDate '.$User_GameStartDate.' gameStartDate '.$_POST[$usergame[$i].'_startdate'].'<br>'; print_r($gamedetails); echo 'accountEndDate '.$User_GameEndDate.' gameEndDate '.$_POST[$usergame[$i].'_enddate'].'<br><br>';
		$result = $functionsObj->InsertData('GAME_USERGAMES', $gamedetails, 0, 0);
	}
	
	// die(trim($gameid,','));
	if($User_GameEndDate > date('Y-m-d'))
	{
		// enable
		$User_gameStatus = '0';
	}
	else
	{
		// disable
		$User_gameStatus = '1';
	}


	$userTableData = (object) array(
		'User_games'         =>	trim($gameid,','),
		'User_GameStartDate' => $User_GameStartDate,
		'User_GameEndDate'   => $User_GameEndDate,
		// 'User_gameStatus'    => $User_gameStatus,
		'User_gameStatus'    => 0,
	);

	$result = $functionsObj->UpdateData('GAME_SITE_USERS', $userTableData, 'User_id', $userid, 0);
	// exit();
	if($result === true){
		$_SESSION['msg']     = "Games updated successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/siteusers");
		exit(0);
	}
}

$file   = 'addGame.php';
// this is to enable showing the end date after today
if($file == 'addGame.php')
{
	$enableEndDate = 'enableEndDate';
}
else
{
	$enableEndDate = '';
}

// fetch game list from db
$userid      = base64_decode($_GET['edit']);
$userGameSql = "SELECT gg.Game_ID, gg.Game_Name,gg.Game_Elearning, gg.Game_Comments,gug.UG_ID, gug.UG_GameStartDate, gug.UG_GameEndDate, gug.UG_ReplayCount, gsu.User_GameStartDate AS User_StartDate, gsu.User_GameEndDate AS User_EndDate FROM GAME_GAME gg LEFT JOIN GAME_USERGAMES gug ON gg.Game_ID = gug.UG_GameID AND gug.UG_UserID =".$userid." LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gug.UG_UserID WHERE gg.Game_Delete = 0 ORDER BY `gug`.`UG_ID` DESC, gg.Game_Name ASC";
$userGameResult = $functionsObj->ExecuteQuery($userGameSql);
// fetcing user details
$userDataObject = $functionsObj->SelectData(array('User_id,User_fname,User_lname,User_email,User_GameStartDate,User_GameEndDate,User_ParentId,User_SubParentId'), 'GAME_SITE_USERS', array('User_id='.$userid), '', '', '', '' ,0);
// echo $userGameSql."<pre>"; print_r($functionsObj->FetchObject($userDataObject)); exit();
$userData = $functionsObj->FetchObject($userDataObject);
include_once doc_root.'ux-admin/view/siteusers/'.$file;