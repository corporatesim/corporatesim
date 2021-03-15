<?php
include_once '../../../config/settings.php';
include_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();

if(isset($_POST['username'])){
	$username = $_POST['username'];
	if(strlen($username) >= 6){
		$where = array("username='".$username."'");
		$result = $functionsObj->SelectData(array(), GAME_ADMINUSERS, $where, '', '', '', '', 0);
		
		if($result->num_rows > 0){
			echo '<div class="col-sm-12 alert alert-danger">Username already taken</div>';
		}else{
			echo '<div class="col-sm-12 alert alert-success">Available</div>';
		}
	}else{
		echo '<div class="col-sm-12 alert alert-danger">Username length should be 6 character or greater</div>';
	}
}