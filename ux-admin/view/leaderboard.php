
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
    <h1 class="page-header">
      <?php if($functionsObj->checkModuleAuth('leaderboard','add')){ ?>
        <a href="javascript:void(0);" data-toggle="tooltip" title="Add Leaderboard/Collaboration" id="addLeaderboard">
          <i class="fa fa-plus-circle" data-toggle="modal" data-target="#addLeaderboardModel"></i>
        </a>
      <?php } ?>
      <?php echo $header; ?>
    </h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed">
        <a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a>
      </li>
      <li class="active">
        <a href="<?php echo site_root."ux-admin/leaderboard"; ?>">Leaderboard/Collaboration</a>
      </li>
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
  <!-- adding model to add leaderboard data -->
  <div class="modal fade" id="addLeaderboardModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Add Leaderboard/Collaboration Data</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="leaderboardCollaborationAddForm" method="post">
          <input type="hidden" name="action" value="saveResponse">
          <div class="modal-body">

            <div class="form-group">
              <label for="Lead_GameId" class="col-form-label">Select Game:</label>
              <select name="Lead_GameId" id="Lead_GameId" class="form-control" required="">
                <option value="">- Select Game -</option>
              </select>
            </div>

            <div class="form-group">
              <label for="Lead_ScenId" class="col-form-label">Select Scenario:</label>
              <select name="Lead_ScenId" id="Lead_ScenId" class="form-control" required="">
                <option value="">- Select Scenario -</option>
              </select>
            </div>

            <div class="form-group">
              <label for="Lead_CompId" class="col-form-label">Select Component:</label>
              <select name="Lead_CompId" id="Lead_CompId" class="form-control" required="">
                <option value="">- Select Component -</option>
              </select>
            </div>

            <div class="form-group">
              <label for="" class="col-form-label">Type</label>
            </div>
            <div class="form-group">
              <label for="leaderboard" class="containerRadio col-md-6"> Leaderboard
               <input type="radio" name="Lead_BelongTo" id="leaderboard" value="0" required=""> 
               <span class="checkmarkRadio"></span>
             </label>

             <label for="collaboration" class="containerRadio col-md-6"> Collaboration
               <input type="radio" name="Lead_BelongTo" id="collaboration" value="1" required=""> 
               <span class="checkmarkRadio"></span>
             </label>
           </div>

           <div class="form-group">
            <label for="" class="col-form-label">Order</label>
          </div>
          <div class="form-group">
            <label for="Ascending" class="containerRadio col-md-6"> Ascending
             <input type="radio" name="Lead_Order" id="Ascending" value="0" required=""> 
             <span class="checkmarkRadio"></span>
           </label>

           <label for="Descending" class="containerRadio col-md-6"> Descending
             <input type="radio" name="Lead_Order" id="Descending" value="1" required=""> 
             <span class="checkmarkRadio"></span>
           </label>
         </div>

         <div class="row col-md-12 alert-danger" id="showAlertMessage">Make sure that o/p component is not hidden</div>
       </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="closeAddLeaderboardModel">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Leaderboard/Collaboration List
    <a href="javascript:void(0);" class="pull-right" data-toggle="tooltip" title="Refresh Table Data" id="refreshServerSideDataTable">
      <i class="fa fa-refresh"></i>
    </a>
  </div>
  <div class="panel-body">
    <div class="dataTable_wrapper">
      <table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root.'ux-admin/model/ajax/dataTables.php';?>" data-action="leaderboard" data-function="deleteLeaderCollab()">
        <thead>
          <th>S.N.</th>
          <th>Game Name</th>
          <th>Scenario Name</th>
          <th>O/P Component Name</th>
          <th>Type</th>
          <th>Order</th>
          <th class="no-sort">Creator</th>
          <th class="no-sort">Action</th>
        </thead>
      </table>
    </div>
  </div>
</div>


</div>

<script>
  $(document).ready(function(){
    // append games to model drop-down for games
    $('#addLeaderboard').on('click',function(){
      var url      = "model/ajax/populate_dropdown.php";
      var data     = {'action':'leaderboard_collaboration'};
      var appendId = "Lead_GameId";
      $("#Lead_GameId").html('');
      $("#Lead_ScenId").html('');
      $("#Lead_CompId").html('');
      triggerAjax(url,data,appendId);
    });

    // when user change the game then get the scenario accordingly
    $('#Lead_GameId').on('change',function(){
      var gameid   = $(this).val();
      var data     = {'action':'leaderboard_collaboration_scenario', 'gameid':gameid};
      var url      = "model/ajax/populate_dropdown.php";
      var appendId = 'Lead_ScenId';
      // when parent is changed then make all child empty first
      $('#'+appendId).html("<option value=''>--Select Scenario--</option>");
      if(gameid<1)
      {
        Swal.fire({
          icon: 'error',
          title: 'Pease Select Game',
        });
        return false;
      }
      triggerAjax(url,data,appendId);
    });

    // when user change the scenario then get the visible o/p component
    $('#Lead_ScenId').on('change',function(){
      var scenid   = $(this).val();
      var gameid   = $('#Lead_GameId').val();
      var data     = {'action':'leaderboard_collaboration_component', 'gameid':gameid, 'scenid':scenid};
      var url      = "model/ajax/populate_dropdown.php";
      var appendId = 'Lead_CompId';
      // when parent is changed then make all child empty first
      $('#'+appendId).html("<option value=''>--Select Component--</option>");
      if(gameid<1 || scenid<1)
      {
        Swal.fire({
          icon: 'error',
          title: 'Pease Select Game/Scenario',
        });
        return false;
      }
      triggerAjax(url,data,appendId);
    });

    // while user add or submit the form for adding leaderboard/collaboration data
    $('#leaderboardCollaborationAddForm').on('submit',function(e){
      e.preventDefault();
      // getting the selected game data-attribute
      var data          = $( this ).serialize();
      var url           = "model/ajax/populate_dropdown.php";
      var collaboration = $("#Lead_GameId").find(':selected').data('collaboration');
      var leaderboard   = $("#Lead_GameId").find(':selected').data('leaderboard');
      var Lead_BelongTo = $("input[name='Lead_BelongTo']:checked").val();
      if(Lead_BelongTo == 1 && collaboration == 'exist')
      {
        console.log('already exist collaboration');
        Swal.fire({
          icon: 'error',
          html: 'Already exist collaboration for the selected game/scenario.',
        });
        return false;
      }
      if(Lead_BelongTo == 0 && leaderboard == 'exist')
      {
        console.log('already exist leaderboard');
        Swal.fire({
          icon: 'error',
          html: 'Already exist leaderboard for the selected game/scenario.',
        });
        return false;
      }
      triggerAjax(url,data);

      // console.log(Lead_BelongTo);
      // console.log(data);
      // console.log(leaderboard);
      // console.log(collaboration);
    });
  });

  function deleteLeaderCollab()
  {
    $('.deleteLeaderCollab').on('click',function(){
      var Lead_Id = $(this).attr('id');
      var url     = "model/ajax/populate_dropdown.php";
      var data    = {'action':'deleteResponse', 'Lead_Id':Lead_Id};
      Swal.fire({
        title             : 'Are you sure?',
        text              : "You won't be able to revert this!",
        icon              : 'warning',
        showCancelButton  : true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor : '#d33',
        confirmButtonText : 'Yes, Proceed!'
      }).then((result) => {
        if (result.value) {
          triggerAjax(url,data);
        }
      })
    });
  }

  function triggerAjax(url,data,appendId)
  {
    $.ajax({
      url :  url,
      type: "POST",
      data: data,
      success: function( result )
      {
        result = JSON.parse(result);
        if(result.status == 200)
        {
          if(appendId)
          {
            // while appending data to dropdown
            $('#'+appendId).html(result.options);
          }
          else
          {
            // while saving data to database
            Swal.fire({
              icon: 'success',
              html: result.message,
            });
            // close model
            $('#closeAddLeaderboardModel').trigger('click');
          }
          // when done every thing then reload the dataTable
          $('#refreshServerSideDataTable').trigger('click');
          // $('#dataTables-serverSide').DataTable().ajax.reload();
        }
        else
        {
          Swal.fire({
            icon: 'error',
            html: result.message,
          });
        }
      },
      error: function(err,msg){
        console.log(err);
      }
    });
  }
</script>
