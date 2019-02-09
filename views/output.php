<?php 
include_once 'includes/header.php'; 
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> <!-- - Outcome --></h2></div>
				<!--<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Game." | ".$result->Scenario ; }?> Your Output</h2></div>
					<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->

					<div class="clearfix"></div>

					<form method="POST" action="" id="game_frm" name="game_frm">
						<input type="hidden" name="ScenarioId" id="ScenarioId" value="<?php echo $result->Link_ScenarioID; ?>">
						<input type="hidden" name="LinkId" id="LinkId" value="<?php echo ($result->Link_ID)?$result->Link_ID:$linkid; ?>">
						<div class="col-sm-12 no_padding shadow">
					<!--
						<div class="col-sm-6 ">
							<span style="margin-right:20px;"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">Game Description</a></span>
							<a href="<?php echo $scenurl; ?>" target="_blank" class="innerPageLink">Scenario Description</a>
						</div>
					-->
						<!--<div class="col-sm-6  text-right">
							<button class="btn innerBtns">Save</button>
							<button class="btn innerBtns">Submit</button>
						</div>-->
						<div class="col-sm-12  text-right pull-right"">
							<!-- <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button> -->
							<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Next</button>
						</div>
						
						<!-- Nav tabs -->	
						<div class=" TabMain col-sm-12">
							<ul class="nav nav-tabs" role="tablist">
								<?php 
								$i=0;
								while($row = mysqli_fetch_array($area)) {
										//echo $row->Area_Name;
									if($row['BackgroundColor'] || $row['TextColor'])
									{
										$areaStyle = "style='background:".$row['BackgroundColor']."; color:".$row['TextColor']." !important;'";
									}
									else
									{
										$areaStyle = '';
									}
									if($i==0)
									{
										echo "<li role='presentation' class='active regular'><a href='#".$row['Area_Name']."Tab' $areaStyle aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
									}else{
										echo "<li role='presentation' class='regular'><a href='#".$row['Area_Name']."Tab' $areaStyle aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
									}
									$i++;
								}
								?>
							</ul>
							
							<!-- Tab panes -->
							<div class="tab-content">

								<?php
						//echo $area->num_rows;
								$area = $functionsObj->ExecuteQuery($sqlarea);
								$i = 0;
								while($row = mysqli_fetch_array($area)) {
									$areaname = $row['Area_Name'];
							//echo $i." ".$row['Area_Name'];
									if($i==0)
									{
										echo "<div role='tabpanel' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
									}
									else{
										echo "<div role='tabpanel' class='tab-pane' id='".$row['Area_Name']."Tab'>";
									}
									$i++;

									// $sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, 
									// c.Comp_Name as Comp_Name, ls.SubLink_Details as Description ,ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder,ls.Sublink_ShowHide as ShowHide , o.output_current as Current ,ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor
									// FROM GAME_LINKAGE l 
									// INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID= ls.SubLink_LinkID 
									// INNER JOIN GAME_OUTPUT o on ls.SubLink_ID = o.output_sublinkid
									// INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
									// INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
									// INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
									// LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
									// INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
									// WHERE ls.SubLink_Type=1 AND o.output_user=".$userid." AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
									$sqlcomp = "SELECT 
									ga.Area_ID AS AreaID,
									gc.Comp_ID AS CompID,
									ga.Area_Name AS Area_Name,
									gc.Comp_Name AS Comp_Name,
									gls.SubLink_Details AS Description,
									gls.SubLink_ViewingOrder AS ViewingOrder,
									gls.SubLink_LabelCurrent AS LabelCurrent,
									gls.SubLink_LabelLast AS LabelLast,
									gls.SubLink_InputFieldOrder AS InputFieldOrder,
									gls.Sublink_ShowHide AS ShowHide,
									go.output_current AS CURRENT,
									gls.SubLink_BackgroundColor AS BackgroundColor,
									gls.SubLink_TextColor AS TextColor
									FROM GAME_LINKAGE_SUB gls 
									LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID
									LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gls.SubLink_CompID
									LEFT JOIN GAME_SUBCOMPONENT gsc ON gsc.SubComp_ID=gls.SubLink_SubCompID
									LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID
									LEFT JOIN GAME_OUTPUT go ON go.output_sublinkid=gls.SubLink_ID
									WHERE
									gls.SubLink_Type = 1 AND gls.SubLink_SubCompID = 0 AND gls.SubLink_LinkID=".$linkid." AND gls.SubLink_AreaID=".$row['AreaID']." 
									GROUP BY gls.SubLink_ID ORDER BY gls.SubLink_Order";
									// echo $sqlcomp; exit;
									$component = $functionsObj->ExecuteQuery($sqlcomp);
							//Get Component for this area for this linkid
									while($row1 = mysqli_fetch_array($component)){ 
										switch ($row1['ViewingOrder']) {
											case 1:
											$ComponentName  = "";
											$DetailsChart   = "";
											$InputFields    = "";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 2:
											$ComponentName  = "";
											$InputFields    = "";
											$DetailsChart   = "pull-right";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 3:
											$DetailsChart   = "";
											$InputFields    = "";
											$ComponentName  = "pull-right";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 4:
											$ComponentName  = "hidden removeThis";
											$DetailsChart   = "pull-left";
											$InputFields    = "pull-right";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 5:
											$ComponentName  = "pull-right";
											$DetailsChart   = "pull-right";
											$InputFields    = "";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 6:
											$InputFields    = "pull-left";
											$ComponentName  = "hidden removeThis";
											$DetailsChart   = "pull-right";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 7:
											$ComponentName  = "pull-right";
											$DetailsChart   = "hidden";
											$InputFields    = "";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 8:
											$ComponentName  = "hidden";
											$DetailsChart   = "pull-right";
											$InputFields    = "";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 9:
											$ComponentName  = "";
											$DetailsChart   = "pull-right";
											$InputFields    = "hidden";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 10:
											$ComponentName  = "";
											$DetailsChart   = "hidden";
											$InputFields    = "pull-right";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 11:
											$ComponentName  = "pull-right";
											$DetailsChart   = "";
											$InputFields    = "hidden";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 12:
											$ComponentName  = "hidden";
											$DetailsChart   = "";
											$InputFields    = "";
											$length         = "col-sm-12";
											$cklength       = "col-md-6";
											break;

											case 13:
											$ComponentName  = "";
											$DetailsChart   = "hidden";
											$InputFields    = "pull-right";
											$length         = "col-sm-6";
											$cklength       = "col-md-12";
											break;

											case 14:
											$InputFields    = "";
											$ComponentName  = "pull-right";
											$DetailsChart   = "hidden";
											$length         = "col-sm-6";
											$cklength       = "col-md-12";
											break;

											case 15:
											$ComponentName  = "hidden";
											$DetailsChart   = "";
											$InputFields    = "hidden";
											$length         = "col-sm-12";
											$cklength       = "col-md-12";
											break;

											case 16:
											$ComponentName  = "hidden";
											$DetailsChart   = "";
											$InputFields    = "hidden";
											$length         = "col-sm-6";
											$cklength       = "col-md-12";
											break;

											case 17:
											$ComponentName  = "hidden";
											$DetailsChart   = "";
											$InputFields    = "pull-right";
											$length         = "col-sm-6";
											$cklength       = "col-md-6";
											break;

											case 18:
											$ComponentName  = "hidden";
											$DetailsChart   = "pull-right";
											$InputFields    = "";
											$length         = "col-sm-6";
											$cklength       = "col-md-6";
											break;
										}
										if($length == 'col-sm-6')
										{
											$width  = "col-md-6";
											$width1 = "col-md-6";
										}
										else
										{
											$width  = "col-md-2";
											$width1 = "col-md-4";
										}
										if ($row1['ShowHide'] == 0)
										{
											$hidden = "";
										}
										else
										{
											$hidden = "hidden";
										}
										// echo $row1['ShowHide'].' and '.$hidden; exit();
										switch ($row1['InputFieldOrder']) {
											case 1:
											$labelC = "";
											$labelL = "pull-right";
											break;

											case 2:
											$labelL = "";
											$labelC = "pull-right";
											break;

											case 3:
											$labelC = "";
											$labelL = "hidden";
											break;

											case 4:
											$labelC = "hidden";
											$labelL = "";
											break;
										}

                   /* if($row1['Current'] == 1){
                    	$labelhide="";
                    	$lblhide="";
                    }
                    elseif($row1['InputFieldOrder'] == 2){
                    	$labelhide="";
                    	$lblhide="";
                    }
                    elseif($row1['InputFieldOrder'] == 3){
                    		$labelhide="hidden";
                    		$lblhide="";
                    }
                    else{
                    		$labelhide="";
                    		$lblhide="hidden";
                    	}*/



								//if ($row1['Area_Name']==$areaname)
								//{
									//echo $row1['Area_Name']." - ".$areaname; 
									//echo $row1['Comp_Name'];

                    	echo "<div class='".$length." scenariaListingDiv ".$hidden."' style='background:".$row1['BackgroundColor']."; color:".$row1['TextColor'].";'>";

                    	echo "<div class='col-sm-2 ".$width." regular text-center ".$ComponentName."'>";

                    	echo $row1['Comp_Name'];
                    	echo "</div>";
                    	echo "<div class='col-sm-4 ".$cklength." no_padding ".$DetailsChart."'>".$row1['Description']."</div>";

                    	echo "<div class=' col-sm-6 ".$width1." text-center ".$InputFields."'>";
                    	// if the value is null then make it 0
                    	$row1['CURRENT'] = $row1['CURRENT']?$row1['CURRENT']:'0';
                    	$sqlOutcome      = "SELECT * FROM GAME_PERSONALIZE_OUTCOME gpo WHERE gpo.Outcome_CompId=".$row1['CompID']." AND gpo.Outcome_LinkId=".$linkid." AND (gpo.Outcome_MinVal >=".$row1['CURRENT']." OR gpo.Outcome_MaxVal <=".$row1['CURRENT'].") AND gpo.Outcome_IsActive=0";
                    	// echo $row1['CURRENT'].' mk';
                    	$objRes       = $functionsObj->ExecuteQuery($sqlOutcome);
                    	$objectResult = $functionsObj->FetchObject($objRes);
                      // if same component and not the default outcome selected i.e. 3
                    	if($row1['CompID'] == $objectResult->Outcome_CompId && $objectResult->Outcome_FileType != 3)
                    	{
                    		echo "<div class ='InlineBox'>";
                    		// echo "<label class ='scenariaLabel'>OutcomeResult</label>";
                    		echo "<img id='".$objectResult->Outcome_FileName."' src='".site_root."ux-admin/upload/Badges/".$objectResult->Outcome_FileName."' alt='Outcome_image' width=100 height=100 />";
                    		echo "</div>";
                    		echo "<div class='InlineBox hidden ".$labelC."'>";
                    		echo "<label class='scenariaLabel'>".$row1['LabelCurrent']."</label>";
                    		echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value='".$row1['CURRENT']."' readonly></input>";
                    		echo "</div>";
                    	}
                    	else
                    	{
                    		echo "<div class='InlineBox ".$labelC."'>";
                    		echo "<label class='scenariaLabel'>".$row1['LabelCurrent']."</label>";
                    		echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value='".$row1['CURRENT']."' readonly></input>";
                    		echo "</div>";
                    		echo "<div class='InlineBox ".$labelL."'>";
                    		echo "<label class='scenariaLabel'>".$row1['LabelLast']."</label>";
                    		echo "<input type='text' class='scenariaInput' value='".$row1['Last']."' readonly></input>";
                    		echo "</div>";
                    	}
                    	
                    	echo "</div>";
                    	if($row1['ViewingOrder'] == 4)
                    	{
                    		echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['Comp_Name']." </div>";
                    	}
                    	if($row1['ViewingOrder'] == 6)
                    	{
                    		echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['Comp_Name']." </div>";
                    	}

                    	echo "<div class='clearfix'></div>";

									//Get SubComponent for this Component, linkid
                    	$sqlsubcomp = "SELECT distinct a.Area_ID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID,  
                    	a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name,ls.SubLink_ViewingOrder as ViewingOrder,
                    	ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast,ls.SubLink_InputFieldOrder as InputFieldOrder,
                    	ls.subLink_ShowHide as ShowHide,
                    	ls.SubLink_Details as Description ,ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor
                    	FROM GAME_LINKAGE l 
                    	INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                    	INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                    	INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                    	INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                    	LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                    	INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                    	WHERE ls.SubLink_Type=1 AND ls.SubLink_SubCompID>0 and ls.SubLink_CompID=".$row1['CompID']." ORDER BY ls.SubLink_Order";
										//echo $sqlsubcomp;exit;

                    	$subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
									//Get Component for this area for this linkid
                    	while($row2 = mysqli_fetch_array($subcomponent)){
                    		switch ($row2['ViewingOrder']) {
                    			case 1:
                    			$SubcomponentName  = "";
                    			$DetailsChart      = "";
                    			$InputFields       = "";
                    			$length         	 = "col-sm-12";
                    			$cklength       	 = "col-md-6";
                    			break;

                    			case 2:
                    			$SubcomponentName  = "";
                    			$InputFields       = "";
                    			$DetailsChart      = "pull-right";
                    			$length         	 = "col-sm-12";
                    			$cklength       	 = "col-md-6";
                    			break;

                    			case 3:
                    			$DetailsChart     = "";
                    			$InputFields      = "";
                    			$SubcomponentName = "pull-right";
                    			$length         	= "col-sm-12";
                    			$cklength       	= "col-md-6";
                    			break;

                    			case 4:
                    			$SubcomponentName = "hidden removeThis";
                    			$DetailsChart     = "pull-left";
                    			$InputFields      = "pull-right";
                    			$length         	= "col-sm-12";
                    			$cklength         = "col-md-6";
                    			break;

                    			case 5:
                    			$SubcomponentName  = "pull-right";
                    			$DetailsChart      = "pull-right";
                    			$InputFields       = "";
                    			$length         	 = "col-sm-12";
                    			$cklength       	 = "col-md-6";
                    			break;

                    			case 6:
                    			$InputFields       = "pull-left";
                    			$SubcomponentName  = "hidden removeThis";
                    			$DetailsChart      = "pull-right";
                    			$length            = "col-sm-12";
                    			$cklength       	 = "col-md-6";
                    			break;

                    			case 7:
                    			$SubcomponentName  = "pull-right";
                    			$DetailsChart      = "hidden";
                    			$InputFields       = "";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 8:
                    			$SubcomponentName  = "hidden";
                    			$DetailsChart      = "pull-right";
                    			$InputFields       = "";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 9:
                    			$SubcomponentName = "";
                    			$DetailsChart     = "pull-right";
                    			$InputFields      = "hidden";
                    			$length           = "col-sm-12";
                    			$cklength         = "col-md-6";
                    			break;

                    			case 10:
                    			$SubcomponentName  = "";
                    			$DetailsChart      = "hidden";
                    			$InputFields       = "pull-right";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 11:
                    			$SubcomponentName  = "pull-right";
                    			$DetailsChart      = "";
                    			$InputFields       = "hidden";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 12:
                    			$SubcomponentName  = "hidden";
                    			$DetailsChart      = "";
                    			$InputFields       = "";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 13:
                    			$SubcomponentName  = "";
                    			$DetailsChart      = "hidden";
                    			$InputFields       = "";
                    			$length            = "col-sm-6";
                    			$cklength          = "col-md-12";
                    			break;

                    			case 14:
                    			$InputFields       = "";
                    			$SubcomponentName  = "pull-right";
                    			$DetailsChart      = "hidden";
                    			$length            = "col-sm-6";
                    			$cklength          = "col-md-12";
                    			break;

                    			case 15:
                    			$SubcomponentName  = "hidden";
                    			$DetailsChart      = "";
                    			$InputFields       = "hidden";
                    			$length            = "col-sm-12";
                    			$cklength          = "col-md-12";
                    			break;

                    			case 16:
                    			$SubcomponentName  = "hidden";
                    			$DetailsChart      = "";
                    			$InputFields       = "hidden";
                    			$length            = "col-sm-6";
                    			$cklength          = "col-md-12";
                    			break;

                    			case 17:
                    			$SubcomponentName  = "hidden";
                    			$DetailsChart      = "";
                    			$InputFields       = "pull-right";
                    			$length            = "col-sm-6";
                    			$cklength          = "col-md-6";
                    			break;

                    			case 18:
                    			$SubcomponentName = "hidden";
                    			$DetailsChart     = "pull-right";
                    			$InputFields      = "";
                    			$length           = "col-sm-6";
                    			$cklength         = "col-md-6";
                    			break;
                    		}

                    		if($length=='col-sm-6')
                    		{
                    			$width="col-md-6";
                    			$width1="col-md-6";
                    		}
                    		else
                    		{
                    			$width="col-md-2";
                    			$width1="col-md-4";
                    		}
                    		if ($row2['ShowHide'] == 0)
                    		{
                    			$hidden="";
                    		}
                    		else
                    		{
                    			$hidden= "hidden";
                    		}

                    		switch ($row2['InputFieldOrder'])
                    		{
                    			case 1:
                    			$labelC="";
                    			$labelL="pull-right";
                    			break;

                    			case 2:
                    			$labelL="";
                    			$labelC="pull-right";
                    			break;

                    			case 3:
                    			$labelC="";
                    			$labelL="hidden";
                    			break;

                    			case 4:
                    			$labelC="hidden";
                    			$labelL="";
                    			break;
                    		}
                 /* if($row2['ShowHide'] == 0)
                  {

                  }*/
                // if component div is half length then make subcomponent div col-md-12
                  echo "<div class='".$length." subCompnent ".$hidden."' style='background:".$row2['BackgroundColor']."; color:".$row2['TextColor'].";'>";
                  echo "<div class='col-sm-2 ".$width." regular text-center".$SubcomponentName."'>";
                  echo $row2['SubComp_Name'];
                  echo "</div>";
                  echo "<div class='col-sm-4 ".$cklength." no_padding".$DetailsChart."'>";
                  echo $row2['Description'];
                  echo "</div>";
                  echo "<div class=' col-sm-6 ".$width1." text-center".$InputFields."'>";
                  echo "<div class='InlineBox ".$labelC."'>";
                  echo "<label class='scenariaLabel'>".$row2['LabelCurrent']."</label>";
                  echo "<input type='text' id='subcomp_".$row2['SubCompID']."' name='".$row2['Area_Name']."_subc_".$row2['SubCompID']."' class='scenariaInput' readonly></input>";
                  echo "</div>";
                  echo "<div class='InlineBox ".$labelL."'>";
                  echo "<label class='scenariaLabel'>".$row2['LabelLast']."</label>";
                  echo "<input type='text' class='scenariaInput' readonly></input>";
                  echo "</div>";
											//echo "<div class='InlineBox'>";
											//	echo "<label class='scenariaLabel'>Difference</label>";
											//	echo "<input type='text' class='scenariaInput' readonly></input>";
											//echo "</div>";
											//echo "<div class='InlineBox'>";
												//echo "<label class='scenariaLabel'>Change %</label>";
												//echo "<input type='text' class='scenariaInput' readonly></input>";
											//echo "</div>";
                  echo "</div>";
                  if($row2['ViewingOrder'] == 4)
                  {
                  	echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['SubComp_Name']." </div>";
                  }
                  if($row2['ViewingOrder'] == 6)
                  {
                  	echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['SubComp_Name']." </div>";
                  }
                  echo "<div class='clearfix'></div>";
                  echo "</div>";

                }
                echo "</div>";	
								//}
								//else{

								//}
              }
							//<!--scenariaListingDiv-->
              echo "</div>";
            }
            ?>
          </div>
        </div> <!--tab content -->
        <div class="clearix"></div>
      </div>					

      <div class="col-sm-12 text-right">
      	<!--<button class="btn innerBtns">Save</button>-->
      	<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button>
      	<!-- <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Next</button> -->
      </div>

    </div><!--row-->
  </form>
</div><!--container---->
</section>	

<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<span> </span>
			</div>
		</div>
	</div>
</footer>
<script src="js/jquery.min.js"></script>	
<script src="js/bootstrap.min.js"></script>	
<script>
	$(document).ready(function(){
		$(".removeThis").each(function(){
			$(this).remove();
		});
	});
</script>
</body>
</html>
