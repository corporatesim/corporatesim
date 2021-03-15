<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';

$functionsObj = new Model();

$file   = 'EntSubEnterpriseUsers.php';
$header = 'Enterprise/SubEnterpriseUsers';
//$adminID = $_SESSION['ux-admin-id'];

//details of Enterpriseuser
$object = $functionsObj->SelectData(array('Enterprise_ID','Enterprise_Name'), 'GAME_ENTERPRISE', array('Enterprise_Status=0'), '', '', '', '', 0);
if($object->num_rows > 0);
{
	while($EnterpriseDetails = mysqli_fetch_object($object))
	{
		$EnterpriseName[] = $EnterpriseDetails;
	}
		//echo "<pre>"; print_r($EnterpriseName); exit();
}

//edit & Update the user detail of enterprise and subenterprise
if(isset($_GET['edit']) && !empty($_GET['edit']))
{
	$file     = 'editEntSubEnterpriseUser.php';
	$UserID   = base64_decode($_GET['edit']);
	$editSql  = "SELECT * FROM GAME_SITE_USERS WHERE User_id = $UserID ";
	$editRes  = $functionsObj->ExecuteQuery($editSql);
	//print_r($editSql );
	if($editRes->num_rows < 1)
	{
		$er_msg             = "No record found, or you do not have the permission to edith record";
		$_SESSION['er_msg'] = $er_msg;
		header("Location: ".site_root."ux-admin/ManageEntSubEntUsers");
		exit();
	}

	$userdetails = $editRes->fetch_object();	
	if(isset($_POST['edituser']) && $_POST['edituser'] == 'edituser')
	{
		// remove last element of post variable
		array_pop($_POST);
    //print_r($_POST); exit();
		if($_POST['Enterprise'] && $_POST['SubEnterprise'] )
		{
			$User_Role =2;
		}
		else if($_POST['Enterprise'])
		{
			$User_Role =1;
		}
		else
		{
			$User_Role =0;
		}

		$updateArr = array(
			'User_id'           => $_POST['id'],
			'User_mobile'       => $_POST['mobile'],
			'User_email'        => $_POST['email'],
			'User_Role'         =>	$User_Role,
			'User_ParentId '    => $_POST['Enterprise'],
			'User_SubParentId ' => $_POST['SubEnterprise'],
		);
   //print_r($updateArr); exit();
		$updateData = $functionsObj->UpdateData ( 'GAME_SITE_USERS', $updateArr, 'User_id', $_POST['id'] );
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

	header("Location: ".site_root."ux-admin/ManageEntSubEntUsers");
	exit();
 }
}
//delete Enteprise/subenterprise users
if(isset($_GET['delete']) && !empty($_GET['delete']))
{
	$deleteId = base64_decode($_GET['delete']);
	//echo "<pre>"; print_r($_POST);
	$deleteSql = "UPDATE GAME_SITE_USERS SET User_Delete=1 WHERE User_id=$deleteId";
	//print_r($deleteSql);exit();
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
	header("Location: ".site_root."ux-admin/ManageEntSubEntUsers");
	exit();
}

include_once doc_root.'ux-admin/view/ManageEntSubEntUsers/'.$file;