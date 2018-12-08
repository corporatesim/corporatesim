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
	// echo $sql;
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		$resultJson = [];
		while ($result = mysqli_fetch_object($Object))
		{
			$resultJson[] = $result;		    
		}
		// print_r($resultJson);
		echo json_encode($resultJson);
	}
	else
	{
		echo 'no link';
	}
}

// to get the users linked with the game with scenario
if($_POST['action'] == 'outputComponent')
{
	// print_r($_POST);
	$linkid = $_POST['linkid'];
	$sql    = "SELECT SubLink_CompID,Comp_Name,SubLink_ID FROM `GAME_LINKAGE_SUB` LEFT JOIN GAME_COMPONENT ON Comp_ID=SubLink_CompID WHERE SubLink_LinkID = $linkid AND SubLink_Type = 1 AND SubLink_SubCompID=0";
	// die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		while($result = mysqli_fetch_object($Object))
		{
			$outputComponent[] = $result;
		}
		// print_r($outputComponent);
		echo json_encode($outputComponent);
	}
	else
	{
		echo 'no link';
	}
}
