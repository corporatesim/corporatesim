<!-- <?php // echo "<pre>"; print_r($chartData); ?> -->
	<style type="text/css">
		span.alert-danger {
			background-color: #ffffff;
			font-size: 18px;
		}
		.removeThis{
			padding: 2% 0%;
		}
		.removeBtn{
			padding: 2px 10px;
		}
	</style>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo $header; ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<ul class="breadcrumb">
				<li class="completed"><a
					href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
					<li class="active"><a href="javascript:void(0);">Manage Chart</a></li>
					<li class="active"><?php echo $header; ?></li>
				</ul>
			</div>
		</div>
		<!-- DISPLAY ERROR MESSAGE -->
		<?php if(isset($msg)){ ?>
			<div class="form-group <?php echo $type[1]; ?>">
				<div align="center" id="<?php echo $type[0]; ?>">
					<label class="control-label" for="<?php echo $type[0]; ?>">
						<?php echo $msg; ?>
					</label>
				</div>
			</div>
		<?php } ?>
		<!-- DISPLAY ERROR MESSAGE END -->
		<div class="col-sm-12">
			<!-- if edit takes place -->
			<?php if(isset($List_ID) && $List_ID != '') { ?>
				<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
					<div class="row">
						<div class="col-md-2">
							<label><span class="alert-danger">*</span>Chart Title</label> 
						</div>
						<div class="col-md-4">
							<select class="form-control" name="List_TitleId" id="List_TitleIdEdit" required>
								<option value="">-- Select Chart Title--</option>
								<?php while ( $row = $titleObj->fetch_object()) { ?>
									<option value="<?php echo $row->Title_ID;?>" <?php echo ($chartData->List_TitleId == $row->Title_ID)?'selected':'';?>><?php echo $row->Title_Name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="clearfix"></div><br>
					<div class="row">
						<div class="col-md-2">
							<label><span class="alert-danger">*</span>Chart Name</label> 
						</div>
						<div class="col-md-4">
							<input type="text" name="List_Name" id="List_Name" value="<?php if(!empty($chartData->List_Name)) echo $chartData->List_Name; ?>"
							class="form-control"	required>
						</div>
					</div>
					<div class="clearfix"></div><br>
					<div class="row">
						<div class="col-md-2">
							<label><span class="alert-danger">*</span>Chart Value</label> 
						</div>
						<div class="col-md-4">
							<input type="text" name="List_Value" id="List_Value" value="<?php if(!empty($chartData->List_Value)) echo $chartData->List_Value; ?>"
							class="form-control"	required>
						</div>
					</div>
					<div class="clearfix"></div><br>
					<div class="row">
						<div class="col-md-2">
							<label class="hidden"><span class="alert-danger">*</span>Action</label> 
						</div>
						<div class="col-md-4">
								<button class="btn btn-primary" type="submit" name="submit" value="Update">Update</button>
							<a href="<?php echo $url;?>" class="btn btn-danger">cancel</a>
						</div>
					</div>
				</form>
			<?php } else { ?>
				<!-- while add takes places -->
				<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
					<div class="row col-md-12">
						<div class="col-md-4"><label><span class="alert-danger">*</span>Chart Title</label></div>
						<div class="col-md-4"><label><span class="alert-danger">*</span>Chart Name</label></div>
						<div class="col-md-4"><label><span class="alert-danger">*</span>Chart Value</label></div>
					</div>
					<div class="row" id="defaultRow">
						<div class="col-md-4">
							<select class="form-control" name="List_TitleId[]" id="List_TitleId" required>
								<option value="">-- Select Chart Title--</option>
							</select>
						</div>
						<div class="col-md-3">
							<input type="text" name="List_Name[]" id="List_Name" value=""	class="form-control" placeholder="Enter Chart Name" required>
						</div>
						<div class="col-md-3">
							<input type="text" name="List_Value[]" id="List_Value" value=""	class="form-control" placeholder="Enter Chart Value" required>
						</div>
						<div class="col-md-2"><button data-toggle="tooltip" id="addDive" title="Add" class="btn btn-primary" type="button"><b>+</b></button></div>
					</div>
					<div id="appendMoreDiv" class="row">
					</div><br>
					<div class="row">
						<div class="col-md-2 hidden">
							<label class="hidden"><span class="alert-danger">*</span>Action</label> 
						</div>
						<div class="col-md-4">
								<button class="btn btn-primary" type="submit" name="submit" value="Add">Add Chart List</button>
							<a href="<?php echo $url;?>" class="btn btn-danger">cancel</a>
						</div>
					</div>
				</form>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
		<script>
			$(document).ready(function(){
				var options = '<option value="">-- Select Chart Title--</option>';
				<?php while ( $row = $titleObj->fetch_object()) { ?>
					options += '<option value="<?php echo $row->Title_ID;?>"><?php echo $row->Title_Name;?></option>';
				<?php } ?>
				$('#List_TitleId').html(options);
				$('#addDive').on('click',function(){
					$('#appendMoreDiv').append('<div class="removeThis"><div class="col-md-4"><select class="form-control" name="List_TitleId[]" id="List_TitleId" required>'+options+'</select></div><div class="col-md-3"><input type="text" name="List_Name[]" placeholder="Enter Chart Name" value=""	class="form-control" required></div><div class="col-md-3"><input type="text" name="List_Value[]" placeholder="Enter Chart Value" value=""	class="form-control" required></div><div class="col-md-2"><button data-toggle="tooltip" title="Add" class="btn btn-danger removeBtn" type="button"><b>-</b></button></div></div>');
					removeDiv();
				});
			});
			function removeDiv()
			{
				$('.removeBtn').on('click',function(){
					$(this).parents('div.removeThis').remove();
				});
			}
		</script>