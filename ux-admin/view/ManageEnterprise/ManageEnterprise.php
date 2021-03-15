<script type="text/javascript">
	<!--
		var loc_url_del = "ux-admin/ManageEnterprise/delete/";
		var loc_url_stat = "ux-admin/ManageEnterprise/stat/";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage Enterprise</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Manage Enterprise</li>			
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
					<li> <span class="glyphicon glyphicon-search">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View		</a></li>
					<li> <span class="glyphicon glyphicon-pencil">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit		</a></li>
					<li> <span class="glyphicon glyphicon-trash">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete	</a></li>
					<li> <span class="fa fa-picture-o">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="Enterprise Icon"> Logo	</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label style="padding-top:7px;">Enterprise List</label>
				<div class="pull-right">
					<a href="<?php echo site_root."ux-admin/ManageEnterprise/add/add";?>" class="btn btn-primary btn-lg btn-block">Add Enterprise</a>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>EnterpriseName</th>
								<th>CreatedOn</th>
								<th>CreatedBy</th>
								<th>UpdatedOn</th>
								<th>UpdatedBy</th>
								<th>AssignedGames</th>
								<th class="no-sort">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=1; while($row = $object->fetch_object()){ ?>
								<tr>
									<th><?php echo $i;?></th>
									<td><?php echo $row->Enterprise_Name; ?></td>
									<td><?php echo $row->Enterprise_CreatedOn;?></td>
									<td><?php echo $row->User_Name;?></td>
									<td><?php echo $row->Enterprise_UpdatedOn;?></td>
									<td><?php if($row->Enterprise_UpdatedBy==0){ echo "NOT NOW";}else{ ?><?php echo $adminName;}?></td>
									<td><?php if($row->gamecount>0){ echo $row->gamecount;}else{ ?><?php echo "0";}?></td>
									<td class="text-center">
										<a href="<?php echo site_root."ux-admin/ManageEnterprise/edit/".$row->Enterprise_ID; ?>" title="Edit"><span class="fa fa-pencil"></span></a>
										<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->Enterprise_ID; ?>"
											title="Delete"><span class="fa fa-trash"></span></a>
											<?php if($row->Enterprise_Logo){ ?>
												<a href="javascript:void(0);" title="Logo">
													<span class="fa fa-picture-o"></span>
												</a>
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