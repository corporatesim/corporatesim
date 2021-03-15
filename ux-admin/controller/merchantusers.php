<?php
require_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$userdetails = (object) array(
			'fname'		=>	$_POST['fname'],
			'lname'		=>	$_POST['lname'],
			'mobile'	=>	$_POST['mobile'],
			'email'		=>	$_POST['email'],
			'address'	=>	$_POST['street_number'],
			'route'		=>	$_POST['route'],
			'city'		=>	$_POST['locality'],
			'state'		=>	$_POST['administrative_area_level_1'],
			'country'	=>	$_POST['country'],
			'zip_code'	=>	$_POST['postal_code'],
			'lat'		=>	$_POST['latitude'],
			'lng'		=>	$_POST['longitude']
	);

	if( !empty($_POST['fname']) && !empty($_POST['lname'])  && !empty($_POST['mobile'])
			&& !empty($_POST['email']) && !empty($_POST['street_number']) && !empty($_POST['route'])
			&& !empty($_POST['locality']) && !empty($_POST['administrative_area_level_1'])
			&& !empty($_POST['postal_code']) && !empty($_POST['country'])
			){
				$uid = $_POST['id'];

				$where = array(
						"(`email` ='".$userdetails->email."'
				OR `mobile` ='".$userdetails->mobile."')",
						"id != ". $uid
				);
				$object = $functionsObj->SelectData(array(), 'SITE_USERS', $where, '', '', '', '', 0);

				if($object->num_rows > 0){
					$msg = "Email address or mobile number already registered with another account";
					$type[0] = "inputError";
					$type[1] = "has-error";
				}else{
					$result = $functionsObj->UpdateData('SITE_USERS', $userdetails, 'id', $uid, 0);
					if($result === true){
						$_SESSION['msg'] = "User details updated successfully";
						$_SESSION['type[0]'] = "inputSuccess";
						$_SESSION['type[1]'] = "has-success";
						header("Location: ".site_root."ux-admin/MerchantUsers");
						exit(0);
					}else{
						$msg = "Error: ".$result;
						$type[0] = "inputError";
						$type[1] = "has-error";
					}
				}
	}else{
		$msg = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if( isset($_GET['edit']) && !empty($_GET['edit'])){
	$header = 'Edit Site User';
	$uid = base64_decode($_GET['edit']);
	
	$object = $functionsObj->SelectData(array(), 'SITE_USERS', array('id='.$uid), '', '', '', '', 0);
	$userdetails = $functionsObj->FetchObject($object);

	$url = site_root."ux-admin/MerchantUsers";
	
	$include_file = 'siteusers/addedit.php';
}else if( isset($_GET['del']) && !empty($_GET['del']) ){
	$id = $_GET['del'];
	// Delete Merchant User
	$result = $functionsObj->UpdateData('SITE_USERS', array( 'del_stat' => 1 ), 'id', $id, 0);
	if($result === true){
		$_SESSION['msg'] = "User deleted";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		
		header("Location: ".site_root."ux-admin/MerchantUsers");
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
	
}else if( isset($_GET['stat']) && !empty($_GET['stat']) ){
	$id = base64_decode($_GET['stat']);
	$object = $functionsObj->SelectData(array(), "SITE_USERS", array("id=".$id), '', '', '', '', 0);
	if($object->num_rows > 0){
		$merchant_details = $functionsObj->FetchObject($object);
		if($merchant_details->usertype == 1){
			$result = $functionsObj->UpdateData('SITE_USERS', array( "usertype" => 2 ), "id", $id, 0);
			$stat = "Enabled";
		} else if($merchant_details->usertype = 2){
			$result = $functionsObj->UpdateData('SITE_USERS', array( "usertype" => 1 ), "id", $id, 0);
			$stat = "Disabled";
		}
		
		
		$_SESSION['msg'] = "Account ".$stat." Successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		
		header("Location: ".site_root."ux-admin/MerchantUsers");
		exit(0);
	}
}else{
	$object = $functionsObj->SelectData(array("GROUP_CONCAT(uid) as uids"), 'BUSINESS_DETAILS', array(), '', '', '', '', 0);
	$result = $functionsObj->FetchObject($object);
	
	if( !empty($result->uids) ){
		$merchant_list = $functionsObj->SelectData(array(), 'SITE_USERS', array('id in ('.$result->uids.')', 'del_stat=0'), 'date_time DESC', '', '', '', 0);
	}else{
		$merchant_list = (object) array();
	}
	
	$include_file = "merchant/merchantlist.php";
}

include_once doc_root."ux-admin/view/".$include_file;