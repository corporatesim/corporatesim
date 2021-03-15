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
      <li class="active"><a href="<?php echo site_root."ux-admin/ManageEnterprise"; ?>">Manage Enterprise</a></li>
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
    <input type="hidden" id="Enterprise_Id" name="Enterprise_Id" value="<?php echo $editResObject->Enterprise_ID;?>">
    <div class="row">
      <div class="col-md-6">
        <label for="Name"><span class="alert-danger">*</span>Enterprise Name</label>
        <input type="text" id="EnterpriseName" name="EnterpriseName" class="form-control" placeholder=" EnterpriseName" value="<?php echo $editResObject->Enterprise_Name;?>">
        <input type="hidden" id="EntId" name="EntId" value="<?php echo $editResObject->Enterprise_ID;?>">
      </div>
    </div><br>
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
            <input type="checkbox" class="enterpriseGameCheckBox" name="enterprisegame[]" value="<?php echo $row->Game_ID;?>" id="<?php echo $row->Game_ID;?>"<?php echo($row->Game_ID == $row->EG_GameID ? 'checked' : '');?>><strong> <?php echo $row->Game_Name;?></strong> 
          </div>
          <?php if($row->EG_ID){ ?>
            <div id="date-container" class="sandcheckBoxId">
              <div class="input-daterange input-group" name="gamedate" id="datepicker">
                <input type="text" class="input-sm form-control" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate[]" value="<?php echo $row->EG_Game_Start_Date ?>" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>"><span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate[]" value="<?php echo $row->EG_Game_End_Date ?>" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>">
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
    </div>
    <br><br>   
    <div class="row">
      <div class="form-group col-md-6">
        <label for="Enterprise"><span class="alert-danger">*</span> Choose Logo</label>
        <input type="file" name="logo" multiple="multiple" accept="image/*" id="image" value="" class="form-control">
      </div>
      <div class="form-group col-md-6">
        <label for="Enterprise"><span class="alert-danger">*</span> Current Enterprise Logo</label><br>
        <img src="<?php echo site_root."ux-admin/upload/Logo/"?><?php echo $editResObject->Enterprise_Logo?>" width=50px height=50px >
      </div>
    </div>
    <div class="row" id="sandbox-container">
      <div class="col-md-4">
        <label for="Game Duration"><span class="alert-danger">*</span>Select Account Duration</label>
      </div>
      <div class="input-daterange input-group col-md-6" id="EnterpriseGameDate">
        <input type="text" class="input-sm form-control" id="GameStartDate" name="GameStartDate" value="<?php echo $editResObject->Enterprise_GameStartDate;?>" placeholder="Select Start Date" data-gamestartdate="<?php echo $editResObject->Enterprise_GameStartDate;?>" data-gameenddate="<?php echo $editResObject->Enterprise_GameEndDate;?>" required readonly/>
        <span class="input-group-addon">to</span>
        <input type="text" class="input-sm form-control" id="GameEndDate" name="GameEndDate" value="<?php echo $editResObject->Enterprise_GameEndDate;?>" placeholder="Select End Date" data-gamestartdate="<?php echo $editResObject->Enterprise_GameStartDate;?>" data-gameenddate="<?php echo $editResObject->Enterprise_GameEndDate;?>" required readonly/>
      </div>
    </div>
    <div class="clearfix"></div>
    <br><br>
    <div class="row">
      <div class="text-center">
        <button type="submit" class="btn btn-primary" name="submit" value="submit" id="submit">UPDATE</button>
        <a href="<?php echo site_root."ux-admin/ManageEnterprise"; ?>" class="btn btn-primary ">CANCEL</a>
      </div>
    </div>
  </div>
</form>
</div>
<div class="clearfix"></div>
<script>
  $(document).ready(function(){
    // #select_all, .enterpriseGameCheckBox, parentsDiv .addPadding
    $('#select_all').on('click',function(){
      if($(this).is(':checked'))
      {
        // alert('checked');
        $('.enterpriseGameCheckBox').each(function(i,e){
          var checkBoxElement = $(e);
          var checkBoxId      = checkBoxElement.attr('id');
          checkBoxElement.prop('checked', true);
          // first remove then add
          checkBoxElement.parents('div.addPadding').find('div#date-container').remove();
          // adding after removing
          checkBoxElement.parents('div.addPadding').append('<div id="date-container" class="sand'+checkBoxId+'"><div class="input-daterange input-group" name="gamedate" id="datepicker"><input type="text" class="input-sm form-control" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate[]" value="" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>"><span class="input-group-addon">to</span><input type="text" class="input-sm form-control" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate[]" value="" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>"></div></div>');
        });
        addDatepicker();
      }
      else
      {
        // alert('unchecked');
        $('.enterpriseGameCheckBox').each(function(i,e){
          var checkBoxElement = $(e);
          checkBoxElement.prop('checked', false);
          checkBoxElement.parents('div.addPadding').find('div#date-container').remove(); 
        });
      }
    });
    // while clicking on each seprate checkbox
    $('.enterpriseGameCheckBox').click(function(i,e){
      if($(this).is(':checked'))
      {
         //alert($(this).val());
         //alert('checked');
         $(this).prop('checked', true);
         $(this).parents('div.addPadding').append('<div id="date-container"><div class="input-daterange input-group" name="gamedate" id="datepicker"><input type="text" class="input-sm form-control" id="Enterprise_GameStartDate" name="Enterprise_GameStartDate[]" value="" placeholder="Select Start Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>"><span class="input-group-addon">to</span><input type="text" class="input-sm form-control" id="Enterprise_GameEndDate" name="Enterprise_GameEndDate[]" value="" placeholder="Select End Date" required="" readonly="" data-startdate="<?php echo strtotime($editResObject->Enterprise_GameStartDate);?>" data-enddate="<?php echo strtotime($editResObject->Enterprise_GameEndDate);?>"></div></div>');
       }
       else
       {
        //alert('unchecked');
        $(this).prop('checked', false);
        $(this).parents('div.addPadding').find('div#date-container').remove();
      }
      addDatepicker();
    });

    //onchange event on Update Account duration
    // $('#EnterpriseGameDate input').on('change',function(){
    //    var GameStartDate = $('#GameStartDate').val();
    //    var GameEndDate   = $('#GameEndDate').val(); 
    //   $('#date-container input').each(function() {
    //    // $(this).attr('data-startdate',GameStartDate);
    //    // $(this).attr('data-enddate',GameEndDate);
    //    var EnterpriseGameStartDate = $('#Enterprise_GameStartDate').val();
    //    var EnterpriseGameEndDate   = $('#Enterprise_GameEndDate').val(); 
    //    if(EnterpriseGameStartDate<GameStartDate&&EnterpriseGameEndDate>GameEndDate)
    //    {
    //     alert('Game Start Date and End Date not under specified account duration');
    //     return true;
    //    }
    //  });
    // });
  });
  function addDatepicker()
  {
    // adding datepicker to added fields for date
    $('#date-container input').each(function(i,e){
      var startDate   = new Date($(this).data('startdate')*1000);
      var endDate     = new Date($(this).data('enddate')*1000);
      //alert(endDate);
      $(this).datepicker({
        format               : "yyyy-mm-dd",
        startDate            : startDate,
        endDate              : endDate,
        weekStart            : 0,
        daysOfWeekHighlighted: "0,6",
        autoclose            : true,
        todayHighlight       : true
      });
    });
  }
</script>
