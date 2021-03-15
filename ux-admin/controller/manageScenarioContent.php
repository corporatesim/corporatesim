<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['gameid'];
	//exit();
		
	if(!empty($_POST['gentitle']) && !empty($_POST['general_Content'])){
		$array = array(
				'ScenGen_ScenID'	=>	$_POST['gameid'],
				'ScenGen_Title'		=>	$_POST['gentitle'],
				'ScenGen_Content'	=> 	$_POST['general_Content'],
				'ScenGen_DateTime'	=>	date('Y-m-d H:i:s')
		);
		
			$result = $functionsObj->InsertData('GAME_SCENGENERAL', $array);
			if($result){
				$_SESSION['msg'] 		= 'General Content Added Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($id));
			}
		
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
		
	if(!empty($_POST['gentitle']) && !empty($_POST['general_Content'])){
		$array = array(
				'ScenGen_Title'		=>	$_POST['gentitle'],
				'ScenGen_Content'	=> 	$_POST['general_Content']
				);

		$result = $functionsObj->UpdateData('GAME_SCENGENERAL', $array, 'ScenGen_ID', $docid);
		if($result){
			$_SESSION['msg'] 		= 'Content Updated Successfully';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($id));
		}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageScenarioContent"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	$fields = array();
	$where  = array('ScenGen_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENGENERAL', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageScenarioContent"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Scen_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENARIO', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_SCENGENERAL', array("ScenGen_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->ScenGen_ScenID;
	}

	$result = $functionsObj->UpdateData('GAME_SCENGENERAL', array('ScenGen_Delete' => 1), 'ScenGen_ID', $id);
	
	if( $result === true ){
		$_SESSION['msg'] 		= 'Content Deleted';
		$_SESSION['type[0]']	= 'inputSuccess';
		$_SESSION['type[1]']	= 'has-success';		
		header("Location:".site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($gameid));
	}
}

$id = base64_decode($_GET['Edit']);

$fields = array();
$where  = array('ScenGen_Delete = 0','ScenGen_ScenID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_SCENGENERAL', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Scenario/manageScenarioContent.php';
?>