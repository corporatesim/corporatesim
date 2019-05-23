<!-- <?php //echo "<pre>"; print_r($header); exit;?>  -->
  
  <script type="text/javascript">
    <!--
     var loc_url_del  = "ux-admin/personalizeOutcome/linkdel/";
     var loc_url_stat = "ux-admin/personalizeOutcome/linkstat/";
  //-->
</script>
<!-- css for overlay div -->
<style>
#overlay {
  position        : fixed;
  display         : none;
  width           : 100%;
  height          : 100%;
  top             : 0;
  left            : 250px;
  right           : 0;
  bottom          : 0;
  background-color: rgba(0,0,0,0.5);
  z-index         : 2;
  cursor          : pointer;
}

.divImages img{
  margin-top: 52px;
  width     : 100px;
  height    : 100px;
}
</style>
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

<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo 'Add '.$header; ?></h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="active"><a href="<?php echo site_root."ux-admin/personalizeOutcome"; ?>">Manage Personalized Outcome</a></li>
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
<!-- Personalise Outcome  -->
<div id="container">
  <form action="" method="post" id="game_report" name="game_report" enctype="multipart/form-data">
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
        </select>
      </div>
      <input type="hidden" name="scenarioname" id="scenarioname">
    </div>
    <div class="clearfix"></div>
    <!-- users checkboxes -->
    <br>
    <div class="row hidden" id="compSubcomp">
      <div class="col-md-3" id="componentDiv">
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
      <div class="col-md-2" id="OutcomeResult">
        <label for="Select Outcome"><span class="alert-danger">*</span>Select Outcome</label>
        <select name="Outcome[]" id="Outcome" class="form-control Outcome" required="">
          <option value="">--Select Outcome--</option>
          <?php foreach ($outcomeName as $OutcomeData) { ?>
            <option value="<?php echo $OutcomeData->Outcome_ResultID; ?>" data-gamename="<?php echo $OutcomeData->Outcome_Name; ?>"><?php echo $OutcomeData->Outcome_Name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-3" id="OutcomeType">
        <label for="Select File"><span class="alert-danger">*</span>Upoload File</label>
        <input type="file" name="image[]" multiple="multiple" accept="image/*" id="image" class="showOverlay" value="" <?php echo site_root."ux-admin\upload\Badges"; ?>>
        <input type="hidden" name="choosenImageName[]" id="choosenImageName">
        <img src="" alt="tmp_img" name="choosenImage[]" id="choosenImage" width="100px" height="100px" class="hidden">
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
          <button type="submit" class="btn btn-primary btn-lg btn-block" name="addOutcome" value="addOutcome" id="addOutcome">SAVE</button>
        </div>
        <div class="col-md-3 text-center">
          <a href="<?php echo site_root."ux-admin/personalizeOutcome"; ?>" class="btn btn-primary btn-lg btn-block">CANCEL</a>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="clearfix"></div>
<!-- creating this for choosing the images from server instead of local server -->
<div id="overlay">
  <?php 
  $imageSql = "SELECT Badges_ImageName FROM `GAME_OUTCOME_BADGES` WHERE Badges_Is_Active=0 GROUP BY Badges_ImageName";
  $imageObj = $functionsObj->ExecuteQuery($imageSql);
  while($images = $imageObj->Fetch_Object()) { ?>
    <div class="col-md-1 divImages"><img src="<?php echo site_root.'ux-admin/upload/Badges/'.$images->Badges_ImageName;?>" alt="<?php $images->Badges_ImageName;?>" id="<?php echo $images->Badges_ImageName;?>" class="selectImages"></div>
  <?php } ?>
</div>
<script>
  $(document).ready(function(){
    CompOption     = '<option value="">--Select Scenario--</option>';
    ScenarioOption = '<option value="">--Select Scenario--</option>';
    $('#overlay').on('click',function(){
      $('#overlay').hide();
    });
    showOutcomeImages();

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
          url : "<?php echo site_root.'ux-admin/'; ?>model/ajax/personalizeOutcome.php",
          type: "POST",
          data: "action=game_scenario&Game_ID="+Game_ID,
          success: function( result )
          {
            if(result.trim() != 'no link')
            {
              result = JSON.parse(result)
              // console.log(result);
              $(result).each(function(i,e)
              {
                scenarioLink += ("<option value='"+result[i].Scen_ID+","+result[i].linkid+"' data-linkid='"+result[i].linkid+"' data-scenarioname="+result[i].Scen_Name+">"+result[i].Scen_Name+"</option>");
              });
              
              $('#game_scenario').html(scenarioLink);
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
        $('#compSubcomp').removeClass('hidden');
        // triggering ajax to show users linked with this game and scenario
        $.ajax({
          url :  "<?php echo site_root.'ux-admin/'; ?>model/ajax/personalizeOutcome.php",
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

    //add choose file type
    $('#Outcome').on('change',function(){
      if($(this).val())
      {    
       $('#OutcomeType').removeClass('hidden');
     }
   });

    // adding more div
    $('#addMore').on('click', function(){
      var addedDiv = $('#addHere').children().length;
      if(addedDiv >= compCount-1)
      {
        // alert('compCount: '+compCount+' and addedDiv: '+addedDiv);
        alert('You can add max '+compCount+' rows. As there are '+compCount+' components');
        return false;
      }
      $('.ComponentName').each(function(i,e){
        $(e).html(CompOption);
      });

      $('#addHere').append('<div class="removeThis"><br><br><div class="col-md-3" id="componentDiv"><label for="Select Component"><span class="alert-danger">*</span>Select Output Component</label><select required name="ComponentName[]" id="ComponentName" class="form-control ComponentName"><option value="">--Select Output Component--</option></select></div><div class="col-md-1" id=""><label for="Minimum Value"><span class="alert-danger">*</span>Min</label><input required type="text" id="minVal" name="minVal[]" class="form-control" placeholder="Min Val"></div><div class="col-md-1" id=""><label for="Maximum Value"><span class="alert-danger">*</span>Max</label><input required type="text" id="maxVal" name="maxVal[]" class="form-control" placeholder="Max Val"></div><div class="col-md-1" id=""><label for="Order Number"><span class="alert-danger">*</span>Order</label><input required type="number" id="order" name="order[]" class="form-control" placeholder="Order Of Comparison"></div> <div class="col-md-2" id="Outcome"><label for="Select Component"><span class="alert-danger">*</span>Select Outcome</label><select name="Outcome[]" id="Outcome" class="form-control Outcome" required=""><option value="">--Select Outcome--</option><?php foreach ($outcomeName as $OutcomeData) { ?><option value="<?php echo $OutcomeData->Outcome_ResultID; ?>" data-gamename="<?php echo $OutcomeData->Outcome_Name; ?>"><?php echo $OutcomeData->Outcome_Name; ?></option><?php } ?></select></div> <div class="col-md-3" id="OutcomeType"><label for="Select File"><span class="alert-danger">*</span>Upoload File</label><input type="file" class="showOverlay" name="image[]" accept="image/*"><input type="hidden" name="choosenImageName[]" id="choosenImageName"><img src="" alt="tmp_img" name="choosenImage[]" id="choosenImage" width="100px" height="100px" class="hidden"></div><div class="col-md-1" id="" style="padding-top:3%;" title="Remove"><button type="button" class="btn-danger btn removeParentDiv" id="removeThis"><b>-</b></button></div></div>');
      removeDiv();
      showOutcomeImages();
    });
  });
function removeDiv()
{
  $('.removeParentDiv').each(function(i,e){
    $(e).on('click',function(){
      // alert($(this).attr('id'));
      $(this).parents('div.removeThis').remove();
    });

    $('.ComponentName').each(function(i,e){
      $(e).html(CompOption);
    });
  });
}

function removeAllAddedDiv()
{
  $('.removeThis').each(function(){
    $(this).remove();
  });
}
function showOutcomeImages()
{
  $('.showOverlay').each(function(){
    $(this).on('click',function(){
      fileElement = $(this);
      $('#overlay').show();
      return false;
    });      
  });
  $('.selectImages').each(function(i,e){
    $(this).on('click',function(){
      var selectedImage = $(this).attr('id');
      var imageUrl      = "<?php echo site_root.'ux-admin/upload/Badges/';?>"+selectedImage;
      // $('#image').hide(); alert(imageUrl);
      // $('#choosenImage').attr('src',imageUrl).removeClass('hidden');
      $(fileElement).next().next().removeClass('hidden').attr('src',imageUrl);
      $(fileElement).next().val(selectedImage);
      // getting the next img tag of clicked element of file type
    });
  });
}
</script>

<!-- for searchable dropdown -->
<script type="text/javascript">
  $(document).ready(function(){
  $("#game_game").select2();
 /* $("#game_scenario").select2();*/
  });
</script>