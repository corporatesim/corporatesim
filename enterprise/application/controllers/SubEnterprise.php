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
		$this->load->model('Common_Model');
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
		$RequestMethod  = $this->input->server('REQUEST_METHOD');
		$query = "SELECT *, (SELECT count(*) FROM GAME_SUBENTERPRISE_GAME WHERE SG_SubEnterpriseID = gs.SubEnterprise_ID) as gamecount FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gs.SubEnterprise_CreatedBy OR ga.id = gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_SITE_USERS gu ON gu.User_id = gs.SubEnterprise_CreatedBy OR gu.User_id = gs.SubEnterprise_UpdatedBy WHERE SubEnterprise_Status = 0 ";

		if($this->session->userdata('loginData')['User_Role'] == 1)
		{
		  //Show SubEnterprize When Enterprize Login
			$User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
			$where = array(
				'SubEnterprise_EnterpriseID' => $User_ParentId,
				'SubEnterprise_Status'       => 0,
			);
			$Subenterprise            = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where,'','SubEnterprise_Name');
			$content['Subenterprise'] = $Subenterprise;
			$query .= " AND SubEnterprise_EnterpriseID=".$User_ParentId;
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('SubEnterprise_ID');
				$query   .= " AND SubEnterprise_ID=".$filterID;
			}

		}
		else
		{
		  //Show SubEnterprize When Admin Login
			$where = array(	
				'Enterprise_Status'       => 0,
			);
			$Enterprise                   = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where,'','Enterprise_Name');
			$content['EnterpriseDetails'] = $Enterprise;
			if($RequestMethod == 'POST')
			{
				$filterID = $this->input->post('Enterprise_ID');
				$query   .= " AND SubEnterprise_EnterpriseID=".$filterID;
			}
		}
		$result     = $this->Common_Model->executeQuery($query);	
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
	public function edit()
	{
		$UserID       = $this->session->userdata('loginData')['User_Id'];
		$UserName     = $this->session->userdata('loginData')['User_Username'];
		$id           = base64_decode($this->uri->segment(3));
		//edit subEnterprise detail
		$query = "SELECT gs.*, ge.Enterprise_Name,ge.Enterprise_ID FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID WHERE SubEnterprise_ID = $id ";
		$result                       = $this->Common_Model->executeQuery($query);
		$content['editSubEnterprise'] = $result[0];
		$RequestMethod                = $this->input->server('REQUEST_METHOD');
		if($RequestMethod == 'POST')
		{
			$EnterpriseID      = $this->input->post('Enterprise_ID');
			$subenterpriseLogo = $_FILES['logo']['name'];
			$SubEnterpriseName = $this->input->post('subenterprise');
			if(!empty($subenterpriseLogo))
			{
				$subEnterprisedata = array(
					'SubEnterprise_Name'         =>$this->input->post('subenterprise'),
					'SubEnterprise_EnterpriseID' =>$EnterpriseID,
					'SubEnterprise_UpdatedOn'    =>date('Y-m-d H:i:s'),
					'SubEnterprise_UpdatedBy'    =>$UserID,
					'SubEnterprise_Logo'         =>$subenterpriseLogo,
				);
			}
			else
			{	
				$subEnterprisedata = array(
					'SubEnterprise_Name'         =>$this->input->post('subenterprise'),
					'SubEnterprise_EnterpriseID' =>$EnterpriseID,
					'SubEnterprise_UpdatedOn'    =>date('Y-m-d H:i:s'),
					'SubEnterprise_UpdatedBy'    =>$UserID,
				);
			}
			$this->do_upload();
			//Update Game_Subenterprise details
			$where = array(
				'SubEnterprise_ID'      => $id,
				'SubEnterprise_Status'  => 0,
			);
			$result1 = $this->Common_Model->updateRecords('GAME_SUBENTERPRISE',$subEnterprisedata,$where);
			//print_r($result1);exit();
			$this->session->set_flashdata("tr_msg","Details Update Successfully" );
			redirect("SubEnterprise","refresh");
		}
		$content['subview']     = 'editSubEnterprise';
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
		$Enterprise = $this->Common_Model->fetchRecords('GAME_ENTERPRISE',$where);
		$content['EnterpriseDetails'] = $Enterprise;
		
		if($RequestMethod == 'POST')
		{
			if($this->session->userdata('loginData')['User_Role']==1)
			{
				$EnterpriseID = $this->session->userdata('loginData')['User_ParentId'];
				$subEnterprisedata = array(
					'SubEnterprise_Name'         => $this->input->post('subenterprise'),
					'SubEnterprise_EnterpriseID' => $EnterpriseID,
					'SubEnterprise_CreatedOn'    => date('Y-m-d H:i:s'),
					'SubEnterprise_CreatedBy'    => $UserID,
					'SubEnterprise_Logo'         => $_FILES['logo']['name'],
					'SubEnterprise_Owner'        => 2
				);	
			}
			else
			{
				$subEnterprisedata           = array(
					'SubEnterprise_Name'         => $this->input->post('subenterprise'),
					'SubEnterprise_EnterpriseID' => $this->input->post('Enterprise_ID'),
					'SubEnterprise_CreatedOn'    => date('Y-m-d H:i:s'),
					'SubEnterprise_CreatedBy'    => $UserID,
					'SubEnterprise_Logo'         => $_FILES['logo']['name'],
					'SubEnterprise_Owner'        => 1
				);
			}
			//print_r($subEnterprisedata);exit();
			$this->do_upload();
			if(!empty($this->input->post('subenterprise')))
			{
				$where  = array(
					'SubEnterprise_Name' =>	$this->input->post('subenterprise'),
				);
				$query = $this->Common_Model->fetchRecords('GAME_SUBENTERPRISE',$where);	
				if($query)
				{
					$this->session->set_flashdata("er_msg","SubEnterprise already registered" );
					redirect("SubEnterprise","refresh");
				}
				else
				{
					$this->Common_Model->insert('GAME_SUBENTERPRISE',$subEnterprisedata);
					$this->session->set_flashdata("tr_msg","Details Insert Successfully" );
					redirect("SubEnterprise","refresh");
				}
			}
		}
		$content['subview']     = 'addSubEnterprise';
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
		$result = $this->Common_Model->fetchRecords('GAME_SUBENTERprise',$where);
		$content['result'] = $result;
		$this->db->set('SubEnterprise_Status', 1);
		$this->db->where('SubEnterprise_ID', $id);
		$this->db->update('GAME_SUBENTERPRISE');
		redirect("SubEnterprise","refresh");
	}

//csv upload for subenterprise...
	public function subenterprisecsv()
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

        			$EnterpriseID              = $this->session->userdata('loginData')['User_ParentId'];
        			$SubEnterprise_CreatedBy   = $this->session->userdata('loginData')['User_Id'];

        			$sql = "LOAD DATA LOCAL INFILE '".$filename."'
        			INTO TABLE GAME_SUBENTERPRISE COLUMNS TERMINATED BY ',' IGNORE 1 LINES (SubEnterprise_Name,SubEnterprise_EnterpriseID,SubEnterprise_CreatedOn,SubEnterprise_CreatedBy) SET SubEnterprise_EnterpriseID = $EnterpriseID,SubEnterprise_CreatedOn = NOW(),SubEnterprise_CreatedBy = $SubEnterprise_CreatedBy";

        					/*	$sql = "LOAD DATA LOCAL INFILE '".$filename."'
        					INTO TABLE GAME_SUBENTERPRISE COLUMNS TERMINATED BY ',' IGNORE 1 LINES (SubEnterprise_Name)";*/
        					$query = $this->db->query($sql);

			//echo $this->db->last_query(); die;
        					/*	$this->db->last_query();*/
			/*	$result = $query->result();
			return $result;*/
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
