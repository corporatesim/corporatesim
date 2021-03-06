<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/ManageScenarioContent/Delete/";
//-->
</script>
<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>

<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">
		<h1 class="page-header">General Content</h1>
		</div>
		<div class="col-lg-4 right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
			<a href="<?php echo site_root."ux-admin/ManageScenario"; ?>"
				title="Scenario List"> Back</a> | 
			<a href="<?php echo site_root."ux-admin/ManageScenarioDocument/Edit/".base64_encode($result->Scen_ID); ?>"
				title="Document"><span class="fa fa-image"></span> Document</a> | 
			<a href="<?php echo site_root."ux-admin/ManageScenarioImage/Edit/".base64_encode($result->Scen_ID); ?>"
				title="Image"><span class="fa fa-image"></span> Image</a> |
			<a href="<?php echo site_root."ux-admin/ManageScenarioVideo/Edit/".base64_encode($result->Scen_ID); ?>"
				title="Video"><span class="fa fa-video-camera"></span> Video</a>	
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"><label>Scenario Name : </label><?php echo $result->Scen_Name; ?></div>
			<div class="panel-body">
				<div class="col-sm-10 col-sm-offset-1">					
					<div class="form-group">
						<label>Scenario Comments : </label><?php echo $result->Scen_Comments; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">Add General Content</div>
			<div class="panel-body">
				<div class="col-sm-10 col-sm-offset-1">
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group col-sm-12">
							<input type="hidden" name="gameid" value="<?php if(isset($_GET['Edit'])){ echo $result->Scen_ID; } ?>" >
							<input type="hidden" name="id" value="<?php if(isset($_GET['tab'])){ echo $resultdoc->ScenGen_ID; } ?>" >
							<label>Title</label>
							<input name="gentitle" id="gentitle" class="form-control" value="<?php if(isset($_GET['tab'])){ echo $resultdoc->ScenGen_Title; } ?>">
						</div>
						<div class="form-group col-sm-12">		
							<label>Content</label>
							<textarea id="general_Content" name="general_Content" class="form-control"><?php if(isset($_GET['tab'])){ echo $resultdoc->ScenGen_Content; } ?></textarea>
						</div>
						<div class="form-group text-center">
							<?php if(isset($_GET['tab'])){ ?>
								<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
								<button class="btn btn-primary" type="button" onclick="history.back();">Cancel</button>
							<?php }else{ ?>
								<button class="btn btn-primary" id="submit" type="submit" name="submit" value="Submit">Submit</button>
							<?php } ?>								
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">			
					<div class="col-sm-12">
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
				<div class="panel panel-default">
					<div class="panel-heading">Content List</div>
					<div class="panel-body">
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>#</th>
										<th>Title</th>
										<th>Content</th>
										<th class="no-sort">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php							
										if($object->num_rows > 0){	
											$i=1;
											while($row = $object->fetch_object()){ ?>
												<tr>										
													<th><?php echo $i;?></th>
													<td><?php echo ucfirst($row->ScenGen_Title);?></td>
													<td><?php echo ucfirst($row->ScenGen_Content);?></td>
													<td class="text-center">
														<a href="<?php echo site_root."ux-admin/ManageScenarioContent/Edit/".base64_encode($row->ScenGen_ScenID)."/tab/".base64_encode($row->ScenGen_ID);?>"
															title="Edit">
															<span class="fa fa-pencil"></span>
														</a>
														<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->ScenGen_ID; ?>"
															title="Delete">
															<span class="fa fa-trash"></span>
														</a>
													</td>
												</tr>
										<?php $i++;
											}
										} ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	


<script type="text/javascript">
<!--
	CKEDITOR.replace('general_Content');	
//-->
</script>