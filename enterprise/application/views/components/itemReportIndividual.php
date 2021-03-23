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

                  <!-- Start of Condition Type -->
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
                  <!-- end of Condition Type -->

                  <!-- ======================== -->
                  <?php
                  // when no entry present in database for selected item
                  if (empty($reportDetails) || $reportDetails == NULL) { ?>
                  <!-- start of item dropdown for x-axis and add more button -->
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-12 col-md-5">
                      <label class="col-form-label" for="usedItemsxAxis0">Items for x-axis: <span class="text-danger">*</span></label> 
                      <!-- <select class="custom-select2 form-control" id="usedItemsxAxis" name="usedItemsxAxis" required=""> -->
                      <select class="form-control" id="usedItemsxAxis0" name="usedItemsxAxis[0]" required="">
                        <option value="">-- Select from CR-CA-SP --</option>
                        <?php 
                        $countAddMore = 0;
                        foreach ($itemUsedDetails as $itemUsedDetailsRow) { ?>
                            <option value="<?php echo $itemUsedDetailsRow->Compt_Id;?>">
                              <?php echo $itemUsedDetailsRow->Compt_Name; ?>
                            </option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="add_col" style="margin-top: 35px;">
                      <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addReportButton"><b>+</b></button>
                    </div>
                  </div>
                  <!-- end of item dropdown for x-axis and add more button -->

                  <!-- start of Min and Max Value for x-axis -->
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="minValuexAxis">Min Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control minValuexAxis" id="minValuexAxis" name="minValuexAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="" >
                    </div>
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="maxValuexAxis">Max Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control maxValuexAxis" id="maxValuexAxis" name="maxValuexAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="" >
                    </div>
                  </div>
                  <!-- end of Min and Max Value for x-axis -->

                  <!-- start of item dropdown for y-axis -->
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-12 col-md-5">
                      <label class="col-form-label" for="usedItemsyAxis0">Items for y-axis: <span class="text-danger">*</span></label> 
                      <!-- <select class="custom-select2 form-control" id="usedItemsyAxis" name="usedItemsyAxis" required=""> -->
                      <select class="form-control" id="usedItemsyAxis0" name="usedItemsyAxis[0]" required="">
                        <option value="">-- Select from CR-CA-SP --</option>
                        <?php
                        foreach ($itemUsedDetails as $itemUsedDetailsRow) { ?>
                            <option value="<?php echo $itemUsedDetailsRow->Compt_Id;?>">
                              <?php echo $itemUsedDetailsRow->Compt_Name; ?>
                            </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- end of item dropdown for y-axis -->

                  <!-- start of Min and Max Value for y-axis -->
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="minValueyAxis">Min Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control minValueyAxis" id="minValueyAxis" name="minValueyAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="" >
                    </div>
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="maxValueyAxis">Max Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control maxValueyAxis" id="maxValueyAxis" name="maxValueyAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="" >
                    </div>
                  </div>
                  <!-- end of Min and Max Value for y-axis -->

                  <!-- start of CK Editor -->
                  <div class="form-group row text-left" style="margin-left: 15px;">
                    <div class="form-group col-sm-10">
                      <label for="details">Details:</label>
                      <div class="input-group">
                        <textarea id="" name="details[]" class="form-control details"></textarea>
                      </div>
                      <div class="details_error"></div>
                    </div>
                  </div>
                  <!-- end of CK Editor -->
                  <!-- ======================== -->
                  <?php }
                  else {
                  // when entry present in database for selected item
                  $countAddMore = 0;
                  foreach ($reportDetails as $reportDetailsRow) { ?>
                  <div class="col-sm-12 removeThis" style="margin-left: 15px;">

                  <!-- start of item dropdown for x-axis and add more button -->
                  <div class="form-group row text-left">
                    <div class="form-group col-sm-12 col-md-5">
                      <label class="col-form-label" for="usedItemsxAxis<?php echo $countAddMore; ?>">Items for x-axis : <span class="text-danger">*</span></label> 
                      <!-- <select class="custom-select2 form-control" id="usedItemsxAxis" name="usedItemsxAxis" required=""> -->
                      <select class="form-control" id="usedItemsxAxis<?php echo $countAddMore; ?>" name="usedItemsxAxis[<?php echo $countAddMore; ?>]" required="">
                        <option value="">-- Select from CR-CA-SP --</option>
                        <?php
                        foreach ($itemUsedDetails as $itemUsedDetailsRow) { ?>
                            <option value="<?php echo $itemUsedDetailsRow->Compt_Id;?>" <?php if ($reportDetailsRow->IRI_xAxis_Item_Id == $itemUsedDetailsRow->Compt_Id) { echo 'selected'; } ?>>
                              <?php echo $itemUsedDetailsRow->Compt_Name; ?>
                            </option>
                        <?php } ?>
                      </select>
                    </div>  
                    <?php
                    // for 2nd onward entry present in database for selected item
                    if ($countAddMore > 0) { ?>
                      <div class="add_col" style="margin-top: 35px;">
                        <button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeReportButton"><b>-</b></button>
                      </div>
                    <?php } else if ($countAddMore == 0) {
                    // for 1st entry present in database for selected item
                    ?>
                      <div class="add_col" style="margin-top: 35px;">
                        <button type="button" data-toggle="tooltip" title="Add More" class="btn btn-primary" id="addReportButton"><b>+</b></button>
                      </div>
                    <?php } // end of else if condition
                    ?>
                  </div>
                  <!-- end of item dropdown for x axis and add more button -->

                  <!-- start of Min and Max Value for x axis-->
                  <div class="form-group row text-left">
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="minValuexAxis">Min Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control minValuexAxis" id="minValuexAxis" name="minValuexAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $reportDetailsRow->IRI_xAxis_Min_Value; ?>">
                    </div>
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="maxValuexAxis">Max Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control maxValuexAxis" id="maxValuexAxis" name="maxValuexAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $reportDetailsRow->IRI_xAxis_Max_Value; ?>">
                    </div>
                  </div>
                  <!-- end of Min and Max Value for x axis -->

                  <!-- start of item dropdown for y-axis -->
                  <div class="form-group row text-left">
                    <div class="form-group col-sm-12 col-md-5">
                      <label class="col-form-label" for="usedItemsyAxis<?php echo $countAddMore; ?>">Items for y-axis : <span class="text-danger">*</span></label> 
                      <!-- <select class="custom-select2 form-control" id="usedItemsyAxis" name="usedItemsyAxis" required=""> -->
                      <select class="form-control" id="usedItemsyAxis<?php echo $countAddMore; ?>" name="usedItemsyAxis[<?php echo $countAddMore; ?>]" required="">
                        <option value="">-- Select from CR-CA-SP --</option>
                        <?php
                        foreach ($itemUsedDetails as $itemUsedDetailsRow) { ?>
                            <option value="<?php echo $itemUsedDetailsRow->Compt_Id;?>" <?php if ($reportDetailsRow->IRI_yAxis_Item_Id == $itemUsedDetailsRow->Compt_Id) { echo 'selected'; } ?>>
                              <?php echo $itemUsedDetailsRow->Compt_Name; ?>
                            </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <!-- end of item dropdown for y axis -->

                  <!-- start of Min and Max Value for y axis-->
                  <div class="form-group row text-left">
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="minValueyAxis">Min Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control minValueyAxis" id="minValueyAxis" name="minValueyAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="<?php echo $reportDetailsRow->IRI_yAxis_Min_Value; ?>">
                    </div>
                    <div class="form-group col-sm-12 col-md-5">
                      <label for="maxValueyAxis">Max Value: <span class="text-danger">*</span></label>
                      <input type="number" class="form-control maxValueyAxis" id="maxValueyAxis" name="maxValueyAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="<?php echo $reportDetailsRow->IRI_yAxis_Max_Value; ?>">
                    </div>
                  </div>
                  <!-- end of Min and Max Value for y axis -->

                  <!-- start of CK Editor -->
                  <div class="form-group row text-left">
                    <div class="form-group col-sm-10">
                      <label for="details">Details:</label>
                      <div class="input-group">
                        <textarea id="" name="details[]" class="form-control details">
                          <?php echo $reportDetailsRow->IRI_Text; ?>
                        </textarea>
                      </div>
                      <div class="details_error"></div>
                    </div>
                  </div>
                  <!-- end of CK Editor -->

                  </div>
                  <?php
                    $countAddMore++; // incrementing loop Count
                   } // end of loop
                  } // end of else for not present any record in database
                  ?>
                  <!-- ======================== -->
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

    // setting item dropdown
    <?php
      $optionsShow = '';
      foreach ($itemUsedDetails as $itemUsedDetailsRow) { 
        $optionsShow .= '<option value="'.$itemUsedDetailsRow->Compt_Id.'">'.$itemUsedDetailsRow->Compt_Name.'</option>';
      }
    ?>
    var optionsShow = '<?php echo $optionsShow; ?>';

    // setting count to distinguished name and id for dropdown   
    var countAddMore = '<?php echo $countAddMore; ?>';
    $('#addReportButton').on('click',function() {
      countAddMore++;
      $('#addReportButton').tooltip('hide');

      $('#addReportHere').append('<div class="col-sm-12 removeThis" style="margin-left: 15px;"> <!-- start of item dropdown for x-axis and add more button --> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"> <label class="col-form-label" for="usedItemsxAxis'+countAddMore+'">Items for x-axis: <span class="text-danger">*</span></label> <select class="form-control" id="usedItemsxAxis'+countAddMore+'" name="usedItemsxAxis['+countAddMore+']" required=""><option value="">-- Select from CR-CA-SP --</option>'+optionsShow+'</select></div> <div class="add_col" style="margin-top: 35px;"><button type="button" data-toggle="tooltip" title="Remove This" class="btn btn-danger removeDiv" id="removeReportButton"><b>-</b></button></div> </div> <!-- end of item dropdown for x-axis and add more button --> <!-- start of Min and Max Value for x axis --> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValuexAxis">Min Value: <span class="text-danger">*</span></label><input type="number" class="form-control minValuexAxis" id="minValuexAxis" name="minValuexAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="" ></div> <div class="form-group col-sm-12 col-md-5"><label for="maxValuexAxis">Max Value: <span class="text-danger">*</span></label><input type="number" class="form-control maxValuexAxis" id="maxValuexAxis" name="maxValuexAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="" ></div></div> <!-- end of Min and Max Value for x axis --> <!-- start of item dropdown for y-axis --> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"> <label class="col-form-label" for="usedItemsyAxis'+countAddMore+'">Items for y-axis: <span class="text-danger">*</span></label> <select class="form-control" id="usedItemsyAxis'+countAddMore+'" name="usedItemsyAxis['+countAddMore+']" required=""><option value="">-- Select from CR-CA-SP --</option>'+optionsShow+'</select></div> </div> <!-- end of item dropdown for y-axis --> <!-- start of Min and Max Value for y axis --> <div class="form-group row text-left"><div class="form-group col-sm-12 col-md-5"><label for="minValueyAxis">Min Value: <span class="text-danger">*</span></label><input type="number" class="form-control minValueyAxis" id="minValueyAxis" name="minValueyAxis[]" min="" max="" required="" placeholder="Enter Min Value" value="" ></div> <div class="form-group col-sm-12 col-md-5"><label for="maxValueyAxis">Max Value: <span class="text-danger">*</span></label><input type="number" class="form-control maxValueyAxis" id="maxValueyAxis" name="maxValueyAxis[]" min="" max="" required="" placeholder="Enter Max Value" value="" ></div></div> <!-- end of Min and Max Value for y axis --> <!-- start of CK Editor --><div class="form-group row text-left"><div class="form-group col-sm-10"><label for="details">Details:</label><div class="input-group"><textarea id="" name="details[]" class="form-control details"></textarea></div><div class="details_error"></div></div></div><!-- end of CK Editor --> </div>');
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
