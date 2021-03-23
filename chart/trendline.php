<?php
include_once '../config/settings.php'; 
include_once '../config/functions.php'; 
set_time_limit(300);

$functionsObj = new Functions();

include_once '../includes/lib/phpchartdir.php';


$ChartID = $_GET['ChartID'];
$gameid  = $_GET['gameid'];
$userid = $_GET['userid'];

	$sqlchart = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$ChartID;
	$chartDetails = $functionsObj->ExecuteQuery($sqlchart);
	$ResultchartDetails= $functionsObj->FetchObject($chartDetails);


	$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$gameid." AND Link_ScenarioID= ".$ResultchartDetails->Chart_ScenarioID;
	$LinkId =  $functionsObj->ExecuteQuery($sqllink);
	$ResultLinkId = $functionsObj->FetchObject($LinkId);


	$sqlexist="SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
	(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
	$object = $functionsObj->ExecuteQuery($sqlexist);


	//chart_component and subcomponent

	$comp = $ResultchartDetails->Chart_Components;
	$subcomp = $ResultchartDetails->Chart_Subcomponents;
	$chartname = $ResultchartDetails->Chart_Name;
	$charttype = $ResultchartDetails->Chart_Type;
	

	$arrayComp = explode(',',$comp);
	$arraysubcomp = explode(',',$subcomp);
	//print_r($arrayComp);

	//echo $object->num_rows;
	if($object->num_rows > 0){
		
		while($row= $object->fetch_object()){
			
			$compdata = $row->input_key;
			$allcompID = explode('_',$compdata);
			$compID = $allcompID[2];
			
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

	// echo "<pre>"; print_r($data); print_r($labels); die();
	
	
	
	
# The data for the line chart
/* $data = array(50, 55, 47, 34, 42, 49, 63, 62, 73, 59, 56, 50, 64, 60, 67, 67, 58, 59, 73, 77, 84,
    82, 80, 91); */

# The labels for the line chart
/* $labels = array("Jan 2000", "Feb 2000", "Mar 2000", "Apr 2000", "May 2000", "Jun 2000", "Jul 2000",
    "Aug 2000", "Sep 2000", "Oct 2000", "Nov 2000", "Dec 2000", "Jan 2001", "Feb 2001", "Mar 2001",
    "Apr 2001", "May 2001", "Jun 2001", "Jul 2001", "Aug 2001", "Sep 2001", "Oct 2001", "Nov 2001",
    "Dec 2001"); */

# Create a XYChart object of size 500 x 320 pixels, with a pale purpule (0xffffff) background, a
# black border, and 1 pixel 3D border effect.
$c = new XYChart(800, 320, 0xffffff, 0x000000, 1);

# Set the plotarea at (55, 45) and of size 420 x 210 pixels, with white background. Turn on both
# horizontal and vertical grid lines with light grey color (0xc0c0c0)
$c->setPlotArea(55, 45, 720, 210, 0xffffff, -1, -1, 0xc0c0c0, -1);

# Add a legend box at (55, 25) (top of the chart) with horizontal layout. Use 8pt Arial font. Set
# the background and border color to Transparent.
$legendObj = $c->addLegend(55, 22, false, "", 8);
$legendObj->setBackground(Transparent);

# Add a title box to the chart using 13pt Times Bold Italic font. The text is white (0xffffff) on a
# purple (0x800080) background, with a 1 pixel 3D border.
$textBoxObj = $c->addTitle($chartname	, "timesbi.ttf", 13, 0x000000);
$textBoxObj->setBackground(0xffffff, -1, 1);

# Add a title to the y axis
// $c->yAxis->setTitle($chartname);

# Set the labels on the x axis. Rotate the font by 90 degrees.
$labelsObj = $c->xAxis->setLabels($labels);
$labelsObj->setFontAngle(60);

# Add a line layer to the chart
$lineLayer = $c->addLineLayer();

# Add the data to the line layer using light brown color (0xcc9966) with a 7 pixel square symbol
$dataSetObj = $lineLayer->addDataSet($data, 0xcc9966, " ");
$dataSetObj->setDataSymbol(SquareSymbol, 7);

# Set the line width to 2 pixels
$lineLayer->setLineWidth(2);

# Add a trend line layer using the same data with a dark green (0x008000) color. Set the line width
# to 2 pixels
$trendLayerObj = $c->addTrendLayer($data, 0x000000, "Trend Line");
$trendLayerObj->setLineWidth(2);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
