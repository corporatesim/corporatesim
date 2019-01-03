
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
//$id   = $_GET['id'];

// if user is logged in then go to select game page
if($_SESSION['username'] != NULL)
{
	header("Location:".site_root."selectgame.php");
}

// for ajax trigger to check the user i.e. exists or not, or have same game associated or not
if($_POST['action'] == 'checkExistance')
{
	$user_email   = $_POST['email'];
	$gameId       = $_POST['gameId'];
	$query        = "SELECT * FROM GAME_SITE_USERS WHERE User_email ='".$user_email."' AND User_Delete=0";
	// die($query);
	$checkRecord  = $modelObj->ExecuteQuery($query);
	$user_records = $checkRecord->fetch_object();
	// print_r($user_records); die();
	$userId = $user_records->User_id;
	// user record exist
	if($checkRecord->num_rows > 0)
	{
		$checkGame = "SELECT * FROM GAME_SITE_USERS WHERE User_id ='".$userId."' AND User_games IN(".$gameId.") AND User_Delete=0";
		$checkGameRecord = $modelObj->ExecuteQuery($checkGame);
		// it means user already has this game so, check that user has played this game or not
		if($checkGameRecord->num_rows > 0)
		{
			$checkPlayed = "SELECT * FROM GAME_USERSTATUS WHERE US_UserID=".$userId." AND US_GameID=".$gameId." AND US_LinkID=1";
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
		// else
		// {
		// 	$result = "allow";
		// 	echo $result;
		// }
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
	echo "<pre>";	print_r($_POST);	exit;
	$fname    =  $_POST['firstName'];
	$lname    =  $_POST['lastName'];
	$email    =  $_POST['email'];
	$mobile   =  $_POST['mobile'];
	$gameName =   $_GET['ID'];
	//echo $gameName;exit;
	$username =  $_POST['username'];

	$userdata= (object) array(
		'User_fname'    => $fname,
		'User_lname'    => $lname,
		'User_email'    => $email,
		'User_mobile'   => $mobile,
		'User_games'    => $gameName,
		'User_username' => $username
	);
	if( !empty($fname) && !empty($lname) && !empty($email) && !empty($mobile) && !empty($gameName) )
	{
		$where  = array("`User_email` ='".$email."' AND User_games='".$gameName."'");

		$object = $modelObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '','');
     //echo $object->num_rows; exit;
		if($object->num_rows > 0)
		{
			$file = 'error-msg.php';
			// header("location:".site_root."views/error-msg.php");
			//$msg = " This email address And game already registered...";
		}

		else
		{
			$insert = $modelObj->insertdata('GAME_SITE_USERS',$userdata);
			//$msg  = "your details have been save in database.";
			$file   = 'thank-you.php';
			// header("location:".site_root."views/thank-you.php");

			if($insert)
			{
				$uid      = $modelObj->InsertID();
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

				$insert1 = $modelObj->InsertData('GAME_USER_AUTHENTICATION', $loginDetails);

				if($insert1)
				{

					$from     = "webmaster@simulation.com";
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
include doc_root.'views/'.$file;
