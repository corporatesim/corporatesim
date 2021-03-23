<script type="text/javascript">
  var loc_url_del = "<?php echo base_url('Users/delete/');?>";
  var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mapping</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <h5 class="text-blue">Add Mapping</h5>
                </div>

                <?php echo form_open('', 'id="competenceMappingForm"', '');?>

                <div class="row col-md-12 col-lg-12 col-sm-12 form-group">
                  <label for="Cmap_Enterprise_ID" class="col-sm-12 col-md-3 col-form-label">Select Enterprize </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_Enterprise_ID" id="Cmap_Enterprise_ID" class="custom-select2 form-control" required="">
                      <option value="">--Select Enterprize--</option>
                      <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
                        <option value="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>
                      <?php } ?>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 form-group">
                  <label for="Cmap_Performance_Type" class="col-sm-12 col-md-3 col-form-label">Select Factor Type </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_Performance_Type" id="Cmap_Performance_Type" class="custom-select2 form-control" required="">
                      <option value="">--Select Factor Type--</option>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 form-group">
                  <label for="Cmap_ComptId" class="col-sm-12 col-md-3 col-form-label">Select Sub-factor</label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_ComptId" id="Cmap_ComptId" class="custom-select2 form-control" required="">
                      <option value="">--Select Sub-factor--</option>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 form-group">
                  <label for="Cmap_GameId" class="col-sm-12 col-md-3 col-form-label">Select Card(s) </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_GameId[]" id="Cmap_GameId" class="custom-select2 form-control" multiple="" required="">
                    </select> <span class="text-danger">* (Use Multi Select)</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 form-group" id="addCompSubcompOfGame">
                  <!-- // on change of game list all the component and subcomponent here -->
                  <!-- addCompSubcompOfGame -->
                </div>

                <div class="clearfix"></div>
                <div class="text-center">
                  <button class="btn btn-primary" name="" type="submit">Create Mapping</button>
                  <a href="<?php echo base_url('Competence/viewCompetenceMapping');?>" class="btn btn-outline-danger">Cancel</a>
                </div>

                <?php echo form_close();?>
              </div>
              <!-- end of adding users -->

<script>
  $(document).ready(function(){
    
    $('#Cmap_ComptId').on('change',function(){
      let item_ID = $("#Cmap_ComptId").val();

      $('#addCompSubcompOfGame').html('<span class="text-danger text-center">Please Select Card(s) To Select Components/Subcomponents</span>');
      appendCompetenceGameComponentSubcomponent(item_ID);
    });

    //according to selected Enterprise showing performance Type
    $('#Cmap_Enterprise_ID').on('change',function(){
      var enterprise_ID = $("#Cmap_Enterprise_ID").val();

      var performanceTypeOptions   = '<option value="">--Select Factor Type--</option> <option value="4">Competence Readiness</option> <option value="5">Competence Application</option> <option value="3">Simulated Performance</option>';

      $('#Cmap_Performance_Type').html(performanceTypeOptions);
    });//end of function

    //according to selected Performance Type fetching its items
    $('#Cmap_Performance_Type').on('change',function(){
      var enterprise_ID       = $("#Cmap_Enterprise_ID").val();
      var performance_Type_ID = $("#Cmap_Performance_Type").val();

      var itemOptions   = '<option value="">--Select Sub-factor--</option>';
      var gameOptions   = '';
      if(enterprise_ID){
        $.ajax({
          url    : "<?php echo base_url('Ajax/getCompetenceGameItems/');?>"+enterprise_ID+"/"+performance_Type_ID,
          type   : 'POST',

          beforeSend: function(){ },
          success: function(result){
            result = JSON.parse(result);
            // console.log(result);
            if(result.status == 200)
            {
              let resultItemOptions = result.enterpriseItemsData;
              let resultGameOptions = result.enterpriseGameData; 
              // console.table(resultItemOptions);

              //Enterprise Items
              $.each(resultItemOptions,function(i,e){
                 itemOptions += '<option value="'+resultItemOptions[i].Compt_Id+'" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</option>'
              });
              $('#Cmap_ComptId').html(itemOptions);

              //Enterprise Games
              $.each(resultGameOptions,function(i,e){
                gameOptions += '<option value="'+resultGameOptions[i].Game_ID+'" title="'+resultGameOptions[i].Game_Comments+'">'+resultGameOptions[i].Game_Name+'</option>'
              });
              $('#Cmap_GameId').html(gameOptions);
            }
            else
            {
              Swal.fire({
                icon: 'error',
                html: result.message,
              });
              $('#Cmap_ComptId').html(itemOptions);
              $('#Cmap_GameId').html(gameOptions);
              $('#addCompSubcompOfGame').html('<span class="text-danger text-center">Please Select Card(s) To Select Components/Subcomponents</span>');
            }

          },
          error: function(jqXHR, exception){
            Swal.fire({
              icon: 'error',
              html: jqXHR.responseText,
            });
            $("#input_loader").html('');
          }

        });
      }
      else{
        $('#Cmap_ComptId').html(itemOptions);
        $('#Cmap_GameId').html(gameOptions);
        return false;
      }
    });//end of function

  });
</script>