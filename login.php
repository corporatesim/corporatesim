<?php 
// die('http://'.$_SERVER['SERVER_NAME']);
$enterpriseDomain = 'http://'.$_SERVER['SERVER_NAME'];
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

// fetch logo to show for b2c modal
$sql     = " SELECT * FROM GAME_DOMAIN WHERE Domain_Name='".$enterpriseDomain."' AND Domain_Status=0";
$logoObj = $funObj->ExecuteQuery($sql);
// echo $sql.'<br>'; print_r($logoObj->num_rows); exit();
if($logoObj->num_rows > 0)
{
	$logoRes = $funObj->FetchObject($logoObj);
	// domain has logo
	$showLogo = $logoRes->Domain_Logo;
	if(!empty($showLogo))
	{
		$_SESSION['logo'] = $showLogo;
	}
}
else
{
	unset($_SESSION['logo']);
}

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
		$username = $funObj->EscapeString(trim($_POST['username']));
		$password = $_POST['password'];

		$sql = "SELECT u.*, ge.Enterprise_Logo ,gse.SubEnterprise_Logo,gd.Domain_Name
		FROM GAME_SITE_USERS u INNER JOIN GAME_USER_AUTHENTICATION ua
		ON u.User_id = ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON u.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_SUBENTERPRISE gse ON u.User_SubParentId=gse.SubEnterprise_ID LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId AND gd.Domain_Status=0  AND( CASE WHEN u.User_Role = 1 THEN gd.Domain_EnterpriseId = u.User_ParentId WHEN u.User_Role = 2 THEN gd.Domain_SubEnterpriseId = u.User_SubParentId END ) WHERE (u.User_username='".$username."' OR u.User_email='".$username."')	AND ua.Auth_password='".$password."'";
		// echo $sql; exit();
		$object = $funObj->ExecuteQuery($sql);

		if($object->num_rows > 0){
			$res = $funObj->FetchObject($object);
		  // echo "<pre>";	print_r($res);exit;
			$domain = $res->Domain_Name;
			if(($_SERVER['SERVER_NAME'] != 'localhost') && ($domain != '' && $domain != $enterpriseDomain))
			{
				$msg  = "Sorry, Please login to your own domain";
				$type = "alert alert-danger alert-dismissible";
			}
			else
			{
				if($res->User_Delete == 0)
				{
					if($res->User_status == 1)
					{
						$_SESSION['userid']    = (int) $res->User_id;
						$_SESSION['username']  = $res->User_username;
						$_SESSION['companyid'] = $res->User_companyid;
						if(empty($_SESSION['logo']))
						{
							if($res->User_Role == 1)
							{
								$_SESSION['logo'] = $res->Enterprise_Logo;
							}
							elseif($res->User_Role == 2)
							{
								$_SESSION['logo'] = $res->SubEnterprise_Logo;
							}
						}
						//unset($_SESSION['logo']);
						//header("Location:".site_root."my_profile.php");
						//echo '<script>window.location = "http://simulation.uxconsultant.in/my_profile.php"; </script>';
						// echo "<pre>"; print_r($_SESSION);die('here');
						echo '<script>window.location = "'.site_root.'selectgame.php"; </script>';
						exit(0);
					}
					else
					{
						$msg  = "Your account is pending for email id confirmation. Please confirm your email address by clicking on link sent to your email address.";
						$type = "alert alert-danger alert-dismissible";
					}
				}

				else
				{
					$msg  = "Your account has been deactivated by siteadmin";
					$type = "alert alert-danger alert-dismissible";
				}
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

if(isset($_POST['reset']) && $_POST['reset'] == "resetPassword")
{
	$registeredEmail = $funObj->EscapeString($_POST['registeredEmail']);
	$requestSql      = " SELECT User_id FROM GAME_SITE_USERS WHERE User_email='".$registeredEmail."'";
	$requestObj      = $funObj->ExecuteQuery($requestSql);
	// print_r($requestObj);exit;
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
		$from           = "support@corporatesim.com";
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