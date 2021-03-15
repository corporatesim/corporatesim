<?php
include_once 'config/settings.php';
include_once 'config/functions.php';
$object = new functions();

$_SESSION['userpage'] = 'Feedback';
$userid    = $_SESSION['userid'];
$query     = "SELECT * FROM GAME_SITE_USERS WHERE User_id = $userid";
$data      = $object->ExecuteQuery($query);
$fetchdata = $object->FetchObject($data);
	//echo "<pre>";print_r($fetchdata);exit;
$fullName   = $fetchdata->User_fname.' '.$fetchdata->User_lname;
$userName   = $fetchdata->User_username;
$Mobile     = $fetchdata->User_mobile;
$Email      = $fetchdata->User_email;
$ProfilePic = $fetchdata->User_profile_pic;
if(isset($_POST['submit']) && $_POST['submit'] == 'Sumbit')
{
	$title   = $_POST['title'];
	$message = $_POST['message'];

	//echo $userid;exit;
	$userData = array(
		'fullName'   => $fullName,
		'Email'      => $Email,
		'ProfilePic' => $ProfilePic,
		'Mobile'     => $Mobile,
	);
	$insertdata = array(
		'Feedback_userid'    => $userid,
		'Feedback_userData'  => json_encode($userData),
		'Feedback_title'     => $title,
		'Feedback_message'   => $message,
		'Feedback_createdOn' => date('Y-m-d H:i:s')
	);

	$insert = $object->InsertData('GAME_FEEDBACK',$insertdata);
	if($insert)
	{
		$msg      = "Feedback Submitted";
		$title    = $_POST['title'];
		$message1 = $_POST['message'];
		$username = $userName.($userid);
		//echo $title.$message.$username;exit;
		$to       = "support@corporatesim.com";
		$from     = $Email;
		$subject  = $title;
		$message  = "<p>".$fullName."(".$username.") has given the feedback <b>".$message1."</b></p>";
		mail($to,$from,$subject,$message);
	}
	else
	{
		$msg = "Connection Error. Please try later.";
	}
}

include_once doc_root.'views/feedback.php';

?>