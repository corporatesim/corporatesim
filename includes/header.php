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
</head>
<body>	
		
	<header>	
		 <nav class="navbar navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <!--<a class="navbar-brand logo" href="#">Logo</a>-->
			   <!--a style="padding: 2px 15px;" class="navbar-brand" href="<?php echo site_root."index.php";?>"--> 
					<img src="<?php echo site_root."images/logo-main.png";?>"  height="60" />
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

