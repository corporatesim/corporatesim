<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enterprise extends CI_Controller {

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
			'Enterprise_Status'       => 0,
		);
		$Enterprise            = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where,'','Enterprise_Name');
		$content['Enterprise'] = $Enterprise;
		$query                 = "SELECT ge.*,concat(ga.fname,' ',ga.lname) AS User_Name, gc.Country_Name, gs.State_Name ,(SELECT count(*) FROM GAME_ENTERPRISE_GAME WHERE EG_EnterpriseID = ge.Enterprise_ID) as gamecount FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ADMINUSERS ga ON ge.Enterprise_CreatedBy=ga.id LEFT JOIN GAME_COUNTRY gc ON gc.Country_Id= ge.Enterprise_Country LEFT JOIN GAME_STATE gs ON gs.State_Id=ge.Enterprise_State WHERE Enterprise_Status = 0";
		$result                       = $this->Common_Model->executeQuery($query);
		$content['EnterpriseDetails'] = $result;
		$content['subview']           = 'manageEnterprise';
		$this->load->view('main_layout',$content);
	}
	
	//Edit/Update Enterprise
	public function edit()
	{
		$UserID       = $this->session->userdata('loginData')['User_Id'];
		$EnterpriseId = base64_decode($this->uri->segment(3));
		$where = array(
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
		//Update Enterprise
		$RequestMethod = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			$EnterpriseLogo = $_FILES['logo']['name'];
			$EnterpriseName = $this->input->post('Enterprise_Name');
			$Enterprisedata = array(
				'Enterprise_Name'      =>$this->input->post('Enterprise_Name'),
				'Enterprise_Email'     => $this->input->post('Enterprise_Email'),
				'Enterprise_Number'    => $this->input->post('Enterprise_Number'),
				'Enterprise_Address1'  => $this->input->post('Enterprise_Address1'),
				'Enterprise_Address2'  => $this->input->post('Enterprise_Address2'),
				'Enterprise_Country'   => $this->input->post('Enterprise_Country'),
				'Enterprise_State'     => $this->input->post('Enterprise_State'),
				'Enterprise_Province'  => $this->input->post('Enterprise_Province'),
				'Enterprise_Pincode'   => $this->input->post('Enterprise_Pincode'),
				'Enterprise_StartDate' => $this->input->post('Enterprise_StartDate'),
				'Enterprise_EndDate'   => $this->input->post('Enterprise_EndDate'),
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
			//print_r($result1);exit();
			$this->session->set_flashdata("tr_msg","Details Update Successfully" );
			redirect("Enterprise","refresh");
		}
		$content['subview']     = 'editEnterprise';
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
			$Enterprisedata           = array(
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
				'Enterprise_StartDate' => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_StartDate'))),
				'Enterprise_EndDate'   => date('Y-m-d H:i:s',strtotime($this->input->post('Enterprise_EndDate'))),
				'Enterprise_CreatedOn' => date('Y-m-d'),
				'Enterprise_CreatedBy' => $UserID ,
				'Enterprise_Logo'      => $_FILES['logo']['name'],
			);
			//print_r($Enterprisedata);exit();
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
					$this->Common_Model->insert('GAME_ENTERPRISE',$Enterprisedata);
					$this->session->set_flashdata("tr_msg","Details Insert Successfully" );
					redirect("Enterprise","refresh");
				}
			}
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
