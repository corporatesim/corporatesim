<script type="text/javascript">
 var loc_url_del  = "ux-admin/ManageEntSubEntUsers/delete/";
 var loc_url_stat = "";
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
      <li class="active"><a href="javascript:void(0);">Manage Enterprise/SubEnterprise Users</a></li>
      <!-- <li class="active"><?php echo $header; ?></li> -->
    </ul>
  </div>
</div>
<!-- DISPLAY ERROR MESSAGE -->
 <!--  <?php  if(!empty($_SESSION['tr_msg'])) { ?>
    <div class="alert-success alert"><?php echo $_SESSION['tr_msg']; ?></div>
  <?php } ?>
  <?php  if(!empty($_SESSION['er_msg'])) { ?>
    <div class="alert-danger alert"><?php echo $_SESSION['er_msg']; ?></div>
    <?php } ?> -->
    <!-- DISPLAY ERROR MESSAGE END -->
    <div id="container">
      <form action="" method="post" id="EntSubEnterpriseUser" name="EntSubEnterpriseUser">
        <!-- Enterprise and Subenterprise drop down -->
        <div class="row">
          <div class="col-md-6" id="Enterprise_Section">
            <label for="Select Enterprise"><span class="alert-danger">*</span>Select Enterprise</label>
            <select name="Enterprise" id="Enterprise" class="form-control">
              <option value="">--Select Enterprise--</option>
              <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" data-enterprise="<?php echo 
                $EnterpriseData->Enterprise_ID; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
              <?php } ?>
            </select>
          </div>
          <input type="hidden" name="Enterprisename" id="Enterprisename">
          <div class="col-md-6" id="SubEnterprise_section">
            <label for="Select SubEnterprise"><span class="alert-danger">*</span>Select SubEnterprise</label>
            <select name="SubEnterprise" id="SubEnterprise" class="form-control">
              <option value="">--Select SubEnterprise--</option>
            </select>
          </div>
          <input type="hidden" name="SubEnterpriseName" id="SubEnterpriseName">
        </div>
        <br><br>
        <div class="row">
          <div class="col-lg-12">
            <div class="pull-right legend">
              <ul>
                <li><b>Legend : </b></li>
                <!-- <li> <span class="glyphicon glyphicon-remove">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="" data-original-title="This Deactive Status"> Deactive  </a></li> -->
                <li> <span class="glyphicon glyphicon-pencil">  </span><a href="javascript:void(0);" data-toggle="tooltip" title="" data-original-title="Edit"> Edit    </a></li>
                <li> <span class="glyphicon glyphicon-trash"> </span><a href="javascript:void(0);" data-toggle="tooltip" title="" data-original-title="Delete"> Delete  </a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row" id="user_section">
          <div class="panel panel-default">
            <div class="panel-heading">
              <label style="padding-top:7px;">Enterprise/SubEnterprise Users List</label>
              <div class="clearfix"></div>
            </div>
            <div class="panel-body">
              <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Enterprise Name</th>
                      <th>SubEnterprise Name</th>
                      <th>User Name</th>
                      <th>User Email</th>
                      <th>Contact</th>
                      <th>Action</th> 
                    </tr></thead>
                    <tbody id="user_data">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
        </form>
      </div>

      <script>

        $(document).ready(function(){
          showAlert();
          //show EnterpriseUsers and dropdown for Subenterprise
          $('#Enterprise').on('change',function(){
            var Enterprise_ID  = $(this).val();
            var EnterpriseName = $(this).find(':selected').data('enterprisename');
            $('#Enterprisename').attr('value',EnterpriseName);
            $('#SubEnterpriseName').attr('value','');
            if($(this).val())
            {
          // triggering ajax to show the Users linked with this Enterprise
          $.ajax({
            url :  "model/ajax/EntSubenterpriseUsers.php",
            type: "POST",
            data: "action=Enterprise_Users&Enterprise_ID="+Enterprise_ID,

            success: function( result )
            {
              //alert(result);
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                var output = "";
                $(result).each(function(i,e)
                {
                  //console.log(result);
                  var userId        = result[i].User_id; 
                  var EncryptUserId = result[i].EncryptUserId; 
                  output +="<tr><td>" +result[i].User_id +"</td><td>" +result[i].Enterprise_Name +"</td><td>" +result[i].SubEnterprise_Name +"</td><td>" +result[i].User_username +
                  "</td><td>" +result[i].User_email +"</td><td>" +result[i].User_mobile +"</td><td><center><a href='<?php echo site_root."ux-admin/ManageEntSubEntUsers/edit/";?>"+EncryptUserId+"' title='Edit'><i class='fa fa-pencil'></i></a> &nbsp; <a href='javascript:void(0);' class='dl_btn' id='"+userId+"' title='Delete'><span class='fa fa-trash'></span></a></center></td></tr>";
                  //alert(output);
                });
                output += "</tbody></table>";
                $('#user_data').html(output);
                //console.log(output);
              }
              else
              {
                output += '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No Records Found</td></tr>';
                $('#user_data').html(output);
                //console.log('here '+output);
              }
              showAlert();
            },
          });

          // triggering ajax to show the subenterprise linked with this enterprise
          $.ajax({
            url : "model/ajax/EntSubenterpriseUsers.php",
            type: "POST",
            data: "action=Subenterprise&Enterprise_ID="+Enterprise_ID,
            success: function( result )
            {
              var option = '<option value="">--Select SubEnterprise--</option>';
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                $(result).each(function(i,e)
                {
                  //console.log(index);
                  option += ('<option value='+result[i].SubEnterprise_ID+' data-subenterpriseid="'+result[i].SubEnterprise_ID+'" data-subenterprisename="'+result[i].SubEnterprise_Name+'">'+result[i].SubEnterprise_Name+'</option>');
                });
               // console.log(option);
               $('#SubEnterprise').html(option);
             }
             else
             {
              $('#SubEnterprise').html(option);
            }
          },
        });          
        }
        else
        {
          alert('Please Select Enterprise...');
          return false;
        }
      });

    //Show SubEnterprise Users List
    $('#SubEnterprise').on('change',function(){
      var element      = $(this);
      var subenterprisename = $(this).find(':selected').data('subenterprisename');
      //console.log(subenterprisename);
      $('#SubEnterprise').attr('value',subenterprisename);
      if($(this).val())
      {
        Enterprise_ID   = $('#Enterprise').val();
        subenterpriseid = $(this).find(':selected').data('subenterpriseid');
        // triggering ajax to show users linked with this enterprise and subenterprise
        $.ajax({
          url :  "model/ajax/EntSubenterpriseUsers.php",
          type: "POST",
          data: "action=EntSubenterprise_Users&SubEnterprise_ID="+subenterpriseid+'&Enterprise_ID='+Enterprise_ID,

          success: function( result )
          {
              //alert(result);
              if(result.trim() != 'no link')
              {
                result = JSON.parse(result)
                var output ="";
                $(result).each(function(i,e)
                {
                  //console.log(result);
                  var userId = result[i].User_id;
                  var EncryptUserId = result[i].EncryptUserId;
                  //console.log(userId);
                  output +="<tr><td>" +result[i].User_id +"</td><td>" +result[i].Enterprise_Name +"</td><td>" +result[i].SubEnterprise_Name +"</td><td>" +result[i].User_username +
                  "</td><td>" +result[i].User_email +"</td><td>" +result[i].User_mobile +"</td><td><center><a href='<?php echo site_root."ux-admin/ManageEntSubEntUsers/edit/";?>"+EncryptUserId+"' title='Edit'><i class='fa fa-pencil'></i></a> &nbsp; <a href='javascript:void(0);' class='dl_btn' title='Delete' id='"+userId+"'><span class='fa fa-trash'></></a></center></td></tr>";
                  //alert(output);
                });
                
                output += "</tbody></table>";
                $('#dataTables-example').html();
                $('#user_data').html(output);
              }
              else
              {
                $('#user_data').html(output);
              }
               showAlert();
            },
          });
      }
      else
      {
        alert('Please Select Subenterprise...');
        return false;
      }
    });
  });
function showAlert()
{
  $('.dl_btn').click( function() {
    $('#cnf_yes').val($(this).attr('id'));
    $('#cnf_del_modal').modal('show');
  });
  $('#cnf_yes').click( function() {
    var val = $(this).val();
    var id = btoa(val);
    window.location.href = site_root + loc_url_del + id;
  });
}
</script>