<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Item Conditions</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Condition Text</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue">Item Condition Text</h5>
                </div>

                <form method="POST" action="" id="formData">

                  <!-- Enterprize Name -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Enterprize <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $itemDetails[0]->Enterprise_Name; ?></option>
                      </select>
                    </div>
                  </div>

                  <!-- Factor Type -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Factor Type <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value="">
                        <?php
                        // 4=Competence Readiness, 5=Competence Application, 3=Simulated Performance
                          if ($itemDetails[0]->Compt_PerformanceType == 4)
                            echo 'Competence Readiness';
                          else if ($itemDetails[0]->Compt_PerformanceType == 5)
                            echo 'Competence Application';
                          else if ($itemDetails[0]->Compt_PerformanceType == 3)
                            echo 'Simulated Performance';
                        ?>
                        </option>
                      </select>
                    </div>
                  </div>

                  <!-- Sub-factor -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Sub-factor <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $itemDetails[0]->Compt_Name; ?></option>
                      </select>
                    </div>
                  </div>

                  <!-- Score Status -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Score Status <span class="text-danger">*</span></label>
                      <!-- 0=Show, 1=Hide -->
                      <?php
                      // when no entry present in database for selected item
                      if (empty($itemConditions) || $itemConditions == NULL) { ?>
                      <!-- Show -->
                      <div class="custom-control custom-radio mx-2">
                        <input type="radio" class="custom-control-input" id="scoreStatusShow" name="scoreStatus" required value="0" checked>
                        <label class="custom-control-label" for="scoreStatusShow">Show</label>
                      </div>
                      <!-- Hide -->
                      <div class="custom-control custom-radio mx-2">
                        <input type="radio" class="custom-control-input" id="scoreStatusHide" name="scoreStatus" required value="1">
                        <label class="custom-control-label" for="scoreStatusHide">Hide</label>
                      </div>
                      <?php } else { ?>
                      <!-- Show -->
                      <div class="custom-control custom-radio mx-2">
                        <input type="radio" class="custom-control-input" id="scoreStatusShow" name="scoreStatus" required value="0" <?php if ($itemConditions[0]->IC_Score_Status == 0) { echo 'checked'; } ?>>
                        <label class="custom-control-label" for="scoreStatusShow">Show</label>
                      </div>
                      <!-- Hide -->
                      <div class="custom-control custom-radio mx-2">
                        <input type="radio" class="custom-control-input" id="scoreStatusHide" name="scoreStatus" required value="1" 
                        <?php if ($itemConditions[0]->IC_Score_Status == 1) { echo 'checked'; } ?>>
                        <label class="custom-control-label" for="scoreStatusHide">Hide</label>
                      </div>
                      <?php } ?>
                  </div>

                  <?php
                  // when no entry present in database for selected item
                  if (empty($itemConditions) || $itemConditions == NULL) { ?>
                    <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="minValue">Min Value: <span class="text-danger">*</span></label>
                          <input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value" value="" >
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValue">Max Value: <span class="text-danger">*</span></label>
                          <input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value" value="" >
                        </div>
                        <div class="col-md-2 add_col" style="margin-top: 22px;">
                          <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addConditionsButton"><b>+</b></button>
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-10">
                          <label for="details">Details:</label>
                          <div class="input-group">
                            <textarea id="" name="details[]" class="form-control details"></textarea>
                          </div>
                          <div class="details_error"></div>
                        </div>
                      </div>
                  <?php }

                  // when entry present in database for selected item
                  $loop = 0;
                  foreach ($itemConditions as $itemConditionsRow) {
                    $loop++;

                    // for 2nd onward entry present in database for selected item
                    if ($loop > 1) { ?>
                      <div class="col-sm-12 removeThis" style="margin-left: 15px;">
                        <div class="form-group row text-left">
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="minValue">Min Value: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $itemConditionsRow->IC_Min_Value; ?>" >
                          </div>
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="maxValue">Max Value: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $itemConditionsRow->IC_Max_Value; ?>" >
                          </div>
                          <div class="col-md-2 add_col" style="margin-top: 22px;">
                            <button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeConditionsButton"><b>-</b></button>
                          </div>
                        </div>
                        <div class="form-group row text-left">
                          <div class="form-group col-sm-10">
                            <label for="details">Details:</label>
                            <div class="input-group">
                              <textarea id="" name="details[]" class="form-control details"><?php echo $itemConditionsRow->IC_Text; ?></textarea>
                            </div>
                            <div class="details_error"></div>
                          </div>
                        </div>
                      </div>
                  <?php } else { 

                    // for 1st entry present in database for selected item
                    ?>
                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="minValue">Min Value: <span class="text-danger">*</span></label>
                          <input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $itemConditionsRow->IC_Min_Value; ?>" >
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValue">Max Value: <span class="text-danger">*</span></label>
                          <input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $itemConditionsRow->IC_Max_Value; ?>" >
                        </div>
                        <div class="col-md-2 add_col" style="margin-top: 22px;">
                          <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addConditionsButton"><b>+</b></button>
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-10">
                          <label for="details">Details:</label>
                          <div class="input-group">
                            <textarea id="" name="details[]" class="form-control details"><?php echo $itemConditionsRow->IC_Text; ?></textarea>
                          </div>
                          <div class="details_error"></div>
                        </div>
                      </div>
                  <?php } } ?>

                  <div id="addConditionsHere"></div>
                  <div class="clearfix"></div>
                  <div class="text-center">
                    <button  type="submit"class="btn btn-primary" name="" id="AddUpdatedConditions">Save</button>
                    <a href="<?php echo base_url('Competence');?>" class="btn btn-outline-danger">Cancel</a>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>

<script type="text/javascript">
  $(document).ready(function() {
    // after 1 seconds of page load calling CKEditor function 
    setTimeout(function() {
      CKEditor();
    }, 1000);
    removeThis();

    $('#addConditionsButton').on('click',function() {
      $('#addConditionsButton').tooltip('hide');
      $('#addConditionsHere').append('<div class="col-sm-12 removeThis" style="margin-left: 15px;"><div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValue">Min Value: <span class="text-danger">*</span></label><input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value"></div><div class="form-group col-sm-12 col-md-5"><label for="maxValue">Max Value: <span class="text-danger">*</span> </label><input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value"></div><div class="col-md-2 add_col" style="margin-top: 22px;"><button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeConditionsButton"><b>-</b></button></div></div><div class="form-group row text-left"><div class="form-group col-sm-10"><label for="details">Details:</label><div class="input-group"><textarea id="" name="details[]" class="form-control details"></textarea></div><div class="details_error"></div></div></div></div>');
      removeThis();
      //CKEditor();
    })
  });

  function removeThis() {
    $('.removeDiv').on('click',function() {
      $(this).parents('div.removeThis').remove();
    });
  }

  function CKEditor() {
    //CKEDITOR.replace('details'); // working on first name only
    CKEDITOR.replaceAll('details'); // working on all classes that exists in page but not working on that we created new

    //$( 'textarea.details' ).CKEDITOR(); // not working
    //CKEDITOR.replaceClass = 'details'; // not working
  }
</script>

