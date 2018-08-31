<?php
require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$object = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename = $functionsObj->FetchObject($object);

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
	$userdetails = (object) array(
			'User_fname'		=>	$_POST['fname'],
			'User_lname'		=>	$_POST['lname'],
			'User_mobile'	=>	$_POST['mobile'],
			'User_email'		=>	$_POST['email'],
			'User_companyid'	=>	$_POST['company'],
			'User_username'	=>	$_POST['username'],			
			'User_datetime'	=>	date('Y-m-d H:i:s')
	);
	
	if( !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username'])  
		&& !empty($_POST['mobile'])	&& !empty($_POST['email']) 
	){
		$where = array("`User_email` ='".$userdetails->email."' OR `User_mobile` ='".$userdetails->mobile."'");
		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);
		if($object->num_rows > 0){
			$msg = "Email address or mobile number already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}else{
			$result = $functionsObj->InsertData('GAME_SITE_USERS', $userdetails, 0, 0);
			if($result){
				$uid = $functionsObj->InsertID();
				$to = $_POST['email'];
				$username = $_POST['username'];
				
				$password = "123456";
				//$functionsObj->randomPassword();
					
				$login_details = array(
						'Auth_userid'	=> $uid,
						'Auth_password'	=>md5($password),
						'Auth_date_time'	=>	date('Y-m-d H:i:s')
				);
				
				//$userdetails = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 1);
				//echo $userdetails->User_email;
				//echo $userdetails->User_username;
				//exit();				
				
				$result1 = $functionsObj->InsertData('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
				if($result1){
					// Send Mail to user
					// Fetch Email template
				//	$object = $functionsObj->SelectData(array(), 'EMAILTEMPLATES', array('id=1'), '', '', '', '', 0);
				//	$emailtemp = $functionsObj->FetchObject($object);
			
					//$userdetails = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
					//$to = $emailto;
					//"mugdha@uxexpert.in";
					//$userdetails->User_email;
					
					$from = "webmaster@simulation.com";
					$subject = "New Account created for Simulation Game";
					$message = "Dear User";
					$message .= "<p>Username : ".$username;
					//$userdetails->User_username;
					$message .= "<p>Password : ".$password;

					$header = "From:" . $from . "\r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html; charset: utf8\r\n";
					//try{
//					echo "data inserted";
//					echo "Userid:".$uid."</br>";
//					echo "to:".$to."</br>";
//					echo "Username:".$username."</br>";
//					echo "Userid:".$password."</br>";
//					echo "from:".$from."</br>";
//					echo "subject:".$subject."</br>";
//					echo "message:".$message."</br>";
//					echo "header:".$header."</br>";

					mail($to, $subject, $message, $header);
//					echo "Mail sent";
//										exit();
					//}catch(Exception $e)					
					//{
					//	echo $e;
					//	exit();
					//}						
					
				//	$to = $userdetails->email;
				//	$from = $emailtemp->from_email;
			
				//	$subject = str_replace("[SITENAME]", $sitename->value, $emailtemp->subject);
				//	$message = str_replace('[SITENAME]', $sitename->value, $emailtemp->content);
				//	$message = str_replace("[LOGO]", $logo, $message);
				//	$message = str_replace("[SITELINK]", site_root, $message);
			
				//	$message = str_replace("[NAME]", $userdetails->fname, $message);
				//	$message = str_replace("[URL]", site_root."register", $message);
			
				//	$message = str_replace("[USERNAME]", $userdetails->email, $message);
				//	$message = str_replace("[PASSWORD]", $password, $message);
			
				//	$header = "From:" . $from . "\r\n";
				//	$header .= "MIME-Version: 1.0\r\n";
				//	$header .= "Content-type: text/html; charset: utf8\r\n";
				//	mail($to, $subject, $message, $header);
			
					$_SESSION['msg'] = "User account created successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";
					header("Location: ".site_root."ux-admin/siteusers");
					exit(0);
				}else{
					$msg = "Error: ".$result1;
					//echo $msg;
					//exit();
					$type[0] = "inputError";
					$type[1] = "has-error";
				}
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

if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
	$userdetails = (object) array(
			'User_fname'		=>	$_POST['fname'],
			'User_lname'		=>	$_POST['lname'],
			'User_mobile'	=>	$_POST['mobile'],
			'User_email'		=>	$_POST['email'],
			'User_companyid'	=>	$_POST['company'],
			'User_username'	=>	$_POST['username'],			
			'User_datetime'	=>	date('Y-m-d H:i:s')
	);	
	if( !empty($_POST['fname']) && !empty($_POST['lname'])  && !empty($_POST['mobile'])
		&& !empty($_POST['email']) && !empty($_POST['username']) 
		){
		$uid = $_POST['id'];
		
		$where = array(
				"(`User_email` ='".$userdetails->User_email."'
				OR `User_mobile` ='".$userdetails->User_mobile."')",
				"User_id != ". $uid
		);
		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);
		
		if($object->num_rows > 0){
			$msg = "Email address or mobile number already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}else{
			$result = $functionsObj->UpdateData('GAME_SITE_USERS', $userdetails, 'User_id', $uid, 0);
			if($result === true){
				$_SESSION['msg'] = "User details updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location: ".site_root."ux-admin/siteusers");
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

// Edit Siteuser
if(isset($_GET['edit'])){
	$header = 'Edit Site User';
	$uid = base64_decode($_GET['edit']);
	$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
	$userdetails = $functionsObj->FetchObject($object);
	$url = site_root."ux-admin/siteusers";
	$file = 'addedit.php';
	
}elseif(isset($_GET['add'])){
	// Add Siteuser
	$header = 'Add Site User';
	$url = site_root."ux-admin/siteusers";
	
	$file = 'addedit.php';

}elseif(isset($_GET['del'])){
	// Delete Siteuser
	$id = base64_decode($_GET['del']);
	$result = $functionsObj->UpdateData('GAME_SITE_USERS', array( 'User_Delete' => 1 ), 'User_id', $id, 0);
	if($result === true){
		header("Location: ".site_root."ux-admin/siteusers");
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}elseif(isset($_GET['stat'])){
	// Enable disable siteuser account
	$id = base64_decode($_GET['stat']);
	$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->User_status == 1){
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 0), 'User_id', $id, 0);
	}else{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 1), 'User_id', $id, 0);
	}
	if($result === true){
		$_SESSION['msg'] = "User account ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/siteusers");
		exit(0);
	}else{
		$msg = "Error: ".$result;
		$type[0] = "inputSuccess";
		$type[1] = "has-success";
	}
}else{
	// fetch siteuser list from db
	$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_Delete=0'), 'User_datetime DESC', '', '', '', 0);
	$file = 'list.php';
}

include_once doc_root.'ux-admin/view/siteusers/'.$file;