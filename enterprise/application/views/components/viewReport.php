<!--   <link href="http://ttc.microwarecomp.com/common/backend/css/app.min.1.css" rel="stylesheet">
  <link href="http://ttc.microwarecomp.com/common/backend/css/app.min.2.css" rel="stylesheet"> -->
  <div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg');?>
      <div class="min-height-200px">
        <div class="page-header">
          <div class="row">
            <div class="col-md-6 col-sm-12">
              <!-- <div class="title">
                <h1><a href="javascript:void(0);" data-toggle="tooltip" title="Reports"><i class="fa fa-file text-blue"> 
                </i></a> Online Reports</h1>
              </div> -->
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url('OnlineReport');?>">Online Report</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Card:- <?php echo $gameName->Game_Name?></li>
                </ol>
              </nav>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="title">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                 <!--  <div class="clearfix mb-20">
                    <h5 class="text-blue">See the users report acoordingly</h5>
                  </div> -->
                  <!-- add users details here -->
                  <div class="row col-md-12 col-lg-12 col-sm-12 form-group mb-20" id="showUserReport">
                    <table id="data_table_id" class="table table-condensed table-striped table-hover table-bordered table-responsive">
                      <thead id="table_body">
                        <tr>
                          <th data-column-id="ID" data-identifier="true" data-header-align="center">S N</th>
                          <th data-column-id="user_game_id" data-identifier="false" data-visible="false">ID</th>
                          <th data-column-id="reportIcons" data-identifier="false" data-formatter="reportIcons" data-sortable="false">Report</th>
                          <?php foreach ($tableHeader as $tableHeaderRow) { ?>
                            <th data-column-id="<?php echo $tableHeaderRow; ?>" data-header-align="center"><?php echo $tableHeaderRow; ?></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $j=1; foreach ($userData as $userDataRow) { ?>
                          <tr>
                            <td><?php echo $j; ?></td>
                            <td><?php echo $userDataRow['user_game_id']; ?></td>
                            <td></td>
                            <!-- <?php // print_r($userDataRow); echo "<br><br>"; ?> -->
                            <?php for($i=0; $i<count($tableHeader); $i++) { ?>
                              <td>
                                <?php echo (array_key_exists($tableHeader[$i], $userDataRow))?$userDataRow[$tableHeader[$i]]:NULL; ?>
                              </td>
                            <?php } ?>
                          </tr>
                          <?php $j++; } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- end of adding users -->
                </div>
              </div>

              <script>
                $(document).ready(function(){
                  $("#data_table_id").bootgrid({
                    caseSensitive: false,
                    selection    : true,
                    // multiSelect  : true,
                    rowSelect    : true,
                    keepSelect   : true,
                    css: {
                      icon       : 'fa',
                      iconColumns: 'fa fa-server',
                      iconDown   : 'fa fa-angle-down',
                      iconRefresh: 'fa fa-refresh',
                      iconUp     : 'fa fa-angle-up',
                      // search     :'fa fa-search'
                    },
                    formatters: {
                      "reportIcons": function(column, row) {
                        // console.log(column); console.log(row);
                        var user_game_id   = row.user_game_id.split('_');
                        var user_id        = user_game_id[0];
                        var game_id        = user_game_id[1];
                        var gameStatus     = user_game_id[2];
                        var lastScenLinkId = user_game_id[3];
                        var report_icon    = '';

                        if(gameStatus > 0)
                        {
                          // this means user has completed game. So, show report icon

                          // report_icon = "<a href='javascript:void(0);' data-user_id='"+user_id+"' data-game_id='"+game_id+"' data-toggle='tooltip' title='Download Report' onclick='downloadGameReport(this)'><span class='fa fa-download'></span></a>";

                          // commenting the above lines, to prevent the report download from pdf, and redirecting the viewUserReport(). So, this will get the view from report.php, via ajax and show to processOwner
                          report_icon = "<a target='_blank' href='<?php echo base_url('OnlineReport/viewUserReport/');?>"+game_id+"/"+lastScenLinkId+"/"+user_id+"' data-user_id='"+user_id+"' data-game_id='"+game_id+"' data-toggle='tooltip' title='Download Report'><span class='fa fa-download'></span></a>";
                        }
                        else
                        {
                          // show alert that user has not completed the game so far
                          report_icon = "<a href='javascript:void(0);' data-toggle='tooltip' title='Card Not Completed So Far' onclick='showAlertForIncompleteGame()'><span class='fa fa-download'></span></a>";
                        }

                        return report_icon+" &nbsp; <a href='javascript:void(0);' data-user_id='"+user_id+"' data-game_id='"+game_id+"' data-toggle='tooltip' title='View Performance Chart' onclick='showPerformanceChart(this)'><span class='fa fa-line-chart'></span></a>";
                      }
                    },
                  }).on("loaded.rs.jquery.bootgrid", function () {

                    if ($('[data-toggle="tooltip"]')[0]) {
                      $('[data-toggle="tooltip"]').tooltip();
                    }

                    // $('[data-toggle=confirmation]').confirmation({
                    //   rootSelector: '[data-toggle=confirmation]',
                    // });
                  });
                });

                function showPerformanceChart(element)
                {
                  var user_id = $(element).data('user_id');
                  var game_id = $(element).data('game_id');
                  // console.log(user_id+' and '+game_id);
                  // trigger ajax to get the data accordingly
                  $.ajax({
                    url : "<?php echo base_url('Ajax/showPerformanceChart/');?>"+user_id+'/'+game_id,
                    type: "POST",
                    data: '',
                    beforeSend: function(){
                    },
                    success:function(result)
                    {
                      // console.log(result);
                      var result = JSON.parse(result);
                      if(result.status == 200)
                      {
                       Swal.fire({
                        // icon : result.icon,
                        // title: result.title,
                        html : 'showing chart for now',
                        showClass: {
                          popup: 'animated zoomInUp faster'
                        },
                        hideClass: {
                          popup: 'animated zoomOutUp faster'
                        }
                      });
                        // create element and show this on alert
                        $('#swal2-content').html('<a id="downloadPerformanceChart" href="javascript:void(0);" download="performanceGraph.png" data-toggle="tooltip" title="Download Performance Chart" class="pull-right"><i class="fa fa-download"></i></a> <canvas id="lineChart" width="400" height="400"></canvas>');
                        var ctx     = $('#lineChart');
                        var myChart = new Chart(ctx, {
                          type: 'line',
                          data: {
                            labels: result.chartLabels,
                            datasets: [{
                              label: result.graphTitle,
                              data: result.chartData,
                              backgroundColor: [
                              'rgba(54, 162, 235, 0.2)',
                              ],
                              borderColor: [
                              'rgba(54, 162, 235, 1)',
                              ],
                              borderWidth: 2,
                              // fill: false,
                            },
                            {
                              label: "Top Score",
                              data: result.overAllBenchmark,
                              backgroundColor: [
                              'rgba(255, 206, 86, 0.2)',
                              ],
                              borderColor: [
                              'rgba(255, 159, 64, 1)'
                              ],
                              borderWidth: 2,
                              fill: false,
                            }
                            ],
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
                                  // maxRotation: 90,
                                  minRotation: 60,
                                }
                              }]
                            },
                          }
                        });
                        // adding chart downloading functionality
                        $('#downloadPerformanceChart').on('click',function(){
                          var url_base64 = document.getElementById('lineChart').toDataURL('image/png');
                          $('#downloadPerformanceChart').attr('href',url_base64);
                        });
                      }
                      else
                      {
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

function showAlertForIncompleteGame()
{
  Swal.fire({
    icon : 'error',
    title: 'Incomplete',
    html : 'User has not completed this Card so far.',
    showClass: {
      popup: 'animated fadeInDown faster'
    },
    hideClass: {
      popup: 'animated fadeOutUp faster'
    }
  });
}

function downloadGameReport(element)
{
  var user_id   = $(element).data('user_id');
  var game_id   = $(element).data('game_id');
  var returnUrl = "<?php echo $this->uri->segment(3); ?>";
  // console.log(returnUrl);
  // console.log(user_id+' and '+game_id);
  window.location = "<?php echo base_url('Ajax/downloadGameReport/');?>"+user_id+'/'+game_id+'/'+returnUrl;
  // trigger ajax to get the data accordingly
  // $.ajax({
  //   url : "<?php echo base_url('Ajax/downloadGameReport/');?>"+user_id+'/'+game_id,
  //   type: "POST",
  //   data: '',
  //   beforeSend: function(){
  //   },
  //   success:function(result)
  //   {
  //     // console.log(result);
  //     var result = JSON.parse(result);
  //     if(result.status == 200)
  //     {
  //       Swal.fire({
  //         icon : result.icon,
  //         title: result.title,
  //         html : result.message,
  //         showClass: {
  //           popup: 'animated fadeInDown faster'
  //         },
  //         hideClass: {
  //           popup: 'animated fadeOutUp faster'
  //         }
  //       });
  //     }
  //     else
  //     {
  //       Swal.fire({
  //         icon : result.icon,
  //         title: result.title,
  //         html : result.message,
  //         showClass: {
  //           popup: 'animated fadeInDown faster'
  //         },
  //         hideClass: {
  //           popup: 'animated fadeOutUp faster'
  //         }
  //       });
  //     }
  //   }

  // });
}
</script>           
<style>
 .pagination {
  display: inline-block;
  padding-left: 0;
  margin: 18px 0;
  border-radius: 2px;
}

.pagination > li {
  display: inline;
}

.pagination > li > a,
.pagination > li > span {
  position: relative;
  float: left;
  padding: 6px 12px;
  line-height: 1.42857143;
  text-decoration: none;
  color: #7e7e7e;
  background-color: #e2e2e2;
  border: 1px solid #ffffff;
  margin-left: -1px;
}

.pagination > li:first-child > a,
.pagination > li:first-child > span {
  margin-left: 0;
  border-bottom-left-radius: 2px;
  border-top-left-radius: 2px;
}

.pagination > li:last-child > a,
.pagination > li:last-child > span {
  border-bottom-right-radius: 2px;
  border-top-right-radius: 2px;
}

.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
  z-index: 2;
  color: #333333;
  background-color: #d7d7d7;
  border-color: #ffffff;
}

.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
  z-index: 3;
  color: #ffffff;
  background-color: #00bcd4;
  border-color: #ffffff;
  cursor: default;
}

.pagination > .disabled > span,
.pagination > .disabled > span:hover,
.pagination > .disabled > span:focus,
.pagination > .disabled > a,
.pagination > .disabled > a:hover,
.pagination > .disabled > a:focus {
  color: #777777;
  background-color: #e2e2e2;
  border-color: #ffffff;
  cursor: not-allowed;
}

.pagination-lg > li > a,
.pagination-lg > li > span {
  padding: 10px 16px;
  font-size: 17px;
  line-height: 1.3333333;
}

.pagination-lg > li:first-child > a,
.pagination-lg > li:first-child > span {
  border-bottom-left-radius: 2px;
  border-top-left-radius: 2px;
}

.pagination-lg > li:last-child > a,
.pagination-lg > li:last-child > span {
  border-bottom-right-radius: 2px;
  border-top-right-radius: 2px;
}

.pagination-sm > li > a,
.pagination-sm > li > span {
  padding: 5px 10px;
  font-size: 12px;
  line-height: 1.5;
}

.pagination-sm > li:first-child > a,
.pagination-sm > li:first-child > span {
  border-bottom-left-radius: 2px;
  border-top-left-radius: 2px;
}

.pagination-sm > li:last-child > a,
.pagination-sm > li:last-child > span {
  border-bottom-right-radius: 2px;
  border-top-right-radius: 2px;
}

.pagination {
  border-radius: 0;
}

.pagination > li {
  margin: 0 2px;
  display: inline-block;
  vertical-align: top;
}

.pagination > li > a,
.pagination > li > span {
  border-radius: 50% !important;
  padding: 0;
  width: 40px;
  height: 40px;
  line-height: 38px;
  text-align: center;
  font-size: 14px;
  z-index: 1;
  position: relative;
  cursor: pointer;
}

.pagination > li > a > .zmdi,
.pagination > li > span > .zmdi {
  font-size: 22px;
  line-height: 39px;
}

.pagination > li.disabled {
  opacity: 0.5;
  filter: alpha(opacity=50);
}

.lv-pagination {
  width: 100%;
  text-align: center;
  padding: 40px 0;
  border-top: 1px solid #F0F0F0;
  margin-top: 0;
  margin-bottom: 0;
}
tr.active{
  background-color: #00bcd4 !important;
}
.bootgrid-table td.select-cell, .bootgrid-table th.select-cell{
  display: none;
}
.bootgrid-footer .search, .bootgrid-header .search{
  margin: 0 20px -25px 0;
}
</style>