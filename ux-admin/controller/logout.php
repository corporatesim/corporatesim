<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

if(isset($_GET['q']) && $_GET['q'] == "Logout"){
	unset($_SESSION['ux-admin-id']);
	setcookie($cookie_name, "", 1);
	header("Location:".site_root."ux-admin/index");
}
?>