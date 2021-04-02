<?php
//require_once doc_root.'ux-admin/model/model.php';
//$functionsObj = new Model();
include_once 'config/settings.php';
include_once 'includes/header.php'; 

include_once doc_root.'config/functions.php';

if(isset($_GET['q']) && $_GET['q'] == "Logout"){
	unset($_SESSION['username']);
	unset($_SESSION['user_report']);
	// unset($_SESSION['logo']);
	
	//setcookie($cookie_name, "", 1);
	if(isset($_COOKIE['returnUrl']))
	{
		$returnUrl = $_COOKIE['returnUrl'];
		setcookie($_COOKIE['returnUrl'], time() - 3600);
		header("Location: $returnUrl");
		exit();
	}
	else
	{
		header("Location:".site_root."login.php");
		exit();
	}
}
?>