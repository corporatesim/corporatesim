<script type="text/javascript">
  var loc_url_del = "<?php echo base_url('feedback/deleteRecord/'); ?>";
  var func        = "<?php //echo $this->uri->segment(2); ?>";
</script>
<style>
  #upload-file-selector {
    display:none;
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
              <h1><a href="<?php echo base_url('feedback/addFeedback'); ?>" data-toggle="tooltip" data-original-title="Add Feedback" ><i class="fa fa-plus-circle text-blue"></i></a> Feedback</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Feedback</li>
              </ol>
            </nav>
          </div>
        </div>

        <!--========================-->
        <!-- Start Bulk Import Modal -->
        <div class="modal fade bs-example-modal-lg" id="Modal_Bulkupload" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title text-success" id="myLargeModalLabel">Import Success</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close" onclick="location.reload();">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <p id="bulk_u_msg"></p>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="location.reload();">Close</button>
              </div>

            </div>
          </div>
        </div>
        <!--========================-->
        <div id="Modal_BulkuploadError" class="modal" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title text-danger">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <p id="bulk_u_err"></p>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
        <!-- End Bulk Import Modal -->
        <!--========================-->

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">

                  <div class="clearfix col-12 mb-5">
                    <div class="col-md-8 pull-left">
                      <div id="containerCardColumnChart"></div>
                    </div>
                    <div class="col-md-4 pull-right">
                      <div id="containerCardPieChart"></div>
                    </div>
                  </div>
                  <hr />
                  <div class="clearfix pb-3 pt-2">
                    <div class="pull-left">
                      <!-- <h5 class="text-blue">Feedback List</h5> -->

                      <a href="javascript:void(0);" id="downloadFeedback"><button type="button" class="btn btn-info px-5"><span class="btn-label"><i class="fa fa-download"></i></span>&nbsp;Download Feedback</button></a>
                    </div>
                    <div class="pull-right">
                      <!-- Upload CSV -->
                      <form method="post" id="bulk_upload_csv" name="bulk_upload_csv" action="" enctype="multipart/form-data">
                        <span id="fileselector" class="btn btn-primary btn-sm">
                          <label class="btn btn-default" for="upload-file-selector">
                            <input id="upload-file-selector" type="file" name="upload_csv">
                            <i class="fa fa-upload"></i> Bulk Upload Feedback
                          </label>
                        </span> 
                      </form>
                      <a href="<?php echo base_url()."csvdemofiles/feedback-upload-csv-demo-file.csv"; ?>" download="Feedback-Bulk-Upload-CSV-Template.csv"><u>Feedback Bulk Upload CSV Template</u></a>
                    </div>
                  </div>

                </div>
                <div class="row" id="addTable">
                  <table class="stripe hover multiple-select-row data-table-export">
                    <thead>
                      <tr>
                        <th>Sl.No.</th>
                        <!-- <th>User ID</th> -->
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Time</th>
                        <th>Rating</th>
                        <th>Title</th>
                        <th class="datatable-nosort noExport">Message</th>
                        <th class="datatable-nosort noExport">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (count($details) < 1 || $details == '') { ?>
                        <tr>
                          <td class="text-danger text-center" colspan="7"> No Record Found </td>
                        </tr>
                      <?php 
                      } // only if record exists
                      else if (!empty($details)) {
                        $slno = 0; // setting variable for table serial Number
                        
                        // print_r($details);
                        foreach ($details as $detailsRow) { 
                          $slno++; // incrementing serial number

                          $data = json_decode($detailsRow->Feedback_userData);
                          // $pic = ($data->ProfilePic) ? $data->ProfilePic : 'avatar.png';
                      ?>
                        <tr>
                          <!-- Sl.No. -->
                          <td><?php echo $slno; ?></td>
                          <!-- User ID -->
                          <!-- <td><?php echo $detailsRow->Feedback_userid; ?></td> -->
                          <!-- Name -->
                          <td><?php echo $data->fullName; ?></td>
                          <!-- Email ID -->
                          <td><?php echo $data->Email; ?></td>
                          <!-- Time -->
                          <td><?php echo date('d-M-y, H:i', strtotime($detailsRow->Feedback_createdOn)); ?></td>
                          <!-- Rating -->
                          <td><?php echo $detailsRow->Feedback_rating; ?></td>
                          <!-- Title -->
                          <td><?php echo $detailsRow->Feedback_title; ?></td>
                          <!-- Message -->
                          <td>
                            <button type="button" class="btn btn-link" title="" data-toggle="tooltip" data-original-title="<?php echo $detailsRow->Feedback_message; ?>" data-id="<?php echo $detailsRow->Feedback_id; ?>" onclick="callDetails(this)">
                              <i class="fa fa-eye text-info fa-2x"></i>
                            </button>
                          </td>
                          <!-- Action -->
                          <td>
                            <div class="dropdown">
                              <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-h"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-left">
                                <a class="dropdown-item" href="<?php echo base_url('feedback/updateFeedback/').base64_encode($detailsRow->Feedback_id); ?>">
                                <i class="fa fa-pencil"></i> Edit</a>

                                <a class="dropdown-item dl_btn" href="javascript:void(0);" class="btn btn-primary dl_btn" id="<?php echo $detailsRow->Feedback_id; ?>" title="Delete">
                                <i class="fa fa-trash"></i> Delete</a>

                                <!-- <a class="dropdown-item" href="javascript:void(0);" data-col_table="Compt_Delete__ITEMS__Compt_Id__listCompetence" data-toggle="tooltip" title="Delete" data-pid="<?php echo $detailsRow->Feedback_id; ?>" class="deleteIcon">
                                <i class="fa fa-trash"></i> Delete</a> -->
                              </div>
                            </div>
                          </td>
                        </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

<script>
  $(document).ready(function() {
    // after 1 seconds of page load displaying Graph
    setTimeout(function() {
      callGraph();
    }, 1000);

    // Showing Graph
    function callGraph() {
      var result = triggerAjax("<?php echo base_url('feedback/getFeedbackGraph'); ?>");
      // console.log(result);

      if (result.status == 200) {
        // console.log(`
        //   Star 1 - ${result.star1}
        //   Star 2 - ${result.star2}
        //   Star 3 - ${result.star3}
        //   Star 4 - ${result.star4}
        //   Star 5 - ${result.star5}
        // `);

        // making Column and Pie Chart
        let star1 = Number(result.star1);
        let star2 = Number(result.star2);
        let star3 = Number(result.star3);
        let star4 = Number(result.star4);
        let star5 = Number(result.star5);

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
            series: {
              colorByPoint: true,
              dataLabels: {
                enabled: true,
              }
            }
          },

          colors: ['#f44336', '#ff9800', '#00bcd4', '#2196F3', '#4CAF50'],

          xAxis: {
            categories: ['1 Star', '2 Star', '3 Star', '4 Star', '5 Star'],
            labels: {
              skew3d: true,
              style: {fontSize: '16px'}
            }
          },

          yAxis: {
            title: {text: 'Total Feedback Users'}
          },

          series: [{
            name: 'Feedback',
            showInLegend: false,
            data: [star1, star2, star3, star4, star5]
          }]
        }); // end of containerCardColumnChart Highcharts

        Highcharts.chart('containerCardPieChart', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            options3d: {
              enabled: true,
              alpha: 0
            }
          },

          title: {text: ''},
          subtitle: {text: ''},
          credits: {enabled: false},
          tooltip: {pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'},
          accessibility: {
            point: {valueSuffix: '%'}
          },

          colors: ['#f44336', '#ff9800', '#00bcd4', '#2196F3', '#4CAF50'],

          plotOptions: {
            pie: {
              depth: 45,
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false,
                // format: '{series.name}: </b>{point.percentage:.2f}%</b>',
              },
              showInLegend: true
            },
            series: {
              colorByPoint: true,
              dataLabels: {
                enabled: true,
                formatter: function() {
                  return Math.round(this.percentage*100)/100 + ' %';
                },
                distance: -30,
                color:'black'
              }
            }
          },

          series: [{
            name: 'Feedback',
            colorByPoint: true,
            data: [{
              name: '1 Star',
              y: star1,
            }, {
              name: '2 Star',
              y: star2,
              // sliced: true,
              // selected: true
            }, {
              name: '3 Star',
              y: star3,
            }, {
              name: '4 Star',
              y: star4,
            }, {
              name: '5 Star',
              y: star5,
            }]
          }]
        }); // end of containerCardPieChart Highcharts
      }
    } // end of callGraph function

    // Downloading Feedback list in csv file
    $('#downloadFeedback').on('click', function() {
      $.ajax({
        url    : '<?php echo base_url('feedback/downloadFeedbackCsvFile'); ?>',
        method : 'POST',
        data   : '',
        xhrFields : {
          responseType : 'blob'
        },

        success: function (data) {
          var a      = document.createElement('a');
          var url    = window.URL.createObjectURL(data);
          a.href     = url;
          a.download = 'feedback-<?Php echo date('d-m-y'); ?>'+'.csv';
          a.click();
          window.URL.revokeObjectURL(url);
        }
      });
    }); // end of downloadind feedback

    $('#upload-file-selector').change( function(){
      $('#loader').addClass('hidden');
      var form = $('#bulk_upload_csv').get(0);                      
      $.ajax({
        url        : "<?php echo base_url('feedback/ajax_bulk_upload_feedback/');?>",
        type       : "POST",
        data       : new FormData(form),
        cache      : false,
        contentType: false,
        processData: false,

        beforeSend: function() {
          $('#loader').addClass('loading');
        },

        success: function(result) {
          try {
            // alert(result);
            var response = JSON.parse(result);
            // alert(response.status);
            if (response.status == 1) {
              $('#bulk_u_msg').html(response.msg);
              $('#Modal_Bulkupload').modal('show');
            }
            else {
              $('#bulk_u_err').html(response.msg);
              $('#Modal_BulkuploadError').modal('show');
            }
          }
          catch (e) {
            console.log(result);
          }
          $('#loader').removeClass('loading');
        }
      });
    }); // end of Uploading selected file

  });

  // Showing Details on pop up
  function callDetails(e) {
    var id = $(e).data('id');

    var result = triggerAjax("<?php echo base_url('feedback/getFeedbackDetails/'); ?>"+id);
    // console.log(result);

    if (result.status == 200) {
      // Bootstrap Model
      $('#model_Details_Header').html('Feedback Details');
      $('#model_Details_msg').html(result.description);
      $('#modal_Details').modal('show');
    }
  }
</script>