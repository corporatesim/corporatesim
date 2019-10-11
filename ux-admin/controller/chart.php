<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();
$object       = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename     = $functionsObj->FetchObject($object);
$file         = 'list.php';
// include PHPExcel

//echo $_POST['chkround'];
//exit();

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['chartType']) )
	{
		$component    = implode(',',$_POST['component']);
		$subcomponent = implode(',',$_POST['subcomponent']);
		$chartdetails = (object) array(
			'Chart_GameID'        =>	$_POST['game_id'],
			'Chart_ScenarioID'    =>	$_POST['scen_id'],
			'Chart_AreaID'        =>	$_POST['area_id'],
			'Chart_Name'          =>	$_POST['chartName'],
			'Chart_Type'          =>	$_POST['chartType'],
			'Chart_Axis'          =>	$_POST['axis_placement'],
			'Chart_Components'    =>	$component,
			'Chart_Subcomponents' =>	$subcomponent,
			'Chart_Status'        =>	1,			
			'Chart_Type_Status'   =>	0,			
			'Chart_CreateDate'    =>	date('Y-m-d H:i:s')
		);

		$result = $functionsObj->InsertData('GAME_CHART', $chartdetails, 0, 0);
		if($result)
		{
			$_SESSION['msg']     = "Sub component chart added successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/chart");
			exit(0);	
		}
	}	
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update')
{	
	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['chartType']) )
	{
		$component    = implode(',',$_POST['component']);
		$subcomponent = implode(',',$_POST['subcomponent']);
		$chartdetails = (object) array(
			'Chart_GameID'        =>	$_POST['game_id'],
			'Chart_ScenarioID'    =>	$_POST['scen_id'],
			'Chart_AreaID'        =>	$_POST['area_id'],
			'Chart_Name'          =>	$_POST['chartName'],
			'Chart_Type'          =>	$_POST['chartType'],
			'Chart_Axis'          =>	$_POST['axis_placement'],
			'Chart_Components'    =>	$component,
			'Chart_Subcomponents' =>	$subcomponent,
			'Chart_Status'        =>	1,			
			'Chart_CreateDate'    =>	date('Y-m-d H:i:s')
		);

		$linkid             = $_GET['edit'];
		$result             = $functionsObj->UpdateData('GAME_CHART', $chartdetails, 'Chart_ID', $linkid, 0);
		$updateChartNameSql = " UPDATE `GAME_LINKAGE_SUB` SET `SubLink_ChartType` = '".$_POST['chartType']."' WHERE SubLink_ChartID =".$linkid;
		$functionsObj->ExecuteQuery($updateChartNameSql);
		
		if($result === true)
		{
			$_SESSION['msg']     = "Sub component chart successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/chart");
			exit(0);
		}
		else
		{
			$msg     = "Error: ".$result;
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}
// Edit Siteuser
if(isset($_GET['edit']))
{
	$chartSql     = "SELECT gcl.List_ID,gcl.List_Name,gcl.List_Value,gcl.List_TitleId,gct.Title_Name FROM GAME_CHART_LIST gcl LEFT JOIN GAME_CHART_TITLE gct ON gct.Title_ID=gcl.List_TitleId WHERE gcl.List_Status=0 ORDER BY `gcl`.`List_TitleId` ASC";
	$chartList    = $functionsObj->ExecuteQuery($chartSql);
	$header       = 'Edit Chart Sub-Component';
	$Chart_ID     = $_GET['edit'];
	$object       = $functionsObj->SelectData(array(), 'GAME_CHART', array('Chart_ID='.$Chart_ID), '', '', '', '', 0);
	$chartdetails = $functionsObj->FetchObject($object);
	$url          = site_root."ux-admin/chart";
	$file         = 'addedit.php';
}
elseif(isset($_GET['add']))
{
	$chartSql  = "SELECT gcl.List_ID,gcl.List_Name,gcl.List_Value,gcl.List_TitleId,gct.Title_Name FROM GAME_CHART_LIST gcl LEFT JOIN GAME_CHART_TITLE gct ON gct.Title_ID=gcl.List_TitleId WHERE gcl.List_Status=0 ORDER BY `gcl`.`List_TitleId` ASC";
	$chartList = $functionsObj->ExecuteQuery($chartSql);
	// Add Siteuser
	$header    = 'Add Chart Sub-Component';
	$url       = site_root."ux-admin/chart";
	$file      = 'addedit.php';
}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id                  = base64_decode($_GET['del']);
	// echo $id; exit();
	$result              = $functionsObj->DeleteData('GAME_CHART','Chart_ID',$id,0);
	$_SESSION['msg']     = "Chart deleted successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/chart");
	exit(0);
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_CHART', array('Chart_ID='.$id), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);

	if($details->Chart_Status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_CHART', array('Chart_Status'=> 0), 'Chart_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_CHART', array('Chart_Status'=> 1), 'Chart_ID', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "Chart ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/chart");
		exit(0);
	}
	else
	{
		$msg     = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}
else
{
	// fetch siteuser list from db
	$sql = "SELECT
	C.*,
	(SELECT `Game_Name`  FROM  GAME_GAME WHERE  `Game_ID` = C.Chart_GameID) as Game,
	(SELECT `Scen_Name`  FROM  GAME_SCENARIO WHERE  `Scen_ID` = C.`Chart_ScenarioID`) as Scenario
	FROM `GAME_CHART`as C where C.Chart_Type_Status=0";
	$object = $functionsObj->ExecuteQuery($sql);
	$file   = 'list.php';
}
// Fetch Services list
$game = $functionsObj->SelectData(array(),'GAME_GAME',array('Game_Delete=0'),'', 'Game_Name','','', 0);
// if in edit mode and contain the chart id
if(isset($_GET['edit']))
{
	$sqlscen = "SELECT s.Scen_ID,s.Scen_Name, Link_ID  
	FROM `GAME_LINKAGE` INNER JOIN GAME_SCENARIO s ON Link_ScenarioID=s.Scen_ID
	WHERE Link_GameID=".$chartdetails->Chart_GameID;
	$scenario = $functionsObj->ExecuteQuery($sqlscen);

	$sqlArea = "SELECT DISTINCT gls.SubLink_AreaID AS Area_ID, gls.SubLink_AreaName AS Area_Name FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID=(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$chartdetails->Chart_GameID." AND Link_ScenarioID=".$chartdetails->Chart_ScenarioID.") ORDER BY Area_Name";	
	$area = $functionsObj->ExecuteQuery($sqlArea);

	$sqlcomp = "SELECT DISTINCT c.Comp_ID, c.Comp_Name, a.Area_Name
	FROM `GAME_LINKAGE_SUB` ls INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID
	INNER JOIN GAME_AREA a ON ls.SubLink_AreaID=a.Area_ID
	WHERE SubLink_LinkID=(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$chartdetails->Chart_GameID." AND Link_ScenarioID=".$chartdetails->Chart_ScenarioID.")	ORDER BY c.Comp_Name";	
	$component = $functionsObj->ExecuteQuery($sqlcomp);

	$sqlcomp = "SELECT DISTINCT s.SubComp_ID, c.Comp_Name, s.SubComp_Name, a.Area_Name
	FROM `GAME_LINKAGE_SUB` ls INNER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID
	INNER JOIN GAME_AREA a ON ls.SubLink_AreaID=a.Area_ID
	INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID
	WHERE SubLink_LinkID=(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID=".$chartdetails->Chart_GameID." AND Link_ScenarioID=".$chartdetails->Chart_ScenarioID.") ORDER BY s.SubComp_Name";	
	$subcomponent = $functionsObj->ExecuteQuery($sqlcomp);
}
else
{
	$scenario     = $functionsObj->SelectData(array(),'GAME_SCENARIO',array('Scen_Delete=0'),'', 'Scen_Name','','', 0);
	$component    = $functionsObj->SelectData(array(),'GAME_COMPONENT',array('Comp_Delete=0'),'Comp_Name', '','','', 0);
	$subcomponent = $functionsObj->SelectData(array(),'GAME_SUBCOMPONENT',array('SubComp_Delete=0'),'SubComp_Name', '','','', 0);
	$area         = $functionsObj->SelectData(array(),'GAME_AREA',array('Area_Delete=0'),'', 'Area_Name','','', 0);
}
// $formula      = $functionsObj->SelectData(array(),'GAME_FORMULAS', array(), 'formula_title', '', '', '', 0);
// echo "<pre>"; print_r($component); exit();
include_once doc_root.'ux-admin/view/Chart/'.$file;