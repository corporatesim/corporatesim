<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

//echo 'in file';
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$id = base64_decode($_GET['Edit']);
	//echo $_POST['gameid'];
	// echo "<pre>"; print_r($_POST); exit();

	if(!empty($_POST['vdotitle']) && !empty($_POST['vdourl']) && !empty($_POST['vdocomments'])){
		$array = array(
			'GameVdo_GameID'   =>	$_POST['gameid'],
			'GameVdo_Title'    =>	$_POST['vdotitle'],
			'GameVdo_Name'     => $_POST['vdourl'],
			'GameVdo_Comments' =>	$_POST['vdocomments'],
			'GameVdo_Type'     =>	$_POST['type'],
			'GameVdo_DateTime' =>	date('Y-m-d H:i:s')
		);
		
		$result = $functionsObj->InsertData('GAME_GAMEVIDEO', $array);
		if($result){
			$_SESSION['msg']     = 'Video Added Successfully';
			$_SESSION['type[0]'] = 'inputSuccess';
			$_SESSION['type[1]'] = 'has-success';
			header("Location:".site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($id));
		}
		
	}
	else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$id    = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);

	if(!empty($_POST['vdotitle']) && !empty($_POST['vdourl']) && !empty($_POST['vdocomments'])){
		$array = array(				
			'GameVdo_Title'    =>	$_POST['vdotitle'],
			'GameVdo_Name'     => $_POST['vdourl'],
			'GameVdo_Comments' =>	$_POST['vdocomments'],
			'GameVdo_Type'     =>	$_POST['type'],
		);

		$result = $functionsObj->UpdateData('GAME_GAMEVIDEO', $array, 'GameVdo_ID', $docid);
		if($result){
			$_SESSION['msg']     = 'Video Updated Successfully';
			$_SESSION['type[0]'] = 'inputSuccess';
			$_SESSION['type[1]'] = 'has-success';
			header("Location:".site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($id));
		}
	}
	else{
		$msg     = 'Field cannot be empty';
		$type[0] = 'inputError';
		$type[1] = 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageGameVideo"){
	$id        = base64_decode($_GET['Edit']);
	$docid     = base64_decode($_GET['tab']);
	//echo $docid;
	//exit();
	$fields    = array();
	$where     = array('GameVdo_ID='.$docid);
	$obj       = $functionsObj->SelectData($fields, 'GAME_GAMEVIDEO', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->GameDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageGameVideo"){
	$id     = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Game_ID='.$id);
	$obj    = $functionsObj->SelectData($fields, 'GAME_GAME', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id     = base64_decode($_GET['Delete']);
	$object = $functionsObj->SelectData(array(), 'GAME_GAMEVIDEO', array("GameVdo_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->GameVdo_GameID;
	}
	
	$result = $functionsObj->UpdateData('GAME_GAMEVIDEO', array('GameVdo_Delete' => 1), 'GameVdo_ID', $id);
	
	if( $result === true ){
		$_SESSION['msg']     = 'Video Deleted';
		$_SESSION['type[0]'] = 'inputSuccess';
		$_SESSION['type[1]'] = 'has-success';
		header("Location:".site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($gameid));
	}
}

$id     = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('GameVdo_Delete = 0','GameVdo_GameID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_GAMEVIDEO', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Game/manageGameVideo.php';
