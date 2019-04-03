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
		$this->load->model('Common_Model');
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

	public function get_dateRange($id=NULL)
	{
		$this->db->select('Enterprise_StartDate,Enterprise_EndDate');
		$this->db->where(array('Enterprise_ID' => $id));
		$result = $this->db->get('GAME_ENTERPRISE')->result();
		// print_r($this->db->last_query()); die(' here ');
		// print_r($result[0]);
		$result = $result[0];
		$result->Enterprise_StartDate = strtotime($result->Enterprise_StartDate);
		$result->Enterprise_EndDate   = strtotime($result->Enterprise_EndDate);
		echo json_encode($result);
	}
}
