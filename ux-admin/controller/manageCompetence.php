<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();
$url          = site_root."ux-admin/manageCompetence";

// add competence
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	$Compt_Name      = ($_POST['Compt_Name']);
	$Compt_Game      = implode(',',$_POST['Compt_Game']);
	$comptencyRecord = array(
		'Compt_Name' => $Compt_Name,
		'Compt_Game' => $Compt_Game,
	);
	if(isset($Compt_Name) && isset($Compt_Game))
	{
		$insertRecord = $functionsObj->InsertData('GAME_Competence', $comptencyRecord, 0, 0);	
		$_SESSION['msg']     = "Competence added successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/manageCompetence");
		exit(0);
	}
	else
	{
		$_SESSION['msg']     = "Competence name or game fields can not be left blank";
		$_SESSION['type[0]'] = "inputError";
		$_SESSION['type[1]'] = "has-error";
		header("Location: ".site_root."ux-admin/manageCompetence/add/1");
		exit(0);
	}
}

// edit competence
if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	// echo "<pre>"; print_r($_POST);	exit();	
	$Compt_Name      = $_POST['Compt_Name'];
	$Compt_Game      = implode(',',$_POST['Compt_Game']);
	$Compt_Id        = base64_decode($_GET['edit']);
	$updateComptency = array(
		'Compt_Name'      => $Compt_Name,
		'Compt_Game'      => $Compt_Game,
		'Compt_UpdatedOn' => date('Y-m-d H:i:s'),
	);
	$result = $functionsObj->UpdateData('GAME_Competence', $updateComptency, 'Compt_Id', $Compt_Id, 0);
	if($result)
	{
		$_SESSION['msg']     = "Competence updated successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/manageCompetence");
		exit(0);
	}
	else
	{
		$_SESSION['msg']     = "Error while updating competence, Plesae try later";
		$_SESSION['type[0]'] = "inputError";
		$_SESSION['type[1]'] = "has-error";
		header("Location: ".site_root."ux-admin/manageCompetence/edit/".$_GET['edit']);
		exit(0);
	}
}

// deleting the competence
if(isset($_GET['del']))
{
	// print_r($_REQUEST['del']); exit();
	$Compt_Id    = base64_decode($_GET['del']);
	$compdetails = (object) array(
		'Compt_status' =>	1,
	);
	$result = $functionsObj->UpdateData('GAME_Competence', $compdetails, 'Compt_Id', $Compt_Id, 0);
	$_SESSION['msg']     = "Competence deleted successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/manageCompetence");
	exit(0);
}

// fetching competence list from competence
$object = $functionsObj->SelectData(array(), 'GAME_Competence', array('Compt_status=0'), '', '', '', '', 0);
$file   = 'list.php';
if(isset($_GET['edit']) || isset($_GET['add']))
{
	$file = 'addEditCompetence.php';
	if(isset($_GET['edit']))
	{
		$Compt_Id        = base64_decode($_GET['edit']);
		$compGame        = $functionsObj->SelectData(array(),'GAME_Competence',array('Compt_Id='.$Compt_Id),'','','','',0);
		$gameObj         = $compGame->fetch_object();
		$compGameDetails = explode(',',$gameObj->Compt_Game);
		// print_r($compGameDetails);
	}
}
// this is to enable showing the end date after today
// if($file == 'addEditCompetence.php')
// {
// 	$enableEndDate = 'enableEndDate';
// }
// else
// {
// 	$enableEndDate = '';
// }

include_once doc_root.'ux-admin/view/competence/'.$file;