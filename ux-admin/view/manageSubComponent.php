<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/ManageSubComponent/del/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage Sub Component</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Component</li>
			<li class="active">Sub Component</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){ ?>
<div class="form-group <?php echo $type[1]; ?>">
	<div align="center" class="form-control" id="<?php echo $type[0]; ?>">
		<label class="control-label" for="<?php echo $type[0] ?>"><?php echo $msg; ?></label>
	</div>
</div>
<?php } ?>

<div class="row">
	<div class="col-sm-12">
		<?php if($functionsObj->checkModuleAuth('sub component','add')){ ?>
		<div class="panel panel-default">
			<div class="panel-heading">Add SubComponent</div>
			<div class="panel-body">
				<div class="col-sm-12">
					<form method="post" action="" enctype="multipart/form-data">
						<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
							<label>Select Area</label> <select class="form-control"
								name="area_id" id="area_id">
								<option value="">-- SELECT --</option>
									<?php while($row = $area->fetch_object()){ ?>
										<option value="<?php echo $row->Area_ID; ?>"
									<?php if(isset($result->SubComp_AreaID) && $result->SubComp_AreaID == $row->Area_ID){echo 'selected'; } ?>>
											<?php echo $row->Area_Name; ?>
										</option>
									<?php } ?>
							</select>
						</div>

						<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
							<label>Select Component</label> <select class="form-control"
								name="comp_id" id="comp_id">
								<option value="">-- SELECT --</option>
								<?php
								
								if (isset ( $_GET ['Edit'] )) {
									while ( $row = $component->fetch_object () ) {
										?>
										<option value="<?php echo $row->Comp_ID; ?>"
									<?php if($row->Comp_ID == $result->SubComp_CompID){ echo 'selected'; } ?>><?php echo $row->Comp_Name; ?></option>
								<?php
									
}
								}
								?>
							</select>
						</div>

						<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
							<label>Sub-Component Name</label> <input type="hidden" name="SubComp_ID"
								value="<?php if(isset($_GET['Edit'])){ echo $result->SubComp_ID; } ?>">
							<input class="form-control" type="text" name="SubComp_Name"
								value="<?php if(isset($_GET['Edit'])){ echo $result->SubComp_Name; } ?>">
						</div>
						<div class="clearfix"></div>
						<div class="form-group col-sm-12 text-center"
							style="margin-top: 22px;">
							<?php if(isset($_GET['Edit'])){ ?>
								<button class="btn btn-primary" type="submit" name="submit"
								value="Update">Update</button>
							<button class="btn btn-primary" type="button"
								onclick="window.location='<?php echo site_root."ux-admin/ManageSubComponent"; ?>';">Cancel</button>
							<?php }else{ ?>
								<button class="btn btn-primary" type="submit" name="submit"
								value="Submit">Submit</button>
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
						<li><span class="glyphicon glyphicon-ok"> </span><a
							href="javascript:void(0);" data-toggle="tooltip"
							title="This is Active Status"> Active </a></li>
						<li><span class="glyphicon glyphicon-remove"> </span><a
							href="javascript:void(0);" data-toggle="tooltip"
							title="This Deactive Status"> Deactive </a></li>
						<li><span class="glyphicon glyphicon-search"> </span><a
							href="javascript:void(0);" data-toggle="tooltip"
							title="User Can View the Record"> View </a></li>
						<li><span class="glyphicon glyphicon-pencil"> </span><a
							href="javascript:void(0);" data-toggle="tooltip"
							title="User Can Edit the Record"> Edit </a></li>
						<li><span class="glyphicon glyphicon-trash"> </span><a
							href="javascript:void(0);" data-toggle="tooltip"
							title="User Can Delete the Record"> Delete </a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="form-group"></div>
		<div class="panel panel-default">
			<div class="panel-heading">Sub Component List</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Sub Component Name</th>
								<th>Component Name</th>
								<th>Area Name</th>
								<th class="no-sort">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($subcomponent->num_rows > 0) {
								$i = 1;
								while ( $row = $subcomponent->fetch_object () ) {
									?>
					    	<tr>
								<th><?php echo $i;?></th>
								<td><?php echo $row->SubComp_Name;?></td>
								<td><?php echo $row->c_name;?></td>
								<td><?php echo $row->s_name;?></td>
								<td class="text-center">
									<?php if($functionsObj->checkModuleAuth('sub component','edit')){ ?>
									<a
										href="<?php echo site_root."ux-admin/ManageSubComponent/Edit/".base64_encode($row->SubComp_ID);?>"
										title="Edit">
										<span class="fa fa-pencil"></span>
									</a>
									<?php } if($functionsObj->checkModuleAuth('sub component','delete')){ ?>
									<a	href="javascript:void(0);" class="dl_btn"
										id="<?php echo $row->SubComp_ID; ?>" title="Delete">
										<span class="fa fa-trash"></span>
									</a>
									<?php } ?>
								</td>
							</tr>
								<?php
									
$i ++;
								}
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#area_id').change( function(){
		var area_id = $(this).val();
		//alert(area_id);
		$('#comp_id').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { area_id: area_id },
			success: function(data){
				$('#comp_id').html(data);
			}
		});
	});

</script>