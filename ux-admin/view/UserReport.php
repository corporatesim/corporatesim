<!-- <?php // echo "<pre>"; print_r($header); exit;?> -->
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
        <li class="active"><a href="javascript:void(0);">Manage User Report</a></li>
        <li class="active"><?php echo $header; ?></li>
      </ul>
    </div>
  </div>
  <div id="container">
    <form action="" method="post" id="game_report" name="game_report">
      <!-- game and scenario drop down -->
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

        <div class="col-md-6 hidden" id="scenario_section">
          <label for="Select Scenario"><span class="alert-danger">*</span>Select Scenario</label>
          <select name="game_scenario" id="game_scenario" class="form-control">
            <option value="">--Select Scenario--</option>
            <!-- <option value="1">Test Scenario</option> -->
            <!-- <option value="<?php // echo $gameScenario->Game_ID; ?>"><?php // echo $gameScenario->Game_Name; ?></option> -->
          </select>
        </div>
        <input type="hidden" name="scenarioname" id="scenarioname">
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
            <label for="All Users">
              <input type="radio"  name="user_filter" id="all_users" checked="" value="all_users">All Users
            </label>
          </div>
          <div class="col-md-2">
            <label for="Select Users">
              <input type="radio" name="user_filter" id="select_users" value="select_users">Select Users
            </label>
          </div>
          <div class="col-md-2 hidden" style="float: right;" id="select_all_div">
            <label for="Select All Data" data-toggle="tooltip" title="Select All Users">
              <input type="checkbox" name="select_all" id="select_all" > Select All
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
        <div class="row" id="sandbox-container">
          <div class="col-md-4">
            <input type="text" name="StartDate" id="StartDate" class="form-control" placeholder="Select Start Date" required>
          </div>
          <div class="col-md-4">
            <input type="text" name="EndDate" id="EndDate" class="form-control" readonly="" placeholder="Select End Date">
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary" name="downloadReport" value="DownloadUserReport" id="downloadReport">Download Report</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(function(){

      $('#game_game').on('change',function(){
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
            url :  "model/ajax/UserReport.php",
            type: "POST",
            data: "action=game_scenario&Game_ID="+Game_ID,
            success: function( result )
            {
              var option = '<option value="">--Select Scenario--</option>';
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(index,e)
                {
                  // console.log(index);
                  option += ('<option value='+result.Scen_ID+' data-linkid='+result.linkid+' data-scenarioname="'+result.Scen_Name+'">'+result.Scen_Name+'</option>');
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
          var linkid = $(this).find(':selected').data('linkid');
          $('#user_section').removeClass('hidden');
          // triggering ajax to show users linked with this game and scenario
          $.ajax({
            url :  "model/ajax/UserReport.php",
            type: "POST",
            data: "action=game_users&linkid="+linkid,
            success: function( result )
            {
              var checkbox = '';
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(index,e)
                {
                  // checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="UserName: '+result[index].UserName+' and Email: '+result[index].Email+'"><input type="checkbox" name="user_id[]" id="user'+result[index].User_id+' value='+result[index].User_id+'"> '+result[index].Name+'</label></div>';
                  checkbox += '<div class="col-md-2"><label for="User Details" data-toggle="tooltip" title="'+result[index].Email+'"><input type="checkbox" value="'+result[index].User_id+'" name="user_id[]"> '+result[index].Name+'</label></div>'
                });
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
      });

      $('input[type=radio]').on('change',function(){
        // alert($(this).val());
        if($(this).val() == 'select_users')
        {
          $('#select_all_div').removeClass('hidden');
          $('#users_data').removeClass('hidden');
        }
        else
        {
          $('#users_data').addClass('hidden');
          $('#select_all_div').addClass('hidden');
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

      // $('#downloadReport').on('click',function(){
      //   var data = $('#game_report').serializeArray();
      //   console.log(data);
      // });

    });
  </script>