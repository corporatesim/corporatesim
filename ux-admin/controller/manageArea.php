<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	if(!empty($_POST['Area_Name'])){
		$Area_Name = $_POST['Area_Name'];
		$object    = $functionsObj->SelectData(array(), 'GAME_AREA', array("Area_Name ='".$Area_Name."'"), '', '', '');
		if($object->num_rows > 0){
			$msg     = 'Entered area name already present';
			$type[0] = 'inputError';
			$type[1] = 'has-error';
		}else{
			$array = array(
				'Area_Name'            =>	ucfirst($Area_Name),
				'Area_CreateDate'      =>	date('Y-m-d H:i:s'),
				'Area_BackgroundColor' => $_POST['Area_BackgroundColor'],
				'Area_TextColor'       => $_POST['Area_TextColor'],
			);
			$result = $functionsObj->InsertData('GAME_AREA', $array);
			if($result){
				$_SESSION['msg']     = 'Area Added Successfully';
				$_SESSION['type[0]'] = 'inputSuccess';
				$_SESSION['type[1]'] = 'has-success';
				header("Location:".site_root."ux-admin/ManageArea");
			}
		}
	}else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	if(!empty($_POST['Area_Name'])){
		$Area_Name = $_POST['Area_Name'];
		$Area_ID   = $_POST['id'];
		$object    = $functionsObj->SelectData(array(), 'GAME_AREA', array("Area_Name ='".$Area_Name."'", "Area_ID !=".$Area_ID), '', '', '', '', 0);
		if($object->num_rows > 0){
			$msg     = 'Entered area name already present';
			$type[0] = 'inputError';
			$type[1] = 'has-error';
		}else{
			$array = array(
				'Area_Name'            =>	ucfirst($Area_Name),
				'Area_BackgroundColor' => $_POST['Area_BackgroundColor'],
				'Area_TextColor'       => $_POST['Area_TextColor'],
			);
			//var_dump($array);
			$result = $functionsObj->UpdateData('GAME_AREA', $array, 'Area_ID', $Area_ID);
			if($result){
				$_SESSION['msg']     = 'Area Updated Successfully';
				$_SESSION['type[0]'] = 'inputSuccess';
				$_SESSION['type[1]'] = 'has-success';
				header("Location:".site_root."ux-admin/ManageArea");
			}
		}
	}else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageArea"){
	$id                   = base64_decode($_GET['Edit']);
	$fields               = array();
	$where                = array('Area_ID='.$id);
	$obj                  = $functionsObj->SelectData($fields, 'GAME_AREA', $where, '', '', '');
	$result               = $functionsObj->FetchObject($obj);
	$Area_BackgroundColor = $result->Area_BackgroundColor;
	$Area_TextColor       = $result->Area_TextColor;

}elseif(isset($_GET['Delete'])){
	$id     = base64_decode($_GET['Delete']);
	$fields = array();
	$where  = array('Comp_AreaID='.$id, "Comp_Delete = 0");
	$obj    = $functionsObj->SelectData($fields, 'GAME_COMPONENT', $where, '', '', '', '', 0);
	if($obj->num_rows > 0){
		$msg     = 'Can not Delete Area! Area not empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}else{		
		//$result = $functionsObj->UpdateData('GAME_AREA', array('Area_Delete' => 1), 'Area_ID', $id);

		$result = $functionsObj->DeleteData('GAME_AREA','Area_ID',$id,0);
		
		//if( $result === true ){
		$_SESSION['msg']     = 'Area Deleted';
		$_SESSION['type[0]'] = 'inputSuccess';
		$_SESSION['type[1]'] = 'has-success';
		header("Location:".site_root."ux-admin/ManageArea");
		//}
	}
}

$fields = array();
$where  = array('Area_Delete = 0');
$object = $functionsObj->SelectData($fields, 'GAME_AREA', $where, '', '', '', '', 0);

//download area in excelsheet..
if(isset($_POST['download_excel']) && $_POST['download_excel'] == 'Download'){

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
	
	$objSheet->setTitle('Area');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Game');
	$objSheet->getCell('B1')->setValue('Area');
	
	if($from == '' && $end == '')
	//if($enddate>$fromdate)
	{
		$sql = "SELECT Area_Name FROM GAME_AREA";
		//echo "error";
	}
	else
	{
		$sql = "SELECT Area_Name FROM GAME_AREA WHERE Area_CreateDate BETWEEN '$fromdate' AND '$enddate'";
	}
	
	//echo $sql;exit;	

	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->Area_Name);
			$i++;
		}
	}
	
	//$objPHPExcel->
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	

	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="area.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}

include_once doc_root.'ux-admin/view/manageArea.php';
?>