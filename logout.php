<?php
//require_once doc_root.'ux-admin/model/model.php';
//$functionsObj = new Model();
include_once 'config/settings.php';
include_once 'includes/header.php'; 

include_once doc_root.'config/functions.php';

if(isset($_GET['q']) && $_GET['q'] == "Logout"){
	unset($_SESSION['username']);
	//setcookie($cookie_name, "", 1);
	header("Location:".site_root."login.php");
}
?>