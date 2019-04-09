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

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
			redirect('Login/login');
		}
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

    if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) ){
     $explode_filename = explode(".", $_FILES['upload_csv']['name']);
     $ext              = strtolower( end($explode_filename) );
     if(in_array( $ext, $validext ) ){
      try{	
       $file   = $_FILES['upload_csv']['tmp_name'];
       $handle = fopen($file, "r");
       $flag   = true;

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
  $result = array(
    "msg"    =>	"Import successful",
    "status" =>	1
  );

} catch (Exception $e) {
 $result = array(
  "msg"    =>	"Error:",
  "status" =>	0
);
}
}

	//exit();	
} else {
 $result = array(
  "msg"    =>	"Please select a file to import",
  "status" =>	0
);
}

echo json_encode($result);
}


     //csv functionality for enterprise Users
public function EnterpriseUsersCSV($Enterpriseid=NULL)
{

		    $maxFileSize = 2097152; // Set max upload file size [2MB]
        $validext    = array ('xls', 'xlsx', 'csv');  // Allowed Extensions
        
        if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) ){
        	$explode_filename = explode(".", $_FILES['upload_csv']['name']);
	    //echo $explode_filename[0];
	    //exit();
        	$ext = strtolower( end($explode_filename) );
		//echo $ext."\n";
        	if(in_array( $ext, $validext ) ){
        		try{	
        			$file              = $_FILES['upload_csv']['tmp_name'];
        			$handle            = fopen($file, "r");
        			$not_inserted_data = array();
        			$inserted_data     = array();
        			$c                 = 0;
        			$flag              = true;

        			while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false ){
        				if($flag) { $flag = false; continue; }

        				if( !empty($filesop) )
        				{
						//convert the date format 
        					$date = $filesop[6];
        					$GameStartDate = date("Y-m-d", strtotime($date));


        					$newdate     =   $filesop[7];
        					$GameEndDate = date("Y-m-d", strtotime($newdate));
						//echo $GameEndDate;exit();

        					$User_role   = 1;
        					$entid       = $Enterpriseid;


        					$array = array(
        						"User_fname"         =>	$filesop[0],
        						"User_lname"         =>	$filesop[1],
        						"User_username"      =>	$filesop[2],
        						"User_mobile"        =>	$filesop[3],
        						"User_email"         =>	$filesop[4],
        						"User_companyid"     =>	$filesop[5],
        						"User_Role"          => $User_role,
        						"User_ParentId"      => $entid,
        						"User_GameStartDate" => $GameStartDate,
        						"User_GameEndDate"   => $GameEndDate,
        						"User_datetime"      =>	date("Y-m-d H:i:s")
        					);
        					/*print_r($array);exit();*/
        					$result = $this->Common_Model->insert("GAME_SITE_USERS", $array, 0, 0);
        					/*print_r($this->db->last_query());exit;*/
        					$c++;
        					if($result){
        						$uid = $result;
        						//echo $uid;exit();
        						$password      = $this->Common_Model->random_password(); 
        						$login_details = array(
        							'Auth_userid'    => $uid,
        							'Auth_username'  => $filesop[2],
        							'Auth_password'  => $password,
        							'Auth_date_time' =>	date('Y-m-d H:i:s')
        						);

        						$result1 = $this->Common_Model->insert('GAME_USER_AUTHENTICATION', $login_details, 0, 0);
        					}
        				}

        			}
				//echo $c;
        			if (!empty($not_inserted_data))
        			{
        				$msg = "</br>Email id not imported -> ".implode(" , ",$not_inserted_data);
        			}

        			$result = array(
        				"msg"    =>	"Import successful",
        				"status" =>	1
        			);

        		} catch (Exception $e) {
        			$result = array(
        				"msg"    =>	"Error: ".$e,
        				"status" =>	0
        			);
        		}
        	}

	//exit();	
        } else {
        	$result = array(
        		"msg"    =>	"Please select a file to import",
        		"status" =>	0
        	);
        }

        echo json_encode($result);
      }
      

      //csv upload for subenterprise...
      public function subenterprisecsv($enterpriseid=NULL)
      {

	    	$maxFileSize = 2097152; // Set max upload file size [2MB]
        $validext    = array ('xls', 'xlsx', 'csv');  // Allowed Extensions
        //$uid = $_SESSION['siteuser'];

        if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) ){
        	$explode_filename = explode(".", $_FILES['upload_csv']['name']);
	   //echo $explode_filename[0];
	   //exit();
        	$ext = strtolower( end($explode_filename) );
		//echo $ext."\n";
        	if(in_array( $ext, $validext ) ){
        		try{	
        			$file              = $_FILES['upload_csv']['tmp_name'];
        			$handle            = fopen($file, "r");

        			$flag              = true;

        			while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false ){
        				if($flag) { $flag = false; continue; }

        				if( !empty($filesop) )
        				{
						  //convert the date format 
        					$date      = $filesop[6];
        					$StartDate = date("Y-m-d", strtotime($date));


        					$newdate   = $filesop[7];
        					$EndDate   = date("Y-m-d", strtotime($newdate));
						  //echo $GameEndDate;exit();
                  $password = $filesop[5];
                  $enterprise = $enterpriseid;
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
                 /*print_r($array);exit();*/
                 $insertResult = $this->Common_Model->insert("GAME_SUBENTERPRISE", $array, 0, 0);
                 /*print_r($this->db->last_query());exit;*/

                 if($insertResult)
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
              "msg"    =>	"Import successful",
              "status" =>	1
            );

          } catch (Exception $e) {
           $result = array(
            "msg"    =>	"Error:",
            "status" =>	0
          );
         }
       }

	//exit();	
     } else {
       $result = array(
        "msg"    =>	"Please select a file to import",
        "status" =>	0
      );
     }

     echo json_encode($result);
   }

       //csv upload for subenterprise users
   public function SubEnterpriseUsersCSV($Enterpriseid=NULL,$SubEnterpriseid)
   {

            $maxFileSize = 2097152; // Set max upload file size [2MB]
        $validext    = array ('xls', 'xlsx', 'csv');  // Allowed Extensions
        
        if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) ){
          $explode_filename = explode(".", $_FILES['upload_csv']['name']);
        //echo $explode_filename[0];
        //exit();
          $ext = strtolower( end($explode_filename) );
        //echo $ext."\n";
          if(in_array( $ext, $validext ) ){
            try{    
              $file              = $_FILES['upload_csv']['tmp_name'];
              $handle            = fopen($file, "r");
              $not_inserted_data = array();
              $inserted_data     = array();
              $c                 = 0;
              $flag              = true;

              while( ( $filesop = fgetcsv( $handle, 1000, "," ) ) !== false ){
                if($flag) { $flag = false; continue; }

                if( !empty($filesop) )
                {
                        //convert the date format 
                  $date = $filesop[6];
                  $GameStartDate = date("Y-m-d", strtotime($date));


                  $newdate     =   $filesop[7];
                  $GameEndDate = date("Y-m-d", strtotime($newdate));
                        //echo $GameEndDate;exit();


                  $entid       = $Enterpriseid;
                  $subentid    = $SubEnterpriseid;
                  $user_role   = 2;


                  $array = array(
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
                    "User_datetime"      => date("Y-m-d H:i:s")
                  );
                  /*print_r($array);exit();*/
                  $result = $this->Common_Model->insert("GAME_SITE_USERS", $array, 0, 0);
                  /*print_r($this->db->last_query());exit;*/
                  $c++;
                  if($result){
                    $uid = $result;
                                //echo $uid;exit();
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
                //echo $c;
              if (!empty($not_inserted_data))
              {
                $msg = "</br>Email id not imported -> ".implode(" , ",$not_inserted_data);
              }

              $result = array(
                "msg"    => "Import successful",
                "status" => 1
              );

            } catch (Exception $e) {
              $result = array(
                "msg"    => "Error: ".$e,
                "status" => 0
              );
            }
          }

    //exit();   
        } else {
          $result = array(
            "msg"    => "Please select a file to import",
            "status" => 0
          );
        }

        echo json_encode($result);
      }

    }

