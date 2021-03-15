<?php 
  // Setting user Role
  // superadmin, 1=Enterprize, 2=SubEnterprize, 3=Report Viewer
  $userRole = $this->session->userdata('loginData')['User_Role']; 
?>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-12">
            <div class="title">
              <h1><a href="javascript:void(0);" data-toggle="tooltip" title="Reports"><i class="fa fa-file text-blue"> 
              </i></a> Card-wise Completion Status Report</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Completion Status Report</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-12 pb-5">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <!-- <h5 class="text-blue">View participation and download</h5> -->
                </div>

                <form action="" method="post" class="" id="">
                  <!-- add filters accordingly, as per the roles if user is superadmin-->
                  <?php if ($userRole == 'superadmin') { ?>
                    <div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
                      <div class=" col-sm-12 col-md-3 col-lg-3">
                        <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="superadminUsers" name="filtertype" class="custom-control-input" checked="" value="superadminUsers" data-filtertype="superadmin">
                          <label class="custom-control-label" for="superadminUsers">My Users</label>
                        </div>
                      </div>

                      <div class=" col-sm-12 col-md-3 col-lg-3">
                        <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" data-filtertype="superadmin">
                          <label class="custom-control-label" for="enterpriseUsers">Enterprize Users</label>
                        </div>
                      </div>

                      <div class=" col-sm-12 col-md-3 col-lg-3 d-none">
                        <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="superadmin">
                          <label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Users</label>
                        </div>
                      </div>

                    </div>
                    <!-- end of radio, choose dropdown -->
                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
                      <label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">
                          <option value="">--Select Enterprize--</option>
                          <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                            <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <!-- for subenterprise selection -->
                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
                      <label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
                          <option value="">-Select SubEnterprize-</option>
                        </select>
                      </div>
                    </div>
                  <?php } ?>

                  <!-- if user is Enterprize -->
                  <?php if ($userRole == 1 || $userRole == 3) { ?>
                    <div class=" col-sm-12 col-md-12 col-lg-12 row form-group">
                      <div class=" col-sm-12 col-md-3 col-lg-3">
                        <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="enterpriseUsers" name="filtertype" class="custom-control-input" value="enterpriseUsers" checked="" data-filtertype="enterprise">
                          <label class="custom-control-label" for="enterpriseUsers">My Users</label>
                        </div>
                      </div>

                      <div class=" col-sm-12 col-md-3 col-lg-3 d-none">
                        <div class="custom-control custom-radio mb-5">
                          <input type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="enterprise">
                          <label class="custom-control-label" for="subEnterpriseUsers">SubEnterprize Users</label>
                        </div>
                      </div>

                    </div>

                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
                      <label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise" required="">
                          <option value="">--Select Enterprize--</option>
                          <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                            <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>" selected><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <!-- for subEnterprize selection -->
                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
                      <label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise">
                          <option value="">-Select SubEnterprize-</option>
                          <?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
                            <option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name; ?>"><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } ?>

                  <!-- if user is subEnterprise -->
                  <?php if ($userRole == 2) { ?>
                    <div class=" col-sm-12 col-md-12 col-lg-12 row form-group d-none">
                      <div class=" col-sm-12 col-md-3 col-lg-3">
                        <div class="custom-control custom-radio mb-5">
                          <input checked="" type="radio" id="subEnterpriseUsers" name="filtertype" class="custom-control-input" value="subEnterpriseUsers" data-filtertype="subEnterprise">
                          <label class="custom-control-label" for="subEnterpriseUsers">My Users</label>
                        </div>
                      </div>
                    </div>

                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="enterpriseDiv">
                      <label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise" required="">
                          <option value="">--Select Enterprize--</option>
                          <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                            <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>" selected><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>

                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group d-none" id="subEnterpriseDiv">
                      <label for="SubEnterprise" class="col-sm-12 col-md-3 col-form-label">Select SubEnterprize</label>
                      <div class="col-sm-12 col-md-9">
                        <select name="SubEnterprise" id="SubEnterprise" class="custom-select2 form-control subenterprise" required="">
                          <option value="">-Select SubEnterprize-</option>
                          <?php foreach ($SubEnterprise as $SubEnterpriseData) { ?>
                            <option value="<?php echo $SubEnterpriseData->SubEnterprise_ID; ?>" date-subEnterprisename="<?php echo $SubEnterpriseData->SubEnterprise_Name; ?>" selected><?php echo $SubEnterpriseData->SubEnterprise_Name; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  <?php } ?>

                  <!-- ========================================== -->
                  <!-- after all the above filter show users here -->
                  <div class="row col-12 row form-group" id="gameDiv">
                    <label for="selectGame" class="col-12 col-md-3 col-form-label">Select Card</label>
                    <div class="col-12 col-md-9">
                      <select name="selectGame" id="selectGame" class="custom-select2 form-control" required="">
                        <option value="">--Select Card--</option>
                      </select>
                    </div>
                  </div>

                  <div id="assignDate" class="row col-12 row form-group">
                    <label for="date" class="col-12 col-md-3 col-form-label">Select Date</label>
                    <div class="col-12 col-md-5">
                      <div class="input-group" name="gamedate" id="datepicker">
                        <input type="text" class="form-control datepicker-here" id="gamestartdate" name="gamestartdate" value="" data-value="<?php echo time(); ?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">

                        &nbsp;&nbsp; <span class="input-group-addon">To</span> &nbsp;&nbsp;

                        <input type="text" class="form-control datepicker-here" id="gameenddate" name="gameenddate" value="" data-value="<?php echo time(); ?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time(); ?>" data-language="en" data-date-format="dd-mm-yyyy">
                      </div>
                    </div>

                    <!-- Get Report Button -->
                    <div class="col-12 col-md-2">
                      <input id="getReport" value="Get Report" class="btn btn-primary getReport" readonly>
                    </div>
                  </div>

                  <div class="clearfix"></div>
                  <div class="col-12">
                    <div class="clearfix"></div>
                    <div class="col-md-8 pull-left">
                      <div id="containerCardColumnChart"></div>
                    </div>
                    <div class="col-md-4 pull-right">
                      <div id="containerCardPieChart"></div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>

                  <div class="table-responsive pt-5" id="returnTableHTML">
                    <!-- Adding datatable here -->
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

<script>
  $(document).ready(function(){
    // show all game by default and then show games as per the filter
    var allGameOption = "<option value=''>--Select Card--</option>";
    <?php foreach ($gameData as $games) { ?>
      allGameOption += "<option value=<?php echo $games->Game_ID; ?>><?php echo $games->Game_Name; ?></option>";
    <?php } ?>
      // console.log(allGameOption);
      $('#selectGame').html(allGameOption);

      $('input[name="filtertype"]').on('change',function(){
        var filterValue = $(this).val();
        var loggedInAs  = $(this).data('filtertype');
      // enterpriseDiv subEnterpriseDiv // superadminUsers enterpriseUsers subEnterpriseUsers
      // console.log(loggedInAs+' of type '+filterValue);

      // removing page Data when user switch filter type 
      $('#containerCardColumnChart, #containerCardPieChart, #returnTableHTML').html('');
      
      if (loggedInAs == 'superadmin') {
        if (filterValue == 'superadminUsers') {
          $('#Enterprise').attr('required',false);
          $('#SubEnterprise').attr('required',false);
          $('#enterpriseDiv').addClass('d-none');
          $('#subEnterpriseDiv').addClass('d-none');
          fetchAssignedGames('superadminUsers',null);
        }
        else if (filterValue == 'enterpriseUsers') {
          $('#Enterprise').attr('required',true);
          $('#SubEnterprise').attr('required',false);
          $('#enterpriseDiv').removeClass('d-none');
          $('#subEnterpriseDiv').addClass('d-none');
        }
        else if (filterValue == 'subEnterpriseUsers') {
          $('#Enterprise').attr('required',true);
          $('#SubEnterprise').attr('required',true);
          $('#enterpriseDiv').removeClass('d-none');
          $('#subEnterpriseDiv').removeClass('d-none');
        }
      }
      else if (loggedInAs == 'enterprise') {
        if (filterValue == 'enterpriseUsers') {
          $('#Enterprise').attr('required',false);
          $('#SubEnterprise').attr('required',false);
          $('#enterpriseDiv').addClass('d-none');
          $('#subEnterpriseDiv').addClass('d-none');
        }
        else if (filterValue == 'subEnterpriseUsers') {
          $('#Enterprise').attr('required',false);
          $('#SubEnterprise').attr('required',true);
          $('#enterpriseDiv').addClass('d-none');
          $('#subEnterpriseDiv').removeClass('d-none');
        }
      }
      else {
        // if user is of type subenterprise
        $('#Enterprise').attr('required',false);
        $('#SubEnterprise').attr('required',true);
        $('#enterpriseDiv').addClass('d-none');
        $('#subEnterpriseDiv').addClass('d-none');
      }
    });

    $('#Enterprise').on('change',function(){
      $this             = $(this);
      var option        = '<option value="">--Select SubEnterprize--</option>';
      var Enterprise_ID = $(this).val();

      if ($(this).val()) { 
        // triggering ajax to show the subenterprise linked with this enterprise
        $.ajax({
          url :"<?php echo base_url();?>Ajax/get_subenterprise/"+Enterprise_ID,
          type: "POST",
          success: function(result){
            result = JSON.parse(result);
            if (result.length > 0) {
              $(result).each(function(i, e){
                option += ("<option value='"+result[i].SubEnterprise_ID+"'>"+result[i].SubEnterprise_Name+"</option>");
              });
              $this.parents('form').find('select.subenterprise').html(option);
              option = '<option value="">--Select Subenterprise--</option>';
              // $('.SubEnterprise').html(option);
            }
            else {
              $this.parents('form').find('select.subenterprise').html(option);
              // alert('No SubEnterprise Associated With The Selected Enterprise');
            }
          },
        });
        fetchAssignedGames('enterpriseUsers', Enterprise_ID);
      }
      else {
        $this.parents('form').find('select.subenterprise').html(option);
        // alert('Please Select Enterprise...');
        return false;
      }
    });

    $('#SubEnterprise').on('change', function() {
      if ($(this).val()) {
        fetchAssignedGames('subEnterpriseUsers', $(this).val());
      }
      else {
        Swal.fire('Please select Subenterprise');
      }
    });
  });

  // writing functions below
  function fetchAssignedGames(ent_SubEnt, id) {
    // show assigned games only
    if (ent_SubEnt=='superadminUsers') {
      $('#selectGame').html(allGameOption);
    }
    else {
      $.ajax({
        url :"<?php echo base_url();?>Ajax/fetchAssignedGames/"+ent_SubEnt+"/"+id,
        type: "POST",
        success: function(result){
          if(result == 'No Card found') {
            Swal.fire('No Card allocated to selected '+ent_SubEnt);
            $('#selectGame').html('<option value="">--Select Card--</option>');
          }
          else {
            result = JSON.parse(result);
            var entGameOption = '<option value="">--Select Card--</option>';
            $(result).each(function(i, e){
              entGameOption += ("<option value='"+result[i].Game_ID+"'>"+result[i].Game_Name+"</option>");
            });
            $('#selectGame').html(entGameOption);
          }
        },
      });
    }
  }

  $('.getReport').on('click', function() {
    // Removing previous Report Table and Graph
    $('#returnTableHTML, #containerCardColumnChart, #containerCardPieChart').html('');
    
    var gameId          = $('#selectGame').val();
    var filterValue     = $('input[name="filtertype"]:checked').val();
    var loggedInAs      = $('input[name="filtertype"]:checked').data('filtertype');
    var enterpriseId    = $('#Enterprise').val();
    var subEnterpriseId = $('#SubEnterprise').val();
    var siteUsers       = '';

    var gamestartdate   = $("#gamestartdate").val();
    var gameenddate     = $("#gameenddate").val();

    // console.log(`
    //   Start Date - ${gamestartdate}
    //   end Date   - ${gameenddate}
    // `);

    if (gamestartdate == "" && gameenddate == "") {
      Swal.fire('Please select start and end date');
    } 
    else if (gamestartdate == "") {
      Swal.fire('Please Select Start Date');
    } 
    else if (gameenddate == "") {
      Swal.fire('Please Select End Date');
    }
    // else if (gamestartdate <= gameenddate) {
    //  Swal.fire('Please make sure End Date is greater then Start Date');
    // } 
    else if (gamestartdate && gameenddate) {

      if (gameId < 1 || gameId == '--Select Card--') {
        // Card not Selected
        // removing table if user not Selected Card
        $('#returnTableHTML').html('<span class="text-danger text-center">Please Select Card To View Report</span>');
      }
      else {
        // show wait text to users
        $('#returnTableHTML').html('<span class="text-success text-center">Please Wait While Loading Report</span>');

        $.ajax({
          url      : "<?php echo base_url('AjaxNew/getReportOneTableData'); ?>",
          type     : "POST",
          dataType : 'html',
          data     : "gameId="+gameId+"&filterValue="+filterValue+"&loggedInAs="+loggedInAs+"&enterpriseId="+enterpriseId+"&subEnterpriseId="+subEnterpriseId+"&gamestartdate="+gamestartdate+"&gameenddate="+gameenddate,

          success: function(result) {
            result = JSON.parse(result);
            // console.log(result.status);

            switch (result.status) {
              case '200':
                // putting whole regenerated table
                $('#returnTableHTML').empty();
                $('#returnTableHTML').html(result.data);
                makeTableDataTable();

                // making Column and Pie Chart
                let countTotalUsers  = result.countTotalUsers;
                let countYetToStart = result.countYetToStart;
                let countPlaying    = result.countPlaying;
                let countCompleted  = result.countCompleted;

                Highcharts.chart('containerCardColumnChart', {
                  chart: {
                    type: 'column',
                    options3d: {
                      enabled: true,
                      alpha: 10,
                      beta: 0,
                      depth: 0
                    }
                  },

                  title: {text: null},
                  subtitle: {text: null},
                  credits: {enabled: false},

                  plotOptions: {
                    column: {depth: 25},
                    series: {colorByPoint: true}
                  },

                  colors: ['#000a12', '#dc3545', '#fec400', '#28a745'],

                  xAxis: {
                    categories: ['Total User', 'Yet To Start', 'Continuing', 'Completed'],
                    labels: {
                      skew3d: true,
                      style: {fontSize: '16px'}
                    }
                  },

                  yAxis: {
                    title: {text: null}
                  },

                  series: [{
                    name: 'Users',
                    showInLegend: false,
                    data: [countTotalUsers, countYetToStart, countPlaying, countCompleted]
                  }]
                }); // end of containerCardColumnChart Highcharts

                Highcharts.chart('containerCardPieChart', {
                  chart: {
                    type: 'pie',
                    options3d: {
                      enabled: true,
                      alpha: 0
                    }
                  },

                  title: {text: null},
                  subtitle: {text: null},
                  credits: {enabled: false},

                  // colors: ['#000a12', '#dc3545', '#fec400', '#28a745'],
                  colors: ['#dc3545', '#fec400', '#28a745'],

                  plotOptions: {
                    pie: {
                      innerSize: 100,
                      depth: 45,
                      allowPointSelect: true,
                      cursor: 'pointer',
                      dataLabels: {enabled: false},
                      showInLegend: true
                    },
                    series: {colorByPoint: true}
                  },

                  series: [{
                    name: 'Users',
                    data: [
                      // ['Total User', countTotalUsers],
                      ['Yet To Start', countYetToStart],
                      ['Continuing', countPlaying],
                      ['Completed', countCompleted]
                    ]
                  }]
                }); // end of containerCardPieChart Highcharts
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
    }
  });
</script>
