<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

// checking login status of user while user execute or save via ajax
if($_POST['action'] == 'check_loggedIn_status')
{
	// die('here');
	echo ($_SESSION['username'])?'yes':'no';
	die();
}

// if user is logout then redirect to login page as we're unsetting the username from session
if($_SESSION['username'] == NULL)
{
	header("Location:".site_root."login.php");
}
$functionsObj         = new Functions();
$_SESSION['userpage'] = 'howToPlay';
$uid                  = $_SESSION['userid'];

include_once doc_root.'views/howToPlay.php';