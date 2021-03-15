<?php 
include_once 'config/settings.php'; 
include_once 'config/functions.php'; 
// Create object
$funObj = new Functions();

// if session is not set then set and if set then reset
if (!empty($_GET['username']) && !empty($_GET['password'])) {
  // Setting variables
  $username = $funObj->EscapeString(trim($_GET['username']));
  $password = trim($_GET['password']);

  $sql = "SELECT u.*, CONCAT( u.User_fname, ' ', u.User_lname ) AS FullName, ge.Enterprise_Logo ,gse.SubEnterprise_Logo,gd.Domain_Name
  FROM GAME_SITE_USERS u INNER JOIN GAME_USER_AUTHENTICATION ua
  ON u.User_id = ua.Auth_userid LEFT JOIN GAME_ENTERPRISE ge ON u.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_SUBENTERPRISE gse ON u.User_SubParentId=gse.SubEnterprise_ID LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId AND gd.Domain_Status=0  AND( CASE WHEN u.User_Role = 1 THEN gd.Domain_EnterpriseId = u.User_ParentId WHEN u.User_Role = 2 THEN gd.Domain_SubEnterpriseId = u.User_SubParentId END ) WHERE (u.User_username='".$username."' OR u.User_email='".$username."')  AND ua.Auth_password='".$password."'";
  // echo $sql; exit(); User_ParentId User_SubParentId
  $object = $funObj->ExecuteQuery($sql);

  if ($object->num_rows > 0) {
    $res = $funObj->FetchObject($object);
    // echo "<pre>";  print_r($res);exit;
        
    // print_r($res->FullName); exit();

    // setting session
    $_SESSION['userid']           = (int) $res->User_id;
    $_SESSION['FullName']         = $res->FullName;
    $_SESSION['username']         = $res->User_username;
    $_SESSION['companyid']        = $res->User_companyid;
    $_SESSION['User_profile_pic'] = $res->User_profile_pic;
    $_SESSION['User_ParentId']    = $res->User_ParentId;
    $_SESSION['User_SubParentId'] = $res->User_SubParentId;

    // setting return url in session
    if (!empty($_GET['return_url'])) {
      $_SESSION['return_url'] = trim($_GET['return_url']);
    }
    
    if (empty($_SESSION['logo'])) {
      if ($res->User_Role == 1) {
        $_SESSION['logo'] = $res->Enterprise_Logo;
      }
      else if ($res->User_Role == 2) {
        $_SESSION['logo'] = $res->SubEnterprise_Logo;
      }
    }

    // Setting game url
    // ===============================================
    $uid = (int) $res->User_id;
    if (!empty($_GET['gid'])) {
      $gameid = trim($_GET['gid']);
    }

    $where = array(
      "US_GameID = " . $gameid,
      "US_UserID = " . $uid
    );

    $obj = $funObj->SelectData(array(), 'GAME_USERSTATUS', $where, 'US_CreateDate desc', '', '1', '', 0);

    $gamestrip      = "StartGameStrip";
    $whereSkipIntro = array(
      'Link_GameID = ' . $gameid,
      'Link_Introduction=1',
      // 'Link_Description'  => 1,
    );

    // checking if introduction is skipped or not
    $skipIntroObj = $funObj->SelectData(array(), 'GAME_LINKAGE', $whereSkipIntro, 'Link_Order', '', '1', '', 0);
    // echo "<pre>"; print_r($funObj->FetchObject ( $skipIntroObj )); exit();

    if ($obj->num_rows > 0 || $skipIntroObj->num_rows > 0) {
      // if there are more than 1 scen id for single users, check in future reference
      $resultSkipIntro = $funObj->FetchObject($skipIntroObj);
      $result1         = $funObj->FetchObject($obj);
      $ScenID          = $result1->US_ScenID;
      //echo $ScenID .'<br>';

      if ($result1->US_LinkID == 0) {
        if ($result1->US_ScenID == 0 && $skipIntroObj->num_rows < 1) {
          $url = site_root."game_description.php?Game=".$gameid;
        } 
        else {
          // get linkid
          // if scenario exists get last scenario
          $scenarioId = !empty($result1->US_ScenID) ? $result1->US_ScenID : $resultSkipIntro->Link_ScenarioID;
          $sqllink    = "SELECT * FROM GAME_LINKAGE WHERE Link_GameID=".$gameid." AND Link_ScenarioID=".$scenarioId;

          $link       = $funObj->ExecuteQuery($sqllink);
          $resultlink = $funObj->FetchObject($link);
          $linkid     = $resultlink->Link_ID;
          // echo $linkid;

          if ($result1->US_Input == 0 && $result1->US_Output == 0 && $resultlink->Link_Description < 1) {
            if ($link->num_rows > 0 && $resultlink->Link_Description < 1) {
              $url = site_root."scenario_description.php?Link=".$resultlink->Link_ID;
            }
          } 
          else if (($result1->US_Input == 1 && $result1->US_Output == 0) || $resultlink->Link_Description > 0) {
            // if input is true
            // goto input
            $url = site_root."input.php?ID=".$gameid;
          } 
          else {
            // else if output is true
            // goto output
            $url = site_root."output.php?ID=".$gameid;
          }
        }
      }
      else {
        // it means user has completed the game
        $url = site_root."result.php?ID=".$gameid;
      }
    }
    else {
      // It means user playing first time, check for skip introduction/description
      $url =  site_root."game_description.php?Game=".$gameid;
    }
    // ===============================================

    // successfully login
    die(json_encode(["status" => "200", 'title' => "Success", 'message' => 'Start Game.', 'dataURL' => $url]));

    // header("Location:".site_root."selectgame.php");
    // echo '<script>window.location="'.site_root.'selectgame.php";</script>';
    // echo '<script>window.location.href="'.site_root.'selectgame.php";</script>';
    exit(0);
  }
  else {
    die(json_encode(["status" => "201", 'title' => "Error", 'message' => 'Wrong username or password.']));
  }
}
