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
	

# 4 data points to represent the cash flow for the Q1 - Q4
//$data = array(230, -140, 220, 330);

# We want to plot a waterfall chart showing the 4 quarters as well as the total
//$labels = array("1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter", "Total");

# The top side of the bars in a waterfall chart is the accumulated data. We use the ChartDirector
# ArrayMath utility to accumulate the data. The "total" is handled by inserting a zero point at the
# end before accumulation (after accumulation it will become the total).
$tmpArrayMath1 = new ArrayMath($data);
$tmpArrayMath1->insert2(0, 1, count($data));
$tmpArrayMath1->acc();
$boxTop = $tmpArrayMath1->result();

# The botom side of the bars is just the top side of the previous bar. So we shifted the top side
# data to obtain the bottom side data.
$tmpArrayMath1 = new ArrayMath($boxTop);
$tmpArrayMath1->shift(1, 0);
$boxBottom = $tmpArrayMath1->result();

# The last point (total) is different. Its bottom side is always 0.
$boxBottom[count($boxBottom) - 1] = 0;

# In this example, we want to use different colors depending on the data is positive or negative.
$posColor = 0x00ff00;
$negColor = 0xff0000;

# Create a XYChart object of size 500 x 280 pixels. Set background color to light blue (ccccff),
# with 1 pixel 3D border effect.
$c = new XYChart(800, 300, 0xccccff, 0x000000, 1);

# Add a title to the chart using 13 points Arial Bold Itatic font, with white (ffffff) text on a
# deep blue (0x80) background
$textBoxObj = $c->addTitle($chartname, "arialbi.ttf", 13, 0xffffff);
$textBoxObj->setBackground(0x000080);

# Set the plotarea at (55, 50) and of size 430 x 215 pixels. Use alternative white/grey background.
$c->setPlotArea(55, 50, 700, 215, 0xffffff, 0xeeeeee);

# Add a legend box at (55, 25) using 8pt Arial Bold font with horizontal layout, with transparent
# background and border color.
$b = $c->addLegend(55, 25, false, "arialbd.ttf", 8);
$b->setBackground(Transparent, Transparent);

# Add keys to show the colors for positive and negative cash flows
$b->addKey("Positive Cash Flow", $posColor);
$b->addKey("Negative Cash Flow", $negColor);

# Set the labels on the x axis using Arial Bold font
//$labelsObj = $c->xAxis->setLabels($labels);
//$labelsObj->setFontStyle("arialbd.ttf");

# Set the x-axis ticks and grid lines to be between the bars
$c->xAxis->setTickOffset(0.5);

# Use Arial Bold as the y axis label font
$c->yAxis->setLabelStyle("arialbd.ttf");

# Add a title to the y axis
$c->yAxis->setTitle($chartname);

# Add a box-whisker layer to represent the waterfall bars
$layer = $c->addBoxWhiskerLayer($boxTop, $boxBottom);

# Color the bars depending on whether it is positive or negative
for($i = 0; $i < count($boxTop); ++$i) {
    if ($boxTop[$i] >= $boxBottom[$i]) {
        $layer->setBoxColor($i, $posColor);
    } else {
        $layer->setBoxColor($i, $negColor);
    }
}

# Put data labels on the bars to show the cash flow using Arial Bold font
$layer->setDataLabelFormat("{={top}-{bottom}}M");
$textBoxObj = $layer->setDataLabelStyle("arialbd.ttf");
$textBoxObj->setAlignment(Center);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
