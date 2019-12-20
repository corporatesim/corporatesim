<?php 
// $csrf = array(
//   'name' => $this->security->get_csrf_token_name(),
//   'hash' => $this->security->get_csrf_hash()
// );
// echo "<pre>"; print_r($csrf); exit();
?>

<div class="" id="outerDiv">
  <h2>Welcome To Mobile Simulation</h2>

  <form class="needs-validation" action="" autocomplete="off" id="loginForm">
    <?php $this->load->view('components/trErAlert'); ?>
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <div class="container">
      <img src="<?php echo base_url('../images/avatar.png'); ?>" alt="Avatar" style="width:100%;">
      <p>Hello. How are you today?</p>
      <p>Please enter your email or username</p>
      <!-- <span class="time-right"><?php echo date('d-m-Y h:i:s'); ?></span> -->
    </div>

    <div class="container darker d-none" id="appendUserEmail">
      <img src="<?php echo base_url('../images/avatar.png'); ?>" alt="Avatar" class="right" style="width:100%;">
      <p id="appendUserEmailData"></p>
      <!-- <span class="time-left"><?php echo date('d-m-Y h:i:s'); ?></span> -->
    </div>

    <div class="container darker d-none" id="appendUserPassword">
      <img src="<?php echo base_url('../images/avatar.png'); ?>" alt="Avatar" class="right" style="width:100%;">
      <p id="appendUserPasswordData"></p>
      <!-- <span class="time-left"><?php echo date('d-m-Y h:i:s'); ?></span> -->
    </div>

    <!-- <div class="clearfix"><br></div> -->
    <!-- for User_Email -->
    <div class="form-row bottom-row" id="emailDiv">
      <div class="input-group col-md-12 mb-12">
        <label for="User_email"></label>
        <input type="text" class="form-control" name="User_email" id="User_email" placeholder="Enter Email/UserName" required="" autocomplete="new-password">
        <!-- <div class="valid-tooltip">
          Please Wait...
        </div> -->
        <div class="invalid-tooltip">
          Provide some inputs
        </div>
        <div class="input-group-append">
          <button class="btn btn-primary" id="emailButton" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
      </div>
    </div> 

    <!-- for Auth_password -->
    <div class="form-row bottom-row d-none" id="passwordDiv">
      <div class="input-group col-md-12 mb-12">
        <label for="Auth_password"></label>
        <input type="password" class="form-control" name="Auth_password" id="Auth_password" placeholder="Enter Password" autocomplete="new-password">
        <!-- <div class="valid-tooltip">
          Please Wait...
        </div> -->
        <div class="invalid-tooltip">
          Provide some inputs
        </div>
        <div class="input-group-append">
          <button class="btn btn-primary" id="passwordButton" type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
      </div>
    </div>    

  </form>
</div>

<script>
  $(document).ready(function(){
    // while click on email button
    $('#emailButton').on('click',function(){
      var User_email = $('#User_email').val();
      if(User_email.trim().length > 1)
      {
        // show user data to user, what he has entered
        $('#appendUserEmail').removeClass('d-none');
        $('#appendUserEmailData').html('You have entered <br><b>'+User_email+'</b> <div class="clearfix"><br></div> <a class="btn btn-outline-danger" href="<?php echo base_url();?>">Cancel</a>');
        $('#emailDiv').addClass('d-none');
        $('#passwordDiv').removeClass('d-none');
      }
      else
      {
        // swal.fire('Email/UserName field is required.');
        Swal.fire({
          title: 'Email/UserName field is required.',
          showClass: {
            popup: 'animated fadeInDown faster'
          },
          hideClass: {
            popup: 'animated fadeOutUp faster'
          }
        })
      }
    });
    // while click on password button
    $('#passwordButton').on('click',function(){
      var Auth_password = $('#Auth_password').val();
      if(Auth_password.trim().length > 1)
      {
        // show pre-loader and trigger ajax to check the login
        $.ajax({
          url     : '<?php echo base_url("AjaxLogin/verifyLogin");?>',
          type    : 'POST',
          // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
          data    : $("form").serialize(),
          success: function(result){
            try
            {
              var result = JSON.parse( result );
              if(result.status == 200)
              {
                window.location = "<?php echo base_url('SelectSimulation');?>";
              }
              else
              {
                $('#appendUserPassword').removeClass('d-none');
                $('#appendUserPasswordData').html('Invalid Credentials. <br> <a class="btn btn-outline-danger" href="<?php echo base_url();?>">Try Again</a>');
                $('#passwordDiv').addClass('d-none');
              }
            }
            catch ( e )
            {
              // swal.fire('Something went wrong. Please try later.');
              Swal.fire({
                title: 'Something went wrong. Please try later.',
                showClass: {
                  popup: 'animated fadeInDown faster'
                },
                hideClass: {
                  popup: 'animated fadeOutUp faster'
                }
              })
              console.log(e + "\n" + result);
            }
          }
        });
        
      }
      else
      {
        // swal.fire('Password field is required.');
        Swal.fire({
          title: 'Password field is required.',
          showClass: {
            popup: 'animated fadeInDown faster'
          },
          hideClass: {
            popup: 'animated fadeOutUp faster'
          }
        })
      }
    });
  });
</script>