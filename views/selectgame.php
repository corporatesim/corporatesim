<?php 
include_once 'includes/header.php'; 
include_once 'includes/header2.php'; 
?>

				<div class="col-sm-10">
				<div class="col-sm-12"><h2 class="InnerPageHeader">Select a Game</h2></div>
				<?php
					//echo $result;

					while($row = mysqli_fetch_array($result)) {
												
						$gameid = $row['Game_ID'];
						$where = array (
							"US_GameID = " . $row['Game_ID'],
							"US_UserID = " . $uid
						);
						$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0 );
						$gamestrip = "StartGameStrip";
						if ($obj->num_rows > 0)
						{								
							$result1 = $functionsObj->FetchObject ( $obj );
							if ($result1->US_LinkID == 0)
							{						
								if($result1->US_ScenID == 0)
								{
									$urlstr = "<a href='game_description.php?Game=".$row['Game_ID']."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
								}
								else
								{
									//get linkid
									//	if scenario exists get last scenario
						
									$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$result1->US_ScenID;
							
									$link = $functionsObj->ExecuteQuery($sqllink);
									$resultlink = $functionsObj->FetchObject($link);
									
									if ($result1->US_Input == 0 && $result1->US_Output == 0 )
									{
										//$gamestrip = "PlayGameStrip";
										if($link->num_rows > 0){											
											$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;											
										}
										
										//		else
										//			goto scenario_description
										
										$urlstr =  "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
									}
									elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
									{
										//		if input is true
										//			goto input
										$gamestrip = "PlayGameStrip";
										
										$url = site_root."input.php?ID=".$row['Game_ID']; //get LinkId from Session value
										
										$urlstr = "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
									}
									else
									{		
										//		elseif output is true
										//			goto output
										$gamestrip = "PlayGameStrip";
										$url = site_root."output.php?ID=".$row['Game_ID'];
										$urlstr = "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";

									}
								}
							}
							else{
								$gamestrip = "EndGameStrip";
								//result
								
								$url = site_root."result.php?ID=".$row['Game_ID'];
								
								$urlstr = "<a href='".$url."'><img src='images/reportIcon.png' alt='Start/Resume Game' class=''></a>";
							}
						}
						else
						{
							$urlstr = "<a href='game_description.php?Game=".$row['Game_ID']."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
						}
						
						echo "<div class='col-sm-12'>";
						echo "<div class='col-sm-12 no_padding ".$gamestrip."'></div>";
						echo "<div class='col-sm-12 shadow' ";
						if ($gamestrip == 'EndGameStrip')
						{
							echo "style='background:#ECEFF1!important;'";
						}
						echo ">";
						echo "<input type='hidden' name='id' value='{$row['Game_ID']}'>";					
						echo "<div class='col-sm-2  col-xs-2 regular no_padding '>";
						echo $row['Game_Name'];
						echo "</div><div class=' col-md-8 col-xs8 light'>";
						echo $row['Game_Comments'];
						echo "</div><div class='col-sm-2 col-xs-2 regular no_padding  text-right'>";
						
						//check status of user for this game
						
						//if record exist for Userid and GameID in Game_Userstatus
						//Show the Start/Report button redirecting to that page
						echo $urlstr; 
						
						echo "</div><div class='clearfix'></div></div></div>";
					}
				?>
				</div>
			</div>
		</div>
	</section>	
	
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
	
	
</body>
</html>