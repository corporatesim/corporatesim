<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_root;?>images/faviconnew.ico">

	<title>Simulation Game - Admin Login</title>

	<!-- Bootstrap Core CSS -->
	<link href="<?php echo site_root; ?>assets/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="<?php echo site_root; ?>assets/components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="<?php echo site_root; ?>assets/dist/css/sb-admin-2.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="<?php echo site_root; ?>assets/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<?php
$bodyArray  = array('mksahu', 'localhost', 'develop.corpsim.in');
$colorArray = array('mksahu', 'rgba(217, 83, 79, 1)', 'rgba(51, 122, 183, 1)');
$bgcolor    = array_search($_SERVER['HTTP_HOST'],$bodyArray);
if($bgcolor)
{
	$bgcolor = "style='background:".$colorArray[$bgcolor].";'";
}
else
{
	$bgcolor = '';
}
// echo $_SERVER['HTTP_HOST']; var_dump(array_search($_SERVER['HTTP_HOST'],$bodyArray,true));
?>
<body <?php echo $bgcolor;?> >
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="login_hold" style="text-align:center; margin:10px auto">
						<img src="<?php echo site_root; ?>images/logo.png" >
					</div>
					<div class="panel-heading">
						<h3 class="panel-title text-center">Login</h3>
					</div>
					<div class="panel-body">
						<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<fieldset>
								<?php if(isset($msg)){echo "<div class=\"col-xs-12 text-center alert alert-danger\">".$msg."</div>";} ?>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password" required>
								</div>
								<div class="checkbox">
									<label>
										<input class="" name="remember" type="checkbox" value="Remember Me">Remember Me
									</label>
								</div>
								<input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btn-block" />
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?php echo site_root; ?>assets/components/jquery/dist/jquery.min.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="<?php echo site_root; ?>assets/components/bootstrap/dist/js/bootstrap.min.js"></script>

	<!-- Metis Menu Plugin JavaScript -->
	<script src="<?php echo site_root; ?>assets/components/metisMenu/dist/metisMenu.min.js"></script>

	<!-- Custom Theme JavaScript -->
	<script src="<?php echo site_root; ?>assets/dist/js/sb-admin-2.js"></script>

</body>
</html>
