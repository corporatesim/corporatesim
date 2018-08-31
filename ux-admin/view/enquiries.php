<div class="clearfix"></div>

<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/ManageEnquiry/delete/";
//-->
</script>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Manage Enquiry</h1>			
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Manage Enquiry</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">Enquiry List</div>
		<div class="panel-body">
			<div class="dataTable_wrapper">
				<table id="dataTables-example" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Contact</th>
							<th>Enq. For</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; while($row = $object->fetch_assoc()){ ?>
							<tr>
								<th><?php echo $i.".";?></th>
								<td><?php echo $row['fname']." ".$row['lname']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo "(+91)".$row['contact']; ?></td>
								<td><?php echo $row['enq_for']; ?></td>
								<td>
									<a href="<?php echo site_root."ux-admin/ManageEnquiry/view/".base64_encode($row['eid']); ?>" title="View"><i class="fa fa-search"></i></a>
									<a href="javascript:void(0);" class="dl_btn"
										id="<?php echo $row['eid']; ?>" title="Delete">
										<i class="fa fa-trash"></i>
									</a>
									<a href="<?php echo site_root."ux-admin/ManageEnquiry/reply/".base64_encode($row['eid']); ?>" title="Reply"><i class="fa fa-mail-reply"></i></a>
								</td>
						<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>

<div class="clearfix"></div>