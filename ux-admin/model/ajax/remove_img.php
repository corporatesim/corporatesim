<?php
include_once '../../../config/settings.php';
include_once doc_root.'config/functions.php';

$funObj = new Functions();

$path = doc_root."images/product_images/";

if(isset($_POST['imgname']) && isset($_POST['p_id']) /* isset($_GET['imgname']) && isset($_GET['p_id']) */){
	$p_id = $_POST['p_id'];
	$imgname = $_POST['imgname'];
	
	/* $p_id = $_GET['p_id'];
	$imgname = $_GET['imgname']; */
	
	$object = $funObj->SelectData(array(), 'products', array('p_id='.$p_id), '', '', '', '', 0);
	$result = $funObj->FetchObject($object);
	$imgs = (array) json_decode($result->imgs);
	$imgs_array = array();
	foreach($imgs as $key => $value){
		if( (string) $value == (string) $imgname ){
			if(file_exists($path.$value)){
				unlink($path.$value);
			}
		}else{
			$imgs_array[$key] = $value;
		}
	}
	
	$array = array(
			"imgs" => !empty($imgs_array) ? json_encode($imgs_array) : ''
	);
	
	$result = $funObj->UpdateData('products', $array, 'p_id', $p_id, 0);
	if($result === true){
		echo json_encode(array('success' => 1));
	}else {
		echo json_encode(array('success' => 0));
	}
}