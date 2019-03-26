<div class="main-container">
	<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
		<?php $this->load->view('components/trErMsg');?>
		<div class="min-height-200px">
			<div class="page-header">
				<div class="row">
					<div class="col-md-6 col-sm-12">
						<div class="title">
							<h1>Add Enterprise</h1>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add Enterprise</li>
							</ol>
						</nav>
					</div>	
				</div>
				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue">Add Enterprise</h4><br>
						</div>
					</div>
					<form method="post" action=""enctype="multipart/form-data">
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span style="color: red">*</span> Enterprise</label>
							<div class="col-sm-12 col-md-6">
								<input class="form-control" name="enterprise" value="" type="text" required="">
							</div>
						</div> 
						<div class="form-group row">
							<label class="col-sm-12 col-md-4 col-form-label"><span style="color: red">*</span> Choose Logo</label>
							<div class="col-sm-12 col-md-6">
								<input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
							</div>
						</div>
						<div class="row" id="sandbox-container">
							<div class="col-md-4">
								<label for="Game Duration"><span class="alert-danger">*</span> Select Account Duration</label>
							</div>
							<div class="input-daterange input-group col-md-6" id="datepicker">
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate" value="" placeholder="Select Start Date" required readonly/>
								<span class="input-group-addon">to</span>
								<input type="text" class="form-control datetimepicker" data-date-format="yyyy-mm-dd" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate" value="" placeholder="Select End Date" required readonly/>
							</div>
						</div><br>
						<div class="text-center">
							<button type="submit" name="submit"class="btn btn-primary">SUBMIT</button>
							<a href="<?php echo base_url('Enterprise');?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

