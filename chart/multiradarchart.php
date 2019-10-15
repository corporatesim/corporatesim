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

# The data for the chart
$data0 = array(90, 60, 85, 75, 55);
$data1 = array(60, 80, 70, 80, 85);

# The labels for the chart
// $labels = array("Speed", "Reliability", "Comfort", "Safety", "Efficiency");

# Create a PolarChart object of size 480 x 380 pixels. Set background color to gold, with 1 pixel 3D
# border effect
$c = new PolarChart(680, 400, goldColor(), 0x000000, 1);

# Add a title to the chart using 15pt Times Bold Italic font. The title text is white (ffffff) on a
# deep blue (000080) background
$textBoxObj = $c->addTitle($chartname, "timesbi.ttf", 15, 0xffffff);
$textBoxObj->setBackground(0x000080);

# Set plot area center at (240, 210), with 150 pixels radius, and a white (ffffff) background.
$c->setPlotArea(340, 210, 150, 0xffffff);

# Add a legend box at top right corner (470, 35) using 10pt Arial Bold font. Set the background to
# silver, with 1 pixel 3D border effect.
$b = $c->addLegend(470, 35, true, "arialbd.ttf", 10);
$b->setAlignment(TopRight);
$b->setBackground(silverColor(), Transparent, 1);

# Add an area layer to the chart using semi-transparent blue (0x806666cc). Add a blue (0x6666cc)
# line layer using the same data with 3 pixel line width to highlight the border of the area.
// $c->addAreaLayer($data0, 0x806666cc, "Model Saturn");
$c->addAreaLayer($data0, 0x806666cc, "");
$lineLayerObj = $c->addLineLayer($data0, 0x6666cc);
$lineLayerObj->setLineWidth(3);

# Add an area layer to the chart using semi-transparent red (0x80cc6666). Add a red (0xcc6666) line
# layer using the same data with 3 pixel line width to highlight the border of the area.
// $c->addAreaLayer($data1, 0x80cc6666, "Model Jupiter");
$c->addAreaLayer($data1, 0x80cc6666, "");
$lineLayerObj = $c->addLineLayer($data1, 0xcc6666);
$lineLayerObj->setLineWidth(3);

# Set the labels to the angular axis as spokes.
$c->angularAxis->setLabels($labels);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>