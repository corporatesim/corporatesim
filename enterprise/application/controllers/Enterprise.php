<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enterprise extends MY_Controller {

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
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
	}

//Show Enterprise 
	public function index()
	{ 
		if($this->session->userdata('loginData')['User_Role']==1 || $this->session->userdata('loginData')['User_Role']==2)
		{
			$this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>Enterprise</b> page');
			redirect('Profile');
		}
		//show dropdown for Enterprise
		$where = array(	
			'Enterprise_Status' => 0,
		);
		$Enterprise            = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where,'','Enterprise_Name');
		$content['Enterprise'] = $Enterprise;
		$query                 = "SELECT ge.*,concat(ga.fname,' ',ga.lname) AS User_Name, gd.Domain_Name, gc.Country_Name, gs.State_Name ,(SELECT count(*) FROM GAME_ENTERPRISE_GAME WHERE EG_EnterpriseID = ge.Enterprise_ID) as gamecount,(SELECT count(*) FROM GAME_ENTERPRISE_CARD WHERE EC_EnterpriseID = ge.Enterprise_ID) as cardcount FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ADMINUSERS ga ON ge.Enterprise_CreatedBy=ga.id LEFT JOIN GAME_COUNTRY gc ON gc.Country_Id= ge.Enterprise_Country LEFT JOIN GAME_STATE gs ON gs.State_Id=ge.Enterprise_State LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId  WHERE Enterprise_Status = 0 GROUP BY ge.Enterprise_ID ORDER BY Enterprise_CreatedOn DESC";
		$result                       = $this->Common_Model->executeQuery($query);
		// echo "$query<br><pre>";print_r($result);exit;
		$content['EnterpriseDetails'] = $result;
		$content['subview']           = 'manageEnterprise';
		$this->load->view('main_layout',$content);
	}
	
	//Edit/Update Enterprise
	public function edit($id=NULL)
	{
		$UserID       = $this->session->userdata('loginData')['User_Id'];
		$EnterpriseId = base64_decode($id);
		$where        = array(
			'Enterprise_ID'      => $EnterpriseId,
			'Enterprise_Status'  => 0,
		);
		$whereCountry = array(
			'Country_Status' => 0,
		);
		$result                    = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
		$content['editEnterprise'] = $result[0];
		$resultCountry             = $this->Common_Model->fetchRecords('GAME_COUNTRY',$whereCountry);
		$content['country']        = $resultCountry;
		$whereDomain               = array(
			'Domain_EnterpriseId' => $EnterpriseId,
			'Domain_Status'       => 0,
		);
		$resultDomain = $this->Common_Model->fetchRecords('GAME_DOMAIN',$whereDomain);
		if(count($resultDomain) > 0)
		{
			$content['domainName'] = $resultDomain[0];
		}
		// print_r($resultDomain[0]->Domain_Name);die();
		//Update Enterprise
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{

			$this->form_validation->set_rules('Enterprise_Name', 'Enterprise Name', 'trim|required|alpha_numeric_spaces');

			//validate email with itself
			$value = $this->db->query("SELECT Enterprise_Email FROM GAME_ENTERPRISE WHERE Enterprise_ID = ".$EnterpriseId)->row()->Enterprise_Email ;
			if($this->input->post('Enterprise_Email') != $value) 
			{
				$is_unique =  '|is_unique[GAME_ENTERPRISE.Enterprise_Email]';
			} 
			else 
			{
				$is_unique =  '';
			}
			$this->form_validation->set_rules('Enterprise_Email', 'Enterprise Email', 'trim|required|valid_email'.$is_unique);
            //validate mobile with itslelf
			$Original_value = $this->db->query("SELECT Enterprise_Number FROM GAME_ENTERPRISE WHERE Enterprise_ID = ".$EnterpriseId)->row()->Enterprise_Number ;
			if($this->input->post('Enterprise_Number') != $Original_value) 
			{
				$is_unique =  '|is_unique[GAME_ENTERPRISE.Enterprise_Number]';
			} 
			else 
			{
				$is_unique =  '';
			}

			$this->form_validation->set_rules('Enterprise_Number', 'Enterprise Number', 'trim|required|numeric|exact_length[10]'.$is_unique);

			$this->form_validation->set_rules('Enterprise_Address1', 'Address', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('Enterprise_Address2', 'Address2', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('Enterprise_Country', 'Country', 'required');

			$this->form_validation->set_rules('Enterprise_State', 'State', 'required');

			$this->form_validation->set_rules('Enterprise_Province', 'Province', 'trim|required');

			$this->form_validation->set_rules('Enterprise_Pincode', 'Pincode', 'trim|required|numeric');

			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
			}

			$EnterpriseLogo = $_FILES['logo']['name'];
			$EnterpriseName = $this->input->post('Enterprise_Name');
			$Enterprisedata = array(
				'Enterprise_Name'      => $this->input->post('Enterprise_Name'),
				'Enterprise_Email'     => $this->input->post('Enterprise_Email'),
				'Enterprise_Number'    => $this->input->post('Enterprise_Number'),
				'Enterprise_Address1'  => $this->input->post('Enterprise_Address1'),
				'Enterprise_Address2'  => $this->input->post('Enterprise_Address2'),
				'Enterprise_Country'   => $this->input->post('Enterprise_Country'),
				'Enterprise_State'     => $this->input->post('Enterprise_State'),
				'Enterprise_Province'  => $this->input->post('Enterprise_Province'),
				'Enterprise_Pincode'   => $this->input->post('Enterprise_Pincode'),
				'Enterprise_StartDate' => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_StartDate'))),
				'Enterprise_EndDate'   => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_EndDate'))),
				'Enterprise_UpdatedOn' => date('Y-m-d H:i:s'),
				'Enterprise_UpdatedBy' => $UserID,
			);
			// if user update his profile pic
			if(!empty($EnterpriseLogo))
			{
				$Enterprisedata['Enterprise_Logo'] = $EnterpriseLogo;
			}
			$this->do_upload();
			//Update Game_Enterprise details
			$where = array(
				'Enterprise_ID'      => $EnterpriseId,
				'Enterprise_Status'  => 0,
			);
			$result1 = $this->Common_Model->updateRecords('GAME_ENTERPRISE',$Enterprisedata,$where);
			// print_r($result1); echo '<br>'.$EnterpriseLogo.'<br>'.$this->input->post('commonDomain');   exit();
			if($result1 && (!empty($EnterpriseLogo) || !empty($this->input->post('commonDomain'))))
			{
				if(!empty($this->input->post('commonDomain')) && !empty($EnterpriseLogo))
				{
					$Domain_Name  = trim("http://".$this->input->post('commonDomain').".corporatesim.com");
					$updateDomain = array(
						"Domain_Name" => $Domain_Name,
						"Domain_Logo" => $EnterpriseLogo,
					);
					$where = array('Domain_EnterpriseId' => $EnterpriseId);
					$state = $this->Common_Model->updateRecords('GAME_DOMAIN',$updateDomain,$where);
					// echo "<pre>"; var_dump($state);
				}

				elseif(!empty($this->input->post('commonDomain')) && empty($EnterpriseLogo))
				{
					$Domain_Name  = trim("http://".$this->input->post('commonDomain').".corporatesim.com");
					$updateDomain = array(
						"Domain_Name" => $Domain_Name,
						// "Domain_Logo" => $EnterpriseLogo,
					);
					$where = array('Domain_EnterpriseId' => $EnterpriseId);
					$state = $this->Common_Model->updateRecords('GAME_DOMAIN',$updateDomain,$where);
					// echo "<pre>"; var_dump($state);
				}

				elseif(empty($this->input->post('commonDomain')) && !empty($EnterpriseLogo))
				{
					$updateDomain  = array(
						// "Domain_Name" => $this->input->post('commonDomain'),
						"Domain_Logo" => $EnterpriseLogo,
					);
					$where = array('Domain_EnterpriseId' => $EnterpriseId);
					$state = $this->Common_Model->updateRecords('GAME_DOMAIN',$updateDomain,$where);
					// echo "<pre>"; var_dump($state);
				}

				else
				{
					// $updateDomain  = array(
					// 	"Domain_Name" => $this->input->post('commonDomain'),
					// 	"Domain_Logo" => $EnterpriseLogo,
					// );
					// $where = array('Domain_EnterpriseId' => $EnterpriseId);
					// $this->Common_Model->updateRecords('GAME_DOMAIN',$updateDomain,$where);
				}

			}
			// die(' here');
			$this->session->set_flashdata("tr_msg","Details Update Successfully" );
			redirect("Enterprise","refresh");

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
		$content['subview'] = 'editEnterprise';
		$this->load->view('main_layout',$content);
	}

  //Insert Enterprise
	public function addEnterprise()
	{
		$UserID        = $this->session->userdata('loginData')['User_Id'];
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		$whereCountry  = array(
			'Country_Status' => 0,
		);
		$resultCountry      = $this->Common_Model->fetchRecords('GAME_COUNTRY',$whereCountry);
		$content['country'] = $resultCountry;
		if($RequestMethod == 'POST')
		{

			$this->form_validation->set_rules('Enterprise_Name', 'Enterprise Name', 'trim|required|alpha_numeric_spaces');
			
			$this->form_validation->set_rules('Enterprise_Email', 'Enterprise Email', 'trim|required|valid_email|is_unique[GAME_ENTERPRISE.Enterprise_Email]');

			$this->form_validation->set_rules('Enterprise_Number', 'Enterprise Number', 'trim|required|numeric|exact_length[10]|is_unique[GAME_ENTERPRISE.Enterprise_Number]');

			$this->form_validation->set_rules('Enterprise_Address1', 'Address', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('Enterprise_Address2', 'Address2', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('Enterprise_Country', 'Country', 'required');

			$this->form_validation->set_rules('Enterprise_State', 'State', 'required');

			$this->form_validation->set_rules('Enterprise_Province', 'Province', 'trim|required');

			$this->form_validation->set_rules('Enterprise_Pincode', 'Pincode', 'trim|required|numeric');

			$this->form_validation->set_rules('Enterprise_Password', 'Password', 'trim|required|min_length[5]|max_length[12]|alpha_numeric');

			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
			}

			// echo "<pre>"; print_r($this->input->post()); exit();
			if($this->input->post('submit') == 'save')
			{
				$Enterprisedata = array(
					'Enterprise_Name'      => $this->input->post('Enterprise_Name'),
					'Enterprise_Email'     => $this->input->post('Enterprise_Email'),
					'Enterprise_Number'    => $this->input->post('Enterprise_Number'),
					'Enterprise_Address1'  => $this->input->post('Enterprise_Address1'),
					'Enterprise_Address2'  => $this->input->post('Enterprise_Address2'),
					'Enterprise_Country'   => $this->input->post('Enterprise_Country'),
					'Enterprise_State'     => $this->input->post('Enterprise_State'),
					'Enterprise_Province'  => $this->input->post('Enterprise_Province'),
					'Enterprise_Pincode'   => $this->input->post('Enterprise_Pincode'),
					'Enterprise_Password'  => $this->input->post('Enterprise_Password'),
					'Enterprise_StartDate' => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_GameStartDate'))),
					'Enterprise_EndDate'   => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_GameEndDate'))),
					'Enterprise_CreatedOn' => date('Y-m-d'),
					'Enterprise_CreatedBy' => $UserID ,
					'Enterprise_Logo'      => $_FILES['logo']['name'],
				);
					//
				$this->do_upload();
				if(!empty($this->input->post('Enterprise_Name')))
				{
					$where  = array(
						'Enterprise_Name' =>	$this->input->post('Enterprise_Name'),
					);
					$query = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);	
					if($query)
					{
						$this->session->set_flashdata("er_msg","Enterprise already registered" );
						redirect("Enterprise","refresh");
					}
					else
					{
						$result = $this->Common_Model->insert('GAME_ENTERPRISE',$Enterprisedata);

						if($result)
						{
							$Domain_EnterpriseId = $result;
							$Domain_Name         = $this->input->post('commonDomain');
							$Domain_Logo         = $_FILES['logo']['name'];
							$Domain_details      = array(
								'Domain_Name'         => (!empty($Domain_Name))?trim("https://".$Domain_Name.".corporatesim.com"):'',
								'Domain_EnterpriseId' => $Domain_EnterpriseId,
								'Domain_Logo'         => $Domain_Logo,
								'Domain_Status'       => 0,
							);
							if($this->input->post('allow') == 'allow' || empty($Domain_Name))
							{
								// insert data to domain table only if domanin is neither existing nor empty
								$this->Common_Model->insert('GAME_DOMAIN',$Domain_details);
							}
							if($result)
							{
								$emailid  = $this->input->post('Enterprise_Email');
								$password = $this->input->post('Enterprise_Password');
								if($this->input->post('commonDomain') == '')
								{
									$domain = "https://live.corporatesim.com";
								}
								else
								{
									$domain   = 'https://'.$this->input->post('commonDomain').'corporatesim.com';
								}
								$message  = "Thanks for your enrolling!\r\n\r\n";
								$message .= 	"Your login and password for accessing our Simulation Games/eLearning programs/Assessments are provided below.\r\n";
								$message .= "You will have to login at :$domain\r\n\r\n";
								$message .=  "login :$emailid\r\n";
								$message .= "password :.$password\r\n\r\n";
								$message .= "Regards,\r\n Admin";

								$config['charset']  = 'utf-8';
								$config['mailtype'] = 'text';
								$config['newline']  = '\r\n';


								$this->email->initialize($config);
								$this->email->to($emailid);
								$this->email->from('support@corporatesim.com','corporatesim','support@corporatesim.com');
								$this->email->subject("Here is your email and password");
								$this->email->message($message);

								$this->email->send();
							}
						}

						$this->session->set_flashdata("tr_msg","Details Insert Successfully" );
						redirect("Enterprise","refresh");
					}
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
		$content['subview'] = 'addEnterprise';
		$this->load->view('main_layout',$content);
	}

//Upload Enterprise Logo
	public function do_upload(){
		//upload Image
		$config['upload_path']   = './common/Logo/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png';
		$config['max_size']      = 1024;

		if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//echo "<pre>"; print_r($this->input->post());print_r($_FILES['User_profile_pic']);
		if (!$this->upload->do_upload('logo'))
		{ 
			$error = array('error' => $this->upload->display_errors());
			//echo $this->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// echo $this->upload->data('file_name');
			$updateSessionData['logo'] = $data['upload_data']['file_name'];
		}	
	}

//delete Enterprise Users
	public function delete($id=NULL)
	{
		$EnterpriseId = base64_decode($this->uri->segment(3));
		$where = array(
			'Enterprise_ID'      => $id,
			'Enterprise_Status'  => 0,
		);
		$result = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$EnterpriseId);
		$content['result'] = $result;
		$this->db->set('Enterprise_Status', 1);
		$this->db->where('Enterprise_ID', $EnterpriseId);
		$this->db->update('GAME_ENTERPRISE');
		redirect("Enterprise","refresh");
	}
}
