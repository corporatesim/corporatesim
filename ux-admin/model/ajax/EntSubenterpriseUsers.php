<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';

$funObj = new Model(); 
// print_r($_POST);
// to get the subenterprise add with the Enterprise
if($_POST['action'] == 'Subenterprise')
{
	$Enterprise_ID = $_POST['Enterprise_ID'];
	//print_r($Enterprise_ID);
	$sql           = "SELECT * FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERprise ge ON ge.Enterprise_ID = gs.SubEnterprise_EnterpriseID WHERE gs.SubEnterprise_EnterpriseID=$Enterprise_ID";
	// die($sql);
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		While($result = mysqli_fetch_object($Object))
		{
			$SubEnterpriseData[] = $result;
		}
		
		echo json_encode($SubEnterpriseData);
	}
	else
	{
		echo "no link";
	}

}

//show Enterprise users
if($_POST['action'] == 'Enterprise_Users')
{
	$Enterprise_ID = $_POST['Enterprise_ID'];
	$sql           = "SELECT gu.User_id,gu.User_username,gu.User_email,gu.User_mobile,ge.Enterprise_Name,IFNULL(gs.SubEnterprise_Name, 'No SubEnterprise') AS SubEnterprise_Name FROM GAME_SITE_USERS gu LEFT JOIN GAME_ENTERPRISE ge ON gu.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_SUBENTERPRISE gs ON gu.User_SubParentId = gs.SubEnterprise_ID WHERE User_Role=1 AND User_ParentId=$Enterprise_ID AND User_Delete=0";
	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		while($result = mysqli_fetch_object($Object))
		{
			$encResult    = (Object)array(
				'EncryptUserId'      => base64_encode($result->User_id),
				'User_id'            => $result->User_id,
				'User_username'      => $result->User_username,
				'User_email'         => $result->User_email,
				'User_mobile'        => $result->User_mobile,
				'Enterprise_Name'    => $result->Enterprise_Name,
				'SubEnterprise_Name' => $result->SubEnterprise_Name,
			);
			$EnterpriseUserData[] = $encResult;
		}
		// print_r($EnterpriseUserData); exit();
		echo json_encode($EnterpriseUserData);
	}
	else
	{
		echo "no link";
	}
}

//show SubEnterprise Users
if($_POST['action'] == 'EntSubenterprise_Users')
{
	$Enterprise_ID    = $_POST['Enterprise_ID'];
	$SubEnterprise_ID = $_POST['SubEnterprise_ID'];

	$sql    = "SELECT gu.User_id,gu.User_username,gu.User_email,gu.User_mobile,gs.SubEnterprise_Name,ge.Enterprise_Name FROM GAME_SITE_USERS gu LEFT JOIN GAME_SUBENTERPRISE gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_Role=2 AND User_Delete=0 AND gu.User_ParentId=$Enterprise_ID AND gu.User_SubParentId=$SubEnterprise_ID";

	$Object = $funObj->ExecuteQuery($sql);
	if($Object->num_rows > 0)
	{
		while($result = mysqli_fetch_object($Object))
		{
			$encResult    = (Object)array(
				'EncryptUserId'      => base64_encode($result->User_id),
				'User_id'            => $result->User_id,
				'User_username'      => $result->User_username,
				'User_email'         => $result->User_email,
				'User_mobile'        => $result->User_mobile,
				'Enterprise_Name'    => $result->Enterprise_Name,
				'SubEnterprise_Name' => $result->SubEnterprise_Name,
			);
			$EnterpriseUserData[] = $encResult;
		}
		echo json_encode($EnterpriseUserData);
	}
	else
	{
		echo "no link";
	}

}
