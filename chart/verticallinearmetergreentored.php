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
if($object->num_rows > 0)
{
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
			$sqlsubcompName                         = "SELECT SubComp_Name FROM GAME_SUBCOMPONENT WHERE SubComp_ID = ".$compID;
			$subcompDetails                         = $functionsObj->ExecuteQuery($sqlsubcompName);
			$subcompName                            = $functionsObj->FetchObject($subcompDetails);
			$dataChart[$subcompName->SubComp_Name] .= $row->input_current;
		}


	}
}

foreach($dataChart as $key=>$val)
{
	$labels [] = $key;
	$data []   = $val;

}


# The value to display on the meter
$value = 74.35;

# Create an LinearMeter object of size 70 x 240 pixels with a very light grey (0xeeeeee) background,
# and a rounded 3-pixel thick light grey (0xcccccc) border
$m = new LinearMeter(70, 240, 0xeeeeee, 0xcccccc);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);

# Set the scale region top-left corner at (28, 18), with size of 20 x 205 pixels. The scale labels
# are located on the left (default - implies vertical meter).
$m->setMeter(28, 18, 20, 205);

# Set meter scale from 0 - 100, with a tick every 10 units
$m->setScale(0, 100, 10);

# Add a smooth color scale to the meter
$smoothColorScale = array(0, 0x006400, 25, 0x07FF00, 50, 0xFFA500, 75, 0xFF7373, 100, 0xFF0000);
// $smoothColorScale = array(0, 0x6666ff, 25, 0x00bbbb, 50, 0x00ff00, 75, 0xffff00, 100, 0xff0000);
$m->addColorScale($smoothColorScale);

# Add a blue (0x0000cc) pointer at the specified value
// $m->addPointer($value, 0x0000cc);
$m->addPointer($data[0], 0x0000cc);

# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));
?>