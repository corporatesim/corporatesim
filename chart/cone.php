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
	

# The data for the pyramid chart
//$data = array(156, 123, 211, 179);

# The labels for the pyramid chart
//$labels = array("Funds", "Bonds", "Stocks", "Cash");

# The semi-transparent colors for the pyramid layers
$colors = array(0x60000088, 0x6066aaee, 0x60ffbb00, 0x60ee6622, 0x66bbbb, 0xaa6644, 0x99bb55, 0xee9944, 0x444466, 0xbb5555);

# Create a PyramidChart object of size 480 x 400 pixels
$c = new PyramidChart(800, 400);

# Set the cone center at (280, 180), and width x height to 150 x 300 pixels
$c->setConeSize(520, 180, 150, 300);

# Set the elevation to 15 degrees
$c->setViewAngle(15);

# Set the pyramid data and labels
$c->setData($data, $labels);

# Set the layer colors to the given colors
$c->setColors2(DataColor, $colors);

# Leave 1% gaps between layers
$c->setLayerGap(0.01);

# Add labels at the left side of the pyramid layers using Arial Bold font. The labels will have 3
# lines showing the layer name, value and percentage.
// $c->setLeftLabel("{label}\nIN {value}K\n({percent}%)", "arialbd.ttf");
$c->setLeftLabel("{label}\n ({percent}%)", "arialbd.ttf");

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
