<?php 
//include_once 'includes/header.php'; 
include_once 'config/settings.php';
include_once doc_root.'config/functions.php';


if(isset($_SESSION['siteuser'])){
	unset($_SESSION['date']);
	header("location:".site_root."my_profile.php");
	exit(0);
}

// Create object
$funObj = new Functions();


// If session value msg is set assign value to variable and unset session variable
if(isset($_SESSION['msg'])){
	
	$msg  = $_SESSION['msg'];
	$type = $_SESSION['type'];
	unset($_SESSION['msg']);
	unset($_SESSION['type']);
	
}

// on sign in Click
if(isset($_POST['submit']) && $_POST['submit'] == "Login"){
	if(!empty($_POST['username']) && !empty($_POST['password'])){
		$username = $funObj->EscapeString($_POST['username']);
		$password = $_POST['password'];
		
		$sql = "SELECT * 
		FROM GAME_SITE_USERS u inner join GAME_USER_AUTHENTICATION ua 
		on u.User_id = ua.Auth_userid 
		WHERE (u.User_username='".$username."' 
		or u.User_email='".$username."') 
		and ua.Auth_password='".$password."' 
		";
		//echo $sql;
		//exit();
		$object = $funObj->ExecuteQuery($sql);
		
		if($object->num_rows > 0){
			$res = $funObj->FetchObject($object);
			
			if($res->User_Delete == 0){
				if($res->User_status == 1){
					
					$_SESSION['userid'] = (int) $res->User_id;
					$_SESSION['username'] = $res->User_username;
					
					//header("Location:".site_root."my_profile.php");
					//echo '<script>window.location = "http://simulation.uxconsultant.in/my_profile.php"; </script>';
					echo '<script>window.location = "'.site_root.'selectgame.php"; </script>';
					exit(0);
				} else {
					$msg = "Your account is pending for email id confirmation. Please confirm your email address by clicking on link sent to your email address.";
					$type = "err";
				}
			}else{
				$msg = "Your account has been deactivated by siteadmin";
				$type = "err";
			}
		}else{
			$msg = "Wrong username or password";
			$_SESSION['msg']=$msg;
			//$type = "err";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}else{
		$msg = "Fields can not be empty";
		$_SESSION['msg']=$msg;
		//$type = "err";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

include_once doc_root.'views/login.php';
?>

