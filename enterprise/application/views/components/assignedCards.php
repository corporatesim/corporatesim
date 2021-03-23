<!-- <?php echo "<pre>"; print_r($gameData); ?> -->
  <div class="main-container">
    <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg'); ?>
      <!-- show games here if available -->
      <div class="row">
        <?php if (count($gameData)>0) {
          foreach ($gameData as $gameDataRow) { ?>
            <div class="col-md-3 px-2 py-3 d-flex align-items-stretch">
              <!-- <div class="card" style="width: 15rem;"> -->
              <div class="card">
                <img class="card-img-top" src="<?php echo base_url('../images/'.($gameDataRow->Game_Image ? $gameDataRow->Game_Image : 'Game2.jpg')); ?>" alt="Simulation Game" style="height: 9rem;">
                <div class="card-body">
                  <!-- <h5 class="card-title"><?php echo $gameDataRow->Game_Name; ?></h5> -->
                  <!-- <p class="card-text"><?php echo count($gameData); ?></p> -->
                  <p class="card-text">
                    <h5>
                      <?php if ($this->session->userdata('loginData')['User_Role'] == 1) { ?>
                        <span data-toggle="tooltip" title="From: <?php echo date('d-m-Y',strtotime($gameDataRow->EG_Game_Start_Date)); ?> To: <?php echo date('d-m-Y', strtotime($gameDataRow->EG_Game_End_Date)); ?>" data-startdate="<?php echo strtotime($gameDataRow->EG_Game_Start_Date); ?>" data-enddate="<?php echo strtotime($gameDataRow->EG_Game_End_Date); ?>">
                        <?php } else { ?>
                          <span data-toggle="tooltip" title="From: <?php echo date('d-m-Y',strtotime($gameDataRow->SG_Game_Start_Date)); ?> To: <?php echo date('d-m-Y', strtotime($gameDataRow->SG_Game_End_Date)); ?>" data-startdate="<?php echo strtotime($gameDataRow->SG_Game_Start_Date); ?>" data-enddate="<?php echo strtotime($gameDataRow->SG_Game_End_Date); ?>">
                          <?php } ?>
                          <?php echo $gameDataRow->Game_Name; ?>
                        </span>

                        <?php if ($this->session->userdata('loginData')['User_Role'] == 'superadmin') { ?>
                          <!-- Allocate/De-Allocate -->
                          <a href="javascript:void(0);" data-toggle="tooltip" title="Allocate/De-Allocate" class="pull-right allocateDeallocate" data-gamedata="<?php echo base64_encode($gameDataRow->Game_ID.','.$gameDataRow->Game_Name);?>" data-gamedata="<?php echo base64_encode($gameDataRow->Game_ID.','.$gameDataRow->Game_Name); ?>"><i class="fa fa-tasks"></i></a>
                        <?php } ?>

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
          <?php } } else { ?>
            <!-- if don't have any games assigened yet -->
            <div class="card" style="width: 18rem;">
              <img class="card-img-top" src="<?php echo base_url('common/Logo'.'/'.$profilePic);?>" alt="Simulation Games">
              <div class="card-body">
                <p class="card-text">No game allocated. Please contact admin.</p>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="clearfix"><br></div>
