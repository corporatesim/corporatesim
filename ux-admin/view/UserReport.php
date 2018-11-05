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
      <li class="completed"><a
        href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
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
              <option value="<?php echo $gameData->Game_ID; ?>"><?php echo $gameData->Game_Name; ?></option>
            <?php } ?>
          </select>
        </div>

        <div class="col-md-6 hidden" id="scenario_section">
          <label for="Select Scenario"><span class="alert-danger">*</span>Select Scenario</label>
          <select name="game_scenario" id="game_scenario" class="form-control">
            <option value="">--Select Scenario--</option>
            <option value="1">Test Scenario</option>
            <!-- <option value="<?php // echo $gameScenario->Game_ID; ?>"><?php // echo $gameScenario->Game_Name; ?></option> -->
          </select>
        </div>
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
        <div class="row hidden" style="margin-left: 1px;" id="users_data">
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> mohit123
            </label>
          </div>
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> mohit1
            </label>
          </div>
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> mohit258741147
            </label>
          </div>
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> mk
            </label>
          </div>
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> sahu
            </label>
          </div>
          <div class="col-md-2">
            <label for="User Details" data-toggle="tooltip" title="Name and Email">
              <input type="checkbox" name="" id=""> 5874125598878747
            </label>
          </div>
        </div>
        <br>
        <div class="row" id="sandbox-container">
          <div class="col-md-4">
            <input type="text" name="StartDate" id="StartDate" class="form-control" readonly="" placeholder="Select Start Date">
          </div>
          <div class="col-md-4">
            <input type="text" name="EndDate" id="EndDate" class="form-control" readonly="" placeholder="Select End Date">
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Download Report</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(function(){
      $('#game_game').on('change',function(){
        if(!($('#user_section').hasClass('hidden')))
        {
          $('#user_section').addClass('hidden');
        }

        if($(this).val())
        {
          $('#scenario_section').removeClass('hidden');
          // triggering ajax to show the scenario linked with this game
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
        if($(this).val())
        {
          $('#user_section').removeClass('hidden');
          // triggering ajax to show the scenario and users linked with this game
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

    });
  </script>