<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/linkage/linkdel/";
	var loc_url_stat = "ux-admin/linkage/linkstat/";
//-->
</script>

<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}

</style>

<?php 
//echo "Test message";
//exit(); 

?>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="subcomp"){	//
			$("#subcomponent").show();
        }
		if($(this).attr("value")=="comp"){
			$("#subcomponent").hide();
		}
		
		if($(this).attr("value")=="yes"){	//
			$("#tipe_of_chart").show();
        }
		if($(this).attr("value")=="no"){
			$("#tipe_of_chart").hide();
		}
		
		if($(this).attr("value")=="pie"){
			$("#show_choose_name").hide();
			$("#axis_placement").hide();
		}
		
		if($(this).attr("value")=="horizntal-bars"){
			$("#show_choose_name").show();
			$("#axis_placement").show();
		}
		
		if($(this).attr("value")=="vertical-bars"){
			$("#show_choose_name").show();
			$("#axis_placement").show();
		}
		
		if($(this).attr("value")=="trendline"){
			$("#show_choose_name").show();
			$("#axis_placement").show();
		}
		
		if($(this).attr("value")=="3D-bars"){
			$("#show_choose_name").show();
			$("#axis_placement").show();
		}
		
		
		
		if($(this).attr("value")=="formula"){	
			$("#formula").show();
			$("#admin").hide();
			$("#carry").hide();			
		}

		if($(this).attr("value")=="admin"){	
			$("#admin").show();
			$("#formula").hide();
			$("#carry").hide();
		}

		if($(this).attr("value")=="carry"){	
			$("#carry").show();
			$("#formula").hide();
			$("#admin").hide();
		}

		if($(this).attr("value")=="user"){	
			$("#carry").hide();
			$("#formula").hide();
			$("#admin").hide();
		}

    });
});
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Manage Linkage</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
				<div class="col-sm-12">
					<input type="hidden" name="linkid" id="linkid" 
						value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">								
					<div class="col-sm-6">	
						<input type="hidden" name="gameid" id="gameid" value="<?php echo $result->Link_GameID ; ?>">
						<div class="form-group">
							<label>Game : </label><?php echo $result->Game; ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Scenario : </label><?php echo $result->Scenario; ?>
						</div>
					</div>					
				</div>
				<?php //if(isset($_GET['link'])) { 
				
				if($linkscenario->num_rows>0) {
				?>
				<div class="col-sm-12">
					<div class="col-sm-6">
						<label>Copy from Scenario - </label>
						<input type="hidden" name="scenid" id="scenid" value="<?php echo $result->Link_ScenarioID; ?>">
						<select class="form-control" name="scen_id" id="scen_id">
							<option value="">-- SELECT --</option>
								<?php while($row = $linkscenario->fetch_object()){ ?>
									<option value="<?php echo $row->Scen_ID; ?>">
										<?php echo $row->Scen_Name; ?>
									</option>
								<?php } ?>
						</select>
					</div>
					<div class="col-sm-6">
						<button type="button" class="btn btn-primary" name="update_link" id="update_link">Link</button>
					</div>					
				</div>
				<div class="clearfix"></div>
				<?php } ?>
				<?php if(!isset($_GET['linkedit']) && empty($_GET['linkedit'])){ ?>
				<form method="POST" action="" id="linkage_frm" name="linkage_frm">
					<div class="col-sm-12">
						<div class="col-sm-6">
							<input type="hidden" name="Link_ID" id="Link_ID" 
									value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">	
							<button type="submit" name="submit" id="Link_download" class="btn btn-primary"
									value="Download"> Download </button>
						</div>
						<div class="col-sm-6">
							<button type="submit" name="submit" id="User_download" class="btn btn-primary"
									value="UserDownload"> User Report </button>
						</div>
					</div>
				</form>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<!-- DISPLAY ERROR MESSAGE ->
<?php if(isset($msg)){ ?>
<div class="form-group <?php echo $type[1]; ?>">
	<div align="center" id="<?php echo $type[0]; ?>">
		<label class="control-label" for="<?php echo $type[0]; ?>">
				<?php echo $msg; ?>
			</label>
	</div>
</div>
<?php } ?>
!-- DISPLAY ERROR MESSAGE END -->

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
<div class="col-sm-12">
<div class="panel panel-default">
			<div class="panel-body">
	<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
		
		<div class="row">			
			<div class="col-md-4">
				<input type="hidden" name="link" id="link" 
					value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">
				<input type="hidden" name="sublinkid"
					value="<?php if(isset($_GET['link'])){ echo $linkdetails->SubLink_ID; } ?>">								
				<div class="form-group" >
					<label><span class="alert-danger">*</span>Select </label>
					<input type="radio" name="Mode" value="comp"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "checked"; } ?> > Component
					<input type="radio" name="Mode" value="subcomp"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID>0){ echo "checked"; } ?> > Sub Component

				</div>

			</div>			
		<!--</div>
		<div class="row">-->
			<div class="col-md-4" id="component" name="component">
				<!--<label><span class="alert-danger">*</span>Select Component</label> -->
				<select class="form-control" name="comp_id" id="comp_id">
					<option value="">-- SELECT COMPONENT--</option>
						<?php while($row = $component->fetch_object()){ ?>
							<option value="<?php echo $row->Comp_ID; ?>"
						<?php if(isset($linkdetails->SubLink_CompID) && $linkdetails->SubLink_CompID == $row->Comp_ID){echo 'selected'; } ?>>
								<?php echo $row->Comp_Name; ?>
							</option>
						<?php } ?>
				</select>
			</div>
			<div class="col-md-4" id="subcomponent" name="subcomponent" <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID>0){ } else { echo "style='display:none;'";}?> >
				<!--<label><span class="alert-danger">*</span>Select SubComponent</label> -->
				<select class="form-control" name="subcomp_id" id="subcomp_id">
					<option value="">-- SELECT SUBCOMPONENT--</option>
						<?php while($row = $subcomponent->fetch_object()){ ?>
							<option value="<?php echo $row->SubComp_ID; ?>"
						<?php if(isset($linkdetails->SubLink_SubCompID) && $linkdetails->SubLink_SubCompID == $row->SubComp_ID){echo 'selected'; } ?>>
								<?php echo $row->SubComp_Name; ?>
							</option>
						<?php } ?>
				</select>
			</div>
		
		</div>
		
		<br>
		
<!-- -----------------------------------------------      Chart Section        --------------------------------------------------------------->
		<?php
			$chartsval =  $linkdetails->SubLink_Charts;
			$charts = json_decode($chartsval, true);
			//print_r($charts);
			$chart 		= $charts['charts']['chartdisplay'];
			$chartType 	= $charts['charts']['charttype'];
			$chartname 	= $charts['charts']['chartname'];
			$chartaxis 	= $charts['charts']['chartaxis'];
		?>
		
		
		
		<div class="row">
			<div class="col-md-8">
				<label><span class="alert-danger">*</span>Charts: Do you wish to view the above in a chart? </label>
				<input type="radio" name="chart" value="yes"
				<?php if(!empty($chart) && $chart == 'yes'){ echo "checked"; } ?> > Yes &nbsp;&nbsp;
				<input type="radio" name="chart" value="no"
				<?php if(!empty($chart) && $chart == 'no'){ echo "checked"; } ?> > No
			</div>
		</div>
	<br>
	<div id="tipe_of_chart" <?php if(!empty($chart) && $chart == 'yes'){ echo 'style="display:block;"'; } else {echo 'style="display:none;"';}?>>
		<div class="row" >
			<div class="col-md-1"></div>
			<div class="col-md-7">
				<label><span class="alert-danger"></span>Type of chart : </label>
				<input type="radio" name="chartType" value="pie"
				<?php if(!empty($chartType) && $chartType == 'pie'){ echo "checked"; } ?> > Pie &nbsp;&nbsp;
				<input type="radio" name="chartType" value="horizntal-bars"
				<?php if(!empty($chartType) && $chartType == 'horizntal-bars'){ echo "checked"; } ?> > Horizntal-Bars &nbsp;&nbsp;
				<input type="radio" name="chartType" value="vertical-bars"
				<?php if(!empty($chartType) && $chartType == 'vertical-bars'){ echo "checked"; } ?> > Vertical-Bars &nbsp;&nbsp;
				<input type="radio" name="chartType" value="trendline"
				<?php if(!empty($chartType) && $chartType == 'trendline'){ echo "checked"; } ?> > Trendline &nbsp;&nbsp;
				<input type="radio" name="chartType" value="3D-bars"
				<?php if(!empty($chartType) && $chartType == '3D-bars'){ echo "checked"; } ?> > 3D-Bars 
		
			</div>
		</div>
		<br>
		<div class="row" id="show_choose_name" <?php if(!empty($chart) && $chart == 'pie'){ echo 'style="display:none;"'; } else {echo 'style="display:block;"';}?>>
			<div class="col-md-1"></div>
			
			<div class="col-md-3">
				<label>New Chart - Choose Name : </label>
			</div>
			
			<div class="col-md-4">
				<input type="text" name="choose_chart_name" id="choose_chart_name" value="<?php if(!empty($chartname)) echo $chartname; ?>"
						 class="form-control">
			</div>
		</div>
		<br>
		<div class="row" id="axis_placement" <?php if(!empty($chart) && $chart == 'pie'){ echo 'style="display:none;"'; } else {echo 'style="display:block;"';}?>>
			<div class="col-md-1"></div>
			
			<div class="col-md-2">
				<label>Axis Placement : </label>
			</div>
			
			<div class="col-md-2">
				<input type="radio" name="axis_placement" value="x-axis"
				<?php if(!empty($chartaxis) && $chartaxis == 'x-axis'){ echo "checked"; } ?> > X-axis
			</div>
			
			<div class="col-md-2">
				<input type="radio" name="axis_placement" value="y-axis"
				<?php if(!empty($chartaxis) && $chartaxis == 'y-axis'){ echo "checked"; } ?> > Y-axis
			</div>
			
			<div class="col-md-2">
				<input type="radio" name="axis_placement" value="Z-axis"
				<?php if(!empty($chartaxis) && $chartaxis == 'z-axis'){ echo "checked"; } ?> > Z-axis
			</div>
		</div>
			
			
	</div>
		
<!-- -----------------------------------------------      Chart Section   end     --------------------------------------------------------------->
		
	<br>	
		
		<div class="row">
			<div class="col-md-8">
			<!--	<div class="form-group">-->
					<label><span class="alert-danger">*</span>Type - </label>
						<input type="radio" name="Type" value="input"
							<?php if(!empty($linkdetails) && $linkdetails->Link_Mode == 0){ echo "checked"; } ?> > Input
						<input type="radio" name="Type" value="output"
							<?php if(!empty($linkdetails) && $linkdetails->Link_Mode == 1){ echo "checked"; } ?> > Output
			<!--	</div>-->
			</div>
		</div>
		
		<div class="row" >
			<div class="col-md-4">
				<input type="radio" name="inputType" value="formula"
					<?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'formula'){ echo "checked"; } ?> > Formula
			</div>
			<div class="col-md-8">
				<div id="formula" name="formula" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'formula') {} else { echo "style='display:none;'";} ?> >
					<!--<label><span class="alert-danger">*</span>Select Formula</label> -->
					<select class="form-control" name="formula_id" id="formula_id">
						<option value="">-- SELECT FORMULA--</option>
							<?php while($row = $formula->fetch_object()){ ?>
								<option value="<?php echo $row->f_id; ?>"
							<?php if(isset($linkdetails->SubLink_FormulaID) && $linkdetails->SubLink_FormulaID == $row->f_id){echo 'selected'; } ?>>
									<?php echo $row->formula_title; ?>
								</option>
							<?php } ?>
					</select>
					<label id="f_exp" name="f_exp"></label>
				</div>			
			</div>			
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-4">
					<input type="radio" name="inputType" value="admin"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'admin'){ echo "checked"; } ?> > By Admin
			</div>
			<div id="admin" name="admin" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'admin') {} else { echo "style='display:none;'";}?> >
				<div class="col-md-4">
					<!--<label>Current Input</label>-->
					<input type="text" name="current" id="current" value="<?php if(!empty($linkdetails->SubLink_AdminCurrent)) echo $linkdetails->SubLink_AdminCurrent;  ?>" 
						 class="form-control">
				</div>			
				<div class="col-md-4">
					<!--<label>Last Stored Input</label>-->
					<input type="text" name="last" id="last" placeholder="Last Stored Input" value="<?php if(!empty($linkdetails->SubLink_AdminLast)) echo $linkdetails->SubLink_AdminLast; ?>"
							 class="form-control">
				 </div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-4">
					<input type="radio" name="inputType" value="carry"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'carry'){ echo "checked"; } ?> > Carry Forward
			</div>
			
			<div id="carry" name="carry" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'carry') {} else { echo "style='display:none;'";}?> >
			<!-- need link to scenario-->
				<div class="col-md-4" id="carry_scen" name="carry_scen">
					<!--<label><span class="alert-danger">*</span>Select Component</label> -->
					<select class="form-control" name="carry_linkid" id="carry_linkid">
						<option value="">-- SELECT SCENARIO LINK--</option>
							<?php 
							while($row = $objcarry->fetch_object()){ ?>
								<option value="<?php echo $row->Link_ID; ?>"
							<?php if(isset($linkdetails->SubLink_LinkIDcarry) && $linkdetails->SubLink_LinkIDcarry == $row->Link_ID){echo 'selected'; } ?>>
									<?php echo $row->Scen_Name; ?>
								</option>
							<?php } ?>
					</select>
				</div>
				<div class="col-md-4" id="carry_comp" name="carry_comp">
					<!--<label><span class="alert-danger">*</span>Select Component</label> -->
					<select class="form-control" name="carry_compid" id="carry_compid">
						<option value="">-- SELECT COMPONENT--</option>
							<?php 
							while($row = $component->fetch_object()){ ?>
								<option value="<?php echo $row->Comp_ID; ?>"
							<?php if(isset($linkdetails->SubLink_CompIDcarry) && $linkdetails->SubLink_CompIDcarry == $row->Comp_ID){echo 'selected'; } ?>>
									<?php echo $row->Comp_Name; ?>
								</option>
							<?php } ?>
					</select>
				</div>
				<div class="col-md-4"></br></div>
				<div class="col-md-4" id="carry_subcomp" name="carry_subcomp">
					<!--<label><span class="alert-danger">*</span>Select SubComponent</label> -->
					<select class="form-control" name="carry_subcompid" id="carry_subcompid">
						<option value="">-- SELECT SUBCOMPONENT--</option>
							<?php while($row = $subcomponent->fetch_object()){ ?>
								<option value="<?php echo $row->SubComp_ID; ?>"
							<?php if(isset($linkdetails->SubLink_SubCompIDcarry) && $linkdetails->SubLink_SubCompIDcarry == $row->SubComp_ID){echo 'selected'; } ?>>
									<?php echo $row->SubComp_Name; ?>
								</option>
							<?php } ?>
					</select>
				</div>
			</div>
		</div>		
		
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-4">
					<input type="radio" name="inputType" value="user"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'user'){ echo "checked"; } ?> > By User
			</div>
			
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-4">
					<input type="radio" name="inputType" value="none"
						<?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'none'){ echo "checked"; } ?> > None
			</div>
			
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-4">
				<label>Order</label>
			</div>
			<div class="col-md-4">
				<input type="text" name="order" id="order" value="<?php if(!empty($linkdetails->SubLink_Order)) echo $linkdetails->SubLink_Order; ?>"
						 class="form-control"	required>
			</div>

		</div>
		
		<div class="row">
			<div class="col-md-4">
				<input type="radio" name="ShowHide" value="0"
					<?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 0){ echo "checked"; } ?> > Show
				<input type="radio" name="ShowHide" value="1"
					<?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 1){ echo "checked"; } ?> > Hide
			</div>
			<div class="col-md-4">
				<div class='checkbox'>
					<input type='checkbox' <?php if(!empty($linkdetails) && $linkdetails->SubLink_Roundoff == 1) { ?> checked='checked' <?php } ?> name='chkround' id='chkround'> Roundoff
				</div>
			</div>		
		</div>
		<div class="row">
			<div class="col-md-4">
				<label>Replace</label>
			</div>
		</div>
		<div class="row">
			<input type="hidden" name="replaceid1" id="replaceid1" 
				value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_ID; } ?>">
			<div class="col-md-4">
				<input type="text" name="start1" id="start1" 
					value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Start; } ?>" 
					placeholder = "Start" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="end1" id="end1" 
					value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_End; } ?>" 
					placeholder = "End" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="value1" id="value1" 
					value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Value; }?>" 
					placeholder = "Value" class="form-control">
			</div>
		</div>
		<div class="row">
			<input type="hidden" name="replaceid2" id="replaceid2" 
				value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_ID; } ?>">
			<div class="col-md-4">
				<input type="text" name="start2" id="start2" 
					value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Start; } ?>" 
					placeholder = "Start" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="end2" id="end2" 
					value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_End; } ?>"
					placeholder = "End" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="value2" id="value2" 
				value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Value; }?>"
					placeholder = "Value" class="form-control">
			</div>
		</div>
		<div class="row">
			<input type="hidden" name="replaceid3" id="replaceid3" 
				value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_ID; } ?>">		
			<div class="col-md-4">
				<input type="text" name="start3" id="start3" 
				value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Start; } ?>"
					placeholder = "Start" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="end3" id="end3" 
				value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_End; } ?>"
					placeholder = "End" class="form-control">
			</div>			
			<div class="col-md-4">
				<input type="text" name="value3" id="value3" 
				value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Value; }?>"
					placeholder = "Value" class="form-control">
			</div>
		</div>

<!--		
		<div class="row">
			<div class="col-md-4">
				<label>Conditional Formula</label>
			</div>
			<div class="col-md-4">
				<div id="conditionformula" name="conditionformula" >
					<select class="form-control" name="conditionformulaid" id="conditionformulaid">
						<option value="">-- SELECT --</option>
							<?php while($row = $subcomponent->fetch_object()){ ?>
								<option value="<?php echo $row->SubComp_ID; ?>"
							<?php if(isset($linkdetails->Link_ScenarioID) && $linkdetails->Link_ScenarioID == $row->SubComp_ID){echo 'selected'; } ?>>
									<?php echo $row->SubComp_Name; ?>
								</option>
							<?php } ?>
					</select>
				</div>					
			</div>
			
		</div>
		-->
		<div class="row">
			<div class="col-sm-12">
				<label><span class="alert-danger">*</span>Details</label>
				<div class="form-group">
					<!--<div class="input-group">-->
						<textarea id="details" name="details" class="form-control"><?php if(!empty($linkdetails->SubLink_Details)){ echo $linkdetails->SubLink_Details; } ?></textarea>
					<!--</div>-->
					<div class="contact_error"></div>
				</div>
			</div>			
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-center">				
				<?php if(isset($_GET['linkedit']) && !empty($_GET['linkedit'])){?>
					<button type="button" id="siteuser_btn_update" class="btn btn-primary"
						> Update </button>
					<button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden"
						value="Update"> Update </button>
					<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }else{?>
					<button type="button" id="siteuser_btn" class="btn btn-primary"
						value="Submit"> Submit </button>
					<button type="submit" name="submit" id="siteuser_sbmit"
						class="btn btn-primary hidden" value="Submit"> Submit </button>
					<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }?>
				</div>
			</div>
		</div>
	</form>
	</div>
	</div>
</div>
</div>
<div class="clearfix"></div>

<!--
<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
-->
<div class="row">
	<div class="col-lg-12">
		<div class="pull-right legend">
			<ul>
				<li><b>Legend : </b></li>
				<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
				<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
				<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>
				<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
				<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Linkage List</label>

			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
					    <tr>
							<th>#</th>
							<th>Component</th>
							<th>Subcomponent</th>
				      		<th>Type</th>
				      		<th>Show/Hide</th>							
				      		<th>Mode</th>
				      		<th>Order</th>
				      		<th class="no-sort">Action</th>
				    	</tr>
			    	</thead>
			    	<tbody>
						<?php 
							$i=1; while($row = $object1->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo $row->Component; ?></td>
								<td><?php if($row->SubLink_SubCompID > 0) { echo $row->SubComponent; } else  echo "--"; ?></td>
								<td><?php if($row->SubLink_Type ==0 ) { echo "Input"; } else {echo "Output";}?></td>
								<td><?php if($row->SubLink_ShowHide ==0 ) { echo "Show"; } else {echo "Hide";}?></td>
								<td><?php echo $row->SubLink_InputMode;?></td>
								<td><?php echo $row->SubLink_Order;?></td>
																
								<td class="text-center">
									<?php if($row->SubLink_Status == 0){?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->SubLink_ID; ?>"
											title="Deactive"><span class="fa fa-times"></span></a>
									<?php }else{?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->SubLink_ID; ?>"
											title="Active"><span class="fa fa-check"></span></a>
									<?php }?>
									<a href="<?php echo site_root."ux-admin/linkage/linkedit/".$row->SubLink_ID; ?>"
										title="Edit"><span class="fa fa-pencil"></span></a>
									<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->SubLink_ID; ?>"
										title="Delete"><span class="fa fa-trash"></span></a>
								</td>
							</tr>
						<?php $i++; } ?>
					</tbody>
			    </table>
			</div>
		</div>
    </div>
</div>
<div class="clearfix"></div>


<!-- Modal -->
<div id="Modal_Success" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">	  
        <button type="button" class="close" onclick="window.location = '<?php echo site_root."ux-admin/linkage/link/".$result->Link_ID; ?>';">&times;</button>
        <h4 class="modal-title"> Linkage Added Successfully</h4>
      </div>
      <div class="modal-body">
        <p> Linkage Added Successfully.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="window.location = '<?php echo site_root."ux-admin/linkage/link/".$result->Link_ID; ?>';">Ok</button>
      </div>
    </div>

  </div>
</div>

<script>
<!--

$('#siteuser_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
		$( "#siteuser_sbmit" ).trigger( "click" );
//	}
});

$('#siteuser_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
		$( "#siteuser_update" ).trigger( "click" );
//	}
});

// -->
</script>

<script type="text/javascript">
	$('#formula_id').change( function(){
		var formula_id = $(this).val();
		//alert(comp_id);
		//$('#subcomp_id').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { formula_id: formula_id },
			success: function(data){
				//alert(data);
				$('#f_exp').html(data);
			}
		});
	});

	$('#comp_id').change( function(){
		var comp_id = $(this).val();
		//alert(comp_id);
		$('#subcomp_id').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { comp_id: comp_id },
			success: function(data){
				$('#subcomp_id').html(data);
			}
		});
	});
	
	$('#carry_compid').change( function(){
		var comp_id = $(this).val();
		var link_id = $('#carry_linkid').val();
		
		$('#carry_subcompid').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { carry_compid: comp_id , carry_linkid: link_id},
			success: function(data){
				$('#carry_subcompid').html(data);
			}
		});
	});
	
	$('#carry_linkid').change( function(){
		var link_id = $(this).val();
		//alert(comp_id);
		$('#carry_compid').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { link_id: link_id },
			success: function(data){
				//alert(data);
				$('#carry_compid').html(data);
			}
		});
	});

	$('#scen_id').change( function(){
		var thisVal = $(this).val();
		//alert(thisVal);
		$("input[id=scenid]").val(thisVal);		
	});
	
	$('#update_link').click( function(){	
		//alert($('#<%= scenid.ClientID%>').val());
		var link_id = $('#linkid').val();
		var game_id = $('#gameid').val();
		var scen_id = $('#scenid').val();
		//alert(link_id);
		//alert(site_root + "ux-admin/model/ajax/update_game_link.php");
		$.ajax({			
			url: site_root + "ux-admin/model/ajax/update_game_link.php",
			type: "POST",
			data: { Link_id: link_id, Game_id: game_id, Scen_id: scen_id },
			beforeSend: function(){
				//alert("beforeSend");
				$('#loader').addClass( 'loader' );
			},
			success: function( result ){
				try{
					//alert("SUCCESS");
					alert (result);
					var response = JSON.parse( result );
					
					if( response.status == 1 ){
						//alert("Linkage added");
						$('#Modal_Success').modal('show', { backdrop: "static" } );
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
</script>

<script type="text/javascript">
<!--
	CKEDITOR.replace('details');	
	

//-->
</script>