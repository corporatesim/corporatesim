<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$logo = '<img src="'.site_root.'images/logo.png">';

// On Submit Click
if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	
	
	// ------------------------  Area -----------------------------------------
	$area_enable	= $_POST['area_enable']!=''?$_POST['area_enable']:'no';
	$enable_area = array('enable' => $area_enable);
	$area_add 	=  $_POST['area_add']!=''?$_POST['area_add']:'no';
	$add_area = array('add' => $area_add);
	$area_edit 	=  $_POST['area_edit']!=''?$_POST['area_edit']:'no';
	$edit_area = array('edit' => $area_edit);
	$area_delete =  $_POST['area_delete']!=''?$_POST['area_delete']:'no';
	$delete_area = array('delete' => $area_delete);
	
	$area = $enable_area + $add_area + $edit_area + $delete_area;
	$val1 = array('area' => $area);
	
	// ------------------------  Component -----------------------------------------
	$component_enable	= $_POST['component_enable']!=''?$_POST['component_enable']:'no';
	$enable_comp = array('enable' => $component_enable);
	$component_add 	=  $_POST['component_add']!=''?$_POST['component_add']:'no';
	$add_comp = array('add' => $component_add);
	$component_edit 	=  $_POST['component_edit']!=''?$_POST['component_edit']:'no';
	$edit_comp = array('edit' => $component_edit);
	$component_delete =  $_POST['component_delete']!=''?$_POST['component_delete']:'no';
	$delete_comp = array('delete' => $component_delete);
	
	$comp= $enable_comp + $add_comp + $edit_comp + $delete_comp;
	$val2 = array('component' => $comp);
	
	// ------------------------  subcomponent -----------------------------------------
	$subcomponent_enable	= $_POST['subcomponent_enable']!=''?$_POST['subcomponent_enable']:'no';
	$enable_subcomp = array('enable' => $subcomponent_enable);
	$subcomponent_add 	=  $_POST['subcomponent_add']!=''?$_POST['subcomponent_add']:'no';
	$add_subcomp = array('add' => $subcomponent_add);
	$subcomponent_edit 	=  $_POST['subcomponent_edit']!=''?$_POST['subcomponent_edit']:'no';
	$edit_subcomp = array('edit' => $subcomponent_edit);
	$subcomponent_delete =  $_POST['subcomponent_delete']!=''?$_POST['subcomponent_delete']:'no';
	$delete_subcomp = array('delete' => $subcomponent_delete);
	
	$subcomp= $enable_subcomp + $add_subcomp + $edit_subcomp + $delete_subcomp;
	$val3 = array('sub component' => $subcomp);
	
	// ------------------------  Game -----------------------------------------
	$game_enable	= $_POST['game_enable']!=''?$_POST['game_enable']:'no';
	$enable_game = array('enable' => $game_enable);
	$game_add 	=  $_POST['game_add']!=''?$_POST['game_add']:'no';
	$add_game = array('add' => $game_add);
	$game_edit 	=  $_POST['game_edit']!=''?$_POST['game_edit']:'no';
	$edit_game = array('edit' => $game_edit);
	$game_delete =  $_POST['game_delete']!=''?$_POST['game_delete']:'no';
	$delete_game = array('delete' => $game_delete);
	
	$game= $enable_game + $add_game + $edit_game + $delete_game;
	$val4 = array('game' => $game);
	
	// ------------------------  Scenario -----------------------------------------
	$scenario_enable	= $_POST['scenario_enable']!=''?$_POST['scenario_enable']:'no';
	$enable_scenario = array('enable' => $scenario_enable);
	$scenario_add 	=  $_POST['scenario_add']!=''?$_POST['scenario_add']:'no';
	$add_scenario = array('add' => $scenario_add);
	$scenario_edit 	=  $_POST['scenario_edit']!=''?$_POST['scenario_edit']:'no';
	$edit_scenario = array('edit' => $scenario_edit);
	$scenario_delete =  $_POST['scenario_delete']!=''?$_POST['scenario_delete']:'no';
	$delete_scenario = array('delete' => $scenario_delete);
	
	$scenario= $enable_scenario + $add_scenario + $edit_scenario + $delete_scenario;
	$val5 = array('scenario' => $scenario);
	
	// ------------------------  Formulas -----------------------------------------
	$formulas_enable	= $_POST['formulas_enable']!=''?$_POST['formulas_enable']:'no';
	$enable_formulas = array('enable' => $formulas_enable);
	$formulas_add 	=  $_POST['formulas_add']!=''?$_POST['formulas_add']:'no';
	$add_formulas = array('add' => $formulas_add);
	$formulas_edit 	=  $_POST['formulas_edit']!=''?$_POST['formulas_edit']:'no';
	$edit_formulas = array('edit' => $formulas_edit);
	$formulas_delete =  $_POST['formulas_delete']!=''?$_POST['formulas_delete']:'no';
	$delete_formulas = array('delete' => $formulas_delete);
	
	$formulas= $enable_formulas + $add_formulas + $edit_formulas + $delete_formulas;
	$val6 = array('formulas' => $formulas);
	
	// ------------------------  Linkage -----------------------------------------
	$linkage_enable	= $_POST['linkage_enable']!=''?$_POST['linkage_enable']:'no';
	$enable_linkage = array('enable' => $linkage_enable);
	$linkage_add 	=  $_POST['linkage_add']!=''?$_POST['linkage_add']:'no';
	$add_linkage = array('add' => $linkage_add);
	$linkage_edit 	=  $_POST['linkage_edit']!=''?$_POST['linkage_edit']:'no';
	$edit_linkage = array('edit' => $linkage_edit);
	$linkage_delete =  $_POST['linkage_delete']!=''?$_POST['linkage_delete']:'no';
	$delete_linkage = array('delete' => $linkage_delete);
	
	$linkage= $enable_linkage + $add_linkage + $edit_linkage + $delete_linkage;
	$val7 = array('linkage' => $linkage);
	
	// ------------------------  end -----------------------------------------
	
	$userrights = $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
	
	
	//Get values in array
	$userdetails = (object) array(
			'fname'			=>	$_POST['fname'],
			'lname'			=>	$_POST['lname'],
			'username'		=>	$_POST['username'],
			'email'			=>	$_POST['email'],
			'usertype'		=>	'admin',
			'password'		=>	md5($_POST['password']),
			'admin_access'	=>	1,
			'status'		=>	1,
			'admin_rights'	=>	json_encode($userrights),	
			'date_time'		=>	date('Y-m-d H:i:s')
	);
	
	

	// Validate fields not empty
	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username'])
		&& !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['retypepass'])
		){
		// Check password and confirm password matches
		if($_POST['password'] == $_POST['retypepass']){
			
				
			$check = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array("username='".$userdetails->username."' OR email='".$userdetails->email."'"), '', '', '', '', 0);
			if($check->num_rows > 0){
				$msg = "Username or Email already present";
				$type[0] = "inputError";
				$type[1] = "has-error";
			}else{
				$result = $functionsObj->InsertData('GAME_ADMINUSERS', $userdetails);
				$userid = $functionsObj->InsertID();
				
			
				if($result){
					// SEND EMAIL TO SUBADMIN USER
					/* $object = $functionsObj->SelectData(array(), 'EMAILTEMPLATES', array('id=7'), '', '', '', '', 0);
					$emailtemp = $functionsObj->FetchObject($object);
						
					$from = $emailtemp->from_email;
					$subject = $emailtemp->subject;
					$subject = str_replace('[USERTYPE]', $_POST['usertype'], $subject);
				
					$message = $emailtemp->content;
					$message = str_replace("[LOGO]", $logo, $message);
					$message = str_replace("[SITELINK]", site_root, $message);
					$message = str_replace("[SITENAME]", $siteDetails[1]['value'], $message);
					$message = str_replace("[NAME]", $userdetails->fname.' '.$userdetails->lname, $message);
					$message = str_replace("[URL]", '<a href="'.site_root.'ux-admin/">'.site_root.'ux-admin/</a>', $message);
					$message = str_replace("[USERNAME]", $userdetails->username, $message);
					$message = str_replace("[PASSWORD]", $_POST['password'], $message);
					$message = str_replace("[ADMIN_ACCESS]", '', $message);
					
					$header = "From:" . $from . "\r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html; charset: utf8\r\n";
					mail($userdetails->email, $subject, $message, $header); */
			
					$_SESSION['msg'] = "Successfully Added";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location:".site_root."ux-admin/adminlist");
					exit(0);
				}
			}
				
			
		}else{
			$msg = "Password and Re-type password do not match";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}else{
		$msg = "Field cannot be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){

	// ------------------------  Area -----------------------------------------
	$area_enable	= $_POST['area_enable']!=''?$_POST['area_enable']:'no';
	$enable_area = array('enable' => $area_enable);
	$area_add 	=  $_POST['area_add']!=''?$_POST['area_add']:'no';
	$add_area = array('add' => $area_add);
	$area_edit 	=  $_POST['area_edit']!=''?$_POST['area_edit']:'no';
	$edit_area = array('edit' => $area_edit);
	$area_delete =  $_POST['area_delete']!=''?$_POST['area_delete']:'no';
	$delete_area = array('delete' => $area_delete);
	
	$area = $enable_area + $add_area + $edit_area + $delete_area;
	$val1 = array('area' => $area);
	
	// ------------------------  Component -----------------------------------------
	$component_enable	= $_POST['component_enable']!=''?$_POST['component_enable']:'no';
	$enable_comp = array('enable' => $component_enable);
	$component_add 	=  $_POST['component_add']!=''?$_POST['component_add']:'no';
	$add_comp = array('add' => $component_add);
	$component_edit 	=  $_POST['component_edit']!=''?$_POST['component_edit']:'no';
	$edit_comp = array('edit' => $component_edit);
	$component_delete =  $_POST['component_delete']!=''?$_POST['component_delete']:'no';
	$delete_comp = array('delete' => $component_delete);
	
	$comp= $enable_comp + $add_comp + $edit_comp + $delete_comp;
	$val2 = array('component' => $comp);
	
	// ------------------------  subcomponent -----------------------------------------
	$subcomponent_enable	= $_POST['subcomponent_enable']!=''?$_POST['subcomponent_enable']:'no';
	$enable_subcomp = array('enable' => $subcomponent_enable);
	$subcomponent_add 	=  $_POST['subcomponent_add']!=''?$_POST['subcomponent_add']:'no';
	$add_subcomp = array('add' => $subcomponent_add);
	$subcomponent_edit 	=  $_POST['subcomponent_edit']!=''?$_POST['subcomponent_edit']:'no';
	$edit_subcomp = array('edit' => $subcomponent_edit);
	$subcomponent_delete =  $_POST['subcomponent_delete']!=''?$_POST['subcomponent_delete']:'no';
	$delete_subcomp = array('delete' => $subcomponent_delete);
	
	$subcomp= $enable_subcomp + $add_subcomp + $edit_subcomp + $delete_subcomp;
	$val3 = array('sub component' => $subcomp);
	
	// ------------------------  Game -----------------------------------------
	$game_enable	= $_POST['game_enable']!=''?$_POST['game_enable']:'no';
	$enable_game = array('enable' => $game_enable);
	$game_add 	=  $_POST['game_add']!=''?$_POST['game_add']:'no';
	$add_game = array('add' => $game_add);
	$game_edit 	=  $_POST['game_edit']!=''?$_POST['game_edit']:'no';
	$edit_game = array('edit' => $game_edit);
	$game_delete =  $_POST['game_delete']!=''?$_POST['game_delete']:'no';
	$delete_game = array('delete' => $game_delete);
	
	$game= $enable_game + $add_game + $edit_game + $delete_game;
	$val4 = array('game' => $game);
	
	// ------------------------  Scenario -----------------------------------------
	$scenario_enable	= $_POST['scenario_enable']!=''?$_POST['scenario_enable']:'no';
	$enable_scenario = array('enable' => $scenario_enable);
	$scenario_add 	=  $_POST['scenario_add']!=''?$_POST['scenario_add']:'no';
	$add_scenario = array('add' => $scenario_add);
	$scenario_edit 	=  $_POST['scenario_edit']!=''?$_POST['scenario_edit']:'no';
	$edit_scenario = array('edit' => $scenario_edit);
	$scenario_delete =  $_POST['scenario_delete']!=''?$_POST['scenario_delete']:'no';
	$delete_scenario = array('delete' => $scenario_delete);
	
	$scenario= $enable_scenario + $add_scenario + $edit_scenario + $delete_scenario;
	$val5 = array('scenario' => $scenario);
	
	// ------------------------  Formulas -----------------------------------------
	$formulas_enable	= $_POST['formulas_enable']!=''?$_POST['formulas_enable']:'no';
	$enable_formulas = array('enable' => $formulas_enable);
	$formulas_add 	=  $_POST['formulas_add']!=''?$_POST['formulas_add']:'no';
	$add_formulas = array('add' => $formulas_add);
	$formulas_edit 	=  $_POST['formulas_edit']!=''?$_POST['formulas_edit']:'no';
	$edit_formulas = array('edit' => $formulas_edit);
	$formulas_delete =  $_POST['formulas_delete']!=''?$_POST['formulas_delete']:'no';
	$delete_formulas = array('delete' => $formulas_delete);
	
	$formulas= $enable_formulas + $add_formulas + $edit_formulas + $delete_formulas;
	$val6 = array('formulas' => $formulas);
	
	// ------------------------  Linkage -----------------------------------------
	$linkage_enable	= $_POST['linkage_enable']!=''?$_POST['linkage_enable']:'no';
	$enable_linkage = array('enable' => $linkage_enable);
	$linkage_add 	=  $_POST['linkage_add']!=''?$_POST['linkage_add']:'no';
	$add_linkage = array('add' => $linkage_add);
	$linkage_edit 	=  $_POST['linkage_edit']!=''?$_POST['linkage_edit']:'no';
	$edit_linkage = array('edit' => $linkage_edit);
	$linkage_delete =  $_POST['linkage_delete']!=''?$_POST['linkage_delete']:'no';
	$delete_linkage = array('delete' => $linkage_delete);
	
	$linkage= $enable_linkage + $add_linkage + $edit_linkage + $delete_linkage;
	$val7 = array('linkage' => $linkage);
	
	// ------------------------  end -----------------------------------------
	
	$userrights = $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
	
	//Get values in array
	$userdetails = (object) array(
			'fname'			=>	$_POST['fname'],
			'lname'			=>	$_POST['lname'],
			'username'		=>	$_POST['username'],
			'usertype'		=>	'admin',
			'admin_access'	=>	1,
			'status'		=>	1,
			'admin_rights'		=>	json_encode($userrights),
			'date_time'		=>	date('Y-m-d H:i:s')
	);


	$uid = $_POST['userid'];
	// Validate fields not empty
	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username'])
	){
		
				if(!empty($_POST['password']) && !empty($_POST['retypepass'])){
					if($_POST['password'] == $_POST['retypepass']){
						$userdetails->password	=	md5($_POST['password']);
						
						$result = $functionsObj->UpdateData('GAME_ADMINUSERS', $userdetails, 'id', $uid, 0);
						if($result === true){
							
								$_SESSION['msg'] = "Password and Details Updated";
								$_SESSION['type[0]'] = "inputSuccess";
								$_SESSION['type[1]'] = "has-success";
								header("Location:".site_root."ux-admin/adminlist");
								exit(0);
							
						}else{
							$msg = "Error : ". $result;
							$type[0] = "inputError";
							$type[1] = "has-error";
						}
					}else{
						$msg = "Password and Re-type password do not match";
						$type[0] = "inputError";
						$type[1] = "has-error";
					}
				}else{
					$result = $functionsObj->UpdateData('GAME_ADMINUSERS', $userdetails, 'id', $uid, 0);
					if($result === true){
						
							$_SESSION['msg'] = "Details Updated";
							$_SESSION['type[0]'] = "inputSuccess";
							$_SESSION['type[1]'] = "has-success";
							header("Location:".site_root."ux-admin/adminlist");
							exit(0);
						
					}else{
						$msg = "Error : ". $result;
						$type[0] = "inputError";
						$type[1] = "has-error";
					}
				}
			
		
	}else{
		$msg = "Field cannot be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

if(isset($_GET['edit'])){
	$id = base64_decode($_GET['edit']);
	if($_SESSION['ux-admin-id'] != $id){
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array('id='.$id), '','', '','', 0);
		$userdetails = $functionsObj->FetchObject($object);
	
		$name = explode(" ",$userdetails->name);
	
		$where  = array('uid='.$id);
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS_ACCESS', $where, '','', '','', 0);
		$useraccessdetails = $functionsObj->FetchObject($object);
		
		$selected_cats = json_decode($useraccessdetails->category);
	}else{
		$msg = "Access Denied";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}elseif(isset($_GET['delete'])){
	$id = base64_decode($_GET['delete']);
	if($_SESSION['ux-admin-id'] != $id){
		$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('del_stat' => 1), 'id', $id, 0);
		if($result === true){
			$_SESSION['msg'] = "User Deleted";
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location:".site_root."/ux-admin/adminlist");
			exit(0);
		}else{
			$msg = "Cannot delete User";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
	}else{
			$msg = "Access Denied";
			$type[0] = "inputError";
			$type[1] = "has-error";
	}
}elseif(isset($_GET['stat'])){
	$id = base64_decode($_GET['stat']);
	if($_SESSION['ux-admin-id'] != $id){
		$object = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', array('id='.$id), '', '', '', '', 0);
		$details = $functionsObj->FetchObject($object);
		
		if($details->status == 1){
			$status = 'Deactivated';
			$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('status'=> 0), 'id', $id, 0);
		}else{
			$status = 'Activated';
			$result = $functionsObj->UpdateData('GAME_ADMINUSERS', array('status'=> 1), 'id', $id, 0);
		}
		if($result === true){
			$_SESSION['msg'] = "User account ". $status;
			$_SESSION['type[0]'] = "inputSuccess";
			$_SESSION['type[1]'] = "has-success";
			header("Location: ".site_root."ux-admin/adminlist");
			exit(0);
		}else{
			$msg = "Error: ".$result;
			$type[0] = "inputSuccess";
			$type[1] = "has-success";
		}
	
	}else{
		$msg = "Access Denied";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}

$where = array("id not in (1)", "id !=".$_SESSION['ux-admin-id'] );
$adminUsersList = $functionsObj->SelectData(array(), 'GAME_ADMINUSERS', $where, "", "", "", "", 0);

//$cities = $functionsObj->SelectData(array('distinct city'), 'BUSINESS_DETAILS', array(), '', '', '', 0);

//$categories = $functionsObj->SelectData(array(), 'SERVICES', array(), '', '', '', 0);

include_once doc_root."ux-admin/view/adminUsers.php";
?>