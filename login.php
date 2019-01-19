<?php 
//include_once 'includes/header.php'; 
include_once 'config/settings.php';
include_once doc_root.'config/functions.php';


if(isset($_SESSION['siteuser']))
{
	unset($_SESSION['date']);
	header("location:".site_root."my_profile.php");
	exit(0);
}
// if user is loggedin then redirect to dashboard/selectgame page
if($_SESSION['username'] != NULL)
{
	header("Location:".site_root."selectgame.php");
}
// Create object
$funObj = new Functions();


// If session value msg is set assign value to variable and unset session variable
if(isset($_SESSION['msg']))
{
	$msg  = $_SESSION['msg'];
	$type = $_SESSION['type'];
	unset($_SESSION['msg']);
	unset($_SESSION['type']);
}

// on sign in Click
if(isset($_POST['submit']) && $_POST['submit'] == "Login")
{
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
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

			if($res->User_Delete == 0)
			{
				if($res->User_status == 1)
				{

					$_SESSION['userid']    = (int) $res->User_id;
					$_SESSION['username']  = $res->User_username;
					$_SESSION['companyid'] = $res->User_companyid;

					//header("Location:".site_root."my_profile.php");
					//echo '<script>window.location = "http://simulation.uxconsultant.in/my_profile.php"; </script>';
					echo '<script>window.location = "'.site_root.'selectgame.php"; </script>';
					exit(0);
				}
				else
				{
					$msg  = "Your account is pending for email id confirmation. Please confirm your email address by clicking on link sent to your email address.";
					$type = "err";
				}
			}
			else
			{
				$msg  = "Your account has been deactivated by siteadmin";
				$type = "err";
			}
		}
		else
		{
			$msg              = "Wrong username or password";
			$_SESSION['msg']  = $msg;
			$type             = "alert alert-danger alert-dismissible";
			$_SESSION['type'] = $type;
		}
	}
	else
	{
		$msg              = "Fields can not be empty";
		$_SESSION['msg']  = $msg;
		$type             = "alert alert-danger alert-dismissible";
		$_SESSION['type'] = $type;
	}
}

if(isset($_POST['reset']) && $_POST['reset'] == "reset")
{
	$registeredEmail = $funObj->EscapeString($_POST['registeredEmail']);
	$requestSql      = " SELECT User_id FROM GAME_SITE_USERS WHERE User_email='".$registeredEmail."'";
	$requestObj      = $funObj->ExecuteQuery($requestSql);
	// print_r($requestObj);
	if($requestObj->num_rows < 1)
	{
		$msg              = "Invalid Email ID";
		$_SESSION['msg']  = $msg;
		$type             = "alert alert-danger alert-dismissible";
		$_SESSION['type'] = $type;
		header("Location:".site_root."login.php");
	}
	else
	{
		$to             = $registeredEmail;
		$requestResult  = $funObj->FetchObject($requestObj);
		$userid         = $requestResult->User_id;
		$passwordSql    = "SELECT Auth_username,Auth_password FROM GAME_USER_AUTHENTICATION WHERE Auth_userid=".$userid;
		$passwordObj    = $funObj->ExecuteQuery($passwordSql);
		$passwordResult = $funObj->FetchObject($passwordObj);
		$password       = $passwordResult->Auth_password;
		$username       = $passwordResult->Auth_username;
		$from           = "webmaster@simulation.com";
		$subject        = "Corporate Simulation - Password Request For Account Login";
		$message        = "<br>Dear User,<br>\r\n Your Username and Password is given below:";
		$message       .= "<p>Username : ".$username."</p>";
		$message       .= "<p>Password : ".$password."</p>";
		$header         = "From:" . $from . "\r\n";
		$header         = "Reply-To: The Sender <debasish@corporatesim.com>\r\n";
		$header        .= "MIME-Version: 1.0\r\n";
		$header        .= "Content-type: text/html; charset=iso 8859-1\r\n";
		$mail           = mail($to, $subject, $message, $header);
		// echo $to.' and '.$subject.' and '.$message; die();

		if($mail)
		{
			$msg  = "Password sent to your registered Email ID. Please check spam also";
			$type = "alert alert-success alert-dismissible";
		}
		else
		{
			$msg  = "Connection Error. Please try later";
			$type = "alert alert-danger alert-dismissible";
		}
		$_SESSION['msg']  = $msg;
		$_SESSION['type'] = $type;
		// echo "<pre>"; print_r($requestObj); die($registeredEmail);	var_dump($mail); exit();
		header("Location:".site_root."login.php");
	}
}

include_once doc_root.'views/login.php';