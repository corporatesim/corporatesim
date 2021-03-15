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
	$sql     = "SELECT gl.Link_ID AS linkid, gl.Link_ScenarioID AS Scen_ID, gc.Scen_Name FROM `GAME_LINKAGE` gl LEFT JOIN GAME_GAME gm ON gm.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gl.Link_ScenarioID WHERE gl.Link_GameID = $Game_ID ORDER BY gc.Scen_Name ASC";
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


// to update the button text for submit in i/p page
if ($_POST['action'] == 'updateButtonText') {
	// print_r($_POST);
	$linkid = $_POST['linkid'];

  // input button 
	$inputbuttontext  = trim($_POST['inputbuttontext']) ? trim($_POST['inputbuttontext']) : 'IIII';
  // buttonAction => 1-Show Side Button, 2-Show Bottom Button, 3-Remove Both Buttons
  $buttonAction     = trim($_POST['buttonAction']) ? trim($_POST['buttonAction']) : '2';

  // output button 
	$outputbuttontext   = trim($_POST['outputbuttontext']) ? trim($_POST['outputbuttontext']) : 'IIII';
  // buttonActionOutput -> 1->Show Side Button, 2->Show Bottom Button
  $buttonActionOutput = trim($_POST['buttonActionOutput']) ? trim($_POST['buttonActionOutput']) : '2';

  // introduction button 
  $introductionbuttontext      = trim($_POST['introductionbuttontext']) ? trim($_POST['introductionbuttontext']) : 'Introduction'; 
  $introductionbuttoncolorcode = trim($_POST['introductionbuttoncolorcode']) ? trim($_POST['introductionbuttoncolorcode']) : 'lightskyblue'; 

  // description button 
  $descriptionbuttontext      = trim($_POST['descriptionbuttontext']) ? trim($_POST['descriptionbuttontext']) : 'Description'; 
  $descriptionbuttoncolorcode = trim($_POST['descriptionbuttoncolorcode']) ? trim($_POST['descriptionbuttoncolorcode']) : 'orange'; 


	if (empty($inputbuttontext) || empty($outputbuttontext)) {
		die(json_encode(['code' => 201, 'icon'=>'error', 'statusText' => 'Button text can not be left blank']));
	}
	else {
		$sql = "UPDATE GAME_LINKAGE SET Link_ButtonText='".$inputbuttontext."', Link_ButtonTextOutput='".$outputbuttontext."', Link_buttonAction='".$buttonAction."', Link_buttonActionOutput='".$buttonActionOutput."', Link_IntroductionText='".$introductionbuttontext."', Link_IntroductionColorCode='".$introductionbuttoncolorcode."', Link_DescriptionText='".$descriptionbuttontext."', Link_DescriptionColorCode='".$descriptionbuttoncolorcode."' WHERE Link_ID=$linkid";

		$Object = $funObj->ExecuteQuery($sql);
    
		die(json_encode(['code' => 200, 'icon'=>'success', 'statusText' => 'Button text updated Successfully', 'inputdefaultvalue' => $inputbuttontext, 'outputdefaultvalue' => $outputbuttontext]));
	}
}