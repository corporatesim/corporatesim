<script type="text/javascript">
<!--
var loc_url_del = "ux-admin/index?q=RequestedProducts&delete=";
var loc_url_stat = "ux-admin/index?q=RequestedProducts&stat=";
//-->
</script>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Products</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/index?q=Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active">Requested Products</li>
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
		<div class="panel panel-default">
			<div class="panel-heading">
				Product List
			</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover"
						id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Merchant</th>
								<th>Product Name</th>
								<th>Manufacturer</th>
								<th>Sub Category</th>
								<th>Category</th>
								<th>Service Area</th>
								<th>Date</th>
								<th class="no-sort">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php if($object->num_rows > 0){ ?>
							<?php $i=1; while($rows = $object->fetch_object()){ ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $rows->merchant_name; ?></td>
									<td><?php echo $rows->product_name; ?></td>
									<td><?php echo $rows->company_name; ?></td>
									<td><?php echo $rows->scat_name; ?></td>
									<td><?php echo $rows->c_name; ?></td>
									<td><?php echo $rows->s_name; ?></td>
									<td><?php echo date('d-m-Y', strtotime($rows->date_time)); ?></td>
									<td class="text-center">
										
										<?php if($rows->status == 1){ ?>
										<a href="javascript:void(0);" class="cs_btn"
											id="<?php echo $rows->p_id; ?>" title="Click to disable">
											<i class="fa fa-check"></i>
										</a>
										<?php }else{ ?>
										<a href="javascript:void(0);" class="cs_btn"
											id="<?php echo $rows->p_id; ?>" title="Click to enable">
											<i class="fa fa-remove"></i>
										</a>
										<?php } ?>
										
										<a href="<?php echo site_root."ux-admin/index?q=RequestedProducts&view=".$functionsObj->numhash($rows->p_id);?>">
											<i class="fa fa-search"></i>
										</a>
										
										<a href="<?php echo site_root."ux-admin/index?q=RequestedProducts&edit=".$functionsObj->numhash($rows->p_id);?>">
											<i class="fa fa-pencil"></i>
										</a>
										
										<a href="javascript:void(0);" class="dl_btn"
											id="<?php echo $rows->p_id; ?>">
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
							<?php $i++; } ?>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>