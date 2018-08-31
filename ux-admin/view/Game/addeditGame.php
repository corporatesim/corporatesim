<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>

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
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active"><a
				href="<?php echo site_root."ux-admin/ManageGame"; ?>"> Manage 
					Game</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>
<?php if(isset($_GET['edit'])){ ?>
<div class="row">
	<div class="col-sm-12">
		<div class=" right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
			<a href="<?php echo site_root."ux-admin/ManageGame"; ?>"
				title="Game List"> Back</a> | 
			<a href="<?php echo site_root."ux-admin/ManageGameContent/Edit/".base64_encode($gamedetails->Game_ID); ?>"
				title="General"><span class="fa fa-book"></span> Content</a> | 
			<a href="<?php echo site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($gamedetails->Game_ID); ?>"
				title="Document"><span class="fa fa-image"></span> Document</a> | 				
			<a href="<?php echo site_root."ux-admin/ManageGameImage/Edit/".base64_encode($gamedetails->Game_ID); ?>"
				title="Image"><span class="fa fa-image"></span> Image</a> | 
			<a href="<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($gamedetails->Game_ID); ?>"
				title="Video"><span class="fa fa-video-camera"></span> Video</a>
		</div>
	</div>
</div>		
<?php } ?>		
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
	<form method="POST" action="" id="game_frm" name="game_frm">
		
		<div class="row name" id="name">
			<div class="col-sm-6">
				<input type="hidden" name="id"
					value="<?php if(isset($_GET['edit'])){ echo $gamedetails->Game_ID; } ?>">
				<div class="form-group">
					<label for="name"><span class="alert-danger">*</span>Name</label>
					<input type="text" name="name"
						value="<?php if(!empty($gamedetails->Game_Name)) echo $gamedetails->Game_Name; ?>"
						class="form-control" placeholder="Game Name" required>
				</div>
			</div>
		</div>
		<div class="row name" id="comments">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="name"><span class="alert-danger">*</span>Comments</label>
					<textarea id="comments" name="comments" class="form-control" placeholder="Comments"><?php if(!empty($gamedetails->Game_Comments)) echo $gamedetails->Game_Comments; ?></textarea>
				</div>
			</div>					
		</div>		
		<div class="row name">
			<div >
				<div class="form-group">
					<label for="name"><span class="alert-danger">*</span>Message</label>
					<textarea id="message" name="message" class="form-control" placeholder="Message"><?php if(!empty($gamedetails->Game_Message)) echo $gamedetails->Game_Message; ?></textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-center">
				<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
					<button type="button" id="game_btn_update" class="btn btn-primary"
						> Update </button>
					<button type="submit" name="submit" id="game_update" class="btn btn-primary hidden"
						value="Update"> Update </button>
					<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }else{?>
					<button type="button" id="game_btn" class="btn btn-primary"
						value="Submit"> Add </button>
					<button type="submit" name="submit" id="game_sbmit"
						class="btn btn-primary hidden" value="Submit"> Add </button>
					<button type="button" class="btn btn-primary"
						onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
				<?php }?>
				</div>
			</div>
		</div>
	</form>
	
	<?php 
		if(isset($_GET['edit']) && !empty($_GET['edit'])){	
			//include_once doc_root.'ux-admin/view/Game/tabheader.php';
		}
	?>	
		
</div>
<div class="clearfix"></div>
<script type="text/javascript">
<!--
	CKEDITOR.replace('message');
//-->
</script>
<script>

$('#game_btn').click( function(){
//	if($("#siteuser_frm").valid()){		
		$( "#game_sbmit" ).trigger( "click" );
//	}
});

$('#game_btn_update').click( function(){
//	if($("#siteuser_frm").valid()){
		$( "#game_update" ).trigger( "click" );
//	}
});

// -->
</script>
