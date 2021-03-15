<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?php echo site_root; ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo site_root; ?>css/errorstyle.css">
  <link rel="stylesheet" href="<?php echo site_root; ?>css/font-awesome.css">

  <title>Error</title>
</head>
<body background="<?php echo site_root; ?>images/hd.jpg">

  <div class="bg" style="text-align: center; color:#ffffff;">
    <img  src="<?php echo site_root; ?>images/close.png" alt="sorry" >
    <h1>Error!</h1>
    <p style="font-size:25px; font-style:italic;">
      <?php 
      if($error)
      {
        echo $error;
      }
      else
      {
        echo "You have already registered, and this game has already been taken with the same email.<br>Please use another email or game";
      }
      ?>
    </p>

    <div class="row">
      <button type="button" class="btn  btn-danger  btn-custom" name="back" id="back" value="back" onclick="location.href='registration.php'">Back</button>
    </div>

  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?php echo site_root; ?>js/jquery-3.3.1.slim.min.js"></script>
  <script src="<?php echo site_root; ?>js/popper.min.js"></script>
  <script src="<?php echo site_root; ?>js/bootstrap.min.js"></script>
</body>
</html>













