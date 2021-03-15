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
				'GameGen_GameID'	=>	$_POST['gameid'],
				'GameGen_Title'		=>	$_POST['gentitle'],
				'GameGen_Content'	=> 	$_POST['general_Content'],
				'GameGen_DateTime'	=>	date('Y-m-d H:i:s')
		);
		
			$result = $functionsObj->InsertData('GAME_GAMEGENERAL', $array);
			if($result){
				$_SESSION['msg'] 		= 'General Content Added Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageGameContent/Edit/".base64_encode($id));
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
				'GameGen_Title'		=>	$_POST['gentitle'],
				'GameGen_Content'	=> 	$_POST['general_Content']
				);

		$result = $functionsObj->UpdateData('GAME_GAMEGENERAL', $array, 'GameGen_ID', $docid);
		if($result){
			$_SESSION['msg'] 		= 'Content Updated Successfully';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			header("Location:".site_root."ux-admin/ManageGameContent/Edit/".base64_encode($id));
		}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageGameContent"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	$fields = array();
	$where  = array('GameGen_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAMEGENERAL', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageGameContent"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Game_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAME', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);
	
	$object = $functionsObj->SelectData(array(), 'GAME_GAMEGENERAL', array("GameGen_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->GameGen_GameID;
	}

	$result = $functionsObj->UpdateData('GAME_GAMEGENERAL', array('GameGen_Delete' => 1), 'GameGen_ID', $id);
	
	if( $result === true ){
		$_SESSION['msg'] 		= 'Content Deleted';
		$_SESSION['type[0]']	= 'inputSuccess';
		$_SESSION['type[1]']	= 'has-success';
		//header("Location:".site_root."ux-admin/ManageArea");
		header("Location:".site_root."ux-admin/ManageGameContent/Edit/".base64_encode($gameid));
	}
}

$id = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('GameGen_Delete = 0','GameGen_GameID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_GAMEGENERAL', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Game/manageGameContent.php';
?>