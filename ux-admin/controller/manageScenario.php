<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();
$object       = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), 'Scen_datetime DESC', '', '', '', 0);
$file         = 'ScenarioList.php';

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	// echo "<pre>"; print_r($_POST); exit();
	$ScenJson = array(
		'aliasStoryline'					 => trim($_POST['aliasStoryline']),
    'aliasStorylineColorCode'  => trim($_POST['aliasStorylineColorCode']),
		'aliasStorylineVisibility' => $_POST['aliasStorylineVisibility'] ? $_POST['aliasStorylineVisibility'] : 0,

		'aliasVideo' 							 => trim($_POST['aliasVideo']),
    'aliasVideoColorCode'      => trim($_POST['aliasVideoColorCode']),
		'aliasVideoVisibility' 		 => $_POST['aliasVideoVisibility'] ? $_POST['aliasVideoVisibility'] : 0,

		'aliasImage'							 => trim($_POST['aliasImage']),
    'aliasImageColorCode'      => trim($_POST['aliasImageColorCode']),
		'aliasImageVisibility'		 => $_POST['aliasImageVisibility'] ? $_POST['aliasImageVisibility'] : 0,

		'aliasDocument' 					 => trim($_POST['aliasDocument']),
    'aliasDocumentColorCode'   => trim($_POST['aliasDocumentColorCode']),
		'aliasDocumentVisibility'  => $_POST['aliasDocumentVisibility'] ? $_POST['aliasDocumentVisibility'] : 0,
	);
	$Scen_Json = json_encode($ScenJson);

	$Scen_Branching = $_POST['Scen_Branching'] ? $_POST['Scen_Branching'] : 0;

	if(isset($_FILES['Scen_Image']['name']) && !empty($_FILES['Scen_Image']['name']))
	{
		$errors     = array();
		$file_name  = base64_encode($_FILES['Scen_Image']['name']);
		$file_size  = $_FILES['Scen_Image']['size'];
		$file_tmp   = $_FILES['Scen_Image']['tmp_name'];
		$file_type  = $_FILES['Scen_Image']['type'];
		$ext        = explode('.',$_FILES['Scen_Image']['name']);
		$file_ext   = strtolower(end($ext));
		$Scen_Image = $file_name;
		$extensions = array("jpeg","jpg","png","gif");

		if(in_array($file_ext,$extensions)=== false)
		{
			$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
		}
		if($_FILES['Scen_Image']['error'] > 0)
		{
			$error[] = "'Error while uploading file ".$_FILES['Scen_Image']['error']."'.";
		}

		if(empty($errors)==true)
		{
			move_uploaded_file($file_tmp,doc_root."images/".$file_name);
		}
		else{
			$_SESSION['msg']     = implode('. ', $errors);
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location: ".site_root."ux-admin/ManageScenario/edit/".$_GET['edit']);
		}
	}

	$existingImageName = ($_POST['Scen_Back_Image'])?$_POST['Scen_Back_Image']:'';
	$Scen_Image        = ($Scen_Image)?$Scen_Image:$existingImageName;
	$gamedetails       = (object) array(
		'Scen_Name'        => $_POST['name'],
		'Scen_Comments'    => $_POST['comments'],
		'Scen_Image'       => $Scen_Image,
		'Scen_Header'      => $_POST['Scen_Header'],
		'Scen_Datetime'    => date('Y-m-d H:i:s'),
		'Scen_Status'      => 1,
		'Scen_InputButton' => $_POST['Scen_InputButton'],
		'Scen_Branching'   => $Scen_Branching,
		'Scen_Json'  			 => $Scen_Json,
	);
	
	if( !empty($_POST['name']) && !empty($_POST['comments']))
	{
		$result = $functionsObj->InsertData('GAME_SCENARIO', $gamedetails, 0, 0);
		if($result)
		{
			$uid                 = $functionsObj->InsertID();
			$_SESSION['msg']     = "Scenario created successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageScenario");			
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}


if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	// echo "<pre>"; print_r($_POST); exit();
	$ScenJson = array(
    'aliasStoryline'           => trim($_POST['aliasStoryline']),
    'aliasStorylineColorCode'  => trim($_POST['aliasStorylineColorCode']),
    'aliasStorylineVisibility' => $_POST['aliasStorylineVisibility'] ? $_POST['aliasStorylineVisibility'] : 0,

    'aliasVideo'               => trim($_POST['aliasVideo']),
    'aliasVideoColorCode'      => trim($_POST['aliasVideoColorCode']),
    'aliasVideoVisibility'     => $_POST['aliasVideoVisibility'] ? $_POST['aliasVideoVisibility'] : 0,

    'aliasImage'               => trim($_POST['aliasImage']),
    'aliasImageColorCode'      => trim($_POST['aliasImageColorCode']),
    'aliasImageVisibility'     => $_POST['aliasImageVisibility'] ? $_POST['aliasImageVisibility'] : 0,

    'aliasDocument'            => trim($_POST['aliasDocument']),
    'aliasDocumentColorCode'   => trim($_POST['aliasDocumentColorCode']),
    'aliasDocumentVisibility'  => $_POST['aliasDocumentVisibility'] ? $_POST['aliasDocumentVisibility'] : 0,
	);
	$Scen_Json = json_encode($ScenJson);

	$Scen_Branching = $_POST['Scen_Branching'] ? $_POST['Scen_Branching'] : 0;
	$Scen_Image = '';
	// uploading image 
	if(isset($_FILES['Scen_Image']['name']) && !empty($_FILES['Scen_Image']['name']))
	{
		$errors     = array();
		$file_name  = base64_encode($_FILES['Scen_Image']['name']);
		$file_size  = $_FILES['Scen_Image']['size'];
		$file_tmp   = $_FILES['Scen_Image']['tmp_name'];
		$file_type  = $_FILES['Scen_Image']['type'];
		$ext        = explode('.',$_FILES['Scen_Image']['name']);
		$file_ext   = strtolower(end($ext));
		$Scen_Image = $file_name;
		$extensions = array("jpeg","jpg","png","gif");

		if(in_array($file_ext,$extensions)=== false)
		{
			$errors[] = "extension not allowed, please choose a JPEG or PNG file.";
		}
		if($_FILES['Scen_Image']['error'] > 0)
		{
			$error[] = "'Error while uploading file ".$_FILES['Scen_Image']['error']."'.";
		}

		if(empty($errors)==true)
		{
			move_uploaded_file($file_tmp,doc_root."images/".$file_name);
		}
		else{
			$_SESSION['msg']     = implode('. ', $errors);
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location: ".site_root."ux-admin/ManageScenario/edit/".$_GET['edit']);
		}
	}

	$existingImageName = ($_POST['Scen_Back_Image'])?$_POST['Scen_Back_Image']:'';
	$Scen_Image        = ($Scen_Image)?$Scen_Image:$existingImageName;
	$gamedetails       = (object) array(
		'Scen_Name'        => $_POST['name'],
		'Scen_Comments'    => $_POST['comments'],
		'Scen_Image'       => $Scen_Image,
		'Scen_Header'      => $_POST['Scen_Header'],
		'Scen_Datetime'    => date('Y-m-d H:i:s'),
		'Scen_Status'      => 1,
		'Scen_InputButton' => $_POST['Scen_InputButton'],
		'Scen_Branching'   => $Scen_Branching,
		'Scen_Json'  			 => $Scen_Json,
	);
	// echo $existingImageName.' and '.$Scen_Image."<pre>"; print_r($gamedetails); exit();
	if( !empty($_POST['name']) && !empty($_POST['comments']) )
	{
		$uid    = $_POST['id'];
		$result = $functionsObj->UpdateData('GAME_SCENARIO', $gamedetails, 'Scen_ID', $uid, 0);
		// updating game_linkage table while updating sceanrio status of default/compBranching
		// die('SELECT * FROM GAME_LINKAGE WHERE Link_ScenarioID='.$uid);
		$linkageDetails = (object) array(
			'Link_Branching' => $Scen_Branching,
		);
		$result = $functionsObj->UpdateData('GAME_LINKAGE', $linkageDetails, 'Link_ScenarioID', $uid, 0);
		if($result === true)
		{
			$_SESSION['msg']     = "Scenario updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/ManageScenario");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}		
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

// Edit Siteuser
if(isset($_GET['edit']))
{
	$header      = 'Edit Scenario';
	$uid         = base64_decode($_GET['edit']);
	$object      = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_ID='.$uid), '', '', '', '', 0);
	$scendetails = $functionsObj->FetchObject($object);
	$url         = site_root."ux-admin/ManageScenario";
	$file        = 'addeditScenario.php';
}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$header = 'Add Scenario';
	$url    = site_root."ux-admin/ManageScenario";	
	$file   = 'addeditScenario.php';

}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id = base64_decode($_GET['del']);
	//$file = 'manageScenario.php';
//	$object = $functionsObj->SelectData(array(), 'GAME_LINKAGE', array('Link_ScenarioID='.$id), '', '', '', '', 0);
	$sql = "SELECT g.Game_Name as Game FROM `GAME_LINKAGE` 
	INNER JOIN GAME_GAME g on Link_GameID=g.Game_ID where Link_ScenarioID=".$id;
	$sublink = $functionsObj->ExecuteQuery($sql);

//	echo $sublink->num_rows;
//	exit();
	if($sublink->num_rows > 0)
	{
//		$file = 'ScenarioList.php';
		while($row = $sublink->fetch_object()){
			$strresult = $strresult." '".$row->Game."' ";			
		}
		$msg     = 'Cannot Delete Scenario. Is linked with '.$strresult;
		$type[0] = 'inputError';
		$type[1] = 'has-error';		
	}
	else
	{
		//$result = $functionsObj->UpdateData('GAME_SCENARIO', array( 'Scen_Delete' => 1 ), 'Scen_ID', $id, 0);
		$result = $functionsObj->DeleteData('GAME_SCENARIO','Scen_ID',$id,0);
		//if($result === true){
		$_SESSION['msg']     = "Scenario Deleted";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/ManageScenario");
		exit(0);
		//}else{
		//	$msg = "Error: ".$result;
		//	$type[0] = "inputError";
		//	$type[1] = "has-error";
		//}
	}
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_ID='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->Scen_Status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_SCENARIO', array('Scen_Status'=> 0), 'Scen_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_SCENARIO', array('Scen_Status'=> 1), 'Scen_ID', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "Scenario ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/ManageScenario");
		exit(0);
	}
	else
	{
		$msg     = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}
else
{
	// fetch scenario list from db
	$object = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), 'Scen_datetime DESC', '', '', '', 0);
	$file   = 'ScenarioList.php';
}

//download Game in excelsheet..
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
	
	$objSheet->setTitle('Scenario');
	$objSheet->getStyle('B1:L1')->getFont()->setBold(true)->setSize(12);
	
	//$objSheet->getCell('A1')->setValue('Scenario');
	$objSheet->getCell('B1')->setValue('Scenario');
	
	if($from == '' && $end == '')
	//if($enddate>$fromdate)
	{
		$sql = "SELECT Scen_Name FROM GAME_SCENARIO";
		//echo "error";
	}
	else
	{
		$sql = "SELECT Scen_Name FROM GAME_SCENARIO WHERE Scen_Datetime BETWEEN '$fromdate' AND '$enddate'";
	}
	
	//echo $sql;exit;	

	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0){
		$i=2;
		while($row= $objlink->fetch_object()){
			//$objSheet->getCell('A'.$i)->setValue('Game');
			$objSheet->getCell('B'.$i)->setValue($row->Scen_Name);
			$i++;
		}
	}
	
	//$objPHPExcel->
	
	//$objSheet->getColumnDimension('A')->setAutoSize(true);
	$objSheet->getColumnDimension('B')->setWidth(20);	

	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="scenario.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
	
}
include_once doc_root.'ux-admin/view/Scenario/'.$file;
