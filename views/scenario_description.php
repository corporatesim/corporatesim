<?php 
// echo "<pre>"; print_r($scen); exit;
include_once 'includes/header.php'; 
?>
<style>
.DisplayNone{
	display: none;
}
</style>
<!--[if IE]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="css/prettyPhoto.css">
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
	<div class="container">
		<div class="row">
			<div class="col-sm-9 col-md-10 no_padding">
				<h2 class="gamename"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">
					<?php echo $game_description; ?></a> / 
					<?php if(!empty($scen)){ echo $scen->Scen_Name; } ?> </h2>	
				</div>
				<div class="col-sm-2  text-right pull-right <?php echo ($scen->Scen_InputButton == 0)?'DisplayNone':'';?>" style="margin-top:-6px;">
					<button class="btn innerBtns" onclick="window.location='<?php echo $url; ?>';">Proceed</button>
						<!--<button class="btn innerBtns">Save</button>
							<button class="btn innerBtns">Submit</button>-->
						</div>

						<div class="col-sm-3 col-md-2 text-center">
							<input type="hidden" name="Scenid" value="<?php if(!empty($result)){ echo $result->Link_ScenarioID; } ?>" >

							<!--header("Location: ".site_root."scenario_description.php?Link=".$result->Link_ID);-->

						</div>

						<div class="clearfix"></div>
						<div class="col-sm-12 no_padding shadow">
							<!-- Nav tabs -->	
							<div class="shadow TabMain col-sm-12">

								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active regular"><a href="#generalTab" aria-controls="generalTab" role="tab" data-toggle="tab">Storyline</a></li>
									<li role="presentation" class="regular"><a href="#videosTab" aria-controls="videosTab" role="tab" data-toggle="tab">Videos</a></li>
									<li role="presentation" class="regular"><a href="#imagesTab" aria-controls="imagesTab" role="tab" data-toggle="tab">Images</a></li>
									<li role="presentation" class="regular"><a href="#documentsTab" aria-controls="documentsTab" role="tab" data-toggle="tab">Documents</a></li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div role="tabpanel" class="tab-pane active" id="generalTab">
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
													<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous" title="Previous" style="width: 75%; background: #DCDCDC;"></img></a>
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
													<a href ="#myCarousel" role="button" data-slide="next"><img src="images/nextIcon.png" alt="Next" title="Next" style="width: 75%;background:#DCDCDC;"></img></a>
												</div>
											</div>
										</div>
										<?php if($i>1) { ?>
											<div class="nextPrev nextPrevbottom no_padding regular col-sm-12 col-md-12 col-lg-12">

												<div class="pull-left text-right col-md-6 col-sm-6">
													<a href ="#myCarousel" role="button" data-slide="prev"><img src="images/prevIcon.png" alt="Previous"></img> Prev</a>
												</div>
												<div class="pull-right text-left col-md-6 col-sm-6">
													<a href ="#myCarousel" role="button" data-slide="next">Next <img src="images/nextIcon.png" alt="Previous"></img></a>
												</div>
											</div>
										<?php } ?>
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
												echo "<video width='100%' height='240' controls><source src='";
												echo $row['ScenVdo_Name'];
												//videos/example.mp4
												echo "' type='video/mp4'></video>";
											}
											else
											{
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
											echo "ux-admin/upload/".$row['ScenImg_Name'];
											echo "' alt='Image' class='img-cntr showImageModal'></img>";
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
			
			<script src="js/jquery.min.js"></script>	
			<script src="js/bootstrap.min.js"></script>			
			<!-- creating pop up for image modal -->
			<style>
			#showImageModal {
				border-radius: 5px;
				cursor       : pointer;
				transition   : 0.3s;
			}

			#showImageModal:hover {opacity: 0.7;}

			/* The Modal (background) */
			.modal {
				display         : none; /* Hidden by default */
				position        : fixed; /* Stay in place */
				z-index         : 1; /* Sit on top */
				padding-top     : 100px; /* Location of the box */
				left            : 0;
				top             : 0;
				width           : 100%; /* Full width */
				height          : 100%; /* Full height */
				overflow        : auto; /* Enable scroll if needed */
				background-color: rgb(0,0,0); /* Fallback color */
				background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
			}

			/* Modal Content (image) */
			.modal-content {
				margin   : auto;
				display  : block;
				width    : 80%;
				max-width: 700px;
				top      : 5%;
			}

			/* Caption of Modal Image */
			#caption {
				margin    : auto;
				display   : block;
				width     : 80%;
				max-width : 700px;
				text-align: center;
				color     : #ccc;
				padding   : 10px 0;
				height    : 150px;
			}

			/* Add Animation */
			.modal-content, #caption {  
				-webkit-animation-name    : zoom;
				-webkit-animation-duration: 0.6s;
				animation-name            : zoom;
				animation-duration        : 0.6s;
			}

			@-webkit-keyframes zoom {
				from {-webkit-transform:scale(0)} 
				to {-webkit-transform:scale(1)}
			}

			@keyframes zoom {
				from {transform:scale(0)} 
				to {transform:scale(1)}
			}

			/* 100% Image Width on Smaller Screens */
			@media only screen and (max-width: 700px){
				.modal-content {
					width: 100%;
				}
			}
		</style>

		<!-- The Modal -->
		<center>
			<div id="imageModal" class="modal">
				<span class="close" id="close" style="font-size: 50px; opacity: 1; color:#f00;">
					&times;
				</span>
				<img class="modal-content" id="showImageHere">
				<div id="caption"></div>
			</div>
		</center>
		<script>
			$(document).ready(function(){
				$('.showImageModal').each(function(){
					$(this).on('click',function(){
						$('#imageModal').show();
						$('#showImageHere').attr('src',$(this).attr('src'));
					});
				});
				$('#close').on('click',function(){
					// $('#imageModal').hide('slow');
					$('#imageModal').slideUp(1000);
				});
				$('img').on('contextmenu', function() {
					return false;
				})
			});
		</script>
	<!--
	<script src="js/function.js"></script>
<script type="text/javascript">

<?php
		// $sql = "SELECT Link_Hour,Link_Min FROM `GAME_LINKAGE` WHERE Link_ID= ".$linkid;
		// $objsql = $functionsObj->ExecuteQuery($sql);
		// $ressql = $functionsObj->FetchObject($objsql);
		// $hour = $ressql->Link_Hour;	
		// $min = $ressql->Link_Min + ($hour * 60);
		
		// echo "if (".$linkid." == getCookie('linkid')){} else {";
		// echo "setCookie('linkid',".$linkid.",10);";
		// echo "setCookie('minutes',".$min.",10);";
		
		// echo "}";

		// echo "countdown(".$min.",true);";
		
?>
</script>
-->
</body>
</html>