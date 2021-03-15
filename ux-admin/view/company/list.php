<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/siteusers/del=";
	var loc_url_stat = "ux-admin/siteusers/stat=";
//-->
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Site Users</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Users</li>			
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
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			<label style="padding-top:7px;">Site Users List</label>
			<div class="pull-right">
				<input class="btn btn-primary" type="button" name="addsiteuser" value="Add Site User"
					onclick="window.location.href='<?php echo site_root."ux-admin/siteusers/add/1"; ?>';"/>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
					<thead>
					    <tr>
							<th>#</th>
							<th>Name</th>
				      		<th>E-mail</th>
				      		<th>Contact</th>
				      		<th>Last Login</th>
				      		<th>Date</th>
				      		<th class="no-sort">Status</th>
				      		<th class="no-sort">Action</th>
				    	</tr>
			    	</thead>
			    	<tbody>
						<?php 
							$i=1; while($row = $object->fetch_object()){ ?>
							<tr>
								<th><?php echo $i;?></th>
								<td><?php echo ucfirst($row->User_fname)." ".ucfirst($row->User_lname); ?></td>
								<td><?php echo $row->User_email;?></td>
								<td><?php echo "+91".$row->User_mobile;?></td>
								
								<td><?php if(!empty($row->User_last_login)){ echo date("Y-m-d H:i:s", strtotime($row->User_last_login)); }else{ echo "-"; } ?></td>
								
								<td><?php echo date('d-m-Y',strtotime($row->User_datetime)); ?></td>
								<td class="text-center">
									<?php if($row->User_status == 0){?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->User_id; ?>"
											title="Deactive"><span class="fa fa-times"></span></a>
									<?php }else{?>
										<a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->User_id; ?>"
											title="Active"><span class="fa fa-check"></span></a>
									<?php }?>
								</td>
								<td class="text-center">
									<a href="<?php echo site_root."ux-admin/siteusers/edit/".base64_encode($row->User_id); ?>"
										title="Edit"><span class="fa fa-pencil"></span></a>
									<a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->User_id; ?>"
										title="Delete"><span class="fa fa-trash"></span></a>
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