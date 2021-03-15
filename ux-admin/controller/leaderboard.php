<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();

$file   = 'personalizeOutcome.php';
$header = 'Leaderboard/Collaboration Management';

// if($queryExecute)
// {
// 	$tr_msg = "Record Saved Successfully";
// 	$_SESSION['tr_msg'] = $tr_msg;
// }
// else
// {
// 	$er_msg = "Database Connection Error, Please Try Later";
// 	$_SESSION['er_msg'] = $er_msg;
// }

include_once doc_root.'ux-admin/view/leaderboard.php';