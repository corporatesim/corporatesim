<?php

phpinfo();
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
set_time_limit(300);

$functionsObj = new Functions();
$userid       = $_SESSION['userid'];
$userName     = $_SESSION['username'];
$gameid       = $_GET['ID'];

$sql    = "SELECT Link_ID,Link_GameID,Link_ScenarioID,Link_Hour,Link_Min FROM `game_linkage`";
$object = $functionsObj->ExecuteQuery($sql);
echo "<pre>";
while ($res = $functionsObj->FetchObject($object))
{
	print_r($res);
	echo ($res->Link_Hour*60)+$res->Link_Min.' min<br>';
}