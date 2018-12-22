<!-- <?php //echo "<pre>"; print_r($header); exit;?>  -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/outcomeBadges/linkdel/";
     var loc_url_stat = "ux-admin/outcomeBadges/linkstat/";
  //-->
</script>
<style>

@media screen and ( min-width: '361px' ){
  .resp_pull_right{
    float: right;
  }
}

@media screen and ( max-width: '360px' ){
  .resp_pull_right{
    float     : none;
    text-align: center;
    width     : 100%;
    padding   : 0 15px;
  }
}

#update-file-selector {
  display:none;
}
</style>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo 'Add '.$header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="<?php echo site_root."ux-admin/outcomeBadges"; ?>">Manage Outcome Badges</a></li>
      <li class="active"><?php echo $header; ?></li>
    </ul>
  </div>
</div>
<!-- DISPLAY ERROR MESSAGE -->
<?php  if(!empty($tr_msg)) { ?>
  <div class="alert-success alert"><?php echo $tr_msg; ?></div>
<?php } ?>
<?php  if(!empty($er_msg)) { ?>
  <div class="alert-success alert"><?php echo $er_msg; ?></div>
<?php } ?>
<!-- DISPLAY ERROR MESSAGE END -->
<style>
span.alert-danger {
  background-color: #ffffff;
  font-size       : 18px;
}
</style>
<div id="container">
  <form action="" method="post" id="Outcome_badges" name="Outcome_badges" enctype="multipart/form-data">
    <div class="form-group col-md-6">
      <label for="Select File"><span class="alert-danger">*</span>Upoload File</label>
      <input type="file" name="image" multiple="multiple" accept="image/*" id="image" class="form-control" value="" required="">
    </div>
    <div class="form-group col-md-6">
      <label for="ShortName"><span class="alert-danger">*</span>Short Name</label>
      <input type="text" name="shortname" value="" class="form-control" required="">
    </div>
    <div class="form-group">
      <label for="Description"><span class="alert-danger">*</span>Description</label>
      <textarea class="form-control rounded-0" name="description" id="desc" rows="3" required=""></textarea>
    </div>
    <div class="form-group">
      <label for="Value"><span class="alert-danger">*</span>Select Value</label>
    </div>
      <div class="row col-md-6" id="FixValue">
        <input type="radio" name="rangeVal" id="FixValue" value="fixvalue" >
        <label for="Value">Fix Value</label>
         <div class="row hidden " id="fixVal">
          <div class="col-md-3" id="FixValDiv">
           <label for="Fix Value"><span class="alert-danger">*</span>Value</label>
           <input type="number" name="fixvalue" class="fixvalue" value="" required="">
         </div>
        </div>
      </div>
      <div class="row col-md-6" id="RangeValue">
        <input type="radio" name="rangeVal"  id="RangeValue" value="RangeValue">
        <label for="Value">Range</label>
        <div class="row hidden" id="RangeVal">
         <div class="col-md-3" id="minValDiv">
          <label for="Minimum Value"><span class="alert-danger">*</span>Min</label>
          <input type="text" id="minVal" name="minVal[]" class="form-control" placeholder="Min Val" required="">
        </div>
        <div class="col-md-3" id="maxValDiv">
          <label for="Maximum Value"><span class="alert-danger">*</span>Max</label>
          <input type="text" id="" name="maxVal[]" class="form-control" placeholder="Max Val" required="">
        </div>
      </div>
    </div>
  
  <div class="clearfix"></div>  <br><br>

  <div class="row" id="sandbox-container" style="margin-left: 25%">
    <div class="col-md-3 text-center">
      <button type="submit" class="btn btn-primary btn-lg btn-block" name="addBadges" value="addBadges" id="addBadges">SAVE</button>
    </div>
    <div class="col-md-3 text-center">
      <a href="<?php echo site_root."ux-admin/outcomeBadges"; ?>" class="btn btn-primary btn-lg btn-block">CANCEL</a>
    </div>
  </div>
</div>
</form>

<script type="text/javascript">
  $(document).ready(function() {

   $('input[type=radio]').on('change',function(){
        //alert($(this).val());
        if($(this).attr('id') == 'FixValue' || $(this).attr('id') == 'RangeValue')
        {
          if($(this).val() == 'RangeValue')
          {
             $('#RangeVal').removeClass('hidden');
            $('#fixVal').addClass('hidden');
          }
          else
          {
            $('#RangeVal').addClass('hidden');
            $('#fixVal').removeClass('hidden');
          }
        }
      });

   $('#RangeValue').on('click',function(){
    if($(this).is(':checked'))
    {
      $(this).attr('value',1);
    }
    else
    {
      $(this).attr('value',0);
    }
  });

   $('#FixValue').on('click',function(){
     if($(this).is(':checked'))
     {
      $(this).attr('value',1);
    }
    else
    {
      $(this).attr('value',0);
    }
  });

  });
</script>