<?php

include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(300);

$funObj = new Functions();
$UserID = $_SESSION['userid'];

if($_POST['action'] == 'replay')
{
	$GameID    = $_POST['GameID'];
	$ScenID    = $_POST['ScenID'];
	$LinkID    = $_POST['LinkID'];
	// taking this query to set the default scenario which is the first scenario of the game
	$scenSql   = " SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_GameID=$GameID ORDER BY Link_Order ASC LIMIT 1";
	$resObj    = $funObj->ExecuteQuery($scenSql);
	$result    = $funObj->FetchObject($resObj);
	// delete from game inputs
	$deleteSql = " DELETE FROM GAME_INPUT WHERE input_user = $UserID AND input_sublinkid IN( SELECT SubLink_Id FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID IN ( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $GameID))";
	// die($deleteSql);
	$resultDelete = $funObj->ExecuteQuery($deleteSql);

	// delete from game_output
	$sqlOut = " DELETE FROM GAME_OUTPUT WHERE output_user =$UserID AND output_sublinkid IN(SELECT Sublink_ID FROM GAME_LINKAGE_SUB WHERE Sublink_LinkID IN (SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID) AND Sublink_Type=1)";
	$sqlOutDel = $funObj->ExecuteQuery($sqlOut);

	$updateSql = " DELETE FROM GAME_USERSTATUS WHERE US_UserID = $UserID AND US_GameID = $GameID AND US_ScenID = $ScenID ";
	// echo $sql.'<br>';
	$resultUpdate = $funObj->ExecuteQuery($updateSql);
	// also make game_linkage_users table unplayed
	$unplay       = " DELETE FROM GAME_LINKAGE_USERS WHERE UsScen_GameId =$GameID AND UsScen_UserId=".$UserID;
	$objectUnplay = $funObj->ExecuteQuery($unplay);
	
	$updTimer     = "UPDATE GAME_LINKAGE_TIMER glt SET glt.timer =( SELECT SUM( (gl.Link_Hour * 60) + gl.Link_Min ) FROM GAME_LINKAGE gl WHERE gl.Link_ID = glt.linkid) WHERE glt.userid = $UserID AND glt.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=$GameID)";
	$funObj->ExecuteQuery($updTimer);
  // die($updTimer);
	// print_r($resultUpdate);	print_r($resultDelete);	die('here');
	//echo $updateSql.'<br>'.$deleteSql; die();

 //to reduce the replaycount with 1
	$qry ="SELECT UG_ReplayCount FROM GAME_USERGAMES WHERE UG_GameID = $GameID AND UG_UserID = $UserID";
	$execute = $funObj->ExecuteQuery($qry);
	$fetch   = $funObj->FetchObject($execute);
	$replayCount = $fetch->UG_ReplayCount;
	//echo $replayCount;exit;
	if($replayCount == -1)
	{

	}
	elseif($replayCount>0)
	{
		$replayCount-=1;

		$qry = "UPDATE GAME_USERGAMES SET UG_ReplayCount = $replayCount WHERE UG_GameID = $GameID AND UG_UserID = $UserID";
		$updatedqry = $funObj->ExecuteQuery($qry);

	}
	else
	{

	}


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
