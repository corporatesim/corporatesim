<style type="text/css">
	input:focus:invalid {
		border-color: red;
	}

	input:focus:valid {
		border-color: green;
	}

	span.alert-danger {
		background-color: #ffffff;
		font-size: 18px;
	}

	.access_user {
		margin-bottom: 2px;
	}
	#category_selection  .form-group, #access_selection .form-group{
		margin-bottom: 5px;
	}
</style>

<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/AdminUsers/delete/";
		var loc_url_stat = "ux-admin/AdminUsers/stat/";
//-->
</script>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">
			<a href="<?php echo site_root."ux-admin/AdminUsers"; ?>" data-toggle="tooltip" title="Add Admin Users">
				<i class="fa fa-plus-circle"></i>
			</a>
			Admin Users
		</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Manage Users</a></li>
			<li class="active">Admin Users</li>
		</ul>
	</div>
</div>


<?php if(isset($msg)){ ?>
	<div class="form-group <?php echo $type[1]; ?>">
		<div align="center" class="form-control" id="<?php echo $type[0]; ?>">
			<label class="control-label" for="<?php echo $type[0] ?>"><?php echo $msg ?></label>
		</div>
	</div>
<?php } ?>

<div class="row">
	<div class="col-sm-12">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b>Admin Users List</b>
					</div>
					<div class="panel-body">
						<div class="dataTable_wrapper">
							<table class="table table-striped table-bordered table-hover"
							id="dataTables-example">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Username</th>
									<th>Email</th>
									<th>Password</th>
									<th>Date</th>
									<th>Status</th>
									<th class="no-sort">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								if ($adminUsersList->num_rows > 0) {
									while ( $row = $adminUsersList->fetch_object () ) {
										?>
										<tr>
											<th><?php echo $i."."; ?></th>
											<td><?php echo $row->fname." ".$row->lname; ?></td>
											<td><?php echo $row->username; ?></td>
											<td><?php echo $row->email; ?></td>
											<td><?php echo ($row->password_view)?$row->password_view:$row->password; ?></td>
											<td><?php echo date('d-m-Y',strtotime($row->date_time)); ?></td>
											<td class="text-center">
												<?php if($_SESSION['ux-admin-id'] != $row->id){ ?>
													<?php if($row->status == 1){ ?>
														<a href="javascript:void(0);"
														class="cs_btn" id="<?php echo $row->id; ?>" title="Active">
														<span class="fa fa-check"></span>
													</a>
												<?php }else{ ?>
													<a href="javascript:void(0);"
													class="cs_btn" id="<?php echo $row->id; ?>" title="Deactive">
													<span class="fa fa-remove"></span>
												</a>
											<?php } ?>
										<?php }else{ echo "-";} ?>
									</td>
									<td class="text-center">
										<?php if($_SESSION['ux-admin-id'] != $row->id){ ?>
											<a
											href="<?php echo site_root."ux-admin/AdminUsers/edit/".base64_encode($row->id); ?>"
											class="" title="Edit">
											<span class="fa fa-pencil"></span>
										</a>

											<!--a href="javascript:void(0);"
												class="dl_btn" id="<?php echo $row->id; ?>" title="Delete">
												<span class="fa fa-trash-o"></span>
											</a-->

										<?php }else{ echo "-";} ?>
									</td>
								</tr>
								<?php $i++; } } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
