<?php
require_once doc_root.'ux-admin/model/model.php';
require_once doc_root.'includes/PHPExcel.php';
//require_once doc_root.'includes/PHPExcel/Writer/Excel2007.php';
//require('../../includes/PHPExcel.php');

$functionsObj = new Model();
$file         = 'reportTwoSequenceList.php';
// include PHPExcel

$gameData = $functionsObj->RunQueryFetchObject("SELECT Game_ID,Game_Name FROM GAME_GAME WHERE Game_Delete=0 ORDER BY Game_Name ASC");
// echo "<pre>"; print_r($gameData); exit();

if(isset($_POST['submit']) && $_POST['submit'] == 'submit')
{
  $OpSeq_GameId = $_POST['OpSeq_GameId'];
  $OpSeq_CompId = $_POST['OpSeq_CompId']; // array
  $OpSeq_SubcCompId = $_POST['OpSeq_SubcCompId']; // array
  $OpSeq_LinkId = $_POST['OpSeq_LinkId']; // array
  $OpSeq_SubLinkId = $_POST['OpSeq_SubLinkId']; // array
  $OpSeq_Order = $_POST['OpSeq_Order']; // array

  $deleteExisting = $functionsObj->ExecuteQuery("DELETE FROM GAME_REPORT_OUTPUT_SEQUENCING WHERE OpSeq_GameId=$OpSeq_GameId");
  $bulkInsertData = array();
  $bulkInsertQuery = "INSERT INTO GAME_REPORT_OUTPUT_SEQUENCING (OpSeq_GameId, OpSeq_CompId, OpSeq_SubcCompId, OpSeq_LinkId, OpSeq_SubLinkId, OpSeq_Order, OpSeq_By) VALUES ";

  for($i=0; $i<count($OpSeq_Order); $i++)
  {
    $bulkInsertData[] = "($OpSeq_GameId, $OpSeq_CompId[$i], $OpSeq_SubcCompId[$i], $OpSeq_LinkId[$i], $OpSeq_SubLinkId[$i], $OpSeq_Order[$i], ".$_SESSION['ux-admin-id']." )";
  }

  $bulkInsertQuery .= implode($bulkInsertData,',');
  $insert = $functionsObj->ExecuteQuery($bulkInsertQuery);

  // echo "$bulkInsertQuery<pre>"; print_r($insert); print_r($_POST); exit();
  if($insert)
  {
    $_SESSION['msg']     = "Sequence Saved Successfully.";
    $_SESSION['type[0]'] = "inputSuccess";
    $_SESSION['type[1]'] = "has-success";
  }

  else
  {
    $_SESSION['msg']     = "Error ouuured while saving sequence. Please try later.";
    $_SESSION['type[0]'] = "inputError";
    $_SESSION['type[1]'] = "has-Error";
  }
}

include_once doc_root.'ux-admin/view/sequence/'.$file;