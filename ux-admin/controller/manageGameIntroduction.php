<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
$functionsObj = new Model();

if (isset($_POST['submit']) && $_POST['submit'] == 'UpdateIntroduction') {
  // echo "<pre>"; print_r($_POST); exit();
  
  // Setting Record ID
  $uid = base64_decode($_GET['edit']);
  // print_r($uid); exit();

  // Setting Introduction Page
  $gameJson = array(
    'gameIntroduction'           => trim($_POST['gameIntroduction']) ? trim($_POST['gameIntroduction']) : 'Introduction',
    'gameIntroductionColorCode'  => trim($_POST['gameIntroductionColorCode']) ? trim($_POST['gameIntroductionColorCode']) : 'lightcyan',
    'gameIntroductionVisibility' => $_POST['gameIntroductionVisibility'] ? $_POST['gameIntroductionVisibility'] : 0,

    'gameVideos'           => trim($_POST['gameVideos']) ? trim($_POST['gameVideos']) : 'Videos',
    'gameVideosColorCode'  => trim($_POST['gameVideosColorCode']) ? trim($_POST['gameVideosColorCode']) : 'lavender',
    'gameVideosVisibility' => $_POST['gameVideosVisibility'] ? $_POST['gameVideosVisibility'] : 0,

    'gameImages'           => trim($_POST['gameImages']) ? trim($_POST['gameImages']) : 'Images',
    'gameImagesColorCode'  => trim($_POST['gameImagesColorCode']) ? trim($_POST['gameImagesColorCode']) : 'lavenderblush',
    'gameImagesVisibility' => $_POST['gameImagesVisibility'] ? $_POST['gameImagesVisibility'] : 0,

    'gameDocuments'           => trim($_POST['gameDocuments']) ? trim($_POST['gameDocuments']) : 'Documents',
    'gameDocumentsColorCode'  => trim($_POST['gameDocumentsColorCode']) ? trim($_POST['gameDocumentsColorCode']) : 'lemonchiffon',
    'gameDocumentsVisibility' => $_POST['gameDocumentsVisibility'] ? $_POST['gameDocumentsVisibility'] : 0,
  );
  $game_Json = json_encode($gameJson);

  $gamedetails = (object) array(
    'Game_Introduction_Json' => $game_Json,
  );

  // echo "<pre>"; print_r($gamedetails); exit;
  $result = $functionsObj->UpdateData('GAME_GAME', $gamedetails, 'Game_ID', $uid, 0);

  if ($result) {
    $_SESSION['msg']     = "Game Introduction updated successfully";
    $_SESSION['type[0]'] = "inputSuccess";
    $_SESSION['type[1]'] = "has-success";
  }
  else {
    $msg     = "Error: ".$result;
    $type[0] = "inputError";
    $type[1] = "has-error";
  }

  header("Location: ".site_root."ux-admin/ManageGame");
  exit(0);
}

// Edit Game Introduction
if (isset($_GET['edit'])) {
  // print_r($_GET['edit']); exit();
  $header      = 'Manage Introduction';
  $uid         = base64_decode($_GET['edit']);
  // $uid         = base64_decode($_GET['introduction']);
  $object      = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_ID='.$uid), '', '', '', '', 0);
  $gamedetails = $functionsObj->FetchObject($object);
  // print_r($gamedetails);exit;

  $url         = site_root."ux-admin/ManageGame";
  $file        = 'manageIntroduction.php';
}
else {
  header("Location: ".site_root."ux-admin/ManageGame");
  exit(0);
}

include_once doc_root.'ux-admin/view/Game/'.$file;