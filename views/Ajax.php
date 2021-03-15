<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller{

  private $loginDataLocal;
  public function __construct(){
    parent::__construct();
    $this->loginDataLocal = $this->session->userdata('loginData');
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      // redirect('Login/login');
    }
  }

  public function checkLoginStatus(){
    die($this->loginDataLocal['User_Id']);
    if ($this->loginDataLocal == NULL) {
      die('redirect');
    } 
    else{
      die($this->loginDataLocal['User_Id']);
    }
  }

  public function deleteRecords($tableName = NULL, $dataCol = NULL)
  {
    $tableName = 'GAME_' . strtoupper($tableName);
    // delete records from table
    $data = array(
      $dataCol => 1,
    );
    $where = $this->input->post();
    // print_r($tableName); print_r($data); print_r($where); exit();
 
    $retData = $this->Common_Model->softDelete($tableName, $data, $where);

    if ($retData) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Deleted Successfully.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Connection Error. Please Try Later.']));
    }
  }

  public function mappingItemSearch($pid=NULL)
  {
    //$checkWhere = $this->input->post();
    $checkWhere = array(
      'Cmap_ComptId' => $pid,
    );
    //print_r($checkWhere); exit();

    //checking item is mapped or not
    $checkDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_MAPPING', $checkWhere, 'Cmap_Id,');
    //prd($checkDetails); exit();

    if(count($checkDetails) > 0){
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "mappingFound", 'icon' => 'error', 'message' => 'Sub-factor Can not be deleted beacause it is used in Mapping.']));
    }
    else{
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "mappingNotFound", 'icon' => 'success', 'message' => 'Sub-factor not used in any mapping.']));
    }
  }

  public function listItems()
  {
    // fetching records for competancy item list
    $competenceQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_PerformanceType, gi.Compt_Description, ge.Enterprise_Name FROM GAME_ITEMS gi INNER JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gi.Compt_Enterprise_ID  WHERE gi.Compt_Delete = 0 ORDER BY gi.Compt_Name";

    $fetchData = $this->Common_Model->executeQuery($competenceQuery);

    if (count($fetchData) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } 
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Data Loaded Successfully.', "data" => $fetchData]));
    }
  }

  public function listSpecialization(){
    // fetching records for Specialization
    $query = "SELECT gus.US_ID, gus.US_Name FROM GAME_USER_SPECIALIZATION gus ORDER BY gus.US_Name ASC";
    $fetchData = $this->Common_Model->executeQuery($query);

    if (count($fetchData) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } 
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Specialization Data Loaded Successfully.', "data" => $fetchData]));
    }
  }

  //Bulk Uploading Specialization
  public function ajax_bulk_upload_Specialization(){
    $maxFileSize    = 2097152; //Set max upload file size [2MB]
    //$maxFileSize    = 1000000; //Set max upload file size [1MB]
    $validext       = array ('xls', 'xlsx', 'csv');  //Allowed Extensions
    $Upload_CSV_ID  = time(); //ID as Current time
    $createdBy      = $this->session->userdata('loginData')['User_Id'];

    //checking user is inserted any file or not
    if(isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])){

      $fileSize = filesize($_FILES['upload_csv']['tmp_name']); //uploaded file size
      //echo print_r($fileSize); exit();

      //checking inserted file size in not greater then declared ($maxFileSize) size 
      if($fileSize < $maxFileSize){
        $explode_filename = explode(".", $_FILES['upload_csv']['name']); //uploaded file extension
        $ext = strtolower(end($explode_filename));
        //echo $ext."\n";

        //checking user is uploading valid file extension and size or not 
        if(in_array($ext, $validext)){
          try{
            $file                  = $_FILES['upload_csv']['tmp_name'];
            $handle                = fopen($file, "r");
            $not_Inserted_Name     = array(); //array of not imported data
            $c                     = 0; //count of all imported data
            $flag                  = true;

            //setting file data to read mode
            $fileStructure = fgetcsv($handle, 1000, ",");
            if(!empty($fileStructure[0])){

              while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                if($flag){
                  $flag = false; 
                  continue;
                }

                //echo print_r($filesop); exit();
                //checking uploading data is present or not in database
                $specialization_Name  = $filesop[0];
                //$where = array("US_Name" => $specialization_Name);
                //$object = $this->Common_Model->findCount('GAME_USER_SPECIALIZATION', $where);

                //$where  = array("US_Name='".$specialization_Name."'");
                $where  = array('US_Name = "'.$specialization_Name.'"');
                $object = $this->Common_Model->SelectData(array(), 'GAME_USER_SPECIALIZATION', $where, '', '', '', '', 0);
                // print_r(count($object));
                // exit();

                if(count($object) > 0){
                  //when found any duplicate Specialization Name in Database 
                  //insert Specialization Name into not_Inserted_Name
                  array_push($not_Inserted_Name, $filesop[0]);
                } 
                else{
                  if(!empty($filesop)){
                    //setting array for Inserting data
                    $array = array(
                      "US_Name"          => $filesop[0],
                      "US_CreatedOn"     => date('Y-m-d H:i:s'),
                      "US_CreatedBy"     => $createdBy,
                      'US_Upload_CSV_ID' => $Upload_CSV_ID,
                    );
                    $result = $this->Common_Model->insert("GAME_USER_SPECIALIZATION", $array, 0, 0);
                    $c++;
                  }
                }
              }

              //echo $c;
              if(!empty($not_Inserted_Name)){
                //showing all Not imported Specialization Name as msg
                $msg = "</br><p class='text-danger'><br />Not imported Specialization:- ".count($not_Inserted_Name)." <br /> Specialization Name:-<br />".implode(" , ",$not_Inserted_Name)."</p>";
              } 
              else{
                $msg = "";
              }

              $result = array(
                //"msg"    => "Import successful. You have imported ".$c." Specialization.".$msg,
                "msg"    => "You have imported ".$c." Specialization.".$msg,
                "status" => 1
              );
            }
            else{
              $result = array(
                "msg"    => "Please select a file with given format to import",
                "status" => 0
              );
            }

          }
          catch(Exception $e){
            $result = array(
              "msg"    => "Error: ".$e,
              "status" => 0
            );
          }
        }
        else{
          $result = array(
            "msg"    => "Please select a valid file with extension(xls, xlsx, csv) to import",
            "status" => 0
          );
        }

      }
      else{
        $result = array(
          "msg"    => "File size is longer then 2 MB",
          "status" => 0
        );
      }

    }
    else{
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }

    echo json_encode($result);
  } // end of ajax_bulk_upload_CSV function

  public function listCampus(){
    // fetching records for Campus
    $query = "SELECT guc.UC_ID, guc.UC_Name, guc.UC_Type, guc.UC_Address, guc.UC_Email, guc.UC_Contact FROM GAME_USER_CAMPUS guc ORDER BY guc.UC_Name ASC";
    $fetchData = $this->Common_Model->executeQuery($query);

    if (count($fetchData) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } 
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Campus Data Loaded Successfully.', "data" => $fetchData]));
    }
  }

  //Bulk Uploading Campus
  public function ajax_bulk_upload_Campus(){
    $maxFileSize    = 2097152; //Set max upload file size [2MB]
    //$maxFileSize    = 1000000; //Set max upload file size [1MB]
    $validext       = array ('xls', 'xlsx', 'csv');  //Allowed Extensions
    $Upload_CSV_ID  = time(); //ID as Current time
    $createdBy      = $this->session->userdata('loginData')['User_Id'];

    //checking user is inserted any file or not
    if(isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])){

      $fileSize = filesize($_FILES['upload_csv']['tmp_name']); //uploaded file size
      //echo print_r($fileSize); exit();

      //checking inserted file size in not greater then declared ($maxFileSize) size 
      if($fileSize < $maxFileSize){
        $explode_filename = explode(".", $_FILES['upload_csv']['name']); //uploaded file extension
        $ext = strtolower(end($explode_filename));
        //echo $ext."\n";

        //checking user is uploading valid file extension and size or not 
        if(in_array($ext, $validext)){
          try{
            $file                  = $_FILES['upload_csv']['tmp_name'];
            $handle                = fopen($file, "r");
            $not_Inserted_Name     = array(); //array of not imported data
            $c                     = 0; //count of all imported data
            $flag                  = true;

            //setting file data to read mode
            $fileStructure = fgetcsv($handle, 1000, ",");
            if(!empty($fileStructure[0])){

              while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                if($flag){
                  $flag = false; 
                  continue;
                }

                //echo print_r($filesop); exit();
                //checking uploading data is present or not in database
                $campus_Name  = $filesop[0];
                //$where = array("UC_Name" => $campus_Name);
                //$object = $this->Common_Model->findCount('GAME_USER_CAMPUS', $where);

                // $where  = array("UC_Name = '".$campus_Name."'");
                $where  = array('UC_Name = "'.$campus_Name.'"');
                $object = $this->Common_Model->SelectData(array(), 'GAME_USER_CAMPUS', $where, '', '', '', '', 0);
                // print_r(count($object));
                // exit();

                if(count($object) > 0){
                  //when found any duplicate Campus Name in Database 
                  //insert Campus Name into not_Inserted_Name
                  array_push($not_Inserted_Name, $filesop[0]);
                } 
                else{
                  if(!empty($filesop)){
                    //setting array for Inserting data
                    $array = array(
                      "UC_Name"          => $filesop[0],
                      "UC_Type"          => $filesop[4],
                      "UC_Address"       => $filesop[1],
                      "UC_Email"         => $filesop[2],
                      "UC_Contact"       => $filesop[3],
                      "UC_CreatedOn"     => date('Y-m-d H:i:s'),
                      "UC_CreatedBy"     => $createdBy,
                      'UC_Upload_CSV_ID' => $Upload_CSV_ID,
                    );
                    $result = $this->Common_Model->insert("GAME_USER_CAMPUS", $array, 0, 0);
                    $c++;
                  }
                }
              }

              //echo $c;
              if(!empty($not_Inserted_Name)){
                //showing all Not imported Campus Name as msg
                $msg = "</br><p class='text-danger'><br />Not imported Campus:- ".count($not_Inserted_Name)." <br /> Campus Name:-<br />".implode(" , ",$not_Inserted_Name)."</p>";
              } 
              else{
                $msg = "";
              }

              $result = array(
                //"msg"    => "Import successful. You have imported ".$c." Campus.".$msg,
                "msg"    => "You have imported ".$c." Campus.".$msg,
                "status" => 1
              );
            }
            else{
              $result = array(
                "msg"    => "Please select a file with given format to import",
                "status" => 0
              );
            }

          }
          catch(Exception $e){
            $result = array(
              "msg"    => "Error: ".$e,
              "status" => 0
            );
          }
        }
        else{
          $result = array(
            "msg"    => "Please select a valid file with extension(xls, xlsx, csv) to import",
            "status" => 0
          );
        }

      }
      else{
        $result = array(
          "msg"    => "File size is longer then 2 MB",
          "status" => 0
        );
      }

    }
    else{
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }

    echo json_encode($result);
  } // end of ajax_bulk_upload_CSV function

  public function getCompetenceGameItems($enterprise_ID = NULL, $performance_Type_ID = NULL)
  {
    //fetching all Items created under this enterprise
    $enterpriseItemsWhere = array(
      'Compt_Enterprise_ID'   => $enterprise_ID,
      'Compt_PerformanceType' => $performance_Type_ID,
      'Compt_Delete'          => 0,
    );
    $enterpriseItemsList = $this->Common_Model->fetchRecords('GAME_ITEMS', $enterpriseItemsWhere, 'Compt_Id, Compt_Name, Compt_Description, Compt_PerformanceType', 'Compt_Name');

    //fetching all Games assigned to this enterprise
    $enterpriseGameQuery = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Comments FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID = gg.Game_ID WHERE gg.Game_Delete = 0 AND geg.EG_EnterpriseID = $enterprise_ID ORDER BY gg.Game_Name";
    $enterpriseGameList = $this->Common_Model->executeQuery($enterpriseGameQuery);
    //print_r($this->db->last_query()); exit();

    // $result = array('itemOptions'=> $enterpriseItemsList, 'gameOptions' => $enterpriseGameList);
    // echo json_encode($result);

    if (count($enterpriseItemsList) < 1 || count($enterpriseGameList) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Data Loaded Successfully.', "enterpriseItemsData" => $enterpriseItemsList, "enterpriseGameData" => $enterpriseGameList]));
    }
  }

  public function getCompetenceUserAndFormula($enterprise_ID = NULL)
  {
    //fetching all formula created under selected enterprise
    $formulawhere = array(
      'Items_Formula_Enterprise_Id' => $enterprise_ID,
    );
    $enterpriseFormulaList = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');

    //fetching all Users assigned to this enterprise
    $enterpriseUserQuery = "SELECT gu.User_id, CONCAT(gu.User_fname, ' ', gu.User_lname) AS User_fullName, gu.User_username FROM GAME_SITE_USERS gu WHERE gu.User_Role = 1 AND gu.User_Delete = 0 AND gu.User_ParentId = $enterprise_ID ORDER BY gu.User_fname, gu.User_lname ASC";
    $enterpriseUserList = $this->Common_Model->executeQuery($enterpriseUserQuery);
    //print_r($this->db->last_query()); exit();

    if (count($enterpriseFormulaList) < 1 || count($enterpriseUserList) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Data Loaded Successfully.', "enterpriseFormulaData" => $enterpriseFormulaList, "enterpriseUserData" => $enterpriseUserList]));
    }
  }

  public function getCompetenceItems($enterprise_ID = NULL)
  {
    //fetching all Items created under selected enterprise where item have any sublink id(mapped with sublink id)
    $itemQuery = "SELECT DISTINCT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType FROM GAME_ITEMS gi INNER JOIN GAME_ITEMS_MAPPING gim ON gim.Cmap_ComptId = gi.Compt_Id WHERE gi.Compt_Delete = 0 AND gi.Compt_Enterprise_ID = $enterprise_ID ORDER BY gi.Compt_Name"; 
    $enterpriseItemsList = $this->Common_Model->executeQuery($itemQuery);
    //print_r($itemQuery); echo '<br />'; print_r($itemData); exit();

    if (count($enterpriseItemsList) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Data Loaded Successfully.', "enterpriseItemsData" => $enterpriseItemsList]));
    }
  }

  public function fetchRecords($tableName = NULL, $orderBy = NULL)
  {
    // fetching records from table with where condition // print_r($this->input->post());
    $where     = $this->input->post();
    $fetchData = $this->Common_Model->fetchRecords($tableName, $where, '', $orderBy, '', '');
    if (count($fetchData) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Record Found.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 800, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Item Data Loaded Successfully.', "data" => $fetchData]));
    }
  }

  public function fetchAssignedGames($gameFor = NULL, $id = NULL)
  {
    if ($gameFor == 'enterpriseUsers') {
      $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_ENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.EG_GameID WHERE gg.Game_Delete=0 AND ge.EG_EnterpriseID=" . $id . " ORDER BY gg.Game_Name";
    }
    if ($gameFor == 'subEnterpriseUsers') {
      $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_SUBENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.SG_GameID WHERE Game_Delete=0 AND ge.SG_SubEnterpriseID=" . $id . " ORDER BY gg.Game_Name";
    }
    $gameData = $this->Common_Model->executeQuery($gameQuery);
    if (count($gameData) > 0) {
      echo json_encode($gameData);
    } else {
      echo 'No Card found';
    }
  }

  public function fetchAssignedGroups($groupFor = NULL, $entId = NULL, $subEntId = NULL)
  {
    if ($groupFor == 'enterpriseUsers') {
      $groupWhere = array(
        'Group_Delete'      => 0,
        'Group_ParentId'    => $entId,
        'Group_SubParentId' => -2,
        'Group_CreatedBy'   => $entId,
      );
    }
    if ($groupFor == 'subEnterpriseUsers') {
      $groupWhere = array(
        'Group_Delete'      => 0,
        'Group_ParentId'    => $entId,
        'Group_SubParentId' => $subEntId,
        'Group_CreatedBy'   => $subEntId,
      );
    }
    $groupData = $this->Common_Model->fetchRecords('GAME_COLLABORATION', $groupWhere, 'Group_Id, Group_Name, Group_Info', 'Group_Name');

    // print_r($this->input->post());  print_r($this->db->last_query()); print_r($groupData);

    if (count($groupData) > 0) {
      echo json_encode($groupData);
    } else {
      echo 'No Group found';
    }
  }

  public function getGroupData()
  {
    // this is the collaboration/group report data function
    // print_r($this->input->post());
    $loggedInAs        = $this->input->post('loggedInAs');
    $filtertype        = $this->input->post('filtertype');
    $Group_ParentId    = $this->input->post('Enterprise');
    $Group_SubParentId = $this->input->post('SubEnterprise');
    $Group_Id          = $this->input->post('selectGroup');
    $gameId            = $this->input->post('selectGame');
    $title             = 'Error';
    $returnData        = array();

    switch ($filtertype) {
      case 'superadminUsers':
        if (empty($Group_Id)) {
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration selected']));
        }
        break;

      case 'enterpriseUsers':
        if (empty($Group_Id) || empty($Group_ParentId)) {
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration or enterprize selected']));
        }
        break;

      case 'subEnterpriseUsers':
        if (empty($Group_Id) || empty($Group_ParentId) || empty($Group_SubParentId)) {
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'No group/collaboration, enterprize or subenterprize selected']));
        }
        break;
    }

    if (!empty($Group_Id)) {
      // creating sql to find the data for making pie/donut chart for groups
      $graphSql = "SELECT gcol.Group_Id, gcol.Group_Name, gcol.Group_Info, gcum.Map_Id, gcum.Map_GameId, gg.Game_Name, gl.Lead_Id, gl.Lead_ScenId, gl.Lead_CompId, gc.Comp_Name, gc.Comp_NameAlias, gl.Lead_Order, gcum.Map_UserId FROM GAME_COLLABORATION gcol LEFT JOIN GAME_COLLABORATION_USERS_MAPPING gcum ON gcum.Map_GroupId = gcol.Group_Id AND gcum.Map_GameId=" . $gameId . " LEFT JOIN GAME_GAME gg ON gg.Game_ID = gcum.Map_GameId AND gg.Game_ID=" . $gameId . " LEFT JOIN GAME_LEADERBOARD gl ON gl.Lead_GameId = gcum.Map_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 1 AND gl.Lead_Status = 0 AND Map_UserId IS NOT NULL AND gcol.Group_Id=" . $Group_Id;
      // print_r($this->input->post()); die($graphSql);
      $graphSqlResult = $this->Common_Model->executeQuery($graphSql);
      $message        = 'No data found for the selected group/collaboration.';
      $icon           = 'error';

      if (count($graphSqlResult) > 0) {
        $message                      = 'Please wait while loading...';
        $icon                         = 'success';
        $title                        = 'Success';
        $returnData['Group_Name']     = $graphSqlResult[0]->Group_Name;
        $returnData['Group_Info']     = $graphSqlResult[0]->Group_Info;
        $returnData['Game_Name']      = $graphSqlResult[0]->Game_Name;
        $returnData['Comp_Name']      = $graphSqlResult[0]->Comp_Name;
        $returnData['Comp_NameAlias'] = $graphSqlResult[0]->Comp_NameAlias;

        foreach ($graphSqlResult as $graphSqlResultRow) {
          $users = json_decode($graphSqlResultRow->Map_UserId);
          for ($i = 0; $i < count($users); $i++) {
            // find the users(this is nothing but team o/p) o/p data from game input table, Lead_ScenId
            $inputSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS fullName, gsu.User_username, gsu.User_email, gi.input_current FROM GAME_SITE_USERS gsu LEFT JOIN GAME_INPUT gi ON gsu.User_Id = gi.input_user AND gi.input_user=" . $users[$i] . " AND gi.input_sublinkid =( SELECT SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_CompID=" . $graphSqlResult[0]->Lead_CompId . " AND gls.SubLink_SubCompID < 1 AND gls.SubLink_LinkID =( SELECT Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID=" . $graphSqlResult[0]->Map_GameId . " AND gl.Link_Status = 1 AND gl.Link_ScenarioID=" . $graphSqlResult[0]->Lead_ScenId . " ) ) WHERE gsu.User_id=" . $users[$i] . " ORDER BY gi.input_caretedOn DESC";
            // echo $inputSql.'<br><br>';
            $inputSqlResult             = $this->Common_Model->executeQuery($inputSql);
            $outputValue                = ($inputSqlResult[0]->input_current) ? $inputSqlResult[0]->input_current : 0;
            $returnData['userData'][]   = array(
              'User_id'       => $inputSqlResult[0]->User_id,
              'fullName'      => $inputSqlResult[0]->fullName,
              'User_username' => $inputSqlResult[0]->User_username,
              'User_email'    => $inputSqlResult[0]->User_email,
              'input_current' => $outputValue,
              'chartColor'    => '#' . $this->random_color(),
            );
          }
        }
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => $title, 'icon' => $icon, 'message' => $message, 'data' => $returnData]));
      } else {
        // foreach ($graphSqlResult as $graphSqlResultRow)
        // {
        //   $users = json_decode($graphSqlResultRow->Map_UserId);
        // }
        // print_r($users);
        // print_r($returnData);
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Collaboration output not set for selected game.']));
      }
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => $title, 'icon' => 'error', 'message' => 'Something went wrong. Please try later.']));
    }
  }

  public function getCollaborationGames($Map_GroupId = NULL)
  {
    if (empty($Map_GroupId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Please select collaboration.']));
    } else {
      $findCollaborationGames = "SELECT gg.Game_ID,gg.Game_Name FROM GAME_COLLABORATION_USERS_MAPPING gum LEFT JOIN GAME_GAME gg ON gg.Game_ID=gum.Map_GameId WHERE gum.Map_GroupId=" . $Map_GroupId;

      $collaborationGames = $this->Common_Model->executeQuery($findCollaborationGames);

      if (count($collaborationGames) > 0) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'success', 'icon' => 'success', 'message' => 'Fetched Associated Cards.', 'gameData' => $collaborationGames]));
      } else {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This collaboration is not associated with any Card.']));
      }
    }
  }

  // generate random html color hex value, for chart data or multipurpose

  private function random_color()
  {
    return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
  }

  private function random_color_part()
  {
    return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
  }

  public function showPerformanceChart($userid = NULL, $gameid = NULL)
  {
    $performanceSql  = "SELECT gp.Performance_Id, gp.Performance_Value, gc.Comp_NameAlias, gc.Comp_Name, gp.Performance_CreatedOn, IF((SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId) > (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1)), (SELECT MAX(Performance_Value) FROM GAME_USER_PERFORMANCE WHERE Performance_GameId=gl.Lead_GameId), (SELECT MAX(input_current) FROM GAME_INPUT WHERE input_sublinkid = (SELECT gls.SubLink_ID FROM GAME_LINKAGE_SUB gls WHERE gls.SubLink_LinkID = (SELECT gln.Link_ID FROM GAME_LINKAGE gln WHERE gln.Link_GameID=gl.Lead_GameId AND gln.Link_ScenarioID=gl.Lead_ScenId) AND gls.SubLink_CompID=gl.Lead_CompId AND gls.SubLink_SubCompID < 1))) AS max_value FROM GAME_USER_PERFORMANCE gp LEFT JOIN GAME_LEADERBOARD gl ON gp.Performance_GameId = gl.Lead_GameId LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gl.Lead_CompId WHERE gl.Lead_BelongTo = 0 AND gl.Lead_Status = 0 AND gl.Lead_GameId =" . $gameid . " AND gp.Performance_Delete = 0 AND gp.Performance_UserId =" . $userid . " ORDER BY gp.Performance_CreatedOn";

    $performanceData = $this->Common_Model->executeQuery($performanceSql);
    if (count($performanceData) > 1) {
      $chartData             = [];
      $chartLabels           = [];
      $overAllBenchmark      = [];
      $performanceGraphTitle = ($performanceData[0]->Comp_NameAlias) ? $performanceData[0]->Comp_NameAlias : $performanceData[0]->Comp_Name;
      foreach ($performanceData as $performanceDataRow) {
        $chartData[]        = $performanceDataRow->Performance_Value;
        $chartLabels[]      = $performanceDataRow->Performance_CreatedOn;
        $overAllBenchmark[] = $performanceDataRow->max_value;
      }

      die(json_encode(['chartData' => $chartData, 'chartLabels' => $chartLabels, 'graphTitle' => $performanceGraphTitle, 'overAllBenchmark' => $overAllBenchmark, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Performance Graph Data.']));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'User has either not completed the Card or not used more than once.']));
    }
  }

  public function downloadGameReport($userid = NULL, $game_id = NULL, $returnUrl = NULL)
  {
    $linkid = $this->Common_Model->executeQuery("SELECT Link_ID FROM `GAME_LINKAGE` WHERE Link_ScenarioID= (SELECT US_ScenID FROM `GAME_USERSTATUS` WHERE US_UserID=" . $userid . " and US_GameID=" . $game_id . " ) AND Link_GameID=" . $game_id . "")[0]->Link_ID;

    $gameDataSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS FullName, gsu.User_email AS Email, gsu.User_mobile AS Mobile, gsu.User_profile_pic AS ProfileImage, gg.Game_Name, gg.Game_ReportFirstPage, gg.Game_ReportSecondPage, gsu.User_ParentId, gsu.User_SubParentId, ge.Enterprise_Name, ge.Enterprise_Logo, gse.SubEnterprise_Name, gse.SubEnterprise_Logo FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gsu.User_id = gug.UG_UserID AND gug.UG_GameID =" . $game_id . " LEFT JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gsu.User_ParentId AND ge.Enterprise_Status=0 LEFT JOIN GAME_SUBENTERPRISE gse ON gse.SubEnterprise_ID=gsu.User_SubParentId AND gse.SubEnterprise_Status=0 WHERE gsu.User_id=" . $userid;
    $gameData = $this->Common_Model->executeQuery($gameDataSql)[0];
    // echo "<pre>"; print_r($gameData); exit(); // Game_ReportFirstPage Game_ReportSecondPage
    $sqlarea = "SELECT distinct a.Area_ID as AreaID, a.Area_Name as Area_Name, a.Area_BackgroundColor as BackgroundColor, a.Area_TextColor as TextColor, gas.Sequence_Order AS Area_Sequencing
                    FROM GAME_LINKAGE l 
                    INNER JOIN GAME_LINKAGE_SUB ls on l.Link_ID=ls.SubLink_LinkID 
                    INNER JOIN GAME_COMPONENT c on ls.SubLink_CompID=c.Comp_ID 
                    INNER join GAME_GAME g on l.Link_GameID=g.Game_ID
                    INNER JOIN GAME_SCENARIO sc on sc.Scen_ID=l.Link_ScenarioID
                    INNER JOIN GAME_AREA a on a.Area_ID=c.Comp_AreaID
                    LEFT JOIN GAME_AREA_SEQUENCE gas on a.Area_ID=gas.Sequence_AreaId
                    LEFT OUTER JOIN GAME_SUBCOMPONENT s on ls.SubLink_SubCompID=s.SubComp_ID 
                    WHERE ls.SubLink_Type=1 AND gas.Sequence_LinkId=" . $linkid . " AND l.Link_ID=" . $linkid . " ORDER BY gas.Sequence_Order DESC";
    // echo $sqlarea; exit();
    $area = $this->Common_Model->executeQuery($sqlarea);
    if (count($area) > 0) {
      $printPdfFlag = TRUE;
      // echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();

      foreach ($area as $areaRow) {
        // to check that this area comp are visible or hide by admin, if visible then only show area to user else not
        $checkVisibleCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=" . $userid . " WHERE gls.SubLink_LinkID =" . $linkid . " AND gls.SubLink_AreaID =" . $areaRow->AreaID . " AND gls.SubLink_ShowHide = 0 AND gls.SubLink_SubCompID<1 ORDER BY gls.SubLink_Order";
        $visibleComponents   = $this->Common_Model->executeQuery($checkVisibleCompSql);
        // echo $checkVisibleCompSql.'<br>';

        if (count($visibleComponents) > 0) {
          // this means this area has some comp or subcomp that is visible, take this area data and break the loop
          $printPdfFlag = FALSE;
          break;
        }
      }

      // if nothing to visible then redirect to result page, showing the alert message
      if ($printPdfFlag) {
        // die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This game output not available/visible. Please contact admin.']));
        $this->session->set_flashdata('er_msg', 'This Card output not available/visible. Please contact admin.');
        redirect(base_url('OnlineReport/viewReport//' . $returnUrl));
      }

      // finding the game completion date
      $gameCompletDate = $this->Common_Model->executeQuery("SELECT US_CompletedOn FROM GAME_USERSTATUS WHERE US_GameID=$game_id AND US_UserID=$userid")[0];

      // echo count($visibleComponents)."<pre><br>".$checkVisibleCompSql.'<br>'; print_r($visibleComponents); exit();
      $pageHeader = '<table align="left" cellspacing="0" cellpadding="1" style"font-weight:bold;"><tr><td colspan="2" align="center" style="background-color:#f0f0f0;"><b>Participant Details</b></td></tr><tr style="background-color:#c4daec;"><td><b>Name</b>: </td><td>' . $gameData->FullName . '</td></tr> <tr style="background-color:#c4daec;"><td><b>Email</b>: </td><td>' . $gameData->Email . '</td></tr> <tr style="background-color:#c4daec;"><td><b>Mobile</b>: </td><td>' . 'XXXXXX' . substr($gameData->Mobile, -4) . '</td></tr> <tr style="background-color:#c4daec;"><td><b>Simulation/Game</b>: </td><td>' . $gameData->Game_Name . ' (' . date('d-m-Y', strtotime($gameCompletDate->US_CompletedOn)) . ')</td></tr></table><br>' . $gameData->Game_ReportFirstPage;

      $printData = '';
      foreach ($visibleComponents as $visibleComponentsRow) {
        // $printData .= $visibleComponentsRow->SubLink_CompName.$visibleComponentsRow->input_current;
        $printData .= '<div style="width:100%; display:inline-block;" class="componentDiv">';

        // adding ckEditor/chart div
        $printData .= '<div class="componentDivCkeditor" style="width:50%; display:inline-block;">';
        if (empty($visibleComponentsRow->SubLink_ChartID)) {
          $printData .= $visibleComponentsRow->SubLink_Details;
        } else {
          // $printData .= $visibleComponentsRow->SubLink_ChartID;
          $printData .= '<img src="' . base_url() . '../chart/' . $visibleComponentsRow->SubLink_ChartType . '.php?gameid=' . $game_id . '&userid=' . $userid . '&ChartID=' . $visibleComponentsRow->SubLink_ChartID . '">';
        }

        $printData .= '</div>';
        // end of ckEditor/chart div

        // adding the inputField/PersonalizeOutcome div GAME_PERSONALIZE_OUTCOME

        $personalizeOutcomeSql = "SELECT * FROM GAME_PERSONALIZE_OUTCOME gpo WHERE gpo.Outcome_LinkId=" . $visibleComponentsRow->SubLink_LinkID . " AND gpo.Outcome_CompId=" . $visibleComponentsRow->SubLink_CompID . " AND gpo.Outcome_IsActive=0 ORDER BY gpo.Outcome_Order ASC";
        $personalizeOutcomeResult = $this->Common_Model->executeQuery($personalizeOutcomeSql);
        if (count($personalizeOutcomeResult) > 0) {
          $foundInRangeFlag = TRUE;
          foreach ($personalizeOutcomeResult as $personalizeOutcomeResultRow) {
            if ($personalizeOutcomeResultRow->Outcome_FileType != 3 && ($visibleComponentsRow->input_current >= $personalizeOutcomeResultRow->Outcome_MinVal and $visibleComponentsRow->input_current <= $personalizeOutcomeResultRow->Outcome_MaxVal)) {
              $printData .= '<div style="width:50%; display:inline-block;" class="componentDivInputFieldPo">';
              $printData .= '<img src="../ux-admin/upload/Badges/' . str_replace(' ', '%20', $personalizeOutcomeResultRow->Outcome_FileName) . '"><br><br><br><div>' . $personalizeOutcomeResultRow->Outcome_Description . '</div>';
              $foundInRangeFlag = FALSE;
              $printData .= '</div>';
              break;
            }
          }
          if ($foundInRangeFlag) {
            // if there is no condition matched, i.e. gap in range so so the value as it is
            $printData .= "Gap in range for personalizeOutcomeResult and the actual value is:- " . $visibleComponentsRow->input_current;
          }
        } else {
          if ($visibleComponentsRow->SubLink_ViewingOrder != 15 && $visibleComponentsRow->SubLink_ViewingOrder != 16) {
            // adding the inputField/PersonalizeOutcome div GAME_PERSONALIZE_OUTCOME
            $printData .= '<div style="width:50%; display:inline-block;" class="componentDivInputField">';
            $printData .= $visibleComponentsRow->input_current;
            $printData .= '</div>';
          }
        }

        // end of adding inputField/PersonalizeOutcome div

        // after coming out from the loop check that component has subcomponent or not
        $checkVisibleSubCompSql = "SELECT gls.*,gi.input_current FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid=gls.SubLink_ID AND gi.input_user=" . $userid . " WHERE gls.SubLink_LinkID =" . $linkid . " AND gls.SubLink_AreaID =" . $visibleComponentsRow->SubLink_AreaID . " AND gls.SubLink_ShowHide = 0 AND gls.SubLink_CompID=" . $visibleComponentsRow->SubLink_CompID . " AND gls.SubLink_SubCompID>1 ORDER BY gls.SubLink_Order";
        $visibleSubComponents   = $this->Common_Model->executeQuery($checkVisibleSubCompSql);

        if (count($visibleSubComponents) > 0) {
          foreach ($visibleSubComponents as $visibleSubComponentsRow) {
            $printData .= '<div class="subComponentDiv" style="width:100%; display:inline-block;">';

            // adding ckEditor/chart div
            $printData .= '<div class="subComponentDivCkeditor" style="width:50%; display:inline-block;">';
            if (empty($visibleSubComponentsRow->SubLink_ChartID)) {
              $printData .= $visibleSubComponentsRow->SubLink_Details;
            } else {
              // $printData .= $visibleSubComponentsRow->SubLink_ChartID;
              $printData .= '<img src="' . base_url() . '../chart/' . $visibleSubComponentsRow->SubLink_ChartType . '.php?gameid=' . $game_id . '&userid=' . $userid . '&ChartID=' . $visibleSubComponentsRow->SubLink_ChartID . '">';
            }

            $printData .= '</div>';
            // end of ckEditor/chart div

            // adding the inputField div
            $printData .= '<div class="subComponentDivInputField" style="width:50%; display:inline-block;">' . $visibleSubComponentsRow->input_current . '</div>';
            // end of adding inputField div

            $printData .= '</div>';
            // end of subComponentDiv
          }
        }

        $printData .= "</div>";
        // end of componentDiv
      }

      // echo $printData; exit();

      define('Enterprise_Name', ($gameData->Enterprise_Name) ? $gameData->Enterprise_Name : 'noVal');
      define('Enterprise_Logo', ($gameData->Enterprise_Logo) ? str_replace(' ', '%20', $gameData->Enterprise_Logo) : 'noVal');
      define('SubEnterprise_Name', ($gameData->SubEnterprise_Name) ? $gameData->SubEnterprise_Name : 'noVal');
      define('SubEnterprise_Logo', ($gameData->SubEnterprise_Logo) ? str_replace(' ', '%20', $gameData->SubEnterprise_Logo) : 'noVal');

      $this->load->library('MYPDF');
      // create new PDF document
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->Header();
      $pdf->SetFont('helvetica', '', 12);
      // set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Humanlinks');
      $pdf->SetTitle($gameData->Game_Name . ' Report');
      $pdf->SetSubject('Simulation Output Report');
      $pdf->SetKeywords('Simulation, Report, Output, Result, Simulation Report');
      // set default header data
      $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

      // set header and footer fonts
      $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(0);
      $pdf->SetFooterMargin(0);

      // remove default footer
      $pdf->setPrintFooter(true);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
      }

      // adding first page to show header and user data
      $pdf->AddPage();
      // ---------------------------------------------------------
      $pdf->writeHTML($pageHeader, true, false, false, false, '');

      // adding a second page for game report
      $pdf->AddPage();
      $secondPage = $gameData->Game_ReportSecondPage;
      $pdf->writeHTML($secondPage, true, false, false, false, '');

      // finally adding page to print game result
      $pdf->AddPage();
      $pdf->writeHTML($printData, true, false, false, false, '');
      $outputFileName = $gameData->FullName . '-' . $gameData->Game_Name . '_' . date('d-m-Y') . '.pdf';
      // to show this pdf in browser
      // $pdf->Output($outputFileName,'I');
      // to download this pdf with the given name
      $pdf->Output($outputFileName, 'D');
      // echo count($area)."<pre><br>".$sqlarea.'<br>'; print_r($area); exit();
    } else {
      // die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'This Card output not available/visible. Please contact admin.']));
      $this->session->set_flashdata('er_msg', 'This Card output not available/visible. Please contact admin.');
      redirect(base_url('OnlineReport/viewReport//' . $returnUrl));
    }
  }

  // get completed games and create dialog for checkboxes
  public function getCompletedGames($userid = NULL)
  {
    $userid = base64_decode($userid);
    $completedGameSql = "SELECT gg.Game_ID, gg.Game_Name, gus.US_ScenID, gl.Link_ID FROM GAME_GAME gg LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gg.Game_ID LEFT JOIN GAME_LINKAGE gl ON gl.Link_GameID = gg.Game_ID AND gl.Link_ScenarioID = gus.US_ScenID WHERE gus.US_UserID =" . $userid . " ORDER BY gg.Game_Name";
    $completedGames = $this->Common_Model->executeQuery($completedGameSql);
    // echo $completedGameSql; print_r($completedGames);
    if (count($completedGames) < 1) {
      // no game allocated or complted
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Selected user has not completed any Card till now.']));
    } else {
      $data = '<form id="completedGamesForm"><input type="hidden" name="userid" value="' . $userid . '"><div class="row col-md-12">';
      foreach ($completedGames as $completedGamesRow) {
        $data .= '<div class="custom-control custom-checkbox col-md-12"><input required type="checkbox" class="custom-control-input" name="completedGameLinkId[]" id="' . $completedGamesRow->Link_ID . '" value="' . $completedGamesRow->Link_ID . '"><label class="custom-control-label" for="' . $completedGamesRow->Link_ID . '">' . $completedGamesRow->Game_Name . '</label></div>';
      }
      $data .= "</div><br><button class='btn btn-success' onclick='getCompleteReport(this,event);'>Download Report</button></form>";
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'Please select Cards(completed) to download consolidated report', 'icon' => 'success', 'message' => $data]));
    }
  }

  public function downloadCompletedGamesReport($userid = NULL, $linkid = NULL)
  {
    // print_r($this->input->post());
    $userid              = $this->input->post('userid');
    $completedGameLinkId = $this->input->post('completedGameLinkId');
    if (count($completedGameLinkId) < 1) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Please select at least one Card to get report']));
    } else {
      $reportSql  = "SELECT gg.Game_Name AS gameName, gls.SubLink_LinkID, IF(IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias) IS NULL OR IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias) = ' ', IF(gc.Comp_NameAlias IS NULL OR gc.Comp_NameAlias = ' ', gc.Comp_Name, gc.Comp_NameAlias), concat(IF(gc.Comp_NameAlias IS NULL OR gc.Comp_NameAlias = ' ', gc.Comp_Name, gc.Comp_NameAlias),' / ',IF(gs.SubComp_NameAlias IS NULL OR gs.SubComp_NameAlias = ' ', gs.SubComp_Name, gs.SubComp_NameAlias))) AS comp_subcomp, IF(gi.input_current IS NULL OR gi.input_current = ' ',0,gi.input_current) AS inputValue FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_INPUT gi ON gi.input_sublinkid = gls.SubLink_ID AND gi.input_user=" . $userid . " LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID LEFT JOIN GAME_LINKAGE gl ON gl.Link_ID=gls.SubLink_LinkID LEFT JOIN GAME_GAME gg ON gg.Game_ID=gl.Link_GameID WHERE gls.SubLink_LinkID IN(" . implode(',', $completedGameLinkId) . ") AND gls.SubLink_ShowHide=0 AND gls.SubLink_Type=1 ORDER BY gls.SubLink_LinkID";
      $reportData = $this->Common_Model->executeQuery($reportSql);
      // add one row to csv, for showing col name
      $rowArr = (object) array(
        'gameName'       => 'Card Name',
        'SubLink_LinkID' => 'Link Id',
        'comp_subcomp'   => 'Comp / Subcomp',
        'inputValue'     => 'Value',
      );
      array_unshift($reportData, $rowArr);

      // print_r($reportData);
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Please wait while downloading report.', 'data' => $reportData]));
    }
  }

  // to get the list of users associated with the games
  public function getAgents()
  {
    // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
    $loggedInAs      = $this->input->post('loggedInAs');
    $filterValue     = $this->input->post('filterValue');
    $enterpriseId    = $this->input->post('enterpriseId');
    $subEnterpriseId = $this->input->post('subEnterpriseId');
    $gameId          = $this->input->post('gameId');
    $searchFilter    = trim($this->input->post('searchFilter'));
    // creating subquery 
    $userDataQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu
                INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$gameId WHERE gsu.User_Delete=0";
    // adding filters here
    if ($filterValue == 'superadminUsers') {
      $userDataQuery .= " AND gsu.User_MasterParentId=21 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
    }

    if ($filterValue == 'enterpriseUsers') {
      $userDataQuery .= " AND gsu.User_ParentId=" . $enterpriseId;
    }

    if ($filterValue == 'subEnterpriseUsers') {
      $userDataQuery .= " AND gsu.User_ParentId=" . $enterpriseId . " AND gsu.User_SubParentId=" . $subEnterpriseId;
    }

    if (isset($searchFilter) && !empty($searchFilter)) {
      $userDataQuery .= " AND (gsu.User_email LIKE '%" . $searchFilter . "%' OR gsu.User_username LIKE '%" . $searchFilter . "%') ";
    }

    // adding the above subquery to main query
    $agentsSql = "SELECT
                ud.User_id AS User_id,
                ud.User_fname AS User_fname,
                ud.User_lname AS User_lname,
                ud.User_email AS User_email,
                ud.US_LinkID
                FROM
                GAME_SITE_USER_REPORT_NEW gr
                INNER JOIN($userDataQuery) ud
                ON
                ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
                WHERE
                gr.linkid IN(
                  SELECT
                  Link_ID
                  FROM
                  GAME_LINKAGE
                  WHERE
                  Link_GameID = $gameId
                  )
                  ORDER BY `ud`.`US_LinkID` DESC";

    $agentsResult = $this->Common_Model->executeQuery($agentsSql);
    // die($agentsSql);
    echo json_encode($agentsResult);
  }

  // to get the agents for creating the collabration
  public function getAgentsForCollaboration()
  {
    // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
    $loggedInAs      = $this->input->post('loggedInAs');
    $filterValue     = $this->input->post('filterValue'); // superadminUsers, enterpriseUsers, subEnterpriseUsers
    $enterpriseId    = $this->input->post('enterpriseId');
    $subEnterpriseId = $this->input->post('subEnterpriseId');
    $gameId          = $this->input->post('gameId');
    $Group_Id        = $this->input->post('Group_Id');
    $searchFilter    = trim($this->input->post('searchFilter'));
    // if filterValue is blank or not defined then show error
    if (empty($filterValue)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", "message" => 'Please select user type to create collabration.', 'title' => 'show this title', 'icon' => 'error']));
    } else {
      $collabrationAgentsSql = "SELECT gsu.User_id, CONCAT(gsu.User_fname,' ',gsu.User_lname) AS fullName, gsu.User_username, gsu.User_email, gum.Map_UserId FROM GAME_SITE_USERS gsu JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID=" . $gameId . " LEFT JOIN GAME_COLLABORATION_USERS_MAPPING gum ON gum.Map_GroupId=" . $Group_Id . " AND gum.Map_GameId=" . $gameId . " WHERE gsu.User_Delete=0 ";
      // getting all agents for team mapping
      $allAgentsSql = "SELECT * FROM GAME_SITE_USERS gsu WHERE gsu.User_Delete=0 ";
      switch ($filterValue) {
        case 'superadminUsers':
          $collabrationAgentsSql .= " AND gsu.User_Role=0 AND gug.UG_ParentId=-1 AND gug.UG_SubParentId=-2 ";
          $allAgentsSql          .= " AND gsu.User_Role=0 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
          break;

        case 'enterpriseUsers':
          $collabrationAgentsSql .= " AND gsu.User_Role=1 AND gug.UG_ParentId=" . $enterpriseId . " AND gug.UG_SubParentId=-2 ";
          $allAgentsSql          .= " AND gsu.User_Role=1 AND gsu.User_ParentId=" . $enterpriseId . " AND gsu.User_SubParentId=-2 ";
          break;

        case 'subEnterpriseUsers':
          $collabrationAgentsSql .= " AND gsu.User_Role=2 AND gug.UG_ParentId=" . $enterpriseId . " AND gug.UG_SubParentId=" . $subEnterpriseId;
          $allAgentsSql          .= " AND gsu.User_Role=2 AND gsu.User_ParentId=" . $enterpriseId . " AND gsu.User_SubParentId=" . $subEnterpriseId;
          break;
      }

      if (!empty($searchFilter)) {
        $collabrationAgentsSql .= " AND (gsu.User_fname LIKE '%" . $searchFilter . "%' OR gsu.User_lname LIKE '%" . $searchFilter . "%' OR gsu.User_username LIKE '%" . $searchFilter . "%' OR gsu.User_email LIKE '%" . $searchFilter . "%') ";
      }
    }

    $collabrationAgentsSql .= " ORDER BY gsu.User_fname ASC ";
    $allAgentsSql          .= " ORDER BY gsu.User_fname ASC ";
    // die($collabrationAgentsSql);
    $collabrationAgentsData = $this->Common_Model->executeQuery($collabrationAgentsSql);
    $collabrationTeamData   = $this->Common_Model->executeQuery($allAgentsSql);

    die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", "userdata" => $collabrationAgentsData, 'title' => 'show this title', 'icon' => 'success', 'mappedUser' => json_decode($collabrationAgentsData[0]->Map_UserId), 'message' => count($collabrationAgentsData) . ' Users Found.', 'teamUsersData' => $collabrationTeamData]));
  }

  // to get the all data of users with team mapping
  public function getAllUsersWithTeamMapping()
  {
    // print_r($this->input->post()); die('<br>Search: '.$searchFilter);
    $loggedInAs      = $this->input->post('loggedInAs');
    $filterValue     = $this->input->post('filterValue'); // superadminUsers, enterpriseUsers, subEnterpriseUsers
    $enterpriseId    = $this->input->post('enterpriseId');
    $subEnterpriseId = $this->input->post('subEnterpriseId');
    $Team_UserId     = $this->input->post('teamUserId');
    // if filterValue is blank or not defined then show error
    if (empty($filterValue)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", "message" => 'Please select filter accordingly.', 'title' => 'show this title', 'icon' => 'error']));
    } elseif (empty($Team_UserId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", "message" => 'Please select at least one team.', 'title' => 'show this title', 'icon' => 'error']));
    } else {
      // getting all agents for team mapping
      $teamAgentsSql = "SELECT User_id, User_fname, User_lname, User_email FROM GAME_SITE_USERS gsu WHERE gsu.User_Delete=0 ";
      switch ($filterValue) {
        case 'superadminUsers':
          $teamAgentsSql .= " AND gsu.User_Role=0 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
          break;

        case 'enterpriseUsers':
          $teamAgentsSql .= " AND gsu.User_Role=1 AND gsu.User_ParentId=" . $enterpriseId . " AND gsu.User_SubParentId=-2 ";
          break;

        case 'subEnterpriseUsers':
          $teamAgentsSql .= " AND gsu.User_Role=2 AND gsu.User_ParentId=" . $enterpriseId . " AND gsu.User_SubParentId=" . $subEnterpriseId;
          break;
      }
    }

    $teamAgentsSql .= " ORDER BY gsu.User_fname ASC ";
    // these are all the users
    $allUsersdata   = $this->Common_Model->executeQuery($teamAgentsSql);
    // these are mapped users
    $mappedUserData = $this->Common_Model->fetchRecords('GAME_TEAM_MAPPING', array('Team_UserId' => $Team_UserId));

    // echo "<pre>"; print_r($mappedUserData); echo "<br><br>"; print_r($allUsersdata);

    if (count($mappedUserData) < 1) {
      // is there is no mapping
      // echo "<pre>"; print_r($mappedUserData); echo "<br><br>"; print_r($allUsersdata);
      $collabrationTeamData = $allUsersdata;
    } else {
      // echo "<pre>"; print_r(json_decode($mappedUserData[0]->Team_Users)); echo "<br><br>"; print_r($allUsersdata);
      $mappedUserIds = json_decode($mappedUserData[0]->Team_Users);
      foreach ($allUsersdata as $allUsersdataRow) {
        if (in_array($allUsersdataRow->User_id, $mappedUserIds)) {
          // echo 'exist_'.$allUsersdataRow->User_id.'<br>';
          $allUsersdataRow->exist = 'checked';
        } else {
          $allUsersdataRow->exist = '';
        }
      }
      $collabrationTeamData = $allUsersdata;
    }

    die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => 'show this message', 'teamUsersData' => $collabrationTeamData]));
  }

  public function getTeamMembers($Team_UserId = NULL)
  {
    if (empty($Team_UserId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'No Team Selected']));
    } else {
      $teamData = $this->Common_Model->fetchRecords('GAME_TEAM_MAPPING', array('Team_UserId' => $Team_UserId));
      if (count($teamData) < 1) {
        // is there is no mapping
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'No User Mapped.']));
      } else {
        $mappedUserIds = implode(',', json_decode($teamData[0]->Team_Users));
        // print_r($mappedUserIds); echo implode(',', $mappedUserIds);
        $userDetails = $this->Common_Model->fetchRecords('GAME_SITE_USERS', "User_id IN ($mappedUserIds)", 'User_id, CONCAT(User_fname," ",User_lname) AS fullName, User_mobile, User_email, User_username');
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'Associated Team Members', 'icon' => 'success', 'message' => 'Associated Team Members', 'teamUsersData' => $userDetails]));
      }
    }
  }

  public function addEditDeleteFetchCollaboration($modification = NULL, $Group_Id = NULL)
  {
    // print_r($_SESSION); print_r($this->input->post()); echo $modification.' and '.$Group_Id; exit(); enterpriseUsers subEnterpriseUsers superadminUsers
    $Enterprise_ID    = $this->input->post('Enterprise_ID');
    $SubEnterprise_ID = $this->input->post('SubEnterprise_ID');
    $fetchFor         = $this->input->post('fetchFor');

    if (isset($this->loginDataLocal['User_ParentId']) && !empty($this->loginDataLocal['User_ParentId'])) {
      // it means this is either enterprise or subenterprise login, and login user will be creator
      if ($this->loginDataLocal['User_SubParentId'] == $this->loginDataLocal['User_ParentId']) {
        // this is enterprise login
        $ParentId    = $this->loginDataLocal['User_ParentId'];
        $SubParentId = -2;
        $CreatedBy   = $this->loginDataLocal['User_ParentId'];
        if (!empty($SubEnterprise_ID)) {
          // it means enterprise is looking for subenterprise
          $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='" . $ParentId . "' AND Group_SubParentId='" . $SubEnterprise_ID . "' AND Group_CreatedBy='" . $SubEnterprise_ID . "' AND Group_Delete=0 ";
        } else {
          // it means enterprise is looking for itself
          $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='" . $ParentId . "' AND Group_SubParentId='" . $SubParentId . "' AND Group_CreatedBy='" . $ParentId . "' AND Group_Delete=0 ";
        }
      } else {
        // this is subenterprise login
        $ParentId    = $this->loginDataLocal['User_ParentId'];
        $SubParentId = $this->loginDataLocal['User_SubParentId'];
        $CreatedBy   = $this->loginDataLocal['User_SubParentId'];
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='" . $ParentId . "' AND Group_SubParentId='" . $SubParentId . "' AND Group_CreatedBy='" . $SubParentId . "' AND Group_Delete=0 ";
      }
    } else {
      // it means this is superadmin login, and login user will be creator
      $ParentId    = -1;
      $SubParentId = -2;
      $CreatedBy   = 1;
      if (!empty($Enterprise_ID) && $fetchFor == 'enterpriseUsers') {
        // it means superadmin is looking for enterprise
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='" . $Enterprise_ID . "' AND Group_CreatedBy='" . $Enterprise_ID . "' AND Group_Delete=0 ";
      } elseif (!empty($SubEnterprise_ID) && $fetchFor == 'subEnterpriseUsers') {
        // it means superadmin is looking for subenterprise
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId='" . $Enterprise_ID . "' AND Group_SubParentId='" . $SubEnterprise_ID . "' AND Group_CreatedBy='" . $SubEnterprise_ID . "' AND Group_Delete=0 ";
      } else {
        // it means superadmin is looking for itself
        $fetch_where = "Group_MasterParentId=-21 AND Group_ParentId=-1 AND Group_SubParentId=-2 AND Group_CreatedBy=1 AND Group_Delete=0 ";
      }
    }

    if (empty($modification)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", "message" => 'Send proper information.']));
    } else {
      $Group_Name   = trim($this->input->post('Group_Name'));
      $Group_Info   = trim($this->input->post('Group_Info'));
      $searchFilter = ($this->input->post('searchFilter')) ? trim($this->input->post('searchFilter')) : '';
      $where        = array('Group_Id' => $Group_Id,);
      // check if group name is empty or not
      if (empty($Group_Name) && ($modification != 'fetch' && $modification != 'delete')) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'show this title', 'icon' => 'error', 'message' => 'Name/Info field can not be empty.']));
      }

      switch ($modification) {
        case 'add':
          $insertArray = array(
            'Group_Name'           => $Group_Name,
            'Group_Info'           => $Group_Info,
            'Group_MasterParentId' => -21,
            'Group_ParentId'       => $ParentId,
            'Group_SubParentId'    => $SubParentId,
            'Group_CreatedBy'      => $CreatedBy,
          );

          $retData = $this->Common_Model->insert('GAME_COLLABORATION', $insertArray);
          $message = 'Record Added Successfully.';
          break;

        case 'edit':
          $updateArray = array('Group_Name' => $Group_Name, 'Group_Info' => $Group_Info, 'Group_UpdatedBy' => $this->loginDataLocal['User_Id'], 'Group_UpdatedOn' => date('Y-m-d H:i:s'));
          $retData     = $this->Common_Model->updateRecords('GAME_COLLABORATION', $updateArray, $where);
          $message     = 'Record Updated Successfully.';
          break;

        case 'delete':
          $updateArray   = array('Group_Delete ' => 1);
          $deleteMapping = $this->Common_Model->deleteRecords('GAME_COLLABORATION_USERS_MAPPING', array('Map_GroupId' => $Group_Id,));
          $retData       = $this->Common_Model->softDelete('GAME_COLLABORATION', $updateArray, $where);
          $message       = 'Record Deleted Successfully.';
          break;

        case 'fetch':
          if (!empty($searchFilter)) {
            $fetch_where .= " AND(Group_Name LIKE '%" . $searchFilter . "%' OR Group_Info LIKE '%" . $searchFilter . "%') ";
          }
          $retData = $this->Common_Model->fetchRecords('GAME_COLLABORATION', $fetch_where, '', 'Group_Name', '', 0);
          // print_r($this->input->post());
          $message = 'Record Fetched Successfully.';
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'show this title', 'icon' => 'success', 'groupData' => $retData]));
          break;
      }
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => $message]));
    }
  }

  public function teamUserMapping()
  {
    // print_r($this->input->post());
    // team id is nothing but user id
    $teamId    = $this->input->post('teamDropdown');
    // users will be of array type
    $teamUsers = $this->input->post('teamUsers');
    if (empty($teamId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Select Team.']));
    } elseif (empty($teamUsers)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Error', 'icon' => 'error', 'message' => 'Select at least one user.']));
    } else {
      // deleting existing user mapping and createing new mapping
      $deleteWhere        = array('Team_UserId' => $teamId);
      $deleteExistingData = $this->Common_Model->deleteRecords('GAME_TEAM_MAPPING', $deleteWhere);

      $insertMapArray     = array(
        'Team_UserId'    => $teamId,
        'Team_Users'     => json_encode($teamUsers),
        'Team_CreatedBy' => $this->loginDataLocal['User_Id'],
      );
      $teamMapping        = $this->Common_Model->insert('GAME_TEAM_MAPPING', $insertMapArray);

      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => 'show this title', 'icon' => 'success', 'message' => 'Users Mapped Successfully']));
    }
  }

  public function get_states($Country_Id = NULL)
  {
    if (!empty($Country_Id)) {
      $whereState  = array(
        'State_Status'    => 0,
        'State_CountryId' => $Country_Id,
      );
      $resultState = $this->Common_Model->fetchRecords('GAME_STATE', $whereState);
      if (count($resultState) > 0) {
        echo json_encode($resultState);
      } else {
        echo 'nos';
      }
    } else {
      echo 'no';
    }
  }

  public function get_subenterprise($SubEnterprise_EnterpriseID = NULL)
  {
    $whereState  = array(
      'SubEnterprise_Status'       => 0,
      'SubEnterprise_EnterpriseID' => $SubEnterprise_EnterpriseID,
    );
    $resultSubEnterprise = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE', $whereState);
    echo json_encode($resultSubEnterprise);
  }

  public function get_dateRange($id = NULL)
  {
    $this->db->select('Enterprise_StartDate,Enterprise_EndDate');
    $this->db->where(array('Enterprise_ID' => $id));
    $result                       = $this->db->get('GAME_ENTERPRISE')->result();
    // print_r($this->db->last_query()); die(' here ');    // print_r($result[0]);
    $result                       = $result[0];
    $result->Enterprise_StartDate = strtotime($result->Enterprise_StartDate);
    $result->Enterprise_EndDate   = strtotime($result->Enterprise_EndDate);
    echo json_encode($result);
  }

  //csv upload for enterprise...
  public function enterprisecsv()
  {
    if (strpos(base_url(), 'localhost') !== FALSE) {
      $sendEmail = FALSE;
    } else {
      $sendEmail = TRUE;
    }

    $maxFileSize = 2097152;
    // Set max upload file size [2MB]
    $validext    = array('xls', 'xlsx', 'csv');

    if (isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])) {
      $explode_filename = explode(".", $_FILES['upload_csv']['name']);
      $ext              = strtolower(end($explode_filename));
      if (in_array($ext, $validext)) {
        try {
          $file              = $_FILES['upload_csv']['tmp_name'];
          $handle            = fopen($file, "r");
          $not_inserted_data = array();
          $inserted_data     = array();
          $c                 = 0;
          $flag              = true;

          while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if ($flag) {
              $flag = false;
              continue;
            }

            if (!empty($filesop)) {
              $date      = $filesop[6];
              $StartDate = date("Y-m-d", strtotime($date));
              $newdate   = $filesop[7];
              $EndDate   = date("Y-m-d", strtotime($newdate));
              $password  = $filesop[5];

              $email     = $filesop[2];
              $mobile    = $filesop[1];

              $where     = array(
                "Enterprise_Number" => $mobile,
                "Enterprise_Email"  => $email
              );
              // die(print_r($where));
              $object  = $this->Common_Model->findCount('GAME_ENTERPRISE', $where, 0, 0, 0);
              //print_r($object);exit;
              //print_r($this->db->last_query()); exit();
              if ($object > 0) {
                array_push($not_inserted_data, $filesop[2]);
                //echo "abcd";exit;
                //$result  = "email and mobile already registered";
              } else {
                if ($password != '') {
                  $password = $filesop[5];
                } else {
                  $password = $this->Common_Model->random_password();
                }

                $array = array(
                  "Enterprise_Name"      => $filesop[0],
                  "Enterprise_Number"    => $filesop[1],
                  "Enterprise_Email"     => $filesop[2],
                  "Enterprise_Address1"  => $filesop[3],
                  "Enterprise_Address2"  => $filesop[4],
                  "Enterprise_Password"  => $password,
                  "Enterprise_StartDate" => $StartDate,
                  "Enterprise_EndDate"   => $EndDate,
                );

                /*print_r($array);exit();*/
                $insertResult = $this->Common_Model->insert("GAME_ENTERPRISE", $array, 0, 0);
                /*print_r($this->db->last_query());exit;*/
                $c++;
                if ($insertResult && $sendEmail) {
                  // send mail only if in live server, not in local
                  $EnterpriseName = $filesop[0];
                  $password1      = $password;
                  $to             = $filesop[2];
                  $from           = "support@corporatesim.com";
                  $subject        = "New Account created..";
                  $message        = "Dear User Your Account has been created";
                  $message       .= "<p>Enterprize Name : " . $EnterpriseName;
                  $message       .= "<p>Email : " . $filesop[2];
                  $message       .= "<p>Password : " . $password1;
                  $header         = "From:" . $from . "\r\n";
                  $header        .= "MIME-Version: 1.0\r\n";
                  $header        .= "Content-type: text/html; charset: utf8\r\n";
                  mail($to, $from, $subject, $message, $header);
                }
              }
            }
          }
          if (!empty($not_inserted_data)) {
            $msg = "</br>Email id not imported -> " . implode(" , ", $not_inserted_data);
          }

          $result = array(
            "msg"    => "Import successfull",
            "status" => 1
          );
        } catch (Exception $e) {
          $result = array(
            "msg"    => "Error:",
            "status" => 0
          );
        }
      }
    } else {
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }
    echo json_encode($result);
  }


  //csv functionality for enterprise Users
  public function EnterpriseUsersCSV($Enterpriseid = NULL)
  {
    // Set max upload file size [2MB]
    $maxFileSize    = 2097152;
    $User_UploadCsv = time();
    // Allowed Extensions
    $validext       = array('xls', 'xlsx', 'csv');

    if (isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])) {
      $explode_filename = explode(".", $_FILES['upload_csv']['name']);
      //echo $explode_filename[0];
      //exit();
      $ext = strtolower(end($explode_filename));
      //echo $ext."\n";
      if (in_array($ext, $validext)) {
        try {
          $file              = $_FILES['upload_csv']['tmp_name'];
          $handle            = fopen($file, "r");
          $not_inserted_data = array();
          $inserted_data     = array();
          $c                 = 0;
          $flag              = true;
          $duplicate         = array();

          // Setting Enterprize ID
          if ($Enterpriseid == 0) {
            $entid = $this->session->userdata('loginData')['User_ParentId'];
          }
          else {
            $entid = $Enterpriseid;
          }

          // searching domail name 
          if ($entid) {
            // enterprise user
            $domainNameWhere = array(
              'Domain_EnterpriseId'      => $entid,
              'Domain_SubEnterpriseId =' => NULL,
            );
          }
          else {
            $domainNameWhere = array(
              'Domain_EnterpriseId ='    => NULL,
              'Domain_SubEnterpriseId =' => NULL,
            );
          }

          $domainName = $this->Common_Model->fetchRecords('GAME_DOMAIN', $domainNameWhere, 'Domain_Name', '');
          // print_r($domainName); print_r($domainName[0]->Domain_Name); exit();
          // if domain name is not set then set as default domain
          if (!empty($domainName[0]->Domain_Name)) {
            $domain = $domainName[0]->Domain_Name;
          }
          else {
            $domain = "https://live.corporatesim.com";
          }

          // Setting email details
          $config['charset'] = 'utf-8';
          $config['mailtype'] = 'text';
          $config['newline'] = '\r\n';

          $this->email->initialize($config);
          // $this->email->from('contact@humanlinks.in','Humanlinks','contact@humanlinks.in');
          $this->email->from('mailhumanlinks@gmail.com','Humanlinks','mailhumanlinks@gmail.com');
          $this->email->subject("Prayog access");

          // looping through each entry
          while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if ($flag) {
              // to skip the 1st row that is title/header in file
              $flag = false;
              continue;
            }

            if (!empty($filesop)) {
              //convert the date format 
              $dateDoesNotAccept = array('.', '-');
              $startDate         = str_replace($dateDoesNotAccept, '/', $filesop[6]);
              $endDate           = str_replace($dateDoesNotAccept, '/', $filesop[7]);
              $userStartDate     = date("Y-m-d", strtotime($startDate));
              $userEndDate       = date("Y-m-d", strtotime($endDate));

              $username          = $filesop[2];
              $mobile            = $filesop[3];
              $email             = $filesop[4];

              $where             = array(
                "User_username" => $username,
                "User_mobile"   => $mobile,
                "User_email"    => $email,
              );
              // echo $filesop[7].' csvSD '.$startDate.' sD '.$userStartDate. ' csvED '.$endDate.' eD '.$userEndDate; exit();

              $object = $this->Common_Model->findCount('GAME_SITE_USERS', $where);
              if ($object > 0) {
                // echo "details already registered";
                $duplicate[] = $email;
                continue;
                // exit();
              }

              $insertArray = array(
                "User_fname"         => $filesop[0],
                "User_lname"         => $filesop[1],
                "User_username"      => $username,
                "User_mobile"        => $mobile,
                "User_email"         => $email,
                "User_companyid"     => $filesop[5],
                "User_Role"          => 1,
                "User_ParentId"      => $entid,
                "User_GameStartDate" => $userStartDate,
                "User_GameEndDate"   => $userEndDate,
                "User_datetime"      => date("Y-m-d H:i:s"),
                'User_UploadCsv'     => $User_UploadCsv,
              );
              // print_r($filesop); echo $userStartDate. ' and '.$userEndDate; print_r($insertArray);exit();
              $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
              // print_r($this->db->last_query());exit;

              $c++;
              if ($result) {
                $uid           = $result;
                $password      = $this->Common_Model->random_password();
                $login_details = array(
                  'Auth_userid'    => $uid,
                  'Auth_username'  => $username,
                  'Auth_password'  => $password,
                  'Auth_date_time' => date('Y-m-d H:i:s')
                );
                // print_r($login_details); exit();
                $result1 = $this->Common_Model->insert('GAME_USER_AUTHENTICATION', $login_details, 0, 0);

                // email ===============================
                if($result1 && $domain) {
                  //$message  = "Thanks for your enrolling!\r\n\r\n";
                  $message  = "Login and password for accessing our eLearning programs and/or assessments are provided below.\r\n\r\n";

                  $message .= "URL: $domain\r\n\r\n";
                  $message .= "Login: $username\r\n";
                  $message .= "Password: $password\r\n\r\n";
                  $message .= "Please contact your Program Administrator for more details.\r\n\r\n";
                  $message .= "Regards,\r\nAdmin\r\nHumanlinks Learning";

                  $this->email->to($email);
                  $this->email->message($message);

                  $addArray = array(
                    //'ESD_Content'         => $message,
                    'ESD_To'              => $email,
                    'ESD_Email_Count'     => 1,
                    'ESD_EnterprizeID'    => $entid,
                    'ESD_DateTime'        => date('Y-m-d H:i:s', time()),
                  );
                  // ESD_Status => 0->Not Send, 1-> Send
                  if ($this->email->send()) {
                    // email Send Success
                    $addArray['ESD_Status'] = 1;
                  }
                  else {
                    // email Not Send
                    $errorlog = $this->email->print_debugger();
                    $errorlog = $errorlog ? $errorlog : 'Email not Send.';

                    $addArray['ESD_Status']  = 0;
                    $addArray['ESD_Comment'] = $errorlog;
                  }
                  $result = $this->Common_Model->insert("GAME_EMAIL_SEND_DETAILS", $addArray, 0, 0);
                }
                // email ===============================
              }
            }
          }

          if (count($duplicate) > 0) {
            $shoMsg = $c . " Record Import successful and the below email id's are duplicate so not inserted:-<br>" . implode('<br>', $duplicate);
          } else {
            $shoMsg = $c . " Record Import successful";
          }

          $result = array(
            "msg"    => $shoMsg,
            "status" => 1
          );
        } catch (Exception $e) {
          $result = array(
            "msg"    => "Error: " . $e,
            "status" => 0
          );
        }
      } else {
        $result = array(
          "msg"    => "Please select CSV or Excel file only",
          "status" => 0
        );
      }
    } else {
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }
    echo json_encode($result);
  }

  //csv upload for subenterprise...
  public function subenterprisecsv($enterpriseid = NULL)
  {
    if (strpos(base_url(), 'localhost') !== FALSE) {
      $sendEmail = FALSE;
    } else {
      $sendEmail = TRUE;
    }

    // Set max upload file size [2MB]
    $maxFileSize = 2097152;
    // Allowed Extensions
    $validext    = array('xls', 'xlsx', 'csv');

    if (isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])) {
      $explode_filename = explode(".", $_FILES['upload_csv']['name']);
      $ext              = strtolower(end($explode_filename));
      if (in_array($ext, $validext)) {
        try {
          $file   = $_FILES['upload_csv']['tmp_name'];
          $handle = fopen($file, "r");
          $flag   = true;
          while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if ($flag) {
              $flag = false;
              continue;
            }
            if (!empty($filesop)) {
              // convert the date format 
              $date      = $filesop[6];
              $StartDate = date("Y-m-d", strtotime($date));
              $newdate   = $filesop[7];
              $EndDate   = date("Y-m-d", strtotime($newdate));
              $mobile    = $filesop[1];
              $email     = $filesop[2];
              $where     = array(
                "SubEnterprise_Number" => $mobile,
                "SubEnterprise_Email"  => $email
              );
              $object = $this->Common_Model->findCount('GAME_SUBENTERPRISE', $where);
              if ($object > 0) {
                echo "details already registered";
                exit;
              }

              if ($enterpriseid == 0) {
                $enterprise = $this->session->userdata('loginData')['User_ParentId'];
              } else {
                $enterprise = $enterpriseid;
              }

              $password = $filesop[5];
              if ($password != '') {
                $password = $filesop[5];
              } else {
                $password = $this->Common_Model->random_password();
              }

              $array = array(
                "SubEnterprise_Name"         => $filesop[0],
                "SubEnterprise_Number"       => $filesop[1],
                "SubEnterprise_Email"        => $filesop[2],
                "SubEnterprise_Address1"     => $filesop[3],
                "SubEnterprise_Address2"     => $filesop[4],
                "SubEnterprise_Password"     => $password,
                "SubEnterprise_EnterpriseID" => $enterprise,
                "SubEnterprise_StartDate"    => $StartDate,
                "SubEnterprise_EndDate"      => $EndDate,
              );
              // print_r($array);exit();
              $insertResult = $this->Common_Model->insert("GAME_SUBENTERPRISE", $array, 0, 0);
              if ($insertResult && $sendEmail) {
                $SubEnterpriseName = $filesop[0];
                $password1         = $password;
                $to                = $filesop[2];
                $from              = "support@corporatesim.com";
                $subject           = "New Account created..";
                $message           = "Dear User Your Account has been created";
                $message          .= "<p>Enterprize Name : " . $SubEnterpriseName;
                $message          .= "<p>Email : " . $filesop[2];
                $message          .= "<p>Password : " . $password1;
                $header            = "From:" . $from . "\r\n";
                $header           .= "MIME-Version: 1.0\r\n";
                $header           .= "Content-type: text/html; charset: utf8\r\n";
                // mail($to,$from,$subject,$message,$header);
              }
            }
          }
          $result = array(
            "msg"    => "Import successful",
            "status" => 1
          );
        } catch (Exception $e) {
          $result = array(
            "msg"    => "Error:",
            "status" => 0
          );
        }
      } else {
        $result = array(
          "msg"    => "Please select CSV or Excel file only",
          "status" => 0
        );
      }
    } else {
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }
    echo json_encode($result);
  }

  //csv upload for subenterprise users
  public function SubEnterpriseUsersCSV($Enterpriseid = NULL, $SubEnterpriseid = NULL)
  {
    // Set max upload file size [2MB]
    $maxFileSize    = 2097152;
    $User_UploadCsv = time();
    // Allowed Extensions
    $validext       = array('xls', 'xlsx', 'csv');

    if (isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])) {
      $explode_filename = explode(".", $_FILES['upload_csv']['name']);
      $ext              = strtolower(end($explode_filename));
      if (in_array($ext, $validext)) {
        try {
          $file              = $_FILES['upload_csv']['tmp_name'];
          $handle            = fopen($file, "r");
          $inserted_data     = array();
          $c                 = 0;
          $flag              = true;
          $duplicate         = array();

          while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            if ($flag) {
              $flag = false;
              continue;
            }

            if (!empty($filesop)) {
              //convert the date format 
              $startDate     = $filesop[6];
              $endDate       = $filesop[7];
              $userStartDate = date("Y-m-d", strtotime($startDate));
              $userEndDate   = date("Y-m-d", strtotime($endDate));
              $mobile        = $filesop[3];
              $email         = $filesop[4];
              $where         = array(
                "User_mobile" => $mobile,
                "User_email"  => $email
              );

              $object = $this->Common_Model->findCount('GAME_SITE_USERS', $where);
              if ($object > 0) {
                // echo "details already registered";
                $duplicate[] = $email;
                continue;
                // exit;
              }
              //enterpriseid for admin and enterprise login
              if ($Enterpriseid == 0) {
                $entid = $this->session->userdata('loginData')['User_ParentId'];
              } else {
                $entid = $Enterpriseid;
              }

              if ($SubEnterpriseid == 0) {
                $subentid = $this->session->userdata('loginData')['User_SubParentId'];
              } else {
                $subentid = $SubEnterpriseid;
              }

              $insertArray = array(
                "User_fname"         => $filesop[0],
                "User_lname"         => $filesop[1],
                "User_username"      => $filesop[2],
                "User_mobile"        => $filesop[3],
                "User_email"         => $filesop[4],
                "User_companyid"     => $filesop[5],
                "User_Role"          => 2,
                "User_ParentId"      => $entid,
                "User_SubParentId"   => $subentid,
                "User_GameStartDate" => $userStartDate,
                "User_GameEndDate"   => $userEndDate,
                "User_datetime"      => date("Y-m-d H:i:s"),
                'User_UploadCsv'     => $User_UploadCsv,
              );
              $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
              $c++;
              if ($result) {
                $uid           = $result;
                $password      = $this->Common_Model->random_password();
                $login_details = array(
                  'Auth_userid'    => $uid,
                  'Auth_username'  => $filesop[2],
                  'Auth_password'  => $password,
                  'Auth_date_time' => date('Y-m-d H:i:s')
                );

                $result1 = $this->Common_Model->insert('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
              }
            }
          }
          if (count($duplicate) > 0) {
            $shoMsg = $c . " Record Import successful and the below email id's are duplicate so not inserted:-<br>" . implode('<br>', $duplicate);
          } else {
            $shoMsg = $c . " Record Import successful";
          }

          $result = array(
            "msg"    => $shoMsg,
            "status" => 1
          );
        } catch (Exception $e) {
          $result = array(
            "msg"    => "Error: " . $e,
            "status" => 0
          );
        }
      } else {
        $result = array(
          "msg"    => "Please select CSV or Excel file only",
          "status" => 0
        );
      }
    } else {
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }

    echo json_encode($result);
  }

  public function getDomainName($Domain_Name = NULL)
  {
    $Domain_Name = $Domain_Name;
    $where       = array(
      'Domain_Status' => 0,
      'Domain_Name'   => trim("http://" . $Domain_Name . ".corporatesim.com"),
    );
    $resultDomain_Name = $this->Common_Model->findCount('GAME_DOMAIN', $where);
    if ($resultDomain_Name > 0) {
      // for duplicate
      echo 'no';
    } else {
      echo 'success';
    }
  }

  public function addCompetence()
  {
    // add competence
    //print_r($this->input->post()); exit();
    $Compt_Name            = $this->input->post('Compt_Name');
    $Compt_Description     = $this->input->post('Compt_Description');
    $Compt_Enterprise_ID   = $this->input->post('Compt_Enterprise_ID');
    $Compt_PerformanceType = $this->input->post('Compt_PerformanceType');
    if (empty($Compt_Name)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Master name can not be left blank.']));
    } else {
      $insertArray = array(
        'Compt_Name'            => $Compt_Name,
        'Compt_Description'     => $Compt_Description,
        'Compt_PerformanceType' => $Compt_PerformanceType,
        'Compt_Enterprise_ID'   => $Compt_Enterprise_ID,
        'Compt_CreatedBy'       => $this->loginDataLocal['User_Id'],
      );
      $checkExistingData = array(
        'Compt_Name'          => $Compt_Name,
        'Compt_Enterprise_ID' => $Compt_Enterprise_ID,
        'Compt_Delete'        => 0,
      );
      $retData = $this->Common_Model->insert('GAME_ITEMS', $insertArray, $checkExistingData);
      if ($retData == 'duplicate') {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Master Name Already Exist.']));
      } else {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Master Added Successfully.']));
      }
    }
  }

  public function addSpecialization(){
    // adding new Specialization
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      //prd($this->input->post()); exit();

      $US_Name = $this->input->post('Specialization_Name');

      if (empty($US_Name)){
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Specialization name can not be left blank.']));
      } 
      else{
        $insertArray = array(
          'US_Name'      => $US_Name,
          'US_CreatedOn' => date('Y-m-d H:i:s', time()),
          'US_CreatedBy' => $this->loginDataLocal['User_Id'],
        );
        $checkExistingData = array('US_Name' => $US_Name);
        $retData = $this->Common_Model->insert('GAME_USER_SPECIALIZATION', $insertArray, $checkExistingData);

        if($retData == 'duplicate'){
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Specialization Name Already Exist.']));
        } 
        else{
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Specialization Added Successfully.']));
        }
      }
    }
  }

  public function editSpecialization(){
    // edit Specialization
    // print_r($this->input->post());
    $US_ID   = $this->input->post('US_ID');
    $US_Name = $this->input->post('Specialization_Name');

    if(empty($US_Name)){
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Specialization Name can not be left blank.']));
    }
    else{
      $updateArray = array('US_Name' => $US_Name);
      $check = array('US_Name' => $US_Name);
      $retData = $this->Common_Model->update('GAME_USER_SPECIALIZATION', $US_ID, $updateArray, $check, 'US_ID');

      if($retData == 'duplicate'){
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Specialization Name Already Exist.']));
      }
      else{
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Specialization Name Updated Successfully.']));
      }
    }
  }

  public function addCampus(){
    // adding new Campus
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      //prd($this->input->post()); exit();

      $UC_Name = $this->input->post('Campus_Name');

      if (empty($UC_Name)){
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Campus name can not be left blank.']));
      } 
      else{
        // Campus Type 1->Management, 2-> Engineering, 3-> Other
        $insertArray = array(
          'UC_Name'      => $this->input->post('Campus_Name'),
          'UC_Type'      => $this->input->post('Campus_Type'),
          'UC_Address'   => $this->input->post('Campus_Address'),
          'UC_Email'     => $this->input->post('Campus_Email'),
          'UC_Contact'   => $this->input->post('Campus_Contact'),
          'UC_CreatedOn' => date('Y-m-d H:i:s', time()),
          'UC_CreatedBy' => $this->loginDataLocal['User_Id'],
        );
        $checkExistingData = array('UC_Name' => $UC_Name);
        $retData = $this->Common_Model->insert('GAME_USER_CAMPUS', $insertArray, $checkExistingData);

        if($retData == 'duplicate'){
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Campus Name Already Exist.']));
        } 
        else{
          die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Campus Added Successfully.']));
        }
      }
    }
  }

  public function editCampus(){
    // edit Campus
    //print_r($this->input->post());
    $UC_ID   = $this->input->post('UC_ID');
    $UC_Name = $this->input->post('Campus_Name');

    if(empty($UC_Name)){
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Campus Name can not be left blank.']));
    }
    else{
      $updateArray = array('UC_Name' => $UC_Name);
      $check = array('UC_Name' => $UC_Name);
      $retData = $this->Common_Model->update('GAME_USER_CAMPUS', $UC_ID, $updateArray, $check, 'UC_ID');

      if($retData == 'duplicate'){
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Campus Name Already Exist.']));
      }
      else{
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Campus Name Updated Successfully.']));
      }
    }
  }

  public function editCompetence()
  {
    // edit competence
    // print_r($this->input->post());
    $Compt_Id          = $this->input->post('Compt_Id');
    $Compt_Name        = trim($this->input->post('Compt_Name'));
    $Compt_Description = trim($this->input->post('Compt_Description'));

    if (empty($Compt_Name)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Master name can not be left blank.']));
    }
    else {
      // taking enterprize ID of item Name
      $where   = array('Compt_Id' => $Compt_Id);
      $details = $this->Common_Model->fetchRecords('GAME_ITEMS', $where, 'Compt_Enterprise_ID', '');
      //print_r($details); print_r($details[0]->Compt_Enterprise_ID); exit();

      // checking Item name exist or not
      $compNameWhere   = array(
        'Compt_Name'          => $Compt_Name,
        'Compt_Enterprise_ID' => $details[0]->Compt_Enterprise_ID,
      );
      $compNameDetails = $this->Common_Model->fetchRecords('GAME_ITEMS', $compNameWhere, 'Compt_Id, Compt_Name', '');
      //print_r($compNameDetails); print_r($compNameDetails[0]->Compt_Id); exit();

      // if item name exist then show error elae update record
      if (!empty($compNameDetails[0]->Compt_Id)) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Master Name Already Exist.']));
      }
      else {
        $where       = array('Compt_Id' => $Compt_Id);
        $updateArray = array(
          'Compt_Name'        => $Compt_Name,
          'Compt_Description' => $Compt_Description,
          'Compt_UpdatedBy'   => $this->loginDataLocal['User_Id'],
          'Compt_UpdatedOn'   => date('Y-m-d H:i:s'),
        );

        $retData = $this->Common_Model->updateRecords('GAME_ITEMS', $updateArray, $where);

        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Master Data Updated Successfully.']));
      }
    }
  }

  public function getPerformanceType($item_ID = NULL)
  {
    $performanceTypeQuery = "SELECT gi.Compt_PerformanceType FROM GAME_ITEMS gi WHERE gi.Compt_Delete = 0 AND gi.Compt_Id = $item_ID";
    $performanceType = $this->Common_Model->executeQuery($performanceTypeQuery);
    //print_r($this->db->last_query()); exit();
    $Compt_PerformanceType = $performanceType[0]->Compt_PerformanceType;

    if ($Compt_PerformanceType) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => '', 'data' => $Compt_PerformanceType]));
    } else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Item To View Card List.']));
    }
  }

  public function compSubcompCheckboxes($selectedCompSubcomps = NULL)
  {
    // print_r($this->input->post());
    // exit();
    if (empty($selectedCompSubcomps)) {
      $selectedCompSubcomps[] = '';
    } else {
      $selectedCompSubcomps = explode('_', $selectedCompSubcomps);
    }
    // prd($this->input->post());
    $competenceId     = $this->input->post('Cmap_ComptId');
    $gamesId          = $this->input->post('Cmap_GameId'); // this is of array type
    $performance_Type = $this->input->post('performance_Type'); // this is performance type of selected item

    if (empty($gamesId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Card To View Data.']));
    } else {
      $returnTableHtml = '<div class="row col-md-12"><div class="col-md-6"><span class="dot-success"></span> Components &nbsp; <span class="dot-danger"></span> SubComponents</div> </div> <table class="table table-bordered table-hover"><thead><tr> <th>Card</th> <th>Competence Readiness</th> <th>Competence Application</th> <th>Simulated Performance</th> </tr></thead><tbody>';
      $gamesId = implode(',', $gamesId);
      // prd($this->input->post());

      // finding the last scenario of selected games
      $scenSql = "SELECT gl.Link_GameID, gl.Link_ID, gl.Link_ScenarioID, gl.Link_Order, gg.Game_Name, gs.Scen_Name FROM GAME_LINKAGE gl LEFT JOIN GAME_GAME gg ON gg.Game_ID = gl.Link_GameID LEFT JOIN GAME_SCENARIO gs ON gs.Scen_ID = gl.Link_ScenarioID WHERE (gl.Link_GameID, gl.Link_Order) IN( SELECT gll.Link_GameID, MAX(gll.Link_Order) FROM GAME_LINKAGE gll WHERE gll.Link_GameID IN($gamesId) AND gl.Link_Status = 1 GROUP BY gll.Link_GameID)";

      $lastScenario = $this->Common_Model->executeQuery($scenSql);
      // echo $scenSql; prd($lastScenario);
      if (count($lastScenario) < 1) {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Scenario Found For Selected Cards.']));
      } else {
        $tableRow = '';
        foreach ($lastScenario as $lastScenarioRow) {
          $tableRow .= '<tr>'; // this is the game comp/subComp row

          // getting the component and subcomponent of scenario one by one
          $compSubcompquery = "SELECT '".$lastScenarioRow->Game_Name."' AS GameName, '".$lastScenarioRow->Scen_Name."' AS ScenName, gls.SubLink_ID AS SubLinkID, gls.SubLink_Competence_Performance AS Competence_Performance, IF(gls.SubLink_SubCompID > 0, 'subComponent', 'component') AS compSubcompType, gls.SubLink_AreaName, CONCAT(gc.Comp_Name,' / ',gc.Comp_NameAlias) AS CompName, CONCAT(gsc.SubComp_Name,' / ',gsc.SubComp_NameAlias) AS SubcompName FROM GAME_LINKAGE_SUB gls LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gsc ON gsc.SubComp_ID = gls.SubLink_SubCompID WHERE gls.SubLink_LinkID = '".$lastScenarioRow->Link_ID."' AND gls.SubLink_ShowHide = 0 AND gls.SubLink_Type = 1 ORDER BY gls.SubLink_CompName, gls.SubLink_SubcompName, gls.SubLink_Competence_Performance";

          $compSubcomp = $this->Common_Model->executeQuery($compSubcompquery);
          // print_r($compSubcompquery); exit();

          // as we are taking only o/p comp/subcomp. // print_r($compSubcomp);
          // echo "<br>starting for ".$lastScenarioRow->Link_GameID."<br><br>";
          if (count($compSubcomp) < 1) {
            // this scenario don't have any comp subcomp or all are hidden
            $tableRow .= '<td class="gameScenRow">' . $lastScenarioRow->Game_Name . ' (' . $lastScenarioRow->Scen_Name . ')</td> <td>N/A</td> <td>N/A</td> <td>N/A</td>';
          } else {
            $tdArray    = array();
            $tdGameScen = '<td class="gameScenRow">' . $lastScenarioRow->Game_Name . ' (' . $lastScenarioRow->Scen_Name . ')</td>';

            $tdSimulatedPerformance = '<td class="tdSimulatedPerformance">';
            $tdCompetence           = '<td class="tdCompetence">';
            $tdApplication          = '<td class="tdApplication">';
            // this scenario has some comp/subcome visible
            foreach ($compSubcomp as $compSubcompRow) {
              // check that this is already selected or not, when editing applicable only then
              if (in_array($compSubcompRow->SubLinkID, $selectedCompSubcomps)) {
                $alreadySelected = 'checked';
              } else {
                $alreadySelected = '';
              }
              // generating html for those. There will be only (3=simulatedPerformance, 4=Competence, 5=Application) for Competence_Performance
              switch ($compSubcompRow->Competence_Performance) {
                case 4:
                  // write code
                  $appendData = 'tdCompetence';
                  break;

                case 5:
                  // write code
                  $appendData = 'tdApplication';
                  break;

                default:
                  // write code
                  $appendData = 'tdSimulatedPerformance';
                  break;
              }

              if (in_array($compSubcompRow->Competence_Performance, $tdArray)) {
                // if Competence_Performance td already created so put this check box into that td 
                $$appendData .= $this->compSubcompCheckboxesHtml($performance_Type, $appendData, $compSubcompRow, $lastScenarioRow->Link_GameID, $alreadySelected);
              } else {
                // create td and put the check box here
                $tdArray[]    = $compSubcompRow->Competence_Performance;
                $$appendData .= $this->compSubcompCheckboxesHtml($performance_Type, $appendData, $compSubcompRow, $lastScenarioRow->Link_GameID, $alreadySelected);
              }
            }
            $tdSimulatedPerformance .= '</td>';
            $tdCompetence           .= '</td>';
            $tdApplication          .= '</td>';
            $tableRow .= $tdGameScen . $tdCompetence . $tdApplication . $tdSimulatedPerformance;
          }
          $tableRow .= '</tr>';
        }
      }
      $returnTableHtml .= $tableRow . '</tbody></table>';
      // die($returnTableHtml);
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Table Created Successfully.', 'data' => $returnTableHtml]));
    }
  }

  private function compSubcompCheckboxesHtml($performance_Type = NULL, $appendData = NULL, $compSubcompRow = NULL, $gameId = NULL, $alreadySelected = NULL)
  {
    // create comp/subcomp checkboxes and return html 
    // prd($compSubcompRow);
    // check compSubcompType i.e. component or subComponent // for Component(#1cc88a), for subComponent(#e74a3b)
    if ($compSubcompRow->compSubcompType == 'component') {
      // if compoentnt, then title as
      $name      = $compSubcompRow->CompName;
      $TextColor = "#1cc88a";
      $title     = 'data-toggle="tooltip" title="Area: ' . $compSubcompRow->SubLink_AreaName . '"';
      $type      = 0;
    } else {
      // if not compoentnt, that means subComponent, then title as CompName
      $name      = $compSubcompRow->SubcompName;
      $TextColor = "#e74a3b";
      $title     = 'data-toggle="tooltip" title="Component: ' . $compSubcompRow->CompName . '"';
      $type      = 1;
    }

    //setting performance_Type_Text behalf of performance_Type so that easily compare can be done between performance_Type_Text and appendData
    switch ($performance_Type) {
      case 4:
        $performance_Type_Text = 'tdCompetence';
        break;
      case 5:
        $performance_Type_Text = 'tdApplication';
        break;
      default:
        $performance_Type_Text = 'tdSimulatedPerformance';
        break;
    }

    //checking if performance_Type_Text is not equal to appendData then make checkbox disabled
    if ($performance_Type_Text === $appendData) {
      return '<div class="custom-control custom-radio" ' . $title . '> <input type="radio" class="custom-control-input" name="' . $gameId . '[]" id="' . $compSubcompRow->SubLinkID . '" value="' . $compSubcompRow->SubLinkID . '_' . $compSubcompRow->Competence_Performance . '_' . $type . '" ' . $alreadySelected . '> <label style="color:' . $TextColor . '" class="custom-control-label" for="' . $compSubcompRow->SubLinkID . '">' . $name . '</label> </div>';
    } else {
      return '<div class="custom-control custom-radio" ' . $title . '> <input type="radio" class="custom-control-input" disabled name="' . $gameId . '[]" id="' . $compSubcompRow->SubLinkID . '" value="' . $compSubcompRow->SubLinkID . '_' . $compSubcompRow->Competence_Performance . '_' . $type . '" ' . $alreadySelected . '> <label style="color:' . $TextColor . '" class="custom-control-label" for="' . $compSubcompRow->SubLinkID . '">' . $name . '</label> </div>';
    }
  }

  public function compUserReportData()
  {
    // prd($this->input->post()); exit();
    $filtertype       = $this->input->post('filtertype');
    $enterpriseId     = $this->input->post('Cmap_Enterprise_ID'); //Enterprise ID for which item is created
    $formulaId        = $this->input->post('Cmap_Formula_ID'); //formula ID
    $report_startDate =  date('Y-m-d H:i:s', strtotime($this->input->post('report_startDate').' 00:00:00'));
    $report_endDate   =  date('Y-m-d H:i:s', strtotime($this->input->post('report_endDate').' 23:59:59'));
    $usersId          = $this->input->post('Cmap_UserId'); //User ID and this is of array type

    if (empty($formulaId)) 
    {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select Formula To View Report.']));
    } 
    else if (empty($usersId) && $filtertype == 'oneByOneItemUsers') 
    {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Select User To View Report.']));
    } 
    else 
    {
      // getting the formula content for the formula evaluation
      $formulaWhere = array(
        'Items_Formula_Id' => $formulaId,
        //'Items_Formula_Enterprise_Id' => $enterpriseId,
      );
      $formulaData = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Expression, Items_Formula_Json');
      // prd($formulaData);

      $returnTableHtml = '<table class="stripe hover data-table-export"><thead><tr> <th>ID</th> <th>Name (email)</th>';

      if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){
        //if superadmin login then show Company/Institute Name
        $returnTableHtml .= '<th>Company/Institute</th>';
      }
      $returnTableHtml .= '<th>Formula Value</th> <th>Report</th> </tr></thead><tbody>';

      // finding the user details according filter type
      $userQuery = "SELECT gsu.User_id, CONCAT(gsu.User_fname, ' ', gsu.User_lname) AS User_fullName, gsu.User_username, gsu.User_email, ge.Enterprise_ID, ge.Enterprise_Name FROM GAME_SITE_USERS gsu LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId WHERE gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_datetime BETWEEN '$report_startDate' AND '$report_endDate' ";

      switch ($filtertype) {
        case 'oneByOneItemUsers':
          //when one enterprise selected some specific user to generate report
          $usersId = implode(',', $usersId);
          //print_r($usersId); exit();
          $userQuery .= "AND gsu.User_id IN ($usersId) AND ge.Enterprise_ID = ". $enterpriseId." ";
          break;
        case 'myItemUsers':
          //when one enterprise all users selecte to generate report
          $userQuery .= "AND ge.Enterprise_ID = ". $enterpriseId." ";
          break;
        case 'allItemUsers':
          //when all enterprise all users selecte to generate report
          break;
        default:
      }

      $userQuery .= "ORDER BY gsu.User_fname, gsu.User_lname ASC";
      //print_r($userQuery); exit();
      $userList = $this->Common_Model->executeQuery($userQuery);

      if (count($userList) < 1) 
      {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No User Found Between Selected Date']));
      } 
      else 
      {
        $tableRow = '';
        $slNo = 1;
        $overall_Scatter_Chart = [];
        foreach ($userList as $userListRow) 
        {
          // $tableRow .= '<tr> <td>' . $slNo . '</td> <td title="' . $userListRow->User_username . '"><a href="javascript:void(0);" data-user_id='.$userListRow->User_id.' data-enterprise_id='.$userListRow->Enterprise_ID.' data-formula_expression="'.$formulaData[0]->Items_Formula_Expression.'" data-formula_Json="'.$formulaData[0]->Items_Formula_Json.'" data-toggle="tooltip" title="View Report Chart" onclick="showReportChart(this)">' . $userListRow->User_fullName . ' (' . $userListRow->User_email . ')</a></td>';

          $tableRow .= '<tr> <td>' . $slNo . '</td> <td title="' . $userListRow->User_username . '"><a href="javascript:void(0);" data-user_id='.$userListRow->User_id.' data-enterprise_id='.$userListRow->Enterprise_ID.' data-toggle="tooltip" title="View Sub-factor Chart" onclick="showReportChart(this)">' . $userListRow->User_fullName . ' (' . $userListRow->User_email . ')</a></td>';

          if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){
            //if superadmin login then show Company/Institute Name
            // $tableRow .= '<td>' . $userListRow->Enterprise_Name . '</td> <td></td>';
            $tableRow .= '<td>' . $userListRow->Enterprise_Name . '</td>';
          }
           // fetching user over all data according to formula
           // $tableRow .= "<td>" . $this->overallValue($userListRow->User_id, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json) . "</td>";

          $returned_Value = $this->overallValue($userListRow->User_id, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
          $returned_Value = json_decode($returned_Value);

          $user_Input_Date       = $returned_Value->input_Date ? $returned_Value->input_Date : 0;
          //setting cap for overall value at 200
          $user_Overall_Value    = $returned_Value->overall_Value >= 200 ? 200 :  round($returned_Value->overall_Value, 2);
          $overall_Scatter_Chart[$slNo-1][0] = array($user_Input_Date);
          $overall_Scatter_Chart[$slNo-1][1] = array($user_Overall_Value);

          $tableRow .= '<td>' . $user_Overall_Value . '</td> <td><a href="javascript:void(0);" data-user_id='.$userListRow->User_id.' data-enterprise_id='.$userListRow->Enterprise_ID.' data-toggle="tooltip" title="Download Report" onclick="downloadReport(this)"><i class="fa fa-download"></i></a></td>';

          $tableRow .= '</tr>';
          $slNo++;
        }
        // prd($overall_Scatter_Chart);
      }
      //print_r($returned_Value->averageJson);
      $returnTableHtml .= $tableRow . '</tbody></table>';
      // die($returnTableHtml);
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Table Created Successfully.', 'data' => $returnTableHtml, 'overallScatterChart' => $overall_Scatter_Chart]));
    }
  }

  private function overallValue($userid = NULL, $formulaString = NULL, $itemCompSubcompJson = NULL)
  {
    $formulaString = explode(' ', $formulaString);
    $averageJson = array();
    $input_Date_Current = ''; 
    // check that user has game or not, completed the game as per the date filter, and take the average and calculate the final value for that 

    // pr($userid); pr(explode(' ', $formulaString)); pr(json_decode($itemCompSubcompJson, true)); prd();

    // if item__id is used in formula, and $itemCompSubcompJson doesn't contain the array[item__id], this means this item id need to be mapped with comp-subcomp
    $gameCompSubcomp = json_decode($itemCompSubcompJson, true);
    foreach ($gameCompSubcomp as $gameCompSubcompRow => $gameCompSubcompValue) {
      // pr($gameCompSubcompRow); pr($gameCompSubcompValue); $averageJson[$gameCompSubcompRow]
      for ($l = 0; $l < count($gameCompSubcompValue); $l++) {
        // this contains sublinkId, gameid. So check for game existance, palyed status and then pick value
        $sublink_gameid = explode(',', $gameCompSubcompValue[$l]);
        $sublinkid = $sublink_gameid[0];
        $gameid = $sublink_gameid[1];

        $userDataSql = "SELECT gug.UG_ID, gug.UG_GameStartDate, gug.UG_GameEndDate, gus.US_ID, gus.US_LinkID, gus.US_CompletedOn, gi.input_current, gug.UG_CratedOn FROM GAME_USERGAMES gug LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gug.UG_GameID AND gus.US_UserID = " . $userid . " LEFT JOIN GAME_INPUT gi ON gi.input_user = " . $userid . " AND gi.input_sublinkid =" . $sublinkid . " WHERE gug.UG_UserID = " . $userid . " AND gug.UG_GameID =" . $gameid;
        $userGameData = $this->Common_Model->executeQuery($userDataSql);
        // this means game is allocated, there must be only one row for user
        //pr($userGameData);
        if (count($userGameData) > 0) {
          //pr($userGameData[0]->US_LinkID);
          //$averageJson[$gameCompSubcompRow][$l] = ($userGameData[0]->input_current) ? number_format((float)$userGameData[0]->input_current, 2, '.', '') : 0;
          //round($userGameData[0]->input_current, 2)
          $averageJson[$gameCompSubcompRow][$l] = ($userGameData[0]->input_current) ? round($userGameData[0]->input_current, 2) : 0;
          //echo 'input_val '.$userGameData[0]->input_current.'<br>';
          $input_Date_Current = $userGameData[0]->UG_CratedOn;
        }
      }
      // evaluate avg of each item after getting the value from avove
      if (isset($averageJson[$gameCompSubcompRow])) {
        // echo implode(' + ', $averageJson[$gameCompSubcompRow]) . "<br>";
        $averageJson[$gameCompSubcompRow] = array_sum($averageJson[$gameCompSubcompRow]) / count($averageJson[$gameCompSubcompRow]);
      }
    }
    // evaluate the final formula, as the avg of each item has been retrived above 
    for ($s = 0; $s < count($formulaString); $s++) {
      if (strpos($formulaString[$s], 'item__') !== false) {
        $item__id = explode('__', $formulaString[$s]);
        $itemid = end($item__id);
        $formulaString[$s] = (array_key_exists($itemid,$averageJson)) ? round($averageJson[$itemid], 2) : 0;
      }
    }
    //prd($averageJson); echo implode('',$formulaString).'<br><br>';
    //return eval("return ".implode('',$formulaString).";");

    $overall_Value = eval("return ".implode('',$formulaString).";");
    // $input_Date    = date('d-m-Y', strtotime($input_Date_Current));
    $input_Date    = strtotime($input_Date_Current);
    return(json_encode(['overall_Value' => $overall_Value, 'input_Date' => $input_Date, 'averageJson' => $averageJson]));
  }

  public function showReportChart($userid = NULL, $formulaId = NULL, $enterpriseId = NULL)
  {
    // getting the formula content for the formula evaluation
    $formulaWhere = array(
      'Items_Formula_Id' => $formulaId,
      //'Items_Formula_Enterprise_Id' => $enterpriseId,
    );
    $formulaData = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Expression, Items_Formula_Json');
    // prd($formulaData);

    $returned_Value = $this->overallValue($userid, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
    $returned_Value = json_decode($returned_Value);
    //prd($returned_Value->averageJson);

    $reportData = [];
    foreach ($returned_Value->averageJson as $key => $value) {
      $reportData[]  = $value;
    }
    //prd($reportData);

    // $reportData = [1,2,3];
    if (count($reportData) > 0) {
      $chartData             = [];
      $chartLabels           = [];
      $chartBackgroundColor  = [];
      $chartBorderColor      = [];

      foreach ($returned_Value->averageJson as $key => $value) {
        //setting cap for overall value at 200
        $chartData[]  = $value >= 200 ? 200 : round($value, 2);

        //getting Item Name
        $itemWhere = array(
          'Compt_Id' => $key,
          //'Compt_Enterprise_ID' => $enterpriseId,
        );
        $itemData = $this->Common_Model->fetchRecords('GAME_ITEMS', $itemWhere, 'Compt_Name, Compt_PerformanceType');
        //print_r($itemData); exit();

        //pushina data according to it's performance type
        switch ($itemData[0]->Compt_PerformanceType) {
          case 3:
            // 3=simulated Performance
            $chartLabels[]          = $itemData[0]->Compt_Name;
            $chartBackgroundColor[] = 'rgba(25, 118, 210, 0.2)';//Blue
            $chartBorderColor[]     = 'rgba(25, 118, 210, 1)';
            break;

          case 4:
            // 4=Competence
            $chartLabels[]          = $itemData[0]->Compt_Name;
            $chartBackgroundColor[] = 'rgba(245, 124, 0, 0.2)';//Orange
            $chartBorderColor[]     = 'rgba(245, 124, 0, 1)';
            break;

          case 5:
            // 5=Application  
            $chartLabels[]          = $itemData[0]->Compt_Name;
            $chartBackgroundColor[] = 'rgba(69, 90, 100, 0.2)';//Blue Gray
            $chartBorderColor[]     = 'rgba(69, 90, 100, 1)';
            break;

          default:
            // write code
        }
      }

      //setting cap for overall value at 200
      //pushina data for overall Value
      $chartData[]            = $returned_Value->overall_Value >= 200 ? 200 : round($returned_Value->overall_Value, 2);
      $chartLabels[]          = 'Formula Value';
      $chartBackgroundColor[] = 'rgba(56, 142, 60, 0.2)';//Green
      $chartBorderColor[]     = 'rgba(56, 142, 60, 1)';

      die(json_encode(['chartData' => $chartData, 'chartLabels' => $chartLabels, 'chartBackgroundColor' => $chartBackgroundColor, 'chartBorderColor' => $chartBorderColor, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Report Graph Data.']));
    } 
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Oops!', 'icon' => 'error', 'message' => 'Not completed by User']));
    }
  }

  public function downloadReport($userid = NULL, $formulaId = NULL, $enterpriseId = NULL) {
    // query to get user Details
    $userQuery = "SELECT gsu.User_id, gsu.User_username, gsu.User_email, gsu.User_mobile, gsu.User_fname, gsu.User_lname, ge.Enterprise_ID, ge.Enterprise_Name, gc.Country_Name FROM GAME_SITE_USERS gsu LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gsu.User_ParentId LEFT JOIN GAME_COUNTRY gc ON gc.Country_Id = ge.Enterprise_Country WHERE gsu.User_id = $userid";
    $userDetails = $this->Common_Model->executeQuery($userQuery);
    //prd($userDetails); exit();

    // query to get Header Section of report
    $headerQuery = "SELECT gir.IR_Text FROM GAME_ITEM_REPORT gir WHERE gir.IR_ID = 1";
    $headerDetails = $this->Common_Model->executeQuery($headerQuery);
    //prd($headerDetails); exit();

    // query to get Disclaimer Section of report
    $disclaimerQuery = "SELECT gir.IR_Text FROM GAME_ITEM_REPORT gir WHERE gir.IR_ID = 2";
    $disclaimerDetails = $this->Common_Model->executeQuery($disclaimerQuery);
    //prd($disclaimerDetails); exit();

    // getting the formula content for the formula evaluation
    $formulaWhere = array('Items_Formula_Id' => $formulaId);
    $formulaData  = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Expression, Items_Formula_Json, Items_Formula_Report_Name_Definition, Items_Formula_Detailed_Report');
    // prd($formulaData);

    $report_Title_Definition = $formulaData[0]->Items_Formula_Report_Name_Definition ? $formulaData[0]->Items_Formula_Report_Name_Definition : '';

    $report_Detailed = $formulaData[0]->Items_Formula_Detailed_Report ? $formulaData[0]->Items_Formula_Detailed_Report : '';

    $returned_Value = $this->overallValue($userid, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
    $returned_Value = json_decode($returned_Value);

    //prd($returned_Value->overall_Value); exit();
    //prd($returned_Value->input_Date); exit();
    //prd($returned_Value->averageJson); exit();

    $reportData = [];
    foreach ($returned_Value->averageJson as $key => $value) {
      $reportData[]  = $value;
    }
    // prd($reportData);

    // $reportData = [1,2,3];
    if (count($reportData) > 0) {
      $reportValue               = [];
      $reportSubFactorName       = [];
      $reportFactorType          = [];
      $itemConditionsText        = [];
      $itemConditionsScoreStatus = [];
      $itemArray                 = []; // for using in individual report
      $valueArray                = []; // for using in individual report

      foreach ($returned_Value->averageJson as $key => $value) {
        // setting cap for overall value at 200
        $reportValue[]  = $value >= 200 ? 200.00 : sprintf("%.2f", $value);
        $currentValue   = $value >= 200 ? 200.00 : sprintf("%.2f", $value);

        // storing into array with value for individual report
        $itemArray[]  = $key; // item ID
        $valueArray[] = $currentValue; //item scored value

        // getting Item Name
        $itemWhere = array('Compt_Id' => $key);
        $itemData = $this->Common_Model->fetchRecords('GAME_ITEMS', $itemWhere, 'Compt_Name, Compt_PerformanceType');
        // print_r($itemData); exit();

        // getting Item Conditions
        // IC_Score_Status -> 0=Show, 1=Hide
        $query = "SELECT gic.IC_Text, gic.IC_Score_Status FROM GAME_ITEM_CONDITIONS gic WHERE gic.IC_Item_ID = $key AND gic.IC_Min_Value <= '$currentValue' AND gic.IC_Max_Value >= '$currentValue'";
        $itemConditionsData = $this->Common_Model->executeQuery($query);
        //print_r($itemConditionsData); exit();
        //print_r($itemConditionsData[0]->IC_Text); exit();
        $itemConditionsText[] = $itemConditionsData ? $itemConditionsData[0]->IC_Text : '';
        $itemConditionsScoreStatus[] = $itemConditionsData ? $itemConditionsData[0]->IC_Score_Status : 1;

        $reportSubFactorName[] = $itemData[0]->Compt_Name;
        $reportFactorType[]    = $itemData[0]->Compt_PerformanceType;
        // pushina data according to it's performance type
        // 4 = Competence Readiness
        // 5 = Competence Application
        // 3 = Simulated Performance
      }

      // storing every outcomes of individual report
      // $individualReport = '';
      $individualReport = [];
      $countLoop = 0; // count loop to store values in an array
      // looping for individual report ( $itemArray $valueArray )
      for ($x=0; $x<count($itemArray); $x++) {
        // for x-axis loop
        for ($y=0; $y<count($itemArray); $y++) {
          // for y-axis loop

          // setting x-axis and y-axis item id for query
          $xAxis = $itemArray[$x];
          $yAxis = $itemArray[$y];

          // setting x-axis and y-axis value for query
          // Readiness
          $xAxisValue = $valueArray[$x] < 100 ? sprintf("%.2f", $valueArray[$x]) : 100.00;
          // Application
          $yAxisValue = $valueArray[$y] < 200 ? sprintf("%.2f", $valueArray[$y]) : 200.00;

          // query to fetch data
          // IRI_Type_Choice => 1 = EXECUTIVE SUMMARY, 2 = CONCLUSION SECTION
          // IRI_Condition_Type => 1 = Average, 2 = Individual 
          $query = "SELECT giri.IRI_ID, giri.IRI_Text, giri.IRI_Type_Choice, giri.IRI_Score_Status 
          FROM GAME_ITEM_REPORT_INDIVIDUAL giri 
          WHERE 
                giri.IRI_Formula_Enterprize_ID = $enterpriseId 
            AND giri.IRI_Items_Formula_Id = $formulaId 
            AND giri.IRI_Condition_Type = 2
            AND giri.IRI_xAxis_Item_Id = $xAxis
            AND giri.IRI_xAxis_Min_Value <= '$xAxisValue' 
            AND giri.IRI_xAxis_Max_Value >= '$xAxisValue'
            AND giri.IRI_yAxis_Item_Id = $yAxis
            AND giri.IRI_yAxis_Min_Value <= '$yAxisValue' 
            AND giri.IRI_yAxis_Max_Value >= '$yAxisValue'";

          $individualReportData = $this->Common_Model->executeQuery($query);
          // print_r($query); exit();
          // print_r($individualReportData); exit();
          
          // if result found then store it into array
          if (count($individualReportData) > 0) {
            // $individualReport[] = $individualReportData[0];

            // storing Data in to array
            $individualReport[$countLoop]['IRI_ID'] = $individualReportData[0]->IRI_ID;
            $individualReport[$countLoop]['IRI_Text'] = $individualReportData[0]->IRI_Text;

            // IRI_Type_Choice => 1 = EXECUTIVE SUMMARY, 2 = CONCLUSION SECTION
            $individualReport[$countLoop]['IRI_Type_Choice'] = $individualReportData[0]->IRI_Type_Choice;

            // Score of x and y axis
            $individualReport[$countLoop]['xAxisValue'] = $xAxisValue;
            $individualReport[$countLoop]['yAxisValue'] = $yAxisValue;

            // IRI_Score_Status => 0=Hide, 1=Show Both, 2=Show x-axis(Readiness), 3=Show y-axis(Application)
            $individualReport[$countLoop]['IRI_Score_Status'] = $individualReportData[0]->IRI_Score_Status;

            // Performance type => 4 = Competence Readiness, 5 = Competence Application, 3 = Simulated Performance
            $individualReport[$countLoop]['xAxisFactorType'] = $reportFactorType[$x];
            $individualReport[$countLoop]['yAxisFactorType'] = $reportFactorType[$y];

            $countLoop++; // incrementing count loop
          } // end of if condition
        } // end of y-axis loop
      } // end of x-axis loop

      // print_r($individualReport); exit();
      // ==================================
      // print_r($individualReport[0]->IRI_Text); exit();

      // setting cap for overall value at 200
      // pushina data for overall Value
      $reportValue[] = $returned_Value->overall_Value >= 200 ? 200.00 : sprintf("%.2f", $returned_Value->overall_Value);

      $reportSubFactorName[]       = 'Formula Value';
      $reportFactorType[]          = 'Formula';
      $itemConditionsText[]        = 'Formula Text';
      $itemConditionsScoreStatus[] = 'Score Status';
      //==========================================
      $overall_Value = round($returned_Value->overall_Value);
      
      // when competence type set to 0 this means this card not used in formula
      $countCR = 0;
      $countCA = 0;
      $countSP = 0;

      // calculating total score value for each factor type that is used in selected formula
      $scoreCR = 0;
      $scoreCA = 0;
      $scoreSP = 0;

      for ($i=0; $i<count($reportFactorType); $i++) {
        // 4 = Competence Readiness
        if ($reportFactorType[$i] == 4) {
          $countCR++;
          $scoreCR += $reportValue[$i];
        }
        // 5 = Competence Application
        if ($reportFactorType[$i] == 5) {
          $countCA++;
          $scoreCA += $reportValue[$i];
        }
        // 3 = Simulated Performance
        if ($reportFactorType[$i] == 3) {
          $countSP++;
          $scoreSP += $reportValue[$i];
        }
      }
      // print_r($countCR); echo '<br />'; print_r($scoreCR); exit();

      // calculating average score value for each factor type
      $averageCR = round($scoreCR) > 0 ? sprintf("%.2f", $scoreCR/$countCR) : 0.00;
      $averageCA = round($scoreCA) > 0 ? sprintf("%.2f", $scoreCA/$countCA) : 0.00;
      $averageSP = round($scoreSP) > 0 ? sprintf("%.2f", $scoreSP/$countSP) : 0.00;
      // print_r($averageCR); echo '<br />'; print_r($averageCA); echo '<br />'; print_r($averageSP); exit();

      // IR_Type_Choice 1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION
      // getting game_item_report Executive Summary and Conclusion Section
      $executiveConclusionQuery = "SELECT gir.IR_Text, gir.IR_Type_Choice FROM GAME_ITEM_REPORT gir WHERE gir.IR_Formula_Enterprize_ID = $enterpriseId AND gir.IR_Items_Formula_Id = $formulaId AND gir.IR_Min_Value <= '$overall_Value' AND gir.IR_Max_Value >= '$overall_Value' AND gir.IR_CR_Min_Average_Value <= '$averageCR' AND gir.IR_CR_Max_Average_Value >= '$averageCR' AND gir.IR_CA_Min_Average_Value <= '$averageCA' AND gir.IR_CA_Max_Average_Value >= '$averageCA' AND gir.IR_SP_Min_Average_Value <= '$averageSP' AND gir.IR_SP_Max_Average_Value >= '$averageSP'";
      $executiveConclusionData = $this->Common_Model->executeQuery($executiveConclusionQuery);
      // print_r($executiveConclusionQuery);
      //====================================
      die(json_encode(['userDetails' => $userDetails, 'headerDetails' => $headerDetails, 'disclaimerDetails' => $disclaimerDetails, 'report_Title_Definition' => $report_Title_Definition, 'report_Detailed' => $report_Detailed, 'executiveConclusionData' => $executiveConclusionData, 'reportValue' => $reportValue, 'reportSubFactorName' => $reportSubFactorName, 'reportFactorType' => $reportFactorType, 'itemConditionsText' => $itemConditionsText, 'itemConditionsScoreStatus' => $itemConditionsScoreStatus, 'individualReport' => $individualReport, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Report Data.']));
    }
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => 'Oops!', 'icon' => 'error', 'message' => 'Not completed by User']));
    }
  }

  public function itemFormulaFormSubmit() {
    // prd($this->input->post()); exit();

    $formula_enterprise_Id   = $this->input->post('Cmap_Enterprise_ID');
    $formula_title           = trim($this->input->post('formula_title'));
    $formula_string          = $this->input->post('formula_string');
    $formula_expression      = $this->input->post('formula_expression');
    $formula_item_id         = $this->input->post('formula_item_id'); // this is comma seprated item id used in formula
    $formula_id              = $this->input->post('formula_id');

    $itemIdArray = explode(",", $formula_item_id);
    $itemIdArray = array_unique($itemIdArray); // got the unique items id in an array

    $formula_expression_array = explode(",", $formula_expression);
    $formula_expression = implode(" ", $formula_expression_array);
    $compSubcompWithItemId = array();

    // getting all the sublink id for comp/subcomp linked with this itemid
    for ($m = 0; $m < count($itemIdArray); $m++) {
      $itemSubLinkQuery = "SELECT gim.Cmap_ComptId, gim.Cmap_GameId, gim.Cmap_SublinkId FROM GAME_ITEMS_MAPPING gim WHERE gim.Cmap_Enterprise_ID = $formula_enterprise_Id AND gim.Cmap_ComptId = $itemIdArray[$m] ORDER BY gim.Cmap_Id ASC";
      $itemSubLinkList = $this->Common_Model->executeQuery($itemSubLinkQuery);
      if (count($itemSubLinkList) > 0) {
        // if the mapping exist then only create json for this
        foreach ($itemSubLinkList as $itemSubLinkListRow) {
          $compSubcompWithItemId[$itemIdArray[$m]][] = $itemSubLinkListRow->Cmap_SublinkId . ',' . $itemSubLinkListRow->Cmap_GameId;
        }
      }
    }
    // prd($compSubcompWithItemId);
    $items_formula_json = json_encode($compSubcompWithItemId);

    if ($formula_id) {
      $updateArray = array(
        'Items_Formula_Title'         => $formula_title,
        'Items_Formula_String'        => $formula_string,
        'Items_Formula_Expression'    => $formula_expression,
        'Items_Formula_Json'          => $items_formula_json,
        'Items_Formula_Enterprise_Id' => $formula_enterprise_Id,
        'Items_Formula_UpdatedBy'     => $this->session->userdata('loginData')['User_Id'],
        'Items_Formula_UpdatedOn'     => date('Y-m-d H:i:s'),
      );
      $checkExistingData = array(
        'Items_Formula_Title' => $formula_title,
      );
      $insertUpdateData = $this->Common_Model->update('GAME_ITEMS_FORMULA', $formula_id, $updateArray, $checkExistingData, 'Items_Formula_Id');
    }
    else {
      $insertArray = array(
        'Items_Formula_Title'         => $formula_title,
        'Items_Formula_String'        => $formula_string,
        'Items_Formula_Expression'    => $formula_expression,
        'Items_Formula_Json'          => $items_formula_json,
        'Items_Formula_Enterprise_Id' => $formula_enterprise_Id,
        'Items_Formula_CreatedBy'     => $this->session->userdata('loginData')['User_Id'],
        'Items_Formula_CreatedOn'     => date('Y-m-d H:i:s'),
      );
      $checkExistingData = array(
        'Items_Formula_Title' => $formula_title,
      );
      $insertUpdateData = $this->Common_Model->insert('GAME_ITEMS_FORMULA', $insertArray, $checkExistingData);
    }

    if ($insertUpdateData == 'duplicate') {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Formula Title Already Exist.']));
    }
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 500, "status" => "200", 'title' => "", 'icon' => 'success', 'message' => 'Formula Added Successfully.']));
    }
  }

  public function dashboardChartData() {
    // prd($this->input->post()); exit();
    $formulaId = $this->input->post('Cmap_Formula_ID'); //formula ID
    if (empty($formulaId)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Please Select Score Selector To View Report.']));
    } 
    else {
      $enterpriseId     = $this->session->userdata('loginData')['User_Id']; //Enterprise ID for which item is created
      $report_startDate =  date('Y-m-d H:i:s', strtotime($this->input->post('report_startDate').' 00:00:00'));
      $report_endDate   =  date('Y-m-d H:i:s', strtotime($this->input->post('report_endDate').' 23:59:59'));

      // getting the formula content for the formula evaluation
      $formulaWhere = array('Items_Formula_Id' => $formulaId);
      $formulaData = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Expression, Items_Formula_Json');
      // prd($formulaData);

      // ====================================================
      // fetching 25 user list
      $userDataSql = "SELECT gi.input_user, gi.input_caretedOn FROM GAME_INPUT gi LEFT JOIN GAME_SITE_USERS gsu ON gsu.User_id = gi.input_user WHERE gsu.User_ParentId = $enterpriseId AND gi.input_caretedOn BETWEEN 'report_startDate' AND '$report_endDate' GROUP BY gi.input_user ORDER BY gi.input_id DESC LIMIT 25";
      $userData = $this->Common_Model->executeQuery($userDataSql);
      //print_r($userData); exit();

      // making array to hold last 25 users chart data
      // lastTwentyFiveChart
      $overallValue = [];
      $creationDate = [];
      $i = 0;
      $overallValue[0] = 0;
      $creationDate[0] = 0;

      foreach ($userData as $userDataRow) {
        $returned_Value = $this->overallValue($userDataRow->input_user, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
        $returned_Value = json_decode($returned_Value);
        // print_r($returned_Value); 

        // $user_Input_Date    = $returned_Value->input_Date;
        // setting cap for overall value at 200
        $user_Overall_Value = $returned_Value->overall_Value >= 200 ? 200 :  round($returned_Value->overall_Value, 2);

        $overallValue[$i] = $user_Overall_Value ? $user_Overall_Value : 0;
        $creationDate[$i] = $userDataRow->input_caretedOn ? date('Y-m-d', strtotime($userDataRow->input_caretedOn)) : 0;
        $i++;
      }

      // ====================================================
      $userDataQuery = "SELECT gsu.User_id FROM GAME_SITE_USERS gsu WHERE gsu.User_Role = 1 AND gsu.User_Delete = 0 AND gsu.User_datetime BETWEEN '$report_startDate' AND '$report_endDate' AND gsu.User_ParentId = $enterpriseId";

      $userIDData = $this->Common_Model->executeQuery($userDataQuery);
      //print_r(count($userIDData)); exit();

      // ====================================================
      // Readiness Vs Simulated Performance
      $quadrantCRvsSPI = []; // Quadrant I -> x-axis (100 - ---), y-axis (100 - ---)
      $quadrantCRvsSPII = []; // Quadrant II -> x-axis (0 - 100), y-axis (100 - ---)
      $quadrantCRvsSPIII = []; // Quadrant III -> x-axis (0 - 100), y-axis (0 - 100)
      $quadrantCRvsSPIV = []; // Quadrant IV -> x-axis (100 - ---), y-axis (0 - 100)

      // Readiness Vs Application
      $quadrantCRvsCAI = []; // Quadrant I -> x-axis (100 - ---), y-axis (100 - ---)
      $quadrantCRvsCAII = []; // Quadrant II -> x-axis (0 - 100), y-axis (100 - ---)
      $quadrantCRvsCAIII = []; // Quadrant III -> x-axis (0 - 100), y-axis (0 - 100)
      $quadrantCRvsCAIV = []; // Quadrant IV -> x-axis (100 - ---), y-axis (0 - 100)
      // ====================================================

      // highestValueChart Data
      $heighestCR      = 0;
      $heighestCA      = 0;
      $heighestSP      = 0;
      $heighestOvarall = 0;

      // highestValueChart user id for singlePersonChart Data
      $heighestUserIDCR      = 0;
      $heighestUserIDCA      = 0;
      $heighestUserIDSP      = 0;
      $heighestUserIDOvarall = 0;

      // averageValueChart Data
      $averageCountCR      = 0;
      $averageCountCA      = 0;
      $averageCountSP      = 0;
      $averageCountOvarall = 0;

      // storing tree map chart data count (Readiness Vs Application)
      // for Learned (score-> 81-100)
      $x1y1 = 0; // 0-25
      $x1y2 = 0; // 100-150
      $x1y3 = 0; // 150-200
      $x1y4 = 0; // 200+
      // for Informed (score-> 61-80)
      $x2y1 = 0; // 0-25
      $x2y2 = 0; // 100-150
      $x2y3 = 0; // 150-200
      $x2y4 = 0; // 200+
      // for Knowledgeable (score-> 41-60)
      $x3y1 = 0; // 0-25
      $x3y2 = 0; // 100-150
      $x3y3 = 0; // 150-200
      $x3y4 = 0; // 200+
      // for Beginner / Ignorant (score-> 0-40)
      $x4y = 0; // 0-200+

      $i = 0;
      foreach ($userIDData as $userIDDataRow) {
        // Storing Score Value for each item type 
        $quadrantScoreCR = 0;
        $quadrantScoreCA = 0;
        $quadrantScoreSP = 0;

        $quadrantCountCR = 0;
        $quadrantCountCA = 0;
        $quadrantCountSP = 0;

        // Setting Overall Value 
        $returned_Value = $this->overallValue($userIDDataRow->User_id, $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
        $returned_Value = json_decode($returned_Value);
        // print_r($returned_Value); 

        $user_Overall_Value = $returned_Value->overall_Value >= 200 ? 200 :  $returned_Value->overall_Value;

        $averageCountOvarall = $user_Overall_Value + $averageCountOvarall;
        if ($user_Overall_Value > $heighestOvarall) {
          $heighestOvarall       = (int)$user_Overall_Value;
          $heighestUserIDOvarall = $userIDDataRow->User_id;
        }

        foreach ($returned_Value->averageJson as $key => $value) {
          // setting cap for overall value at 200
          $value = $value >= 200 ? 200 : $value;
          // $value = $user_Overall_Value; // for tree chart and quadrant chart

          // getting Item Name
          $itemWhere = array('Compt_Id' => $key);
          $itemData = $this->Common_Model->fetchRecords('GAME_ITEMS', $itemWhere, 'Compt_Name, Compt_PerformanceType');
          // print_r($itemData); exit();

          // pushina data according to it's performance type
          switch ($itemData[0]->Compt_PerformanceType) {
            case 3:
              // 3 = Simulated Performance
              $quadrantScoreSP = $quadrantScoreSP + $value; // setting SP value for use in Quadrants
              $averageCountSP = $averageCountSP + $value;
              if ($value > $heighestSP) {
                $heighestSP       = (int)$value;
                $heighestUserIDSP = $userIDDataRow->User_id;
              }
              $quadrantCountSP++;
              break;

            case 4:
              // 4 = Competence Readiness
              $quadrantScoreCR = $quadrantScoreCR + $value; // setting CR value for use in Quadrants
              $averageCountCR = $averageCountCR + $value;
              if ($value > $heighestCR) {
                $heighestCR       = (int)$value;
                $heighestUserIDCR = $userIDDataRow->User_id;
              }
              $quadrantCountCR++;
              break;

            case 5:
              // 5 = Competence Application
              $quadrantScoreCA = $quadrantScoreCA + $value; // setting CA value for use in Quadrants
              $averageCountCA = $averageCountCA + $value;
              if ($value > $heighestCA) {
                $heighestCA       = (int)$value;
                $heighestUserIDCA = $userIDDataRow->User_id;
              }
              $quadrantCountCA++;
              break;
          }
        }
        // storing score value into array

        // Readiness Vs Simulated Performance
        // x-axis -> Simulated Performance, y-axis -> Readiness

        // sending values into array according to Quadrant Criteria for Readiness Vs Simulated Performance
        // $quadrantCRvsSP = [];
        // $quadrantCRvsSP[0]  = round($quadrantScoreSP, 2);
        // $quadrantCRvsSP[1]  = round($quadrantScoreCR, 2);
        // // Quadrant I
        // if ($quadrantScoreSP > 100 && $quadrantScoreCR > 100) {
        //   $quadrantCRvsSPI[] = $quadrantCRvsSP;
        // }
        // // Quadrant II
        // else if ($quadrantScoreSP >= 0 && $quadrantScoreSP <= 100 && $quadrantScoreCR > 100) {
        //   $quadrantCRvsSPII[] = $quadrantCRvsSP;
        // }
        // // Quadrant III
        // else if ($quadrantScoreSP >= 0 && $quadrantScoreSP <= 100 && $quadrantScoreCR >= 0 && $quadrantScoreCR <= 100) {
        //   $quadrantCRvsSPIII[] = $quadrantCRvsSP;
        // }
        // // Quadrant IV
        // else if ($quadrantScoreSP > 100 && $quadrantScoreCR >= 0 && $quadrantScoreCR <= 100) {
        //   $quadrantCRvsSPIV[] = $quadrantCRvsSP;
        // }

        // Readiness Vs Application
        // x-axis -> Application, y-axis -> Readiness

        // sending values into array according to Quadrant Criteria for Readiness Vs Application
        
        $quadrantCRvsCA = [];
        // CR -> x-Axis (0-100)
        if ($quadrantCountCR > 0)
          $quadrantCRvsCA[0] = ($quadrantScoreCR/$quadrantCountCR)>100 ? 100 : round($quadrantScoreCR/$quadrantCountCR,2);
        else 
          $quadrantCRvsCA[0] = $quadrantScoreCR>100 ? 100 : round($quadrantScoreCR,2);

        // CA -> y-Axis (0-200)
        if ($quadrantCountCA > 0)
          $quadrantCRvsCA[1] = ($quadrantScoreCA/$quadrantCountCA)>200 ? 200 : round($quadrantScoreCA/$quadrantCountCA,2);
        else 
          $quadrantCRvsCA[1] = $quadrantScoreCA>200 ? 200 : round($quadrantScoreCA,2);
        // ==========================

        // Quadrant IV
        if ($quadrantScoreCR > 60 && $quadrantScoreCA >= 0 && $quadrantScoreCA <= 100) {
          $quadrantCRvsCAIV[] = $quadrantCRvsCA;
        }
        // Quadrant III
        else if ($quadrantScoreCR >= 0 && $quadrantScoreCR <= 60 && $quadrantScoreCA >= 0 && $quadrantScoreCA <= 100) {
          $quadrantCRvsCAIII[] = $quadrantCRvsCA;
        }
        // Quadrant II
        else if ($quadrantScoreCR >= 0 && $quadrantScoreCR <= 60 && $quadrantScoreCA > 100) {
          $quadrantCRvsCAII[] = $quadrantCRvsCA;
        }
        // Quadrant I
        else if ($quadrantScoreCR > 60 && $quadrantScoreCA > 100) {
          $quadrantCRvsCAI[] = $quadrantCRvsCA;
        }
        // ==========================

        // setting tree map count data (Readiness Vs Application)
        // x-> Readiness
        if ($quadrantCountCR > 0)
          $xAxis = ($quadrantScoreCR/$quadrantCountCR) < 100 ? $quadrantScoreCR/$quadrantCountCR : 100;
        else 
          $xAxis = $quadrantScoreCR < 100 ? $quadrantScoreCR : 100;

        //y-> Application
        if ($quadrantCountCA > 0)
          $yAxis = ($quadrantScoreCA/$quadrantCountCA) < 200 ? $quadrantScoreCA/$quadrantCountCA : 200;
        else 
          $yAxis = $quadrantScoreCA < 200 ? $quadrantScoreCA : 200;
        
        //================================
        // $x4y => x(0-40) y(0-200)
        if ($xAxis<=40 && $yAxis<=200) {
          $x4y++;
        }
        //================================
        // $x3y1 => x(41-60) y(0-25)
        if ($xAxis>40 && $xAxis<=60 && $yAxis>=0 && $yAxis<=25) {
          $x3y1++;
        }
        // $x3y2 => x(41-60) y(25-100)
        if ($xAxis>40 && $xAxis<=60 && $yAxis>=25 && $yAxis<=100) {
          $x3y2++;
        }
        // $x3y3 => x(41-60) y(100-150)
        if ($xAxis>40 && $xAxis<=60 && $yAxis>=100 && $yAxis<=150) {
          $x3y3++;
        }
        // $x3y4 => x(41-60) y(150-200)
        if ($xAxis>40 && $xAxis<=60 && $yAxis>=150 && $yAxis<=200) {
          $x3y4++;
        }
        //================================
        // $x2y1 => x(61-80) y(0-25)
        if ($xAxis>60 && $xAxis<=80 && $yAxis>=0 && $yAxis<=25) {
          $x2y1++;
        }
        // $x2y2 => x(61-80) y(25-100)
        if ($xAxis>60 && $xAxis<=80 && $yAxis>=25 && $yAxis<=100) {
          $x2y2++;
        }
        // $x2y3 => x(61-80) y(100-150)
        if ($xAxis>60 && $xAxis<=80 && $yAxis>=100 && $yAxis<=150) {
          $x2y3++;
        }
        // $x2y4 => x(61-80) y(150-200)
        if ($xAxis>60 && $xAxis<=80 && $yAxis>=150 && $yAxis<=250) {
          $x2y4++;
        }
        //================================
        // $x1y1 => x(81-100) y(0-25)
        if ($xAxis>80 && $xAxis<=100 && $yAxis>=0 && $yAxis<=25) {
          $x1y1++;
        }
        // $x1y2 => x(81-100) y(25-100)
        if ($xAxis>80 && $xAxis<=100 && $yAxis>=25 && $yAxis<=100) {
          $x1y2++;
        }
        // $x1y3 => x(81-100) y(100-150)
        if ($xAxis>80 && $xAxis<=100 && $yAxis>=100 && $yAxis<=150) {
          $x1y3++;
        }
        // $x1y4 => x(81-100) y(150-200)
        if ($xAxis>80 && $xAxis<=100 && $yAxis>=150 && $yAxis<=200) {
          $x1y4++;
        }
        //================================
        // incrementing loop count
        $i++;
      }

      // averageValueChart Data
      $averageCR      = $averageCountCR ? (int)($averageCountCR / $i) : 0;
      $averageCA      = $averageCountCA ? (int)($averageCountCA / $i) : 0;
      $averageSP      = $averageCountSP ? (int)($averageCountSP / $i) : 0;
      $averageOvarall = $averageCountOvarall ? (int)($averageCountOvarall / $i) : 0;

      // singlePersonChart Data
      $scoredByUserIDArray = [];
      $scoredByUserIDArray[0] = $heighestUserIDCR;
      $scoredByUserIDArray[1] = $heighestUserIDCA;
      $scoredByUserIDArray[2] = $heighestUserIDSP;
      $scoredByUserIDArray[3] = $heighestUserIDOvarall;

      $scoredByUserName = [];
      $scoredByCR       = [];
      $scoredByCA       = [];
      $scoredBySP       = [];
      $scoredByOvarall  = [];

      // for ($j=0; $j<=3; $j++) {
      //   $userNameQuery = "SELECT CONCAT(gsu.User_fname,' ',gsu.User_lname) AS user_Name FROM GAME_SITE_USERS gsu WHERE gsu.User_id = $scoredByUserIDArray[$j]";
      //   $userNameData = $this->Common_Model->executeQuery($userNameQuery);
      //   // print_r($userNameData[0]->user_Name);
      //   if (empty($userNameData))
      //     $scoredByUserName[$j] = '';
      //   else
      //     $scoredByUserName[$j] = $userNameData[0]->user_Name;

      //   $returned_Value = $this->overallValue($scoredByUserIDArray[$j], $formulaData[0]->Items_Formula_Expression, $formulaData[0]->Items_Formula_Json);
      //   $returned_Value = json_decode($returned_Value);
      //   // print_r($returned_Value); 

      //   $user_Overall_Value = $returned_Value->overall_Value >= 200 ? 200 :  $returned_Value->overall_Value;

      //   $scoredByOvarall[$j] = round($user_Overall_Value, 2);

      //   foreach ($returned_Value->averageJson as $key => $value) {
      //     // setting cap for overall value at 200
      //     $value = $value >= 200 ? 200 : round($value, 2);

      //     // getting Item Name
      //     $itemWhere = array('Compt_Id' => $key,);
      //     $itemData = $this->Common_Model->fetchRecords('GAME_ITEMS', $itemWhere, 'Compt_Name, Compt_PerformanceType');
      //     // print_r($itemData); exit();

      //     // pushina data according to it's performance type
      //     switch ($itemData[0]->Compt_PerformanceType) {
      //       case 3:
      //         // 3 = Simulated Performance
      //         $scoredBySP[$j] = $value;
      //         break;

      //       case 4:
      //         // 4 = Competence Readiness
      //         $scoredByCR[$j] = $value;
      //         break;

      //       case 5:
      //         // 5 = Competence Application
      //         $scoredByCA[$j] = $value;
      //         break;
      //     }
      //   }
      //   $i++;
      // }

      die(json_encode(['x1y1' => $x1y1, 'x1y2' => $x1y2, 'x1y3' => $x1y3, 'x1y4' => $x1y4, 'x2y1' => $x2y1, 'x2y2' => $x2y2, 'x2y3' => $x2y3, 'x2y4' => $x2y4, 'x3y1' => $x3y1, 'x3y2' => $x3y2, 'x3y3' => $x3y3, 'x3y4' => $x3y4, 'x4y' => $x4y, 'quadrantCRvsSPI' => $quadrantCRvsSPI, 'quadrantCRvsSPII' => $quadrantCRvsSPII, 'quadrantCRvsSPIII' => $quadrantCRvsSPIII, 'quadrantCRvsSPIV' => $quadrantCRvsSPIV, 'quadrantCRvsCAI' => $quadrantCRvsCAI, 'quadrantCRvsCAII' => $quadrantCRvsCAII, 'quadrantCRvsCAIII' => $quadrantCRvsCAIII, 'quadrantCRvsCAIV' => $quadrantCRvsCAIV, 'overallValue' => $overallValue, 'creationDate' => $creationDate, 'heighestCR' => $heighestCR, 'heighestCA' => $heighestCA, 'heighestSP' => $heighestSP, 'heighestOvarall' => $heighestOvarall, 'averageCR' => $averageCR, 'averageCA' => $averageCA, 'averageSP' => $averageSP, 'averageOvarall' => $averageOvarall, 'scoredByUserName' => $scoredByUserName, 'scoredByCR' => $scoredByCR, 'scoredByCA' => $scoredByCA, 'scoredBySP' => $scoredBySP, 'scoredByOvarall' => $scoredByOvarall, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Report Data.']));
    }
  }

  public function dashboardCardRunChartData() {
    $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

    // fetching all game ID and Name list for loged in enterprise
    $gameQuery = "SELECT geg.EG_GameID, gg.Game_Name FROM GAME_ENTERPRISE_GAME geg LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID WHERE geg.EG_EnterpriseID = $enterprise_ID ORDER BY gg.Game_Name";
    $gameDetails = $this->Common_Model->executeQuery($gameQuery);
    //print_r($gameDetails); print_r($gameDetails[0]->Game_Name); exit();

    if (count($gameDetails) < 1 || $gameDetails == '') {
      // no game/card available for this enterprise
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No Card Assigned.']));
    }
    else {
      // making array to hold all values for chart
      $card_ID              = [];
      $card_Name            = [];
      $card_User_Total      = [];
      $card_User_Started    = [];
      $card_User_Completed  = [];
      $card_User_NotStarted = [];

      foreach ($gameDetails as $gameDetailsRow) {
        $cardID   = $gameDetailsRow->EG_GameID;
        $cardName = $gameDetailsRow->Game_Name;
        // pushing data into array
        $card_ID[]    = (int)$cardID;
        $card_Name[]  = $cardName;

        // counting total number of users have this game
        //==================================================
        $totalUserQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

        // adding the above subquery to main query
        $totalUserSql = "SELECT
                ud.User_id AS User_id,
                ud.User_fname AS User_fname,
                ud.User_lname AS User_lname,
                ud.User_email AS User_email,
                ud.US_LinkID
                FROM GAME_SITE_USER_REPORT_NEW gr
                INNER JOIN($totalUserQuery) ud
                ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
                WHERE
                gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) ORDER BY ud.US_LinkID DESC";

        $totalUser = $this->Common_Model->executeQuery($totalUserSql);
        //==================================================
        $totalUserCount = count($totalUser) ? count($totalUser) : 0;

        // counting total number of users Started this game
        //==================================================
        $totalUserStartedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

        // adding the above subquery to main query
        $totalUserStartedSql = "SELECT
                ud.User_id AS User_id,
                ud.User_fname AS User_fname,
                ud.User_lname AS User_lname,
                ud.User_email AS User_email,
                ud.US_LinkID
                FROM GAME_SITE_USER_REPORT_NEW gr
                INNER JOIN($totalUserStartedQuery) ud
                ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
                WHERE
                gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=0 ORDER BY ud.US_LinkID DESC";

        $totalUserStarted = $this->Common_Model->executeQuery($totalUserStartedSql);
        //==================================================
        $totalUserStartedCount = count($totalUserStarted) ? count($totalUserStarted) : 0;

        // counting total number of users Completed this game
        //==================================================
        $totalUserCompletedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

        // adding the above subquery to main query
        $totalUserCompletedSql = "SELECT
                ud.User_id AS User_id,
                ud.User_fname AS User_fname,
                ud.User_lname AS User_lname,
                ud.User_email AS User_email,
                ud.US_LinkID
                FROM GAME_SITE_USER_REPORT_NEW gr
                INNER JOIN($totalUserCompletedQuery) ud
                ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
                WHERE
                gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=1 ORDER BY ud.US_LinkID DESC";

        $totalUserCompleted = $this->Common_Model->executeQuery($totalUserCompletedSql);
        //==================================================
        $totalUserCompletedCount = count($totalUserCompleted) ? count($totalUserCompleted) : 0;

        // counting total number of users Not Completed this game
        $totalUserNotStartedCount = $totalUserCount - ($totalUserStartedCount + $totalUserCompletedCount);

        //print_r('Total-'.$totalUserCount.' Started-'.$totalUserStartedCount.' Completed-'.$totalUserCompletedCount.' Not Started-'.$totalUserNotStartedCount);
        //echo '<br />';
        $card_User_Total[]      = (int)$totalUserCount;
        $card_User_Started[]    = (int)$totalUserStartedCount;
        $card_User_Completed[]  = (int)$totalUserCompletedCount;
        $card_User_NotStarted[] = (int)$totalUserNotStartedCount;
      }
      //print_r($card_Name);
      //exit();

      die(json_encode(['card_ID' => $card_ID, 'card_Name' => $card_Name, 'card_User_Total' => $card_User_Total, 'card_User_Started' => $card_User_Started, 'card_User_Completed' => $card_User_Completed, 'card_User_NotStarted' => $card_User_NotStarted, "status" => "200", 'title' => 'Success', 'icon' => 'success', 'message' => 'Card Run Data.']));
    }
  }

  public function getCardUserDetailsData($cardID=NULL, $type=NULL) {
    $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

    $returnTableHtml = '<table class="stripe hover data-table-export"><thead><tr> <th>ID</th> <th>Name</th> <th>Username</th> <th>Email</th> </tr></thead><tbody>';
    // setting table data accourding to condition
    if ($type == 'totalUser') {

      // counting total number of users have this game
      //==================================================
      $totalUserQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_mobile, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

      // adding the above subquery to main query
      $totalUserSql = "SELECT
              ud.User_id AS User_id,
              CONCAT(ud.User_fname,' ',ud.User_lname) AS user_Full_Name,
              ud.User_username AS User_username,
              ud.User_mobile AS User_mobile,
              ud.User_email AS User_email,
              ud.US_LinkID
              FROM GAME_SITE_USER_REPORT_NEW gr
              INNER JOIN($totalUserQuery) ud
              ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
              WHERE
              gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) ORDER BY ud.US_LinkID DESC";

      $totalUser = $this->Common_Model->executeQuery($totalUserSql);
      //==================================================

      if (count($totalUser) < 1 || $totalUser == '') {
        $returnTableHtml = '<tr> <td>No User Available for This Card</td> </tr>';
      }
      else {
        $slNo = 0;
        foreach ($totalUser as $totalUserRow) {
          $slNo++;
          // $totalUserRow->User_mobile
          $returnTableHtml .= '<tr> <td>'.$slNo.'</td> <td>'.$totalUserRow->user_Full_Name.'</td> <td>'.$totalUserRow->User_username.'</td> <td>'.$totalUserRow->User_email.'</td> </tr>';
        }
      }
    }
    else if ($type == 'notStartes') {

    }
    else if ($type == 'started') {

      // counting total number of users Started this game
      //==================================================
      $totalUserStartedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_mobile, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

      // adding the above subquery to main query
      $totalUserStartedSql = "SELECT
              ud.User_id AS User_id,
              CONCAT(ud.User_fname,' ',ud.User_lname) AS user_Full_Name,
              ud.User_username AS User_username,
              ud.User_mobile AS User_mobile,
              ud.User_email AS User_email,
              ud.US_LinkID
              FROM GAME_SITE_USER_REPORT_NEW gr
              INNER JOIN($totalUserStartedQuery) ud
              ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
              WHERE
              gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=0 ORDER BY ud.US_LinkID DESC";

      $totalUserStarted = $this->Common_Model->executeQuery($totalUserStartedSql);
      //==================================================

      if (count($totalUserStarted) < 1 || $totalUserStarted == '') {
        $returnTableHtml = '<tr> <td>No User Started Playing This Card</td> </tr>';
      }
      else {
        $slNo = 0;
        foreach ($totalUserStarted as $totalUserRow) {
          $slNo++;
          // $totalUserRow->User_mobile
          $returnTableHtml .= '<tr> <td>'.$slNo.'</td> <td>'.$totalUserRow->user_Full_Name.'</td> <td>'.$totalUserRow->User_username.'</td> <td>'.$totalUserRow->User_email.'</td> </tr>';
        }
      }
    }
    else if ($type == 'completed') {

      // counting total number of users Completed this game
      //==================================================
      $totalUserCompletedQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_username, gsu.User_mobile, gsu.User_email, gsu.User_ParentId, gus.US_LinkID, (SELECT gl.Link_ID FROM GAME_LINKAGE gl WHERE gl.Link_GameID = gus.US_GameID AND gl.Link_ScenarioID = gus.US_ScenID) AS lastLinkId FROM GAME_SITE_USERS gsu INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$cardID WHERE gsu.User_Delete=0 AND gsu.User_ParentId=$enterprise_ID";

      // adding the above subquery to main query
      $totalUserCompletedSql = "SELECT
              ud.User_id AS User_id,
              CONCAT(ud.User_fname,' ',ud.User_lname) AS user_Full_Name,
              ud.User_username AS User_username,
              ud.User_mobile AS User_mobile,
              ud.User_email AS User_email,
              ud.US_LinkID
              FROM GAME_SITE_USER_REPORT_NEW gr
              INNER JOIN($totalUserCompletedQuery) ud
              ON ud.User_id = gr.uid AND ud.lastLinkId = gr.linkid
              WHERE
              gr.linkid IN(SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = $cardID) AND ud.US_LinkID=1 ORDER BY ud.US_LinkID DESC";

      $totalUserCompleted = $this->Common_Model->executeQuery($totalUserCompletedSql);
      //==================================================
      
      if (count($totalUserCompleted) < 1 || $totalUserCompleted == '') {
        $returnTableHtml = '<tr> <td>No User Completed for This Card</td> </tr>';
      } 
      else {
        $slNo = 0;
        foreach ($totalUserCompleted as $totalUserRow) {
          $slNo++;
          // $totalUserRow->User_mobile
          $returnTableHtml .= '<tr> <td>'.$slNo.'</td> <td>'.$totalUserRow->user_Full_Name.'</td> <td>'.$totalUserRow->User_username.'</td> <td>'.$totalUserRow->User_email.'</td> </tr>';
        }
      }
    }
    $returnTableHtml .= '</tbody></table>';

    // sending result
    die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => '', 'cardUserData' => $returnTableHtml]));
  }

  public function getCardData($game_ID=NULL) {
    $game_ID = base64_decode($game_ID);

    $query = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_ProcessOwner_Details FROM GAME_GAME gg WHERE gg.Game_ID = $game_ID";
    $gameData = $this->Common_Model->executeQuery($query);
    //print_r($this->db->last_query()); exit();
    $Game_Name = $gameData[0]->Game_Name;
    $Game_ProcessOwner_Details = $gameData[0]->Game_ProcessOwner_Details ? $gameData[0]->Game_ProcessOwner_Details : 'Description Not Available.';

    if (!empty($Game_Name)) {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => '', 'Game_Name' => $Game_Name, 'Game_ProcessOwner_Details' => $Game_ProcessOwner_Details]));
    }
    else {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 1500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Error.']));
    }
  }

  public function userReportData() {
    print_r($this->input->post());
  }
}
