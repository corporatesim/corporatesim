<style>
.addPadding{
  padding-bottom: 10px;
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
      <li class="active"><a href="<?php echo site_root."ux-admin/ManageSubEnterprise"; ?>">Manage SubEnterprise</a></li>
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
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" id="SubEnterprise_Id" name="SubEnterprise_Id" value="<?php echo $editResObject->SubEnterprise_ID;?>">
    <div class="row">
     <div class="col-md-6 hidden" id="enterprise_section">
      <label for="Select Enterprise"><span class="alert-danger">*</span>Select Enterprise</label>
      <select name="enterprise" id="enterprise" class="form-control">
        <option value="">--Select Enterprise--</option>
        <?php foreach ($EnterpriseName as $EnterpriseData){ ?>
          <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" data-enterprise="<?php echo 
          $EnterpriseData->Enterprise_ID; ?>"<?php echo ($EnterpriseData->Enterprise_ID==$editResObject->SubEnterprise_EnterpriseID)?"selected":''; ?>><?php echo $EnterpriseData->Enterprise_Name; ?></option>
        <?php } ?>
      </select>
    </div> 
  </div>
  <div class="row">
    <div class="col-md-6">
      <label for="Name"><span class="alert-danger">*</span>SubEnterprise Name</label>
      <input type="text" id="SubEnterpriseName" name="SubEnterpriseName" class="form-control" placeholder="SubEnterpriseName" value="<?php echo $editResObject->SubEnterprise_Name;?>">
      <input type="hidden" id="SubEntId" name="SubEntId" value="<?php echo $editResObject->SubEnterprise_ID;?>">
    </div>
  </div>
  <br>
    <div class="row">
      <div class="col-md-6">
        <label for="name"><span class="alert-danger">*</span>Select Games</label>
        <input type="hidden" name="id" value="">
      </div>
      <div class="col-md-6">
        <input type="checkbox" name="select_all" id="select_all">
        <label for="name"> Select All</label>
      </div>
    </div><br>
    <div class="row">
      <?php while($row = $games->fetch_object()) { ?>
        <!-- // print_r($row->Game_Name); -->
        <div class="col-md-6 addPadding <?php echo $row->Game_ID;?>">
          <div class="col-md-4">
            <input type="checkbox" class="subenterpriseGameCheckBox" name="subenterprisegame[]" value="<?php echo $row->Game_ID;?>" id="<?php echo $row->Game_ID;?>"<?php echo($row->Game_ID == $row->SG_GameID ? 'checked' : '');?>><strong> <?php echo $row->Game_Name;?></strong> 
          </div>
          <?php if($row->SG_ID){ ?>
          <div id="sandbox-container" class="sandcheckBoxId">
              <div class="input-daterange input-group" name="gamedate" id="datepicker">
                <input type="text" class="input-sm form-control" id="SubEnterprise_GameStartDate" name="SubEnterprise_GameStartDate[]" value="<?php echo $row->SG_Game_Start_Date ?>" placeholder="Select Start Date" required="" readonly=""><span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" id="SubEnterprise_GameEndDate" name="SubEnterprise_GameEndDate[]" value="<?php echo $row->SG_Game_End_Date ?>" placeholder="Select End Date" required="" readonly="">
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <br><br>  
 <div class="row">
    <div class="form-group col-md-6">
      <label for="SubEnterprise"><span class="alert-danger">*</span> Choose Logo</label>
      <input type="file" name="logo" multiple="multiple" accept="image/*" id="image"value=""class="form-control">
    </div>
  <div class="form-group row col-md-6">
    <label for="SubEnterprise"><span class="alert-danger">*
    </span> Current Enterprise Logo</label><br>
    <img src="<?php echo site_root."ux-admin/upload/Logo/"?><?php echo $editResObject->SubEnterprise_Logo?>" width=50px height=50px >
  </div>
</div>
  <div class="clearfix"></div>
  <br><br>
  <div class="row">
    <div class="text-center">
      <button type="submit" class="btn btn-primary" name="editSubEnterprise" value="editSubEnterprise" id="editSubEnterprise">UPDATE</button>
      <a href="<?php echo site_root."ux-admin/ManageSubEnterprise"; ?>" class="btn btn-primary ">CANCEL</a>
    </div>
  </div>
</div>
</form>
</div>
<div class="clearfix"></div>
<script>
  $(document).ready(function(){
    // #select_all, .subenterpriseGameCheckBox, parentsDiv .addPadding
    $('#select_all').on('click',function(){
      if($(this).is(':checked'))
      {
        // alert('checked');
        $('.subenterpriseGameCheckBox').each(function(i,e){
          var checkBoxElement = $(e);
          var checkBoxId      = checkBoxElement.attr('id');
          checkBoxElement.prop('checked', true);
          // first remove then add
          checkBoxElement.parents('div.addPadding').find('div#sandbox-container').remove();
          // adding after removing
          checkBoxElement.parents('div.addPadding').append('<div id="sandbox-container" class="sand'+checkBoxId+'"><div class="input-daterange input-group" name="gamedate" id="datepicker"><input type="text" class="input-sm form-control" id="SubEnterprise_GameStartDate" name="SubEnterprise_GameStartDate[]" value="" placeholder="Select Start Date" required="" readonly=""><span class="input-group-addon">to</span><input type="text" class="input-sm form-control" id="SubEnterprise_GameEndDate" name="SubEnterprise_GameEndDate[]" value="" placeholder="Select End Date" required="" readonly=""></div></div>');
        });
        addDatepicker();
      }
      else
      {
        // alert('unchecked');
        $('.subenterpriseGameCheckBox').each(function(i,e){
          var checkBoxElement = $(e);
          checkBoxElement.prop('checked', false);
          checkBoxElement.parents('div.addPadding').find('div#sandbox-container').remove(); 
        });
      }
    });
    // while clicking on each seprate checkbox
    $('.subenterpriseGameCheckBox').click(function(i,e){
      if($(this).is(':checked'))
      {
         //alert($(this).val());
         //alert('checked');
         $(this).prop('checked', true);
         $(this).parents('div.addPadding').append('<div id="sandbox-container"><div class="input-daterange input-group" name="gamedate" id="datepicker"><input type="text" class="input-sm form-control" id="SubEnterprise_GameStartDate" name="SubEnterprise_GameStartDate[]" value="" placeholder="Select Start Date" required="" readonly=""><span class="input-group-addon">to</span><input type="text" class="input-sm form-control" id="SubEnterprise_GameEndDate" name="SubEnterprise_GameEndDate[]" value="" placeholder="Select End Date" required="" readonly=""></div></div>');
       }
       else
       {
        //alert('unchecked');
        $(this).prop('checked', false);
        $(this).parents('div.addPadding').find('div#sandbox-container').remove();
      }
      addDatepicker();
    });
  });
  function addDatepicker()
  {
    // adding datepicker to added fields for date
    $('#sandbox-container input').datepicker({
      format               : "yyyy-mm-dd",
      // endDate              : '-d',
      weekStart            : 0,
      daysOfWeekHighlighted: "0,6",
      autoclose            : true,
      todayHighlight       : true
    });
  }
</script>