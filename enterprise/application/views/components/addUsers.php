<?php 
  // Setting Login user Role
  // superadmin, 1 = Enterprize, 2 = SubEnterprize
  $userRole = $this->session->userdata('loginData')['User_Role'];

  // Setting date Value
  // 86400 // 1 day value (24 hours)
  // 2592000 // 1 Month value (30 days)
  // 31536000 // 1 year value (365 days)

  $currentTimeStamp = strtotime(date('Y-m-d'));
  $gameOneYearTime  = $currentTimeStamp + 31536000*1; // 1 year time
  $gameEndTime      = $currentTimeStamp + 31536000*10; // 10 year time
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
              <!-- <h1><i class="fa fa-user-plus"></i> Add User</h1> -->
              <h1>Add User</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>"><i class="fa fa-home"></i> Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('Users/EnterpriseUsers'); ?>">Enterprize Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add User</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

          <div class="clearfix pb-3">
            <div class="pull-left">
              <h4 class="text-blue ">Enter Details</h4>
            </div>
            <div class="pull-right">
              <input type="checkbox" name="showCsvForm" id="showCsvForm"> Choose File To Upload Users
            </div>
          </div>

          <!-- to add data by csv -->
          <form action="" method="post" id="addByCsv" enctype="multipart/form-data" class="d-none">
            <div class="pull-right" style="margin-top:-30px;">
              <a href="<?php echo base_url(); ?>csvdemofiles/user-enterprise-upload-csv-demo-file.csv" download="DemoEnterpriseUsers.csv"> <i class="fa fa-download"></i> Demo CSV file</a>
            </div>

            <div class="form-group row" id="Enterprise_Section">
              <?php if ($userRole == 1) { ?>
                <label for="Select Enterprize" class="col-sm-12 col-md-3 col-form-label">Select Enterprize<span class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-6">
                  <input  type="text" name="Enterprise" id="Enterprise" class="form-control Enterprise" value="<?php echo $this->session->userdata('loginData')['User_FullName']; ?> " readonly>
                </div>
              <?php } else if ($userRole != 1 && $userRole != 2) { ?>
                <label for="Select Enterprize" class="col-sm-12 col-md-3 col-form-label">Select Enterprize<span class="text-danger">*</span></label>
                <div class="col-sm-12 col-md-6">
                  <select name="Enterprise" id="Enterprise1" class="custom-select2 form-control Enterprise" required>
                    <option value="">--Select Enterprize--</option>
                    <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                      <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } ?>
            </div>

            <!-- subenterprise dropdown -->
            <?php if ($typeUser == 'subentuser') { ?>
              <div class="form-group row selectSubenterprise" id="selectSubenterprise">
                <label for="Select SubEnterprize" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span>Select SubEnterprize</label>
                <?php if ($userRole == 2) { ?>
                <div class="col-sm-12 col-md-6 ">
                  <input  type="text" name="subenterprise" id="subenterprise" class="form-control subenterprise" value="<?php echo $this->session->userdata('loginData')['User_FullName']; ?> " readonly>
                </div>
               <?php } else { ?>
                <div class="col-sm-12 col-md-6">
                  <select name='subenterprise' id='subenterprise1' class='custom-select2 form-control subenterprise' required>
                    <option value=''>-Select SubEnterprize-</option>
                    <?php foreach ($Subenterprise as $row) { ?> 
                      <option value="<?php echo $row->SubEnterprise_ID; ?>"><?php echo $row->SubEnterprise_Name; ?></option>
                    <?php } ?> 
                  </select>
                </div>
              <?php } ?>
              </div>
            <?php } ?>

          <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label">Select Date <span class="text-danger">*</span></label>
            <div class="input-group col-sm-12 col-md-6">
              <input type="text" class="form-control datepicker-here" id="User_GameStartDateCSV" name="User_GameStartDateCSV" value="<?php echo date('Y-m-d'); ?>" data-value="<?php echo strtotime(date('Y-m-d')); ?>" data-startdate="<?php echo time(); ?>" data-enddate="<?php echo $gameEndTime; ?>" placeholder="Select Start Date" required readonly data-language='en' data-date-format="dd-mm-yyyy">

              <span class="input-group-addon px-2">To</span>

              <input type ="text" class="form-control datepicker-here" id="User_GameEndDateCSV" name="User_GameEndDateCSV" value="<?php echo $gameOneYearTime; ?>" data-value="<?php echo $gameOneYearTime; ?>" data-startdate="<?php echo time(); ?>" data-enddate="<?php echo $gameEndTime; ?>" placeholder="Select End Date" required readonly data-language='en' data-date-format="dd-mm-yyyy">
            </div>
          </div>

          <!-- Setting Company ID -->
          <!-- <input type="hidden" name="User_companyid" value="0"> -->

          <div class="form-group row">
            <label class="col-sm-12 col-md-3 col-form-label">Choose Csv File To Upload <span class="text-danger">*</span></label>
            <div class="col-sm-12 col-md-6">
              <input type="file" name="upload_csv" accept=".csv" id="upload-file" value="" class="form-control" required>
            </div>
          </div>

          <div class="form-group row pt-2 text-center">
            <label class="col-sm-12 col-md-3 col-form-label"></label>
            <div class="col-sm-12 col-md-6">
              <button class="btn btn-primary px-5" type="submit" name="submit" value="Upload" id="clickButton"><i class="fa fa-upload"></i> Upload Users</button>
            </div>
          </div>

        </form>

        <!-- to add data by single record -->
        <form method="post" action="" id="addByForm">

          <div class="form-group row d-none">
            <label for="User Type" class="col-sm-12 col-md-3 col-form-label">User Type</label>
            <div class="col-sm-12 col-md-6">
              <input type="radio" value="0" name="userType" <?php echo ($typeUser == 'entuser')?'checked':''; ?> id="enterpriseUser"> Enterprize
              <input type="radio" value="1" name="userType" <?php echo ($typeUser == 'subentuser')?'checked':''; ?> id="subenterpriseUser"> Subenterprize
            </div>
          </div>

          <!-- Enterprize dropdwon -->
          <div class="form-group row" id="Enterprise_Section">
            <?php if ($userRole == 1) { ?>
              <label for="Select Enterprize" class="col-sm-12 col-md-3 col-form-label">Select Enterprize <span class="text-danger">*</span></label>
              <div class="col-sm-12 col-md-6">
                <input  type="text" name="Enterprise" id="Enterprise" class="form-control Enterprise" value="<?php echo $this->session->userdata('loginData')['User_FullName']; ?> " readonly>
              </div>
            <?php } else if ($userRole != 1 && $userRole != 2) { ?>
              <label for="Select Enterprize" class="col-sm-12 col-md-3 col-form-label">Select Enterprize <span class="text-danger">*</span></label>
              <div class="col-sm-12 col-md-6">
                <select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">

                  <option value="">--Select Enterprize--</option>
                  <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                    <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                  <?php } ?>
                </select>
                <?php echo form_error('Enterprise'); ?>							
              </div>
            <?php } ?>
          </div>

          <!-- subEnterprize dropdown -->
          <?php if ($typeUser == 'subentuser') { ?>
            <div class="form-group row selectSubenterprise" id="selectSubenterprise">
              <label for="Select SubEnterprize" class="col-sm-12 col-md-3 col-form-label"><span class="alert-danger">*</span>Select SubEnterprize</label>
              <?php if ($userRole == 2) { ?>
                <div class="col-sm-12 col-md-6">
                 <input  type="text" name="subenterprise" id="subenterprise" class=" form-control subenterprise" value="<?php echo $this->session->userdata('loginData')['User_FullName']; ?>" readonly>
               </div>
             <?php } else { ?>
              <div class="col-sm-12 col-md-6 ">
                <select name='subenterprise' id='subenterprise' class='custom-select2 form-control subenterprise'>
                  <option value=''>-Select SubEnterprize-</option>
                  <?php foreach ($Subenterprise as $row) { ?> 
                    <option value="<?php echo $row->SubEnterprise_ID; ?>"><?php echo $row->SubEnterprise_Name; ?></option>
                  <?php } ?> 
                </select>
                <?php echo form_error('subenterprise'); ?>								
              </div>
            <?php }?>
          </div>
        <?php } ?>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">First Name <span class="text-danger">*</span></label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control" type="text" name="User_fname" required placeholder="Enter First Name" value="<?php echo set_value('User_fname'); ?>">
            <?php echo form_error('User_fname'); ?>							
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">Last Name <span class="text-danger">*</span></label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control" placeholder="Enter Last Name" required name="User_lname" type="text" value="<?php echo set_value('User_lname'); ?>" >
            <?php echo form_error('User_lname'); ?>							
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">Username <span class="text-danger">*</span></label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control" name="User_username" required placeholder="Enter Username" value="<?php echo set_value('User_username'); ?>" type="text" >
            <?php echo form_error('User_username'); ?>							
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">Email ID <span class="text-danger">*</span></label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control" name="User_email" required placeholder="Enter Email ID" type="text" value="<?php echo set_value('User_email'); ?>">
            <?php echo form_error('User_email'); ?>							
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">Mobile Number <span class="text-danger">*</span></label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control" name="User_mobile" required placeholder="Enter Mobile Number" type="tel" value="<?php echo set_value('User_mobile'); ?>">
            <?php echo form_error('User_mobile'); ?>							
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-12 col-md-3 col-form-label">Select Date <span class="text-danger">*</span></label>
          <div class="input-group col-sm-12 col-md-6">
            <input type="text" class="form-control datepicker-here" id="User_GameStartDate" name="User_GameStartDate" value="<?php echo date('Y-m-d'); ?>" data-value="<?php echo strtotime(date('Y-m-d')); ?>" data-startdate="<?php echo time(); ?>" data-enddate="<?php echo $gameEndTime; ?>" placeholder="Select Start Date" required readonly data-language='en' data-date-format="dd-mm-yyyy">

            <span class="input-group-addon px-2">To</span>

            <input type ="text" class="form-control datepicker-here" id="User_GameEndDate" name="User_GameEndDate" value="<?php echo $gameOneYearTime; ?>" data-value="<?php echo $gameOneYearTime; ?>" data-startdate="<?php echo time(); ?>" data-enddate="<?php echo $gameEndTime; ?>" placeholder="Select End Date" required readonly data-language='en' data-date-format="dd-mm-yyyy">
          </div>
        </div>

        <!-- Setting Company ID -->
        <input type="hidden" name="User_companyid" value="0">

        <!-- <div class="form-group row d-none">
          <label class="col-sm-12 col-md-3 col-form-label">Company</label>
          <div class="col-sm-12 col-md-6">
            <input class="form-control " value="0" required placeholder="If applicable" name="User_companyid" type="text" value="<?php //echo set_value('User_companyid'); ?>">
            <?php //echo form_error('User_companyid'); ?>							
          </div>
        </div> -->

        <div class="text-center">
          <button type="submit" name="submit" class="btn btn-primary px-5"><span class="btn-label"><i class="fa fa-user-plus"></i></span>&nbsp;Add User</button>
          <a href="<?php echo base_url('Users/EnterpriseUsers'); ?>"><button type="button" name="submit"class="btn btn-danger px-5"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button></a>
        </div>

      </form>
    </div>
  </div>

<div id="Modal_Bulkupload" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p id="bulk_u_msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="Modal_BulkuploadError" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p id="bulk_u_err"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
 $('#clickButton').on( 'click',function(e){
  e.preventDefault();
  var Enterpriseid    = $('#Enterprise1').val();
  var SubEnterpriseid = $('#subenterprise1').val();

  var User_GameStartDateCSV = btoa($("#User_GameStartDateCSV").val());
  var User_GameEndDateCSV   = btoa($("#User_GameEndDateCSV").val());
  // console.log(`
  //   Start Date - ${User_GameStartDateCSV}
  //   end Date   - ${User_GameEndDateCSV}
  // `);



  if (SubEnterpriseid != '' && SubEnterpriseid != undefined) {
    var gotourl = '<?php echo base_url(); ?>Ajax/SubEnterpriseUsersCSV/'+Enterpriseid+'/'+SubEnterpriseid;
  }
  else {
    // var gotourl = '<?php // echo base_url(); ?>Ajax/EnterpriseUsersCSV/'+Enterpriseid;
    var gotourl = '<?php echo base_url(); ?>Ajax/EnterpriseUsersCSV/'+Enterpriseid+'/'+User_GameStartDateCSV+'/'+User_GameEndDateCSV;
  }

  var formFile = $('#addByCsv').get(0);                     
  $.ajax({
    url        : gotourl,
    type       : "POST",
    data       : new FormData(formFile),
    cache      : false,
    contentType: false,
    processData: false,

    beforeSend : function(){
     // $('#loader').addClass('loading');
     $('.pre-loader').show();
    },

    success: function(result){
      try {
        var response = JSON.parse( result );
        //alert(response.status);
        if (response.status == 1) {
          //alert('in status = 1 ');
          $('#bulk_u_msg').html( response.msg );
          $('#Modal_Bulkupload').modal( 'show' );
        }
        else {
          $('#bulk_u_err').html( response.msg );
          $('#Modal_BulkuploadError').modal( 'show' );
        }
      } 
      catch (e) {
        console.log( result );
      }

      // $('#loader').removeClass('loading');
      $('.pre-loader').hide();
    }

  });
});
</script>
