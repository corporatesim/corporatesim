
<?php
include 'config/dbconnect.php';
include 'config/functions.php';
include 'config/settings.php';
include 'includes/header.php';
$FunctionsObj = new functions();

if(isset($_POST['submit']) && $_POST['submit'] == 'Enroll')
{
	
	//echo "<pre>"; print_r($_POST); exit;
	session_start();
	$gameId         = $_POST['gameId'];
	$_SESSION['id'] = $gameId;
	
	//$gameName=$_POST['gameName'];
	//echo $gameId;exit;

	// header("location:".site_root."user_registration.php?ID=$gameId");
	echo "<script>window.location='".site_root."/user_registration.php?ID=".$gameId."'</script>";
}

$sql    = "select Game_ID, Game_Name,Game_Comments from GAME_GAME where Game_Delete=0";
$sqlObj = $FunctionsObj->ExecuteQuery($sql);
// $resultObj = $FunctionsObj->FetchObject($sqlObj);
// print_r($resultObj);
include_once doc_root.'views/LandingPage.php';
