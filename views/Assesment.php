<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
?>
<div class="row" style="margin-top:50px;">
  <div class="col-md-9" style="margin-left:-10px;">
    <h1 style="text-align: center; margin-top: 20px; color:#ffffff;">Select Assesment</h1>
    <div class="row">
      <div id="input_container" class="col-md-6 mb-3" style="margin-top:60px;">
        <input  type="text" id="myFilter" class="form-control icon" onkeyup="searchGame()" placeholder="Search for Games..">
      </div>
    </div>
    <div class="row" id="myItems" style="margin-top:20px;">
      <?php 
      while ($resultObj = $FunctionsObj->FetchObject($sqlObj)) { 
        $image = ($resultObj->Game_Image)?$resultObj->Game_Image:'Game2.jpg';
        ?>
        <form method="post" action="">
          <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultObj->Game_ID;?>">
          <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
          <input type="hidden" id="Description" name="Description" value='"<?php echo $resultObj->Game_Comments;?>"'>
          <div class="col-md-4 col-md-6 col-xs-12 reduce_width" title="<?php echo $resultObj->Game_Name; ?>">
            <div style="background:none; height:420px !important;" class="card card-flip h-100">
              <div class="card-front text-white" style="background-color: #263238;" >
                <div class="card-body">
                  <h3 style="height:70px;"  class="card-title text-center"><?php echo $resultObj->Game_Name;?></h3>
                  <img class="cardimg" src="<?php echo site_root.'images/'.$image;?>" style="width:100%; height:150px; "><br><br>
                  <div class="link" style="height:35px;">
                    <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
                  </div>
                  <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a> -->
                  <button type="submit" style="margin-left:120px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll">Enroll</button>
                </div>
              </div>
              <div class="card-back bg-primary reduce_flipspeed" style="width:280px;height:410px;background-color: #263238;">
                <div class="card-body">
                  <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
                  <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
                  <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>

                  <div  style="margin-top:180px;">
                   <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="enroll btn btn-danger">Enroll</a>  -->
                   <button type="submit" style="margin-left:120px;" class="enroll btn btn-danger" name= "submit" id="submit" value="Enroll">Enroll</button>
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
</body>
</html>

<?php include_once 'includes/footer.php'; ?>    
