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

if(isset($_POST['submit']) && $_POST['submit'] == 'Add')
{
	// echo "<pre>"; print_r($_SESSION['ux-admin-id']); print_r($_POST); exit();
	$VALUES    = array();
	$count     = count($_POST['List_TitleId']);
	$insertSql = "INSERT INTO GAME_CHART_LIST (`List_Name`,`List_Value`,`List_TitleId`,`List_CreatedBy`,`List_CreatedOn`) VALUES ";

	for($i=0; $i<$count; $i++)
	{
		$checkExist = "SELECT * FROM GAME_CHART_LIST WHERE List_TitleId=".$_POST['List_TitleId'][$i]." AND List_Value='".$_POST['List_Value'][$i]."'";
		$resObj = $functionsObj->ExecuteQuery($checkExist);
		if($resObj->num_rows < 1)
		{
			$VALUES[] = "('".trim($_POST['List_Name'][$i])."','".trim($_POST['List_Value'][$i])."','".$_POST['List_TitleId'][$i]."','".$_SESSION['ux-admin-id']."','".date('Y-m-d H:i:s')."')";
		}
	}

	$insertSql .= implode(',',$VALUES);
	
	if( count($VALUES) >0 )
	{
		$result = $functionsObj->ExecuteQuery($insertSql);
		// print_r($result); exit();
		if($result)
		{
			$_SESSION['msg']     = "Chart details added successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/addChartDetails");
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
	$chartdetails = (object) array(
		'List_Name'      =>	$_POST['List_Name'],
		'List_Value'     =>	$_POST['List_Value'],
		'List_TitleId'   =>	$_POST['List_TitleId'],
		'List_UpdatedOn' =>	date('Y-m-d H:i:s'),
		'List_UpdatedBy' =>	$_SESSION['ux-admin-id'],
	);

	if( !empty($_POST['List_Name']) && !empty($_POST['List_Value']) && !empty($_POST['List_TitleId']) )
	{
		$linkid = $_GET['edit'];
		$result = $functionsObj->UpdateData('GAME_CHART_LIST', $chartdetails, 'List_ID', $linkid, 0);
		if($result === true)
		{
			$_SESSION['msg']     = "Chart details updated successfully";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/addChartDetails");
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
	$titleObj  = $functionsObj->SelectData(array(), 'GAME_CHART_TITLE', array('Title_Status=0'), 'Title_Name', '', '', '', 0);
	$header    = 'Edit Chart List';
	$List_ID   = $_GET['edit'];
	$where     = "List_ID=$List_ID AND List_Status=0";
	$chartObj  = $functionsObj->SelectData(array(), 'GAME_CHART_LIST', $where, '', '', '', '', 0);
	$chartData = $functionsObj->FetchObject($chartObj);
	$url       = site_root."ux-admin/addChartDetails";
	$file      = 'addedit.php';
}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$titleObj  = $functionsObj->SelectData(array(), 'GAME_CHART_TITLE', array('Title_Status=0'), 'Title_Name', '', '', '', 0);
	$header    = 'Add Chart List';
	$url       = site_root."ux-admin/addChartDetails";
	$file      = 'addedit.php';
}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id                  = base64_decode($_GET['del']);
	// echo $id; exit();
	$result              = $functionsObj->Update('GAME_CHART_LIST',array('List_Status'=>1),'List_ID='.$id,0);
	$_SESSION['msg']     = "Chart deleted successfully";
	$_SESSION['type[0]'] = "inputSuccess";
	$_SESSION['type[1]'] = "has-success";
	header("Location: ".site_root."ux-admin/addChartDetails");
	exit(0);
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_CHART_LIST', array('List_ID='.$id), '', '', '', '', 0);
	$details = $functionsObj->FetchObject($object);

	if($details->List_Status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_CHART_LIST', array('List_Status'=> 0), 'List_ID', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_CHART_LIST', array('List_Status'=> 1), 'List_ID', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "Chart ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/addChartDetails");
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
	$sql    = "SELECT gcl.*,gct.Title_Name FROM GAME_CHART_LIST gcl LEFT JOIN GAME_CHART_TITLE gct ON gct.Title_ID=gcl.List_TitleId WHERE gcl.List_Status=0";
	$object = $functionsObj->ExecuteQuery($sql);
	$file   = 'list.php';
}

// Fetch Services list

$area         = $functionsObj->SelectData(array(), 'GAME_AREA', array('Area_Delete=0'), 'Area_Name', '', '', '', 0);
$game         = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), 'Game_Name', '', '', '', 0);
$scenario     = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), 'Scen_Name', '', '', '', 0);
$component    = $functionsObj->SelectData(array(), 'GAME_COMPONENT', array('Comp_Delete=0'), 'Comp_Name', '', '', '', 0);
$subcomponent = $functionsObj->SelectData(array(), 'GAME_SUBCOMPONENT', array('SubComp_Delete=0'),'SubComp_Name','','','',0);
$formula      = $functionsObj->SelectData(array(), 'GAME_FORMULAS', array(), 'formula_title', '', '', '', 0);
include_once doc_root.'ux-admin/view/chartDetails/'.$file;