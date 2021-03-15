<?php 
  // Setting Login user Role
  // superadmin, 1 = Enterprize, 2 = SubEnterprize, 3 = Report Viewer
  $userRole = $this->session->userdata('loginData')['User_Role'];
?>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title mb-2">
              <h1>Dashboard</h1>
            </div>
          </div>
        </div>

        <!--========================-->
        <!-- Start card details Modal -->
        <div class="modal fade bs-example-modal-lg" id="Modal_cardDetails" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title text-success" id="myLargeModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <p id="cardDetails_msg"></p>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal" aria-hidden="true">Close</button>
              </div>

            </div>
          </div>
        </div>
        <!--========================-->

        <div class="row">
          <div class="col-12">
          <div class="title">
          <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix"></div>

            <div class="col-12">
              <div class="clearfix"></div>
              <div class="col-md-6 pull-left">
                <div id="containerCard"></div>
              </div>
              <div class="col-md-6 pull-right d-none">
                <div id="containerCampus"></div>
              </div>
              <div class="col-md-8 pull-left">
                <div id="containerCardStartedCompleted"></div>
              </div>
              <div class="col-md-4 pull-right">
                <div id="containerCardTotalPie"></div>
              </div>
              <div class="clearfix"></div>
            </div>

            <div class="clearfix"></div>
            <div class="col-12" id="containerCardStartedCompletedPie">
              <!-- all pie chart will come here -->
            </div>
            <div class="clearfix"></div>

            <?php if ($userRole == 1) { ?>
            <div class="col-12 my-3">
              <div class="clearfix"></div>
              <hr />
              <form method="POST" action="" id="generateChart">

                <div class="row col-12 row form-group">
                  <label for="Cmap_Formula_ID" class="col-12 col-md-3 col-form-label">Score Selector <span class="text-danger">*</span></label>
                  <div class="col-12 col-md-9">
                    <select name="Cmap_Formula_ID" id="Cmap_Formula_ID" class="form-control custom-select2" required="">
                      <option value="">--Score Selector--</option>
                      <?php foreach ($formulaDetails as $formulaRow) { ?>
                        <option value="<?php echo $formulaRow->Items_Formula_Id;?>"><?php echo $formulaRow->Items_Formula_Title; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="row col-12 form-group">
                  <label for="date" class="col-12 col-md-3 col-form-label">Select Date</label>
                  <div class="col-12 col-md-5">
                    <div class="input-group" name="gamedate" id="datepicker">
                      <input type="text" class="form-control datepicker-here" id="report_startDate" name="report_startDate" value="" data-value="<?php echo time();?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">

                      &nbsp; <span class="input-group-addon">To</span> &nbsp;

                      <input type="text" class="form-control datepicker-here" id="report_endDate" name="report_endDate" value="" data-value="<?php echo time();?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">
                    </div>
                  </div>

                  <!-- Generate Chart Button -->
                  <div class="col-12 col-md-2">
                    <input name="generate_Report" id="" value="Chart" class="btn btn-primary generate_Report" readonly>
                    <!-- <button name="generate_Report" id="" class="btn btn-primary generate_Report px-5">Chart</button> -->
                  </div>
                </div>

              </form>
              <div class="clearfix"></div>

              <!-- Chart Message -->
              <div class="col-12">
                <h4 id="chartMessage" style="text-align: center;"></h4>
              </div>
              <!-- === -->
              <div class="col-12">
                <div id="lastTwentyFiveChart"></div>
              </div>
              <!-- === -->
              <div class="col-12 col-md-6 pull-left">
                <div id="averageValueChart"></div>
              </div>

              <div class="col-12 col-md-6 pull-right">
                <div id="highestValueChart"></div>
              </div>
              <!-- === -->
              <!-- Hidden -->
              <div class="col-12 col-md-6 pull-left">
                <div id="containerCRvsSP"></div>
              </div>
              
              <div class="col-12">
                <div id="singlePersonChart"></div>
              </div>
              
              <div class="col-12">
                <div id="singlePersonChart2"></div>
              </div>
              <!-- Hidden -->
              <!-- === -->

              <div class="clearfix"></div>
                <div class="row col-12 pt-5 row form-group">
                  <label for="Cmap_Chart_Type" class="col-12 col-md-3 col-form-label">Chart Type</label>
                  <div class="col-12 col-md-5">
                    <select name="Cmap_Chart_Type" id="Cmap_Chart_Type" class="form-control custom-select2" required>
                      <option value="" Selected>--Select--</option>
                      <option value="readiness">Readiness</option>
                      <option value="application">Application</option>
                      <option value="both">Both</option>
                    </select>
                  </div>

                  <!-- Generate Chart Button -->
                  <!-- <div class="col-12 col-md-1">
                    <input name="generate_Report2" id="" value="Chart" class="btn btn-primary generate_Report2" readonly>
                  </div> -->
                </div>

                <div class="row col-12 col-offset-2 pb-5 form-group justify-content-center">
                  <button name="generate_Report2" id="" class="btn btn-primary generate_Report2 px-5">Chart</button>
                </div>
              <!-- === -->
              <!-- <div class="clearfix"></div> -->

              <!-- Chart Message -->
              <div class="col-12">
                <h4 id="chartMessage2" style="text-align: center;"></h4>
              </div>
              <!-- === -->
              <div class="col-12 col-md-6 pull-left">
                <div id="treeMapChart"></div>
              </div>

              <div class="col-12 col-md-6 pull-right">
                <div id="containerCRvsCA"></div>
              </div>
              <div class="clearfix"></div>
              <!-- === -->
              <div class="col-12">
                <div id="readinessANDapplication"></div>
              </div>

            </div>
            <?php } ?>

          </div>
          </div>
          </div>
        </div>

    </div>
  </div>

<script>
  $(document).ready(function() {
    // after .5 seconds of page load calling all functions 
    setTimeout(function() {
      chartFunction();
    }, 500);

    function sleep(milliseconds) {
      const date = Date.now();
      let currentDate = null;
      do {
        currentDate = Date.now();
      } while (currentDate - date < milliseconds);
    }

    function chartFunction() {
      $.ajax({
        url: "<?php echo base_url('Ajax/dashboardCardRunChartData'); ?>",
        type: 'POST',
        //data: formData,

        success: function(result) {
          result = JSON.parse(result);
          // console.log(result);

          if (result.status == 200) {
            // building column chart
            Highcharts.chart('containerCardStartedCompleted', {
              chart   : {type: 'column'},
              title   : {text: 'Card Run'},
              subtitle: {text: null},
              credits : {enabled: false},

              // legend: {
              //   align: 'right',
              //   verticalAlign: 'middle',
              //   layout: 'vertical'
              // },

              xAxis: {
                categories: result.card_Name,
                labels: {x: -10},
                crosshair: true
              },

              yAxis: {
                min: 0,
                allowDecimals: false,
                title: {text: 'Count'}
              },

              plotOptions: {
                column: {
                  pointPadding: 0.2,
                  borderWidth: 0
                }
              },

              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:2px"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },

              colors: ['#000a12', '#dc3545', '#fec400', '#28a745'],

              series: [{
                name: 'Total User',
                data: result.card_User_Total,
                events: {
                  click: function (event) {
                    let cardName = event.point.category;
                    ChatClickShowDetail(cardName, result.card_ID[event.point.x], 'totalUser');
                  }
                }
              },{
                name: 'Yet To Start',
                data: result.card_User_NotStarted,
                // events: {
                //   click: function (event) {
                //     let cardName = event.point.category;
                //     ChatClickShowDetail(cardName, result.card_ID[event.point.x], 'notStartes');
                //   }
                // }
              }, {
                name: 'Continuing',
                data: result.card_User_Started,
                events: {
                  click: function (event) {
                    let cardName = event.point.category;
                    ChatClickShowDetail(cardName, result.card_ID[event.point.x], 'started');
                  }
                }
              }, {
                name: 'Completed',
                data: result.card_User_Completed,
                events: {
                  click: function (event) {
                    let cardName = event.point.category;
                    ChatClickShowDetail(cardName, result.card_ID[event.point.x], 'completed');
                  }
                }
              }],

              responsive: {
                rules: [{
                  condition: {maxWidth: 500},
                  chartOptions: {
                    legend: {
                      align: 'center',
                      verticalAlign: 'bottom',
                      layout: 'horizontal'
                    },
                    yAxis: {
                      labels: {
                        align: 'left',
                        x: 0,
                        y: -5
                      },
                      title: {text: null}
                    },
                    subtitle: {text: null},
                    credits: {enabled: false}
                  }
                }]
              }
            }); // end of containerCardStartedCompleted Highcharts

            // Building Combined Pie chart for all cards
            let countTotalUsers = 0;
            let countYetToStart = 0;
            let countPlaying    = 0;
            let countCompleted  = 0;
            for (var i=0; i<result.card_Name.length; i++) {
              countTotalUsers = countTotalUsers + result.card_User_Total[i];
              countYetToStart = countYetToStart + result.card_User_NotStarted[i];
              countPlaying    = countPlaying    + result.card_User_Started[i];
              countCompleted  = countCompleted  + result.card_User_Completed[i];
            }

            Highcharts.chart('containerCardTotalPie', {
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
            }); // end of containerCardTotalPie Highcharts

            // Building Single-single(individual) Pie chart for all cards 
            // var chartData = '<div class="clearfix"></div>';
            // let chartCount = 0;
            // for (var i=0; i<result.card_Name.length; i++) {
            //   chartDataCount = 'chartData'+i;
            //   chartCount++;
            //   chartData += '<div class="col-md-4"><div id="'+chartDataCount+'"></div></div>';
            //   if (chartCount%3 == 0) {
            //     chartData += '<div class="clearfix"></div>';
            //   }
            // }

            // $('#containerCardStartedCompletedPie').html(chartData);
            // sleep(2000);
            // console.log(chartData);

            // for (var i=0; i<result.card_Name.length; i++) {
            //   Highcharts.chart('chartData'+i, {
            //     chart: {
            //       type: 'pie',
            //       options3d: {
            //         enabled: true,
            //         alpha: 0 // tilt at angle
            //       }
            //     },

            //     title: {text: result.card_Name[i]},
            //     subtitle: {text: ''},
            //     credits: {enabled: false},

            // colors: ['#000a12', '#dc3545', '#fec400', '#28a745'],
            // // colors: ['#dc3545', '#fec400', '#28a745'],

            //     plotOptions: {
            //       pie: {
            //         innerSize: 100, // hollow inside circle
            //         depth: 45, // height of circle
            //         allowPointSelect: true,
            //         cursor: 'pointer',
            //         dataLabels: {enabled: false},
            //         showInLegend: true
            //       },
            //       series: {colorByPoint: true}
            //     },

            //     series: [{
            //       name: 'Users',
            //       data: [
            //         // ['Total User', result.card_User_Total[i]],
            //         ['Yet To Start', result.card_User_NotStarted[i]],
            //         ['Playing', result.card_User_Started[i]],
            //         ['Completed', result.card_User_Completed[i]]
            //       ]
            //     }]
            //   }); // end of chartData Highcharts
            // } // end of for loop

          } // end of status == 200
        } // end of success function
      }); // end of ajax function
    } //end of function

    function ChatClickShowDetail(cardName, cardID, type) {
      // setting card type
      switch (type) {
        case 'totalUser':
          cardType = 'Total User';
          break;
        case 'notStartes':
          cardType = 'Yet To Start';
          break;
        case 'started':
          cardType = 'Playing';
          break;
        case 'completed':
          cardType = 'Completed';
          break;
      }
      // console.log(cardID);

      var result = triggerAjax("<?php echo base_url('Ajax/getCardUserDetailsData/'); ?>"+cardID+"/"+type);
      //console.log(result);
      if (result.status == 200) {
        // Bootstrap Model
        $('#myLargeModalLabel').html(cardName+' Card - '+cardType);
        $('#cardDetails_msg').html(result.cardUserData);
        makeTableDataTable();
        $('#Modal_cardDetails').modal('show');
      }
    }

    $('.generate_Report').on('click', function() {
      var report_startDate = $("#report_startDate").val();
      var report_endDate   = $("#report_endDate").val();
      //console.log(report_startDate);
      //console.log(report_endDate);

      if (report_startDate == "" && report_endDate == "") {
        Swal.fire('Please select start and end date');
      } 
      else if (report_startDate == "") {
        Swal.fire('Please Select Start Date');
      } 
      else if (report_endDate == "") {
        Swal.fire('Please Select End Date');
      }
      // else if (report_startDate < report_endDate) {
      //  Swal.fire('Please make sure End Date is greater then Start Date');
      // } 
      else if (report_startDate && report_endDate) {
        let formula_selected = $('#Cmap_Formula_ID').val();
        //console.log(formula_selected);

        if (formula_selected < 1 || formula_selected == '--Score Selector--') {
          // Formula not Selected
          //removing the Chart if user not Selected Formula
          $('#lastTwentyFiveChart, #averageValueChart, #highestValueChart, #singlePersonChart, #singlePersonChart2, #containerCRvsSP, #containerCRvsCA, #treeMapChart, #readinessANDapplication, #chartMessage2').html('');

          $('#chartMessage').html('<span class="text-danger text-center">Score Selector not selected.</span>');
        }
        else {
          // show some wait text to users
          $('#chartMessage').html('<span class="text-dark text-center">Chart Loading, Please Wait...</span>');
          // $('#chartMessage').html('<div class="spinner-border text-dark" role="status"><span class="sr-only"> Chart Loading, Please Wait...</span></div>');
          // removing the Chart if user viewed earlier
          $('#lastTwentyFiveChart, #averageValueChart, #highestValueChart, #singlePersonChart, #singlePersonChart2, #containerCRvsSP, #containerCRvsCA, #treeMapChart, #readinessANDapplication, #chartMessage2').html('');

          // Setting Choosen Chart Type
          // chartType => readiness, application, both
          var chartType = $("#Cmap_Chart_Type").val();

          // tirgger ajax and get the user Chart which are visible
          var formData = $('#generateChart').serialize();
          $.ajax({
            url: "<?php echo base_url('Ajax/dashboardChartData'); ?>",
            type: 'POST',
            data: formData,

            success: function(result) {
              result = JSON.parse(result);
              //console.log(result);

              if (result.status == 200) {
                // removing the chart message if user viewed earlier
                $('#chartMessage, #chartMessage2').html('');
                // removing the Chart if user viewed earlier
                //$('#lastTwentyFiveChart, #averageValueChart, #highestValueChart, #singlePersonChart, #singlePersonChart2, #containerCRvsSP, #containerCRvsCA').html('');
                // ================================================
                // console.log(result.overallValue.length);
                var totalScoresCount = result.overallValue.length;
                if (totalScoresCount > 0) {
                  Highcharts.chart('lastTwentyFiveChart', {
                    chart: {
                      type: 'column',
                      options3d: {
                        enabled: true,
                        alpha: 10,
                        beta: 0,
                        depth: 0
                      }
                    },
                    title: {text: 'Last '+totalScoresCount+' Scores (Using Score Selector)'},
                    subtitle: {text: ''},
                    credits: {enabled: false},
                    plotOptions: {
                      column: {depth: 25}
                    },
                    xAxis: {
                      categories: result.creationDate,
                      labels: {
                        skew3d: true,
                        style: {fontSize: '16px'}
                      }
                    },
                    yAxis: {
                      title: {text: null}
                    },
                    series: [{
                      name: 'Scores',
                      showInLegend: false,
                      data: result.overallValue
                    }]
                  }); // end of lastTwentyFiveChart
                }
                // else {
                //   $('#lastTwentyFiveChart').html('No users Score any value.');
                // }
                // ================================================
                Highcharts.chart('averageValueChart', {
                  chart: {
                    type: 'column',
                    options3d: {
                      enabled: true,
                      alpha: 10,
                      beta: 0,
                      depth: 0
                    }
                  },
                  title: {text: 'Average Scores'},
                  subtitle: {text: ''},
                  credits: {enabled: false},
                  plotOptions: {
                    column: {depth: 25},
                    series: {colorByPoint: true}
                  },
                  xAxis: {
                    categories: ['Competence Readiness', 'Competence Application', 'Simulated Performance', 'Overall Value'],
                    labels: {
                      skew3d: true,
                      style: {fontSize: '16px'}
                    }
                  },
                  yAxis: {
                    title: {text: null}
                  },
                  series: [{
                    name: 'Scores',
                    showInLegend: false,
                    data: [result.averageCR, result.averageCA, result.averageSP, result.averageOvarall]
                  }]
                }); // end of averageValueChart
                // ================================================
                Highcharts.chart('highestValueChart', {
                  chart: {
                    type: 'column',
                    options3d: {
                      enabled: true,
                      alpha: 10,
                      beta: 0,
                      depth: 0
                    }
                  },
                  title: {text: 'Highest Scores'},
                  subtitle: {text: ''},
                  credits: {enabled: false},
                  plotOptions: {
                    column: {depth: 25},
                    series: {colorByPoint: true}
                  },
                  xAxis: {
                    categories: ['Competence Readiness', 'Competence Application', 'Simulated Performance', 'Overall Value'],
                    labels: {
                      skew3d: true,
                      style: {fontSize: '16px'}
                    }
                  },
                  yAxis: {
                    title: {text: null}
                  },
                  series: [{
                    name: 'Scores',
                    showInLegend: false,
                    data: [result.heighestCR, result.heighestCA, result.heighestSP, result.heighestOvarall]
                  }]
                }); // end of highestValueChart
                // ================================================
                // Highcharts.chart('singlePersonChart', {
                //   chart: {
                //     type: 'column'
                //   },
                //   title: {
                //     text: 'Highest Scored By'
                //   },
                //   subtitle: {
                //     text: ''
                //   },
                //   credits: {
                //     enabled: false
                //   },
                //   legend: {
                //     align: 'right',
                //     verticalAlign: 'middle',
                //     layout: 'vertical'
                //   },
                //   xAxis: {
                //     categories: result.scoredByUserName,
                //     labels: {
                //       x: -10
                //     }
                //   },
                //   yAxis: {
                //     allowDecimals: false,
                //     title: {
                //       text: 'Scores'
                //     }
                //   },

                //   series: [{
                //     name: 'Competence Readiness',
                //     data: result.scoredByCR
                //   }, {
                //     name: 'Competence Application',
                //     data: result.scoredByCA
                //   }, {
                //     name: 'Simulated Performance',
                //     data: result.scoredBySP
                //   }, {
                //     name: 'Overall Value',
                //     data: result.scoredByOvarall
                //   }],

                //   responsive: {
                //     rules: [{
                //       condition: {
                //         maxWidth: 500
                //       },
                //       chartOptions: {
                //         legend: {
                //           align: 'center',
                //           verticalAlign: 'bottom',
                //           layout: 'horizontal'
                //         },
                //         yAxis: {
                //           labels: {
                //             align: 'left',
                //             x: 0,
                //             y: -5
                //           },
                //           title: {
                //             text: null
                //           }
                //         },
                //         subtitle: {
                //           text: null
                //         },
                //         credits: {
                //           enabled: false
                //         }
                //       }
                //     }]
                //   }
                // }); // end of singlePersonChart
                // ================================================
                // Highcharts.chart('singlePersonChart2', {
                //   chart: {
                //     type: 'area'
                //   },
                //   title: {
                //     text: 'Highest Scores By'
                //   },
                //   subtitle: {
                //     text: ''
                //   },
                //   credits: {
                //     enabled: false
                //   },
                //   xAxis: {
                //     categories: result.scoredByUserName,
                //     labels: {
                //       x: -10
                //     },
                //     tickmarkPlacement: 'on',
                //   },
                //   yAxis: {
                //     allowDecimals: false,
                //     title: {
                //       text: 'Scores'
                //     }
                //   },
                //   tooltip: {
                //     split: true,
                //     // valueSuffix: ''
                //   },
                //   plotOptions: {
                //     area: {
                //       stacking: 'normal',
                //       lineColor: '#666666',
                //       lineWidth: 1,
                //       marker: {
                //         lineWidth: 1,
                //         lineColor: '#666666'
                //       }
                //     }
                //   },
                //   series: [{
                //     name: 'Competence Readiness',
                //     // data: [502, 635, 809, 947]
                //     data: result.scoredByCR
                //   }, {
                //     name: 'Competence Application',
                //     // data: [106, 107, 111, 133]
                //     data: result.scoredByCA
                //   }, {
                //     name: 'Simulated Performance',
                //     // data: [163, 203, 276, 408]
                //     data: result.scoredBySP
                //   }, {
                //     name: 'Overall Value',
                //     // data: [18, 31, 54, 156]
                //     data: result.scoredByOvarall
                //   }]
                //   // result.heighestCR, result.heighestCA, result.heighestSP, result.heighestOvarall
                // }); // end of singlePersonChart2
                // ================================================
                // Highcharts.chart('containerCRvsSP', {
                //   chart: {
                //     type: 'scatter',
                //     zoomType: 'xy'
                //   },
                //   title: {text: 'Readiness Vs Simulated Performance'},
                //   subtitle: { },
                //   credits: {enabled: false},
                //   xAxis: {
                //     title: {
                //       enabled: true,
                //       text: 'Scores in Simulated Performance'
                //     },
                //     startOnTick: true,
                //     endOnTick: true,
                //     showLastLabel: true
                //   },
                //   yAxis: {
                //     title: {text: 'Scores in Readiness'}
                //   },
                //   legend: {
                //     layout: 'vertical',
                //     align: 'left',
                //     verticalAlign: 'top',
                //     x: 100,
                //     y: 70,
                //     floating: true,
                //     backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
                //     borderWidth: 1
                //   },
                //   plotOptions: {
                //     scatter: {
                //       marker: {
                //         radius: 5,
                //         states: {
                //           hover: {
                //             enabled: true,
                //             lineColor: 'rgb(100,100,100)'
                //           }
                //         }
                //       },
                //       states: {
                //         hover: {
                //           marker: {enabled: false}
                //         }
                //       },
                //       tooltip: {
                //         headerFormat: '<b>{series.name}</b><br>',
                //         pointFormat: '{point.x}, {point.y}'
                //       }
                //     }
                //   },
                //   series: [{
                //     name: 'Quadrant I',
                //     // x-axis (100 - ---), y-axis (100 - ---)
                //     showInLegend: false,
                //     color: 'rgba(56, 142, 60)',
                //     // data: [[130, 110], [160, 172], [170, 128], [140, 174], [184, 186], [147, 158], [111, 171], [184, 186], [147, 158], [111, 151]]
                //     data: result.quadrantCRvsSPI

                //   }, {
                //     name: 'Quadrant II',
                //     // x-axis (0 - 100), y-axis (100 - ---)
                //     showInLegend: false,
                //     color: 'rgba(25, 118, 210)',
                //     // data: [[61, 110], [16, 109], [50, 149], [40, 163], [10, 153], [80, 159]]
                //     data: result.quadrantCRvsSPII

                //   }, {
                //     name: 'Quadrant III',
                //     // x-axis (0 - 100), y-axis (0 - 100)
                //     showInLegend: false,
                //     color: 'rgba(223, 83, 83)',
                //     // data: [[60, 51], [15, 59],[26, 71], [5, 9], [25, 19], [35, 60], [50, 63], [80, 90], [70, 47]]
                //     data: result.quadrantCRvsSPIII

                //   }, {
                //     name: 'Quadrant IV',
                //     // x-axis (100 - ---), y-axis (0 - 100)
                //     showInLegend: false,
                //     color: 'rgba(251, 192, 45)',
                //     // data: [[130, 10], [160, 72], [170, 28], [140, 74], [184, 86], [147, 58], [111, 71]]
                //     data: result.quadrantCRvsSPIV
                //   }]
                // }); // end of containerCRvsSP
                // ================================================
              } // end of status == 200
            } // end of success function
          }); // end of ajax function
        } // end of else
      } // end of else if
    }); // end of onclick generate_Report function

    //=========================================================
    //=========================================================

    $('.generate_Report2').on('click', function() {
      var report_startDate = $("#report_startDate").val();
      var report_endDate   = $("#report_endDate").val();
      //console.log(report_startDate);
      //console.log(report_endDate);

      if (report_startDate == "" && report_endDate == "") {
        Swal.fire('Please select start and end date');
      } 
      else if (report_startDate == "") {
        Swal.fire('Please Select Start Date');
      } 
      else if (report_endDate == "") {
        Swal.fire('Please Select End Date');
      }
      // else if (report_startDate < report_endDate) {
      //  Swal.fire('Please make sure End Date is greater then Start Date');
      // } 
      else if (report_startDate && report_endDate) {
        let formula_selected = $('#Cmap_Formula_ID').val();
        //console.log(formula_selected);

        // Setting Choosen Chart Type
        // chartType => readiness, application, both
        var chartType = $("#Cmap_Chart_Type").val();

        if (formula_selected < 1 || formula_selected == '--Score Selector--') {
          // Formula not Selected
          //removing the Chart if user not Selected Formula
          $('#containerCRvsSP, #containerCRvsCA, #treeMapChart, #readinessANDapplication').html('');

          $('#chartMessage2').html('<span class="text-danger text-center">Score Selector not selected.</span>');
        }
        else if (chartType == '--Select--' || chartType == '') {
          //removing the Chart if user not Selected Formula
          $('#containerCRvsSP, #containerCRvsCA, #treeMapChart, #readinessANDapplication').html('');

          $('#chartMessage2').html('<span class="text-danger text-center">Chart Type not selected.</span>');
        }
        else {
          // show some wait text to users
          $('#chartMessage2').html('<span class="text-dark text-center">Chart Loading, Please Wait...</span>');
          
          // removing the Chart if user viewed earlier
          $('#containerCRvsSP, #containerCRvsCA, #treeMapChart, #readinessANDapplication').html('');

          // tirgger ajax and get the user Chart which are visible
          var formData = $('#generateChart').serialize();
          $.ajax({
            url: "<?php echo base_url('Ajax/dashboardChartData'); ?>",
            type: 'POST',
            data: formData,

            success: function(result) {
              result = JSON.parse(result);
              //console.log(result);

              if (result.status == 200) {
                // removing the chart message if user viewed earlier
                $('#chartMessage2').html('');
                // ================================================
                // chartType => readiness, application, both
                if (chartType == 'both') {
                  Highcharts.chart('treeMapChart', {
                    series: [{
                      type: "treemap",
                      showInLegend: false,
                      layoutAlgorithm: 'stripes',
                      alternateStartingDirection: true,
                      levels: [{
                        /* level: 1, */
                        layoutAlgorithm: 'sliceAndDice',
                        dataLabels: {
                          allowOverlap: true,
                          crop: false,
                          enabled: true,
                          align: 'left',
                          verticalAlign: 'top',
                          style: {
                            fontSize: '15px',
                            fontWeight: 'bold',
                          }
                        }
                      }],
                      data: [
                      {id: 'heading', name: '', color: "#eeeeee", sortIndex: 0},
                      {id: 'learned', name: 'LEARNED', color: "#EC2500", sortIndex: 0},
                      {id: 'informed', name: 'INFORMED', color: "#ECE100", sortIndex: 0},
                      {id: 'knowledgeable', name: 'KNOWLEDGEABLE', color: '#EC9800', sortIndex: 0},
                      {id: 'beginner', name: 'BEGINNER', color: '#EC9800', sortIndex: 0},
              
                      {name: 'RANDOM', parent: 'heading', value: 2, color: '#eeeeee'},
                      {name: 'UNFAVORABLE', parent: 'heading', value: 2, color: '#eeeeee'},
                      {name: 'FAVORABLE', parent: 'heading', value: 2, color: '#eeeeee'},
                      {name: 'EXEMPLARY', parent: 'heading', value: 2, color: '#eeeeee'},
                      {name: '', parent: 'heading', value: 2, color: '#eeeeee'},

                        
                      {name: 'COMPETENT ('+result.x1y4+')', parent: 'learned', value: 2, color: '#fdd835'},
                      {name: 'PROFICIENT ('+result.x1y3+')', parent: 'learned', value: 2, color: '#7cb342'},
                      {name: 'EXPERT ('+result.x1y2+')', parent: 'learned', value: 2, color: '#2e7d32'},
                      {name: 'EXPERT ('+result.x1y1+')', parent: 'learned', value: 2, color: '#2e7d32'},
                      {name: 'LEARNED', parent: 'learned', value: 2, color: '#eeeeee'},
                        
                      {name: 'PRACTITIONER ('+result.x2y4+')', parent: 'informed', value: 2, color: '#ef6c00'},
                      {name: 'COMPETENT ('+result.x2y3+')', parent: 'informed', value: 2, color: '#fdd835'},
                      {name: 'PROFICIENT ('+result.x2y2+')', parent: 'informed', value: 2, color: '#7cb342'},
                      {name: 'PROFICIENT ('+result.x2y1+')', parent: 'informed', value: 2, color: '#7cb342'},
                      {name: 'INFORMED', parent: 'informed', value: 2, color: '#eeeeee'},
                        
                      {name: 'NOVICE ('+result.x3y4+')', parent: 'knowledgeable', value: 2, color: '#EC2500'},
                      {name: 'PRACTITIONER ('+result.x3y3+')', parent: 'knowledgeable', value: 2, color: '#ef6c00'},
                      {name: 'COMPETENT ('+result.x3y2+')', parent: 'knowledgeable', value: 2, color: '#fdd835'},
                      {name: 'COMPETENT ('+result.x3y1+')', parent: 'knowledgeable', value: 2, color: '#fdd835'},
                      {name: 'KNOWLEDGEABLE', parent: 'knowledgeable', value: 2, color: '#eeeeee'},

                      {name: 'NOVICE ('+result.x4y+')', parent: 'beginner', value: 8, color: '#EC2500'},
                      {name: 'BEGINNER/IGNORANT', parent: 'beginner', value: 2, color: '#eeeeee'},
                      ]
                    }],
                    tooltip: {
                      formatter: function (tooltip) {
                        return false;
                      }
                    },
                    title: {text: 'Readiness Vs Application'},
                    credits: {enabled: false},
                  }); // end of treeMapChart (Readiness Vs Application)
                } // end of if chartType is both

                
                // ================================================

                // chartType => readiness, application, both
                if (chartType == 'both') {
                  Highcharts.chart('containerCRvsCA', {
                    chart: {
                      type: 'scatter',
                      zoomType: 'xy'
                    },
                    title: {text: 'Readiness Vs Application'},
                    subtitle: {text: ''},
                    credits: {enabled: false},
                    xAxis: {
                      title: {
                        enabled: true,
                        text: 'Scores in Readiness'
                      },
                      startOnTick: true,
                      endOnTick: true,
                      showLastLabel: true
                    },
                    yAxis: {
                      title: {text: 'Scores in Application'}
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
                            marker: {enabled: false}
                          }
                        },
                        tooltip: {
                          headerFormat: '<b>{series.name}</b><br>',
                          pointFormat: '{point.x}, {point.y}'
                        }
                      }
                    },
                    tooltip: {
                      formatter: function(tooltip) {
                        return this.x+','+this.y;
                      }
                    },
                    series: [{
                      name: 'Quadrant I',
                      // x-axis (100 - ---), y-axis (100 - ---)
                      showInLegend: false,
                      color: 'rgba(251, 192, 45)',
                      // data: [[130, 110], [160, 172], [170, 128], [140, 174], [184, 186], [147, 158], [111, 171], [184, 186], [147, 158], [111, 151]]
                      data: result.quadrantCRvsCAI

                    }, {
                      name: 'Quadrant II',
                      // x-axis (0 - 100), y-axis (100 - ---)
                      showInLegend: false,
                      color: 'rgba(223, 83, 83)',
                      // data: [[61, 110], [16, 109], [50, 149], [40, 163], [10, 153], [80, 159]]
                      data: result.quadrantCRvsCAII

                    }, {
                      name: 'Quadrant III',
                      // x-axis (0 - 100), y-axis (0 - 100)
                      showInLegend: false,
                      color: 'rgba(223, 83, 83)',
                      // data: [[60, 51], [15, 59],[26, 71], [5, 9], [25, 19], [35, 60], [50, 63], [80, 90], [70, 47]]
                      data: result.quadrantCRvsCAIII

                    }, {
                      name: 'Quadrant IV',
                      // x-axis (100 - ---), y-axis (0 - 100)
                      showInLegend: false,
                      color: 'rgba(56, 142, 60)',
                      // data: [[130, 10], [160, 72], [170, 28], [140, 74], [184, 86], [147, 58], [111, 71]]
                      data: result.quadrantCRvsCAIV
                    }]
                  }); // end of containerCRvsCA
                } // end of if chartType is both
                // ================================================

                // chartType => readiness, application, both
                if (chartType == 'readiness' || chartType == 'application') {
                  // Setting Chart Title and values
                  if (chartType == 'readiness') {
                    chartTitle  = 'Readiness';
                    chartValues = result.readiness;
                  }
                  else if (chartType == 'application') {
                    chartTitle  = 'Application';
                    chartValues = result.application;
                  }

                  var myScatter_Chart_Array = [];
                  for (var i=0; i < chartValues.length; i++) {
                    // console.log(chartValues[i]);
                    my_Single_Scatter_Chart_Array = [i+1, chartValues[i]];
                    myScatter_Chart_Array.push(my_Single_Scatter_Chart_Array);
                  }
                  // console.log(myScatter_Chart_Array);

                  Highcharts.chart('readinessANDapplication', {
                    chart: {
                      type: 'scatter',
                      zoomType: 'xy'
                    },
                    title: {
                      text: chartTitle
                    },
                    subtitle: {
                      text: 'Click and select area to zoom in. Use Reset Zoom to zoom out.'
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
                          // pointFormat: '{new Date(point.x *1000).getDate()+"-"+new Date(point.x *1000).getMonth()} Date,<br/>{point.y} Score'
                        }
                      }
                    },
                    series: [{
                      showInLegend: false,
                      name: 'User Score',
                      // color: 'rgba(54, 162, 235, 15)',
                      // fillColor:'#FF0000',

                      // [date,value]
                      // data: [[174, 65],[175, 71],[193, 80],[186, 72],[172, 72],[185, 76],[178, 69],[167, 84],[175, 64],[180, 69]]

                      data: myScatter_Chart_Array,
                      zones: [{
                            value: 1,
                            color: '#1c313a' // Black
                        }, {
                            value: 40,
                            color: '#b71c1c' // Red
                        }, {
                            value: 80,
                            color: '#fb8c00' // Orange
                        }, {
                            value: 120,
                            color: '#ffeb3b' // Yellow
                        }, {
                            value: 160,
                            color: '#1976d2' // Blue
                        }, {
                            color: '#43a047' // Green
                        }]
                    }]
                  }); // end of High Chart
                } // end of if chartType is both
                // ================================================
              } // end of status == 200
            } // end of success function
          }); // end of ajax function
        } // end of else
      } // end of else if
    }); // end of onclick generate_Report2 function

  }); // end of document.ready function
</script>