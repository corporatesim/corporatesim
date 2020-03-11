<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

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
//
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
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
		$query = "SELECT gu.*, gua.Auth_password AS password, ge.*,(SELECT count(UG_GameID) FROM GAME_USERGAMES WHERE UG_UserID = gu.User_id) AS gameCount FROM GAME_SITE_USERS gu LEFT JOIN GAME_ENTERPRISE ge ON gu.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_USER_AUTHENTICATION gua ON gua.Auth_userid = gu.User_id";
		if($this->session->userdata('loginData')['User_Role']!=1)
		{
			// it means user is not enterprise
			//$query .= " WHERE User_Role = 1 AND User_Delete = 0";
			$query .= " WHERE User_Role = 1 AND User_Delete = 0 ORDER BY User_datetime DESC";
		}
		else
		{
			$query .= " WHERE User_ParentId = ".$this->session->userdata('loginData')['User_ParentId']." AND User_Role = 1 AND User_Delete = 0";
		}
		$result                            = $this->Common_Model->executeQuery($query);
		$content['enterpriseusersDetails'] = $result;
		$content['subview']                = 'listEnterpriseUsers';
		$this->load->view('main_layout',$content);
	}

//show SubEnterprise Users
	public function SubEnterpriseUsers()
	{
		$where         = array();
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		$query         = "SELECT gu.*, gua.Auth_password AS password, gs.*, ge.*,(SELECT count(UG_GameID) FROM GAME_USERGAMES WHERE UG_UserID = gu.User_id) AS gameCount, ge.Enterprise_Name FROM GAME_SITE_USERS AS gu LEFT JOIN GAME_SUBENTERPRISE AS gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE AS ge ON gu.User_ParentId = ge.Enterprise_ID LEFT JOIN GAME_USER_AUTHENTICATION gua ON gua.Auth_userid = gu.User_id WHERE User_Delete = 0 AND User_Role = 2 ";
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
		$query .= " ORDER BY User_datetime DESC ";
		//show dropdownlist of Subenterprise
		$where['SubEnterprise_Status'] = 0;
		$Subenterprise                 = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where,' ','SubEnterprise_ID');
		// echo "<pre>"; print_r($where); print_r($Subenterprise); exit();
		$content['Subenterprise']      = $Subenterprise;
		//Show Detail Lists Of SubEnterprise Users;
		$result                        = $this->Common_Model->executeQuery($query); 
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
		$id = base64_decode($this->uri->segment(3));
		//edit user deatil
		$query = "SELECT * FROM GAME_SITE_USERS gs LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gs.User_ParentId WHERE User_id=$id";
		$result              = $this->Common_Model->executeQuery($query);
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
			$query = "SELECT gs.SubEnterprise_Name,gs.SubEnterprise_ID FROM GAME_SITE_USERS gsu LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID=gsu.User_ParentId LEFT JOIN GAME_SUBENTERPRISE gs ON gs.SubEnterprise_EnterpriseID=ge.Enterprise_ID WHERE User_id=$id AND SubEnterprise_Status=0";
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

			$this->form_validation->set_rules('User_fname', 'First Name', 'trim|required|alpha_numeric_spaces'); 
			$this->form_validation->set_rules('User_lname', 'Last Name', 'trim|required|alpha_numeric_spaces');
			//validate mobile with itself
			$value = $this->db->query("SELECT User_mobile FROM GAME_SITE_USERS WHERE User_id = ".$id)->row()->User_mobile;
			if($this->input->post('User_mobile' != $value))
			{
				$unique ='|[GAME_SITE_USERS.User_mobile]';
			}
			else
			{
				$unique = '';
			}
			$this->form_validation->set_rules('User_mobile', 'Mobile', 'trim|required|numeric|exact_length[10]'.$unique);
				//validate email with itself
			$value = $this->db->query("SELECT User_email FROM GAME_SITE_USERS WHERE User_id = ".$id)->row()->User_email;
			if($this->input->post('User_email' != $value))
			{
				$unique ='|[GAME_SITE_USERS.User_email]';
			}
			else
			{
				$unique = '';
			}

			$this->form_validation->set_rules('User_email', 'Email', 'trim|required|valid_email'.$unique);
				//validate username with itself
			$value = $this->db->query("SELECT User_username FROM GAME_SITE_USERS WHERE User_id = ".$id)->row()->User_username;
			if($this->input->post('User_username' != $value))
			{
				$unique ='|[GAME_SITE_USERS.User_username]';
			}
			else
			{
				$unique = '';
			}
			$this->form_validation->set_rules('User_username', 'Username', 'trim|required|alpha_numeric_spaces'.$unique);
			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
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
  	prepareview:
     $hasValidationErrors = '';
		if($hasValidationErrors)
		{
			$content['hasValidationErrors'] = true;
		}
		else
		{
			$content['hasValidationErrors'] = false;                
		}

		$content['subview'] = 'editUser';
		$this->load->view('main_layout',$content);
	}

//insert Enterprize and SubEnterprize users 
	public function addUsers($typeUser=NULL)
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
				$User_Role        = 2;
			}
			else
			{
				$User_SubParentId = -2;
				$User_Role        =  1;
			}
		}
		//add subent users by subenterprize depending on subenterprize logged in
		elseif($this->session->userdata('loginData')['User_Role']==2)
		{
			$User_ParentId    = $this->session->userdata('loginData')['User_ParentId'];
			$User_SubParentId = $this->session->userdata('loginData')['User_SubParentId'];
			$User_Role        = 2;
		}
		//add Ent/subEnterprize Users by admin
		else
		{
			$where['Enterprise_Status'] = 0;
			$Enterprise                 = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
			$content['EnterpriseName']  = $Enterprise;

			if($this->input->post('Enterprise') && $this->input->post('subenterprise') )
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

			if($this->input->post('subenterprise'))
			{
				$User_SubParentId = $this->input->post('subenterprise');
			}
			else
			{
				$User_SubParentId = -2;
			}

		}
		if($RequestMethod == 'POST')
		{ 
			$this->form_validation->set_rules('Enterprise', 'Enterprise', 'required');
			if($typeUser == 'subentuser')
			{
				$this->form_validation->set_rules('subenterprise', 'SubEnterprise', 'required');
			}
			$this->form_validation->set_rules('User_fname', 'First Name', 'trim|required|alpha_numeric_spaces'); 
			$this->form_validation->set_rules('User_lname', 'Last Name', 'trim|required|alpha_numeric_spaces');
			$this->form_validation->set_rules('User_mobile', 'Mobile', 'trim|required|numeric|exact_length[10]|is_unique[GAME_SITE_USERS.User_mobile]');

			$this->form_validation->set_rules('User_email', 'Email', 'trim|required|valid_email|is_unique[GAME_SITE_USERS.User_email]');
			$this->form_validation->set_rules('User_username', 'Username', 'trim|required|alpha_numeric_spaces|is_unique[GAME_SITE_USERS.User_username]');
			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
			}

			$userdata = array(
				'User_fname'         =>	$this->input->post('User_fname'),
				'User_lname'         =>	$this->input->post('User_lname'),
				'User_mobile'        =>	$this->input->post('User_mobile'),
				'User_email'         =>	$this->input->post('User_email'),
				'User_companyid'     =>	$this->input->post('User_companyid'),
				'User_username'      =>	$this->input->post('User_username'),
				'User_Role'          =>	$User_Role,
				'User_ParentId'      =>	$User_ParentId,
				'User_SubParentId'   =>	$User_SubParentId,
				'User_csv_status'    =>	2,			
				'User_GameStartDate' =>	date('Y-m-d H:i:s'),			
				'User_GameEndDate'   =>	date('Y-m-d H:i:s', strtotime('+5 years')),			
				'User_datetime'      =>	date('Y-m-d H:i:s'),
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
						if($result)
						{

						$domain = "https://live.corporatesim.com";

						$message  = "Thanks for your enrolling!\r\n\r\n";
						$message .= 	"Your login and password for accessing our Simulation Games/eLearning programs/Assessments are provided below.\r\n\r\n";
						$message .= "You will have to login at :$domain\r\n\r\n";
						$message .= "Login :$username\r\n";
						$message .= "Password :$password\r\n\r\n";
						$message .= "Regards,\r\n Admin";

						$config['charset'] = 'utf-8';
						$config['mailtype'] = 'text';
						$config['newline'] = '\r\n';


						$this->email->initialize($config);
						$this->email->to($to);
						$this->email->from('support@corporatesim.com','corporatesim','support@corporatesim.com');
						$this->email->subject("Here is your email and password");
						$this->email->message($message);

						$this->email->send();
						}	
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

		prepareview:
     $hasValidationErrors = '';
		if($hasValidationErrors)
		{
			$content['hasValidationErrors'] = true;
		}
		else
		{
			$content['hasValidationErrors'] = false;                
		}

		$content['subview']  = 'addUsers';
		$content['typeUser'] = $typeUser;
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
}
