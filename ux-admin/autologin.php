<?php 
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$fields   = array();
$where    = array();
$siteData = $functionsObj->SelectData($fields, 'GAME_SITESETTINGS', $where, $order='', $group='', $limit='', $offset='', $print_flag='');
$i        = 1;

//var_dump($siteData);
while($row = $siteData->fetch_assoc()){
	$siteDetails[$i] = $row;
	$i++;
}

if(isset($cookie_name)){
	// Check if the cookie exists
	if(isset($_COOKIE[$cookie_name])){
		parse_str($_COOKIE[$cookie_name]);

		$fields = array();
		$where  = array("username='".$usr."'", "password='".$hash."'");
		$result = $functionsObj->SelectData($fields, 'GAME_ADMINUSERS', $where, '', '', '', '', 0);
		
		if($result->num_rows > 0){
			$result                   = $functionsObj->FetchObject($result);
			$object                   = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS_ACCESS', array('id='.$result->id), '', '', '', '', 0);
			$_SESSION['ux-admin-id']  = $result->id;
			$_SESSION['admin_access'] = $functionsObj->FetchObject($object);
			
			include_once doc_root.'ux-admin/controller/index.php';
		}
		else
		{
			include_once doc_root.'ux-admin/controller/login.php';
		}
	}
}
?>