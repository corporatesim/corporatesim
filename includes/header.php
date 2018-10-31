<!doctype html>
<html>

<head>
	<title> Corporate Sim</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">  
	<link rel="stylesheet" href="css/inner_pages.css">  
	<link rel="shortcut icon" type="image/x-icon" href="images/faviconnew.ico">
	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300,500,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700" rel="stylesheet"> 
	<style>


	.dbl-spinner {
		margin: 20% 0 0 50%;
		position: absolute;
		width: 75px;
		height: 75px;
		border-radius: 50%;
		background-color: transparent;
		border: 4px solid transparent;
		border-top: 4px solid #222;
		border-left: 4px solid #222;
		-webkit-animation: 2s spin linear infinite;
		animation: 2s spin linear infinite;
	}

	.dbl-spinner:nth-child(2) {
		border: 4px solid transparent;
		border-right: 4px solid #03A9F4;
		border-bottom: 4px solid #03A9F4;
		-webkit-animation: 1s spin linear infinite;
		animation: 1s spin linear infinite;
	}

	@-webkit-keyframes spin {
		from {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@keyframes spin {
		from {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}


	/*css for overlay div*/
	.overlay {
		height: 100%;
		width: 100%;
		display: none;
		position: fixed;
		z-index: 1;
		top: 0;
		left: 0;
		background-color: rgb(0,0,0);
		background-color: rgba(0,0,0, 0.9);
	}

	.overlay-content {
		position: relative;
		top: 25%;
		width: 100%;
		text-align: center;
		margin-top: 30px;
	}

	.overlay span {
		padding: 8px;
		text-decoration: none;
		font-size: 36px;
		color: #818181;
		display: block;
		transition: 0.3s;
	}

	.overlay span:hover, .overlay span:focus {
		color: #f1f1f1;
	}

	.overlay .closebtn {
		position: absolute;
		top: 20px;
		right: 45px;
		font-size: 60px;
	}

	@media screen and (max-height: 450px) {
		.overlay span {font-size: 20px}
		.overlay .closebtn {
			font-size: 40px;
			top: 15px;
			right: 35px;
		}
	}
</style>
</head>
<body>	
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
	<header>	
		<nav class="navbar navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<!--<a class="navbar-brand logo" href="#">Logo</a>-->
					<!--a style="padding: 2px 15px;" class="navbar-brand" href="<?php echo site_root."index.php";?>"--> 
					<img src="<?php echo site_root."images/logo-main.png";?>"  width="40px" />
					<!--/a-->
				</div>
				<ul class="nav navbar-nav navbar-right headerNav">
					<?php 
					if($_REQUEST['act']!='chart')
					{

						if(isset($_SESSION['username']) && !empty($_SESSION['username'])){ 
							?>


							<li><a href="<?php echo site_root."selectgame.php";?>">Welcome <?php echo ucfirst(strtolower($_SESSION['username'])); ?></a></li>						
							<li>
								<a class="" href="<?php echo site_root."logout.php?q=Logout";?>">Logout</a>
							</li>
						<?php }else{ ?>
							<li>
								<a href="<?php echo site_root;?>login.php">
									Login
								</a>
							</li>
						<?php } }?>
						<li>&nbsp; &nbsp;&nbsp;</li>
						<!--li><img src="<?php echo site_root."images/logo-ksom.png";?>" style="margin-top:-3%"  /></li-->
					</ul>
				</div>
			</nav>
		</header>	

