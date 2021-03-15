<div class="clearfix"></div>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Site Settings</h1>			
	</div>
</div>
	
<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">Site Settings</li>
		</ul>
	</div>
</div>
	
<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="col-sm-12">
	<div class="dataTable_wrapper">
		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Value</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=1; while ($row = $object->fetch_assoc()){ ?>
					<tr>
						<th><?php echo $i."."; ?></th>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['value']; ?></td>
						<td><a href="<?php echo site_root."ux-admin/SiteSettings&edit=".base64_encode($row['id']); ?>" title="Edit"><i class="fa fa-pencil"></i></a></td>
					</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</div>
<div class="clearfix"></div>
