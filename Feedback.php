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
$email = $fetchdata->User_email;
$name  = $fetchdata->User_username;
if(isset($_POST['submit']) && $_POST['submit'] == 'Sumbit')
{
	$title   = $_POST['title'];
	$message = $_POST['message'];

	//echo $userid;exit;

	$insertdata = array(
		'Feedback_userid'    => $userid,
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
		$username = $name.($userid);
		//echo $title.$message.$username;exit;
		$to       = "support@corporatesim.com";
		$from     = $email;
		$subject  = $title;
		$message  = "<p> Here is the message ".$message1." And the Username is: ".$username."</p>";
		mail($to,$from,$subject,$message);
	}
	else
	{
		$msg = "Connection Error. Please try later.";
	}
}

include_once doc_root.'views/feedback.php';

?>