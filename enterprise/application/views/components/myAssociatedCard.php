  <div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg'); ?>
      <div class="min-height-200px">
        <div class="page-header">

          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="title">
                <h1>My Cards</h1>
              </div>
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">My Cards</li>
                </ol>
              </nav>
            </div>  
          </div>

          <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix">

              <div class="col-md-6 pull-left text-left">
                Selected Cards are listed below:-
              </div>
              <div class="col-md-6"></div>
            </div>
            <br />
            <?php
            if(count($assignCards) < 1){ ?>
              <marquee behavior="alternate" direction="">
                <div class="col-md-10 col-xs-12 row text-center alert-danger">No Cards Assigned</div>
              </marquee>
              <br />
              <div class="row" id="labelNames">
                <div class="col-md-12 text-center">
                  <a href="<?php echo base_url('Dashboard/');?>" class="btn btn-outline-danger">CLOSE</a>
                </div>
              </div>
            <?php } else{ ?>
                <form action="associateCardsWithEnterprise" method="POST" enctype="multipart/form-data">

                  <div class="row justify-content">
                  <?php foreach($assignCards as $cards){ ?>
                    <div class="form-group" id="addCards<?php echo $cards->Game_ID; ?>">
                      <div class="col-sm-3 my-2">

                        <div class="card" style="width: 17rem;">
                          <img src="<?php echo base_url('../images/'.($cards->Game_Image ? $cards->Game_Image : 'Game2.jpg'));?>" class="card-img-top" alt="Simulation Game" style="max-height: 164px;">
                          <div class="card-body" style="min-height: 60px; max-height: 100px;">
                            <h5 class="card-title"><?php echo $cards->Game_Name; ?>
                            </h5>
                            <h6 class="card-subtitle mb-2"><code><?php echo $cards->Game_Category; ?></code></h6>
                          </div>
                        </div>

                      </div>
                    </div>
                  <?php } ?>
                  </div>

                  <div class="clearfix"></div>
              </form>
            <?php } ?>
          </div>
          <div class="clearfix"></div>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#select_all').click(function(i,e){
        if($(this).is(':checked'))
        {
          $('input[type=checkbox]').each(function(i,e){
            $(this).prop('checked',true);
          });
        }
        else
        {
          $('input[type=checkbox]').each(function(i,e){
            $(this).prop('checked',false);
          });
        }
      });
    });
  </script>