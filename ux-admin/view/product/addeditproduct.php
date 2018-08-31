<script src="<?php echo site_root; ?>js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?php echo site_root; ?>js/script.js"></script>

<style>
<!--
	#img{
		position: absolute;
		top:-5px;
		right: 0px;
		cursor: pointer;
	}
-->
</style>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active"><a href="<?php echo site_rootl; ?>ux-admin/ManageProducts">Products</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>


<?php if(isset($msg)){ ?>
	<div class="form-group <?php echo $type[1]; ?>">
		<div align="center" id="<?php echo $type[0]; ?>">
			<label class="control-label" for="<?php echo $type[0] ?>"><?php echo $msg ?></label>
		</div>
	</div>
<?php } ?>

<form name="add_product" id="add_product" method="post" action="" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-12 error">* All fields are mandatory</div>
			<div class="form-group col-sm-4">
				<input type="hidden" name="p_id" value="<?php echo $product_array['p_id']; ?>" >
				<label>Service Area</label>
				<select name="s_id" class="form-control" id="s_id">
					<option value="">-- SELECT --</option>
					<?php if($services->num_rows > 0){ ?>
					<?php while($row = $services->fetch_object()){ ?>
					<option value="<?php echo $row->s_id; ?>" <?php if($row->s_id == $product_array['s_id']){ echo 'selected'; } ?>>
						<?php echo $row->s_name; ?>
					</option>
					<?php } ?>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group col-sm-4">
				<label>Category</label>
				<select name="category" class="form-control" id="category">
					<option value="">-- SELECT --</option>
					<?php if(isset($_GET['edit'])){
						while($row = $category->fetch_object()){ ?>
							<option value="<?php echo $row->cat_id; ?>" <?php if($row->cat_id == $product_array['cat_id']){ echo 'selected'; } ?>>
								<?php echo $row->c_name; ?>
							</option>
						<?php 
						}
					} ?>
				</select>
			</div>
			<div class="clearfix"></div>
						
			<div class="form-group col-sm-4">
				<label>Sub Category</label>
				<select name="subcategory" class="form-control" id="subcategory">
					<option value="">-- SELECT --</option>
					<?php if(isset($_GET['edit'])){
						while($row = $subcategory->fetch_object()){ ?>
							<option value="<?php echo $row->scat_id; ?>" <?php if($row->scat_id == $product_array['scat_id']){ echo 'selected'; } ?>>
								<?php echo $row->scat_name; ?>
							</option>
						<?php 
						}
					} ?>
				</select>
			</div>
			
			<div class="clearfix"></div>
			
			<div class="form-group col-sm-8">
				<label>Company Name</label>
				<input type="text" name="company_name" value="<?php echo $product_array['company_name']; ?>" class="form-control">
			</div>
			
			<div class="clearfix"></div>
			
			<div class="form-group col-sm-8">
				<label>Product Name</label>
				<input type="text" name="product_name" value="<?php echo $product_array['product_name']; ?>" class="form-control">
			</div>
			
			<div class="form-group col-sm-8">
				<label>Product Specification</label>
				<textarea id="product_spec" name="product_spec" class="form-control"><?php echo $product_array['product_spec']; ?></textarea>
			</div>
			
			<div class="form-group col-sm-8 img_div">
				<label>[Note]: Allowed Image size 1MB and allowed extentions .jpeg, .jpg and .png</label>
				<div class="clearfix"></div>
				<label>Add Image (optional)</label>
				<div class="clearfix"></div>
				
				<?php 
				$rows = json_decode($product_array['imgs']);
				if(!empty($rows)){ 
					foreach ($rows as $key => $value){
					?>
				<div id="filediv" class="col-sm-12 row rm<?php echo $key; ?>">
					<div id="upload_img2" class="col-sm-6 form-group">
						<img  src="<?php echo site_root.'images/product_images/'.$value; ?>" class="img-responsive">
						<button type="button" class="btn btn-link btn_img" id="img" value="<?php echo $value; ?>">
							<img src="<?php echo site_root; ?>images/x.png" alt="delete">
						</button>
					</div>
				</div>
				<?php }
				}
				?>
				<div id="filediv" class="col-sm-12 row">
					<input name="file[]" type="file" id="file" multiple/>
				</div>
				
				<div class="col-sm-12 row" id="add_more_btn">
					<input type="button" id="add_more" class="upload btn btn-default" value="Add More Files"/>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group col-sm-8 text-center">
				<?php if(isset($_GET['edit'])){ ?>
				<button type="button" id="updt_btn" class="btn btn-primary">Update</button>
				<button type="button" onclick="window.location='<?php echo $url; ?>';" class="btn btn-primary">Back</button>
				<button type="submit" id="update_btn" name="updateProduct" value="Update" class="btn btn-primary hidden">Submit</button>
				<?php }else{ ?>
				<button type="button" id="frm_submit" class="btn btn-primary">Submit</button>
				<button type="submit" id="addproduct_btn" name="addProduct" value="Submit" class="btn btn-primary hidden">Submit</button>
				<?php } ?>
			</div>
		</div>
	</div>

</form>

<!-- Modal -->
<div id="warning" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Warning!</h4>
			</div>
			<div class="modal-body">
				<p>Can not add more than 3 images.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
<!--
	<?php if(isset($_GET['edit'])){ ?>
	var p_id = <?php echo $functionsObj->numhash($_GET['edit']); ?>
	<?php }?>

	CKEDITOR.replace('product_spec');
//-->
</script>
<script src="<?php echo site_root; ?>ux-admin/common/js/common.js"></script>