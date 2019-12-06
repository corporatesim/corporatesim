<style type="text/css">
	span.alert-danger {
		background-color: #ffffff;
		font-size: 18px;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Manage SiteUsers</a></li>
			<li class="active"><a
				href="<?php echo site_root."ux-admin/siteusers"; ?>">
			Games</a></li>
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

<div class="col-sm-10">
	<form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
		<input type="hidden" name="User_ParentId" value="<?php echo $userData->User_ParentId;?>">
		<input type="hidden" name="User_SubParentId" value="<?php echo $userData->User_SubParentId;?>">

		<div class="row" id="sandbox-container">
			<div class="col-md-4">
				<label for="Game Duration" data-toggle="tooltip" title="<?php echo $userData->User_email; ?>"><span class="alert-danger">*</span>User (<?php echo ucwords($userData->User_fname.' '.$userData->User_lname);?>) Account Duration</label>
			</div>
			<!-- user account date reange -->
			<div class="col-md-6">
				<div class="input-daterange input-group" id="datepicker">
					<input type="text" class="input-sm form-control" id="User_GameStartDate" name="User_GameStartDate" value="<?php echo $userData->User_GameStartDate; ?>" placeholder="Select Start Date" required readonly/>
					<span class="input-group-addon">to</span>
					<input type="text" class="input-sm form-control" id="User_GameEndDate" name="User_GameEndDate" value="<?php echo $userData->User_GameEndDate; ?>" placeholder="Select End Date" required readonly/>
				</div>
			</div>
			<!-- select all checkBox -->
			<div class="col-md-2">
				<label for="name" class="checkbox containerCheckbox" id="select_all_checkbox">
					<input type="checkbox" name="select_all" id="select_all">
					Selecte All
					<span class="checkmark"></span>
				</label>
			</div>
		</div>
		<marquee behavior="alternate" direction="" onmouseover="this.stop();" onmouseout="this.start();"><span class='alert-danger'>Game Start-Date and End-Date Can Not Exceed User Account Duration (if you choose, then automatically adjusted)</span></marquee>
		<hr/>
		<!-- header row -->
		<div class="row">
			<div class="col-md-4">
				<label for="name"><span class="alert-danger">*</span>Select Games</label>
				<input type="hidden" name="id" value="<?php if(isset($_GET['edit'])){ echo $userdetails->User_id; } ?>">
			</div>

			<div class="col-md-3">
				<label for="name"><span class="alert-danger">*</span>Choose Start Date</label>
			</div>
			<div class="col-md-3">
				<label for="name"><span class="alert-danger">*</span>Choose End Date</label>
			</div>
			<div class="col-md-2">
				<label for="name"><span class="alert-danger">*</span>Replay</label>
			</div>
		</div>
		<!-- game data div -->
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php	while($row = mysqli_fetch_array($userGameResult)) { ?>
						<div class="row">
							<!-- game name -->
							<div class='col-sm-4'>
								<label class='checkbox containerCheckbox' <?php echo ($row['UG_ID'])?'style=background:#ccc;':''; ?> data-toggle="tooltip" title='"<?php echo $row['Game_Comments']; ?>"'>
									<input type='checkbox' class='usergame' name='usergame[]' value='<?php echo $row['Game_ID'];?>' <?php echo ($row['UG_ID'])?'checked':''; ?> >
									<?php echo ($row['Game_Elearning'])?$row['Game_Name'].' <b class="text-danger">(eLearning)</b>':$row['Game_Name'];?>
									<!-- check if this game is bot enabled or not -->
									<?php echo ($row['Game_Type'] == 1)?'<b class="text-danger">(Bot)</b>':''; ?>
									<span class='checkmark'></spam>
									</label>
								</div>
								<!-- game date reange -->
								<div class="col-sm-6" id="sandbox-container">
									<?php
									if(!empty($row['UG_GameStartDate']))
									{
										$startDate = $row['UG_GameStartDate'];
									}
									else
									{
										$startDate = $userData->User_GameStartDate;
									}

									if(!empty($row['UG_GameEndDate']))
									{
										$endDate = $row['UG_GameEndDate'];
									}
									else
									{
										$endDate = $userData->User_GameEndDate;
									}
									?>
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="input-sm form-control" id="<?php echo $row['Game_ID'];?>_startdate" name="<?php echo $row['Game_ID'];?>_startdate" value="<?php echo date('Y-m-d',strtotime($startDate)); ?>" placeholder="Select Start Date" required readonly data-startdate="<?php echo date('Y-m-d',strtotime($userData->User_GameStartDate)); ?>" data-enddate="<?php echo date('Y-m-d',strtotime($userData->User_GameEndDate)); ?>" />

										<span class="input-group-addon">To</span>

										<input type="text" class="input-sm form-control" id="<?php echo $row['Game_ID'];?>_enddate" name="<?php echo $row['Game_ID'];?>_enddate" value="<?php echo date('Y-m-d',strtotime($endDate)); ?>" placeholder="Select End Date" required readonly data-startdate="<?php echo date('Y-m-d',strtotime($userData->User_GameStartDate)); ?>" data-enddate="<?php echo date('Y-m-d',strtotime($userData->User_GameEndDate)); ?>" />
									</div>

								</div>
								<!-- game replay count -->
								<div class="col-md-2">
									<input type="number" class="input-sm form-control" id="<?php echo $row['Game_ID'];?>_replayCount" name="<?php echo $row['Game_ID'];?>_replayCount" value="<?php echo ($row['UG_ReplayCount']>0)?$row['UG_ReplayCount']:0; ?>" placeholder="Replay" required min="-1"/>
								</div>

							</div>
						<?php }	?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group text-center">
						<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
							<button type="button" id="siteuser_btn_update" class="btn btn-primary"
							> Update </button>
							<button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden"
							value="Update"> Update </button>
							<button type="button" class="btn btn-primary"
							onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
						<?php }else{?>
							<button type="button" id="siteuser_btn" class="btn btn-primary"
							value="Submit"> Submit </button>
							<button type="submit" name="submit" id="siteuser_sbmit"
							class="btn btn-primary hidden" value="Submit"> Submit </button>
							<button type="button" class="btn btn-primary"
							onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
						<?php }?>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>

