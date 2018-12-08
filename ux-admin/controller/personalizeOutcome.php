<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'personalizeOutcome.php';
$header = 'Personalize Outcome';

// selcting all games for dropdown
$object = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0,'order by asc') ;
if($object->num_rows > 0);

{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameName[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// selcting all scenario linked with the games for dropdown
$object = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0,'order by asc');
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameScenario[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

//selecting all outcome results for dropdown
$object = $functionsObj->SelectData(array('Outcome_ResultID','Outcome_Name'), 'GAME_OUTCOME_RESULT', array('Outcome_Status=0'), '', '', '', '', 0);
if($object->num_rows > 0);

{
	while($outcomeDetails = mysqli_fetch_object($object))
	{
		$outcomeName[] = $outcomeDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// for save and update Personalize outcome
if(isset($_POST['addOutcome']) && $_POST['addOutcome'] == 'addOutcome')
{
	// remove last element of post variable
	array_pop($_POST);
	$sql = "INSERT INTO GAME_PERSONALIZE_OUTCOME (Outcome_GameId,Outcome_ScenId,Outcome_CompId,Outcome_MinVal,Outcome_MaxVal,Outcome_Order,Outcome_Result,Outcome_LinkId) values ";

	$arr           = explode(',',$_POST['game_scenario']);
	$count         = count($_POST['ComponentName']);
	$values        = array();
	$gameId        = $_POST['game_game'];
	$game_name     = $_POST['gamename'];
	$scenarioId    = $arr['0'];
	$linkId        = $arr['1'];
	// these variables are array type
	$scenarioName  = $_POST['scenarioname'];
	$ComponentName = $_POST['ComponentName'];
	$minVal        = $_POST['minVal'];
	$maxVal        = $_POST['maxVal'];
	$order         = $_POST['order'];
	$outcome       = $_POST['Outcome'];
  echo $outcome;
	if($count > 1)
	{
		for($i=0; $i<$count; $i++)
		{
			$values[] = "($gameId,$scenarioId,$ComponentName[$i],$minVal[$i],$maxVal[$i],$order[$i],$outcome[$i],$linkId)";
		}
		$queryValue = implode(',',$values);
	}	
	else
	{
		$values[]   = "($gameId,$scenarioId,$ComponentName[0],$minVal[0],$maxVal[0],$order[0],$outcome[0],$linkId)";
		$queryValue = implode(',',$values);
	}
	$sql          .= $queryValue;
	$queryExecute  =  $functionsObj->ExecuteQuery($sql);
	if($queryExecute)
	{
		$tr_msg             = "Record Saved Successfully";
		$_SESSION['tr_msg'] = $tr_msg;
	}
	else
	{
		$er_msg             = "Database Connection Error, Please Try Later";
		$_SESSION['er_msg'] = $er_msg;
	}

	header("Location: ".site_root."ux-admin/personalizeOutcome");
	exit();
}

// for adding the Personalize outcome or saving
if(isset($_GET['add']) && $_GET['add'] == 'add')
{
	$file = 'addPersonalizeOutcome.php';
	// echo "<pre>"; print_r($_POST);
	// die('here');
}

//*/ for editing table records
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file      = 'editPersonalizeOutcome.php';
	$OutcomeID = $_GET['edit'];
	$editSql   = "SELECT gp.*,gm.Game_Name,gc.Scen_Name,go.Outcome_Name FROM GAME_PERSONALIZE_OUTCOME gp LEFT JOIN GAME_GAME gm ON gm.Game_ID=gp.Outcome_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID=gp.Outcome_ScenId LEFT JOIN GAME_OUTCOME_RESULT go ON go.Outcome_ResultID = gp.Outcome_Result WHERE OutcomeID = $OutcomeID";
	$editRes   = $functionsObj->ExecuteQuery($editSql);
	
	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edith record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/personalizeOutcome");
		exit();
	}

	$editResObject = $editRes->fetch_object();
	 // echo "<pre>"; print_r($editResObject);
	 // die('edited '.$file);
	if(isset($_POST['editOutcome']) && $_POST['editOutcome'] == 'editOutcome')
	{
		// remove last element of post variable
		array_pop($_POST);
		 //echo "<pre>"; print_r($_POST); die();
		$updateArr = array(
			'Outcome_CompId'   => $_POST['ComponentName'],
			'Outcome_MinVal'   => $_POST['minVal'],
			'Outcome_MaxVal	'  => $_POST['maxVal'],
			'Outcome_Order'    => $_POST['order'],
			'Outcome_Result'   => $_POST['outcome'],
			'OutcomeID'        => $_POST['Outcome_Id'],
		);
		$updateData = $functionsObj->UpdateData ( 'GAME_PERSONALIZE_OUTCOME', $updateArr, 'OutcomeID', $_POST['Outcome_Id']  );
		//die($updateData);
		if($updateData)
		{
			$tr_msg             = "Record Updated Successfully";
			$_SESSION['tr_msg'] = $tr_msg;
		}
		else
		{
			$er_msg             = "Database connection error, while updaing records";
			$_SESSION['er_msg'] = $er_msg;
		}
		header("Location: ".site_root."ux-admin/personalizeOutcome");
		exit();
	}
}

// for deleting table records
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$deleteId = $_GET['delete'];
	// echo "<pre>"; print_r($_POST);
	$deleteSql = "UPDATE GAME_PERSONALIZE_OUTCOME SET Outcome_IsActive=1 WHERE OutcomeID=$deleteId";
	$deleteRes = $functionsObj->ExecuteQuery($deleteSql);
	if($deleteRes)
	{
		$tr_msg             = "Record Deleted Successfully";
		$_SESSION['tr_msg'] = $tr_msg;
	}
	else
	{
		$er_msg             = "Database Connection Error While Deleting, Please Try Later";
		$_SESSION['er_msg'] = $er_msg;
	}
	header("Location: ".site_root."ux-admin/personalizeOutcome");
	exit();
}

// for table data
$dataQuery = "SELECT gp.*,gg.Game_Name,gc.Scen_Name,gcomp.Comp_Name,go.Outcome_Name FROM GAME_PERSONALIZE_OUTCOME gp LEFT JOIN GAME_GAME gg ON gg.Game_ID = gp.Outcome_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gp.Outcome_ScenId LEFT JOIN GAME_COMPONENT gcomp ON gcomp.Comp_ID = gp.Outcome_CompId LEFT JOIN GAME_OUTCOME_RESULT go ON go.Outcome_ResultID = gp.Outcome_Result WHERE Outcome_IsActive = 0";
//print_r($dataQuery);
$object = $functionsObj->ExecuteQuery($dataQuery);
 //print_r($object); exit;


include_once doc_root.'ux-admin/view/PersonalizeOutcome/'.$file;