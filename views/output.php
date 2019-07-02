<style>
 input[type=text] {
  border-radius: 12px;
  /*border       : none;*/
  text-align   : center !important; 
}
</style>
<?php 
include_once 'includes/header.php'; 
?>
<section id="video_player">
	<div class="container">
		<div class="row">
        <!--<div class="col-sm-9 col-md-10 no_padding"><h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Game." | ".$result->Scenario ; }?> Your Output</h2></div>
        	<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->
          <div class="col-md-12 InnerPageHeader">
            <?php if(!empty($result)){ echo $result->Scenario ; }?>
            <button type="button" name="submit" id="submitShow" class="btn btn-primary pull-right" value="Submit">Next</button>
          </div>
          <form method="POST" action="" id="game_frm" name="game_frm">
            <input type="hidden" name="ScenarioId" id="ScenarioId" value="<?php echo $result->Link_ScenarioID; ?>">
            <input type="hidden" name="LinkId" id="LinkId" value="<?php echo ($result->Link_ID)?$result->Link_ID:$linkid; ?>">
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
            	<!-- <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Download">Download</button> -->
            	<button type="submit" name="submit" id="submit" class="btn btn-primary hidden" value="Submit">Next</button>
            </div>
            
            <!-- Nav tabs --> 
            <div class=" TabMain col-sm-12">
            	<ul class="nav nav-tabs" role="tablist">
            		<?php 
            		$i=0;
            		while($row = mysqli_fetch_array($area)) {
                    //echo $row->Area_Name;
            			if($row['BackgroundColor'] || $row['TextColor'])
            			{
            				$areaStyle = "style='background:".$row['BackgroundColor']."; color:".$row['TextColor']." !important;'";
            			}
            			else
            			{
            				$areaStyle = '';
            			}
                  // adding backForward class to click the forward and back button and move the area accordingly
            			if($i==0)
            			{
            				echo "<li role='presentation' class='backForward active regular' id='".$row['Area_Name']."'><a href='#".$row['Area_Name']."Tab' $areaStyle aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
            			}else{
            				echo "<li role='presentation' class='backForward regular' id='".$row['Area_Name']."'><a href='#".$row['Area_Name']."Tab' $areaStyle aria-controls='".$row['Area_Name']."'Tab role='tab' data-toggle='tab'>".$row['Area_Name']."</a></li>";
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
                $i    = 0;
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

                  // $sqlcomp = "SELECT distinct a.Area_ID as AreaID, c.Comp_ID as CompID, a.Area_Name as Area_Name, 
                  // c.Comp_Name as Comp_Name, ls.SubLink_Details as Description ,ls.SubLink_ViewingOrder as ViewingOrder, ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast, ls.SubLink_InputFieldOrder as InputFieldOrder,ls.Sublink_ShowHide as ShowHide , o.output_current as Current ,ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor
                  // FROM GAME_LINKAGE l 
                  // INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID= ls.SubLink_LinkID 
                  // INNER JOIN GAME_OUTPUT o on ls.SubLink_ID = o.output_sublinkid
                  // INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                  // INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                  // INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                  // LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                  // INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                  // WHERE ls.SubLink_Type=1 AND o.output_user=".$userid." AND ls.SubLink_SubCompID=0 and l.Link_ID=".$linkid." and a.Area_ID=".$row['AreaID']." ORDER BY ls.SubLink_Order";
                $sqlcomp = "SELECT 
                ga.Area_ID AS AreaID,
                gc.Comp_ID AS CompID,
                ga.Area_Name AS Area_Name,
                gc.Comp_Name AS Comp_Name,
                gls.SubLink_Details AS Description,
                gls.SubLink_ViewingOrder AS ViewingOrder,
                gls.SubLink_LabelCurrent AS LabelCurrent,
                gls.SubLink_LabelLast AS LabelLast,
                gls.SubLink_InputFieldOrder AS InputFieldOrder,
                gls.Sublink_ShowHide AS ShowHide,
                go.output_current AS CURRENT,
                gls.SubLink_BackgroundColor AS BackgroundColor,
                gls.SubLink_TextColor AS TextColor,
                gls.SubLink_InputMode as Mode,
                gls.Sublink_AdminCurrent as AdminCurrent,
                gls.SubLink_LinkIDcarry as CarryLinkID,
                gls.SubLink_CompIDcarry as CarryCompID,
                gls.SubLink_SubCompIDcarry as CarrySubCompID,
                gls.SubLink_ID as SubLinkID,
                gls.SubLink_FontSize as fontSize,
                gls.SubLink_FontStyle as fontStyle
                FROM GAME_LINKAGE_SUB gls 
                LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID
                LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gls.SubLink_CompID
                LEFT JOIN GAME_SUBCOMPONENT gsc ON gsc.SubComp_ID=gls.SubLink_SubCompID
                LEFT JOIN GAME_AREA ga ON ga.Area_ID=gls.SubLink_AreaID
                LEFT JOIN GAME_OUTPUT go ON go.output_sublinkid=gls.SubLink_ID AND go.output_user=$userid
                WHERE
                gls.SubLink_Type = 1 AND gls.SubLink_SubCompID = 0 AND gls.SubLink_LinkID=".$linkid." AND gls.SubLink_AreaID=".$row['AreaID']."	GROUP BY gls.SubLink_ID ORDER BY gls.SubLink_Order";
                  // echo $sqlcomp; exit;
                $component = $functionsObj->ExecuteQuery($sqlcomp);
              //Get Component for this area for this linkid
                while($row1 = mysqli_fetch_array($component)){ 
                  switch ($row1['ViewingOrder']) {
                      //Name - detailsChart - inputfields
                   case 1:
                   $ComponentName  = "";
                   $DetailsChart   = "";
                   $InputFields    = "";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                    //Name - inputfields - Detailschart
                   case 2:
                   $ComponentName  = "";
                   $InputFields    = "";
                   $DetailsChart   = "pull-right";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                    //Detailchart - inputfields - Name
                   case 3:
                   $DetailsChart   = "";
                   $InputFields    = "";
                   $ComponentName  = "pull-right";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //detailchart - inputfields
                   case 4:
                   $ComponentName  = "hidden removeThis";
                   $DetailsChart   = "pull-left";
                   $InputFields    = "pull-right";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //inputfields - detailschart - Name
                   case 5:
                   $ComponentName  = "pull-right";
                   $DetailsChart   = "pull-right";
                   $InputFields    = "";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //inputfiels - detailchart
                   case 6:
                   $InputFields    = "pull-left";
                   $ComponentName  = "hidden removeThis";
                   $DetailsChart   = "pull-right";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                    //inputfield - name - fullLength
                   case 7:
                   $ComponentName  = "pull-right";
                   $DetailsChart   = "hidden";
                   $InputFields    = "";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //inputfield - detailchart
                   case 8:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "pull-right";
                   $InputFields    = "";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //Name - detailchart
                   case 9:
                   $ComponentName  = "";
                   $DetailsChart   = "pull-right";
                   $InputFields    = "hidden";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //Name - inputfields - fullLength
                   case 10:
                   $ComponentName  = "";
                   $DetailsChart   = "hidden";
                   $InputFields    = "pull-right";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                    //detailschart - Name
                   case 11:
                   $ComponentName  = "pull-right";
                   $DetailsChart   = "";
                   $InputFields    = "hidden";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //Detailschart - inputfields
                   case 12:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "";
                   $InputFields    = "";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-6";
                   break;

                     //Name - inputfields - halfLength
                   case 13:
                   $ComponentName  = "";
                   $DetailsChart   = "hidden";
                   $InputFields    = "pull-right";
                   $length         = "col-sm-6";
                   $cklength       = "col-md-12";
                   break;

                    //Inputfiels - Name - halfLength
                   case 14:
                   $InputFields    = "";
                   $ComponentName  = "pull-right";
                   $DetailsChart   = "hidden";
                   $length         = "col-sm-6";
                   $cklength       = "col-md-12";
                   break;

                     //CkEditor - fullLength
                   case 15:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "";
                   $InputFields    = "hidden";
                   $length         = "col-sm-12";
                   $cklength       = "col-md-12";
                   break;

                     //CkEditor - halfLength
                   case 16:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "";
                   $InputFields    = "hidden";
                   $length         = "col-sm-6";
                   $cklength       = "col-md-12";
                   break;

                    // ckEditor - InputFields - HalfLength
                   case 17:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "";
                   $InputFields    = "pull-right";
                   $length         = "col-sm-6";
                   $cklength       = "col-md-6";
                   break;

                     // InputFields - ckEditor - HalfLength
                   case 18:
                   $ComponentName  = "hidden";
                   $DetailsChart   = "pull-right";
                   $InputFields    = "";
                   $length         = "col-sm-6";
                   $cklength       = "col-md-6";
                   break;

                    //Name - Detailchart - halfLength
                   case 19:
                   $ComponentName  = "";
                   $DetailsChart   = "pull-right";
                   $InputFields    = "hidden";
                   $length         = "col-sm-6";
                   $cklength       = 'col-md-6';
                   break;
                 }

                 if($length == 'col-sm-6')
                 {
                   $width  = "col-md-6";
                   $width1 = "col-md-6";
                 }
                 else
                 {
                   $width  = "col-md-2";
                   $width1 = "col-md-4";
                 }
                 if ($row1['ShowHide'] == 0)
                 {
                   $hidden = "";
                 }
                 else
                 {
                   $hidden = "hidden";
                 }
                    // echo $row1['ShowHide'].' and '.$hidden; exit();
                 switch ($row1['InputFieldOrder']) {
                   case 1:
                   $labelC = "";
                   $labelL = "pull-right";
                   break;

                   case 2:
                   $labelL = "";
                   $labelC = "pull-right";
                   break;

                   case 3:
                   $labelC = "";
                   $labelL = "hidden";
                   break;

                   case 4:
                   $labelC = "hidden";
                   $labelL = "";
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
                      if ($row1['Mode']=="none")
                      {
                        // if mode none then show only ckEditor
                        $ShowHide = 'hidden';
                      }
                      else
                      {
                        $ShowHide = '';
                      }
                      // finding mode and valu of input field accordingly
                      switch ($row1['Mode']) {
                        case 'carry':
                        $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` 
                        WHERE input_user=".$userid." AND input_sublinkid = 
                        (SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` 
                        WHERE SubLink_LinkID=".$row1['CarryLinkID']." and SubLink_CompID=".$row1['CarryCompID'];
                        if($row1['CarrySubCompID']>0)         
                        {
                          $sqlcurrent .= " AND SubLink_SubCompID = ".$row1['CarrySubCompID'];
                        }          
                        $sqlcurrent .= ")";
                        // echo $sqlcurrent;
                        $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                        $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                        $value           = $rescarry->input_current;
                        break;

                        case 'admin':
                        $value = $row1['AdminCurrent'];
                        break;

                        case 'formula':
                        // $formulaSql = "SELECT input_current FROM GAME_INPUT WHERE input_sublinkid =".$row1['SubLinkID']." AND input_user=".$userid;
                        // // echo $formulaSql;
                        // $formulaCurrent = $functionsObj->ExecuteQuery($formulaSql);
                        // $formaulValue   = $functionsObj->FetchObject($formulaCurrent);
                        // if(!$formaulValue->input_current)
                        // {
                        //   // $value = $formaulValue->input_current;
                        //   $value = $row1['CURRENT'];
                        // }
                        $value = $row1['CURRENT'];
                        break;
                        
                        default:
                        // if the value is null then make it 0
                        $value = ($row1['CURRENT'] != '')?$row1['CURRENT']:'0';
                        break;
                      }

                      if(empty($value) || $value=='')
                      {
                        $value = 0;
                      }

                      echo "<div class='".$length." scenariaListingDiv ".$hidden."' style='background:".$row1['BackgroundColor']."; color:".$row1['TextColor'].";'>";

                      echo "<div class='col-sm-2 ".$width." regular text-center ".$ComponentName." ".$ShowHide."' style='font-size: ".$row1['fontSize']."px; font-family: ".$row1['fontStyle'].";'>";

                      echo $row1['Comp_Name'];
                      echo "</div>";
                      echo "<div class='col-sm-4 ".$cklength." no_padding ".$DetailsChart."'>".$row1['Description']."</div>";

                      echo "<div class=' col-sm-6 ".$width1." text-center ".$InputFields." ".$ShowHide."'>";
                      $sqlOutcome = "SELECT * FROM GAME_PERSONALIZE_OUTCOME gpo WHERE gpo.Outcome_CompId=".$row1['CompID']." AND gpo.Outcome_LinkId=".$linkid." AND ".$value.">=gpo.Outcome_MinVal AND ".$value."<=gpo.Outcome_MaxVal AND gpo.Outcome_IsActive=0 ORDER BY Outcome_Order";
                      $objRes              = $functionsObj->ExecuteQuery($sqlOutcome);
                      $Outcome_Description = "";
                      if($objRes->num_rows > 0)
                      {
                       while($objectResult = $functionsObj->FetchObject($objRes))
                       {
	                      	// echo "<pre>".$row1['CURRENT'].' mk '.$sqlOutcome; print_r($objectResult); echo "</pre>";
		                      // if same component and not the default outcome selected i.e. 3
                        if($objectResult->Outcome_FileType !=3 && ($value>=$objectResult->Outcome_MinVal AND $value<=$objectResult->Outcome_MaxVal))
                        {
                          $Outcome_Description = $objectResult->Outcome_Description;
                          echo "<div class ='InlineBox'>";
		                        // echo "<label class ='scenariaLabel'>OutcomeResult</label>";
                          echo "<img id='".$objectResult->Outcome_FileName."' src='".site_root."ux-admin/upload/Badges/".$objectResult->Outcome_FileName."' alt='Outcome_image' width=100 height=100 />";
                          echo "</div>";
                          echo "<div class='InlineBox hidden ".$labelC."'>";
                          echo "<label class='scenariaLabel'>".$row1['LabelCurrent']."</label>";
                          echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value='".$value."' readonly></input>";
                          echo "</div>";
                          break;
                        }
                      }
                    }
                    else
                    {
                     echo "<div class='InlineBox ".$labelC."'>";
                     echo "<label class='scenariaLabel'>".$row1['LabelCurrent']."</label>";
                     echo "<input type='text' id='comp_".$row1['CompID']."' name='".$row1['Area_Name']."_comp_".$row1['CompID']."' class='scenariaInput' value='".$value."' readonly></input>";
                     echo "</div>";
                     echo "<div class='InlineBox ".$labelL."'>";
                     echo "<label class='scenariaLabel'>".$row1['LabelLast']."</label>";
                     echo "<input type='text' class='scenariaInput' value='".$row1['Last']."' readonly></input>";
                     echo "</div>";
                   }

                   echo "</div>";
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
                   go.output_current AS outputValue,
                   a.Area_Name as Area_Name, c.Comp_Name as Comp_Name, s.SubComp_Name as SubComp_Name,ls.SubLink_ViewingOrder as ViewingOrder,
                   ls.SubLink_LabelCurrent as LabelCurrent, ls.SubLink_LabelLast as LabelLast,ls.SubLink_InputFieldOrder as InputFieldOrder,
                   ls.subLink_ShowHide as ShowHide,
                   ls.SubLink_Details as Description ,ls.SubLink_BackgroundColor as BackgroundColor, ls.SubLink_TextColor as TextColor, ls.SubLink_FontSize as fontSize, ls.SubLink_FontStyle as fontStyle, ls.SubLink_InputMode as Mode, ls.SubLink_LinkIDcarry as CarryLinkID, ls.SubLink_CompIDcarry as CarryCompID, ls.SubLink_SubCompIDcarry as CarrySubCompID
                   FROM GAME_LINKAGE l 
                   INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                   INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                   INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                   INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                   LEFT JOIN GAME_OUTPUT go ON go.output_sublinkid=ls.SubLink_ID AND go.output_user=$userid
                   LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                   INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                   WHERE ls.SubLink_Type=1 AND ls.SubLink_SubCompID>0 and ls.SubLink_CompID=".$row1['CompID']." ORDER BY ls.SubLink_Order";
                    //echo $sqlsubcomp;exit;

                   $subcomponent = $functionsObj->ExecuteQuery($sqlsubcomp);
                  //Get Component for this area for this linkid
                   while($row2 = mysqli_fetch_array($subcomponent)){
                     switch ($row2['ViewingOrder']) {
                       // Name - Details/Chart - InputFields
                      case 1:
                      $SubcomponentName  = "";
                      $DetailsChart      = "";
                      $InputFields       = "";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                       // Name - InputFields - Details/Chart
                      case 2:
                      $SubcomponentName  = "";
                      $InputFields       = "";
                      $DetailsChart      = "pull-right";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                     // Details/Chart - InputFields - Name
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

                      // InputFields - Details/Chart - Name
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

                       // InputFields - Name - FullLength
                      case 7:
                      $SubcomponentName  = "pull-right";
                      $DetailsChart      = "hidden";
                      $InputFields       = "";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                      // InputFields - Details/Chart
                      case 8:
                      $SubcomponentName  = "hidden";
                      $DetailsChart      = "pull-right";
                      $InputFields       = "";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                       // Name - Details/Chart
                      case 9:
                      $SubcomponentName = "";
                      $DetailsChart     = "pull-right";
                      $InputFields      = "hidden";
                      $length           = "col-sm-12";
                      $cklength         = "col-md-6";
                      break;

                       // Name - InputFields - FullLength
                      case 10:
                      $SubcomponentName  = "";
                      $DetailsChart      = "hidden";
                      $InputFields       = "pull-right";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                      // Details/Chart - Name
                      case 11:
                      $SubcomponentName  = "pull-right";
                      $DetailsChart      = "";
                      $InputFields       = "hidden";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                      // Details/Chart - InputFields
                      case 12:
                      $SubcomponentName  = "hidden";
                      $DetailsChart      = "";
                      $InputFields       = "";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-6";
                      break;

                      // Name - InputFields - HalfLength
                      case 13:
                      $SubcomponentName  = "";
                      $DetailsChart      = "hidden";
                      $InputFields       = "";
                      $length            = "col-sm-6";
                      $cklength          = "col-md-12";
                      break;

                      // InputFields - Name - HalfLength
                      case 14:
                      $InputFields       = "";
                      $SubcomponentName  = "pull-right";
                      $DetailsChart      = "hidden";
                      $length            = "col-sm-6";
                      $cklength          = "col-md-12";
                      break;

                      // CkEditor - FullLength
                      case 15:
                      $SubcomponentName  = "hidden";
                      $DetailsChart      = "";
                      $InputFields       = "hidden";
                      $length            = "col-sm-12";
                      $cklength          = "col-md-12";
                      break;

                      // CkEditor - HalfLength
                      case 16:
                      $SubcomponentName  = "hidden";
                      $DetailsChart      = "";
                      $InputFields       = "hidden";
                      $length            = "col-sm-6";
                      $cklength          = "col-md-12";
                      break;

                      // ckEditor - InputFields - HalfLength
                      case 17:
                      $SubcomponentName  = "hidden";
                      $DetailsChart      = "";
                      $InputFields       = "pull-right";
                      $length            = "col-sm-6";
                      $cklength          = "col-md-6";
                      break;

                      // InputFields - ckEditor - HalfLength
                      case 18:
                      $SubcomponentName = "hidden";
                      $DetailsChart     = "pull-right";
                      $InputFields      = "";
                      $length           = "col-sm-6";
                      $cklength         = "col-md-6";
                      break;

                       // Name - Details/Chart - HalfLength
                      case 19:
                      $SubcomponentName  = "";
                      $DetailsChart      = "pull-right";
                      $InputFields       = "hidden";
                      $length            = "col-sm-6";
                      $cklength          = 'col-md-6';
                      break;

                      //ck-editor 1/4 length
                      case 20:
                      $SubcomponentName = "hidden";
                      $DetailsChart     = "";
                      $InputFields      = "hidden";
                      $length           = "col-md-3";
                      $cklength         = 'col-md-12';
                      break;

                      //inputfields 1/4 length
                      case 21:
                      $SubcomponentName = "hidden";
                      $DetailsChart     = "hidden";
                      $InputFields      = "";
                      $length           = "col-md-3";
                      $cklength         = 'col-md-12';
                      break;
                    }

                    if($length  ==  'col-sm-6')
                    {
                      $width  = "col-md-6";
                      $width1 = "col-md-6";
                    }
                    elseif($length  ==  'col-sm-12')
                    {
                      $width  = "col-md-2";
                      $width1 = "col-md-4";
                    }
                    else
                    {
                     $width1 = "col-md-12";
                   }
                    //for show and hide components and subcomponents
                   if ($row2['ShowHide'] == 0)
                   {
                    $hidden = "";
                  }
                  else
                  {
                    $hidden = "hidden";
                  }

                  switch ($row2['InputFieldOrder'])
                  {
                    case 1:
                    $labelC = "";
                    $labelL = "pull-right";
                    break;

                    case 2:
                    $labelL = "";
                    $labelC = "pull-right";
                    break;

                    case 3:
                    $labelC = "";
                    $labelL = "hidden";
                    break;

                    case 4:
                    $labelC = "hidden";
                    $labelL = "";
                    break;
                  }
                 /* if($row2['ShowHide'] == 0)
                  {

                  }*/
                // if component div is half length then make subcomponent div col-md-12
                  if($row2['Mode'] == 'carry')
                  {
                    $sqlcurrent = "SELECT input_current FROM `GAME_INPUT` 
                    WHERE input_user=".$userid." AND input_sublinkid = 
                    (SELECT SubLink_ID FROM `GAME_LINKAGE_SUB` 
                    WHERE SubLink_LinkID=".$row2['CarryLinkID']." and SubLink_CompID=".$row2['CarryCompID'];
                    if($row2['CarrySubCompID']>0)         
                    {
                      $sqlcurrent .= " AND SubLink_SubCompID = ".$row2['CarrySubCompID'];
                    }          
                    $sqlcurrent .= ")";
                    $objcarrycurrent = $functionsObj->ExecuteQuery($sqlcurrent);
                    $rescarry        = $functionsObj->FetchObject($objcarrycurrent);
                    $opValue         = $rescarry->input_current;
                  }
                  else
                  {
                    $opValue = $row2['outputValue'];
                  }
                  echo "<div class='".$length." subCompnent ".$hidden."' style='background:".$row2['BackgroundColor']."; color:".$row2['TextColor'].";'>";
                  echo "<div class='col-sm-2 ".$width." regular text-center ".$SubcomponentName."' style='font-size: ".$row2['fontSize']."px; font-family: ".$row2['fontStyle'].";'>";
                  echo $row2['SubComp_Name'];
                  echo "</div>";
                  echo "<div class='col-sm-4 ".$cklength." no_padding ".$DetailsChart."'>";
                  echo $row2['Description'];
                  echo "</div>";
                  echo "<div class=' col-sm-6 ".$width1." text-center ".$InputFields."'>";
                  echo "<div class='InlineBox ".$labelC."'>";
                  echo "<label class='scenariaLabel'>".$row2['LabelCurrent']."</label>";
                  echo "<input type='text' id='subcomp_".$row2['SubCompID']."' name='".$row2['Area_Name']."_subc_".$row2['SubCompID']."' class='scenariaInput' readonly ".$row2['Mode']." value='".$opValue."'></input>";
                  echo "</div>";
                  echo "<div class='InlineBox ".$labelL."'>";
                  echo "<label class='scenariaLabel'>".$row2['LabelLast']."</label>";
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
                  	echo "<div class='col-sm-2 ".$width." text-center regular'>".$row2['SubComp_Name']." </div>";
                  }
                  if($row2['ViewingOrder'] == 6)
                  {
                  	echo "<div class='col-sm-2 ".$width." text-center regular'>".$row2['SubComp_Name']." </div>";
                  }
                  echo "<div class='clearfix'></div>";
                  echo "</div>";

                }
                echo "</div>";
                if(!empty($Outcome_Description)){
                  ?>
                  <!-- adding this div here to show the description for outcome badges -->
                  <div class="scenariaListingDiv <?php echo $length;?>">
                    <center>
                      <?php echo $Outcome_Description;?>
                    </center>
                  </div>
                  <?php
                }
                //}
                //else{

                //}
              }
              //<!--scenariaListingDiv-->

              echo "</div>";
            }
            ?>
            <!-- adding next and previous buttons -->
            <div class="">
              <button type="button" class="btn btn-primary pull-right" id="goForward">Go Forward</button>
              <button type="button" class="btn btn-primary pull-right hidden" id="submitBtn2">Next</button>
              <button type="button" class="btn btn-primary" id="goBackward">Go Back</button>
            </div>
            <!-- end of adding next and previous buttons -->
          </div>
        </div> <!--tab content -->
        <div class="clearfix"></div>
      </div>          

      <div class="col-sm-12 text-right">
      	<!--<button class="btn innerBtns">Save</button>-->
      	<button type="submit" name="submit" id="submit" class="btn innerBtns hidden" value="Download">Download</button>
      	<!-- <button type="submit" name="submit" id="submit" class="btn innerBtns" value="Submit">Next</button> -->
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
<script>
	$(document).ready(function(){
		$(".removeThis").each(function(){
			$(this).remove();
		});
    $('#submitShow').on('click',function(){
      $('#submit').trigger('click');
    });
    // functionality to move forward and backward using 'go forward' and 'go back' buttons starts here
    id_count             = 0;
    backForward_id_array = {};
    currentActive_li     = '';
    nextActive_li        = '';
    prevActive_li        = '';
    setFlagForNext       = false;
    setFlagForPrev       = true;
    // console.log(parseInt(prevActive_li)+' : '+parseInt(currentActive_li)+' : '+parseInt(nextActive_li)+' : '+parseInt(id_count));
    $('.backForward').each(function(){
      var li_id = $(this).attr('id');
      if($(this).hasClass('hidden'))
      {
        console.log('li ID: '+li_id+' has class hidden');
      }
      else
      {
        $(this).attr('data-sequence',id_count); // setting the data-sequence for li
        $(this).children('a').attr('data-sequence',id_count); // setting the data-sequence for li children a
        // adding a to li_id value i.e. it's ID+a to trigger click on it's child element a to make it active
        backForward_id_array[id_count] = li_id+' a';
        addClickHandler(li_id+' a');
        if($(this).hasClass('active'))
        {
          currentActive_li = id_count;
          setFlagForNext   = true;
          setFlagForPrev   = false;
        }
        else
        {
          if(setFlagForNext)
          {
            nextActive_li  = id_count;
            setFlagForNext = false;
          }
          if(setFlagForPrev)
          {
            prevActive_li = id_count;
          }
        }
        id_count++;
      }
    });
    
    backForwardButtonsToggle();
    // while someone directly clicks to tab then match the value for prev, next and current active li accordingly
    
    function addClickHandler(li_child_a){
      $('#'+li_child_a).on('click',function(){
        if(!$(this).parent('li').hasClass('hidden'))
        {
          var data_sequence = $(this).attr('data-sequence');
          prevActive_li     = data_sequence-1;
          currentActive_li  = data_sequence;
          nextActive_li     = parseInt(data_sequence)+1;
          // alert(prevActive_li+' : '+currentActive_li+' : '+nextActive_li+' : '+id_count);
          backForwardButtonsToggle();
        }
      });
    }

    $('#goForward').on('click',function(){
      $('#'+backForward_id_array[nextActive_li]).trigger('click');
    });

    $('#goBackward').on('click',function(){
      $('#'+backForward_id_array[prevActive_li]).trigger('click');
    });

    // submit from bottom submit button as well
    $('#submitBtn2').on('click',function(){
      $('#submit').trigger('click');
    });
    // functionality to move forward and backward using 'go forward' and 'go back' buttons ends here

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

    function backForwardButtonsToggle()
    {
      // if there is no next and prev i.e. there is only one area so hide goForward and goBackward buttons
      if(parseInt(id_count) < 2)
      {
        $('#goForward').addClass('hidden');
        $('#submitBtn2').addClass('hidden');
        $('#goBackward').addClass('hidden');  
      }
      else
      {
        // hide/show the goForward, goBackward and submit(downside) buttons accordingly
        // i.e. loaded first area selected or go to first area by clicking
        if((isNaN(parseInt(prevActive_li)) || parseInt(prevActive_li)<0) && parseInt(nextActive_li)<parseInt(id_count))
        {
          $('#goForward').removeClass('hidden');
          $('#submitBtn2').addClass('hidden');
          $('#goBackward').addClass('hidden');  
        }

        else if((isNaN(parseInt(nextActive_li)) || parseInt(nextActive_li)==parseInt(id_count)) && parseInt(prevActive_li)>=0)
        {
          $('#goForward').addClass('hidden');
          $('#submitBtn2').removeClass('hidden');
          $('#goBackward').removeClass('hidden');  
        }

        else
        {
          $('#submitBtn2').addClass('hidden');
          $('#goForward').removeClass('hidden');
          $('#goBackward').removeClass('hidden');  
        }
      }
      // console.log(parseInt(prevActive_li)+' : '+parseInt(currentActive_li)+' : '+parseInt(nextActive_li)+' : '+parseInt(id_count));
    }
  });
</script>
</body>
</html>
