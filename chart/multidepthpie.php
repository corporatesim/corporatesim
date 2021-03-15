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

$comp      = $ResultchartDetails->Chart_Components;
$subcomp   = $ResultchartDetails->Chart_Subcomponents;
$chartname = $ResultchartDetails->Chart_Name;
$charttype = $ResultchartDetails->Chart_Type;


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
// echo "<pre>"; print_r($dataChart); exit;
foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;
}

# The data for the pie chart
//$data = array(72, 18, 15, 12);

# The labels for the pie chart
//$labels = array("Labor", "Machinery", "Facilities", "Computers");

# The depths for the sectors
$depths = array(30, 20, 10, 10);
# Create a PieChart object of size 360 x 300 pixels, with a light blue (DDDDFF) background and a 1
# pixel 3D border
$c = new PieChart(800, 300, 0xddddff, -1, 1);

# Set the center of the pie at (180, 175) and the radius to 100 pixels
$c->setPieSize(380, 150, 120);

# Add a title box using 15pt Times Bold Italic font and blue (AAAAFF) as background color
$textBoxObj = $c->addTitle($chartname, "timesbi.ttf", 15);
$textBoxObj->setBackground(0xaaaaff);

# Set the pie data and the pie labels
$c->setData($data, $labels);

# Draw the pie in 3D with variable 3D depths
$c->set3D2($depths);

# Set the start angle to 225 degrees may improve layout when the depths of the sector are sorted in
# descending order, because it ensures the tallest sector is at the back.
$c->setStartAngle(225);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
