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

# data for the gantt chart, representing the start date, end date and names for various activities
$startDate = array(chartTime(2004, 8, 16), chartTime(2004, 8, 30), chartTime(2004, 9, 13),
    chartTime(2004, 9, 20), chartTime(2004, 9, 27), chartTime(2004, 10, 4), chartTime(2004, 10, 25),
    chartTime(2004, 11, 1), chartTime(2004, 11, 8));
$endDate = array(chartTime(2004, 8, 30), chartTime(2004, 9, 13), chartTime(2004, 9, 27), chartTime(
    2004, 10, 4), chartTime(2004, 10, 11), chartTime(2004, 11, 8), chartTime(2004, 11, 8),
    chartTime(2004, 11, 22), chartTime(2004, 11, 22));
// $labels = array("Market Research", "Define Specifications", "Overall Archiecture",
//     "Project Planning", "Detail Design", "Software Development", "Test Plan", "Testing and QA",
//     "User Documentation");

# Create a XYChart object of size 620 x 280 pixels. Set background color to light blue (ccccff),
# with 1 pixel 3D border effect.
$c = new XYChart(620, 280, 0xccccff, 0x000000, 1);

# Add a title to the chart using 15 points Times Bold Itatic font, with white (ffffff) text on a
# deep blue (000080) background
$textBoxObj = $c->addTitle($chartname, "timesbi.ttf", 15, 0xffffff);
$textBoxObj->setBackground(0x000080);

# Set the plotarea at (140, 55) and of size 460 x 200 pixels. Use alternative white/grey background.
# Enable both horizontal and vertical grids by setting their colors to grey (c0c0c0). Set vertical
# major grid (represents month boundaries) 2 pixels in width
$plotAreaObj = $c->setPlotArea(140, 55, 460, 200, 0xffffff, 0xeeeeee, LineColor, 0xc0c0c0, 0xc0c0c0)
    ;
$plotAreaObj->setGridWidth(2, 1, 1, 1);

# swap the x and y axes to create a horziontal box-whisker chart
$c->swapXY();

# Set the y-axis scale to be date scale from Aug 16, 2004 to Nov 22, 2004, with ticks every 7 days
# (1 week)
$c->yAxis->setDateScale(chartTime(2004, 8, 16), chartTime(2004, 11, 22), 86400 * 7);

# Set multi-style axis label formatting. Month labels are in Arial Bold font in "mmm d" format.
# Weekly labels just show the day of month and use minor tick (by using '-' as first character of
# format string).
$c->yAxis->setMultiFormat(StartOfMonthFilter(), "<*font=arialbd.ttf*>{value|mmm d}",
    StartOfDayFilter(), "-{value|d}");

# Set the y-axis to shown on the top (right + swapXY = top)
$c->setYAxisOnRight();

# Set the labels on the x axis
$c->xAxis->setLabels($labels);

# Reverse the x-axis scale so that it points downwards.
$c->xAxis->setReverse();

# Set the horizontal ticks and grid lines to be between the bars
$c->xAxis->setTickOffset(0.5);

# Add a green (33ff33) box-whisker layer showing the box only.
$c->addBoxWhiskerLayer($startDate, $endDate, null, null, null, 0x00cc00, SameAsMainColor,
    SameAsMainColor);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>