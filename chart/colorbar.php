<?php
include_once '../config/settings.php'; 
include_once '../config/functions.php'; 
set_time_limit(300);

$functionsObj = new Functions();

include_once '../includes/lib/phpchartdir.php';


$ChartID = $_GET['ChartID'];
$gameid  = $_GET['gameid'];
$userid  = $_GET['userid'];

$sqlchart           = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$ChartID;
$chartDetails       = $functionsObj->ExecuteQuery($sqlchart);
$ResultchartDetails = $functionsObj->FetchObject($chartDetails);


$sqllink      = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$ResultchartDetails->Chart_ScenarioID;
// echo $sqllink;
$LinkId       =  $functionsObj->ExecuteQuery($sqllink);
$ResultLinkId = $functionsObj->FetchObject($LinkId);


$sqlexist = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID =".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
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

	while($row= $object->fetch_object()){

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


foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;

}

# The data for the bar chart
//$data = array(85, 156, 179, 211, 123, 189, 166);

# The labels for the bar chart
//$labels = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

# The colors for the bars
$colors = array(0x5588bb, 0x66bbbb, 0xaa6644, 0x99bb55, 0xee9944, 0x444466, 0xbb5555);

# Create a XYChart object of size 600 x 360 pixels
$c = new XYChart(800, 300);

# Set the plotarea at (70, 20) and of size 500 x 300 pixels, with transparent background and border
# and light grey (0xcccccc) horizontal grid lines
$c->setPlotArea(70, 20, 700, 250, Transparent, -1, Transparent, 0xcccccc);

# Set the x and y axis stems to transparent and the label font to 12pt Arial
$c->xAxis->setColors(Transparent);
$c->yAxis->setColors(Transparent);
$c->xAxis->setLabelStyle("arial.ttf", 12);
$c->yAxis->setLabelStyle("arial.ttf", 12);

# Add a multi-color bar chart layer using the given data
$layer = $c->addBarLayer3($data, $colors);

# Use bar gradient lighting with the light intensity from 0.8 to 1.15
$layer->setBorderColor(Transparent, barLighting(0.8, 1.15));

# Set rounded corners for bars
$layer->setRoundedCorners();

# Set the labels on the x axis.
//$c->xAxis->setLabels($labels);

# For the automatic y-axis labels, set the minimum spacing to 40 pixels.
$c->yAxis->setTickDensity(40);

# Add a title to the y axis using dark grey (0x555555) 14pt Arial font
$c->yAxis->setTitle("Y-Axis Title Placeholder", "arial.ttf", 14, 0x555555);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
