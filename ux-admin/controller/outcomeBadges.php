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
	/*echo "<pre>"; print_r($_POST);

	//$Badges_Value = $_POST['fixvalue'];
	$minVal           = $_POST['minVal'];
	$maxVal           = $_POST['maxVal'];
	$Badges_Value     = $minVal . ','.$maxVal;
	echo $Badges_Value;*/
	//exit();
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

	
	$shortname        = $_POST['shortname'];
	$description      = $_POST['description'];
	$fixvalue         = $_POST['fixvalue'];
	$minVal           = $_POST['minVal'];
	$maxVal           = $_POST['maxVal'];
	$value            = $_POST['rangeVal'];
	$Badges_Value     = $minVal . ','.$maxVal;
	$Badges_ImageName = $file_name;
	
 //echo "<pre>"; print_r($_POST);print_r($Badges_Value); /*exit;*/
	if($fixvalue)
	{
		$values[]   = "('$Badges_ImageName','$shortname','$description','$value,$fixvalue')";
		$queryValue = implode(',',$values);
	}
	else
	{
		$values[]   = "('$Badges_ImageName','$shortname','$description','$value,$Badges_Value')";
		$queryValue = implode(',',$values);
	}
	$move=move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Badges/".$file_name);
	
// var_dump($move); //exit; 
	$sql          .= $queryValue;
 // print_r($sql); exit();
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

//edit OUtcome Badges
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file      = 'editOutcomeBadges.php';
	$BadgesID = $_GET['edit'];
	$editSql   = "SELECT * FROM GAME_OUTCOME_BADGES WHERE Badges_ID = $BadgesID ";
	$editRes   = $functionsObj->ExecuteQuery($editSql);
	//print_r($editSql );
	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edith record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/outcomeBadges");
		exit();
	}

	$editResObject = $editRes->fetch_object();	

	/* echo "<pre>"; print_r($editResObject);
		die('edited '.$file);*/
		if(isset($_POST['editBadges']) && $_POST['editBadges'] == 'editBadges')
		{
			// remove last element of post variable
			array_pop($_POST);

			// if user doesn't choose file to upload
			//echo "<pre>"; print_r($_POST); print_r($_FILES); 
				if(isset($_FILES['image']))
				{
					$errors    = array();
					$file_name = $_FILES['image']['name'];
					$file_size = $_FILES['image']['size'];
					$file_tmp  = $_FILES['image']['tmp_name'];
					$fixvalue  = $_POST['fixvalue'];
					$minVal    = $_POST['minVal'];
					$maxVal    = $_POST['maxVal'];
					$value     = $_POST['rangeVal'];
					//echo $Badges_Value = $minVal . ','.$maxVal;
						if($fixvalue)
						{
							$Badges_Val = $value. ','.$fixvalue;
						}
						else
						{

						$Badges_Val = $value. ','.$minVal . ','.$maxVal;	
						}
					if(empty($file_name))
					{
						$updateArr = array(
						'Badges_ID'           => $BadgesID,
						'Badges_ShortName'    => $_POST['shortname'],
						'Badges_Description	' => $_POST['description'],
						'Badges_Value'        => $Badges_Val,    
						);
						//print_r($_POST);print_r($_FILES);
						//print_r($updateArr);exit();
						$updateData = $functionsObj->UpdateData ( 'GAME_OUTCOME_BADGES', $updateArr,  'Badges_ID', $BadgesID);
					  //print_r($updateData);exit();
					}
					else
					{
						$updateArr = array(
						'Badges_ID'           => $BadgesID,
						'Badges_ImageName'    => $file_name,
						'Badges_ShortName'    => $_POST['shortname'],
						'Badges_Description	' => $_POST['description'],
						'Badges_Value'        => $Badges_Value,

						);
						//print_r($_POST);print_r($_FILES);//exit();
						$move = move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Badges/".$file_name);
						//var_dump($move);
						if($move)
						{
							$updateData = $functionsObj->UpdateData ('GAME_OUTCOME_BADGES', $updateArr, 'Badges_ID', $BadgesID);
							//print_r($updateData);//exit();
						}
						else
						{
							$updateData = false;
							//print_r($updateData);exit();	
						}
					}

				}
				//die($updateArr);
				if($updateData)
				{
					$tr_msg             = "Record Updated Successfully";
					$_SESSION['tr_msg'] = $tr_msg;
				}
				else
				{
					$er_msg             = "Database connection error, while updaing records";
					$_SESSION['er_msg'] = $er_msg;
				}
				header("Location: ".site_root."ux-admin/outcomeBadges");
				exit();
			}
		}

		if(isset($_GET['delete']) && !empty($_GET['delete']))
		{
			$deleteId = base64_decode($_GET['delete']);
			 //echo "<pre>"; print_r($_POST);
				$deleteSql = "UPDATE GAME_OUTCOME_Badges SET Badges_Is_Active=1 WHERE Badges_ID=$deleteId";
				$deleteRes = $functionsObj->ExecuteQuery($deleteSql);
				if($deleteRes)
				{
					$tr_msg             = "Record Deleted Successfully";
					$_SESSION['tr_msg'] = $tr_msg;
				}
				else
				{
					$er_msg             = "Database Connection Error While Deleting, Please Try Later";
					$_SESSION['er_msg'] = $er_msg;
				}
				header("Location: ".site_root."ux-admin/outcomeBadges");
				exit();
			}


			$sql = "SELECT * FROM GAME_OUTCOME_BADGES WHERE Badges_Is_Active=0";

			$badges = $functionsObj->ExecuteQuery($sql);
			//$badgesResult = $badges->fetch_object();

			include_once doc_root.'ux-admin/view/OutcomeBadges/'.$file;

