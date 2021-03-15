<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'componentBranching.php';
$linkId = $_GET['link'];
$uid    = $_SESSION['ux-admin-id'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
// if there is no linkId then move to linkage page
if(!$linkId)
{
	$_SESSION['msg']     = "Invalid Request";
	$_SESSION['type[0]'] = "inputError";
	$_SESSION['type[1]'] = "has-error";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}
$query    = "SELECT gl.*,gg.Game_Name,gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE gl.Link_ID=".$linkId;
$queryObj = $functionsObj->ExecuteQuery($query);
// if user submit(save/update)
if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
	// echo "<pre>"; print_r($_SESSION['id']); print_r($_POST); exit();
	$count          = count($_POST['componentName']);
	$tableDataArray = array ();
	for($i=0; $i<$count; $i++)
	{
		$compDetail       = explode(',',$_POST['componentName'][$i]);
		$compId           = $compDetail[0];
		$sublinkId        = $compDetail[1];
		$areaId           = $compDetail[2];
		$nextCompDetail   = explode(',',$_POST['componentNextName'][$i]);
		$nextCompId       = $nextCompDetail[0];
		$nextSublinkId    = $nextCompDetail[1];
		$tableDataArray[] = "(".$compId.",".$linkId.",".$sublinkId.",".$areaId.",".$_POST['minVal'][$i].",".$_POST['maxVal'][$i].",".$_POST['order'][$i].",".$nextCompId.",".$nextSublinkId.",'".date('Y-m-d H:i:s')."',".$uid.")";

		if(empty($compId) || $_POST['minVal'][$i]=='' || $_POST['maxVal'][$i]=='' || $_POST['order'][$i]=='' || empty($nextCompId))
		{
			$_SESSION['msg']     = "Fields can not be left blank";
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location: ".site_root."ux-admin/componentBranching/link/".$linkId);
			exit(0);
		}
		// $functionsObj->InsertData('GAME_BRANCHING_COMPONENT',$tableDataArray);

	}
	if($_POST['update'] == 'update')
	{
		$deleteSql = "DELETE FROM GAME_BRANCHING_COMPONENT WHERE CompBranch_LinkId=".$linkId;
		$functionsObj->ExecuteQuery($deleteSql);
	}
	// after deleting the record updating
	$insertQery = "INSERT INTO GAME_BRANCHING_COMPONENT(CompBranch_CompId,CompBranch_LinkId,CompBranch_SublinkId,CompBranch_AreaId,CompBranch_MinVal,CompBranch_MaxVal,CompBranch_Order,CompBranch_NextCompId,CompBranch_NextCompSublinkId,CompBranch_CreatedOn,CompBranch_CreatedBy) VALUES ";
	$insertQery .= implode(',',$tableDataArray);
	$functionsObj->ExecuteQuery($insertQery);
	// echo "<pre>"; print_r($tableDataArray); exit();
	$_SESSION['msg']     = "Branching Saved Successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}
// to download the component branching
if(isset($_POST['downloadData']) && $_POST['downloadData'] == 'downloadBranchingData')
{
	$gameName      = $_POST['game_name'];
	$scenarioName  = $_POST['scen_name'];
	$downloadQuery = $_POST['downloadQuery'];
	$objPHPExcel   = new PHPExcel;
	$fileName      = 'Component Branching_'.date('d-m-Y').'.xlsx';
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();

	$objSheet->setTitle('Component Branching');
	$objSheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(12);
	$objSheet->getStyle('A2:F2')->getFont()->setBold(true)->setSize(10);

	// print_r($downloadQuery); exit();
	$objlink = $functionsObj->ExecuteQuery(trim($downloadQuery));
	$objSheet->getCell('A1')->setValue('Game: '.$gameName);
	$objSheet->getCell('B1')->setValue('Scenario: '.$scenarioName);
	$objSheet->getCell('D1')->setValue('Component Branching Data');
	$objSheet->getCell('A2')->setValue('Component Name');
	$objSheet->getCell('B2')->setValue('Min Value');
	$objSheet->getCell('C2')->setValue('Max Value');
	$objSheet->getCell('D2')->setValue('Branching Order');
	$objSheet->getCell('E2')->setValue('Next Component Name');
	$objSheet->getCell('F2')->setValue('Area');
		// validate here
	if(empty($linkId) || $objlink->num_rows<1)
	{
		die('No record found');
	}
	else
	{
		if($objlink->num_rows > 0){
			$i=3;
			while($row= $objlink->fetch_object()){
				//$objSheet->getCell('A'.$i)->setValue('Game');
				// print_r($row);
				$objSheet->getCell('A'.$i)->setValue($row->Comp_Name);
				$objSheet->getCell('B'.$i)->setValue($row->CompBranch_MinVal);
				$objSheet->getCell('C'.$i)->setValue($row->CompBranch_MaxVal);
				$objSheet->getCell('D'.$i)->setValue($row->CompBranch_Order);
				$objSheet->getCell('E'.$i)->setValue($row->NextCompName);
				$objSheet->getCell('F'.$i)->setValue($row->Area_Name);
				$i++;
			}
		}

			 //$objPHPExcel->

			//$objSheet->getColumnDimension('A')->setAutoSize(true);
		$objSheet->getColumnDimension('A')->setWidth(20);	
		$objSheet->getColumnDimension('B')->setWidth(20);	
		$objSheet->getColumnDimension('C')->setWidth(10); 
		$objSheet->getColumnDimension('D')->setWidth(30); 
		$objSheet->getColumnDimension('E')->setWidth(10);
		$objSheet->getColumnDimension('F')->setWidth(30);	

		$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
		$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
		$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
		$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
		$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fileName);
		header('Cache-Control: max-age=0');

		$objWriter->save('php://output');
	 		//$objWriter->save('testoutput.xlsx');
	 		//$objWriter->save('testlinkage.csv'); 
	}
}

if($queryObj->num_rows < 1)
{
	$_SESSION['msg']     = "No record found";
	$_SESSION['type[0]'] = "inputError";
	$_SESSION['type[1]'] = "has-error";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}
else
{
	$result = $functionsObj->FetchObject($queryObj);
	if($result->Link_Branching < 1)
	{
		$_SESSION['msg']     = "Not eligible for component branching";
		$_SESSION['type[0]'] = "inputError";
		$_SESSION['type[1]'] = "has-error";
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);
	}
	$compSql = "SELECT gls.*,gc.Comp_Name,gg.Game_Name,gs.Scen_Name,ga.Area_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_GAME gg ON gg.Game_ID=(SELECT Link_GameID FROM GAME_LINKAGE WHERE Link_ID=".$linkId.") LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=(SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_ID=".$linkId.") WHERE gls.SubLink_LinkID=".$linkId." AND gls.SubLink_ShowHide<1 AND gls.SubLink_SubCompID<1 ORDER BY gls.SubLink_Order ASC";
	// die($compSql);
	$gameScenSql = "SELECT gg.Game_Name,gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE Link_ID=".$linkId;
	$compSqlObj  = $functionsObj->ExecuteQuery($compSql);
	$gameScenObj = $functionsObj->ExecuteQuery($gameScenSql);
	$gameScen    = $functionsObj->FetchObject($gameScenObj);
	$gameName    = $gameScen->Game_Name;
	$scenName    = $gameScen->Scen_Name;
	// query for getting the branching of component
	$sqlComp     = "SELECT gbc.*,gc.Comp_Name,gcn.Comp_Name AS NextCompName, ga.Area_Name FROM GAME_BRANCHING_COMPONENT gbc LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gbc.CompBranch_CompId LEFT JOIN GAME_AREA ga ON ga.Area_ID=gbc.CompBranch_AreaId LEFT JOIN GAME_COMPONENT gcn ON gcn.Comp_ID=gbc.CompBranch_NextCompId WHERE gbc.CompBranch_LinkId = ".$linkId." ORDER BY gbc.CompBranch_Order";
	// echo $sqlComp;
}

include_once doc_root.'ux-admin/view/componentBranching/'.$file;