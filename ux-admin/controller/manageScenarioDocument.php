<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['gameid'];
	//exit();
	if(isset($_FILES['docname'])){
		$errors= array();
		$file_name = $_FILES['docname']['name'];
		$file_size =$_FILES['docname']['size'];
		$file_tmp =$_FILES['docname']['tmp_name'];
		$file_type=$_FILES['docname']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['docname']['name'])));
		move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);
	}	
	
	if(!empty($_POST['doctitle']) && !empty($file_name)){
		$array = array(
					'ScenDoc_ScenID'	=>	$_POST['scenid'],
					'ScenDoc_Title'		=>	$_POST['doctitle'],
					'ScenDoc_Name'		=> 	$file_name,
					'ScenDoc_DateTime'	=>	date('Y-m-d H:i:s')
			);
			$result = $functionsObj->InsertData('GAME_SCENDOCUMENT', $array);
			if($result){
				$_SESSION['msg'] 		= 'Document Added Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($id));
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
	
	if(isset($_FILES['docname'])){
		$errors= array();
		$file_name = $_FILES['docname']['name'];
		$file_size =$_FILES['docname']['size'];
		$file_tmp =$_FILES['docname']['tmp_name'];
		$file_type=$_FILES['docname']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['docname']['name'])));
		move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/".$file_name);
	}	
	
	if(!empty($_POST['doctitle'])){
			if(!empty($file_name)){
				$array = array(
						'ScenDoc_Title'	=>	$_POST['doctitle'],
						'ScenDoc_Name'		=> 	$file_name
				);				
			}else{
				$array = array(
					'ScenDoc_Title'	=>	$_POST['doctitle']					
				);
			}
			$result = $functionsObj->UpdateData('GAME_SCENDOCUMENT', $array, 'ScenDoc_ID', $docid);
			if($result){
				$_SESSION['msg'] 		= 'Document Updated Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($id));
			}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageScenarioDocument"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	//echo $docid;
	//exit();
	$fields = array();
	$where  = array('ScenDoc_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENDOCUMENT', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->ScenDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageScenarioDocument"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Scen_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_SCENARIO', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);
	$object = $functionsObj->SelectData(array(), 'GAME_SCENDOCUMENT', array("ScenDoc_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->ScenDoc_ScenID;
	}
	//echo $id;
	//exit();
	
	$result = $functionsObj->UpdateData('GAME_SCENDOCUMENT', array('ScenDoc_Delete' => 1), 'ScenDoc_ID', $id);
	
		if( $result === true ){
			$_SESSION['msg'] 		= 'Document Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			
			header("Location:".site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($gameid));
		}
	}

$id = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('ScenDoc_Delete = 0','ScenDoc_ScenID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_SCENDOCUMENT', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Scenario/manageScenarioDocument.php';
?>