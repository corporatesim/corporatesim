<!-- <?php  // echo "<pre>"; print_r($gameFeedback); exit(); ?> -->
  <div class="main-container">
    <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg'); ?>

        <div class="row clearfix">
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
