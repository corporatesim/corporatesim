<?php 
switch($_GET['q']){
	case '':
	$showfile = 'dashboard.php';
	break;

	case 'Dashboard':
	$showfile = 'dashboard.php';
	break;

	case 'ManageArea':
	$showfile = 'manageArea.php';
	break;

	case 'ManageComponent':
	$showfile = 'manageComponent.php';
	break;

	case 'ManageSubComponent':
	$showfile = 'manageSubComponent.php';
	break;

	case 'ManageGame':
	$showfile = 'manageGame.php';
	break;

	case 'ManageScenario':
	$showfile = 'manageScenario.php';
	break;

	case 'adminlist':
	$showfile = 'adminList.php';
	break;

	case 'AdminUsers':
	$showfile = 'adminUsers.php';
	break;

	case 'siteusers':
	$showfile = 'siteusers.php';
	break;

	case 'linkage':
	$showfile = 'linkage.php';
	break;

	// to test the component branching, once the functionality completed then remove this section after merging it into linkage
	case 'linkageBranching':
	$showfile = 'linkageBranching.php';
	break;

	case 'chart':
	$showfile = 'chart.php';
	break;

	case 'chartComp':
	$showfile = 'chartComp.php';
	break;

	case 'Formulas':
	$showfile = 'Formulas.php';
	break;

	case 'siteusers':
	$showfile = 'siteusers.php';
	break;

	case 'addUserGame':
	$showfile = 'addUserGame.php';
	break;

		// Site Settings
	case 'SiteSettings':
	$showfile = 'siteSettings.php';
	break;

		// SEO Settings
	case 'SeoSettings':
	$showfile = 'seoSettings.php';
	break;

	case 'GameDocument':
	$showfile = 'GameDocument.php';
	break;

	case 'ManageGameDocument':
	$showfile = 'manageGameDocument.php';
	break;

	case 'ManageGameImage':
	$showfile = 'manageGameImage.php';
	break;

	case 'ManageGameVideo':
	$showfile = 'manageGameVideo.php';
	break;

	case 'ManageGameContent':
	$showfile = 'manageGameContent.php';
	break;


	case 'ManageScenarioDocument':
	$showfile = 'manageScenarioDocument.php';
	break;

	case 'ManageScenarioImage':
	$showfile = 'manageScenarioImage.php';
	break;

	case 'ManageScenarioVideo':
	$showfile = 'manageScenarioVideo.php';
	break;

	case 'ManageScenarioContent':
	$showfile = 'manageScenarioContent.php';
	break;

		// Profile
	case 'MyProfile':
	$showfile = 'myProfile.php';
	break;

			// Report
	case 'UserReport':
	$showfile = 'UserReport.php';
	break;

	case 'ReplayPermission':
	$showfile = 'ReplayPermission.php';
	break;

	case 'ScenarioBranching':
	$showfile = 'ScenarioBranching.php';
	break;

	case 'outcomeBadges':
	$showfile = 'outcomeBadges.php';
	break;

	case 'personalizeOutcome':
	$showfile = 'personalizeOutcome.php';
	break;

	case 'componentBranching':
	$showfile = 'componentBranching.php';
	break;

	case 'ManageEnterprise':
	$showfile = 'ManageEnterprise.php';
	break;

	case 'ManageSubEnterprise':
	$showfile = 'ManageSubEnterprise.php';
	break;

	case 'EntSubEnterpriseUsers':
	$showfile = 'EntSubEnterpriseUsers.php';
	break;

	case 'addChartDetails':
	$showfile = 'addChartDetails.php';
	break;

	case 'createMis':
	$showfile = 'createMis.php';
	break;

		// Logout
	case 'Logout':
	$showfile = 'logout.php';
	break;

		// Default Page to show
	default:
	$showfile = 'error.php';
}

include_once doc_root.'ux-admin/controller/'.$showfile;
?>
