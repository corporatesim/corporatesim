<?php 
include_once 'includes/header.php'; 

?>
<style>
.DisplayNone{
  display: none;
}
</style>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.9.0/math.min.js"></script>-->
<script src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Chango">
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
            <a href="chart.php?act=chart&ID=<?=$gameid?>" target="_blank" class="innerPageLink DisplayNone">Dashboard</a><i class="fa fa-window-restore" aria-hidden="true"></i>
          </div>
          <div class="col-sm-6  text-right">
            <div id="input_loader" style="float:left; color:#2A8037;"></div>
            <button type="button" class="btn innerBtns" name="execute_input" id="execute_input">Execute</button>
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
                ls.SubLink_SubCompIDcarry as CarrySubCompID, g.Game_ID as GameID, l.Link_ScenarioID as ScenID, ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder
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
                      //echo "<form > ";
                  echo "<div class='col-sm-12 scenariaListingDiv'";
                  switch ($row1['ViewingOrder']) {
                    case 1:
                    $SubcomponentName = "";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    break;

                    case 2:
                    $SubcomponentName = "";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    break;

                    case 3:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    break;

                    case 4:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    break;

                    case 5:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    break;

                    case 6:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    break;

                    case 7:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    break;

                    case 8:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    break;

                    case 9:
                    $SubcomponentName = "";
                    $DetailsChart     = "";
                    $InputFields      = "DisplayNone";
                    break;

                    case 10:
                    $SubcomponentName = "";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    break;

                    case 11:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "";
                    $InputFields      = "DisplayNone";
                    break;

                    case 12:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    break;
                  }
                  if ($row1['ShowHide']==1){
                    echo "style='display:none;'";
                  }
                  echo ">";             
                  echo "<div class='col-sm-1 col-md-2 regular ".$SubcomponentName."'>";
                  echo $row1['Comp_Name'];
                  echo "</div>";
                  echo "<div class='col-sm-6 col-md-7 no_padding ".$DetailsChart."''>";

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
                    echo "<div class=' col-sm-5 col-md-3 text-right ".$InputFields."''>";
                    echo "<div class='InlineBox'>";
                    echo "<div class='InlineBox ".(($row1['InputFieldOrder']==2)?'pull-right':'')." ".(($row1['InputFieldOrder']==4)?'DisplayNone':'')."'>";
                    echo "<label class='scenariaLabel'>".$row1['LabelCurrent']."</label>";
                    echo "<input type='hidden' id='".$areaname."_linkcomp_".$row1['CompID']."' name='".$areaname."_linkcomp_".$row1['CompID']."' value='".$row1['SubLinkID']."'></input>";

                    if($row1['Mode']=="formula")
                    {
                      echo "<input type='text' id='".$areaname."_fcomp_".$row1['CompID']."' name='".$areaname."_fcomp_".$row1['CompID']."' ";
                      $sankey_val1 = '"'.$areaname."_fcomp_".$row1['CompID'].'"';
                      echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);'";
                    }
                    else
                    {
                      echo "<input type='text' id='".$areaname."_comp_".$row1['CompID']."' name='".$areaname."_comp_".$row1['CompID']."' ";
                      $sankey_val1 = '"'.$areaname."_comp_".$row1['CompID'].'"';
                      echo "onclick='return lookupCurrent(".$row1['SubLinkID'].",".$sankey_val1.",this.value);'";
                    }
                    if($addedit=='Edit')
                    {
                    //if($data[$areaname."_comp_".$row1['CompID']]>=0)
                      if(isset($data[$areaname."_comp_".$row1['CompID']]) || (!empty($data[$areaname."_comp_".$row1['CompID']])))
                      { 
                       if($row1['RoundOff'] == 0)
                       {
                        echo " value ='".$data[$areaname."_comp_".$row1['CompID']]."' ";
                      }
                      else
                      {
                        echo " value ='".round($data[$areaname."_comp_".$row1['CompID']])."' ";
                      }
                    }
                    elseif($row1['Mode']=="admin")
                    {
                     echo " value ='".$row1['AdminCurrent']."' ";
                   }
                   elseif($row1['Mode']=="formula")
                   {
                     echo " value = 0 ";
                   }
                 }
                 elseif($row1['Mode']=="admin")
                 {
                  echo " value ='".$row1['AdminCurrent']."' ";
                }
                elseif($row1['Mode']=="formula")
                {
                  echo " value = 0 ";
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
                 echo " value = ".$rescarry->input_current;
               }
                  echo " class='scenariaInput current'  ";  //onChange='showUser(this);'
                  if ($row1['Mode']!="user")
                  {
                    echo " readonly ";
                  }
                  else
                  {
                    echo " required ";
                    echo "style='background:#009aef; color:#ffffff;'";
                  }
                  echo '></input>';
                  if ($row1['Mode']=="formula")
                  {
                    echo "<input type='hidden' id='".$areaname."_expcomp_".$row1['CompID']."' name='".$areaname."_expcomp_".$row1['CompID']."' value='".$row1['exp']."'>";
                  }
                  echo "</div>";
                  echo "<div class='InlineBox ".(($row1['InputFieldOrder']==3)?'DisplayNone':'')."'>";
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

                  echo '<div class="InlineBox"> <div class="timer closeSave text-center col-sm-1 pull-right" id="SaveInput_'.$row1['SubLinkID'].'" style="width:40px; margin-bottom: -7px; display:none; cursor:pointer;background: #009aef;">Save</div> </div>';

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
                ls.SubLink_SubCompIDcarry as CarrySubCompID, g.Game_ID as GameID, l.Link_ScenarioID as ScenID, ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder
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
                  ($row2['ShowHide']==1)?$hide='DisplayNone':$hide='';

                  switch ($row2['ViewingOrder']) {
                    case 1:
                    $SubcomponentName = "";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 2:
                    $SubcomponentName = "";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 3:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 4:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 5:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 6:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 7:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 8:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "pull-right";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 9:
                    $SubcomponentName = "";
                    $DetailsChart     = "";
                    $InputFields      = "DisplayNone";
                    $length           = "col-sm-12";
                    break;

                    case 10:
                    $SubcomponentName = "";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;

                    case 11:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "";
                    $InputFields      = "DisplayNone";
                    $length           = "col-sm-12";
                    break;

                    case 12:
                    $SubcomponentName = "DisplayNone";
                    $DetailsChart     = "";
                    $InputFields      = "";
                    $length           = "col-sm-12";
                    break;
                    // for half length
                    case 13:
                    $SubcomponentName = "";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    $length           = "col-sm-6";
                    break;

                    case 14:
                    $SubcomponentName = "pull-right";
                    $DetailsChart     = "DisplayNone";
                    $InputFields      = "";
                    $length           = "col-sm-6";
                    break;
                  }
                  if($length == 'col-sm-6')
                  {
                    $input_lenght = 'col-md-6';
                    $name_length  = 'col-md-6';
                  }
                  else
                  {
                    $input_lenght = 'col-md-3';
                    $name_length  = 'col-md-2';
                  }
                  echo "<div class='".$length." subCompnent ".$hide."' style='background:".$row2['BackgroundColor']."; color:".$row2['TextColor'].";'";
                  // if ($row2['ShowHide']==1){
                  //   echo "style='display:none;'";
                  // }
                  echo ">";
                  echo "<div class='col-sm-1 ".$name_length." regular ".$SubcomponentName."'>";
                  echo $row2['SubComp_Name']; //." - Mode - ".$row2['Mode'] ;
                  echo "</div>";
                  echo "<div class='col-sm-6 col-md-7 no_padding ".$DetailsChart."'>";

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
            echo "<div class='InlineBox ".(($row2['InputFieldOrder']==2)?'pull-right':'')." ".(($row2['InputFieldOrder']==4)?'DisplayNone':'')."'>";
            echo "<label class='scenariaLabel'>".$row2['LabelCurrent']."</label>";
            echo "<input type='hidden' id='".$areaname."_linksubc_".$row2['SubCompID']."' name='".$areaname."_linksubc_".$row2['SubCompID']."' value='".$row2['SubLinkID']."'></input>";
            if($row2['Mode']=="formula")
            {
              echo "<input type='text' id='".$areaname."_fsubc_".$row2['SubCompID']."' name='".$areaname."_fsubc_".$row2['SubCompID']."' ";
              $sankey_val = '"'.$areaname."_fsubc_".$row2['SubCompID'].'"';
              echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);' "." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'";
            }
            else
            {
              echo "<input type='text' id='".$areaname."_subc_".$row2['SubCompID']."' name='".$areaname."_subc_".$row2['SubCompID']."' ";
              $sankey_val = '"'.$areaname."_subc_".$row2['SubCompID'].'"';
              echo "onclick='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'"." onfocus='return lookupCurrent(".$row2['SubLinkID'].",".$sankey_val.",this.value);'";
            }
            if($addedit == 'Edit')
            {
              //if(!empty($data[$areaname."_subc_".$row2['SubCompID']])){
              if(isset($data[$areaname."_subc_".$row2['SubCompID']]) || !empty($data[$areaname."_subc_".$row2['SubCompID']]))
              {
                if($row2['RoundOff'] == 0)
                {
                  echo " value ='".$data[$areaname."_subc_".$row2['SubCompID']]."'";
                }
                else
                {
                  echo " value ='".round($data[$areaname."_subc_".$row2['SubCompID']])."'";
                }
              }
              elseif($row2['Mode']=="admin")
              {
                echo " value ='".$row2['AdminCurrent']."' ";
              }
              elseif($row2['Mode']=="formula")
              {
                echo " value = 0 ";
              }
            }
            elseif($row2['Mode']=="admin")
            {
              echo " value ='".$row2['AdminCurrent']."' ";
            }
            elseif($row2['Mode']=="formula")
            {
              echo " value = 0 ";
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
              echo " value = ".$rescarry->input_current;

            }
                          echo " class='scenariaInput current'  ";  //onChange='showUser(this);'
                          if ($row2['Mode'] != "user")
                          {
                            echo "readonly";
                          }
                          else{
                            echo " required ";
                            echo "style='background:#009aef; color:#ffffff;'";
                          }
                          
                          echo "></input>";
                          if ($row2['Mode'] == "formula")
                          {
                            echo "<input type='hidden' id='".$areaname."_expsubc_".$row2['SubCompID']."' name='".$areaname."_expsubc_".$row2['SubCompID']."' value='".$row2['exp']."'>";
                          }
                          echo "</div>";
                          echo "<div class='InlineBox ".(($row2['InputFieldOrder']==3)?'DisplayNone':'')."'>";
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
                      echo "</div>";  
                //}
                //else{

                //}

                    }
                //echo "</form>";
                //<!--scenariaListingDiv-->
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
</script>
</body>
</html>