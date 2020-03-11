<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubEnterprise extends MY_Controller {

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
//
//show Subenterprise details
	public function index()
	{
		if($this->session->userdata('loginData')['User_Role']==2)
		{
			$this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>SubEnterprize</b> page');
			redirect('Profile');
		}
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		$query         = "SELECT *, (SELECT count(*) FROM GAME_SUBENTERPRISE_GAME WHERE SG_SubEnterpriseID = gs.SubEnterprise_ID) as gamecount FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gs.SubEnterprise_CreatedBy OR ga.id = gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_SITE_USERS gu ON gu.User_id = gs.SubEnterprise_CreatedBy OR gu.User_id = gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_COUNTRY gc ON gc.Country_Id=gs.SubEnterprise_Country LEFT JOIN GAME_STATE gst ON gst.State_Id=gs.SubEnterprise_State WHERE SubEnterprise_Status = 0 ";

		if($this->session->userdata('loginData')['User_Role'] == 1)
		{
		  //Show SubEnterprize When Enterprize Login
			$User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
			$where = array(
				'SubEnterprise_EnterpriseID' => $User_ParentId,
				'SubEnterprise_Status'       => 0,
			);
			$Subenterprise = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where,'','SubEnterprise_Name');
			$content['SubEnterprise_Name'] = $Subenterprise;
			$query                        .= " AND SubEnterprise_EnterpriseID=".$User_ParentId;
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('SubEnterprise_ID');
				if($filterID != '')
				{
					$query   .= " AND SubEnterprise_ID=".$filterID;
				}
			}

		}
		else
		{
		  //Show SubEnterprize When Admin Login
			$where = array(	
				'Enterprise_Status' => 0,
			);
			$Enterprise                   = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where,'','Enterprise_Name');
			$content['EnterpriseDetails'] = $Enterprise;
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('Enterprise_ID');
				if($filterID != '')
				{
					$query .= " AND SubEnterprise_EnterpriseID=".$filterID;
				}
			}
		}
		// die($query);
		$query .= " ORDER BY SubEnterprise_CreatedOn DESC";
		$result = $this->Common_Model->executeQuery($query);	
		if(!empty($filterID))
		{
			$filterID = $filterID;
		}
		else
		{
			$filterID = '-1';
		}
		$content['filterID']             = $filterID;
		$content['subEnterpriseDetails'] = $result;
		$content['subview']              = 'listSubEnterprise';
		$this->load->view('main_layout',$content);	
	}

//edit subentyerprise details
	public function edit($encodedId=NULL)
	{
		$UserID       = $this->session->userdata('loginData')['User_Id'];
		$UserName     = $this->session->userdata('loginData')['User_Username'];
		$id           = base64_decode($encodedId);
		$whereCountry = array(
			'Country_Status' => 0,
		);
		$resultCountry      = $this->Common_Model->fetchRecords('GAME_COUNTRY',$whereCountry);
		$content['country'] = $resultCountry;
		//edit subEnterprise detail
		$query = "SELECT gs.*, ge.Enterprise_Name,ge.Enterprise_ID, ge.Enterprise_StartDate, ge.Enterprise_EndDate FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID WHERE SubEnterprise_ID = $id ";
		$result                       = $this->Common_Model->executeQuery($query);
		$content['editSubEnterprise'] = $result[0];
		$RequestMethod                = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			$this->form_validation->set_rules('SubEnterprise_Name', 'SubEnterprise Name', 'trim|required|alpha_numeric_spaces');

			//validate email with itself 
			$value = $this->db->query("SELECT SubEnterprise_Email FROM GAME_SUBENTERPRISE WHERE SubEnterprise_ID = ".$id)->row()->SubEnterprise_Email ;
			if($this->input->post('SubEnterprise_Email') != $value) 
			{
				$is_unique =  '|is_unique[GAME_SUBENTERPRISE.SubEnterprise_Email]';
			} 
			else 
			{
				$is_unique =  '';
			}

			$this->form_validation->set_rules('SubEnterprise_Email', 'SubEnterprise Email', 'trim|required|valid_email'.$is_unique);

			//validate mobile with itself 
			$value = $this->db->query("SELECT SubEnterprise_Number FROM GAME_SUBENTERPRISE WHERE SubEnterprise_ID = ".$id)->row()->SubEnterprise_Number ;
			if($this->input->post('SubEnterprise_Number') != $value) 
			{
				$is_unique =  '|is_unique[GAME_SUBENTERPRISE.SubEnterprise_Number]';
			} 
			else 
			{
				$is_unique =  '';
			}

			$this->form_validation->set_rules('SubEnterprise_Number', 'SubEnterprise Number', 'trim|required|numeric|exact_length[10]'.$is_unique);

			$this->form_validation->set_rules('SubEnterprise_Address1', 'Address', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('SubEnterprise_Address2', 'Address2', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('SubEnterprise_Country', 'Country', 'required');

			$this->form_validation->set_rules('SubEnterprise_State', 'State', 'required');

			$this->form_validation->set_rules('SubEnterprise_Province', 'Province', 'trim|required');

			$this->form_validation->set_rules('SubEnterprise_Pincode', 'Pincode', 'trim|required|numeric');

			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
			}

			$EnterpriseID      = $this->input->post('Enterprise_ID');
			$subenterpriseLogo = $_FILES['logo']['name'];
			$SubEnterpriseName = $this->input->post('SubEnterprise_Name');
			$subEnterprisedata = array(
				'SubEnterprise_Name'         => $this->input->post('SubEnterprise_Name'),
				'SubEnterprise_EnterpriseID' => $EnterpriseID,
				'SubEnterprise_Number'       => $this->input->post('SubEnterprise_Number'),
				'SubEnterprise_Email'        => $this->input->post('SubEnterprise_Email'),
				'SubEnterprise_Address1'     => $this->input->post('SubEnterprise_Address1'),
				'SubEnterprise_Address2'     => $this->input->post('SubEnterprise_Address2'),
				'SubEnterprise_Country'      => $this->input->post('SubEnterprise_Country'),
				'SubEnterprise_State'        => $this->input->post('SubEnterprise_State'),
				'SubEnterprise_Province'     => $this->input->post('SubEnterprise_Province'),
				'SubEnterprise_Pincode'      => $this->input->post('SubEnterprise_Pincode'),
				'SubEnterprise_StartDate'    => date('Y-m-d H:i:s',strtotime($this->input->post('SubEnterprise_StartDate'))),
				'SubEnterprise_EndDate'      => date('Y-m-d H:i:s',strtotime($this->input->post('SubEnterprise_EndDate'))),
				'SubEnterprise_UpdatedOn'    => date('Y-m-d H:i:s'),
				'SubEnterprise_UpdatedBy'    => $UserID,
			);
			if(!empty($subenterpriseLogo))
			{
				$subEnterprisedata['SubEnterprise_Logo'] = $subenterpriseLogo;
			}
			$this->do_upload();
			//Update Game_Subenterprise details
			$where = array(
				'SubEnterprise_ID'     => $id,
				'SubEnterprise_Status' => 0,
			);

			$result1 = $this->Common_Model->updateRecords('GAME_SUBENTERPRISE',$subEnterprisedata,$where);
			if($result1)
			{
				$this->session->set_flashdata("tr_msg","Details Update Successfully" );
				redirect("SubEnterprise");
			}
			else
			{
				$this->session->set_flashdata("er_msg","Connection problem, Please try later" );
				redirect("SubEnterprise/edit/".$encodedId);
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
		$content['subview'] = 'editSubEnterprise';
		$this->load->view('main_layout',$content);
	}

  //Insert Subenterprise
	public function addSubEnterprise()
	{
		$UserID        = $this->session->userdata('loginData')['User_Id'];
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		//Dropdown list of Enterprize
		$where = array(	
			'Enterprise_Status' => 0,
		);
		$Enterprise                   = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
		$content['EnterpriseDetails'] = $Enterprise;
		$whereCountry                 = array(
			'Country_Status' => 0,
		);
		$resultCountry      = $this->Common_Model->fetchRecords('GAME_COUNTRY',$whereCountry);
		$content['country'] = $resultCountry;
		
		if($RequestMethod == 'POST')
		{
			$this->form_validation->set_rules('Enterprise_ID', 'Select Enterprise', 'required');
			$this->form_validation->set_rules('SubEnterprise_Name', 'SubEnterprise Name', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('SubEnterprise_Email', 'SubEnterprise Email', 'trim|required|valid_email|is_unique[GAME_ENTERPRISE.Enterprise_Email]');

			$this->form_validation->set_rules('SubEnterprise_Number', 'SubEnterprise Number', 'trim|required|numeric|exact_length[10]|is_unique[GAME_SUBENTERPRISE.SubEnterprise_Number]');

			$this->form_validation->set_rules('SubEnterprise_Address1', 'Address', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('SubEnterprise_Address2', 'Address2', 'trim|required|alpha_numeric_spaces');

			$this->form_validation->set_rules('SubEnterprise_Country', 'Country', 'required');

			$this->form_validation->set_rules('SubEnterprise_State', 'State', 'required');

			// $this->form_validation->set_rules('SubEnterprise_Province', 'Province', 'trim|required');

			$this->form_validation->set_rules('SubEnterprise_Pincode', 'Pincode', 'trim|required|numeric');

			$this->form_validation->set_rules('SubEnterprise_Password', 'Password', 'trim|required|min_length[5]|max_length[12]|alpha_numeric');

			if($this->form_validation->run() == FALSE)
			{
				$this->form_validation->set_error_delimiters('<div class="text-danger">','</div>');

				$this->session->set_flashdata('er_msg', 'There have been validation error(s), please check the error messages');

				$hasValidationErrors = true;
				goto prepareview;
			}
			$subEnterprisedata = array(
				'SubEnterprise_Name'      => $this->input->post('SubEnterprise_Name'),
				'SubEnterprise_Number'    => $this->input->post('SubEnterprise_Number'),
				'SubEnterprise_Email'     => $this->input->post('SubEnterprise_Email'),
				'SubEnterprise_Address1'  => $this->input->post('SubEnterprise_Address1'),
				'SubEnterprise_Address2'  => $this->input->post('SubEnterprise_Address2'),
				'SubEnterprise_Country'   => $this->input->post('SubEnterprise_Country'),
				'SubEnterprise_State'     => $this->input->post('SubEnterprise_State'),
				'SubEnterprise_Province'  => $this->input->post('SubEnterprise_Province'),
				'SubEnterprise_Pincode'   => $this->input->post('SubEnterprise_Pincode'),
				'SubEnterprise_Password'  => $this->input->post('SubEnterprise_Password'),
				'SubEnterprise_StartDate' => date('Y-m-d H:i:s',strtotime($this->input->post('SubEnterprise_StartDate'))),
				'SubEnterprise_EndDate'   => date('Y-m-d H:i:s',strtotime($this->input->post('SubEnterprise_EndDate'))),
				'SubEnterprise_CreatedOn' => date('Y-m-d H:i:s'),
				'SubEnterprise_CreatedBy' => $UserID,
				'SubEnterprise_Logo'      => $_FILES['logo']['name'],
				'SubEnterprise_Owner'     => 2
			);	
			if($this->session->userdata('loginData')['User_Role']==1)
			{
				$EnterpriseID                                    = $this->session->userdata('loginData')['User_ParentId'];
				$subEnterprisedata['SubEnterprise_Owner']        = 2;
				$subEnterprisedata['SubEnterprise_EnterpriseID'] = $EnterpriseID;
			}
			else
			{
				$EnterpriseID                                    = $this->input->post('Enterprise_ID');
				$subEnterprisedata['SubEnterprise_Owner']        = 1;
				$subEnterprisedata['SubEnterprise_EnterpriseID'] = $EnterpriseID;
			}
			//print_r($subEnterprisedata);exit();
			$this->do_upload();
			if(!empty($this->input->post('SubEnterprise_Name')))
			{
				$where  = array(
					'SubEnterprise_Name' =>	$this->input->post('SubEnterprise_Name'),
				);
				$query = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where);	
				if($query)
				{
					$this->session->set_flashdata("er_msg","SubEnterprise already registered" );
					redirect("SubEnterprise","refresh");
				}
				else
				{
					$result = $this->Common_Model->insert('GAME_SUBENTERPRISE',$subEnterprisedata);
					if($result){
						            //$Domain_EnterpriseId  = $UserID  ;
						$Domain_SubEnterpriseId = $result;
						$Domain_Name            = $this->input->post('commonDomain');
						$Domain_Logo            = $_FILES['logo']['name'];
						$Domain_details         = array(
							'Domain_Name'            => $Domain_Name,
							'Domain_EnterpriseId'    => $this->input->post('Enterprise_ID'),
							'Domain_SubEnterpriseId' => $Domain_SubEnterpriseId,
							'Domain_Logo'            => $Domain_Logo,
							'Domain_Status'          => 0,
						);
                            //print_r($Domain_details);exit();
						$this->Common_Model->insert('GAME_DOMAIN',$Domain_details);
					}
					if($result)
					{
						$emailid  = $this->input->post('SubEnterprise_Email');
						$password = $this->input->post('SubEnterprise_Password');
						$domain   = "https://live.corporatesim.com";

						$message  = "Thanks for your enrolling!\r\n\r\n";
						$message .= "Your login and password for accessing our Simulation Games/eLearning programs/Assessments are provided below.\r\n\r\n";
						$message .= "You will have to login at :$domain\r\n\r\n";
						$message .= "login :$emailid\r\n";
						$message .= "password :.$password\r\n\r\n";
						$message .= "Regards,\r\n Admin";

						$config['charset']  = 'utf-8';
						$config['mailtype'] = 'text';
						$config['newline']  = '\r\n';


						$this->email->initialize($config);
						$this->email->to($emailid);
						$this->email->from('support@corporatesim.com','Corporatesim','support@corporatesim.com');
						$this->email->subject("Here is your email and password");
						$this->email->message($message);
						// stop sending email from localhost
						if($this->input->server('HTTP_HOST') != 'localhost')
						{
							$this->email->send();
						}
					}
				}
				$this->session->set_flashdata("tr_msg","Record Saved Successfully" );
				redirect("SubEnterprise","refresh");
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
		$content['subview'] = 'addSubEnterprise';
		$this->load->view('main_layout',$content);
	}

 //Upload SubEnterprise Logo
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

//delete subenterprise details
	public function delete($id=NULL)
	{
		$id    = base64_decode($this->uri->segment(3));
		$where = array(
			'SubEnterprise_ID' => $id,
			// 'SubEnterprise_Status' => 0,
		);
		$update = array(
			'SubEnterprise_Status' => 1,
		);
		$this->Common_Model->softDelete('GAME_SUBENTERPRISE',$update,$where);
		redirect("SubEnterprise","refresh");
	}
}
