<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';

$functionsObj = new Model();

// Add Sub category
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	if(!empty($_POST['area_id']) && !empty($_POST['comp_id']) && !empty($_POST['SubComp_Name'])){
		$object = $functionsObj->SelectData ( array (), 'GAME_SUBCOMPONENT', array (
			'SubComp_AreaID=' . $_POST['area_id'],
			'SubComp_CompID=' . $_POST['comp_id'],
			"SubComp_Name='" .$_POST['SubComp_Name']. "'"
		), '', '', '', '', 0 );
		if ($object->num_rows > 0) {
			$msg      = 'Entered SubComponent name already present';
			$type [0] = 'inputError';
			$type [1] = 'has-error';
		} else {		
			$array = array(
				'subcomp_areaid'    => $_POST['area_id'],
				'subcomp_compid'    => $_POST['comp_id'],
				'subcomp_name'      => $_POST['SubComp_Name'],
				'SubComp_NameAlias' => $_POST['SubComp_NameAlias'],
				'subcomp_date'      => date('Y-m-d H:i:s')
			);
			
			// Insert Values in db
			$result = $functionsObj->InsertData('GAME_SUBCOMPONENT', $array, 0, 0);
			if($result){
				// Display Success Message
				$_SESSION['msg']     = 'SubComponent Added Successfully';
				$_SESSION['type[0]'] = 'inputSuccess';
				$_SESSION['type[1]'] = 'has-success';
				// Redirect to url
				header("Location:".site_root."ux-admin/ManageSubComponent");
				exit(0);
			}
		}
	}else{
		// Display Error Message
		$msg     = 'Please fill all fields';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

// Update Sub Category
if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	if(!empty($_POST['area_id']) && !empty($_POST['comp_id']) && !empty($_POST['SubComp_Name'])){
		$SubComp_ID  = $_POST['SubComp_ID'];
		$subCompName = $_POST['SubComp_Name'];
		$array       = array(
			'subcomp_areaid'    => $_POST['area_id'],
			'subcomp_compid'    => $_POST['comp_id'],
			'SubComp_NameAlias' => $_POST['SubComp_NameAlias'],
			'subcomp_name'      => $subCompName
		);
		$result = $functionsObj->UpdateData('GAME_SUBCOMPONENT', $array, 'SubComp_ID', $SubComp_ID, 0);
		// updating the GAME_LINKAGE_SUB as we made flat table to avoid joins
		$functionsObj->UpdateData('GAME_LINKAGE_SUB', array('SubLink_SubcompName' => $subCompName), 'SubLink_SubCompID', $SubComp_ID);

		if( $result === true ){
			$_SESSION['msg']     = 'Sub Component Updated Successfully';
			$_SESSION['type[0]'] = 'inputSuccess';
			$_SESSION['type[1]'] = 'has-success';
			header("Location:".site_root."ux-admin/ManageSubComponent");
			exit(0);
		}
	}else{
		$msg     = 'Field can not be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

// Edit Sub category
if(isset($_GET['Edit']) && $_GET['q'] = "ManageSubComponent"){
	$SubComp_ID = base64_decode($_GET['Edit']);
	
	$where      = array('SubComp_ID='.$SubComp_ID);
	$obj        = $functionsObj->SelectData(array(), 'GAME_SUBCOMPONENT', $where, '', '', '', '', 0);
	$result     = $functionsObj->FetchObject($obj);
	
	$component  = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID='.$result->SubComp_AreaID), 'Comp_Name', '', '', '', 0);
	$componentforexcel  = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_AreaID='.$result->SubComp_AreaID), 'Comp_Name', '', '', '', 0);
}

// Delete Subcategory
if(isset($_GET['del'])){
	$SubComp_ID = base64_decode($_GET['del']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE_SUB', array('SubLink_SubCompID='.$SubComp_ID), '', '', '', '', 0);

	if($object->num_rows > 0)
	{
		//$result = $functionsObj->FetchObject($object);
		$sql="SELECT g.Game_Name as Game, s.Scen_Name as Scenario 
		FROM `GAME_LINKAGE` l INNER JOIN GAME_GAME g on l.Link_GameID = g.Game_ID
		INNER JOIN GAME_SCENARIO s on Link_ScenarioID =s.Scen_ID
		WHERE Link_ID IN(SELECT SubLink_LinkID 
		FROM `GAME_LINKAGE_SUB` WHERE SubLink_SubCompID = ".$SubComp_ID.")";
		$sublink = $functionsObj->ExecuteQuery($sql);

		while($row = $sublink->fetch_object()){
			$strresult = $strresult." '".$row->Game."->".$row->Scenario."' ";			
		}
		$msg     = 'Cannot Delete SubComponent! SubComponent exists in '.$strresult;
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
	else
	{
		//$result = $functionsObj->UpdateData('GAME_SUBCOMPONENT', array('SubComp_Delete' => 1), 'SubComp_ID', $SubComp_ID, 0);
		$result              = $functionsObj->DeleteData('GAME_SUBCOMPONENT','SubComp_ID',$SubComp_ID,0);
			//if($result         === true){
		$_SESSION['msg']     = 'Sub Component Deleted';
		$_SESSION['type[0]'] = 'inputSuccess';
		$_SESSION['type[1]'] = 'has-success';
		header("Location:".site_root."ux-admin/ManageSubComponent");
		exit(0);
		//}
	}
}

// Fetch Services list
$area = $functionsObj->SelectData(array(), 'GAME_AREA', array('Area_Delete=0'), 'Area_Name', '', '', '', 0);
$areaforexcel = $functionsObj->SelectData(array(), 'GAME_AREA', array('Area_Delete=0'), 'Area_Name', '', '', '', 0);
// Fetch Sub Categories List
$sql  = "SELECT 
SubComp_ID, SubComp_Name, SubComp_NameAlias, (
SELECT Comp_Name FROM GAME_COMPONENT WHERE comp_id = sub.subcomp_compid
) as c_name, (
SELECT Area_name FROM GAME_AREA WHERE area_id = sub.subcomp_areaid
) as s_name 
FROM
GAME_SUBCOMPONENT as sub
WHERE 
subcomp_delete = 0
";
$subcomponent = $functionsObj->ExecuteQuery($sql);

//download Component in excelsheet..
if(isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download'){
	$areaid =  $_POST['area'];
	$areaids = implode(',',$areaid);
	//echo $areaids;exit;
	$compid =  $_POST['comp'];
	$compids = implode(',',$compid);
	/*echo $areaids;
	echo $compids;exit;*/

	//echo $areaid;exit;

	$from     =  $_POST['fromdate'];
	$end      =  $_POST['enddate'];
	$fromdate = date('Y-m-d', strtotime($from));
	$enddate  = date('Y-m-d', strtotime($end));
	//echo $fromdate;exit;

	//echo "<pre>";print_r($_POST);exit;
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('SubComponent');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Game');
	$objSheet->getCell('B1')->setValue('Area');
	$objSheet->getCell('C1')->setValue('Comp Name');
	$objSheet->getCell('D1')->setValue('SubComp Name');
	//echo $from.$end.$areaid.$compid;exit;

	if($from == '' && $end == '' && $areaid == '' && $compid == '')
	{
		$sql ="SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID";
	}

	elseif($from == '' && $end == '' && $compid == '')
	{
		$sql = "SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID WHERE gs.SubComp_AreaID IN($areaids)";
	}

	elseif($compid == '')
	{
		$sql = "SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID WHERE gs.SubComp_AreaID IN($areaids) AND SubComp_Date BETWEEN '$fromdate' AND '$enddate'";
	}

	elseif($areaid == '' && $compid == '')
	{
		$sql = "SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID WHERE SubComp_Date BETWEEN '$fromdate' AND '$enddate'";
	}

	elseif($from == '' && $end == '')
	{
		$sql = "SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID WHERE SubComp_CompID IN($compids) AND SubComp_AreaID IN ($areaids)";
				//echo $sql;exit;
	}

	else
	{
		$sql = "SELECT ga.Area_Name,gc.Comp_Name,gs.SubComp_Name FROM GAME_SUBCOMPONENT gs INNER JOIN GAME_COMPONENT gc ON gs.SubComp_CompID=gc.Comp_ID INNER JOIN GAME_AREA ga ON gs.SubComp_AreaID=ga.Area_ID WHERE SubComp_CompID IN ($compids) AND SubComp_AreaID IN ($areaids) AND SubComp_Date BETWEEN '$fromdate' AND '$enddate'";
	}
	 //echo $sql;exit;	

	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->Area_Name);
			$objSheet->getCell('C'.$i)->setValue($row->Comp_Name);
			$objSheet->getCell('D'.$i)->setValue($row->SubComp_Name);
			$i++;
		}
	}
	
	//$objPHPExcel->
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	
	$objSheet->getColumnDimension('C')->setWidth(20);
	$objSheet->getColumnDimension('D')->setWidth(20); 
	
	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="SubComponent.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
}

include_once doc_root.'ux-admin/view/manageSubComponent.php';
?>