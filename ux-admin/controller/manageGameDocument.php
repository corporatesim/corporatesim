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
					'GameDoc_GameID'	=>	$_POST['gameid'],
					'GameDoc_Title'		=>	$_POST['doctitle'],
					'GameDoc_Name'		=> 	$file_name,
					'GameDoc_DateTime'	=>	date('Y-m-d H:i:s')
			);
			$result = $functionsObj->InsertData('GAME_GAMEDOCUMENT', $array);
			if($result){
				$_SESSION['msg'] 		= 'Document Added Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($id));
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
						'GameDoc_Title'	=>	$_POST['doctitle'],
						'GameDoc_Name'		=> 	$file_name
				);				
			}else{
				$array = array(
					'GameDoc_Title'	=>	$_POST['doctitle']					
				);
			}
			$result = $functionsObj->UpdateData('GAME_GAMEDOCUMENT', $array, 'GameDoc_ID', $docid);
			if($result){
				$_SESSION['msg'] 		= 'Document Updated Successfully';
				$_SESSION['type[0]']	= 'inputSuccess';
				$_SESSION['type[1]']	= 'has-success';
				header("Location:".site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($id));
			}
	}
	else{
		$msg 		= 'Field cannot be empty';
		$type[0]	= 'inputError';
		$type[1]	= 'has-error';
	}	
}

if(isset($_GET['Edit']) && isset($_GET['tab']) && $_GET['q'] = "ManageGameDocument"){
	$id = base64_decode($_GET['Edit']);
	$docid = base64_decode($_GET['tab']);
	
	//echo $docid;
	//exit();
	$fields = array();
	$where  = array('GameDoc_ID='.$docid);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAMEDOCUMENT', $where, '', '', '');
	$resultdoc = $functionsObj->FetchObject($obj);
	//var_dump($result);
	//echo $resultdoc->GameDoc_Title; 
	//exit();
}

if(isset($_GET['Edit']) && $_GET['q'] = "ManageGameDocument"){
	$id = base64_decode($_GET['Edit']);
	$fields = array();
	$where  = array('Game_ID='.$id);
	$obj = $functionsObj->SelectData($fields, 'GAME_GAME', $where, '', '', '');
	$result = $functionsObj->FetchObject($obj);
}

if(isset($_GET['Delete'])){
	$id = base64_decode($_GET['Delete']);
	$object = $functionsObj->SelectData(array(), 'GAME_GAMEDOCUMENT', array("GameDoc_ID ='".$id."'"), '', '', '');
	if($object->num_rows > 0){
		$result = $functionsObj->FetchObject($object);
		$gameid = $result->GameDoc_GameID;
	}
	//echo $id;
	//exit();
	
	$result = $functionsObj->UpdateData('GAME_GAMEDOCUMENT', array('GameDoc_Delete' => 1), 'GameDoc_ID', $id);
	
		if( $result === true ){
			$_SESSION['msg'] 		= 'Document Deleted';
			$_SESSION['type[0]']	= 'inputSuccess';
			$_SESSION['type[1]']	= 'has-success';
			//header("Location:".site_root."ux-admin/ManageArea");
			header("Location:".site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($gameid));
		}
	}

$id = base64_decode($_GET['Edit']);
$fields = array();
$where  = array('GameDoc_Delete = 0','GameDoc_GameID='.$id);
$object = $functionsObj->SelectData($fields, 'GAME_GAMEDOCUMENT', $where, '', '', '', '', 0);

include_once doc_root.'ux-admin/view/Game/manageGameDocument.php';
?>