<?php 
include_once 'includes/headerNav.php'; 
// include_once 'includes/header2.php'; 
?>
<div class="row col-md-9" style="margin-left: 23%;">
  <!-- <h1 style="text-align: center; margin-top: 20px; color:#ffffff;">Select Module</h1> -->
  <div class="row col-md-12">
    <div class="col-md-2 pull-right">
      <br>
      <!-- <i class="glyphicon glyphicon-search icon pull-right"></i> -->
      <input type="search" id="myFilter" class="form-control icon pull-right" onkeyup="searchGame()" placeholder="Search Modules" style="width: 200px; border-radius: 18px;">
    </div>
  </div>
  <div class="clearfix"></div>
  <?php
    // echo "<pre>"; print_r($result->num_rows); exit;
  if($disable == 'disabled' || $result->num_rows < 1) { ?>
    <marquee behavior="alternate" direction="" onMouseOver="this.stop()" onMouseOut="this.start()" class="row">
      <div style="color:#a94442; background-color:#f2dede; border-color:#ebccd1; text-align:center; font-weight:bold;"><?php echo $game_status; ?></div>
    </marquee>
    <?php die(); }  ?>
    <!-- only if game assigned or enabled -->
    <div class="row" id="simulationGames" style="margin-top:20px;">
      <?php
      while($row = mysqli_fetch_assoc($result))
      { 
       $row['Game_Image'] = ($row['Game_Image'])?$row['Game_Image']:'Game2.jpg';
       $gameid            = $row['Game_ID'];
       $where             = array (
        "US_GameID = " . $row['Game_ID'],
        "US_UserID = " . $uid
      );
       $obj            = $functionsObj->SelectData(array (),'GAME_USERSTATUS',$where,'US_CreateDate desc', '', '1', '', 0 );
       $gamestrip      = "StartGameStrip";
       $whereSkipIntro = array(
        'Link_GameID = '.$gameid,
        'Link_Introduction=1',
        // 'Link_Description'  => 1,
      );
       // checking if introduction is skipped or not
       $skipIntroObj = $functionsObj->SelectData(array (),'GAME_LINKAGE',$whereSkipIntro,'Link_Order', '', '1', '', 0 );
       // echo "<pre>"; print_r($functionsObj->FetchObject ( $skipIntroObj )); exit();
       if ($obj->num_rows > 0 || $skipIntroObj->num_rows > 0)
       {
        // if there are more than 1 scen id for single users, check in future reference
        $resultSkipIntro = $functionsObj->FetchObject ( $skipIntroObj );
        $result1         = $functionsObj->FetchObject ( $obj );
        $ScenID          = $result1->US_ScenID;
        //echo $ScenID .'<br>';
        if ($result1->US_LinkID == 0)
        {
         if($result1->US_ScenID == 0 && $skipIntroObj->num_rows < 1)
         {
          $returnUrl = "<a class='icons' href='game_description.php?Game=".$row['Game_ID']."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;' alt='Start/Resume Game'></a>";
        }
        else
        {
          // get linkid
          // if scenario exists get last scenario
          $scenarioId = !empty($result1->US_ScenID)?$result1->US_ScenID:$resultSkipIntro->Link_ScenarioID;
          $sqllink    = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$scenarioId;

          $link       = $functionsObj->ExecuteQuery($sqllink);
          $resultlink = $functionsObj->FetchObject($link);
          $linkid     = $resultlink->Link_ID;
          // echo $linkid;

          if ($result1->US_Input == 0 && $result1->US_Output == 0 && $resultlink->Link_Description < 1)
          {
           if($link->num_rows > 0 && $resultlink->Link_Description < 1)
           {                      
            $url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;                     
          }
          // else
          // goto scenario_description
          $returnUrl = "<a class='icons' href='".$url."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
        }
        elseif(($result1->US_Input == 1 && $result1->US_Output == 0) || $resultlink->Link_Description > 0)
        {
          // if input is true
          // goto input
         $gamestrip = "PlayGameStrip";
         // get LinkId from Session value
         $url       = site_root."input.php?ID=".$row['Game_ID'];
         $returnUrl = "<a class='icons' href='".$url."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
       }
       else
       {   
        // elseif output is true
        // goto output
        $gamestrip = "PlayGameStrip";
        $url       = site_root."output.php?ID=".$row['Game_ID'];
        $returnUrl = "<a class='icons' href='".$url."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
      }
      if($result1->US_ReplayStatus==1)
      {
        $returnUrl .= "<a class='icons1 restart' id='restart' title='Replay will loose all your progress' href='javascript:void(0);' data-gameid='".$row['Game_ID']."' data-scenid='".$ScenID."' data-linkid='".$linkid."' style='margin-left:50px;'><img src='images/replay1.png' style='width:50px; height:50px; color:#d10053;'></a>";
      }
    }
  }
  else
  {
    // it means user has completed the game
    $sqllink    = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$result1->US_ScenID;
    $link       = $functionsObj->ExecuteQuery($sqllink);
    $resultlink = $functionsObj->FetchObject($link);
    $linkid     = $resultlink->Link_ID;
    $gamestrip  = "EndGameStrip";
            //result
    $url        = site_root."result.php?ID=".$row['Game_ID'];
    $returnUrl  = "<a class='icons' href='".$url."' style='margin-left:40px;'><img src='images/report.png' style='width:80px; height:80px;'></a>";
    // echo "<pre>"; print_r($result1); echo "</pre>";
    // finding user company id if it is 21 then allow replay $result1->US_UserID
    $compSql = "SELECT User_companyid FROM GAME_SITE_USERS WHERE User_companyid = '21' AND User_id=".$result1->US_UserID;
    $compObj = $functionsObj->ExecuteQuery($compSql);

    if(($compObj->num_rows > 0) || ($row->UG_ReplayCount == '-1') || ($row->UG_ReplayCount > 0))
    {
      $allowReplay = true;
    }
    else
    {
      $allowReplay = false;
    }
    if($result1->US_ReplayStatus==1 || $allowReplay)
    {
      $returnUrl .= "<a class='icons1 restart' id='restart' href='javascript:void(0);' data-gameid='".$row['Game_ID']."' data-scenid='".$ScenID."' data-linkid='".$linkid."' style='margin-left:58px;'><img src='images/replay1.png' style='width:50px; height:50px; color:#d10053;'></a>";
    }
  }
}
else
{
  // It means user playing first time, check for skip introduction/description
  // to complete div clickable..
  $url       =  site_root."game_description.php?Game=".$row['Game_ID'];
  $returnUrl = "<a class='icons' href='game_description.php?Game=".$row['Game_ID']."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
}
// echo date('d-m-Y h:i:s',strtotime($row['startDate'])).' '.date('d-m-Y h:i:s',strtotime($row['endDate'])).' '.$row['Game_ID'];die(' mksahu '.date('d-m-Y H:i:s'));
// check for user game start and end date
if((time() >= strtotime($row['startDate'])) && (time() <= strtotime($row['endDate'])))
{
  $url       =  site_root."game_description.php?Game=".$row['Game_ID'];
  $returnUrl = "<a class='icons' href='game_description.php?Game=".$row['Game_ID']."' style='margin-left:27px;'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
}
else
{
  $url       = "'return false;'";
  // generated error from above line to stop propogation
  $returnUrl = "<a class='icons notInDateRange' href='#' style='margin-left:27px;' data-startdate='".date('d-m-Y',strtotime($row['startDate']))."' data-enddate='".date('d-m-Y',strtotime($row['endDate']))."'><img src='images/play1.png' style='width:80px; height:80px;'></a>";
}
?>
<div class="col-md-4 col-xs-12 col-sm-6 col-lg-3 reduce_width" title="<?php echo $row['Game_Name']; ?>">
  <div style="background:none; height:320px !important;" class="card card-flip h-100">
    <div class="card-front text-white" style="background-color: #263238;" >
      <div class="card-body">
        <h3 style="height:70px;"  class="card-title text-center"><?php echo $row['Game_Name'];?></h3>
        <img class="cardimg" src="<?php echo site_root.'images/'.$row['Game_Image']; ?>" style="width:100%; height:150px; margin-top: -25px">
        <br><br>
        <div class="link" style="height:35px;margin-top:-10px;">
          <!-- <a style="margin-left:70px; color:#ffffff !important;" href="#" class="text-center">How to Play</a> -->
        </div>
        <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
        <div style="margin-top:-30px; margin-left: -35px;">
          <?php echo $returnUrl; ?>
        </div>
      </div>
    </div>
    <div class="card-back bg-primary reduce_flipspeed" onclick="window.location.href='<?php echo $url?>'" style="width:222px;height:310px; background-color: #263238;">
      <div class="card-body">
        <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
        <p class="card-text text-center" style="margin-left:20px"> <?php echo $row['Game_Comments'];?></p>
        <a class="how-to" style="margin-left:50px; color:#ffffff !important;" href="#" class="text-center"></a>
        <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
        <div style="margin-top:125px; margin-left: -35px;">
          <?php echo $returnUrl; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
</div>
</div>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <span> </span>
      </div>
    </div>
  </div>
</footer>
<?php include_once 'includes/footer.php' ?>
<script>
  $('.notInDateRange').each(function(){
    $(this).on('click',function(){
      var startdate = $(this).data('startdate');
      var enddate   = $(this).data('enddate');
      Swal.fire('You are allowed to play this simulation from '+startdate+' to '+enddate);
    });
  });
</script>