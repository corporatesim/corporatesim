<style>
  .componentDiv, .componentNameDiv, .ckEditorDiv, .inputFieldDiv
  {
    display: inline-block;
  }
</style>
<section style="margin-top: 48px!important;">
  <div class="container">
    <?php $this->load->view('components/trErAlert'); ?>
    <!-- <div class="row clearfix">show timing here</div> -->

    <ul class="nav nav-tabs d-none" id="myTab" role="tablist">
      <li class="nav-item">
        <!-- as bot-enabled game can have only one area, and it will not be shown, also set the area style -->
        <?php
        $areaStyle = ($findLinkageSub[0]->Area_BackgroundColor || $findLinkageSub[0]->Area_TextColor)?"style='background-color:".$findLinkageSub[0]->Area_BackgroundColor."; color:".$findLinkageSub[0]->Area_TextColor."'":'';
        ?>
        <a class="nav-link active" id="area-tab" data-toggle="tab" href="#areaCompSubcomp" role="tab" aria-controls="areaCompSubcomp" aria-selected="true" <?php echo $areaStyle;?>>
          <?php echo $findLinkageSub[0]->SubLink_AreaName; ?>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li> -->
    </ul>
    <!-- showing selected tab content -->
    <div class="tab-content row col-md-12 m-1" id="myTabContent" <?php echo ($findScenario->Scen_Image)?"style='width:auto; background-image:url(".base_url('../images/'.$findScenario->Scen_Image).")'":"style:width:auto;" ?> >
      <!-- if this scenario has background image then show that image -->
      <div class="row col-md-12 tab-pane fade show active" id="areaCompSubcomp" role="tabpanel" aria-labelledby="area-tab" style="width:auto;">
        <?php foreach ($findLinkageSub as $findLinkageSubRow) { 
          // setting these variables values below, accordingly
          $hideByAdmin = "";
          $current     = "";
          $last        = "";
          $fontStyle   = "";
          // check if the component is hide by admin
          if($findLinkageSubRow->SubLink_ShowHide == 1)
          {
            $hideByAdmin = 'd-none';
          }
          // setting the viewingOrder accordingly
          switch ($findLinkageSubRow->SubLink_ViewingOrder) {
            // Name - Details/Chart - InputFields
            case 1:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
            break;

            // Name - InputFields - Details/Chart 
            case 2:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
            break;

            // Details/Chart - InputFields - Name
            case 3:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
            break;

            // Details/Chart - Name - InputFields
            case 4:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
            break;

            // InputFields - Details/Chart - Name
            case 5:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
            break;

            // InputFields - Name - Details/Chart
            case 6:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-none";
            $CompDetailsChart = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-right";
            $CompInputFields  = "col-md-4 col-xl-4 col-xs-4 col-sm-4 float-left";
            break;

            // InputFields - Name - FullLength
            case 7:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
            $CompDetailsChart = "d-none";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
            break;

            // InputFields - Details/Chart - FullLength
            case 8:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
            break;

            // Name - Details/Chart - FullLength
            case 9:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            $CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            $CompInputFields  = "d-none";
            break;

            // Name - InputFields - FullLength
            case 10:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            $CompDetailsChart = "d-none";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            break;

            // Details/Chart - Name - FullLength
            case 11:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-right";
            $CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6 float-left";
            $CompInputFields  = "d-none";
            break;

            // Details/Chart - InputFields - FullLength
            case 12:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-6 col-sm-6";
            break;

            // Name - InputFields - HalfLength
            case 13:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-12 col-sm-6";
            $CompDetailsChart = "d-none";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-12 col-sm-6";
            break;

            // InputFields - Name - HalfLength
            case 14:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "col-md-6 col-xl-6 col-xs-12 col-sm-6 float-right";
            $CompDetailsChart = "d-none";
            $CompInputFields  = "col-md-6 col-xl-6 col-xs-12 col-sm-6 float-left";
            break;

            // CkEditor - FullLength
            case 15:
            $ComponentLength  = "col-md-12 col-xs-12 col-xl-12";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-12 col-xl-12 col-xs-12 col-sm-12";
            $CompInputFields  = "d-none";
            break;

            // CkEditor - HalfLength
            case 16:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-12 col-xl-12 col-xs-12 col-sm-12";
            $CompInputFields  = "d-none";
            break;

            // ckEditor - InputFields - HalfLength
            case 17:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
            $CompInputFields  = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
            break;

            // InputFields - ckEditor - HalfLength
            case 18:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "d-none";
            $CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3 float-right";
            $CompInputFields  = "col-md-3 col-xl-3 col-xs-12 col-sm-3 float-left";
            break;

            //Name - Detailchart - HalfLength
            case 19:
            $ComponentLength  = "col-md-6 col-xs-12 col-xl-6";
            $ComponentName    = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
            $CompDetailsChart = "col-md-3 col-xl-3 col-xs-12 col-sm-3";
            $CompInputFields  = "d-none";
            break;

            default:
            $ComponentLength  = "";
            $ComponentName    = "";
            $CompDetailsChart = "";
            $CompInputFields  = "";
            break;
          }
          // setting background-color, text-color, font-size and font-style if set by admin
          if($findLinkageSubRow->SubLink_FontSize || $findLinkageSubRow->SubLink_FontStyle)
          {
            $fontStyle = "style='width:auto; font-size:".$findLinkageSubRow->SubLink_FontSize."px; font-family:".$findLinkageSubRow->SubLink_FontStyle."; background-color:".$findLinkageSubRow->SubLink_BackgroundColor."; color:".$findLinkageSubRow->SubLink_TextColor."; '";
          }

          ?>
          <div class="row clearfix <?php echo $ComponentLength.' '.$hideByAdmin;?> componentDiv" id="removeCompDiv" <?php echo ($fontStyle)?$fontStyle:"style='width:auto;'";?>>

            <div class="row <?php echo $ComponentName;?> componentNameDiv" id="">
              <?php echo $findLinkageSubRow->SubLink_CompName;?>
            </div>

            <div class="row <?php echo $CompDetailsChart;?> ckEditorDiv" id="">
              <?php if($findLinkageSubRow->SubLink_ChartID && $findLinkageSubRow->SubLink_ChartType){ ?>

                <img class="graph_chart comp_chart col-md-12" id="chart_<?php echo $findLinkageSubRow->SubLink_ID;?>" src="<?php echo base_url('../chart/'.$findLinkageSubRow->SubLink_ChartType.'.php?gameid='.$findLinkage->Link_GameID.'&userid='.$this->session->userdata['botUserData']->User_id.'&ChartID='.$findLinkageSubRow->SubLink_ChartID);?>" alt="<?php echo $findLinkageSubRow->SubLink_ChartType;?> Chart For Component" onclick="return showImageOnFullScreen(this.id)" style="border-radius: 0; max-width: fit-content;" title="Chart For <?php echo $findLinkageSubRow->SubLink_CompName;?>">

              <?php } else { echo $findLinkageSubRow->SubLink_Details; } ?>
            </div>

            <!-- if mode is not none then only show the inputFields values (carry admin formula) -->
            <?php if($findLinkageSubRow->SubLink_InputMode != 'none') { ?>
              <div class="row <?php echo $CompInputFields;?> inputFieldDiv" id="">
                <?php 
                if($findLinkageSubRow->SubLink_InputMode == 'carry')
                  { ?>
                    <label for="carry_<?php echo $findLinkageSubRow->SubLink_ID; ?>">
                      <?php echo $findLinkageSubRow->SubLink_LabelCurrent; ?>
                    </label>
                    <input type="range" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" id="carry_<?php echo $findLinkageSubRow->SubLink_ID; ?>" value="<?php echo $findLinkageSubRow->input_current; ?>" readonly>
                  <?php }

                  elseif($findLinkageSubRow->SubLink_InputMode == 'admin')
                  {
                    // check for SubLink_InputFieldOrder, it means show only current or last values
                    switch ($findLinkageSubRow->SubLink_InputFieldOrder)
                    {
                      case 1:
                      // label current - label last
                      $current = "";
                      $last    = "";
                      break;

                      case 2:
                      // label current - label last
                      $current = "float-right";
                      $last    = "float-left";
                      break;

                      case 3:
                      // label current
                      $current = "";
                      $last    = "d-none";
                      break;

                      case 4:
                      // label last
                      $current = "d-none";
                      $last    = "";
                      break;
                    }
                    ?>
                    <div class="<?php $current; ?>" <?php echo $fontStyle;?>>
                      <input type="text" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" value="<?php echo $findLinkageSubRow->SubLink_AdminCurrent?>" readonly>
                    </div>
                    <div class="<?php $last; ?>" <?php echo $fontStyle;?>>
                      <input type="text" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" value="<?php echo $findLinkageSubRow->SubLink_AdminLast?>" readonly>
                    </div>

                  <?php }

                  elseif($findLinkageSubRow->SubLink_InputMode == 'formula')
                    { ?>
                      <label for="formula_<?php echo $findLinkageSubRow->SubLink_ID; ?>">
                        <?php echo $findLinkageSubRow->SubLink_LabelCurrent; ?>
                      </label>
                      <input type="range" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" id="formula_<?php echo $findLinkageSubRow->SubLink_ID; ?>" value="<?php echo $findLinkageSubRow->input_current; ?>" readonly>
                    <?php }
                    // if none of the above then user mode, it can have mChoice, range or normal text box
                    else { ?>
                      <!-- show user inputs here "$findLinkageSubRow->SubLink_InputModeTypeValue"-->
                      <div class="userInputsDiv" <?php echo $fontStyle;?>>
                        <!-- show multiple choice options here -->
                        <?php if($findLinkageSubRow->SubLink_InputModeType == 'mChoice') {
                          $SubLink_InputModeTypeValue = json_decode($findLinkageSubRow->SubLink_InputModeTypeValue,true);

                        // echo $findLinkageSubRow->input_current."<pre>"; print_r($SubLink_InputModeTypeValue); echo "</pre>";

                          $question       = $SubLink_InputModeTypeValue['question'];
                          $defaultChecked = $SubLink_InputModeTypeValue['makeDefaultChecked'];
                          $questionFlag   = false;
                          // if default checked is selected from admin, then remove last element from array
                          if($defaultChecked)
                          {
                            array_pop($SubLink_InputModeTypeValue);
                          }
                          // print question in a row
                          echo "<div class=''>".$question."</div><br>";
                          foreach(($SubLink_InputModeTypeValue) as $optionText => $optionValue)
                          {
                            // as first is question, so skip this,
                            if($questionFlag)
                            {
                              // hiding the default, selected from admin end
                              $hideDefault = ($defaultChecked==$optionText)?'d-none':'';
                              // check the value and make it checked
                              $checkedDefault = ($findLinkageSubRow->input_current==$optionValue)?'checked':'';
                              echo '<div class="custom-control custom-radio mb-3 '.$hideDefault.'">
                              <input type="radio" data-sublinkid="'.$findLinkageSubRow->SubLink_ID.'" class="custom-control-input" id="'.$optionText.$optionText.'" name="radio-stacked" value="'.$optionValue.'" required '.$checkedDefault.'>
                              <label class="custom-control-label" for="'.$optionText.$optionText.'">'.$optionText.'</label>
                              <div class="invalid-feedback">More example invalid feedback text</div>
                              </div>';
                            }
                            $questionFlag = true;
                          }
                          ?>
                        <?php } elseif($findLinkageSubRow->SubLink_InputModeType == 'range') { 
                          $SubLink_InputModeTypeValue = explode(',',$findLinkageSubRow->SubLink_InputModeTypeValue);
                          ?>
                          <!-- show range type inputs here -->
                          <label for="range_<?php echo $findLinkageSubRow->SubLink_ID; ?>">
                            <?php echo $findLinkageSubRow->SubLink_LabelCurrent; ?>
                          </label>
                          <input type="range" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" class="typeRange custom-range" id="range_<?php echo $findLinkageSubRow->SubLink_ID; ?>" value="<?php echo $findLinkageSubRow->input_current; ?>" min="<?php echo $SubLink_InputModeTypeValue[0]; ?>" max="<?php echo $SubLink_InputModeTypeValue[1]; ?>" step="<?php echo $SubLink_InputModeTypeValue[2]; ?>" required>
                          <center><span class="rangeValue badge badge-pill badge-primary" style="font-size: 100%;"><?php echo $findLinkageSubRow->input_current; ?></span></center>
                        <?php } else{ ?>
                          <!-- show normal input box here for taking user input, show it like wsp input -->
                          <div class="clearfix"><br></div>

                          <div class="bottom-row col-md-12 float-left" style="left:1px; background:#ffffff;">

                            <div class="" style="display: inline-block;">
                              <?php echo $findLinkageSubRow->SubLink_LabelCurrent; ?>
                            </div>

                            <div class="float-right" style="display: inline-block;">
                              <input type="text" data-sublinkid="<?php echo $findLinkageSubRow->SubLink_ID; ?>" id="userInput" class="form-control" aria-describedby="userInput" value="<?php echo $findLinkageSubRow->input_current; ?>" style="color: #000000; font-weight: bolder; width: 100px;" required>
                            </div>

                          </div>
                        <?php } ?>

                      </div>

                    <?php } ?>

                    <!-- show all InputFields -->
                  </div>

                <?php } else { echo "<script>console.log('Component ".$findLinkageSubRow->SubLink_ID." mode is none.')</script>"; }?>
                <!-- add subcomponent of the component here -->
                <div class="subcomponentDiv">
                  <!-- put all the subComponents here, trigger ajax to fetch all the subcomponents here-->
                </div>
                <!-- subComponentDiv ends here -->

              </div>
              <!-- componentDiv ends here -->
              <div class="clearfix"><br></div>

            <?php } ?>
            <!-- <div class="row col-md-12">Append Component or Subcomponent&nbsp;<code>Div.row.col-md-12</code>&nbsp;to #areaCompSubcomp</div> -->
          </div>
          <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">Profile</div> -->
        </div>

    <!-- <div class="position-static">position-static</div>
    <div class="position-relative">position-relative</div>
    <div class="position-absolute">position-absolute</div>
    <div class="position-fixed">position-fixed</div>
    <div class="position-sticky">position-sticky</div> -->
    
  </div>
</section>
<script>
  $(document).ready(function(){
    // csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    // csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    // console.log('show first component excluding subcomponent, getting the subcomponent via ajax, but when user play then putting component and subcomponent together via ajax');
    // trigger ajax to get the time of the scenario
    $.ajax({
      url     : '<?php echo base_url("Ajax/getScenarioTime/".$findLinkage->Link_ID);?>',
      type    : 'POST',
      data    : {[csrfName]: csrfHash},
      success: function(result){
        try
        {
          var result = JSON.parse( result );
              // updating csrf token value
              csrfHash = result.csrfHash;
              // console.log(result);
              if(result.status == 200)
              {
                // alert(result.timer);
                $('#submitLink').removeClass('d-none');
                $('#clockTimeHolder').removeClass('d-none');
                $('#showTimer').text(result.timer+":00")
                var status = true;
                countDown(result.timer,status);
              }
              else
              {
                swal.fire('Connection Error. Please try later.');
                console.log(result);
              }
            }
            catch ( e )
            {
              // swal.fire('Something went wrong. Please try later.');
              Swal.fire({
                title: 'Something went wrong. Please try later.',
                showClass: {
                  popup: 'animated fadeInDown faster'
                },
                hideClass: {
                  popup: 'animated fadeOutUp faster'
                }
              })
              console.log(e + "\n" + result);
            }
          }
        });

    // show range value on change or while click on it
    $('.typeRange').each(function(e)
    {
      $(this).on('change input',function(e)
      {
        var range_value = $(this).val();
        // alert(range_value);
        $(this).parent('div.userInputsDiv').find('span.rangeValue').text(range_value);
      });
    });

    triggerAjaxToShowHideComp();

    // submit page when time is completed or user submit the page
    $('#submitPage, #submitPageViaCkEditor').on('click',function(e){
      if(e.originalEvent !== undefined)
      {
        if(<?php echo $skipAlert; ?>)
        {
          submitPage();
        }
        else
        {
          Swal.fire({
            icon              : 'warning',
            title             : 'Are you sure?',
            showCancelButton  : true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor : '#d33',
            confirmButtonText : 'OK',
            text              : "Please press OK if you have provided all your inputs and are ready to submit else press Cancel. Please note that you can not come back to this page after clicking OK",
          }).then((result) => {
            if (result.value) {
              submitPage();
            }
            else
            {
              return false;
            }
          })
        }
      }
      else
      {
        submitPage();
      }
    });
  });

  function submitPage()
  {
    // triggering ajax to save data and submit the page to move
    $('#pre-loader').show();
    $.ajax({
      url        : '<?php echo base_url("Ajax/submitInput/".$findLinkage->Link_ID."/".$findLinkage->Link_GameID);?>',
      type       : 'POST',
      // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
      // data    : $("form").serialize(),
      global     : false,
      data       : {[csrfName]: csrfHash},
      success: function(result){
        try
        {
          var result = JSON.parse( result );
          // updating csrf token value
          csrfHash = result.csrfHash;
          // console.log(result);
          if(result.status == 200)
          {
            // rdirect to the result url
            // alert(result.redirect);
            // $('#pre-loader').show();
            window.location = result.redirect;
            // Swal.fire('Submitted Successfully. Please Wait...');
          }
          else
          {
            $('#pre-loader').hide();
            swal.fire('Connection Error. Please try later.');
            console.log(result);
          }
        }
        catch ( e )
        {
          $('#pre-loader').hide();
          // swal.fire('Something went wrong. Please try later.');
          Swal.fire({
            title: 'Something went wrong. Please try later.',
            showClass: {
              popup: 'animated fadeInDown faster'
            },
            hideClass: {
              popup: 'animated fadeOutUp faster'
            }
          })
          console.log(e + "\n" + result);
        }
      }
    });
  }
  function triggerAjaxToShowHideComp()
  {
    // trigger ajax on change of inputs
    $('input').each(function(){
      $(this).on('change',function(){
        var selectedValueByUser = $(this).val();
        var sublinkid           = $(this).data('sublinkid');
        // alert(selectedValueByUser+' '+sublinkid);
        // triggering ajax to update value in database
        $.ajax({
          url     : '<?php echo base_url("Ajax/showNextComponent/");?>'+sublinkid+'/'+selectedValueByUser,
          type    : 'POST',
          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          // data    : $("form").serialize(),
          data    : {[csrfName]: csrfHash},
          success: function(result){
            try
            {
              var result = JSON.parse( result );
              // updating csrf token value
              csrfHash = result.csrfHash;
              // console.log(result);
              if(result.status == 200)
              {
                // if reset successfully then refresh the page
                $('#removeCompDiv').remove();
                $('#areaCompSubcomp').append(result.appendHtml);
                $('html, body').animate({scrollTop: '0px'}, 0);
                triggerAjaxToShowHideComp();
              }
              else
              {
                swal.fire('Connection Error. Please try later.');
                console.log(result);
              }
            }
            catch ( e )
            {
              // swal.fire('Something went wrong. Please try later.');
              Swal.fire({
                title: 'Something went wrong. Please try later.',
                showClass: {
                  popup: 'animated fadeInDown faster'
                },
                hideClass: {
                  popup: 'animated fadeOutUp faster'
                }
              })
              console.log(e + "\n" + result);
            }
          }
        });
      });
    });
  }
</script>
<!-- <script>
  $('input[type=range]').on('change input',function(e){
  var range_value = $(this).val();
  // console.log($(this).parent().attr('class') + ' and ' + range_value);
  $(this).parent('div.InlineBox').find('span.range').text(range_value);
});
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false)
        {
          event.preventDefault();
          event.stopPropagation();
        }
        else
        {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script> -->