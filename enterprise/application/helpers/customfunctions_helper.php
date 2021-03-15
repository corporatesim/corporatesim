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

