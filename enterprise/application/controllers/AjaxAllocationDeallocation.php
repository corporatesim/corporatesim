<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxAllocationDeallocation extends MY_Controller 
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
  private $loginDataLocal;
  public function __construct()
  {
    parent::__construct();
    $this->loginDataLocal = $this->session->userdata('loginData');
    if($this->session->userdata('loginData') == NULL)
    {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function fetchAssignedGames($gameFor=NULL,$id=NULL)
  {
    if($gameFor == 'enterpriseUsers')
    {
      $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_ENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.EG_GameID WHERE gg.Game_Delete=0 AND ge.EG_EnterpriseID=".$id." ORDER BY gg.Game_Name";
    }
    if($gameFor == 'subEnterpriseUsers')
    {
      $gameQuery = "SELECT gg.Game_ID, gg.Game_Name FROM GAME_SUBENTERPRISE_GAME ge LEFT JOIN GAME_GAME gg ON gg.Game_ID=ge.SG_GameID WHERE Game_Delete=0 AND ge.SG_SubEnterpriseID=".$id." ORDER BY gg.Game_Name";
    }
    $gameData = $this->Common_Model->executeQuery($gameQuery);
    if(count($gameData)>0)
    {
      echo json_encode($gameData);
    }
    else
    {
      echo 'No game found';
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
    $userDataQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_ParentId, gus.US_LinkID FROM GAME_SITE_USERS gsu
    INNER JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id AND gus.US_GameID=$gameId WHERE gsu.User_Delete=0";
    // adding filters here
    if($filterValue == 'superadminUsers')
    {
      $userDataQuery .= " AND gsu.User_MasterParentId=21 AND gsu.User_ParentId=-1 AND gsu.User_SubParentId=-2 ";
    }

    if($filterValue == 'enterpriseUsers')
    {
      $userDataQuery .= " AND gsu.User_ParentId=".$enterpriseId;
    }

    if($filterValue == 'subEnterpriseUsers')
    {
      $userDataQuery .= " AND gsu.User_ParentId=".$enterpriseId." AND gsu.User_SubParentId=".$subEnterpriseId;
    }

    if(isset($searchFilter) && !empty($searchFilter))
    {
      $userDataQuery .= " AND (gsu.User_email LIKE '%".$searchFilter."%' OR gsu.User_username LIKE '%".$searchFilter."%') ";
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
    ud.User_id = gr.uid
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

  public function getSubEnterpriseWithGame($SubEnterprise_EnterpriseID=NULL,$gameId=NULL,$allocateTo=NULL)
  {
    // check that this enterprise has the game or not
    $enterpriseId = $SubEnterprise_EnterpriseID;
    $gameWhere    = array(
      'EG_EnterpriseID' => $enterpriseId,
      'EG_GameID'       => $gameId,
    );
    $checkGame = $this->Common_Model->findCount('GAME_ENTERPRISE_GAME',$gameWhere);
    if($checkGame > 0)
    {
      if($allocateTo == 'subEnterprise')
      {
        $subEntSql = "SELECT gs.SubEnterprise_ID, gs.SubEnterprise_Name, gs.SubEnterprise_Email, UNIX_TIMESTAMP(gs.SubEnterprise_StartDate) AS SubEnterprise_StartDate, UNIX_TIMESTAMP(gs.SubEnterprise_EndDate) AS SubEnterprise_EndDate, gsg.SG_GameID, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date) AS SG_Game_Start_Date, UNIX_TIMESTAMP(gsg.SG_Game_End_Date) AS SG_Game_End_Date FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID=gs.SubEnterprise_ID AND gsg.SG_GameID=".$gameId." WHERE gs.SubEnterprise_Status=0 AND gs.SubEnterprise_EnterpriseID=".$enterpriseId;
        // die($subEntSql);
        $resultSubEnterprise = $this->Common_Model->executeQuery($subEntSql);
        echo json_encode($resultSubEnterprise);
      }

      if($allocateTo == 'entErpriseUsers')
      {
        $entUserSql = "SELECT gsu.User_id, CONCAT(gsu.User_fname,' ',gsu.User_lname) AS userName , gsu.User_GameStartDate, UNIX_TIMESTAMP(gsu.User_GameStartDate) AS UserStartDate, UNIX_TIMESTAMP(gsu.User_GameEndDate) AS UserEndDate, gug.UG_GameID, UNIX_TIMESTAMP(gug.UG_GameStartDate) AS UG_GameStartDate, UNIX_TIMESTAMP(gug.UG_GameEndDate) AS UG_GameEndDate, gug.UG_ReplayCount, gsu.User_email FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID=gsu.User_id AND gug.UG_GameID=".$gameId." AND gug.UG_ParentId=".$enterpriseId." WHERE gsu.User_ParentId=".$enterpriseId." AND gsu.User_Role=1 AND gsu.User_GameEndDate>=DATE(NOW()) AND gsu.User_Delete=0";
        // die($entUserSql);
        $resultentUsers = $this->Common_Model->executeQuery($entUserSql);
        echo json_encode($resultentUsers);
      }
      // not using this condition, for this we have written spetrate function getSubEnterpriseUsers()
      if($allocateTo == 'subEnterpriseUsers')
      {
        $subEntSql = "SELECT gs.SubEnterprise_ID, gs.SubEnterprise_Name, gs.SubEnterprise_Email, UNIX_TIMESTAMP(gs.SubEnterprise_StartDate) AS SubEnterprise_StartDate, UNIX_TIMESTAMP(gs.SubEnterprise_EndDate) AS SubEnterprise_EndDate, gsg.SG_GameID, UNIX_TIMESTAMP(gsg.SG_Game_Start_Date) AS SG_Game_Start_Date, UNIX_TIMESTAMP(gsg.SG_Game_End_Date) AS SG_Game_End_Date FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_SUBENTERPRISE_GAME gsg ON gsg.SG_SubEnterpriseID=gs.SubEnterprise_ID AND gsg.SG_GameID=".$gameId." WHERE gs.SubEnterprise_Status=0 AND gs.SubEnterprise_EnterpriseID=".$enterpriseId;
        // die($subEntSql);
        $resultSubEnterprise = $this->Common_Model->executeQuery($subEntSql);
        echo json_encode($resultSubEnterprise);
      }
      
    }
    else
    {
      echo 'no game';
    }
  }

  public function getSubEnterpriseUsers($SubEnterprise_ID=NULL,$gameId=NULL,$allocateTo=NULL)
  {
    $whereGame = array(
      'SG_SubEnterpriseID' => $SubEnterprise_ID,
      'SG_GameID'          => $gameId,
    );
    $gameCheck = $this->Common_Model->findCount('GAME_SUBENTERPRISE_GAME',$whereGame);
    if($gameCheck > 0)
    {
      $subEntUserSql = "SELECT gsu.User_id, CONCAT( gsu.User_fname, ' ', gsu.User_lname ) AS userName, gsu.User_GameStartDate, gsu.User_GameEndDate, UNIX_TIMESTAMP(gsu.User_GameStartDate) AS UserStartDate, UNIX_TIMESTAMP(gsu.User_GameEndDate) AS UserEndDate, gug.UG_GameID, UNIX_TIMESTAMP(gug.UG_GameStartDate) AS UG_GameStartDate, UNIX_TIMESTAMP(gug.UG_GameEndDate) AS UG_GameEndDate, gug.UG_ReplayCount, gsu.User_email FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USERGAMES gug ON gug.UG_UserID = gsu.User_id AND gug.UG_GameID =".$gameId." AND gug.UG_SubParentId = 4 WHERE gsu.User_Role = 2 AND gsu.User_GameEndDate >= DATE(NOW()) AND gsu.User_SubParentId =".$SubEnterprise_ID." AND gsu.User_Delete = 0";
      // die($subEntUserSql);
      $resultSubEnterpriseUsers = $this->Common_Model->executeQuery($subEntUserSql);
      echo json_encode($resultSubEnterpriseUsers);
    }
    else
    {
      echo 'no game';
    }
  }

  public function get_dateRange($id=NULL)
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

}

