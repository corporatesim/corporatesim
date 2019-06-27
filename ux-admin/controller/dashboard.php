<?php

require_once doc_root.'ux-admin/model/model.php';
$functionsObj = new Model();

$gameSql   = "SELECT * FROM GAME_GAME WHERE Game_Delete=0";
$totalGame = $functionsObj->RunQueryFetchCount($gameSql);

$scenSql   = "SELECT * FROM GAME_SCENARIO WHERE Scen_Delete=0";
$totalScen = $functionsObj->RunQueryFetchCount($scenSql);

$areaSql   = "SELECT * FROM GAME_AREA WHERE Area_Delete=0";
$totalArea = $functionsObj->RunQueryFetchCount($areaSql);

$compSql   = "SELECT * FROM GAME_COMPONENT WHERE Comp_Delete=0";
$totalComp = $functionsObj->RunQueryFetchCount($compSql);

// $normalGameSql   = "SELECT * FROM GAME_GAME WHERE Game_Delete=0 AND Game_Status='0'";
// $normalGame = $functionsObj->RunQueryFetchCount($normalGameSql);
include_once doc_root.'ux-admin/view/dashboard.php';
?>