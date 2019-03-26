<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';


$funObj = new Model(); // Create Object

// print_r($_POST);
// to get the subenterprise add with the Enterprise
if($_POST['action'] == 'Subenterprise')
{
	//print_r($_POST);
	$Enterprise_ID = $_POST['Enterprise_ID'];
	$sql           = "SELECT * FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gs.SubEnterprise_EnterpriseID WHERE gs.SubEnterprise_EnterpriseID=$Enterprise_ID";
	 //die($sql);
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