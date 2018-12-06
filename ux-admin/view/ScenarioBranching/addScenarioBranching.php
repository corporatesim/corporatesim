<!-- <?php //echo "<pre>"; print_r($header); exit;?>  -->
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/ScenarioBranching/linkdel/";
     var loc_url_stat = "ux-admin/ScenarioBranching/linkstat/";
  //-->
</script>
<!-- scenario branching Data table CSS -->
<style>
<!--
.dropdown-menu > li > button {
  display    : block;
  padding    : 3px 20px;
  clear      : both;
  font-weight: 400;
  line-height: 1.42857143;
  color      : #ffffff;
  white-space: nowrap;
}
#contact
{
  width: auto!important;
}
#password
{
  width: auto!important;
}
#action
{
  width: 70px!important;
}
.drop_down{
  padding: 0 5px !important;
}

#upload-file-selector {
  display:none;
}
.margin-correction {
  margin-right: 10px;
}

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
-->
#update-file-selector {
  display:none;
}
</style>
<!-- scenario branching Data table CSS ends -->
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo 'Add '.$header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="<?php echo site_root."ux-admin/ScenarioBranching"; ?>">Manage Scenario Branching</a></li>
      <li class="active"><?php echo $header; ?></li>
      <!-- <li class="active"><a href="<?php // echo site_root."ux-admin/ScenarioBranching";?>">Manage Scenario Branching</a></li> -->
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
<!-- scenario branching -->
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
    <div class="row hidden" id="compSubcomp">
      <div class="col-md-4" id="componentDiv">
        <label for="Select Component"><span class="alert-danger">*</span>Select Output Component</label>
        <select name="ComponentName[]" id="ComponentName" class="form-control ComponentName" required="">
        </select>
      </div>
      <div class="col-md-1" id="minValDiv">
        <label for="Minimum Value"><span class="alert-danger">*</span>Min</label>
        <input type="text" id="minVal" name="minVal[]" class="form-control" placeholder="Min Val" required="">
      </div>
      <div class="col-md-1" id="maxValDiv">
        <label for="Maximum Value"><span class="alert-danger">*</span>Max</label>
        <input type="text" id="" name="maxVal[]" class="form-control" placeholder="Max Val" required="">
      </div>
      <div class="col-md-1" id="orderDiv">
        <label for="Order Number"><span class="alert-danger">*</span>Order</label>
        <input type="number" id="" name="order[]" class="form-control" placeholder="Order Of Comparison" required="" min="1">
      </div>
      <div class="col-md-4" id="scenarioDiv">
        <label for="Select Component"><span class="alert-danger">*</span>Next Scenario</label>
        <select name="NextScenario[]" id="NextScenario" class="form-control NextScenario">
          <option value="">--Select Next Scenario--</option>
          <?php foreach ($gameName as $gameData) { ?>
            <option value="<?php echo $gameData->Game_ID; ?>" data-gamename="<?php echo $gameData->Game_Name; ?>"><?php echo $gameData->Game_Name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-1 hidden" id="buttonDiv" style="padding-top: 3%;">
        <button type="button" class="btn-primary btn" id="addMore" title="Add New"><b>+</b></button>
      </div>
      <div id="addHere"></div>
      <br>
      <div class="clearfix"></div>
      <br><br>
      <br><br>
      <div class="row" id="sandbox-container" style="margin-left: 25%">
        <div class="col-md-3 text-center">
          <button type="submit" class="btn btn-primary btn-lg btn-block" name="addBranching" value="addBranching" id="addBranching">SAVE</button>
        </div>
        <div class="col-md-3 text-center">
          <a href="<?php echo site_root;?>ux-admin/ScenarioBranching" class="btn btn-primary btn-lg btn-block">CANCEL</a>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="clearfix"></div>
<script>
  $(document).ready(function(){
    classCount     = 0;
    CompOption     = '<option value="">--Select Scenario--</option>';
    ScenarioOption = '<option value="">--Select Scenario--</option>';

    $('#game_game').on('change',function(){
      var Game_ID      = $(this).val();
      var scenarioLink = '<option value="">--Select Scenario--</option>';
      var gamename = $(this).find(':selected').data('gamename');
      $('#gamename').attr('value',gamename);
      $('#scenarioname').attr('value','');
      if(!($('#compSubcomp').hasClass('hidden')))
      {
        $('#compSubcomp').addClass('hidden');
      }

      if($(this).val())
      {
        $('#scenario_section').removeClass('hidden');
        // triggering ajax to show the scenario linked with this game
        $.ajax({
          url : "<?php echo site_root.'ux-admin/'; ?>model/ajax/ScenarioBranching.php",
          type: "POST",
          data: "action=game_scenario&Game_ID="+Game_ID,
          success: function( result )
          {
            ScenarioOption = '<option value="">--Select Next Scenario--</option>';
            if(result.trim() != 'no link')
            {
              result = JSON.parse(result)
              // console.log(result);
              $(result).each(function(i,e)
              {
                ScenarioOption += ('<option value='+result[i].Scen_ID+' data-linkid='+result[i].linkid+' data-scenarioname="'+result[i].Scen_Name+'">'+result[i].Scen_Name+'</option>');
                // taking this variable to save the link id for scenario branching by breaking it's value seprated by value,link
                scenarioLink += ("<option value='"+result[i].Scen_ID+","+result[i].linkid+"' data-linkid='"+result[i].linkid+"' data-scenarioname="+result[i].Scen_Name+">"+result[i].Scen_Name+"</option>");
              });
              $('.NextScenario').each(function(i,e){
                $(e).html(ScenarioOption);
              });
              $('#game_scenario').html(scenarioLink);
            }
            else
            {
              $('.NextScenario').each(function(i,e){
                $(e).html(ScenarioOption);
              });
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
      // remove all added div via add button
      removeAllAddedDiv();
      if($(this).val())
      {
        linkid = $(this).find(':selected').data('linkid');
        $('#compSubcomp').removeClass('hidden');
        // triggering ajax to show users linked with this game and scenario
        $.ajax({
          url :  "<?php echo site_root.'ux-admin/'; ?>model/ajax/ScenarioBranching.php",
          type: "POST",
          data: "action=outputComponent&linkid="+linkid,
          success: function( result )
          {
            CompOption = '<option value="">--Select Component--</option>';
            if(result.trim() != 'no link')
            {
              compCount = 0;
              result    = JSON.parse(result)
              // console.log(result);
              $(result).each(function(i,e)
              {
                //console.log(i);
                compCount++;
                CompOption += ('<option value='+result[i].SubLink_CompID+' data-SubLink_ID='+result[i].SubLink_ID+'>'+result[i].Comp_Name+'</option>');
              });
              $('.ComponentName').each(function(i,e){
                $(e).html(CompOption);
              });
              $('#buttonDiv').removeClass('hidden');
            }
            else
            {
              if(!$('#buttonDiv').hasClass('hidden'))
              {
               $('#buttonDiv').addClass('hidden');
             }
             $('.ComponentName').each(function(i,e){
              $(e).html(CompOption);
            });
             removeAllAddedDiv();
           }
         },
       });
      }
      else
      {
        if(!($('#compSubcomp').hasClass('hidden')))
        {
          $('#compSubcomp').addClass('hidden');
        }
        alert('Please Select Scenario...');
        return false;
      }
    });
    // adding more div
    $('#addMore').on('click', function(){
      classCount++;
      var addedDiv = $('#addHere').children().length;
      if(addedDiv >= compCount-1)
      {
        // alert('compCount: '+compCount+' and addedDiv: '+addedDiv);
        alert('You can add max '+compCount+' rows. As there are '+compCount+' components');
        return false;
      }

      $('#addHere').append('<div class="removeThis"><div class="col-md-4" id="componentDiv"><label for="Select Component"><span class="alert-danger">*</span>Select Output Component</label><select required name="ComponentName[]" id="ComponentName" class="form-control ComponentName'+classCount+'"><option value="">--Select Output Component--</option></select></div><div class="col-md-1" id=""><label for="Minimum Value"><span class="alert-danger">*</span>Min</label><input required type="text" id="minVal" name="minVal[]" class="form-control" placeholder="Min Val"></div><div class="col-md-1" id=""><label for="Maximum Value"><span class="alert-danger">*</span>Max</label><input required type="text" id="maxVal" name="maxVal[]" class="form-control" placeholder="Max Val"></div><div class="col-md-1" id=""><label for="Order Number"><span class="alert-danger">*</span>Order</label><input required type="number" min="1" id="order" name="order[]" class="form-control" placeholder="Order Of Comparison"></div><div class="col-md-4" id="scenarioDiv"><label for="Select Component"><span class="alert-danger">*</span>Next Scenario</label><select required name="NextScenario[]" id="NextScenario" class="form-control NextScenario'+classCount+'"><option value="">--Select Scenario--</option></select></div><div class="col-md-1" id="" style="padding-top:3%;" title="Remove"><button type="button" class="btn-danger btn" id="removeThis"><b>-</b></button></div></div>');

      $('.ComponentName'+classCount).html(CompOption);

      $('.NextScenario'+classCount).html(ScenarioOption);
      removeDiv();
    });
  });
function removeDiv()
{
  $('.btn-danger').each(function(i,e){
    $(e).on('click',function(){
      // alert($(this).attr('id'));
      $(this).parents('div.removeThis').remove();
    });
  });
}

function removeAllAddedDiv()
{
  $('.removeThis').each(function(){
    $(this).remove();
  });
}
</script>