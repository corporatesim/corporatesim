
<?php
include 'config/settings.php';
//include 'config/dbconnect.php';
include 'config/functions.php';
require_once doc_root.'ux-admin/model/model.php';
//$obj = new functions();
$modelObj = new Model();
session_start();
$id     = $_GET['ID'];
$file   = 'user_registration.php';
$tempid = $userId;
//echo $_SESSION['userid'];exit;
//$id   = $_GET['id'];

// if user is logged in then go to select game page
/*if($_SESSION['username'] != NULL)
{
	header("Location:".site_root."selectgame.php");
}*/

// for ajax trigger to check the user i.e. exists or not, or have same game associated or not
if($_POST['action'] == 'checkExistance')
{
	$user_email   = $_POST['email'];
	$gameId       = $_POST['gameId'];
	//if record exist
	$query        = "SELECT * FROM GAME_SITE_USERS WHERE User_email ='".$user_email."' AND User_Delete=0";
	// die($query);
	$checkRecord  = $modelObj->ExecuteQuery($query);
	$user_records = $checkRecord->fetch_object();
	// print_r($user_records); die();
	$userId = $user_records->User_id;

	//echo $userId;exit;

	// user record exist
	if($checkRecord->num_rows > 0)
	{
		echo "This email is already taken";
	//	$checkGame = "SELECT * FROM GAME_SITE_USERS WHERE User_id ='".$userId."' AND locate(".$gameId.",User_games) AND User_Delete=0";
		//die($checkGame);
	//	$checkGameRecord = $modelObj->ExecuteQuery($checkGame);

    // echo $checkRecord->num_rows;exit;

		// it means user already has this game so, check that user has played this game or not
		/*if($checkGameRecord->num_rows > 0)
		{
			$checkPlayed = "SELECT * FROM GAME_USERSTATUS WHERE US_UserID=".$userId." AND US_GameID=".$gameId." AND US_LinkID=1";
			//die($checkPlayed);
			$playedCheck = $modelObj->ExecuteQuery($checkPlayed);

			if($playedCheck->num_rows > 0)
			{
				$result = "reset allow";
				echo $result;
				
			}
			else
			{
				$result = "do not allow";
				echo $result;
			}
		}
		else
		{
			$result = "allow";
			echo $result;
		}*/
	}

	// it means record doesn't exist, so let the user register
	else
	{
		$result = "allow";
		echo $result;
	}
	die();
}

$query  = "select Game_Name from GAME_GAME where Game_ID=$id";

$result = $modelObj->ExecuteQuery($query);

$run    = $result->fetch_object();

if(isset($_POST['submit']) && $_POST['submit'] == 'register')
{
	  //echo "<pre>";print_r($_POST);exit;

	$fname    =  $_POST['firstName'];
	$lname    =  $_POST['lastName'];
	$email    =  $_POST['email'];
	$mobile   =  $_POST['mobile'];
	$gameName =   $_GET['ID'];
	//echo $gameName;exit;
	$username =  $_POST['username'];

	$userdata = (object) array(
		'User_fname'         => $fname,
		'User_lname'         => $lname,
		'User_email'         => $email,
		'User_mobile'        => $mobile,
		'User_games'         => $gameName.',',
		'User_username'      => $username,
		'User_GameStartDate' => date('Y-m-d'),
		'User_GameEndDate'   => date('Y-m-d',strtotime("+3 days"))
	);

	if( !empty($fname) && !empty($lname) && !empty($email) && !empty($mobile) && !empty($gameName) )
	{
		//$where  = array("`User_email` ='".$email."' AND User_games='".$gameName."'");
		$where  = array("`User_email` ='".$email."' OR User_username='".$username."'");

		$object = $modelObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '','');
     //echo $object->num_rows; exit;
		if($object->num_rows > 0)
		{
			$msg              = "This email id or username already registered";
			//$_SESSION['msg']  = $msg;
			$type             = "alert alert-danger alert-dismissible";
		//	$_SESSION['type'] = $type;
		
			//$file = 'error-msg.php';
			// header("location:".site_root."views/error-msg.php");
			//$msg = " This email address And game already registered...";
		}
		/*else
		{
			if(!empty($fname) && !empty($lname) && !empty($email) && !empty($mobile) && !empty($gameName) )
			{
				$Where = array("`User_email` ='".$email."'");
				$Object = $modelObj->SelectData(array(),'GAME_SITE_USERS',$Where,'','','','');
				$data=$Object->fetch_object();
					if($Object->num_rows > 0)
					{
						$USERID=$data->User_id;
						
						$usersdata = (object) array(
		              'User_fname'         => $fname,
		              'User_lname'         => $lname,
		              'User_email'         => $email,
		              'User_mobile'        => $mobile,
		              'User_games'         => $gameName.',',
		              'User_username'      => $username,
		              'User_GameStartDate' => date('Y-m-d'),
		              'User_GameEndDate'   => date('Y-m-d',strtotime("+3 days"))
	              );
						
						$Result  = $modelObj->UpdateData('GAME_SITE_USERS', $usersdata, 'User_id', $USERID, 0);
					}
				}exit;*/

        //update functionality.....
			/*	$where   = array("`User_email` ='".$email."'");
				$object  = $modelObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '','');
				$data    = $object->fetch_object();
      //echo $object->num_rows; exit;

				if($object->num_rows > 0)
				{
					$USERID    = $data->User_id;
					$user_game = $data->User_games;
					//echo $USERID."<br>".$user_game; exit;
					//$user_game1=array();
          //$user_game1[]=$user_game;
					$usersdata = (object) array(
						'User_fname'         => $fname,
						'User_lname'         => $lname,
						'User_email'         => $email,
						'User_mobile'        => $mobile,
						'User_games'         => $user_game.$gameName.',',
						'User_username'      => $username,
						'User_GameStartDate' => date('Y-m-d'),
						'User_GameEndDate'   => date('Y-m-d',strtotime("+3 days"))
					);

					$Result   = $modelObj->UpdateData('GAME_SITE_USERS', $usersdata, 'User_id', $USERID, 0);

					$UserData = (object) array(
						'UG_UserID'   => $USERID,
						'UG_GameID'   => $gameName,
					);

					$InsertDetail = $modelObj->InsertData('GAME_USERGAMES',$UserData);

					if($Result)
					{
						$password   = $modelObj->randomPassword();

						$loginDetail = array(

							'Auth_username'  => $username,
							'Auth_password'  => $password,
							'Auth_Date_time' => date('Y-m-d H:i:s')
						);

						$updatedata = $modelObj->UpdateData('GAME_USER_AUTHENTICATION',$loginDetail,'Auth_userid',$USERID);

					/*	$msg = "details have been successfully changed";
					$_SESSION['msg'] = $msg;*/
				//}
				//header("location:".site_root."selectgame.php");
			//}
//*/
					else
					{
					//New user record inserted in database..
						$insert = $modelObj->insertdata('GAME_SITE_USERS',$userdata);

			//$msg  = "your details have been save in database.";
						$file   = 'thank-you.php';
			// header("location:".site_root."views/thank-you.php");

						if($insert)
						{
							$uid      = $modelObj->InsertID();
							$_SESSION['userid']=$uid;
							$to       = $_POST['email'];
							$username = $_POST['username'];
							$password = $modelObj->randomPassword();
							$gameName = $_POST['game'];
		        // echo $gameName;exit;

							$loginDetails = array(

								'Auth_userid'    => $uid,
								'Auth_username'  => $_POST['username'],
								'Auth_password'  => $password,
								'Auth_Date_time' => date('Y-m-d H:i:s')
							);
				    //echo "<pre>";print_r($loginDetails);exit;

							$insert1        = $modelObj->InsertData('GAME_USER_AUTHENTICATION', $loginDetails);

				 	//added data into game_usergames table
							$insertUserGame = "INSERT INTO GAME_USERGAMES (UG_UserID,UG_GameID) VALUES ($uid,$id)";
							$objUserGame    = $modelObj->ExecuteQuery($insertUserGame);

							if($insert1)
							{

								$from     = "support@corporatesim.com";
								$subject  = "New Account created for Simulation Game";
								$message  = "Dear User";
								$message .= "<p>Username : ".$username;
								$message .= "<p>Password : ".$password;
								$message .= "<p>Game Choosen :".$gameName;
								$header   = "From:" . $from . "\r\n";
								$header  .= "MIME-Version: 1.0\r\n";
								$header  .= "Content-type: text/plain; charset: utf8\r\n";

								mail($to, $subject, $message, $header);
							}
						}
					}
				}
				else
				{
					$error = "Please provide all the mandatory details.";
					$file  = 'error-msg.php';
				}
			}
/*if(isset($_POST['back']) && $_POST['back']=='back')
{
	//echo "<pre>"; print_r($_POST); exit;
	header("location:".site_root."LandingPage.php");
}*/
// die($file);

//login page functionality..
if(isset($_POST['submit']) && $_POST['submit'] == "Login")
{
	if(!empty($_POST['username']) && !empty($_POST['password']))
	{
		$username = $modelObj->EscapeString($_POST['username']);
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
		$object = $modelObj->ExecuteQuery($sql);

		if($object->num_rows > 0){
			$res = $modelObj->FetchObject($object);

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

//request password functionality....
if(isset($_POST['reset']) && $_POST['reset'] == "resetPassword")
{
	$registeredEmail = $modelObj->EscapeString($_POST['registeredEmail']);
	$requestSql      = " SELECT User_id FROM GAME_SITE_USERS WHERE User_email='".$registeredEmail."'";
	$requestObj      = $modelObj->ExecuteQuery($requestSql);
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
		$requestResult  = $modelObj->FetchObject($requestObj);
		$userid         = $requestResult->User_id;
		$passwordSql    = "SELECT Auth_username,Auth_password FROM GAME_USER_AUTHENTICATION WHERE Auth_userid=".$userid;
		$passwordObj    = $modelObj->ExecuteQuery($passwordSql);
		$passwordResult = $modelObj->FetchObject($passwordObj);
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

include doc_root.'views/'.$file;
