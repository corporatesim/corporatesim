<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file        = 'manageSubEnterprise.php';
$header      = 'SubEnterprise';
$adminID     = $_SESSION['ux-admin-id'];
//$adminname = $_SESSION['admin_username'];
$adminfname  = $_SESSION['admin_fname'];
$adminlname  = $_SESSION['admin_lname'];
$adminName   = $adminfname.' '.$adminlname;
//print_r($adminName);exit();
$object = $functionsObj->SelectData(array('Enterprise_ID','Enterprise_Name'), 'GAME_ENTERPRISE', array('Enterprise_Status=0'), '', '', '', '', 0);
if($object->num_rows > 0);

{
	while($EnterpriseDetails = mysqli_fetch_object($object))
	{
		$EnterpriseName[] = $EnterpriseDetails;
	}
	//	echo "<pre>"; print_r($EnterpriseName); exit;
}

if(isset($_GET['add']) && $_GET['add'] == 'add')
{
	$file = 'addSubEnterprise.php';
}

if(isset($_POST['addSubEnterprise']) && $_POST['addSubEnterprise'] == 'addSubEnterprise')
{
	//echo "<pre>"; print_r($_POST); 
	//exit();
	// check subEnterprisename is already exist or not
	$subEnterprise = $_POST['subEnterprisename'];
	$query         = "SELECT * FROM GAME_SUBENTERPRISE WHERE SubEnterprise_Name='$subEnterprise'";
	$queryExecute  = $functionsObj->ExecuteQuery($query);
	if($queryExecute->num_rows>0)
	{
		$tr_msg             = "Record already Exists";
		$_SESSION['tr_msg'] = $tr_msg;
	}
	else
	{
		if(isset($_FILES['logo']))
		{
			$file_name  = $_FILES['logo']['name'];
			$file_size  = $_FILES['logo']['size'];
			$file_tmp   = $_FILES['logo']['tmp_name'];
		}	
	//insert data
		$sql = "INSERT INTO GAME_SUBENTERPRISE(SubEnterprise_Name,SubEnterprise_EnterpriseID,SubEnterprise_CreatedOn, SubEnterprise_CreatedBy,SubEnterprise_UpdatedOn,SubEnterprise_UpdatedBy,SubEnterprise_Logo,SubEnterprise_Owner) VALUES";

		$subenterprise = $_POST['subEnterprisename'];
		$enterpriseID  = $_POST['enterprise'];
		$logo          = $file_name;
	//print_r($createddBy) ;
		$date          = date('Y-m-d H:i:s');
		$values[]      = "('$subenterprise',$enterpriseID,'$date',$adminID, '', '','$logo',1)";
		$queryValue    = implode(',',$values);
		$move          = move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Logo/".$file_name);
		$sql           .= $queryValue;
	//print_r($sql); exit();

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

		header("Location: ".site_root."ux-admin/ManageSubEnterprise");
		exit();
	}
}

//edit SubEnterprises
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file            = 'editSubEnterprise.php';
	$EnterpriseID    = $_POST['enterprise'];
	$SubEnterpriseID = $_GET['edit'];
	$editSql         = "SELECT * FROM GAME_SUBENTERPRISE WHERE SubEnterprise_ID = $SubEnterpriseID ";
	$editRes         = $functionsObj->ExecuteQuery($editSql);
	//print_r($editSql ); exit();

	//Select games from game_game table and show already existing game as selected
	$sql  = "SELECT gg.Game_ID, gg.Game_Name, gsg.SG_GameID, gsg.SG_ID, gsg.SG_Game_Start_Date, gsg.SG_Game_End_Date FROM `game_game` gg LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_GameID = gg.Game_ID AND gsg.SG_SubEnterpriseID = $SubEnterpriseID WHERE gg.Game_Delete = 0 ORDER BY `gg`.`Game_ID` ASC";
	$games = $functionsObj->ExecuteQuery($sql);

	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edit record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/ManageSubEnterprise");
		exit();
	}

	$editResObject = $editRes->fetch_object();	

	if(isset($_POST['editSubEnterprise']) && $_POST['editSubEnterprise'] == 'editSubEnterprise')
	{
		$CreatedOn         = date('Y-m-d H:i:s');
		$subenterprisegame = $_POST['subenterprisegame'];
		
   //Get Enterprise startdate and enddate for particular game
		$StartDate      = $_POST['SubEnterprise_GameStartDate'];
		for ($i=0; $i < count($StartDate) ; $i++) 
		{ 
			if(!$StartDate[$i])
			{
				$StartDate[$i] =  '2000-00-00 00:00:00';
			}
			else
			{
				$StartDate[$i];
			}
		}

		$EndDate        = $_POST['SubEnterprise_GameEndDate'];
		for ($i=0; $i <count($EndDate) ; $i++) 
		{
			if(!$EndDate[$i])
			{
				$EndDate[$i] =  date('Y-m-d H:i:s');
			}
			else
			{
				$EndDate[$i];
			} 
		}

		//Firstly delete already exist enteprise game then insert
		$DeleteGame = $functionsObj->DeleteData('GAME_SUBENTERPRISE_GAME','SG_SubEnterpriseID',$SubEnterpriseID,0);

    //insert Subenterprise game
		for($i=0;$i<count($subenterprisegame);$i++)
		{
			$exp                     = explode(',',$subenterprisegame[$i]);
			$SubEnterprisegameid     = $SubEnterprisegameid. $subenterprisegame[$i].",";		
			$InsertSubEnterpriseGame =  array(
				'SG_EnterpriseID'        => $EnterpriseID,
				'SG_SubEnterpriseID'     => $SubEnterpriseID,
				'SG_GameID'              => $subenterprisegame[$i],
				'SG_Game_Start_Date'     => $StartDate[$i],
				'SG_Game_End_Date'       => $EndDate[$i],
				'SG_CreatedOn'           => $CreatedOn,
				'SG_CreatedBy'           => $adminID,
			);
      //print_r($InsertSubEnterpriseGame);

			if( !empty($subenterprisegame) && !empty($CreatedOn) && !empty($SubEnterpriseID) )
			{
				$InsertGame = $functionsObj->InsertData('GAME_SUBENTERPRISE_GAME', $InsertSubEnterpriseGame);
				if($InsertGame)
				{
					$tr_msg             = "Record Updated Successfully";
					$_SESSION['tr_msg'] = $tr_msg;
				}
				else
				{
					$er_msg             = "Database connection error, while updaing records";
					$_SESSION['er_msg'] = $er_msg;
				}
			}
		}
			// remove last element of post variable
		array_pop($_POST);
		if(isset($_FILES['logo']))
		{
			$file_name = $_FILES['logo']['name'];
			$file_size = $_FILES['logo']['size'];
			$file_tmp  = $_FILES['logo']['tmp_name'];
		}	
		//print_r($file_name); 
		$SubEnterpriseName = $_POST['SubEnterpriseName'];
		$enterpriseID      = $_POST['enterprise'];
		$UpdatedOn         = date('Y-m-d H:i:s');;
		$UpdatedBy         = $adminID;
		if(!empty($file_name))
		{
			$updateArr = array(
				'SubEnterprise_ID'          => $SubEnterpriseID,
				'SubEnterprise_Name'        => $_POST['SubEnterpriseName'],
				'SubEnterprise_EnterpriseID'=> $enterpriseID,
				'SubEnterprise_UpdatedOn	' => $UpdatedOn,
				'SubEnterprise_UpdatedBy	' => $UpdatedBy,
				'SubEnterprise_Games	'     => $SubEnterprisegameid,
				'SubEnterprise_Logo	'       => $file_name,
			);
     //print_r($updateArr);exit();
		}
		else
		{
			$updateArr = array(
				'SubEnterprise_ID'          => $SubEnterpriseID,
				'SubEnterprise_Name'        => $_POST['SubEnterpriseName'],
				'SubEnterprise_EnterpriseID'=> $enterpriseID,
				'SubEnterprise_UpdatedOn	' => $UpdatedOn,
				'SubEnterprise_UpdatedBy	' => $UpdatedBy,
				'SubEnterprise_Games	'     => $SubEnterprisegameid,
			);
		}
		move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Logo/".$file_name);
		$updateData = $functionsObj->UpdateData ( 'GAME_SUBENTERPRISE', $updateArr,  'SubEnterprise_ID', 
			$SubEnterpriseID);
			//print_r($updateData);exit();

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
		header("Location: ".site_root."ux-admin/ManageSubEnterprise");
		exit();
	}
}


/*delete records*/
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$deleteId = base64_decode($_GET['delete']);
			 //echo "<pre>"; print_r($_POST);
	$deleteSql = "UPDATE GAME_SUBENTERPRISE SET SubEnterprise_Status=1 WHERE SubEnterprise_ID=$deleteId";
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
	header("Location: ".site_root."ux-admin/ManageSubEnterprise");
	exit();
}
$sql = "SELECT *, (SELECT count(*) FROM GAME_SUBENTERPRISE_GAME WHERE SG_SubEnterpriseID = gs.SubEnterprise_ID) as gamecount FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gs.SubEnterprise_CreatedBy OR ga.id = gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_SITE_USERS gu ON gu.User_id = gs.SubEnterprise_CreatedBy OR gu.User_id = gs.SubEnterprise_UpdatedBy WHERE SubEnterprise_Status = 0 ";
$object = $functionsObj->ExecuteQuery($sql);

include_once doc_root.'ux-admin/view/ManageSubEnterprise/'.$file;