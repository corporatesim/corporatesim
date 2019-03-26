<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
  <?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Edit SubEnterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Edit SubEnterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<!-- <h4 class="text-blue">Edit SubEnterprise</h4><br> -->
						</div>
					</div>
					<form method="post" action=""enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Enterprise Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="Enterprise_Name" value="<?php echo $editSubEnterprise->Enterprise_Name?>" type="text"readonly>
								<input class="form-control" name="Enterprise_ID" value="<?php echo $editSubEnterprise->Enterprise_ID?>" type="hidden"readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> SubEnterprise Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" value="<?php echo $editSubEnterprise->SubEnterprise_Name?>" 
								  name="subenterprise">
							</div>
						</div>
						<!-- <div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">CreatedOn</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" placeholder="" type="text" value="<?php //echo 
								$editSubEnterprise->SubEnterprise_CreatedOn?>" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">CreatedBy</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" value="<?php //echo 
								$editSubEnterprise->SubEnterprise_CreatedBy?>" type="text" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label for="example-datetime-local-input" class="col-sm-12 col-md-2 col-form-label">UpdatedOn</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" placeholder="Choose Date and time" type="text" value="<?php //echo 
								$editSubEnterprise->SubEnterprise_UpdatedOn?>" readonly>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-2 col-form-label">UpadtedBy</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" placeholder="" type="text" value="<?php //echo 
								$editSubEnterprise->SubEnterprise_UpdatedBy?>" readonly>
							</div>
						</div> -->
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Choose Logo</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Current SubEnterprise Logo</label>
							<div class="col-sm-12 col-md-6">
							<img src="<?php echo base_url('Common/Logo/'.$editSubEnterprise->SubEnterprise_Logo);?>" width="100px"height="100px" alternate="SubEnterprise_Logo">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
							<a href="<?php echo base_url('SubEnterprise/');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

