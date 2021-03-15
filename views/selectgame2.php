<?php
include_once 'includes/header.php'; 
?>
    <div class="row" style="margin-top:50px;">
      <div class="col-md-9" style="margin-left:-10px;">
        <h1 style="text-align: center; margin-top: 20px; color:#ffffff;">Select a Game</h1>
        <div class="row">
          <div id="input_container" class="col-md-6 mb-3" style="margin-top:60px;">
            <input  type="text" id="myFilter" class="form-control icon" onkeyup="searchGame()" placeholder="Search for Games..">
          </div>
        </div>
        <div class="row" id="myItems" style="margin-top:20px;">
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">iRecruit</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>

                  <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6  col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">Sonees Dhonis</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px ; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6  col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">WoCa WoCa</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px ; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">Game Changer</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                  <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;" class="card-title text-center">iDeliver</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">Reuben's Lift</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 class="card-title text-center" style="margin-left:10px;">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>

                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">Survivors of Tumboutou</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px;"><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">Work-In-Progress</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-md-6 col-xs-12">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center">iCounsel</h3>
                  <img class="cardimg" src="images/Game2.jpg" style="width:315px; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <a class="icons" href="#" style="margin-left:50px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
              </div>
              <div class="card-back bg-primary" style="width:315px; height:410px; background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                   <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
                  <div class="myicons" style="margin-top:180px;">
                  <a class="icons" href="#" style="margin-left:40px;"><img src="Images/play1.png" style="width:120px; height:120px;"></a>
                  <a class="icons1" href="#"><img src="Images/replay1.png" style="width:60px; height:60px; color:#d10053;"></a>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      function searchGame() {
      	var input, filter, cards, cardContainer, h5, title, i;
        input         = document.getElementById("myFilter");
        filter        = input.value.toUpperCase();
        cardContainer = document.getElementById("myItems");
        cards         = cardContainer.getElementsByClassName("col-md-4");
      	for (i = 0; i < cards.length; i++) {
      		title = cards[i].querySelector(".card-body h3.card-title");
      		if (title.innerText.toUpperCase().indexOf(filter) > -1) {
      			cards[i].style.display = "";
      		} else {
      			cards[i].style.display = "none";
      		}
      	}
      }
    </script>
  </body>
  </html>