<?php 
  // Setting Login user Role
  // superadmin, 1 = Enterprize, 2 = SubEnterprize, 3 = Report Viewer
  $userRole = $this->session->userdata('loginData')['User_Role'];

  // Setting date Value
  // 86400 // 1 day value (24 hours)
  // 2592000 // 1 Month value (30 days)
  // 31536000 // 1 year value (365 days)

  $currentTimeStamp   = strtotime(date('Y-m-d H:i:s'));
  $gameOneYearAgoTime = $currentTimeStamp - 31536000*1; // 1 year ago time
  $gameTenYearAgoTime = $currentTimeStamp - 31536000*10; // 10 year ago time
  $gameOneYearTime    = $currentTimeStamp + 31536000*1; // 1 year time
  $gameFiveYearTime   = $currentTimeStamp + 31536000*5; // 5 year time
  $gameTenYearTime    = $currentTimeStamp + 31536000*10; // 10 year time
?>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <!-- <h1><i class="fa fa-database text-blue"></i> Allocate/De-Allocate Card</h1> -->
              <h1>Allocate/De-Allocate Card</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Allocate/De-Allocate Card</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <!-- <h5 class="text-blue">List</h5> -->
                </div>
                  
                <!-- Start Form -->
                <form action="#" method="POST" id="formHTML">

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="enterprizeID">Select Enterprize <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-9">
                      <select class="custom-select2 form-control" name="enterprizeID" id="enterprizeID" required>
                        <option value="">--Select Enterprize--</option>
                        <?php foreach ($enterprizeList as $detailsRow) { ?>
                          <option value="<?php echo $detailsRow->Enterprise_ID; ?>"><?php echo $detailsRow->Enterprise_Name; ?></option>
                        <?php } ?>
                      </select>
                      <span id="enterprizeIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row col-12 row form-group" id="gameDiv">
                    <label class="col-12 col-md-3 col-form-label" for="cardID" >Select Card <span class="text-danger">*</span></label>
                    <div class="col-12 col-md-9">
                      <select class="custom-select2 form-control" name="cardID" id="cardID" required>
                        <option value="">--Select Card--</option>
                      </select>
                      <span id="cardIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div id="assignDate" class="row col-12 row form-group">
                    <label for="userCreationDate" class="col-12 col-md-3 col-form-label">Select User Account Start Date</label>
                    <div class="col-12 col-md-5">
                      <div class="input-group">
                        <input type="text" class="form-control datepicker-here" id="userCreationDateStart" name="userCreationDateStart" value="" data-value="<?php echo $currentTimeStamp; ?>" placeholder="Start Date" readonly data-startdate="<?php echo $gameTenYearAgoTime; ?>" data-enddate="<?php echo $gameTenYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy">

                        &nbsp;&nbsp;<span class="input-group-addon">To</span>&nbsp;&nbsp;

                        <input type="text" class="form-control datepicker-here" id="userCreationDateEnd" name="userCreationDateEnd" value="" data-value="<?php echo $currentTimeStamp; ?>" placeholder="End Date" readonly data-startdate="<?php echo $gameTenYearAgoTime; ?>" data-enddate="<?php echo $gameTenYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>

                    <!-- Get User List Button -->
                    <!-- <div class="col-12 col-md-2">
                      <input id="getUserList" value="Get Active Users List" class="btn btn-primary getUserList" readonly>
                    </div> -->
                     <br /><br /> or
                  </div>

                  <div class="text-center pr-5 pt-0">
                   
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="searchUsername">Username</label>
                    <div class="col-sm-12 col-md-5">
                      <input type="text" class="form-control" name="searchUsername" id="searchUsername" value=""  placeholder="Search By Username">
                      <span id="searchUsernameError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="text-center pr-5">
                    <input id="getUserList" value="Get Users List" class="btn btn-primary getUserList px-5" readonly>
                  </div>

                  <span class="" id ="userMessage"></span>
                  <span class="d-none" id ="userListForm">
                  <hr />
                  <!-- ================================ -->

                  <div id="assignDate" class="row col-12 row form-group">
                    <label for="allocateDate" class="col-12 col-md-3 col-form-label">Set User Card Date & Time <span class="text-danger">*</span></label>
                    <div class="col-12 col-md-5">
                      <div class="input-group">
                        <input type="text" class="form-control datetimepicker" id="allocateDateStart" name="allocateDateStart" value="" data-value="<?php echo $currentTimeStamp; ?>" placeholder="Select Start Date" required readonly data-startdate="<?php echo $currentTimeStamp; ?>" data-enddate="<?php echo $gameTenYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy">

                        &nbsp;&nbsp;<span class="input-group-addon">To</span>&nbsp;&nbsp;

                        <input type="text" class="form-control datetimepicker" id="allocateDateEnd" name="allocateDateEnd" value="" data-value="<?php echo $currentTimeStamp; ?>" placeholder="Select End Date" required readonly data-startdate="<?php echo $currentTimeStamp; ?>" data-enddate="<?php echo $gameTenYearTime; ?>" data-language="en" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="replayCount">Replay Count (Unlimited -1) <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input type="number" class="form-control" name="replayCount" id="replayCount" value="0" min="-1" max="10000" placeholder="Enter Replay Count" required>
                      <span id="replayCountError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="clearfix">
                    <div class="col-md-2 custom-control custom-checkbox pull-right">
                      <input type="checkbox" class="custom-control-input" value="" id="select_all" name="select_all">&nbsp;
                      <label class="custom-control-label" for="select_all">Select/Unselect All</label>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="table-responsive py-5" id="returnTableHTML">
                    <!-- Adding datatable here -->
                  </div>
                  <div class="clearfix"></div>

                  <div class="text-center">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary px-5"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit</button>
                    <a href="<?php echo base_url('allocateGame'); ?>"><button type="button" name="submit"class="btn btn-danger px-5"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button></a>
                  </div>

                  </span>

                </form>
                <!-- End Form -->

              </div>
            </div>
          </div>
        </div>

<script>
  $(document).ready(function() {

    // $('#userListForm').removeClass('d-none');
    $('#userListForm').addClass('d-none');

    // on change of enterprize ID fetching card list
    $('#enterprizeID').on('change', function() {
      var enterprizeID = $('#enterprizeID').val();
      var optionCard   = '<option value="">--Select Card--</option>';
      $('#userListForm').addClass('d-none');

      if (enterprizeID) {
        $.ajax({
          url : "<?php echo base_url(); ?>Ajax/fetchAssignedGames/enterpriseUsers/"+enterprizeID,
          type: "POST",

          success: function(result) {           
            if (result == 'No Card found') {
              Swal.fire('No Card allocated to selected Enterprize');
            }
            else {
              result = JSON.parse(result);

              $(result).each(function(i, e) {
                optionCard += ("<option value='"+result[i].Game_ID+"'>"+result[i].Game_Name+"</option>");
              });

              $('#cardID').html(optionCard);
            }
          },
        });
      }
      else {
        Swal.fire('Please select Enterprize');
      }
    }); // end of on change Enterprize ID 

    // on change of Card ID fetching card list
    $('#cardID').on('change', function() {
      $('#userListForm').addClass('d-none');
    }); // end of on change Card ID 
   
    // on click get user list
    $('.getUserList').on('click', function() {
      // Removing previous User List Table
      $('#returnTableHTML, #userMessage').html('');
      $('#userListForm').addClass('d-none');

      var enterprizeID          = $('#enterprizeID').val();
      var cardID                = $('#cardID').val();

      var userCreationDateStart = $("#userCreationDateStart").val();
      var userCreationDateEnd   = $("#userCreationDateEnd").val();

      var searchUsername        = $("#searchUsername").val();

      // console.log(`
      //   Start Date - ${userCreationDateStart}
      //   end Date   - ${userCreationDateEnd}
      // `);

      // if (userCreationDateStart == "" && userCreationDateEnd == "") {
      //   Swal.fire('Please select User Creation start and end date');
      // } 
      // else if (userCreationDateStart == "") {
      //   Swal.fire('Please Select User Creation Start Date');
      // } 
      // else if (userCreationDateEnd == "") {
      //   Swal.fire('Please Select User Creation End Date');
      // }
      // else if (userCreationDateStart <= userCreationDateEnd) {
      //  Swal.fire('Please make sure User Creation End Date is greater then Start Date');
      // } 
      // else if (userCreationDateStart && userCreationDateEnd) {   
        if (enterprizeID < 1 || enterprizeID == '--Select Enterprize--') {
          // Enterprize not selected
          Swal.fire('Please Select Enterprize');
        }
        else if (cardID < 1 || cardID == '--Select Card--') {
          // Card not Selected
          Swal.fire('Please Select Card');
        }
        else {
          // show wait text to users
          $('#userMessage').html('<span class="text-success text-center">Please Wait While Loading User list</span>');

          // if (searchUsername) {
          //   var dataValue = "enterprizeID="+enterprizeID+"&cardID="+cardID+"&userCreationDateStart="+userCreationDateStart+"&userCreationDateEnd="+userCreationDateEnd+"&searchUsername="+searchUsername
          // }
          // else {
          //   var dataValue = "enterprizeID="+enterprizeID+"&cardID="+cardID+"&userCreationDateStart="+userCreationDateStart+"&userCreationDateEnd="+userCreationDateEnd
          // }

          $.ajax({
            url      : "<?php echo base_url('AllocateGame/getUserListData'); ?>",
            type     : "POST",
            dataType : 'html',
            data     : "enterprizeID="+enterprizeID+"&cardID="+cardID+"&userCreationDateStart="+userCreationDateStart+"&userCreationDateEnd="+userCreationDateEnd+"&searchUsername="+searchUsername,

            success: function(result) {
              result = JSON.parse(result);
              console.log(result.data);

              // removing wait message
              $('#userMessage').html('');

              switch (result.status) {
                case '200':
                  // putting whole regenerated table
                  $('#returnTableHTML').empty();
                  $('#returnTableHTML').html(result.data);
                  // makeTableDataTable();
                  // makeTableDataTable({
                  //   "paging": false,
                  // });
                  $('#userListForm').removeClass('d-none');
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
            },
          });
        }
      // }
    });

    // for selecting all users at ones or removing all selected users at once
    $('#select_all').click(function(i,e) {
      if($(this).is(':checked')) {
        $('input[type=checkbox]').each(function(i,e) {
          $(this).prop('checked',true);
        });
      }
      else {
        $('input[type=checkbox]').each(function(i,e) {
          $(this).prop('checked',false);
        });
      }
    }); // end of On Click select_all function

    // on form submit
    $('#formHTML').submit(function(e) {
      // removing all error message when form submit
      $(".removemsg").html('');
      // console.log('inside form submit');

      // disable button
      $('#submit').prop("disabled", true);
      // adding spinner to button
      $('#submit').html('<span class="btn-label"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');

      e.preventDefault();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('AllocateGame/allocateCard'); ?>",
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
          $('#submit').html('<span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit');

          switch (result.status) {
            case 'error':
              // console.log(result.message);
              $("#enterprizeIDError").html(result.message.enterprizeIDError);
              $("#cardIDError").html(result.message.cardIDError);
              $("#replayCountError").html(result.message.replayCountError);
              break;

            case '200':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              }).then(function(){
                  window.location = "<?php echo base_url('allocateGame'); ?>";
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
</script>
