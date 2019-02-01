<?php
include_once '../config/settings.php'; 
include_once '../config/functions.php'; 
set_time_limit(300);

$functionsObj = new Functions();

include_once '../includes/lib/phpchartdir.php';

$ChartID            = $_GET['ChartID'];
$gameid             = $_GET['gameid'];
$userid             = $_GET['userid'];
$sqlchart           = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$ChartID;
$chartDetails       = $functionsObj->ExecuteQuery($sqlchart);
$ResultchartDetails = $functionsObj->FetchObject($chartDetails);
$sqllink            = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$ResultchartDetails->Chart_ScenarioID;
$LinkId             =  $functionsObj->ExecuteQuery($sqllink);
$ResultLinkId       = $functionsObj->FetchObject($LinkId);
$sqlexist           = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
$object       = $functionsObj->ExecuteQuery($sqlexist);
	//chart_component and subcomponent
$comp         = $ResultchartDetails->Chart_Components;
$subcomp      = $ResultchartDetails->Chart_Subcomponents;
$chartname    = $ResultchartDetails->Chart_Name;
$charttype    = $ResultchartDetails->Chart_Type;
$arrayComp    = explode(',',$comp);
$arraysubcomp = explode(',',$subcomp);
	//print_r($arrayComp);

	//echo $object->num_rows;
if($object->num_rows > 0)
{
	while($row = $object->fetch_object())
	{
		$compdata  = $row->input_key;
		$allcompID = explode('_',$compdata);
		$compID    = $allcompID[2];
		if (in_array($compID, $arrayComp) && $allcompID[1]=='comp')
		{
			$sqlcompName                     = "SELECT Comp_Name FROM GAME_COMPONENT WHERE Comp_ID = ".$compID;
			$compDetails                     = $functionsObj->ExecuteQuery($sqlcompName);
			$compName                        = $functionsObj->FetchObject($compDetails);
			$dataChart[$compName->Comp_Name] = $row->input_current;
		}
		if (in_array($compID, $arraysubcomp) && $allcompID[1]=='subc')
		{
			$sqlsubcompName                         = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
			$subcompDetails                         = $functionsObj->ExecuteQuery($sqlsubcompName);
			$subcompName                            = $functionsObj->FetchObject($subcompDetails);
			$dataChart[$subcompName->SubComp_Name] .= $row->input_current;
		}
	}
}

foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;
}
// echo "<pre>"; print_r($data); exit;

# The value to display on the meter
	// this value need to be modified
// $value = 52.55;

# Create an AngularMeter object of size 300 x 180 pixels with transparent background
$m = new AngularMeter(300, 180, Transparent);

# Center at (150, 150), scale radius = 128 pixels, scale angle -90 to +90 degrees
$m->setMeter(150, 150, 128, -90, 90);

# Add a pale grey (0xeeeeee) scale background of 148 pixels radius, with a 10 pixel thick light grey
# (0xcccccc) border
$m->addScaleBackground(148, 0xeeeeee, 10, 0xcccccc);

# Meter scale is 0 - 100, with major tick every 20 units, minor tick every 10 units, and micro tick
# every 5 units
$m->setScale(0, 100, 20, 10, 5);

# Set the scale label style to 15pt Arial Italic. Set the major/minor/micro tick lengths to 16/16/10
# pixels pointing inwards, and their widths to 2/1/1 pixels.
$m->setLabelStyle("ariali.ttf", 16);
$m->setTickLength(-16, -16, -10);
$m->setLineWidth(0, 2, 1, 1);

# Add a smooth color scale to the meter
$smoothColorScale = array(0, #006400, 25, #07FF00, 50, #FFA500, 75, #FF7373, 100, #FF0000);
// $smoothColorScale = array(0, 0x3333ff, 25, 0x0088ff, 50, 0x00ff00, 75, 0xdddd00, 100, 0xff0000);
$m->addColorScale($smoothColorScale);
$m->addColorScale($smoothColorScale);

# Add a text label centered at (150, 125) with 15pt Arial Italic font
$m->addText(150, 125, ".", "ariali.ttf", 15, TextColor, BottomCenter);

# Add a red (0xff0000) pointer at the specified value
// $m->addPointer2($value, 0xff0000);
// adding this line for value and removing above line coz it is for demo
$m->addPointer2($data[0], 0xff0000);

# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));
?>