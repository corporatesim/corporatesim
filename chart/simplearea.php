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
	
	

# The data for the area chart
/* $data = array(30, 28, 40, 55, 75, 68, 54, 60, 50, 62, 75, 65, 75, 89, 60, 55, 53, 35, 50, 66, 56,
    48, 52, 65, 62); */

# The labels for the area chart
/* $labels = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14",
    "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"); */

# Create a XYChart object of size 250 x 250 pixels
$c = new XYChart(800, 350);

# Set the plotarea at (30, 20) and of size 200 x 200 pixels
$c->setPlotArea(30, 20, 700, 200);

# Add an area chart layer using the given data
$c->addAreaLayer($data);

# Set the labels on the x axis.
//$c->xAxis->setLabels($labels);

# Display 1 out of 3 labels on the x-axis.
$c->xAxis->setLabelStep(3);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
