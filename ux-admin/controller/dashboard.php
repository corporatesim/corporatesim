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

// data for bar chart
$GameSql  = "SELECT 'Game' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM Game_Datetime) AS YEAR FROM `GAME_GAME` WHERE Game_Delete=0 GROUP BY YEAR ORDER BY YEAR ASC";
$GameData = $functionsObj->RunQueryFetchObject($GameSql);

$ScenarioSql  = "SELECT 'Scenario' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM Scen_Datetime) AS YEAR FROM `GAME_SCENARIO` WHERE Scen_Delete=0 GROUP BY YEAR ORDER BY YEAR ASC";
$ScenarioData = $functionsObj->RunQueryFetchObject($ScenarioSql);

$AreaSql  = "SELECT 'Area' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM Area_CreateDate) AS YEAR FROM `GAME_AREA` WHERE Area_Delete=0 GROUP BY YEAR ORDER BY YEAR ASC";
$AreaData = $functionsObj->RunQueryFetchObject($AreaSql);

$ComponentSql  = "SELECT 'Component' AS Title, COUNT(*) AS Count, EXTRACT(YEAR FROM Comp_Date) AS YEAR FROM `GAME_COMPONENT` WHERE Comp_Delete=0 GROUP BY YEAR ORDER BY YEAR ASC";
$ComponentData = $functionsObj->RunQueryFetchObject($ComponentSql);

$chartData = array($GameData, $AreaData, $ScenarioData, $ComponentData);

// $dataChart = array();
// for($i=0; $i<count($chartData); $i++)
// {
// 	$dataCount = '';
// 	foreach ($chartData[$i] as $chartDataRow)
// 	{
// 		$dataCount .= $chartDataRow->Count.',';
// 	}
// 		$dataChart[$chartData[$i][0]->Title] = trim($dataCount,',');
// }
// echo "<pre>"; print_r($chartData); print_r($dataChart); exit();
// setting the game background and border color
$backgroundColor = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)');

$borderColor     = array('rgba(51, 122, 183, 1)', 'rgba(92, 184, 92, 1)', 'rgba(240, 173, 78, 1)', 'rgba(217, 83, 79, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)');

include_once doc_root.'ux-admin/view/dashboard.php';
?>