<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';
//require_once doc_root . 'ux-admin/model/model.php';
//$functionsObj = new Model ();
// echo 'Test message';
// exit();

$funObj = new Model(); // Create Object

// print_r($_POST);
// to get the game scenario linked with the game id
if($_POST['action'] == 'game_scenario')
{
	$Game_ID = $_POST['Game_ID'];
	$sql     = "SELECT gl.Link_ID AS linkid, gl.Link_ScenarioID AS Scen_ID, gc.Scen_Name FROM `GAME_LINKAGE` gl LEFT JOIN GAME_GAME gm ON gm.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gl.Link_ScenarioID WHERE gl.Link_GameID = $Game_ID";
	// die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		$resultScenario = array();
		while($result = mysqli_fetch_object($Object))
		{
			$resultScenario[] = $result;
		}
		// print_r($resultScenario);
		echo json_encode($resultScenario);
	}
	else
	{
		echo 'no link';
	}
}

// to get the users linked with the game with scenario
if($_POST['action'] == 'game_users')
{
	if($_POST['email_value'])
	{
		$searchEmail = $_POST['email_value'];
		$filterSql   = " AND gu.User_email LIKE '%".$searchEmail."%' ";
	}
	else
	{
		$filterSql = '';
	}
	$linkid = $_POST['linkid'];
	$sql    = "SELECT gu.User_id,concat(gu.User_fname,' ',gu.User_lname) AS Name,gu.User_username AS UserName,gu.User_email AS Email FROM GAME_SITE_USERS gu LEFT JOIN GAME_SITE_USER_REPORT_NEW gr ON gr.uid = gu.User_id WHERE gr.linkid=$linkid";
	$sql .= $filterSql;
	// die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		while($result = mysqli_fetch_object($Object))
		{
			$userData[] = $result;
		}
		// print_r($userData);
		echo json_encode($userData);
	}
	else
	{
		echo 'no link';
	}
}

