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
<header>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<!-- add image logo here -->
				<div class="navbar-header" style="margin: 5px 0px 5px 0px;">
											<a href="http://localhost/corp_simulation/" id="homeLogo">
							<!-- <img src="http://localhost/corp_simulation/images/logo-main.png" width="40px"> -->
						</a>
									</div>
				<!-- end of adding image logo here -->
				<ul class="nav navbar-nav navbar-right">
												<!-- show this text only when user review -->
							<li class="hoverAnchor">
								<a href="http://localhost/corp_simulation/selectgame.php" class="">
								<i class="glyphicon glyphicon-home"></i> &nbsp;
								Welcome Mohituser</a>
              </li>
							<li class="hoverAnchor">
                <a href="<?php echo site_root; ?>/logout.php?q=Logout" class="">Logout</a>
              </li>
										</ul>
			</div>
		</nav>
	</header>
  <script>
    $(document).ready(function(){
      setTimeout(function(){
        // $('#homeLogo').html('<img src="http://localhost/corp_simulation/images/logo-main.png" width="40px">');
        $('#homeLogo').html('<div style="background-image:url(images/logo-main.png); background-position:center; background-repeat:no-repeat; width:70px; height:40px; border-radius:40px; background-size: 40px;"></div>');
      }, 100);
    });
  </script>