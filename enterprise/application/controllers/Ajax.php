<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

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
     $this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
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
  $userDataQuery   = " SELECT gsu.User_id, gsu.User_fname, gsu.User_lname, gsu.User_email, gsu.User_Delete, gsu.User_ParentId, gus.US_LinkID FROM GAME_SITE_USERS gsu
  LEFT JOIN GAME_USERSTATUS gus ON gus.US_UserID = gsu.User_id WHERE gsu.User_Delete=0";
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
  ud.User_Delete = 0 AND gr.linkid IN(
  SELECT
  Link_ID
  FROM
  GAME_LINKAGE
  WHERE
  Link_GameID = $gameId
)
GROUP BY
ud.User_id  
ORDER BY `ud`.`US_LinkID` DESC";

$agentsResult = $this->Common_Model->executeQuery($agentsSql);
// die($agentsSql);
echo json_encode($agentsResult);
}

public function get_states($Country_Id=NULL)
{
  if(!empty($Country_Id))
  {
    $whereState  = array(
      'State_Status'    => 0,
      'State_CountryId' => $Country_Id,
    );
    $resultState = $this->Common_Model->fetchRecords('GAME_STATE',$whereState);
    if(count($resultState) > 0)
    {
      echo json_encode($resultState);
    }
    else
    {
      echo 'nos';
    }
  }
  else
  {
    echo 'no';
  }
}

public function get_subenterprise($SubEnterprise_EnterpriseID=NULL)
{
  $whereState  = array(
   'SubEnterprise_Status'       => 0,
   'SubEnterprise_EnterpriseID' => $SubEnterprise_EnterpriseID,
 );
  $resultSubEnterprise = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$whereState);
  echo json_encode($resultSubEnterprise);
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

//csv upload for enterprise...
public function enterprisecsv()
{
  if(strpos(base_url(),'localhost') !== FALSE)
  {
    $sendEmail = FALSE;
  }
  else
  {
    $sendEmail = TRUE;
  }

  $maxFileSize = 2097152; 
  // Set max upload file size [2MB]
  $validext    = array ('xls', 'xlsx', 'csv');  

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $not_inserted_data = array();
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag)
          {
            $flag = false; continue; 
          }

          if( !empty($filesop) )
          {
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
            $object  = $this->Common_Model->findCount('GAME_ENTERPRISE',$where,0,0,0);
            //print_r($object);exit;
            //print_r($this->db->last_query()); exit();
            if($object > 0)
            {
              array_push($not_inserted_data,$filesop[2]);
              //echo "abcd";exit;
              //$result  = "email and mobile already registered";
            }
            else
            {
              if($password != '')
              {
                $password = $filesop[5];
              }
              else
              {
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
              if($insertResult && $sendEmail)
              {
                // send mail only if in live server, not in local
                $EnterpriseName = $filesop[0];
                $password1      = $password;
                $to             = $filesop[2];
                $from           = "support@corporatesim.com";
                $subject        = "New Account created..";
                $message        = "Dear User Your Account has been created";
                $message       .= "<p>Enterprise Name : ".$EnterpriseName;
                $message       .= "<p>Email : ".$filesop[2];
                $message       .= "<p>Password : ".$password1;
                $header         = "From:" . $from . "\r\n";
                $header        .= "MIME-Version: 1.0\r\n";
                $header        .= "Content-type: text/html; charset: utf8\r\n";
                mail($to,$from,$subject,$message,$header);
              }
            }
          }
        }
        if (!empty($not_inserted_data))
        {
          $msg = "</br>Email id not imported -> ".implode(" , ",$not_inserted_data);
        }

        $result = array(
          "msg"    => "Import successfull",
          "status" => 1
        );

      }
      catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error:",
          "status" => 0
        );
      }
    }
  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}


//csv functionality for enterprise Users
public function EnterpriseUsersCSV($Enterpriseid=NULL)
{
  // Set max upload file size [2MB]
  $maxFileSize    = 2097152;
  $User_UploadCsv = time();
  // Allowed Extensions
  $validext       = array ('xls', 'xlsx', 'csv');

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    //echo $explode_filename[0];
    //exit();
    $ext = strtolower( end($explode_filename) );
    //echo $ext."\n";
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $not_inserted_data = array();
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;
        $duplicate         = array();

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag)
          {
            $flag = false;
            continue;
          }

          if( !empty($filesop) )
          {
            //convert the date format 
            $date          = $filesop[6];
            $GameStartDate = date("Y-m-d", strtotime($date));
            $newdate       = $filesop[7];
            $GameEndDate   = date("Y-m-d", strtotime($newdate));
            $email         = $filesop[4];
            $mobile        = $filesop[3];
            $where         = array(
              "User_mobile" => $mobile,
              "User_email"  => $email
            );

            $object = $this->Common_Model->findCount('GAME_SITE_USERS',$where);
            if($object > 0)
            {
              // echo "details already registered";
              $duplicate[] = $email;
              continue;
              // exit();
            }

            $User_role = 1;
            if($Enterpriseid == 0)
            {
              $entid = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $entid = $Enterpriseid;
            }
            $insertArray = array(
              "User_fname"         => $filesop[0],
              "User_lname"         => $filesop[1],
              "User_username"      => $filesop[2],
              "User_mobile"        => $filesop[3],
              "User_email"         => $filesop[4],
              "User_companyid"     => $filesop[5],
              "User_Role"          => $User_role,
              "User_ParentId"      => $entid,
              "User_GameStartDate" => $GameStartDate,
              "User_GameEndDate"   => $GameEndDate,
              "User_datetime"      => date("Y-m-d H:i:s"),
              'User_UploadCsv'     => $User_UploadCsv,
            );
            // print_r($filesop); echo $GameStartDate. ' and '.$GameEndDate; print_r($insertArray);exit();
            $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
            // print_r($this->db->last_query());exit;
            $c++;
            if($result)
            {
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

        if(count($duplicate) > 0)
        {
          $shoMsg = $c." Record Import successful and the below email id's are duplicate so not inserted:-<br>".implode('<br>',$duplicate);
        }
        else
        {
          $shoMsg = $c." Record Import successful";
        }

        $result = array(
          "msg"    => $shoMsg,
          "status" => 1
        );
      }
      catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error: ".$e,
          "status" => 0
        );
      }
    }
  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}

//csv upload for subenterprise...
public function subenterprisecsv($enterpriseid=NULL)
{
  if(strpos(base_url(),'localhost') !== FALSE)
  {
    $sendEmail = FALSE;
  }
  else
  {
    $sendEmail = TRUE;
  }

  // Set max upload file size [2MB]
  $maxFileSize = 2097152;
  // Allowed Extensions
  $validext    = array ('xls', 'xlsx', 'csv'); 

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      { 
        $file   = $_FILES['upload_csv']['tmp_name'];
        $handle = fopen($file, "r");
        $flag   = true;
        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag) { $flag = false; continue; }
          if( !empty($filesop) )
          {
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
            $object = $this->Common_Model->findCount('GAME_SUBENTERPRISE',$where);
            if($object > 0)
            {
              echo "details already registered";
              exit;
            }

            if($enterpriseid == 0)
            {
              $enterprise = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $enterprise = $enterpriseid;
            }

            $password = $filesop[5];
            if($password != '')
            {
              $password = $filesop[5];
            }
            else
            {
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
            if($insertResult && $sendEmail)
            {
              $SubEnterpriseName = $filesop[0];
              $password1         = $password;
              $to                = $filesop[2];
              $from              = "support@corporatesim.com";
              $subject           = "New Account created..";
              $message           = "Dear User Your Account has been created";
              $message          .= "<p>Enterprise Name : ".$SubEnterpriseName;
              $message          .= "<p>Email : ".$filesop[2];
              $message          .= "<p>Password : ".$password1;
              $header            = "From:" . $from . "\r\n";
              $header           .= "MIME-Version: 1.0\r\n";
              $header           .= "Content-type: text/html; charset: utf8\r\n";
              mail($to,$from,$subject,$message,$header);
            }
          }

        }
        $result = array(
          "msg"    => "Import successful",
          "status" => 1
        );

      } catch (Exception $e)
      {
        $result = array(
          "msg"    => "Error:",
          "status" => 0
        );
      }
    }

  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }
  echo json_encode($result);
}

//csv upload for subenterprise users
public function SubEnterpriseUsersCSV($Enterpriseid=NULL,$SubEnterpriseid)
{
  // Set max upload file size [2MB]
  $maxFileSize    = 2097152;
  $User_UploadCsv = time();
  // Allowed Extensions
  $validext       = array ('xls', 'xlsx', 'csv'); 

  if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
  {
    $explode_filename = explode(".", $_FILES['upload_csv']['name']);
    $ext              = strtolower( end($explode_filename) );
    if(in_array( $ext, $validext ) )
    {
      try
      {
        $file              = $_FILES['upload_csv']['tmp_name'];
        $handle            = fopen($file, "r");
        $inserted_data     = array();
        $c                 = 0;
        $flag              = true;
        $duplicate         = array();

        while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false )
        {
          if($flag) { $flag = false; continue; }

          if( !empty($filesop) )
          {
            //convert the date format 
            $date          = $filesop[6];
            $GameStartDate = date("Y-m-d", strtotime($date));
            $newdate       = $filesop[7];
            $GameEndDate   = date("Y-m-d", strtotime($newdate));
            $mobile        = $filesop[3];
            $email         = $filesop[4];
            $where         = array(
              "User_mobile" => $mobile,
              "User_email"  => $email
            );

            $object = $this->Common_Model->findCount('GAME_SITE_USERS',$where);
            if($object > 0)
            {
              // echo "details already registered";
              $duplicate[] = $email;
              continue;
              // exit;
            }
            //enterpriseid for admin and enterprise login
            if($Enterpriseid == 0)
            {
              $entid = $this->session->userdata('loginData')['User_ParentId'];
            }
            else
            {
              $entid = $Enterpriseid;
            }

            if($SubEnterpriseid == 0)
            {
              $subentid = $this->session->userdata('loginData')['User_SubParentId'];
            }
            else
            {
              $subentid = $SubEnterpriseid;
            }
            $user_role = 2;

            $insertArray = array(
              "User_fname"         => $filesop[0],
              "User_lname"         => $filesop[1],
              "User_username"      => $filesop[2],
              "User_mobile"        => $filesop[3],
              "User_email"         => $filesop[4],
              "User_companyid"     => $filesop[5],
              "User_Role"          => $user_role,
              "User_ParentId"      => $entid,
              "User_SubParentId"   => $subentid,
              "User_GameStartDate" => $GameStartDate,
              "User_GameEndDate"   => $GameEndDate,
              "User_datetime"      => date("Y-m-d H:i:s"),
              'User_UploadCsv'     => $User_UploadCsv,
            );
            $result = $this->Common_Model->insert("GAME_SITE_USERS", $insertArray, 0, 0);
            $c++;
            if($result)
            {
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
        if(count($duplicate) > 0)
        {
          $shoMsg = $c." Record Import successful and the below email id's are duplicate so not inserted:-<br>".implode('<br>',$duplicate);
        }
        else
        {
          $shoMsg = $c." Record Import successful";
        }

        $result = array(
          "msg"    => $shoMsg,
          "status" => 1
        );

      } catch (Exception $e) {
        $result = array(
          "msg"    => "Error: ".$e,
          "status" => 0
        );
      }
    }

  }
  else
  {
    $result = array(
      "msg"    => "Please select a file to import",
      "status" => 0
    );
  }

  echo json_encode($result);
}

public function getDomainName($Domain_Name=NULL)
{
  $Domain_Name = $Domain_Name;
  $where       = array(
    'Domain_Status' => 0,
    'Domain_Name'   => trim("http://".$Domain_Name.".corporatesim.com"),
  );
  $resultDomain_Name = $this->Common_Model->findCount('GAME_DOMAIN',$where);
  if($resultDomain_Name > 0)
  {
    // for duplicate
    echo 'no';
  }
  else
  {
    echo 'success';
  }
}

}

