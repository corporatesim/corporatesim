
<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/ManageComponent/delete/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage Component</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Component</li>
			<li class="active">Component</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-sm-12">
		<?php if($functionsObj->checkModuleAuth('component','add')){ ?>
		<div class="panel panel-default">
			<div class="panel-heading">Add Component</div>
			<div class="panel-body">
				<div class="col-sm-6 col-sm-offset-3">
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label>Select Area</label>
							<input type="hidden" name="Comp_ID" value="<?php if(isset($_GET['edit'])){ echo $result->Comp_ID; } ?>" >
							<select class="form-control" name="Area_ID" id="area">
								<option value="">-- SELECT --</option>
								
								<?php while($row = $Area->fetch_object()){?>
								<option 
									value="<?php echo $row->Area_ID; ?>" 
									<?php if(isset($_GET['edit']) && $result->Comp_AreaID == $row->Area_ID){ 
										echo 'selected'; 
									} ?> >
									<?php echo $row->Area_Name; ?>
								</option>
								<?php } ?>
							</select>
						</div>
						
						<div class="form-group">
							<label>Enter Component Name</label>
							<input class="form-control" type="text" name="Comp_Name" value="<?php if(isset($_GET['edit'])){ echo $result->Comp_Name; } ?>" >
						</div>

						<div class="form-group text-center">
							<?php if(isset($_GET['edit'])){ ?>
								<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
								<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageComponent"; ?>';">Cancel</button>
							<?php }else{ ?>
								<button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit</button>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php }?>
		<div class="row">
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
		<div class="form-group"></div>
		<div class="panel panel-default">
			<div class="panel-heading">Component List</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Component Name</th>
								<th>Area</th>
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
					    					<td><?php echo $row->Comp_Name;?></td>
					    					<td><?php echo $row->Area_Name;?></td>
					    					<td class="text-center">
												<?php if($functionsObj->checkModuleAuth('component','edit')){ ?>
					    						<a href="<?php echo site_root."ux-admin/ManageComponent/edit/".base64_encode($row->Comp_ID);?>" title="Edit"><span class="fa fa-pencil"></span></a>
												<?php } if($functionsObj->checkModuleAuth('component','delete')){ ?>
					    						<a href="javascript:void(0);" class="dl_btn"
					    							id="<?php echo $row->Comp_ID; ?>" title="Delete">
					    							<span class="fa fa-trash"></span>
					    						</a>
												<?php }?>
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

