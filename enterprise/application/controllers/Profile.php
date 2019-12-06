<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
		// $this->load->helper(array('form', 'url'));
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
		elseif($this->session->userdata('loginData')['User_Role'] == 'superadmin')
		{
			$this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>Profile</b> page');
			redirect('dashboard');
		}
	}
	public function index()
	{
		// while form is posted
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			// echo "<pre>"; print_r($this->input->post()); print_r($_FILES); 
			// exit();
			if($this->input->post('type') == 'enterprise')
			{
				// insert array for enterprise
				if(!empty($_FILES['logo']['name']))
				{
					$this->do_upload('enterprise');
				}
				else
				{
					$tableName  = 'GAME_ENTERPRISE';
					$columnName = 'Enterprise_ID';
					$updateArr  = array(
						'Enterprise_Name'      => $this->input->post('Enterprise_Name'),
						'Enterprise_Number'    => $this->input->post('Enterprise_Number'),
						'Enterprise_Email'     => $this->input->post('Enterprise_Email'),
						'Enterprise_Address1'  => $this->input->post('Enterprise_Address1'),
						'Enterprise_Address2'  => $this->input->post('Enterprise_Address2'),
						'Enterprise_Country'   => $this->input->post('Enterprise_Country'),
						'Enterprise_State'     => $this->input->post('Enterprise_State'),
						'Enterprise_Province'  => $this->input->post('Enterprise_Province'),
						'Enterprise_Pincode'   => $this->input->post('Enterprise_Pincode'),
						'Enterprise_Password'  => $this->input->post('Enterprise_Password'),
						'Enterprise_UpdatedOn' => date('Y-m-d H:i:s'),
						'Enterprise_UpdatedBy' => $this->session->userdata('loginData')['User_Id'],
					);
					$check = array(
						'Enterprise_Name'   => $this->input->post('Enterprise_Name'),
						'Enterprise_Number' => $this->input->post('Enterprise_Number'),
						'Enterprise_Email'  => $this->input->post('Enterprise_Email'),
					);
				}
			}
			if($this->input->post('type') == 'subenterprise')
			{
				// insert array for subenterprise
				if(!empty($_FILES['logo']['name']))
				{
					$this->do_upload('subenterprise');
				}
				else
				{
					$tableName  = 'GAME_SUBENTERPRISE';
					$columnName = 'SubEnterprise_ID';
					$updateArr  = array(
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
						'SubEnterprise_UpdatedOn' => date('Y-m-d H:i:s'),
						'SubEnterprise_UpdatedBy' => $this->session->userdata('loginData')['User_Id'],
					);
					$check = array(
						'SubEnterprise_Name'   => $this->input->post('SubEnterprise_Name'),
						'SubEnterprise_Number' => $this->input->post('SubEnterprise_Number'),
						'SubEnterprise_Email'  => $this->input->post('SubEnterprise_Email'),
					);
				}
			}
			$id         = $this->session->userdata('loginData')['User_Id'];
			$UpdProfile = $this->Common_Model->update($tableName,$id,$updateArr,$check,$columnName);
			//print_r($UpdProfile);exit();
			if($UpdProfile == 'update')
			{
				$this->session->set_flashdata("tr_msg","Details Update Successfully");
				redirect("dashboard/logout");
			}
			else
			{
				$this->session->set_flashdata("er_msg","UserName, Email or Mobile No already exist");
				redirect("Profile");
			}
		}
		// form post end here
		$whereCountry = array(
			'Country_Status' => 0,
		);
		$resultCountry      = $this->Common_Model->fetchRecords('GAME_COUNTRY',$whereCountry);
		$content['country'] = $resultCountry;
		// for enterprise
		if($this->session->userdata('loginData')['User_Role'] == 1)
		{
			$tableName = 'GAME_ENTERPRISE';
			$where     = array(
				'Enterprise_ID'     => $this->session->userdata('loginData')['User_Id'],
				'Enterprise_Status' => 0,
			);
			$content['subview'] = 'enterpriseProfile';
			$result             = $this->Common_Model->fetchRecords($tableName,$where);
		}
		// for subenterprise
		if($this->session->userdata('loginData')['User_Role'] == 2)
		{
			$tableName = 'GAME_SUBENTERPRISE';
			$where     = array(
				'SubEnterprise_ID'     => $this->session->userdata('loginData')['User_Id'],
				'SubEnterprise_Status' => 0,
			);
			$content['subview'] = 'subenterpriseProfile';
			$result             = $this->Common_Model->fetchRecords($tableName,$where);
		}
		// echo '<pre>'; print_r($result[0]); exit();
		// $content['subview'] = 'profile';
		$content['userDetails']  = $result[0];
		$this->load->view('main_layout',$content);
	}

	//Upload Image On seleted Path
	public function do_upload($type=NULL){
		//upload Image
		$config['upload_path']   = './common/Logo/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png';
		$config['max_size']      = 1024;
		// $config['max_width']     = 1024;
		// $config['max_height']    = 768;
		//echo $config['upload_path'];
		if ( ! is_dir($config['upload_path']) )
		{
			$this->session->set_flashdata('er_msg', 'The upload directory does not exist');
			redirect('Profile');
			die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		} 

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//echo "<pre>"; print_r($this->input->post());print_r($_FILES['User_profile_pic']);
		if (!$this->upload->do_upload('logo'))
		{ 
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('er_msg',$error);
			redirect('Profile');
			//echo $this->upload->display_errors();
		}
		else
		{
			$data       = array('upload_data' => $this->upload->data());
			$updateLogo = ($this->upload->data('file_name'))?$this->upload->data('file_name'):$this->session->userdata('loginData')['User_profile_pic'];
			// print_r($this->upload->data()); exit();
			// $updateSessionData = $this->session->userdata('loginData');
			// $updateSessionData['User_profile_pic'] = $data['upload_data']['file_name'];
			// $this->session->set_userdata('loginData',$updateSessionData);
      // echo "<pre>"; print_r($updateSessionData['User_profile_pic']); print_r($data); exit();
			if($type == 'enterprise')
			{
				// insert array for enterprise
				$tableName  = 'GAME_ENTERPRISE';
				$columnName = 'Enterprise_ID';
				$updateArr  = array(
					'Enterprise_Name'      => $this->input->post('Enterprise_Name'),
					'Enterprise_Number'    => $this->input->post('Enterprise_Number'),
					'Enterprise_Email'     => $this->input->post('Enterprise_Email'),
					'Enterprise_Address1'  => $this->input->post('Enterprise_Address1'),
					'Enterprise_Address2'  => $this->input->post('Enterprise_Address2'),
					'Enterprise_Country'   => $this->input->post('Enterprise_Country'),
					'Enterprise_State'     => $this->input->post('Enterprise_State'),
					'Enterprise_Province'  => $this->input->post('Enterprise_Province'),
					'Enterprise_Pincode'   => $this->input->post('Enterprise_Pincode'),
					'Enterprise_Password'  => $this->input->post('Enterprise_Password'),
					'Enterprise_UpdatedOn' => date('Y-m-d H:i:s'),
					'Enterprise_UpdatedBy' => $this->session->userdata('loginData')['User_Id'],
					'Enterprise_Logo'      => $updateLogo,
				);
				$check = array(
					'Enterprise_Name'   => $this->input->post('Enterprise_Name'),
					'Enterprise_Number' => $this->input->post('Enterprise_Number'),
					'Enterprise_Email'  => $this->input->post('Enterprise_Email'),
				);
			}
			else
			{
				// insert array for subenterprise
				$tableName  = 'GAME_SUBENTERPRISE';
				$columnName = 'SubEnterprise_ID';
				$updateArr  = array(
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
					'SubEnterprise_UpdatedOn' => date('Y-m-d H:i:s'),
					'SubEnterprise_UpdatedBy' => $this->session->userdata('loginData')['User_Id'],
					'SubEnterprise_Logo'      => $updateLogo,
				);
				$check = array(
					'SubEnterprise_Name'   => $this->input->post('SubEnterprise_Name'),
					'SubEnterprise_Number' => $this->input->post('SubEnterprise_Number'),
					'SubEnterprise_Email'  => $this->input->post('SubEnterprise_Email'),
				);
			}
			// echo "<pre>"; print_r($updateArr); exit();
			$id         = $this->session->userdata('loginData')['User_Id'];
			$UpdProfile = $this->Common_Model->update($tableName,$id,$updateArr,$check,$columnName);
			//print_r($UpdProfile);exit();
			if($UpdProfile == 'update')
			{
				$this->session->set_flashdata("tr_msg","Details Update Successfully");
				redirect("dashboard/logout");
			}
			else
			{
				$this->session->set_flashdata("er_msg","UserName, Email or Mobile No already exist");
				redirect("Profile");
			}
		}	
	}
}
