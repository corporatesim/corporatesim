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
		$password = trim($_POST['password']);

		$sql = "SELECT u.*, CONCAT( u.User_fname, ' ', u.User_lname ) AS FullName, ge.Enterprise_Logo ,gse.SubEnterprise_Logo,gd.Domain_Name
		FROM GAME_SITE_USERS u INNER JOIN GAME_USER_AUTHENTICATION ua
		ON u.User_id = ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON u.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_SUBENTERPRISE gse ON u.User_SubParentId=gse.SubEnterprise_ID LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId AND gd.Domain_Status=0  AND( CASE WHEN u.User_Role = 1 THEN gd.Domain_EnterpriseId = u.User_ParentId WHEN u.User_Role = 2 THEN gd.Domain_SubEnterpriseId = u.User_SubParentId END ) WHERE (u.User_username='".$username."' OR u.User_email='".$username."')	AND ua.Auth_password='".$password."'";
		// echo $sql; exit(); User_ParentId User_SubParentId
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
            //updating user game end date
            $uid = (int) $res->User_id;

            //$sql = "SELECT gug.UG_GameEndDate, gug.UG_GameID, gug.UG_ParentId, gug.UG_SubParentId, gsu.User_companyid FROM GAME_USERGAMES gug LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id=gug.UG_UserID WHERE gug.UG_UserID = $uid AND gg.Game_ID IS NOT NULL AND gug.UG_ParentId=".$res->User_ParentId." AND gug.UG_SubParentId=".$res->User_SubParentId." ORDER BY `gg`.`Game_Name` ASC";

            $sql = "SELECT * FROM GAME_USERGAMES gug LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gug.UG_UserID LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_ID = gsu.User_SubParentId LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_EnterpriseID = ge.Enterprise_ID AND geg.EG_GameID = gug.UG_GameID LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID = gsu.User_SubParentId AND gsg.SG_GameID = gug.UG_GameID WHERE gsu.User_id = $uid AND gug.UG_ParentId = ".$res->User_ParentId." AND gug.UG_SubParentId = ".$res->User_SubParentId;

            $result = $funObj->ExecuteQuery($sql);
            //print_r($sql); exit();

            //looping for each game user having
            while ($row = mysqli_fetch_assoc($result)) {

              //randam query so that if not true any condition execute query will get query to execute
              $query = "SELECT * FROM GAME_USERGAMES WHERE UG_ID = ".$row['UG_ID'];

              if ($row['UG_GameID'] == $row['EG_GameID']) {
                //if user and enterprise both having same game

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['User_GameEndDate']) && !empty(strtotime($row['User_GameEndDate']))) {
                  //if user game game end date is greater than user end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['User_GameEndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['Enterprise_EndDate']) && !empty(strtotime($row['Enterprise_EndDate']))) {
                  //if user game game end date is greater than enterprise end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['Enterprise_EndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['SubEnterprise_EndDate']) && !empty(strtotime($row['SubEnterprise_EndDate']))) {
                  //if user game game end date is greater than subenterprise end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['SubEnterprise_EndDate']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['EG_Game_End_Date']) && !empty(strtotime($row['EG_Game_End_Date']))) {
                  //if user game game end date is greater than enterprise game end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['EG_Game_End_Date']."' WHERE UG_ID = ".$row['UG_ID'];
                }

                if (strtotime($row['UG_GameEndDate']) > strtotime($row['SG_Game_End_Date']) && !empty(strtotime($row['SG_Game_End_Date']))) {
                  //if user game game end date is greater than subenterprise game end date
                  $query = "UPDATE GAME_USERGAMES SET UG_GameEndDate = '".$row['SG_Game_End_Date']."' WHERE UG_ID = ".$row['UG_ID'];
                }

              }
              else {
                //if not present game for enterprise and present for user then delete game form user
                $query = "DELETE FROM GAME_USERGAMES WHERE UG_ID = ".$row['UG_ID'];
              }
							//executing Query
							// commenting this line to test properly
              // $queryResult = $funObj->ExecuteQuery($query);
              //print_r($query); echo "<br />";
            }
            //exit();

            //setting session
						$_SESSION['userid']           = (int) $res->User_id;
						$_SESSION['FullName']         = $res->FullName;
						$_SESSION['username']         = $res->User_username;
						$_SESSION['companyid']        = $res->User_companyid;
						$_SESSION['User_profile_pic'] = $res->User_profile_pic;
						$_SESSION['User_ParentId']    = $res->User_ParentId;
						$_SESSION['User_SubParentId'] = $res->User_SubParentId;
						
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