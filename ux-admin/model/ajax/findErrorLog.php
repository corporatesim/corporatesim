<?php
include_once '../../../config/settings.php';
require_once doc_root.'ux-admin/model/model.php';

$funObj = new Model(); 
// to get the error log for selected scenario
if($_POST['action'] == 'fetchScenarioErrorLog')
{
  $Gal_LinkId = $_POST['Gal_LinkId'];
  $logSql = "SELECT * FROM GAME_APP_LOG WHERE Gal_LinkId=$Gal_LinkId ORDER BY Gal_CreatedOn DESC";
  $logResult = $funObj->RunQueryFetchObject($logSql);
  // echo $logSql; echo json_encode($logResult);
  if(count($logResult)<1)
  {
    die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '2000', 'icon' => 'error', 'msg' => 'No Error Log Found For The Selected Scenario.']));
  }
  else
  {
    $errorLogTable = '<table id="dataTables-example" class="table table-striped table-bordered table-hover text-center"> <thead> <tr> <th>ID</th> <th>User</th> <th>Comp Name</th> <th>Sub-Comp Name</th> <th>Actual Error Msg</th> <th>Custom Error Msg</th> <th>Error Occured</th> </tr> </thead> <tbody>';
    $rowId = 1;
    foreach($logResult as $logResultRow)
    {
      $errorLogTable .= '<tr> <td>'.$rowId.'</td> <td>'.$logResultRow->Gal_UserData.'</td> <td>'.$logResultRow->Gal_CompName.'</td> <td>'.$logResultRow->Gal_SubCompName.'</td> <td>'.$logResultRow->Gal_ErrorMsg.'</td> <td>'.$logResultRow->Gal_CustomErrorMsg.'</td> <td>'.date('d-m-Y H:i:s', strtotime($logResultRow->Gal_CreatedOn)).'</td> </tr>';
      $rowId++;
    }

    $errorLogTable .= '</tbody> </table>';
    // $errorLogTable .= '</tbody> <tfoot> <tr> <th>ID</th> <th>User</th> <th>Comp Name</th> <th>Sub-Comp Name</th> <th>Actual Error Msg</th> <th>Custom Error Msg</th> <th>Error Occured</th> </tr> </tfoot> </table>';
    die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'center', 'timer' => '', 'icon' => '', 'msg' => $errorLogTable]));
  }
  // echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Linkage Found']);
}
