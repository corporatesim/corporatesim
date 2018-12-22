<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'outcomeBadges.php';
$header = 'Outcome Badges';

if(isset($_GET['add']) && $_GET['add'] == 'add')
{
	$file = 'addOutcomeBadges.php';
}

if(isset($_POST['addBadges']) && $_POST['addBadges'] == 'addBadges')
{
	// remove last element of post variable
	//array_pop($_POST);
  // upload file
	if(isset($_FILES['image'])){
		$errors= array();
		$file_name  = $_FILES['image']['name'];
		$file_size  = $_FILES['image']['size'];
		$file_tmp   = $_FILES['image']['tmp_name'];
	}	
	echo "<pre>"; print_r($_POST); print_r($_FILES);
	//exit();
	//insert data
	$sql = "INSERT INTO GAME_OUTCOME_BADGES (Badges_ImageName,Badges_ShortName,Badges_Description,Badges_Value) values ";

	$arr              = explode(',',$_POST['rangeVal']);
	print_r($arr);
	$shortname        = $_POST['shortname'];
	$description      = $_POST['description'];
	$fixvalue         = $_POST['fixvalue'];
	$minVal           = $_POST['minVal'];
	$maxVal           = $_POST['maxVal'];
	$Badges_ImageName = $file_name;
  echo "<pre>"; print_r($_POST); //exit;

	$values[]   = "('$Badges_ImageName','$shortname','$description',$fixvalue)";
	$queryValue = implode(',',$values);
	
	for ($i=0; $i < count($file_tmp) ; $i++) 
	{ 
		move_uploaded_file($file_tmp[$i],doc_root."/ux-admin/upload/".$file_name[$i]);
	}
	 var_dump($move); //exit; 
	$sql          .= $queryValue;
  print_r($sql);exit();
	//die($sql);
	$queryExecute  =  $functionsObj->ExecuteQuery($sql);

	if($queryExecute)
	{
		$tr_msg             = "Record Saved Successfully";
		$_SESSION['tr_msg'] = $tr_msg;
	}
	else
	{
		$er_msg             = "Database Connection Error, Please Try Later";
		$_SESSION['er_msg'] = $er_msg;
	}

	header("Location: ".site_root."ux-admin/outcomeBadges");
	exit();
}





include_once doc_root.'ux-admin/view/OutcomeBadges/'.$file;

