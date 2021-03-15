<div class="row m-1" style="margin-top: 48px!important;">
  <?php $this->load->view('components/trErAlert'); ?>
  <div class="card m-1 col-md-3" style="background-color: #fff8dc">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="<?php echo base_url('../images/');
                  echo ($gameResult->Game_Image) ? $gameResult->Game_Image : 'Game2.jpg'; ?>" class="card-img" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?php echo $gameResult->Game_Name; ?></h5>
          <p class="card-text"><?php echo $gameResult->Game_Comments; ?></p>
          <p class="card-text">
            <!-- if user is allowed to play games within UG_GameStartDate and UG_GameEndDate-->
            <?php if (time() > strtotime($gameResult->UG_GameStartDate) && time() < strtotime($gameResult->UG_GameEndDate)) { ?>
              <!-- check if user has completed (US_LinkID == 1)) the simulation-->
              <?php if ($gameResult->US_LinkID == 1) { ?>

                <?php if ($gameResult->UG_ReplayCount > 0 || $gameResult->UG_ReplayCount < 0 || $this->session->userdata('botUserData')->User_companyid == 21) { ?>
                  <!-- it means user belongs to humanlink or has some or unlimited replay access to play the simulation -->
                  <a href="javascript:void(0);" data-toggle="tooltip" title="Simulation Result" id="showLeaderboard">
                    <img src="<?php echo base_url('../images/leaderboard.png'); ?>" alt="Simulation Result" width="80" height="80">
                  </a>

                  <a href="javascript:void(0);" class="replaySimulation" data-imageurl="<?php echo base_url('../images/');
                                                                                        echo ($gameResult->Game_Image) ? $gameResult->Game_Image : 'Game2.jpg'; ?>" data-gameid="<?php echo $gameResult->Game_ID; ?>" data-toggle="tooltip" title="Replay ">
                    <img src="<?php echo base_url('../images/replay.png'); ?>" alt="Replay" width="80" height="80">
                  </a>

                <?php } else { ?>
                  <!-- user has completed the simulation and don't have the replay option -->
                  <a href="javascript:void(0);" data-toggle="tooltip" title="Simulation Result" id="showLeaderboard">
                    <img src="<?php echo base_url('../images/leaderboard.png'); ?>" alt="Simulation Result" width="80" height="80">
                  </a>
                <?php } ?>

              <?php } else { ?>
                <!-- further check that user has sumitted the o/p page or not -->

                <?php if ($gameResult->US_Output == 1) { ?>
                  <!-- It means user has not submitted the o/p page, still in o/p page -->
                  <a href="<?php echo base_url('PlaySimulation/output/' . base64_encode($gameResult->Game_ID)); ?>" data-toggle="tooltip" title="Submit O/P to complete"><img src="<?php echo base_url('../images/play1.png'); ?>" alt="Submit O/P to complete" width="80" height="80"></a>

                <?php } else { ?>
                  <!-- this means user has not started the simulation till now -->
                  <a href="<?php echo base_url('PlaySimulation/input/' . base64_encode($gameResult->Game_ID)); ?>" data-toggle="tooltip" title="Play"><img src="<?php echo base_url('../images/play1.png'); ?>" alt="Play " width="80" height="80"></a>
                <?php } ?>

              <?php }
            } else { ?>
              <!-- when user is not allowed to play games -->
              <small class="text-muted notAllowedToPlay" data-imageurl="<?php echo base_url('../images/');
                                                                        echo ($gameResult->Game_Image) ? $gameResult->Game_Image : 'Game2.jpg'; ?>" data-startdate="<?php echo date('d-m-Y', strtotime($gameResult->UG_GameStartDate)); ?>" data-enddate="<?php echo date('d-m-Y', strtotime($gameResult->UG_GameEndDate)); ?>" data-gamename="<?php echo $gameResult->Game_Name; ?>"><img src="<?php echo base_url('../images/timer.gif'); ?>" alt="Play" width="80" height="80" style="cursor: pointer;"></small>
            <?php } ?>

          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    // var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    // var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    $('#showLeaderboard').on('click', function() {
      showLeaderboard();
    });
    // showLeaderboard();
  });

  function showLeaderboard() {
    $.ajax({
      url: "<?php echo base_url('Ajax/showLeaderboard/' . $this->uri->segment(3)); ?>",
      type: 'POST',
      data: {
        [csrfName]: csrfHash
      },
      // global: false, // this is used to prevent the ajaxStart function
      success: function(result) {
        try {
          var result = JSON.parse(result);
          // updating csrf token value
          csrfHash = result.csrfHash;
          if (result.status == 200) {
            swal.fire({
              // icon             : 'success',
              title: 'Leaderboard',
              html: result.message,
              showConfirmButton: true,
              customClass: 'custom-style-alert',
              showClass: {
                popup: 'animated bounceInRight faster'
              },
              hideClass: {
                popup: 'animated lightSpeedOut faster'
              }
            });
          } else {
            swal.fire({
              icon: 'error',
              title: 'Leaderboard',
              html: result.message,
              showConfirmButton: true,
              customClass: 'custom-style-alert',
              showClass: {
                popup: 'animated bounceInRight faster'
              },
              hideClass: {
                popup: 'animated lightSpeedOut faster'
              }
            });
            console.log(result);
          }
        } catch (e) {
          swal.fire('Something went wrong. Please try later.');
          console.log(e + "\n" + result);
        }
      }
    });
  }
</script>