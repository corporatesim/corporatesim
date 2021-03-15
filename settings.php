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
$_SESSION['userpage'] = 'settings';
$uid                  = $_SESSION['userid'];
//base64_decode($_GET['edit']);
$object               = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
$userdetails          = $functionsObj->FetchObject($object);
//$url                = site_root."ux-admin/index?q=siteusers";
$msg                  = $_SESSION['msg'];		
$type[0]              = $_SESSION['type[0]'];
$type[1]              = $_SESSION['type[1]'];
$_SESSION['msg']      = '';
$_SESSION['type[0]']  = '';
$_SESSION['type[1]']  = '';

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{
	// echo "<pre>"; print_r($_POST); exit();
	$uid             = $_POST['id'];
	$old_password    = $_POST['old_password'];
	$password        = $_POST['password'];
	$confirm         = $_POST['confirm'];
	$userPasswordObj = $functionsObj->SelectData(array(), 'GAME_USER_AUTHENTICATION', array('Auth_userid='.$uid, 'Auth_password="'.$old_password.'"'), '', '', '', '', 0);
	$userPassword    = $functionsObj->FetchObject($userPasswordObj);
	// $userOldPassword = $userPassword->Auth_password;
	// echo "<pre>"; print_r($userPasswordObj); exit();
	if($userPasswordObj->num_rows > 0)
	{
		// it means that old password provided by users match with the database so allow user to update
		$login_details = array(
			'Auth_password'	=>($password)						
		);
		if($password === $confirm)
		{
			//GAME_USER_AUTHENTICATION
			$result = $functionsObj->UpdateData('GAME_USER_AUTHENTICATION', $login_details, 'Auth_userid', $uid, 0);
			if($result === true){
				$_SESSION['msg']     = "Password updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
					//$msg = "User details updated successfully";
					//$type[0] = "inputSuccess";
					//$type[1] = "has-success";
				header("Location: ".site_root."settings.php");
				exit(0);
			}
			else
			{
				$msg     = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
			}
			//}
		}
		else
		{
			//echo 'Error - Field(s) can not be empty';
			$msg     = "Password do not match";		
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	else
		{
			$msg     = "Incorrect old password";		
			$type[0] = "inputError";
			$type[1] = "has-error";
		}	
}

include_once doc_root.'views/settings.php';
