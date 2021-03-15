<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();
$gameData  = $functionsObj->RunQueryFetchObject('SELECT Game_ID,Game_Name FROM GAME_GAME WHERE Game_Delete=0 ORDER BY Game_Name');
// echo "<pre>"; print_r($gameData); die('');
include_once doc_root.'ux-admin/view/linkgame.php';
?>