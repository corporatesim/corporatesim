<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/ManageArea/Delete=";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Area</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Master Management</li>
			<li class="active">Area</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-sm-12">
		<?php if($functionsObj->checkModuleAuth('game','add')){ ?>
		<div class="panel panel-default">
			<div class="panel-heading">Add Area</div>
			<div class="panel-body">
				<div class="col-sm-6 col-sm-offset-3">
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group">
							<label>Enter Area Name</label>
							<input type="hidden" name="id" value="<?php if(isset($_GET['Edit'])){ echo $result->Area_ID; } ?>" >
							<input class="form-control" type="text" name="Area_Name" value="<?php if(isset($_GET['Edit'])){ echo $result->Area_Name; } ?>" >
						</div>

						<div class="form-group text-center">
							<?php if(isset($_GET['Edit'])){ ?>
								<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
								<button class="btn btn-primary" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageArea"; ?>';">Cancel</button>
							<?php }else{ ?>
								<button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit</button>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php } ?>
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
			<div class="panel-heading">Area List</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
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
					    					<td><?php echo ucfirst($row->Area_Name);?></td>
					    					<td class="text-center">
												<?php if($functionsObj->checkModuleAuth('game','edit')){ ?>
					    						<a href="<?php echo site_root."ux-admin/ManageArea/Edit/".base64_encode($row->Area_ID);?>"
					    							title="Edit">
					    							<span class="fa fa-pencil"></span>
					    						</a>
												<?php } if($functionsObj->checkModuleAuth('game','delete')){ ?>
					    						<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->Area_ID; ?>"
					    							title="Delete">
					    							<span class="fa fa-trash"></span>
					    						</a>
												<?php } ?>
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
