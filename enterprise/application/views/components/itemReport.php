<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-12">
            <div class="title">
              <h1>Report <?php echo $reportType; ?></h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('Competence/itemFormula');?>">Formula</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report <?php echo $reportType; ?></li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue">Report <?php echo $reportType; ?></h5>
                </div>

                <form method="POST" action="" id="formData">
                  <!-- Enterprize Name -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Enterprize <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $enterprizeDetails[0]->Enterprise_Name; ?></option>
                      </select>
                    </div>
                  </div>

                  <!-- Formula Name -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-sm-12 col-md-3 col-form-label">Formula Name <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select form-control" disabled="">
                        <option value=""><?php echo $formulaDetails[0]->Items_Formula_Title; ?></option>
                      </select>
                    </div>
                  </div>

                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label class="col-12 col-form-label">Formula Expression <span class="text-danger">*</span></label>
                    <div class="col-12">
                      <textarea class="form-control" disabled=""><?php echo $formulaDetails[0]->Items_Formula_String; ?></textarea>
                    </div>
                  </div>

                  <!-- ======================== -->
                   <!-- Condition Type => 1-> Average, 2-> Individual -->
                  <div class="row col-10 form-group" style="margin-left: 15px;">
                    <label>Condition Type <span class="text-danger">*</span></label>
                    <!-- 1 = Average -->
                    <div class="custom-control custom-radio mx-4">
                      <input type="radio" class="custom-control-input" disabled="" value="1" <?php if ($conditionType == 1) { echo 'checked'; } ?>>
                      <label class="custom-control-label">Average</label>
                    </div>
                    <!-- 2 = Individual -->
                    <div class="custom-control custom-radio">
                      <input type="radio" class="custom-control-input" disabled="" value="2" <?php if ($conditionType == 2) { echo 'checked'; } ?>>
                      <label class="custom-control-label">Individual</label>
                    </div>
                  </div>
                  <!-- ======================== -->

                  <?php
                  // when no entry present in database for selected item
                  if (empty($reportDetails) || $reportDetails == NULL) { ?>
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
                        <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addReportButton"><b>+</b></button>
                      </div>
                    </div>

                    <div class="form-group row text-left" style="margin-left: 15px;">
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="minValueCRAverage">CR Average Min Value:</label>
                        <input type="number" class="form-control minValueCRAverage" id="minValueCRAverage" name="minValueCRAverage[]" min="" max="" placeholder="Enter CR Average Min Value" value="" >
                      </div>
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="maxValueCRAverage">CR Average Max Value:</label>
                        <input type="number" class="form-control maxValueCRAverage" id="maxValueCRAverage" name="maxValueCRAverage[]" min="" max="" placeholder="Enter CR Average Max Value" value="" >
                      </div>
                    </div>

                    <div class="form-group row text-left" style="margin-left: 15px;">
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="minValueCAAverage">CA Average Min Value:</label>
                        <input type="number" class="form-control minValueCAAverage" id="minValueCAAverage" name="minValueCAAverage[]" min="" max="" placeholder="Enter CA Average Min Value" value="" >
                      </div>
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="maxValueCAAverage">CA Average Max Value:</label>
                        <input type="number" class="form-control maxValueCAAverage" id="maxValueCAAverage" name="maxValueCAAverage[]" min="" max="" placeholder="Enter CA Average Max Value" value="" >
                      </div>
                    </div>

                    <div class="form-group row text-left" style="margin-left: 15px;">
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="minValueSPAverage">SP Average Min Value:</label>
                        <input type="number" class="form-control minValueSPAverage" id="minValueSPAverage" name="minValueSPAverage[]" min="" max="" placeholder="Enter SP Average Min Value" value="" >
                      </div>
                      <div class="form-group col-sm-12 col-md-5">
                        <label for="maxValueSPAverage">SP Average Max Value:</label>
                        <input type="number" class="form-control maxValueSPAverage" id="maxValueSPAverage" name="maxValueSPAverage[]" min="" max="" placeholder="Enter SP Average Max Value" value="" >
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
                  foreach ($reportDetails as $reportDetailsRow) {
                    $loop++;

                    // for 2nd onward entry present in database for selected item
                    if ($loop > 1) { ?>
                      <div class="col-sm-12 removeThis" style="margin-left: 15px;">
                        <div class="form-group row text-left">
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="minValue">Min Value: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $reportDetailsRow->IR_Min_Value; ?>">
                          </div>
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="maxValue">Max Value: <span class="text-danger">*</span></label>
                            <input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $reportDetailsRow->IR_Max_Value; ?>">
                          </div>
                          <div class="col-md-2 add_col" style="margin-top: 22px;">
                            <button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeReportButton"><b>-</b></button>
                          </div>
                        </div>

                        <div class="form-group row text-left">
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="minValueCRAverage">CR Average Min Value:</label>
                            <input type="number" class="form-control minValueCRAverage" id="minValueCRAverage" name="minValueCRAverage[]" min="" max="" placeholder="Enter CR Average Min Value" value="<?php echo $reportDetailsRow->IR_CR_Min_Average_Value; ?>">
                          </div>
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="maxValueCRAverage">CR Average Max Value:</label>
                            <input type="number" class="form-control maxValueCRAverage" id="maxValueCRAverage" name="maxValueCRAverage[]" min="" max="" placeholder="Enter CR Average Max Value" value="<?php echo $reportDetailsRow->IR_CR_Max_Average_Value; ?>">
                          </div>
                        </div>

                        <div class="form-group row text-left">
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="minValueCAAverage">CA Average Min Value:</label>
                            <input type="number" class="form-control minValueCAAverage" id="minValueCAAverage" name="minValueCAAverage[]" min="" max="" placeholder="Enter CA Average Min Value" value="<?php echo $reportDetailsRow->IR_CA_Min_Average_Value; ?>">
                          </div>
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="maxValueCAAverage">CA Average Max Value:</label>
                            <input type="number" class="form-control maxValueCAAverage" id="maxValueCAAverage" name="maxValueCAAverage[]" min="" max="" placeholder="Enter CA Average Max Value" value="<?php echo $reportDetailsRow->IR_CA_Max_Average_Value; ?>">
                          </div>
                        </div>

                        <div class="form-group row text-left">
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="minValueSPAverage">SP Average Min Value:</label>
                            <input type="number" class="form-control minValueSPAverage" id="minValueSPAverage" name="minValueSPAverage[]" min="" max="" placeholder="Enter SP Average Min Value" value="<?php echo $reportDetailsRow->IR_SP_Min_Average_Value; ?>">
                          </div>
                          <div class="form-group col-sm-12 col-md-5">
                            <label for="maxValueSPAverage">SP Average Max Value:</label>
                            <input type="number" class="form-control maxValueSPAverage" id="maxValueSPAverage" name="maxValueSPAverage[]" min="" max="" placeholder="Enter SP Average Max Value" value="<?php echo $reportDetailsRow->IR_SP_Max_Average_Value; ?>">
                          </div>
                        </div>

                        <div class="form-group row text-left">
                          <div class="form-group col-sm-10">
                            <label for="details">Details:</label>
                            <div class="input-group">
                              <textarea id="" name="details[]" class="form-control details"><?php echo $reportDetailsRow->IR_Text; ?></textarea>
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
                          <input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $reportDetailsRow->IR_Min_Value; ?>">
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValue">Max Value: <span class="text-danger">*</span></label>
                          <input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $reportDetailsRow->IR_Max_Value; ?>">
                        </div>
                        <div class="col-md-2 add_col" style="margin-top: 22px;">
                          <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addReportButton"><b>+</b></button>
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="minValueCRAverage">CR Average Min Value:</label>
                          <input type="number" class="form-control minValueCRAverage" id="minValueCRAverage" name="minValueCRAverage[]" min="" max="" placeholder="Enter CR Average Min Value" value="<?php echo $reportDetailsRow->IR_CR_Min_Average_Value; ?>">
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValueCRAverage">CR Average Max Value:</label>
                          <input type="number" class="form-control maxValueCRAverage" id="maxValueCRAverage" name="maxValueCRAverage[]" min="" max="" placeholder="Enter CR Average Max Value" value="<?php echo $reportDetailsRow->IR_CR_Max_Average_Value; ?>">
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="minValueCAAverage">CA Average Min Value:</label>
                          <input type="number" class="form-control minValueCAAverage" id="minValueCAAverage" name="minValueCAAverage[]" min="" max="" placeholder="Enter CA Average Min Value" value="<?php echo $reportDetailsRow->IR_CA_Min_Average_Value; ?>">
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValueCAAverage">CA Average Max Value:</label>
                          <input type="number" class="form-control maxValueCAAverage" id="maxValueCAAverage" name="maxValueCAAverage[]" min="" max="" placeholder="Enter CA Average Max Value" value="<?php echo $reportDetailsRow->IR_CA_Max_Average_Value; ?>">
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="minValueSPAverage">SP Average Min Value:</label>
                          <input type="number" class="form-control minValueSPAverage" id="minValueSPAverage" name="minValueSPAverage[]" min="" max="" placeholder="Enter SP Average Min Value" value="<?php echo $reportDetailsRow->IR_SP_Min_Average_Value; ?>">
                        </div>
                        <div class="form-group col-sm-12 col-md-5">
                          <label for="maxValueSPAverage">SP Average Max Value:</label>
                          <input type="number" class="form-control maxValueSPAverage" id="maxValueSPAverage" name="maxValueSPAverage[]" min="" max="" placeholder="Enter SP Average Max Value" value="<?php echo $reportDetailsRow->IR_SP_Max_Average_Value; ?>">
                        </div>
                      </div>

                      <div class="form-group row text-left" style="margin-left: 15px;">
                        <div class="form-group col-sm-10">
                          <label for="details">Details:</label>
                          <div class="input-group">
                            <textarea id="" name="details[]" class="form-control details"><?php echo $reportDetailsRow->IR_Text; ?></textarea>
                          </div>
                          <div class="details_error"></div>
                        </div>
                      </div>
                  <?php } } ?>

                  <div id="addReportHere"></div>
                  <div class="clearfix"></div>
                  <div class="text-center">
                    <button  type="submit"class="btn btn-primary" name="" id="AddUpdatedReport">Save</button>
                    <a href="<?php echo base_url('Competence/itemFormula');?>" class="btn btn-outline-danger">Cancel</a>
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

    $('#addReportButton').on('click',function() {
      $('#addReportButton').tooltip('hide');
      $('#addReportHere').append('<div class="col-sm-12 removeThis" style="margin-left: 15px;"> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValue">Min Value: <span class="text-danger">*</span> </label><input type="number" class="form-control minValue" id="minValue" name="minValue[]" min="" max="" required="" placeholder="Enter Min Value"></div><div class="form-group col-sm-12 col-md-5"><label for="maxValue">Max Value: <span class="text-danger">*</span> </label><input type="number" class="form-control maxValue" id="maxValue" name="maxValue[]" min="" max="" required="" placeholder="Enter Max Value"></div><div class="col-md-2 add_col" style="margin-top: 22px;"><button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeReportButton"><b>-</b></button></div></div> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValueCRAverage">CR Average Min Value:</label><input type="number" class="form-control minValueCRAverage" id="minValueCRAverage" name="minValueCRAverage[]" min="" max="" placeholder="Enter CR Average Min Value" value="" ></div><div class="form-group col-sm-12 col-md-5"><label for="maxValueCRAverage">CR Average Max Value:</label><input type="number" class="form-control maxValueCRAverage" id="maxValueCRAverage" name="maxValueCRAverage[]" min="" max="" placeholder="Enter CR Average Max Value" value="" ></div></div> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValueCAAverage">CA Average Min Value:</label><input type="number" class="form-control minValueCAAverage" id="minValueCAAverage" name="minValueCAAverage[]" min="" max="" placeholder="Enter CA Average Min Value" value="" ></div><div class="form-group col-sm-12 col-md-5"><label for="maxValueCAAverage">CA Average Max Value:</label><input type="number" class="form-control maxValueCAAverage" id="maxValueCAAverage" name="maxValueCAAverage[]" min="" max="" placeholder="Enter CA Average Max Value" value="" ></div></div> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValueSPAverage">SP Average Min Value:</label><input type="number" class="form-control minValueSPAverage" id="minValueSPAverage" name="minValueSPAverage[]" min="" max="" placeholder="Enter SP Average Min Value" value="" ></div><div class="form-group col-sm-12 col-md-5"><label for="maxValueSPAverage">SP Average Max Value:</label><input type="number" class="form-control maxValueSPAverage" id="maxValueSPAverage" name="maxValueSPAverage[]" min="" max="" placeholder="Enter SP Average Max Value" value="" ></div></div> <div class="form-group row text-left"><div class="form-group col-sm-10"><label for="details">Details:</label><div class="input-group"><textarea id="" name="details[]" class="form-control details"></textarea></div><div class="details_error"></div></div></div></div>');
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
