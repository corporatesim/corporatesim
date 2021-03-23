<!-- <?php // echo "<pre>"; print_r($editUser->User_SubParentId); exit;?> -->
	<div class="main-container">
		<!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
			<?php $this->load->view('components/trErMsg'); ?>
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
									<li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit User</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
						<div class="clearfix"></div>
						<form method="post" action="">

							<div class="form-group row d-none">
								<label class="col-sm-12 col-md-3 col-form-label">Enterprise</label>
								<div class="col-sm-12 col-md-5">
									<input class="form-control" type="text" name="Enterprise_Name" placeholder="EnterpriseName" value="<?php echo $editUser->Enterprise_Name ?>" readonly="">
									<input class="form-control" type="hidden" name="EnterpriseID" placeholder="EnterpriseID" value="<?php echo $editUser->Enterprise_ID ?>" readonly="">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-3 col-form-label">First Name</label>
								<div class="col-sm-12 col-md-5">
									<input type="text" class="form-control" type="text" name="User_fname" required="" placeholder="FirstName" value="<?php echo $editUser->User_fname; ?>">
									<?php echo form_error('User_fname'); ?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-3 col-form-label">Last Name</label>
								<div class="col-sm-12 col-md-5">
									<input type="text" class="form-control" name="User_lname" placeholder=
									"LastName"  required="" value="<?php echo $editUser->User_lname; ?>">
									<?php echo form_error('User_lname'); ?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-3 col-form-label">User Name</label>
								<div class="col-sm-12 col-md-5">
									<input type="text" class="form-control"  required="" name="User_username" value="<?php echo $editUser->User_username; ?>">
									<?php echo form_error('User_username'); ?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-3 col-form-label">Email ID</label>
								<div class="col-sm-12 col-md-5">
									<input type="email" class="form-control"  required="" name="User_email" value="<?php echo $editUser->User_email; ?>">
									<?php echo form_error('User_email'); ?>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-12 col-md-3 col-form-label">Contact Number</label>
								<div class="col-sm-12 col-md-5">
									<input type="number" class="form-control"  required="" name="User_mobile" value="<?php echo $editUser->User_mobile; ?>">
									<?php echo form_error('User_mobile'); ?>
								</div>
							</div>

              <?php 
                // Setting date Value
                // 86400 // 1 day value (24 hours)
                // 2592000 // 1 Month value (30 days)
                // 31536000 // 1 year value (365 days)

                // echo $editUser->User_GameStartDate;
                // echo $editUser->User_GameEndDate;

                $currentTimeStamp   = strtotime(date('Y-m-d H:i:s'));
                $gameStartDateStamp = strtotime(date($editUser->User_GameStartDate));
                $gameEndDateStamp   = strtotime(date($editUser->User_GameEndDate));
                // echo $gameStartDateStamp;
                $gameTwentyYearAgoTime = $currentTimeStamp - 31536000*20; // 20 year ago time
                $gameTwentyYearTime    = $currentTimeStamp + 31536000*20; // 20 year time
              ?>

              <div class="form-group row">
                <label for="userDurationDate" class="col-12 col-md-3 col-form-label">Account Duration</label>
                <div class="col-12 col-md-5">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker-here" id="userDurationDateStart" name="userDurationDateStart" value="" data-value="<?php echo $gameStartDateStamp; ?>" placeholder="Start Date" readonly data-startdate="<?php echo $gameTwentyYearAgoTime; ?>" data-enddate="<?php echo $gameTwentyYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy" required>

                    &nbsp;&nbsp;<span class="input-group-addon">To</span>&nbsp;&nbsp;

                    <input type="text" class="form-control datepicker-here" id="userDurationDateEnd" name="userDurationDateEnd" value="" data-value="<?php echo $gameEndDateStamp; ?>" placeholder="End Date" readonly data-startdate="<?php echo $gameTwentyYearAgoTime; ?>" data-enddate="<?php echo $gameTwentyYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy" required>
                  </div>
                </div>
              </div>

              <?php 
                // echo $editUser->User_gameStatus;
                // 0-Enable, 1-Disable
              ?>

              <div class="form-group row">
                <label class="col-sm-12 col-md-3 col-form-label" for="userStatus">User Status</label>
                <div class="col-sm-12 col-md-9">
                  <select class="custom-select2 form-control" name="userStatus" id="userStatus" required>
                    <option value="0" <?php if ($editUser->User_gameStatus == 0){ echo 'selected'; } ?>>Active</option>
                    <option value="1" <?php if ($editUser->User_gameStatus == 1){ echo 'selected'; } ?>>Deactive</option>
                  </select>
                  <span id="userStatusError" class="removemsg text-danger"></span>
                </div>
              </div>

							<?php if ($editUser->User_SubParentId != -2) { ?>
								<div class='form-group row d-none'>
									<label for='SubEnterprise' class='col-sm-12 col-md-2 col-form-label'>SubEnterprise</label>
									<div class='col-sm-12 col-md-6'>
										<select name='subenterprise' id='subenterprise' class='form-control' required >
											<option value=''>--Select SubEnterprise--</option>
											<?php foreach ($Subenterprise as $row) { ?>
												<option value="<?php echo $row->SubEnterprise_ID; ?>"<?php echo ($row->SubEnterprise_ID == $editUser->User_SubParentId) ? "selected" : ''; ?>><?php echo $row->SubEnterprise_Name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							<?php } ?>

						<div class="text-center">
							<button type="submit" name="submit" class="btn btn-primary">Update</button>
							<a href="<?php echo base_url('Users/'). $this->uri->segment(4); ?>"><button type="button" name="submit"class="btn btn-primary">CANCEL</button></a>
						</div>

					</form>
				</div>
			</div>
    

