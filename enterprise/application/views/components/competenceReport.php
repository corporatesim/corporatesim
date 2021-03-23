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
              <h1><i class="fa fa-superpowers text-blue"></i> Multi-Card Reports</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Multi-Card Reports</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue">Choose Filter</h5>
                </div>

                <!-- <form action="" method="post" class="" id="fetchItemsReportData"> -->
                <?php echo form_open('', 'id="fetchItemsReportData"', ''); ?>

                  <div class=" col-sm-12 col-md-12 col-lg-12 row form-group">

                    <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?> 
                    <div class=" col-sm-12 col-md-3 col-lg-3">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="allItemUsers" name="filtertype" class="custom-control-input" value="allItemUsers" data-filtertype="allItemUsers">
                        <label class="custom-control-label" for="allItemUsers">All Users</label>
                      </div>
                    </div>
                    <?php } ?>

                    <div class=" col-sm-12 col-md-3 col-lg-3">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="myItemUsers" name="filtertype" class="custom-control-input" checked="" value="myItemUsers" data-filtertype="myItemUsers">
                        <label class="custom-control-label" for="myItemUsers">My Users</label>
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-3 col-lg-3 d-none">
                      <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="oneByOneItemUsers" name="filtertype" class="custom-control-input" value="oneByOneItemUsers" data-filtertype="oneByOneItemUsers">
                        <label class="custom-control-label" for="oneByOneItemUsers">One by One Users</label>
                      </div>
                    </div>

                  </div>
                  <!-- end of radio, choose dropdown -->
                  <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                    <div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="enterpriseShowHide">
                      <label for="Cmap_Enterprise_ID" class="col-sm-12 col-md-3 col-form-label">Select Enterprize </label>
                      <div class="col-sm-12 col-md-9">
                        <select name="Cmap_Enterprise_ID" id="Cmap_Enterprise_ID" class="custom-select2 form-control" required="">
                          <option value="">--Select Enterprize--</option>
                          <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
                            <option value="<?php echo $enterpriseRow->Enterprise_ID; ?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>
                          <?php } ?>
                        </select> <span class="text-danger">*</span>
                      </div>
                    </div>
                  <?php } else{ ?>
                    <input type="hidden" id="Cmap_Enterprise_ID" name="Cmap_Enterprise_ID" value="<?php echo $this->session->userdata('loginData')['User_Id']; ?>">
                  <?php } ?>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="Cmap_Formula_ID" class="col-sm-12 col-md-3 col-form-label">Score Selector<br />(Using Formula Value) </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_Formula_ID" id="Cmap_Formula_ID" class="custom-select2 form-control" required="">
                      <option value="">--Score Selector--</option>
                      <?php foreach ($formulaDetails as $formulaRow) { ?>
                        <option value="<?php echo $formulaRow->Items_Formula_Id; ?>"><?php echo $formulaRow->Items_Formula_Title; ?></option>
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
                      <option value="<?php echo $usersRow->User_id; ?>" title="<?php echo $usersRow->User_username; ?>"><?php echo $usersRow->User_fullName; ?></option>
                    <?php } } ?>
                    </select> <span class="text-danger">* (Click on box for dropdown)</span>
                  </div>
                </div>
                <!-- end of dropdown -->

                <div class="row col-12 form-group">
                  <label for="date" class="col-12 col-md-3 col-form-label">Select Date</label>
                  <div class="col-12 col-md-5">
                    <div class="input-group" name="gamedate" id="datepicker">
                      <input type="text" class="form-control datepicker-here" id="report_startDate" name="report_startDate" value="" data-value="<?php echo time(); ?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time(); ?>" data-language="en" data-date-format="dd-mm-yyyy">

                      &nbsp; <span class="input-group-addon">To</span> &nbsp;

                      <input type="text" class="form-control datepicker-here" id="report_endDate" name="report_endDate" value="" data-value="<?php echo time(); ?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time(); ?>" data-language="en" data-date-format="dd-mm-yyyy">
                    </div>
                  </div>

                  <!-- Generate Report Button -->
                  <div class="col-12 col-md-2">
                    <input name="generate_Report_Operation" id="" value="Generate Table" data-report="generaTetable" class="btn btn-primary generate_Report_Operation" readonly>

                    <input name="generate_Report_Operation" id="" value="Generate Chart" data-report="generateChart" class="btn btn-primary generate_Report_Operation mt-2" readonly>
                  </div>
                </div>

                <!-- </form> -->
                <?php echo form_close(); ?>
              </div>
              <!-- end of adding users -->

              <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="title">
                  <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    <h3 id="tableContentText" class="text-primary mb-3"></h3>
                    <!-- <div id="overallScatterChart"> -->
                      <!-- report Scatter Chart shows here -->
                    <!-- </div> -->
                    <div class="row" id="addTable">
                      <!-- report data shows here -->
                    </div>
                  </div>
                </div>
              </div>
              </div>
 
            </div>
          </div>
        </div>

<script>
  $(document).ready(function(){
    appendCompetenceUserReports();    

    $('input[name="filtertype"]').on('change', function(){
      // var filterValue     = $(this).val();
      var itemUsersFilter = $(this).data('filtertype');
      //console.log(itemUsersFilter);

      // removing Title, chart and table view on Filter type change
      $('#addTable, #overallScatterChart, #tableContentText').html('');

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

        <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
          var enterpriseListOnRadioChange = '<option value="">--Select Enterprize--</option>';
          <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
            enterpriseListOnRadioChange += '<option value="<?php echo $enterpriseRow->Enterprise_ID; ?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>';
          <?php } ?>
          $('#Cmap_Enterprise_ID').html(enterpriseListOnRadioChange);
        <?php } ?>

        //appending formula details on dropdown box
        var formulaOptionsOnRadioChange = '<option>--Score Selector--</option>';
        <?php foreach ($formulaDetails as $formulaRow) { ?>
          formulaOptionsOnRadioChange += '<option value="<?php echo $formulaRow->Items_Formula_Id; ?>"><?php echo $formulaRow->Items_Formula_Title; ?></option>';
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

  });
  
  //====================================

  function appendCompetenceUserReports() {
    $('.generate_Report_Operation').on('click', function() {

      var generate_Report_Type = $(this).data('report');
      //console.log(generate_Report_Type);

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

        if (formula_selected < 1 || formula_selected == '--Score Selector--') {
          // Formula not Selected
          //removing the table and chart report if user not Selected Formula
          $('#addTable, #overallScatterChart, #tableContentText').html('');

          $('#addTable').html('<span class="text-danger text-center">Please Select Score Selector To View Report</span>');
        } else {
          // show some wait text to users
          $('#addTable').html('<span class="text-success text-center">' + waitStringText + '</span>');
          // tirgger ajax and get the user report which are visible
          var formData = $('#fetchItemsReportData').serialize();

          //var compUserReportData = triggerAjax("<?php //echo base_url('Ajax/compUserReportData/'); ?>", formData);
          $.ajax({
            url: "<?php echo base_url('Ajax/compUserReportData/'); ?>",
            type: 'POST',
            data: formData,

            success: function(result) {
              compUserReportData = JSON.parse(result);
              //console.log(compUserReportData);

              if (compUserReportData.status == 201) {
                Swal.fire({
                  position: compUserReportData.position,
                  icon: compUserReportData.icon,
                  title: compUserReportData.title,
                  html: compUserReportData.message,
                  showConfirmButton: compUserReportData.showConfirmButton,
                  timer: compUserReportData.timer,
                });
              } 
              else {

                if(generate_Report_Type == 'generateChart'){
                  //if user choose for chart only 

                  //removing the table report if user viewed earlier
                  $('#addTable, #tableContentText').html('');

                  //setting overall_Scatter_Chart so that access it and use it on high chart
                  overall_Scatter_Chart = compUserReportData.overallScatterChart;
                  console.log(overall_Scatter_Chart);

                  var myScatter_Chart_Array = [];
                  for (var i = 0; i < overall_Scatter_Chart.length; i++) {
                    //console.log(overall_Scatter_Chart[i][0]);
                    //if (overall_Scatter_Chart[i][0] != 0 && overall_Scatter_Chart[i][1] != 0) {
                      //if value is not zero then user played game

                      // var dateNumber = overall_Scatter_Chart[i][0][0];
                      // var date = new Date(dateNumber *1000).getDate()+'_'+new Date(dateNumber *1000).getMonth();
                      // my_Single_Scatter_Chart_Array = [date, overall_Scatter_Chart[i][1][0]];

                      //according to table id
                      my_Single_Scatter_Chart_Array = [i+1, overall_Scatter_Chart[i][1][0]];

                      //according to date
                      // my_Single_Scatter_Chart_Array = [overall_Scatter_Chart[i][0][0], overall_Scatter_Chart[i][1][0]];
                      
                      myScatter_Chart_Array.push(my_Single_Scatter_Chart_Array);
                    //}
                  }
                  console.log(myScatter_Chart_Array);

                  Swal.fire({
                    // icon : result.icon,
                    // title: result.title,

                    confirmButtonColor: '#1976d2',
                    showConfirmButton: false,
                    confirmButtonText: "OK",

                    cancelButtonColor: '#d32f2f',
                    showCancelButton: true,
                    cancelButtonText: "Close",

                    width: '1400px',
                    html : 'showing chart for now',
                    showClass: {
                      popup: 'animated zoomInUp faster'
                    },
                    hideClass: {
                      popup: 'animated zoomOutUp faster'
                    }
                  });
                  $('#swal2-content').html('<div id="overallScatterChart"> </div>');
                  //High Chart for Overall Value
                  Highcharts.chart('overallScatterChart', {
                    chart: {
                      type: 'scatter',
                      zoomType: 'xy'
                    },
                    title: {
                      text: 'Formula Value - All Users'
                    },
                    subtitle: {
                      text: 'Click and select area to zoom in. Use Reset to zoom out.'
                    },
                    credits: {
                      enabled: false
                    },
                    xAxis: {
                      //type: 'datetime',
                      title: {
                        enabled: true,
                        text: 'User'
                      },
                      startOnTick: true,
                      endOnTick: true,
                      showLastLabel: true,
                      min: 1,
                      allowDecimals: false,
                    },
                    yAxis: {
                      title: {
                        enabled: true,
                        text: 'Formula Value'
                      },
                    },
                    legend: {
                      layout: 'vertical',
                      align: 'left',
                      verticalAlign: 'top',
                      x: 100,
                      y: 70,
                      floating: true,
                      backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
                      borderWidth: 1
                    },
                    plotOptions: {
                      scatter: {
                        marker: {
                          radius: 5,
                          states: {
                            hover: {
                              enabled: true,
                              lineColor: 'rgb(100,100,100)'
                            }
                          }
                        },
                        states: {
                          hover: {
                            marker: {
                              enabled: false
                            }
                          }
                        },
                        tooltip: {
                          headerFormat: '<b>{series.name}</b><br>',
                          pointFormat: 'User: {point.x}<br/>Overall Score: {point.y}'

                          // pointFormat: '{point.x} Date,<br/>{point.y} Score'
                          //pointFormat: '{new Date(point.x *1000).getDate()+"-"+new Date(point.x *1000).getMonth()} Date,<br/>{point.y} Score'
                        }
                      }
                    },
                    series: [{
                      showInLegend: false,
                      name: 'User Score',
                      //color: 'rgba(54, 162, 235, 15)',
                      //fillColor:'#FF0000',

                      //[date,value]
                      // data: [[174, 65],[175, 71],[193, 80],[186, 72],[172, 72],[185, 76],[178, 69],[167, 84],[175, 64],[180, 69]]
                      data: myScatter_Chart_Array,
                      zones: [{
                            value: 1,
                            color: '#1c313a' //Black
                        }, {
                            value: 40,
                            color: '#b71c1c' //Red
                        }, {
                            value: 80,
                            color: '#fb8c00' //Orange
                        }, {
                            value: 120,
                            color: '#ffeb3b' //Yellow
                        }, {
                            value: 160,
                            color: '#1976d2' //Blue
                        }, {
                            color: '#43a047' //Green
                        }]
                    }]
                  });
                  //end of High Chart
                }
                else if(generate_Report_Type == 'generaTetable'){
                  //else if user choose for table only

                  //removing the chart report if user viewed earlier
                  $('#overallScatterChart').html('');
                  $('#tableContentText').html('Please Click on Name (email) to view Sub-factor Charts');

                  $('#addTable').html(compUserReportData.data);
                  makeTableDataTable();
                }

                $('[data-toggle="tooltip"]').tooltip();
              }
            }
          });
        }
      }
    });
  }

  function showReportChart(element) {
    var user_id          = $(element).data('user_id');
    let enterprise_ID    = $(element).data('enterprise_id');
    // var formula_expression = $(element).data('formula_expression');
    // var formula_Json       = $(element).data('formula_Json');
    // console.log(formula_expression);
    // console.log(formula_Json);
    let formula_selected = $('#Cmap_Formula_ID').val();
    // let enterprise_ID    = $("#Cmap_Enterprise_ID").val();

    //console.log(user_id);
    // trigger ajax to get the data accordingly
    $.ajax({
      url : "<?php echo base_url('Ajax/showReportChart/');?>"+user_id+'/'+formula_selected+'/'+enterprise_ID,
      type: "POST",
      data: '',
      beforeSend: function(){  },
      success:function(result) {
        var result = JSON.parse(result);
        if (result.status == 200) {
          Swal.fire({
            // icon : result.icon,
            // title: result.title,

            confirmButtonColor: '#1976d2',
            showConfirmButton: false,
            confirmButtonText: "OK",

            cancelButtonColor: '#d32f2f',
            showCancelButton: true,
            cancelButtonText: "Close",

            width: '1000px',
            html : 'showing chart for now',
            showClass: {
              popup: 'animated zoomInUp faster'
            },
            hideClass: {
              popup: 'animated zoomOutUp faster'
            }
          });

          // create element and show this on alert
          //with download option
          //$('#swal2-content').html('<div> <h5 id="chart_Download_Text" class="col-10 float-left"><span style="color:rgba(25, 118, 210);">Simulated Performance,</span> <span style="color:rgba(69, 90, 100);">Competence Application,</span> <span style="color:rgba(245, 124, 0);">Competence Readiness,</span> <span style="color:rgba(56, 142, 60);">Overall Value</span> </h5> <a id="download" download="Item-Report-<?Php echo date("d-m-y"); ?>.jpg" href="javascript:void(0)" class="btn btn-primary float-right" title="Download Report"><i class="fa fa-download" onclick="Export()"></i></a> <br /> <canvas id="barChart"></canvas> </div>');

          //without download option
          $('#swal2-content').html('<div> <h5 id="chart_Download_Text" class="col-10 float-left"><span style="color:rgba(25, 118, 210);">Simulated Performance,</span> <span style="color:rgba(69, 90, 100);">Competence Application,</span> <span style="color:rgba(245, 124, 0);">Competence Readiness,</span> <span style="color:rgba(56, 142, 60);">Formula Value</span> </h5> <canvas id="barChart"></canvas> </div>');
          //Chart JS for Items and Overall Value
          var ctx     = $('#barChart');
          var myChart = new Chart(ctx, {
            type: 'bar',
            exportEnabled: true,
            data: {
              labels: result.chartLabels,
              datasets: [{
                label: 'Score',
                data: result.chartData,
                backgroundColor: result.chartBackgroundColor,
                borderColor: result.chartBorderColor,
                borderWidth: 2,
                // fill: false,
              }],
            },
            options: {
              scales: {

                yAxes: [{
                  ticks: {
                    beginAtZero: true,
                  }
                }],

                xAxes: [{
                  ticks: {
                    autoSkip: false,
                    // minRotation: 60,
                  }
                }]

              },

              title: {
                display: false,
                text: ''
              },

              legend: {
                display: false
              },

              tooltips: {
                callbacks: {
                  label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                  }
                }
              }
            }
          });
          //end of Chart JS
        }
        else {
          Swal.fire({
            icon : result.icon,
            title: result.title,
            html : result.message,
            showClass: {
              popup: 'animated fadeInDown faster'
            },
            hideClass: {
              popup: 'animated fadeOutUp faster'
            }
          });
        }
      }
    });
  }

  function Export() {
    // generating report chart image for downloading
    // document.getElementById("download").addEventListener('click', function(){
    $('#download').on('click', function(){
      //console.log('here in download');

      // Get image of canvas element
      // chart_Download_Text
      var url_base64jp = document.getElementById("barChart").toDataURL("image/jpg");
      // get download button (tag: <a></a>) 
      var a =  document.getElementById("download");
      // insert chart image url to download button (tag: <a></a>)
      a.href = url_base64jp;
    });
  }

  function downloadReport(element) {
    var user_id          = $(element).data('user_id');
    let enterprise_ID    = $(element).data('enterprise_id');
    let formula_selected = $('#Cmap_Formula_ID').val();

    // console.log(user_id);
    // trigger ajax to get the data accordingly
    $.ajax({
      url : "<?php echo base_url('Ajax/downloadReport/');?>"+user_id+'/'+formula_selected+'/'+enterprise_ID,
      type: "POST",
      data: '',
      beforeSend: function(){  },
      success:function(result) {
        var result = JSON.parse(result);
        // console.log(result);
        
        if (result.status == 200) {
          var reportValue               = result.reportValue;
          var reportFactorType          = result.reportFactorType;
          var reportSubFactorName       = result.reportSubFactorName;
          var itemConditionsText        = result.itemConditionsText;
          var itemConditionsScoreStatus = result.itemConditionsScoreStatus
          var userDetails               = result.userDetails;
          var headerDetails             = result.headerDetails;
          var disclaimerDetails         = result.disclaimerDetails;
          var report_Title_Definition   = result.report_Title_Definition;
          var report_Detailed           = result.report_Detailed;
          var executiveConclusionData   = result.executiveConclusionData;
          var individualReport          = result.individualReport;
          // when competence type set to 0 this means this card not used in formula
          // var countCompetenceReadiness   = 0;
          // var countCompetenceApplication = 0;
          // var countSimulatedPerformance  = 0;

          // creating user Details in Table form
          var userDetailsTable = '<table style="width:100%"> <tr><th colspan="5" style="text-align: center; height: 70px; background-color: #eeeeee;"><h2><strong><font face="Arial">Registration Details</font></strong></h2></th></tr> <tr><td colspan="5" style="height: 20px;"></td></tr>  <tr> <td><strong><font face="Arial">First Name:</font></strong></td> <td><font face="Arial">'+userDetails[0].User_fname+'</font></td> <td style="width: 100px;"></td> <td><strong><font face="Arial">Organization:</font></strong></td> <td><font face="Arial">'+userDetails[0].Enterprise_Name+'</font></td></tr>  <tr><td><strong><font face="Arial">Last Name:</font></strong></td> <td><font face="Arial">'+userDetails[0].User_lname+'</font></td> <td style="width: 100px;"></td> <td><strong><font face="Arial">Email Address:</font></strong></td> <td><font face="Arial">'+userDetails[0].User_email+'</font></td></tr>  <tr><td><strong><font face="Arial">Country:</font></strong></td> <td><font face="Arial">'+userDetails[0].Country_Name+'</font></td> <td style="width: 100px;"></td> <td><strong><font face="Arial">Date of Report:</font></strong></td> <td><font face="Arial"><?Php echo date('d-m-Y'); ?></font></td></tr> </table>';

          var printWindow = window.open('', '', 'height=400,width=800');
          printWindow.document.write('<html><head><title>Report '+userDetails[0].User_fname+' '+userDetails[0].User_lname+' <?Php echo date('d-m-Y'); ?></title>');
          printWindow.document.write('</head><body style="margin: 0px 50px 50px 50px;"><div>');

          // user Details
          printWindow.document.write('<br />'+userDetailsTable+'<br />');

          // header section of report common for all report
          printWindow.document.write('</div><div>');
          printWindow.document.write(headerDetails[0].IR_Text);
          printWindow.document.write('</div><div>');

          // Report Title and Definition section of report
          printWindow.document.write('</div><div>');
          printWindow.document.write(report_Title_Definition);

          // EXECUTIVE SUMMARY 1 (Average)
          // IR_Type_Choice 1->EXECUTIVE SUMMARY, 2->CONCLUSION SECTION
          // console.log(executiveConclusionData);
          if (executiveConclusionData[0]) {
          printWindow.document.write('</div><div>');
            for (var j=0; j<executiveConclusionData.length; j++) { 
              if (executiveConclusionData[j].IR_Type_Choice == 1) {
                var executiveSummary1 = executiveConclusionData[j].IR_Text ? executiveConclusionData[j].IR_Text : '';
                printWindow.document.write(executiveSummary1);
                 //console.log(executiveSummary1);
              }
            }
          }

          // EXECUTIVE SUMMARY 2 (Individual)
          // IRI_Type_Choice => 1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION
          // IRI_Score_Status => 0=Hide, 1=Show Both, 2=Show x-axis(Readiness), 3=Show y-axis(Application)
          if (individualReport[0]) {
          printWindow.document.write('</div><div>');
            for (var ir=0; ir<individualReport.length; ir++) {
              
              if (individualReport[ir].IRI_Type_Choice == 1) {
                var executiveSummary2 = individualReport[ir].IRI_Text ? individualReport[ir].IRI_Text : '';
                printWindow.document.write(executiveSummary2);
                // console.log(executiveSummary2);
                
                if (individualReport[ir].IRI_Score_Status == 3) {
                  printWindow.document.write('<p style="text-align:right"><button type="button">Score: '+individualReport[ir].yAxisValue+'</button></p><br />');
                }
              }
            }
          }

          // Detailed Report section of report
          printWindow.document.write('</div><div>');
          printWindow.document.write(report_Detailed);
          printWindow.document.write('</div><div>');

          // printWindow.document.write('<h1><strong>Detailed Analysis</strong></h1>');
          // 4 = Competence Readiness
          // printWindow.document.write('<h2><strong>SECTION- I: Competence Readiness</strong></h2>');
          for (var i=0; i<reportFactorType.length; i++) {
            if (reportFactorType[i] == 4) {
              // countCompetenceReadiness++;
              // printWindow.document.write('<h3>'+reportSubFactorName[i]+'</h3>');
              printWindow.document.write(itemConditionsText[i]);
              
              // IC_Score_Status -> 0=Show, 1=Hide
              if (itemConditionsScoreStatus[i] == 0) {
                printWindow.document.write('<p style="text-align:right"><button type="button">Score: '+reportValue[i]+'</button></p><br />');
              }
            }
          }
          // if (countCompetenceReadiness==0) {
          //   printWindow.document.write('<p>Not Used</p>');
          // }
          printWindow.document.write('</div><div>');

          // 5 = Competence Application
          // printWindow.document.write('<h2><strong>SECTION- II:  Competence Application</strong></h2>');
          for (var i=0; i<reportFactorType.length; i++) {
            if (reportFactorType[i] == 5) {
              // countCompetenceApplication++;
              // printWindow.document.write('<h3>'+reportSubFactorName[i]+'</h3>');
              printWindow.document.write(itemConditionsText[i]);

              // IC_Score_Status -> 0=Show, 1=Hide
              if (itemConditionsScoreStatus[i] == 0) {
                printWindow.document.write('<p style="text-align:right"><button type="button">Score: '+reportValue[i]+'</button></p><br />');
              }
            }
          }
          // if (countCompetenceApplication==0) {
          //   printWindow.document.write('<p>Not Used</p>');
          // }
          printWindow.document.write('</div><div>');

          // 3 = Simulated Performance
          // printWindow.document.write('<h2><strong>SECTION- III: Simulated Performance</strong></h2>');
          for (var i=0; i<reportFactorType.length; i++) {
            if (reportFactorType[i] == 3) {
              // countSimulatedPerformance++;
              // printWindow.document.write('<h3>'+reportSubFactorName[i]+'</h3>');
              printWindow.document.write(itemConditionsText[i]);

              // IC_Score_Status -> 0=Show, 1=Hide
              if (itemConditionsScoreStatus[i] == 0) {
                printWindow.document.write('<p style="text-align:right"><button type="button">Score: '+reportValue[i]+'</button></p><br />');
              }
            }
          }
          // if (countSimulatedPerformance==0) {
          //   printWindow.document.write('<p>Not Used</p>');
          // }
          printWindow.document.write('</div><div>');

          // Formula
          // printWindow.document.write('<h2 style="text-align:center">Formula Value</h2>');
          // for (var i=0; i<reportFactorType.length; i++) {
          //   if (reportFactorType[i] == 'Formula') {
          //     printWindow.document.write('<p style="text-align:center"><button type="button">Score: '+reportValue[i]+'</button></p><br />');
          //   }
          // }

          // conclusion section 1 (Individual)
          // IRI_Text IRI_Type_Choice
          // IRI_Type_Choice => 1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION
          if (individualReport[0]) {
          printWindow.document.write('</div><div>');
            for (var ir=0; ir<individualReport.length; ir++) {
              if (individualReport[ir].IRI_Type_Choice == 2) {
                var conclusionSection1 = individualReport[ir].IRI_Text ? individualReport[ir].IRI_Text : '';
                printWindow.document.write(conclusionSection1);
              }
            }
          }

          // conclusion section 2 (Average)
          // IR_Type_Choice 1->EXECUTIVE SUMMARY, 2->CONCLUSION SECTION
          // console.log(executiveConclusionData);
          if (executiveConclusionData[0]) {
          printWindow.document.write('</div><div>');
            for (var j=0; j<executiveConclusionData.length; j++) { 
              if (executiveConclusionData[j].IR_Type_Choice == 2) {
                var conclusionSection2 = executiveConclusionData[j].IR_Text ? executiveConclusionData[j].IR_Text : '';
                printWindow.document.write(conclusionSection2);
              }
            }
          }
          printWindow.document.write('</div><div>');

          // Disclaimer section of report common for all report
          // printWindow.document.write('<h3><strong>Disclaimer</strong></h3>'+disclaimerDetails[0].IR_Text);
          printWindow.document.write(disclaimerDetails[0].IR_Text);
          
          printWindow.document.write('</div></body></html>');
          printWindow.document.close();
          printWindow.print();
        }
        else {
          Swal.fire({
            icon : result.icon,
            title: result.title,
            html : result.message,
            showClass: {
              popup: 'animated fadeInDown faster'
            },
            hideClass: {
              popup: 'animated fadeOutUp faster'
            }
          });
        } // end of else
      }
    });
  }

</script>
