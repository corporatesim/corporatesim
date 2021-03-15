<?php
include_once '../../config/settings.php';
include_once '../../config/functions.php';
set_time_limit(300);

$funObj = new Functions();
$userid = $_SESSION['userid'];

$timerVal=$_REQUEST["timerVal"];

$array = array (
	'timerVal' => $timerVal
);


//$result = $funObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );


?>