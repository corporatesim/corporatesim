<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

// $object   = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
// $sitename = $functionsObj->FetchObject($object);
$file   = 'ScenarioBranching.php';
$header = 'Scenario Branching';

// selcting all games for dropdown
// $object   = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), 'Game_Name', '', '', '', 0);
$sql = " SELECT * FROM GAME_GAME WHERE Game_ID IN (SELECT Link_GameID FROM GAME_LINKAGE GROUP BY Link_GameID HAVING COUNT(Link_GameID)>1 ) ORDER BY Game_Name";
$object = $functionsObj->ExecuteQuery($sql);
if($object->num_rows > 0);

{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameName[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// selcting all scenario linked with the games for dropdown
$object = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
if($object->num_rows > 0)
{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameScenario[] = $gameDetails;
	}
	// echo "<pre>"; print_r($gameName); exit;
}

// for save and update ScenarioBranching
if(isset($_POST['addBranching']) && $_POST['addBranching'] == 'addBranching')
{
	// remove last element of post variable
	array_pop($_POST);
	// echo "<pre>"; print_r($_POST); // exit;
	$sql = "INSERT INTO GAME_BRANCHING_SCENARIO (Branch_IsEndScenario,Branch_NextLinkId,Branch_GameId,Branch_ScenId,Branch_CompId,Branch_MinVal,Branch_MaxVal,Branch_Order,Branch_NextScen,Branch_LinkId) values ";

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
	$NextScenario  = $_POST['NextScenario'];
	$lastScenario  = $_POST['end'];

	if($count > 1)
	{
		for($i=0; $i<$count; $i++)
		{
			$nextSql       = " SELECT Link_ID FROM GAME_LINKAGE WHERE Link_ScenarioID=$NextScenario[$i] AND Link_GameID=$gameId ";
			$NextScenId    = $functionsObj->ExecuteQuery($nextSql);
			$NextScenIdObj = $functionsObj->FetchObject($NextScenId);
			$values[]      = "($lastScenario[$i],$NextScenIdObj->Link_ID,$gameId,$scenarioId,$ComponentName[$i],$minVal[$i],$maxVal[$i],$order[$i],$NextScenario[$i],$linkId)";
		}
		$queryValue = implode(',',$values);
	}	
	else
	{
		$nextSql       = " SELECT Link_ID FROM GAME_LINKAGE WHERE Link_ScenarioID=$NextScenario[0] AND Link_GameID=$gameId ";
		$NextScenId    = $functionsObj->ExecuteQuery($nextSql);
		$NextScenIdObj = $functionsObj->FetchObject($NextScenId);
		// echo "<pre>"; print_r($NextScenIdObj); exit;
		$values[]      = "($lastScenario[0],$NextScenIdObj->Link_ID,$gameId,$scenarioId,$ComponentName[0],$minVal[0],$maxVal[0],$order[0],$NextScenario[0],$linkId)";
		$queryValue    = implode(',',$values);
	}
	
	$sql .= $queryValue;
	// die($sql);
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

	header("Location: ".site_root."ux-admin/ScenarioBranching");
	exit();
}

// for adding the scenarioBranching or saving
if(isset($_GET['add']) && $_GET['add'] == 'add')
{
	$file = 'addScenarioBranching.php';
	// echo "<pre>"; print_r($_POST);
	// die('here');
}

// for editing table records
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file      = 'editScenarioBranching.php';
	$Branch_Id = $_GET['edit'];
	$editSql   = "SELECT gb.*,gm.Game_Name,gc.Scen_Name FROM GAME_BRANCHING_SCENARIO gb LEFT JOIN GAME_GAME gm ON gm.Game_ID=gb.Branch_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID=gb.Branch_ScenId WHERE Branch_Id = $Branch_Id";
	$editRes   = $functionsObj->ExecuteQuery($editSql);
	// if user try to edit by passing the self branch id
	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edith record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/ScenarioBranching");
		exit();
	}

	$editResObject = $editRes->fetch_object();
	// echo "<pre>"; print_r($editResObject);
	// die('edited '.$file);
	if(isset($_POST['editBranching']) && $_POST['editBranching'] == 'editBranching')
	{
		// remove last element of post variable
		array_pop($_POST);
		// echo "<pre>"; print_r($_POST);
		$Link_GameID   = $_POST['gameId'];
		$ScenId        = $_POST['NextScenario'];
		$nextSql       = " SELECT Link_ID FROM GAME_LINKAGE WHERE Link_ScenarioID=$ScenId AND Link_GameID=$Link_GameID ";
		$NextScenId    = $functionsObj->ExecuteQuery($nextSql);
		$NextScenIdObj = $functionsObj->FetchObject($NextScenId);
		$lastScenario  = $_POST['end'];
		// die($nextSql); $NextScenIdObj->Link_ID
		$updateArr     = array(
			'Branch_CompId'     => $_POST['ComponentName'],
			'Branch_NextScen'   => $_POST['NextScenario'],
			'Branch_NextLinkId' => $NextScenIdObj->Link_ID,
			'Branch_MinVal'     => $_POST['minVal'],
			'Branch_MaxVal	'   => $_POST['maxVal'],
			'Branch_Order'      => $_POST['order'],
		);
		if($lastScenario == 1)
		{
			$updateArr['Branch_IsEndScenario'] = $lastScenario;
		}
		else
		{
			$updateArr['Branch_IsEndScenario'] = 0;
		}
		$updateData = $functionsObj->UpdateData ( 'GAME_BRANCHING_SCENARIO', $updateArr, 'Branch_Id', $_POST['Branch_Id']  );
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
		header("Location: ".site_root."ux-admin/ScenarioBranching");
		exit();
	}
}

// for deleting table records
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$deleteId = base64_decode($_GET['delete']);
	// echo "<pre>"; print_r($_POST);
	$deleteSql = "UPDATE GAME_BRANCHING_SCENARIO SET Branch_IsActive=1 WHERE Branch_Id=$deleteId";
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
	header("Location: ".site_root."ux-admin/ScenarioBranching");
	exit();
}

// for table data
$dataQuery = "SELECT gb.*,gg.Game_Name,gc.Scen_Name,gcn.Scen_Name AS NextSceneName,gcomp.Comp_Name FROM GAME_BRANCHING_SCENARIO gb LEFT JOIN GAME_GAME gg ON gg.Game_ID = gb.Branch_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gb.Branch_ScenId LEFT JOIN GAME_COMPONENT gcomp ON gcomp.Comp_ID = gb.Branch_CompId LEFT JOIN GAME_SCENARIO gcn ON gcn.Scen_ID = gb.Branch_NextScen WHERE Branch_IsActive = 0";
$object = $functionsObj->ExecuteQuery($dataQuery);
// print_r($object); exit;

//download scenario branching in excelsheet..
if(isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download'){
	$game     = $_POST['game'];
	$scenario1 = $_POST['scenario'];
	$scenario = implode(',',$scenario1);
	//echo $scenario;


	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('ScenarioBranching');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Scenario');
	$objSheet->getCell('B1')->setValue('Game');
	$objSheet->getCell('C1')->setValue('Scenario');
	$objSheet->getCell('D1')->setValue('Component');
	$objSheet->getCell('E1')->setValue('Min Value');
	$objSheet->getCell('F1')->setValue('Max Value');
	$objSheet->getCell('G1')->setValue('Next ScenName');

	if($game == '' && $scenario == '')
	{
	$sql = "SELECT gbs.Branch_MinVal,gbs.Branch_MaxVal,gg.Game_Name,gs.Scen_Name,gc.Comp_Name,gsn.Scen_Name AS NextSceneName FROM GAME_BRANCHING_SCENARIO gbs INNER JOIN GAME_GAME gg ON gbs.Branch_GameId=gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gbs.Branch_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gbs.Branch_CompId = gc.Comp_ID INNER JOIN GAME_SCENARIO gsn ON gbs.Branch_NextScen = gsn.Scen_ID";
  }
  elseif($scenario == '')
  {
    $sql = "SELECT gbs.Branch_MinVal,gbs.Branch_MaxVal,gg.Game_Name,gs.Scen_Name,gc.Comp_Name,gsn.Scen_Name AS NextSceneName FROM GAME_BRANCHING_SCENARIO gbs INNER JOIN GAME_GAME gg ON gbs.Branch_GameId=gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gbs.Branch_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gbs.Branch_CompId = gc.Comp_ID INNER JOIN GAME_SCENARIO gsn ON gbs.Branch_NextScen = gsn.Scen_ID WHERE gbs.Branch_GameId = $game";
  }
  else
  {
  	$sql = "SELECT gbs.Branch_MinVal,gbs.Branch_MaxVal,gg.Game_Name,gs.Scen_Name,gc.Comp_Name,gsn.Scen_Name AS NextSceneName FROM GAME_BRANCHING_SCENARIO gbs INNER JOIN GAME_GAME gg ON gbs.Branch_GameId=gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gbs.Branch_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gbs.Branch_CompId = gc.Comp_ID INNER JOIN GAME_SCENARIO gsn ON gbs.Branch_NextScen = gsn.Scen_ID WHERE gbs.Branch_GameId = $game AND gbs.Branch_ScenId IN ($scenario)";
  }
	
	/*$sql = "SELECT gg.Game_Name,gs.Scen_Name,gc.Comp_Name FROM GAME_PERSONALIZE_OUTCOME gpo INNER JOIN GAME_GAME gg ON gpo.Outcome_GameId = gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gpo.Outcome_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gpo.Outcome_CompId = gc.Comp_ID WHERE Scen_Datetime BETWEEN '$fromdate' AND '$enddate'";*/
	
	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->Game_Name);
			$objSheet->getCell('C'.$i)->setValue($row->Scen_Name);
			$objSheet->getCell('D'.$i)->setValue($row->Comp_Name);
			$objSheet->getCell('E'.$i)->setValue($row->Branch_MinVal);
			$objSheet->getCell('F'.$i)->setValue($row->Branch_MaxVal);
			$objSheet->getCell('G'.$i)->setValue($row->NextSceneName);
			$i++;
		}
	}
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	
	$objSheet->getColumnDimension('C')->setWidth(20);	
	$objSheet->getColumnDimension('D')->setWidth(20);
	$objSheet->getColumnDimension('E')->setWidth(20);
	$objSheet->getColumnDimension('F')->setWidth(20);	
	$objSheet->getColumnDimension('G')->setWidth(20);	

	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="scenariobranching.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}

$query = "SELECT * FROM GAME_GAME WHERE Game_Delete = 0 ORDER BY Game_Name ASC";
$execute = $functionsObj->ExecuteQuery($query);

include_once doc_root.'ux-admin/view/ScenarioBranching/'.$file;