<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['gameid'];
	//exit();

	if(!empty($_POST['vdotitle']) && !empty($_POST['vdourl']) && !empty($_POST['vdocomments']))
	{
		if($_POST['ScenVdo_Type'] > 0)
		{
			$videoUrl = base64_encode($_POST['vdourl']);
		}
		else
		{
			$videoUrl = $_POST['vdourl'];
		}
		$array = array(
			'ScenVdo_ScenID'   =>	$_POST['scenid'],
			'ScenVdo_Title'    =>	$_POST['vdotitle'],
			'ScenVdo_Comments' =>	$_POST['vdocomments'],
			'ScenVdo_Type'     =>	$_POST['ScenVdo_Type'],
			'ScenVdo_Name'     => $videoUrl,
			'ScenVdo_DateTime' =>	date('Y-m-d H:i:s')
		);
		// echo "<pre>"; print_r($array); exit();
		$result = $functionsObj->InsertData('GAME_SCENVIDEO', $array);
		if($result)
		{
			$_SESSION['msg']     = 'Video Added Successfully';
			$_SESSION['type[0]'] = 'inputSuccess';
			$_SESSION['type[1]'] = 'has-success';
			header("Location:".site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($id));
		}
	}
	else
	{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	$id    = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);

	if(!empty($_POST['vdotitle']) && !empty($_POST['vdourl']) && !empty($_POST['vdocomments']))
	{
		if($_POST['ScenVdo_Type'] > 0)
		{
			$videoUrl = base64_encode($_POST['vdourl']);
		}
		else
		{
			$videoUrl = $_POST['vdourl'];
		}
		$array = array(				
			'ScenVdo_Title'    =>	$_POST['vdotitle'],
			'ScenVdo_Type'     =>	$_POST['ScenVdo_Type'],
			'ScenVdo_Comments' =>	$_POST['vdocomments'],
			'ScenVdo_Name'     => $videoUrl,
		);
		// echo "<pre>"; print_r($array); exit();

		$result = $functionsObj->UpdateData('GAME_SCENVIDEO', $array, 'ScenVdo_ID', $docid);
		if($result)
		{
			$_SESSION['msg']     = 'Video Updated Successfully';
			$_SESSION['type[0]'] = 'inputSuccess';
			$_SESSION['type[1]'] = 'has-success';
			header("Location:".site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($id));
		}
	}
	else
	{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageScenarioVideo")
{
	$id        = base64_decode($_GET['Edit']);
	$docid     = base64_decode($_GET['tab']);
	$fields    = array();
	$where     = array('ScenVdo_ID='.$docid);
	$obj       = $functionsObj->SelectData($fields, 'GAME_SCENVIDEO', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->ScenDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageScenarioVideo")
{
	$id     = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Scen_ID='.$id);
	$obj    = $functionsObj->SelectData($fields, 'GAME_SCENARIO', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete']))
{
	$id     = base64_decode($_GET['Delete']);
	$object = $functionsObj->SelectData(array(), 'GAME_SCENVIDEO', array("ScenVdo_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$scenid = $result->ScenVdo_ScenID;
	}
	
	$result = $functionsObj->UpdateData('GAME_SCENVIDEO', array('ScenVdo_Delete' => 1), 'ScenVdo_ID', $id);
	
	if( $result === true ){
		$_SESSION['msg']     = 'Video Deleted';
		$_SESSION['type[0]'] = 'inputSuccess';
		$_SESSION['type[1]'] = 'has-success';	
		header("Location:".site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($scenid));
	}
}

$id     = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('ScenVdo_Delete = 0','ScenVdo_ScenID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_SCENVIDEO', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Scenario/manageScenarioVideo.php';
