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
		$where = array(
			'Compt_Delete' => 0,
		);
		$competency = $this->Common_Model->fetchRecords('GAME_COMPETENCY', $where, 'Compt_Id, Compt_Name, Compt_Description', 'Compt_Name');
		
		$content['competency'] = $competency;
		$content['subview']    = 'competency';
		$this->load->view('main_layout',$content);
	}

	public function viewCompetencyMapping()
	{
  	// viewing competency mapping with all the games, for superadmin
		$sql = "SELECT gcm.Cmap_Id, gcm.Cmap_ComptId, gc.Compt_Name, gcm.Cmap_GameId, gg.Game_Name FROM GAME_COMPETENCY_MAPPING gcm LEFT JOIN GAME_COMPETENCY gc ON gc.Compt_Id = gcm.Cmap_ComptId LEFT JOIN GAME_GAME gg ON gg.Game_ID = gcm.Cmap_GameId ORDER BY gc.Compt_Name";

		$competencyMapping = $this->Common_Model->executeQuery($sql);

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
					// $competencyMappingArray[$competencyMappingRow->Compt_Name] = $competencyMappingRow->Game_Name;
					// $competencyMappingArray[$competencyMappingRow->Compt_Name.'_id'] = $competencyMappingRow->Cmap_ComptId;
					$competencyMappingArray[$competencyMappingRow->Compt_Name] = array($competencyMappingRow->Game_Name, $competencyMappingRow->Cmap_ComptId);
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

		$where = array(
			'Compt_Delete' => 0,
		);
		$competency = $this->Common_Model->fetchRecords('GAME_COMPETENCY', $where, 'Compt_Id, Compt_Name, Compt_Description', 'Compt_Name');

		$whereGame = array(
			'Game_Delete' => 0,
		);
		$games = $this->Common_Model->fetchRecords('GAME_GAME', $whereGame, 'Game_ID, Game_Name, Game_Comments', 'Game_Name');
		
		$content['competency'] = $competency;
		$content['games']      = $games;
		$content['subview']    = 'addCompetencyMapping';
		$this->load->view('main_layout',$content);
	}

	public function editCompetencyMapping($id=NULL)
	{
		$Cmap_ComptId = base64_decode($id);
		if(empty($Cmap_ComptId))
		{
			$this->session->set_flashdata('er_msg', 'No Competency Selected To Edit');
			redirect('Competency/viewCompetencyMapping');
		}

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if($RequestMethod == 'POST')
		{
			// prd($this->input->post());
			$this->addEditCompetencyMappingOnSubmit();
		}

		// fetching the list of all competency
		$where = array(
			'Compt_Delete' => 0,
		);
		$competency = $this->Common_Model->fetchRecords('GAME_COMPETENCY', $where, 'Compt_Id, Compt_Name, Compt_Description', 'Compt_Name');

		// fetching the list of all the games, with mapping Id, if cmap_id is not null, then mapped
		$gameSql = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Comments, gcm.Cmap_Id FROM GAME_GAME gg LEFT JOIN GAME_COMPETENCY_MAPPING gcm ON gcm.Cmap_GameId=gg.Game_ID AND gcm.Cmap_ComptId=".$Cmap_ComptId." WHERE Game_Delete=0 GROUP BY gg.Game_ID ORDER BY gg.Game_Name";
		$games = $this->Common_Model->executeQuery($gameSql);
		// fetching the list of all the components and subcomponents associated with the competency game mapping
		$whereMap = array(
			'Cmap_ComptId' => $Cmap_ComptId,
		);
		$mappedCompSubcomp = $this->Common_Model->fetchRecords('GAME_COMPETENCY_MAPPING', $whereMap, 'Cmap_SublinkId', '', '', '');
		$mappedCompSubcompArray = array();
		foreach ($mappedCompSubcomp as $mappedCompSubcompRow)
		{
			$mappedCompSubcompArray[] = $mappedCompSubcompRow->Cmap_SublinkId;
		}

		// pr($this->db->last_query()); prd($mappedCompSubcompArray);

		$content['mappedCompSubcomp'] = $mappedCompSubcompArray;
		$content['games']             = $games;
		$content['competency']        = $competency;
		$content['Cmap_ComptId']      = $Cmap_ComptId;
		$content['subview']           = 'editCompetencyMapping';
		$this->load->view('main_layout',$content);
	}

	private function addEditCompetencyMappingOnSubmit()
	{
		// array value may be of type = 11521_3_1 or 1757_3_0, i.e. sublinkId_compePerforType_compSubComp, 0-comp, 1-Subcomp
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
			$this->Common_Model->deleteRecords('GAME_COMPETENCY_MAPPING', $whereCompt);
			$this->Common_Model->batchInsert('GAME_COMPETENCY_MAPPING', $insertArray);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				$this->session->set_flashdata('er_msg', 'Connection Error. While processing');
				// prd(log_message());
				redirect(current_url());
			}
			else
			{
				$this->session->set_flashdata('tr_msg', 'Competency Mapping Done Successfully');
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
			$this->session->set_flashdata('er_msg', 'No Competency Selected To Delete');
			redirect('Competency/viewCompetencyMapping');
		}
		else
		{
			$whereCompt = array(
				'Cmap_ComptId' => $Cmap_ComptId,
			);
			$del = $this->Common_Model->deleteRecords('GAME_COMPETENCY_MAPPING', $whereCompt);
			$this->session->set_flashdata('tr_msg', 'Competency Mapping Deleted Successfully');
			redirect('Competency/viewCompetencyMapping');
		}
	}
}
