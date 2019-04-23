<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 
?>
<div class="row" style="margin-top:50px;">
	<div class="col-md-9" style="margin-left:-10px;">
		<h1 style="text-align: center; margin-top: 20px; color:#ffffff;">Select Module</h1>
		<div class="row">
			<div id="input_container" class="col-md-6 mb-3" style="margin-top:60px;">
				<input  type="text" id="myFilter" class="form-control icon" onkeyup="searchGame()" placeholder="Search for Games..">
			</div>
		</div>
		<?php
      // echo "<pre>"; print_r($result->num_rows); exit;
		if($disable == 'disabled' || $result->num_rows < 1)	{ ?>
			<marquee behavior="alternate" direction="" onMouseOver="this.stop()" onMouseOut="this.start()" class="row">
				<div style="color:#a94442; background-color:#f2dede; border-color:#ebccd1; text-align:center; font-weight:bold;"><?php echo $game_status; ?></div>
			</marquee>
			<?php	die(); }	?>
			<!-- only if game assigned or enabled -->
			<div class="row" id="myItems" style="margin-top:20px;">
				<?php
				while($row = mysqli_fetch_assoc($result))
				{ 
					$row['Game_Image'] = ($row['Game_Image'])?$row['Game_Image']:'Game2.jpg';
					$gameid            = $row['Game_ID'];
					$where             = array (
						"US_GameID = " . $row['Game_ID'],
						"US_UserID = " . $uid
					);
					$obj       = $functionsObj->SelectData(array (),'GAME_USERSTATUS',$where,'US_CreateDate desc', '', '1', '', 0 );
					$gamestrip = "StartGameStrip";
					if ($obj->num_rows > 0)
					{		
        		// if there are more than 1 scen id for single users, check in future reference
						$result1 = $functionsObj->FetchObject ( $obj );
						$ScenID  = $result1->US_ScenID;
        		//echo $ScenID .'<br>';
						if ($result1->US_LinkID == 0)
						{						
							if($result1->US_ScenID == 0)
							{
								$returnUrl = "<a class='icons' href='game_description.php?Game=".$row['Game_ID']."' style='margin-left:40px;'><img src='images/play1.png' style='width:120px; height:120px;' alt='Start/Resume Game'></a>";
							}
							else
							{
        				//get linkid
        				//if scenario exists get last scenario
								$sqllink    = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$result1->US_ScenID;

								$link       = $functionsObj->ExecuteQuery($sqllink);
								$resultlink = $functionsObj->FetchObject($link);
								$linkid     = $resultlink->Link_ID;
        				// echo $linkid;

								if ($result1->US_Input == 0 && $result1->US_Output == 0 )
								{
        					//$gamestrip = "PlayGameStrip";
									if($link->num_rows > 0)
									{											
										$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;											
									}
        					//else
        					//goto scenario_description
									$returnUrl = "<a class='icons' href='".$url."' style='margin-left:40px;'><img src='images/play1.png' style='width:120px; height:120px;'></a>";
								}
								elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
								{
        					//if input is true
        					//goto input
									$gamestrip = "PlayGameStrip";
        					$url       = site_root."input.php?ID=".$row['Game_ID']; //get LinkId from Session value
        					$returnUrl = "<a class='icons' href='".$url."' style='margin-left:40px;'><img src='images/play1.png' style='width:120px; height:120px;'></a>";
        				}
        				else
        				{		
        					//elseif output is true
        					//goto output
        					$gamestrip = "PlayGameStrip";
        					$url       = site_root."output.php?ID=".$row['Game_ID'];
        					$returnUrl = "<a class='icons' href='".$url."' style='margin-left:40px;'><img src='images/play1.png' style='width:120px; height:120px;'></a>";
        				}
        				if($result1->US_ReplayStatus==1)
        				{
        					$returnUrl .= "<a class='icons1' id='restart' title='Replay will loose all your progress' href='javascript:void(0);' data-GameID='".$row['Game_ID']."' data-ScenID='".$ScenID."' data-LinkID='".$linkid."' style='margin-left:40px;'><img src='images/replay1.png' style='width:60px; height:60px; color:#d10053;'></a>";
        				}
        			}
        		}
        		else
        		{
             $sqllink    = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$result1->US_ScenID;
             $link       = $functionsObj->ExecuteQuery($sqllink);
             $resultlink = $functionsObj->FetchObject($link);
             $linkid     = $resultlink->Link_ID;
             $gamestrip  = "EndGameStrip";
							//result
             $url        = site_root."result.php?ID=".$row['Game_ID'];
             $returnUrl  = "<a class='icons' href='".$url."' style='margin-left:40px;'><img src='images/report.png' style='width:120px; height:120px;'></a>";
        			// echo "<pre>"; print_r($result1); echo "</pre>";
        			// finding user company id if it is 21 then allow replay $result1->US_UserID
             $compSql = "SELECT User_companyid FROM GAME_SITE_USERS WHERE User_companyid = '21' AND User_id=".$result1->US_UserID;
             $compObj = $functionsObj->ExecuteQuery($compSql);
             if($compObj->num_rows > 0)
             {
              $allowReplay = true;
            }
            else
            {
              $allowReplay = false;
            }
            if($result1->US_ReplayStatus==1 || $allowReplay)
            {
              $returnUrl .= "<a class='icons1' id='restart' href='javascript:void(0);' data-GameID='".$row['Game_ID']."' data-ScenID='".$ScenID."' data-LinkID='".$linkid."' style='margin-left:40px;'><img src='images/replay1.png' style='width:60px; height:60px; color:#d10053;'></a>";
            }
          }
        }
        else
        {
          $returnUrl = "<a class='icons' href='game_description.php?Game=".$row['Game_ID']."' style='margin-left:40px;'><img src='images/play1.png' style='width:120px; height:120px;'></a>";
        }
        ?>
        <div class="col-md-4 col-md-6 col-xs-12 reduce_width" title="<?php echo $row['Game_Name']; ?>">
          <div style="background:none; height:420px !important;" class="card card-flip h-100">
           <div class="card-front text-white" style="background-color: #263238;" >
            <div class="card-body">
             <h3 style="height:70px;"  class="card-title text-center"><?php echo $row['Game_Name'];?></h3>
             <img class="cardimg" src="<?php echo site_root.'images/'.$row['Game_Image']; ?>" style="width:100%; height:150px; ">
             <br><br>
             <div class="link" style="height:35px;">
              <a style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
            </div>
            <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
            <?php echo $returnUrl; ?>
          </div>
        </div>
        <div class="card-back bg-primary reduce_flipspeed" style="width:280px;height:410px; background-color: #263238;">
          <div class="card-body">
           <h3 style="margin-left:10px;" class="card-title text-center">Know More</h3>
           <p class="card-text text-center">Suprise this one has more more more more content on the back!</p>
           <a class="how-to" style="margin-left:120px; color:#ffffff !important;" href="#" class="text-center">How to Play</a>
           <!-- <a style="margin-left:120px;" href="javascript:void(0)" class="btn btn-danger">Register</a> -->
           <div style="margin-top:180px;">
            <?php echo $returnUrl; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
</div>
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
<script src="js/jquery.min.js"></script>	
<script src="js/bootstrap.min.js"></script>			
<script type="text/javascript">
 $(document).ready(function() {

  $('a#restart').on('click',function(e){
   e.preventDefault();
   var GameID = $(this).attr('data-GameID');
   var ScenID = $(this).attr('data-ScenID');
   var LinkID = $(this).attr('data-LinkID');
   var conf   = confirm('Press OK to confirm your wish to play this simulation again else press Cancel');
   if(conf == true)
   {
    $.ajax({
     url : "includes/ajax/ajax_replay.php",
     type: "POST",
     data: "action=replay&GameID="+GameID+'&ScenID='+ScenID+'&LinkID='+LinkID,
     beforeSend: function(){
      $('.overlay').show();
    },
    success:function(result)
    {
      if(result == 'redirect')
      {
  			// alert('Redirect User to input page');
       window.location = "<?php echo site_root.'selectgame.php'?>";
     }	
     else
     {
       $('.overlay').hide();
       alert('Connection Problem');
       console.log(result);
     }
   }
 });
  }
  else
  {
    return false;
  }
});	
});
</script>	
</body>
</html>