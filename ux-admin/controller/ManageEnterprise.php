<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj  = new Model();
$enableEndDate = true;
$file          = 'ManageEnterprise.php';
$header        = 'Enterprise';
$adminID       = $_SESSION['ux-admin-id'];
$adminfname    = $_SESSION['admin_fname'];
$adminlname    = $_SESSION['admin_lname'];
$adminName     = $adminfname.' '.$adminlname;
//print_r($adminName);exit();
if(isset($_GET['add']) && $_GET['add'] == 'add')
{
	$file = 'addEnterprise.php';
}

if(isset($_POST['addEnterprise']) && $_POST['addEnterprise'] == 'addEnterprise')
{
	/*echo "<pre>"; print_r($_POST); 
	exit();*/
	// check Enterprisename is already exist or not
	$enterprise   = $_POST['Enterprise'];
	$query        = "SELECT * FROM GAME_ENTERPRISE WHERE Enterprise_Name='$enterprise'";
	$queryExecute = $functionsObj->ExecuteQuery($query);
	if($queryExecute->num_rows>0)
	{
		$tr_msg             = "Record already Exists";
		$_SESSION['tr_msg'] = $tr_msg;
	}
	else
	{
	//insert data
		if(isset($_FILES['logo'])){
			$file_name  = $_FILES['logo']['name'];
			$file_size  = $_FILES['logo']['size'];
			$file_tmp   = $_FILES['logo']['tmp_name'];
		}	
  //print_r($file_name);
		$sql = "INSERT INTO GAME_ENTERPRISE (Enterprise_Name,Enterprise_GameStartDate,Enterprise_GameEndDate,Enterprise_CreatedOn, Enterprise_CreatedBy,Enterprise_UpdatedOn,Enterprise_UpdatedBy,Enterprise_Logo) VALUES";
		$enterprise = $_POST['Enterprise'];
		$logo       = $file_name;
		$date       = date('Y-m-d H:i:s');
		$Enterprise_GameStartDate = $_POST['Enterprise_GameStartDate'];
		$Enterprise_GameEndDate   = $_POST['Enterprise_GameEndDate'];
		$values[]   = "('$enterprise','$Enterprise_GameStartDate','$Enterprise_GameEndDate','$date', $adminID,'', '','$logo')";
		$queryValue = implode(',',$values);
		$move       = move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Logo/".$file_name);
		$sql       .= $queryValue;
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

		header("Location: ".site_root."ux-admin/ManageEnterprise");
		exit();
	}
}

//edit Enterprises
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file         = 'editEnterprise.php';
	$EnterpriseID = $_GET['edit'];
	//select data from game enterprise table
	$editSql      = "SELECT * FROM GAME_ENTERPRISE WHERE Enterprise_ID = $EnterpriseID ";
	$editRes      = $functionsObj->ExecuteQuery($editSql);
	
  //Select games from game_game table
	// $games = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);

	//Select games from game_game table and show already existing game as selected
  $sql  = "SELECT gg.Game_ID,gg.Game_Name,geg.EG_GameID,geg.EG_ID,geg.EG_Game_Start_Date,geg.EG_Game_End_Date FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID=gg.Game_ID AND geg.EG_EnterpriseID=$EnterpriseID WHERE gg.Game_Delete = 0 ORDER BY gg.Game_ID ASC";
	$games = $functionsObj->ExecuteQuery($sql); 
	// $games  = $functionsObj->FetchObject($games);  
  // echo "<pre>"; print_r($games->fetch_object());exit();

	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edit record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/ManageEnterprise");
		exit();
	}
  
	$editResObject = $editRes->fetch_object();

  //insert games into game_enterprise_game table and update game_enterprise table 
	if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
	{    
		//echo "<pre>"; print_r($_POST); exit();
    //update game_enterprise_game table
    $UpdatedOn      = date('Y-m-d H:i:s');
		$CreatedOn      = date('Y-m-d H:i:s');
		$enterprisegame = $_POST['enterprisegame'];
    $Enterprisegamestartdate = $_POST['GameStartDate'];
    $Enterpeizegameenddate   = $_POST['GameEndDate'];
    // print_r($Enterprisegamestartdate);print_r($Enterpeizegameenddate);exit();
   //Get Enterprise startdate and enddate for particular game
		$StartDate      = $_POST['Enterprise_GameStartDate'];
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

		$EndDate        = $_POST['Enterprise_GameEndDate'];
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
    $DeleteGame = $functionsObj->DeleteData('GAME_ENTERPRISE_GAME','EG_EnterpriseID',$EnterpriseID,0);
    
    //insert enterprise game
		for($i=0;$i<count($enterprisegame);$i++)
		{
				$exp              = explode(',',$enterprisegame[$i]);
				$Enterprisegameid = $Enterprisegameid. $enterprisegame[$i].",";		
				$InsertEnterpriseGame =  array(
				'EG_EnterpriseID'    => $EnterpriseID,
				'EG_GameID'          => $enterprisegame[$i],
				'EG_Game_Start_Date' => $StartDate[$i],
				'EG_Game_End_Date'   => $EndDate[$i],
				'EG_CreatedOn'       => $CreatedOn,
				'EG_CreatedBy'       => $adminID,
				);

			if( !empty($enterprisegame) && !empty($CreatedOn) && !empty($EnterpriseID) )
			{
        //print_r($InsertEnterpriseGame);exit();
				$InsertGame = $functionsObj->InsertData('GAME_ENTERPRISE_GAME', $InsertEnterpriseGame);
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
		//print_r($file_name);exit();
		//$UpdatedOn      = date('Y-m-d H:i:s');
		if(!empty($file_name))
		{
			$updateArr = array(
				'Enterprise_ID'            => $EnterpriseID,
				'Enterprise_Name'          => $_POST['EnterpriseName'],
				'Enterprise_GameStartDate' => $_POST['GameStartDate'],
				'Enterprise_GameEndDate'   => $_POST['GameEndDate'],
				'Enterprise_UpdatedOn	'    => $UpdatedOn,
				'Enterprise_UpdatedBy	'    => $adminID,
				'Enterprise_Games'         => $Enterprisegameid,
				'Enterprise_Logo	'        => $file_name,
			);
		}
		else
		{
			$updateArr = array(
				'Enterprise_ID'            => $EnterpriseID,
				'Enterprise_Games'         => $Enterprisegameid,
				'Enterprise_Name'          => $_POST['EnterpriseName'],
				'Enterprise_GameStartDate' => $_POST['GameStartDate'],
				'Enterprise_GameEndDate'   => $_POST['GameEndDate'],
				'Enterprise_UpdatedOn	'    => $UpdatedOn,
				'Enterprise_UpdatedBy	'    => $adminID,
			);
		}
		//print_r($updateArr);exit();
		move_uploaded_file($file_tmp,doc_root."/ux-admin/upload/Logo/".$file_name);
		$updateData = $functionsObj->UpdateData ( 'GAME_ENTERPRISE', $updateArr,  'Enterprise_ID', 
			$EnterpriseID);
			//print_r($updateData);exit();

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
	//die($updateArr);
		header("Location: ".site_root."ux-admin/ManageEnterprise");
		exit();
	}
}

/*delete records*/
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$deleteId  = base64_decode($_GET['delete']);
			 //echo "<pre>"; print_r($_POST);
	$deleteSql = "UPDATE GAME_ENTERPRISE SET Enterprise_Status=1 WHERE Enterprise_ID=$deleteId";
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
	header("Location: ".site_root."ux-admin/ManageEnterprise");
	exit();
}

$sql = "SELECT ge.*,concat(ga.fname,' ',ga.lname) AS User_Name,(SELECT count(*) FROM GAME_ENTERPRISE_GAME WHERE EG_EnterpriseID = ge.Enterprise_ID) as gamecount FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ADMINUSERS ga ON ge.Enterprise_CreatedBy=ga.id WHERE Enterprise_Status = 0";
  //print_r($sql);exit();

$object = $functionsObj->ExecuteQuery($sql);

include_once doc_root.'ux-admin/view/ManageEnterprise/'.$file;
