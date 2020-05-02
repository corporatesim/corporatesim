<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competence extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
		// 	$this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"'.$this->router->fetch_class().'"</b> page');
		// 	redirect('Dashboard');
		// }
	}

	public function index()
	{
		if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
			$this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
			redirect('Dashboard');
		}
		// adding competence master
		$competenceQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType, ge.Enterprise_Name FROM GAME_ITEMS gi LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gi.Compt_Enterprise_ID WHERE gi.Compt_Delete = 0 ORDER BY gi.Compt_Name";

		$competence = $this->Common_Model->executeQuery($competenceQuery);

		// print_r($this->db->last_query()); exit();
		$content['competence'] = $competence;

		// fetching all Game Enterprise
		$enterprisewhere = array(
			'Enterprise_Status' => 0,
		);
		$enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');

		$content['enterpriseDetails'] = $enterpriseDetails;

		$content['subview']    = 'competence';
		$this->load->view('main_layout', $content);
	}

	public function viewCompetenceMapping()
	{
		$content['subview'] = 'viewCompetenceMapping';

		// viewing competence mapping with all the games, for superadmin
		$sql = "SELECT gcm.Cmap_Id, gcm.Cmap_ComptId, gi.Compt_Name, gi.Compt_PerformanceType, gcm.Cmap_GameId, gg.Game_Name, ge.Enterprise_Name FROM GAME_ITEMS_MAPPING gcm LEFT JOIN GAME_ITEMS gi ON gi.Compt_Id = gcm.Cmap_ComptId LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gcm.Cmap_Enterprise_ID LEFT JOIN GAME_GAME gg ON gg.Game_ID = gcm.Cmap_GameId WHERE gi.Compt_Delete = 0 ";
		
		// if process owner is logged in then only show this page
		if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
			$sql .= " AND ge.Enterprise_ID=".$this->session->userdata('loginData')['User_Id'];
			// echo $sql; prd($this->session->userdata('loginData'));
		}
		
		$sql .= " ORDER BY gi.Compt_Name";
		$competenceMapping = $this->Common_Model->executeQuery($sql);
		//print_r($this->db->last_query()); exit();

		if (count($competenceMapping) < 1) {
			$content['competenceMapping'] = $competenceMapping;
		} else {
			$competenceMappingArray = array();

			foreach ($competenceMapping as $competenceMappingRow) {
				if (array_key_exists($competenceMappingRow->Compt_Name, $competenceMappingArray)) {
					// if competence name exist then appent the game value
					if (strpos($competenceMappingArray[$competenceMappingRow->Compt_Name][0], $competenceMappingRow->Game_Name) === FALSE) {
						// if game name already exist then don't append
						$competenceMappingArray[$competenceMappingRow->Compt_Name][0] .= '<br>' . $competenceMappingRow->Game_Name;
					}
				} else {
					$competenceMappingArray[$competenceMappingRow->Compt_Name] = array($competenceMappingRow->Game_Name, $competenceMappingRow->Cmap_ComptId, $competenceMappingRow->Enterprise_Name, $competenceMappingRow->Compt_PerformanceType);
				}
			}

			$content['competenceMapping'] = $competenceMappingArray;
			// foreach ($competenceMappingArray as $competenceMappingArrayRow => $values)
			// {
			// 	echo 'KeyIs:- '.$competenceMappingArrayRow.' ValueIs:-'; print_r($values); echo '<br>';
			// }
			// prd($competenceMappingArray);
		}
		$this->load->view('main_layout', $content);
	}

	public function addCompetenceMapping()
	{
		if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
			$this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
			redirect('Dashboard');
		}
		// adding competence mapping with all the games, for superadmin
		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if ($RequestMethod == 'POST') {
			// prd($this->input->post());
			$this->addEditCompetenceMappingOnSubmit();
		}

		// fetching all Game Enterprise
		$enterprisewhere = array(
			'Enterprise_Status' => 0,
		);
		$enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');

		$content['enterpriseDetails'] = $enterpriseDetails;
		$content['subview']    = 'addCompetenceMapping';
		$this->load->view('main_layout', $content);
	}

	public function editCompetenceMapping($id = NULL)
	{
		if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
			//$this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
			//redirect('Dashboard');
      $content['subview'] = 'viewCompetenceMappingProcessOwner';
		}
    else{
      $content['subview'] = 'editCompetenceMapping';
    }

		$Cmap_ComptId = base64_decode($id);
		if (empty($Cmap_ComptId)) {
			$this->session->set_flashdata('er_msg', 'No sub-factor Selected To Edit');
			redirect('Competence/viewCompetenceMapping');
		}

		$RequestMethod = $this->input->server('REQUEST_METHOD');

		if ($RequestMethod == 'POST') {
			// prd($this->input->post());
			$this->addEditCompetenceMappingOnSubmit();
		}

		//fetching Item Name and Description
		$competenceQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType FROM GAME_ITEMS gi WHERE gi.Compt_Delete = 0 AND gi.Compt_Id = $Cmap_ComptId";
		$competence = $this->Common_Model->executeQuery($competenceQuery);
		//print_r($this->db->last_query()); exit();
		$compt_Name            = $competence[0]->Compt_Name;
		$compt_Description     = $competence[0]->Compt_Description;
		$compt_PerformanceType = $competence[0]->Compt_PerformanceType;

		switch ($compt_PerformanceType) {
			case 4:
				$performanceType = 'Competence Readiness';
				break;
			case 5:
				$performanceType = 'Competence Application';
				break;
			default:
				$performanceType = 'Simulated Performance';
		}

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

		// fetching the list of all the components and subcomponents associated with the competence game mapping
		$whereMap = array(
			'Cmap_ComptId' => $Cmap_ComptId,
		);
		$mappedCompSubcomp = $this->Common_Model->fetchRecords('GAME_ITEMS_MAPPING', $whereMap, 'Cmap_SublinkId', '', '', '');
		$mappedCompSubcompArray = array();
		foreach ($mappedCompSubcomp as $mappedCompSubcompRow) {
			$mappedCompSubcompArray[] = $mappedCompSubcompRow->Cmap_SublinkId;
		}

		// pr($this->db->last_query()); prd($mappedCompSubcompArray);

		$content['mappedCompSubcomp'] = $mappedCompSubcompArray;
		$content['games']             = $games;
		$content['enterprise_ID']     = $enterprise_ID;
		$content['enterprise_Name']   = $enterprise_Name;
		$content['compt_Name']        = $compt_Name;
		$content['compt_Description'] = $compt_Description;
		$content['performanceType_ID'] = $compt_PerformanceType;
		$content['performanceType']   = $performanceType;
		$content['Cmap_ComptId']      = $Cmap_ComptId;
		
		$this->load->view('main_layout', $content);
	}

	private function addEditCompetenceMappingOnSubmit()
	{
		// array value may be of type = 11521_3_1 or 1757_3_0, i.e. sublinkId_compePerforType_compSubComp, 0-comp, 1-Subcomp
		$enterpriseID = $this->input->post('Cmap_Enterprise_ID');
		$gamesId      = $this->input->post('Cmap_GameId');
		$competenceId = $this->input->post('Cmap_ComptId');
		if (count($gamesId) < 1) {
			$this->session->set_flashdata('er_msg', 'No Game Selected');
			redirect(current_url());
		} else {
			$insertArray = array();
			$flag        = TRUE;

			for ($i = 0; $i < count($gamesId); $i++) {
				if ($this->input->post($gamesId[$i])) {
					// echo 'Game_comp-subComp_Found: '.$gamesId[$i].'<br><br>';
					$gameDataArray = $this->input->post($gamesId[$i]);
					for ($j = 0; $j < count($gameDataArray); $j++) {
						$flag          = FALSE;
						$tableColData  = explode('_', $gameDataArray[$j]);
						$insertArray[] = array(
							'Cmap_Enterprise_ID'   => $enterpriseID,
							'Cmap_ComptId'         => $competenceId,
							'Cmap_GameId'          => $gamesId[$i],
							'Cmap_SublinkId'       => $tableColData[0],
							'Cmap_PerformanceType' => $tableColData[1],
							'Cmap_CompSubComp'     => $tableColData[2],
						);
					}
				}
			}
			if ($flag) {
				// this means user has selected games, but no checkboxes, for comp/subcomp
				$this->session->set_flashdata('er_msg', 'Please select at least one component or subcomponent');
				redirect(current_url());
			}
			$this->db->trans_start();
			$whereCompt = array(
				'Cmap_ComptId' => $competenceId,
			);
			$this->Common_Model->deleteRecords('GAME_ITEMS_MAPPING', $whereCompt);
			$this->Common_Model->batchInsert('GAME_ITEMS_MAPPING', $insertArray);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE) {
				$this->session->set_flashdata('er_msg', 'Connection Error. While processing');
				// prd(log_message());
				redirect(current_url());
			} else {
				$this->session->set_flashdata('tr_msg', 'Mapping Done Successfully');
				redirect('Competence/viewCompetenceMapping');
			}
		}
	}

	public function competenceReport()
	{
    if($this->session->userdata('loginData')['User_Role'] == 'superadmin'){
  		// fetching all Enterprise list
  		$enterprisewhere = array(
  			'Enterprise_Status' => 0,
  		);
  		$enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
  		$content['enterpriseDetails'] = $enterpriseDetails;

      // fetching all formula list
      $formulawhere = array(
        //'Items_Formula_Enterprise_Id' => $enterprise_ID,
      );
      $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');
      $content['formulaDetails'] = $formulaDetails;
      
      $content['usersDetails']      = '';
  	}
    else if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
      $enterprise_ID = $this->session->userdata('loginData')['User_Id'];

      $enterprisewhere = array(
        'Enterprise_ID'     => $enterprise_ID,
        'Enterprise_Status' => 0,
      );
      $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprisewhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
      $content['enterpriseDetails'] = $enterpriseDetails;

      // fetching all formula list for loged in enterprise
      $formulawhere = array(
        'Items_Formula_Enterprise_Id' => $enterprise_ID,
      );
      $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulawhere, 'Items_Formula_Id, Items_Formula_Title', 'Items_Formula_Title');
      $content['formulaDetails'] = $formulaDetails;

      //fetching all Users assigned to this enterprise
      $enterpriseUserQuery ="SELECT gu.User_id, CONCAT(gu.User_fname, ' ', gu.User_lname) AS User_fullName, gu.User_username FROM GAME_SITE_USERS gu WHERE gu.User_Role = 1 AND gu.User_Delete = 0 AND gu.User_ParentId = $enterprise_ID ORDER BY gu.User_fname, gu.User_lname ASC";
      $enterpriseUserList = $this->Common_Model->executeQuery($enterpriseUserQuery);
      //print_r($this->db->last_query()); exit();
      $content['usersDetails'] = $enterpriseUserList;
    }
    
    $content['subview']    = 'competenceReport';
    $this->load->view('main_layout', $content);
  }

  public function itemFormula()
  {
    $content['subview'] = 'itemFormula';

    // viewing item formula with all the items
    $sql = "SELECT gif.Items_Formula_Id, gif.Items_Formula_Title, gif.Items_Formula_String, ge.Enterprise_Name FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id";
    
    // if process owner is logged in then only show this page
    if($this->session->userdata('loginData')['User_Role'] != 'superadmin'){
      $sql .= " WHERE gif.Items_Formula_Enterprise_Id=".$this->session->userdata('loginData')['User_Id'];
    }
    
    $sql .= " ORDER BY gif.Items_Formula_Title";
    $itemFormulaList = $this->Common_Model->executeQuery($sql);
    // echo $sql; prd($itemFormulaList); exit();

    if(count($itemFormulaList) > 0){
      $itemFormulaListArray = array();

      foreach ($itemFormulaList as $itemFormulaListRow){
        $itemFormulaListArray[$itemFormulaListRow->Items_Formula_Id] = array($itemFormulaListRow->Items_Formula_Id, $itemFormulaListRow->Items_Formula_Title, $itemFormulaListRow->Items_Formula_String, $itemFormulaListRow->Enterprise_Name);

        $content['itemFormulaList'] = $itemFormulaListArray;
      }
    }
    else{
      $content['itemFormulaList'] = '';
    }
    
    $this->load->view('main_layout', $content);
  }

  public function addItemFormula()
  {
    // fetching all Game Enterprise
    $enterpriseWhere = array(
      'Enterprise_Status' => 0,
    );
    $enterpriseDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterpriseWhere, 'Enterprise_ID, Enterprise_Name', 'Enterprise_Name');
    $content['enterpriseDetails'] = $enterpriseDetails;

    $operatorsWhere = array(
      'Game_Operators_Status' => 0,
    );
    $operatorsDetails = $this->Common_Model->fetchRecords('GAME_OPERATORS', $operatorsWhere, 'Game_Operators_Id, Game_Operators_Value, Game_Operators_String', 'Game_Operators_Id');
    $content['operatorsDetails'] = $operatorsDetails;

    $content['subview']    = 'addItemFormula';
    $this->load->view('main_layout', $content);
  }

  public function editItemFormula($id = NULL)
  {
    $items_formula_Id = base64_decode($id);

    // fetching item formula
    $sql = "SELECT gif.Items_Formula_Id, gif.Items_Formula_Title, gif.Items_Formula_String, gif.Items_Formula_Expression, ge.Enterprise_ID, ge.Enterprise_Name FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id WHERE gif.Items_Formula_Id = $items_formula_Id";
    $itemFormulaList = $this->Common_Model->executeQuery($sql);
    // echo $sql; prd($itemFormulaList); exit();
    $content['itemFormulaList'] = $itemFormulaList;

    $operatorsWhere = array(
      'Game_Operators_Status' => 0,
    );
    $operatorsDetails = $this->Common_Model->fetchRecords('GAME_OPERATORS', $operatorsWhere, 'Game_Operators_Id, Game_Operators_Value, Game_Operators_String', 'Game_Operators_Id');
    $content['operatorsDetails'] = $operatorsDetails;

    $content['subview'] = 'editItemFormula';
    $this->load->view('main_layout', $content);
  }

  public function deleteFormula($id=NULL, $redirect=NULL)
  {
    $items_formula_Id = base64_decode($id);
    if(empty($items_formula_Id)){
      $this->session->set_flashdata('er_msg', 'No Formula Selected To Delete');
      // redirect('Competence/itemFormula');
      redirect("Competence/".$redirect,"refresh");
    } 
    else{
      $whereCompt = array(
        'Items_Formula_Id' => $items_formula_Id,
      );
      $del = $this->Common_Model->deleteRecords('GAME_ITEMS_FORMULA', $whereCompt);
      $this->session->set_flashdata('tr_msg', 'Formula Deleted Successfully');
      // redirect('Competence/itemFormula');
      redirect("Competence/".$redirect,"refresh");
    }
  }

  public function mapCompetence()
  {
    // map competence with enterprise/subenterprise games, which are allocated
    die('mapCompetence');
  }

	public function deleteMapping($id=NULL, $redirect=NULL)
	{
		$Cmap_ComptId = base64_decode($id);
		if (empty($Cmap_ComptId)) {
			$this->session->set_flashdata('er_msg', 'No Mapping Selected To Delete');
			//redirect('Competence/viewCompetenceMapping');
      redirect("Competence/".$redirect,"refresh");
		} else {
      //firstly check that this mapping in not used in any formula
      //checking mapping id $Cmap_ComptId inside JSON
      $query = "SELECT gif.Items_Formula_Id, gif.Items_Formula_Title FROM GAME_ITEMS_FORMULA gif WHERE gif.Items_Formula_Expression LIKE '%__$Cmap_ComptId%'";
      $queryResult = $this->Common_Model->executeQuery($query);
      //print_r($query); print_r(count($queryResult)); exit();

      if(count($queryResult) > 0){
        //if any formula found with this mapping
        //then showing an error with all formula name
        $formula_Name = '';
        for($i=0; $i<count($queryResult); $i++){
          if($i == count($queryResult)-1){
            $formula_Name .= $queryResult[$i]->Items_Formula_Title;
          }
          else{
            $formula_Name .= $queryResult[$i]->Items_Formula_Title.', ';
          }
        }
        //print_r($formula_Name); exit();
        $this->session->set_flashdata('er_msg', 'Mapping Can not be deleted beacause it is used in formula <br />'.$formula_Name);
      }
      else{
        //else not found any formula with this mapping
        //then delete mapping
  			$whereCompt = array(
  				'Cmap_ComptId' => $Cmap_ComptId,
  			);
  			$del = $this->Common_Model->deleteRecords('GAME_ITEMS_MAPPING', $whereCompt);
  			$this->session->set_flashdata('tr_msg', 'Mapping Deleted Successfully');
      }
			//redirect('Competence/viewCompetenceMapping');
      redirect("Competence/".$redirect,"refresh");
		}
	}

  // public function deleteMaster($id=NULL)
  // {
  //   $items_Id = base64_decode($id);
  //   if(empty($items_Id)){
  //     $this->session->set_flashdata('er_msg', 'No Master Selected To Delete');
  //     redirect('Competence');
  //   } 
  //   else{
  //     //before deleting item check item is not mapped with game
  //     $checkWhere = array(
  //       'Cmap_ComptId' => $items_Id,
  //     );
  //     $checkDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_MAPPING', $checkWhere, 'Cmap_Id');
  //     prd($checkDetails); exit();

  //     if($checkDetails[0]->Cmap_Id > 0){
  //       //if present any record then show an alert msg
  //       $this->session->set_flashdata('er_msg', 'Master Mapped with Card');
  //     }
  //     else{
  //       $data = array(
  //         'Compt_Delete' => 1,
  //       );
  //       $where= array(
  //         'Compt_Id' => $items_Id,
  //       );
  //       $retData = $this->Common_Model->softDelete('GAME_ITEMS', $data, $where);
  //       // $del = $this->Common_Model->deleteRecords('GAME_ITEMS', $where);
  //       $this->session->set_flashdata('tr_msg', 'Master Deleted Successfully');
  //     }
  //     redirect('Competence');
  //   }
  // }

}
