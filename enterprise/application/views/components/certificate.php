<?php
  // setting certificate image in base64
  $certificate1baseimageURL  = 'https://corpsim.in/images/certificate1basicstructure.png';
  // Setting image type
  $certificate1baseimageType = exif_imagetype($certificate1baseimageURL);
  $certificate1baseimageType = image_type_to_mime_type($certificate1baseimageType);

  $certificate1baseimagefilecontent = file_get_contents($certificate1baseimageURL);
  $certificate1baseimagebase64 = rtrim(base64_encode($certificate1baseimagefilecontent));
  $certificate1baseimage = 'data:'.$certificate1baseimageType.';base64,'.$certificate1baseimagebase64;
  // print_r($certificate1baseimage); exit();


  $certificate2baseimageURL  = 'https://corpsim.in/images/certificate2basicstructure.png';
  // Setting image type
  $certificate2baseimageType = exif_imagetype($certificate2baseimageURL);
  $certificate2baseimageType = image_type_to_mime_type($certificate2baseimageType);

  $certificate2baseimagefilecontent = file_get_contents($certificate2baseimageURL);
  $certificate2baseimagebase64 = rtrim(base64_encode($certificate2baseimagefilecontent));
  $certificate2baseimage = 'data:'.$certificate2baseimageType.';base64,'.$certificate2baseimagebase64;
  // print_r($certificate2baseimage); exit();


  $certificate3baseimageURL  = 'https://corpsim.in/images/certificate3basicstructure.png';
  // Setting image type
  $certificate3baseimageType = exif_imagetype($certificate3baseimageURL);
  $certificate3baseimageType = image_type_to_mime_type($certificate3baseimageType);

  $certificate3baseimagefilecontent = file_get_contents($certificate3baseimageURL);
  $certificate3baseimagebase64 = rtrim(base64_encode($certificate3baseimagefilecontent));
  $certificate3baseimage = 'data:'.$certificate3baseimageType.';base64,'.$certificate3baseimagebase64;
  // print_r($certificate3baseimage); exit();
?>
<div class="main-container">
  <!-- <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10"> -->
  <div class="pd-ltr-20 height-100-p xs-pd-20-10">
    <?php $this->load->view('components/trErMsg'); ?>
    <div class="min-height-200px">
      <div class="page-header">

        <div class="row">
          <div class="col-md-6 col-sm-12">
            <div class="title">
              <h1>Certificate</h1>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('Dashboard'); ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Certificate</li>
              </ol>
            </nav>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="title">
              <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix mb-20">
                  <!-- <h5 class="text-blue">List</h5> -->
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="enterpriseDiv">
                  <label for="Enterprise" class="col-sm-12 col-md-3 col-form-label">Select Enterprize</label>
                  <div class="col-sm-12 col-md-9">
                    <select name="Enterprise" id="Enterprise" class="custom-select2 form-control Enterprise">
                      <option value="">--Select Enterprize--</option>
                      <?php foreach ($EnterpriseName as $EnterpriseData) { ?>
                        <option value="<?php echo $EnterpriseData->Enterprise_ID; ?>" date-enterprisename="<?php echo $EnterpriseData->Enterprise_Name; ?>"><?php echo $EnterpriseData->Enterprise_Name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="row col-12 row form-group" id="gameDiv">
                  <label for="selectGame" class="col-12 col-md-3 col-form-label">Select Card</label>
                  <div class="col-12 col-md-9">
                    <select name="selectGame" id="selectGame" class="custom-select2 form-control" required="">
                      <option value="">--Select Card--</option>
                    </select>
                  </div>
                </div>

                <div id="assignDate" class="row col-12 row form-group">
                  <label for="date" class="col-12 col-md-3 col-form-label">Select Date</label>
                  <div class="col-12 col-md-5">
                    <div class="input-group" name="gamedate" id="datepicker">
                      <input type="text" class="form-control datepicker-here" id="gamestartdate" name="gamestartdate" value="" data-value="<?php echo time(); ?>" placeholder="Select Start Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time();?>" data-language="en" data-date-format="dd-mm-yyyy">

                      &nbsp;&nbsp; <span class="input-group-addon">To</span> &nbsp;&nbsp;

                      <input type="text" class="form-control datepicker-here" id="gameenddate" name="gameenddate" value="" data-value="<?php echo time(); ?>" placeholder="Select End Date" required="" readonly="" data-startdate="1554069600" data-enddate="<?php echo time(); ?>" data-language="en" data-date-format="dd-mm-yyyy">
                    </div>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group" id="certificateTypeDiv">
                  <label for="certificateType" class="col-sm-12 col-md-3 col-form-label">Select Certificate Type</label>
                  <div class="col-sm-12 col-md-5">
                    <select name="certificateType" id="certificateType" class="custom-select2 form-control certificateType">
                      <option value="1" selected>1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>

                  <!-- Get Users Button -->
                  <div class="col-12 col-md-2">
                    <input id="getUsers" value="Get Users" class="btn btn-primary getUsers" readonly>
                  </div>
                </div>

                <div class="row col-md-12 col-lg-12 col-sm-12 row form-group">
                    <div class="input-group">
                      <div class="avatar-image">
                        <img id="imageView" src="https://corpsim.in/images/certificatetypes.png" alt="image" class="avatar-img rounded" style="cursor: pointer;">
                      </div>
                    </div>
                    <!-- <label>Click On Image to view full image</label> -->
                  </div>

                <div class="clearfix"></div>

                <div class="table-responsive pt-5" id="returnTableHTML">
                  <!-- Adding datatable here -->
                </div>

              </div>
            </div>
          </div>
        </div>


<script>
  // show image model on click
  // $('img').on('click',function() {
  $(document).on('click', '#imageView', function () {
    var imageUrl  = $(this).attr('src');
    // alert(this.width + 'x' + this.height);
    // console.log(imageUrl);

    Swal.fire({
      // imageWidth       : 700,
      // imageHeight      : 400,
      imageUrl         : imageUrl,
      imageAlt         : 'Custom image',
      // icon             : 'success',
      // title            : '',
      // showConfirmButton: true,
      showConfirmButton: false,
      // html             : '',
      // footer           : '',
      // showCancelButton : false,
      // cancelButtonColor: '#3085d6',
      // footer           : ''
    });
  });


  $(document).ready(function() { 

    $('#Enterprise').on('change',function(){
      var optionList    = '<option value="">--Select Card--</option>';
      var enterprise_ID = $(this).val();

      if (enterprise_ID) {
        // triggering ajax to show the enterprize game
        $.ajax({
          url :"<?php echo base_url();?>Ajax/fetchAssignedGames/enterpriseUsers/"+enterprise_ID,
          type: "POST",
          success: function(result){
            if (result == 'No Card found') {
              Swal.fire('No Card allocated to selected Enterprize');
              $('#selectGame').html(optionList);
            }
            else {
              result = JSON.parse(result);
              $(result).each(function(i, e) {
                optionList += ("<option value='"+result[i].Game_ID+"'>"+result[i].Game_Name+"</option>");
              });
              $('#selectGame').html(optionList);
            }
          },
        });
      }
      else {
        Swal.fire('Please Select Enterprize');
        return false;
      }
    });
  });

  $('.getUsers').on('click', function() {
    // Removing previous User List Table
    $('#returnTableHTML').html('');
    
    var gameId          = $('#selectGame').val();
    var enterpriseId    = $('#Enterprise').val();
    var siteUsers       = '';

    var gamestartdate   = $("#gamestartdate").val();
    var gameenddate     = $("#gameenddate").val();

    // console.log(`
    //   Start Date - ${gamestartdate}
    //   end Date   - ${gameenddate}
    // `);

    if (gamestartdate == "" && gameenddate == "") {
      Swal.fire('Please select start and end date');
    } 
    else if (gamestartdate == "") {
      Swal.fire('Please Select Start Date');
    } 
    else if (gameenddate == "") {
      Swal.fire('Please Select End Date');
    }
    // else if (gamestartdate <= gameenddate) {
    //  Swal.fire('Please make sure End Date is greater then Start Date');
    // } 
    else if (gamestartdate && gameenddate) {

      if (gameId < 1 || gameId == '--Select Card--') {
        // Card not Selected
        // removing table if user not Selected Card
        $('#returnTableHTML').html('<span class="text-danger text-center">Please Select Card To View Users List</span>');
      }
      else {
        // show wait text to users
        $('#returnTableHTML').html('<span class="text-success text-center">Please Wait While Loading Users List</span>');

        $.ajax({
          url      : "<?php echo base_url('Certificate/getCertificateTableData'); ?>",
          type     : "POST",
          dataType : 'html',
          data     : "gameId="+gameId+"&enterpriseId="+enterpriseId+"&gamestartdate="+gamestartdate+"&gameenddate="+gameenddate,

          success: function(result) {
            result = JSON.parse(result);
            // console.log(result.status);

            switch (result.status) {
              case '200':
                // putting whole regenerated table
                $('#returnTableHTML').empty();
                $('#returnTableHTML').html(result.data);
                makeTableDataTable();
                break;

              case '201':
                Swal.fire(result.title, result.message, {
                  icon : result.icon,
                  buttons: {
                    confirm: {
                      className : result.button
                    }
                  },
                });
                break;
            }
          },
        });
      }
    }
  });

function downloadCertificate(e) {
  var userName        = $(e).data('name');
  var gameName        = $(e).data('gamename');
  var CompletionDate  = $(e).data('completiondate');
  var emailID         = $(e).data('emailid');

  var certificateType = $('#certificateType').val();
  
  // setting base64 image based on Selected certificate type
  if (certificateType == 2) {
    var certificatebaseimage = "<?php echo $certificate2baseimage; ?>";
  }
  else if (certificateType == 3) {
    var certificatebaseimage = "<?php echo $certificate3baseimage; ?>";
  } 
  else {
    var certificatebaseimage = "<?php echo $certificate1baseimage; ?>";
  }

  // ================================================ 
  // jsPDF(orientation, unit, format)
  // orientation One of "portrait" or "landscape" (or shortcuts "p" (Default), "l")
  // unit Measurement unit to be used when coordinates are specified. One of "pt" (points), "mm" (Default), "cm", "in"
  // format One of 'a3', 'a4' (Default),'a5' ,'letter' ,'legal'

  // var pdf = new jsPDF('p', 'pt', 'letter');
  // var pdf = new jsPDF();

  // Document of 220 mm high and 320 mm wide
  var pdf = new jsPDF('l', 'mm', [220, 310]);

  pdf.addImage(certificatebaseimage, 'PNG', 0, 0, 310, 220);

  pdf.setFont("Courier");
  // pdf.setFontType("bold");
  pdf.setTextColor(255,152,0);
  pdf.setFontSize(30);
  var textContent = userName;
  var textWidth = pdf.getStringUnitWidth(textContent) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;
  var textOffset = (pdf.internal.pageSize.width - textWidth) / 2;
  pdf.text(textOffset, 110, textContent);

  pdf.setFont("Courier");
  pdf.setTextColor(0,0,0);
  pdf.setFontSize(20);
  pdf.text(87, 185, CompletionDate);

  // ================================================
  // pdf.save('certificate-'+certificateType+'.pdf');
  var pdffile = btoa(pdf.output());
  // console.log(pdffile);

  // e.preventDefault();
  var data = new FormData();
      data.append('emailID', emailID);
      data.append('userName', userName);
      data.append("pdffile" , pdffile);

  $.ajax({
    type     : "POST",
    url      : "<?php echo base_url('Certificate/send_mail_pdf'); ?>",
    // data     : "pdfContents="+pdfContents+"&emailID="+emailID+"&userName="+userName+"&pdfName="+pdfName,
    data     : data,
    // data     : "pdfContents="+pdfContents+"&emailID="+emailID+"&userName="+userName,
    // data: {pdffile: pdffile},

    mimeType: "multipart/form-data",
    contentType: false,
    cache: false,
    dataType: "html",
    processData: false,

    success: function(result) {
      result = JSON.parse(result);
      // console.log(result.status);

      switch (result.status) {
        case '200':
          Swal.fire(result.title, result.message, {
            icon : result.icon,
            buttons: {
              confirm: {
                className : result.button
              }
            },
          });
          break;

        case '201':
          Swal.fire(result.title, result.message, {
            icon : result.icon,
            buttons: {
              confirm: {
                className : result.button
              }
            },
          });
          break;
      }
    },
  });
}
</script>