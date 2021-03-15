
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
									<label>Select Area</label>
									<select class="form-control" name="area_id" id="area_id" required>
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
									<label>Select Component</label>
									<select class="form-control" name="comp_id" id="comp_id" required>
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
										value="<?php if(isset($_GET['Edit'])){ echo $result->SubComp_Name; } ?>" required>
									</div>

									<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
										<label>Sub-Component Alias</label> <input type="hidden" name="SubComp_ID"
										value="<?php if(isset($_GET['Edit'])){ echo $result->SubComp_ID; } ?>">
										<input class="form-control" type="text" name="SubComp_NameAlias"
										value="<?php if(isset($_GET['Edit'])){ echo $result->SubComp_NameAlias; } ?>">
									</div>

									<div class="clearfix"></div>
									<div class="form-group col-sm-12 text-center" style="margin-top: 22px;">
										<?php if(isset($_GET['Edit'])){ ?>
											<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
											<button class="btn btn-danger" type="button" onclick="window.location='<?php echo site_root."ux-admin/ManageSubComponent"; ?>';">Cancel</button>
										<?php }else{ ?>
											<button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit</button>
										<?php } ?>
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>
				<form method="post" action="">
					<div class="row">
						<div class="col-md-6">
							<a id="HideDownloadIcon"><i class="fa fa-download" aria-hidden="true" data-toggle="tooltip" title="Download SubComponent"></i></a>
							<div id="downloadSubCompo">
								<div class="row" id="sandbox-container">
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="input-sm form-control" id="fromdate" name="fromdate"placeholder="Select Start Date" required readonly/>
										<span class="input-group-addon">to</span>
										<input type="text" class="input-sm form-control" id="enddate" name="enddate" placeholder="Select End Date" required readonly/>
									</div>
								</div>
								<br>
								<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
									<label>Select Area</label> 
									<select class="form-control"
									name="area[]" id="area" multiple>
									<option value="">-- SELECT --</option>
									<?php while($row = $areaforexcel->fetch_object()){ ?>
										<option value="<?php echo $row->Area_ID; ?>"
											<?php if(isset($result->SubComp_AreaID) && $result->SubComp_AreaID == $row->Area_ID){echo 'selected'; } ?>>
											<?php echo $row->Area_Name; ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group col-xs-12 col-sm-8 col-sm-offset-2">
								<label>Select Component</label> <select class="form-control"
								name="comp[]" id="comp" multiple>
								<option value="">-- SELECT --</option>
								<?php

								if (isset ( $_GET ['Edit'] )) {
									while ( $rowdata = $componentforexcel->fetch_object () ) {
										?>   
										<option value="<?php echo $rowdata->Comp_ID; ?>"
											<?php if($rowdata->Comp_ID == $result->SubComp_CompID){ echo 'selected'; } ?>><?php echo $rowdata->Comp_Name; ?></option>
											<?php

										}
									}
									?>
								</select>
							</div>
							<button type="submit" name="download_excel" id="download_excel" class="btn btn-primary" value="Download"> Download </button>
						</div>
					</div>

					<div class="col-md-6">
						<div class="col-sm-12">
							<div class="pull-right legend">
								<ul>
									<li><b>Legend : </b></li>
									<li><span class="glyphicon glyphicon-ok"> </span>
										<a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active </a>
									</li>
									<li><span class="glyphicon glyphicon-remove"> </span>
										<a href="javascript:void(0);" data-toggle="tooltip"	title="This Deactive Status"> Deactive </a>
									</li>
									<li><span class="glyphicon glyphicon-search"> </span>
										<a href="javascript:void(0);" data-toggle="tooltip"	title="User Can View the Record"> View </a>
									</li>
									<li><span class="glyphicon glyphicon-pencil"> </span>
										<a href="javascript:void(0);" data-toggle="tooltip"	title="User Can Edit the Record"> Edit </a>
									</li>
									<li><span class="glyphicon glyphicon-trash"> </span>
										<a href="javascript:void(0);" data-toggle="tooltip"	title="User Can Delete the Record"> Delete </a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="form-group"></div>
			<div class="panel panel-default">
				<div class="panel-heading">Sub Component List
					<a href="javascript:void(0);" class="pull-right" data-toggle="tooltip" title="Refresh Table Data" id="refreshServerSideDataTable">
						<i class="fa fa-refresh"></i>
					</a>
				</div>
				<div class="panel-body">
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root.'ux-admin/model/ajax/dataTables.php';?>" data-action="ManageSubComponent">
							<thead>
								<tr>
									<th>S.N.</th>
									<th>Area ID</th>
									<th>Area Name</th>
									<th>Component ID</th>
									<th>Component Name / Alias</th>
									<th>Sub Component ID</th>
									<th>Sub Component Name</th>
									<th>Sub Component Alias</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
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
			url: "<?php echo site_root; ?>ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { area_id: area_id },
			success: function(data){
				$('#comp_id').html(data);
			}
		});
	});
</script>

<script type="text/javascript">
	$('#area').change( function(){
		var area = $(this).val();
		//alert(area_id);
		$('#comp').html('<option value="">-- SELECT --</option>');

		$.ajax({
			url: "<?php echo site_root; ?>ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { area: area },
			success: function(data){
				$('#comp').html(data);
			}
		});
	});
</script>