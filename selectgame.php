<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
$localIP = getHostByName(getHostName());
// echo '<pre>'; print_r($_SERVER); var_dump($localIP); exit();
// checking login status of user while user execute or save via ajax
if($_POST['action'] == 'check_loggedIn_status')
{
	// die('here');
	echo ($_SESSION['username'])?'yes':'no';
	die();
}

// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	$msg              = "Please login form your account.";
	$_SESSION['msg']  = $msg;
	$type             = "alert alert-danger alert-dismissible";
	$_SESSION['type'] = $type;
	header("Location:".site_root."login.php");
}

$functionsObj         = new Functions();
$_SESSION['userpage'] = 'selectgame';
$uid                  = $_SESSION['userid'];
$check_endDate        = "SELECT User_GameEndDate FROM GAME_SITE_USERS WHERE User_id=$uid";
$res_check            = $functionsObj->ExecuteQuery($check_endDate);
$check_status         = $functionsObj->FetchObject($res_check);
if($check_status->User_GameEndDate <= date('Y-m-d'))
{
	$update_gameStatus = $functionsObj->ExecuteQuery("UPDATE GAME_SITE_USERS SET User_gameStatus=1 WHERE User_id=$uid");
	// die($update_gameStatus);
}
//base64_decode($_GET['edit']);
// $object               = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid,'User_companyid='.$companyid), '', '', '', '', 0);
// $userdetails          = $functionsObj->FetchObject($object);
//$url = site_root."ux-admin/index?q=siteusers";

// if user assigned b/w the defined duration and user_game_status is 0, then only show the list of games
$sql_status = "SELECT User_gameStatus,User_GameStartDate,User_GameEndDate FROM GAME_SITE_USERS WHERE User_id=$uid";
$res        = $functionsObj->ExecuteQuery($sql_status);
$res_status = $functionsObj->FetchObject($res);

// if($res_status->User_gameStatus == 1 || $res_status->User_GameStartDate > date('Y-m-d'))
// {
// 	$disable = 'disabled';
// 	if($res_status->User_GameStartDate > date('Y-m-d'))
// 	{
// 		$game_status = 'You have been assigned simulation game(s) from <span style="color:#3c763d;">'.date('d-m-Y',strtotime($res_status->User_GameStartDate)).'</span> TO <span style="color:#3c763d;">'.date('d-m-Y',strtotime($res_status->User_GameEndDate)).'</span>';
// 	}
// 	else
// 	{
// 		$game_status = 'Assigned simulations/games have been disabled or not assigned yet. If required, please contact the administration.';
// 	}
// }

// else
// {
// 	$sql = "SELECT gug.UG_GameStartDate AS startDate, gug.UG_GameEndDate AS endDate,gug.UG_ReplayCount, gg.* FROM GAME_USERGAMES gug LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID WHERE gug.UG_UserID = $uid";

// 	// echo $sql; exit();
// 	$result      = $functionsObj->ExecuteQuery($sql);
// 	$game_status = 'Assigned simulations/games have been disabled or not assigned yet. If required, please contact the administration.';
// }

// commenting the above old code, check the user disable/end date functionality later
$sql = "SELECT gug.UG_GameStartDate AS startDate, gug.UG_GameEndDate AS endDate,gug.UG_ReplayCount, gg.* FROM GAME_USERGAMES gug LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID WHERE gug.UG_UserID = $uid";
// echo $sql; exit();
$result = $functionsObj->ExecuteQuery($sql);

include_once doc_root.'views/selectgame.php';
