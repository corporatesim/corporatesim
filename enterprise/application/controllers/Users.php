<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$this->load->model('Common_Model');
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
			redirect('Login/login');
		}
	}

//Show Enterprise Users
	public function EnterpriseUsers()
	{
		if($this->session->userdata('loginData')['User_Role']==2)
		{
			$this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>'.$this->uri->segment(2).'</b> page');
			redirect('Users/SubEnterpriseUsers');
		}
		$query = "SELECT gu.*, ge.*,(SELECT count(UG_GameID) FROM GAME_USERGAMES WHERE UG_UserID = gu.User_id) AS gameCount FROM GAME_SITE_USERS gu LEFT JOIN GAME_ENTERPRISE ge ON gu.User_ParentId = ge.Enterprise_ID ";
		if($this->session->userdata('loginData')['User_Role']!=1)
		{
			// it means user is not enterprise
			$query .= " WHERE User_Role = 1 AND User_Delete = 0";
		}
		else
		{
			$query .= " WHERE User_ParentId = ".$this->session->userdata('loginData')['User_ParentId']." AND User_Role = 1 AND User_Delete = 0";
		}
		$result = $this->Common_Model->executeQuery($query);
		$content['enterpriseusersDetails'] = $result;
		$content['subview']     = 'listEnterpriseUsers';
		$this->load->view('main_layout',$content);
	}

//show SubEnterprise Users
	public function SubEnterpriseUsers()
	{
		$where         = array();
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		$query         = "SELECT gu.*, gs.*, ge.*,(SELECT count(UG_GameID) FROM GAME_USERGAMES WHERE UG_UserID = gu.User_id) AS gameCount FROM GAME_SITE_USERS AS gu LEFT JOIN GAME_SUBENTERPRISE AS gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE AS ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_Delete = 0 AND User_Role = 2";
		if($this->session->userdata('loginData')['User_Role'] == 1)
		{
			// it means enterprise is logged in = only dependent subent users
			$User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
			$where['SubEnterprise_EnterpriseID'] = $User_ParentId;
			$query .= " AND User_ParentId=".$User_ParentId;
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('SubEnterprise_ID');
				if($filterID > 0)
				{
					$query   .= " AND User_SubParentId=".$filterID;
				}
			}
		}
		elseif($this->session->userdata('loginData')['User_Role']==2)
		{
			// it means subEnterprise is logged in = only for its users
			$query .= " AND User_ParentId=".$this->session->userdata('loginData')['User_ParentId']." AND User_SubParentId=".$this->session->userdata('loginData')['User_SubParentId'];
		}
		else
		{
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('SubEnterprise_ID');
				if($filterID > 0)
				{
					$query   .= " AND User_SubParentId=".$filterID;
				}
			}
		}
		//show dropdownlist of Subenterprise
		$where['SubEnterprise_Status'] = 0;
		$Subenterprise = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where,' ','SubEnterprise_ID');
		// echo "<pre>"; print_r($where); print_r($Subenterprise); exit();
		$content['Subenterprise'] = $Subenterprise;

		//Show Detail Lists Of SubEnterprise Users;
		$result  = $this->Common_Model->executeQuery($query); 
		// print_r($result);exit();
		if(!empty($filterID))
		{
			$filterID = $filterID;
		}
		else
		{
			$filterID = '-1';
		}
		$content['filterID']    = $filterID;
		$content['userDetails'] = $result;
		$content['subview']     = 'listSubEnterpriseUsers';
		$this->load->view('main_layout',$content);
	}
	
  //edit users of Enterprise and SubEnterprise 
	public function user($id=NULL,$redirect=NULL)
	{
		$id             = base64_decode($this->uri->segment(3));
		//edit user deatil
		$query = "SELECT * FROM GAME_SITE_USERS gs LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gs.User_ParentId WHERE User_id=$id";
		$result = $this->Common_Model->executeQuery($query);
		$content['editUser'] = $result[0];		
    //Show Subenterprize dropdown list When Enterprise Login
		if($this->session->userdata('loginData')['User_Role']==1)
		{
			$User_ParentId    = $this->session->userdata('loginData')['User_ParentId'];
			$where = array(
				'SubEnterprise_EnterpriseID' => $User_ParentId,
				'SubEnterprise_Status'       => 0,
			);
			$Subenterprise            = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where);
			$content['Subenterprise'] = $Subenterprise;
		}
    //Show Subenterprize dropdown list When Admin login
		else
		{
			$query = "SELECT gs.SubEnterprise_Name,gs.SubEnterprise_ID FROM GAME_SITE_USERS gsu LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gsu.User_ParentId LEFT JOIN game_subenterprise gs ON gs.SubEnterprise_EnterpriseID=ge.Enterprise_ID WHERE User_id=$id AND SubEnterprise_Status=0";
			$Subenterprise            = $this->Common_Model->executeQuery($query);
			$content['Subenterprise'] = $Subenterprise;
			
		}
		// echo "<pre>"; print_r($Subenterprise); exit();
		$RequestMethod  = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			$User_ParentId  = $this->input->post('EnterpriseID');
			$subenterprise  = $this->input->post('subenterprise');
			if($subenterprise)
			{
				$User_SubParentId = $this->input->post('subenterprise');
				$User_Role        = 2;
			}
			else
			{
				$User_SubParentId = -2;
				$User_Role        =  1;
			}
			$userdata = array(
				'User_fname'       => $this->input->post('User_fname'),
				'User_lname'       => $this->input->post('User_lname'),
				'User_username'    => $this->input->post('User_username'),
				'User_email'       => $this->input->post('User_email'),
				'User_mobile'      => $this->input->post('User_mobile'),
				'User_ParentId'    =>	$User_ParentId,
				'User_SubParentId' =>	$User_SubParentId,
				'User_Role'        =>	$User_Role,
				'User_csv_status'  =>	2,			
				'User_datetime'    =>	date('Y-m-d H:i:s'),
			);

			$check = array(
				'User_username' => $this->input->post('User_username'),
				'User_email'    => $this->input->post('User_email'),
				'User_mobile'   => $this->input->post('User_mobile'),
			);
      //print_r($userdata); exit();
			$UpdData = $this->Common_Model->update('GAME_SITE_USERS',$id,$userdata,$check,'User_id');
			if($UpdData == 'update')
			{
				$this->session->set_flashdata("tr_msg","Details Update Successfully" );
				redirect("Users/".$redirect,"refresh");
			}
			else
			{
				$this->session->set_flashdata("er_msg","UserName, Email or Mobile No already exist" );
				redirect("Users/user/".$this->uri->segment(3),"refresh");
			}	
		}
		$content['subview'] = 'editUser';
		$this->load->view('main_layout',$content);
	}

//insert Enterprize and SubEnterprize users 
	public function addUsers()
	{
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		$userType      = $this->input->post('userType');
	//add subent users by enterprize depending on enterprize was logeed In
		if($this->session->userdata('loginData')['User_Role']==1)
		{
			$User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
			//show dropdownlist of Subenterprise
			$where        = array(
				'SubEnterprise_EnterpriseID' => $User_ParentId,
				'SubEnterprise_Status'       => 0,
			);
			$Subenterprise            = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where);
			$content['Subenterprise'] = $Subenterprise;

			if(!empty($this->input->post('subenterprise')) && $this->input->post('userType')==1)
			{
				$User_SubParentId = $this->input->post('subenterprise');
				$User_Role      = 2;
			}
			else
			{
				$User_SubParentId  = -2;
				$User_Role      =  1;
			}
		}
	//add subent users by subenterprize depending on subenterprize logged in
		elseif($this->session->userdata('loginData')['User_Role']==2)
		{
			$User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
			$User_SubParentId = $this->session->userdata('loginData')['User_SubParentId'];
			$User_Role     = 2;
		}
	//add Ent/subEnterprize Users by admin
		else
		{
			$where['Enterprise_Status'] = 0;
			$Enterprise = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
			$content['EnterpriseName'] = $Enterprise;

			if($this->input->post('Enterprise') && $this->input->post('SubEnterprise') )
			{
				$User_Role =2;
			}
			else if($this->input->post('Enterprise'))
			{
				$User_Role =1;
			}
			else
			{
				$User_Role =0;
			}

     //For Enterprise And SubENterprise
			if($this->input->post('Enterprise'))
			{
				$User_ParentId = $this->input->post('Enterprise');
			}
			else
			{
				$User_ParentId = -1;
			}

			if($this->input->post('SubEnterprise'))
			{
				$User_SubParentId = $this->input->post('SubEnterprise');
			}
			else
			{
				$User_SubParentId = -2;
			}

		}
		if($RequestMethod == 'POST')
		{
			$userdata = array(
				'User_fname'       =>	$this->input->post('User_fname'),
				'User_lname'       =>	$this->input->post('User_lname'),
				'User_mobile'      =>	$this->input->post('User_mobile'),
				'User_email'       =>	$this->input->post('User_email'),
				'User_companyid'   =>	$this->input->post('User_companyid'),
				'User_username'    =>	$this->input->post('User_username'),
				'User_Role'        =>	$User_Role,
				'User_ParentId'    =>	$User_ParentId,
				'User_SubParentId' =>	$User_SubParentId,
				'User_csv_status'  =>	2,			
				'User_datetime'    =>	date('Y-m-d H:i:s'),
			);
			//print_r($userdata); exit();
			if(!empty($this->input->post('User_fname')) && !empty($this->input->post('User_lname')) && !empty($this->input->post('User_username')) && !empty($this->input->post('User_mobile')) && !empty($this->input->post('User_email')))
			{
				$where  = array(
					'User_email'    =>	$this->input->post('User_email'),
					'User_username' =>	$this->input->post('User_username'),
					'User_mobile'   =>	$this->input->post('User_mobile'),
				);
         //print_r($where);
				$query = $this->Common_Model->fetchRecords('GAME_SITE_USERS',$where);
        //print_r($query);exit();
				if($query)
				{
					$this->session->set_flashdata("er_msg","Email id, username or mobile number already registered" );
					redirect("Users/addUsers","refresh");
				}
				else
				{
					$result = $this->Common_Model->insert('GAME_SITE_USERS',$userdata);
					//print_r($result);exit();
					if($result)
					{
						$uid      = $result;
						$to       = $this->input->post('User_email');
						$username = $this->input->post('User_username');
						$password = $this->Common_Model->random_password();
							//print_r($password);
						$login_details = array(
							'Auth_userid'    => $uid,
							'Auth_password'  => $password,
							'Auth_username'  => $username,
							'Auth_date_time' =>	date('Y-m-d H:i:s')
						);
							//print_r($login_details);exit();
						$this->Common_Model->insert('GAME_USER_AUTHENTICATION',$login_details);		
					}
				}
				$this->session->set_flashdata("tr_msg","Details Insert Successfully" );
				if($userType==1)
				{
					redirect("Users/SubEnterpriseUsers","refresh");
				}
				else
				{
					redirect("Users/EnterpriseUsers","refresh");
				}
			}
		}
		$content['subview']     = 'addUsers';
		$this->load->view('main_layout',$content);
	}

	//select subenterprize
	public function SelectSubEnterprise()
	{
		if($this->input->post('ajax')=='SelectSubEnterprise')
		{
			$Enterprise_ID = $this->input->post('Enterprise_ID');
			$query         = "SELECT gs.* FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gs.SubEnterprise_EnterpriseID WHERE gs.SubEnterprise_EnterpriseID=$Enterprise_ID AND gs.SubEnterprise_Status=0";
			$SubEnterprise     = $this->Common_Model->executeQuery($query);
			echo json_encode($SubEnterprise);
		}
	}

	//delete Enterprise/SubEnterprise Users
	public function delete($id=NULL,$redirect=NULL)
	{
		$id    = base64_decode($this->uri->segment(3));
		$where = array(
			'User_Id'     => $id,
			'User_Delete' => 0,
		);
		$result = $this->Common_Model->fetchRecords('GAME_SITE_USERS',
			$id);
		$content['result'] = $result;
		$this->db->set('User_Delete', 1);
		$this->db->where('User_Id', $id);
		$this->db->update('GAME_SITE_USERS');
		redirect("Users/".$redirect,"refresh");
	}


//csv upload for enterprise Users
	public function EnterpriseUsersCSV()
	{
    $maxFileSize = 2097152; // Set max upload file size [2MB]
    $validext    = array ('csv'); // Allowed Extensions

    function check_ext($file)
    {
    	$ext = explode('.', $file);
    	if($ext[count($ext)-1]=='csv')
    		return true;
    }

    if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
    {

    	if($_FILES['upload_csv']['size']==0 || !check_ext($_FILES['upload_csv']['name'])) 
    	{
    		$_SESSION['err_msg'] = 'Please Upload CSV File Type!';
    	}
    	else 
    	{

    		$fileName     = $_FILES['upload_csv']['name']; 

    		$ext          = substr(strrchr($fileName, "."), 1); 

    		$array        = explode('.', $fileName);

    		$first        = str_replace(' ','_',$array [0]);

    		$filename_chh = $first.'-'.time().'.' . $ext;

    		$path         = $_SERVER['DOCUMENT_ROOT'].'/corp_simulation/enterprise/movecsv/'.$filename_chh;

    		$tmpfile      = $_FILES['upload_csv']['tmp_name'];

    		$movefile     = move_uploaded_file($tmpfile,$path);

    		if($movefile)
    		{ 
    			$file = fopen($path, "r");

    			if($_SERVER["DOCUMENT_ROOT"] == 'C:/xampp/htdocs')
    			{
        // for local server
    				$filename = $_SERVER['DOCUMENT_ROOT'].'/corp_simulation/enterprise/movecsv/'.$filename_chh;
    			}
    			else
    			{

    				$filename = $_SERVER["DOCUMENT_ROOT"].'/corp_simulation/enterprise/'.$filename_chh;
    			}

    			$Enterprise_User   = $this->session->userdata('loginData')['User_ParentId'];
    			$User_SubParentId  = -2;
    			$User_role         =  1;

    			$sql = "LOAD DATA LOCAL INFILE '".$filename."'
    			INTO TABLE GAME_SITE_USERS COLUMNS TERMINATED BY ',' IGNORE 1 LINES (User_fname,User_lname,User_username,User_mobile,User_email,User_companyid,User_Role,User_ParentId,User_SubParentId,User_datetime) SET
    			User_role = $User_role,User_ParentId = $Enterprise_User,User_SubParentId = $User_SubParentId";

    		/*	$sql = "LOAD DATA LOCAL INFILE '".$filename."'
    		INTO TABLE GAME_SITE_USERS COLUMNS TERMINATED BY ',' IGNORE 1 LINES (User_fname,User_lname,User_username,User_mobile,User_email,User_companyid)";*/

    		$query = $this->db->query($sql);
      //echo $this->db->last_query(); die;
    	}

    }

    $result = array(
    	"msg"    => "Import Successfull",
    	"status" => 0
    );
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


//csv upload for subenterprise users...
public function subenterpriseUsersCSV($subEnterprizeID=NULL)
{
		$maxFileSize = 2097152; // Set max upload file size [2MB]
    $validext    = array ('csv');  // Allowed Extensions

    function check_ext($file)
    {
    	$ext = explode('.', $file);
    	if($ext[count($ext)-1]=='csv')
    		return true;
    }

    if( isset( $_FILES['upload_csv']['name'] ) && !empty( $_FILES['upload_csv']['name'] ) )
    {

    	if($_FILES['upload_csv']['size']==0 || !check_ext($_FILES['upload_csv']['name'])) 
    	{
    		$_SESSION['err_msg'] = 'Please Upload CSV File';
    	}
    	else 
    	{

    		$fileName     = $_FILES['upload_csv']['name']; 

    		$ext          = substr(strrchr($fileName, "."), 1); 

    		$array        = explode('.', $fileName);

    		$first        = str_replace(' ','_',$array [0]);

    		$filename_chh = $first.'-'.time().'.' . $ext;

    		$path         = $_SERVER['DOCUMENT_ROOT'].'/corp_simulation/enterprise/movecsv/'.$filename_chh;

    		$tmpfile      = $_FILES['upload_csv']['tmp_name'];

    		$movefile     = move_uploaded_file($tmpfile,$path);

    		if($movefile)
    		{
    			$file = fopen($path, "r");

    			if($_SERVER["DOCUMENT_ROOT"] == 'C:/xampp/htdocs')
    			{
						// for local server
    				$filename = $_SERVER['DOCUMENT_ROOT'].'/corp_simulation/enterprise/movecsv/'.$filename_chh;
    			}
    			else
    			{
    				$filename = $_SERVER["DOCUMENT_ROOT"].'/corp_simulation/enterprise/'.$filename_chh;
    			}

    			$User_ParentId    = $this->session->userdata('loginData')['User_ParentId'];
    			$User_SubParentId = $subEnterprizeID;
    			$user_role        = 2;
    			$sql              = "LOAD DATA LOCAL INFILE '".$filename."'
    			INTO TABLE GAME_SITE_USERS COLUMNS TERMINATED BY ',' IGNORE 1 LINES (User_fname,User_lname,User_username,User_mobile,User_email,User_companyid,User_Role,User_ParentId,User_SubParentId) SET User_Role = $user_role,User_ParentId = $User_ParentId,User_SubParentId = $User_SubParentId";
    			$query = $this->db->query($sql);
					//echo $this->db->last_query(); die;
    		}

    	}

    	$result = array(
    		"msg"    => "Import Successfull",
    		"status" => 0
    	);
    }
    else
    {
    	$result = array(
    		"msg"    =>	"Please select a file to import",
    		"status" =>	0
    	);
    }

    echo json_encode($result);
  }

}