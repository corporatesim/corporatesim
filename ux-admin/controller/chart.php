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

	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['chartType']) )
	{
		$result = $functionsObj->InsertData('GAME_CHART', $chartdetails, 0, 0);
		if($result)
		{
			$_SESSION['msg']     = "Link created successfully";
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

	if( !empty($_POST['game_id']) && !empty($_POST['scen_id']) && !empty($_POST['chartType']) )
	{
		$linkid = $_GET['edit'];
		$result = $functionsObj->UpdateData('GAME_CHART', $chartdetails, 'Chart_ID', $linkid, 0);
		if($result === true)
		{
			$_SESSION['msg']     = "Link updated successfully";
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
}
// Edit Siteuser
if(isset($_GET['edit']))
{
	$header       = 'Edit Chart Sub-Component';
	$uid          = $_GET['edit'];
	$object       = $functionsObj->SelectData(array(), 'GAME_CHART', array('Chart_ID='.$uid), '', '', '', '', 0);
	$chartdetails = $functionsObj->FetchObject($object);
	$url          = site_root."ux-admin/chart";
	$file         = 'addedit.php';
}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$header = 'Add Chart Sub-Component';
	$url    = site_root."ux-admin/chart";
	$file   = 'addedit.php';
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
$area         = $functionsObj->SelectData(array(),'GAME_AREA',array('Area_Delete=0'),'', '','','', 0);
$game         = $functionsObj->SelectData(array(),'GAME_GAME',array('Game_Delete=0'),'', '','','', 0);
$scenario     = $functionsObj->SelectData(array(),'GAME_SCENARIO',array('Scen_Delete=0'),'', '','','', 0);
$component    = $functionsObj->SelectData(array(),'GAME_COMPONENT',array('Comp_Delete=0'),'Comp_Name', '','','', 0);
$subcomponent = $functionsObj->SelectData(array(),'GAME_SUBCOMPONENT',array('SubComp_Delete=0'),'SubComp_Name', '','','', 0);
$formula      = $functionsObj->SelectData(array(),'GAME_FORMULAS', array(), 'formula_title', '', '', '', 0);

include_once doc_root.'ux-admin/view/Chart/'.$file;