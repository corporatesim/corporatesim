<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/ManageScenario/del/";
		var loc_url_stat = "ux-admin/ManageScenario/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Scenario</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Scenario</li>			
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="pull-right legend">
			<ul>
				<li><b>Legend : </b></li>
				<li> <span class="glyphicon glyphicon-ok">		</span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active	</a></li>
				<li> <span class="glyphicon glyphicon-remove">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive	</a></li>
				<!--<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>-->
				<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
				<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
				<li> <span class="fa fa-book">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Content"> General	</a></li>
				<li> <span class="fa fa-file-o">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Document"> Document	</a></li>
				<li> <span class="fa fa-image">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Image"> Image	</a></li>
				<li> <span class="fa fa-video-camera">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="To Add/ Edit Video"> Video	</a></li>
				<li> <span class="fa fa-code-fork">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching"> Branching	</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Scenarios List</label>
			<?php if($functionsObj->checkModuleAuth('scenario','add')){ ?>
				<div class="pull-right">
					<input class="btn btn-primary" type="button" name="addsiteuser" value="Add Scenario"
					onclick="window.location.href='<?php echo site_root."ux-admin/ManageScenario/add/1"; ?>';"/>
				</div>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Comments</th>
							<th>Header</th>
							<th class="no-sort">Upload Option</th>
							<th>I/P Button Status</th>
							<th class="no-sort">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i=1; while($row = $object->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo $row->Scen_Name; ?></td>
								<td><?php echo $row->Scen_Comments;?></td>
								<td><?php echo $row->Scen_Header;?></td>

								<td class="text-center">
									<a href="<?php echo site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($row->Scen_ID); ?>"
										data-toggle="tooltip" title="General"><span class="fa fa-book"></span></a>
										<a href="<?php echo site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($row->Scen_ID); ?>"
											data-toggle="tooltip" title="Document"><span class="fa fa-file-o"></span></a>
											<a href="<?php echo site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($row->Scen_ID); ?>"
												data-toggle="tooltip" title="Image"><span class="fa fa-image"></span></a>								
												<a href="<?php echo site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($row->Scen_ID); ?>"
													data-toggle="tooltip" title="Video"><span class="fa fa-video-camera"></span></a>
												</td>
												<td>
													<?php echo ($row->Scen_InputButton == 0)?'Hidden':'Show';?>
												</td>
												<td class="text-center">
													<?php if($row->Scen_Status == 0){?>
														<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->Scen_ID; ?>"
															data-toggle="tooltip" title="Deactive"><span class="fa fa-times"></span></a>
														<?php }else{?>
															<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->Scen_ID; ?>"
																data-toggle="tooltip" title="Active"><span class="fa fa-check"></span></a>
															<?php } if($functionsObj->checkModuleAuth('scenario','edit')){ ?>
																<a href="<?php echo site_root."ux-admin/ManageScenario/edit/".base64_encode($row->Scen_ID); ?>"
																	data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>
																<?php } if($functionsObj->checkModuleAuth('scenario','delete')){ ?>
																	<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->Scen_ID; ?>"
																		data-toggle="tooltip" title="Delete"><span class="fa fa-trash"></span></a>
																	<?php } ?>
																	<?php if($row->Scen_Branching == 1){ ?>
																		<a href="javascript:void(0);" data-toggle="tooltip" title="Component Branching"><span class="fa fa-code-fork"></span></a>
																		<?php } ?>
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