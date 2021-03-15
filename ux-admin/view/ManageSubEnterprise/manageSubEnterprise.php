<script type="text/javascript">
	var loc_url_del = "ux-admin/ManageSubEnterprise/delete/";
	var loc_url_stat = "ux-admin/ManageSubEnterprise/stat/";
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Manage SubEnterprise</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Manage SubEnterprise</li>			
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
					<li> <span class="fa fa-picture-o">	</span><a href="javascript:void(0);" data-toggle="tooltip" title="SubEnterprise Logo"> Logo	</a></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label style="padding-top:7px;">SubEnterprise List</label>
				<div class="pull-right">
					<input class="btn btn-primary" type="button" name="addlink" value="Add SubEnterprise"
					onclick="window.location.href='<?php echo site_root."ux-admin/ManageSubEnterprise/add/add"; ?>';"/>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Enterprise Name</th>
								<th>SubEnterpriseName</th>
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
									<td><?php echo $row->SubEnterprise_Name; ?></td>
									<td><?php echo $row->SubEnterprise_CreatedOn;?></td>
									<td>
										<?php if($row->SubEnterprise_Owner==1){
											echo $row->fname.' '.$row->lname;
										}else{ echo $row->User_fname.' '.$row->User_lname;}?>
									</td>
									<td><?php echo $row->SubEnterprise_UpdatedOn;?>
								</td>
								<td><?php if($row->SubEnterprise_UpdatedBy==$row->User_id){
									echo $row->User_fname.' '.$subEnterpriseDetails->User_lname;}
									else if($row->SubEnterprise_UpdatedBy==$row->id){echo $row->fname.' '.$row->lname;}else{echo "NOT NOW";}?> 
								</td>
								<td><?php if($row->gamecount>0){ echo $row->gamecount;}else{ ?><?php echo "0";}?>
							</td>
							<td class="text-center">
								<a href="<?php echo site_root."ux-admin/ManageSubEnterprise/edit/".$row->SubEnterprise_ID; ?>"title="Edit"><span class="fa fa-pencil"></span></a>
								<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->SubEnterprise_ID;?>"title="Delete"><span class="fa fa-trash"></span></a>
								<?php if ($row->SubEnterprise_Logo) { ?>
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