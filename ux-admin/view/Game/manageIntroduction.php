<?php 
  // Setting Introduction Tabs Text, Color and Show/Hide 
  // echo "<pre>"; print_r(json_decode($gamedetails->Game_Introduction_Json, true)); exit();

  $game_Json = json_decode($gamedetails->Game_Introduction_Json, true);

  // Introduction
  $gameIntroduction           = $game_Json['gameIntroduction'] ? $game_Json['gameIntroduction'] : 'Introduction';
  $gameIntroductionColorCode  = $game_Json['gameIntroductionColorCode'] ? $game_Json['gameIntroductionColorCode'] : 'lightcyan';
  $gameIntroductionVisibility = $game_Json['gameIntroductionVisibility'] ? $game_Json['gameIntroductionVisibility'] : '0';
  // Videos
  $gameVideos           = $game_Json['gameVideos'] ? $game_Json['gameVideos'] : 'Videos';
  $gameVideosColorCode  = $game_Json['gameVideosColorCode'] ? $game_Json['gameVideosColorCode'] : 'lavender';
  $gameVideosVisibility = $game_Json['gameVideosVisibility'] ? $game_Json['gameVideosVisibility'] : '0';
  // Images
  $gameImages           = $game_Json['gameImages'] ? $game_Json['gameImages'] : 'Images';
  $gameImagesColorCode  = $game_Json['gameImagesColorCode'] ? $game_Json['gameImagesColorCode'] : 'lavenderblush';
  $gameImagesVisibility = $game_Json['gameImagesVisibility'] ? $game_Json['gameImagesVisibility'] : '0';
  // Documents
  $gameDocuments           = $game_Json['gameDocuments'] ? $game_Json['gameDocuments'] : 'Documents';
  $gameDocumentsColorCode  = $game_Json['gameDocumentsColorCode'] ? $game_Json['gameDocumentsColorCode'] : 'lemonchiffon';
  $gameDocumentsVisibility = $game_Json['gameDocumentsVisibility'] ? $game_Json['gameDocumentsVisibility'] : '0';
?>
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
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active"><a	href="<?php echo site_root."ux-admin/ManageGame"; ?>">Manage Game</a></li>
			<li class="active"><?php echo $header; ?> <?php echo ($gamedetails->Game_Name)?"<b>(".$gamedetails->Game_Name.")</b>":'';?></li>
		</ul>
	</div>
</div>

<?php if (isset($_GET['edit'])) { ?>
	<div class="row">
		<div class="col-sm-12">
			<div class=" right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
				<a href="<?php echo site_root."ux-admin/ManageGame"; ?>" title="Game List"> Back</a> | 
				<a href="<?php echo site_root."ux-admin/ManageGameContent/Edit/".base64_encode($gamedetails->Game_ID); ?>" title="General"><span class="fa fa-book"></span> Content</a> | 
				<a href="<?php echo site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($gamedetails->Game_ID); ?>" title="Document"><span class="fa fa-image"></span> Document</a> | 				
				<a href="<?php echo site_root."ux-admin/ManageGameImage/Edit/".base64_encode($gamedetails->Game_ID); ?>" title="Image"><span class="fa fa-image"></span> Image</a> | 
				<a href="<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($gamedetails->Game_ID); ?>" title="Video"><span class="fa fa-video-camera"></span> Video</a>
			</div>
		</div>
	</div>
<br /><br />		
<?php } ?>

<!-- DISPLAY ERROR MESSAGE -->
<?php if (isset($msg)) { ?>
	<div class="form-group <?php echo $type[1]; ?>">
		<div align="center" id="<?php echo $type[0]; ?>">
			<label class="control-label" for="<?php echo $type[0]; ?>">
				<?php echo $msg; ?>
			</label>
		</div>
	</div>
<?php } ?>
<!-- DISPLAY ERROR MESSAGE END -->

<div class="col-sm-12">
	<form method="POST" action="" id="game_frm" name="game_frm" enctype="multipart/form-data">
							
    <!-- ===================== -->
    <div class="row name">
      <div class="col-sm-12">
        <h3><strong>To view color codes <a href="https://material.io/resources/color/" target="_blank">click here!</a></strong></h3>
      </div>
    </div>
    <br />

    <!-- game Introduction -->
    <div class="row" id="renameIntroduction">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="gameIntroduction">Game Introduction</label>
          <input type="text" name="gameIntroduction" value="<?php echo $gameIntroduction; ?>" class="form-control" placeholder="Put Game Introduction Title">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="gameIntroductionColorCode">Introduction Color Code</label>
          <input type="text" name="gameIntroductionColorCode" value="<?php echo $gameIntroductionColorCode; ?>" class="form-control" placeholder="Introduction Color Code">
        </div>
      </div>
      <br>
      
      <div class="col-md-1">
        <label for="gameIntroductionShow" class="containerRadio">
          <input type="radio" id="gameIntroductionShow" name="gameIntroductionVisibility" value="0" <?php echo ($gameIntroductionVisibility == 0) ? 'checked' : ''; ?>> Show
          <span class="checkmarkRadio"></span>
        </label>
      </div>

      <div class="col-md-1">
        <label for="gameIntroductionHide" class="containerRadio">
          <input type="radio" id="gameIntroductionHide" name="gameIntroductionVisibility" value="1" <?php echo ($gameIntroductionVisibility == 1) ? 'checked' : ''; ?>> Hide
          <span class="checkmarkRadio"></span>
        </label>
      </div>
    </div>

    <!-- game Video -->
    <div class="row" id="renameVideo">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="gameVideos">Game Video</label>
          <input type="text" name="gameVideos" value="<?php echo $gameVideos; ?>" class="form-control" placeholder="Put Game Video Title">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="gameVideosColorCode">Video Color Code</label>
          <input type="text" name="gameVideosColorCode" value="<?php echo $gameVideosColorCode; ?>" class="form-control" placeholder="Video Color Code">
        </div>
      </div>
      <br>
      
      <div class="col-md-1">
        <label for="gameVideoShow" class="containerRadio">
          <input type="radio" id="gameVideoShow" name="gameVideosVisibility" value="0" <?php echo ($gameVideosVisibility == 0) ? 'checked' : ''; ?>> Show
          <span class="checkmarkRadio"></span>
        </label>
      </div>

      <div class="col-md-1">
        <label for="gameVideoHide" class="containerRadio">
          <input type="radio" id="gameVideoHide" name="gameVideosVisibility" value="1" <?php echo ($gameVideosVisibility == 1) ? 'checked' : ''; ?>> Hide
          <span class="checkmarkRadio"></span>
        </label>
      </div>
    </div>

    <!-- Image alias -->
    <div class="row" id="renameImage">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="gameImages">Game Image</label>
          <input type="text" name="gameImages" value="<?php echo $gameImages; ?>" class="form-control" placeholder="Put Game Image Title">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="gameImagesColorCode">Image Color Code</label>
          <input type="text" name="gameImagesColorCode" value="<?php echo $gameImagesColorCode; ?>" class="form-control" placeholder="Image Color Code">
        </div>
      </div>
      <br>
      
      <div class="col-md-1">
        <label for="gameImageShow" class="containerRadio">
          <input type="radio" id="gameImageShow" name="gameImagesVisibility" value="0" <?php echo ($gameImagesVisibility == 0) ? 'checked' : ''; ?>> Show
          <span class="checkmarkRadio"></span>
        </label>
      </div>

      <div class="col-md-1">
        <label for="gameImageHide" class="containerRadio">
          <input type="radio" id="gameImageHide" name="gameImagesVisibility" value="1" <?php echo ($gameImagesVisibility == 1) ? 'checked' : ''; ?>> Hide
          <span class="checkmarkRadio"></span>
        </label>
      </div>
    </div>

    <!-- Document alias -->
    <div class="row" id="renameDocument">
      <div class="col-sm-6">
        <div class="form-group">
          <label for="gameDocuments">Game Document</label>
          <input type="text" name="gameDocuments" value="<?php echo $gameDocuments; ?>" class="form-control" placeholder="Put Game Document Title">
        </div>
      </div>

      <div class="col-sm-3">
        <div class="form-group">
          <label for="gameDocumentsColorCode">Document Color Code</label>
          <input type="text" name="gameDocumentsColorCode" value="<?php echo $gameDocumentsColorCode; ?>" class="form-control" placeholder="Document Color Code">
        </div>
      </div>
      <br>
      
      <div class="col-md-1">
        <label for="gameDocumentShow" class="containerRadio">
          <input type="radio" id="gameDocumentShow" name="gameDocumentsVisibility" value="0" <?php echo ($gameDocumentsVisibility == 0) ? 'checked' : ''; ?>> Show
          <span class="checkmarkRadio"></span>
        </label>
      </div>

      <div class="col-md-1">
        <label for="gameDocumentHide" class="containerRadio">
          <input type="radio" id="gameDocumentHide" name="gameDocumentsVisibility" value="1" <?php echo ($gameDocumentsVisibility == 1) ? 'checked' : ''; ?>> Hide
          <span class="checkmarkRadio"></span>
        </label>
      </div>
    </div>
    <br /><br />
    <!-- ===================== -->

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group text-center">
					<?php if (isset($_GET['edit']) && !empty($_GET['edit'])) { ?>
						<button type="button" id="game_introduction_btn_update" class="btn btn-primary"> Update </button>
						<button type="submit" name="submit" id="game_introduction_update" class="btn btn-primary hidden" value="UpdateIntroduction"> Update </button>
						<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
					<?php } ?>
				</div>
			</div>
		</div>
    
	</form>
</div>

<script>
	$(document).ready(function(){
		$('#game_introduction_btn_update').click(function(){
			//	if($("#siteuser_frm").valid()){
				$( "#game_introduction_update" ).trigger( "click" );
			//	}
		});
	});
</script>
