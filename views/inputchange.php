<?php 
include_once 'includes/header.php'; 
?>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.9.0/math.min.js"></script>-->
  	<script src="js/jquery.min.js"></script>	
	<script src="js/bootstrap.min.js"></script>			

<script type="text/javascript">
function showUser(str) {
	alert("str.id - "+str.id);
	alert("str.value - " +str.value);
	$.each($("input[type='hidden']"), function (index, value) {		
		alert("value - "+$(value));
		var strval =$(value).val();
		//alert (strval);
		strval = strval.replace(str.id, str.value+'');
		alert ("strval - "+strval);
		alert($(value).attr('name'));
		document.getElementById($(value).attr('name')).value=strval;
		//alert (strval);
		//alert(strval.indexOf('comp'));
		//alert(strval.indexOf('subc'));
		var strname = $(value).attr('name');
		//alert (strname);
		if (strval.indexOf('comp')==-1 && strval.indexOf('subc')==-1){
			//alert(math.eval(strval));
			document.getElementById($(value).attr('name')).value=math.eval(strval);
			strname = strname.substr(3);
			document.getElementById(strname).value=math.eval(strval);
			//alert(strname.substr(3));
		}
		//if (strval.indexOf("title") !=-1) {
		//if strval doesnot contain comp or subc then evaluate		
	});
}
</script>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Game." | ".$result->Scenario ; }?> Decisions</h2></div>
				<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>
				<div class="clearfix"></div>
				
				<!--<form method="POST" action="" id="game_frm" name="game_frm">-->
					<div class="col-sm-12 no_padding shadow">
						<div class="col-sm-6 ">
							<span style="margin-right:20px;"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">Game Description</a></span>
							<a href="<?php echo $scenurl; ?>" target="_blank" class="innerPageLink">Scenario Description</a>
						</div>
						<div class="col-sm-6  text-right">
							<button class="btn innerBtns">Save</button>
							<button class="btn innerBtns">Submit</button>
						</div>
						<div class="col-sm-12"><hr style="margin: 5px 0;"></hr></div>
						
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
						//echo "Area - ".$sqlarea;
						while($row = mysqli_fetch_array($area)) {
							$areaname = $row['Area_Name'];
							//echo row['Area_Name'];
							if($i==0)
							{
								echo "<div role='tabpanel' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
							}
							else{
								echo "<div role='tabpanel' class='tab-pane' id='".$row['Area_Name']."Tab'>";
							}
							$i++;
							
							$sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, 
								c.Comp_Name as Comp_Name, ls.SubLink_Details as Description, ls.SubLink_InputMode as Mode, f.expression as exp , ls.SubLink_ID as SubLinkID 
							FROM GAME_LINKAGE l 
									INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
									INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
									INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
									INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
									LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
									INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
									LEFT OUTER JOIN GAME_FORMULAS f on ls.SubLink_FormulaID=f.f_id 
							WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
							//echo "Component - ".$sqlcomp;
							$component = $functionsObj->ExecuteQuery($sqlcomp);
							//Get Component for this area for this linkid
							echo $areaname;
							echo "<form method='POST' action='' id='".$areaname."' name='".$areaname."'> ";
							while($row1 = mysqli_fetch_array($component)){										
									echo "<div class='col-sm-12 scenariaListingDiv'>";							
									echo "<div class='col-sm-2 col-md-2 regular'>";
									echo $row1['Comp_Name'];
									echo "</div>";
									echo "<div class='col-sm-4 col-md-6 no_padding'>".$row1['Description']."</div>";
								
									echo "<div class=' col-sm-6 col-md-4 text-right'>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Current</label>";
											echo "<input type='hidden' id='linkcomp_".$row1['CompID']."' name='linkcomp_".$row1['CompID']."' value='".$row1['SubLinkID']."'>";
											echo "<input type='text' id='comp_".$row1['CompID']."' name='comp_".$row1['CompID']."' class='scenariaInput current'  ";	//onChange='showUser(this);'
											if ($row1['Mode']!="user")
											{
												echo "readonly";
											}
											echo "></input>";
											if ($row1['Mode']=="formula")
											{
												echo "<input type='hidden' id='expcomp_".$row1['CompID']."' name='expcomp_".$row1['CompID']."' value='".$row1['exp']."'>";
											}
										echo "</div>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Last</label>";
											echo "<input type='text' class='scenariaInput' readonly></input>";
										echo "</div>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Difference</label>";
											echo "<input type='text' class='scenariaInput' readonly></input>";
										echo "</div>";
										echo "<div class='InlineBox'>";
											echo "<label class='scenariaLabel'>Change %</label>";
											echo "<input type='text' class='scenariaInput' readonly></input>";
										echo "</div>";
									echo "</div>";
									echo "<div class='clearfix'></div>";
																		
									//Get SubComponent for this Component, linkid
									$sqlsubcomp = "SELECT distinct a.Area_ID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID,  
											a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name, 
											ls.SubLink_Details as Description, ls.SubLink_InputMode as Mode , f.expression as exp , ls.SubLink_ID as SubLinkID 
										FROM GAME_LINKAGE l 
												INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
												INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
												INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
												INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
												LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
												INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
												LEFT OUTER JOIN GAME_FORMULAS f on ls.SubLink_FormulaID=f.f_id 
										WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID>0 and l.Link_ID=".$linkid." and ls.SubLink_CompID=".$row1['CompID']." ORDER BY ls.SubLink_Order";
									//echo "SubComponent - ".$sqlsubcomp;
									$subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
									//Get Component for this area for this linkid
									while($row2 = mysqli_fetch_array($subcomponent)){
										echo "<div class='col-sm-12 subCompnent'>";
										echo "<div class='col-sm-2 col-md-2 regular'>";
											echo $row2['SubComp_Name'];
										echo "</div>";
										echo "<div class='col-sm-4 col-md-6 no_padding'>";
											echo $row2['Description'];
										echo "</div>";
										echo "<div class=' col-sm-6 col-md-4 text-right'>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Current</label>";
												echo "<input type='hidden' id='linksubc_".$row2['SubCompID']."' name='linksubc_".$row2['SubCompID']."' value='".$row2['SubLinkID']."'>";
												echo "<input type='text' id='subc_".$row2['SubCompID']."' name='subc_".$row2['SubCompID']."' class='scenariaInput current'  ";	//onChange='showUser(this);'
												if ($row2['Mode']!="user")
												{
													echo "readonly";
												}
												echo "></input>";
												if ($row2['Mode']=="formula")
												{
													echo "<input type='hidden' id='expsubc_".$row2['SubCompID']."' name='expsubc_".$row2['SubCompID']."' value='".$row2['exp']."'>";
												}
											echo "</div>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Last</label>";
												echo "<input type='text' class='scenariaInput' readonly></input>";
											echo "</div>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Difference</label>";
												echo "<input type='text' class='scenariaInput' readonly></input>";
											echo "</div>";
											echo "<div class='InlineBox'>";
												echo "<label class='scenariaLabel'>Change %</label>";
												echo "<input type='text' class='scenariaInput' readonly></input>";
											echo "</div>";
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
								<div class="col-sm-12 text-right">
									<button type="button" class="btn innerBtns" name="save_input" id="save_input">Save</button>
									<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Submit</button>
									<?php //echo site_root; ?>
								</div>
								
								<script type="text/javascript">
								//<!--
								
									$('#save_input').click( function(){	
										//alert($("#tab-pane").find(".active").attr('id'));
										var form = $('#game_frm').get(0);
										
										//alert (site_root +"includes/ajax/ajax_addedit_input.php");
										$.ajax({
											//alert(result);
											url:  "includes/ajax/ajax_addedit_input.php",
											type: "POST",
											data: new FormData(form),
											processData: false,
											cache: false,
											contentType: false,
											beforeSend: function(){
												//alert("beforeSend");
												$('#loader').addClass( 'loader' );
											},
											success: function( result ){
												try{
													alert (result);
													var response = JSON.parse( result );
													if( response.status == 1 ){
														//$('#Modal_Success').modal('show', { backdrop: "static" } );
													} else {
														$('.option_err').html( result.msg );
													}
												} catch ( e ) {
													alert(e + "\n" + result);
													console.log( e + "\n" + result );
												}
												
												$('#loader').removeClass( 'loader' );
											},
											error: function(jqXHR, exception){
												alert('error'+ jqXHR.status +" - "+exception);
											}
										});
									});
								
								//-->
								</script>
								
								</form>
							</div>
						</div> <!--tab content -->
						<div class="clearix"></div>
					</div>		
					
					<!--
					<div class="col-sm-12 text-right">
						<button type="button" class="btn innerBtns" name="save_input" id="save_input">Save</button>
						<button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Submit</button>
						<?php //echo site_root; ?>
					</div>
					-->
				</div><!--row-->
			<!--</form>-->
		</div><!--container---->
	</section>	
	
<!-- Modal -->
<div id="Modal_Success" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="window.location = '<?php echo site_root."ux-admin/ManageQuestions".(!empty($_GET['topic']) ? "/topic/".$_GET['topic'] : "" ); ?>';">&times;</button>
        <h4 class="modal-title"> Question Added Successfully</h4>
      </div>
      <div class="modal-body">
        <p> Question Added Successfully.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="window.location = '<?php echo site_root."ux-admin/ManageQuestions".(!empty($_GET['topic']) ? "/topic/".$_GET['topic'] : "" ); ?>';">Ok</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal -->
<div id="Modal_Update_Success" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="window.location = '<?php echo site_root."ux-admin/ManageQuestions".(!empty($_GET['topic']) ? "/topic/".$_GET['topic'] : "" ); ?>';">&times;</button>
        <h4 class="modal-title"> Updated Successfully</h4>
      </div>
      <div class="modal-body">
        <p> Question Details Updated Successfully.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="window.location = '<?php echo site_root."ux-admin/ManageQuestions".(!empty($_GET['topic']) ? "/topic/".$_GET['topic'] : "" ); ?>';">Ok</button>
      </div>
    </div>

  </div>
</div>

	<script type="text/javascript">
	//<!--
	
		$('#save_input').click( function(){	
			//alert('in Save click');
			//alert(site_root);
			var form = $('#game_frm').get(0);
			
			//alert (site_root +"includes/ajax/ajax_addedit_input.php");
			$.ajax({
				//alert(result);
				url:  "includes/ajax/ajax_addedit_input.php",
				type: "POST",
				data: new FormData(form),
				processData: false,
				cache: false,
				contentType: false,
				beforeSend: function(){
					//alert("beforeSend");
					$('#loader').addClass( 'loader' );
				},
				success: function( result ){
					try{
						alert (result);
						var response = JSON.parse( result );
						if( response.status == 1 ){
							//$('#Modal_Success').modal('show', { backdrop: "static" } );
						} else {
							$('.option_err').html( result.msg );
						}
					} catch ( e ) {
						alert(e + "\n" + result);
						console.log( e + "\n" + result );
					}
					
					$('#loader').removeClass( 'loader' );
				},
				error: function(jqXHR, exception){
					alert('error'+ jqXHR.status +" - "+exception);
				}
			});
		});
	
	//-->
	</script>
	
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<span>Footer Area </span>
				</div>
			</div>
		</div>
	</footer>
			
	
	
</body>
</html>
