<script type="text/javascript">
  var loc_url_del = "<?php echo base_url('Users/delete/');?>";
  var func        = "<?php echo $this->uri->segment(2);?>";
</script>
<div class="main-container">
  <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg');?>
    <div class="min-height-200px">
      <div class="page-header">
        <div class="row">
          <div class="col-md-6 col-sm-12">
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard');?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Item Mapping</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <h5 class="text-blue">Add Item Mapping</h5>
                </div>

                <?php echo form_open('', 'id="competencyMappingForm"', '');?>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="Cmap_Enterprise_ID" class="col-sm-12 col-md-3 col-form-label">Select Enterprise </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_Enterprise_ID" id="Cmap_Enterprise_ID" class="custom-select2 form-control" required="">
                      <option value="">--Select Enterprise--</option>
                      <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
                        <option value="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>
                      <?php } ?>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="Cmap_ComptId" class="col-sm-12 col-md-3 col-form-label">Select Item </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_ComptId" id="Cmap_ComptId" class="custom-select2 form-control" required="">
                      <option value="">--Select Item--</option>
                    </select> <span class="text-danger">*</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                  <label for="Cmap_GameId" class="col-sm-12 col-md-3 col-form-label">Select Game </label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Cmap_GameId[]" id="Cmap_GameId" class="custom-select2 form-control" multiple="" required="">
                    </select> <span class="text-danger">* (Click on the box to see games dropdown)</span>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="addCompSubcompOfGame">
                  <!-- // on change of game list all the component and subcomponent here -->
                  addCompSubcompOfGame
                </div>

                <div class="clearfix"></div>
                <div class="text-center">
                  <button class="btn btn-primary" name="" type="submit">Create Mapping</button>
                  <a href="<?php echo base_url('Competency/viewCompetencyMapping');?>" class="btn btn-outline-danger">Cancel</a>
                </div>

                <?php echo form_close();?>
              </div>
              <!-- end of adding users -->
            </div>
          </div>

<script>
  $(document).ready(function(){
    appendCompetencyGameComponentSubcomponent();

    //according to selected Enterprise fetching its items
    $('#Cmap_Enterprise_ID').on('change',function(){
      var enterprise_ID = $("#Cmap_Enterprise_ID").val();

      var itemOptions   = '<option value="">--Select Item--</option>';
      var gameOptions   = '';
      if(enterprise_ID){
        $.ajax({
          url    : "<?php echo base_url('Ajax/getCompetencyGameItems/');?>"+enterprise_ID,
          type   : 'POST',

          beforeSend: function(){ },
          success: function(result){
            result = JSON.parse(result);
            // console.log(result);
            if(result.status == 200)
            {
              let resultItemOptions = result.enterpriseItemsData;
              let resultGameOptions = result.enterpriseGameData; 

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
              $('#addCompSubcompOfGame').html('<span class="text-danger text-center">Please Select Game To Select Components/Subcomponents</span>');
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