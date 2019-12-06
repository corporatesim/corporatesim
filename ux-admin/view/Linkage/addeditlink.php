<!-- <?php // echo "<pre>"; print_r($object1->fetch_object()); exit; ?> -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/linkage/linkdel/";
     var loc_url_stat = "ux-admin/linkage/linkstat/";
  //-->
</script>
<style type="text/css">
  span.alert-danger {
    background-color: #ffffff;
    font-size       : 18px;
  }
  .checkedDefault{
    margin-left: 5px !important;
  }
</style>
<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>
<!-- Generate alert box when select range & mChoice by user -->
<script type="text/javascript">
  $(document).ready(function()
  {
    <?php if(empty($linkdetails) || $linkdetails->SubLink_SubCompID==0){ ?>
      $('.onlyForSubcomponent').each(function(){
        $(this).attr('disabled',true);
      });
    <?php } ?>
    // adding the font-style and size to demo text for user view
    $('#fontSize,#fontFamily').on('change',function(){
      // if integer then font-size else font-style
      var fontSize   = $('#fontSize').val()+'px';
      var fontFamily = $('#fontFamily :selected').val();
      if(fontFamily.length < 1)
      {
        fontFamily = '"Helvetica Neue",Helvetica,Arial,sans-serif';
      }

      $('#demoText').css({'font-size':fontSize,'font-family':'"'+fontFamily});
      console.log(fontSize+' and '+fontFamily); 
    });
    // end of showing demo font size and style
    // adding options and value on button click
    removeDiv();
    // adding this code to change radio button value for default selection
    makeDefaultChecked();
    // while option text value is changed, change value of it's radio button as well
    changeValueOnChangingText();
    // writing this line to get the comp on change of scen while page load
    <?php if(isset($linkdetails->SubLink_LinkIDcarry)){ ?>
      $('#carry_linkid').trigger('change');
      console.log('trigger change in linkid');
    <?php } ?>

    $('input[type="radio"]').click(function(){
     if($(this).attr("value")=="subcomp"){
      var statusType = 0;
      // if subcomponent then show all dropdowns
      $('.onlyForSubcomponent').each(function(){
        $(this).attr('disabled',false);
      });
      $('#subcomp_id').attr('required',true);
      $("#subcomponent").show();
      $.ajax({
        url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
        type: "POST",
        data: { gameId: '<?php echo $result->Link_GameID; ?>', statusType: statusType },
        success: function(resultData){
          // console.log(resultData);
          $('#chart_id').html(resultData);
        }
      });
    }
    if($(this).attr("value")=="comp"){
      $('#subcomp_id').attr('required',false);
      var statusType = 1;
      // if component then disable all dropdowns implemented for subcomponent only
      $('.onlyForSubcomponent').each(function(){
        $(this).attr('disabled',true);
      });
      $("#subcomponent").hide();
      $.ajax({
        url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
        type: "POST",
        data: { gameId: '<?php echo $result->Link_GameID; ?>', statusType: statusType },
        success: function(resultData){
          $('#chart_id').html(resultData);
        }
      });
    }

    if($(this).attr("value")=="formula"){ 
      $("#formula").show();
      $("#admin").hide();
      $("#carry").hide();     
    }

    if($(this).attr("value")=="admin"){ 
      $("#admin").show();
      $("#formula").hide();
      $("#carry").hide();
    }

    if($(this).attr("value")=="carry"){ 
      $("#carry").show();
      $("#formula").hide();
      $("#admin").hide();
    }

    if($(this).attr("value")=="user"){  
      $("#carry").hide();
      $("#formula").hide();
      $("#admin").hide();
    }
  });
    // adding this to remvoe required from input field to novalidate if hidden or not selected /inputTypeUser
    setTimeout(function(){
      if($('input[name=inputType]:checked').val() != 'user')
      {
        $('.inputTypeUser').each(function(){
          $(this).attr('required',false);
        });
      }
      else
      {
        if($('#SubLink_InputModeType').val() != 'mChoice')
        {
          $('.inputTypeUser').each(function(){
            $(this).attr('required',false);
          });
        }
      }
    },1000);
  });
  /*function label_choice(select){
  
    //console.log('clicked'+select);
    var x = document.getElementById("SubLink_InputFieldOrder");
    document.getElementById("SubLink_InputFieldOrder").options[3].selected=false;
    document.getElementById("SubLink_InputFieldOrder").options[4].selected=false;
    if(x.options[x.selectedIndex].value)
    {
    alert("You have selected Both Labels.");
    }
    
     //alert(select.options[select.selectedIndex].text);
  }
  */
  
  
</script>
<!-- <script src="js/jscolor.js"></script> -->
<!-- change color code hex to rgb -->
<!-- <script type="text/javascript">
  function hexToRgb(hex) {
    // console.log('clicked '+hex);
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex))
    {
      c = hex.substring(1).split('');
      if(c.length == 3)
      {
        c = [c[0], c[0], c[1], c[1], c[2], c[2]];
      }
      c = '0x'+c.join('');
      console.log('rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',1)');
      return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',1)';
    }
  
  }
  
  //jquery to change color format
  // $(document).ready(function(){
  //  $("#changeMe").spectrum({
  //    preferredFormat: "rgb",
  //    showInput: true,
  //    showPalette: true,
  //    palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
  //  });
  
  //  $("#changeMe").spectrum("show");
  //  $("#change").click(function() {
  //    $("#changeMe").spectrum("set", $("#entervalue").val());
  //  });
  // });
</script> -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed">
        <a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a>
      </li>
      <li class="active">
        <a href="<?php echo site_root."ux-admin/linkage"; ?>">Manage Linkage</a>
      </li>
      <li class="active"><?php echo $header; ?></li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading"></div>
      <div class="panel-body">
        <div class="col-sm-12">
          <input type="hidden" name="linkid" id="linkid" 
          value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">                
          <div class="col-sm-6">
            <input type="hidden" name="gameid" id="gameid" value="<?php echo $result->Link_GameID ; ?>">
            <div class="form-group">
              <label>Game : </label><?php echo $result->Game; ?>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Scenario : </label><?php echo $result->Scenario; ?>
            </div>
          </div>
        </div>
        <?php //if(isset($_GET['link'])) { 
          if($linkscenario->num_rows>0) {
            ?>
            <div class="col-sm-12">
              <div class="col-sm-6">
                <label>Copy from Scenario - </label>
                <input type="hidden" name="scenid" id="scenid" value="<?php echo $result->Link_ScenarioID; ?>">
                <select class="form-control" name="scen_id" id="scen_id">
                  <option value="">-- SELECT --</option>
                  <?php while($row = $linkscenario->fetch_object()){ ?>
                    <option value="<?php echo $row->Scen_ID; ?>">
                      <?php echo $row->Scen_Name; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-sm-6">
                <br><button type="button" class="btn btn-primary" name="update_link" id="update_link">Link</button>
              </div>
            </div>
            <div class="clearfix"></div>
          <?php } ?>
          <?php if(!isset($_GET['linkedit']) && empty($_GET['linkedit'])){ ?>
            <form method="POST" action="" id="linkage_frm" name="linkage_frm">
              <br>
              <div class="col-sm-12">
                <input type="hidden" name="Link_ID" id="Link_ID" 
                value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">  
                <button type="submit" name="submit" id="Link_download" class="btn btn-primary"
                value="Download"> Download </button>
              </div>
              <br>
              <hr/>

              <!-- adding new functionality for downloading user report -->
             <!--  <div class="row" id="sandbox-container">
                <div class="col-md-4">
                  <label>Date :</label>From <br>
                  <input type="text" class="form-control"  name="reportDateFrom" id="reportDateFrom" placeholder="yyyy-mm-dd" readonly >
                </div>
                <div class="col-md-4">
                  <label>Date :</label>To <br>
                  <input type="text" class="form-control"  name="reportDateTo" id="reportDateTo" placeholder="yyyy-mm-dd" readonly >
                </div>
                <div class="col-sm-4" style="margin-top: 2%;">
                  <button type="submit" name="submit" id="User_download" class="btn btn-primary"
                  value="UserDownloadNew">Download User Report New</button>
                </div>
              </div> -->
              <!-- end of user download report -->

              <hr>
              <label>Request/Download User Report -</label> <br>
              <div class="col-sm-12" id="sandbox-container">
                <?php  
                $resultReq = $userRequest->fetch_object();
                $reqstatus = $resultReq->status;
                if($reqstatus == 2)
                {
                 ?>
            <!--div class="col-md-3">
              <select class="form-control" name="area_id" id="area_id">
                <option value="">-- SELECT USER --</option>
              </select>
            </div-->
            <div class="col-sm-3">
              <button type="submit" name="submit" id="User_request" class="btn btn-primary"
              value="RequestDownload"> Request User Report</button>
            </div>
            <div class="col-md-3">
              <input type="text" class="form-control"  name="reportDate" placeholder="yyyy-mm-dd" readonly >
            </div>
            <div class="col-sm-3">
              <button type="submit" name="submit" id="User_download" class="btn btn-primary"
              value="UserDownload">Download User Report </button>
            </div>
          <?php } else if($reqstatus == 1) {?>
            <div class="col-sm-6">
              <p><img src='<?=site_root?>images/loading.gif' height='30'> Report being executed, please wait...</p>
            </div>
            <script>
              /* setInterval(function() {
                window.location.reload();
              }, 300000);  */
            </script>
          <?php } else { ?>
            <div class="col-sm-3">
              <button type="submit" name="submit" id="User_request" class="btn btn-primary"
              value="RequestDownload"> Request User Report</button>
            </div>
          <?php }?>
        </div>
      </form>
    <?php } ?>
  </div>
</div>
</div>
</div>
<!-- DISPLAY ERROR MESSAGE ->
  <?php if(isset($msg)){ ?>
  <div class="form-group <?php echo $type[1]; ?>">
    <div align="center" id="<?php echo $type[0]; ?>">
      <label class="control-label" for="<?php echo $type[0]; ?>">
          <?php echo $msg; ?>
        </label>
    </div>
  </div>
  <?php } ?>
  !-- DISPLAY ERROR MESSAGE END -->
  <?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="POST" action="" id="siteuser_frm" name="siteuser_frm">
            <input type="hidden" name="defaultCheckedValue" id="defaultCheckedValue" value="0">
            <input type="hidden" name="Game_Type" id="Game_Type" value="<?php echo $result->Game_Type; ?>">
            
            <div class="row">
              <div class="col-md-4">
                <label><span class="alert-danger">*</span>Select Area</label>
              </div>
              <div class="col-md-4">
                <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_area')){?>
                  <select class="form-control" name="area_id" id="area_id" required="">
                  <?php } else {?>
                    <input type="hidden" name="dis_area_id" value="<?php echo $linkdetails->SubLink_AreaID;?>">
                    <select class="form-control" name="area_id" id="area_id" disabled="" >
                    <?php }?>
                    <option value="">-- SELECT --</option>
                    <!-- <?php while($row = $areaLink->fetch_object()){ ?>
                      <option value="<?php echo $row->Area_ID; ?>"
                        <?php if(isset($linkdetails->SubLink_AreaID) && $linkdetails->SubLink_AreaID == $row->Area_ID){echo 'selected'; } ?>>
                        <?php echo $row->Area_Name; ?>
                      </option>
                      <?php } ?> -->
                      <?php foreach ($areaArray as $value) { ?>
                        <option value="<?php echo $value['Area_ID'];?>" <?php echo ($linkdetails->SubLink_AreaID==$value['Area_ID'])?'selected':'';?> title="Game: <?php echo $value['Game_Name']; ?>">
                          <?php echo $value['Area_Name'];?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <br><br>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <input type="hidden" name="link" id="link" 
                    value="<?php if(isset($result)){ echo $result->Link_ID; } ?>">
                    <input type="hidden" name="sublinkid"
                    value="<?php if(isset($_GET['link'])){ echo $linkdetails->SubLink_ID; } ?>">

                    <div class="form-group">
                      <label><span class="alert-danger">*</span> Select </label>

                      <label for="Modecomp" class="containerRadio">
                        <input type="radio" name="Mode" value="comp" id="Modecomp"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "checked"; }else{ echo 'checked'; } ?> > Component
                        <span class="checkmarkRadio"></span>
                      </label>

                      <label for="Modesubcomp" class="containerRadio" <?php echo ($result->Game_Type == 1)?"title='SubComponent not allowed for bot-enabled games'":''; ?>>
                        <input type="radio" name="Mode" value="subcomp" id="Modesubcomp"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID>0){ echo "checked"; } ?> <?php echo ($result->Game_Type == 1)?'disabled':''; ?> > Sub Component
                        <span class="checkmarkRadio"></span>
                      </label>
                    </div>
                  </div>
            <!--</div>
              <div class="row">-->
                <div class="col-md-4" id="component" name="component">
                  <!--<label><span class="alert-danger">*</span>Select Component</label> -->
                  <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_compo')){ ?>
                    <select class="form-control" name="comp_id" id="comp_id" required="">
                    <?php } else { ?>
                      <input type="hidden" name="dis_comp_id" value="<?php echo $linkdetails->SubLink_CompID; ?>">
                      <select class="form-control" name="comp_id" id="comp_id" disabled="">
                        <!-- as due to permissions component dropdown will be disabled so no value will be passed, that's why adding a hidden field to send comp id in the controller -->
                      <?php }?>
                      <option value="">-- SELECT COMPONENT--</option>
                      <?php while($row = $component->fetch_object()){ ?>
                        <option value="<?php echo $row->Comp_ID; ?>"
                          <?php if(isset($linkdetails->SubLink_CompID) && $linkdetails->SubLink_CompID == $row->Comp_ID){echo 'selected'; } ?>>
                          <?php echo $row->Comp_Name; ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4" id="subcomponent" name="subcomponent" <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID>0){ } else { echo "style='display:none;'";}?> >
                    <!--<label><span class="alert-danger">*</span>Select SubComponent</label> -->
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_subcompo')){?>
                      <select class="form-control" name="subcomp_id" id="subcomp_id">
                      <?php } else {?>
                        <input type="hidden" name="dis_subcomp_id" value="<?php echo $linkdetails->SubLink_SubCompID;?>">
                        <select class="form-control" name="subcomp_id" id="subcomp_id" disabled="">
                        <?php }?>
                        <option value="">-- SELECT SUBCOMPONENT--</option>
                        <?php while($row = $subcomponent->fetch_object()){ ?>
                          <option value="<?php echo $row->SubComp_ID; ?>"
                            <?php if(isset($linkdetails->SubLink_SubCompID) && $linkdetails->SubLink_SubCompID == $row->SubComp_ID){echo 'selected'; } ?>>
                            <?php echo $row->SubComp_Name; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- taking this field to put the data to game views table for key -->
                  <input type="hidden" name="input_key" id="input_key" value="">
                  <!-- adding this to adjust viewing order at the user end -->
                  <div class="row">
                    <div class="col-md-4">
                      <label>Viewing Order</label> 
                    </div>
                    <div class="col-md-4">
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_viewingorder')){?>
                        <select class="form-control" name="SubLink_ViewingOrder" id="SubLink_ViewingOrder">
                        <?php } else {?>
                          <input type="hidden" name="dis_SubLink_ViewingOrder" value="<?php echo $SubLink_ViewingOrder;?>">
                          <select class="form-control" name="SubLink_ViewingOrder" id="SubLink_ViewingOrder" disabled="">
                          <?php }?>
                          <option value="">-- SELECT --</option>
                          <option value="1" <?php echo ($SubLink_ViewingOrder == 1?'selected':''); ?>>Name - Details/Chart(CkEditor) - Input Fields</option>
                          <option value="2" <?php echo ($SubLink_ViewingOrder == 2?'selected':''); ?>>Name - Input Fields - Details/Chart(CkEditor)</option>
                          <option value="3" <?php echo ($SubLink_ViewingOrder == 3?'selected':''); ?>>Details/Chart(CkEditor) - Input Fields - Name</option>
                          <option value="4" <?php echo ($SubLink_ViewingOrder == 4?'selected':''); ?>>Details/Chart(CkEditor) - Name - Input Fields</option>
                          <option value="5" <?php echo ($SubLink_ViewingOrder == 5?'selected':''); ?>>Input Fields - Details/Chart(CkEditor) - Name</option>
                          <option value="6" <?php echo ($SubLink_ViewingOrder == 6?'selected':''); ?>>Input Fields - Name - Details/Chart(CkEditor) </option>
                          <option value="7" <?php echo ($SubLink_ViewingOrder == 7?'selected':''); ?>>Input Fields - Name - Full Length</option>
                          <option value="8" <?php echo ($SubLink_ViewingOrder == 8?'selected':''); ?>>Input Fields - Details/Chart(CkEditor)</option>
                          <option value="9" <?php echo ($SubLink_ViewingOrder == 9?'selected':''); ?>>Name - Details/Chart(CkEditor)</option>
                          <option value="10" <?php echo ($SubLink_ViewingOrder == 10?'selected':''); ?>>Name - Input Fields - Full Length</option>
                          <option value="11" <?php echo ($SubLink_ViewingOrder == 11?'selected':''); ?>>Details/Chart(CkEditor) - Name</option>
                          <option value="12" <?php echo ($SubLink_ViewingOrder == 12?'selected':''); ?>>Details/Chart(CkEditor) - Input Fields</option>
                          <option value="13" <?php echo ($SubLink_ViewingOrder == 13?'selected':''); ?>>Name - Input Fields - Half Length</option>
                          <option value="14" <?php echo ($SubLink_ViewingOrder == 14?'selected':''); ?>>Input Fields - Name - Half Length</option>
                          <option value="15" <?php  echo ($SubLink_ViewingOrder == 15?'selected':''); ?>> Details/Chart(CkEditor) - Full Length</option> 
                          <option value="16" <?php  echo ($SubLink_ViewingOrder == 16?'selected':''); ?>> Details/Chart(CkEditor) - Half Length</option> 
                          <option value="17" <?php  echo ($SubLink_ViewingOrder == 17?'selected':''); ?>> Details/Chart(CkEditor) - Input Fields - Half Length</option> 
                          <option value="18" <?php  echo ($SubLink_ViewingOrder == 18?'selected':''); ?>> Input Fields - Details/Chart(CkEditor) - Half Length</option> 
                          <option value="19" <?php  echo ($SubLink_ViewingOrder == 19?'selected':''); ?>> Name - Details/Chart(CkEditor) - Half Length</option> 

                          <!-- for subcomponent only -->
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="20" <?php  echo ($SubLink_ViewingOrder == 20?'selected':''); ?>> Details/Chart(CkEditor) 1/4 length (for SubComponent only)</option> 
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="21" <?php  echo ($SubLink_ViewingOrder == 21?'selected':''); ?>> InputField 1/4 length (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="22" <?php  echo ($SubLink_ViewingOrder == 22?'selected':''); ?>> Details/Chart(CkEditor) 75% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="23" <?php  echo ($SubLink_ViewingOrder == 23?'selected':''); ?>>  Input Fields - Details/Chart(CkEditor) 75% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="24" <?php  echo ($SubLink_ViewingOrder == 24?'selected':''); ?>>  Details/Chart(CkEditor) - Input Fields 75% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="25" <?php  echo ($SubLink_ViewingOrder == 25?'selected':''); ?>> Details/Chart(CkEditor) 33% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="26" <?php  echo ($SubLink_ViewingOrder == 26?'selected':''); ?>> Input Fields - Details/Chart(CkEditor) 33% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="27" <?php  echo ($SubLink_ViewingOrder == 27?'selected':''); ?>> Details/Chart(CkEditor) - Input Fields 33% (for SubComponent only)</option>
                          <option <?php if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0){ echo "disabled"; } ?> class="onlyForSubcomponent" value="28" <?php  echo ($SubLink_ViewingOrder == 28?'selected':''); ?>> Input Fields 33% (for SubComponent only)</option>
                        </select>
                      </div>
                      <br><br>
                    </div>
                    <div class="row">
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_label')){?>
                        <div class="col-md-2">
                          <label><span class="alert-danger">*</span>Label Current</label>
                          <input type="text" name="SubLink_LabelCurrent" id="SubLink_LabelCurrent" class="form-control" value="<?php echo $SubLink_LabelCurrent;?>" placeholder="Enter Label Text" required>
                        </div>
                        <div class="col-md-2">
                          <label><span class="alert-danger">*</span>Label Last</label>
                          <input type="text" name="SubLink_LabelLast" id="SubLink_LabelLast" class="form-control"  value="<?php echo $SubLink_LabelLast;?>" placeholder="Enter Label Text" required>
                        </div>
                      <?php } else {?>
                        <div class="col-md-2">
                          <label><span class="alert-danger">*</span>Label Current</label>
                          <input type="text" name="SubLink_LabelCurrent" id="SubLink_LabelCurrent" class="form-control" value="<?php echo $SubLink_LabelCurrent;?>" placeholder="Enter Label Text"disabled="">
                        </div>
                        <div class="col-md-2">
                          <label><span class="alert-danger">*</span>Label Last</label>
                          <input type="text" name="SubLink_LabelLast" id="SubLink_LabelLast" class="form-control"  value="<?php echo $SubLink_LabelLast;?>" placeholder="Enter Label Text" disabled="">
                        </div>
                      <?php }?>
                    </div>
                    <br>
                    <!-- adding font-size box for label name -->
                    <div class="row">
                      <div class="col-md-2">
                        <label><span class="alert-danger">*</span>Label Font Size</label> (px)
                        <input type="number" name="SubLink_FontSize" id="fontSize" class="form-control"  value="<?php echo (!empty($SubLink_FontSize))?$SubLink_FontSize:'14';?>" placeholder="Font Size In Pixal">
                      </div>
                      <div class="col-md-2">
                        <label>Font Style</label>
                        <select class="form-control" name="SubLink_FontStyle" id="fontFamily">
                          <option value="">-- Select Font-Style --</option>
                          <option value="Abadi MT Condensed Light" <?php echo($SubLink_FontStyle=='Abadi MT Condensed Light')?'selected':'';?> >Abadi MT Condensed Light</option>
                          <option value="Arial Black" <?php echo($SubLink_FontStyle=='Arial Black')?'selected':'';?> >Arial Black</option>
                          <option value="Impact" <?php echo($SubLink_FontStyle=='Impact')?'selected':'';?> >Impact</option>
                          <option value="Technical" <?php echo($SubLink_FontStyle=='Technical')?'selected':'';?> >Technical</option>
                          <option value="system-ui" <?php echo($SubLink_FontStyle=='system-ui')?'selected':'';?> >system-ui</option>
                          <option value="initial" <?php echo($SubLink_FontStyle=='initial')?'selected':'';?> >initial</option>
                          <option value="Courier New" <?php echo($SubLink_FontStyle=='Courier New')?'selected':'';?> >Courier New</option>
                          <option value="Calibri" <?php echo($SubLink_FontStyle=='Calibri')?'selected':'';?> >Calibri</option>
                          <option value="Arial" <?php echo($SubLink_FontStyle=='Arial')?'selected':'';?> >Arial</option>
                          <option value="Arial Narrow" <?php echo($SubLink_FontStyle=='Arial Narrow')?'selected':'';?> >Arial Narrow</option>
                          <option value="Lucida Handwriting" <?php echo($SubLink_FontStyle=='Lucida Handwriting')?'selected':'';?> >Lucida Handwriting</option>
                          <option value="Times New Roman" <?php echo($SubLink_FontStyle=='Times New Roman')?'selected':'';?> >Times New Roman</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label>Demo Text</label>
                        <div class="form-control" id="demoText" style="font-size: <?php echo $SubLink_FontSize.'px';?>; font-family: <?php echo $SubLink_FontStyle;?>;">
                          The quick brown fox jumps over the lazy dog
                        </div>
                      </div>
                    </div>
                    <!-- end of adding font-size for label -->
                    <br>
                    <div class="row">
                      <div class="col-md-4">
                        <label>Label Order</label> 
                      </div>
                      <div class="col-md-4">
                        <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_labelOrder')){?>
                          <select class="form-control" name="SubLink_InputFieldOrder" id="SubLink_InputFieldOrder">
                          <?php } else {?>
                           <select class="form-control" name="SubLink_InputFieldOrder" id="SubLink_InputFieldOrder" disabled="">
                           <?php }?>
                           <option value="">-- SELECT --</option>
                           <option value="1" <?php echo ($SubLink_InputFieldOrder == 1?'selected':'');?>>Label(C) <?php echo $SubLink_LabelCurrent;?> - Label(L) <?php echo $SubLink_LabelLast;?></option>
                           <option value="2" <?php echo ($SubLink_InputFieldOrder == 2?'selected':'');?>>Label(L) <?php echo $SubLink_LabelLast;?> - Label(C) <?php echo $SubLink_LabelCurrent;?></option>
                           <option value="3" <?php echo ($SubLink_InputFieldOrder == 3?'selected':'');?>>Label(C) <?php echo $SubLink_LabelCurrent;?></option>
                           <option value="4" <?php echo ($SubLink_InputFieldOrder == 4?'selected':'');?>>Label(L) <?php echo $SubLink_LabelLast;?></option>
                         </select>
                       </div>
                       <br><br><br>
                     </div>
                     <div class="row">
                      <div class="col-md-6">
                        <label>Background Color</label>
                        <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_bgcolor')){?>
                          <input type="color" id="changeMe" name="SubLink_BackgroundColor" id="SubLink_BackgroundColor" value="<?php echo ($SubLink_BackgroundColor == NULL)?'#ffffff':$SubLink_BackgroundColor;?>" onchange="hexToRgb(this.value)">
                        <?php } else {?>
                         <input type="color" id="changeMe" name="SubLink_BackgroundColor" id="SubLink_BackgroundColor" value="<?php echo ($SubLink_BackgroundColor == NULL)?'#ffffff':$SubLink_BackgroundColor;?>" onchange="hexToRgb(this.value)" disabled="">
                       <?php }?>
                       <!-- <button id="change" style='color:white;background-color: blue; width: 40px; height:20px' onclick="hexToRgb('#fbafff')"></button> -->
                       <label for="makeTransparent" class='containerCheckbox'>
                        <input type='checkbox' name='makeTransparent' id='makeTransparent' value="makeTransparent" <?php echo ($linkdetails->SubLink_BackgroundColor == '#0000ff00')?'checked':''; ?>> Transparent
                        <span class="checkmark"></span>
                      </label>
                    </div>
                    <div class="col-md-6">
                      <label>Text Color</label>
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_textbgcolor')){?>
                        <input type="color" name="SubLink_TextColor" id="SubLink_TextColor" value="<?php echo ($SubLink_TextColor == NULL)?'#000000':$SubLink_TextColor;?>">
                      <?php } else {?>
                       <input type="color" name="SubLink_TextColor" id="SubLink_TextColor" value="<?php echo ($SubLink_TextColor == NULL)?'#000000':$SubLink_TextColor;?>" disabled="">
                     <?php }?>
                   </div>
                 </div>
                 <br>
                 <div class="row col-md-12">
                  <!--  <div class="form-group">-->
                    <label class="pull-left"><span class="alert-danger">*</span>Type - </label>
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                      <div class="col-md-2">
                        <label class="containerRadio">
                          <input type="radio" name="Type" value="input" id="typeInput"
                          <?php if(!empty($linkdetails) && $linkdetails->SubLink_Type == 0){ echo "checked"; } ?> checked/> Input
                          <span class="checkmarkRadio"></span>
                        </label>
                      </div>

                      <div class="col-md-2">
                        <label class="containerRadio">
                          <input type="radio" name="Type" value="output" id="typeOutput"
                          <?php if(!empty($linkdetails) && $linkdetails->SubLink_Type == 1){ echo "checked"; } ?> > Output
                          <span class="checkmarkRadio"></span>
                        </label>
                      </div>

                    <?php } else {?>

                      <div class="col-md-2">
                        <label class="containerRadio">
                          <input type="radio"  name="Type" value="input" id="typeInput"
                          <?php if(!empty($linkdetails) && $linkdetails->SubLink_Type == 0){ echo "checked"; } ?> checked disabled=""/> Input
                          <span class="checkmarkRadio"></span>
                        </label>
                      </div>

                      <div class="col-md-2">
                        <label class="containerRadio">
                          <input type="radio"  name="Type" value="output" id="typeOutput"
                          <?php if(!empty($linkdetails) && $linkdetails->SubLink_Type == 1){ echo "checked"; } ?> disabled=""> Output
                          <span class="checkmarkRadio"></span>
                        </label>
                      </div>
                    <?php }?>
                    <!--  </div>-->
                  </div>
                  <br>
                  <div class="row" >
                    <div class="col-md-4">
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                        <label class="containerRadio" for="inputTypeformula">
                          <input type="radio" name="inputType" value="formula" id="inputTypeformula"
                          <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'formula'){ echo "checked"; } ?> > Formula
                          <span class="checkmarkRadio"></span>
                        </label>
                      <?php } else {?>
                        <label class="containerRadio" for="inputTypeformula">
                         <input type="radio" name="inputType" value="formula" id="inputTypeformula"
                         <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'formula'){ echo "checked"; } ?> disabled=""> Formula
                         <span class="checkmarkRadio"></span>
                       </label>
                     <?php }?>
                   </div>
                   <div class="col-md-4">
                    <div id="formula" name="formula" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'formula') {} else { echo "style='display:none;'";} ?> >
                      <!--<label><span class="alert-danger">*</span>Select Formula</label> -->
                      <select class="form-control" name="formula_id" id="formula_id">
                        <option value="">-- SELECT FORMULA--</option>
                        <?php while($row = $formula->fetch_object()){ ?>
                          <option value="<?php echo $row->f_id; ?>"
                            <?php if(isset($linkdetails->SubLink_FormulaID) && $linkdetails->SubLink_FormulaID == $row->f_id){echo 'selected'; } ?>>
                            <?php echo $row->formula_title; ?>
                          </option>
                        <?php } ?>
                      </select>
                      <label id="f_exp" name="f_exp"></label>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-4">
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                      <label class="containerRadio" for="inputTypeAdmin">
                        <input type="radio" name="inputType" value="admin" id="inputTypeAdmin"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'admin'){ echo "checked"; } ?> > By Admin
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php } else {?>
                      <label class="containerRadio" for="inputTypeAdmin">
                        <input type="radio" name="inputType" value="admin" id="inputTypeAdmin"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'admin'){ echo "checked"; } ?> disabled=""> By Admin
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php }?>
                  </div>
                  <div id="admin" name="admin" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'admin') {} else { echo "style='display:none;'";}?> >
                    <div class="col-md-4">
                      <!--<label>Current Input</label>-->
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                        <input type="text" name="current" id="current" value="<?php if(!empty($linkdetails->SubLink_AdminCurrent)) echo $linkdetails->SubLink_AdminCurrent;  ?>" 
                        class="form-control">
                      <?php } else {?>
                        <input type="text" name="current" id="current" value="<?php if(!empty($linkdetails->SubLink_AdminCurrent)) echo $linkdetails->SubLink_AdminCurrent;  ?>" 
                        class="form-control" disabled="">
                      <?php }?>
                    </div>
                    <div class="col-md-4">
                      <!--<label>Last Stored Input</label>-->
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                        <input type="text" name="last" id="last" placeholder="Last Stored Input" value="<?php if(!empty($linkdetails->SubLink_AdminLast)) echo $linkdetails->SubLink_AdminLast; ?>"
                        class="form-control">
                      <?php } else {?>
                        <input type="text" name="last" id="last" placeholder="Last Stored Input" value="<?php if(!empty($linkdetails->SubLink_AdminLast)) echo $linkdetails->SubLink_AdminLast; ?>"
                        class="form-control" disabled="">
                      <?php }?>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-4">
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                      <label class="containerRadio" for="inputTypeCarry">
                        <input type="radio" name="inputType" value="carry" id="inputTypeCarry"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'carry'){ echo "checked"; } ?> > Carry Forward
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php } else {?>
                      <label class="containerRadio" for="inputTypeCarry">
                        <input type="radio" name="inputType" value="carry" id="inputTypeCarry"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'carry'){ echo "checked"; } ?> disabled=""> Carry Forward
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php }?>
                  </div>
                  <div id="carry" name="carry" <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'carry') {} else { echo "style='display:none;'";}?> >
                    <!-- need link to scenario-->
                    <div class="col-md-2" id="carry_scen" name="carry_scen">
                      <!--<label><span class="alert-danger">*</span>Select Component</label> -->
                      <select class="form-control" name="carry_linkid" id="carry_linkid">
                        <option value="">-- SELECT SCENARIO LINK--</option>
                        <?php 
                        while($row = $objcarry->fetch_object()){ ?>
                          <option value="<?php echo $row->Link_ID; ?>"
                            <?php if(isset($linkdetails->SubLink_LinkIDcarry) && $linkdetails->SubLink_LinkIDcarry == $row->Link_ID){echo 'selected'; } ?>>
                            <?php echo $row->Scen_Name; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-2" id="carry_comp" name="carry_comp">
                      <!--<label><span class="alert-danger">*</span>Select Component</label> -->
                      <select class="form-control" name="carry_compid" id="carry_compid">
                        <option value="">-- SELECT COMPONENT--</option>
                        <?php 
                        while($row = $component->fetch_object()){ ?>
                          <option value="<?php echo $row->Comp_ID; ?>"
                            <?php if(isset($linkdetails->SubLink_CompIDcarry) && $linkdetails->SubLink_CompIDcarry == $row->Comp_ID){echo 'selected'; } ?>>
                            <?php echo $row->Comp_Name; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                    <!-- <div class="col-md-4"></br></div> -->
                    <div class="col-md-2" id="carry_subcomp" name="carry_subcomp">
                      <!--<label><span class="alert-danger">*</span>Select SubComponent</label> -->
                      <select class="form-control" name="carry_subcompid" id="carry_subcompid">
                        <option value="">-- SELECT SUBCOMPONENT--</option>
                        <?php while($row = $subcomponent->fetch_object()){ ?>
                          <option value="<?php echo $row->SubComp_ID; ?>"
                            <?php if(isset($linkdetails->SubLink_SubCompIDcarry) && $linkdetails->SubLink_SubCompIDcarry == $row->SubComp_ID){echo 'selected'; } ?>>
                            <?php echo $row->SubComp_Name; ?>
                          </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-4">
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                      <label class="containerRadio" for="inputTypeUser">
                        <input type="radio" name="inputType" value="user" id="inputTypeUser"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'user'){ echo "checked"; } ?>/> By User
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php } else {?>
                      <label class="containerRadio" for="inputTypeUser">
                        <input type="radio" name="inputType" value="user" id="inputTypeUser"
                        <?php if(!empty($linkdetails) && $linkdetails->SubLink_InputMode == 'user'){ echo "checked"; } ?> disabled=""/> By User
                        <span class="checkmarkRadio"></span>
                      </label>
                    <?php }?>
                  </div>
                  <!-- adding multiple choice and range type here -->
                  <div class="row col-md-8 <?php echo ($linkdetails->SubLink_InputMode == 'user')?'':'hidden'; ?>" id="user" name="user">
                    <!--  <div class="col-md-4 <?php // echo ($linkdetails->SubLink_InputMode == 'user')?'':'hidden'; ?>">  -->
                      <div class="col-md-6">
                        <select name="SubLink_InputModeType" id="SubLink_InputModeType" class="form-control">
                          <!-- <option value="select" id="1" <?php echo ($linkdetails->SubLink_InputModeType == 'select')?'selected':''; ?> >-- Select Input --</option> -->
                          <option value="user" id="2" <?php echo ($linkdetails->SubLink_InputModeType == 'user')?'selected':''; ?> > Default/Text</option>
                          <option value="mChoice" id="3" <?php echo ($linkdetails->SubLink_InputModeType == 'mChoice')?'selected':''; ?>>Multiple Choice</option>
                          <option value="range" id="4" <?php echo ($linkdetails->SubLink_InputModeType == 'range')?'selected':''; ?> >Range/Button</option>
                        </select>
                      </div>
                      <!--for default Text--->
                      <div class="col-md-6 <?php echo ($linkdetails->SubLink_InputModeType == 'user')?'':'hidden'; ?>" id="user_default_value">
                        <input type="text" name="enterText" placeholder="Enter Default Value" class="form-control" readonly="">
                      </div>
                      <!-- for multiple choice -->
                      <div class="row">
                        <div class="col-md-12 <?php echo ($linkdetails->SubLink_InputModeType == 'mChoice')?'':'hidden'; ?>" id="mChoice">
                          <br>
                          <div class="form-group col-md-6">
                            <label for="No of questions">Enter Question:</label>
                            <input name="question" id="question" type="text" value="<?php echo $question;?>" class="form-control inputTypeUser" placeholder="Enter Question" required="">
                          </div>
                          <div class="form-group col-md-3 alert-danger">
                            Note: Default selected option will not be visible to user
                          </div>
                          <div class="form-group col-md-3" style="float: right;">
                            <button class="btn-primary" type="button" id="add_options" data-toggle="tooltip" title="Add More Options" style="margin-top: 16%;">+</button>
                          </div>
                          <br>
                          <div class="form-group col-md-6" style="margin-left: 1px;">
                            <label for="No of questions">Text:</label>
                            <input name="option[]" id="option[]" type="text" value="<?php echo (!empty($options))?$options:'Option-';?>" class="form-control optionTextBox inputTypeUser" placeholder="Enter Option Text" required="">
                          </div>
                          <div class="form-group col-md-3">
                            <label for="No of questions">Value:</label>
                            <input name="option_value[]" id="option_value[]" type="text" value="<?php echo $options_value;?>" class="form-control inputTypeUser" placeholder="Value" required="">
                          </div>
                          <?php if(count($option) > 1 && count($option_value) > 1){
                            // array_pop(array);
                            for($i=1; $i < count($option); $i++) { ?>
                              <div class="parentDefault">
                                <div class="form-group col-md-6"><input name="option[]" type="text" value="<?php echo $option[$i];?>" placeholder="Text" class="form-control optionTextBox"></div>
                                <div class="form-group col-md-3"><input name="option_value[]" type="text" value="<?php echo $option_value[$i];?>" placeholder="Value" class="form-control" required=""></div>
                                <div class="form-group col-md-2"><button class="btn-danger removeDiv" type="button" data-toggle="tooltip" title="Remove Option">-</button>
                                  <input class="checkedDefault" type="radio" name="makeDefaultChecked[]" data-toggle="tooltip" title="Make This Default Checked" value="<?php echo $option[$i];?>" <?php echo ($makeDefaultChecked == $option[$i])?'checked':'';?> required/>
                                </div>
                              </div>
                            <?php } } ?>
                            <div class="row">
                              <div id="add_here"></div>
                            </div>
                          </div>
                        </div>
                        <!-- for range -->
                        <div class="row">
                          <!-- <div class="col-md-12 <?php echo ($linkdetails->SubLink_InputModeType == 'range')?'':'hidden'; ?>" id="range" onchange="label_choice(this.value)"><br> -->
                            <div class="col-md-12 <?php echo ($linkdetails->SubLink_InputModeType == 'range')?'':'hidden'; ?>" id="range">
                              <div class="form-group col-md-2">
                                <label for="Min Value">Min:</label>
                                <input name="SubLink_MinVal" id="SubLink_MinVal" type="number" value="<?php echo ($SubLink_MinVal)?$SubLink_MinVal:'0';?>" class="form-control" placeholder="Enter Min Range">
                              </div>
                              <div class="form-group col-md-2">
                                <label for="Max Value">Max:</label>
                                <input name="SubLink_MaxVal" id="SubLink_MaxVal" type="number" value="<?php echo ($SubLink_MaxVal)?$SubLink_MaxVal:'0';?>" class="form-control" placeholder="Enter Min Range">
                              </div>
                              <div class="form-group col-md-2">
                                <label for="Interval Value">Interval:</label>
                                <input name="SubLink_RangeInterval" id="SubLink_RangeInterval" type="number" value="<?php echo ($SubLink_RangeInterval)?$SubLink_RangeInterval:'0';?>" class="form-control" placeholder="Enter Interval">
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end of multiple choice and range type -->
                      </div>
                      <div class="clearfix"></div>
                      <div class="row">
                        <div class="col-md-4">
                         <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_type')){?>
                          <label class="containerRadio" for="inputTypeNone">
                            <input type="radio" name="inputType" value="none" id="inputTypeNone"
                            <?php if(empty($linkdetails) || $linkdetails->SubLink_InputMode == 'none'){ echo "checked"; } ?> > None
                            <span class="checkmarkRadio"></span>
                          </label>
                        <?php } else {?>
                          <label class="containerRadio" for="inputTypeNone">
                            <input type="radio" name="inputType" value="none" id="inputTypeNone"
                            <?php if(empty($linkdetails) || $linkdetails->SubLink_InputMode == 'none'){ echo "checked"; } ?>disabled=""> None
                            <span class="checkmarkRadio"></span>
                          </label>
                        <?php }?>
                      </div>
                    </div>
                    <br>
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col-md-4">
                        <label>Order</label>
                      </div>
                      <div class="col-md-4">
                        <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_order')){?>
                          <input type="text" name="order" id="order" value="<?php if(!empty($linkdetails->SubLink_Order)) echo $linkdetails->SubLink_Order; ?>" class="form-control" placeholder="Enter Order No" required>
                        <?php } else {?>
                         <input type="text" name="order" id="order" value="<?php if(!empty($linkdetails->SubLink_Order)) echo $linkdetails->SubLink_Order; ?>" class="form-control" placeholder="Enter Order No" disabled="">
                       <?php }?>
                     </div>
                   </div>
                   <br>
                   <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_showhide')){?>
                          <label class="containerRadio" for="ShowHide0">
                            <input type="radio" name="ShowHide" id="ShowHide0" value="0"
                            <?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 0){ echo "checked"; } ?> > Show
                            <span class="checkmarkRadio"></span>
                          </label>
                          <label class="containerRadio" for="ShowHide1">
                            <input type="radio" name="ShowHide" id="ShowHide1" value="1"
                            <?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 1){ echo "checked"; } ?> > Hide
                            <span class="checkmarkRadio"></span>
                          </label>
                        <?php } else {?>
                          <label class="containerRadio" for="ShowHide0">
                           <input type="radio" name="ShowHide" id="ShowHide0" value="0"
                           <?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 0){ echo "checked"; } ?> disabled=""> Show
                           <span class="checkmarkRadio"></span>
                         </label>
                         <label class="containerRadio" for="ShowHide1">
                           <input type="radio" name="ShowHide" id="ShowHide1" value="1"
                           <?php if(!empty($linkdetails) && $linkdetails->SubLink_ShowHide == 1){ echo "checked"; } ?> disabled=""> Hide
                           <span class="checkmarkRadio"></span>
                         </label>
                       <?php }?>
                     </div>
                     <div class="col-md-6">
                      <label for="chkround" class='containerCheckbox'>
                        <input type='checkbox' <?php if(!empty($linkdetails) && $linkdetails->SubLink_Roundoff == 1) { ?> checked='checked' <?php } ?> name='chkround' id='chkround'> Round Off
                        <span class="checkmark"></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <label>Replace</label>
                  </div>
                </div>
                <div class="row">
                  <input type="hidden" name="replaceid1" id="replaceid1" 
                  value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_ID; } ?>">
                  <div class="col-md-4">
                    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
                      <input type="text" name="start1" id="start1" 
                      value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Start; } ?>" 
                      placeholder = "Start" class="form-control">
                    <?php } else {?>
                      <input type="text" name="start1" id="start1" 
                      value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Start; } ?>" 
                      placeholder = "Start" class="form-control" <?php if($linkreplace1 != ''){?> disabled=""<?php } ?>>
                    <?php }?>
                  </div>
                  <div class="col-md-4">
                   <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
                    <input type="text" name="end1" id="end1" 
                    value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_End; } ?>" 
                    placeholder = "End" class="form-control">
                  <?php } else {?>
                   <input type="text" name="end1" id="end1" 
                   value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_End; } ?>" 
                   placeholder = "End" class="form-control" <?php if($linkreplace1 != ''){?> disabled=""<?php } ?>>
                 <?php }?>
               </div>
               <div class="col-md-4">
                 <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
                  <input type="text" name="value1" id="value1" 
                  value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Value; }?>" 
                  placeholder = "Value" class="form-control">
                <?php } else {?>
                  <input type="text" name="value1" id="value1" 
                  value="<?php if(isset($linkreplace1)){ echo $linkreplace1->Rep_Value; }?>" 
                  placeholder = "Value" class="form-control" <?php if($linkreplace1 != ''){?> disabled=""<?php } ?>>
                <?php }?>
              </div>
            </div>
            <div class="row">
              <input type="hidden" name="replaceid2" id="replaceid2" 
              value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_ID; } ?>">
              <div class="col-md-4">
               <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
                <input type="text" name="start2" id="start2" 
                value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Start; } ?>" 
                placeholder = "Start" class="form-control">
              <?php } else {?>
               <input type="text" name="start2" id="start2" 
               value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Start; } ?>" 
               placeholder = "Start" class="form-control" <?php if($linkreplace2 != ''){?> disabled=""<?php } ?>>
             <?php }?>
           </div>
           <div class="col-md-4">
             <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
              <input type="text" name="end2" id="end2" 
              value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_End; } ?>"
              placeholder = "End" class="form-control">
            <?php } else {?>
             <input type="text" name="end2" id="end2" 
             value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_End; } ?>"
             placeholder = "End" class="form-control" <?php if($linkreplace2 != ''){?> disabled=""<?php } ?>>
           <?php }?>
         </div>
         <div class="col-md-4">
           <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
            <input type="text" name="value2" id="value2" 
            value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Value; }?>"
            placeholder = "Value" class="form-control">
          <?php } else {?>
           <input type="text" name="value2" id="value2" 
           value="<?php if(isset($linkreplace2)){ echo $linkreplace2->Rep_Value; }?>"
           placeholder = "Value" class="form-control" <?php if($linkreplace2 != ''){?> disabled=""<?php } ?>>
         <?php }?>
       </div>
     </div>
     <div class="row">
      <input type="hidden" name="replaceid3" id="replaceid3" 
      value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_ID; } ?>">   
      <div class="col-md-4">
       <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
        <input type="text" name="start3" id="start3" 
        value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Start; } ?>"
        placeholder = "Start" class="form-control">
      <?php } else {?>
        <input type="text" name="start3" id="start3" 
        value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Start; } ?>"
        placeholder = "Start" class="form-control" <?php if($linkreplace3 != ''){?> disabled=""<?php } ?>>
      <?php }?>
    </div>
    <div class="col-md-4">
      <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
        <input type="text" name="end3" id="end3" 
        value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_End; } ?>"
        placeholder = "End" class="form-control">
      <?php } else {?>
       <input type="text" name="end3" id="end3" 
       value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_End; } ?>"
       placeholder = "End" class="form-control" <?php if($linkreplace3 != ''){?> disabled=""<?php } ?>>
     <?php }?>
   </div>
   <div class="col-md-4">
    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_replace')){?>
      <input type="text" name="value3" id="value3" 
      value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Value; }?>"
      placeholder = "Value" class="form-control">
    <?php } else {?>
      <input type="text" name="value3" id="value3" 
      value="<?php if(isset($linkreplace3)){ echo $linkreplace3->Rep_Value; }?>"
      placeholder = "Value" class="form-control"  <?php if($linkreplace3 != ''){?> disabled=""<?php } ?>>
    <?php }?>
  </div>
</div>
<div class="row">
  <br><br>
  <div class="col-md-4">
    <label><span class="alert-danger"></span>Select Chart</label> 
  </div>
  <div class="col-md-4">
    <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_chart')){?>
      <select class="form-control" name="chart_id" id="chart_id">
      <?php } else {?> 
        <select class="form-control" name="chart_id" id="chart_id" <?php if($linkdetails != ''){?> disabled=""<?php }else {?> "" <?php }?>>
        <?php }?>
        <option value="">-- SELECT --</option>
        <!-- for components chart -->
        <?php
        if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID==0) { 
          $sqlchart = "SELECT * FROM `GAME_CHART` WHERE `Chart_GameID`=".$result->Link_GameID." AND Chart_Type_Status=1";
          $subCompChart =  $functionsObj->ExecuteQuery($sqlchart);
          while($row = $subCompChart->fetch_object()) { ?>
            <option value="<?php echo $row->Chart_ID; ?>"
              <?php if(isset($linkdetails->SubLink_ChartID) && $linkdetails->SubLink_ChartID == $row->Chart_ID){echo 'selected'; } ?>>
              <?php echo $row->Chart_Name; ?>
            </option>
          <?php }} ?>
          <!-- for subcomponent charts -->
          <?php
          if(!empty($linkdetails) && $linkdetails->SubLink_SubCompID>0) { 
            $sqlchart = "SELECT * FROM `GAME_CHART` WHERE `Chart_GameID`=".$result->Link_GameID." AND Chart_Type_Status=0";
            $subCompChart =  $functionsObj->ExecuteQuery($sqlchart);
            while($row = $subCompChart->fetch_object()) { ?>
              <option value="<?php echo $row->Chart_ID; ?>"
                <?php if(isset($linkdetails->SubLink_ChartID) && $linkdetails->SubLink_ChartID == $row->Chart_ID){echo 'selected'; } ?>>
                <?php echo $row->Chart_Name; ?>
              </option>
            <?php }} ?>
          </select>
        </div>
      </div>
      <br>OR<br><br>
      <div class="row">
        <div class="col-sm-12">
          <label><span class="alert-danger">*</span>Details</label>
          <div class="form-group">
            <!--<div class="input-group">-->
             <?php if($functionsObj->checkModuleAuth('innerlinkage','innerPermission','edit_chart')){?>
              <textarea id="details" name="details" class="form-control"><?php if(!empty($linkdetails->SubLink_Details)){ echo $linkdetails->SubLink_Details; } ?></textarea>
            <?php } else {?>
             <textarea id="details" name="details" class="form-control" disabled="">

              <?php if(!empty($linkdetails->SubLink_Details)){ echo $linkdetails->SubLink_Details; } ?></textarea>
            <?php }?>
            <!--</div>-->
            <div class="contact_error"></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group text-center">        
            <?php if(isset($_GET['linkedit']) && !empty($_GET['linkedit'])){?>
              <button type="button" id="siteuser_btn_update" class="btn btn-primary"> Update </button>
              <button type="submit" name="submit" id="siteuser_update" class="btn btn-primary hidden" value="Update"> Update </button>
              <button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
            <?php }else{?>
              <?php if($functionsObj->checkModuleAuth('innerlinkage','add')){?>
                <button type="button" id="siteuser_btn" class="btn btn-primary"
                value="Submit"> Submit </button>
              <?php } ?>
              <button type="button" id="siteuser_btn" class="btn btn-primary hidden" value="Submit"> Submit </button>
              <button type="submit" name="submit" id="siteuser_sbmit" class="btn btn-primary hidden" value="Submit"> Submit </button>
              <button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
            <?php }?>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>
<div class="clearfix"></div>
<!--
  <?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
-->
<div class="row">
  <div class="col-lg-12">
    <div class="pull-right legend">
      <ul>
        <li><b>Legend : </b></li>
        <li> <span class="glyphicon glyphicon-ok">    </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active  </a></li>
        <li> <span class="glyphicon glyphicon-remove">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li>
        <li> <span class="glyphicon glyphicon-search">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can View the Record"> View   </a></li>
        <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit   </a></li>
        <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
        <li> <span class="fa fa-bolt">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="Start component for area"> Start Component  </a></li>
      </ul>
    </div>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <label style="padding-top:7px;">Linkage List</label>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>#</th>
              <th>Area</th>
              <th>Component</th>
              <th>Subcomponent</th>
              <th>Type</th>
              <th>Show/Hide</th>
              <th>Mode</th>
              <th>Order</th>
              <th>Background</th>
              <th>Text Color</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i=1; while($row = $object1->fetch_object()){ ?>
              <tr>
                <th><?php echo $i;?></th>
                <td><?php echo $row->AreaName; ?></td>
                <td><?php echo $row->Component; ?></td>
                <td><?php if($row->SubLink_SubCompID > 0) { echo $row->SubComponent; } else  echo "--"; ?></td>
                <td><?php if($row->SubLink_Type ==0 ) { echo "Input"; } else {echo "Output";}?></td>
                <td><?php if($row->SubLink_ShowHide ==0 ) { echo "Show"; } else {echo "Hide";}?></td>
                <td><?php echo $row->SubLink_InputMode;?></td>
                <td><?php echo $row->SubLink_Order;?></td>
                <td><input type="color" value="<?php echo $row->SubLink_BackgroundColor;?>" disabled "><code> 
                  <?php
                  if($row->SubLink_BackgroundColor)
                  {
                    $hex = sscanf($row->SubLink_BackgroundColor, "#%02x%02x%02x");
                    $r   = $hex[0];
                    $g   = $hex[1];
                    $b   = $hex[2];
                    echo $row->SubLink_BackgroundColor.'<br>';
                    echo $r.','.$g.','.$b;
                  }
                  ?> 
                </code>
              </td>
              <td><input type="color" value="<?php echo $row->SubLink_TextColor;?>" disabled>
                <code>
                  <?php
                  if($row->SubLink_TextColor)
                  {
                    $hex = sscanf($row->SubLink_TextColor, "#%02x%02x%02x");
                    $r   = $hex[0];
                    $g   = $hex[1];
                    $b   = $hex[2];
                    echo $row->SubLink_TextColor.'<br>';
                    echo $r.','.$g.','.$b;
                  }
                  ?> </code>
                </td>
                <td class="text-center">
                  <?php if($row->SubLink_Status == 0){ ?>
                    <a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->SubLink_ID; ?>" title="Deactive">
                      <span class="fa fa-times"></span></a>
                    <?php } else { ?>
                      <a href="javascript:void(0);" class="cs_btn" id="<?php echo $row->SubLink_ID; ?>" title="Active">
                        <span class="fa fa-check"></span></a>
                      <?php } ?>
                      <?php if($functionsObj->checkModuleAuth('innerlinkage','edit')) { ?>
                        <a href="<?php echo site_root."ux-admin/linkage/linkedit/".$row->SubLink_ID; ?>" title="Edit">
                          <span class="fa fa-pencil"></span></a>
                        <?php } if($functionsObj->checkModuleAuth('innerlinkage','delete')) { ?>
                          <a href="javascript:void(0);" class="dl_btn" id="<?php echo $row->SubLink_ID; ?>" title="Delete">
                            <span class="fa fa-trash"></span></a>
                          <?php } ?>
                        </td>
                      </tr>
                      <?php $i++; } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <!-- Modal -->
          <div id="Modal_Success" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" onclick="window.location = '<?php echo site_root."ux-admin/linkage/link/".$result->Link_ID; ?>';">&times;</button>
                  <h4 class="modal-title"> Linkage Added Successfully</h4>
                </div>
                <div class="modal-body">
                  <p> Linkage Added Successfully.</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" onclick="window.location = '<?php echo site_root."ux-admin/linkage/link/".$result->Link_ID; ?>';">Ok</button>
                </div>
              </div>
            </div>
          </div>
          <script>
            <!--

             $('#siteuser_btn').click( function()
             {
              if($('input[name=Mode]:checked').val() == 'comp')
              {
                var key = 'comp_'+$('#comp_id').val();
              }
              else
              {
                var key = 'subc_'+$('#subcomp_id').val();
              }
              $('#input_key').val(($('#area_id option:selected').text()).trim()+'_'+key);
              $("#siteuser_sbmit").trigger( "click" );
            });

             $('#siteuser_btn_update').click( function()
             {
              if($('input[name=Mode]:checked').val() == 'comp')
              {
                var key = 'comp_'+$('#comp_id').val();
              }
              else
              {
                var key = 'subc_'+$('#subcomp_id').val();
              }
              // alert($('#area_id option:selected').text().trim()+'_'+key);
              $('#input_key').val(($('#area_id option:selected').text()).trim()+'_'+key);
              $( "#siteuser_update" ).trigger( "click" );
            });

  // -->
</script>
<script type="text/javascript">

  $('#add_options').on('click',function(){
    $('#add_here').append('<div class="col-md-12 parentDefault"><div class="form-group col-md-6"><input name="option[]" type="text" placeholder="Enter Option Text" class="form-control inputTypeUser optionTextBox" value="Option-" required=""></div> <div class="form-group col-md-3"><input name="option_value[]" type="text" placeholder="Value" value="" required="" class="form-control inputTypeUser "></div><div class="form-group col-md-2"><button class="btn-danger removeDiv" type="button" data-toggle="tooltip" title="Remove Option">-</button><input class="checkedDefault" type="radio" name="makeDefaultChecked[]" data-toggle="tooltip" title="Make This Default Checked" value="" required/></div></div>');
    removeDiv();
    makeDefaultChecked();
    changeValueOnChangingText();
    $('[data-toggle="tooltip"]').tooltip();
  });
  
  function removeDiv()
  {
    $('.removeDiv').on('click',function(){
      // alert('clicked');
      $(this).parent().parent().remove();
    });
  }
  
  $('input[name=inputType]').on('change',function(){
    if($(this).val() != 'user')
    {
      $('.inputTypeUser').each(function(){
        $(this).attr('required',false);
      });
      $('#user').addClass('hidden');
      $('#question').attr('required',false);
      $('input[name*="makeDefaultChecked"]').each(function(){
        $(this).attr('required',false);
      });
    }
    else
    {
      if($('#SubLink_InputModeType').val() == 'mChoice')
      {
        $('.inputTypeUser').each(function(){
          $(this).attr('required',true);
        });
      }
      $('#user').removeClass('hidden');
    }
  });
  
  $('#SubLink_InputModeType').on('change',function(){
    if($("#SubLink_InputModeType option:selected").attr('id') == 3 || $("#SubLink_InputModeType  option:selected").attr('id') == 4)
    {
     if($('#SubLink_InputFieldOrder').val()== 1 || $('#SubLink_InputFieldOrder').val()== 2)
     {
       Swal.fire({
        icon: 'error',
        text:"Since you have selected both the labels, user input is not possible for last label",
      });
     }
   }
   $('.inputTypeUser').each(function(){
    $(this).attr('required',false);
  });
   var input_type = $(this).val();
  //  if(input_type == 'select')
  //  {
  //   $('#user_default_value').addClass('hidden');
  //   $('#mChoice').addClass('hidden');
  //   $('#range').addClass('hidden');
  //   $('#question').attr('required',false);
  // }
  if(input_type == 'user')
  {
    // $('#user_default_value').removeClass('hidden');
    $('#mChoice').addClass('hidden');
    $('#range').addClass('hidden');
    $('input[name*="makeDefaultChecked"]').each(function(){
      $(this).attr('required',false);
    });
  }
  if(input_type == 'mChoice')
  {
    $('#mChoice').removeClass('hidden');
    $('#range').addClass('hidden');
    $('#user_default_value').addClass('hidden');
    $('.inputTypeUser').each(function(){
      $(this).attr('required',true);
    });
    $('input[name*="makeDefaultChecked"]').each(function(){
      $(this).attr('required',true);
    });
  }
  if(input_type == 'range')
  {
    $('#range').removeClass('hidden');
    $('#mChoice').addClass('hidden');
    $('#user_default_value').addClass('hidden');
    $('input[name*="makeDefaultChecked"]').each(function(){
      $(this).attr('required',false);
    });
  }
});
  
  $('#formula_id').on('change', function(){
    var formula_id = $(this).val();
    //alert(comp_id);
    //$('#subcomp_id').html('<option value="">-- SELECT --</option>');
    if(formula_id)
    {
      $.ajax({
        url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
        type: "POST",
        data: { formula_id: formula_id },
        success: function(data)
        {
          $('#f_exp').html(data);
        }
      });
    }
    else
    {
      console.log('Please select formula.');
    }
  });
  
  
  $('#area_id').on('change', function(){
    var area_id = $(this).val();
    //alert(area_id);
    $('#comp_id').html('<option value="">-- SELECT --</option>');

    $.ajax({
      url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
      type: "POST",
      data: { area_id: area_id },
      success: function(data){
        $('#comp_id').html(data);
      }
    });
  }); 
  
  $('#comp_id').on('change', function(){
    var comp_id = $(this).val();
    //alert(comp_id);
    $('#subcomp_id').html('<option value="">-- SELECT --</option>');

    $.ajax({
      url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
      type: "POST",
      data: { comp_id: comp_id },
      success: function(data){
        $('#subcomp_id').html(data);
      }
    });
  });
  
  $('#carry_linkid').on('change',function(){
    var link_id = $(this).val();
    //alert(comp_id);
    $('#carry_compid').html('<option value="">-- SELECT --</option>');

    $.ajax({
      url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
      type: "POST",
      data: { link_id: link_id },
      success: function(data){
        //alert(data);
        $('#carry_compid').html(data);
        <?php if(isset($linkdetails->SubLink_CompIDcarry)){ ?>
          setTimeout(function()
          {
            // if there is no carry forward or we are adding it first time then using 2 instead of SubLink_CompIDcarry
            $('#carry_compid [value=<?php echo $linkdetails->SubLink_CompIDcarry; ?>]').prop('selected', true);
            // writing this line to get the comp on change of scen while page load
            $('#carry_compid').trigger('change');
            console.log('trigger change in comp_id');
          },1);
        <?php } ?>
      }
    });
  });

  $('#carry_compid').on('change', function(){
    var comp_id = $(this).val();
    var link_id = $('#carry_linkid').val();
    
    $('#carry_subcompid').html('<option value="">-- SELECT --</option>');

    $.ajax({
      url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
      type: "POST",
      data: { carry_compid: comp_id , carry_linkid: link_id},
      success: function(data){
        $('#carry_subcompid').html(data);
        <?php if(isset($linkdetails->SubLink_SubCompIDcarry)){ ?>
          setTimeout(function()
          {
            // if there is no carry forward or we are adding it first time then using 2 instead of SubLink_SubCompIDcarry
            if(<?php echo ($linkdetails->SubLink_SubCompIDcarry)?$linkdetails->SubLink_SubCompIDcarry:'2'; ?>)
            {
              $('#carry_subcompid [value=<?php echo $linkdetails->SubLink_SubCompIDcarry; ?>]').prop('selected', true);
            }
          },1);
        <?php } ?>
      }
    });
  });
  
  $('#scen_id').on('change', function(){
    var thisVal = $(this).val();
    //alert(thisVal);
    $("input[id=scenid]").val(thisVal);   
  });
  
  $('#update_link').click( function(){  
    //alert($('#<%= scenid.ClientID%>').val());
    var link_id = $('#linkid').val();
    var game_id = $('#gameid').val();
    var scen_id = $('#scenid').val();
    if($('#scen_id').val() == '')
    {
      Swal.fire({
        icon: 'error',
        text: 'Please Select Scenario',
      });
      return false;
    }
    //alert(link_id);
    //alert(site_root + "ux-admin/model/ajax/update_game_link.php");
    $.ajax({      
      url: site_root + "ux-admin/model/ajax/update_game_link.php",
      type: "POST",
      data: { Link_id: link_id, Game_id: game_id, Scen_id: scen_id },
      beforeSend: function(){
        //alert("beforeSend");
        $('#loader').addClass( 'loader' );
      },
      success: function( result ){
        try{
          //alert("SUCCESS");
          var response = JSON.parse( result );
          
          if( response.status == 1 ){
            //alert("Linkage added");
            // console.log(response); console.log(result);
            Swal.fire (response.msg);
            $('#Modal_Success').modal('show', { backdrop: "static" } );
          } else {
            $('.option_err').html( result.msg );
          }
        } catch ( e ) {
          Swal.fire(e + "\n" + result);
          console.log( e + "\n" + result );
        }
        
        $('#loader').removeClass( 'loader' );
      },
      error: function(jqXHR, exception){
        Swal.fire('error'+ jqXHR.status +" - "+exception);
      }
    });
  });

  function makeDefaultChecked()
  {
    $('.checkedDefault').on('click',function(){
      var defaultRadioButton = $(this);
      var defaultOptionText  = $(this).parents('div.parentDefault').find('input[name*="option"]').val();
      var defaultOptionValue = $(this).parents('div.parentDefault').find('input[name*="option_value"]').val();
      $(defaultRadioButton).val(defaultOptionText);
      $('#defaultCheckedValue').val(defaultOptionValue);
      // alert('default:- '+defaultOptionText+' value:- '+defaultOptionValue);
    });
  }

  function changeValueOnChangingText()
  {
    $('.optionTextBox').on('click change blur keyup keydown',function(){
      var optionTextBox       = $(this);
      var textValue           = $(this).val();
      var adjecentRadioButton = $(this).parents('div.parentDefault').find('input[name*="makeDefaultChecked"]');
      console.log(adjecentRadioButton);
      $(adjecentRadioButton).val(textValue);
    });
  }

  // to show the formula by default while page load
  var selectedFormula = $('#formula_id').val();
  if(selectedFormula)
  {
    $('#formula_id').trigger('change');
  }

</script>
<script type="text/javascript">
  <!--
    CKEDITOR.replace('details');  
  //-->
</script>