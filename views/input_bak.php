<?php 
include_once 'includes/header.php'; 
?>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.9.0/math.min.js"></script>-->
<script src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Chango">
<!-- adding css for component branching componentBranching branchingOverlay -->
<style>
  .addOverlay{
    /**/
  }
  /*for active area highlighting*/
  .nav-tabs > li > a::after {
    content   : "";
    background: #009aef;
    height    : 4px;
    position  : absolute;
    width     : 100%;
    left      : 0px;
    bottom    : -1px;
    transition: all 250ms ease 0s;
    transform : scale(0);
  }

</style>
<section id="video_player">
  <div class="container">
    <div class="row scenario_name">
      <div class="col-sm-12 col-lg-6 pull-right">
        <div class="timer text-center col-sm-2 pull-right" id="timer">0:00</div>
      </div>
      <div class="col-sm-9 col-md-10 no_padding col-lg-6 pull-left">
        <h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> <!-- Decisions --></h2>
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
            <span style="margin-right:20px;"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">Introduction</a><i class="fa fa-window-restore" aria-hidden="true"></i>
            </span>
            <span style="margin-right:20px;"><a href="<?php echo $scenurl; ?>" target="_blank" class="innerPageLink">Description</a><i class="fa fa-window-restore" aria-hidden="true"></i></span>
            <a href="chart.php?act=chart&ID=<?=$gameid?>" target="_blank" class="innerPageLink hidden">Dashboard</a><i class="fa fa-window-restore" aria-hidden="true"></i>
          </div>
          <div class="col-sm-6  text-right" style="padding: 2px 2px 5px 0px;">
            <div id="input_loader" style="float:left; color:#2A8037;"></div>
            <button type="button" class="btn innerBtns hidden" name="execute_input" id="execute_input">Execute</button>
            <button type="submit" name="submit" id="submit" class="btn innerBtns hidden" value="Submit">Submit</button>
            <button type="button" name="submit" id="submitBtn" class="btn innerBtns" value="Submit">Submit</button>
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
                  $showhide = "style='padding-bottom:3px;'";
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
                // to set the area classes according to its name laength
                // if(strlen($row['Area_Name']) <= 8)
                // {
                //   $area_length = 'col-md-1';
                // }
                // elseif(strlen($row['Area_Name']) > 8 && strlen($row['Area_Name']) <= 20)
                // {
                //   $area_length = 'col-md-2';
                // }
                // elseif(strlen($row['Area_Name']) > 20 && strlen($row['Area_Name']) <= 36)
                // {
                //   $area_length = 'col-md-3';
                // }
                // elseif(strlen($row['Area_Name']) > 36 && strlen($row['Area_Name']) <= 46)
                // {
                //   $area_length = 'col-md-4';
                // }
                // else
                // {
                //   $area_length = 'col-md-6';
                // }

                if ($tab == 'NOTSET') 
                {
                  if($i == 0)
                  {
                    echo "<li role='presentation' id='".$row['Area_Name']."' class='active ".$area_length." regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                    $activearea=$row['Area_Name'];

                  }
                  else
                  {
                    echo "<li role='presentation' id='".$row['Area_Name']."' class='regular ".$area_length."' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  }

                  $i++;
                }
                else if ($tab == $row['Area_Name'])
                {
                  echo "<li role='presentation' id='".$row['Area_Name']."' class='active ".$area_length." regular' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  $activearea=$row['Area_Name'];
                }
                else
                {
                  echo "<li role='presentation' id='".$row['Area_Name']."' class='regular ".$area_length."' ".$showhide."><a ".$showStyle." href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
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
                // applicable only for scenario branching
                $firstComponent = 0;
                if ($tab == 'NOTSET') 
                {
                  if($i == 0)
                  {
                    echo "<div role='tabpanel' data-TabId='".$row['Area_Name']."' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
                  }
                  else
                  {
                    echo "<div role='tabpanel' data-TabId='".$row['Area_Name']."' class='tab-pane' id='".$row['Area_Name']."Tab'>";
                  }
                  $i++;
                }
                else if ($tab == $row['Area_Name'])
                {
                  echo "<div role='tabpanel' data-TabId='".$row['Area_Name']."' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
                }
                else              
                {
                  echo "<div role='tabpanel' data-TabId='".$row['Area_Name']."' class='tab-pane' id='".$row['Area_Name']."Tab'>";
                }

                $sqlcomp = "SELECT distinct gi.input_showComp, a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, l.Link_Order as 'Order', l.Link_Branching as componentBranching,
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
                INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID 
                LEFT JOIN GAME_INPUT gi on gi.input_sublinkid=ls.SubLink_ID and input_user=".$userid." 
                LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                LEFT OUTER JOIN GAME_FORMULAS f on ls.SubLink_FormulaID=f.f_id 
                WHERE ls.SubLink_Type=0 AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." 
                and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
                  // echo "Component - ".$sqlcomp;
                  //echo $userid;
                $component = $functionsObj->ExecuteQuery($sqlcomp);
                  //Get Component for this area for this linkid
                while($row1 = mysqli_fetch_array($component)){    
                      //echo "<form > ";
                  switch ($row1['ViewingOrder']) {
                    // Name - Details/Chart - InputFields
                    case 1:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Name - InputFields - Details/Chart 
                    case 2:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "pull-right";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Details/Chart - InputFields - Name
                    case 3:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "pull-right";
                    $DetailsChart   = "";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Details/Chart - Name - InputFields
                    case 4:
                    $ckEditorLength = 'col-md-6';
                    // adding removeThis class to remove the div to prevent duplicacy, coz showing this below to show the component name in the middle
                    $ComponentName  = "hidden removeThis"; 
                    $DetailsChart   = "";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // InputFields - Details/Chart - Name
                    case 5:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "pull-right";
                    $DetailsChart   = "pull-right";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // InputFields - Name - Details/Chart
                    case 6:
                    $ckEditorLength = 'col-md-6';
                    // adding removeThis class to remove the div to prevent duplicacy, coz showing this below to show the component name in the middle
                    $ComponentName  = "hidden removeThis"; 
                    $DetailsChart   = "pull-right";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // InputFields - Name - FullLength
                    case 7:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "pull-right";
                    $DetailsChart   = "hidden";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // InputFields - Details/Chart
                    case 8:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "hidden";
                    $DetailsChart   = "pull-right";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Name - Details/Chart
                    case 9:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "";
                    $InputFields    = "hidden";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Name - InputFields - FullLength
                    case 10:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "hidden";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "90%";
                    break;

                    // Details/Chart - Name
                    case 11:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "pull-right";
                    $DetailsChart   = "";
                    $InputFields    = "hidden";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Details/Chart - InputFields
                    case 12:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "hidden";
                    $DetailsChart   = "";
                    $InputFields    = "";
                    $comp_length    = 'col-md-12';
                    $ImageMaxWidth  = "60%";
                    break;

                    // Name - InputFields - HalfLength
                    case 13:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "hidden";
                    $InputFields    = "";
                    $comp_length    = "col-sm-6";
                    $ImageMaxWidth  = "90%";
                    break;

                    // InputFields - Name - HalfLength
                    case 14:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "pull-right";
                    $DetailsChart   = "hidden";
                    $InputFields    = "";
                    $comp_length    = "col-sm-6";
                    $ImageMaxWidth  = "90%";
                    break;

                    // CkEditor - FullLength
                    case 15:
                    $ckEditorLength = "col-md-12";
                    $ComponentName  = "hidden";
                    $DetailsChart   = "";
                    $InputFields    = "hidden";
                    $comp_length    = "col-md-12";
                    $ImageMaxWidth  = "30%";
                    break;

                    // CkEditor - HalfLength
                    case 16:
                    $ckEditorLength = "col-md-12";
                    $ComponentName  = "hidden";
                    $DetailsChart   = "";
                    $InputFields    = "hidden";
                    $comp_length    = "col-md-6";
                    $ImageMaxWidth  = "90%";
                    break;

                    // ckEditor - InputFields - HalfLength
                    case 17:
                    $ckEditorLength = "col-md-6";
                    $ComponentName  = "hidden";
                    $DetailsChart   = "";
                    $InputFields    = "";
                    $comp_length    = "col-md-6";
                    $ImageMaxWidth  = "90%";
                    break;

                    // InputFields - ckEditor - HalfLength
                    case 18:
                    $ckEditorLength = "col-md-6";
                    $ComponentName  = "hidden";
                    $DetailsChart   = "pull-right";
                    $InputFields    = "";
                    $comp_length    = "col-md-6";
                    $ImageMaxWidth  = "90%";
                    break;

                    case 19:
                    $ckEditorLength = 'col-md-6';
                    $ComponentName  = "";
                    $DetailsChart   = "";
                    $InputFields    = "hidden";
                    $comp_length    = "col-sm-6";
                    $ImageMaxWidth  = "90%";
                    break;
                  }

                  if($comp_length == 'col-md-6')
                  {
                    $comp_input_lenght      = 'col-md-6';
                    $comp_name_length       = 'col-md-6';
                    $comp_limit_char        = 30;
                    $comp_label_min_width   = '110px';
                    // $comp_save_button_align = 'top: 50%; position: absolute;';
                  }
                  else
                  {
                    $comp_input_lenght      = 'col-md-4';
                    $comp_name_length       = 'col-md-2';
                    $comp_limit_char        = 55;
                    $comp_label_min_width   = '122px';
                    // $comp_save_button_align = 'top: 50%; position: absolute;';
                  }
                  // if ($row1['ShowHide']==1){
                  //   echo "style='display:none;'";
                  // }
                  // component branching, if branching enabled then make the first component of the area visible and then as per the component branching conditions, show the next component
                  
                  if($row1['componentBranching'] > 0)
                  {
                    // for show hide-> 0-show and 1-hide, if component is visible from admin end
                    if($row1['ShowHide'] < 1)
                    {
                      if($firstComponent < 1)
                      {
                        $showComp    = '';
                        $hideByAdmin = '';
                        $firstComponent++;
                      }
                      else
                      {
                        $showComp    = 'hidden';
                        $hideByAdmin = '';
                      }
                    }
                    else
                    {
                      // it means component is hide from admin end
                      $showComp    = 'hidden';
                      // add a class to component div, to find wheather we have to show the div after execute or not
                      $hideByAdmin = 'hideByAdmin';
                    }
                    echo "<div class='".$comp_length." scenariaListingDiv componentBranching ".$showComp." ".$hideByAdmin."' style='background:".$row1['BackgroundColor']."; color:".$row1['TextColor'].";' id='branchComp_".$row1['SubLinkID']."'>";
                    // adding div to create overlay, to prevent clicking after execute or click on save
                    echo "<div class='branchingOverlay' id='overlay_".$row1['SubLinkID']."'>";
                  }
                  else
                  {
                    echo "<div class='".$comp_length." scenariaListingDiv ".(($row1['ShowHide']==1)?'hidden':'')."' style='background:".$row1['BackgroundColor']."; color:".$row1['TextColor'].";' id='ref_".$row1['SubLinkID']."'>";
                  }

                  echo "<div class='col-sm-1 ".$comp_name_length." regular ".$ComponentName."'>";
                  echo $row1['Comp_Name'];
                  echo "</div>";
                  echo "<div class='col-sm-6 ".$ckEditorLength." no_padding ".$DetailsChart."'>";

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
                    // adding a refresh icon
                    echo '<a class="refreshChart" data-redirect="'.site_root.'input.php?ID='.$gameid.'&tab='.$row['Area_Name'].'#ref_'.$row1['SubLinkID'].'" data-toggle="tooltip" title="Refresh"><span class="glyphicon glyphicon-refresh"></span></a>';
                    ?>  
                    <img class="graph_chart showImageModal comp_chart col-md-12" src="chart/<?=$charttypeComp?>.php?gameid=<?=$gameid?>&userid=<?=$userid?>&ChartID=<?=$row1['ChartID']?>" style="max-width:<?php echo $ImageMaxWidth; ?>;">
                    <?php
                  }
                  echo "</div>";
                  // writing this to show only for alignmenet of viewing order to show component name in middle
                  if($row1['ViewingOrder'] == 4)
                  {
                    echo "<div class='col-sm-1 col-md-2 regular'>";
                    echo $row1['Comp_Name'];
                    echo "</div>";
                  }

                  if ($row1['Mode']!="none")
                  {
                    echo "<div class=' col-sm-5 ".$comp_input_lenght." text-right ".$InputFields."'>";
                    echo "<div class='InlineBox'>";
                    echo "<div class='InlineBox ".(($row1['InputFieldOrder']==2)?'pull-right':'')." ".(($row1['InputFieldOrder']==4)?'hidden':'')."'>";
                    if($row1['Mode']=="user" && $row1['InputModeType'] == "mChoice")
                    {
                      $hide_label = 'hidden';
                    }
                    else
                    {
                      $hide_label = '';
                    }

                    $comp_query   = "SELECT * FROM GAME_INPUT WHERE input_user=$userid AND input_sublinkid='".$row1['SubLinkID']."' AND input_key LIKE '%comp_".$row1['CompID']."'";
                    $query_result = $functionsObj->ExecuteQuery($comp_query);
                    if($query_result->num_rows > 0)
                    {
                      $query_result     = mysqli_fetch_assoc($query_result);
                      $comp_data_id_key = "class='data_element' data-input_id='".$query_result['input_id']."' data-input_key='".$query_result['input_key']."'";
                      $formulaValue     = $query_result['input_current'];
                    }
                    else
                    {
                      $comp_data_id_key = "class='data_element'";
                      $formulaValue     = 0;
                    }

                    echo "<label class='scenariaLabel ".$hide_label."'>".$row1['LabelCurrent']."</label>";
                    echo "<input $comp_data_id_key type='hidden' id='".$areaname."_linkcomp_".$row1['CompID']."' name='".$areaname."_linkcomp_".$row1['CompID']."' value='".$row1['SubLinkID']."'></input>";

                    // getting the value here for iput field
                    if($addedit!='Add')
                    {
                      // to update carry forward value intant without page refresh
                      $linkCarry = '';

                      if($row1['Mode']=="carry")
                      {
                        //get input value from link, comp, subcomp
                        $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." AND input_sublinkid =(SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` WHERE SubLink_LinkID=".$row1['CarryLinkID']." and SubLink_CompID=".$row1['CarryCompID'];
                        if($row1['CarrySubCompID']>0)         
                        {
                         $sqlcurrent .= " AND SubLink_SubCompID = ".$row1['CarrySubCompID'];
                       }          
                       $sqlcurrent     .= ")";
                       // echo $sqlcurrent;
                       $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                       $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                       $value           = $rescarry->input_current;
                       $linkCarry       = "<input type='hidden' class='linkCarry' data-id_name='".$areaname."_comp_".$row1['CompID']."' value='".$sqlcurrent."'/>";
                     }
                      //if($data[$areaname."_comp_".$row1['CompID']]>=0)
                     elseif($row1['Mode']=="admin")
                     {
                      $value = $row1['AdminCurrent'];
                    }
                    elseif($row1['Mode']=="formula")
                    {
                      $value = 0;
                    }
                    elseif(isset($data[$areaname."_comp_".$row1['CompID']]) || (!empty($data[$areaname."_comp_".$row1['CompID']])))
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
                  $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` WHERE input_user=".$userid." AND input_sublinkid =(SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` WHERE SubLink_LinkID=".$row1['CarryLinkID']." and SubLink_CompID=".$row1['CarryCompID'];
                  if($row1['CarrySubCompID']>0)         
                  {
                    $sqlcurrent .= " AND SubLink_SubCompID = ".$row1['CarrySubCompID'];
                  }          
                  $sqlcurrent     .= ")";
                  // echo $sqlcurrent;
                  $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                  $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                  $value           = $rescarry->input_current;
                  $linkCarry       = "<input type='hidden' class='linkCarry' data-id_name='".$areaname."_comp_".$row1['CompID']."' value='".$sqlcurrent."'/>";
                }
                    // end of getting value

                if($row1['Mode']=="formula")
                {
                  echo "<input type='hidden' id='".$areaname."_expcomp_".$row1['CompID']."' name='".$areaname."_expcomp_".$row1['CompID']."' value='".$row1['exp']."' class='json_expcomp'>";

                  $sankey_val1 = '"'.$areaname."_fcomp_".$row1['CompID'].'"';

                  echo "<input value='".$formulaValue."' type ='text' class='scenariaInput current' id='".$areaname."_fcomp_".$row1['CompID']."' name='".$areaname."_fcomp_".$row1['CompID']."' readonly></input>";
                  // echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' readonly ></input>";
                }
                else
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


                      echo "<input value='".$value."' class='scenariaInput current' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' required $type $style_text ";

                      echo "onchange='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' ";
                      echo " onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' required $type $style_text></input>";
                      ?>
                      <span class="range" style="float: left; background:#009aef; color:#ffffff; margin-left: 30%; margin-top: 1%; padding: 0.6px 4px;"></span>
                      <?php
                    }

                    elseif($row1['InputModeType'] == "mChoice")
                    {
                      $mChoice_details = json_decode($row1['InputModeTypeValue'],TRUE);
                      echo "<div class='row text-center pull-left' style='font-weight: 700; margin-left:1px;font-size:17px;'>".$mChoice_details['question']."</div>";
                      $makeDefaultChecked = $mChoice_details['makeDefaultChecked'];
                      // removing the last element of the array, i.e. default selection from admin end, if exist
                      if($makeDefaultChecked)
                      {
                        array_pop($mChoice_details);
                      }
                      $defSql = "SELECT * FROM GAME_INPUT WHERE input_user=$userid AND input_sublinkid=".$row1['SubLinkID'];
                      $defObj = $functionsObj->ExecuteQuery($defSql);
                      $defRes = $functionsObj->FetchObject($defObj);
                      $value  = $defRes->input_current;
                      // echo $makeDefaultChecked.' and '.$value;
                      ?>
                      <div class="col-md-12" style="margin-top:7px;margin-left:-30px;font-size:14px;">
                        <?php
                        $continue = 0;
                        $flag     = true;
                        // check value from database to make default radio button checked
                        foreach ($mChoice_details as $wrow => $wrow_value)
                        {
                          if($continue < 1)
                          {
                            // skipping the question
                            $continue++;
                            continue;
                          }
                          // 'makeDefaultChecked' is the array key for default selection from admin and it's value is the text of the option for the particular question i.e. $wrow
                          echo "<div class='col-md-12 align_radio text-left' data-toggle='tooltip' title='".$wrow."'><label style='min-width:".$comp_label_min_width."; display: inline-flex;'><input type='radio' value='".$wrow_value."' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' required ";
                          // if db value is matched from option value then checked that option, otherwise make admin choice selected
                          if($flag)
                          {
                            // echo (($value == $wrow_value)?"checked":($makeDefaultChecked==$wrow)?"checked":($continue==1)?"checked":'');
                            if($value == $wrow_value)
                            {
                              $flag = false;
                              echo 'checked';
                            }

                            elseif($makeDefaultChecked == $wrow)
                            { 
                              $flag = false;
                              echo 'checked';
                            }

                            // else
                            // { 
                            //   // $flag = false;
                            //   echo 'checked';
                            // }
                          }
                          echo " $style_text onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' required $type $style_text></input>".(strlen($wrow) > $comp_limit_char?substr($wrow,0,$comp_limit_char).'...':$wrow)."</label></div>";
                        }
                        ?>
                      </div>
                      <?php
                    }

                    else
                    {
                    // $sankey_val1 = '"'.$areaname."_comp_".$row1['CompID'].'"';
                      echo "<input type='text' value='".$value."' class='scenariaInput current' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' ";
                      echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' required $style_text></input>";
                    }

                  }
                  else
                  {
                    $sankey_val1 = '"'.$areaname."_comp_".$row1['CompID'].'"';
                    echo $linkCarry;
                    echo "<input type='text' value='".$value."' class='scenariaInput current' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' readonly></input>";
                    // echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);' readonly></input>";
                  }
                }


                echo "</div>";
                echo "<div class='InlineBox ".(($row1['InputFieldOrder']==3)?'hidden':'')."'>";
                echo "<label class='scenariaLabel'>".$row1['LabelLast']."</label>";
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
                    //echo $sqllast;
                echo "<input type='text' class='scenariaInput' ";
                if($row1['Mode']=="admin"){
                  echo " value ='".$row1['AdminLast']."' ";                         
                }
                else{                         
                  $objlast = $functionsObj->ExecuteQuery($sqllast);
                  $reslast = $functionsObj->FetchObject($objlast);
                  echo " value ='".$reslast->input_current."' ";
                }
                echo 'readonly></input>';
                echo "</div>";
                echo "</div>";

                echo '<div class="InlineBox"> <div class="timer closeSave text-center col-sm-1 pull-right" id="SaveInput_'.$row1['SubLinkID'].'" style="width:40px; margin-bottom: -11px; display:none; cursor:pointer;background: #009aef;">Save</div> </div>';

                echo "</div>";
              }

                // writing this to show only for alignmenet of viewing order to show component name in middle
              if($row1['ViewingOrder'] == 6)
              {
                echo "<div class='col-sm-1 col-md-2 regular'>";
                echo $row1['Comp_Name'];
                echo "</div>";
              }

              echo "<div class='clearfix'></div>";

                //Get SubComponent for this Component, linkid
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
                  // hiding the subcomponent if mode = 1
                ($row2['ShowHide']==1)?$hide='hidden':$hide='';

                switch ($row2['ViewingOrder']) {
                  // Name - Details/Chart - InputFields
                  case 1:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Name - InputFields - Details/Chart
                  case 2:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "pull-right";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Details/Chart - InputFields - Name
                  case 3:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "pull-right";
                  $DetailsChart     = "";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Details/Chart - Name - InputFields
                  case 4:
                  $SubCkEditor      = 'col-md-6';
                  // adding removeThis class to remove the div to prevent duplicacy, coz showing this below to show the component name in the middle
                  $SubcomponentName = "hidden removeThis";
                  $DetailsChart     = "";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // InputFields - Details/Chart - Name
                  case 5:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "pull-right";
                  $DetailsChart     = "pull-right";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // InputFields - Name - Details/Chart
                  case 6:
                  $SubCkEditor      = 'col-md-6';
                  // adding removeThis class to remove the div to prevent duplicacy, coz showing this below to show the component name in the middle
                  $SubcomponentName = "hidden removeThis";
                  $DetailsChart     = "pull-right";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // InputFields - Name - FullLength
                  case 7:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "pull-right";
                  $DetailsChart     = "hidden";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // InputFields - Details/Chart
                  case 8:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "pull-right";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Name - Details/Chart
                  case 9:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "";
                  $InputFields      = "hidden";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Name - InputFields - FullLength
                  case 10:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "hidden";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "90%";
                  break;

                  // Details/Chart - Name
                  case 11:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "pull-right";
                  $DetailsChart     = "";
                  $InputFields      = "hidden";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Details/Chart - InputFields
                  case 12:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "";
                  $InputFields      = "";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "60%";
                  break;

                  // Name - InputFields - HalfLength
                  case 13:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "hidden";
                  $InputFields      = "";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;

                  // InputFields - Name - HalfLength
                  case 14:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "pull-right";
                  $DetailsChart     = "hidden";
                  $InputFields      = "";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;

                  // CkEditor - FullLength
                  case 15:
                  $SubCkEditor      = 'col-md-12';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "";
                  $InputFields      = "hidden";
                  $length           = "col-md-12";
                  $sImageMaxWidth   = "30%";
                  break;

                  // CkEditor - HalfLength
                  case 16:
                  $SubCkEditor      = 'col-md-12';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "";
                  $InputFields      = "hidden";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;

                  // ckEditor - InputFields - HalfLength
                  case 17:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "";
                  $InputFields      = "";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;

                  // InputFields - ckEditor - HalfLength
                  case 18:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "hidden";
                  $DetailsChart     = "pull-right";
                  $InputFields      = "";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;

                  // Name - Details/Chart - HalfLength
                  case 19:
                  $SubCkEditor      = 'col-md-6';
                  $SubcomponentName = "";
                  $DetailsChart     = "";
                  $InputFields      = "hidden";
                  $length           = "col-md-6";
                  $sImageMaxWidth   = "90%";
                  break;
                }

                // if component div is half length then make subcomponent div col-md-12
                if($comp_length == 'col-md-6')
                {
                  $length       = 'col-md-12';
                  $input_lenght = 'col-md-6';
                  $name_length  = 'col-md-6';
                }

                elseif($length == 'col-md-6')
                {
                  $input_lenght              = 'col-md-6';
                  $name_length               = 'col-md-6';
                  $limit_char                = 30;
                  $subcomp_label_min_width   = '110px';
                  // $subcomp_save_button_align = '';
                }
                else
                {
                  $input_lenght              = 'col-md-4';
                  $name_length               = 'col-md-2';
                  $limit_char                = 55;
                  $subcomp_label_min_width   = '122px';
                  // $subcomp_save_button_align = 'top: 50%; position: absolute;';
                }
                echo "<div class='".$length." subCompnent ".$hide."' style='background:".$row2['BackgroundColor']."; color:".$row2['TextColor']."; border:none;'";
                  // if ($row2['ShowHide']==1){
                  //   echo "style='display:none;'";
                  // }
                echo ">";
                echo "<div class='col-sm-1 ".$name_length." regular ".$SubcomponentName."'>";
                  echo $row2['SubComp_Name']; //." - Mode - ".$row2['Mode'] ;
                  echo "</div>";
                  echo "<div class='col-sm-6 ".$SubCkEditor." no_padding ".$DetailsChart."'>";

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
                    // adding a refresh icon
                    echo '<a class="refreshChart" data-redirect="'.site_root.'input.php?ID='.$gameid.'&tab='.$row['Area_Name'].'#ref_'.$row2['SubLinkID'].'" data-toggle="tooltip" title="Refresh"><span class="glyphicon glyphicon-refresh"></span></a>';
                    ?>
                    <!-- adding this section to make comp chart insert into subcomp as discussed -->
                    <img class="graph_chart showImageModal subcomp_chart col-md-12" src="chart/<?=$charttype?>.php?gameid=<?=$gameid?>&userid=<?=$userid?>&ChartID=<?=$row2['ChartID']?>" style="max-width:<?php echo $sImageMaxWidth; ?>;">
                    <!-- Edn of adding section to make comp chart insert into subcomp as discussed -->
                    <?php
                  }
                  echo "</div>";
          // writing this to show only for alignmenet of viewing order to show component name in middle
                  if($row2['ViewingOrder'] == 4)
                  {
                    echo "<div class='col-sm-1 col-md-2 regular'>";
                    echo $row2['SubComp_Name'];
                    echo "</div>";
                  }
                  if ($row2['Mode']!="none")
                  {
                    echo "<div class=' col-sm-5 ".$input_lenght." text-right ".$InputFields."'>";
                  // putting both current and last input field div inside a div having same class inlinebox to shift left/right
                    echo "<div class='InlineBox'>";
                    echo "<div class='InlineBox ".(($row2['InputFieldOrder']==2)?'pull-right':'')." ".(($row2['InputFieldOrder']==4)?'hidden':'')."'>";
                    if($row2['Mode']=="user" && $row2['InputModeType'] == "mChoice")
                    {
                      $hide_label = 'hidden';
                    }
                    else
                    {
                      $hide_label = '';
                    }
                    echo "<label class='scenariaLabel $hide_label'>".$row2['LabelCurrent']."</label>";
                    $subcomp_query = "SELECT * FROM GAME_INPUT WHERE input_user=$userid AND input_sublinkid='".$row2['SubLinkID']."' AND input_key LIKE '%subc_".$row2['SubCompID']."'";
                  // echo $subcomp_query;
                    $query_result = $functionsObj->ExecuteQuery($subcomp_query);
                    if($query_result->num_rows > 0)
                    {
                      $query_result = mysqli_fetch_assoc($query_result);
                      $subcomp_data_id_key  = "class='data_element' data-input_id='".$query_result['input_id']."' data-input_key='".$query_result['input_key']."'";
                    }
                    else
                    {
                      $subcomp_data_id_key = "class='data_element'";
                    }
                    ?>
                    <input type="hidden" <?php echo $subcomp_data_id_key;?> id="<?php echo $areaname.'_linksubc_'.$row2['SubCompID'];?>" name="<?php echo $areaname.'_linksubc_'.$row2['SubCompID'];?>" value="<?php echo $row2['SubLinkID'];?>">
                    <?php
                    if($addedit != 'Add')
                    {
                      if($row2['Mode']=="carry")
                      {
                //get input value from link, comp, subcomp
                        $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` 
                        WHERE input_user=".$userid." AND input_sublinkid = 
                        (SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` 
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
              //if(!empty($data[$areaname."_subc_".$row2['SubCompID']])){
                      elseif($row2['Mode']=="admin")
                      {
                        $value = $row2['AdminCurrent'];
                      }
                      elseif($row2['Mode']=="formula")
                      {
                        $value = 0;
                      }
                      elseif(isset($data[$areaname."_subc_".$row2['SubCompID']]) || !empty($data[$areaname."_subc_".$row2['SubCompID']]))
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
                      $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` 
                      WHERE input_user=".$userid." AND input_sublinkid = 
                      (SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` 
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
                     $formulaSql = "SELECT input_current FROM GAME_INPUT WHERE input_sublinkid =".$row2['SubLinkID']." AND input_user=".$userid;
              // die($formulaSql);
                     $formulaCurrent = $functionsObj->ExecuteQuery($formulaSql);
                     $formaulValue   = $functionsObj->FetchObject($formulaCurrent);
                     if($formaulValue->input_current)
                     {
                      $value = $formaulValue->input_current;
                    }
                    echo "<input type='text' value='".$value."' id='".$areaname."_fsubc_".$row2['SubCompID']."' name='".$areaname."_fsubc_".$row2['SubCompID']."' ";
                    $sankey_val = '"'.$areaname."_fsubc_".$row2['SubCompID'].'"';
                    echo " readonly></input>";
              // echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' "." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' readonly></input>";
                    echo "<input type='hidden' class='json_expsubc' id='".$areaname."_expsubc_".$row2['SubCompID']."' name='".$areaname."_expsubc_".$row2['SubCompID']."' value='".$row2['exp']."'>";
                  }
                  else
                  {
                    $sankey_val = '"'.$areaname."_subc_".$row2['SubCompID'].'"';
                    if ($row2['Mode']=="user")
                    {
                      if($data[$areaname."_subc_".$row2['SubCompID']])
                      {
                        $value = $data[$areaname."_subc_".$row2['SubCompID']];
                      }
                      else
                      {
                        $value = 0;
                      }
                      if($row2['InputModeType']=="range")
                      {
                        $range                 = explode(',', $row2['InputModeTypeValue']);
                        $SubLink_MinVal        = $range['0'];
                        $SubLink_MaxVal        = $range['1'];
                        $SubLink_RangeInterval = $range['2'];
                        $type                  = "type='range' min='".$SubLink_MinVal."' max='".$SubLink_MaxVal."' step='".$SubLink_RangeInterval."'";


                        echo "<input value='".$value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' required $type ";

                        echo "onchange='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'";

                        echo " onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' required ".$style_text."></input>";
                        ?>
                        <span class="range" style="float: left; background:#009aef; color:#ffffff; margin-left: 30%; margin-top: 1%; padding: 0.6px 4px;"></span>
                        <?php
                      }
                      elseif($row2['InputModeType']=="mChoice")
                      {
                        $mChoice_details = json_decode($row2['InputModeTypeValue'],TRUE);
                        echo "<div class='row text-center' style='font-weight: 700;margin-left:28px;float:left;'>".$mChoice_details['question']."</div>";
                        $makeDefaultCheckedSub = $mChoice_details['makeDefaultChecked'];
                        // removing the last element of the array, i.e. default selection from admin end, if exist
                        if($makeDefaultCheckedSub)
                        {
                          array_pop($mChoice_details);
                        }
                        ?>
                        <div class="col-md-12">
                          <?php
                          $continue = 0;
                          $flag     = true;
                          foreach ($mChoice_details as $wrow => $wrow_value)
                          {
                            if($continue < 1)
                            {
                              $continue++;
                              continue;
                            }
                            echo "<div class='col-md-12 align_radio text-left' data-toggle='tooltip' title='".$wrow."'><label style='min-width:".$subcomp_label_min_width."; display: inline-flex;'><input type='radio' value='".$wrow_value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' required ";
                            // echo (($value == $wrow_value)?'checked':'');
                            if($flag)
                            {
                              if($value == $wrow_value)
                              {
                                $flag = false;
                                echo 'checked';
                              }

                              elseif($makeDefaultCheckedSub == $wrow)
                              { 
                                $flag = false;
                                echo 'checked';
                              }

                              else
                              { 
                                echo 'checked';
                              }
                            }
                            echo " onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' required ".$style_text."></input>".(strlen($wrow) > $limit_char?substr($wrow,0,$limit_char).'...':$wrow)."</label></div>";
                          } ?>
                        </div>
                      <?php }
                      else
                      {
                        echo "<input type='text' value='".$value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' ";
                        echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' required ".$style_text."></input>";
                      }
                    }
                    else
                    {
                      echo "<input type='text' value='".$value."' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' ";
                      $sankey_val = '"'.$areaname."_subc_".$row2['SubCompID'].'"';
                      echo " readonly></input>";
                // echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' readonly></input>";
                    }
                  }
                  ?>
                </div>
                <?php
                echo "<div class='InlineBox ".(($row2['InputFieldOrder']==3)?'hidden':'')."'>";
                          //echo "<label class='scenariaLabel'>Last</label>";
                echo "<label class='scenariaLabel'>".$row2['LabelLast']."</label>";
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
                              //echo $sqllast;
                echo "<input type='text' class='scenariaInput' ";
                if($row2['Mode']=="admin"){
                  echo " value ='".$row2['AdminLast']."' ";                         
                }
                else{

                  $objlast = $functionsObj->ExecuteQuery($sqllast);
                  $reslast = $functionsObj->FetchObject($objlast);
                  echo " value ='".$reslast->input_current."' ";
                }
                echo " readonly></input>";
                          //echo "<input type='text' class='scenariaInput' readonly></input>";
                echo "</div>";
                echo "</div>";

                echo '<div class="InlineBox"> <div class="timer closeSave text-center col-sm-1 pull-right" id="SaveInput_'.$row2['SubLinkID'].'" style="width:40px; margin-bottom: -7px; display:none; cursor:pointer;background: #009aef;">Save</div> </div>';


                echo "</div>";
              }
                         // writing this to show only for alignmenet of viewing order to show component name in middle

              if($row2['ViewingOrder'] == 6)
              {
                echo "<div class='col-sm-1 col-md-2 regular'>";
                echo $row2['SubComp_Name'];
                echo "</div>";
              }

              echo "<div class='clearfix'></div>";

              echo "</div>";

            }
            if($row1['componentBranching'] > 0)
            {
      // closing the branchingOverlay div here
              echo '</div>';
            }
            echo "</div>";  
    //<!--scenariaListingDiv-->
    //}
    //else{

    //}

          }
                //echo "</form>";
          echo "</div>";

        }
        ?>              
      </form>
    </div>
  </div> <!--tab content -->
  <div class="clearix"></div>
</div>
      <!--
        <div class="col-sm-12 text-right">
        <?php if($addedit=="Add") { ?>
          <button type="button" class="btn innerBtns" name="save_input" id="save_input">Save</button>
        <?php } else {  ?>
          <button type="button" class="btn innerBtns" name="update_input" id="update_input">Update</button>           
        <?php } ?>
          <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Submit</button>
          <?php //echo site_root; ?>
        </div>
      -->
    </div>
    <!--row-->
  </form>
</div>
<!--container---->
</section>
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
    // var ref_tab     = $("ul.nav-tabs li.active a").text(); //active tab slect
    // window.location = "input.php?ID="+<?php echo $gameid; ?> +"&tab="+ref_tab;              
    setTimeout(function()
    {
    //$('#save_input').click( function(){ 
      //$("#save_input").attr('disabled',true);
      var ref_tab = $("ul.nav-tabs li.active a").text(); //active tab slect
      // alert(ref_tab); return false;
      var form    = $('#game_frm').get(0);
      $.ajax({
        url:  "includes/ajax/ajax_addedit_input.php",
        type: "POST",
        data: new FormData(form),
        processData: false,
        cache: false,
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
              alert('Inputs saved successfully.');
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
    <?php if($result->Branching){ ?>
      componentBranchingDivId = 'branchComp_'+sublinkid;
    <?php } ?>
  }
  
  function SaveCurrent(sublinkid,key)
  {
    //alert(key);
    // checking if user has logged out or not in another tab
    $.ajax({
      type: "POST",
      url : "<?php echo site_root;?>selectgame.php",
      data: '&action=check_loggedIn_status&key='+key,
      success: function(result) 
      {
        if(result.trim() == 'no')
        {
          location.reload();
          return false;
        }
      }
    });

    start_time         = new Date();
    var save_button_id = "SaveInput_"+sublinkid;
    var value          = $("#"+key).val();
    var ref_tab        = $("ul.nav-tabs li.active a").text(); //active tab slect
    $('#'+save_button_id).hide();
    $('.overlay').show();

    $.ajax({
      type: "POST",
      url : "includes/ajax/ajax_update_execute_input.php",
      data: '&action=updateInput&sublinkid='+sublinkid+'&key='+key+'&value='+value,
      beforeSend: function() {
        $("#input_loader").html("<img src='images/loading.gif' height='30'> Inputs being updated, please wait.");
      },
      success: function(result) 
      {
        //alert(result);
        if(result.trim() == 'Yes')
        {
          //$('#step3').hide();
          $('#thanks').show();
          $("#input_loader").html('');
          update_json_data(save_button_id,key,formula_json_expcomp,formula_json_expsubc,input_field_values);
          // $(".closeSave").hide();
          //window.location = "input.php?ID="+<?php // echo $gameid; ?> +"&tab="+ref_tab;
        }
        else
        {
          alert('Connection problem, Please try later.');
          $('.overlay').hide();
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
          $("#input_loader").html("<img src='images/loading.gif' height='30'> Saving inputs, please wait.");
          $('#loader').addClass( 'loader' );
        },
        success: function( result ){
          try{
            //alert (result);
            var response = JSON.parse( result );
            if( response.status == 1 ){
              //alert(response.msg);
              alert('Saved successfully.');
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
            window.location = "input.php?ID="+<?php echo $gameid; ?>+"&tab="+ref_tab;
            $("#execute_input").attr('disabled',false);
            $("#input_loader").html('');
          }         
          $('#loader').removeClass( 'loader' );
        },
        error: function(jqXHR, exception){
          alert('error'+ jqXHR.status +" - "+exception);
          alert('Formulas could not be executed, please try again.');
          window.location = "input.php?ID="+<?php echo $gameid; ?>+"&tab="+ref_tab;
          $("#execute_input").attr('disabled',false);
          $("#input_loader").html('');
        }
      });
    });

  // writing code for execute 2 button start here
  $('#execute_input_2').click( function()
  {
    //
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
    else
    {
      // trigger submit if time is up and show overlay
      echo "$('.overlay').show();";
      // while auto submit then remove all required from inputs
      ?>
      $('input').each(function(){
        $(this).prop('required',false);
      });
      <?php
      echo "$('#submit').trigger('click');";
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
    $(this).parent('div.InlineBox').find('span.range').text(range_value);
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
  $(document).ready(function(){
    componentBranchingDivId = "";
    // writing this to hide the already played component by user
    <?php if($result->Branching){ 
      $hideShowSql = "SELECT input_sublinkid,input_showComp FROM GAME_INPUT WHERE input_user=$userid AND input_showComp>0 AND input_sublinkid IN (SELECT SubLink_ID FROM GAME_LINKAGE_SUB WHERE SubLink_LinkID=$linkid)";
      $hideShowObj = $functionsObj->ExecuteQuery($hideShowSql);
      while($row = $hideShowObj->fetch_object())
      {
        // hide component if value is 1 i.e. user already played it, and show if value is 2, i.e. then comp where user left
        if($row->input_showComp < 2){ ?>
          $("#branchComp_<?php echo $row->input_sublinkid;?>").addClass('hidden')
        <?php } 
        else { 
          ?>
          $("#branchComp_<?php echo $row->input_sublinkid;?>").removeClass('hidden');
        <?php }
      }
      ?>
      // remove required from hidden component/subcomponent
      $('div.scenariaListingDiv').each(function(){
        if($(this).hasClass('hidden'))
        {
          $(this).find('input').prop('required',false);
        }
        else
        {
          $(this).find('input').prop('required',true);
        }
      });
    <?php } ?>
    // while pressing the refresh button then redirect to same page and same element
    $('.refreshChart').each(function(){
      var redirect = $(this).data('redirect');
      $(this).on('click',function(){
        $(location).attr('href',redirect);
      });
    });
    // adding alert box while submitting the form to submit the inputs
    $('#submitBtn').on('click',function(){
      var conf = confirm('Please press OK if you have provided all your inputs and are ready to submit else press Cancel. Please note that you can not come back to this page after clicking OK');
      if(conf)
      {
        $('#submit').trigger('click');
      }
    });
    // trigger click on save button onchange if type=radio
    // $('input:radio').each(function(i,e){
    //   $(this).click(function(e){
    //     $(this).parents('div.text-right').find('div.closeSave').trigger('click');
    //   });
    // });
    // removing inlinebox class from button div if input type=range to align button down
    $('input[type="range"]').each(function(i,e){
      $(this).parents('div.text-right').find('div.closeSave').parent('div').removeClass('InlineBox').css({'margin':'4% 1% 0% 2%'});
      $(this).parents('div.text-right').find('div.closeSave').css({'margin-top':'-11%'});
    });
    $('[data-toggle="tooltip"]').tooltip();

    // fixing the width of table in details/chart
    $('.subCompnent').each(function(i,e){
      // .css({'width':'auto'});
      if($(this).hasClass('col-md-6'))
      {
        if($(e).find('table').length)
        {
          $(e).find('table').css({'width':'auto'});
        }
      }        
    });

    // hide area if there is no component or all of them are hidden
    $('.tab-pane').each(function(i,e)
    {
      var tabId   = $(this).attr('data-tabId');
      var hidden  = 0;
      var element = $(e).find('div.scenariaListingDiv').length;
      if(element > 0)
      {
        $(e).children('div.scenariaListingDiv').each(function(){
          if($(this).hasClass('hidden'))
          {
            hidden++;
          }
        });
        if(element == hidden)
        {
          $('#'+tabId).addClass('hidden');
        }
      }
      else
      {
        $('#'+tabId).addClass('hidden');
      }
    });

    // stopping form submission while user press enter key
    $('form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) { 
        e.preventDefault();
        return false;
      }
    });

    // removing the element which are twice
    $(".removeThis").each(function(){
      $(this).remove();
    });

    formula_json_expcomp = {};
    formula_json_expsubc = {};
    input_field_values   = {};
    input_field_keys     = {};
    carry_field_data     = {};
    create_json_carry_field_data();
    create_json_input_field();
    create_json_input_field_keys();
    create_json_expsubc_onload();
    create_json_expcomp_onload();
    // console.log(formula_json_expcomp);
    // console.log(formula_json_expsubc);
    // console.log(input_field_values);
    // console.log(input_field_keys);
    // making component charts
    $('.graph_chart').each(function(index, el) {
      var new_src    = $(this).attr('src');
      $(this).attr('src',new_src);
    });

  });
function create_json_carry_field_data()
{
  // create carry forward json to update it without refresh
  $('.linkCarry').each(function(){
    var carryId    = $(this).data('id_name');
    var carryQuery = $(this).val();
    // console.log(carryId+' and '+carryQuery);
    carry_field_data[carryId] = carryQuery;
  });
  // console.log(carry_field_data);
}
function create_json_input_field_keys(key)
{
    // comp,expcomp,fcomp and subc,expsubc,fsubc
    $('input[type="hidden"]').each(function(i,e){
      var value = $(this).val();
      // console.log($(this).attr('id'));
      // console.log(value);
      if(($(this).attr('id')))
      {

        if(($(this).attr('id')).indexOf('link') != -1)
        {
          var key_key = $(this).attr('id').split('_');
          input_field_keys[key_key[1]+'_'+key_key[2]] = $(this).attr('id');
        }
      }
    });
    // console.log(input_field_keys);
  }
  function create_json_expcomp_onload()
  {
    $('.json_expcomp').each(function(index, el) 
    {
      var id         = $(el).attr('id');
      var str        = id.split('_');
      var expression = $(el).val().split(' ');
      $(expression).each(function(i,e)
      {
        if((expression[i]).indexOf('comp') != -1)
        {
          // finding wheather it is depending to any other comp or subcomp
          if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expcomp').length > 0)
          {
            expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
          }
          else
          {
            // find wheater this component or subcomponent exist or not
            if($('#'+str[0]+'_'+expression[i]).length > 0)
            {
              expression[i] = str[0]+'_'+expression[i];
            }
            else
            {
              // trigger ajax if that component or subcomponent doesn't exist
              var new_id = element_not_found(expression[i]);
              new_id     = new_id.split('_');
              if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expcomp').length > 0)
              {
                expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
              }
              else
              {
                expression[i] = new_id.join('_');
              }
            }
          }
        }
        else if((expression[i]).indexOf('subc') != -1)
        {
          // finding wheather it is depending to any other comp or subcomp
          if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expsubc').length > 0)
          {
            expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
          }
          else
          {
            // find wheater this component or subcomponent exist or not
            if($('#'+str[0]+'_'+expression[i]).length > 0)
            {
              expression[i] = str[0]+'_'+expression[i];
            }
            else
            {
              // trigger ajax if that component or subcomponent doesn't exist
              var new_id = element_not_found(expression[i]);
              new_id     = new_id.split('_');
              if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expsubc').length > 0)
              {
                expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
              }
              else
              {
                expression[i] = new_id.join('_');
              }
            }
          }
        }
        else
        {
          expression[i] = expression[i];
        }
      });
      formula_json_expcomp[str[0]+'_fcomp_'+str[2]] = expression.join(' ');
    });
  }

  function create_json_expsubc_onload()
  {
    $('.json_expsubc').each(function(index, el) 
    {
      var id         = $(el).attr('id');
      var str        = id.split('_');
      var expression = $(el).val().split(' ');
      $(expression).each(function(i,e)
      {
        if((expression[i]).indexOf('comp') != -1)
        {
          // finding wheather it is depending to any other comp or subcomp
          if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expcomp').length > 0)
          {
            expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
          }
          else
          {
            // find wheater this component or subcomponent exist or not
            if($('#'+str[0]+'_'+expression[i]).length > 0)
            {
              expression[i] = str[0]+'_'+expression[i];
            }
            else
            {
              // trigger ajax if that component or subcomponent doesn't exist
              var new_id = element_not_found(expression[i]);
              new_id     = new_id.split('_');
              if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expcomp').length > 0)
              {
                expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
              }
              else
              {
                expression[i] = new_id.join('_');
              }
            }
          }
        }
        else if((expression[i]).indexOf('subc') != -1)
        {
          // finding wheather it is depending to any other comp or subcomp
          if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expsubc').length > 0)
          {
            expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
          }
          else
          {
            // find wheater this component or subcomponent exist or not
            if($('#'+str[0]+'_'+expression[i]).length > 0)
            {
              expression[i] = str[0]+'_'+expression[i];
            }
            else
            {
              // trigger ajax if that component or subcomponent doesn't exist
              var new_id = element_not_found(expression[i]);
              new_id     = new_id.split('_');
              if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expsubc').length > 0)
              {
                expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
              }
              else
              {
                expression[i] = new_id.join('_');
              }
            }
          }
        }
        else
        {
          expression[i] = expression[i];
        }
      });
      formula_json_expsubc[str[0]+'_fsubc_'+str[2]] = expression.join(' ');
    });
  }

  function find_function_expression(id)
  {
    // getting id like expcomp or expsubc and exp is the last part of id like subc_123, comp_232
    var formula_expansion = new Array();
    var str               = id.split('_');
    var expression        = $('#'+id).val().split(' ');
    $(expression).each(function(i,e)
    {
      if((expression[i]).indexOf('comp') != -1)
      {
        if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expcomp').length > 0)
        {
          expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
        }
        else
        {
          // find wheater this component or subcomponent exist or not
          if($('#'+str[0]+'_'+expression[i]).length > 0)
          {
            expression[i] = str[0]+'_'+expression[i];
          }
          else
          {
            // trigger ajax if that component or subcomponent doesn't exist
            var new_id = element_not_found(expression[i]);
            new_id     = new_id.split('_');
            if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expcomp').length > 0)
            {
              expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
            }
            else
            {
              expression[i] = new_id.join('_');
            }
          }
        }
      }
      else if((expression[i]).indexOf('subc') != -1)
      {
        if($('#'+str[0]+'_link'+expression[i]).parent('div').find('input.json_expsubc').length > 0)
        {
          expression[i] = find_function_expression(str[0]+'_exp'+expression[i]);
        }
        else
        {
          // find wheater this component or subcomponent exist or not
          if($('#'+str[0]+'_'+expression[i]).length > 0)
          {
            expression[i] = str[0]+'_'+expression[i];
          }
          else
          {
            // trigger ajax if that component or subcomponent doesn't exist
            var new_id = element_not_found(expression[i]);
            new_id     = new_id.split('_');
            // console.log(new_id[0]+'_link'+new_id[1]+'_'+new_id[2]);
            if($('#'+new_id[0]+'_link'+new_id[1]+'_'+new_id[2]).parent('div').find('input.json_expsubc').length > 0)
            {
              expression[i] = find_function_expression(new_id[0]+'_exp'+new_id[1]+'_'+new_id[2]);
            }
            else
            {
              expression[i] = new_id.join('_');
            }
          }
        }
      }
      else
      {
        expression[i] = expression[i];
      }
    });
    // formula_expansion.push(expression);
    expression.unshift('(');
    expression.push(')');
    expression_string = expression.join(' ');
    return expression_string;
  }

  function element_not_found(key)
  {
    var exp       = '';
    var find      = 'link'+key;
    var ret_value = input_field_keys[find].split('_');
    return ret_value[0]+'_'+key;
  }

  function create_json_input_field()
  {
    $('input').each(function(i,e){
      if($(this).attr('type') == 'range')
      {
        $(this).parent('div.InlineBox').css({'padding':'0px 5px 0px 0px'});
      }

      if($(e).attr('required') || $(e).attr('readonly'))
      {
        if($(this).attr('id'))
        {
          // console.log($(this).attr('id'));
          // input_field_values[$(this).attr('id')] = $(this).val();
          // // console.log($(this).prev().attr('id'));
          if($(this).parents('div').hasClass('align_radio'))
          {
            // if multiple choice or radio button
            var data_element = $(this).parents('div.InlineBox').find('input.data_element');
            var sublink_id   = data_element.val();
            var genenrate_id = $(this).attr('id').split('_');
            var value        = $("input[type='radio']:checked").val();
          }
          else
          {
            var value        = $(this).val();
            var data_element = $(this).parent('div.InlineBox').find('input.data_element');
            var sublink_id   = data_element.val();
            var genenrate_id = $(this).attr('id').split('_');
          }

          if(data_element.attr('data-input_key') || data_element.attr('data-input_id'))
          {
            var key_input = data_element.attr('data-input_key');
            var id_input  = data_element.attr('data-input_id');
          }
          else
          {
            if(genenrate_id[1].indexOf('comp') != -1)
            {
              var key_input = genenrate_id[0]+'_comp_'+genenrate_id[2];
              var id_input  = 0;
            }
            if(genenrate_id[1].indexOf('subc') != -1)
            {
              var key_input = genenrate_id[0]+'_subc_'+genenrate_id[2];
              var id_input  = 0;
            }
          }

          input_field_values[$(this).attr('id')] = {
            values         :value,
            input_id       :id_input,
            input_sublinkid:sublink_id,
            input_key      :key_input,
          };
        }
      }
    });
    // console.log(input_field_values);
  }


  function update_json_data(id,key,formula_json_expcomp,formula_json_expsubc,input_field_values)
  {
    // console.log($('#'+key).val());
    if($('#'+key).parents('div').hasClass('align_radio'))
    {
      var value = $("input[name='"+key+"']:checked").val();
    }
    else
    {
      var value = $("#"+key).val();
    }

    $.each(input_field_values, function (index, val) {
      if(index == key)
      {
        input_field_values[index].values = value;
      }
    });

    $.ajax({
      // contentType: "application/json; charset=utf-8",
      type    : "POST",
      dataType: "json",
      // if component branching is enabled for the current scenario then send an extra parameter to get the branching details
      <?php if($result->Branching){ ?>

        data:{'action':'updateFormula','carry_field_data':carry_field_data,formula_json_expcomp:formula_json_expcomp,formula_json_expsubc:formula_json_expsubc,input_field_values:input_field_values,'compBranching':'enabled'},

      <?php } 
      else{
        ?>
      // if component branching is not enabled then send this data
      data:{'action':'updateFormula','carry_field_data':carry_field_data,formula_json_expcomp:formula_json_expcomp,formula_json_expsubc:formula_json_expsubc,input_field_values:input_field_values},
    <?php } ?>
      // data    :{'action':'updateFormula',formula_json_expcomp:formula_json_expcomp},
      url     : "includes/ajax/ajax_update_execute_input.php",
      // data       : '&action=updateFormula&formula_json_expcomp='+formula_expcomp+'&formula_json_expsubc='+formusubc+'&input_field_values='+input_values,
      beforeSend: function() {
        $("#input_loader").html("<img src='images/loading.gif' height='30'> Executing Formula, please wait.");
      },
      success: function(result) 
      {
        if(result != 'no')
        {
          $.each(result, function (index, val){
            input_field_values[index].values   = result[index].values;
            input_field_values[index].input_id = result[index].input_id;
            // console.log(parseFloat(result[index].values).toFixed(2));
            // $('#'+index).val(parseFloat(result[index].values).toFixed(2));
            // $('#'+index).val(parseInt(result[index].values));


            $('#'+index).val(result[index].values);
            // input_field_values[index] = result[index];
            
            // red, if component branching enabled, if component main div has class 'hideByAdmin' then don't show this div. otherwise show div, having id=branchComp_sublinkId, if component branching is enabled and it's child div which is added to make the comp div unclickable so that user can not change prev comp value has the id overlay_sublinkId
            <?php if($result->Branching){ ?>
              // console.log('branchComp_'+result[index].input_sublinkid);
              // console.log(componentBranchingDivId);
              // if('branchComp_'+result[index].input_sublinkid == componentBranchingDivId)
              // {
                // trigger ajax for component branching
                $.ajax({
                  url    :  "includes/ajax/ajax_update_execute_input.php",
                  type   : "POST",
                  data   : 'action=componentBranching&param='+componentBranchingDivId+'&name=mohit',
                  success: function( branchResult ){
                    if(branchResult != 'no')
                    {
                      // result is=> (hide)branchComp_sublinkid,overlay_sublinkid,branchComp_sublinkid(show)
                      var resultBranch = branchResult.split(',');
                      var hideComp     = resultBranch[0];
                      var overlayComp  = resultBranch[1];
                      var showComp     = resultBranch[2];
                      // remove rquired from hidden and add required to non hidden comp/subcomp
                      $('div.scenariaListingDiv').each(function(){
                        $(this).find('input').prop('required',false);
                      });
                      $('#'+hideComp).addClass('hidden');
                      if(!($('#'+showComp).hasClass('hideByAdmin')))
                      {
                        $('#'+showComp).removeClass('hidden');
                        $('#'+showComp).find('input').prop('required',true);
                      }
                    }
                    else
                    {
                      console.log('No component branching found, for the selected component');
                    }
                  }
                });
              // }
            <?php } ?>
          });
          end_time   = new Date();
          final_time = (start_time.getTime() - end_time.getTime())/1000;
          // $("#"+id).show();
          
          // refreshing charts
          $('.graph_chart').each(function(index, el) {
            var new_src    = $(this).attr('src');
            $(this).attr('src',new_src);
          });
          
          $("#input_loader").html('');
          $('.overlay').hide();
          // var relocate = key.split('_');
          // window.location.href = "<?php // echo site_root.'input.php?ID='.$gameid.'&tab=';?>"+relocate[0];
          // console.log("<?php // echo site_root.'input.php?ID='.$gameid.'&tab=';?>"+);
          // alert('Saved Successfully.');
          // $(".closeSave").hide();
          // console.log(input_field_values);
        }
      },
      error: function(jqXHR, exception){
        {
          $('.overlay').hide();
          alert(jqXHR.responseText);
          // console.log(exception);
          // $("#"+id).show();
          $("#input_loader").html('');
          $('.overlay').hide();
        }
      }
    });
}
</script>
</body>
</html>
