<?php 
include_once 'includes/header.php'; 
?>
<section id="video_player">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 no_padding scenario_name scenario_header"><h2 class="InnerPageHeader">End of Game</h2></div>
			<div class="clearfix"></div>
			<div class="col-sm-12 no_padding ">
				<div class="shadow col-sm-12">
					<div class="col-sm-10 col-sm-offset-1 mssgeforUser">
						<!--Message for User... -->
						<?php echo $gamedetails->Game_Message; ?>
					</div>
					<div class="col-sm-10 col-sm-offset-1 text-right">
						View Game Report <img src="images/reportIcon.png" alt="Report">
						<?php 
						// echo "<pre>"; print_r($result1); echo "</pre>";
						// finding user company id if it is 21 then allow replay $result1->US_UserID
						$compSql        = "SELECT User_companyid FROM GAME_SITE_USERS WHERE User_companyid = '21' AND User_id=".$result1->US_UserID;
						$compObj        = $functionsObj->ExecuteQuery($compSql);
						$replaySql      = "SELECT UG_ReplayCount FROM GAME_USERGAMES WHERE UG_GameID = ".$gameid." AND UG_UserID=".$result1->US_UserID;
						$replayObj      = $functionsObj->ExecuteQuery($replaySql);
						$UG_ReplayCount = $functionsObj->FetchObject($replayObj);

						if(($compObj->num_rows > 0) || ($UG_ReplayCount->UG_ReplayCount == '-1') || ($UG_ReplayCount->UG_ReplayCount > 0))
						{
							$allowReplay = true;
						}
						else
						{
							$allowReplay = false;
						}
						if($result1->US_ReplayStatus == 1 || $allowReplay)
						{
							$urlstr .= "<a id='restart' href='#' data-gameid='".$gameid."' data-scenid='".$ScenID."' data-linkid='".$linkid."' class='restart'><img src='images/restartGameIcon.png' alt='ReStart/Resume Game'></a>";
							echo $urlstr;
						}
						?>						
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-12">
						<hr></hr>
					</div>	
					<div class="col-sm-10 col-sm-offset-1 ">
						<h4 class="innerh4">Other Unplayed Game</h4>
					</div>	
					<div class="col-sm-10 col-sm-offset-1 no_padding" style="padding-bottom:20px;">	
						<?php 
							//echo $str;
						if(count($strgames) > 0)
						{
							foreach($strgames as $y=>$y_value) 
							{ 
								//if exists in user_status with result =1
								//echo $y ."--".$y_value;
								if(!empty($y_value))
								{
									$sqlquery="SELECT US_Gameid FROM `GAME_USERSTATUS` WHERE US_LinkID>0 AND US_UserID=".$userid." and US_GameID=".$y_value;
									//echo $sqlquery;
									$result1 = $functionsObj->ExecuteQuery($sqlquery);
									if($result1->num_rows > 0){
									}
									else
									{
										$sql="SELECT
										  *
										FROM
										`GAME_USERGAMES` UG
										INNER JOIN
										GAME_GAME G ON UG.`UG_GameID` = G.Game_ID
										WHERE
										G.Game_Status = 1 and G.Game_ID =".$y_value." AND G.Game_Delete = 0 AND UG.`UG_UserID` = ".$userid;
										//echo $sql;
										// exit();
										$result = $functionsObj->ExecuteQuery($sql);
										while($row = mysqli_fetch_array($result)) 
										{
											echo "<div class='col-sm-12'>";
											echo "<div class='col-sm-12 no_padding StartGameStrip'></div>";
											echo "<div class='col-sm-12 shadow'>";
											echo "<input type='hidden' name='id' value='{$row['Game_ID']}'>";					
											echo "<div class='col-sm-2  col-xs-2 regular no_padding '>";
											echo $row['Game_Name'];
											echo "</div><div class=' col-md-8 col-xs8 light'>";
											echo $row['Game_Comments'];
											echo "</div><div class='col-sm-2 col-xs-2 regular no_padding  text-right'>";
											//check status of user for this game
											//if record exist for Userid and GameID in Game_Userstatus
											$where = array (
												"US_GameID = " . $row['Game_ID'],
												"US_UserID = " . $userid
											);
											$obj = $functionsObj->SelectData ( array (), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0 );
											if ($obj->num_rows > 0)
											{							
												$result1 = $functionsObj->FetchObject ( $obj );
												//print_r($result1);
												if ($result1->US_LinkID == 0)
												{
													//get linkid
													$sqllink = "SELECT * FROM `GAME_LINKAGE` WHERE `Link_GameID`=".$row['Game_ID']." AND Link_ScenarioID= ".$result1->US_ScenID;
													//echo $sqllink;
													$link       = $functionsObj->ExecuteQuery($sqllink);
													$resultlink = $functionsObj->FetchObject($link);
													$linkid     = $resultlink->Link_ID;
												//echo $linkid;
													if ($result1->US_Input == 0 && $result1->US_Output == 0 )
													{							
														if($link->num_rows > 0){									
															$url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;
															//echo $url;
														}
														//exit();
														//scenario_description.php?Link=".$result->Link_ID;
														echo "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
													}
													elseif($result1->US_Input == 1 && $result1->US_Output == 0 )
													{
														//goto Input page
														$url = site_root."input.php?ID=".$row['Game_ID'];
														echo "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
													}
													else
													{
														$url = site_root."output.php?ID=".$row['Game_ID'];
														echo "<a href='".$url."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
														//Goto next scenario
													}
												}
												else{
													//result
													$url = site_root."result.php?ID=".$row['Game_ID'];
													echo "<a href='".$url."'><img src='images/reportIcon.png' alt='Start/Resume Game' class=''></a>";
												}
											}
											else
											{
												echo "<a href='game_description.php?Game=".$row['Game_ID']."'><img src='images/startGameIcon.png' alt='Start/Resume Game' class=''></a>";
											}					
											echo "</div><div class='clearfix'></div></div></div>";
										}
									}
								}
							} 
						} ?>
					</div>
				</div><!--shadow-->
				<div class="clearfix"></div>
			</div>			
		</div><!--row-->
	</div><!--container---->
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
<?php include_once 'includes/footer.php' ?>
