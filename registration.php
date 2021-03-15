<?php
include 'config/dbconnect.php';
include 'config/functions.php';
include 'config/settings.php';
//include 'includes/header.php';
$FunctionsObj = new functions();

// if user is logged in then go to select game page
if($_SESSION['username'] != NULL)
{
	header("Location:".site_root."selectgame.php");
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Enroll')
{
	
	//echo "<pre>"; print_r($_POST); exit;
	session_start();
	$gameId         = $_POST['gameId'];
	$_SESSION['id'] = $gameId;

	//$gameName=$_POST['gameName'];
	//echo $gameId;exit;
	
	header("location:".site_root."user_registration.php?ID=$gameId");
	//echo "<script>window.location='".site_root."user_registration.php?ID=".$gameId."'</script>";
}

$sql    = "SELECT Game_ID, Game_Name,Game_Comments,Game_shortDescription,Game_longDescription,Game_prise,Game_discount, Game_Image FROM GAME_GAME WHERE Game_Delete = 0";
//$sql    = "select Game_ID, Game_Name, Game_Comments, Game_Image from GAME_GAME where Game_Delete=0";
$sqlObj = $FunctionsObj->ExecuteQuery($sql);
//$resultObj = $FunctionsObj->FetchObject($sqlObj);
// print_r($resultObj);
 /*$game_prise=$resultObj->Game_prise;
 $game_discount=$resultObj->Game_discount;
 $totalprize=$game_prise-$game_discount;
 echo $totalprize;
*/
 include_once doc_root.'views/registration.php';
