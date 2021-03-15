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
			<li class="active"><a href="<?php echo site_root.'ux-admin/manageCompetence';?>">Manage Compentency</a></li>
			<!-- <li class="active"><a	href="<?php echo site_root."ux-admin/siteusers"; ?>">Games</a></li> -->
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

		<div class="form-group">
			<label for="name" class="containerCheckbox"><span class="alert-danger">*</span>Competence Name</label>
			<input type="text" name="Compt_Name" class="form-control" value="<?php if(isset($_GET['edit'])){ echo $gameObj->Compt_Name; } ?>" placeholder="Enter Competence Name" required>
		</div>

		<div class="row">
			<div class="col-md-6">
				<label for="name" class="containerCheckbox"><span class="alert-danger">*</span>Select Games</label>
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

					$result   = $functionsObj->SelectData(array(),'GAME_GAME',array('Game_Delete=0','Game_Elearning=0'), '', '', '', '', 0);
					//print_r($result);exit;
					while($row = mysqli_fetch_array($result)) {
					//print_r($row);exit;
						echo "<div class='col-sm-4'><label class='checkbox containerCheckbox'";

						if(isset($_GET['edit']))
						{
							// $Compt_Id = base64_decode($_GET['edit']);		
							// $object   = $functionsObj->SelectData(array(),'GAME_USERGAMES', array('UG_UserID IN ()', 'UG_GameID='.$row['Game_ID']), '', '', '', '', 0);
							if(in_array($row['Game_ID'],$compGameDetails))
							{
								echo "style='background:#ccc;'><input type='checkbox' checked='checked' class='usergame' name='Compt_Game[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
							}
							else
							{
								echo "><input type='checkbox' class='usergame' name='Compt_Game[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
							}
						}
						// showing form for add don't check the checkboxes
						else
						{
							echo "><input type='checkbox' class='usergame' name='Compt_Game[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
						}
						echo "<span class='checkmark'></span></label></div>";
					}
					?>
				</div>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="form-group text-center">
					<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
						<button type="button" id="siteuser_btn_update" class="btn btn-primary"
						> Update </button>
						<button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden"
						value="Update"> Update </button>
						<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
					<?php }
					else{ 
						?>
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
