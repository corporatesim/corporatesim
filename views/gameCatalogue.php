<?php 
include_once 'includes/headerNav.php'; 
// require_once 'eLearning.php'; 
?>
<div class="row col-md-9" style="margin-left: 23%;">
  <div class="tab-content tabs tab-content1">
    <div role="tabpanel" class="tab-pane fade in active" id="intro">
      <div class="row">

        <div class="tab" role="tabpanel">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs tab2 row col-md-12 col-sm-6 col-xs-12" role="tablist" style="margin-top:1%;">
            <li role="presentation" class="row col-md-4 col-sm-12 col-xs-12 active simulation"><a href="#simulation" aria-controls="simulation" role="tab" data-toggle="tab" style="">Simulation</a></li>
            <li role="presentation" class="row col-md-4 col-sm-12 col-xs-12"><a href="#eLearning" aria-controls="eLearning" role="tab" data-toggle="tab" style="">eLearning</a></li>

            <li role="presentation" class="row col-md-4 col-sm-12 col-xs-12"><a href="#Assessment" aria-controls="Assessment" role="tab" data-toggle="tab" style=" ">Assessment</a></li>
          </ul>
          <div class="clearfix"></div>
          <!-- Tab panes -->
          <div class="tab-content tabs tab-content2">

            <div role="tabpanel" class="tab-pane fade in active" id="simulation">
              <div class="row">
                <div id="wowslider-container1">

                 <div class="row col-md-12">
                  <div class="col-md-2 pull-right">
                    <br>
                    <!-- <i class="glyphicon glyphicon-search icon pull-right"></i> -->
                    <input type="search" id="myFilter" class="form-control icon pull-right" onkeyup="searchGame();" placeholder="Search Simulation" style="width: 200px; border-radius: 18px;">
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row" id="simulationGames" style="margin-top:20px;">
                  <?php
                  while ($resultObj = mysqli_fetch_object($simulationGames)) { 
                    $image = ($resultObj->Game_Image)?$resultObj->Game_Image:'Game2.jpg';
                    ?>
                    <form method="post" action="">
                      <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultObj->Game_ID;?>">
                      <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
                      <input type="hidden" id="Description" name="Description" value='"<?php echo $resultObj->Game_Comments;?>"'>
                      <div class="col-md-4 col-xs-12 col-sm-6 col-lg-3 reduce_width" title="<?php echo $resultObj->Game_Name; ?>">
                        <div style="background:none; height:330px !important;" class="card card-flip h-100">
                          <div class="card-front text-white" style="background-color: #263238;" >
                            <div class="card-body">
                              <h3 style="height:70px;"  class="card-title text-center"><?php echo $resultObj->Game_Name;?></h3>
                              <img class="cardimg" src="<?php echo site_root.'images/'.$image;?>" style="width:100%; height:150px; margin-top:-15px"><br><br>
                              <div class="link" style="height:35px;margin-top: -8px;">
                                <!-- <a style="margin-left:80px; color:#ffffff !important;" href="#" class="text-center">How to Play</a> -->
                              </div>
                              <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a> -->
                              <button type="submit" style="margin-left:80px;margin-top:-5px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                            </div>
                          </div>
                          <div class="card-back bg-primary reduce_flipspeed" style="width:222px;height:320px; background-color: #263238;">
                            <div class="card-body">
                              <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3><br>
                              <p class="card-text text-center" style="margin-left:20px; margin-top:-10px;"><?php echo $resultObj->Game_Comments;?></p>
                              <a class="how-to" style="margin-left:50px; color:#ffffff !important;" href="#" class="text-center"></a>

                              <div  style="margin-top:180px; margin-top:110px;">
                               <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a>  -->
                               <button type="submit" style="margin-left:80px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </form>
                 <?php } ?>
               </div>
             </div>  
           </div>
         </div>

         <div role="tabpanel" class="tab-pane fade" id="eLearning">
          <div class="row">
            <div class="row col-md-12">
              <div class="col-md-2 pull-right">
                <br>
                <!-- <i class="glyphicon glyphicon-search icon pull-right"></i> -->
                <input type="search" id="myeLearning" class="form-control icon pull-right" onkeyup="searcheLearning();" placeholder="Search eLearning" style="width: 200px; border-radius: 18px;margin-bottom: 20px;">
              </div>
            </div>
            <div class="row" id="simulationElearning" style="margin-top:20px;">
              <?php

              while ($resultElearning = mysqli_fetch_object($simulationElearning)) { 

                $image = ($resultElearning->Game_Image)?$resultElearning->Game_Image:'Game2.jpg';
                ?>
                <form method="post" action="">
                  <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultElearning->Game_ID;?>">
                  <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultElearning->Game_Name; ?>"> 
                  <input type="hidden" id="Description" name="Description" value='"<?php echo $resultElearning->Game_Comments;?>"'>
                  <div class="col-md-4 col-xs-12 col-sm-6 col-lg-3 reduce_width" title="<?php echo $resultElearning->Game_Name; ?>">
                    <div style="background:none; height:330px !important;" class="card card-flip h-100">
                      <div class="card-front text-white" style="background-color: #263238;" >
                        <div class="card-body">
                          <h3 style="height:70px;"  class="card-title text-center"><?php echo $resultElearning->Game_Name;?></h3>
                          <img class="cardimg" src="<?php echo site_root.'images/'.$image;?>" style="width:100%; height:150px; margin-top:-20px"><br><br>
                          <div class="link" style="height:35px;margin-top: -8px;">
                            <!-- <a style="margin-left:80px; color:#ffffff !important;" href="#" class="text-center">How to Play</a> -->
                          </div>
                          <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a> -->
                          <button type="submit" style="margin-left:80px;margin-top:-2px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                        </div>
                      </div>
                      <div class="card-back bg-primary reduce_flipspeed" style="width:222px;height:320px; background-color: #263238;">
                        <div class="card-body">
                          <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3><br>
                          <p class="card-text text-center" style="margin-left:20px"><?php echo $resultElearning->Game_Comments;?></p>
                          <a class="how-to" style="margin-left:50px; color:#ffffff !important;" href="#" class="text-center"></a>

                          <div  style="margin-top:180px; margin-top:150px;">
                           <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a>  -->
                           <button type="submit" style="margin-left:80px;margin-top:-5px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
               </form>
             <?php } ?>
           </div>
         </div>
       </div>

       <div role="tabpanel" class="tab-pane fade" id="Assessment">
        <div class="row">
          <div class="row col-md-12">
            <div class="col-md-2 pull-right">
              <br>
              <!-- <i class="glyphicon glyphicon-search icon pull-right"></i> -->
              <input type="search" id="myAssessment" class="form-control icon pull-right" onkeyup="searchassessment();" placeholder="Search Assessment" style="width: 200px; border-radius: 18px; margin-bottom: 20px;">
            </div>
          </div>

          <div class="row" id="simulationAssesment" style="margin-top:20px;">
            <?php

            while ($resultAssesment = mysqli_fetch_object($simulationAssesment)) { 

              $image = ($resultAssesment->Game_Image)?$resultAssesment->Game_Image:'Game2.jpg';
              ?>
              <form method="post" action="">
                <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultAssesment->Game_ID;?>">
                <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultAssesment->Game_Name; ?>"> 
                <input type="hidden" id="Description" name="Description" value='"<?php echo $resultAssesment->Game_Comments;?>"'>

                <div class="col-md-4 col-xs-12 col-sm-6 col-lg-3 reduce_width" title="<?php echo $result->Game_Name; ?>">
                  <div style="background:none; height:330px !important;" class="card card-flip h-100">
                    <div class="card-front text-white" style="background-color: #263238;" >
                      <div class="card-body">
                        <h3 style="height:70px;"  class="card-title text-center"><?php echo $resultAssesment->Game_Name;?></h3>
                        <img class="cardimg" src="<?php echo site_root.'images/'.$image;?>" style="width:100%; height:150px; margin-top:-20px"><br><br>
                        <div class="link" style="height:35px;margin-top:-8px; ">
                          <!-- <a style="margin-left:80px; color:#ffffff !important;" href="#" class="text-center">How to Play</a> -->
                        </div>
                        <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a> -->
                        <button type="submit" style="margin-left:80px; margin-top: -1px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                      </div>
                    </div>
                    <div class="card-back bg-primary reduce_flipspeed" style="width:222px;height:320px; background-color: #263238;">
                      <div class="card-body">
                        <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3><br>
                        <p class="card-text text-center" style="margin-left:20px"><?php echo $resultAssesment->Game_Comments;?></p>
                        <a class="how-to" style="margin-left:50px; color:#ffffff !important;" href="#" class="text-center"></a>

                        <div  style="margin-top:180px; margin-top:150px;">
                         <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a>  -->
                         <button type="submit" style="margin-left:80px;margin-top: -5px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll" disabled="">Enroll</button>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </form>
           <?php } ?>
         </div>

       </div>
     </div>

   </div>
 </div>

</div>
</div>
</div>

<?php include_once 'includes/footer.php' ?>