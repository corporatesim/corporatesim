<!doctype html>
<html>

<head>
	<title> Corporate Sim</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/selectgame.css">  

	<link rel="stylesheet" href="css/inner_pages.css">  
	<link rel="stylesheet" href="css/style.css">  
	<link rel="shortcut icon" type="image/x-icon" href="images/faviconnew.ico">
	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300,500,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700" rel="stylesheet"> 
	<script src="js/jquery.min.js"></script>	
	<script src="js/bootstrap.min.js"></script>		
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
		<div class="dbl-spinner"></div>
		<div class="dbl-spinner"></div> 
		<div class="overlay-content">
			<span>Please Wait...</span>
		</div>
		<!-- <div style="margin: 20% 0 0 50%;">Please Wait...</div> -->
	</div>
	<!-- end of adding loader -->
	<header>	
		<nav class="navbar1 navbar-fixed-top">
			<div class="container">
				<div class="navbar-header1">
					<!--<a class="navbar-brand logo" href="#">Logo</a>-->
					<!--a style="padding: 2px 15px;" class="navbar-brand" href="<?php echo site_root."index.php";?>"--> 
					<img src="<?php echo site_root."images/logo-main.png";?>"  width="40px" />
					<!--/a-->
				</div>
				<ul class="nav navbar-nav navbar-right headerNav" id="nav">
					<?php 
					if($_REQUEST['act']!='chart')
					{

						if(isset($_SESSION['username']) && !empty($_SESSION['username'])){ 
							?>

							<li class="hover" style="margin-top:-35px;"><a class="welcome btn btn-lg btn-primary pull-right" style="margin-right: 0%; padding: 6px 12px; color:#ffffff"  href="<?php echo site_root."selectgame.php";?>">Welcome <?php echo ucfirst(strtolower($_SESSION['username'])); ?></a></li>						
							<li class="hover" style="margin-top:-35px;">
								<a class="logout btn btn-lg btn-primary  pull-right" style="margin-right: -250%; padding: 6px 12px; color:#FFFFFF" href="<?php echo site_root."logout.php?q=Logout";?>">Logout</a>
							</li>
						<?php }else{ ?>
							<!-- <li>
								<a href="<?php echo site_root;?>login.php">
									Login
								</a>
							</li> -->
							<li>
								<div>
									<button name="login" value="login" class="btn btn-lg btn-primary  pull-right register" style="margin-right: -10%; padding: 6px 12px;" onclick="window.location='registration.php'">Register</button>
								</div>
							</li>
						<?php } }?>
						<li>&nbsp; &nbsp;&nbsp;</li>
						<!--li><img src="<?php echo site_root."images/logo-ksom.png";?>" style="margin-top:-3%"  /></li-->
					</ul>
				</div>
			</nav>
		</header>	
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