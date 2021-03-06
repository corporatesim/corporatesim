<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'personalizeOutcome.php';
$header = 'Personalized Outcome';

// selcting all games for dropdown
$object = $functionsObj->SelectData(array('Game_ID','Game_Name'), 'GAME_GAME', array('Game_Delete=0'), 'Game_Name', '', '', '', 0);
if($object->num_rows > 0);

{
	while($gameDetails = mysqli_fetch_object($object))
	{
		$gameName[] = $gameDetails;
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
	$sql = "INSERT INTO GAME_PERSONALIZE_OUTCOME (Outcome_GameId,Outcome_ScenId,Outcome_CompId,Outcome_MinVal,Outcome_MaxVal,Outcome_Order,Outcome_FileType,Outcome_LinkId,Outcome_FileName) values ";

	$arr             = explode(',',$_POST['game_scenario']);
	$count           = count($_POST['ComponentName']);
	$values          = array();
	$gameId          = $_POST['game_game'];
	$game_name       = $_POST['gamename'];
	$scenarioId      = $arr['0'];
	$linkId          = $arr['1'];
	// these variables are array type
	$scenarioName    = $_POST['scenarioname'];
	$ComponentName   = $_POST['ComponentName'];
	$minVal          = $_POST['minVal'];
	$maxVal          = $_POST['maxVal'];
	$order           = $_POST['order'];
	$outcome         = $_POST['Outcome'];
	$outcomeFileName = $_POST['choosenImageName'];
  // echo "<pre>"; print_r($_POST); exit();

	if($count > 1 )
	{
		for($i=0; $i<$count&&count($outcome); $i++)
		{
			$values[] = "($gameId,$scenarioId,$ComponentName[$i],$minVal[$i],$maxVal[$i],$order[$i],$outcome[$i],$linkId,'$outcomeFileName[$i]')";
		}
		$queryValue = implode(',',$values);
	}	
	else
	{
		$values[]   = "($gameId,$scenarioId,$ComponentName[0],$minVal[0],$maxVal[0],$order[0],$outcome[0],$linkId,'$outcomeFileName[0]')";
		$queryValue = implode(',',$values);
	}

	$sql .= $queryValue;
	// die($sql);
	$queryExecute = $functionsObj->ExecuteQuery($sql);

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

// for editing table records
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file      = 'editPersonalizeOutcome.php';
	$OutcomeID = $_GET['edit'];
	$editSql   = "SELECT gp.*,gm.Game_Name,gc.Scen_Name,go.Outcome_Name FROM GAME_PERSONALIZE_OUTCOME gp LEFT JOIN GAME_GAME gm ON gm.Game_ID=gp.Outcome_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID=gp.Outcome_ScenId LEFT JOIN GAME_OUTCOME_RESULT go ON go.Outcome_ResultID = gp.Outcome_FileType WHERE OutcomeID = $OutcomeID";
	$editRes   = $functionsObj->ExecuteQuery($editSql);
	//print_r($editSql );
	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edith record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/personalizeOutcome");
		exit();
	}

	$editResObject = $editRes->fetch_object();
	/* echo "<pre>"; print_r($editResObject);
	die('edited '.$file);*/
	if(isset($_POST['editOutcome']) && $_POST['editOutcome'] == 'editOutcome')
	{
		// remove last element of post variable
		array_pop($_POST);

		// if user doesn't choose file to upload
	 // echo "<pre>"; print_r($_POST); print_r($_FILES);
		if(isset($_FILES['image']) || isset($_POST['choosenImageName']))
		{
			$errors    = array();
			$file_name = $_FILES['image']['name'];
			$file_size = $_FILES['image']['size'];
			$file_tmp  = $_FILES['image']['tmp_name'];
			if(empty($file_name))
			{
				$file_name = $_POST['choosenImageName'];
				$updateArr = array(
					'OutcomeID'           => $_POST['Outcome_Id'],
					'Outcome_CompId'      => $_POST['ComponentName'],
					'Outcome_MinVal'      => $_POST['minVal'],
					'Outcome_MaxVal'      => $_POST['maxVal'],
					'Outcome_Description' => $_POST['Outcome_Description'],
					'Outcome_Order'       => $_POST['order'],
					'Outcome_FileName'    => $file_name,
					//'Outcome_FileType' => $_POST['outcome'],	
				);
        // echo "<pre>"; print_r($updateArr);print_r($_FILES);exit();
				$updateData = $functionsObj->UpdateData ( 'GAME_PERSONALIZE_OUTCOME', $updateArr, 'OutcomeID', $_POST['Outcome_Id'] );
				//print_r($updateData);exit();
			}
			else
			{
				$updateArr = array(
					'OutcomeID'             => $_POST['Outcome_Id'],
					'Outcome_CompId'        => $_POST['ComponentName'],
					'Outcome_MinVal'        => $_POST['minVal'],
					'Outcome_MaxVal	'       => $_POST['maxVal'],
					'Outcome_Description	' => $_POST['Outcome_Description'],
					'Outcome_Order'         => $_POST['order'],
					'Outcome_FileType'      => $_POST['Outcome'],
					'Outcome_FileName'      => $file_name,
				);
				//print_r($_POST);print_r($_FILES);exit();
				$move = move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);
	      //var_dump($move);
				if($move)
				{
					$updateData = $functionsObj->UpdateData ('GAME_PERSONALIZE_OUTCOME', $updateArr, 'OutcomeID', $_POST['Outcome_Id']);
					//print_r($updateData);exit();
				}
				else
				{
					$updateData = false;
          //print_r($updateData);exit();	
				}
			}
			
		}
	//die($updateArr);
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
	$deleteId = base64_decode($_GET['delete']);
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
$dataQuery = "SELECT gp.*,gg.Game_Name,gc.Scen_Name,gcomp.Comp_Name,go.Outcome_Name,gp.Outcome_FileName FROM GAME_PERSONALIZE_OUTCOME gp LEFT JOIN GAME_GAME gg ON gg.Game_ID = gp.Outcome_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gp.Outcome_ScenId LEFT JOIN GAME_COMPONENT gcomp ON gcomp.Comp_ID = gp.Outcome_CompId LEFT JOIN GAME_OUTCOME_RESULT go ON go.Outcome_ResultID = gp.Outcome_FileType WHERE Outcome_IsActive = 0";
//print_r($dataQuery);
$object = $functionsObj->ExecuteQuery($dataQuery);
 //print_r($object); exit;

//download personalize outcome in excelsheet..
if(isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download'){
	$game = $_POST['game'];
	$scenario1 = $_POST['scenario'];
	$scenario = implode(',',$scenario1);
	/*echo $game.$scenario;exit;*/

	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \???;[Red]-#,#0.## \???';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('PersonalizeOutcome');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Scenario');
	$objSheet->getCell('B1')->setValue('Game');
	$objSheet->getCell('C1')->setValue('Scenario');
	$objSheet->getCell('D1')->setValue('Component');
	$objSheet->getCell('E1')->setValue('Min Value');
	$objSheet->getCell('F1')->setValue('Max Value');
	$objSheet->getCell('G1')->setValue('File Name');
	
	if($game == '' && $scenario == '')
	{
		$sql = "SELECT gpo.Outcome_MinVal,gpo.Outcome_MaxVal,gpo.Outcome_FileName,gg.Game_Name,gs.Scen_Name,gc.Comp_Name FROM GAME_PERSONALIZE_OUTCOME gpo INNER JOIN GAME_GAME gg ON gpo.Outcome_GameId = gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gpo.Outcome_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gpo.Outcome_CompId = gc.Comp_ID";
	}
	elseif($scenario == '')
	{
		$sql = "SELECT gpo.Outcome_MinVal,gpo.Outcome_MaxVal,gpo.Outcome_FileName,gg.Game_Name,gs.Scen_Name,gc.Comp_Name FROM GAME_PERSONALIZE_OUTCOME gpo INNER JOIN GAME_GAME gg ON gpo.Outcome_GameId = gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gpo.Outcome_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gpo.Outcome_CompId = gc.Comp_ID WHERE gpo.Outcome_GameId = $game";
	}
	else
	{
		$sql = "SELECT gpo.Outcome_MinVal,gpo.Outcome_MaxVal,gpo.Outcome_FileName,gg.Game_Name,gs.Scen_Name,gc.Comp_Name FROM GAME_PERSONALIZE_OUTCOME gpo INNER JOIN GAME_GAME gg ON gpo.Outcome_GameId = gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gpo.Outcome_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gpo.Outcome_CompId = gc.Comp_ID WHERE gpo.Outcome_GameId = $game AND gpo.Outcome_ScenId IN ($scenario)";
	}
		//echo "error";
	
		/*$sql = "SELECT gg.Game_Name,gs.Scen_Name,gc.Comp_Name FROM GAME_PERSONALIZE_OUTCOME gpo INNER JOIN GAME_GAME gg ON gpo.Outcome_GameId = gg.Game_ID INNER JOIN GAME_SCENARIO gs ON gpo.Outcome_ScenId = gs.Scen_ID INNER JOIN GAME_COMPONENT gc ON gpo.Outcome_CompId = gc.Comp_ID WHERE Scen_Datetime BETWEEN '$fromdate' AND '$enddate'";*/
	
	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->Game_Name);
			$objSheet->getCell('C'.$i)->setValue($row->Scen_Name);
			$objSheet->getCell('D'.$i)->setValue($row->Comp_Name);
			$objSheet->getCell('E'.$i)->setValue($row->Outcome_MinVal);
			$objSheet->getCell('F'.$i)->setValue($row->Outcome_MaxVal);
			$objSheet->getCell('G'.$i)->setValue($row->Outcome_FileName);
			$i++;
		}
	}

	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	
	$objSheet->getColumnDimension('C')->setWidth(20);	
	$objSheet->getColumnDimension('D')->setWidth(20);
	$objSheet->getColumnDimension('E')->setWidth(15);
	$objSheet->getColumnDimension('F')->setWidth(15);
	$objSheet->getColumnDimension('G')->setWidth(20);	

	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="personalizeOutcome.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}

$query = "SELECT * FROM GAME_GAME WHERE Game_Delete = 0 ORDER BY Game_Name ASC";
$execute = $functionsObj->ExecuteQuery($query);

include_once doc_root.'ux-admin/view/PersonalizeOutcome/'.$file;