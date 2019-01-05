<?php 
// include_once 'includes/header.php'; 
?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/LandingStyle.css">

  <title>Landing Page</title>
</head>
<body background="images/bg2.jpg">
  <nav class="navbar navbar-fixed-top" style="background: #ffffff; border-color: #000000;">
    <div class="container">
      <div class="navbar-header">
        <!--<a class="navbar-brand logo" href="#">Logo</a>-->
        <!--a style="padding: 2px 15px;" class="navbar-brand" href="http://localhost/corp_simulation/index.php"--> 
        <img src="<?php echo site_root;?>images/logo-main.png" width="40px" style="margin-top: 2px;">
        <!--/a-->
      </div>
      <div>
        <button name="login" value="login" class="btn btn-lg btn-primary  pull-right" style="margin-top: 2px; margin-right: -4%;" onclick="window.location='login.php'">Login</button>
      </div>
    </div>
  </nav>
  <div class="container-fluid">

    <h1 style="text-align: center; color: white; margin-top: 15px; font-family: 'Poiret One', cursive; margin-left: 25px;">Our Games</h1>

    <div class="row">

     <?php 
     while ($resultObj = $FunctionsObj->FetchObject($sqlObj)) { ?>
      <form method="post" action="">
        <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultObj->Game_ID;?>">
        <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
        <input type="hidden" id="Description" name="Description" value='"<?php echo $resultObj->Game_Comments;?>"'>
        <div class="col-md-4 col-sm-6 col-xs-12 game-item red">
          <div class="games "><br>


            <h4 class="my-0 display-2 text-light  text-center font-weight-normal mb-3"><span class="h3"><?php echo $resultObj->Game_Name; ?></span></h4><br><br>
            <svg class='games-img' enable-background='new 0 0 300 100' height='100px' id='Layer_1' preserveAspectRatio='none' version='1.1' viewBox='0 0 300 100' width='300px' x='0px' xml:space='preserve' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns='http://www.w3.org/2000/svg' y='0px'>
              <path class='deco-layer deco-layer--1' d='M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729
              c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z' fill='#FFFFFF' opacity='0.6'></path>
              <path class='deco-layer deco-layer--2' d='M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729
              c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z' fill='#FFFFFF' opacity='0.6'></path>
              <path class='deco-layer deco-layer--3' d='M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716
              H42.401L43.415,98.342z' fill='#FFFFFF' opacity='0.7'></path>
              <path class='deco-layer deco-layer--4' d='M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428
              c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z' fill='#FFFFFF'></path>
            </svg>
          </div>
          <div class="card-body bg-white shadow" style="background:#ffffff;">
            <div class="para">
              <p style="text-align: center;">  <?php echo $resultObj->Game_Comments; ?></p></div><br>
              <button class="btn btn-lg btn-block  btn-custom " name= "submit" id="submit" value="Enroll">Register</button><br>
            </div><br>
          </div>
        </form>
      <?php }?>

    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
