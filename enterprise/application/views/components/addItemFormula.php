<style>
  .undo_btn{
    position: absolute;
    bottom  : 15px; 
  }
  .formula_box{
    display: flex;
  }

  .operators, .Cmap_ComptId{
    list-style: none;
    margin    : 0;
    padding   : 0;
    border    : 1px solid #d8d8d8;
    height    : 300px;
    overflow-y: scroll;
  }

  .operators li, .Cmap_ComptId li{
    cursor : pointer;
    padding: 2px 10px;
  }

  .operators li:hover, .Cmap_ComptId li:hover{
    background-color: #f8f8f8;
  }

  @media only screen and (max-width:360px){
    .undo_btn{
      position: unset;
      bottom  : auto;
    }
    .formula_box{
      display: unset;
    }
  }
</style>
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
                <li class="breadcrumb-item active" aria-current="page">Formula</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">

                <div class="clearfix mb-20">
                  <h5 class="text-blue">Add Formula</h5>
                </div>

                <form method="POST" action="" id="itemFormulaForm">
                <!-- <?php //echo form_open(base_url('Competence/itemFormulaFormOnSubmit/')); ?> -->
                
                <?php if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){ ?>
                <div class="col-12 col-sm-4 form-group">
                  <label class="col-form-label" for="Cmap_Enterprise_ID">Select Enterprize <span class="text-danger">*</span></label> 
                  <!-- <select class="custom-select2 form-control" id="Cmap_Enterprise_ID" name="Cmap_Enterprise_ID" required=""> -->
                  <select class="custom-select2 form-control" id="Cmap_Enterprise_ID" name="Cmap_Enterprise_ID" required="">
                    <option value="">-- Select Enterprize --</option>
                    <?php foreach ($enterpriseDetails as $enterpriseRow) { ?>
                        <option value="<?php echo $enterpriseRow->Enterprise_ID;?>"><?php echo $enterpriseRow->Enterprise_Name; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <?php } else{ ?>
                  <input type="hidden" id="Cmap_Enterprise_ID" name="Cmap_Enterprise_ID" value="<?php echo $this->session->userdata('loginData')['User_Id']; ?>">
                <?php } ?>     

                <div class="col-12 col-sm-4 form-group">
                  <label>Formula title <span class="text-danger">*</span></label>
                  <input type="text" name="formula_title" id="formula_title" class="form-control" required="" />
                </div>
  
                <!-- formula String box -->
                <div class="formula_box invisible"> 
                  <div class="col-sm-6">
                    <label>Count of ( : </label><label id="openbracket" name="openbracket" >0</label>
                  </div>
                  <div class="col-sm-6">
                    <label>Count of ) : </label><label id="closebracket" name="closebracket" >0</label>
                  </div>
                </div>

                <div class="formula_box">       
                  <div class="col-8 form-group">
                    <label>Create Formula</label>
                    <textarea name="formula_string" id="formula_string" class="form-control" rows="10" readonly></textarea>
                  </div>
                  <div class="col-4">
                    <button type="button" class="btn btn-default undo_btn" style="">Undo</button>
                  </div>
                </div>
                <input type="hidden" name="formula_expression" id="formula_expression" value="">
                <!-- end of formula string box -->
                  
                <div class="clearfix"></div>
                <div class="row col-12">

                  <!-- Items box -->
                  <div class="col-12 col-sm-8 col-md-4 form-group">
                    <label>Sub-factor</label>
                    <ul class="Cmap_ComptId" id="Cmap_ComptId"></ul>
                  </div>
                  <!-- end of Items box -->
                      
                  <!-- Operators box -->
                  <div class="col-12 col-sm-4 col-md-2 form-group">
                    <label>Operators</label>
                    <ul class="operators">
                      <?php foreach ($operatorsDetails as $operatorsRow) { ?>
                        <li id="<?php echo $operatorsRow->Game_Operators_Value; ?>" value="{<?php echo $operatorsRow->Game_Operators_Value; ?>}"><?php echo $operatorsRow->Game_Operators_String; ?></li>
                      <?php } ?>
                    </ul>
                  </div>
                  <!-- end of Operators box -->

                </div>
                <div class="clearfix"></div>

                <div class="text-center">
                  <button class="btn btn-primary" name="" type="submit">Create Formula</button>
                  <!-- <input type="submit" class="btn btn-primary" name="createFormula" id="createFormula" value="Create Formula"> -->
                  <a href="<?php echo base_url('Competence/itemFormula');?>" class="btn btn-outline-danger">Cancel</a>
                </div>

                </form>
                <!-- <?php //echo form_close();?> -->

              </div>
              <!-- end of adding Formula -->
            </div>
          </div>

<script>
  $(document).ready(function(){
    var formula_expression = [];
    var formula_string     = [];

    //adding operator or item in array and view
    $('.operators,.Cmap_ComptId').on('click', 'li', function(){
      //checking if because if we click on performance type then undefined value is inserted in array
      if($(this).attr('id')){
        formula_expression.push($(this).attr('id'));
        $('#formula_expression').val(formula_expression.join(" "));

        if($(this).attr('value') == '{(}'){
          $('#openbracket').html(parseInt(($('#openbracket').html()),10)+1);      
        }   
        if($(this).attr('value') == '{)}'){
          $('#closebracket').html(parseInt(($('#closebracket').html()),10)+1);
        }

        formula_string.push($(this).attr('value'));
        $('#formula_string').text(formula_string.join(" "));
        //console.log(formula_string);
      } 
    });

    //undo process
    $('.undo_btn').click(function(){
      var fpop  = formula_expression.pop();
      var fspop = formula_string.pop();

      if(fspop == '{(}'){
        $('#openbracket').html(parseInt(($('#openbracket').html()),10)-1);      
      }   
      if(fspop == '{)}'){
        $('#closebracket').html(parseInt(($('#closebracket').html()),10)-1);
      }
      $('#formula_expression').val(formula_expression.join(" "));
      $('#formula_string').text(formula_string.join(" "));
    });

    //on form submit
    $('#itemFormulaForm').submit(function(e){
      e.preventDefault();
      // console.log($(this).serialize());

      //checking if user created any formula or not
      if(formula_expression[0]){
        //console.log(formula_expression);

        //making an array of all items id
        var formula_includes_items = [];
        for(i=0; i<formula_expression.length; i++){
          if(formula_expression[i].includes("item__")){
            formula_includes_items.push(formula_expression[i]);
          }
        }
        //console.log(formula_includes_items);

        //removing item__ from all item list
        var x = formula_includes_items.toString();
        var formatted_Item = x.split('item__');
        //console.log(formatted_Item);

        //storing all item id used in formula in an array formula_includes_items_id
        var formula_includes_items_id = [];
        for(i=0; i<formatted_Item.length; i++){
          if(formatted_Item[i]){
            // console.log(formatted_Item[i]);
            formatted_Item[i] = formatted_Item[i].replace(/,\s*$/, "");
            formula_includes_items_id.push(formatted_Item[i]);
          }
        }
        //console.log(formula_includes_items_id);

        var data = $("#itemFormulaForm").serialize()+'&formula_item_id='+formula_includes_items_id;
        
        $.ajax({
          type: "POST",
          data: data,
          url : "<?php echo base_url('Ajax/itemFormulaFormSubmit/');?>",
          
          success: function(result){
            result = JSON.parse(result);
            if(result.status == 200){
              Swal.fire({
                position: result.position,
                icon: result.icon,
                title: result.title,
                html: result.message,
                showConfirmButton: result.showConfirmButton,
                timer: result.timer,
              }).then(function(){
                  window.location = "itemFormula";
              });
            }
            else{
              Swal.fire({
                icon: 'error',
                title: result.title,
                html: result.message,
              });
            }
          }
        });
      }
      else{
        Swal.fire('Please first create formula');
        return false;
      }
    });//end of form submit
    //=========================================

    //according to selected Enterprise resetting Performance type(items)
    $('#Cmap_Enterprise_ID').on('change', function(){
      var enterprise_ID = $("#Cmap_Enterprise_ID").val();

      var itemOptions   = '<ul class="Cmap_ComptId" id="Cmap_ComptId">';
      if(enterprise_ID){
        $.ajax({
          url    : "<?php echo base_url('Ajax/getCompetenceItems/');?>"+enterprise_ID,
          type   : 'POST',

          beforeSend: function(){ },
          success: function(result){
            result = JSON.parse(result);
            // console.log(result);

            if(result.status == 200){
              let resultItemOptions = result.enterpriseItemsData;

              var itemOptionsCompetence           = '<li style="cursor: context-menu;"><strong>Competence Readiness</strong><li>';
              var itemOptionsApplication          = '<li style="cursor: context-menu;"><strong>Competence Application</strong><li>';
              var itemOptionsSimulatedPerformance = '<li style="cursor: context-menu;"><strong>Simulated Performance</strong><li>';

              $.each(resultItemOptions,function(i,e){
                if(resultItemOptions[i].Compt_PerformanceType == 3){
                  //Simulated Performance
                  itemOptionsSimulatedPerformance += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
                else if(resultItemOptions[i].Compt_PerformanceType == 4){
                  //Competence
                  itemOptionsCompetence += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
                else if(resultItemOptions[i].Compt_PerformanceType == 5){
                  //Application
                  itemOptionsApplication += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
              });
              
              itemOptions += ''+itemOptionsCompetence+''+itemOptionsApplication+''+itemOptionsSimulatedPerformance+'';

              $('#Cmap_ComptId').html(itemOptions+'</ul>');

            }
            else{
              Swal.fire({
                icon: 'error',
                html: result.message,
              });
              $('#Cmap_ComptId').html(itemOptions+'</ul>');
              $('#showResultDataComp').html('<span class="text-danger text-center">Please Select Enterprize to see all sub-factor</span>');
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
        $('#Cmap_ComptId').html(itemOptions+'</ul>');
        return false;
      }
    });//end of function

    //if enterprise login then showing items performance type items wise
    let login_User  = "<?php echo $this->session->userdata('loginData')['User_Role']; ?>";
    if(login_User != 'superadmin'){
      var enterprise_ID = "<?php echo $this->session->userdata('loginData')['User_Id']; ?>";

      var itemOptions   = '<ul class="Cmap_ComptId" id="Cmap_ComptId">';
      if(enterprise_ID){
        $.ajax({
          url    : "<?php echo base_url('Ajax/getCompetenceItems/');?>"+enterprise_ID,
          type   : 'POST',

          beforeSend: function(){ },
          success: function(result){
            result = JSON.parse(result);
            // console.log(result);

            if(result.status == 200){
              let resultItemOptions = result.enterpriseItemsData;

              var itemOptionsCompetence           = '<li style="cursor: context-menu;"><strong>Competence Readiness</strong><li>';
              var itemOptionsApplication          = '<li style="cursor: context-menu;"><strong>Competence Application</strong><li>';
              var itemOptionsSimulatedPerformance = '<li style="cursor: context-menu;"><strong>Simulated Performance</strong><li>';

              $.each(resultItemOptions,function(i,e){
                if(resultItemOptions[i].Compt_PerformanceType == 3){
                  //Simulated Performance
                  itemOptionsSimulatedPerformance += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
                else if(resultItemOptions[i].Compt_PerformanceType == 4){
                  //Competence
                  itemOptionsCompetence += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
                else if(resultItemOptions[i].Compt_PerformanceType == 5){
                  //Application
                  itemOptionsApplication += '<li id="item__'+resultItemOptions[i].Compt_Id+'" value="{'+resultItemOptions[i].Compt_Name+'}" title="'+resultItemOptions[i].Compt_Description+'">'+resultItemOptions[i].Compt_Name+'</li>';
                }
              });
              
              itemOptions += ''+itemOptionsCompetence+''+itemOptionsApplication+''+itemOptionsSimulatedPerformance+'';

              $('#Cmap_ComptId').html(itemOptions+'</ul>');

            }
            else{
              Swal.fire({
                icon: 'error',
                html: result.message,
              });
              $('#Cmap_ComptId').html(itemOptions+'</ul>');
              $('#showResultDataComp').html('<span class="text-danger text-center">Please Select Enterprize to see all sub-factor</span>');
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
        $('#Cmap_ComptId').html(itemOptions+'</ul>');
        return false;
      }
    }

  });

</script>