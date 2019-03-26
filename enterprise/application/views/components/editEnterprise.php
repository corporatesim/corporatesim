<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Edit Enterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Edit Enterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
						</div>
					</div>
					<form method="post" action=""enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span>Enterprise Name</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" type="text" value="<?php echo $editEnterprise->Enterprise_Name?>" name="enterprise">
							</div>
						</div>
						<div class="form-group row"id="sandbox-container">
							<div class="col-md-4">
								<label for="Game Duration"><span class="alert-danger">*</span> Select Account Duration</label>
							</div>
							<div class="input-daterange input-group col-md-6" id="datepicker">
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate" value="<?php echo $editEnterprise->Enterprise_GameStartDate;?>" placeholder="Select Start Date" required readonly/>
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate" value="<?php echo $editEnterprise->Enterprise_GameEndDate;?>" placeholder="Select End Date" required readonly/>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label">
								<span class="alert-danger">*</span> Choose Logo</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span class="alert-danger">*</span> Current Enterprise Logo</label>
							<div class="col-sm-12 col-md-6">
								<img src="<?php echo base_url('Common/Logo/'.$editEnterprise->Enterprise_Logo);?>" width="100px"height="100px" alternate="Enterprise_Logo">
							</div>
						</div>
						<div class="text-center">
							<button type="submit" name="submit"class="btn btn-primary">UPDATE</button>
							<a href="<?php echo base_url('Enterprise/');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

