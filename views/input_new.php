<?php 
include_once 'includes/header.php'; 
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.9.0/math.min.js"></script>-->
<script src="js/jquery.js"></script>
<!-- <script> -->
  <!-- // expcomp = new Array(); -->
  <!-- // expsubc = new Array(); -->
  <!-- expcomp = []; -->
  <!-- expsubc = []; -->
  <!-- </script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Chango">
  <style>
  .align_radio{
    margin-left: 5%;
  }
  .closeSave
  {
    width        :40px;
    margin-bottom: -7px; 
    display      :none; 
    cursor       :pointer;
    background   : #009aef;
  }
</style>
<section id="video_player">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-lg-6 pull-right">
        <div class="timer text-center col-sm-2 pull-right" id="timer">0:00</div>
      </div>
      <div class="col-sm-9 col-md-10 no_padding col-lg-6 pull-left">
        <h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> Decisions</h2>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <!-- <div class="col-sm-9 col-md-10 no_padding">
        <h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> Decisions</h2>
      </div> -->
      <!--<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->
      <?php //echo $_SESSION['date']; ?>
      <div class="clearfix"></div>
      <form method="POST" action="" id="game_frm" name="game_frm">
        <div class="col-sm-12 no_padding shadow">
          <div class="col-sm-6 ">
            <span style="margin-right:20px;"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">Game Description</a><i class="fa fa-window-restore" aria-hidden="true"></i>
            </span>
            <span style="margin-right:20px;"><a href="<?php echo $scenurl; ?>" target="_blank" class="innerPageLink">Scenario Description</a><i class="fa fa-window-restore" aria-hidden="true"></i></span>
            <a href="chart.php?act=chart&ID=<?=$gameid?>" target="_blank" class="innerPageLink hidden">Dashboard</a><i class="fa fa-window-restore" aria-hidden="true"></i>
          </div>
          <div class="col-sm-6  text-right" style="padding: 2px 2px 5px 0px;">
            <div id="input_loader" style="float:left; color:#2A8037;"></div>
            <button type="button" class="btn innerBtns" name="execute_input" id="execute_input">Execute</button>
            <button type="button" class="btn innerBtns" name="execute_input_2" id="execute_input_2">Execute 2</button>
            <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Submit</button>
            <!--<button class="btn innerBtns">Save</button>
              <button class="btn innerBtns">Submit</button>-->
            </div>
            <div class="col-sm-12">
              <hr style="margin: 5px 0;">
            </hr>
          </div>
          <!-- Nav tabs --> 
          <div class=" TabMain col-sm-12">
            <ul class="nav nav-tabs" role="tablist" id="navtabs" name="navtabs">
              <?php 
              $i          = 0;
              $activearea = '';
              $style_text = "style='background:#D3D3D3; color:#000000; font-weight:bolder;'";
              while($row = mysqli_fetch_array($area))
              {
                    //echo $row->Area_Name;
                    //if ($tab == $row['Area_Name'])
                    //echo "ShowHide = ".$row['ShowHide']."</br>";
                    //echo "countlnk = ".$row['countlnk']."</br>";
                if($row['ShowHide'] == $row['countlnk'] && $row['ShowHide']>0)
                {
                  $showhide = "style='display:none;'";
                }
                else
                {
                  $showhide = '';
                }
                  // writing this condition to change the background color and text color of game area
                if($row['TextColor'] || $row['BackgroundColor'])
                {
                  $showStyle = "style='background:".$row['BackgroundColor']."; color:".$row['TextColor']." !important;'";
                }
                else
                {
                  $showStyle = '';
                }
                
                if ($tab == 'NOTSET') 
                {
                  if($i == 0)
                  {
                    echo "<li role='presentation' class='active regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                    $activearea=$row['Area_Name'];

                  }
                  else
                  {
                    echo "<li role='presentation' class='regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  }

                  $i++;
                }
                else if ($tab == $row['Area_Name'])
                {
                  echo "<li role='presentation' class='active regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  $activearea=$row['Area_Name'];
                }
                else
                {
                  echo "<li role='presentation' class='regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                }
                
              }
              ?>
            </ul>
            <input type='hidden' id='active' name='active' value='<?php echo $activearea; ?>'>
            <!-- Tab panes -->
            <div class="tab-content">
              <?php
                //echo $area->num_rows;
              $area = $functionsObj->ExecuteQuery($sqlarea);
              $i    = 0;
                //echo "Area - ".$sqlarea;
              while($row = mysqli_fetch_array($area)) {
                $areaname = $row['Area_Name'];
                  //echo row['Area_Name'];
                if ($tab == 'NOTSET') 
                {
                  if($i == 0)
                  {
                    echo "<div role='tabpanel' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
                  }
                  else
                  {
                    echo "<div role='tabpanel' class='tab-pane' id='".$row['Area_Name']."Tab'>";
                  }
                  $i++;
                }
                else if ($tab == $row['Area_Name'])
                {
                  echo "<div role='tabpanel' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
                }
                else              
                {
                  echo "<div role='tabpanel' class='tab-pane' id='".$row['Area_Name']."Tab'>";
                }
                
                $sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, l.Link_Order as 'Order',  
                c.Comp_Name as Comp_Name, ls.SubLink_ChartID as ChartID, ls.SubLink_Details as Description, ls.SubLink_InputMode as Mode, 
                f.expression as exp , ls.SubLink_ID as SubLinkID,ls.Sublink_AdminCurrent as AdminCurrent, 
                ls.Sublink_AdminLast as AdminLast, ls.Sublink_ShowHide as ShowHide , ls.Sublink_Roundoff as RoundOff,
                ls.SubLink_LinkIDcarry as CarryLinkID, ls.SubLink_CompIDcarry as CarryCompID, 
                ls.SubLink_SubCompIDcarry as CarrySubCompID, g.Game_ID as GameID, l.Link_ScenarioID as ScenID, ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder, ls.SubLink_InputModeType as InputModeType, ls.SubLink_InputModeTypeValue as InputModeTypeValue
                FROM GAME_LINKAGE l 
                INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
                LEFT OUTER JOIN GAME_FORMULAS f on ls.SubLink_FormulaID=f.f_id 
                WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." 
                and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
                  //echo "Component - ".$sqlcomp;
                  //echo $userid;
                $component = $functionsObj->ExecuteQuery($sqlcomp);
                  //Get Component for this area for this linkid
                while($row1 = mysqli_fetch_array($component)){ 
                  if($row1['TextColor'] || $row1['BackgroundColor'])
                  {
                    $component_style = "style=";

                    if($row1['TextColor'])
                    {
                      $component_style .= "color:".$row1['TextColor'].";";
                    }

                    if($row1['BackgroundColor'])
                    {
                      $component_style .= "background:".$row1['BackgroundColor'].";";
                    }
                  }
                  else
                  {
                    $component_style = '';
                  }
                  ?>
                  <!-- main component div start here -->
                  <div class="col-sm-12 scenariaListingDiv <?php echo (($row1['ShowHide']==1)?'hidden':'');?>" <?php echo $component_style;?>>
                    <!-- component name div-->
                    <div class="col-sm-1 col-md-2 regular"><?php echo $row1['Comp_Name'];?></div>
                    <!-- component chart details/CK Editor div -->
                    <div class='col-sm-6 col-md-6 no_padding'>                
                      <?php 
                      if(empty($row1['ChartID']))
                      {
                        echo $row1['Description'];
                      }
                      else
                      {
                        $sqlchartComp           = "SELECT Chart_Type FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$row1['ChartID'];
                        $chartDetailscomp       = $functionsObj->ExecuteQuery($sqlchartComp);
                        $ResultchartDetailsComp = $functionsObj->FetchObject($chartDetailscomp);
                        $charttypeComp          = $ResultchartDetailsComp->Chart_Type; 
                        ?>  
                        <img src="chart/<?=$charttypeComp?>.php?gameid=<?=$gameid?>&userid=<?=$userid?>&ChartID=<?=$row1['ChartID']?>">
                      <?php } ?>
                    </div>
                    <?php
                    if ($row1['Mode']!="none") { ?>
                      <!-- input field div -->
                      <div class="col-sm-5 col-md-4 text-right">
                        <!-- label starts here -->
                        <div class='InlineBox'>
                          <!-- label first -->
                          <div class='InlineBox'>
                            <?php
                            if($row1['Mode']=="user" && $row1['InputModeType'] == "mChoice")
                            {
                              $hide_label = 'hidden';
                            }
                            else
                            {
                              $hide_label = '';
                            }
                            ?>
                            <label class="scenariaLabel <?php echo $hide_label;?>"><?php echo $row1['LabelCurrent'];?></label>
                            <input type='hidden' id="<?php echo $areaname.'_linkcomp_'.$row1['CompID'];?>" name="<?php echo $areaname.'_linkcomp_'.$row1['CompID'];?>" value="<?php echo $row1['SubLinkID'];?>"></input>
                            <?php
                        // getting the value here for input field
                            if($addedit=='Edit')
                            {
                              //if($data[$areaname."_comp_".$row1['CompID']]>=0)
                              if(isset($data[$areaname."_comp_".$row1['CompID']]) || (!empty($data[$areaname."_comp_".$row1['CompID']])))
                              { 
                               if($row1['RoundOff'] == 0)
                               {
                                $value = $data[$areaname."_comp_".$row1['CompID']];
                              }
                              else
                              {
                                $value = round($data[$areaname."_comp_".$row1['CompID']]);
                              }
                            }
                            elseif($row1['Mode']=="admin")
                            {
                              $value = $row1['AdminCurrent'];
                            }
                            elseif($row1['Mode']=="formula")
                            {
                              $value = 0;
                            }
                          }
                          elseif($row1['Mode']=="admin")
                          {
                            $value = $row1['AdminCurrent'];
                          }
                          elseif($row1['Mode']=="formula")
                          {
                            $value = 0;
                          }
                          elseif($row1['Mode']=="carry")
                          {
                        //get input value from link, comp, subcomp

                            $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` 
                            WHERE input_user=".$userid." AND input_sublinkid = 
                            (SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` 
                            WHERE SubLink_LinkID=".$row1['CarryLinkID']." and SubLink_CompID=".$row1['CarryCompID'];
                            if($row1['CarrySubCompID']>0)         
                            {
                             $sqlcurrent .=   " AND SubLink_SubCompID = ".$row1['CarrySubCompID'];
                           }          
                           $sqlcurrent .= ")";

                           $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                           $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                           $value           = $rescarry->input_current;
                         }

                         if($row1['Mode']=="formula") { 
                          $sankey_val1 = '"'.$areaname."_fcomp_".$row1['CompID'].'"';
                          ?>
                          <input type='hidden' id="<?php echo $areaname.'_expcomp_'.$row1['CompID']; ?>" name="<?php echo $areaname.'_expcomp_'.$row1['CompID']; ?>" value="<?php echo $row1['exp'];?>" class='json_expcomp'></input>
                          <input type="text" id="<?php echo $areaname.'_fcomp_'.$row1['CompID'];?>" name="<?php echo $areaname.'_fcomp_'.$row1['CompID'];?>" value="<?php echo $value;?>" class='scenariaInput current' onclick='return lookupCurrent(<?php echo $row1["SubLinkID"].",$sankey_val1";?> ,this.value)' readonly></input>
                        <?php } else
                        {
                          $sankey_val1 = '"'.$areaname."_comp_".$row1['CompID'].'"';
                          if(($row1['Mode']=="user"))
                          {

                            if($row1['InputModeType'] == "range")
                            {
                              $range                 = explode(',', $row1['InputModeTypeValue']);
                              $SubLink_MinVal        = $range['0'];
                              $SubLink_MaxVal        = $range['1'];
                              $SubLink_RangeInterval = $range['2'];
                              $type                  = "type='range' min='".$SubLink_MinVal."' max='".$SubLink_MaxVal."' step='".$SubLink_RangeInterval."'";


                              echo "<input value='".$value."' class='scenariaInput current' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' data-id='check_value' required $type ";

                              echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' data-id='check_value' required $type $style_text></input>";
                            }

                            elseif($row1['InputModeType'] == "mChoice")
                            {
                              $mChoice_details = json_decode($row1['InputModeTypeValue'],TRUE);
                              echo "<div class='row text-center'>".$mChoice_details['question']."</div>";
                              array_shift($mChoice_details);
                              ?>
                              <div class="row">
                                <?php
                                foreach ($mChoice_details as $wrow => $wrow_value)
                                {
                                  echo "<div class='radio-inline'><label><input type='radio' value='".$wrow_value."' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' data-id='check_value' required ";
                                  echo (($value == $wrow_value)?'checked':'');
                                  echo " onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' data-id='check_value' required></input> ".$wrow."</label></div>";
                                } ?>
                              </div>
                            <?php } else { ?>
                              <!-- // $sankey_val1 = '"'.$areaname."_comp_".$row1['CompID'].'"'; -->
                              <input type='text' value="<?php echo $value; ?>" class='scenariaInput current' id='<?php echo $areaname."_comp_".$row1['CompID'];?>' name='<?php echo $areaname."_comp_".$row1['CompID'];?>' onclick='return lookupCurrent(<?php echo $row1["SubLinkID"].",$sankey_val1";?>,this.value);' data-id='check_value' required <?php echo $style_text;?>></input>    
                            <?php  } } else { ?>
                              <input type='text' value="<?php echo $value; ?>" class='scenariaInput current' id="<?php echo $areaname.'_comp_'.$row1['CompID'];?>" name="<?php echo $areaname.'_comp_'.$row1['CompID'];?>" onclick='return lookupCurrent(<?php echo $row1["SubLinkID"].",$sankey_val1";?>,this.value);' readonly></input>
                            <?php }  }  ?>
                          </div>
                          <!-- label last -->
                          <div class='InlineBox'>
                            <label class="scenariaLabel "><?php echo $row1['LabelLast'];?></label>
                            <?php
                            $sqllast = "SELECT * FROM `GAME_INPUT`
                            WHERE input_user=".$userid." AND input_sublinkid = 
                            (SELECT ls.SubLink_ID
                            FROM GAME_LINKAGE_SUB ls 
                            WHERE SubLink_SubCompID = 0 AND SubLink_CompID=".$row1['CompID']." AND ls.SubLink_LinkID =
                            (
                            SELECT Link_ID FROM `GAME_LINKAGE`
                            WHERE Link_GameID=".$row1['GameID']." AND Link_ScenarioID != ".$row1['ScenID']." 
                            AND Link_Order < ".$row1['Order']." 
                            ORDER BY Link_Order DESC LIMIT 1))";
                            if($row1['Mode']=="admin")
                            {
                              $last_value = $row1['AdminLast'];                         
                            }
                            else
                            {                         
                              $objlast    = $functionsObj->ExecuteQuery($sqllast);
                              $reslast    = $functionsObj->FetchObject($objlast);
                              $last_value = $reslast->input_current;
                            }
                            ?>
                            <input type="text" class="scenariaInput" value="<?php echo $last_value;?>" readonly>
                          </div>
                        </div>
                        <!-- label ends here -->
                        <span class="range <?php echo ($row1['InputModeType'] == "range")?'hidden':'';?>" <?php echo $style_text; ?>></span>
                        <div class='InlineBox'>
                          <div class="timer closeSave text-center col-sm-1 pull-right" id="SaveInput_<?php echo $row1['SubLinkID'];?>">Save</div>
                        </div>
                      </div>
                    <?php  } ?>
                    <div class='clearfix'></div>
                    <?php 
                    // subcomponent div starts here
                    $sqlsubcomp = "SELECT distinct a.Area_ID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID,  
                    a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name, l.Link_Order AS 'Order', 
                    ls.SubLink_ChartID as ChartID, ls.SubLink_Details as Description, ls.SubLink_InputMode as Mode , f.expression as exp, 
                    ls.SubLink_ID as SubLinkID ,ls.Sublink_AdminCurrent as AdminCurrent, ls.Sublink_AdminLast as AdminLast, 
                    ls.Sublink_ShowHide as ShowHide , ls.Sublink_Roundoff as RoundOff , 
                    ls.SubLink_LinkIDcarry as CarryLinkID, ls.SubLink_CompIDcarry as CarryCompID, 
                    ls.SubLink_SubCompIDcarry as CarrySubCompID, g.Game_ID as GameID, l.Link_ScenarioID as ScenID, ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder, ls.SubLink_InputModeType as InputModeType, ls.SubLink_InputModeTypeValue as InputModeTypeValue
                    FROM GAME_LINKAGE l 
                    INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                    INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                    INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                    INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                    LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                    INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
                    LEFT OUTER JOIN GAME_FORMULAS f on ls.SubLink_FormulaID=f.f_id 
                    WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID>0 and l.Link_ID=".$linkid
                    ." AND ls.SubLink_CompID =".$row1['CompID']." ORDER BY ls.SubLink_Order";
                //echo "SubComponent - ".$sqlsubcomp;
                //echo "</br> addedit - ".$addedit;
                    $subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
                //Get Component for this area for this linkid
                    while($row2 = mysqli_fetch_array($subcomponent)){ 
                      if($row2['TextColor'] || $row2['BackgroundColor'])
                      {
                        $sub_component_style = "style=";

                        if($row2['TextColor'])
                        {
                          $sub_component_style .= "color:".$row2['TextColor'].";";
                        }

                        if($row2['BackgroundColor'])
                        {
                          $sub_component_style .= "background:".$row2['BackgroundColor'].";";
                        }
                      }
                      else
                      {
                        $sub_component_style = '';
                      }
                      ?>
                      <!-- subcomponent main div starts here -->
                      <div class="subCompnent col-sm-12 <?php echo ($row2['ShowHide']?'hidden':'').' '.$length;?>" <?php echo $sub_component_style;?>>
                        <!-- subcomponent name -->
                        <div class="col-sm-1 col-md-2 regular"><?php echo $row2['SubComp_Name'];?></div>
                        <!-- subcomponent chart/details CK Editor -->
                        <div class="col-sm-6 col-md-7 no_padding">
                          <?php
                          if(empty($row2['ChartID']))
                          {
                            echo $row2['Description'];
                          }
                          else
                          {

                            $dataChart          = GetChartData($gameid,$userid,$row2['ChartID']);
                            $sqlchart           = "SELECT * FROM GAME_CHART WHERE Chart_Status=1 and Chart_ID =".$row2['ChartID'];
                            $chartDetails       = $functionsObj->ExecuteQuery($sqlchart);
                            $ResultchartDetails = $functionsObj->FetchObject($chartDetails);
                            $chartname          = $ResultchartDetails->Chart_Name;
                            $charttype          = $ResultchartDetails->Chart_Type;

                //print_r($dataChart);
                            ?>
                            <!-- -----------------------------       Chart Section    ----------------------------------------------->
                            <br><br>
                            <div id="chart_div_<?=$row2['SubCompID']?>" style="width: 800px; height: 400px;"></div>
                            <script type="text/javascript">
                              google.load('visualization', '1', {packages: ['corechart']});
                            </script>
                            <script type="text/javascript">
                              function drawVisualization() {
                // Some raw data (not necessarily accurate)
                
                var data = google.visualization.arrayToDataTable([
                  ['Components', 'Inputs'],
                //     [role:  domain,   data,       data,      data,   domain,   data,     data],    --  hint for cols
                <?php foreach($dataChart as $keyChart=>$valChart) { ?>
                  ['<?=$keyChart?>',<?=$valChart?>],
                <?php }?>
                ]);
                
                var options = {
                  title           :  '<?=ucfirst($chartname)?> : ', 
                  is3D            : true,
                  width           :800,
                  height          :400,
                  interpolateNulls: true,
                  vAxis           : {titleTextStyle:{ fontName: 'Chango'}},
                  hAxis           : {title: "---- Components/Subcomponents ---- -> ",titleTextStyle:{ fontName: 'Chango'},textStyle: {color: '#000', fontSize: 12},textPosition:"out",textPosition: 'none',slantedText:true},
                  seriesType: "bars",
                };
                
                var chart = new google.visualization.<?=$charttype=='pie'?'PieChart':'ComboChart'?>(document.getElementById('chart_div_<?=$row2['SubCompID']?>'));
                chart.draw(data, options);
                
              }
              google.setOnLoadCallback(drawVisualization);
            </script>
            <!-- -----------------------------       Chart Section  end  ----------------------------------------------->
          <?php } ?>
          <!-- subcomponent chart ends here -->
        </div>
        <div class=" col-sm-5 col-md-3 text-right ">
          <?php
         // subcomponent input field
          if ($row2['Mode']!="none") { ?>
            <div class='InlineBox'>
              <div class='InlineBox'>
                <!-- label current -->
                <?php
                if($row2['Mode']=="user" && $row2['InputModeType'] == "mChoice")
                {
                  $hide_label = 'hidden';
                }
                else
                {
                  $hide_label = '';
                }
                ?>
                <label class='scenariaLabel <?php echo $hide_label;?>'><?php echo $row2['LabelCurrent'];?></label>
                <input type="hidden" id="<?php echo $areaname.'_linksubc_'.$row2['SubCompID'];?>" name="<?php echo $areaname.'_linksubc_'.$row2['SubCompID'];?>" value="<?php echo $row2['SubLinkID'];?>">
                <?php
                if($addedit == 'Edit')
                {
              //if(!empty($data[$areaname."_subc_".$row2['SubCompID']])){
                  if(isset($data[$areaname."_subc_".$row2['SubCompID']]) || !empty($data[$areaname."_subc_".$row2['SubCompID']]))
                  {
                    if($row2['RoundOff'] == 0)
                    {
                      $value = $data[$areaname."_subc_".$row2['SubCompID']];
                    }
                    else
                    {
                      $value = round($data[$areaname."_subc_".$row2['SubCompID']]);
                    }
                  }
                  elseif($row2['Mode']=="admin")
                  {
                    $value = $row2['AdminCurrent'];
                  }
                  elseif($row2['Mode']=="formula")
                  {
                    $value = 0;
                  }
                }
                elseif($row2['Mode']=="admin")
                {
                  $value = $row2['AdminCurrent'];
                }
                elseif($row2['Mode']=="formula")
                {
                  $value = 0;
                }
                elseif($row2['Mode']=="carry")
                {
                            //get input value from link, comp, subcomp

                  $sqlcurrent = "SELECT input_current FROM `game_input` 
                  WHERE input_user=".$userid." AND input_sublinkid = 
                  (SELECT SubLink_ID FROM `game_linkage_sub` 
                  WHERE SubLink_LinkID=".$row2['CarryLinkID']." and SubLink_CompID=".$row2['CarryCompID'];
                  if($row2['CarrySubCompID']>0)
                  {
                    $sqlcurrent .=  " AND SubLink_SubCompID = ".$row2['CarrySubCompID'];
                  }
                  $sqlcurrent     .=  ")";
                  $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                  $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                  $value           = $rescarry->input_current;

                }
                if($row2['Mode']=="formula")
                {
                  echo "<input type='text' value='".$value."' id='".$areaname."_fsubc_".$row2['SubCompID']."' name='".$areaname."_fsubc_".$row2['SubCompID']."' ";
                  $sankey_val = '"'.$areaname."_fsubc_".$row2['SubCompID'].'"';
                  echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' "." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' readonly></input>";
                  echo "<input type='hidden' class='json_expsubc' id='".$areaname."_expsubc_".$row2['SubCompID']."' name='".$areaname."_expsubc_".$row2['SubCompID']."' value='".$row2['exp']."'>";
                }
                else
                {
                  $sankey_val = '"'.$areaname."_subc_".$row2['SubCompID'].'"';
                  if ($row2['Mode']=="user")
                  {
                    if($row2['InputModeType']=="range")
                    {
                      $range                 = explode(',', $row2['InputModeTypeValue']);
                      $SubLink_MinVal        = $range['0'];
                      $SubLink_MaxVal        = $range['1'];
                      $SubLink_RangeInterval = $range['2'];
                      $type                  = "type='range' min='".$SubLink_MinVal."' max='".$SubLink_MaxVal."' step='".$SubLink_RangeInterval."'";


                      echo "<input value='".$value."' id='".$areaname."_subc_".$row2['CompID']."' name='".$areaname."_subc_".$row2['CompID']."' data-id='check_value' required $type ";

                      echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' data-id='check_value' required ".$style_text."></input>";
                    }
                    elseif($row2['InputModeType']=="mChoice")
                    {
                      $mChoice_details = json_decode($row2['InputModeTypeValue'],TRUE);
                      echo "<div class='row text-center'>".$mChoice_details['question']."</div>";
                      array_shift($mChoice_details);
                      ?>
                      <div class="row">
                        <?php
                        foreach ($mChoice_details as $wrow => $wrow_value)
                        {
                          echo "<div class='radio-inline col-md-4 align_radio'><input type='radio' value='".$wrow_value."' id='".$areaname."_subc_".$row2['CompID']."' name='".$areaname."_subc_".$row2['CompID']."' data-id='check_value' required ";
                          echo (($value == $wrow_value)?'checked':'');
                          echo " onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' data-id='check_value' required ".$style_text."></input><label>".$wrow."</label></div>";
                        } ?>
                      </div>
                    <?php }
                    else
                    {
                      echo "<input type='text' value='".$value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' ";
                      echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' data-id='check_value' required ".$style_text."></input>";
                    }
                  }
                  else
                  {
                    echo "<input type='text' value='".$value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' ";
                    $sankey_val = '"'.$areaname."_subc_".$row2['SubCompID'].'"';
                    echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' readonly></input>";
                  }
                }
                ?>
              </div>
              <!-- label last -->
              <div class="InlineBox">
                <label class='scenariaLabel'><?php echo $row2['LabelLast'];?></label>
                <?php
                $sqllast = "SELECT * FROM `GAME_INPUT`
                WHERE input_user=".$userid." AND input_sublinkid = 
                (SELECT ls.SubLink_ID
                FROM GAME_LINKAGE_SUB ls 
                WHERE SubLink_SubCompID = ".$row2['SubCompID']." AND SubLink_CompID=".$row2['CompID']." 
                AND ls.SubLink_LinkID =
                (
                SELECT Link_ID FROM `GAME_LINKAGE`
                WHERE Link_GameID=".$row2['GameID']." AND Link_ScenarioID != ".$row2['ScenID']."
                AND Link_Order < ".$row2['Order']." 
                ORDER BY Link_Order DESC LIMIT 1))";
                if($row2['Mode']=="admin"){
                  $last_value = $row2['AdminLast'];                         
                }
                else
                {

                  $objlast    = $functionsObj->ExecuteQuery($sqllast);
                  $reslast    = $functionsObj->FetchObject($objlast);
                  $last_value = $reslast->input_current;
                }
                ?>
                <input type="text" class="scenariaInput" value="<?php echo $last_value;?>" readonly>
              </div>
            </div>
            <?php
            echo '<div class="InlineBox"> <div class="timer closeSave text-center col-sm-1 pull-right" id="SaveInput_'.$row2['SubLinkID'].'">Save</div> </div>';
            ?>

          <?php } ?>
          <!-- if not none -->
        </div>
        <div class="clearfix"></div>
      </div>
      <!-- // end of showing subcomponent -->
    <?php } ?>
    <!-- end of while loop -->
  </div>
<?php } ?>
</div>
<?php } ?>      
</div>
</form>
</div>
<div class="clearfix"></div>
</div>
<!--row-->
</form>
</div>
<!--tab content -->
</section>
<!--container---->
<!-- Modal -->
<div id="Modal_Success" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="window.location = '<?php echo site_root."input.php?ID=".$gameid; ?>';">&times;</button>
        <h4 class="modal-title"> Input Data Saved</h4>
      </div>
      <div class="modal-body">
        <?php //echo $activearea; ?>
        <p> Input Data Saved Successfully.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="window.location = '<?php echo site_root."input.php?ID=".$gameid; ?>';" >Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div id="Modal_Update_Success" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="window.location = '<?php echo site_root."input.php?Link=".$linkid."&tab=".$activearea; ?>';">&times;</button>
        <!--."'"-->
        <h4 class="modal-title"> Updated Successfully</h4>
      </div>
      <div class="modal-body">
        <?php //echo $activearea; ?>
        <p>  Updated Successfully.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" 
        onclick="window.location = '<?php echo site_root."input.php?ID=".$gameid."&tab=".$activearea; ?>';">Ok</button>
        <!--."&tab='".$activearea."'"-->
      </div>
    </div>
  </div>
</div>
<?php if($addedit=="Add") { ?>
  <script type="text/javascript">
    setTimeout(function()
    {

  //$('#save_input').click( function(){ 
  //$("#save_input").attr('disabled',true);
  var ref_tab = $("ul.nav-tabs li.active a").text(); //active tab slect
  var form    = $('#game_frm').get(0);
  $.ajax({
    url        :  "includes/ajax/ajax_addedit_input.php",
    type       : "POST",
    data       : new FormData(form),
    processData: false,
    cache      : false,
    contentType: false,
    beforeSend: function(){
      //alert("beforeSend");
      $("#input_loader").html("<img src='images/loading.gif' height='30'> Inputs being saved, please wait.");
      $('#loader').addClass( 'loader' );
    },
    success: function( result ){
      try{
        //alert (result);
        var response = JSON.parse( result );
        if( response.status == 1 ){
          //alert(response.msg);
          alert('Your time has started. All the best!');
          window.location = "input.php?ID="+<?php echo $gameid; ?> +"&tab="+ref_tab;              
          
          //$('#Modal_Success').modal('show', { backdrop: "static" } );
        } else {
          $('.option_err').html( result.msg );
          //$("#save_input").attr('disabled',false);
          $("#input_loader").html('');
        }
      } catch ( e ) {
        alert(e + "\n" + result);
        alert('Inputs could not be saved, please try again.');
        console.log( e + "\n" + result );
        $("#save_input").attr('disabled',false);
        $("#input_loader").html('');
      }         
      $('#loader').removeClass( 'loader' );
    },
    error: function(jqXHR, exception){
      //alert('error'+ jqXHR.status +" - "+exception);
      alert('Inputs could not be saved, please try again.');
      //$("#save_input").attr('disabled',false);
      $("#input_loader").html('');
    }
  });
  
  
}, 3000);

</script>
<?php } ?>
<script type="text/javascript">
  function lookupCurrent(sublinkid,key,value)
  {
    $(".closeSave").hide();
    $('#SaveInput_'+sublinkid).show();

    //$('#SaveInput_'+sublinkid).click('onclick="alert('+ sublinkid,key,value +')"');
    $('#SaveInput_'+sublinkid).attr('onclick','return SaveCurrent("'+sublinkid+'","'+key+'")');
    
  }
  
  
  function SaveCurrent(sublinkid,key)
  {
    //alert(key);
    value = $("#"+key).val();
    if($('#'+key).attr('required'))
    {
      var update_json = ($("#"+key).parents('.scenariaListingDiv').find('input.json_expcomp').attr('id'));
      var update_sub_json = ($("#"+key).parents('.scenariaListingDiv').find('input.json_expsubc').attr('id'));
    }    
    
    var ref_tab = $("ul.nav-tabs li.active a").text(); //active tab slect
    $.ajax({
      type: "POST",
      url : "includes/ajax/ajax_update_execute_input.php",
      data: '&action=updateInput&sublinkid='+sublinkid+'&key='+key+'&value='+value,
      beforeSend: function() {
        $("#input_loader").html("<img src='images/loading.gif' height='30'> Inputs being updated, please wait.");
      },
      success: function(result) 
      { //alert(result);
        if(result.trim() == 'Yes')
        {
          //$('#step3').hide();
          $('#thanks').show();
          alert('Inputs updated successfully.');
          $("#input_loader").html('');
          $(".closeSave").hide();
          // updating created expcomp json
          if(update_json || update_sub_json)
          {
            update_json_expcomp(update_json);
            update_json_expsubc(update_sub_json);
          }

            //window.location = "input.php?ID="+<?php echo $gameid; ?> +"&tab="+ref_tab;
          }
        }
      });
  }
  
  $('#execute_input').click( function()
  {
    $("#execute_input").attr('disabled',true);
      var ref_tab = $("ul.nav-tabs li.active a").text(); //active tab slect
      var form    = $('#game_frm').get(0);
      //alert('in execute_input');
      $.ajax({
        url        :  "includes/ajax/ajax_execute_input.php",
        type       : "POST",
        data       : new FormData(form),
        processData: false,
        cache      : false,
        contentType: false,
        beforeSend: function(){
          //alert("beforeSend");
          $("#input_loader").html("<img src='images/loading.gif' height='30'> Formulas being executed, please wait.");
          $('#loader').addClass( 'loader' );
        },
        success: function( result ){
          try{
            //alert (result);
            var response = JSON.parse( result );
            if( response.status == 1 ){
              //alert(response.msg);
              alert('Formulas executed successfully.');
              window.location = "input.php?ID="+<?php echo $gameid; ?>+"&tab="+ref_tab;
              //$('#Modal_Success').modal('show', { backdrop: "static" } );
            } else {
              $('.option_err').html( result.msg );
              $("#execute_input").attr('disabled',false);
              $("#input_loader").html('');
            }
          } catch ( e ) {
            alert(e + "\n" + result);
            alert('Formulas could not be executed, please try again.');
            console.log( e + "\n" + result );
            $("#execute_input").attr('disabled',false);
            $("#input_loader").html('');
          }         
          $('#loader').removeClass( 'loader' );
        },
        error: function(jqXHR, exception){
          alert('error'+ jqXHR.status +" - "+exception);
          alert('Formulas could not be executed, please try again.');
          $("#execute_input").attr('disabled',false);
          $("#input_loader").html('');
        }
      });
    });
  
  // writing code for execute 2 button start here
  $('#execute_input_2').click( function()
  {
    jsonToQuery();    
  });
  //  execute 2 button code ends here
  
  
</script>
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
<script src="js/function.js"></script>  
<script type="text/javascript">
  <?php
  $sql_timer    = "SELECT timer FROM `GAME_LINKAGE_TIMER` WHERE linkid= ".$linkid." and userid = ".$userid;
  $objsql_timer = $functionsObj->ExecuteQuery($sql_timer);  
  if($objsql_timer->num_rows > 0) 
  {

    $ressql_timer = $functionsObj->FetchObject($objsql_timer);
    $min          = $ressql_timer->timer; 
    
      /* echo "if (".$linkid." == getCookie('linkid')){} else {";
      echo "setCookie('linkid',".$linkid.",10);";
      echo "setCookie('minutes',".$min.",10);";
      //echo "setCookie('seconds',".$linkid.",10);";
      echo "}"; */
      
      if($min > 0)
      {
        echo "countdown(".$linkid.",".$userid.",".$min.",true);";
      }
    }
    else
    {
      $sql    = "SELECT Link_Hour,Link_Min FROM `GAME_LINKAGE` WHERE Link_ID= ".$linkid;
      $objsql = $functionsObj->ExecuteQuery($sql);
      $ressql = $functionsObj->FetchObject($objsql);
      $hour   = $ressql->Link_Hour; 
      $min    = $ressql->Link_Min + ($hour * 60);

      /* echo "if (".$linkid." == getCookie('linkid')){} else {";
      echo "setCookie('linkid',".$linkid.",10);";
      echo "setCookie('minutes',".$min.",10);";
      //echo "setCookie('seconds',".$linkid.",10);";
      echo "}"; */
      
      echo "countdown(".$linkid.",".$userid.",".$min.",true);";
    }
    
    ?>

    $('input[type=range]').on('change',function(){
      var range_value = $(this).val();
    // console.log($(this).parent().attr('class') + ' and ' + range_value);
    $(this).parent().parent().next().text(range_value);
  });

    $('.range').each(function(i,e){
      if($(e).parent().find('input[type=range]'))
      {
        $(e).text($(e).parent().find('input[type=range]').val());
      }
    });

  // if($('.range').parent().find('input[type=range]')){
  //   $(this).text($(this).parent().find('input[type=range]').val())
  // }
  // creating json here when page load for execution
  $(document).ready(function(){
    crate_json_expcomp();
    crate_json_expsubc();
    // console.log(expcomp);
    // console.log(expsubc);
  });

  // to create expcomp json on page load
  function crate_json_expcomp()
  {
    expcomp = new Array();
    // var tmp = new Array();
    // start expcomp here
    $('.json_expcomp').each(function(index, el)
    {
      // expcomp.push($(el).attr('id'));
      var id             = $(el).attr('id');
      var str            = id.split('_');
      var expression     = $(el).val().split(' ');
      // also make this as json main key to store value and query by making fcomp as main_input_key
      var input_key      = str[0]+'_comp_'+str[2];
      // tmp is sublinkid
      var tmp            = $('#'+(str[0]+'_linkcomp_'+str[2])).val();
      var query          = '';
      var main_input_key = {};

      // each loop for strvalue or y_value
      $(expression).each(function(i,e)
      {
        if((expression[i]).indexOf('comp') != -1 || (expression[i]).indexOf('subc') != -1)
        {
          var sublinkid = $('#'+(str[0]+'_link'+expression[i])).val();
          // trigger ajax to replace the array formula with value
          $.ajax({
            type : "POST",
            url  : "includes/ajax/ajax_update_execute_input.php",
            data : '&action=fetchInput&input_sublinkid='+sublinkid+'&key='+expression[i],
            async: false,
            success: function(result) 
            {
              if(result != 'no')
              {
                // replace array value
                expression[i] = result;
              }
            }
          });
        }
      });
      // console.log(expression);
      if(expression.join('').indexOf('comp') != -1 || expression.join('').indexOf('subc') != -1)
      {
        var flag = false;
      }
      else
      {
        var current = eval(expression.join(''));

      // trigger ajax to get data from game_input where input_sublinkid = tmp and input_key = input_key
      $.ajax({
        type : "POST",
        url  : "includes/ajax/ajax_update_execute_input.php",
        data : '&action=fetchInput_tmp&input_sublinkid='+tmp+'&key='+input_key+'&current='+current+'&main_input_key='+str[0]+'_fcomp_'+str[2],
        async: false,
        success: function(result) 
        {
          if(result != 'no')
          {
            // store array value to create query
            main_input_key = $.parseJSON(result);
            // console.log($.parseJSON(main_input_key));
            expcomp.push(main_input_key);
          }
        }
      });
      // main_input_key = $.parseJSON(query);
    }
    // main_input_key = $.parseJSON(query);
  });
    // console.log(expcomp);
  }
  // update json key value when save button is clicked for expcomp
  function update_json_expcomp(id)
  {
    if(id)
    {
      var update_expcomp = new Array();
      var element        = $('#'+id);
      // expcomp.push($(el).attr('id'));
      var id             = id;
      var str            = id.split('_');
      var expression     = $(element).val().split(' ');
      // also make this as json main key to store value and query by making fcomp as main_input_key
      var input_key      = str[0]+'_comp_'+str[2];
      // tmp is sublinkid
      var tmp            = $('#'+(str[0]+'_linkcomp_'+str[2])).val();
      var query          = '';
      var update_id      = '';
      var update_value   = '';
      var main_input_key = {};

      // each loop for strvalue or y_value
      $(expression).each(function(i,e)
      {
        if((expression[i]).indexOf('comp') != -1 || (expression[i]).indexOf('subc') != -1)
        {
          var sublinkid = $('#'+(str[0]+'_link'+expression[i])).val();
            // trigger ajax to replace the array formula with value
            $.ajax({
              type : "POST",
              url  : "includes/ajax/ajax_update_execute_input.php",
              data : '&action=fetchInput&input_sublinkid='+sublinkid+'&key='+expression[i],
              async: false,
              success: function(result) 
              {
                if(result != 'no')
                {
                  // replace array value
                  expression[i] = result;
                }
              }
            });
          }
        });
        // console.log(expression);
        if(expression.join('').indexOf('comp') != -1 || expression.join('').indexOf('subc') != -1)
        {
          var flag = false;
        }
        else
        {
          var current = eval(expression.join(''));

        // trigger ajax to get data from game_input where input_sublinkid = tmp and input_key = input_key
        $.ajax({
          type : "POST",
          url  : "includes/ajax/ajax_update_execute_input.php",
          data : '&action=fetchInput_tmp&input_sublinkid='+tmp+'&key='+input_key+'&current='+current+'&main_input_key='+str[0]+'_fcomp_'+str[2],
          async: false,
          success: function(result) 
          {
            if(result != 'no')
            {
              // replace array value
              query = result;
            }
          }
        });
        main_input_key = $.parseJSON(query);
      }
        // console.log(query);
        update_expcomp.push(main_input_key);
        // console.log(update_expcomp); 
        // console.log(expcomp); 
        $(expcomp).each(function(i, el)
        {
          if(expcomp[i].main_input_key == update_expcomp[0].main_input_key)
          {
            // console.log(expcomp[i].input_current);
            expcomp[i].input_current = update_expcomp[0].input_current;
            // console.log(expcomp[i].input_current);
            update_id    = expcomp[i].main_input_key;
            update_value = expcomp[i].input_current;
          }
        });
        var save_data = jsonToQuery();
        if(save_data == 'no')
        {
          alert('Error In Formula Execution');
        }
        else
        {
          $('#'+update_id).val(update_value);
          // alert('Formula Executed Successfully');
        }
        // console.log(expcomp); 

      }
    }
  // to create expsubc json on page load
  function crate_json_expsubc()
  {
    expsubc = new Array();
    $('.json_expsubc').each(function(index, el)
    {
      // expcomp.push($(el).attr('id'));
      var id             = $(el).attr('id');
      var str            = id.split('_');
      var expression     = $(el).val().split(' ');
      // also make this as json main key to store value and query by making fcomp as main_input_key
      var input_key      = str[0]+'_subc_'+str[2];
      var tmp            = $('#'+(str[0]+'_linksubc_'+str[2])).val();
      var query          = '';
      var main_input_key = {};

      // each loop for strvalue or y_value
      $(expression).each(function(i,e)
      {
        if((expression[i]).indexOf('comp') != -1 || (expression[i]).indexOf('subc') != -1)
        {
          var sublinkid = $('#'+(str[0]+'_link'+expression[i])).val();
          // trigger ajax to replace the array formula with value
          $.ajax({
            type : "POST",
            url  : "includes/ajax/ajax_update_execute_input.php",
            data : '&action=fetchInput&input_sublinkid='+sublinkid+'&key='+expression[i],
            async: false,
            success: function(result) 
            {
              if(result != 'no')
              {
                // replace array value
                expression[i] = result;
              }
            }
          });
        }
      });
      if(expression.join('').indexOf('comp') != -1 || expression.join('').indexOf('subc') != -1)
      {
        var flag = false;
      }
      else
      {
        var current = eval(expression.join(''));
      // trigger ajax to get data from game_input where input_sublinkid = tmp and input_key = input_key
      $.ajax({
        type : "POST",
        url  : "includes/ajax/ajax_update_execute_input.php",
        data : '&action=fetchInput_tmp&input_sublinkid='+tmp+'&key='+input_key+'&current='+current+'&main_input_key='+str[0]+'_fsubc_'+str[2],
        async: false,
        success: function(result) 
        {
          if(result != 'no')
          {
            // replace array value
            query = result;
          }
        }
      });
      main_input_key = query;
    }
    main_input_key = $.parseJSON(query);
    expsubc.push(main_input_key);
  });
  }
  // update json key value when we click on save for expsubc
  function update_json_expsubc(id)
  {
    if(id)
    {
      
      update_expsubc     = new Array();
      var element        = $('#'+id);
    // expcomp.push($(el).attr('id'));
    var id             = id;
    var str            = id.split('_');
    var expression     = $(element).val().split(' ');
    // also make this as json main key to store value and query by making fcomp as main_input_key
    var input_key      = str[0]+'_subc_'+str[2];
    var tmp            = $('#'+(str[0]+'_linksubc_'+str[2])).val();
    var query          = '';
    var update_id      = '';
    var update_value   = '';
    var main_input_key = {};

    // each loop for strvalue or y_value
    $(expression).each(function(i,e)
    {
      if((expression[i]).indexOf('comp') != -1 || (expression[i]).indexOf('subc') != -1)
      {
        var sublinkid = $('#'+(str[0]+'_link'+expression[i])).val();
        // trigger ajax to replace the array formula with value
        $.ajax({
          type : "POST",
          url  : "includes/ajax/ajax_update_execute_input.php",
          data : '&action=fetchInput&input_sublinkid='+sublinkid+'&key='+expression[i],
          async: false,
          success: function(result) 
          {
            if(result != 'no')
            {
              // replace array value
              expression[i] = result;
            }
          }
        });
      }
    });
    if(expression.join('').indexOf('comp') != -1 || expression.join('').indexOf('subc') != -1)
    {
      var flag = false;
    }
    else
    {
      var current = eval(expression.join(''));
      // trigger ajax to get data from game_input where input_sublinkid = tmp and input_key = input_key
      $.ajax({
        type : "POST",
        url  : "includes/ajax/ajax_update_execute_input.php",
        data : '&action=fetchInput_tmp&input_sublinkid='+tmp+'&key='+input_key+'&current='+current+'&main_input_key='+str[0]+'_fsubc_'+str[2],
        async: false,
        success: function(result) 
        {
          if(result != 'no')
          {
            // replace array value
            query = result;
          }
        }
      });
      main_input_key = $.parseJSON(query);
    }
    // main_input_key = $.parseJSON(query);
    update_expsubc.push(main_input_key);
    $(expsubc).each(function(i, el)
    {
      if(expsubc[i].main_input_key == update_expsubc[0].main_input_key)
      {
        // console.log(expsubc[i].input_current);
        expsubc[i].input_current = update_expsubc[0].input_current;
        // console.log(expsubc[i].input_current);
        update_id    = expsubc[i].main_input_key;
        update_value = expsubc[i].input_current;
      }
    });
    var save_data = jsonToQuery();
    if(save_data == 'no')
    {
      alert('Error In Formula Execution');
    }
    else
    {
      $('#'+update_id).val(update_value);
      // alert('Formula Executed Successfully');
    }
    
  }
}
    // while we click on execute then this function runs the final bulk query
    function jsonToQuery()
    {
    // making json to query to update bulk
    $.ajax({
      type : "POST",
      url  : "includes/ajax/ajax_update_execute_input.php",
      data : '&action=runQuery&expcomp='+JSON.stringify(expcomp)+'&expsubc='+JSON.stringify(expsubc),
      async: false,
      success: function(result) 
      {
       return result;
     }
   });
  }
</script>
</body>
</html>