<!-- <?php //echo "<pre>"; print_r($header); exit;?>  -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/manageSubEnterprise/delete/";
     var loc_url_stat = "ux-admin/manageSubEnterprise/stat/";
  //-->
</script>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Add SubEnterprise</h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="<?php echo site_root."ux-admin/ManageSubEnterprise"; ?>">Manage SubEnterprise</a></li>
      <li class="active">AddSubEnterprise</li>
    </ul>
  </div>
</div>
<!-- DISPLAY ERROR MESSAGE -->
<?php  if(!empty($tr_msg)) { ?>
  <div class="alert-danger alert"><?php echo $tr_msg; ?></div>
<?php } ?>
<?php  if(!empty($er_msg)) { ?>
  <div class="alert-danger alert"><?php echo $er_msg; ?></div>
<?php } ?>
<!-- DISPLAY ERROR MESSAGE END -->
<style>
span.alert-danger {
  background-color: #ffffff;
  font-size       : 18px;
}
</style>
<!-- Personalise Outcome  -->
<div id="container">
  <form action="" method="post" enctype="multipart/form-data">
    <!-- game and scenario drop down -->
    <div class="row">
      <div class="col-md-6" id="enterprise_section">
        <label for="Select Enterprise"><span class="alert-danger">*</span>Select Enterprise</label>
        <select name="enterprise" id="enterprise" class="form-control">
          <option value="">--Select Enterprise--</option>
          <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
            <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" data-enterprise="<?php echo 
            $EnterpriseData->Enterprise_ID; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-6 " id="subEnterprise_section">
        <label for="Select Scenario"><span class="alert-danger">*</span>Add SubEnterprise</label>
        <input class="form-control" type="text" name="subEnterprisename" id="subEnterprisename">
      </div>
    </div>
    <div class="form-group row col-md-6">
      <label for="SubEnterprise"><span class="alert-danger">*</span> Choose Logo</label>
      <input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
    </div><br>
    <div class="clearfix"></div>
    <br>
    <div class="row text-center">
      <button type="submit" class="btn btn-primary " name="addSubEnterprise" value="addSubEnterprise" id="addSubEnterprise">SAVE</button>
      <a href="<?php echo site_root."ux-admin/ManageSubEnterprise"; ?>" class="btn btn-primary">CANCEL</a>
    </div>
  </div>
</form>
</div>
<div class="clearfix"></div>

<!-- <script type="text/javascript">

    //add choose file type
    $('#enterprise_section').on('click',function(){
      if($(this).val())
      {    
       $('#subEnterprise').removeClass('hidden');
     }
   });

 </script> -->