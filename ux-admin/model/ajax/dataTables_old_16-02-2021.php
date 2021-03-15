<?php
include_once '../../../config/settings.php';
require_once doc_root . 'ux-admin/model/model.php';


$funObj = new Model(); // Create Object

// print_r($_POST);

// to get the site user list via ajax
if ($_POST['action'] == 'siteusers') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
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

	if (!empty($search)) {
		$siteusersSql .= " AND (User_fname LIKE '%" . $search . "%' OR User_lname LIKE '%" . $search . "%' OR User_email LIKE '%" . $search . "%' OR Enterprise_Name LIKE '%" . $search . "%' OR SubEnterprise_Name LIKE '%" . $search . "%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($siteusersSql);
	$filterCount    = $filterCountObj->num_rows;

	$siteusersSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$userDataObj = $funObj->ExecuteQuery($siteusersSql);

	while ($siteusersDataRow = mysqli_fetch_object($userDataObj)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		// for user type
		if ($siteusersDataRow->User_Role == 2) {
			$type = "<code>SubEnterpriseUser</code><br><b>Ent-</b> " . $siteusersDataRow->Enterprise_Name . "<br><b>SubEnt-</b> " . $siteusersDataRow->SubEnterprise_Name;
		} elseif ($siteusersDataRow->User_Role == 1) {
			$type = "<code>EnterpriseUser</code><br><b>Ent-</b> " . $siteusersDataRow->Enterprise_Name;
		} else {
			$type = "HumanLinks User";
		}

		$gamecount = "<a href='" . site_root . "ux-admin/addUserGame/edit/" . base64_encode($siteusersDataRow->User_id) . "'>" . $siteusersDataRow->gamecount . "</a> ";

		// for user status
		if ($siteusersDataRow->User_status == 1) {
			$edit .= '<a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $siteusersDataRow->User_id . '" data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a> ';
		} else {
			$edit .= '<a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $siteusersDataRow->User_id . '" data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a> ';
		}

		$edit .= '<a href="' . site_root . "ux-admin/siteusers/edit/" . base64_encode($siteusersDataRow->User_id) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> <a href="javascript:void(0);" class="dl_btn" id="' . $siteusersDataRow->User_id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a> ';

		// for user replay and blok games
		$statusSql = "SELECT Game_Name FROM GAME_USERSTATUS LEFT JOIN GAME_GAME ON Game_ID=US_GameID WHERE US_UserID=$siteusersDataRow->User_id AND US_ReplayStatus=1";

		$resObject = $funObj->ExecuteQuery($statusSql);
		$count     = $resObject->num_rows;
		if ($resObject->num_rows > 0) {
			$gameName = [];
			while ($nameGame = $resObject->fetch_object()) {
				$gameName[] = $nameGame->Game_Name;
			}
			if (count($gameName) > 1) {
				$userGames = implode(', ', $gameName);
				$title     = 'Replay allowed for ' . $userGames . ' games';
			} else {
				$userGames = $gameName[0];
				$title     = 'Replay allowed only for ' . $userGames;
			}
			$edit .= '<a href="javascript:void(0)" data-toggle="tooltip" data-toggle="tooltip" title="' . $title . '" id="replay_' . $siteusersDataRow->User_id . '"><span class="glyphicon glyphicon-refresh"></span></a> ';
		}

		if ($siteusersDataRow->User_gameStatus == 1) {
			$edit .= '<a href="javascript:void(0)" data-toggle="tooltip" title="Disabled" id="disable_' . $siteusersDataRow->User_id . '"><span class="glyphicon glyphicon-ban-circle"></span></a>';
		}

		$data[] = array($i, $siteusersDataRow->User_id, $siteusersDataRow->User_fname . ' ' . $siteusersDataRow->User_lname, $type, $siteusersDataRow->User_email, $siteusersDataRow->pwd, $siteusersDataRow->User_mobile, date('d-m-Y', strtotime($siteusersDataRow->User_datetime)), $gamecount, $edit);
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
if ($_POST['action'] == 'manageArea') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
			$colName = 'Area_ID';
			break;

		case 2:
			$colName = 'Area_Name';
			break;

		case 3:
			$colName = 'Area_BackgroundColor';
			break;

		case 4:
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

	if (!empty($search)) {
		$gameAreaSql .= " AND Area_Name LIKE '%" . $search . "%' ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($gameAreaSql);
	$filterCount    = $filterCountObj->num_rows;

	$gameAreaSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$areaDataObj = $funObj->ExecuteQuery($gameAreaSql);

	while ($areaDataObjRow = mysqli_fetch_object($areaDataObj)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('area', 'edit')) {
			$edit .= '<a href="' . site_root . "ux-admin/ManageArea/Edit/" . base64_encode($areaDataObjRow->Area_ID) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if ($funObj->checkModuleAuth('area', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="' . $areaDataObjRow->Area_ID . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}
		$Area_BackgroundColor = '<input type="color" value="' . $areaDataObjRow->Area_BackgroundColor . '" disabled>';
		$Area_TextColor       = '<input type="color" value="' . $areaDataObjRow->Area_TextColor . '" disabled>';
		$data[] = array($i, $areaDataObjRow->Area_ID, $areaDataObjRow->Area_Name, $Area_BackgroundColor, $Area_TextColor, $edit);
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
if ($_POST['action'] == 'ManageComponent') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
			$colName = 'Area_ID';
			break;

		case 2:
			$colName = 'Area_Name';
			break;

		case 3:
			$colName = 'Comp_ID';
			break;

		case 4:
			$colName = 'Comp_Name';
			break;

		case 5:
			$colName = 'Comp_NameAlias';
			break;

		default:
			$colName   = 'Comp_date';
			$direction = 'DESC';
			break;
	}

	$compSql = "SELECT ga.Area_ID, ga.Area_Name, gc.Comp_ID, gc.Comp_Name, gc.Comp_NameAlias, gc.Comp_date FROM GAME_COMPONENT gc LEFT JOIN GAME_AREA ga ON ga.Area_ID = gc.Comp_AreaID WHERE gc.Comp_Delete=0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($compSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$compSql .= " AND (Area_Name LIKE '%" . $search . "%' OR Comp_Name LIKE '%" . $search . "%' OR Comp_NameAlias LIKE '%" . $search . "%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($compSql);
	$filterCount    = $filterCountObj->num_rows;

	$compSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$compSqlObj = $funObj->ExecuteQuery($compSql);

	while ($compSqlObjRow = mysqli_fetch_object($compSqlObj)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('component', 'edit')) {
			$edit .= '<a href="' . site_root . "ux-admin/ManageComponent/edit/" . base64_encode($compSqlObjRow->Comp_ID) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if ($funObj->checkModuleAuth('component', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="' . $compSqlObjRow->Comp_ID . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}

		$data[] = array($i, $compSqlObjRow->Area_ID, $compSqlObjRow->Area_Name, $compSqlObjRow->Comp_ID, $compSqlObjRow->Comp_Name, $compSqlObjRow->Comp_NameAlias, $edit);
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
if ($_POST['action'] == 'ManageSubComponent') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 1:
			$colName = 'Area_ID';
			break;

		case 2:
			$colName = 'Area_Name';
			break;

		case 3:
			$colName = 'Comp_ID';
			break;

		case 4:
			$colName = 'Comp_Name';
			break;

		case 5:
			$colName = 'SubComp_ID';
			break;

		case 6:
			$colName = 'SubComp_Name';
			break;

		case 7:
			$colName = 'SubComp_NameAlias';
			break;

		default:
			$colName   = 'SubComp_Date';
			$direction = 'DESC';
			break;
	}

	$subCompSql = "SELECT ga.Area_ID, ga.Area_Name, gc.Comp_ID, gc.Comp_Name, gc.Comp_NameAlias, gs.SubComp_ID, gs.SubComp_Name, gs.SubComp_NameAlias FROM GAME_SUBCOMPONENT gs LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gs.SubComp_CompID LEFT JOIN GAME_AREA ga ON ga.Area_ID = gc.Comp_AreaID WHERE gs.SubComp_Delete = 0";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($subCompSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$subCompSql .= " AND (Area_Name LIKE '%" . $search . "%' OR Comp_Name LIKE '%" . $search . "%' OR Comp_NameAlias LIKE '%" . $search . "%' OR SubComp_Name LIKE '%" . $search . "%' OR SubComp_NameAlias LIKE '%" . $search . "%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($subCompSql);
	$filterCount    = $filterCountObj->num_rows;

	$subCompSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$subCompObj = $funObj->ExecuteQuery($subCompSql);
	// print_r($_POST); echo $subCompSql; exit();
	while ($subCompRow = mysqli_fetch_object($subCompObj)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('sub component', 'edit')) {
			$edit .= '<a href="' . site_root . "ux-admin/ManageSubComponent/Edit/" . base64_encode($subCompRow->SubComp_ID) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if ($funObj->checkModuleAuth('sub component', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="' . $subCompRow->SubComp_ID . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}

		$data[] = array($i, $subCompRow->Area_ID, $subCompRow->Area_Name, $subCompRow->Comp_ID, $subCompRow->Comp_Name . ' / ' . $subCompRow->Comp_NameAlias, $subCompRow->SubComp_ID, $subCompRow->SubComp_Name, $subCompRow->SubComp_NameAlias, $edit);
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
if ($_POST['action'] == 'ScenarioBranching') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
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

	if (!empty($search)) {
		$scenBranchingSql .= " AND (gg.Game_Name LIKE '%" . $search . "%' OR gc.Scen_Name LIKE '%" . $search . "%' OR Comp_Name LIKE '%" . $search . "%' OR gcn.Scen_Name LIKE '%" . $search . "%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($scenBranchingSql);
	$filterCount    = $filterCountObj->num_rows;

	$scenBranchingSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$scenBranchingObj = $funObj->ExecuteQuery($scenBranchingSql);

	while ($scenBranchingObjRow = mysqli_fetch_object($scenBranchingObj)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('ScenarioBranching', 'edit')) {
			$edit .= '<a href="' . site_root . "ux-admin/ScenarioBranching/edit/" . $scenBranchingObjRow->Branch_Id . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>&nbsp;';
		}
		if ($funObj->checkModuleAuth('ScenarioBranching', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="dl_btn" id="' . $scenBranchingObjRow->Branch_Id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>&nbsp;';
		}

		if ($scenBranchingObjRow->Branch_IsEndScenario == 1) {
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
if ($_POST['action'] == 'Dashboard') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
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

	$dashboardDataSql = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Category, gg.Game_CreatedBy, CONCAT(gau.fname, ' ', gau.lname) AS Creator, gg.Game_Datetime AS Created_On, IF( gg.Game_Elearning > 0, 'eLearning', 'Game' ) AS Game_eLearning, IF( gg.Game_Type > 0, 'Bot', 'Game' ) AS Game_Type, IF( gg.Game_Complete > 0, 'Complete', 'In-Progress' ) AS Game_Status, gg.Game_UpdatedBy, CONCAT(ga.fname,' ',ga.lname) AS Completed_By, gg.Game_UpdatedOn, IF( gg.Game_Complete > 0, DATEDIFF( gg.Game_UpdatedOn, gg.Game_Datetime ), DATEDIFF( NOW(), gg.Game_Datetime ) ) AS Time_Taken, gau.email, gg.Game_Associates AS Associates FROM GAME_GAME gg LEFT JOIN GAME_ADMINUSERS gau ON gau.id = gg.Game_CreatedBy LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gg.Game_UpdatedBy WHERE gg.Game_Delete = 0 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($dashboardDataSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$dashboardDataSql .= " AND (gg.Game_Name LIKE '%" . $search . "%' OR gau.fname LIKE '%" . $search . "%' OR gau.lname LIKE '%" . $search . "%') ";
		$filterRecord = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($dashboardDataSql);
	$filterCount    = $filterCountObj->num_rows;

	$dashboardDataSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$dashboardData = $funObj->ExecuteQuery($dashboardDataSql);

	while ($dashboardDataRow = mysqli_fetch_object($dashboardData)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if (($_SESSION['ux-admin-id'] == $dashboardDataRow->Associates) || ($_SESSION['ux-admin-id'] == $dashboardDataRow->Game_CreatedBy) || ($_SESSION['ux-admin-id'] == 1)) {
			// <!-- if user has access or created the game then only show comments -->
			$edit .= '<a href="javascript:void(0);" class="comments" id="' . base64_encode($dashboardDataRow->Game_ID) . '" data-toggle="tooltip" title="Comments" data-gamename="' . $dashboardDataRow->Game_Name . '" data-notification="' . $dashboardDataRow->Game_CreatedBy . ', ' . $dashboardDataRow->Associates . '"> <i class="fa fa-eye"></i> </a>';
		} else {
			// <!-- if user is neither Associates nor creator then don't show the view/add/edit/delete comments option -->
			$edit .= '<a href="javascript:void(0);" class="comments" data-toggle="tooltip" title="Comments"><i class="fa fa-eye"></i></a>';
		}

		if ($dashboardDataRow->Game_Status == 'Complete') {
			$status = "<span class='alert-success'>" . $dashboardDataRow->Game_Status . "<br></span><b>" . $dashboardDataRow->Completed_By . "</b>";
		} else {
			$status = "<span class='alert-danger'>" . $dashboardDataRow->Game_Status . "</span>";
		}

		$data[] = array($i, $dashboardDataRow->Game_ID, $dashboardDataRow->Game_Name . '<br><code>' . $dashboardDataRow->Game_Category . '</code>', $dashboardDataRow->Game_eLearning . '<b>:-</b> ' . $dashboardDataRow->Game_Type, $dashboardDataRow->Creator, $dashboardDataRow->Created_On, $status, $dashboardDataRow->Game_UpdatedOn, ($dashboardDataRow->Time_Taken < 8) ? $dashboardDataRow->Time_Taken . ' Days' : '<span class="alert-danger">' . $dashboardDataRow->Time_Taken . ' Days</span>', $edit);
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

// to get the all leaderboard/collaboration list via ajax
if ($_POST['action'] == 'leaderboard') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'Lead_Id';
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
			$colName = 'Lead_BelongTo';
			break;

		case 5:
			$colName = 'Lead_Order';
			break;

		default:
			$colName   = 'Lead_CreatedBy';
			$direction = 'DESC';
			break;
	}

	$leaderboardSql = "SELECT gl.Lead_Id, IF( gl.Lead_Order, '<b>Descending</b>', 'Ascending' ) AS Lead_Order, gg.Game_Name, gs.Scen_Name, gc.Comp_Name, IF( gl.Lead_BelongTo, '<b>Collaboration</b>', 'Leaderboard' ) AS Type, gl.Lead_CreatedOn, CONCAT(gau.fname, ' ', gau.lname) AS creator, gl.Lead_CreatedOn FROM GAME_LEADERBOARD gl LEFT JOIN GAME_GAME gg ON gg.Game_ID = gl.Lead_GameId LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Lead_ScenId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId LEFT JOIN GAME_ADMINUSERS gau ON gau.id = gl.Lead_CreatedBy WHERE gl.Lead_Status = 0";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($leaderboardSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$leaderboardSql .= " AND Game_Name LIKE '%" . $search . "%' OR Scen_Name LIKE '%" . $search . "%' OR Comp_Name LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($leaderboardSql);
	$filterCount    = $filterCountObj->num_rows;

	$leaderboardSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$leaderboard = $funObj->ExecuteQuery($leaderboardSql);

	while ($leaderboardRow = mysqli_fetch_object($leaderboard)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('leaderboard', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="deleteLeaderCollab" id="' . $leaderboardRow->Lead_Id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		} else {
			$edit .= '<a href="javascript:void(0);" data-toggle="tooltip" title="Not allowed to delete"><span class="fa fa-eye"></span></a>';
		}

		$creator = date('d-m-Y H:i:s', strtotime($leaderboardRow->Lead_CreatedOn)) . '<br>' . $leaderboardRow->creator;
		$data[]  = array($i, $leaderboardRow->Game_Name, $leaderboardRow->Scen_Name, $leaderboardRow->Comp_Name, $leaderboardRow->Type, $leaderboardRow->Lead_Order, $creator, $edit);
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

// to get the data from database table, and show for js game mapping
if ($_POST['action'] == 'linkgame') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'Js_id';
			break;

		case 1:
			$colName = 'Js_Name';
			break;

		case 2:
			$colName = 'Game_Name';
			break;

		case 3:
			$colName = 'Scen_Name';
			break;

		case 4:
			$colName = 'Js_Element';
			break;

		case 5:
			$colName = 'Js_Alias';
			break;

		case 6:
			$colName = 'SubLink_CompName';
			break;

		default:
			$colName   = 'Js_id';
			$direction = 'ASC';
			break;
	}

	$jsGameSql = "SELECT gj.*, gg.Game_Name, gs.Scen_Name, gls.SubLink_CompName FROM GAME_JSGAME gj LEFT JOIN GAME_GAME gg ON gg.Game_ID = gj.Js_GameId LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gj.Js_ScenId LEFT JOIN GAME_LINKAGE_SUB gls ON gls.SubLink_ID=gj.Js_SublinkId WHERE gj.Js_id > 0 ";
	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($jsGameSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$jsGameSql .= " AND Game_Name LIKE '%" . $search . "%' OR Scen_Name LIKE '%" . $search . "%' OR Js_Name LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($jsGameSql);
	$filterCount    = $filterCountObj->num_rows;

	$jsGameSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$jsGame = $funObj->ExecuteQuery($jsGameSql);

	while ($jsGameRow = mysqli_fetch_object($jsGame)) {
		$i++;
		$edit = '';
		// checking for active and deactive status
		if ($jsGameRow->Js_Status == 1) {
			$edit .= '<a href="javascript:void(0);" onclick="return activeDeactive(' . $jsGameRow->Js_id . ',0)" id="deactive_' . $jsGameRow->Js_id . '" data-toggle="tooltip" title="Deactive"><span class="glyphicon glyphicon-remove"></span></a> ';
		} else {
			$edit .= '<a href="javascript:void(0);" onclick="return activeDeactive(' . $jsGameRow->Js_id . ',1)" id="active_' . $jsGameRow->Js_id . '" data-toggle="tooltip" title="Active"><span class="glyphicon glyphicon-ok"></span></a> ';
		}
		// checking for edit permission
		if ($funObj->checkModuleAuth('linkgame', 'edit')) {
			$editFormContent = '<form id="editFormData" action="" method="post"><input type="hidden" name="action" value="editJsGameData"> <input type="hidden" name="Js_id" value="' . $jsGameRow->Js_id . '"> <div class="form-row">';
			// startng of generating the html form to edit the form at user end
			$editFormContent .= "<div class='row col-md-12'> <div class='row col-md-4'><lable>JS Game Name</lable> <input class='form-control' type='text' value='" . $jsGameRow->Js_Name . "' readonly></div> <div class='row col-md-4'><lable>Element Name</lable> <input class='form-control' type='text' name='JS_Element' value='" . $jsGameRow->Js_Element . "'></div> <div class='row col-md-4'><lable>Element Alias</lable> <input class='form-control' type='text' name='Js_Alias' value='" . $jsGameRow->Js_Alias . "'></div> </div>";

			$editFormContent .= '</div> <div class="clearfix"></div><br><button type="submit" id="submitEditForm" onclick="return editGameIntegration(event);" class="btn btn-primary">Update</button> <button type="button" class="btn btn-danger" onclick="return swal.close();">Cancel</button></form>';
			// end of generating form

			$edit .= '<a href="javascript:void(0);" data-formdata="' . base64_encode($editFormContent) . '" onclick="return showEditGameIntegration(this)" id="edit' . $jsGameRow->Js_id . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a> ';
		} else {
			$edit .= '<a href="javascript:void(0);" data-toggle="tooltip" title="Not allowed to edit"><span class="fa fa-pencil"></span></a> ';
		}
		// checking for delete permission
		if ($funObj->checkModuleAuth('linkgame', 'delete')) {
			$edit .= '<a href="javascript:void(0);" onclick="return deleteGameIntegration(' . $jsGameRow->Js_id . ');" id="delete_' . $jsGameRow->Js_id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		} else {
			$edit .= '<a href="javascript:void(0);" data-toggle="tooltip" title="Not allowed to delete"><span class="fa fa-trash"></span></a>';
		}
		$scenName = "<a href='" . site_root . "ux-admin/ManageScenario/edit/" . base64_encode($jsGameRow->Js_ScenId) . "' target='_blank' title='" . $jsGameRow->Js_LinkId . "'>$jsGameRow->Scen_Name</a>";
		$compName = "<a href='" . site_root . "ux-admin/linkage/linkedit/" . $jsGameRow->Js_SublinkId . "' target='_blank'>$jsGameRow->SubLink_CompName</a>";
		$gameNameLink = "<a href='" . site_root . "ux-admin/ManageGame/edit/" . base64_encode($jsGameRow->Js_GameId) . "' target='_blank'>" . $jsGameRow->Game_Name . "</a>";
		$data[]  = array($i, $jsGameRow->Js_Name, $gameNameLink, $scenName, $jsGameRow->Js_Element, $jsGameRow->Js_Alias, $compName, $edit);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount;
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	// return the data to be displayed to user into and data array
	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);
}

// to get the all the linkage of game and scenarios list via ajax
if ($_POST['action'] == 'getlinkage') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'Link_ID';
			break;

		case 1:
			$colName = 'Game_Name';
			break;

		case 2:
			$colName = 'Scen_Name';
			break;

		case 3:
			$colName = 'Link_Order';
			break;

		case 4:
			$colName = 'Link_Introduction';
			break;

		case 5:
			$colName = 'Link_IntroductionLink';
			break;

		case 6:
			$colName = 'Link_Description';
			break;

		case 7:
			$colName = 'Link_DescriptionLink';
			break;

		case 8:
			$colName = 'Link_BackToIntro';
			break;

		case 9:
			$colName = 'Game_Complete';
			break;

		default:
			$colName   = 'Link_CreateDate';
			$direction = 'DESC';
			break;
	}

	$linkSql = "SELECT gl.*, gg.Game_ID, gg.Game_Name AS Game, gg.Game_Type AS BotEnabled, gg.Game_Complete, gs.Scen_Name AS Scenario, gg.Game_CreatedBy AS Creator, gg.Game_Associates AS AssociateAccess, CONCAT( gau.fname, ' ', gau.lname, ', ', gau.email ) AS nameEmail, CONCAT( gau.fname, ' ', gau.lname) AS name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID LEFT JOIN GAME_ADMINUSERS gau ON gau.id = gg.Game_CreatedBy WHERE gl.Link_ID>1 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($linkSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$linkSql .= " AND Game_Name LIKE '%" . $search . "%' OR Scen_Name LIKE '%" . $search . "%' OR gau.fname LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($linkSql);
	$filterCount    = $filterCountObj->num_rows;

	$linkSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$fetchLinkage = $funObj->ExecuteQuery($linkSql);

	while ($fetchLinkageRow = mysqli_fetch_object($fetchLinkage)) {
		// return the data to be displayed to user into and data array
		$i++;
		$edit = '';
		if ($funObj->checkModuleAuth('fetchLinkage', 'delete')) {
			$edit .= '<a href="javascript:void(0);" class="deleteLeaderCollab" id="' . $fetchLinkageRow->Lead_Id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		} else {
			$edit .= '<a href="javascript:void(0);" data-toggle="tooltip" title="Not allowed to delete"><span class="fa fa-eye"></span></a>';
		}

		$creator = date('d-m-Y H:i:s', strtotime($fetchLinkageRow->Lead_CreatedOn)) . '<br>' . $fetchLinkageRow->creator;
		$Link_Introduction = ($fetchLinkageRow->Link_Introduction > 0) ? 'Skipped' : 'Default';
		$Link_IntroductionLink = ($fetchLinkageRow->Link_IntroductionLink > 0) ? 'Skipped' : 'Default';
		$Link_Description = ($fetchLinkageRow->Link_Description > 0) ? 'Skipped' : 'Default';
		$Link_DescriptionLink = ($fetchLinkageRow->Link_DescriptionLink > 0) ? 'Skipped' : 'Default';
		$Link_BackToIntro = ($fetchLinkageRow->Link_BackToIntro > 0) ? 'Skipped' : 'Default';

		$fetchLinkageRow->name = $fetchLinkageRow->name ?? 'Admin';
		$creator = ($fetchLinkageRow->Game_Complete) ? 'Creator: <b>' . $fetchLinkageRow->name . '</b> <span class="alert-success">(Completed)</span>' : 'Creator: <b>' . $fetchLinkageRow->name . '</b> <span class="alert-danger">(In-Progress)</span>';
		if ($fetchLinkageRow->Game_Complete) {
			// if game is completed then no one can make any changes
			$allowEdit    = "data-gamedata='This game is completed. So, no changes are allowed.'";
			if (($fetchLinkageRow->Creator == $_SESSION['ux-admin-id']) || $_SESSION['ux-admin-id'] == 1) {
				$activeDelete = " ";
			} else {
				$activeDelete = "data-gamedata='Only admin or creator (" . $fetchLinkageRow->nameEmail . ") can make the changes.'";
			}
		} else {
			// if game is not completed then only creater or superadmin can make the changes
			if (($fetchLinkageRow->Creator == $_SESSION['ux-admin-id']) || $_SESSION['ux-admin-id'] == 1) {
				$allowEdit    = ' ';
				$activeDelete = " ";
			} else {
				$allowEdit    = "data-gamedata='Only admin or creator (" . $fetchLinkageRow->nameEmail . ") can make the changes.'";
				$activeDelete = $allowEdit;
			}

			// if game is completed then no one can make any changes, apart from associates like designers
			if ($fetchLinkageRow->AssociateAccess == $_SESSION['ux-admin-id']) {
				$allowEdit = ' ';
			}
		}
		$action = '<a href="' . site_root . 'ux-admin/linkage/tab/' . $fetchLinkageRow->Link_ID . '" ' . $allowEdit . '; data-toggle="tooltip" title="Area Tab Sequencing"><span class="fa fa-gear fa-fw"></span></a>';

		if ($funObj->checkModuleAuth('innerlinkage', 'enable')) {
			$action .= ' <a href="' . site_root . 'ux-admin/linkage/link/' . $fetchLinkageRow->Link_ID . '" ' . $allowEdit . '; data-toggle="tooltip" title="Link Game - Comp/Subcomp"> <span class="fa fa-link"></span></a>';
		}
		if ($fetchLinkageRow->Link_Status == 0) {
			$action .= ' <a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $fetchLinkageRow->Link_ID . '" ' . $activeDelete . ' data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a>';
		} else {
			$action .= ' <a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $fetchLinkageRow->Link_ID . '" ' . $activeDelete . ' data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a>';
		}
		if ($funObj->checkModuleAuth('linkage', 'edit')) {
			$action .= ' <a href="' . site_root . "ux-admin/linkage/edit/" . $fetchLinkageRow->Link_ID . '" ' . $allowEdit . ' data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>';
		}
		if ($funObj->checkModuleAuth('linkage', 'delete')) {
			$action .= ' <a href="javascript:void(0);" class="dl_btn" id="' . $fetchLinkageRow->Link_ID . '" ' . $activeDelete . ' data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}
		if ($fetchLinkageRow->Link_Branching == 1) {
			$action .= ' <a href="' . site_root . "ux-admin/componentBranching/link/" . $fetchLinkageRow->Link_ID . '" ' . $allowEdit . ' data-toggle="tooltip" title="Component Branching" target="_blank"><span class="fa fa-code-fork"></span></a>';
		}
		if ($fetchLinkageRow->Link_SaveStatic == 1) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" title="Static Save Button Enabled"><span class="fa fa-save"></span></a>';
		}
		if ($fetchLinkageRow->Link_SkipAlert == 1) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" title="Confirmation Alert For I/P Page Submission Skipped"><span class="fa fa-bell"></span></a>';
		}
		if ($fetchLinkageRow->Link_Enabled == 1) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" title="Auto Submit O/P Page (O/P page is skipped)"><span class="fa fa-paper-plane"></span></a>';
		}
		if ($fetchLinkageRow->Link_JsGameScen == 1) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" onclick="return showJsMapping(this)" data-linkid="' . $fetchLinkageRow->Link_ID . '" title="View Mapping (Js Game Element can be mapped with it\'s components)"><span class="fa fa-eye"></span></a>';
		}
    // Button Text
		$action .= ' <a href="javascript:void(0);" onclick="return changeButtonText(this)" id="viewJsMappingLinkage" title="Change submit button text" data-linkid="' . $fetchLinkageRow->Link_ID . '" class="changeButtonText" data-inputdefaultvalue="' . $fetchLinkageRow->Link_ButtonText . '" data-outputdefaultvalue="' . $fetchLinkageRow->Link_ButtonTextOutput . '" data-inputbuttonactionvalue="' . $fetchLinkageRow->Link_buttonAction . '" data-outputbuttonactionvalue="' . $fetchLinkageRow->Link_buttonActionOutput . '" data-descriptionbuttontext="' . $fetchLinkageRow->Link_DescriptionText . '" data-descriptionbuttoncolor="' . $fetchLinkageRow->Link_DescriptionColorCode . '" data-introductionbuttontext="' . $fetchLinkageRow->Link_IntroductionText . '" data-introductionbuttoncolor="' . $fetchLinkageRow->Link_IntroductionColorCode . '"><span class="fa fa-font"></span></a>';
    

		$gnameS = ($fetchLinkageRow->BotEnabled == 1) ? $fetchLinkageRow->Game . ' (<code>Bot</code>)' : $fetchLinkageRow->Game;
		$gname = "<a href='".site_root."ux-admin/ManageGame/edit/".base64_encode($fetchLinkageRow->Game_ID)."' target='_blank'>".$gnameS."</a>";
		$scenAreaSql = "SELECT ga.Area_ID, ga.Area_Name, gas.Sequence_Order, if(gas.Sequence_Alias IS NOT NULL,gas.Sequence_Alias,'No Alias') AS Sequence_Alias, gas.Sequence_AreaId FROM GAME_AREA_SEQUENCE gas LEFT JOIN GAME_AREA ga ON ga.Area_ID = gas.Sequence_AreaId AND ga.Area_Delete=0 WHERE gas.Sequence_LinkId = $fetchLinkageRow->Link_ID ORDER BY gas.Sequence_Order";

		$scenArea = $funObj->RunQueryFetchObject($scenAreaSql);
		if(count($scenArea)>0)
		{
			$scenAreaInTitle = '';
			foreach($scenArea as $scenAreaRow)
			{
				$scenAreaInTitle .= $scenAreaRow->Area_Name.': {'.$scenAreaRow->Sequence_Alias.'}: ('.$scenAreaRow->Sequence_Order.')'.'&#013;';
			}
			$scenAreaInTitle = trim($scenAreaInTitle, "&#013;");
		}
		else
		{
			$scenAreaInTitle = "This scenario don't have any area";
		}
		$scenarioWithArea = "<a href='".site_root."ux-admin/ManageScenario/edit/".base64_encode($fetchLinkageRow->Link_ScenarioID)."' title='".$scenAreaInTitle."' target='_blank'>".$fetchLinkageRow->Scenario."</a>";

		$data[]  = array($i, $gname, $scenarioWithArea, $fetchLinkageRow->Link_Order, $Link_Introduction, $Link_IntroductionLink, $Link_Description, $Link_DescriptionLink, $Link_BackToIntro, $creator, $action);
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


// to get the all the linkage of game and scenarios list via ajax
if ($_POST['action'] == 'listgame') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'Game_ID';
			break;

		case 1:
			$colName = 'Game_ID';
			break;

		case 2:
			$colName = 'Game_Name';
			break;

		case 3:
			$colName = 'Game_Comments';
			break;

		case 4:
			$colName = 'Game_Header';
			break;

		case 5:
			$colName = 'Game_Elearning';
			break;

		case 6:
			$colName = 'Game_Introduction';
			break;

		case 7:
			$colName = 'Game_IntroductionLink';
			break;

		case 8:
			$colName = 'Game_Description';
			break;

		case 9:
			$colName = 'Game_DescriptionLink';
			break;

		case 10:
			$colName = 'Game_BackToIntro';
			break;

		case 11:
			$colName = 'Game_Image';
			break;

		case 12:
			$colName = 'Game_Complete';
			break;

		default:
			$colName   = 'Game_datetime';
			$direction = 'DESC';
			break;
	}

	$gameSql = "SELECT ( SELECT COUNT(*) FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gg.Game_ID ) AS ScenarioCount, gg.*, CONCAT( ga.fname, ' ', ga.lname, ', ', ga.email ) AS nameEmail, CONCAT(ga.fname, ' ', ga.lname) AS NAME FROM GAME_GAME gg LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gg.Game_CreatedBy WHERE 1 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($gameSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$gameSql .= " AND Game_Name LIKE '%" . $search . "%' OR Game_Comments LIKE '%" . $search . "%' OR Game_Header LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($gameSql);
	$filterCount    = $filterCountObj->num_rows;

	$gameSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$fetchGames = $funObj->ExecuteQuery($gameSql);

	while ($gameListRow = mysqli_fetch_object($fetchGames)) {
		// return the data to be displayed to user into and data array
		$i++;
		$gameType = ($gameListRow->Game_Elearning == 1) ? 'eLearning' : 'Game';
		$gameType .= ($gameListRow->Game_Type == 1) ? "<code>(Bot-Enabled)</code>" : '';
		$gameImage = ($gameListRow->Game_Image) ? "<img src='" . site_root . "images/" . $gameListRow->Game_Image . "' alt='No Image' width='25' height='25' onclick='return showImagePopup(this);'>" : "<code>No Image</code>";
		$uploadOption = '<a target="_blank" href="' . site_root . "ux-admin/ManageGameContent/Edit/" . base64_encode($gameListRow->Game_ID) . '" data-toggle="tooltip" title="General"><span class="fa fa-book"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageGameDocument/Edit/" . base64_encode($gameListRow->Game_ID) . '" data-toggle="tooltip" title="Document"><span class="fa fa-file-o"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageGameImage/Edit/" . base64_encode($gameListRow->Game_ID) . '" data-toggle="tooltip" title="Image"><span class="fa fa-image"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageGameVideo/Edit/" . base64_encode($gameListRow->Game_ID) . '" data-toggle="tooltip" title="Video"><span class="fa fa-video-camera"></span></a>';
		// game is completed
		if ($gameListRow->Game_Complete) {
			$creator = 'Creator: <b>' . $gameListRow->NAME . '</b> <span class="alert-success">(Completed)</span>';
		} else {
			$creator = 'Creator: <b>' . $gameListRow->NAME . '</b> <span class="alert-danger">(In-Progress)</span>';
		}
		$action = '';
		// check for active de-active games
		if ($gameListRow->Game_Delete > 0) {
			$action .= " <a href='javascript:void(0);' data-createdby='.$gameListRow->Game_CreatedBy.' onclick='return changeStatus(this);' class='cs_btn' id='.$gameListRow->Game_ID.' data-toggle='tooltip' onclick='return changeStatus(" . $gameListRow->Game_ID . ", 0);' title='Deactive'><span class='fa fa-times'></span></a>";
		} else {
			$action .= " <a href='javascript:void(0);' data-createdby='.$gameListRow->Game_CreatedBy.' onclick='return changeStatus(this);' class='cs_btn' id='.$gameListRow->Game_ID.' data-toggle='tooltip' onclick='return changeStatus(" . $gameListRow->Game_ID . ", 1);' title='Active'><span class='fa fa-check'></span></a>";
		}
		if ($funObj->checkModuleAuth('game', 'edit')) {
			$editHref = ($gameListRow->Game_Complete < 1) ? site_root . "ux-admin/ManageGame/edit/" . base64_encode($gameListRow->Game_ID) : 'javascript:void(0);';

			$action .= ' <a href="' . $editHref . '" onclick="return preventEdit(this);" data-createdby="' . $gameListRow->Game_CreatedBy . '" data-toggle="tooltip" title="Edit" class="editGame"><span class="fa fa-pencil"></span></a>';
		}
		if ($funObj->checkModuleAuth('game', 'delete')) {
			$action .= ' <a href="javascript:void(0);" data-createdby="' . $gameListRow->Game_CreatedBy . '" class="dl_btn" id="' . $gameListRow->Game_ID . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}
		$branchingState = ($gameListRow->ScenarioCount > 2) ? "data-scenbranching='" . $gameListRow->ScenarioCount . "'" : '';
		if ($gameListRow->Game_Complete) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" title="Game: Completed" class="completed" data-gameid="' . $gameListRow->Game_ID . '" onclick="return game_complete(this)" data-createdby="' . $gameListRow->Game_CreatedBy . '" data-creator="' . $gameListRow->name . '" data-completedby="' . $gameListRow->nameEmail . '" data-completedon="' . date('d-m-Y H:i:s', strtotime($gameListRow->Game_UpdatedOn)) . '" ' . $branchingState . '><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a>';
		} else {
			$className = (($gameListRow->Game_CreatedBy == $_SESSION['ux-admin-id']) || ($_SESSION['admin_usertype'] == 'superadmin')) ? "progress" : "notAllow";
			$onclickFunction = (($gameListRow->Game_CreatedBy == $_SESSION['ux-admin-id']) || ($_SESSION['admin_usertype'] == 'superadmin')) ? "onclick='return game_progress(this);'" : "onclick='return notAllowToComplete(this);'";

			$action .= '<a href="javascript:void(0);" data-toggle="tooltip" title="Game: In-Progress" id="progress_' . $gameListRow->Game_ID . '" data-cancomplete="' . $gameListRow->nameEmail . '" ' . $onclickFunction . ' class="' . $className . '" data-gameid="' . $gameListRow->Game_ID . '" data-createdby="' . $gameListRow->Game_CreatedBy . '" data-creator="' . $gameListRow->name . '" data-completedby="' . $gameListRow->nameEmail . '" data-completedon="' . date('d-m-Y H:i:s', strtotime($gameListRow->Game_UpdatedOn)) . '" ' . $branchingState . '><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></a>';
		}
		// adding game linked scenarios as title
		$gamScenSql = "SELECT gs.Scen_Name,gl.Link_Order FROM GAME_SCENARIO gs LEFT JOIN GAME_LINKAGE gl ON gl.Link_ScenarioID=gs.Scen_ID AND gl.Link_Status=1 WHERE gl.Link_GameID=$gameListRow->Game_ID ORDER BY gl.Link_Order";
		$gameScen = $funObj->RunQueryFetchObject($gamScenSql);
		if(count($gameScen)>0)
		{
			$gameScenarios = '';
			foreach($gameScen as $gameScenRow)
			{
				// $gameScenRow
				$gameScenarios .= $gameScenRow->Scen_Name.': ('.$gameScenRow->Link_Order.')&#013;';
			}
			$gameScenarios = trim($gameScenarios, "&#013;");
		}
		else
		{
			$gameScenarios = "No scenario linked with this game";
		}
		// echo $gameScenarios.'<br><br>';
		$gamewithScenarioAsTitle = "<a href='javascript:void(0);' title='".$gameScenarios."'>$gameListRow->Game_Name</a>";

		$data[]  = array($i, $gameListRow->Game_ID, $gamewithScenarioAsTitle, $gameListRow->Game_Comments, $gameListRow->Game_Header, $gameType, ($gameListRow->Game_Introduction > 0) ? 'Skipped' : 'Default', ($gameListRow->Game_IntroductionLink > 0) ? 'Skipped' : 'Default', ($gameListRow->Game_Description > 0) ? 'Skipped' : 'Default', ($gameListRow->Game_DescriptionLink > 0) ? 'Skipped' : 'Default', ($gameListRow->Game_BackToIntro > 0) ? 'Skipped' : 'Default', $gameImage, $uploadOption, $creator, $action);
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

// to list all the scenario
if ($_POST['action'] == 'listScenario') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'Scen_ID';
			break;

		case 2:
			$colName = 'Scen_Name';
			break;

		case 3:
			$colName = 'Scen_Comments';
			break;

		case 4:
			$colName = 'Scen_Header';
			break;

		case 6:
			$colName = 'Scen_InputButton';
			break;

		case 7:
			$colName = 'Scen_Image';
			break;

		default:
			$colName   = 'Scen_Datetime';
			$direction = 'DESC';
			break;
	}

	$scenSql = "SELECT * FROM GAME_SCENARIO WHERE 1 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($scenSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$scenSql .= " AND Scen_Name LIKE '%" . $search . "%' OR Scen_Comments LIKE '%" . $search . "%' OR Scen_Header LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($scenSql);
	$filterCount    = $filterCountObj->num_rows;

	$scenSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$fetchScenarios = $funObj->ExecuteQuery($scenSql);

	while ($scenListRow = mysqli_fetch_object($fetchScenarios)) {
		// return the data to be displayed to user into and data array
		$i++;
		$uploadOption = '<a target="_blank" href="' . site_root . "ux-admin/ManageScenarioContent/Edit/" . base64_encode($scenListRow->Scen_ID) . '" data-toggle="tooltip" title="General"><span class="fa fa-book"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageScenarioDocument/Edit/" . base64_encode($scenListRow->Scen_ID) . '" data-toggle="tooltip" title="Document"><span class="fa fa-file-o"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageScenarioImage/Edit/" . base64_encode($scenListRow->Scen_ID) . '" data-toggle="tooltip" title="Image"><span class="fa fa-image"></span></a> <a target="_blank" href="' . site_root . "ux-admin/ManageScenarioVideo/Edit/" . base64_encode($scenListRow->Scen_ID) . '" data-toggle="tooltip" title="Video"><span class="fa fa-video-camera"></span></a>';

		$action = '';
		if ($scenListRow->Scen_Status == 0) {
			$action .= ' <a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $scenListRow->Scen_ID . '" data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a>';
		} else {
			$action .= ' <a href="javascript:void(0);" onclick="return changeStatus(this);" class="cs_btn" id="' . $scenListRow->Scen_ID . '" data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a>';
		}
		if ($funObj->checkModuleAuth('scenario', 'edit')) {
			$action .= ' <a href="' . site_root . "ux-admin/ManageScenario/edit/" . base64_encode($scenListRow->Scen_ID) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>';
		}
		if ($funObj->checkModuleAuth('scenario', 'delete')) {
			$action .= ' <a href="javascript:void(0);" class="dl_btn" id="' . $scenListRow->Scen_ID . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}

		if ($scenListRow->Scen_Branching == 1) {
			$action .= ' <a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching Enabled"><span class="fa fa-code-fork"></span></a>';
		}

		$scenImage = ($scenListRow->Scen_Image) ? "<img src='" . site_root . "images/" . $scenListRow->Scen_Image . "' alt='No Image' width='25' height='25' onclick='return showImagePopup(this);'>" : "<code>No Image</code>";

		$data[]  = array($i, $scenListRow->Scen_ID, $scenListRow->Scen_Name, $scenListRow->Scen_Comments, $scenListRow->Scen_Header, $uploadOption, ($scenListRow->Scen_InputButton == 1) ? 'Show' : 'Hidden', $scenImage, $action);
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

// to list all the Formulas
if ($_POST['action'] == 'listFormula') {
	$colIndex     = $_POST['order'][0]['column'];
	$direction    = $_POST['order'][0]['dir'];
	$start        = $_POST['start'];
	$length       = $_POST['length'];
	$search       = trim($_POST['search']['value']);
	$data         = array();
	$i            = $start;
	$filterRecord = false;

	switch ($colIndex) {
		case 0:
			$colName = 'f_id';
			$sortLinkage = '';
		break;

		case 1:
			$colName = 'formula_title';
			$sortLinkage = '';
		break;

		case 2:
			$colName = 'expression_string';
			$sortLinkage = '';
		break;

		case 3:
			$sortLinkage = 'linkage';
			$colName = 'f_id';
		break;

		case 4:
			$colName = 'date_time';
			$sortLinkage = '';
		break;

		case 5:
			$colName = 'formula_updatedOn';
			$sortLinkage = '';
		break;

		default:
			$sortLinkage = '';
			$colName   = 'f_id';
			$direction = 'DESC';
			break;
	}

	$formulaSql = "SELECT * FROM GAME_FORMULAS WHERE 1 ";

	// to get the total user record
	$countAllData = $funObj->ExecuteQuery($formulaSql);
	$totalCount   = $countAllData->num_rows;

	if (!empty($search)) {
		$formulaSql .= " AND formula_title LIKE '%" . $search . "%' OR expression_string LIKE '%" . $search . "%' OR expression LIKE '%" . $search . "%'";
		$filterRecord    = true;
	}
	// to get the filter user record
	$filterCountObj = $funObj->ExecuteQuery($formulaSql);
	$filterCount    = $filterCountObj->num_rows;

	$formulaSql .= " ORDER BY " . $colName . " " . $direction . " LIMIT " . $start . "," . $length;

	$fetchFormula = $funObj->ExecuteQuery($formulaSql);

	while ($formulaListRow = mysqli_fetch_object($fetchFormula)) {
		// return the data to be displayed to user into and data array
		$i++;
		// finding the linkage with formulas
		$fLinkSql = "SELECT gls.Sublink_ID, gls.SubLink_LinkID, gls.SubLink_AreaName, gls.SubLink_CompName, gls.SubLink_SubcompName, gs.Scen_Name FROM `GAME_LINKAGE_SUB` gls LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID = gls.SubLink_LinkID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID WHERE gls.SubLink_InputMode = 'formula' AND gls.SubLink_FormulaID =" . $formulaListRow->f_id;
		if(!empty($sortLinkage))
		{
			$fLinkSql .= " ORDER BY gls.SubLink_CompID ".$direction;
		}
		$linkFormula = $funObj->RunQueryFetchObject($fLinkSql);
		$formulaLinkage = '';
		foreach ($linkFormula as $linkageRow) {
			$formulaLinkage .= "<a href='" . site_root . "ux-admin/linkage/linkedit/" . $linkageRow->Sublink_ID . "' title='(" . $linkageRow->Scen_Name . "): " . $linkageRow->SubLink_AreaName . "' target='_blank'>" . $linkageRow->SubLink_SubcompName ?? $linkageRow->SubLink_CompName . "</a>, ";
		}

		$action = '';
		if ($funObj->checkModuleAuth('formulas', 'edit')) {
			$action .= ' <a href="' . site_root . "ux-admin/Formulas/edit/" . base64_encode($formulaListRow->f_id) . '" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>';
		}
		if ($funObj->checkModuleAuth('formulas', 'delete')) {
			$action .= ' <a href="javascript:void(0);" class="dl_btn" id="' . $formulaListRow->f_id . '" data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>';
		}

		$id = "<span title='" . $formulaListRow->f_id . "'>$i</span>";
		$formujaExpression = "<a href='javascript:void(0);' title='" . $formulaListRow->expression . "'>" . $formulaListRow->expression_string . "</a>";

		$data[]  = array($id, $formulaListRow->formula_title, $formujaExpression, trim($formulaLinkage, ', '), date('d-m-Y', strtotime($formulaListRow->date_time)), ($formulaListRow->formula_updatedOn) ? date('d-m-Y', strtotime($formulaListRow->formula_updatedOn)) : '', $action);
	}

	// $filterCount = ($filterRecord)?$filterCount:$totalCount; expression
	// $totalCount  = ($filterRecord)?$filterCount:$totalCount;

	$output = array(
		"draw"            => $_POST['draw'],
		"recordsTotal"    => $totalCount,
		"recordsFiltered" => $filterCount,
		"data"            => $data,
	);

	echo json_encode($output);
}
