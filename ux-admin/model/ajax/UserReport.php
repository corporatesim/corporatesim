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
	//die($Game_ID);
	$sql     = "SELECT gl.Link_ID AS linkid, gl.Link_ScenarioID AS Scen_ID, gc.Scen_Name FROM `GAME_LINKAGE` gl LEFT JOIN GAME_GAME gm ON gm.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gl.Link_ScenarioID WHERE gl.Link_GameID = $Game_ID ORDER BY Scen_Name ASC";
	// die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		//$result = mysqli_fetch_object($Object);
		
		//$result = array();
		while($data = $Object->fetch_object()){
		/*	$linkid = $data->linkid;
			$scenid = $data->Scen_ID;
			$scenname = $data->Scen_Name;*/
			$result[]=$data;
		}
		echo json_encode($result);
	}
	else
	{
		echo 'no link';
	}
}

// to get the users linked with the game with scenario
if($_POST['action'] == 'game_users')
{
	$gameId = $_POST['Link_GameID'];
	if($_POST['email_value'])
	{
		$searchEmail = $_POST['email_value'];
		$filterSql   = " AND (gu.User_email LIKE '%".$searchEmail."%' OR gu.User_username LIKE '%".$searchEmail."%')";
	}
	else
	{
		$filterSql = '';
	}
	$linkid = $_POST['linkid'];
	$sql    = "SELECT gu.User_id,concat(gu.User_fname,' ',gu.User_lname) AS Name,gu.User_username AS UserName,gu.User_email AS Email FROM GAME_SITE_USERS gu LEFT JOIN GAME_SITE_USER_REPORT_NEW gr ON gr.uid = gu.User_id ";

	if($linkid == 'all scenario')
	{
		$linkidArray   = '';
		$findLinkidSql = "SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$gameId;
		$findLinkidObj = $funObj->ExecuteQuery($findLinkidSql);
		foreach($findLinkidObj as $gameLinkid)
		{
			$linkidArray .= $gameLinkid['Link_ID'].','; 
		}
		$linkidArray = trim($linkidArray,',');
		$sql .= " WHERE linkid IN ($linkidArray)";
	}
	else
	{
		$sql .= " WHERE gr.linkid=$linkid ";
	}

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

// to download the final report of users associated with the game, scenario and applied filters
if($_POST['action'] == 'downloadUserReport')
{
	echo "<pre>";	print_r($_POST);	exit;
	$gameId          = $_POST['game_game'];
	$scenarioId      = $_POST['game_scenario'];
	$StartDate       = $_POST['StartDate'];
	$EndDate         = $_POST['EndDate'];
	$add_user_filter = $_POST['user_filter'];
	$query           = "";
}