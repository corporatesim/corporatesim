<?php 
include_once 'includes/header.php'; 
  // echo "<pre>"; print_r($game); exit;

  $game_Json = json_decode($game->Game_Introduction_Json, true);

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
<!--[if IE]
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
<style>
.active a {
  background-color: lightgray !important;
  color: black !important;
}
.regular a {
  color: black !important;
}
</style>
<script src="js/jquery.js"></script>
<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

<script type="text/javascript" charset="utf-8">
	
	$(document).ready(function () {
		$("area[rel^='prettyPhoto']").prettyPhoto();

		$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({ animation_speed: 'normal', theme: 'light_square', slideshow: 10000, autoplay_slideshow: true });
		$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({ animation_speed: 'fast', slideshow: 5000, hideflash: true });

		$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
			custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
			changepicturecallback: function () { initialize(); }
		});

		$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
			custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
			changepicturecallback: function () { _bsap.exec(); }
		});
	});
</script>

<section id="video_player">
	<div class="container" style="width: 92%;">
		<div class="row">
			<div class="col-sm-9 col-md-10 no_padding">
				<!-- <h4 class="InnerPageHeader"><?php if(!empty($game)){ echo $game->Game_Header; } ?> </h4> -->
				<h2 class="gamename">
					<?php if(!empty($game)){ echo $game->Game_Header; } ?>
				</h2>
			</div>
			
			<div class="col-sm-2 text-right pull-right <?php echo ($game->Game_HideScenarioLink == 1)?'hidden':'';?>">
				<input type="hidden" name="Scenid" value="<?php if(!empty($result)){ echo $result->Link_ScenarioID; } ?>" >
				<button id="scenario_button" class="btn innerBtns" onclick="window.location='<?php echo $url; ?>';">Scenario</button>
			</div>

			<div class="clearfix scenario_header"></div>
			<div class="col-sm-12 no_padding shadow">
				<!-- Nav tabs -->	
				<div class="shadow TabMain col-sm-12">

            <ul class="nav nav-pills" role="tablist">
              <!-- <li role="presentation" class="nav-item regular active" style="background-color: lightcyan;">
                <a role="presentation" class="nav-link regular" href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">Introduction</a>
              </li> -->
              <?php if ($gameIntroductionVisibility == 0) { ?>
              <li role="presentation" class="nav-item regular" style="background-color: <?php echo $gameIntroductionColorCode; ?>; margin:3px;">
                <a role="presentation" class="nav-link" href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab"><?php echo $gameIntroduction; ?></a>
              </li>
              <?php } ?>

              <!-- <li role="presentation" class="nav-item regular" style="background-color: lavender;">
                <a class="nav-link" href="#videosTab" aria-controls="videosTab" role="tab" data-toggle="tab">Videos</a>
              </li> -->
              <?php if ($gameVideosVisibility == 0) { ?>
              <li role="presentation" class="nav-item regular" style="background-color: <?php echo $gameVideosColorCode; ?>; margin:3px;">
                <a role="presentation" class="nav-link" href="#videosTab" aria-controls="videosTab" role="tab" data-toggle="tab"><?php echo $gameVideos; ?></a>
              </li>
              <?php } ?>

              <!-- <li role="presentation" class="nav-item regular" style="background-color: lavenderblush;">
                <a class="nav-link" href="#imagesTab" aria-controls="imagesTab" role="tab" data-toggle="tab">Images</a>
              </li> -->
              <?php if ($gameImagesVisibility == 0) { ?>
              <li role="presentation" class="nav-item regular" style="background-color: <?php echo $gameImagesColorCode; ?>; margin:3px;">
                <a role="presentation" class="nav-link" href="#imagesTab" aria-controls="imagesTab" role="tab" data-toggle="tab"><?php echo $gameImages; ?></a>
              </li>
              <?php } ?>
   
              <!-- <li role="presentation" class="nav-item regular" style="background-color: lemonchiffon;">
                <a class="nav-link" href="#documentsTab" aria-controls="documentsTab" role="tab" data-toggle="tab">Documents</a>
              </li> -->
              <?php if ($gameDocumentsVisibility == 0) { ?>
              <li role="presentation" class="nav-item regular" style="background-color: <?php echo $gameDocumentsColorCode; ?>; margin:3px;">
                <a role="presentation" class="nav-link" href="#documentsTab" aria-controls="documentsTab" role="tab" data-toggle="tab"><?php echo $gameDocuments; ?></a>
              </li>
              <?php } ?>

              <li role="presentation" class="nav-item regular" style="background-color: #337ab7; margin:3px;">
                <a class="nav-link" href="javascript:void(0);" aria-controls="" role="tab" data-toggle="tab" onclick="closeMe()">Close Window</a>
              </li>
              <script>
                function closeMe() {
                  window.opener = self;
                  window.close();
                  setTimeout (window.close, 1000);
                }
              </script>
            </ul>

            <!-- Older tabs -->
					<!-- <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active regular">
              <a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">Introduction</a>
            </li>
						<li role="presentation" class="regular">
              <a href="#videosTab" aria-controls="videosTab" role="tab" data-toggle="tab">Videos</a>
            </li>
						<li role="presentation" class="regular">
              <a href="#imagesTab" aria-controls="imagesTab" role="tab" data-toggle="tab">Images</a>
            </li>
						<li role="presentation" class="regular">
              <a href="#documentsTab" aria-controls="documentsTab" role="tab" data-toggle="tab">Documents</a>
            </li>
					</ul> -->

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="generalTab">
							<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
								<!-- Indicators -->
								<ol class="carousel-indicators" style="display:none;">
									<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
									<li data-target="#myCarousel" data-slide-to="1"></li>
									<li data-target="#myCarousel" data-slide-to="2"></li>
									<li data-target="#myCarousel" data-slide-to="3"></li>
								</ol>
										<!-- <div class="nextPrev no_padding regular col-sm-12">
											<div class="col-sm-6 text-right">
												<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous"></img> Prev</a>
											</div>
											<div class="col-sm-6 text-left">
												<a href ="#myCarousel" role="button" data-slide="next">Next <img src="images/nextIcon.png" alt="Previous"></img></a>
											</div>
										</div> -->
										<!-- adding 'hide_this' class to hide next and prev button to hide on screen size less -->
										<div class="carousel-inner" role="listbox" >
											<div class="col-sm-1 col-lg-1 text-right pull-left hide_this hidden" style="margin-top: 15%;">
												<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous" title="Previous" style="width: 75%; background: #DCDCDC;"></img></a>
											</div>
											<?php
											$i = 1;
											while($row = mysqli_fetch_array($general)) {
												if($i==1)
												{
													echo "<div class='item active col-sm-10 col-lg-10'>";
												}
												else
												{												
													echo "<div class='item col-sm-10 col-lg-10'>";
												}
												$i++;
												echo "<div class='col-sm-12 no_padding'>";
												echo $row['GameGen_Content'];												
												echo "</div></div>";
											}
											?>
											<div class="col-sm-1 col-lg-1 text-left pull-right hide_this hidden" style="margin-top: 15%;">
												<a href ="#myCarousel" role="button" data-slide="next"><img src="images/nextIcon.png" alt="Next" title="Next" style="width: 75%; background: #DCDCDC;"></img></a>
											</div>
										</div>
									</div>
									<?php if($i>2) { ?>
										<div class="nextPrev nextPrevbottom no_padding regular col-sm-12 hidden">

											<div class="col-md-6 col-sm-6 pull-left text-right">
												<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous"></img> Prev</a>
											</div>
											<div class="col-md-6 col-sm-6 pull-right text-left">
												<a href ="#myCarousel" role="button" data-slide="next">Next <img src="images/nextIcon.png" alt="Previous"></img></a>
											</div>
										</div>
									<?php } ?>
								</div>
								
								<div role="tabpanel" class="tab-pane" id="videosTab">
									<?php 
									while($row = mysqli_fetch_array($video)) {
										echo "<div class='col-sm-6 videoDiv'>";
										if($row['GameVdo_Type'] == 1)
										{
											echo $row['GameVdo_Name'];
										}
										else
										{
											echo "<video width='100%' height='240' controls><source src='";
											echo $row['GameVdo_Name'];
											echo "' type='video/mp4'></video>";
										}

										echo "<div class='col-sm-12 no_padding videoName'>";
										echo "<h4 class=''>";
										echo $row['GameVdo_Title'];
										echo "</h4><span class='videoDiscription'>";
										echo $row['GameVdo_Comments'];
										echo "</span></div><div class='clearfix'></div></div>";
									}
									?>
								</div>
								
								<div role="tabpanel" class="tab-pane" id="imagesTab">
									<?php 
									while($row = mysqli_fetch_array($image)) {
										echo "<div class='col-sm-6 ImageDiv gallery'>";
										echo "<div class='img-container '>";
										echo "<img src='";
										echo "ux-admin/upload/".$row['GameImg_Name'];
										echo "' alt='Image' class='img-cntr'onclick='return showNextPreviousImage(this, \"ImageDiv\");'></img>";
										echo "</div><div class='col-sm-12 no_padding ImageName'><h4 class=''>";
										echo $row['GameImg_Title'];
										echo "</h4><span class='videoDiscription'>";
										echo $row['GameImg_Comments'];
										echo "</span></div></div>";
									}									
									?>
								</div>
								
								<div role="tabpanel" class="tab-pane" id="documentsTab">
									<?php 
									while($row = mysqli_fetch_array($document)) {
										echo "<div class='col-sm-12 documentDownload regular'>";
										echo $row['GameDoc_Title'];
										echo "<span class='pull-right'>";
										echo "<a href='game_description.php?Game=".$row['GameDoc_GameID']."&File=".$row['GameDoc_ID']."'>".$row['GameDoc_Name']." <img src='images/downloadIcon.png' alt='Download'></img></a>";
										echo "</span></div>";
									}
									?>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>

						<div class="clearix"></div>
					</div>			
				</div>
			</div>
		</section>	

		<?php 
				// echo "<pre>"; print_r($scen); exit;
				include_once 'includes/footer.php'; 
			?>