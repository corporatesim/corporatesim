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
</style>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo 'Edit '.$header; ?></h1>
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
    <div class="form-group col-md-4">
      <label for="Select File"><span class="alert-danger">*</span>Upoload File</label>
      <input type="file" name="image" multiple="multiple" accept="image/*" id="image" class="form-control" value="<?php echo $editResObject->Badges_ImageName?>">

    </div>
    <div class="form-group col-md-4">
      <label for="ShortName"><span class="alert-danger">*</span>Short Name</label>
      <input type="text" name="shortname" value="<?php echo $editResObject->Badges_ShortName?>" class="form-control" >
    </div>
    <div class="form-group col-md-4">
      <label for="SelectedImage"><span class="alert-danger">*</span>Current Selected Image</label><br>
      <img src="<?php echo site_root."ux-admin/upload/Badges/"?><?php echo $editResObject->Badges_ImageName?>" width=100px height=100px >
    </div>
    <div class="form-group">
      <label for="Description"><span class="alert-danger">*</span>Description</label>
      <input type=text class="form-control rounded-0" name="description" id="desc" rows="3" value="<?php echo $editResObject->Badges_Description?>" >
    </div>
    <?php
    $var = explode(',',$editResObject->Badges_Value);
//var_dump($var);
    for ($i=0; $i <count($var) ; $i++) { 
      if(count($var)>2)
      {
        if($i==1)
        {
          $minVal = $var[$i];
        }
        if($i==2)
        {
          $maxval = $var[$i];
        }
      }
      else 
      {
        if($i==1)
          $value = $var[$i];
      }
    }
    ?>
    <div class="form-group">
      <div class="row col-md-6" id="FixValues">
        <label for="FixValue" class="containerRadio">
          <input type="radio" name="rangeVal" id="FixValue" value="0" <?php echo (count($var)==2)?'checked':'' ?>> Fix Value
          <span class="checkmarkRadio"></span>
        </label>
        <div class="row hidden " id="fixVal">
          <div class="col-md-3" id="FixValDiv">
            <label for="Fix Value"><span class="alert-danger">*</span>Value</label>
            <input type='number' name='fixvalue' id='fixvalue' class='form-control' value="<?php echo $value?>">
          </div>
        </div>
      </div>
      <div class="row col-md-6" id="RangeValues">
        <label for="RangeValue" class="containerRadio">
          <input type="radio" name="rangeVal"  id="RangeValue" value="1"  <?php echo (count($var)>2)?'checked':'' ?>> Range
          <span class="checkmarkRadio"></span>
        </label>
        <div class="row hidden" id="RangeVal" name="RangeVal" value="">
          <div class="col-md-3" id="minValDiv">
            <label for="Minimum Value"><span class="alert-danger">*</span>Min</label>
            <input type="number" id="minVal" name="minVal" class="form-control" value="<?php echo $minVal?>" placeholder="Min Val" >
          </div>
          <div class="col-md-3" id="maxValDiv">
            <label for="Maximum Value"><span class="alert-danger">*</span>Max</label>
            <input type="number" id="maxVal" name="maxVal" class="form-control" value="<?php echo $maxval?>" placeholder="Max Val" >
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>  <br><br>

    <div class="row" id="sandbox-container" style="margin-left: 25%">
      <div class="col-md-3 text-center">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="editBadges" value="editBadges" id="editBadges">Update</button>
      </div>
      <div class="col-md-3 text-center">
        <a href="<?php echo site_root."ux-admin/outcomeBadges"; ?>" class="btn btn-danger btn-lg btn-block">CANCEL</a>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
  $(document).ready(function() {
    $('input[type=radio]').on('change click',function(){
      if($(this).attr('id') == 'FixValue' || $(this).attr('id') == 'RangeValue')
      {
        if($(this).val() == 0)
        {
          $('#fixVal').removeClass('hidden');
          $('#RangeVal').addClass('hidden');
          $('#fixvalue').attr('required',true);
          $('#minVal').attr('required',false);
          $('#maxVal').attr('required',false);
        }
        else
        {
          $('#RangeVal').removeClass('hidden');
          $('#fixVal').addClass('hidden');
          $('#minVal').attr('required',true);
          $('#maxVal').attr('required',true);
          $('#fixvalue').attr('required',false);
        }
      }
    });
    <?php if(count($var)>2) { ?>
      $('input[type=radio][value=1]').trigger('click');
    <?php } else { ?>
      $('input[type=radio][value=0]').trigger('click');
    <?php } ?>
  });
</script>