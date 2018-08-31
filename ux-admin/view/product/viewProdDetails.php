<style>
<!--
.img-cntr {
    display: block;
    margin: auto;
}
-->
</style>
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
			<li class="active"><a href="<?php echo site_root; ?>ux-admin/index?q=RequestedProducts">Requested Products</a></li>
			<li class="active">View Products Details</li>
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
		<div class="col-sm-6">
			<?php 
				$imgs = json_decode($product_details->imgs);
			?>
			<div class="col-sm-12" style="overflow: hidden;" id="showimg">
				<?php if( !empty( $imgs ) ){ ?>
					<img src="<?php echo site_root; ?>images/product_images/<?php echo $imgs[0]; ?>" class="img-cntr" height="300" />
				<?php } else { ?>
					<img src="<?php echo site_root; ?>images/no_image.jpg" height="300" />
				<?php } ?>
			</div>
			<div class="col-sm-12" id="dataTable_wrapper">
				<table class="table table-bordered" id="dataTables-example">
					<tbody>
						<tr>
							<?php if( !empty( $imgs ) ){ ?>
							<?php foreach($imgs as $key => $value){ ?>
							<td>
								<a href="javascript:void(0);" class="image_select">
									<img src="<?php echo site_root; ?>images/product_images/<?php echo $imgs[0]; ?>" class="img-cntr" height="75" />
								</a>
							</td>
							<?php } ?>
							<?php } ?>
						</tr>
					</tbody>
				</table>
			</div>
			
		</div>
		<div class="col-sm-6">
			<h3>
				<?php echo $product_details->product_name; ?>
				<span class="pull-right">
					<a href="<?php echo site_root."ux-admin/index?q=RequestedProducts&edit=".$functionsObj->numhash($product_details->p_id);?>" title="Edit" style="font-size: 16px; font-weight: normal;">Edit</a>
				</span>
			</h3>
			<p><?php echo $product_details->s_name; ?> &gt;&gt; <?php echo $product_details->c_name; ?> &gt;&gt; <?php echo $product_details->scat_name; ?></p>
			<p><strong>Date Added</strong>: <?php echo date('d/m/Y', strtotime($product_details->date_time)); ?> </p>
			<p><strong>Manufacturer</strong>: <?php echo $product_details->company_name; ?></p>
			<div class="product_specs">
				<strong>Product Specification:</strong>
				<?php echo $product_details->product_spec; ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
<!--
	$('.image_select').click( function () {
		$('#showimg img').attr('src', $(this).find('img').attr('src'));
	});
//-->
</script>
