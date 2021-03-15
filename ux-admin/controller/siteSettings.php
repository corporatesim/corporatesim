<?php
if(isset($_POST['settings']) && $_POST['settings'] == 'Update'){
	$array	=	array(
			'value'		=>	$functionsObj->EscapeString($_POST['value'])
	);
	$result = $functionsObj->UpdateData('GAME_SITESETTINGS', $array, 'id', $_POST['sid']);
	if($result === true){
		$_SESSION['msg']		=	'Settings Updated Successfully';
		$_SESSION['type[0]']	=	'inputSuccess';
		$_SESSION['type[1]']	=	'has-success';
		header("Location:".site_root."ux-admin/SiteSettings");
	}
}

if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$id = base64_decode($_GET['edit']);
	$fields	= array();
	$where	=	array('id='.$id);
	$object = $functionsObj->SelectData($fields, 'GAME_SITESETTINGS', $where, $limit='', $offset='', $print_flag='');
	$editsetting = $functionsObj->FetchData($object);
	include_once doc_root.'ux-admin/view/sitesettings/editSetting.php';
}else{
	$fields	= array();
	$where	=	array();
	$object = $functionsObj->SelectData($fields, 'GAME_SITESETTINGS', $where, $limit='', $offset='', $print_flag='');
	include_once doc_root.'ux-admin/view/sitesettings/siteSettings.php';
}
?>