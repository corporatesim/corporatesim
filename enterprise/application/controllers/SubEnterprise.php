<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubEnterprise extends CI_Controller {

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
						            $Domain_SubEnterpriseId  = $result;
                        $Domain_Name          = $this->input->post('commonDomain');
                        $Domain_Logo          = $_FILES['logo']['name'];
                        $Domain_details = array(
                            'Domain_Name'             => $Domain_Name,
                            'Domain_EnterpriseId'     => $this->input->post('Enterprise_ID'),
                            'Domain_SubEnterpriseId'  => $Domain_SubEnterpriseId,
                            'Domain_Logo'             => $Domain_Logo,
                            'Domain_Status'           => 0,
                        );
                            //print_r($Domain_details);exit();
                        $this->Common_Model->insert('GAME_DOMAIN',$Domain_details);
					}

					$this->session->set_flashdata("tr_msg","Details Insert Successfully" );
					redirect("SubEnterprise","refresh");
				}
			}
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
			'SubEnterprise_ID'     => $id,
			'SubEnterprise_Status' => 0,
		);
		$result            = $this->Common_Model->fetchRecords('GAME_SUBENTERprise',$where);
		$content['result'] = $result;
		$this->db->set('SubEnterprise_Status', 1);
		$this->db->where('SubEnterprise_ID', $id);
		$this->db->update('GAME_SUBENTERPRISE');
		redirect("SubEnterprise","refresh");
	}
}
