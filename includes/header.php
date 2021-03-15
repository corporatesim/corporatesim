<!-- <?php //echo $_SESSION['logo']; exit; ?> -->
<!DOCTYPE html>
<html>

<head>
	<title> Corporate Sim</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="<?php echo site_root; ?>css/bootstrap.min.css?v=<?php echo version; ?>">
	<!-- <link rel="stylesheet" href="<?php echo site_root; ?>css/selectgame.css?v=<?php echo version; ?>">   -->

	<link rel="stylesheet" href="<?php echo site_root; ?>css/inner_pages.css?v=<?php echo version; ?>">
	<link rel="stylesheet" href="<?php echo site_root; ?>css/style.css?v=<?php echo version; ?>">
	<link rel="shortcut icon" type="image/x-icon" href="images/faviconnew.ico">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300,500,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700" rel="stylesheet">
	<script src="js/jquery.min.js?v=<?php echo version; ?>"></script>
	<script src="js/bootstrap.min.js?v=<?php echo version; ?>"></script>
	<!-- adding sweet alert -->
	<link href="<?php echo site_root; ?>dist/sweetalert/sweetalert2.min.css?v=<?php echo version; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo site_root; ?>dist/sweetalert/animate.min.css?v=<?php echo version; ?>" rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css?v=<?php echo version; ?>"> -->
	<script src="<?php echo site_root; ?>dist/sweetalert/sweetalert2.all.min.js?v=<?php echo version; ?>"></script>

	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

	<!-- adding these links to include chart.js -->
	<script src="<?php echo site_root; ?>chartjs/chart.bundle.min.js?v=<?php echo version; ?>"></script>
	<link href="<?php echo site_root; ?>chartjs/chart.min.css?v=<?php echo version; ?>" rel="stylesheet" type="text/css">
	<script src="<?php echo site_root; ?>chartjs/chart.min.js?v=<?php echo version; ?>"></script>

	<style>
		.navbar-default .navbar-nav>li>a {
			color: #337ab7;
		}

		.swal2-container.swal2-backdrop-show {
			background: #00000066;
		}

.loader-spinner {
  margin: 12em auto;
  font-size: 24px;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  position: relative;
  text-indent: -9999em;
  -webkit-animation: load 1.1s infinite ease;
  animation: load 1.1s infinite ease;
}

@-webkit-keyframes load {
  0%,
  100% {
    box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
  }
  12.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
  }
  25% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  37.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  50% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  62.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  75% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  87.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
  }
}
@keyframes load {
  0%,
  100% {
    box-shadow: 0em -2.6em 0em 0em #ffffff, 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.5), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7);
  }
  12.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.7), 1.8em -1.8em 0 0em #ffffff, 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5);
  }
  25% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.5), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.7), 2.5em 0em 0 0em #ffffff, 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  37.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.5), 2.5em 0em 0 0em rgba(255, 255, 255, 0.7), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  50% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.5), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.7), 0em 2.5em 0 0em #ffffff, -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.2), -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  62.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.5), 0em 2.5em 0 0em rgba(255, 255, 255, 0.7), -1.8em 1.8em 0 0em #ffffff, -2.6em 0em 0 0em rgba(255, 255, 255, 0.2), -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  75% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.5), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.7), -2.6em 0em 0 0em #ffffff, -1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2);
  }
  87.5% {
    box-shadow: 0em -2.6em 0em 0em rgba(255, 255, 255, 0.2), 1.8em -1.8em 0 0em rgba(255, 255, 255, 0.2), 2.5em 0em 0 0em rgba(255, 255, 255, 0.2), 1.75em 1.75em 0 0em rgba(255, 255, 255, 0.2), 0em 2.5em 0 0em rgba(255, 255, 255, 0.2), -1.8em 1.8em 0 0em rgba(255, 255, 255, 0.5), -2.6em 0em 0 0em rgba(255, 255, 255, 0.7), -1.8em -1.8em 0 0em #ffffff;
  }
}

.adjust {
  min-height: 60px; 
  height: auto;
}

	</style>
	<!-- <script>
		$(document).bind("contextmenu",function(e){
			return false;
		});
	</script> -->

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
</head>

<body background="images/bg3.jpg">
	<!-- adding loader -->
	<div id="loader" class="col-md-12 overlay">
    <div class="adjust"> <div class="loader-spinner"></div> </div>

    <!-- old loader -->
		<!-- <div class="dbl-spinner"></div>
		<div class="dbl-spinner"></div>  -->
		<!-- <div class="overlay-content">
			<span id="showOverlayText">Please Wait...</span>
		</div> -->
		<!-- <div style="margin: 20% 0 0 50%;">Please Wait...</div> -->
	</div>
	<!-- end of adding loader -->
	<header>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- add image logo here -->
				<div class="navbar-header" style="margin: 5px 0px 5px 0px;">
					<?php if (isset($_SESSION['logo'])) { ?>
						<a href="<?php echo site_root; ?>">
							<img src="<?php echo site_root . "enterprise/common/Logo/" . $_SESSION['logo']; ?>" style="max-width: 300px; height: 45px;" />
						</a>

					<?php } else { ?>
						<a href="<?php echo site_root; ?>">
							<img src="<?php echo site_root . "images/logo-main.png"; ?>" width="40px" />
						</a>
					<?php } ?>
				</div>
				<!-- end of adding image logo here -->
				<ul class="nav navbar-nav navbar-right">
					<?php
					if ($_REQUEST['act'] != 'chart') {
						if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
					?>
							<!-- show this text only when user review -->
							<li class="hidden hoverAnchor" id="notifyText">
                <a href="javascript:void(0);" style="color: #ffffff !important; background-color: #C0392B !important;"><?php echo ucwords('click here for play mode'); ?></a>
              </li>
							<li class="hoverAnchor">
								<a href="<?php echo site_root . "selectgame.php"; ?>" class="">
								<i class="glyphicon glyphicon-home"></i> &nbsp;
								Welcome <?php echo ucfirst(strtolower($_SESSION['username'])); ?></a>
              </li>
							<li class="hoverAnchor" id="showGuide">
                <a href="#">Guide</a>
              </li>
							<li class="hoverAnchor">
                <a href="<?php echo site_root . "logout.php?q=Logout"; ?>" class="">Logout</a>
              </li>
						<?php } else { ?>

							<?php if (site_root == "http://live.corpsim.in/") { ?>
								<li class="hoverAnchor hidden">
								<?php } else if (site_root == "http://develop.corpsim.in/") { ?>
								<li class="hoverAnchor">
								<?php } else if (site_root == "http://localhost/corp_simulation/") { ?>
								<li class="hoverAnchor">
								<?php } else { ?>
								<li class="hoverAnchor hidden">
								<?php } ?>
								<a href="<?php echo site_root . "registration.php"; ?>" class="">Register</a></li>
								<!-- <li>
								<div>
									<button name="login" value="login" class="btn btn-lg btn-primary  pull-right register" style="margin-right: -10%; padding: 6px 12px;" onclick="window.location='registration.php'">Register</button>
								</div>
							</li> -->
						<?php }
					} ?>
						<?php
						$allowedDonmain = ['http://localhost/corp_simulation/', 'http://develop.corpsim.in/'];
						if (in_array(site_root, $allowedDonmain)) { ?>
							<li class="" id="google_translate_element"></li>
						<?php } else {
							echo '<script>$(document).on("contextmenu", function() {
								return false;
							});</script>';
						} ?>
				</ul>
			</div>
		</nav>
	</header>
	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'en'
			}, 'google_translate_element');
		}

		// on language change set the default language for user
		setTimeout(function() {
			$('select.goog-te-combo').on('change', function() {
				console.log($(this).val());
			});
			// $('.skiptranslate').css({'display':'none'});
			// $(".goog-logo-link").parent().remove();
			// $(".goog-te-gadget").html(
			// 	$(".goog-te-gadget").html().replace('Powered by ', '')
			// 	);
		}, 1000);
	</script>
	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
			showImageModal();
			// countInclick   = 0;
			// countOutclick  = 0;
			// animateInArray = ['bounceIn', 'bounceInDown', 'bounceInLeft', 'bounceInRight', 'bounceInUp', 'flipInX', 'flipInY', 'fadeIn', 'fadeInDown', 'fadeInDownBig', 'fadeInLeft', 'fadeInLeftBig', 'fadeInRight', 'fadeInRightBig', 'fadeInUp', 'fadeInUpBig', 'rotateIn', 'rotateInDownLeft', 'rotateInDownRight', 'rotateInUpLeft', 'rotateInUpRight', 'slideInUp', 'slideInDown', 'slideInLeft', 'slideInRight', 'zoomIn', 'zoomInDown', 'zoomInLeft', 'zoomInRight', 'zoomInUp', 'lightSpeedIn', 'bounce', 'flash', 'pulse', 'rubberBand', 'shake', 'swing', 'tada', 'wobble', 'jello', 'heartBeat', 'flip', 'hinge', 'jackInTheBox', 'rollIn'];

			// animateOutArray = ['bounceOut', 'bounceOutDown', 'bounceOutLeft', 'bounceOutRight', 'bounceOutUp', 'flipOutX', 'flipOutY', 'fadeOut', 'fadeOutDown', 'fadeOutDownBig', 'fadeOutLeft', 'fadeOutLeftBig', 'fadeOutRight', 'fadeOutRightBig', 'fadeOutUp', 'fadeOutUpBig', 'rotateOut', 'rotateOutDownLeft', 'rotateOutDownRight', 'rotateOutUpLeft', 'rotateOutUpRight', 'slideOutUp', 'slideOutDown', 'slideOutLeft', 'slideOutRight', 'zoomOut', 'zoomOutDown', 'zoomOutLeft', 'zoomOutRight', 'zoomOutUp', 'lightSpeedOut', 'rollOut'];
		});

		function showImageModal() {
			$('marquee').each(function() {
				$(this).on('mouseover', function() {
					this.stop();
				});
				$(this).on('mouseout', function() {
					this.start();
				});
			});

			$('.showImageModal').each(function() {
				$(this).on('click', function() {
					$('#imageModal').show();
					$('#showImageHere').attr('src', $(this).attr('src'));
				});
			});
			$('#close').on('click', function() {
				// $('#imageModal').hide('slow');
				$('#imageModal').slideUp(1000);
			});
		}
	</script>