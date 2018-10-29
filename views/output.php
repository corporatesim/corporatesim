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
							<!--<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button>-->
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
								c.Comp_Name as Comp_Name, ls.SubLink_Details as Description , o.output_current as Current 
								FROM GAME_LINKAGE l 
									INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID= ls.SubLink_LinkID 
									INNER JOIN GAME_OUTPUT o on ls.SubLink_ID = o.output_sublinkid
									INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
									INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
									INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
									LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
									INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
							WHERE ls.SubLink_Type=1 AND o.output_user=".$userid." AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
							//echo $sqlcomp;
							$component = $functionsObj->ExecuteQuery($sqlcomp);
							//Get Component for this area for this linkid
							while($row1 = mysqli_fetch_array($component)){
								//if ($row1['Area_Name']==$areaname)
								//{
									//echo $row1['Area_Name']." - ".$areaname;
									//echo $row1['Comp_Name'];
									echo "<div class='col-sm-12 scenariaListingDiv'>";							
									echo "<div class='col-sm-2 col-md-2 regular'>";
									echo $row1['Comp_Name'];
									echo "</div>";
									echo "<div class='col-sm-4 col-md-7 no_padding'>".$row1['Description']."</div>";
								
									echo "<div class=' col-sm-6 col-md-3 text-right'>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Current</label>";
											echo "<input type='text' id='comp_".$row1['CompID']."' class='scenariaInput' value=".$row1['Current']." readonly></input>";
										echo "</div>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Last</label>";
											echo "<input type='text' class='scenariaInput' readonly></input>";
										echo "</div>";
										
									echo "</div>";
									echo "<div class='clearfix'></div>";
																		
									//Get SubComponent for this Component, linkid
									$sqlsubcomp = "SELECT distinct a.Area_ID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID,  
											a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name, 
											ls.SubLink_Details as Description 
										FROM GAME_LINKAGE l 
												INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
												INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
												INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
												INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
												LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
												INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
												WHERE ls.SubLink_Type=1 AND ls.SubLink_SubCompID>0 and ls.SubLink_CompID=".$row1['CompID']." ORDER BY ls.SubLink_Order";

									$subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
									//Get Component for this area for this linkid
									while($row2 = mysqli_fetch_array($subcomponent)){
										echo "<div class='col-sm-12 subCompnent'>";
										echo "<div class='col-sm-2 col-md-2 regular'>";
											echo $row2['SubComp_Name'];
										echo "</div>";
										echo "<div class='col-sm-4 col-md-7 no_padding'>";
											echo $row2['Description'];
										echo "</div>";
										echo "<div class=' col-sm-6 col-md-3 text-right'>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Current</label>";
												echo "<input type='text' id='subcomp_".$row2['SubCompID']."' class='scenariaInput' readonly></input>";
											echo "</div>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Last</label>";
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
	
	
</body>
</html>