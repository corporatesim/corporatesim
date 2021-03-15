<?php 

$uid = $_SESSION['ux-admin-id'];

if(isset($_POST['update'])){
	if(!empty($_POST['email']) && !empty($_POST['fname'])){
		$array = array(
				'fname'		=>	$functionsObj->EscapeString($_POST['fname']),
				'lname'		=>	$functionsObj->EscapeString($_POST['lname']),
				'contact'	=>	$functionsObj->EscapeString($_POST['contact']),
				'email'		=>	$functionsObj->EscapeString($_POST['email']),
		);
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array("email='".$_POST['email']."'", "id != ".$uid), '', '', '', '', 0);
		if($object->num_rows > 0){
			$msg = "Email already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}else{
			$result = $functionsObj->UpdateData('GAME_ADMINUSERS', $array, 'id', $uid, 0);
			if($result === true){
				$_SESSION['msg']		=	'Profile Updated Successfully';
				$_SESSION['type[0]']	=	'inputSuccess';
				$_SESSION['type[1]']	=	'has-success';
				header("Location:".site_root."ux-admin/MyProfile");
			}
		}
	}else{
		$msg = "Fields cannot be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if(isset($_POST['changePassword'])){
	if(!empty($_POST['old_pass']) && !empty($_POST['new_pass']) && !empty($_POST['retype_pass'])){
		if($_POST['old_pass'] == $_POST['new_pass']){
			$msg = "New password cannot be same as Old Password";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}else{
			if($_POST['new_pass'] == $_POST['retype_pass']){
				$fields = array();
				$where  = array('id='.$uid);
				$object = $functionsObj->SelectData($fields, 'GAME_ADMINUSERS', $where, '', '', '', '', 0);
				$details = $functionsObj->FetchData($object);
				if($details['password'] == md5($_POST['old_pass'])){
					$array = array(
							'password'	=> md5($_POST['new_pass'])
					);
					$result = $functionsObj->UpdateData('GAME_ADMINUSERS', $array, 'id', $uid, 0);
					if($result === true){
						$_SESSION['msg']		=	'Password Changed Successfully';
						$_SESSION['type[0]']	=	'inputSuccess';
						$_SESSION['type[1]']	=	'has-success';
						header("Location:".site_root."ux-admin/MyProfile");
					}
				}else{
					$msg = "Incorrect Old Password";
					$type[0] = "inputError";
					$type[1] = "has-error";
				}
			}else{
				$msg = "Retype Password and New Password does not match";
				$type[0] = "inputError";
				$type[1] = "has-error";
			}
		}
	}else{
		$msg = "Field cannot be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

$fields = array();
$where  = array('id='.$uid);
$object = $functionsObj->SelectData($fields, 'GAME_ADMINUSERS', $where, '', '', '', '', 0);
$details = $functionsObj->FetchData($object);

if(isset($_GET['q']) && $_GET['q'] == "MyProfile" && $_GET['edit']){
	include_once doc_root."ux-admin/view/profile/editProfile.php";
}elseif(isset($_GET['q']) && $_GET['q'] == "MyProfile" && $_GET['ChangePassword']){
	include_once doc_root."ux-admin/view/profile/changePassword.php";
}else{
	include_once doc_root."ux-admin/view/profile/myProfile.php";
}


?>