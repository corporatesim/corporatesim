<style>
  .swal-size-sm {
    width: auto;
  }
</style>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">
      <?php if ($functionsObj->checkModuleAuth('linkgame', 'add')) { ?>
        <a href="javascript:void(0);" id="addJsGame" data-toggle="tooltip" title="Add Js Game To Link">
          <i class="fa fa-plus-circle"></i>
        </a>
      <?php } ?>
      Game Integration
    </h1>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <ul class="breadcrumb">
      <li class="completed"><a href="<?php echo site_root . "ux-admin/Dashboard"; ?>">Home</a></li>
      <li class="completed">Link Management</li>
      <li class="active">Game Integration</li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="pull-right legend">
      <ul>
        <li><b>Legend : </b></li>
        <li> <span class="glyphicon glyphicon-ok"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This is Active Status"> Active </a></li>
        <li> <span class="glyphicon glyphicon-remove"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="This Deactive Status"> Deactive </a></li>
        <li> <span class="glyphicon glyphicon-pencil"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Edit the Record"> Edit </a></li>
        <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="User Can Delete the Record"> Delete </a></li>
      </ul>
    </div>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <label style="padding-top:7px;">List</label>
      <div class="clearfix"></div>
    </div>
    <div class="panel-body">
      <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover text-center" id="dataTables-serverSide" data-url="<?php echo site_root . 'ux-admin/model/ajax/dataTables.php'; ?>" data-action="linkgame">
          <thead>
            <tr>
              <th>#</th>
              <th>JS Game</th>
              <th>Game</th>
              <th>Scenario</th>
              <th>Data Elements</th>
              <th>Elements Alias</th>
              <th>Mapped Component</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<script>
  $(document).ready(function() {
    // setting the ajax url globally
    ajaxUrl = "<?php echo site_root . 'ux-admin/model/ajax/gameAddMapping.php'; ?>";

    var gameData = "<select name='Js_GameId' class='form-control' onchange='return fetchScenario(this.value);'><option value=''>--Select Game--</option>";
    <?php foreach ($gameData as $gameRow) { ?>
      gameData += "<option value='<?php echo $gameRow->Game_ID; ?>'><?php echo $gameRow->Game_Name; ?></option>";
    <?php } ?>
    gameData += "</select>";
    $('#addJsGame').on('click', function() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
          popup: 'swal-size-sm',
        },
        buttonsStyling: false,
      });
      swalWithBootstrapButtons.fire({
        // icon: 'success',
        // addClass: 'swal-size-sm',
        title: "Add Game And It's Element",
        html: '<form id="addFormData" action="" method="post"><input type="hidden" name="action" value="addGameData"> <input type="hidden" id="Js_LinkId" name="Js_LinkId" value=""> <div class="form-row"> <div class="col-md-4">JS Game Name </div> <div class="col-md-6"><input type="text" class="form-control" name="Js_Name" required placeholder="Enter JS Game Name"></div><div class="col-md-2"><button type="button" onclick="return addParentDiv();" class="btn btn-success" title="Click to add game element and alias">+</button></div><br><br><div class="form-row"><div class="col-md-6">' + gameData + '</div><div class="col-md-6"><select id="Js_ScenId" name="Js_ScenId" onclick="return setLinkId(this);" class="form-control"><option value="">--Select Scenario--</option></select></div></div><br><div class="clearfix"></div><br><div class="form-row" id="addElementAlias"><div class="col-md-12"><div class="col-md-6">Element Name</div><div class="col-md-4">Alias</div><div class="col-md-2"></div></div><div class="col-md-12"><div class="col-md-6"><input type="text" class="form-control col-md-6" name="Js_Element[]" required placeholder="Enter Element Name"></div><div class="col-md-4"><input type="text" class="form-control col-md-4" name="Js_Alias[]" placeholder="Enter Alias"></div></div></div></div><div class="clearfix"></div><br><button type="submit" id="submitForm" onclick="return addGameDataFn(event);" class="btn btn-primary">Add</button> <button type="button" class="btn btn-danger" onclick="return swal.close();">Cancel</button></form>',
        showConfirmButton: false,
        // showCancelButton: true,
        // confirmButtonText: 'Add'
        allowOutsideClick: false, // this won't close alert if click is outside
        showClass: {
          popup: 'animated ' + animateInArray[countInclick] + ' faster'
        },
        hideClass: {
          popup: 'animated ' + animateOutArray[countOutclick] + ' faster'
        }
      });
      countInclick++;
      countOutclick++;
      countInclick = (countInclick == animateInArray.length) ? 0 : countInclick;
      countOutclick = (countOutclick == animateOutArray.length) ? 0 : countOutclick;
    });
  });

  function addParentDiv(element) {
    // $(element).parent('div').remove();
    $('#addElementAlias').append('<br><div style="margin:5px 0 5px 0;" class="col-md-12"><div class="col-md-6"><input type="text" class="form-control col-md-6" name="Js_Element[]" required placeholder="Enter Element Name"></div><div class="col-md-4"><input type="text" class="form-control col-md-4" name="Js_Alias[]" placeholder="Enter Alias"></div><button type="button" class="btn btn-danger" onclick="return removeParentDiv(this);" Zclass="removeParentDiv" title="Remove Element and Alias">-</button></div>');
  }

  function removeParentDiv(element) {
    $(element).parent('div').remove();
  }

  function addGameDataFn(e) {
    e.preventDefault();
    var addFormData = $('#addFormData').serialize();
    var insertRecord = triggerAjax(ajaxUrl, addFormData, 'show');
    // $('#dataTables-serverSide').DataTable().ajax.reload();
  }

  function fetchScenario(gameid) {
    var postData = "action=fetchScenario&gameid=" + gameid;
    var allScenarios = triggerAjax(ajaxUrl, postData, 'return');
    setTimeout(function() {
      if (allScenarios[0].status == 200) {
        var scenOptions = "<option value=''> - Select Scenario - </option>";
        $.each(allScenarios[0].data, function(i, e) {
          scenOptions += "<option value='" + e.Scen_ID + "' data-linkid='" + e.Link_ID + "'>" + e.Scen_Name + "</option>";
        });
        $('#Js_ScenId').html(scenOptions);
      } else {
        $('#Js_ScenId').html("<option value=''>--Select Game--</option>");
        alert(allScenarios[0].msg);
      }
    }, 1000);
  }

  function setLinkId(element) {
    // console.log($(element).find(':selected').data('linkid'));
    var selectedLinkid = $(element).find(':selected').data('linkid');
    $('#Js_LinkId').val(selectedLinkid);
  }

  function deleteGameIntegration(Js_id) {
    Swal.fire({
      icon: 'question',
      title: 'Confirmation',
      html: "Are you sure want to delete?",
      showCancelButton: true,
    }).then((result) => {
      if (result.value) {
        var deleteData = triggerAjax(ajaxUrl, "action=deleteIntegration&Js_id=" + Js_id, "show");
        // $('#dataTables-serverSide').DataTable().ajax.reload();
        // console.log('delete');
      }
    });

  }

  function activeDeactive(Js_id, Js_Status) {

    Swal.fire({
      icon: 'question',
      title: 'Confirmation',
      html: "Are you sure want to change status?",
      showCancelButton: true,
    }).then((result) => {
      if (result.value) {
        var changeStatus = triggerAjax(ajaxUrl, "action=changeStatus&Js_id=" + Js_id + "&Js_Status=" + Js_Status, "show");
        // $('#dataTables-serverSide').DataTable().ajax.reload();
      }
    });
  }

  function showEditGameIntegration(element) {
    var editFormData = window.atob($(element).data('formdata'));
    // console.log(editFormData)
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger',
        popup: 'swal-size-sm',
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons.fire({
      // icon: 'success',
      // addClass: 'swal-size-sm',
      title: "Edit Game Integration Mapping",
      html: editFormData,
      showConfirmButton: false,
      // showCancelButton: true,
      // confirmButtonText: 'Add'
      allowOutsideClick: false, // this won't close alert if click is outside
      showClass: {
        popup: 'animated ' + animateInArray[countInclick] + ' faster'
      },
      hideClass: {
        popup: 'animated ' + animateOutArray[countOutclick] + ' faster'
      }
    });
    countInclick++;
    countOutclick++;
    countInclick = (countInclick == animateInArray.length) ? 0 : countInclick;
    countOutclick = (countOutclick == animateOutArray.length) ? 0 : countOutclick;
  }

  function editGameIntegration(e) {
    // submitting the edited form
    e.preventDefault();
    var editFormData = $('#editFormData').serialize();
    console.log(editFormData);
    var updateData = triggerAjax(ajaxUrl, editFormData, 'show');
    // $('#dataTables-serverSide').DataTable().ajax.reload();
  }

  function triggerAjax(url, data, showAlert) {
    // console.log(showAlert); console.log(url); console.log(data); return false; // triggering ajax for various operations
    var returnResult = [];
    fetch(url, {
      method: 'post',
      headers: {
        'Accept': 'application/json, text/plain, */*',
        "Content-type": "application/x-www-form-urlencoded;"
        // "Content-type": "application/json;"
      },
      body: data,
    }).then(function(response) {
      return response.json();
    }).then(function(result) {
      // show returned response here
      if (showAlert == 'show') {
        if (result.status == 200) {
          Swal.fire({
            icon: result.icon,
            html: result.msg,
            position: result.position,
            timer: result.timer,
            showConfirmButton: false,
            showClass: {
              popup: result.showclass
            },
            hideClass: {
              popup: result.hideclass
            }
          });
        } else {
          alert(result.msg);
        }
      } else if (showAlert == 'return') {
        returnResult.push(result);
      } else {
        console.log(result);
      }
      $('#dataTables-serverSide').DataTable().ajax.reload();
    }).catch(function(err) {
      console.log('Fetch Error :-S', err);
    });
    return returnResult;
  }
</script>