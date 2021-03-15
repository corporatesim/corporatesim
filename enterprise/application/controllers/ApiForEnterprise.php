<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiForEnterprise extends CI_Controller {

  public $tempStartData;
  public $tempEndData;
  private $Enterprise_ID;
  private $entEmail;
  private $entPassword;

  public function __construct() {
    parent::__construct();
		header('Access-Control-Allow-Origin: *');
    // echo "<pre>";
    // if($this->session->userdata('loginData') == NULL) {
    //   $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
    //   redirect('Login/login');
    // }
    $this->load->model('Api_Model');
    $this->tempStartData = date('Y-m-d H:i:s');
    $this->tempEndData = date('Y-m-d H:i:s', strtotime("+1 week"));
    // print_r($this->input->post()); die(' in constructor ');
    $this->entEmail = $this->input->post('email');
    $this->entPassword = $this->input->post('password');
    if(empty($this->entEmail) || empty($this->entPassword))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'email and password are mandatory.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
    }
    else
    {
      $fetchEntData = $this->Api_Model->executeQuery("SELECT * FROM GAME_ENTERPRISE WHERE Enterprise_Email='$this->entEmail' AND Enterprise_Password='$this->entPassword'");
      if(count($fetchEntData)>0)
      {
        $this->Enterprise_ID = $fetchEntData[0]->Enterprise_ID;
        return true;
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Invalid Email Or Password.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
    }
    }
    die(' In Constructor ');
  }

  // use this type of josn format for return

  // die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No Ent', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));

  public function index()
  {
    die(' here in index ');
  } //end of index function

  public function getGamesCatalogue()
  {
    // die('here in getGamesCatalogue ');
    if(empty($this->Enterprise_ID))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No enterprise selected. Or enterprise is not registered.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    $getGameSql = "SELECT geg.`EG_EnterpriseID`, geg.EG_Game_Start_Date, geg.EG_Game_End_Date, gg.Game_ID, gg.Game_Name, gg.Game_Comments, gg.Game_Message, gg.Game_shortDescription, gg.Game_longDescription, gg.Game_prise, gg.Game_discount, gg.Game_Image, gg.Game_Elearning, gg.Game_Category FROM `GAME_ENTERPRISE_GAME` geg LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID WHERE geg.EG_EnterpriseID = $this->Enterprise_ID";
    $fetchData = $this->Api_Model->executeQuery($getGameSql);
    if(count($fetchData)>0)
    {
      die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game catalogue fetched successfully.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => $fetchData)));
    }
    else
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There is no game. Please contact admin.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
  }

  public function playSimulation()
  {
    // die(' play simulation'); // entUsrLogin
    // $simulationId = $this->input->post('gameid');
    $useremail = $this->input->post('useremail');
    $userpassword = $this->input->post('userpassword');
    $returnUrl = ($this->input->post('returnUrl'))?$this->input->post('returnUrl'):"";
    if(empty($useremail) || empty($userpassword))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'User-Email and User-Password Are Mandatory', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
    }
    $domainSql = "SELECT Domain_Name FROM GAME_DOMAIN WHERE Domain_EnterpriseId=$this->Enterprise_ID";
    $fetchedName = $this->Api_Model->executeQuery($domainSql);
    if(count($fetchedName)>0)
    {
      $domainName = $fetchedName[0]->Domain_Name;
    }
    else
    {
      $domainName = 'https://corpsim.in';
    }
    $simulationUrl = base64_encode('returnUrl='.$returnUrl.'&email='.$useremail.'&password='.$userpassword);
    $playSimulationUrl = "$domainName?entUsrLogin=$simulationUrl";
    // print_r($this->input->post()); echo $playSimulationUrl;
    die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Redirecting to play simulation. Please wait.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => $playSimulationUrl, 'gamesCatalogue' => '')));
  }

  public function getRequestedGames()
  {
    //$this->Enterprise_ID
    // echo $this->Enterprise_ID."<br>$this->entEmail<br>$this->entPassword<br>"; print_r($this->input->post());
    $gameid = trim($this->input->post('gameid'),',');
    if(empty($gameid))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Empty game id.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
    }
    else
    {
      // $gameid = explode(',', $gameid); print_r($gameid);
      // check that this game is allocated to enterprise or not
      $engGameSql = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Comments, gg.Game_Message, gg.Game_Header, gg.Game_shortDescription, gg.Game_longDescription, gg.Game_prise, gg.Game_discount, gg.Game_Image, gg.Game_Elearning, geg.EG_Game_Start_Date, geg.EG_Game_End_Date FROM GAME_GAME gg JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID = gg.Game_ID AND geg.EG_EnterpriseID = $this->Enterprise_ID AND geg.EG_GameID IN($gameid)";
      $fetchEntGameData = $this->Api_Model->executeQuery($engGameSql);
      // print_r($fetchEntGameData);
      if(count($fetchEntGameData)>0)
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game fetched successfully.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => $fetchEntGameData)));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'You do not have the game, which you are requesting. Please contact admin.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
      }
    }
  }

  public function fetchCartGame($entId=NULL, $userId=NULL)
  {
    // echo "$entId and $userId"; print_r($_POST['gameid']);

    // also fetch here that game id which are send via post are allocated to the requested enterprise then send the game data
    if(empty($this->Enterprise_ID) || empty($userId))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No enterprise selected. Or enterprise is not registered.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }

    $gameid = $this->input->post('gameid'); // multiple game id comma seprated, find these games data
    if(empty($gameid))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There is no game in cart.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      $getGameSql = "SELECT geg.`EG_EnterpriseID`, geg.EG_Game_Start_Date, geg.EG_Game_End_Date, gg.Game_ID, gg.Game_Name, gg.Game_Comments, gg.Game_Message, gg.Game_shortDescription, gg.Game_longDescription, gg.Game_prise, gg.Game_discount, gg.Game_Image, gg.Game_Elearning, gg.Game_Category FROM `GAME_ENTERPRISE_GAME` geg LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID WHERE geg.EG_EnterpriseID = $this->Enterprise_ID AND gg.Game_ID IN($gameid)";
      $fetchData = $this->Api_Model->executeQuery($getGameSql);
      if(count($fetchData)>0)
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Your cart is ready.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => $fetchData)));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There is no game. Please contact admin.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
    }
  }

  public function fetchPurchasedGame($entId=NULL, $userId=NULL)
  {
    // echo "$entId and $userId"; print_r($_POST['gameid']);

    // also fetch here that game id which are send via post are allocated to the requested enterprise then send the game data
    if(empty($entId) || empty($userId))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'No enterprise selected. Or enterprise is not registered.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }

    $gameid = $this->input->post('gameid'); // multiple game id comma seprated, find these games data
    if(empty($gameid))
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'You have not purchased any game.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      $getGameSql = "SELECT geg.`EG_EnterpriseID`, geg.EG_Game_Start_Date, geg.EG_Game_End_Date, gg.Game_ID, gg.Game_Name, gg.Game_Comments, gg.Game_Message, gg.Game_shortDescription, gg.Game_longDescription, gg.Game_prise, gg.Game_discount, gg.Game_Image, gg.Game_Elearning, gg.Game_Category, gd.Domain_Name FROM `GAME_ENTERPRISE_GAME` geg LEFT JOIN GAME_GAME gg ON gg.Game_ID = geg.EG_GameID LEFT JOIN GAME_DOMAIN gd ON gd.Domain_EnterpriseId= geg.EG_EnterpriseID WHERE geg.EG_EnterpriseID = $entId AND gg.Game_ID IN($gameid)";
      // die($getGameSql);
      $fetchData = $this->Api_Model->executeQuery($getGameSql);
      if(count($fetchData)>0)
      {
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Play Simulation.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => $fetchData)));
      }
      else
      {
        die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'There is no game. Please contact admin.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
      }
    }
  }

  public function createUser($entId = NULL)
  {
    // print_r($this->input->post()); print_r(json_decode($this->input->post('userDataWithGame'),true)); 
    // echo '<br>'.$this->input->post('gameStartDate').'<br>';
    // echo $this->input->post('gameEndDate').'<br>';
    // echo strtotime($this->input->post('gameStartDate')).'<br>';
    // echo strtotime($this->input->post('gameEndDate')).'<br>';
    // echo strtotime('now').' and '.strtotime('+1 week');
    // die('here in createUser ');

    $postData = json_decode($this->input->post('userDataWithGame'),true);

    if(empty($this->Enterprise_ID) || count($postData)<1)
    {
      die(json_encode(array('class' => 'bg-danger', 'title' => '', 'subtitle' => 'Failed', 'icon' => 'fas fa-times-circle', 'delay' => 3000, 'type' => 'Error', 'code' => 201, 'image' => '', 'imageAlt' => '', 'message' => 'Invalid Data Provided.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '')));
    }
    else
    {
      $games = trim($this->input->post('games'),',');
      $gameStartDate = $this->input->post('gameStartDate');
      $gameEndDate = $this->input->post('gameEndDate');
      $games = explode(',', $games);
      // check user existency, and cteate/update record $postData['user_Email'] $postData['user_UserName'] $postData['user_Phone'] $postData['user_Password']
      $fetchData = $this->Api_Model->executeQuery("SELECT * FROM GAME_SITE_USERS WHERE (User_email='".$postData['user_Email']."' OR User_username='".$postData['user_UserName']."') AND User_ParentId=$this->Enterprise_ID");
      // print_r($fetchData);
      if(count($fetchData) > 0)
      {
        // print_r($fetchData[0]->User_id);
        // Record already exist, so only allocate/de-allocate game to this user
        $this->allocateGameToUser($fetchData[0]->User_id, $games, $this->Enterprise_ID, $postData['user_AccountDurationStart'], $postData['user_AccountDurationEnd']);
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game allocated.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
      }
      else
      {
        // creating user
        $insertArray = array(
          'User_fname' => $postData['user_Fname'],
          'User_lname' => $postData['user_Lname'],
          'User_email' => $postData['user_Email'],
          'User_mobile' => $postData['user_Phone'],
          'user_UserName' => $postData['user_UserName'],
          'User_Role' => 1,
          // 'User_profile_pic' => $postData['user_Pic'],
          // 'User_GameStartDate' => $postData['user_AccountDurationStart'],
          'User_GameStartDate' => $this->tempStartData,
          // 'User_GameEndDate' => $postData['user_AccountDurationEnd'],
          'User_GameEndDate' => $this->tempEndData,
          'User_ParentId' => $this->Enterprise_ID,
        );
        $insertUser = $this->Api_Model->insert('GAME_SITE_USERS', $insertArray);
        if($insertUser)
        {
          $passInsertArray = array(
            'Auth_userid' => $insertUser,
            'Auth_username' => $postData['user_UserName'],
            'Auth_password' => $postData['user_Password'],
          );
          $insertPassword = $this->Api_Model->insert('GAME_USER_AUTHENTICATION', $passInsertArray);
        }
        // allocating games
        $this->allocateGameToUser($insertUser, $games, $this->Enterprise_ID, $gameStartDate, $gameEndDate);
        die(json_encode(array('class' => 'bg-success', 'title' => '', 'subtitle' => 'Success', 'icon' => 'fas fa-check-circle', 'delay' => 3000, 'type' => 'Success', 'code' => 200, 'image' => '', 'imageAlt' => '', 'message' => 'Game allocated.', 'devMsg' => 'No msg', 'data' => '', 'redirect' => '', 'gamesCatalogue' => '')));
      }
    }
  }

  private function allocateGameToUser($userId=NULL, $gameIdArray=NULL, $UG_ParentId=NULL, $UG_GameStartDate=NULL, $UG_GameEndDate=NULL)
  {
    for($i=0; $i<count($gameIdArray); $i++)
    {
      $gameInsertArray = array(
        'UG_UserID' => $userId,
        'UG_GameID' => $gameIdArray[$i],
        'UG_ParentId' => $UG_ParentId,
        'UG_SubParentId' => -2,
        // 'UG_GameStartDate' => $UG_GameStartDate,
        // 'UG_GameEndDate' => $UG_GameEndDate,
        'UG_GameStartDate' => $this->tempStartData,
        'UG_GameEndDate' => $this->tempEndData,
      );
      $fetchData = $this->Api_Model->insert('GAME_USERGAMES', $gameInsertArray);
    }
  }

  public function allocateGamesToUser($userId=NULL, $gameid=NULL)
  {
    die('allocate games to user ');
  }

  public function getUserId()
  {
    die('herer in getUserId ');
  }
  
  public function startPlay()
  {
    die('herer in startPlay ');
  }

}