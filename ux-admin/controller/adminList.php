<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$logo = '<img src="'.site_root.'images/logo.png">';

// On Submit Click


if(isset($_GET['edit'])){
	$id = base64_decode($_GET['edit']);
	if($_SESSION['ux-admin-id'] != $id){
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array('id='.$id), '','', '','', 0);
		$userdetails = $functionsObj->FetchObject($object);
	
		$name = explode(" ",$userdetails->name);
	
		$where  = array('uid='.$id);
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS_ACCESS', $where, '','', '','', 0);
		$useraccessdetails = $functionsObj->FetchObject($object);
		
		$selected_cats = json_decode($useraccessdetails->category);
	}else{
		$msg = "Access Denied";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}elseif(isset($_GET['delete'])){
	$id = base64_decode($_GET['delete']);
	if($_SESSION['ux-admin-id'] != $id){
		$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('del_stat' => 1), 'id', $id, 0);
		if($result === true){
			$_SESSION['msg'] = "User Deleted";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location:".site_root."/ux-admin/AdminUsers");
			exit(0);
		}else{
			$msg = "Cannot delete User";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}else{
			$msg = "Access Denied";
			$type[0] = "inputError";
			$type[1] = "has-error";
	}
}elseif(isset($_GET['stat'])){
	$id = base64_decode($_GET['stat']);
	if($_SESSION['ux-admin-id'] != $id){
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array('id='.$id), '', '', '', '', 0);
		$details = $functionsObj->FetchObject($object);
		
		if($details->status == 1){
			$status = 'Deactivated';
			$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('status'=> 0), 'id', $id, 0);
		}else{
			$status = 'Activated';
			$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('status'=> 1), 'id', $id, 0);
		}
		if($result === true){
			$_SESSION['msg'] = "User account ". $status;
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/AdminUsers");
			exit(0);
		}else{
			$msg = "Error: ".$result;
			$type[0] = "inputSuccess";
			$type[1] = "has-success";
		}
	
	}else{
		$msg = "Access Denied";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

$where = array("id not in (1)", "id !=".$_SESSION['ux-admin-id'] );
$adminUsersList = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', $where, "", "", "", "", 0);

//$cities = $functionsObj->SelectData(array('distinct city'), 'BUSINESS_DETAILS', array(), '', '', '', 0);

//$categories = $functionsObj->SelectData(array(), 'SERVICES', array(), '', '', '', 0);

include_once doc_root."ux-admin/view/adminList.php";
?>