<script type="text/javascript">
	<!--
		var loc_url_del = "ux-admin/ManageGameVideo/Delete/";
  //-->
</script>
<div class="row">
	<div class="col-lg-12">
		<div class="col-lg-8">
			<h1 class="page-header">Video</h1>
		</div>
		<div class="col-lg-4 right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
			<a href="<?php echo site_root."ux-admin/ManageGame"; ?>"
				title="Game List"> Back</a> | 
				<a href="<?php echo site_root."ux-admin/ManageGameContent/Edit/".base64_encode($result->Game_ID); ?>"
					title="General"><span class="fa fa-book"></span> Content</a> | 
					<a href="<?php echo site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($result->Game_ID); ?>"
						title="Document"><span class="fa fa-image"></span> Document</a> | 
						<a href="<?php echo site_root."ux-admin/ManageGameImage/Edit/".base64_encode($result->Game_ID); ?>"
							title="Image"><span class="fa fa-image"></span> Image</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading"><label>Game Name : </label><?php echo $result->Game_Name; ?></div>
							<div class="panel-body">
								<div class="col-sm-10 col-sm-offset-1">
									<div class="form-group">
										<label>Game Comments : </label><?php echo $result->Game_Comments; ?>
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
							<div class="panel-heading">Add Video </div>
							<div class="panel-body">
								<div class="col-sm-10 col-sm-offset-1">
									<form method="post" action="" enctype="multipart/form-data">
										<div class="form-group col-sm-12">
											<input type="hidden" name="gameid" value="<?php if(isset($_GET['Edit'])){ echo $result->Game_ID; } ?>" >
											<input type="hidden" name="id" value="<?php if(isset($_GET['tab'])){ echo $resultdoc->GameImg_ID; } ?>" >
											<label>Title</label>
											<input name="vdotitle" id="vdotitle" class="form-control" value="<?php if(isset($_GET['tab'])){ echo $resultdoc->GameVdo_Title; } ?>">
										</div>
										<?php
										if(isset($_GET['tab'])){ 
											if($resultdoc->GameVdo_Type == 1)
											{
												$Default = '';
												$Embed   = 'checked';
											}
											else
											{
												$Default = 'checked';
												$Embed   = '';
											}
										}
										else
										{
											$Default = 'checked';
											$Embed   = '';
										}
										?>
										<div class="form-group col-sm-12">		
											<label class="radio-inline"><input type="radio" name="type" value="0" <?php echo $Default; ?> >Default</label>
											<label class="radio-inline"><input type="radio" name="type" value="1" <?php echo $Embed; ?> >Embed</label>
										</div>

										<div class="form-group col-sm-12">		
											<label>URL</label>
											<input name="vdourl" id="vdourl" class="form-control" value='<?php if(isset($_GET["tab"])){ echo $resultdoc->GameVdo_Name; } ?>'>
										</div>

										<div class="form-group col-sm-12">		
											<label>Comments</label>
											<textarea id="vdocomments" name="vdocomments" class="form-control"><?php if(isset($_GET['tab'])){ echo $resultdoc->GameVdo_Comments; } ?></textarea>
										</div>
										<div class="form-group text-center">
											<?php if(isset($_GET['tab'])){ ?>
												<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
												<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($resultdoc->GameVdo_GameID); ?>';">Cancel</button>
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
								<div class="panel-heading">Video List</div>
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="dataTables-example">
											<thead>
												<tr>
													<th>#</th>
													<th>Title</th>
													<th>URL</th>
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
															<td><?php echo ucfirst($row->GameVdo_Title);?></td>
															<td><?php echo ucfirst($row->GameVdo_Name);?></td>
															<td class="text-center">
																<a href="<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($row->GameVdo_GameID)."/tab/".base64_encode($row->GameVdo_ID);?>"
																	title="Edit">
																	<span class="fa fa-pencil"></span>
																</a>
																<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->GameVdo_ID; ?>"
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