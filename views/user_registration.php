<!DOCTYPE html>
<html>
<head>
	<title>user registration form</title>
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
	<h2 class="text-center">User Registration </h2>
	<div class="container">
		<?php if(isset($msg)) {?> 
			<div class="text-white text-center bg-primary"><?php echo $msg;}?></div>
			<div class="card-body">
				<form method="post">
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="firstName">First name</label>
									<input type="text" id="firstName" name="firstName"class="form-control" placeholder="First name" required="required" autofocus="autofocus">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="lastName">Last name</label>
									<input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last name" required="required">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="email">Email address</label>
									<input type="email" id="email" name="email" class="form-control" placeholder="Email address" required="required">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="mobile">Username</label>
									<input type="text" id="username" name="username" class="form-control" placeholder="username" required="required">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="mobile">Mobile</label>
									<input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile " required="required">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-label-group">
									<label for="GameName">GameName</label>
									<input type="text" id="game" name="game" class="form-control" placeholder="GameName " required="required" readonly="readonly" value="<?php echo $run->Game_Name?>">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6" style="margin-top:20px;">
						<button class="btn btn-primary pull-right" name="submit" id="submit" value="submit"  style="width:100px;">Submit</button>
					</div>
					<div class="col-md-6" style="margin-top:20px;">
						<button class="btn btn-primary" name="back" id="back" value="back" style="width:100px;" onclick="location.href='LandingPage.php'">Back</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	</html>