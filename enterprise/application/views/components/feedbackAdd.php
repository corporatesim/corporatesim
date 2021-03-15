<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Add Feedback</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('feedback'); ?>">Feedback</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Feedback</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <!-- <h5 class="text-blue">Master List</h5> -->
                </div>

                <!-- Start Form -->
                <form action="#" method="POST" id="formHTML">

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackUserID">User ID</label>
                    <div class="col-sm-12 col-md-5">
                      <input type="number" class="form-control" name="feedbackUserID" id="feedbackUserID" value="" placeholder="Enter User ID">
                      <span id="feedbackUserIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackName">Name <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input type="text" class="form-control" name="feedbackName" id="feedbackName" value="" placeholder="Enter Full Name" required>
                      <span id="feedbackNameError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackEmailID">Email ID <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input type="email" class="form-control" name="feedbackEmailID" id="feedbackEmailID" value="" placeholder="Enter Email ID" required>
                      <span id="feedbackEmailIDError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackMobileNo">Mobile No.</label>
                    <div class="col-sm-12 col-md-5">
                      <input type="number" class="form-control" name="feedbackMobileNo" id="feedbackMobileNo" value="" placeholder="Enter Mobile No.">
                      <span id="feedbackMobileNoError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackRating">Rating</label>
                    <div class="col-sm-12 col-md-5">
                      <!-- step=".1" -->
                      <input type="number" class="form-control" name="feedbackRating" id="feedbackRating" value="0" min="0" max="5" placeholder="Enter Rating">
                      <span id="feedbackRatingError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackTitle">Feedback Title <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <input type="text" class="form-control" name="feedbackTitle" id="feedbackTitle" value=""  placeholder="Feedback Title" required>
                      <span id="feedbackTitleError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="row form-group col-12">
                    <label class="col-sm-12 col-md-3 col-form-label" for="feedbackMessage">Feedback Message <span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-md-5">
                      <textarea name="feedbackMessage" id="feedbackMessage" class="form-control" rows="10" required></textarea>
                      <span id="feedbackMessageError" class="removemsg text-danger"></span>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary px-5"><span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit</button>
                    <a href="<?php echo base_url('feedback'); ?>"><button type="button" name="submit"class="btn btn-danger px-5"><span class="btn-label"><i class="fa fa-times-circle"></i></span>&nbsp;Cancel</button></a>
                  </div>

                </form>
                <!-- End Form -->

              </div>
            </div>
          </div>
        </div>

<script>
  $(document).ready(function() {

    // on form submit
    $('#formHTML').submit(function(e) {
      // removing all error message when form submit
      $(".removemsg").html('');

      // disable button
      $('#submit').prop("disabled", true);
      // adding spinner to button
      $('#submit').html('<span class="btn-label"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>');

      e.preventDefault();
      //var data = $("#formHTML").serialize();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('feedback/addUpdateFeedback'); ?>",
        data: new FormData(document.getElementById('formHTML')),
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        dataType: "html",
        processData: false,
                
        success: function(result) {
          result = JSON.parse(result);
          // console.log(result);

          // enabling button
          $('#submit').prop("disabled", false);
          // removing spinner from button
          $('#submit').html('<span class="btn-label"><i class="fa fa-save"></i></span>&nbsp;Submit');
          
          switch (result.status) {
            case 'error':
              // console.log(result.message);
              $("#feedbackUserIDError").html(result.message.feedbackUserIDError);
              $("#feedbackNameError").html(result.message.feedbackNameError);
              $("#feedbackEmailIDError").html(result.message.feedbackEmailIDError);
              $("#feedbackMobileNoError").html(result.message.feedbackMobileNoError);
              $("#feedbackRatingError").html(result.message.feedbackRatingError);
              $("#feedbackTitleError").html(result.message.feedbackTitleError);
              $("#feedbackMessageError").html(result.message.feedbackMessageError);

              // Setting error message on pop up
              if (result.message.feedbackUserIDError)
                var errorMessage = $(result.message.feedbackUserIDError).text();
              else if (result.message.feedbackNameError)
                var errorMessage = $(result.message.feedbackNameError).text();
              else if (result.message.feedbackEmailIDError)
                var errorMessage = $(result.message.feedbackEmailIDError).text();
              else if (result.message.feedbackMobileNoError)
                var errorMessage = $(result.message.feedbackMobileNoError).text();
              else if (result.message.feedbackRatingError)
                var errorMessage = $(result.message.feedbackRatingError).text();
              else if (result.message.feedbackTitleError)
                var errorMessage = $(result.message.feedbackTitleError).text();
              else if (result.message.feedbackMessageError)
                var errorMessage = $(result.message.feedbackMessageError).text();

              // Showing Pop up error message
              Swal.fire('Error', errorMessage, {
                icon : 'error',
                buttons: {
                  confirm: {
                    className : 'btn btn-danger'
                  }
                },
              });
              break;

            case '200':
              Swal.fire(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              }).then(function(){
                  window.location = "<?php echo base_url('feedback'); ?>";
              });
              break;

            case '201':
              swal(result.title, result.message, {
                icon : result.icon,
                buttons: {
                  confirm: {
                    className : result.button
                  }
                },
              });
              break;
          }
        }
      });
    }); // end of form submit

  });
</script>