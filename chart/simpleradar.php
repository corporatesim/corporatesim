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
	

# The data for the chart
//$data = array(90, 60, 65, 75, 40);

# The labels for the chart
//$labels = array("Speed", "Reliability", "Comfort", "Safety", "Efficiency");

# Create a PolarChart object of size 450 x 350 pixels
$c = new PolarChart(800, 350);

# Set center of plot area at (225, 185) with radius 150 pixels
$c->setPlotArea(450, 185, 150);

# Add an area layer to the polar chart
$c->addAreaLayer($data, 0x9999ff);

# Set the labels to the angular axis as spokes
$c->angularAxis->setLabels($labels);

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
