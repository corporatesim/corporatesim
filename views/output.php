<?php 
include_once 'includes/header.php'; 
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> - Outcome</h2></div>
				<!--<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Game." | ".$result->Scenario ; }?> Your Output</h2></div>
					<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->

					<div class="clearfix"></div>

					<form method="POST" action="" id="game_frm" name="game_frm">
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
							<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button>
						</div>
						
						<!-- Nav tabs -->	
						<div class=" TabMain col-sm-12">
							<ul class="nav nav-tabs" role="tablist">
								<?php 
								$i=0;
								while($row = mysqli_fetch_array($area)) {
										//echo $row->Area_Name;
									if($i==0)
									{
										echo "<li role='presentation' class='active regular'><a href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
									}else{
										echo "<li role='presentation' class='regular'><a href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
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
								$i=0;
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

									$sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, 
									c.Comp_Name as Comp_Name, ls.SubLink_Details as Description ,ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast,ls.Sublink_ShowHide as ShowHide , o.output_current as Current 
									FROM GAME_LINKAGE l 
									INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID= ls.SubLink_LinkID 
									INNER JOIN GAME_OUTPUT o on ls.SubLink_ID = o.output_sublinkid
									INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
									INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
									INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
									LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
									INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
									WHERE ls.SubLink_Type=1 AND o.output_user=".$userid." AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
						//echo $sqlcomp; exit;
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

									  if ($row1['ShowHide'] == 0)
									    {

										    $hidden="";

										 	}

                      else
                     {

                    	 $hidden= "hidden";

                     }

									
                 

								//if ($row1['Area_Name']==$areaname)
								//{
									//echo $row1['Area_Name']." - ".$areaname;
									//echo $row1['Comp_Name'];
										echo "<div class='".$length." scenariaListingDiv ".$hidden."'>";

										echo "<div class='col-sm-2 ".$width." regular text-center ".$ComponentName."'>";

										echo $row1['Comp_Name'];
										echo "</div>";
										echo "<div class='col-sm-4 ".$cklength." no_padding ".$DetailsChart."'>".$row1['Description']."</div>";

										echo "<div class=' col-sm-6 ".$width1." text-center ".$InputFields."'>";

										echo "<div class='InlineBox'>";
										echo "<label class='scenariaLabel'>Label Current</label>";
										echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value=".$row1['Current']." readonly></input>";
										echo "</div>";
										echo "<div class='InlineBox'>";
										echo "<label class='scenariaLabel'>Label Last</label>";
										echo "<input type='text' class='scenariaInput' readonly></input>";
										echo "</div>";
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
										 ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast,
										 ls.subLink_ShowHide as ShowHide,
										ls.SubLink_Details as Description 
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

										 if ($row2['ShowHide'] == 0)
									    {

										    $hidden="";

										 	}

                      else
                     {

                    	 $hidden= "hidden";

                     }

                 /* if($row2['ShowHide'] == 0)
                  {

                  }*/
                // if component div is half length then make subcomponent div col-md-12

											echo "<div class='".$length." subCompnent".$hidden."'>";
											echo "<div class='col-sm-2 col-md-2 regular text-center".$SubcomponentName."'>";
											echo $row2['SubComp_Name'];
											echo "</div>";
											echo "<div class='col-sm-4 ".$cklength." no_padding".$DetailsChart."'>";
											echo $row2['Description'];
											echo "</div>";
											echo "<div class=' col-sm-6 col-md-4 text-center".$InputFields."'>";
											echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Label Current</label>";
											echo "<input type='text' id='subcomp_".$row2['SubCompID']."' name='".$row2['Area_Name']."_subc_".$row2['SubCompID']."' class='scenariaInput' readonly></input>";
											echo "</div>";
											echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Label Last</label>";
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
											echo "<div class='col-sm-2 col-md-4 text-center regular'>".$row1['SubComp_Name']." </div>";
										}
										if($row2['ViewingOrder'] == 6)
										{
											echo "<div class='col-sm-2 col-md-4 text-center regular'>".$row1['SubComp_Name']." </div>";
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
						<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Next</button>
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
