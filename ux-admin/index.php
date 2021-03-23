<?php
require_once '../config/settings.php';

// Check cookie
if(empty($_SESSION['ux-admin-id'])){
	include_once(doc_root.'/ux-admin/autologin.php');
}

// Check Session
if(isset($_SESSION['ux-admin-id']) && !empty($_SESSION['ux-admin-id'])){
	include_once doc_root.'ux-admin/controller/index.php';
}else{
	include_once doc_root.'ux-admin/controller/login.php';
}
?>
