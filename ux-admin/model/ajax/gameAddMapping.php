<?php
include_once '../../../config/settings.php';
include_once doc_root . 'config/functions.php';

$funObj = new Functions();
$viewingOrder = array ('mksahu','Name - Details/Chart(CkEditor) - Input Fields', 'Name - Input Fields - Details/Chart(CkEditor)', 'Details/Chart(CkEditor) - Input Fields - Name', 'Details/Chart(CkEditor) - Name - Input Fields', 'Input Fields - Details/Chart(CkEditor) - Name', 'Input Fields - Name - Details/Chart(CkEditor)', 'Input Fields - Name - Full Length', 'Input Fields - Details/Chart(CkEditor)', 'Name - Details/Chart(CkEditor)', 'Name - Input Fields - Full Length', 'Details/Chart(CkEditor) - Name', 'Details/Chart(CkEditor) - Input Fields', 'Name - Input Fields - Half Length', 'Input Fields - Name - Half Length', 'Details/Chart(CkEditor) - Full Length', 'Details/Chart(CkEditor) - Half Length', 'Details/Chart(CkEditor) - Input Fields - Half ', 'Input Fields - Details/Chart(CkEditor) - Half ', 'Name - Details/Chart(CkEditor) - Half Length', 'Details/Chart(CkEditor) 1/4 length', 'InputField 1/4 length', 'Details/Chart(CkEditor) 75%  ', 'Input Fields - Details/Chart(CkEditor) 75%', 'Details/Chart(CkEditor) - Input Fields 75%', 'Details/Chart(CkEditor) 33%', 'Input Fields - Details/Chart(CkEditor) 33%', 'Details/Chart(CkEditor) - Input Fields 33%', 'Input Fields 33%', 'Input Fields 20%', 'Details/Chart(CkEditor) 20%');


if (isset($_POST['action']) && $_POST['action'] == 'addGameData') {
  // print_r($_POST); die(' here ');
  $adminId = $_SESSION['ux-admin-id'];
  $Js_Name = trim($_POST['Js_Name']);
  $Js_Element = $_POST['Js_Element'];
  $Js_Alias = $_POST['Js_Alias'];
  $Js_GameId = $_POST['Js_GameId'];
  $Js_ScenId = $_POST['Js_ScenId'];
  $Js_LinkId = $_POST['Js_LinkId'];

  if (empty($Js_Name)) {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Game Name Is Required']);
  } elseif (empty($Js_GameId)) {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Mapping Game Not Selected']);
  } elseif (empty($Js_ScenId)) {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No scenario selected']);
  } elseif (empty($Js_LinkId)) {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Linkage Found']);
  } else {
    // check if element name is not empty
    foreach ($Js_Element as $row => $value) {
      if (empty($value)) {
        // die('no value');
        die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Element Name Is Required']));
      }
    }

    // check for duplicate game
    $fetchGame = $funObj->ExecuteQuery("SELECT * FROM GAME_JSGAME WHERE Js_Name='" . $Js_Name . "'");
    // print_r($fetchGame);die(' here ');
    if ($fetchGame->num_rows > 0) {
      die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Game name already exist']));
    }

    // $Js_Element = json_encode($_POST['Js_Element']);
    // $Js_Alias = json_encode($_POST['Js_Alias']);
    // $insertQuery = "INSERT INTO GAME_JSGAME (Js_Name, Js_Element, Js_Alias, Js_GameId, Js_ScenId, Js_LinkId, Js_CreatedBy) VALUES ('$Js_Name',' $Js_Element', '$Js_Alias', $Js_GameId, $Js_ScenId, $Js_LinkId, $adminId)";
    // $insertGameData = $funObj->ExecuteQuery($insertQuery);
    for ($in = 0; $in < count($Js_Element); $in++) {
      $insertQuery = "INSERT INTO GAME_JSGAME (Js_Name, Js_GameId, Js_ScenId, Js_LinkId, Js_Element, Js_Alias, Js_CreatedBy) VALUES ('$Js_Name',$Js_GameId, $Js_ScenId, $Js_LinkId, '".trim($Js_Element[$in])."', '".trim($Js_Alias[$in])."', $adminId)";
      $insertGameData = $funObj->ExecuteQuery($insertQuery);
    }

    if ($insertGameData) {
      echo json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'success', 'msg' => 'Record Saved Successfully']);
    } else {
      echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Error occured while inserting record']);
    }
  }
}

// fetching the active linked scenario list for the selected game
if (isset($_POST['action']) && $_POST['action'] == 'fetchScenario') {
  $gameid = $_POST['gameid'];
  if (empty($gameid)) {
    die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No game selected']));
  } else {
    $fetchLinkedScenarios = $funObj->RunQueryFetchObject("SELECT gl.Link_ID, gl.Link_GameID, gl.Link_ScenarioID, gs.Scen_ID, gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID WHERE gl.Link_JsGameScen = 1 AND gl.Link_Status=1 AND gl.Link_GameID =" . $gameid);
    if (isset($fetchLinkedScenarios) && count($fetchLinkedScenarios) > 0) {
      die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'success', 'msg' => 'Active Scenairo Linkage Found', 'data' => $fetchLinkedScenarios]));
    } else {
      die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Active Scenario Linkage Found']));
    }
  }
}

// deleting the record from the table for data integration
if (isset($_POST['action']) && $_POST['action'] == 'deleteIntegration') {
  $Js_id = $_POST['Js_id'];
  if (empty($Js_id)) {
    die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Data Provided To Delete']));
  } else {
    // check if this is linked with component or not, if linked then don't delete
    $checkLinkage = $funObj->RunQueryFetchObject("SELECT Js_SublinkId FROM GAME_JSGAME WHERE Js_id=" . $Js_id);
    if (!empty($checkLinkage[0]->Js_SublinkId)) {
      die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Remove Linkage First To Delete This Element Record']));
    }
    $deleteData = $funObj->ExecuteQuery("DELETE FROM GAME_JSGAME WHERE Js_id=" . $Js_id);
    if ($deleteData) {
      die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'success', 'msg' => 'Integration Deleted Successfully']));
    } else {
      echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Error occured while deleting record']);
    }
  }
}

// update, changing the status from active/deactive
if (isset($_POST['action']) && $_POST['action'] == 'changeStatus') {
  $Js_id = $_POST['Js_id'];
  $Js_Status = $_POST['Js_Status'];
  if (empty($Js_id)) {
    die(json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Data Provided To Delete']));
  } else {
    $deleteData = $funObj->ExecuteQuery("UPDATE GAME_JSGAME SET Js_Status=" . $Js_Status . " WHERE Js_id=" . $Js_id);
    if ($deleteData) {
      die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'success', 'msg' => 'Status Changed Successfully']));
    } else {
      echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Error occured while updating status']);
    }
  }
}


// update, game mapping records, while editing
if (isset($_POST['action']) && $_POST['action'] == 'editJsGameData') {
  // print_r($_POST); die(' here ');
  $Js_id = $_POST['Js_id'];
  $JS_Element = trim($_POST['JS_Element']);
  $Js_Alias = trim($_POST['Js_Alias']);

  if(empty($Js_id))
  {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No Mapping Selected']);
  }
  else
  {
    $updateData = $funObj->ExecuteQuery("UPDATE GAME_JSGAME SET Js_Alias='" . $Js_Alias . "', JS_Element='" . $JS_Element . "' WHERE Js_id=" . $Js_id);
    if ($updateData) {
      echo json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'success', 'msg' => 'Record Updated Successfully']);
    } else {
      echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'Error occured while inserting record']);
    }
  }
}

// show all js mapped link for the given scenario
if (isset($_POST['action']) && $_POST['action'] == 'fetchScenarioJsMapping') {
  // print_r($_POST); die(' here ');
  $Js_LinkId = $_POST['Js_LinkId'];

  $mapSql = "SELECT * FROM GAME_JSGAME WHERE Js_LinkId = $Js_LinkId";

  $fetchMapping = $funObj->ExecuteQuery($mapSql);

  // print_r($fetchMapping); die(' here ');

  if ($fetchMapping->num_rows > 0) {
    $mapSql = "SELECT gj.Js_Name, gj.Js_Element, gj.Js_Alias, gg.Game_Name, gs.Scen_Name, gls.SubLink_CompName FROM `GAME_JSGAME` gj LEFT JOIN GAME_GAME gg ON gg.Game_ID = gj.Js_GameId LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gj.Js_ScenId LEFT JOIN GAME_LINKAGE_SUB gls ON gls.SubLink_ID = gj.Js_SublinkId WHERE Js_LinkId = $Js_LinkId";
    $fetchMapping = $funObj->RunQueryFetchObject($mapSql);
    $showTable = "<table class='table table-bordered table-striped table-hover'> <thead class='thead-dark'><tr><th>ID</th> <th>JS Game Name</th> <th>Simulation/Card Name</th> <th>Scenario Name</th> <th>Element</th> <th>Alias</th> <th>Component</th></tr></thead> <tbody>";
    $id = 1;
    foreach($fetchMapping as $fetchMappingRow)
    {
      $showTable .= "<tr> <td>".$id."</td> <td>".$fetchMappingRow->Js_Name."</td> <td>".$fetchMappingRow->Game_Name."</td> <td>".$fetchMappingRow->Scen_Name."</td> <td>".$fetchMappingRow->Js_Element."</td> <td>".$fetchMappingRow->Js_Alias."</td> <td>".$fetchMappingRow->SubLink_CompName."</td></tr>";
      $id++;
    }
    $showTable .= "</tbody> </table>";
    echo json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => '', 'timer' => '', 'icon' => 'success', 'msg' => $showTable, ]);
  } else {
    echo json_encode(['status' => 201, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'This Scenario Is Not Mapped With Any JS Game, Or Deleted']);
  }
}


// to fetch game component/subcomponent linkage details into game_linkage_sub table
if (isset($_POST['action']) && $_POST['action'] == 'fetchLinkage') {
  // print_r($_POST); die(' here ');
  if(empty($_POST['Sublink_ID']))
  {
    die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No data found for selected row.']));
  }
  $Sublink_ID = $_POST['Sublink_ID'];
  $linkageData = $funObj->RunQueryFetchObject("SELECT * FROM GAME_LINKAGE_SUB WHERE Sublink_ID=$Sublink_ID");
  // print_r($linkageData);
  if(isset($linkageData) && count($linkageData)>0)
  {
    $viewingOrderOptions = '<option value="">--choose viewing order--</option>';
    $skipFlag = true;
    foreach($viewingOrder as $arrayKey => $viewingOrderText)
    {
      if($skipFlag){ $skipFlag=false; continue;}
      $selected = ($linkageData[0]->SubLink_ViewingOrder==$arrayKey)?'selected':'';
      // echo $arrayKey.' for '.$viewingOrderText.' and '.$selected.' with '.$linkageData[0]->SubLink_ViewingOrder.'<br>';
      $viewingOrderOptions .= '<option value="'.$arrayKey.'" '.$selected.'>'.$viewingOrderText.'</option>';
    }

    if($linkageData[0]->SubLink_ShowHide > 0)
    {
      $show = '';
      $Hide = 'checked';
    }
    else
    {
      $show = 'checked';
      $Hide = '';
    }
    $showForm = '<form action="" method="post" id="linkageFormData" onsubmit="return updateLinkageData(event);"> <br><br> <input type="hidden" name="action" value="updateLinkageData"> <input type="hidden" name="Sublink_ID" value="'.$Sublink_ID.'"> <row class="form-row" id="viewingOrder"> <div class="col-md-4"><label for="ViewingOrder">Viewing Order</label></div> <div class="col-md-8"> <select class="form-control" name="ViewingOrder" id="ViewingOrder" required>'.$viewingOrderOptions.'</select> </div> </row> <br><br> <row class="form-row" id=""> <div class="col-md-4"> <label for="LabelCurrent">Label Current</label> </div> <div class="col-md-8"> <input type="text" name="LabelCurrent" id="LabelCurrent" class="form-control" required value="'.$linkageData[0]->SubLink_LabelCurrent.'"> </div> </row> <br><br> <row class="form-row" id=""> <div class="col-md-4"> <label for="LabelLast">Label Last</label> </div> <div class="col-md-8"> <input type="text" name="LabelLast" id="LabelLast" required value="'.$linkageData[0]->SubLink_LabelLast.'" class="form-control"> </div> </row> <br><br> <row class="form-row" id=""> <div class="col-md-4"> <label for="Order_SubLink">Order</label> </div> <div class="col-md-8"> <input type="number" name="Order_SubLink" id="Order_SubLink" class="form-control" required value="'.$linkageData[0]->SubLink_Order.'"> </div> </row> <br><br> <row class="col-md-4 form-row" id=""> <label class="containerRadio" for="hideShow0"><input type="radio" name="hideShow" '.$show.' id="hideShow0" value="0">Show <span class="checkmarkRadio"></span> </label> <label class="containerRadio" for="hideShow1"><input type="radio" name="hideShow" '.$Hide.' id="hideShow1" value="1">Hide <span class="checkmarkRadio"></span> </label> </row> <br><br> <row class="col-md-12"><button type="submit" name="inlineUpdate" value="updateInline" class="btn btn-success">Update</button> <button type="button" class="btn btn-danger" onclick="return Swal.close();">Cancel</button></row> </form>';
  
    echo json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => '', 'timer' => '', 'icon' => 'info', 'title' => 'Update', 'clickClose' => false, 'msg' => $showForm, ]);
  }
  else
  {
    die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'No data found for selected row.']));
  }
}


// to update game component/subcomponent linkage details into game_linkage_sub table
if (isset($_POST['action']) && $_POST['action'] == 'updateLinkageData') {
  // print_r($_POST); die(' here ');
  $Sublink_ID = $_POST['Sublink_ID'];
  $SubLink_ViewingOrder = $_POST['ViewingOrder'];
  $SubLink_LabelCurrent = $_POST['LabelCurrent'];
  $SubLink_LabelLast = $_POST['LabelLast'];
  $SubLink_Order = $_POST['Order_SubLink'];
  $SubLink_ShowHide = $_POST['hideShow'];
  
  if(empty($Sublink_ID) || empty($SubLink_ViewingOrder) || empty($SubLink_LabelCurrent) || empty($SubLink_LabelLast) || empty($SubLink_Order))
  {
    die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '1500', 'icon' => 'error', 'msg' => 'All fields are mandatory.']));
  }
  // if not empty then
  $updateArray = array(
    'SubLink_ViewingOrder' => $SubLink_ViewingOrder,
    'SubLink_LabelCurrent' => $SubLink_LabelCurrent,
    'SubLink_LabelLast' => $SubLink_LabelLast,
    'SubLink_Order' => $SubLink_Order,
    'SubLink_ShowHide' => $SubLink_ShowHide,
  );
  $updateLinkage = $funObj->UpdateData('GAME_LINKAGE_SUB', $updateArray, 'Sublink_ID', $Sublink_ID, $print_flag = 0);
  die(json_encode(['status' => 200, 'showclass' => 'animate__shakeX', 'hideclass' => '', 'position' => 'top-end', 'timer' => '2000', 'icon' => 'success', 'msg' => 'Linkage data updated successfully. Refresh page to see udpated data in table.']));
}