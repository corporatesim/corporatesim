      </div>
      
  <!-- <div class="footer-wrap bg-white pd-20 mb-20 border-radius-5 box-shadow">
    Corporate Sim
  </div> -->

    </div>
  </div>

<style>
  .swal-size-sm {
    width: auto;
  }
  .progress-bar.active, .progress.active .progress-bar{
    animation: progress-bar-stripes 2s reverse linear infinite;
    -webkit-animation: progress-bar-stripes 2s reverse linear infinite;
  }

  .buttonclick {
    background-color: #22ACC3;
    color: #fff;
    padding: 10px;
    border: 2px solid #19616f;
    font-size: 15px;
    border-radius: 5px !important;
  }
</style>
  <!-- js -->
  <script src="<?php echo site_root; ?>assets-simulation/vendors/scripts/script.js?v=<?php echo version; ?>"></script>
    
  <script>
    $(document).ready(function() {
    // show guide popup
    $('#showGuide').on('click', function() {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger',
          popup: 'swal-size-sm',
        },
        buttonsStyling: false,
      })
      swalWithBootstrapButtons.fire({
        // icon: 'success',
        title: ' ',
        html: '<section id="modal-plans"><div class="row"><div class="col-md-4 col-12 text-center"><h2 style="color: #d8853e; margin-top: -20px; margin-left: -40px;"><strong>Guide</strong></h2><p style="font-size: 15px; margin-left: -36px;"><strong>Click below for details</strong></p><div class="img-links"><ul style="list-style-type: none;"><li style="text-align: left; margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 57px;" id="0" value="Screen"></li><li style="text-align: left; margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 56px;" id="1" value="Section"></li><li style="text-align: left; margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 51px;" id="2" value="Scenario"></li><li style="text-align: left; margin-bottom: 20px;"><input class="buttonclick" type="button" style="padding: 6px 64px;" id="3" value="Card"></li></ul></div></div><div class="col-md-8 col-12"><div class="featured-img"><img src="https://corpsim.in/corporatesim/picvid/Sapna/default.png" width="100%" alt="image"></div></div></div></section>',
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: 'Close',
      });

      imgSrcArray = ["https://corpsim.in/corporatesim/picvid/Sapna/screen.png", "https://corpsim.in/corporatesim/picvid/Sapna/section.png", "https://corpsim.in/corporatesim/picvid/Sapna/scenario.png", "https://corpsim.in/corporatesim/picvid/Sapna/card.png"];

      function changeImg(arrayIndex) {}
      $('.buttonclick').each(function() {
        $(this).on('click', function() {
          var arrayIndex = $(this).attr('id');
          $('.featured-img img').attr('src', imgSrcArray[arrayIndex]);
          // console.log(arrayIndex);
        });
      });
    });
  });
  </script>
</body>
</html>
