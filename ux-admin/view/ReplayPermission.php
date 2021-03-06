
<!-- <?php //echo "<pre>"; print_r($header); exit;?>  -->

  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/linkage/linkdel/";
     var loc_url_stat = "ux-admin/linkage/linkstat/";
  //-->
</script>
<style>
  span.alert-danger {
    background-color: #ffffff;
    font-size       : 18px;
  }
</style>

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="javascript:void(0);">Manage Replay Permision</a></li>
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
<div id="container">
  <form action="" method="post" id="game_report" name="game_report">
    <!-- game and scenario drop down -->
    <div class="row" id="check">
     <div class="col-md-4" >
      <label class="containerCheckbox" style="background-color: rgb(255, 255, 255);">
        <input type="checkbox" name="reset" id="reset" class="reset" value="0">Reset Values(Only One Time)
        <span class="checkmark"></span>
      </label>
    </div>

    <div class="col-md-4">
      <label for="replay" class="containerRadio"> Replay (More than One)
       <input type="radio" name="radio" id="replay" class="replay" value="replay"> 
       <span class="checkmarkRadio"></span>
     </label>
   </div>

   <div class="col-md-4">
    <label for="stop" class="containerRadio"> StopReplay (Never)
     <input type="radio" name="radio" id="stop" class="stop" value="stopReplay" checked="checked"> 
     <span class="checkmarkRadio"></span>
   </label>
 </div>

</div>
<br>
<div class="row">
  <div class="col-md-6" id="game_section">
    <label for="Select Game"><span class="alert-danger">*</span>Select Game</label>
    <select name="game_game" id="game_game" class="form-control">
      <option value="">--Select Game--</option>
      <?php foreach ($gameName as $gameData) { ?>
        <option value="<?php echo $gameData->Game_ID; ?>" data-gamename="<?php echo $gameData->Game_Name; ?>"><?php echo $gameData->Game_Name; ?></option>
      <?php } ?>
    </select>
  </div>
  <input type="hidden" name="gamename" id="gamename">

  <!-- <div class="col-md-6 hidden" id="scenario_section">
    <label for="Select Scenario"><span class="alert-danger">*</span>Select Scenario</label>
    <select name="game_scenario" id="game_scenario" class="form-control">
      <option value="">--Select Scenario--</option> -->
      <!-- <option value="1">Test Scenario</option> -->
      <!-- <option value="<?php // echo $gameScenario->Game_ID; ?>"><?php // echo $gameScenario->Game_Name; ?></option> -->
   <!--  </select>
  </div>
  <input type="hidden" name="scenarioname" id="scenarioname"> -->
</div>

<div class="clearfix"></div>
<!-- users checkboxes -->
<br>
<div class="row hidden" id="user_section">
  <!-- ask user for filter -->
  <div class="row" style="margin-left: 1px;">
    <div class="col-md-2">
      <label for="Choose Filters"><span class="alert-danger">*</span>Choose Filters</label>
    </div>
    <div class="col-md-2">
      <label for="all_users" class="containerRadio">
        <input type="radio"  name="user_filter" id="all_users" checked="" value="all_users">All Users
        <span class="checkmarkRadio"></span>
      </label>
    </div>
    <div class="col-md-2">
      <label for="select_users" class="containerRadio">
        <input type="radio" name="user_filter" id="select_users" value="select_users">Select Users
        <span class="checkmarkRadio"></span>
      </label>
    </div>

    <div class="col-md-2 hidden" name= "count" id="count">
      <!-- <label> Total Users </label> -->
    </div>

    <div class="col-md-2 hidden" id="search">
      <label>
        <input type="search" id="searchBox" name="searchBox" class="form-control input-sm" placeholder="Serach By Email ID" aria-controls="" style="max-height: 23px; border-radius: 5px;">
      </label>
    </div>

    <div class="col-md-2 hidden" id="select_all_div">
      <label for="select all users" data-toggle="tooltip" title="Select All Users" class="containerCheckbox" id="select_all_checkbox">
        <input type="checkbox" name="select_all" id="select_all" value=select_all > Select All
        <span class="checkmark"></span>
      </label>
    </div>
  </div>
  <br>
  <!-- if user select for filter then show this -->
  <input type="hidden" name="linkid" id="linkid">
  <div class="row hidden" style="margin-left: 1px;" id="users_data">
    <!-- adding users details to this div via jquery after selection of scenario -->
  </div>
  <br>
  <div class="row" id="sandbox-container" style="margin-left: 25%">
    <div class="col-md-3 text-center">
      <button type="submit" class="btn btn-primary btn-block" name="submit" value="submit" id="submit">SUBMIT</button>
    </div>
    <div class="col-md-3 text-center">
      <a href="<?php echo site_root.'ux-admin/ReplayPermission'; ?>" class="btn btn-danger btn-block">CANCEL</a>
    </div>
  </div>
</div>
</form>
</div>

<script>
  $(document).ready(function(){

   //on game change select the users
   $('#game_game').on('change',function(){
    var Game_ID  = $(this).val();
    var gamename = $(this).find(':selected').data('gamename');
    $('#gamename').attr('value',gamename); 
    if($(this).val())
    {
      $('#user_section').removeClass('hidden');
          // triggering ajax to show users linked with this game 
          $.ajax({
            url :  "model/ajax/ReplayPermission.php",
            type: "POST",
            data: "action=game_users&Game_ID="+Game_ID,
            success: function( result )
            {
              var checkbox = '';
              var count    = 0;
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(index,e)
                {
                  count++;
                  // checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="UserName: '+result[index].UserName+' and Email: '+result[index].Email+'"><input type="checkbox" name="user_id[]" id="user'+result[index].User_id+' value='+result[index].User_id+'"> '+result[index].Name+'</label></div>';
                  checkbox += '<div class="col-md-2"><label class="containerCheckbox" for="id_'+result[index].User_id+'" data-toggle="tooltip" title="'+result[index].Email+'"><input type="checkbox" class="user_id" id="id_'+result[index].User_id+'" value="'+result[index].User_id+'" name="user_id[]"> '+result[index].Name+' <span class="checkmark"></span> </label></div>'
                });
                // alert(count);
                $('#count').html('<label class="alert-success">Total Users: '+count+'</label>');
                // $('#count').html('<label>Total Users: '+count+'</label>');
                $('#users_data').html(checkbox);
              }
              else
              {
                $('#users_data').html(checkbox);
              }
            },
          });
        }
        else
        {
          if(!($('#user_section').hasClass('hidden')))
          {
            $('#user_section').addClass('hidden');
          }
          alert('Please Select game...');
          return false;
        }
      });
   
   /* $('#game_game').on('change',function(){
      var Game_ID  = $(this).val();
      var gamename = $(this).find(':selected').data('gamename');
      $('#gamename').attr('value',gamename);
      $('#scenarioname').attr('value','');
      if(!($('#user_section').hasClass('hidden')))
      {
        $('#user_section').addClass('hidden');
      }

      if($(this).val())
      {
        $('#scenario_section').removeClass('hidden');
          // triggering ajax to show the scenario linked with this game
          $.ajax({
            url : "model/ajax/ReplayPermission.php",
            type: "POST",
            data: "action=game_scenario&Game_ID="+Game_ID,
            success: function( result )
            {
              var option = '<option value="">--Select Scenario--</option>';
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(i,e)
                {
                  //console.log(i);
                  option += ('<option value='+result[i].Scen_ID+' data-linkid='+result[i].linkid+' data-scenarioname="'+result[i].Scen_Name+'">'+result[i].Scen_Name+'</option>');
                });
               // console.log(option);
               $('#game_scenario').html(option);
             }
             else
             {
              $('#game_scenario').html(option);
            }
          },
        });          
        }
        else
        {
          if(!($('#scenario_section').hasClass('hidden')))
          {
            $('#scenario_section').addClass('hidden');
          }
          alert('Please Select Game...');
          return false;
        }
      });

    $('#game_scenario').on('change',function(){
      var element      = $(this);
      var scenarioname = $(this).find(':selected').data('scenarioname');
      $('#scenarioname').attr('value',scenarioname);
      if($(this).val())
      {
        linkid = $(this).find(':selected').data('linkid');
        $('#user_section').removeClass('hidden');
          // triggering ajax to show users linked with this game and scenario
          $.ajax({
            url :  "model/ajax/ReplayPermission.php",
            type: "POST",
            data: "action=game_users&linkid="+linkid,
            success: function( result )
            {
              var checkbox = '';
              var count    = 0;
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(index,e)
                {
                  count++;
                  // checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="UserName: '+result[index].UserName+' and Email: '+result[index].Email+'"><input type="checkbox" name="user_id[]" id="user'+result[index].User_id+' value='+result[index].User_id+'"> '+result[index].Name+'</label></div>';
                  checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="'+result[index].Email+'"><input type="checkbox" class="user_id" value="'+result[index].User_id+'" name="user_id[]"> '+result[index].Name+'</label></div>'
                });
                // alert(count);
                $('#count').html('<label class="alert-success">Total Users: '+count+'</label>');
                // $('#count').html('<label>Total Users: '+count+'</label>');
                $('#linkid').attr('value',linkid);
                $('#users_data').html(checkbox);
              }
              else
              {
                $('#users_data').html(checkbox);
              }
            },
          });
        }
        else
        {
          if(!($('#user_section').hasClass('hidden')))
          {
            $('#user_section').addClass('hidden');
          }
          alert('Please Select Scenario...');
          return false;
        }
      });*/

      $('input[type=radio]').on('change',function(){
        // alert($(this).val());
        if($(this).attr('id') == 'all_users' || $(this).attr('id') == 'select_users')
        {
          if($(this).val() == 'select_users')
          {
            $('#select_all_div').removeClass('hidden');
            $('#search').removeClass('hidden');
            $('#count').removeClass('hidden');
            $('#users_data').removeClass('hidden');
          }
          else
          {
            $('#users_data').addClass('hidden');
            $('#select_all_div').addClass('hidden');
            $('#search').addClass('hidden');
            $('#count').addClass('hidden');
          }
        }
      });

      $('#select_all').on('click',function(){
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

      $('#searchBox').on('keyup',function(){
        var search = $(this).val().toLowerCase();
        var Game_ID  = $('#game_game').val();
        $.ajax({
          url : "model/ajax/ReplayPermission.php",
          type: "POST",
          data: "action=game_users&Game_ID="+Game_ID+'&email_value='+search,
          success: function( result )
          {
            var checkbox = '';
            var count    = 0;
            if(result.trim() != 'no link')
            {
              result = JSON.parse(result)
              $(result).each(function(index,e)
              {
                count++;
                checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="'+result[index].Email+'"><input type="checkbox" class="user_id" value="'+result[index].User_id+'" name="user_id[]"> '+result[index].Name+'</label></div>';
              });

              $('#count').html('<label class="alert-success">Total Users: '+count+'</label>');
              $('#users_data').html(checkbox);
              

            }
            else
            {
              $('#count').html('<label class="alert-danger">No Record Found</label>');
              $('#users_data').html(checkbox);
            }
          },
        });
      });

// Set the value 0 & 1 for check and Unchecked 

$('#reset').on('click',function(){
  if($(this).is(':checked'))
  {
    $(this).attr('value',1);
  }
  else
  {
    $(this).attr('value',0);
  }
});

$('#replay').on('click',function(){
  if($(this).is(':checked'))
  {
    $(this).attr('value',1);
  }
  else
  {
    $(this).attr('value',0);
  }
});

$('#stop').on('click',function(){
  if($(this).is(':checked'))
  {
    $(this).attr('value',0);
  }
  else
  {
    $(this).attr('value',1);
  }
});


//Alert generate for Select user when click on submit button
$('#submit').on('click',function(){
  if($('input[name=reset]').is(':checked') || $('input[name=radio]').is(':checked'))
  {
    // if user selects filter option not the all users
    if($('input[name=user_filter]:checked').val() != 'all_users')
    {
      // check if there is any checkbox is not checked
      var total_checkboxes = $('#users_data').find('input.user_id').length;
      var limit            = 0;
      $('.user_id').each(function(index, el)
      {
        if($(this).is(':checked'))
        {
          limit++;
        }
      });
      if(limit < 1)
      {
        alert('Please Select At Least One User To Submit.');
        return false;
      }
    }
  }
  else
  {
    alert('Please Select Permision Type Replay/Reset/StopPlay');
    return false;
  }
});

});
</script>
