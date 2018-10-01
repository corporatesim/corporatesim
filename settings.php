<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

//echo $_SESSION['userid'];
//echo $_SESSION['username'];

//exit();
// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}

$functionsObj         = new Functions();
$_SESSION['userpage'] ='settings';
$uid                  = $_SESSION['userid'];
	//base64_decode($_GET['edit']);
$object               = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
$userdetails          = $functionsObj->FetchObject($object);
	//$url = site_root."ux-admin/index?q=siteusers";

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
//	echo $_POST['fname'];
//	echo $_POST['lname'];
//	echo $_POST['mobile'];
//	echo $_POST['email'];
//	exit();

	$login_details = array(
		'Auth_password'	=>($_POST['password'])						
	);
	
	$userdetails = (object) array(
		'User_fname'  =>	$_POST['fname'],
		'User_lname'  =>	$_POST['lname'],
		'User_mobile' =>	$_POST['mobile'],			
	);	
	if($_POST['password'] === $_POST['confirm']){
		echo 'Confirm';
		$uid = $_POST['id'];
		
//		$where = array(
//				"(`User_email` ='".$userdetails->User_email."'
//				OR `User_mobile` ='".$userdetails->User_mobile."')",
//				"User_id != ". $uid
//		);
//		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);
		
//		if($object->num_rows > 0){
//			$msg = "Email address or mobile number already registered";
//			$type[0] = "inputError";
//			$type[1] = "has-error";
//		}else{
			//GAME_USER_AUTHENTICATION
		$result = $functionsObj->UpdateData('GAME_USER_AUTHENTICATION', $login_details, 'Auth_userid', $uid, 0);
			//$result = $functionsObj->InsertData('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
			//$result = $functionsObj->UpdateData('GAME_SITE_USERS', $userdetails, 'User_id', $uid, 0);
		if($result === true){
			$_SESSION['msg']     = "User details updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
				//$msg = "User details updated successfully";
				//$type[0] = "inputSuccess";
				//$type[1] = "has-success";
			header("Location: ".site_root."settings.php");
			exit(0);
		}else{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		//}
	}else{
		//echo 'Error - Field(s) can not be empty';
		$msg     = "Password do not match";		
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

include_once doc_root.'views/settings.php';
