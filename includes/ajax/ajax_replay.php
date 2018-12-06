<?php

include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(300);

$funObj    = new Functions();

$UserID    = $_SESSION['userid'];

/*print_r($userid);
print_r($gameid);*/

if($_POST['action'] == 'replay')
{
	$GameID  = $_POST['GameID'];
	$ScenID  = $_POST['ScenID'];
	$LinkID  = $_POST['LinkID'];
	// taking this query to set the default scenario which is the first scenario of the game
	$scenSql = " SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_GameID=$GameID ORDER BY Link_Order ASC";
	$resObj  = $funObj->ExecuteQuery($scenSql);
	$result  = $funObj->FetchObject($resObj);

	$updateSql = "UPDATE GAME_USERSTATUS SET US_LinkID=0, US_Output=0, US_Input=0, US_ScenID=$result->Link_ScenarioID WHERE US_UserID = $UserID AND US_GameID = $GameID AND US_ScenID = $ScenID ";
	// echo $sql.'<br>';
	$resultUpdate = $funObj->ExecuteQuery($updateSql);

	$deleteSql = " DELETE FROM GAME_INPUT WHERE input_user = $UserID AND input_sublinkid IN( SELECT SubLink_Id FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID = ( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $GameID AND Link_ScenarioID = $ScenID ))";
	// echo $deleteSql;
	$resultDelete = $funObj->ExecuteQuery($deleteSql);

	$updTimer = " UPDATE  GAME_LINKAGE_TIMER  gt  SET  gt.timer = (
	SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min) FROM GAME_LINKAGE gl
	WHERE gl.Link_GameID = $GameID  AND gl.Link_ScenarioID = $ScenID) WHERE
	gt.linkid = $LinkID  AND gt.userid = $UserID ";
	$funObj->ExecuteQuery($updTimer);
  /*print_r($updTimer);
  die();*/
	// print_r($resultUpdate);	print_r($resultDelete);	die('here');
	//echo $updateSql.'<br>'.$deleteSql; die();
	if($resultUpdate && $resultDelete)
	{
		echo 'redirect';
	}
	elseif($resultUpdate)
	{
		echo 'User Status Update';
	}
	elseif($resultDelete)
	{
		echo 'User Record Deleted';
	}
	else
	{
		echo 'Database Connection Error';
	}
}
