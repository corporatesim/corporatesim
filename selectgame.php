<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$functionsObj = new Functions();
$_SESSION['userpage'] ='game';

$uid         = $_SESSION['userid'];
//base64_decode($_GET['edit']);
$object      = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
$userdetails = $functionsObj->FetchObject($object);
//$url = site_root."ux-admin/index?q=siteusers";

$sql = "SELECT *
FROM
`GAME_USERGAMES` UG
INNER JOIN
GAME_GAME G ON UG.`UG_GameID` = G.Game_ID
WHERE
G.Game_Status = 1 AND G.Game_Delete = 0 AND UG.`UG_UserID` = ".$uid." group by UG.`UG_GameID`";

// echo $sql;
// exit();
$result = $functionsObj->ExecuteQuery($sql);

include_once doc_root.'views/selectgame.php';