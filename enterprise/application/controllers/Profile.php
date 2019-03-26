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
		$this->load->helper(array('form', 'url'));
		$this->load->model('Common_Model');
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
			redirect('Login/login');
		}
	}
//edit and update logged in user details
	public function index()
	{
		if($this->session->userdata('loginData')['User_Role']!=1 && $this->session->userdata('loginData')['User_Role']!=2)
		{
			$this->session->set_flashdata('er_msg', 'You do not have the permission to access <b>Profile</b> page');
			redirect('Enterprise');
		}
		$where = array(
			'User_id'     => $this->session->userdata('loginData')['User_Id'],
			'User_Delete' => 0,
		);
		$result                  = $this->Common_Model->fetchRecords('GAME_SITE_USERS',$where);
		$content['userDetails']  = $result[0];

		//Update Enterprise Profile
		$id                      = $this->session->userdata('loginData')['User_Id'];
		$editPassword            = $this->Common_Model->editPassword($id);
		$content['editPassword'] = $editPassword[0];
		$RequestMethod           = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			if(empty($_FILES['User_profile_pic']['name']))
			{
				$userdata = array(
					'User_fname'       => $this->input->post('User_fname'),
					'User_lname'       => $this->input->post('User_lname'),
					'User_username'    => $this->input->post('User_username'),
					'User_email'       => $this->input->post('User_email'),
					'User_mobile'      => $this->input->post('User_mobile'),
					'User_profile_pic' => $this->session->userdata('loginData')['User_profile_pic'],
				);
			}
			else
			{
				$userdata = array(
					'User_fname'       => $this->input->post('User_fname'),
					'User_lname'       => $this->input->post('User_lname'),
					'User_username'    => $this->input->post('User_username'),
					'User_email'       => $this->input->post('User_email'),
					'User_mobile'      => $this->input->post('User_mobile'),
					'User_profile_pic' => $_FILES['User_profile_pic']['name'],
				);	
			}
      //print_r($userdata);exit();
			$check = array(
				'User_username' => $this->input->post('User_username'),
				'User_email'    => $this->input->post('User_email'),
				'User_mobile'   => $this->input->post('User_mobile'),
			);
			// echo "<pre>"; print_r($this->input->post()); print_r($_FILES['User_profile_pic']); print_r($data); 
			$this->do_upload();
			$UpdProfile = $this->Common_Model->update('GAME_SITE_USERS',$id,$userdata,$check,'User_id');
			//print_r($UpdProfile);exit();
			if($UpdProfile == 'update')
			{
				if(!empty($this->input->post('password')))
				{
					$password = array(
						'Auth_password' =>$this->input->post('password'),
					);
				}
				$UpdPass = $this->Common_Model->updatePassword($id,$password);
				$this->session->set_flashdata("tr_msg","Details Update Successfully" );
				redirect("Profile","refresh");
			}
			else
			{
				$this->session->set_flashdata("er_msg","UserName, Email or Mobile No already exist" );
				redirect("Profile","refresh");
			}
			
		}
		$content['subview']     = 'profile';
		$this->load->view('main_layout',$content);

	}

//Upload Image On seleted Path
	public function do_upload(){
		//upload Image
		$config['upload_path']   = './common/profileImages/';
		$config['allowed_types'] = 'gif|jpeg|jpg|png';
		$config['max_size']      = 1024;
		// $config['max_width']     = 1024;
		// $config['max_height']    = 768;
		//echo $config['upload_path'];
		if ( ! is_dir($config['upload_path']) ) die("THE UPLOAD DIRECTORY DOES NOT EXIST");
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		//echo "<pre>"; print_r($this->input->post());print_r($_FILES['User_profile_pic']);
		if (!$this->upload->do_upload('User_profile_pic'))
		{ 
			$error = array('error' => $this->upload->display_errors());
			//echo $this->upload->display_errors();
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			// echo $this->upload->data('file_name');
			$updateSessionData = $this->session->userdata('loginData');
			$updateSessionData['User_profile_pic'] = $data['upload_data']['file_name'];
			$this->session->set_userdata('loginData',$updateSessionData);
      // echo "<pre>"; print_r($updateSessionData['User_profile_pic']); print_r($data); exit();
		}	
	}
}
