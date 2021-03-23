<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Select Cards</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cards Allocation/Deallocation</li>
              </ol>
            </nav>
          </div>  
        </div>

        <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          <div class="clearfix">

            <div class="col-md-6 pull-left text-left d-none">
              All Assigned Cards are listed below:-
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-2 custom-control custom-checkbox pull-right">
              <input type="checkbox" class="custom-control-input" value="" id="select_all" name="select_all">
              <label class="custom-control-label" for="select_all">Select All</label>
            </div>
            
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
              <!-- <div class="row" id="labelNames">
                <div class="col-md-4">
                  <label for="name"><span class="alert-danger">*</span>Select Cards</label>
                </div>
              </div> -->
              <form action="associateCardsWithEnterprise" method="POST" enctype="multipart/form-data">

                <div class="row justify-content">
                <?php foreach($assignCards as $cards){ ?>
                  <div class="form-group" id="addCards<?php echo $cards->Game_ID; ?>">
                    <?php
                      if($cards->EC_Enterprise_Selected == 1){
                        $checked = 'checked';
                      }
                      else{
                         $checked = ' ';
                      }
                    ?>
                    <div class="col-sm-3 my-2">

                      <div class="card <?php if($cards->EC_Enterprise_Selected == '1'){ echo 'bg-secondary'; } ?>" style="width: 17rem;">
                        <img src="<?php echo base_url('../images/'.($cards->Game_Image ? $cards->Game_Image : 'Game2.jpg'));?>" class="card-img-top" alt="Simulation Game" style="height: 150px;">
                        <div class="card-body">
                          <h5 class="card-title <?php if($cards->EC_Enterprise_Selected == '1'){ echo 'text-white'; } ?>"><?php echo $cards->Game_Name; ?>
                            <!-- bootstrap checkbox -->
                            <div class="custom-control custom-checkbox pull-right">
                              <input type="checkbox" class="custom-control-input" value="<?php echo $cards->Game_ID; ?>" id="<?php echo $cards->Game_ID; ?>" name="assigncards[]" <?php echo $checked; ?> >
                              <label class="custom-control-label" for="<?php echo $cards->Game_ID; ?>"></label>
                            </div>
                          </h5>
                          <h6 class="card-subtitle mb-2">
                            <?php if(!empty($cards->Game_Category)){ echo $cards->EC_Enterprise_Selected == '1' ? "<mark>$cards->Game_Category</mark>" : "<code>$cards->Game_Category</code>"; } ?>
                            <!-- Showing Card Details on popup -->
                            <a href="javascript:void(0);" data-toggle="tooltip" title="Card Details" class="pull-right showCardDetails" data-gamedata="<?php echo base64_encode($cards->Game_ID); ?>">
                              <i class="fa fa-info-circle text-info"></i>
                            </a>
                          </h6>
                        </div>
                      </div>

                    </div>
                  </div>
                <?php } ?>
                </div>

                <div class="clearfix"></div>
                <br><br>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="submit" value="submit" id="submit">SUBMIT</button>&nbsp;&nbsp;
                  <a href="<?php echo base_url('Dashboard/');?>" class="btn btn-outline-danger">CANCEL</a>
              </div>
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

