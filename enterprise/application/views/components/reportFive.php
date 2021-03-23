<style>
  .swal-size-sm{
    width: auto;
  }
  .swal2-content
  {
    font-size: 1em;
    font-weight: bold !important;
  }
</style>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1><i class="fa fa-eercast text-blue"></i> Report</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report</li>
              </ol>
            </nav>
          </div>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="" id="formHTML">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue">Choose Filter</h5>
                </div>

                  <div class=" col-sm-12 col-md-12 col-lg-12 row form-group">

                    <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?> 
                    <div class=" col-sm-12 col-md-3 col-lg-3 d-none">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="allItemUsers" name="filtertype" class="custom-control-input" value="allItemUsers" data-filtertype="allItemUsers">
                        <label class="custom-control-label" for="allItemUsers">All Users</label>
                      </div>
                    </div>
                    <?php } ?>

                    <div class=" col-sm-12 col-md-3 col-lg-3 d-none">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="myItemUsers" name="filtertype" class="custom-control-input" checked="" value="myItemUsers" data-filtertype="myItemUsers">
                        <label class="custom-control-label" for="myItemUsers">My Users</label>
                      </div>
                    </div>

                    <div class=" col-sm-12 col-md-3 col-lg-3 d-none">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="oneByOneItemUsers" name="filtertype" class="custom-control-input" value="oneByOneItemUsers" data-filtertype="oneByOneItemUsers">
                        <label class="custom-control-label" for="oneByOneItemUsers">One by One Users</label>
                      </div>
                    </div>

                  </div>
                  <!-- end of radio, choose dropdown -->
                  <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="enterpriseShowHide">
                      <label for="Cmap_Enterprise_ID" class="col-sm-12 col-md-3 col-form-label">Select Enterprize </label>
                      <div class="col-sm-12 col-md-9">
                        <select name="Cmap_Enterprise_ID" id="Cmap_Enterprise_ID" class="custom-select2 form-control" required="">
                          <option value="">--Select Enterprize--</option>
                          <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
                            <option value="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>
                          <?php } ?>
                        </select> <span class="text-danger">*</span>
                      </div>
                    </div>
                  <?php } else { ?>
                    <input type="hidden" id="Cmap_Enterprise_ID" name="Cmap_Enterprise_ID" value="<?php echo $this->session->userdata('loginData')['User_Id']; ?>">
                  <?php } ?>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="Cmap_Formula_ID" class="col-sm-12 col-md-3 col-form-label">Score Selector<br />(Using Formula Value) </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_Formula_ID" id="Cmap_Formula_ID" class="custom-select2 form-control" required="">
                      <option value="">--Score Selector--</option>
                      <?php foreach ($formulaDetails as $formulaRow) { ?>
                        <option value="<?php echo $formulaRow->Items_Formula_Id;?>"><?php echo $formulaRow->Items_Formula_Title; ?></option>
                      <?php } ?>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>
  
                <div class="row col-12 row form-group d-none" id="userShowHide">
                  <label for="Cmap_UserId" class="col-12 col-md-3 col-form-label">Select Users </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_UserId[]" id="Cmap_UserId" class="custom-select2 form-control" multiple="" required="">
                    <?php 
                      if ($usersDetails > 0 || $usersDetails != '') {
                      foreach ($usersDetails as $usersRow) { ?>
                      <option value="<?php echo $usersRow->User_id;?>" title="<?php echo $usersRow->User_username;?>"><?php echo $usersRow->User_fullName; ?></option>
                    <?php } } ?>
                    </select> <span class="text-danger">* (Click on box for dropdown)</span>
                  </div>
                </div>

                <!-- 1->Shortlist, 2->IDP, 3->ehire -->
                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="action_ID" class="col-sm-12 col-md-3 col-form-label">Select Action </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="action_ID" id="action_ID" class="custom-select2 form-control" required>
                      <option value="1" selected>Shortlist</option>
                      <option value="2">IDP</option>
                      <option value="3">ehire</option>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>
                <!-- end of dropdown -->

                <div class="row col-12 form-group">
                  <label for="date" class="col-12 col-md-3 col-form-label">Select Date</label>
                  <div class="col-12 col-md-5">
                    <div class="input-group" name="gamedate" id="datepicker">
                      <input type="text" class="form-control datepicker-here" id="report_startDate" name="report_startDate" value="" data-value="<?php echo time();?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">

                      &nbsp; <span class="input-group-addon">To</span> &nbsp;

                      <input type="text" class="form-control datepicker-here" id="report_endDate" name="report_endDate" value="" data-value="<?php echo time();?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">
                    </div>
                  </div>

                  <!-- Generate Report Button -->
                  <div class="col-12 col-md-2">
                    <input name="generate_Report_Operation" id="" value="Get Report" class="btn btn-primary generate_Report_Operation" readonly>
                  </div>
                </div>

              </div>
              <!-- end of adding users -->

              <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="title">
                  <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h3 id="tableContentText" class="text-primary mb-3"></h3>
                    
                      <div class="row" id="addTable">
                        <!-- report data shows here -->
                      </div>

                      <div class="clearfix"></div>
                      <div class="text-center d-none" id="btnSaveCancel">
                        <button type="submit" class="btn btn-primary px-5" id="submit" name="submit" value="submit"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Save</button>
                        <a href="<?php echo base_url('ReportFive/'); ?>" class="btn btn-outline-danger">CANCEL</a>
                      </div>

                  </div>
                </div>
              </div>
              </div>
        </form>
 
            </div>
          </div>
        </div>

<script>
  $(document).ready(function(){
    appendCompetenceUserReports();    

    $('input[name="filtertype"]').on('change',function(){
      // var filterValue     = $(this).val();
      var itemUsersFilter = $(this).data('filtertype');
      //console.log(itemUsersFilter);

      // removing Title and table view on Filter type change
      $('#addTable, #tableContentText').html('');

      if(itemUsersFilter == 'myItemUsers'){
        //if filter is of type myItemUsers
        //for selected enterprise users only

        //removed user selection
        // $('#Cmap_UserId').html('');
        $('#Cmap_UserId').attr('selected', false);
        $("#Cmap_UserId").attr('disabled','disabled');
        //$('#userShowHide').addClass('invisible');
        $('#userShowHide').addClass('d-none');

        //added enterprise selection
        $("#Cmap_Enterprise_ID").removeAttr('disabled');
        //$('#enterpriseShowHide').removeClass('invisible');
        $('#enterpriseShowHide').removeClass('d-none');

        //appending formula details on dropdown box
        //var formulaOptionsOnRadioChange = '<option>--Score Selector--</option>';
        //$('#Cmap_Formula_ID').html(formulaOptionsOnRadioChange);
      }
      else if(itemUsersFilter == 'oneByOneItemUsers'){
        //else if filter is of type oneByOneItemUsers
        //for selected user of selected enterprise only

        //added user selection
        $("#Cmap_UserId").removeAttr('disabled');
        //$('#userShowHide').removeClass('invisible');
        $('#userShowHide').removeClass('d-none');

        //added enterprise selection
        $("#Cmap_Enterprise_ID").removeAttr('disabled');
        //$('#enterpriseShowHide').removeClass('invisible');
        $('#enterpriseShowHide').removeClass('d-none');

        //appending formula details on dropdown box
        //var formulaOptionsOnRadioChange = '<option>--Score Selector--</option>';
        //$('#Cmap_Formula_ID').html(formulaOptionsOnRadioChange);
      }
      else if(itemUsersFilter == 'allItemUsers'){
        //else filter is of type allItemUsers
        //for all enterprise all user

        //removed user selection
        // $('#Cmap_UserId').html('');
        $('#Cmap_UserId').attr('selected', false);
        $("#Cmap_UserId").attr('disabled','disabled');
        //$('#userShowHide').addClass('invisible');
        $('#userShowHide').addClass('d-none');

        //removed enterprise selection
        $("#Cmap_Enterprise_ID").attr('disabled','disabled');
        //$('#enterpriseShowHide').addClass('invisible');
        $('#enterpriseShowHide').addClass('d-none');
      }

        <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
          var enterpriseListOnRadioChange = '<option value="">--Select Enterprize--</option>';
          <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
            enterpriseListOnRadioChange += '<option value="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>';
          <?php } ?>
          $('#Cmap_Enterprise_ID').html(enterpriseListOnRadioChange);
        <?php }?>

        //appending formula details on dropdown box
        var formulaOptionsOnRadioChange = '<option>--Score Selector--</option>';
        <?php foreach ($formulaDetails as $formulaRow) { ?>
          formulaOptionsOnRadioChange += '<option value="<?php echo $formulaRow->Items_Formula_Id;?>"><?php echo $formulaRow->Items_Formula_Title; ?></option>';
        <?php } ?>
        $('#Cmap_Formula_ID').html(formulaOptionsOnRadioChange);
    });

    //according to selected Enterprise fetching all its formula and users
    $('#Cmap_Enterprise_ID').on('change',function(){
      var enterprise_ID = $("#Cmap_Enterprise_ID").val();

      var formulaOptions = '<option>--Score Selector--</option>';
      var userOptions    = '';
      if(enterprise_ID){
        $.ajax({
          url  : "<?php echo base_url('Ajax/getCompetenceUserAndFormula/'); ?>"+enterprise_ID,
          type : 'POST',

          beforeSend: function(){  },
          success: function(result){
            result = JSON.parse(result);
            if(result.status == 200) {
              let resultFormulaOptions = result.enterpriseFormulaData;
              let resultUserOptions    = result.enterpriseUserData; 

              //Enterprise Formula
              $.each(resultFormulaOptions,function(i,e){
                formulaOptions += '<option value="'+resultFormulaOptions[i].Items_Formula_Id+'">'+resultFormulaOptions[i].Items_Formula_Title+'</option>'
              });

              //Enterprise Games
              $.each(resultUserOptions,function(i,e){
                userOptions += '<option value="'+resultUserOptions[i].User_id+'" title="'+resultUserOptions[i].User_username+'">'+resultUserOptions[i].User_fullName+'</option>'
              });
            }
            else{
              Swal.fire({
                icon: 'error',
                html: result.message,
              });

              $('#showResultDataComp').html('<span class="text-danger text-center">Please Select Score Selector To show Report</span>');
            }
            //appending formula and user details on dropdown box
            $('#Cmap_Formula_ID').html(formulaOptions);
            $('#Cmap_UserId').html(userOptions);
          },
          error: function(jqXHR, exception){
            Swal.fire({
              icon: 'error',
              html: jqXHR.responseText,
            });
            $("#input_loader").html('');
          }
        });
      }
      else{
        $('#Cmap_Formula_ID').html(formulaOptions);
        $('#Cmap_UserId').html(userOptions);
        return false;
      }
    });//end of function

    // on form submit
    $('#formHTML').submit(function(e) {
      // removing all error message when form submit
      $(".removemsg").html('');

      // disable button
      $('#submit').prop("disabled", true);
      // adding spinner to button
      $('#submit').html('<span class="btn-label"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');

      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('AjaxNew/saveReportFiveData'); ?>",
        data: new FormData(document.getElementById('formHTML')),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        dataType: "html",
        processData: false,
        
        success: function(result) {
          result = JSON.parse(result);
          // console.log(result.message);

          // enabling button
          $('#submit').prop("disabled", false);
          // removing spinner from button
          $('#submit').html('<span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Save');

          switch (result.status) {
            case 'error':
              // console.log(result.message);
              // $("#folderTitleError").html(result.message.folderTitleError);
              break;

            case '200':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              });
              break;

            case '201':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              });
              break;
          }
        }
      });
    }); // end of form submit
  });
  
  //====================================

  function appendCompetenceUserReports() {
    $('.generate_Report_Operation').on('click', function() {

      var report_startDate = $("#report_startDate").val();
      var report_endDate   = $("#report_endDate").val();

      //console.log(report_startDate);
      //console.log(report_endDate);
      if (report_startDate == "" && report_endDate == "") {
        Swal.fire('Please select start and end date');
      } else if (report_startDate == "") {
        Swal.fire('Please Select Start Date');
      } else if (report_endDate == "") {
        Swal.fire('Please Select End Date');
      }
      //     else if(report_startDate <= report_endDate){
      //  Swal.fire('Please make sure End Date is greater then Start Date');
      // } 
      else if (report_startDate && report_endDate) {
        let formula_selected = $('#Cmap_Formula_ID').val();
        //console.log(formula_selected);

        let user_selected    = $('#Cmap_UserId').val();
        let waitStringText   = "Please Wait While Loading Report";
        let action_ID        = $('#action_ID').val();

        if (formula_selected < 1 || formula_selected == '--Score Selector--') {
          // Formula not Selected
          // removing the table and chart report if user not Selected Formula
          $('#addTable, #tableContentText').html('');

          $('#addTable').html('<span class="text-danger text-center">Please Select Score Selector To View Report</span>');
        }
        else if (action_ID < 1 ) {
          // 1->Shortlist, 2->IDP, 3->ehire

          // action not selected
          $('#addTable, #tableContentText').html('');

          $('#addTable').html('<span class="text-danger text-center">Please Select Action To View Report</span>');
        }
        else {
          // show some wait text to users
          $('#addTable').html('<span class="text-success text-center">' + waitStringText + '</span>');
          // tirgger ajax and get the user report which are visible
          var formData = $('#formHTML').serialize();

          $.ajax({
            url: "<?php echo base_url('Ajax/compUserReportFiveData/'); ?>",
            type: 'POST',
            data: formData,

            success: function(result) {
              result = JSON.parse(result);
              //console.log(result);

              if (result.status == 201) {
                $('#btnSaveCancel').addClass('d-none');
                Swal.fire({
                  position: result.position,
                  icon: result.icon,
                  title: result.title,
                  html: result.message,
                  showConfirmButton: result.showConfirmButton,
                  timer: result.timer,
                });
              } 
              else {
                // removing the chart report if user viewed earlier
                $('#tableContentText').html('');

                $('#addTable').html(result.data);
                makeTableDataTable();

                $('#btnSaveCancel').removeClass('d-none');
                
                $('[data-toggle="tooltip"]').tooltip();
              }
            }
          });
        }
      }
    });
  }
</script>
