<!-- <?php // echo "<pre>"; print_r($_SESSION); exit;?> -->
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<title>Corporate Sim | Select Game</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- <link rel="stylesheet" href="<?php echo site_root;?>css/selectgame.css?v=<?php echo version;?>">   -->

		<link rel="stylesheet" href="<?php echo site_root;?>css/inner_pages.css?v=<?php echo version;?>">  
		<link rel="stylesheet" href="<?php echo site_root;?>css/style.css?v=<?php echo version;?>"> 
		<link rel="stylesheet" href="<?php echo site_root;?>css/simulation.css?v=<?php echo version;?>"> 
		
		<!-- Admin files starts here -->
		<!-- favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_root;?>images/favicon.ico">
		<!-- Bootstrap Core CSS -->
		<link href="<?php echo site_root;?>assets/components/bootstrap/dist/css/bootstrap.min.css?v=<?php echo version;?>" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<?php echo site_root;?>assets/dist/css/sb-admin-2.css?v=<?php echo version;?>" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="<?php echo site_root;?>assets/components/font-awesome/css/font-awesome.min.css?v=<?php echo version;?>" rel="stylesheet" type="text/css">
		<!-- Admin files end here -->
		<script src="<?php echo site_root;?>js/jquery.min.js?v=<?php echo version;?>"></script>	
		<script src="<?php echo site_root;?>js/bootstrap.min.js?v=<?php echo version;?>"></script>
		<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
		<!-- adding sweet alert -->
		<link href="<?php echo site_root;?>dist/sweetalert/sweetalert2.min.css?v=<?php echo version;?>" rel="stylesheet" type="text/css">
		<link href="<?php echo site_root;?>dist/sweetalert/animate.min.css?v=<?php echo version;?>" rel="stylesheet" type="text/css">
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css?v=<?php echo version;?>"> -->
		<script src="<?php echo site_root;?>dist/sweetalert/sweetalert2.all.min.js?v=<?php echo version;?>"></script>
		
		<!-- adding these links to include chart.js -->
		<script src="<?php echo site_root;?>chartjs/chart.bundle.min.js?v=<?php echo version;?>"></script>
		<link href="<?php echo site_root;?>chartjs/chart.min.css?v=<?php echo version;?>" rel="stylesheet" type="text/css">
		<script src="<?php echo site_root;?>chartjs/chart.min.js?v=<?php echo version;?>"></script>

		<style>
			.swal2-container.swal2-backdrop-show{
				background: #00000066;
			}
		</style>

		<center>
			<div id="imageModal" class="modal">
				<span class="close" id="close" style="font-size: 50px; opacity: 1; color:#f00;">
					&times;
				</span>
				<img class="modal-content" id="showImageHere">
				<div id="caption"></div>
			</div>
		</center>
		<!-- adding custom css for navigation -->
		
		<!-- end of adding custom css for navitation -->
		<!-- adding new navBar here -->
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header" style="margin: 5px 0px 5px 0px;">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
					<span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<!-- <a style="padding: 2px 15px;" class="navbar-brand" href="<?php echo site_root;?>ux-admin/index">  -->
					<?php if(isset($_SESSION['logo'])) { ?>
						<a href="<?php echo site_root;?>">
							<img src="<?php echo site_root."enterprise/common/Logo/".$_SESSION['logo'];?>" style="max-width: 300px; height: 45px;"/>
						</a>
					<?php } else { ?>
						<a href="<?php echo site_root;?>">
							<img src="<?php echo site_root."images/logo-main.png";?>"  width="40px"/>
						</a>
					<?php } ?>
				</div>
			</a>
			<p class="pull-left wel_note"></p>
		</div>
		<!-- Profile & SeoSetting Drop down Navigation -->
		<ul class="nav navbar-nav navbar-right">
			<?php 
			if($_REQUEST['act']!='chart')
			{
				if(isset($_SESSION['username']) && !empty($_SESSION['username'])){ 
					?>
					<li class="hoverAnchor"><a href="<?php echo site_root."selectgame.php";?>" class="">Welcome <?php echo ucfirst(strtolower($_SESSION['username'])); ?></a></li>
					<li class="hoverAnchor"><a href="<?php echo site_root."logout.php?q=Logout";?>" class="">Logout</a></li>
				<?php }else{ ?>
					<li class="hoverAnchor hidden"><a href="<?php echo site_root."registration.php";?>" class="">Register</a></li>
				<?php } }?>
				<?php
				$allowedDonmain = ['http://localhost/corp_simulation/','https://develop.corporatesim.com/'];
				if(in_array(site_root,$allowedDonmain)) { ?>
					<li class="" id="google_translate_element"></li>
				<?php } else {
					echo '<script>$(document).on("contextmenu", function() {
						return false;
					});</script>';
				}?>
			</ul>
			<div class="clearfix"></div>
			<!-- Left Side Main Navigation -->
			<div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse">
					<ul class="nav in" id="side-menu">
						<!-- adding user profile pic -->
						<li>
							<a href="javascript:void(0);">
								<center>
									<img src="<?php $imageSrc=($_SESSION['User_profile_pic'])?$_SESSION['User_profile_pic']:'avatar.png'; echo site_root.'images/userProfile/'.$imageSrc;?>" alt="Profile Image" class="showImagePopUp" width="65%" data-toggle="tooltip" title="Update your profile pic from My-Profile section">
								</center>
							</a>
						</li>
						<!-- end of user profile pic -->
						<li>
							<a style="color:#d1dae2;" href="selectgame.php" class="<?php echo ($_SESSION['userpage'] == 'selectgame')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-bishop"></i> Simulations</a>
						</li>
						<li class="hidden">
							<a style="color:#d1dae2;" href="gameCatalogue.php" class="<?php echo ($_SESSION['userpage'] == 'gameCatalogue')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-knight"></i> Catalogue</a>
						</li>
						<li>
							<a style="color:#d1dae2;" href="howToPlay.php" class="<?php echo ($_SESSION['userpage'] == 'howToPlay')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-play"></i> How To Play</a>
						</li>
						<li>
							<a style="color:#d1dae2;" href="settings.php" class="<?php echo ($_SESSION['userpage'] == 'settings')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-cog"></i>  Settings</a>
						</li>
						<li>
							<a style="color:#d1dae2;" href="my_profile.php" class="<?php echo ($_SESSION['userpage'] == 'my_profile')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-user"></i> My Profile</a>
						</li>
						<li>
							<a style="color:#d1dae2;" href="feedback.php" class="<?php echo ($_SESSION['userpage'] == 'Feedback')?'active':'';?>"><i style="padding-right:20px;" class="glyphicon glyphicon-envelope"></i> Feedback</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- end of adding new navBar here -->
	</head>
	<body background="images/bg3.jpg">	
		<!-- adding loader -->
		<div id="loader" class="col-md-12 overlay">
			<div class="dbl-spinner"></div>
			<div class="dbl-spinner"></div> 
			<div class="overlay-content">
				<span>Please Wait...</span>
			</div>
			<!-- <div style="margin: 20% 0 0 50%;">Please Wait...</div> -->
		</div>
		<!-- end of adding loader -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			// countInclick   = 0;
			// countOutclick  = 0;
			// animateInArray = ['bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'flipInX', 'flipInY', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'lightSpeedIn', 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'flip', 'hinge', 'jackInTheBox', 'rollIn'];

			// animateOutArray = ['bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'flipOutX', 'flipOutY', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'lightSpeedOut', 'rollOut'];
			
			showImageModal();
			
			function googleTranslateElementInit() {
				new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
			}
		// on language change set the default language for user
		setTimeout(function(){
			$('select.goog-te-combo').on('change',function(){
				console.log($(this).val());
			});
			// $('.skiptranslate').css({'display':'none'});
			// $(".goog-logo-link").parent().remove();
			// $(".goog-te-gadget").html(
			// 	$(".goog-te-gadget").html().replace('Powered by ', '')
			// 	);
		},1000);
	});
			function showImageModal()
			{
				$('marquee').each(function(){
					$(this).on('mouseover',function(){this.stop();});
					$(this).on('mouseout',function(){this.start();});
				});

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
			}
		</script>