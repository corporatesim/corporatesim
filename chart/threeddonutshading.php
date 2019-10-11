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
	
	while($row = $object->fetch_object()){
		
		$compdata  = $row->input_key;
		$allcompID = explode('_',$compdata);
		$compID    = $allcompID[2];
		
		if (in_array($compID, $arrayComp) && $allcompID[1]=='comp')
		{
			$sqlcompName = "SELECT Comp_Name FROM GAME_COMPONENT WHERE Comp_ID = ".$compID;
			$compDetails = $functionsObj->ExecuteQuery($sqlcompName);
			$compName    = $functionsObj->FetchObject($compDetails);
			
			$dataChart[$compName->Comp_Name]  = $row->input_current;
		}
		if (in_array($compID, $arraysubcomp) && $allcompID[1]=='subc')
		{
			$sqlsubcompName = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
			$subcompDetails = $functionsObj->ExecuteQuery($sqlsubcompName);
			$subcompName    = $functionsObj->FetchObject($subcompDetails);
			
			$dataChart[$subcompName->SubComp_Name] .= $row->input_current;
		}
	}
}
// echo "<pre>"; print_r($dataChart); exit;
foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;
	
}
// echo "<pre>"; print_r($data); print_r($labels); exit();
# This script can draw different charts depending on the chartIndex
$chartIndex = (int)($_REQUEST["img"]);
# The data for the pie chart
// $data = array(18, 30, 20, 65);
# The colors to use for the sectors
// $colors = array(0x66aaee, 0xeebb22, 0xbbbbbb, 0x8844ff, 0xaaeaaa);
$colors = array(0xFF6633, 0xFFB399, 0xFF33FF, 0xFFFF99, 0x00B3E6, 0xE6B333, 0x3366E6, 0x999966, 0x99FF99, 0xB34D4D, 0x80B300, 0x809900, 0xE6B3B3, 0x6680B3, 0x66991A,  0xFF99E6, 0xCCFF1A, 0xFF1A66, 0xE6331A, 0x33FFCC, 0x66994D, 0xB366CC, 0x4D8000, 0xB33300, 0xCC80CC,  0x66664D, 0x991AFF, 0xE666FF, 0x4DB3FF, 0x1AB399, 0xE666B3, 0x33991A, 0xCC9999, 0xB3B31A, 0x00E680,  0x4D8066, 0x809980, 0xE6FF80, 0x1AFF33, 0x999933, 0xFF3380, 0xCCCC00, 0x66E64D, 0x4D80CC, 0x9900B3,  0xE64D66, 0x4DB380, 0xFF4D4D, 0x99E6E6, 0x6666FF);
# Create a PieChart object of size 200 x 200 pixels. Use a vertical gradient color from blue
# (0000cc) to deep blue (000044) as background. Use rounded corners of 16 pixels radius.
$c = new PieChart(400, 400);
$c->setBackground($c->linearGradientColor(0, 0, 0, $c->getHeight(), 0x0000cc, 0x000044));
$c->setRoundedFrame(0xffffff, 16);

# Set donut center at (100, 100), and outer/inner radii as 80/40 pixels
$c->setDonutSize(200, 190, 110, 60);

# Set the pie data
$c->setData($data);

# Set the sector colors
$c->setColors2(DataColor, $colors);

# Draw the pie in 3D with a pie thickness of 20 pixels
$c->set3D(20);

# Demonstrates various shading modes
if ($chartIndex == 0) {
    // $c->addTitle("Default Shading", "bold", 12, 0xffffff);
    $c->addTitle("", "bold", 12, 0xffffff);
} else if ($chartIndex == 1) {
    $c->addTitle("Flat Gradient", "bold", 12, 0xffffff);
    $c->setSectorStyle(FlatShading);
} else if ($chartIndex == 2) {
    $c->addTitle("Local Gradient", "bold", 12, 0xffffff);
    $c->setSectorStyle(LocalGradientShading);
} else if ($chartIndex == 3) {
    $c->addTitle("Global Gradient", "bold", 12, 0xffffff);
    $c->setSectorStyle(GlobalGradientShading);
} else if ($chartIndex == 4) {
    $c->addTitle("Concave Shading", "bold", 12, 0xffffff);
    $c->setSectorStyle(ConcaveShading);
} else if ($chartIndex == 5) {
    $c->addTitle("Rounded Edge", "bold", 12, 0xffffff);
    $c->setSectorStyle(RoundedEdgeShading);
} else if ($chartIndex == 6) {
    $c->addTitle("Radial Gradient", "bold", 12, 0xffffff);
    $c->setSectorStyle(RadialShading);
} else if ($chartIndex == 7) {
    $c->addTitle("Ring Shading", "bold", 12, 0xffffff);
    $c->setSectorStyle(RingShading);
}

# Disable the sector labels by setting the color to Transparent
$c->setLabelStyle("", 8, 0xffffff);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>