  <div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
      <?php $this->load->view('components/trErMsg'); ?>
      <div class="min-height-200px">
        <div class="page-header">

          <div class="row">
            <div class="col-md-6 col-sm-12">
              <div class="title">
                <h1>All Available Cards</h1>
              </div>
              <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Cards Allocation/Deallocation</li>
                  <li class="breadcrumb-item active" aria-current="page">
                    <?php 
                      if($type && !empty($assignCardsEnterprise)){
                        echo "Enterprise : $assignCardsEnterprise";
                      }
                    ?>
                  </li>
                </ol>
              </nav>
            </div>  
          </div>

          <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
            <div class="clearfix">

              <div class="col-md-6 pull-left text-left">
                All Available Cards are listed below:-
              </div>
              <div class="col-md-4"></div>
              <div class="col-md-2 custom-control custom-checkbox pull-right">
                <input type="checkbox" class="custom-control-input" value="" id="select_all" name="select_all">
                <label class="custom-control-label" for="select_all">Select All</label>
              </div>
              <!-- <div class="col-md-6 pull-right text-right">
                <input type="checkbox" name="select_all" id="select_all">
                <label for="name"> Select All</label>
              </div> -->
            </div>
            <br />
            <?php
            if(count($assignCards) < 1){ ?>
              <marquee behavior="alternate" direction="">
                <div class="col-md-10 col-xs-12 row text-center alert-danger">No Cards Assign</div>
              </marquee>
              <br />
              <div class="row" id="labelNames">
                <div class="col-md-12 text-center">
                  <a href="<?php echo base_url('Enterprise/');?>" class="btn btn-outline-danger">CLOSE</a>
                </div>
              </div>
            <?php } else{ ?>
                <div class="row" id="labelNames">
                  <div class="col-md-4">
                    <label for="name"><span class="alert-danger">*</span>Select Cards</label>
                  </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                  <div class="row justify-content">
                  <?php foreach($assignCards as $cards){ ?>
                    <div class="form-group" id="addCards<?php echo $cards->Game_ID; ?>">
                      <?php
                        if($cards->Game_ID == $cards->EC_GameID){
                          $checked = 'checked';
                        }
                        else{
                           $checked = ' ';
                        }
                      ?>
                      <div class="col-sm-3 my-2">
                        <!-- <?php //if($checked == 'checked'){ echo 'style="bborder:5px solid green;"'; } ?> -->
                        <!-- <?php //if($checked == 'checked'){ echo 'text-white bg-success'; } ?> -->
                        <div class="card <?php if($cards->EC_Enterprise_Selected == '1'){ echo 'bg-secondary'; } ?>" style="width: 17rem;">
                          <img src="<?php echo base_url('../images/'.($cards->Game_Image ? $cards->Game_Image : 'Game2.jpg'));?>" class="card-img-top" alt="Simulation Game" style="max-height: 164px;">
                          <div class="card-body" <?php if($checked == 'checked'){ echo 'style="border:5px solid #A5ABA6;"'; } ?> style="min-height: 60px; max-height: 94px;">
                            <h5 class="card-title <?php if($cards->EC_Enterprise_Selected == '1'){ echo 'text-white'; } ?>"><?php echo $cards->Game_Name; ?>
                              <!-- bootstrap checkbox -->
                              <div class="custom-control custom-checkbox pull-right">
                                <input type="checkbox" class="custom-control-input" value="<?php echo $cards->Game_ID; ?>" id="<?php echo $cards->Game_ID; ?>" name="assigncards[]" <?php echo $checked; ?> >
                                <label class="custom-control-label" for="<?php echo $cards->Game_ID; ?>"></label>
                              </div>
                            </h5>
                            <h6 class="card-subtitle mb-2"><?php if(!empty($cards->Game_Category)){ echo $cards->EC_Enterprise_Selected == '1' ? "<mark>$cards->Game_Category</mark>" : "<code>$cards->Game_Category</code>"; } ?></h6>
                          </div>
                        </div>

                      </div>
                    </div>
                    <input type="hidden" name="cardEnterpriseSelectedID[]" value="<?php echo $cards->EC_Enterprise_Selected != NULL ? $cards->EC_Enterprise_Selected : 0; ?>" >
                  <?php } ?>
                  </div>

                  <div class="clearfix"></div>
                  <br><br>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submit" value="submit" id="submit">SUBMIT</button>&nbsp;&nbsp;
                    <?php if($type=='Enterprise'){ ?>
                      <a href="<?php echo base_url('Enterprise/');?>" class="btn btn-outline-danger">CANCEL</a>
                    <?php } ?>       
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

