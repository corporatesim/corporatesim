
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <!-- show games here if available -->
    <div class="row">
      <?php if(count($gameData)>0){
        foreach ($gameData as $gameDataRow){ ?>
          <div class="col-md-3">
            <div class="card" style="width: 18rem;">
              <img class="card-img-top" src="<?php echo base_url('../images/'.($gameDataRow->Game_Image?$gameDataRow->Game_Image:'Game2.jpg'));?>" alt="Card image cap">
              <div class="card-body">
                <!-- <h5 class="card-title"><?php echo $gameDataRow->Game_Name; ?></h5> -->
                <!-- <p class="card-text"><?php echo count($gameData);?> Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                <p class="card-text">
                  <?php echo $gameDataRow->Game_Name; ?>
                </p>
                <!-- <a href="javascript:void(0);" class="btn btn-primary">Allocate/De-Allocate</a> -->
              </div>
            </div>
          </div>
        <?php } } else { ?>
          <!-- if don't have any games assigened yet -->
          <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?php echo base_url('common/Logo'.'/'.$profilePic);?>" alt="Simulation Games">
            <div class="card-body">
              <p class="card-text">No game allocated. Pleaes contact admin.</p>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="clearfix"><br></div>
