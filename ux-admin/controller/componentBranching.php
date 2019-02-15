<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'componentBranching.php';
$linkId = $_GET['link'];
$uid    = $_SESSION['ux-admin-id'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
// if there is no linkId then move to linkage page
if(!$linkId)
{
	$_SESSION['msg']     = "Invalid Request";
	$_SESSION['type[0]'] = "inputError";
	$_SESSION['type[1]'] = "has-error";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}
$query    = "SELECT gl.*,gg.Game_Name,gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE gl.Link_ID=".$linkId;
$queryObj = $functionsObj->ExecuteQuery($query);
// if user submit(save/update)
if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
	// echo "<pre>"; print_r($_SESSION['id']); print_r($_POST); exit();
	if($_POST['update'] == 'update')
	{
		$deleteSql = "DELETE FROM GAME_BRANCHING_COMPONENT WHERE CompBranch_LinkId=".$linkId;
		$functionsObj->ExecuteQuery($deleteSql);
	}
	$count          = count($_POST['componentName']);
	$tableDataArray = array ();
	for($i=0; $i<$count; $i++)
	{
		$compDetail     = explode(',',$_POST['componentName'][$i]);
		$compId         = $compDetail[0];
		$sublinkId      = $compDetail[1];
		$areaId         = $compDetail[2];
		$nextCompDetail = explode(',',$_POST['componentNextName'][$i]);
		$nextCompId     = $nextCompDetail[0];
		$nextSublinkId  = $nextCompDetail[1];
		$tableDataArray = array (
			'CompBranch_CompId'            => $compId,
			'CompBranch_LinkId'            => $linkId,
			'CompBranch_SublinkId'         => $sublinkId,
			'CompBranch_AreaId'            => $areaId,
			'CompBranch_MinVal'            => $_POST['minVal'][$i],
			'CompBranch_MaxVal'            => $_POST['maxVal'][$i],
			'CompBranch_Order'             => $_POST['order'][$i],
			'CompBranch_NextCompId'        => $nextCompId,
			'CompBranch_NextCompSublinkId' => $nextSublinkId,
			'CompBranch_CreatedOn'         => date('Y-m-d H:i:s'),
			'CompBranch_CreatedBy'         => $uid,
		);
		if(empty($compId) || empty($_POST['minVal'][$i]) || empty($_POST['maxVal'][$i]) || empty($_POST['order'][$i]) || empty($nextCompId))
		{
			$_SESSION['msg']     = "Fields can not be left blank";
			$_SESSION['type[0]'] = "inputError";
			$_SESSION['type[1]'] = "has-error";
			header("Location: ".site_root."ux-admin/componentBranching/link/".$linkId);
			exit(0);
		}
		$functionsObj->InsertData('GAME_BRANCHING_COMPONENT',$tableDataArray);
	}
	// echo "<pre>"; print_r($tableDataArray); exit();
	$_SESSION['msg']     = "Branching Saved Successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}

if($queryObj->num_rows < 1)
{
	$_SESSION['msg']     = "No record found";
	$_SESSION['type[0]'] = "inputError";
	$_SESSION['type[1]'] = "has-error";
	header("Location: ".site_root."ux-admin/linkage");
	exit(0);
}
else
{
	$result = $functionsObj->FetchObject($queryObj);
	if($result->Link_Branching < 1)
	{
		$_SESSION['msg']     = "Not eligible for component branching";
		$_SESSION['type[0]'] = "inputError";
		$_SESSION['type[1]'] = "has-error";
		header("Location: ".site_root."ux-admin/linkage");
		exit(0);
	}
	$compSql = "SELECT gls.*,gc.Comp_Name,gg.Game_Name,gs.Scen_Name,ga.Area_Name FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_GAME gg ON gg.Game_ID=(SELECT Link_GameID FROM GAME_LINKAGE WHERE Link_ID=".$linkId.") LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=(SELECT Link_ScenarioID FROM GAME_LINKAGE WHERE Link_ID=".$linkId.") WHERE gls.SubLink_LinkID=".$linkId." AND gls.SubLink_ShowHide<1 AND gls.SubLink_SubCompID<1 ORDER BY gls.SubLink_Order ASC";
	// die($compSql);
	$gameScenSql = "SELECT gg.Game_Name,gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID=gl.Link_ScenarioID WHERE Link_ID=".$linkId;
	$compSqlObj  = $functionsObj->ExecuteQuery($compSql);
	$gameScenObj = $functionsObj->ExecuteQuery($gameScenSql);
	$gameScen    = $functionsObj->FetchObject($gameScenObj);
	$gameName    = $gameScen->Game_Name;
	$scenName    = $gameScen->Scen_Name;
}

include_once doc_root.'ux-admin/view/componentBranching/'.$file;