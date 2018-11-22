<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$functionsObj         = new Functions();
$_SESSION['userpage'] = 'game';
$uid                  = $_SESSION['userid'];
$check_endDate        = " SELECT User_id,User_GameEndDate FROM GAME_SITE_USERS WHERE 1 ";
$res_check            = $functionsObj->ExecuteQuery($check_endDate);
$arr = array();

while ($check_status = $functionsObj->FetchObject($res_check))
{
	if($check_status->User_GameEndDate <= date('Y-m-d'))
	{
		$update_gameStatus = $functionsObj->ExecuteQuery("UPDATE GAME_SITE_USERS SET User_gameStatus=1 WHERE User_id=$check_status->User_id");
	}
}
