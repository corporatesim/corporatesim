<!-- <?php  // echo "<pre>"; print_r($gameFeedback); exit(); ?> -->
  <div class="main-container">
    <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg'); ?>
      <div class="row clearfix progress-box">

        <!-- total enterprise -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30 d-none">
          <a href="<?php echo base_url('Enterprise'); ?>">
            <div class="card border-success mb-3" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-success"><b>Total Enterprize</b></div>
              <div class="card-body text-success">
                <!-- <h5 class="card-title"></h5> -->
                <div class="project-info clearfix">
                  <div class="project-info-left">
                    <div class="icon box-shadow bg-blue text-white">
                      <i class="fa fa-institution"></i>
                    </div>
                  </div>
                  <div class="project-info-right">
                    <span class="no text-blue weight-500 font-24"><?php echo $totalEnterprise; ?></span>
                    <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
            </div>
          </a>
        </div>

        <!-- Enterprise users -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30 d-none">
          <a href="<?php echo base_url('Users/EnterpriseUsers'); ?>">
            <div class="card border-success mb-3" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-success"><b>Total Enterprize Users</b></div>
              <div class="card-body text-success">
                <div class="project-info clearfix">
                  <div class="project-info-left">
                    <div class="icon box-shadow bg-light-green text-white">
                      <i class="fa fa-users"></i>
                    </div>
                  </div>
                  <div class="project-info-right">
                    <span class="no text-light-green weight-500 font-24"><?php echo $totalEnterpriseUsers; ?></span>
                    <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
            </div>
          </a>
        </div>

        <!-- total subenterprise -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30 d-none">
          <a href="<?php echo base_url('SubEnterprise'); ?>">
            <div class="card border-success mb-3" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-success"><b>Total Sub Enterprize</b></div>
              <div class="card-body text-success">
                <div class="project-info clearfix">
                  <div class="project-info-left">
                    <div class="icon box-shadow bg-light-orange text-white">
                      <i class="fa fa-building"></i>
                    </div>
                  </div>
                  <div class="project-info-right">
                    <span class="no text-light-orange weight-500 font-24"><?php echo $totalSubEnterprise; ?></span>
                    <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
            </div>
          </a>
        </div>

        <!-- subenterprise users -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30 d-none">
          <a href="<?php echo base_url('Users/SubEnterpriseUsers'); ?>">
            <div class="card border-success mb-3" style="max-width: 18rem;">
              <div class="card-header bg-transparent border-success"><b>Total Sub Enterprize Users</b></div>
              <div class="card-body text-success">
                <div class="project-info clearfix">
                  <div class="project-info-left">
                    <div class="icon box-shadow bg-light-purple text-white">
                      <i class="fa fa-user-circle-o"></i>
                    </div>
                  </div>
                  <div class="project-info-right">
                    <span class="no text-light-purple weight-500 font-24"><?php echo $totalSubEnterpriseUsers; ?></span>
                    <!-- <p class="weight-400 font-18">Projects Complete</p> -->
                  </div>
                </div>
              </div>
              <!-- <div class="card-footer bg-transparent border-success">Footer</div> -->
            </div>
          </a>
        </div>

      </div>

      <!-- loading games here -->
      <!-- <marquee behavior="" direction="" onmouseover="this.stop();" onmouseout="this.start();">
        <h2 class="text-green">
          Available <img src="<?php echo base_url('common/images/giphy_remote.gif'); ?>" alt="Game Allocation/De-allocation" style="height: 70px; width: 20%;"> Games
        </h2>
      </marquee> -->
      <div class="clearfix"><br></div>

      <div class="row">
        <?php foreach ($gameData as $gameDataRow) { ?>
          <div class="col-md-3 px-2 py-3 d-flex align-items-stretch">
            <!-- <div class="card" style="width: 15rem;"> -->
            <div class="card">
              <img class="card-img-top" src="<?php echo base_url('../images/'.($gameDataRow->Game_Image ? $gameDataRow->Game_Image : 'Game2.jpg')); ?>" alt="Simulation Game" style="height: 9rem;">
              <div class="card-body">
                <!-- <h5 class="card-title"><?php echo $gameDataRow->Game_Name; ?></h5> -->
                <!-- <p class="card-text"><?php echo count($gameData); ?></p> -->
                <p class="card-text">
                  <h5>
                    <?php echo $gameDataRow->Game_Name; ?>
                    <a href="javascript:void(0);" data-gamedata="<?php echo base64_encode($gameDataRow->Game_ID.','.$gameDataRow->Game_Name); ?>" data-toggle="tooltip" title="Allocate/De-Allocate" class="pull-right allocateDeallocate"><i class="fa fa-tasks "></i></a>
                  </h5>
                  <?php if (!empty($gameDataRow->Game_Category)) {
                    echo "<code>$gameDataRow->Game_Category</code>";
                  } ?>
                  <!-- <?php if ($gameDataRow->Game_Elearning > 0) { ?>
                    <h5>(eLearning)</h5>
                    <?php } ?> -->
                  </p>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- end of loading games -->

        <br>
        <div class="row clearfix d-none">
          <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
              <h4 class="mb-30">Devices Managed</h4>
              <div class="device-manage-progress-chart">
                <ul>
                  <li class="clearfix">
                    <div class="device-name">Window</div>
                    <div class="device-progress">
                      <div class="progress">
                        <div class="progress-bar window border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                        </div>
                      </div>
                    </div>
                    <div class="device-total">60</div>
                  </li>
                  <li class="clearfix">
                    <div class="device-name">Mac</div>
                    <div class="device-progress">
                      <div class="progress">
                        <div class="progress-bar mac border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 20%;">
                        </div>
                      </div>
                    </div>
                    <div class="device-total">20</div>
                  </li>
                  <li class="clearfix">
                    <div class="device-name">Android</div>
                    <div class="device-progress">
                      <div class="progress">
                        <div class="progress-bar android border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                        </div>
                      </div>
                    </div>
                    <div class="device-total">30</div>
                  </li>
                  <li class="clearfix">
                    <div class="device-name">Linux</div>
                    <div class="device-progress">
                      <div class="progress">
                        <div class="progress-bar linux border-radius-8" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 10%;">
                        </div>
                      </div>
                    </div>
                    <div class="device-total">10</div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
              <h4 class="mb-30">Device Usage</h4>
              <div class="clearfix device-usage-chart">
                <div class="width-50-p pull-left">
                  <div id="device-usage" style="min-width: 180px; height: 200px; margin: 0 auto"></div>
                </div>
                <div class="width-50-p pull-left">
                  <table style="width: 100%;">
                    <thead>
                      <tr>
                        <th class="weight-500"><p>Device</p></th>
                        <th class="text-right weight-500"><p>Usage</p></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-yellow"></i> IE</p></td>
                        <td class="text-right weight-400">10%</td>
                      </tr>
                      <tr>
                        <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-green"></i> Chrome</p></td>
                        <td class="text-right weight-400">40%</td>
                      </tr>
                      <tr>
                        <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-orange-50"></i> Firefox</p></td>
                        <td class="text-right weight-400">30%</td>
                      </tr>
                      <tr>
                        <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-blue-50"></i> Safari</p></td>
                        <td class="text-right weight-400">10%</td>
                      </tr>
                      <tr>
                        <td width="70%"><p class="weight-500 mb-5"><i class="fa fa-square text-red-50"></i> Opera</p></td>
                        <td class="text-right weight-400">10%</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
              <h4 class="mb-30">Profile Completion</h4>
              <div class="clearfix device-usage-chart">
                <div class="width-50-p pull-left">
                  <div id="ram" style="min-width: 160px; max-width: 180px; height: 200px; margin: 0 auto"></div>
                </div>
                <div class="width-50-p pull-left">
                  <div id="cpu" style="min-width: 160px; max-width: 180px; height: 200px; margin: 0 auto"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix d-none">
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
              <div class="pb-30">
                <h4 class="float-left">Recent Feedbacks</h4>
                <h4 class="float-right">

                  <!-- <a href="javascript:void(0);" data-toggle="tooltip" title="Download Feedback" onclick="downloadFeedbacks()">
                    <i class="fa fa-download fa-2x"></i>
                  </a> -->

                  <a href="javascript:void(0)" id="downloadFeedback" data-toggle="tooltip" title="Download Feedback">
                    <i class="fa fa-download fa-2x"></i>
                  </a>

                </h4>
              </div>
              <div class="notification-list mx-h-450 customscroll pt-20">
                <ul>

                  <?php if(count($gameFeedback) > 0){ 
                    foreach($gameFeedback as $gameFeedbackRow){
                      $Feedback_userData = json_decode($gameFeedbackRow->Feedback_userData);
                      $pic = ($Feedback_userData->ProfilePic)?$Feedback_userData->ProfilePic:'avatar.png';
                      ?>
                      <li class="showFeedback">
                        <a href="#" data-toggle="tooltip" title="<?php echo $gameFeedbackRow->Feedback_message;?>">
                          <img src="<?php echo base_url('../images/userProfile/'.$pic);?>" alt="User Profile Pic" data-username="<?php echo $Feedback_userData->fullName?>" data-useremail="<?php echo $Feedback_userData->Email?>" data-userid="<?php echo $gameFeedbackRow->Feedback_userid?>" data-feedbacktitle="<?php echo $gameFeedbackRow->Feedback_title; ?>" data-feedbackmessage="<?php echo $gameFeedbackRow->Feedback_message; ?>">
                          <h3 class="clearfix"><?php echo $Feedback_userData->fullName.' ('.$gameFeedbackRow->Feedback_userid.'):- '.$Feedback_userData->Email; ?> <span class="text-blue"><?php echo date('d-M-y H:i',strtotime($gameFeedbackRow->Feedback_createdOn)) ?></span></h3>
                          <p><?php echo $gameFeedbackRow->Feedback_title;?></p>
                        </a>
                      </li>
                    <?php } } else{ ?>

                      <li>
                        Currently no feedback available
                      <!-- <a href="#" data-toggle="tooltip" title="Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...">
                        <img src="<?php echo base_url('common/vendors/images/img.jpg');?>" alt="User Profile Pic">
                        <h3 class="clearfix">No User <span>3 mins ago</span></h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed...</p>
                      </a> -->
                    </li>
                  <?php } ?>

                </ul>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-30">
            <div class="bg-white pd-20 box-shadow border-radius-5 height-100-p">
              <h4 class="mb-30">Data Creation</h4>
              <div class="customscroll">
                <canvas id="barChart" width="400" height="400"></canvas>
              </div>
            </div>
          </div>
        </div>

<script>
$(document).ready(function(){
  // #randomModal
  $('.showFeedback').each(function(){
    $(this).on('click',function(){
      var imgTag          = $(this).find('img');
      var username        = imgTag.data('username');
      var useremail       = imgTag.data('useremail');
      var userid          = imgTag.data('userid');
      var feedbacktitle   = imgTag.data('feedbacktitle');
      var feedbackmessage = imgTag.data('feedbackmessage');
      var imgSrc          = imgTag.attr('src');
      var data            = "<img src='"+imgSrc+"'> <div class='row text-blue'><b class='text-dark'>Title:-</b>&nbsp;"+feedbacktitle+"</div><div class='row text-blue'><b class='text-dark'>Message:-</b>&nbsp;"+feedbackmessage+"</div><div class='row text-blue'><b class='text-dark'>Name:-</b>&nbsp;"+username+"</div><div class='row text-blue'><b class='text-dark'>User Email:-</b>&nbsp; <a class='text-danger' href='mailto:"+useremail+"'>"+useremail+"</a></div><div class='row text-blue'><b class='text-dark'>User ID:-</b>&nbsp;"+userid+"</div>";
      $('#randomModal').modal('show');
      var modalTitle = $('#randomModal').find('.modal-title').text('Feedback');
      var modalBody  = $('#randomModal').find('.modal-body');
      modalBody.html(data);
      modalBody.css({'margin-left':'15%'});
    });
  });

  // for chartJs graphs
  var ctx = $('#barChart');
  var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php echo implode(',',$years)?>],
      datasets: [
      <?php
      for($i=0; $i<count($chartData); $i++)
      {
        echo "{label: '".$chartData[$i][0]->Title."',";
        $dataCount            = '';
        $fetchBackgroundColor = '';
        $fetchBorderColor     = '';

        for($j=0; $j<count($chartData[$i]); $j++)
        {
          // to check that this contains data for that year or not, if not then append 0
          $dataCount            .= $chartData[$i][$j]->Count.',';
          $fetchBackgroundColor .= "'".$backgroundColor[$i]."',";
          $fetchBorderColor     .= "'".$borderColor[$i]."',";
        }
        echo "data: [".trim($dataCount,',')."],";
        echo "backgroundColor: [".trim($fetchBackgroundColor,',')."],";
        echo "borderColor: [".trim($fetchBorderColor,',')."],";
        echo "borderWidth: 1 },";
      }
      ?>
      // label: 'Game',
      // data: [12, 19, 3, 5, 2, 3],
      // backgroundColor: [
      // 'rgba(255, 99, 132, 0.2)',
      // ],
      // borderColor: [
      // 'rgba(255, 99, 132, 1)',
      // ],
      ]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

  // this is Downloading process in csv file via trigger ajax
  $('#downloadFeedback').on('click', function() {
    $.ajax({
      url    : '<?php echo base_url('AjaxNew/downloadFeedbackCsvFile');?>',
      method : 'POST',
      data   : '',
      xhrFields : {
        responseType : 'blob'
      },

      success: function (data){
        var a      = document.createElement('a');
        var url    = window.URL.createObjectURL(data);
        a.href     = url;
        a.download = 'feedback-<?Php echo date('d-m-y'); ?>'+'.csv';
        a.click();
        window.URL.revokeObjectURL(url);
      }
    });
  });//end of downloadind .csv file process
});

  // function downloadFeedbacks() {
  //   // trigger ajax to get the all Feedbacks data
  //   $.ajax({
  //     url : "<?php //echo base_url('Ajax/downloadReport/');?>"+user_id+'/'+formula_selected+'/'+enterprise_ID,
  //     type: "POST",
  //     data: '',

  //     success:function(result) {
  //       var result = JSON.parse(result);
  //       // console.log(result);
        
  //       if (result.status == 200) { 

  //       }
  //     }
  //   });
  // }
</script>
