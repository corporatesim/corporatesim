<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function prd($data=NULL){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die(' into_helper ');
}


function pr($data=NULL){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function SendMail($toEmail=NULL,$html=NULL,$subject=NULL)
{
	$ci =& get_instance();
	$ci->load->library('Phpmailer');
	$mail = new Phpmailer;

	$mail->isSMTP();
	$mail->SMTPDebug   = 0;
	$mail->Debugoutput = 'html';
	$mail->Host        = 'smtp.gmail.com';
	$mail->Port        = 587;
	$mail->SMTPSecure  = 'tls';
	$mail->SMTPAuth    = true;
	$mail->IsHTML(true);
	$mail->Username    = 'goyalsajal9654@gmail.com';
	$mail->Password    = 'digialayatesting';
  // $mail->setFrom('bhagwatpsahu8@gmail.com', 'Digialaya');
	$mail->addAddress($toEmail);
	$mail->Subject = 'Digialaya - ' .$subject;
	$mail->msgHTML($html);


	if($mail->send())
	{
		$result = 'success';
		echo json_encode($result);
	}
	else
	{ 
   // var_dump($mail->ErrorInfo); exit();
		$result = 'error';
		echo json_encode($result);
	}
}

function do_upload($imageDataArray=NULL)
{
	// $this->prd($imageDataArray);
	$CI =& get_instance();

	$config['upload_path']   = './datafiles/';
	$config['allowed_types'] = 'gif|jpeg|jpg|png';
	$config['max_size']      = 2048;
	if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");

	$CI->load->library('upload', $config);
	$CI->upload->initialize($config);

	if (!$CI->upload->do_upload('user_profilePic'))
	{ 
		$error = array('error' => $CI->upload->display_errors());
		return array('status' => 201, 'data' => implode(', ', $error));
	}
	else
	{
		$data                             = array('upload_data' => $CI->upload->data());
		$data['upload_data']['file_name'] = str_replace(' ', '_', $data['upload_data']['file_name']);
		return array('status' => 200, 'data' => $data['upload_data']['file_name']);
	} 

}

