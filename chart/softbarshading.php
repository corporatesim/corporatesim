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

	while($row= $object->fetch_object())
	{
		$compdata  = $row->input_key;
		$allcompID = explode('_',$compdata);
		$compID    = $allcompID[2];

		if (in_array($compID, $arrayComp) && $allcompID[1]=='comp')
		{
			$sqlcompName = "SELECT Comp_Name FROM GAME_COMPONENT WHERE Comp_ID = ".$compID;
			$compDetails = $functionsObj->ExecuteQuery($sqlcompName);
			$compName= $functionsObj->FetchObject($compDetails);

			$dataChart[$compName->Comp_Name]  = $row->input_current;
		}
		if (in_array($compID, $arraysubcomp) && $allcompID[1]=='subc')
		{
			$sqlsubcompName = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
			$subcompDetails = $functionsObj->ExecuteQuery($sqlsubcompName);
			$subcompName= $functionsObj->FetchObject($subcompDetails);

			$dataChart[$subcompName->SubComp_Name]  .= $row->input_current;
		}
	}
}


foreach($dataChart as $key=>$val)
{
	$labels []= $key;
	$data []= $val;

}

# The data for the bar chart
// $data = array(450, 560, 630, 800, 1100, 1350, 1600, 1950, 2300, 2700);

# The labels for the bar chart
// $labels = array("1996", "1997", "1998", "1999", "2000", "2001", "2002", "2003", "2004", "2005");

# Create a XYChart object of size 600 x 360 pixels
$c = new XYChart(600, 360);

# Add a title to the chart using 18pt Times Bold Italic font
$c->addTitle($chartname, "timesbi.ttf", 18);

# Set the plotarea at (60, 40) and of size 500 x 280 pixels. Use a vertical gradient color from
# light blue (eeeeff) to deep blue (0000cc) as background. Set border and grid lines to white
# (ffffff).
$c->setPlotArea(60, 40, 500, 280, $c->linearGradientColor(60, 40, 60, 280, 0xeeeeff, 0x0000cc), -1,
	0xffffff, 0xffffff);

# Add a multi-color bar chart layer using the supplied data. Use soft lighting effect with light
# direction from left.
$barLayerObj = $c->addBarLayer3($data);
$barLayerObj->setBorderColor(Transparent, softLighting(Left));

# Set x axis labels using the given labels
$c->xAxis->setLabels($labels);

# Draw the ticks between label positions (instead of at label positions)
$c->xAxis->setTickOffset(0.5);

# Add a title to the y axis with 10pt Arial Bold font
$c->yAxis->setTitle("USD (millions)", "arialbd.ttf", 10);

# Set axis label style to 8pt Arial Bold
$c->xAxis->setLabelStyle("arialbd.ttf", 8);
$c->yAxis->setLabelStyle("arialbd.ttf", 8);

# Set axis line width to 2 pixels
$c->xAxis->setWidth(2);
$c->yAxis->setWidth(2);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>