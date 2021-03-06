<?php 
  // echo "<pre>"; print_r($scen); print_r($_GET['close']); exit;
  $closeWindow = $_GET['close'];
  include_once 'includes/header.php'; 

  // echo "<pre>"; 
  // print_r('Storyline-'.$Scen_Json['aliasStoryline'].'<br />'); 
  // print_r('Video-'.$Scen_Json['aliasVideo'].'<br />'); 
  // print_r('Image-'.$Scen_Json['aliasImage'].'<br />'); 
  // print_r('Document-'.$Scen_Json['aliasDocument'].'<br />'); 
  // echo "</pre>"; 
  // exit();

  $aliasStoryline           = $Scen_Json['aliasStoryline'] ? $Scen_Json['aliasStoryline'] : 'Storyline';
  $aliasStorylineColorCode  = $Scen_Json['aliasStorylineColorCode'] ? $Scen_Json['aliasStorylineColorCode'] : 'lightcyan';
  $aliasStorylineVisibility = $Scen_Json['aliasStorylineVisibility'] == 1 ? 'hidden' : '';

  $aliasVideo               = $Scen_Json['aliasVideo'] ? $Scen_Json['aliasVideo'] : 'Video';
  $aliasVideoColorCode      = $Scen_Json['aliasVideoColorCode'] ? $Scen_Json['aliasVideoColorCode'] : 'lavender';
  $aliasVideoVisibility     = $Scen_Json['aliasVideoVisibility'] == 1 ? 'hidden' : '';

  $aliasImage               = $Scen_Json['aliasImage'] ? $Scen_Json['aliasImage'] : 'Image';
  $aliasImageColorCode      = $Scen_Json['aliasImageColorCode'] ? $Scen_Json['aliasImageColorCode'] : 'lavenderblush';
  $aliasImageVisibility     = $Scen_Json['aliasImageVisibility'] == 1 ? 'hidden' : '';

  $aliasDocument            = $Scen_Json['aliasDocument'] ? $Scen_Json['aliasDocument'] : 'Documents';
  $aliasDocumentColorCode   = $Scen_Json['aliasDocumentColorCode'] ? $Scen_Json['aliasDocumentColorCode'] : 'lemonchiffon';
  $aliasDocumentVisibility  = $Scen_Json['aliasDocumentVisibility'] == 1 ? 'hidden' : '';
?>
<!--[if IE]>
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
	<div class="container">
		<div class="row">
			<!--<div class="col-sm-12"><div class="timer text-center col-sm-1 pull-right" id="timer">2:00</div></div>-->
		</div>
	</div>
	<div class="container" style="width: 92%;">
		<div class="row">
			<div class="col-sm-9 col-md-10 no_padding">
				<h2 class="gamename">
					<!-- <a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">
						<?php // echo $game_description; ?></a> /  -->
						<?php if(!empty($scen)){ echo $scen->Scen_Header; } ?>
					</h2>	
				</div>
				
				<div class="col-sm-2  text-right pull-right <?php echo ($scen->Scen_InputButton == 0)?'hidden':'';?> <?php echo ($closeWindow == 'true')?'hidden':'';?>" style="margin-top:-6px;">
					<button class="btn innerBtns" id="proceedBtn" type="button">Proceed</button>
				</div>

				<div class="col-sm-3 col-md-2 text-center">
					<input type="hidden" name="Scenid" value="<?php if(!empty($result)){ echo $result->Link_ScenarioID; } ?>" >

					<!--header("Location: ".site_root."scenario_description.php?Link=".$result->Link_ID);-->

				</div>

				<!-- <div class="clearfix scenario_header"></div> -->
				<div class="col-sm-12 no_padding shadow">
					<!-- Nav tabs -->	
					<div class="shadow TabMain col-sm-12">

            <ul class="nav nav-pills" role="tablist">
              <li role="presentation" class="nav-item regular <?php echo $aliasStorylineVisibility; ?>" style="background-color: <?php echo $aliasStorylineColorCode; ?>; margin:3px;">
                <a role="presentation" class="nav-link" href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab"><?php echo $aliasStoryline; ?></a>
              </li>

              <li role="presentation" class="nav-item regular <?php echo $aliasVideoVisibility; ?>" style="background-color: <?php echo $aliasVideoColorCode; ?>; margin:3px;">
                <a class="nav-link" href="#videosTab" aria-controls="videosTab" role="tab" data-toggle="tab"><?php echo $aliasVideo; ?></a>
              </li>

              <li role="presentation" class="nav-item regular <?php echo $aliasImageVisibility; ?>" style="background-color: <?php echo $aliasImageColorCode; ?>; margin:3px;">
                <a class="nav-link" href="#imagesTab" aria-controls="imagesTab" role="tab" data-toggle="tab"><?php echo $aliasImage; ?></a>
              </li>

              <li role="presentation" class="nav-item regular <?php echo $aliasDocumentVisibility; ?>" style="background-color: <?php echo $aliasDocumentColorCode; ?>; margin:3px;">
                <a class="nav-link" href="#documentsTab" aria-controls="documentsTab" role="tab" data-toggle="tab"><?php echo $aliasDocument; ?></a>
              </li>

              <li role="presentation" class="nav-item regular pull-right <?php echo ($link->Link_BackToIntro) ? 'hidden' : ''; ?>" style="background-color: lightgray;">
                <a class="nav-link" href='<?php echo site_root."game_description.php?Game=".$gameidChk; ?>'>Go Back To Introduction</a>
							</li>
							<!-- to close the current tab -->
							<?php if($closeWindow == 'true') { ?>
								<!-- <li><a href="javascript:void(0);" onclick="window.close();">Close Window</a></li> -->
								<!-- <li style="background-color: #337ab7;"><a onclick="window.close();" style="color:black;"><b>Close Window</b></a></li> -->
								<li role="presentation" class="nav-item regular" style="background-color: #337ab7; margin:3px;">
                  <a class="nav-link" href="#" aria-controls="" role="tab" data-toggle="tab" onclick="window.close();">Close Window</a>
                </li>
							<?php } ?>
            </ul>

            <!-- Older tabs -->
						<!-- <ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active regular">
                <a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">Storyline</a>
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
							<li role="presentation" class="regular pull-right <?php //echo ($link->Link_BackToIntro)?'hidden':''?>" style="margin-right: 40%;">
                <a href='<?php //echo site_root."game_description.php?Game=".$gameidChk; ?>'>Go Back To Introduction</a>
              </li>
						</ul> -->

						<!-- Tab panes -->
						<div class="tab-content">
							<div role="tabpanel" class="tab-pane <?php echo ($Scen_Json['aliasStorylineVisibility'] == 1)?'hidden':''; ?>" id="generalTab">
								<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
									<!-- Indicators -->
									<ol class="carousel-indicators"  style="display:none;">
										<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
										<li data-target="#myCarousel" data-slide-to="1"></li>
										<li data-target="#myCarousel" data-slide-to="2"></li>
										<li data-target="#myCarousel" data-slide-to="3"></li>
									</ol>
									<!-- adding 'hide_this' class to hide next and prev button to hide on screen size less -->
									<div class="carousel-inner col-lg-12 col-md-6" role="listbox" >
										<div class="col-sm-1 col-lg-1 col-md-1 text-right pull-left hide_this" style="margin-top: 15%;">
											<!-- <a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous" title="Previous" style="width: 75%; background: #DCDCDC;"></img></a> -->
										</div>
										<?php
										$i=1;
										while($row = mysqli_fetch_array($general)) {
											if($i==1)
											{
												echo "<div class='item active col-sm-10 col-lg-10 col-md-10'>";
											}
											else
											{												
												echo "<div class='item col-sm-10 col-lg-10 col-md-10'>";
											}
											$i++;
											echo "<div class='col-sm-12 no_padding'>";
											echo $row['ScenGen_Content'];												
											echo "</div></div>";
										}
										?>											
										<div class="col-sm-1 col-lg-1 col-md-1 text-left pull-right hide_this" style="margin-top: 15%;">
											<!-- <a href ="#myCarousel" role="button" data-slide="next"><img src="images/nextIcon.png" alt="Next" title="Next" style="width: 75%;background:#DCDCDC;"></img></a> -->
										</div>
									</div>
								</div>
										<!-- <?php if($i>1) { ?>
											<div class="nextPrev nextPrevbottom no_padding regular col-sm-12 col-md-12 col-lg-12">

												<div class="pull-left text-right col-md-6 col-sm-6">
													<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous"></img> Prev</a>
												</div>
												<div class="pull-right text-left col-md-6 col-sm-6">
													<a href ="#myCarousel" role="button" data-slide="next">Next <img src="images/nextIcon.png" alt="Previous"></img></a>
												</div>
											</div>
											<?php } ?> -->
										</div>

										<div role="tabpanel" class="tab-pane" id="videosTab">
											<?php 
											while($row = mysqli_fetch_array($video)) {
												echo "<div class='col-sm-6 videoDiv'>";										
												//echo "<iframe width='100%' height='240' autoplay='false' src='";
												//echo $row['ScenVdo_Name']."?autoplay=1";
												//echo "'></iframe> ";
												if($row['ScenVdo_Type'] < 1)
												{
													// url 
													echo "<video width='100%' height='240' controls controlsList='nodownload'><source src='".$row['ScenVdo_Name']."' type='video/mp4'></video>";
												}
												else
												{
													// embed 
													echo base64_decode($row['ScenVdo_Name']);
												}

												echo "<div class='col-sm-12 no_padding videoName'>";
												echo "<h4 class=''>";
												echo $row['ScenVdo_Title'];
												echo "</h4><span class='videoDiscription'>";
												echo $row['ScenVdo_Comments'];
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
												echo "ux-admin/upload/".$row['ScenImg_Name']."'";
												echo " alt='Image' class='img-cntr' onclick='return showNextPreviousImage(this, \"ImageDiv\");'></img>";
												echo "</div><div class='col-sm-12 no_padding ImageName'><h4 class=''>";
												echo $row['ScenImg_Title'];
												echo "</h4><span class='videoDiscription'>";
												echo $row['ScenImg_Comments'];
												echo "</span></div></div>";
											}									
											?>
										</div>

										<div role="tabpanel" class="tab-pane" id="documentsTab">
											<?php 
											while($row = mysqli_fetch_array($document)) {
												echo "<div class='col-sm-12 documentDownload regular'>";
												echo $row['ScenDoc_Title'];
												echo "<span class='pull-right'>";
												echo "<a href='scenario_description.php?Scen=".$row['ScenDoc_ScenID']."&File=".$row['ScenDoc_ID']."'>".$row['ScenDoc_Name']." <img src='images/downloadIcon.png' alt=''></img></a>";
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

				<footer>
					<div class="container">
						<div class="row">
							<div class="col-sm-12 text-center">
								<span></span>
							</div>
						</div>
					</div>
				</footer>
				<script>
					$(document).ready(function()
					{
						// adding the below code to show the visible tab by admin
						$('.nav-item').each(function(){
							if(!$(this).hasClass('hidden')){
								$('#'+$(this).children('a').attr('aria-controls')).addClass('active');
								return false
							}
						});
					// adding a confirmation box while click on proceed
					$('#proceedBtn').on('click',function(){
						// removing alert
						window.location='<?php echo $url; ?>';
						return false;
						// remove above 2 lines to show alert
						const swalWithBootstrapButtons = Swal.mixin({
							customClass: {
								confirmButton: 'btn btn-success',
								cancelButton : 'btn btn-danger'
							},
							buttonsStyling: false,
						})

						swalWithBootstrapButtons.fire({
					// title: 'Are you sure?',
					text             : "Please confirm that you have gone through all the content by clicking YES else press NO",
					icon             : 'warning',
					showCancelButton : true,
					confirmButtonText: 'YES',
					cancelButtonText : 'NO',
					reverseButtons   : false,
					showClass: {
						popup: 'animated fadeInRight faster'
					},
					hideClass: {
						popup: 'animated fadeOutRight faster'
					}
				}).then((result) => {
					if (result.value) {
						window.location='<?php echo $url; ?>';
						// swalWithBootstrapButtons.fire(
						//   'Deleted!',
						//   'Your file has been deleted.',
						//   'success'
						//   )
					}
					//     else if (
					// // Read more about handling dismissals
					// result.dismiss === Swal.DismissReason.cancel
					// ) {
					//       swalWithBootstrapButtons.fire(
					//         'Cancelled',
					//         'Your imaginary file is safe :)',
					//         'error'
					//         )
					//     }
				})

			});
				});
			</script>
			<!-- <script src="js/jquery.min.js"></script>	
			<script src="js/bootstrap.min.js"></script>			 -->
			<?php 
				// echo "<pre>"; print_r($scen); exit;
				include_once 'includes/footer.php'; 
			?>