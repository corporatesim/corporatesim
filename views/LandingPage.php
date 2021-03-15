
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">  
	<link rel="stylesheet" href="css/inner_pages.css">  
	<link rel="shortcut icon" type="image/x-icon" href="images/faviconnew.ico">
	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300,500,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="container">
		<div class="row">
			<?php
			while ($resultObj = $FunctionsObj->FetchObject($sqlObj)) { ?>
				<form method="post" action="">
					<input type="hidden" id="gameId" name="gameId" value="<?php echo $resultObj->Game_ID;?>">
					<input type="hidden" id="gameName" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
					<input type="hidden" id="Description" name="Description" value='"<?php echo $resultObj->Game_Comments;?>"'>
					<div class="col-md-4" style="border: 1px solid gray; margin: 5px; text-align: center;">
						<div class="row">
							<?php echo $resultObj->Game_ID; ?>
						</div>
						<div class="row">
							<?php echo $resultObj->Game_Name; ?>
						</div>
						<div class="row">
							<?php echo $resultObj->Game_Comments; ?>
						</div>
						<div class="row">
							<button name="submit" id="submit" value="Enroll" class="btn btn-success">Enroll</button>
						</div><br>
					</div>
				</form>
			<?php }	?>
		</div>
	</div>
</body>
</html>
<?php include 'includes/footer.php'; ?>


