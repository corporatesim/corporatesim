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
		<div class="row">
			<div class="col-md-6">
				<label for="name"><span class="alert-danger">*</span>Select Games</label>
				<input type="hidden" name="id" value="<?php if(isset($_GET['edit'])){ echo $userdetails->User_id; } ?>">
			</div>
			<div class="col-md-6">
				<label for="name" class="checkbox containerCheckbox" id="select_all_checkbox">
					<input type="checkbox" name="select_all" id="select_all">
					Selecte All
					<span class="checkmark"></span>
				</label>
			</div>
		</div>
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
		//$sql = 'select name from STUDENT';
		//$result = mysqli_query($connection_object,$sql);

					$id     = base64_decode($_GET['edit']);		
					$result = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
					//print_r($result);exit;
					while($row = mysqli_fetch_array($result)) {
					//print_r($row);exit;
						$object = $functionsObj->SelectData(array(), 'GAME_USERGAMES', array('UG_UserID='.$id, 'UG_GameID='.$row['Game_ID']), '', '', '', '', 0);

						echo "<div class='col-sm-4'><label class='checkbox containerCheckbox'";
						if($object->num_rows > 0)
						{
							if($row['Game_Elearning'] == 1)
							{
								echo "style='background:#ccc;'><input type='checkbox' checked='checked' class='usergame' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name']." <b>(Elearning)</b>";
							}else
							{
								echo "style='background:#ccc;'><input type='checkbox' checked='checked' class='usergame' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
							}
						}
						else{

							if($row['Game_Elearning'] == 1)
							{
								echo "><input type='checkbox' class='usergame' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name']." <b>(eLearning)</b>";
							}
							else{
								echo "><input type='checkbox' class='usergame' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
							}
						}
						echo "<span class='checkmark'></label></div>";
					}
					?>
				</div>
			</div>
		</div>
		<div class="row" id="sandbox-container">
			<div class="col-md-4">
				<label for="Game Duration"><span class="alert-danger">*</span>Select Account Duration</label>
			</div>
				<!-- <div class="col-md-4">
					<input type="text" name="User_GameStartDate" id="User_GameStartDate" class="form-control" placeholder="Select Start Date" required>
				</div>
				<div class="col-md-4">
					<input type="text" name="User_GameEndDate" id="User_GameEndDate" class="form-control" placeholder="Select Start Date" required>
				</div>
				<br> -->
				<?php
				$res = $functionsObj->ExecuteQuery("SELECT User_GameStartDate,User_GameEndDate FROM GAME_SITE_USERS WHERE User_id=$id");
				if ($res->num_rows > 0)
				{
					$date = $functionsObj->FetchObject($res);
					// echo "<pre>"; print_r($date); exit;
					$User_GameStartDate = $date->User_GameStartDate;
					$User_GameEndDate   = $date->User_GameEndDate;
				}
				else
				{
					$User_GameStartDate = '';
					$User_GameEndDate   = '';
				}
				?>
				<div class="input-daterange input-group" id="datepicker">
					<input type="text" class="input-sm form-control" id="User_GameStartDate" name="User_GameStartDate" value="<?php echo $User_GameStartDate; ?>" placeholder="Select Start Date" required readonly/>
					<span class="input-group-addon">to</span>
					<input type="text" class="input-sm form-control" id="User_GameEndDate" name="User_GameEndDate" value="<?php echo $User_GameEndDate; ?>" placeholder="Select End Date" required readonly/>
				</div>
			</div>
			<br>
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

	