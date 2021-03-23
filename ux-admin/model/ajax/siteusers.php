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
		while($result = mysqli_fetch_object($Object))
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

if($_POST['action'] == 'reportTwoSequence')
{
	// 3-(Output)Simulated Performance, 4-(Output)Competence Readiness, 5-(Output)Competence Application, 6-(Output)None	

	$gameid = trim($_POST['gameid']);
	if(!empty($gameid))
	{
		$findSql = "SELECT gls.SubLink_CompID, gls.SubLink_SubCompID, gls.SubLink_LinkID, gls.SubLink_AreaName,gls.SubLink_CompName,gls.SubLink_SubcompName,gls.SubLink_SubcompName,gls.SubLink_Competence_Performance,gls.SubLink_CompID,gls.SubLink_SubCompID,gls.SubLink_LinkID,gls.SubLink_ID,gros.OpSeq_Order, gs.Scen_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_REPORT_OUTPUT_SEQUENCING gros ON gros.OpSeq_GameId=$gameid AND gros.OpSeq_SubLinkId=gls.SubLink_ID LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE gls.SubLink_LinkID IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID =$gameid) AND gls.SubLink_Type = 1 AND gls.SubLink_ShowHide=0 AND gls.SubLink_Competence_Performance != 6 AND gls.SubLink_InputMode !='none' ORDER BY gros.OpSeq_Order";
		// die($findSql);
		$sqlObj = $funObj->RunQueryFetchObject($findSql);
		if(count($sqlObj)>0)
		{
			die(json_encode(array('code'=>200, 'msg'=>'Output linkage fetched successfully.', 'data'=>$sqlObj)));
		}
		else
		{
			die(json_encode(array('code'=>201, 'msg'=>'Selected game does not have any linkage in output side.')));
		}
	}
	else
	{
		die(json_encode(array('code'=>201, 'msg'=>'No game selected.')));
	}

}