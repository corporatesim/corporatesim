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
    <h1 class="page-header"><?php echo 'Edit '.$header; ?></h1>
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
    <input type="hidden" id="Branch_Id" name="Branch_Id" value="<?php echo $editResObject->Branch_Id;?>">
    <div class="row">
      <div class="col-md-6">
        <label for="Game">Game</label>
        <input type="text" id="gameName" name="gameName" class="form-control" placeholder="Selected Game" readonly="" value="<?php echo $editResObject->Game_Name;?>">
        <input type="hidden" id="gameId" name="gameId" value="<?php echo $editResObject->Branch_GameId;?>">
      </div>
      <div class="col-md-6">
        <label for="Scenario">Scenario</label>
        <input type="text" id="scenarioName" name="scenarioName" class="form-control" placeholder="Selected Scenario" readonly="" value="<?php echo $editResObject->Scen_Name;?>">
        <input type="hidden" id="scenarioId" name="scenarioId" value="<?php echo $editResObject->Branch_ScenId;?>">
      </div>
    </div>
    <div class="row">
      <div class="col-md-4" id="componentDiv">
        <label for="Select Component"><span class="alert-danger">*</span>Select Output Component</label>
        <select name="ComponentName" id="ComponentName" class="form-control ComponentName" required="">
          <?php 
          $compSql    = "SELECT gl.SubLink_ID,gc.Comp_Name,gc.Comp_ID FROM `GAME_LINKAGE_SUB` gl LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID=gl.SubLink_CompID WHERE gl.SubLink_LinkID=$editResObject->Branch_LinkId AND gl.SubLink_SubCompID=0 AND gl.SubLink_Type=1"; 
          $compResObj = $functionsObj->ExecuteQuery($compSql);
          // $scenRes    = $compResObj->Fetch_Object();
          // echo $compSql;
          ?>
          <option value="">--Select Output Component--</option>
          <?php while ($compRes = $compResObj->Fetch_Object()) { ?>
            <option value="<?php echo $compRes->Comp_ID;?>" <?php echo ($compRes->Comp_ID==$editResObject->Branch_CompId)?"selected":''; ?>><?php echo $compRes->Comp_Name;?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-1" id="minValDiv">
        <label for="Minimum Value"><span class="alert-danger">*</span>Min</label>
        <input type="text" id="minVal" name="minVal" class="form-control" placeholder="Min Val" required="" value="<?php echo $editResObject->Branch_MinVal;?>">
      </div>
      <div class="col-md-1" id="maxValDiv">
        <label for="Maximum Value"><span class="alert-danger">*</span>Max</label>
        <input type="text" id="" name="maxVal" class="form-control" placeholder="Max Val" required="" value="<?php echo $editResObject->Branch_MaxVal;?>">
      </div>
      <div class="col-md-1" id="orderDiv">
        <label for="Order Number"><span class="alert-danger">*</span>Order</label>
        <input type="number" id="" name="order" class="form-control" placeholder="Order Of Comparison" required="" value="<?php echo $editResObject->Branch_Order;?>">
      </div>
      <div class="col-md-4" id="scenarioDiv">
        <label for="Select Component"><span class="alert-danger">*</span>Next Scenario</label>
        <select name="NextScenario" id="NextScenario" class="form-control NextScenario">
          <?php 
          $scenSql    = "SELECT gl.Link_ID,gc.Scen_Name,gc.Scen_ID FROM `GAME_LINKAGE` gl LEFT JOIN GAME_SCENARIO gc ON gc.Scen_ID=gl.Link_ScenarioID WHERE Link_GameID = $editResObject->Branch_GameId ORDER BY gc.Scen_Name ASC"; 
          $scenResObj = $functionsObj->ExecuteQuery($scenSql);
          // $scenRes    = $scenResObj->Fetch_Object();
          ?>
          <option value="">--Select Next Scenario--</option>
          <?php while ($scenRes = $scenResObj->Fetch_Object()) { ?>
            <option value="<?php echo $scenRes->Scen_ID;?>" <?php echo ($scenRes->Scen_ID==$editResObject->Branch_NextScen)?"selected":''; ?>><?php echo $scenRes->Scen_Name;?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-1" style="margin-top:3%;">
        <label for="end" title="If selected then last" class="containerCheckbox">End
          <input type="checkbox" value="1" class="form-control" name="end" id="end" <?php echo ($editResObject->Branch_IsEndScenario)?"checked":'';?>>
          <span class="checkmark"></span>
        </label>
      </div>
    </div>
    <div class="clearfix"></div>
    <br><br>
    <br><br>
    <div class="row" id="sandbox-container" style="margin-left: 25%">
      <div class="col-md-3 text-center">
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="editBranching" value="editBranching" id="editBranching">UPDATE</button>
      </div>
      <div class="col-md-3 text-center">
        <a href="<?php echo site_root;?>ux-admin/ScenarioBranching" class="btn btn-primary btn-lg btn-block">CANCEL</a>
      </div>
    </div>
  </div>
</form>
</div>
<div class="clearfix"></div>

<!-- for searchable dropdown -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#NextScenario").select2();
    $("#ComponentName").select2();
  });
</script>
