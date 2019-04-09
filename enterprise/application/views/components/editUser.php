<!-- <?php // echo "<pre>"; print_r($editUser->User_SubParentId); exit;?> -->
	<div class="main-container">
		<div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
			<?php $this->load->view('components/trErMsg');?>
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h1>Edit Users
								</h1>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit User</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						<div class="clearfix">
						</div>
						<form method="post" action="">
							<div class="form-group row d-none">
								<label class="col-sm-12 col-md-2 col-form-label">
									Enterprise
								</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" type="text" name="Enterprise_Name" placeholder="EnterpriseName" value="<?php echo $editUser->Enterprise_Name ?>" readonly="">
									<input class="form-control" type="hidden" name="EnterpriseID" placeholder="EnterpriseID" value="<?php echo $editUser->Enterprise_ID ?>" readonly="">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">First Name</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" type="text" name="User_fname" placeholder="FirstName" value="<?php echo $editUser->User_fname ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Last Name</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" name="User_lname" placeholder=
									"LastName" value="<?php echo $editUser->User_lname ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">User Name</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" name="User_username" value="<?php echo $editUser->User_username ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Email ID</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" name="User_email" value="<?php echo $editUser->User_email ?>">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Contact Number</label>
								<div class="col-sm-12 col-md-6">
									<input class="form-control" name="User_mobile" value="<?php echo $editUser->User_mobile ?>">
								</div>
							</div>
							<?php if($editUser->User_SubParentId != -2){?>
								<div class='form-group row d-none'>
									<label for='SubEnterprise' class='col-sm-12 col-md-2 col-form-label'>SubEnterprise</label>
									<div class='col-sm-12 col-md-6'>
										<select name='subenterprise' id='subenterprise' class='form-control' required >
											<option value=''>--Select SubEnterprise--</option>
											<?php foreach ($Subenterprise as $row) { ?>
												<option value="<?php echo $row->SubEnterprise_ID;?>"<?php echo ($row->SubEnterprise_ID==$editUser->User_SubParentId)?"selected":''; ?>><?php echo $row->SubEnterprise_Name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php }?>
						</div>
						<div class="text-center">
							<button type="submit" name="submit" class="btn btn-primary">Update</button>
							<a href="<?php echo base_url('Users/'). $this->uri->segment(4);?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

