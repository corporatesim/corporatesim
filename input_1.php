<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 

$functionsObj = new Functions();

$userid = $_SESSION['userid'];
$linkid = $_GET['Link'];
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'NOTSET';

//$scenid=$_GET['Scenario'];

//echo site_root;
//exit();

$sqlexist="SELECT * FROM `GAME_INPUT` i WHERE i.input_user=".$userid." and i.input_sublinkid in 
(SELECT s.SubLink_ID FROM GAME_LINKAGE_SUB s WHERE s.SubLink_LinkID=".$linkid.")";
$object = $functionsObj->ExecuteQuery($sqlexist);
//echo $object->num_rows;
if($object->num_rows > 0){
	$addedit="Edit";
	while($row= $object->fetch_object()){
		$data[$row->input_key]  = $row->input_current;
		//echo $row->key."-".$row->current.",";
	}
}
else{
	$addedit="Add";
}
//echo $addedit;
//foreach($data as $x=>$x_value)
//{	echo $x."=>".$x_value." ";
//}
//exit;

$sql = "SELECT * FROM GAME_LINKAGE WHERE Link_ID = ".$linkid;
$object =$functionsObj->ExecuteQuery($sql);
if($object->num_rows > 0){
	$link = $functionsObj->FetchObject($object);
	$gameid = $link->Link_GameID;
	$scenid = $link->Link_ScenarioID;
	$gameurl = site_root."game_description.php?Game=".$gameid;
	$scenurl = site_root."scenario_description.php?Link=".$linkid;
	
}

if(isset($_POST['submit']) && $_POST['submit'] == 'Submit'){
//	echo "IN SUBMIT";
//	exit();
	if( !empty($_POST) )
	{
		$data =array();
	
		foreach($_POST as $key => $value)
		{
			$strresult = $strresult.$key."->".$value." , ";
			$data[$key]  = $value;		
		}
	
		foreach($data as $x=>$x_value)
		{	  
		$str = explode("_",$x);
	
		//if($str[0] == $_POST['active'])
		//{
			if($str[1] == 'comp'){
				$sublinkid = $data[$str[0].'_linkcomp_'.$str[2]];
				$compid = $str[2];
				$subcompid=0;
				$current= $x_value;
				$key=$x;
				
				//check if already exists				
				$sql="SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
				//echo $sql;
				//exit();
				$object = $functionsObj->ExecuteQuery($sql);
						
				if ($object->num_rows > 0) {
					$res = $functionsObj->FetchObject($object);
					$array = array (
						'input_current' => $current
					);
					$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
				}
				else{
					$array = array(
						'input_user'	=> $userid,
						'input_sublinkid'		=> $sublinkid,
						'input_current'	=> $current,
						'input_key' => $key
					);				
					$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
				}
			}elseif($str[1] == 'subc'){
				$sublinkid = $data[$str[0].'_linksubc_'.$str[2]];
				$compid = 0;
				$subcompid=$str[2];
				$current= $x_value;
				$key=$x;
				
				//update if already exists
				$sql="SELECT * FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$sublinkid." and input_key='".$key."'";
				$object = $functionsObj->ExecuteQuery($sql);						
				
				if ($object->num_rows > 0) {
					$res = $functionsObj->FetchObject($object);
					$array = array (
						'input_current' => $current
					);
					$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );					
				}
				else{
					$array = array(
						'input_user'	=> $userid,
						'input_sublinkid'	=> $sublinkid,
						'input_current'	=> $current,
						'input_key' => $key
					);	
					
					$functionsObj->InsertData('GAME_INPUT', $array, 0, 0);
				}
			}
		//}		
		}
	
		foreach($data as $x=>$x_value)
		{
			$str = explode("_",$x);

			//if($str[0] == $_POST['active'])
			//{
			if($str[1] == 'expcomp'){
				$strkey = explode("_",$x);
				$strvalue = explode(" ",$x_value);
				foreach($strvalue as $y=>$y_value)
				{
					if (strpos($y_value,'comp')!== false)
					{
						//$data[$str[0].'_link'.$y_value];
						$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_link'.$y_value]." and input_key='".$str[0]."_".$y_value."'";
						$formula = $functionsObj->ExecuteQuery($sql);
						if($formula->num_rows > 0){
							$result = $functionsObj->FetchObject($formula);
							$strvalue[$y]=$result->input_current;
						}						
					}
					elseif(strpos($y_value,'subc')!== false){
						$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_link'.$y_value]." and input_key='".$str[0]."_".$y_value."'";
						$formula = $functionsObj->ExecuteQuery($sql);
						if($formula->num_rows > 0){
							$result = $functionsObj->FetchObject($formula);
							$strvalue[$y]=$result->input_current;
						}						
					}
				}				
				//execute using eval
				$value = implode(" ",$strvalue);
				$tmp=$str[0]."_linkcomp_".$str[2];

				//Update
				$object = $functionsObj->SelectData ( array (), 'GAME_INPUT', array (
					"input_sublinkid=" . $data[$tmp],
					"input_key='" . $str[0]."_comp_". $str[2]."'",
					"input_user =" . $userid 
				), '', '', '', '', 0 );
				
				if ($object->num_rows > 0) {
					$res = $functionsObj->FetchObject($object);
					$array = array (
						'input_current' => eval('return '.$value.';')
					);
					$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
					$strdata = $strdata." Update for id ".$res->input_id;
				}
			}elseif($str[1] == 'expsubc'){
				$strkey = explode("_",$x);
				$strvalue = explode(" ",$x_value);
				foreach($strvalue as $y=>$y_value)
				{
					if (strpos($y_value,'comp')!== false)
					{
						//$data[$str[0].'_link'.$y_value];
						$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_link'.$y_value]." and input_key='".$str[0]."_".$y_value."'";
						$formula = $functionsObj->ExecuteQuery($sql);
						if($formula->num_rows > 0){
							$result = $functionsObj->FetchObject($formula);
							$strvalue[$y]=$result->input_current;
						}						
					}
					elseif(strpos($y_value,'subc')!== false){
						//$data[$str[0].'_link'.$y_value];
						$sql="SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." and input_sublinkid=".$data[$str[0].'_link'.$y_value]." and input_key='".$str[0]."_".$y_value."'";
						$formula = $functionsObj->ExecuteQuery($sql);
						if($formula->num_rows > 0){
							$result = $functionsObj->FetchObject($formula);
							$strvalue[$y]=$result->input_current;
						}						
					}
				}
				//execute using eval
				$value = implode(" ",$strvalue);
				$strdata = $strdata." ".$value." = ".eval('return '.$value.';');
				$tmp=$str[0]."_linksubc_".$str[2];
				
				// update current in Db for sublink and key
				$object = $functionsObj->SelectData ( array (), 'GAME_INPUT', array (
					"input_sublinkid=" . $data[$tmp],
					"input_key='" . $str[0]."_subc_". $str[2]."'",
					"input_user =" . $userid 
				), '', '', '', '', 0 );
				
				if ($object->num_rows > 0) {
					$res = $functionsObj->FetchObject($object);
					$array = array (
						'input_current' => eval('return '.$value.';')
					);
					$result = $functionsObj->UpdateData ( 'GAME_INPUT', $array, 'input_id', $res->input_id );
				}
			}
			//bind 
		//}				
		}
		
		//calculate output values from database values.
		
		//get all formula for output fields
		$sql = "SELECT ls.SubLink_ID , f.expression as expression
		FROM GAME_LINKAGE_SUB ls INNER JOIN GAME_FORMULAS f on SubLink_FormulaID=f_id 
		WHERE SubLink_type=1 and SubLink_LinkID=".$linkid;
		//echo "SQL - ".$sql;
		
		$formula = $functionsObj->ExecuteQuery($sql);
		if($formula->num_rows > 0){
			while($row = mysqli_fetch_array($formula)){
				$expression = $row['expression'];
				$sublinkid = $row['SubLink_ID'];
				//echo "expression".$expression;
				//exit();
				$strvalue = explode(" ",$expression);
				foreach($strvalue as $y=>$y_value)
				{
					
					$strkey = explode("_",$y_value);
					
					if ($strkey[0]=='subc')
					{
						$sqlvalue = "SELECT input_current FROM GAME_INPUT 
						WHERE input_user=".$userid." AND input_sublinkid IN
						(SELECT ls.SubLink_ID FROM GAME_LINKAGE_SUB ls 
						WHERE SubLink_SubCompId=".$strkey[1]." AND SubLink_type=0 and SubLink_LinkID=".$linkid." )";
						
						//echo $sqlvalue;
						$value = $functionsObj->ExecuteQuery($sqlvalue);
						$resultvalue= $functionsObj->FetchObject($value);
						//echo "y - ".$y."  strvalue[y] - ".$strvalue[$y]."</br>";
						//echo $resultvalue->input_current."</br>";
						
						$strvalue[$y] = $resultvalue->input_current;
						
					}
					elseif($strkey[0]=='comp'){
						$sqlvalue = "SELECT input_current FROM GAME_INPUT 
						WHERE input_user=".$userid." AND input_sublinkid IN
						(SELECT ls.SubLink_ID FROM GAME_LINKAGE_SUB ls 
						WHERE SubLink_CompId=".$strkey[1]." AND SubLink_SubCompId=0 AND SubLink_type=0 and SubLink_LinkID=".$linkid." )";
	
						//echo $sqlvalue;
						
						$value = $functionsObj->ExecuteQuery($sqlvalue);
						$resultvalue= $functionsObj->FetchObject($value);
						//echo "y - ".$y."  strvalue[y] - ".$strvalue[$y]."</br>";
						//echo $resultvalue->input_current."</br>";

						
						$strvalue[$y] = $resultvalue->input_current;
						
					}					
				}
				
				$streval = implode(" ",$strvalue);
				//$current = eval('return '.$streval.';');

				$sql="SELECT * FROM `GAME_OUTPUT` WHERE output_user=".$userid." and output_sublinkid=".$sublinkid;
				//echo $sql;
				//exit();
				$object = $functionsObj->ExecuteQuery($sql);
						
				if ($object->num_rows > 0) {
					$res = $functionsObj->FetchObject($object);
					$array = array (
						'output_current' => eval('return '.$streval.';')
					);
					$result = $functionsObj->UpdateData ( 'GAME_OUTPUT', $array, 'output_id', $res->output_id );
				}
				else{
					$array = array(
						'output_user'	=> $userid,
						'output_sublinkid'		=> $sublinkid,
						'output_current'	=> $current
					);				
					$functionsObj->InsertData('GAME_OUTPUT', $array, 0, 0);
				}
								
				//echo(implode(" ",$strvalue));
				//join implode
			}
		}
	}
	
	
	header("Location: ".site_root."output.php?Link=".$linkid);
	exit(0);

}


$sql ="SELECT g.game_name as Game,sc.Scen_Name as Scenario,a.Area_Name as Area, 
		c.Comp_Name as Component, s.SubComp_Name as Subcomponent, l.*,ls.* 
	FROM GAME_LINKAGE l 
		INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
		INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
        INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
        INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
        LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
        INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE l.Link_ID=".$linkid;
//" order by link_gameid,Link_ScenarioID,Link_Order";

$input = $functionsObj->ExecuteQuery($sql);
if($input->num_rows > 0){
	$result = $functionsObj->FetchObject($input);
	//$url = site_root."scenario_description.php?Link=".$result->Link_ID;
}

$sqlarea="SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name
FROM GAME_LINKAGE l 
		INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
		INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
        INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
        INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
        LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
        INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE ls.SubLink_Type=0 AND l.Link_ID=".$linkid;
//echo $sql;
$area = $functionsObj->ExecuteQuery($sqlarea);


$sqlcomp = "SELECT distinct a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, ls.SubLink_Details as Description 
FROM GAME_LINKAGE l 
		INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
		INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
        INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
        INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
        LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
        INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
WHERE ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid;
$component = $functionsObj->ExecuteQuery($sqlcomp);


				
$url = site_root."input.php?Scenario=".$result->Link_ScenarioID;

include_once doc_root.'views/input.php';

?>

				