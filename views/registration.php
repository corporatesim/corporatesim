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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/flip.css">
  <link rel="stylesheet" href="css/overlaycss.css">
  
  <link rel="shortcut icon" type="image/x-icon" href="images/faviconnew.ico">
  
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300,500,700' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700" rel="stylesheet"> 
  <script src="js/jquery.min.js"></script>  
  <script src="js/bootstrap.min.js"></script>   

  <title>Registration</title>
</head>

<!--  overlay div -->
<div id="myNav" class="overlay">
  <a href="javascript:void(0)" class="closebtn" id="closeOverlay">&times;</a>

  <div class="main_div"  style="" class="col-md-offset-4">

    <div class="row col-md-12 game_row" style="margin-top:-10px;" >
      <div class="col-md-6 name game_name" style="margin-left:15px;">Game Name:</div>
      <div class="col-md-6 game_div" style="color:#ffffff;margin-top:70px; margin-left:-15px ;" id="putGameName">
        <!-- put value here -->
      </div>
    </div>

    <div class="row col-md-12" style="margin-top:-40px; margin-right:40px;">
      <div class="col-md-6 name" style="">Short Description:</div>
      <div class="col-md-6 short_div" style="color:#ffffff;margin-top:70px;" id="putShortDescription">
        <!-- put value here -->
      </div>
    </div>

    <div class="row col-md-12" style="margin-top:-40px; margin-right:40px;">
      <div class="col-md-6 name" style="">
        Long Description:
      </div>
      <div class="col-md-6 long_div" style="color:#ffffff;margin-top:70px;" id="putLongDescription">
        <!-- put value here -->
      </div>
    </div>

    <div class="row col-md-12" style="margin-top:-40px; ">
      <div class="col-md name price" style="margin-left:-565px;">Price:</div>
      <div class="col-md-6 price_div" style="color:#ffffff; margin-left:285px; margin-top:70px;" id="putPrice">
        <!-- put value here -->
      </div>
    </div>

    <button class="col-md-4 col-md-offset-4 btn" style="background-color:#A93937; color:#ffffff;padding:6px; font-size:22px;border-radius: 5px;  margin-top:50px;" id="registerButton" name="submit" value="Enroll" disabled=""> Register
    </button>

  </div>
</div>


<body background="images/bg3.jpg">
  <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- add image logo here -->
        <div class="navbar-header">
          <?php if(isset($_SESSION['logo'])) { ?>
            <a href="<?php echo site_root;?>"><img src="<?php echo site_root."enterprise/common/Logo/".$_SESSION['logo'];?>" width="40px" height="40px" /></a>

          <?php } else { ?>
            <a href="<?php echo site_root;?>"><img src="<?php echo site_root."images/logo-main.png";?>"  width="40px" /></a>
          <?php } ?>
        </div>
        <!-- end of adding image logo here -->
        <ul class="nav navbar-nav navbar-right">
          <?php 
          if($_REQUEST['act']!='chart')
          {
            if(isset($_SESSION['username']) && !empty($_SESSION['username'])){ 
              ?>
              <li class="hoverAnchor"><a href="<?php echo site_root."selectgame.php";?>" class="btn btn-primary">Welcome <?php echo ucfirst(strtolower($_SESSION['username'])); ?></a></li>
              <li class="hoverAnchor"><a href="<?php echo site_root."logout.php?q=Logout";?>" class="btn btn-primary">Logout</a></li>
            <?php }else{ ?>
              <li class="hoverAnchor"><a href="<?php echo site_root."login.php";?>" class="btn btn-primary">Login</a></li>
              <!-- <li>
                <div>
                  <button name="login" value="login" class="btn btn-lg btn-primary  pull-right register" style="margin-right: -10%; padding: 6px 12px;" onclick="window.location='registration.php'">Register</button>
                </div>
              </li> -->
            <?php } }?>
          </ul>
        </div>
      </nav>

  <div class="container" style="margin-top:15px;">

    <h1 style="text-align: center; color: white; margin-top: 50px; font-family: 'Poiret One', cursive; margin-left: 25px; ">Our Games</h1>

    <?php 
    while ($resultObj = $sqlObj->fetch_object()) {

     $Game_prise    = $resultObj->Game_prise;
     $Game_discount = $resultObj->Game_discount;
     $totalprize    = $Game_prise-$Game_discount;
     ?>
     <!-- <?php // echo "<pre>"; print_r($resultObj); echo "</pre>"; ?> -->
     <form method="post" action="">

      <input type="hidden" id="gameId_<?php echo $resultObj->Game_ID;?>" name="gameId" value="<?php echo $resultObj->Game_ID;?>">
      <input type="hidden" id="gameName_<?php echo $resultObj->Game_ID;?>" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
      <input type="hidden" id="Description_<?php echo $resultObj->Game_ID;?>" name="Description" value='"<?php echo $resultObj->Game_Comments;?>"'>
      <input type="hidden" id="Game_prise_<?php echo $resultObj->Game_ID;?>" value="<?php echo $Game_prise; ?>">
      <input type="hidden" id="Game_discount_<?php echo $resultObj->Game_ID;?>" value="<?php echo $Game_discount; ?>">
      <input type="hidden" id="totalprize_<?php echo $resultObj->Game_ID;?>" value="<?php echo $totalprize; ?>">
      <input type="hidden" id="Game_shortDescription<?php echo $resultObj->Game_ID;?>" value="<?php echo $resultObj->Game_shortDescription; ?>">
      <input type="hidden" id="Game_longDescription<?php echo $resultObj->Game_ID;?>" value="<?php echo $resultObj->Game_longDescription; ?>">
      <div class="col-md-3 col-md-4 col-sm-6 col-xs-12">
        <div style="background:none; height:400px !important;" class="card card-flip h-100">
          <div class="card-front text-white" style="background-color: #263238;" >
            <div class="card-body">
             <h3 style="height:70px;"  class="card-title text-center"><?php echo $resultObj->Game_Name; ?></h3>
             <img class="cardimg" src="images/<?php echo ($resultObj->Game_Image)?$resultObj->Game_Image:'Game2.jpg';?>" style="width:255px; height:150px; "><br><br>
             <div style="height:70px; text-align: center; color: #ffffff">
               <!-- <a style="margin-left:90px; color:#ffffff !important;" href="#" class="text-center"><?php echo strip_tags($resultObj->Game_Comments);?></a> -->
               <?php echo strip_tags($resultObj->Game_Comments); ?>
             </div>
             <!-- <a style="margin-left:90px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
             <button type="button" class="btn btn-danger openOverlay" data-gameid="<?php echo $resultObj->Game_ID;?>" id="openOverlay_<?php echo $resultObj->Game_ID;?>" style="margin-left:90px; color:#ffffff !important;" disabled="">Register</button>
           </div>
         </div>
         <div class="card-back bg-primary" style="width:255px; height:390px !important; background-color: #263238;">
          <div class="card-body">
            <h3 class="card-title text-center">Know More</h3>
            <p class="card-text text-center"><?php echo strip_tags($resultObj->Game_Message);?></p>

            <div style="height:70px;">
              <b><a style="margin-left:70px; color:#ffffff !important;" href="#" class="text-center"><?php echo strip_tags($resultObj->Game_Comments);?></a></b></div>

              <!-- <a style="margin-left:90px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
              <button type="button" data-gameid="<?php echo $resultObj->Game_ID;?>" class="btn btn-danger openOverlay" id="openOverlay_<?php echo $resultObj->Game_ID;?>" style="margin-left:90px; margin-top:220px; color:#ffffff !important;" disabled="">Register</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  <?php }?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- <script src="js/jquery-3.3.1.slim.min.js"></script> -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
 $(document).ready(function(){
  $(".openOverlay").each(function(){
    $(this).on('click', function(){
      var gameid = $(this).data('gameid');
      // $('#gameId_').val();
      var gameName              = $('#gameName_'+gameid).val();
      var Description           = $('#Description_'+gameid).val();
      var Game_prise            = $('#Game_prise_'+gameid).val();
      var Game_discount         = $('#Game_discount_'+gameid).val();
      var totalprize            = $('#totalprize_'+gameid).val();
      var Game_shortDescription = $('#Game_shortDescription'+gameid).val();
      var Game_longDescription  = $('#Game_longDescription'+gameid).val();
      // take the details of above fields put it below
      $('#putGameName').text(gameName);
      $('#putShortDescription').text(Game_shortDescription);
      $('#putLongDescription').text(Game_longDescription);
      $('#putPrice').text(totalprize);
      
      $("#myNav").css("display", "block");

      $("#registerButton").click(function(){
        window.location.href = "user_registration.php?ID="+gameid;
      });
    });
  });

  $("#closeOverlay").click(function(){
    $("#myNav").css("display", "none");
  });
});
</script>
</body>
</html>
