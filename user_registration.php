
<?php
include 'config/settings.php';
//include 'config/dbconnect.php';
include 'config/functions.php';
require_once doc_root.'ux-admin/model/model.php';
//$obj = new functions();

$modelObj = new Model();
session_start();
$id = $_GET['ID'];

//$id = $_GET['id'];

$query  = "select Game_Name from GAME_GAME where Game_ID=$id";

$result = $modelObj->ExecuteQuery($query);

$run    = $result->fetch_object();

if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
/*	echo "<pre>";
	print_r($_POST);
	exit;*/
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
		'User_games'     => $gameName,
		'User_username' => $username
	);
	if( !empty($fname) && !empty($lname) && !empty($email) && !empty($mobile) )
	{
		$where  = array("`User_email` ='".$email."'");
		$object = $modelObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '','');

		if($object->num_rows > 0)
		{
			$msg = " This email address already registered,please use a new email";
		}

		else
		{
			$insert = $modelObj->insertdata('GAME_SITE_USERS',$userdata);

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
					$header  .= "Content-type: text/html; charset: utf8\r\n";

					mail($to, $subject, $message, $header);
				}
			}
		}
	}
}
/*if(isset($_POST['back']) && $_POST['back']=='back')
{
	//echo "<pre>"; print_r($_POST); exit;
	header("location:".site_root."LandingPage.php");
}*/

include doc_root.'views/user_registration.php';
?>