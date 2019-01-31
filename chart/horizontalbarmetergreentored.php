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
$sqlexist           = "SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$ResultLinkId->Link_ID.") group by i.input_sublinkid";
$object       = $functionsObj->ExecuteQuery($sqlexist);
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
	while($row = $object->fetch_object()){
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
$value = 75.35;

# Create an LinearMeter object of size 260 x 66 pixels with a very light grey (0xeeeeee) background,
# and a rounded 3-pixel thick light grey (0xaaaaaa) border
$m = new LinearMeter(260, 66, 0xeeeeee, 0xaaaaaa);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);

# Set the scale region top-left corner at (18, 24), with size of 222 x 20 pixels. The scale labels
# are located on the top (implies horizontal meter)
$m->setMeter(18, 24, 222, 20, Top);

# Set meter scale from 0 - 100, with a tick every 10 units
$m->setScale(0, 100, 10);

# Add a 5-pixel thick smooth color scale to the meter at y = 48 (below the meter scale)
$smoothColorScale = array(0, 0x0000ff, 25, 0x0088ff, 50, 0x00ff00, 75, 0xffff00, 100, 0xff0000);
$m->addColorScale($smoothColorScale, 48, 5);

# Add a light blue (0x0088ff) bar from 0 to the data value with glass effect and 4 pixel rounded
# corners
// $m->addBar(0, $value, 0x0088ff, glassEffect(NormalGlare, Top), 4);
$m->addBar(0, $data[0], 0x0088ff, glassEffect(NormalGlare, Top), 4);

# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));
?>