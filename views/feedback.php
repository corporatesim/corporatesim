<?php 
include_once 'includes/headerNav.php'; 
  // include_once 'includes/header.php'; 
  // include_once 'includes/header2.php'; 
?>
<style>
  .text-errorMsg{
    background: white;
    color: red;
  }

  fieldset, label { margin: 0; padding: 0; }

  /* Style Star Rating */
  .rating { 
    border: none;
    float: left;
  }

  .rating > input { display: none; } 
  .rating > label:before { 
    margin: 5px;
    font-size: 1.25em;
    font-family: FontAwesome;
    display: inline-block;
    content: "\f005";
  }

  .rating > .half:before { 
    content: "\f089";
    position: absolute;
  }

  .rating > label { 
    color: #ddd; 
   float: right; 
  }

  /* CSS Magic to Highlight Stars on Hover */

  .rating > input:checked ~ label, /* show gold star when clicked */
  .rating:not(:checked) > label:hover, /* hover current star */
  .rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

  .rating > input:checked + label:hover, /* hover current star when changing rating */
  .rating > input:checked ~ label:hover,
  .rating > label:hover ~ input:checked ~ label, /* lighten current selection */
  .rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
</style>

<div class="row" style="margin-top:2%;">
  <div class="container col-md-7" style="margin-left:30%;" >
    <span class="anchor" id="formUserEdit"></span>
    <!-- form user info -->
    <div class="card card-outline-secondary">
      <div class="card-header">
        <?php if(isset($msg)) { ?>
          <div class="text-errorMsg text-center"><b><?php echo $msg;?></b></div>
        <?php unset($msg); } ?>
        <h3 style="color:#ffffff;" class="mb-0 text-center">Feedback</h3>
      </div>
      <div class="card-body" style="margin: 5%;" >
        <form class="form-group" role="form" autocomplete="off" method="post" action="">
          <div class="form-group row">
            <label class="col-lg-2 col-form-label form-control-label">Title</label>
            <div class="col-lg-9">
              <input class="form-control" type="text" name="title" id="title" value="" required="" style="border-radius: 4px !important;">
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-2 col-form-label form-control-label">Message</label>
            <div class="col-lg-9">
              <textarea class="form-control" type="textarea" rows="5" name="message" id="message" value="" required=""></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-lg-2 col-form-label form-control-label">Rating</label>
            <div class="col-lg-9">
              <fieldset class="rating">
                <!-- 5 -->
                <input type="radio" id="star5" name="rating" value="5" />
                <label class="full" for="star5" title="5 stars"></label>
                <!-- 4.5 -->
                <!-- <input type="radio" id="star4half" name="rating" value="4.5" />
                <label class="half" for="star4half" title="4.5 stars"></label> -->
                <!-- 4 -->
                <input type="radio" id="star4" name="rating" value="4" />
                <label class="full" for="star4" title="4 stars"></label>
                <!-- 3.5 -->
                <!-- <input type="radio" id="star3half" name="rating" value="3.5" />
                <label class="half" for="star3half" title="3.5 stars"></label> -->
                <!-- 3 -->
                <input type="radio" id="star3" name="rating" value="3" />
                <label class="full" for="star3" title="3 stars"></label>
                <!-- 2.5 -->
                <!-- <input type="radio" id="star2half" name="rating" value="2.5" />
                <label class="half" for="star2half" title="2.5 stars"></label> -->
                <!-- 2 -->
                <input type="radio" id="star2" name="rating" value="2" />
                <label class="full" for="star2" title="2 stars"></label>
                <!-- 1.5 -->
                <!-- <input type="radio" id="star1half" name="rating" value="1.5" />
                <label class="half" for="star1half" title="1.5 stars"></label> -->
                <!-- 1 -->
                <input type="radio" id="star1" name="rating" value="1" />
                <label class="full" for="star1" title="1 star"></label>
                <!-- 0.5 -->
                <!-- <input type="radio" id="starhalf" name="rating" value="0.5" />
                <label class="half" for="starhalf" title="0.5 stars"></label> -->
              </fieldset>
            </div>
          </div>

          <center>
            <div class="form-group row">
              <div class="col-lg-12">
                <input type="submit" class="update btn btn-danger" name="submit" value="Submit" id="submit">
              </div>
            </div>
          </center>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once 'includes/footer.php' ?>
