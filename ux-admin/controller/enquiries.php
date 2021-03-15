<?php
include_once doc_root.'ux-admin/model/model.php';

$functionsObj = new Model();

// Fetch Sitename from sitesettings
$object = $functionsObj->SelectData(array(), 'GAME_SITESETTINGS', array('id=1'), '', '', '', '', 0);
$sitename = $functionsObj->FetchObject($object);

if(isset($_POST['Reply'])){
	if(!empty($_POST['reply_msg']) && !empty($_POST['subject'])){
		$enq_id = $_POST['enquiry_id']; // get enquiry id

		$logo = '<img src="'.site_root.'img/logo.png" >'; // set logo image

		$object = $functionsObj->SelectData(array(), 'EMAILTEMPLATES', array('id=7'), '', '', '', '', 0); // fetch emailtemplate
		$emailtemp = $functionsObj->FetchObject($object);
		$from = $emailtemp->from_email; // set from email

		$object = $functionsObj->SelectData(array(), 'ENQUIRIES', array('eid='.$enq_id), '', '', '', '', 0); // get enquiry details
		$details = $functionsObj->FetchData($object);

		$to = $details['email'];
		$subject = $_POST['subject']; // set email subject
		$data = $_POST['reply_msg']; // set message

		$message = $emailtemp->content;
		$message = str_replace("[DETAILS]", $data, $message);
		$message = str_replace("[LOGO]", $logo, $message);
		$message = str_replace("[SITENAME]", $sitename->value, $message);
		$message = str_replace("[SITELINK]", site_root, $message);

		$header = "From:" . $from . "\r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html; charset: utf8\r\n";
		if(mail($to, $subject, $message, $header)){
			$_SESSION['msg']		=	'Message Sent Successfully';
			$_SESSION['type[0]']	=	'inputSuccess';
			$_SESSION['type[1]']	=	'has-success';

			header("location:".site_root."ux-admin/ManageEnquiry");
			exit();
		}else{
			$msg		=	'Error: Mail not Sent';
			$type[0]	=	'inputError';
			$type[1]	=	'has-error';
		}
	}else{
		$msg		=	'Message can not be empty';
		$type[0]	=	'inputError';
		$type[1]	=	'has-error';
	}
}

if(isset($_GET['view'])){
	$enq_id = base64_decode($_GET['view']);
	$fields = array();
	$where = array('eid='.$enq_id);
	$object = $functionsObj->SelectData($fields, 'ENQUIRIES', $where, '', '', '', '', 0);
	$enq_details = $functionsObj->FetchData($object);
	include_once doc_root.'ux-admin/view/viewEnquiry.php';

}elseif(isset($_GET['delete'])){
	$enq_id = base64_decode($_GET['delete']);
	
	$result = $functionsObj->UpdateData('ENQUIRIES', array('del_stat' => 1), 'eid', $enq_id);
	if($result === true){
		$_SESSION['msg'] 	 = "Enquiry Deleted Successfully";
		$_SESSION['type[0]'] = "inputSuccess";
		$_SESSION['type[1]'] = "has-success";
		header("Location:".site_root."ux-admin/ManageEnquiry");
	}
}elseif(isset($_GET['reply'])){
	$enq_id = base64_decode($_GET['reply']);

	$fields = array();
	$where = array('eid='.$enq_id);
	$object = $functionsObj->SelectData($fields, 'ENQUIRIES', $where, '', '', '', '', 0);
	$enq_details = $functionsObj->FetchData($object);

	$header = "Reply Enquiry";
	include_once doc_root.'ux-admin/view/replyEnquiry.php';
}else{
	$object = $functionsObj->SelectData(array(), 'ENQUIRIES', array('del_stat = 0'), 'date_time DESC', '', '', '', 0);
	include_once doc_root.'ux-admin/view/enquiries.php';
}
?>