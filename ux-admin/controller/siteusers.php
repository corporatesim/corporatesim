<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();

$object   = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename = $functionsObj->FetchObject($object);

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit')
{
	$userdetails = (object) array(
		'User_fname'      =>	$_POST['fname'],
		'User_lname'      =>	$_POST['lname'],
		'User_mobile'     =>	$_POST['mobile'],
		'User_email'      =>	$_POST['email'],
		'User_companyid'  =>	$_POST['company'],
		'User_username'   =>	$_POST['username'],			
		'User_csv_status' =>	2,			
		'User_datetime'   =>	date('Y-m-d H:i:s')
	);
	
	if( !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username']) && !empty($_POST['mobile'])	&& !empty($_POST['email']) )
	{
		$where  = array("`User_email` ='".$_POST['email']."' OR `User_username` ='".$_POST['username']."'");
		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 1);
		//exit();
		if($object->num_rows > 0)
		{
			$msg     = "Email address or mobile number already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		else
		{
			$result = $functionsObj->InsertData('GAME_SITE_USERS', $userdetails, 0, 0);
			if($result)
			{
				$uid      = $functionsObj->InsertID();
				$to       = $_POST['email'];
				$username = $_POST['username'];
				$password = $functionsObj->randomPassword(); 
				//"123456";
					//md5($password)
				$login_details = array(
					'Auth_userid'    => $uid,
					'Auth_password'  => $password,
					'Auth_username'  => $_POST['username'],
					'Auth_date_time' =>	date('Y-m-d H:i:s')
				);
				
				$result1 = $functionsObj->InsertData('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
				if($result1)
				{
					$from     = "webmaster@simulation.com";
					$subject  = "New Account created for Simulation Game";
					$message  = "Dear User";
					$message .= "<p>Username : ".$username;
					$message .= "<p>Password : ".$password;

					$header   = "From:" . $from . "\r\n";
					$header  .= "MIME-Version: 1.0\r\n";
					$header  .= "Content-type: text/html; charset: utf8\r\n";
					//try{
					mail($to, $subject, $message, $header);
					//}catch(Exception $e)					
					//{
					//	echo $e;
					//	exit();
					//}						

					$_SESSION['msg']     = "User account created successfully";
					$_SESSION['type[0]'] = "inputSuccess";
					$_SESSION['type[1]'] = "has-success";

					header("Location: ".site_root."ux-admin/siteusers");
					exit(0);
				}
				else
				{
					$msg = "Error: ".$result1;
					//echo $msg;
					//exit();
					$type[0] = "inputError";
					$type[1] = "has-error";
				}
			}
			else
			{
				$msg     = "Error: ".$result;
				$type[0] = "inputError";
				$type[1] = "has-error";
			}
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
	$userdetails = (object) array(
		'User_fname'     =>	$_POST['fname'],
		'User_lname'     =>	$_POST['lname'],
		'User_mobile'    =>	$_POST['mobile'],
		'User_email'     =>	$_POST['email'],
		'User_companyid' =>	$_POST['company'],
		'User_username'  =>	$_POST['username'],			
		'User_datetime'  =>	date('Y-m-d H:i:s')
	);	
	if( !empty($_POST['fname']) && !empty($_POST['lname'])  && !empty($_POST['mobile'])	&& !empty($_POST['email']) && !empty($_POST['username']))
	{
		$uid = $_POST['id'];

		$where = array(
			"(`User_email` ='".$userdetails->User_email."'
			OR `User_mobile` ='".$userdetails->User_mobile."')",
			"User_id != ". $uid
		);
		$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', $where, '', '', '', '', 0);

		if($object->num_rows > 0)
		{
			$msg     = "Email address or mobile number already registered";
			$type[0] = "inputError";
			$type[1] = "has-error";
		}
		else
		{
			$result   = $functionsObj->UpdateData('GAME_SITE_USERS', $userdetails, 'User_id', $uid, 0);
			$userauth = (object) array(
				'Auth_password'		=>	$_POST['password']
			);
			$result1 = $functionsObj->UpdateData('GAME_USER_AUTHENTICATION', $userauth, 'Auth_userid', $uid, 0);
			if($result === true)
			{
				$_SESSION['msg']     = "User details updated successfully";
				$_SESSION['type[0]'] = "inputSuccess";
				$_SESSION['type[1]'] = "has-success";
				header("Location: ".site_root."ux-admin/siteusers");
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
	else
	{
		$msg     = "Field(s) can not be empty";
		$type[0] = "inputError";
		$type[1] = "has-error";
	}
}



if(isset($_POST['submit']) && $_POST['submit'] == 'Download')
{
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
	ob_end_clean();
	$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
	$numberFormat   = '#,#0.##;[Red]-#,#0.##';
	$objSheet       = $objPHPExcel->getActiveSheet();
	
	$objSheet->setTitle('Linkage');
	$objSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(10);
	
	$objSheet->getCell('A1')->setValue('User ID');
	$objSheet->getCell('B1')->setValue('User First Name');
	$objSheet->getCell('C1')->setValue('User Last Name');
	$objSheet->getCell('D1')->setValue('Username');
	$objSheet->getCell('E1')->setValue('Mobile');
	$objSheet->getCell('F1')->setValue('Email');
	
	$sql     = "select * from GAME_SITE_USERS where 1=1 order by User_id desc";	
	$objlink = $functionsObj->ExecuteQuery($sql);
	
	if($objlink->num_rows > 0)
	{
		$i=2;
		while($row= $objlink->fetch_object())
		{
			$objSheet->getCell('A'.$i)->setValue($row->User_id);
			$objSheet->getCell('B'.$i)->setValue($row->User_fname);
			$objSheet->getCell('C'.$i)->setValue($row->User_lname);
			$objSheet->getCell('D'.$i)->setValue($row->User_username);
			$objSheet->getCell('E'.$i)->setValue($row->User_mobile);
			$objSheet->getCell('F'.$i)->setValue($row->User_email);
			$i++;
		}
	}
	//$objPHPExcel->
	$objSheet->getColumnDimension('A')->setWidth(10);	
	$objSheet->getColumnDimension('B')->setWidth(20); 
	$objSheet->getColumnDimension('C')->setWidth(20); 
	$objSheet->getColumnDimension('D')->setWidth(30);
	$objSheet->getColumnDimension('E')->setWidth(20);	
	$objSheet->getColumnDimension('F')->setWidth(30);
	
	$objSheet->getStyle('A1:A'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('B1:B'.$i)->getAlignment()->setWrapText(true);
	$objSheet->getStyle('D1:D100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('F1:F100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('J1:J100')->getAlignment()->setWrapText(true);
	$objSheet->getStyle('K1:K100')->getAlignment()->setWrapText(true); 
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="users.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
	//$objWriter->save('testoutput.xlsx');
	//$objWriter->save('testlinkage.csv'); 
}

// Edit Siteuser
if(isset($_GET['edit']))
{
	$header      = 'Edit Site User';
	$uid         = base64_decode($_GET['edit']);
	$object      = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$uid), '', '', '', '', 0);
	$userdetails = $functionsObj->FetchObject($object);
	
	$object1     = $functionsObj->SelectData(array(), 'GAME_USER_AUTHENTICATION', array('Auth_userid='.$uid), '', '', '', '', 0);
	$userauth    = $functionsObj->FetchObject($object1);
	$url         = site_root."ux-admin/siteusers";
	$file        = 'addedit.php';
}
elseif(isset($_GET['add']))
{
	// Add Siteuser
	$header = 'Add Site User';
	$url    = site_root."ux-admin/siteusers";
	$file   = 'addedit.php';
}
elseif(isset($_GET['del']))
{
	// Delete Siteuser
	$id     = base64_decode($_GET['del']);
	$result = $functionsObj->DeleteData('GAME_SITE_USERS','User_id',$id,0);
	//$result = $functionsObj->UpdateData('GAME_SITE_USERS', array( 'User_Delete' => 1 ), 'User_id', $id, 0);
	//if($result === true){
	header("Location: ".site_root."ux-admin/siteusers");
	exit(0);

	//}else{
	//	$msg = "Error: ".$result;
	//	$type[0] = "inputError";
	//	$type[1] = "has-error";
	//}
}
elseif(isset($_GET['stat']))
{
	// Enable disable siteuser account
	$id      = base64_decode($_GET['stat']);
	$object  = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_id='.$id), '', '', '', '', 1);
	$details = $functionsObj->FetchObject($object);
	
	if($details->User_status == 1)
	{
		$status = 'Deactivated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 0), 'User_id', $id, 0);
	}
	else
	{
		$status = 'Activated';
		$result = $functionsObj->UpdateData('GAME_SITE_USERS', array('User_status'=> 1), 'User_id', $id, 0);
	}
	if($result === true)
	{
		$_SESSION['msg']     = "User account ". $status;
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location: ".site_root."ux-admin/siteusers");
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
	$sql="SELECT  u.*,ua.Auth_password as pwd, (SELECT count(*) FROM GAME_USERGAMES WHERE UG_UserID = u.User_id) as gamecount 
	FROM `GAME_SITE_USERS` u INNER JOIN GAME_USER_AUTHENTICATION ua on u.User_id=ua.Auth_userid
	WHERE User_Delete = 0 
	ORDER BY User_datetime DESC";
	//$sql="SELECT  u.*, (SELECT count(*) FROM GAME_USERGAMES WHERE UG_UserID = u.User_id) as gamecount FROM `GAME_SITE_USERS` u WHERE User_Delete = 0 ORDER BY User_datetime DESC";
	
	//$object = $functionsObj->SelectData(array(), 'GAME_SITE_USERS', array('User_Delete=0'), 'User_datetime DESC', '', '', '', 0);
	$object = $functionsObj->ExecuteQuery($sql);
	$file   = 'list.php';
}

include_once doc_root.'ux-admin/view/siteusers/'.$file;