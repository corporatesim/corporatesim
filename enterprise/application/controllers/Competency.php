<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competency extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
			$this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"'.$this->router->fetch_class().'"</b> page');
			redirect('Dashboard');
		}
	}

	public function index()
	{
  	// adding competency master
    $competencyQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, ge.Enterprise_Name FROM GAME_ITEMS gi LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gi.Compt_Enterprise_ID WHERE gi.Compt_Delete = 0 ORDER BY gi.Compt_Name";

    $competency = $this->Common_Model->executeQuery($competencyQuery);

		// print_r($this->db->last_query()); exit();
		$content['competency'] = $competency;

    // fetching all Game Enterprise
    $enterprisewhere = array(
      'Enterprise_Status' => 0,
    );
    $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
    
    $content['enterpriseDetails'] = $enterpriseDetails;

		$content['subview']    = 'competency';
		$this->load->view('main_layout',$content);
	}

	public function viewCompetencyMapping()
	{
  	// viewing competency mapping with all the games, for superadmin
		$sql = "SELECT gcm.Cmap_Id, gcm.Cmap_ComptId, gi.Compt_Name, gcm.Cmap_GameId, gg.Game_Name, ge.Enterprise_Name FROM GAME_ITEMS_MAPPING gcm LEFT JOIN GAME_ITEMS gi ON gi.Compt_Id = gcm.Cmap_ComptId LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gcm.Cmap_Enterprise_ID LEFT JOIN GAME_GAME gg ON gg.Game_ID = gcm.Cmap_GameId WHERE gi.Compt_Delete = 0 ORDER BY gi.Compt_Name";

		$competencyMapping = $this->Common_Model->executeQuery($sql);
    //print_r($this->db->last_query()); exit();

		if(count($competencyMapping)<1)
		{
			$content['competencyMapping'] = $competencyMapping;
		}
		else
		{
			$competencyMappingArray = array();

			foreach ($competencyMapping as $competencyMappingRow)
			{
				if(array_key_exists($competencyMappingRow->Compt_Name, $competencyMappingArray))
				{
					// if competency name exist then appent the game value
					if(strpos($competencyMappingArray[$competencyMappingRow->Compt_Name][0], $competencyMappingRow->Game_Name) === FALSE)
					{
						// if game name already exist then don't append
						$competencyMappingArray[$competencyMappingRow->Compt_Name][0] .= ', '.$competencyMappingRow->Game_Name;
					}
				}
				else
				{
          $competencyMappingArray[$competencyMappingRow->Compt_Name] = array($competencyMappingRow->Game_Name, $competencyMappingRow->Cmap_ComptId, $competencyMappingRow->Enterprise_Name);
				}
			}
			
			$content['competencyMapping'] = $competencyMappingArray;
			// foreach ($competencyMappingArray as $competencyMappingArrayRow => $values)
			// {
			// 	echo 'KeyIs:- '.$competencyMappingArrayRow.' ValueIs:-'; print_r($values); echo '<br>';
			// }
			// prd($competencyMappingArray);
		}

		$content['subview']           = 'viewCompetencyMapping';
		$this->load->view('main_layout',$content);
	}

	public function addCompetencyMapping()
	{
  	// adding competency mapping with all the games, for superadmin
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == 'POST')
		{
			// prd($this->input->post());
			$this->addEditCompetencyMappingOnSubmit();
		}

    // fetching all Game Enterprise
    $enterprisewhere = array(
      'Enterprise_Status' => 0,
    );
    $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
		
		$content['enterpriseDetails'] = $enterpriseDetails;
		$content['subview']    = 'addCompetencyMapping';
		$this->load->view('main_layout',$content);
	}

	public function editCompetencyMapping($id=NULL)
	{
		$Cmap_ComptId = base64_decode($id);
		if(empty($Cmap_ComptId))
		{
			$this->session->set_flashdata('er_msg', 'No Item Selected To Edit');
			redirect('Competency/viewCompetencyMapping');
		}

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == 'POST')
		{
			// prd($this->input->post());
			$this->addEditCompetencyMappingOnSubmit();
		}

		//fetching Item Name and Description
    $competencyQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description FROM GAME_ITEMS gi WHERE gi.Compt_Delete = 0 AND gi.Compt_Id = $Cmap_ComptId";
    $competency = $this->Common_Model->executeQuery($competencyQuery);
    //print_r($this->db->last_query()); exit();
    $compt_Name        = $competency[0]->Compt_Name;
    $compt_Description = $competency[0]->Compt_Description;

    // fetching Item Game Enterprise
    $enterpriseQuery = "SELECT ge.Enterprise_ID, ge.Enterprise_Name FROM GAME_ENTERPRISE ge LEFT JOIN GAME_ITEMS gi ON gi.Compt_Enterprise_ID = ge.Enterprise_ID WHERE gi.Compt_Delete = 0 AND gi.Compt_Id = $Cmap_ComptId";
    $enterpriseDetails = $this->Common_Model->executeQuery($enterpriseQuery);
    //print_r($this->db->last_query()); exit();
    $enterprise_ID   = $enterpriseDetails[0]->Enterprise_ID;
    $enterprise_Name = $enterpriseDetails[0]->Enterprise_Name;

    //fetching all games that assign to this($enterprise_ID) enterprise 
    $gameSql = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Comments, gim.Cmap_Id FROM GAME_GAME gg LEFT JOIN GAME_ENTERPRISE_GAME geg ON geg.EG_GameID = gg.Game_ID  LEFT JOIN GAME_ITEMS_MAPPING gim ON gim.Cmap_GameId = gg.Game_ID AND gim.Cmap_ComptId = $Cmap_ComptId WHERE gg.Game_Delete = 0 AND geg.EG_EnterpriseID = $enterprise_ID GROUP BY gg.Game_ID ORDER BY gg.Game_Name";
    $games = $this->Common_Model->executeQuery($gameSql);
    //print_r($this->db->last_query()); exit();

		// fetching the list of all the components and subcomponents associated with the competency game mapping
		$whereMap = array(
			'Cmap_ComptId' => $Cmap_ComptId,
		);
		$mappedCompSubcomp = $this->Common_Model->fetchRecords('GAME_ITEMS_MAPPING', $whereMap, 'Cmap_SublinkId', '', '', '');
		$mappedCompSubcompArray = array();
		foreach ($mappedCompSubcomp as $mappedCompSubcompRow)
		{
			$mappedCompSubcompArray[] = $mappedCompSubcompRow->Cmap_SublinkId;
		}

		// pr($this->db->last_query()); prd($mappedCompSubcompArray);

    $content['mappedCompSubcomp'] = $mappedCompSubcompArray;
    $content['games']             = $games;
    $content['enterprise_ID']     = $enterprise_ID;
    $content['enterprise_Name']   = $enterprise_Name;
    $content['compt_Name']        = $compt_Name;
    $content['compt_Description'] = $compt_Description;
    $content['Cmap_ComptId']      = $Cmap_ComptId;
    $content['subview']           = 'editCompetencyMapping';
		$this->load->view('main_layout',$content);
	}

	private function addEditCompetencyMappingOnSubmit()
	{
		// array value may be of type = 11521_3_1 or 1757_3_0, i.e. sublinkId_compePerforType_compSubComp, 0-comp, 1-Subcomp
    $enterpriseID = $this->input->post('Cmap_Enterprise_ID');
    $gamesId      = $this->input->post('Cmap_GameId');
    $competencyId = $this->input->post('Cmap_ComptId');
		if(count($gamesId)<1)
		{
			$this->session->set_flashdata('er_msg', 'No Game Selected');
			redirect(current_url());
		}
		else
		{
			$insertArray = array();
			$flag        = TRUE;

			for($i=0; $i<count($gamesId); $i++)
			{
				if($this->input->post($gamesId[$i]))
				{
					// echo 'Game_comp-subComp_Found: '.$gamesId[$i].'<br><br>';
					$gameDataArray = $this->input->post($gamesId[$i]);
					for($j=0; $j<count($gameDataArray); $j++)
					{
						$flag          = FALSE;
						$tableColData  = explode('_', $gameDataArray[$j]);
						$insertArray[] = array(
              'Cmap_Enterprise_ID'   => $enterpriseID,
							'Cmap_ComptId'         => $competencyId,
							'Cmap_GameId'          => $gamesId[$i],
							'Cmap_SublinkId'       => $tableColData[0],
							'Cmap_PerformanceType' => $tableColData[1],
							'Cmap_CompSubComp'     => $tableColData[2],
						);
					}
				}
			}
			if($flag)
			{
				// this means user has selected games, but no checkboxes, for comp/subcomp
				$this->session->set_flashdata('er_msg', 'Please select at least one component or subcomponent');
				redirect(current_url());
			}
			$this->db->trans_start();
			$whereCompt = array(
				'Cmap_ComptId' => $competencyId,
			);
			$this->Common_Model->deleteRecords('GAME_ITEMS_MAPPING', $whereCompt);
			$this->Common_Model->batchInsert('GAME_ITEMS_MAPPING', $insertArray);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$this->session->set_flashdata('er_msg', 'Connection Error. While processing');
				// prd(log_message());
				redirect(current_url());
			}
			else
			{
				$this->session->set_flashdata('tr_msg', 'Item Mapping Done Successfully');
				redirect('Competency/viewCompetencyMapping');
			}
		}
	}

	public function mapCompetency()
	{
  	// map competency with enterprise/subenterprise games, which are allocated
		die('mapCompetency');
	}

	public function delete($id=NULL)
	{
		$Cmap_ComptId = base64_decode($id);
		if(empty($Cmap_ComptId))
		{
			$this->session->set_flashdata('er_msg', 'No Item Selected To Delete');
			redirect('Competency/viewCompetencyMapping');
		}
		else
		{
			$whereCompt = array(
				'Cmap_ComptId' => $Cmap_ComptId,
			);
			$del = $this->Common_Model->deleteRecords('GAME_ITEMS_MAPPING', $whereCompt);
			$this->session->set_flashdata('tr_msg', 'Item Mapping Deleted Successfully');
			redirect('Competency/viewCompetencyMapping');
		}
	}
}
