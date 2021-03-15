<?php
  include_once 'includes/headerSimulation.php';
  $totalPrice = 0;
?>

<style>
  .cardContent {
    position: relative;
    min-height: 150px;
  }

  .cardButtons1 {
    position: absolute;
    bottom: 0;
  }

  .cardButtons2 {
    position: absolute;
    bottom: 0;
    right:4%;
  }
</style>

  <!-- <div class="page-header">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="title">
          <h4>Cart</h4>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo site_root; ?>selectgame.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
          </ol>
        </nav>
      </div>
    </div>
  </div> -->

  <?php if (isset($msg) && !empty($msg)) { ?>
    <div class="alert <?php echo ($type[0]=='inputError') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <?php echo $msg; ?>
    </div>
  <?php } ?>

<div class="row">
  <div class="col-md-8 col-sm-12 mb-30">
    <?php
    if ($cartGames->num_rows > 0) {
      while ($resultObj = mysqli_fetch_object($cartGames)) { 
        $image = ($resultObj->Game_Image) ? $resultObj->Game_Image : 'Game2.jpg';
        $totalPrice = $totalPrice+$resultObj->Game_prise;
    ?>
    <form method="POST" action="">
      <input type="hidden" id="gameId" name="gameId" value="<?php echo $resultObj->Game_ID; ?>">
      <input type="hidden" id="gameName" name="gameName" value="<?php echo $resultObj->Game_Name; ?>"> 
      <input type="hidden" id="Description" name="Description" value='"<?php echo $resultObj->Game_Comments; ?>"'>

      <div class="card mb-3">
        <div class="card-header text-blue"><?php echo $resultObj->Game_Name; ?></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3">
              <img src="<?php echo site_root.'images/'.$image; ?>" width="150px" class="" alt="<?php echo $resultObj->Game_Name; ?>" style="width:100%; height:150px;">
            </div>
            <div class="col-md-9 cardContent">
              <p class="card-text"><?php echo substr($resultObj->Game_shortDescription, 0, 140).'...'; ?></p>
              <div>
                <button class="btn btn-info pull-left cardButtons1" disabled><?php echo $resultObj->Game_prise; ?> Rs</button>
                <button type="submit" class="btn btn-danger pull-right cardButtons2" name="submit" id="submit" value="remove">Remove</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </form>
    <?php } } else { ?>
      <div class="card mb-3">
        <div class="card-header text-blue">No Game Present</div>
        <div class="card-body">
          <div class="row px-3">
            <p class="card-text">There is no game in your cart</p>
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
  <div class="col-md-4 col-sm-12">
    <?php if ($cartGames->num_rows > 0) { ?>
    <div class="card mb-3">
      <div class="card-header text-blue">Billing</div>
      <div class="row no-gutters">
        <div class="col-md-12">
          <div class="card-body">
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Total Game</td>
                  <td>:</td>
                  <td><?php echo $_SESSION['User_CartCount']; ?></td>
                </tr>
                <tr>
                  <td>Total Price</td>
                  <td>:</td>
                  <td><?php echo $totalPrice; ?> Rs</td>
                </tr>
              </tbody>
            </table>
            <!-- <p class="card-text">Total Game: <?php echo $_SESSION['User_CartCount']; ?></p>
            <p class="card-text">Total Price: <?php echo $totalPrice; ?> Rs</p> -->
            <div class="text-center">
              <a href="<?php echo site_root; ?>payment.php" class="btn btn-success px-5">Proceed to Pay</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
  </div>
</div>

<?php 
  include_once 'includes/footerSimulation.php';
?>
