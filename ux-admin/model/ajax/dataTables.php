<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';


$funObj = new Model(); // Create Object

// print_r($_POST);

// to get the site user list via ajax
if($_POST['action'] == 'siteusers')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
		$colName = 'User_id';
		break;

		case 2:
		$colName = 'User_fname';
		break;

		case 4:
		$colName = 'User_email';
		break;

		case 7:
		$colName = 'User_datetime';
		break;
		
		default:
		$colName   = 'User_id';
		$direction = 'desc';
		break;
	}

	$siteusersSql = "SELECT  u.User_id, u.User_fname, u.User_lname, u.User_Role, u.User_email, u.User_mobile, u.User_datetime, u.User_status, u.User_gameStatus, ua.Auth_password as pwd, (SELECT count(*) FROM GAME_USERGAMES WHERE UG_UserID = u.User_id) as gamecount,ge.Enterprise_Name,gs.SubEnterprise_Name FROM `GAME_SITE_USERS` u INNER JOIN GAME_USER_AUTHENTICATION ua on u.User_id=ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=u.User_ParentId LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_ID=u.User_SubParentId WHERE User_Delete = 0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($siteusersSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$siteusersSql .= " AND (User_fname LIKE '%".$search."%' OR User_lname LIKE '%".$search."%' OR User_email LIKE '%".$search."%' OR Enterprise_Name LIKE '%".$search."%' OR SubEnterprise_Name LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($siteusersSql);
	$filterCount    = $filterCountObj->num_rows;

	$siteusersSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$userDataObj = $funObj->ExecuteQuery($siteusersSql);

	while($siteusersDataRow = mysqli_fetch_object($userDataObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		// for user type
		if($siteusersDataRow->User_Role == 2)
		{ 
			$type = "<code>SubEnterpriseUser</code><br><b>Ent-</b> ".$siteusersDataRow->Enterprise_Name."<br><b>SubEnt-</b> ".$siteusersDataRow->SubEnterprise_Name;
		} 
		elseif ($siteusersDataRow->User_Role == 1)
		{
			$type = "<code>EnterpriseUser</code><br><b>Ent-</b> ".$siteusersDataRow->Enterprise_Name;
		} 
		else
		{
			$type = "HumanLinks User";
		}

		$gamecount = "<a href='".site_root."ux-admin/addUserGame/edit/".base64_encode($siteusersDataRow->User_id)."'>".$siteusersDataRow->gamecount."</a> ";

		// for user status
		if($siteusersDataRow->User_status == 1)
		{
			$edit .= '<a href="javascript:void(0);" class="cs_btn" id="'.$siteusersDataRow->User_id.'" data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a> ';
		}
		else
		{
			$edit .= '<a href="javascript:void(0);" class="cs_btn" id="'.$siteusersDataRow->User_id.'" data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a> ';
		}

		$edit .= '<a href="'.site_root."ux-admin/siteusers/edit/".base64_encode($siteusersDataRow->User_id).'" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> <a href="javascript:void(0);" class="dl_btn" id="'.$siteusersDataRow->User_id.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a> ';

		// for user replay and blok games
		$statusSql = "SELECT Game_Name FROM GAME_USERSTATUS LEFT JOIN GAME_GAME ON Game_ID=US_GameID WHERE US_UserID=$siteusersDataRow->User_id AND US_ReplayStatus=1";

		$resObject = $funObj->ExecuteQuery($statusSql);
		$count     = $resObject->num_rows;
		if($resObject->num_rows > 0) { 
			$gameName = [];
			while($nameGame = $resObject->fetch_object())
			{
				$gameName[] = $nameGame->Game_Name;
			}
			if(count($gameName) > 1)
			{
				$userGames = implode(', ',$gameName);
				$title     = 'Replay allowed for '.$userGames.' games';
			}
			else
			{
				$userGames = $gameName[0];
				$title     = 'Replay allowed only for '.$userGames;
			}
			$edit .= '<a href="javascript:void(0)" data-toggle="tooltip" data-toggle="tooltip" title="'.$title.'" id="replay_'.$siteusersDataRow->User_id.'"><span class="glyphicon glyphicon-refresh"></span></a> ';
		}

		if($siteusersDataRow->User_gameStatus == 1)
		{
			$edit .= '<a href="javascript:void(0)" data-toggle="tooltip" title="Disabled" id="disable_'.$siteusersDataRow->User_id.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';
		}

		$data[] = array($i, $siteusersDataRow->User_id, $siteusersDataRow->User_fname.' '.$siteusersDataRow->User_lname, $type, $siteusersDataRow->User_email, $siteusersDataRow->pwd, $siteusersDataRow->User_mobile, date('d-m-Y', strtotime($siteusersDataRow->User_datetime)), $gamecount, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);
}


// to get the all area list via ajax
if($_POST['action'] == 'manageArea')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
		$colName = 'Area_Name';
		break;

		case 2:
		$colName = 'Area_BackgroundColor';
		break;

		case 3:
		$colName = 'Area_TextColor';
		break;
		
		default:
		$colName   = 'Area_CreateDate';
		$direction = 'DESC';
		break;
	}

	$gameAreaSql = "SELECT * FROM GAME_AREA ga WHERE ga.Area_Delete=0";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($gameAreaSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$gameAreaSql .= " AND Area_Name LIKE '%".$search."%' ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($gameAreaSql);
	$filterCount    = $filterCountObj->num_rows;

	$gameAreaSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$areaDataObj = $funObj->ExecuteQuery($gameAreaSql);

	while($areaDataObjRow = mysqli_fetch_object($areaDataObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if($funObj->checkModuleAuth('area','edit'))
		{
			$edit .= '<a href="'.site_root."ux-admin/ManageArea/Edit/".base64_encode($areaDataObjRow->Area_ID).'" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if($funObj->checkModuleAuth('area','delete'))
		{
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="'.$areaDataObjRow->Area_ID.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}
		$Area_BackgroundColor = '<input type="color" value="'.$areaDataObjRow->Area_BackgroundColor.'" disabled>';
		$Area_TextColor       = '<input type="color" value="'.$areaDataObjRow->Area_TextColor.'" disabled>';
		$data[] = array($i, $areaDataObjRow->Area_Name, $Area_BackgroundColor, $Area_TextColor, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);

}

// to get the all component list via ajax
if($_POST['action'] == 'ManageComponent')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
		$colName = 'Comp_ID';
		break;

		case 1:
		$colName = 'Area_Name';
		break;

		case 2:
		$colName = 'Comp_Name';
		break;

		case 3:
		$colName = 'Comp_NameAlias';
		break;
		
		default:
		$colName   = 'Comp_date';
		$direction = 'DESC';
		break;
	}

	$compSql = "SELECT gc.Comp_ID, ga.Area_Name, gc.Comp_Name, gc.Comp_NameAlias, gc.Comp_date FROM GAME_COMPONENT gc LEFT JOIN GAME_AREA ga ON ga.Area_ID = gc.Comp_AreaID WHERE gc.Comp_Delete=0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($compSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$compSql .= " AND (Area_Name LIKE '%".$search."%' OR Comp_Name LIKE '%".$search."%' OR Comp_NameAlias LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($compSql);
	$filterCount    = $filterCountObj->num_rows;

	$compSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$compSqlObj = $funObj->ExecuteQuery($compSql);

	while($compSqlObjRow = mysqli_fetch_object($compSqlObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if($funObj->checkModuleAuth('component','edit'))
		{
			$edit .= '<a href="'.site_root."ux-admin/ManageComponent/edit/".base64_encode($compSqlObjRow->Comp_ID).'" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if($funObj->checkModuleAuth('component','delete'))
		{
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="'.$compSqlObjRow->Comp_ID.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}		

		$data[] = array($i, $compSqlObjRow->Area_Name, $compSqlObjRow->Comp_Name, $compSqlObjRow->Comp_NameAlias, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);

}


// to get the all sub-component list via ajax
if($_POST['action'] == 'ManageSubComponent')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
		$colName = 'SubComp_ID';
		break;

		case 1:
		$colName = 'Area_Name';
		break;

		case 2:
		$colName = 'Comp_Name';
		break;

		case 3:
		$colName = 'SubComp_Name';
		break;

		case 4:
		$colName = 'SubComp_NameAlias';
		break;
		
		default:
		$colName   = 'SubComp_Date';
		$direction = 'DESC';
		break;
	}

	$subCompSql = "SELECT gs.SubComp_ID, ga.Area_Name, gc.Comp_Name, gs.SubComp_Name, gs.SubComp_NameAlias FROM GAME_SUBCOMPONENT gs LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gs.SubComp_CompID LEFT JOIN GAME_AREA ga ON ga.Area_ID = gc.Comp_AreaID WHERE gs.SubComp_Delete = 0";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($subCompSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$subCompSql .= " AND (Area_Name LIKE '%".$search."%' OR Comp_Name LIKE '%".$search."%' OR SubComp_Name LIKE '%".$search."%' OR SubComp_NameAlias LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($subCompSql);
	$filterCount    = $filterCountObj->num_rows;

	$subCompSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$subCompObj = $funObj->ExecuteQuery($subCompSql);
	// print_r($_POST); echo $subCompSql; exit();
	while($subCompRow = mysqli_fetch_object($subCompObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if($funObj->checkModuleAuth('sub component','edit'))
		{
			$edit .= '<a href="'.site_root."ux-admin/ManageSubComponent/Edit/".base64_encode($subCompRow->SubComp_ID).'" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if($funObj->checkModuleAuth('sub component','delete'))
		{
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="'.$subCompRow->SubComp_ID.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}		

		$data[] = array($i, $subCompRow->Area_Name, $subCompRow->Comp_Name, $subCompRow->SubComp_Name, $subCompRow->SubComp_NameAlias, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);
}


// to get the all ScenarioBranching list via ajax
if($_POST['action'] == 'ScenarioBranching')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
		$colName = 'Branch_Id';
		break;

		case 1:
		$colName = 'Game_Name';
		break;

		case 2:
		$colName = 'Scen_Name';
		break;

		case 3:
		$colName = 'Comp_Name';
		break;

		case 4:
		$colName = 'Branch_MinVal';
		break;

		case 5:
		$colName = 'Branch_MaxVal';
		break;

		case 6:
		$colName = 'Branch_Order';
		break;

		case 7:
		$colName = 'NextSceneName';
		break;
		
		default:
		$colName   = 'Branch_CreatedOn';
		$direction = 'DESC';
		break;
	}

	$scenBranchingSql = "SELECT gb.*, gg.Game_Name, gc.Scen_Name, gcn.Scen_Name AS NextSceneName, gcomp.Comp_Name FROM GAME_BRANCHING_SCENARIO gb LEFT JOIN GAME_GAME gg ON gg.Game_ID = gb.Branch_GameId LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID = gb.Branch_ScenId LEFT JOIN GAME_COMPONENT gcomp ON gcomp.Comp_ID = gb.Branch_CompId LEFT JOIN GAME_SCENARIO gcn ON gcn.Scen_ID = gb.Branch_NextScen WHERE Branch_IsActive = 0";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($scenBranchingSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$scenBranchingSql .= " AND (gg.Game_Name LIKE '%".$search."%' OR gc.Scen_Name LIKE '%".$search."%' OR Comp_Name LIKE '%".$search."%' OR gcn.Scen_Name LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($scenBranchingSql);
	$filterCount    = $filterCountObj->num_rows;

	$scenBranchingSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$scenBranchingObj = $funObj->ExecuteQuery($scenBranchingSql);

	while($scenBranchingObjRow = mysqli_fetch_object($scenBranchingObj))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if($funObj->checkModuleAuth('ScenarioBranching','edit'))
		{
			$edit .= '<a href="'.site_root."ux-admin/ScenarioBranching/edit/".$scenBranchingObjRow->Branch_Id.'" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if($funObj->checkModuleAuth('ScenarioBranching','delete'))
		{
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="'.$scenBranchingObjRow->Branch_Id.'" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>&nbsp;';
		}

		if($scenBranchingObjRow->Branch_IsEndScenario == 1)
		{
			$edit .= '<a href="javascript:void(0);" data-toggle="tooltip" title="End Scenario"><span class="fa fa-ban"></span></a>';
		}

		$data[] = array($i, $scenBranchingObjRow->Game_Name, $scenBranchingObjRow->Scen_Name, $scenBranchingObjRow->Comp_Name, $scenBranchingObjRow->Branch_MinVal, $scenBranchingObjRow->Branch_MaxVal, $scenBranchingObjRow->Branch_Order, $scenBranchingObjRow->NextSceneName, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);

}

// to get the all Dashboard-Game_data list via ajax
if($_POST['action'] == 'Dashboard')
{
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = $_POST['search']['value'];
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
		$colName = 'Game_ID';
		break;

		case 2:
		$colName = 'Game_Name';
		break;

		case 3:
		$colName = 'Game_eLearning';
		break;

		case 4:
		$colName = 'Creator';
		break;

		case 5:
		$colName = 'Created_On';
		break;

		case 6:
		$colName = 'Game_Status';
		break;

		case 7:
		$colName = 'Game_UpdatedOn';
		break;

		case 8:
		$colName = 'Time_Taken';
		break;
		
		default:
		$colName   = 'Created_On';
		$direction = 'DESC';
		break;
	}

	$dashboardDataSql = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_CreatedBy, CONCAT(gau.fname, ' ', gau.lname) AS Creator, gg.Game_Datetime AS Created_On, IF( gg.Game_Elearning > 0, 'eLearning', 'Game' ) AS Game_eLearning, IF( gg.Game_Type > 0, 'Bot', 'Game' ) AS Game_Type, IF( gg.Game_Complete > 0, 'Complete', 'In-Progress' ) AS Game_Status, gg.Game_UpdatedBy, CONCAT(ga.fname,' ',ga.lname) AS Completed_By, gg.Game_UpdatedOn, IF( gg.Game_Complete > 0, DATEDIFF( gg.Game_UpdatedOn, gg.Game_Datetime ), DATEDIFF( NOW(), gg.Game_Datetime ) ) AS Time_Taken, gau.email, gg.Game_Associates AS Associates FROM GAME_GAME gg LEFT JOIN GAME_ADMINUSERS gau ON gau.id = gg.Game_CreatedBy LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gg.Game_UpdatedBy WHERE gg.Game_Delete = 0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($dashboardDataSql);
	$totalCount   = $countAllData->num_rows;

	if(!empty($search))
	{
		$dashboardDataSql .= " AND (gg.Game_Name LIKE '%".$search."%' OR gau.fname LIKE '%".$search."%' OR gau.lname LIKE '%".$search."%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($dashboardDataSql);
	$filterCount    = $filterCountObj->num_rows;

	$dashboardDataSql .= " ORDER BY ".$colName." ".$direction." LIMIT ".$start.",".$length;
	
	$dashboardData = $funObj->ExecuteQuery($dashboardDataSql);

	while($dashboardDataRow = mysqli_fetch_object($dashboardData))
	{
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if(($_SESSION['ux-admin-id'] == $dashboardDataRow->Associates) || ($_SESSION['ux-admin-id'] == $dashboardDataRow->Game_CreatedBy) || ($_SESSION['ux-admin-id'] == 1) ) {
			// <!-- if user has access or created the game then only show comments -->
			$edit .= '<a href="javascript:void(0);" class="comments" id="'.base64_encode($dashboardDataRow->Game_ID).'" data-toggle="tooltip" title="Comments" data-gamename="'.$dashboardDataRow->Game_Name.'" data-notification="'.$dashboardDataRow->Game_CreatedBy.', '.$dashboardDataRow->Associates.'"> <i class="fa fa-eye"></i> </a>';
		}
		else
		{
			// <!-- if user is neither Associates nor creator then don't show the view/add/edit/delete comments option -->
			$edit .= '<a href="javascript:void(0);" class="comments" data-toggle="tooltip" title="Comments"><i class="fa fa-eye"></i></a>';
		}

		if($dashboardDataRow->Game_Status == 'Complete')
		{
			$status = "<span class='alert-success'>".$dashboardDataRow->Game_Status."<br></span><b>".$dashboardDataRow->Completed_By."</b>";
		}
		else
		{
			$status = "<span class='alert-danger'>".$dashboardDataRow->Game_Status."</span>";
		}

		$data[] = array($i, $dashboardDataRow->Game_ID, $dashboardDataRow->Game_Name, $dashboardDataRow->Game_eLearning.'<b>:-</b> '.$dashboardDataRow->Game_Type, $dashboardDataRow->Creator, $dashboardDataRow->Created_On, $status, $dashboardDataRow->Game_UpdatedOn, ($dashboardDataRow->Time_Taken < 8)?$dashboardDataRow->Time_Taken.' Days':'<span class="alert-danger">'.$dashboardDataRow->Time_Taken.' Days</span>', $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);

}