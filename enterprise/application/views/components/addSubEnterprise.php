<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Add SubEnterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add SubEnterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Add SubEnterprise</h4>
						</div>
					</div><br>
							<form method="post" action="" enctype="multipart/form-data" id="filterForm">
								<?php if($this->session->userdata('loginData')['User_Role']!=1) {?>
									<div class="form-group row" id="selectSubenterprise">
										<label for="Select SubEnterprise" class="col-sm-12 col-md-2 col-form-label"><span class="alert-danger">*</span> Choose Filter</label>
										<div class="col-sm-12 col-md-6">
											<select name='Enterprise_ID' id='enterprise' class='form-control'>
												<option value=''>--Select Enterprise--</option>
												<?php foreach ($EnterpriseDetails as $row) { ?> <option value="<?php echo $row->Enterprise_ID;?>"><?php echo $row->Enterprise_Name; ?></option>
											<?php } ?> 
										</select>
									</div>
								</div>
							<?php }?>
					<div class="form-group row">
						<label class="col-sm-12 col-md-2 col-form-label"><span class="alert-danger">*</span> SubEnterprise</label>
						<div class="col-sm-12 col-md-6">
							<input class="form-control" name="subenterprise" value="" type="text" required="">
						</div>
					</div> 
					<div class="form-group row">
						<label class="col-sm-12 col-md-2 col-form-label"><span class="alert-danger">*</span> Choose Logo</label>
						<div class="col-sm-12 col-md-6">
							<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
						</div>
					</div>
					<div class="text-center">
						<button type="submit" name="submit"class="btn btn-primary">SUBMIT</button>
						<a href="<?php echo base_url('SubEnterprise');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
        //select enterprize
        $('#enterprise').on('change',function(){
        	$('#filterForm').submit();
        });
      });
    </script>
