<?php 
include_once 'includes/header.php'; 
?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> - Outcome</h2></div>
        <!--<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Game." | ".$result->Scenario ; }?> Your Output</h2></div>
          <div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->

          <div class="clearfix"></div>

          <form method="POST" action="" id="game_frm" name="game_frm">
            <div class="col-sm-12 no_padding shadow">
          <!--
            <div class="col-sm-6 ">
              <span style="margin-right:20px;"><a href="<?php echo $gameurl; ?>" target="_blank" class="innerPageLink">Game Description</a></span>
              <a href="<?php echo $scenurl; ?>" target="_blank" class="innerPageLink">Scenario Description</a>
            </div>
          -->
            <!--<div class="col-sm-6  text-right">
              <button class="btn innerBtns">Save</button>
              <button class="btn innerBtns">Submit</button>
            </div>-->
            <div class="col-sm-12  text-right pull-right"">
              <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button>
            </div>
            
            <!-- Nav tabs --> 
            <div class=" TabMain col-sm-12">
              <ul class="nav nav-tabs" role="tablist">
                <?php 
                $i=0;
                while($row = mysqli_fetch_array($area)) {
                    //echo $row->Area_Name;
                  if($i==0)
                  {
                    echo "<li role='presentation' class='active regular'><a href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  }else{
                    echo "<li role='presentation' class='regular'><a href='#".$row['Area_Name']."Tab' aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
                  }
                  $i++;
                }
                ?>
              </ul>
              
              <!-- Tab panes -->
              <div class="tab-content">

                <?php
            //echo $area->num_rows;
                $area = $functionsObj->ExecuteQuery($sqlarea);
                $i=0;
                while($row = mysqli_fetch_array($area)) {
                  $areaname = $row['Area_Name'];
              //echo $i." ".$row['Area_Name'];
                  if($i==0)
                  {
                    echo "<div role='tabpanel' class='tab-pane active' id='".$row['Area_Name']."Tab'>";
                  }
                  else{
                    echo "<div role='tabpanel' class='tab-pane' id='".$row['Area_Name']."Tab'>";
                  }
                  $i++;

                  $sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, 
                  c.Comp_Name as Comp_Name, ls.SubLink_Details as Description ,ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder,ls.Sublink_ShowHide as ShowHide , o.output_current as Current 
                  FROM GAME_LINKAGE l 
                  INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID= ls.SubLink_LinkID 
                  INNER JOIN GAME_OUTPUT o on ls.SubLink_ID = o.output_sublinkid
                  INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                  INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                  INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                  LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                  INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                  WHERE ls.SubLink_Type=1 AND o.output_user=".$userid." AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
          //  echo $sqlcomp; exit;
                  $component = $functionsObj->ExecuteQuery($sqlcomp);
                  $sqlUpd ="UPDATE game_input gi LEFT JOIN game_output gu ON gi.input_sublinkid = gu.output_sublinkid SET gi.input_current = gu.output_current WHERE gi.input_user = 3026 AND gi.input_sublinkid IN (SELECT SubLink_ID FROM `game_linkage_sub` WHERE SubLink_Type=1 AND sublink_LinkID=".$linkid.") AND gu.output_user=".$userid."";
                  $compUpd = $functionsObj->ExecuteQuery($sqlUpd);

              //Get Component for this area for this linkid
                  while($row1 = mysqli_fetch_array($component,$compUpd)){ 
                    switch ($row1['ViewingOrder']) {
                      case 1:
                      $ComponentName  = "";
                      $DetailsChart   = "";
                      $InputFields    = "";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 2:
                      $ComponentName  = "";
                      $InputFields    = "";
                      $DetailsChart   = "pull-right";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 3:
                      $DetailsChart   = "";
                      $InputFields    = "";
                      $ComponentName  = "pull-right";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 4:
                      $ComponentName  = "hidden removeThis";
                      $DetailsChart   = "pull-left";
                      $InputFields    = "pull-right";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 5:
                      $ComponentName  = "pull-right";
                      $DetailsChart   = "pull-right";
                      $InputFields    = "";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 6:
                      $InputFields    = "pull-left";
                      $ComponentName  = "hidden removeThis";
                      $DetailsChart   = "pull-right";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 7:
                      $ComponentName  = "pull-right";
                      $DetailsChart   = "hidden";
                      $InputFields    = "";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 8:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "pull-right";
                      $InputFields    = "";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 9:
                      $ComponentName  = "";
                      $DetailsChart   = "pull-right";
                      $InputFields    = "hidden";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 10:
                      $ComponentName  = "";
                      $DetailsChart   = "hidden";
                      $InputFields    = "pull-right";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 11:
                      $ComponentName  = "pull-right";
                      $DetailsChart   = "";
                      $InputFields    = "hidden";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 12:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "";
                      $InputFields    = "";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-6";
                      break;

                      case 13:
                      $ComponentName  = "";
                      $DetailsChart   = "hidden";
                      $InputFields    = "pull-right";
                      $length         = "col-sm-6";
                      $cklength       = "col-md-12";
                      break;

                      case 14:
                      $InputFields    = "";
                      $ComponentName  = "pull-right";
                      $DetailsChart   = "hidden";
                      $length         = "col-sm-6";
                      $cklength       = "col-md-12";
                      break;

                      case 15:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "";
                      $InputFields    = "hidden";
                      $length         = "col-sm-12";
                      $cklength       = "col-md-12";
                      break;

                      case 16:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "";
                      $InputFields    = "hidden";
                      $length         = "col-sm-6";
                      $cklength       = "col-md-12";
                      break;

                      case 17:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "";
                      $InputFields    = "pull-right";
                      $length         = "col-sm-6";
                      $cklength       = "col-md-6";
                      break;

                      case 18:
                      $ComponentName  = "hidden";
                      $DetailsChart   = "pull-right";
                      $InputFields    = "";
                      $length         = "col-sm-6";
                      $cklength       = "col-md-6";
                      break;
                    }
                    if($length=='col-sm-6')
                    {
                      $width="col-md-6";
                      $width1="col-md-6";
                    }
                    else
                    {
                      $width="col-md-2";
                      $width1="col-md-4";
                    }

                    if ($row1['ShowHide'] == 0)
                    {

                      $hidden="";

                    }

                    else
                    {

                      $hidden= "hidden";

                    }

                    switch ($row1['InputFieldOrder']) {
                      case 1:

                      $labelC="";
                      $labelL="pull-right";
                      break;

                      case 2:

                      $labelL="";
                      $labelC="pull-right";
                      break;

                      case 3:

                      $labelC="";
                      $labelL="hidden";
                      break;

                      case 4:

                      $labelC="hidden";
                      $labelL="";
                      break;
                    }

                   /* if($row1['Current'] == 1){
                      $labelhide="";
                      $lblhide="";
                    }
                    elseif($row1['InputFieldOrder'] == 2){
                      $labelhide="";
                      $lblhide="";
                    }
                    elseif($row1['InputFieldOrder'] == 3){
                        $labelhide="hidden";
                        $lblhide="";
                    }
                    else{
                        $labelhide="";
                        $lblhide="hidden";
                      }*/



                //if ($row1['Area_Name']==$areaname)
                //{
                  //echo $row1['Area_Name']." - ".$areaname;
                  //echo $row1['Comp_Name'];
                      

                      $sql1 ="SELECT gl.SubLink_ID,gp.*,gr.Outcome_Name,gcomp.Comp_Name FROM game_personalize_outcome gp LEFT JOIN GAME_LINKAGE_SUB gl ON gl.SubLink_CompID=gp.Outcome_CompId AND gl.SubLink_LinkID=gp.Outcome_LinkId LEFT JOIN game_outcome_result gr ON gr.Outcome_ResultID = gp.Outcome_FileType LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gl.SubLink_ID LEFT JOIN GAME_COMPONENT gcomp ON gcomp.Comp_ID = gp.Outcome_CompId  WHERE gi.input_user=$userid AND gp.Outcome_GameId=$gameid AND gl.SubLink_Type=1 AND gl.SubLink_SubCompID=0  AND ".$row1['Current']." >= gp.Outcome_MinVal AND ".$row1['Current']."<=gp.Outcome_Maxval AND Outcome_CompId=".$row1['CompID']." AND gp.Outcome_IsActive=0 ORDER BY gp.Outcome_Order";
                       //print_r( $sql1);

                      $object2      = $functionsObj->ExecuteQuery($sql1);
                      
                      echo "<div class='".$length." scenariaListingDiv ".$hidden."'>";

                      echo "<div class='col-sm-2 ".$width." regular text-center ".$ComponentName."'>";

                      echo $row1['Comp_Name'];
                      echo "</div>";
                      echo "<div class='col-sm-4 ".$cklength." no_padding ".$DetailsChart."'>".$row1['Description']."</div>";

                      echo "<div class=' col-sm-6 ".$width1." text-center ".$InputFields."'>";
                      $objectResult = mysqli_fetch_assoc($object2);    		
                      if($row1['CompID']==$objectResult['Outcome_CompId'])
                      {
                        echo "<div class   ='InlineBox'>";       
                        echo "<label class ='scenariaLabel'>OutcomeResult</label>";
                        echo "<img id      ='img' src='".site_root."ux-admin/upload/".$objectResult['Outcome_FileName']."' alt='Outcome_image' width=100 height=100 />";
                        echo "</div>";
                      }
                      else
                      {
                        echo "<div class='InlineBox ".$labelC."'>";
                        echo "<label class='scenariaLabel'>Label Current</label>";
                        echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value=".$row1['Current']." readonly></input>";
                        echo "</div>";
                        echo "<div class='InlineBox hidden ".$labelL."'>";
                        echo "<label class='scenariaLabel'>Label Last</label>";
                        echo "<input type='text' class='scenariaInput' readonly></input>";
                        echo "</div>";
                           
                      }
                      echo "</div>";   
                     // echo "<pre>"; print_r($objectRes);
                      
                      if($row1['ViewingOrder'] == 4)
                      {
                        echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['Comp_Name']." </div>";
                      }
                      if($row1['ViewingOrder'] == 6)
                      {
                        echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['Comp_Name']." </div>";
                      }

                      echo "<div class='clearfix'></div>";

                  //Get SubComponent for this Component, linkid
                      $sqlsubcomp = "SELECT distinct a.Area_ID as AreaID, ls.SubLink_CompID as CompID, ls.SubLink_SubCompID as SubCompID,  
                      a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name,ls.SubLink_ViewingOrder as ViewingOrder,
                      ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast,ls.SubLink_InputFieldOrder as InputFieldOrder,
                      ls.subLink_ShowHide as ShowHide,
                      ls.SubLink_Details as Description 
                      FROM GAME_LINKAGE l 
                      INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                      INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                      INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                      INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                      LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                      INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                      WHERE ls.SubLink_Type=1 AND ls.SubLink_SubCompID>0 and ls.SubLink_CompID=".$row1['CompID']." ORDER BY ls.SubLink_Order";
                    //echo $sqlsubcomp;exit;

                      $subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
                  //Get Component for this area for this linkid
                      while($row2 = mysqli_fetch_array($subcomponent)){
                        switch ($row2['ViewingOrder']) {
                          case 1:
                          $SubcomponentName  = "";
                          $DetailsChart      = "";
                          $InputFields       = "";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 2:
                          $SubcomponentName  = "";
                          $InputFields       = "";
                          $DetailsChart      = "pull-right";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 3:
                          $DetailsChart     = "";
                          $InputFields      = "";
                          $SubcomponentName = "pull-right";
                          $length           = "col-sm-12";
                          $cklength         = "col-md-6";
                          break;

                          case 4:
                          $SubcomponentName = "hidden removeThis";
                          $DetailsChart     = "pull-left";
                          $InputFields      = "pull-right";
                          $length           = "col-sm-12";
                          $cklength         = "col-md-6";
                          break;

                          case 5:
                          $SubcomponentName  = "pull-right";
                          $DetailsChart      = "pull-right";
                          $InputFields       = "";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 6:
                          $InputFields       = "pull-left";
                          $SubcomponentName  = "hidden removeThis";
                          $DetailsChart      = "pull-right";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 7:
                          $SubcomponentName  = "pull-right";
                          $DetailsChart      = "hidden";
                          $InputFields       = "";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 8:
                          $SubcomponentName  = "hidden";
                          $DetailsChart      = "pull-right";
                          $InputFields       = "";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 9:
                          $SubcomponentName = "";
                          $DetailsChart     = "pull-right";
                          $InputFields      = "hidden";
                          $length           = "col-sm-12";
                          $cklength         = "col-md-6";
                          break;

                          case 10:
                          $SubcomponentName  = "";
                          $DetailsChart      = "hidden";
                          $InputFields       = "pull-right";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 11:
                          $SubcomponentName  = "pull-right";
                          $DetailsChart      = "";
                          $InputFields       = "hidden";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 12:
                          $SubcomponentName  = "hidden";
                          $DetailsChart      = "";
                          $InputFields       = "";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-6";
                          break;

                          case 13:
                          $SubcomponentName  = "";
                          $DetailsChart      = "hidden";
                          $InputFields       = "";
                          $length            = "col-sm-6";
                          $cklength          = "col-md-12";
                          break;

                          case 14:
                          $InputFields       = "";
                          $SubcomponentName  = "pull-right";
                          $DetailsChart      = "hidden";
                          $length            = "col-sm-6";
                          $cklength          = "col-md-12";
                          break;

                          case 15:
                          $SubcomponentName  = "hidden";
                          $DetailsChart      = "";
                          $InputFields       = "hidden";
                          $length            = "col-sm-12";
                          $cklength          = "col-md-12";
                          break;

                          case 16:
                          $SubcomponentName  = "hidden";
                          $DetailsChart      = "";
                          $InputFields       = "hidden";
                          $length            = "col-sm-6";
                          $cklength          = "col-md-12";
                          break;

                          case 17:
                          $SubcomponentName  = "hidden";
                          $DetailsChart      = "";
                          $InputFields       = "pull-right";
                          $length            = "col-sm-6";
                          $cklength          = "col-md-6";
                          break;

                          case 18:
                          $SubcomponentName = "hidden";
                          $DetailsChart     = "pull-right";
                          $InputFields      = "";
                          $length           = "col-sm-6";
                          $cklength         = "col-md-6";
                          break;
                        }

                        if($length=='col-sm-6')
                        {
                          $width="col-md-6";
                          $width1="col-md-6";
                        }
                        else
                        {
                          $width="col-md-2";
                          $width1="col-md-4";
                        }

                        if ($row2['ShowHide'] == 0)
                        {

                          $hidden="";

                        }

                        else
                        {

                          $hidden= "hidden";

                        }

                        switch ($row2['InputFieldOrder']) {
                          case 1:

                          $labelC="";
                          $labelL="pull-right";
                          break;

                          case 2:

                          $labelL="";
                          $labelC="pull-right";
                          break;

                          case 3:

                          $labelC="";
                          $labelL="hidden";
                          break;

                          case 4:

                          $labelC="hidden";
                          $labelL="";
                          break;
                        }


                 /* if($row2['ShowHide'] == 0)
                  {

                  }*/
                // if component div is half length then make subcomponent div col-md-12

                  echo "<div class='".$length." subCompnent".$hidden."'>";
                  echo "<div class='col-sm-2 ".$width." regular text-center".$SubcomponentName."'>";
                  echo $row2['SubComp_Name'];
                  echo "</div>";
                  echo "<div class='col-sm-4 ".$cklength." no_padding".$DetailsChart."'>";
                  echo $row2['Description'];
                  echo "</div>";
                  echo "<div class=' col-sm-6 ".$width1." text-center".$InputFields."'>";
                  echo "<div class='InlineBox ".$labelC."'>";
                  echo "<label class='scenariaLabel'>Label Current</label>";
                  echo "<input type='text' id='subcomp_".$row2['SubCompID']."' name='".$row2['Area_Name']."_subc_".$row2['SubCompID']."' class='scenariaInput' readonly></input>";
                  echo "</div>";
                  echo "<div class='InlineBox ".$labelL."'>";
                  echo "<label class='scenariaLabel'>Label Last</label>";
                  echo "<input type='text' class='scenariaInput' readonly></input>";
                  echo "</div>";
                      //echo "<div class='InlineBox'>";
                      //  echo "<label class='scenariaLabel'>Difference</label>";
                      //  echo "<input type='text' class='scenariaInput' readonly></input>";
                      //echo "</div>";
                      //echo "<div class='InlineBox'>";
                        //echo "<label class='scenariaLabel'>Change %</label>";
                        //echo "<input type='text' class='scenariaInput' readonly></input>";
                      //echo "</div>";
                  echo "</div>";
                  if($row2['ViewingOrder'] == 4)
                  {
                    echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['SubComp_Name']." </div>";
                  }
                  if($row2['ViewingOrder'] == 6)
                  {
                    echo "<div class='col-sm-2 ".$width." text-center regular'>".$row1['SubComp_Name']." </div>";
                  }
                  echo "<div class='clearfix'></div>";
                  echo "</div>";

                }
                echo "</div>";  
                //}
                //else{

                //}
              }
              //<!--scenariaListingDiv-->
              echo "</div>";
            }
            ?>
          </div>
        </div> <!--tab content -->
        <div class="clearix"></div>
      </div>

      <!-- according the output result show the outcome result   -->
      <div class="panel-body">
        <div class="dataTable_wrapper">
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>Sr. No</th>
                <th id="password">OutputComponent</th>
                <th class="no-sort" >KeyValue</th>
                <th class="no-sort" >CurrentValue</th>
                <th class="no-sort" >MinValue</th>
                <th class="no-sort" >MaxValue</th>
                <th class="no-sort" >OutcomeResult</th> 
                <th class="no-sort" >OutcomeImage</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i=1; while($row = $object->fetch_object()){ ?>
                <tr>
                  <th><?php echo $i;?></th>
                  <td><?php echo $row->Comp_Name;?></td>
                  <td><?php echo $row->input_key;?></td>
                  <td><?php echo $row->input_current;?></td>
                  <td><?php echo $row->Outcome_MinVal;?></td>
                  <td><?php echo $row->Outcome_MaxVal;?></td>
                  <td><?php echo $row->Outcome_Name;?></td>
                  <td><img id="img" src="ux-admin/upload/<?php echo $row->Outcome_FileName;?>" alt="Outcome_image" width=100 height=100 /></td>

                </tr>
                <?php $i++; } ?>
              </tbody>
            </table>
          </div>
        </div>
        <!-- end of outcome result -->

        <div class="col-sm-12 text-right">
          <!--<button class="btn innerBtns">Save</button>-->
          <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Next</button>
        </div>

      </div><!--row-->
    </form>
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
    <!-- <script>
    $(document).ready(function(){
      $(".removeThis").each(function(){
        $(this).remove();
      });
      $(".InlineBox").each(function(){
        $(this).hidden();
      });
    });
  </script> -->
</body>
</html>
