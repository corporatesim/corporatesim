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
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
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
		<label for="name"><span class="alert-danger">*</span>Select Games</label>
		<input type="hidden" name="id"
			value="<?php if(isset($_GET['edit'])){ echo $userdetails->User_id; } ?>">
		<div class="row">
		<div class="panel panel-default">
		<div class="panel-body">
		<?php
		//$sql = 'select name from STUDENT';
		//$result = mysqli_query($connection_object,$sql);

		$id = base64_decode($_GET['edit']);		
		$result = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);

		while($row = mysqli_fetch_array($result)) {
			
			$object = $functionsObj->SelectData(array(), 'GAME_USERGAMES', array('UG_UserID='.$id, 'UG_GameID='.$row['Game_ID']), '', '', '', '', 0);

			echo "<div class='col-sm-4'><div class='checkbox'";
			if($object->num_rows > 0)
			{
				echo "style='background:#ccc;'><input type='checkbox' checked='checked' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
			}
			else{
				echo "><input type='checkbox' name='usergame[]' value='{$row['Game_ID']}'>" . $row['Game_Name'];
			}
			echo "</div></div>";
		}
	 ?>
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

<script>
<!--

//$("#siteuser_frm").validate({
//	rules: {
//		fname: "required",
//		lname: "required",
//		mobile: {
//			required: true,
//			minlength: 10,
//			maxlength: 10
//		},
//		email:  {
//			required: true,
//			email: true
//		},
//		username: "required"
//	},
//	// Specify validation error messages
//	messages: {
//		mobile: {
//			required: "Please provide mobile number",
//			minlength: "Please Enter a valid 10 digit mobile number",
//			maxlength: "Please Enter a valid 10 digit mobile number"
//		}
//    },
//    errorPlacement: function(error, element) {
//		if (element.attr("name") == "mobile" ){  //Id of input field
//             error.appendTo('.contact_error');
//		}
//	}
//});

$('#siteuser_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
		$( "#siteuser_sbmit" ).trigger( "click" );
//	}
});

$('#siteuser_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
		$( "#siteuser_update" ).trigger( "click" );
//	}
});

// -->
</script>
