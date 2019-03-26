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


$sqlexist = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
$object = $functionsObj->ExecuteQuery($sqlexist);
//chart_component and subcomponent
$comp         = $ResultchartDetails->Chart_Components;
$subcomp      = $ResultchartDetails->Chart_Subcomponents;
$chartname    = $ResultchartDetails->Chart_Name;
$charttype    = $ResultchartDetails->Chart_Type;
$arrayComp    = explode(',',$comp);
$arraysubcomp = explode(',',$subcomp);
	//print_r($arrayComp);

	//echo $object->num_rows;
if($object->num_rows > 0){

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
			$sqlsubcompName                        = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
			$subcompDetails                        = $functionsObj->ExecuteQuery($sqlsubcompName);
			$subcompName                           = $functionsObj->FetchObject($subcompDetails);
			$dataChart[$subcompName->SubComp_Name].= $row->input_current;
		}
	}
}


foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;

}
// echo "<pre>"; print_r($data); print_r($labels); exit();
# This script can draw different charts depending on the chartIndex
$chartIndex = (int)($_REQUEST["img"]);

# The value to display on the meter
// $value = 66;
// assigning value as per data
$value = $data[0];

# The background and border colors of the meters
$bgColor     = array(0x88ccff, 0xffdddd);
$borderColor = array(0x000077, 0x880000);

# Create an AngularMeter object of size 300 x 200 pixels with transparent background
$m = new AngularMeter(300, 200, Transparent);

# Center at (150, 150), scale radius = 124 pixels, scale angle -90 to +90 degrees
$m->setMeter(150, 150, 124, -90, 90);

# Background gradient color with brighter color at the center
$bgGradient = array(0, $m->adjustBrightness($bgColor[$chartIndex], 3), 0.75, $bgColor[$chartIndex]);

# Add a scale background of 148 pixels radius using the background gradient, with a 13 pixel thick
# border
$m->addScaleBackground(148, $m->relativeRadialGradient($bgGradient), 13, $borderColor[$chartIndex]);

# Meter scale is 0 - 100, with major tick every 20 units, minor tick every 10 units, and micro tick
# every 5 units
$m->setScale(0, 100, 20, 10, 5);

# Set the scale label style to 15pt Arial Italic. Set the major/minor/micro tick lengths to 16/16/10
# pixels pointing inwards, and their widths to 2/1/1 pixels.
$m->setLabelStyle("ariali.ttf", 16);
$m->setTickLength(-16, -16, -10);
$m->setLineWidth(0, 2, 1, 1);

# Demostrate different types of color scales and putting them at different positions
$smoothColorScale = array(0, 0x3333ff, 25, 0x0088ff, 50, 0x00ff00, 75, 0xdddd00, 100, 0xff0000);

if ($chartIndex == 0) {
  # Add the smooth color scale at the default position
	$m->addColorScale($smoothColorScale);
  # Add a red (0xff0000) triangular pointer starting from 38% and ending at 60% of scale radius,
  # with a width 6 times the default
	$m->addPointer2($value, 0xff0000, -1, TriangularPointer2, 0.38, 0.6, 6);
}
else
{
  # Add the smooth color scale starting at radius 124 with zero width and ending at radius 124
  # with 16 pixels inner width
	$m->addColorScale($smoothColorScale, 124, 0, 124, -16);
  # Add a red (0xff0000) pointer
	$m->addPointer2($value, 0xff0000);
}

# Configure a large "pointer cap" to be used as the readout circle at the center. The cap radius and
# border width is set to 33% and 4% of the meter scale radius. The cap color is dark blue
# (0x000044). The border color is light blue (0x66bbff) with a 60% brightness gradient effect.
$m->setCap2(Transparent, 0x000044, 0x66bbff, 0.6, 0, 0.33, 0.04);

# Add value label at the center with light blue (0x66ddff) 28pt Arial Italic font
$textBoxObj = $m->addText(150, 150, $m->formatValue($value, "{value|0}"), "ariali.ttf", 28,
	0x66ddff, Center);
$textBoxObj->setMargin(0);

# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));
?>