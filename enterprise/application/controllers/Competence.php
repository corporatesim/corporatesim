<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Competence extends MY_Controller {
	public function __construct() {
		parent::__construct();
	}

	public function index() {
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

  public function itemReportCreation() {
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    $content['subview']    = 'itemReportCreation';
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

  public function itemFormula() {
    // viewing item formula with all the items
    $sql = "SELECT gif.Items_Formula_Id, gif.Items_Formula_Title, gif.Items_Formula_String, ge.Enterprise_Name, ge.Enterprise_ID FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id";
    
    // if process owner is logged in then only show this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $sql .= " WHERE gif.Items_Formula_Enterprise_Id=".$this->session->userdata('loginData')['User_Id'];
    }
    
    $sql .= " ORDER BY gif.Items_Formula_Title";
    $itemFormulaList = $this->Common_Model->executeQuery($sql);
    // echo $sql; prd($itemFormulaList); exit();

    if (count($itemFormulaList) > 0) {
      $itemFormulaListArray = array();

      foreach ($itemFormulaList as $itemFormulaListRow) {
        $itemFormulaListArray[$itemFormulaListRow->Items_Formula_Id] = array($itemFormulaListRow->Items_Formula_Id, $itemFormulaListRow->Items_Formula_Title, $itemFormulaListRow->Items_Formula_String, $itemFormulaListRow->Enterprise_Name, $itemFormulaListRow->Enterprise_ID);

        $content['itemFormulaList'] = $itemFormulaListArray;
      }
    }
    else {
      $content['itemFormulaList'] = [];
    }

    $content['subview'] = 'itemFormula';
    $this->load->view('main_layout', $content);
  }

  public function addItemFormula() {
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

  public function editItemFormula($id = NULL) {
    $items_formula_Id = base64_decode($id);

    // fetching item formula
    $sql = "SELECT gif.Items_Formula_Id, gif.Items_Formula_Title, gif.Items_Formula_String, gif.Items_Formula_Expression, gif.Items_Formula_Report_Name_Definition, ge.Enterprise_ID, ge.Enterprise_Name FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id WHERE gif.Items_Formula_Id = $items_formula_Id";
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

  public function itemConditionText($ID=NULL) {
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    // $ID will be ItemID
    //$ID = base64_decode($ID);

    // Query to fetch enterprize name, factor type, subfactor type
    // 4=Competence Readiness, 5=Competence Application, 3=Simulated Performance 
    $queryDetails = "SELECT gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType, ge.Enterprise_Name FROM GAME_ITEMS gi LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gi.Compt_Enterprise_ID WHERE gi.Compt_Id = $ID";
    $itemDetails = $this->Common_Model->executeQuery($queryDetails);
    // print_r($queryDetails); print_r($itemDetails); exit();
    $content['itemDetails'] = $itemDetails;

    // Query to fetch all item conditions text
    $query = "SELECT ic.IC_Min_Value, ic.IC_Max_Value, ic.IC_Text, ic.IC_Score_Status FROM GAME_ITEM_CONDITIONS ic WHERE ic.IC_Item_ID = $ID ORDER BY ic.IC_ID ASC";
    $itemConditions = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r($itemConditions); exit();
    $content['itemConditions'] = $itemConditions;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array('IC_Item_ID' => $ID); //Array ( [IC_Item_ID] => 21 )
      $itemMinValue = $this->input->post('minValue'); //array type
      $itemMaxValue = $this->input->post('maxValue'); //array type
      $itemDetails  = $this->input->post('details');  //array type

      //making array to hold all inserting Data
      $insertArray = array();

      for ($i=0; $i<count($itemMinValue); $i++) {
        $array = array(
          'IC_Item_ID'      => $ID,
          'IC_Min_Value'    => $itemMinValue[$i],
          'IC_Max_Value'    => $itemMaxValue[$i],
          'IC_Text'         => $itemDetails[$i],
          'IC_Score_Status' => $this->input->post('scoreStatus'), // 0=Show, 1=Hide
          'IC_Created_By'   => $this->session->userdata('loginData')['User_Id']
        );
        array_push($insertArray, $array);
      }
      //print_r($insertArray); exit();
      //Array ( [0] => Array ( [IC_Item_ID] => 21 [IC_Min_Value] => 1 [IC_Max_Value] => 10 [IC_Text] =>AAA [IC_Created_By] => 1 ) [1] => Array ( [IC_Item_ID] => 21 [IC_Min_Value] => 11 [IC_Max_Value] => 20 [IC_Text] => BBB [IC_Created_By] => 1 ) )

      $result = $this->Common_Model->deleteInsert('GAME_ITEM_CONDITIONS', $where, $insertArray);
      //print_r($result); exit();
      redirect('Competence');
    }

    $content['subview'] = 'itemConditionText';
    $this->load->view('main_layout',$content);
  }

  public function itemReportExecutiveSummary($ID=NULL, $EntID=NULL) {
    // IR_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IR_Condition_Type (1-> Average, 2-> Individual)

    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }
    
    // setting titl for the page
    // $content['reportType'] = 'Executive Summary for Average';
    $content['reportType'] = 'Executive Summary 1';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    $formulaWhere   = array('Items_Formula_Id' => $ID);
    $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Id, Items_Formula_Title, Items_Formula_String', '');
    // print_r($formulaDetails); print_r($formulaDetails[0]->Items_Formula_Title); exit();
    $content['formulaDetails'] = $formulaDetails;

    $enterprizeWhere   = array('Enterprise_ID' => $EntID);
    $enterprizeDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprizeWhere, 'Enterprise_ID, Enterprise_Name', '');
    // print_r($enterprizeDetails); print_r($enterprizeDetails[0]->Enterprise_Name); exit();
    $content['enterprizeDetails'] = $enterprizeDetails;

    // IR_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IR_Condition_Type (1-> Average, 2-> Individual)
    $content['conditionType'] = 1;
    // selecting WHERE IR_Type_Choice is 1-> EXECUTIVE SUMMARY and IR_Condition_Type is 1-> Average
    // Query to fetch all item report text
    $query = "SELECT ir.IR_Min_Value, ir.IR_Max_Value, ir.IR_CR_Min_Average_Value, ir.IR_CR_Max_Average_Value, ir.IR_CA_Min_Average_Value, ir.IR_CA_Max_Average_Value, ir.IR_SP_Min_Average_Value, ir.IR_SP_Max_Average_Value, ir.IR_Text FROM GAME_ITEM_REPORT ir WHERE ir.IR_Items_Formula_Id = $ID AND ir.IR_Type_Choice = 1 AND ir.IR_Condition_Type = 1 AND ir.IR_Formula_Enterprize_ID = $EntID ORDER BY ir.IR_ID ASC";
    $reportDetails = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r($reportDetails); exit();
    $content['reportDetails'] = $reportDetails;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'IR_Formula_Enterprize_ID' => $EntID,
        'IR_Items_Formula_Id'      => $ID,
        'IR_Type_Choice'           => 1, // 1-> EXECUTIVE SUMMARY
        'IR_Condition_Type'        => 1, // 1-> Average
      );

      $itemReportMinValue = $this->input->post('minValue'); //array type
      $itemReportMaxValue = $this->input->post('maxValue'); //array type
      $itemReportMinValueCRAverage = $this->input->post('minValueCRAverage'); //array type
      $itemReportMaxValueCRAverage = $this->input->post('maxValueCRAverage'); //array type
      $itemReportMinValueCAAverage = $this->input->post('minValueCAAverage'); //array type
      $itemReportMaxValueCAAverage = $this->input->post('maxValueCAAverage'); //array type
      $itemReportMinValueSPAverage = $this->input->post('minValueSPAverage'); //array type
      $itemReportMaxValueSPAverage = $this->input->post('maxValueSPAverage'); //array type
      $itemReportDetails  = $this->input->post('details');  //array type

      //making array to hold all inserting Data
      $insertArray = array();

      for ($i=0; $i<count($itemReportMinValue); $i++) {
        $array = array(
          'IR_Formula_Enterprize_ID' => $EntID,
          'IR_Items_Formula_Id'      => $ID,
          'IR_Type_Choice'           => 1, // 1-> EXECUTIVE SUMMARY
          'IR_Condition_Type'        => 1, // 1-> Average
          'IR_Min_Value'             => $itemReportMinValue[$i] ? $itemReportMinValue[$i] : 0,
          'IR_Max_Value'             => $itemReportMaxValue[$i] ? $itemReportMaxValue[$i] : 0,
          'IR_CR_Min_Average_Value'  => $itemReportMinValueCRAverage[$i] ? $itemReportMinValueCRAverage[$i] : 0,
          'IR_CR_Max_Average_Value'  => $itemReportMaxValueCRAverage[$i] ? $itemReportMaxValueCRAverage[$i] : 0,
          'IR_CA_Min_Average_Value'  => $itemReportMinValueCAAverage[$i] ? $itemReportMinValueCAAverage[$i] : 0,
          'IR_CA_Max_Average_Value'  => $itemReportMaxValueCAAverage[$i] ? $itemReportMaxValueCAAverage[$i] : 0,
          'IR_SP_Min_Average_Value'  => $itemReportMinValueSPAverage[$i] ? $itemReportMinValueSPAverage[$i] : 0,
          'IR_SP_Max_Average_Value'  => $itemReportMaxValueSPAverage[$i] ? $itemReportMaxValueSPAverage[$i] : 0,
          'IR_Text'                  => $itemReportDetails[$i],
          'IR_Created_By'            => $this->session->userdata('loginData')['User_Id'],
          'IR_Created_On'            => date('Y-m-d H:i:s'),
        );
        array_push($insertArray, $array);
      }
      //print_r($insertArray); exit();

      $result = $this->Common_Model->deleteInsert('GAME_ITEM_REPORT', $where, $insertArray);
      //print_r($result); exit();
      redirect('Competence/itemFormula');
    }

    $content['subview'] = 'itemReport';
    $this->load->view('main_layout', $content);
  }

  public function itemReportConclusionSection($ID=NULL, $EntID=NULL) {
    // IR_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IR_Condition_Type (1-> Average, 2-> Individual)

    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }
    
    // setting titl for the page
    // $content['reportType'] = 'Conclusion Section for Average';
    $content['reportType'] = 'Conclusion 2';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    $formulaWhere   = array('Items_Formula_Id' => $ID);
    $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Id, Items_Formula_Title, Items_Formula_String', '');
    // print_r($formulaDetails); print_r($formulaDetails[0]->Items_Formula_Title); exit();
    $content['formulaDetails'] = $formulaDetails;

    $enterprizeWhere   = array('Enterprise_ID' => $EntID);
    $enterprizeDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprizeWhere, 'Enterprise_ID, Enterprise_Name', '');
    // print_r($enterprizeDetails); print_r($enterprizeDetails[0]->Enterprise_Name); exit();
    $content['enterprizeDetails'] = $enterprizeDetails;

    // IR_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IR_Condition_Type (1-> Average, 2-> Individual)
    $content['conditionType'] = 1;
    // selecting WHERE IR_Type_Choice is 2-> CONCLUSION SECTION and IR_Condition_Type is 1-> Average
    // Query to fetch all item report text
    $query = "SELECT ir.IR_Min_Value, ir.IR_Max_Value, ir.IR_CR_Min_Average_Value, ir.IR_CR_Max_Average_Value, ir.IR_CA_Min_Average_Value, ir.IR_CA_Max_Average_Value, ir.IR_SP_Min_Average_Value, ir.IR_SP_Max_Average_Value, ir.IR_Text FROM GAME_ITEM_REPORT ir WHERE ir.IR_Items_Formula_Id = $ID AND ir.IR_Type_Choice = 2 AND ir.IR_Condition_Type = 1 AND ir.IR_Formula_Enterprize_ID = $EntID ORDER BY ir.IR_ID ASC";
    $reportDetails = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r($reportDetails); exit();
    $content['reportDetails'] = $reportDetails;

    // if form submit
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'IR_Formula_Enterprize_ID' => $EntID,
        'IR_Items_Formula_Id'      => $ID,
        'IR_Type_Choice'           => 2, // 2-> CONCLUSION SECTION
        'IR_Condition_Type'        => 1, // 1-> Average
      );

      $itemReportMinValue = $this->input->post('minValue'); //array type
      $itemReportMaxValue = $this->input->post('maxValue'); //array type
      $itemReportMinValueCRAverage = $this->input->post('minValueCRAverage'); //array type
      $itemReportMaxValueCRAverage = $this->input->post('maxValueCRAverage'); //array type
      $itemReportMinValueCAAverage = $this->input->post('minValueCAAverage'); //array type
      $itemReportMaxValueCAAverage = $this->input->post('maxValueCAAverage'); //array type
      $itemReportMinValueSPAverage = $this->input->post('minValueSPAverage'); //array type
      $itemReportMaxValueSPAverage = $this->input->post('maxValueSPAverage'); //array type
      $itemReportDetails  = $this->input->post('details');  //array type

      //making array to hold all inserting Data
      $insertArray = array();

      for ($i=0; $i<count($itemReportMinValue); $i++) {
        $array = array(
          'IR_Formula_Enterprize_ID' => $EntID,
          'IR_Items_Formula_Id'      => $ID,
          'IR_Type_Choice'           => 2, // 2-> CONCLUSION SECTION
          'IR_Condition_Type'        => 1, // 1-> Average
          'IR_Min_Value'             => $itemReportMinValue[$i] ? $itemReportMinValue[$i] : 0,
          'IR_Max_Value'             => $itemReportMaxValue[$i] ? $itemReportMaxValue[$i] : 0,
          'IR_CR_Min_Average_Value'  => $itemReportMinValueCRAverage[$i] ? $itemReportMinValueCRAverage[$i] : 0,
          'IR_CR_Max_Average_Value'  => $itemReportMaxValueCRAverage[$i] ? $itemReportMaxValueCRAverage[$i] : 0,
          'IR_CA_Min_Average_Value'  => $itemReportMinValueCAAverage[$i] ? $itemReportMinValueCAAverage[$i] : 0,
          'IR_CA_Max_Average_Value'  => $itemReportMaxValueCAAverage[$i] ? $itemReportMaxValueCAAverage[$i] : 0,
          'IR_SP_Min_Average_Value'  => $itemReportMinValueSPAverage[$i] ? $itemReportMinValueSPAverage[$i] : 0,
          'IR_SP_Max_Average_Value'  => $itemReportMaxValueSPAverage[$i] ? $itemReportMaxValueSPAverage[$i] : 0,
          'IR_Text'                  => $itemReportDetails[$i],
          'IR_Created_By'            => $this->session->userdata('loginData')['User_Id'],
          'IR_Created_On'            => date('Y-m-d H:i:s'),
        );
        array_push($insertArray, $array);
      }
      //print_r($insertArray); exit();
      $result = $this->Common_Model->deleteInsert('GAME_ITEM_REPORT', $where, $insertArray);

      //print_r($result); exit();
      redirect('Competence/itemFormula');
    } // end of form submit

    $content['subview']    = 'itemReport';
    $this->load->view('main_layout', $content);
  }

  public function itemReportESI($ID=NULL, $EntID=NULL) {
    // IRI_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IRI_Condition_Type (1-> Average, 2-> Individual)

    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }
    
    // setting titl for the page
    // $content['reportType'] = 'Executive Summary for Individual';
    $content['reportType'] = 'Executive Summary 2';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    $formulaWhere   = array('Items_Formula_Id' => $ID);
    $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Id, Items_Formula_Title, Items_Formula_String, Items_Formula_Expression, Items_Formula_Json', '');
    // print_r($formulaDetails); print_r($formulaDetails[0]->Items_Formula_Title); exit();
    $content['formulaDetails'] = $formulaDetails;

    // decoding JSON
    $formulaJSON = json_decode($formulaDetails[0]->Items_Formula_Json, true);
    //print_r($formulaJSON); exit();
    $usedItemArray = []; //storing used Item ID in array

    $keys   = array_keys($formulaJSON);
    //$values = array_values($formulaJSON); 
    for ($x=0; $x<count($formulaJSON); $x++) {
      $usedItemArray[$x] = $keys[$x];
    }
    //print_r($usedItemArray); exit();

    // converting array to string for query
    $usedItem = implode(',', $usedItemArray);

    // Query to fetch all items used in selected formula
    $itemQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType FROM GAME_ITEMS gi WHERE gi.Compt_Id IN ($usedItem)  AND gi.Compt_Enterprise_ID = $EntID ORDER BY gi.Compt_Id ASC";
    $itemUsedDetails = $this->Common_Model->executeQuery($itemQuery);
    //print_r($itemUsedDetails); exit();
    // setting data for view
    $content['itemUsedDetails'] = $itemUsedDetails;

    $enterprizeWhere   = array('Enterprise_ID' => $EntID);
    $enterprizeDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprizeWhere, 'Enterprise_ID, Enterprise_Name', '');
    // print_r($enterprizeDetails); print_r($enterprizeDetails[0]->Enterprise_Name); exit();
    $content['enterprizeDetails'] = $enterprizeDetails;

    // IRI_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IRI_Condition_Type (1-> Average, 2-> Individual)
    $content['conditionType'] = 2;
    // selecting WHERE IRI_Type_Choice is 1-> EXECUTIVE SUMMARY and IRI_Condition_Type is 2-> Individual
    // Query to fetch all item report text
    $query = "SELECT iri.IRI_ID, iri.IRI_Text, iri.IRI_xAxis_Item_Id, iri.IRI_xAxis_Min_Value, iri.IRI_xAxis_Max_Value, iri.IRI_yAxis_Item_Id, iri.IRI_yAxis_Min_Value, iri.IRI_yAxis_Max_Value FROM GAME_ITEM_REPORT_INDIVIDUAL iri WHERE iri.IRI_Items_Formula_Id = $ID AND iri.IRI_Type_Choice = 1 AND iri.IRI_Condition_Type = 2 AND iri.IRI_Formula_Enterprize_ID = $EntID ORDER BY iri.IRI_ID ASC";
    $reportDetails = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r($reportDetails); exit();
    $content['reportDetails'] = $reportDetails;

    // if form submit
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'IRI_Formula_Enterprize_ID' => $EntID,
        'IRI_Items_Formula_Id'      => $ID,
        'IRI_Type_Choice'           => 1, // 1-> EXECUTIVE SUMMARY
        'IRI_Condition_Type'        => 2, // 2-> Individual
      );

      // =========================================
      // for X-Axis
      $usedItemsxAxis = $this->input->post('usedItemsxAxis'); //array type but unseralised key
      $minValuexAxis  = $this->input->post('minValuexAxis'); //array type
      $maxValuexAxis  = $this->input->post('maxValuexAxis'); //array type
      // for Y-Axis
      $usedItemsyAxis = $this->input->post('usedItemsyAxis'); //array type but unseralised key
      $minValueyAxis  = $this->input->post('minValueyAxis'); //array type
      $maxValueyAxis  = $this->input->post('maxValueyAxis'); //array type

      $details        = $this->input->post('details');  //array type

      // making new array to hold used items in it with serialised key for x-axis
      $usedItemsxAxisArray = array();
      $foreachCountxAxis = 0;
      foreach ($usedItemsxAxis as $key => $value) {
        // $usedItemsxAxisArray[$foreachCountxAxis] =  $usedItemsxAxis[$key];
        $usedItemsxAxisArray[$foreachCountxAxis] =  $value;
        $foreachCountxAxis++;
      }
      // print_r($usedItemsxAxisArray); exit();

      // making new array to hold used items in it with serialised key for y-axis
      $usedItemsyAxisArray = array();
      $foreachCountyAxis = 0;
      foreach ($usedItemsyAxis as $key => $value) {
        // $usedItemsyAxisArray[$foreachCountyAxis] =  $usedItemsyAxis[$key];
        $usedItemsyAxisArray[$foreachCountyAxis] =  $value;
        $foreachCountyAxis++;
      }
      // print_r($usedItemsyAxisArray); exit();

      // making array to hold all inserting Data
      $insertArray = array();

      for ($i=0; $i<count($usedItemsxAxisArray); $i++) {
        $array = array(
          'IRI_Formula_Enterprize_ID' => $EntID,
          'IRI_Items_Formula_Id'      => $ID,
          'IRI_Type_Choice'           => 1, // 1-> EXECUTIVE SUMMARY
          'IRI_Condition_Type'        => 2, // 2-> Individual
          'IRI_xAxis_Item_Id'         => $usedItemsxAxisArray[$i],
          'IRI_xAxis_Min_Value'       => $minValuexAxis[$i] ? $minValuexAxis[$i] : 0,
          'IRI_xAxis_Max_Value'       => $maxValuexAxis[$i] ? $maxValuexAxis[$i] : 0,
          'IRI_yAxis_Item_Id'         => $usedItemsyAxisArray[$i],
          'IRI_yAxis_Min_Value'       => $minValueyAxis[$i] ? $minValueyAxis[$i] : 0,
          'IRI_yAxis_Max_Value'       => $maxValueyAxis[$i] ? $maxValueyAxis[$i] : 0,
          'IRI_Text'                  => $details[$i],
          'IRI_Created_By'            => $this->session->userdata('loginData')['User_Id'],
          'IRI_Created_On'            => date('Y-m-d H:i:s'),
        );
        array_push($insertArray, $array);
      }
      //print_r($insertArray); exit();
      $result = $this->Common_Model->deleteInsert('GAME_ITEM_REPORT_INDIVIDUAL', $where, $insertArray);
      // =========================================

      //print_r($result); exit();
      redirect('Competence/itemFormula');
    } // end of form submit

    $content['subview'] = 'itemReportIndividual';
    $this->load->view('main_layout', $content);
  }

  public function itemReportCSI($ID=NULL, $EntID=NULL) {
    // IRI_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IRI_Condition_Type (1-> Average, 2-> Individual)

    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }
    
    // setting titl for the page
    // $content['reportType'] = 'Conclusion Section for Individual';
    $content['reportType'] = 'Conclusion 1';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    $formulaWhere   = array('Items_Formula_Id' => $ID);
    $formulaDetails = $this->Common_Model->fetchRecords('GAME_ITEMS_FORMULA', $formulaWhere, 'Items_Formula_Id, Items_Formula_Title, Items_Formula_String, Items_Formula_Expression, Items_Formula_Json', '');
    // print_r($formulaDetails); print_r($formulaDetails[0]->Items_Formula_Title); exit();
    $content['formulaDetails'] = $formulaDetails;

    // decoding JSON
    $formulaJSON = json_decode($formulaDetails[0]->Items_Formula_Json, true);
    //print_r($formulaJSON); exit();
    $usedItemArray = []; //storing used Item ID in array

    $keys   = array_keys($formulaJSON);
    //$values = array_values($formulaJSON); 
    for ($x=0; $x<count($formulaJSON); $x++) {
      $usedItemArray[$x] = $keys[$x];
    }
    //print_r($usedItemArray); exit();

    // converting array to string for query
    $usedItem = implode(',', $usedItemArray);

    // Query to fetch all items used in selected formula
    $itemQuery = "SELECT gi.Compt_Id, gi.Compt_Name, gi.Compt_Description, gi.Compt_PerformanceType FROM GAME_ITEMS gi WHERE gi.Compt_Id IN ($usedItem)  AND gi.Compt_Enterprise_ID = $EntID ORDER BY gi.Compt_Id ASC";
    $itemUsedDetails = $this->Common_Model->executeQuery($itemQuery);
    //print_r($itemUsedDetails); exit();
    // setting data for view
    $content['itemUsedDetails'] = $itemUsedDetails;

    $enterprizeWhere   = array('Enterprise_ID' => $EntID);
    $enterprizeDetails = $this->Common_Model->fetchRecords('GAME_ENTERPRISE', $enterprizeWhere, 'Enterprise_ID, Enterprise_Name', '');
    // print_r($enterprizeDetails); print_r($enterprizeDetails[0]->Enterprise_Name); exit();
    $content['enterprizeDetails'] = $enterprizeDetails;

    // IRI_Type_Choice (1-> EXECUTIVE SUMMARY, 2-> CONCLUSION SECTION)
    // IRI_Condition_Type (1-> Average, 2-> Individual)
    $content['conditionType'] = 2;
    // selecting WHERE IRI_Type_Choice is 2-> CONCLUSION SECTION and IRI_Condition_Type is 2-> Individual
    // Query to fetch all item report text
    $query = "SELECT iri.IRI_ID, iri.IRI_Text, iri.IRI_xAxis_Item_Id, iri.IRI_xAxis_Min_Value, iri.IRI_xAxis_Max_Value, iri.IRI_yAxis_Item_Id, iri.IRI_yAxis_Min_Value, iri.IRI_yAxis_Max_Value FROM GAME_ITEM_REPORT_INDIVIDUAL iri WHERE iri.IRI_Items_Formula_Id = $ID AND iri.IRI_Type_Choice = 2 AND iri.IRI_Condition_Type = 2 AND iri.IRI_Formula_Enterprize_ID = $EntID ORDER BY iri.IRI_ID ASC";
    $reportDetails = $this->Common_Model->executeQuery($query);
    // print_r($query); print_r($reportDetails); exit();
    $content['reportDetails'] = $reportDetails;

    // if form submit
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'IRI_Formula_Enterprize_ID' => $EntID,
        'IRI_Items_Formula_Id'      => $ID,
        'IRI_Type_Choice'           => 2, // 2-> CONCLUSION SECTION
        'IRI_Condition_Type'        => 2, // 2-> Individual
      );

      // =========================================
      // for X-Axis
      $usedItemsxAxis = $this->input->post('usedItemsxAxis'); //array type but unseralised key
      $minValuexAxis  = $this->input->post('minValuexAxis'); //array type
      $maxValuexAxis  = $this->input->post('maxValuexAxis'); //array type
      // for Y-Axis
      $usedItemsyAxis = $this->input->post('usedItemsyAxis'); //array type but unseralised key
      $minValueyAxis  = $this->input->post('minValueyAxis'); //array type
      $maxValueyAxis  = $this->input->post('maxValueyAxis'); //array type

      $details        = $this->input->post('details');  //array type

      // making new array to hold used items in it with serialised key for x-axis
      $usedItemsxAxisArray = array();
      $foreachCountxAxis = 0;
      foreach ($usedItemsxAxis as $key => $value) {
        // $usedItemsxAxisArray[$foreachCountxAxis] =  $usedItemsxAxis[$key];
        $usedItemsxAxisArray[$foreachCountxAxis] =  $value;
        $foreachCountxAxis++;
      }
      // print_r($usedItemsxAxisArray); exit();

      // making new array to hold used items in it with serialised key for y-axis
      $usedItemsyAxisArray = array();
      $foreachCountyAxis = 0;
      foreach ($usedItemsyAxis as $key => $value) {
        // $usedItemsyAxisArray[$foreachCountyAxis] =  $usedItemsyAxis[$key];
        $usedItemsyAxisArray[$foreachCountyAxis] =  $value;
        $foreachCountyAxis++;
      }
      // print_r($usedItemsyAxisArray); exit();

      // making array to hold all inserting Data
      $insertArray = array();

      for ($i=0; $i<count($usedItemsxAxisArray); $i++) {
        $array = array(
          'IRI_Formula_Enterprize_ID' => $EntID,
          'IRI_Items_Formula_Id'      => $ID,
          'IRI_Type_Choice'           => 2, // 2-> CONCLUSION SECTION
          'IRI_Condition_Type'        => 2, // 2-> Individual
          'IRI_xAxis_Item_Id'         => $usedItemsxAxisArray[$i],
          'IRI_xAxis_Min_Value'       => $minValuexAxis[$i] ? $minValuexAxis[$i] : 0,
          'IRI_xAxis_Max_Value'       => $maxValuexAxis[$i] ? $maxValuexAxis[$i] : 0,
          'IRI_yAxis_Item_Id'         => $usedItemsyAxisArray[$i],
          'IRI_yAxis_Min_Value'       => $minValueyAxis[$i] ? $minValueyAxis[$i] : 0,
          'IRI_yAxis_Max_Value'       => $maxValueyAxis[$i] ? $maxValueyAxis[$i] : 0,
          'IRI_Text'                  => $details[$i],
          'IRI_Created_By'            => $this->session->userdata('loginData')['User_Id'],
          'IRI_Created_On'            => date('Y-m-d H:i:s'),
        );
        array_push($insertArray, $array);
      }
      //print_r($insertArray); exit();
      $result = $this->Common_Model->deleteInsert('GAME_ITEM_REPORT_INDIVIDUAL', $where, $insertArray);
      // =========================================

      //print_r($result); exit();
      redirect('Competence/itemFormula');
    } // end of form submit

    $content['subview'] = 'itemReportIndividual';
    $this->load->view('main_layout', $content);
  }

  public function itemReportHeaderSection() {
    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    // setting titl for the page
    $content['reportType'] = 'Header Section of Report';

    $headerWhere   = array('IR_ID' => 1); // IR_ID 1 is used for header section for report
    $headerDetails = $this->Common_Model->fetchRecords('GAME_ITEM_REPORT', $headerWhere, 'IR_Text', '');
    // print_r($headerDetails); print_r($headerDetails[0]->IR_Text); exit();
    $content['headerDetails'] = $headerDetails;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array('IR_ID' => 1);
      $updateArray = array(
        'IR_Text'       => $this->input->post('details'), // array type
        'IR_Created_On' => date('Y-m-d H:i:s'),
        'IR_Created_By' => $this->session->userdata('loginData')['User_Id'],
      );
      $result = $this->Common_Model->updateRecords('GAME_ITEM_REPORT', $updateArray, $where);
      //print_r($result); exit();

      redirect('Competence/itemReportCreation');
    }

    $content['subview'] = 'itemReportHeaderDisclaimer';
    $this->load->view('main_layout', $content);
  }

  public function itemReportDisclaimerSection() {
    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    // setting titl for the page
    $content['reportType'] = 'Disclaimer Section of Report';

    $headerWhere   = array('IR_ID' => 2); // IR_ID 2 is used for Desclamer section for report
    $headerDetails = $this->Common_Model->fetchRecords('GAME_ITEM_REPORT', $headerWhere, 'IR_Text', '');
    // print_r($headerDetails); print_r($headerDetails[0]->IR_Text); exit();
    $content['headerDetails'] = $headerDetails;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array('IR_ID' => 2);
      $updateArray = array(
        'IR_Text'       => $this->input->post('details'), // array type
        'IR_Created_On' => date('Y-m-d H:i:s'),
        'IR_Created_By' => $this->session->userdata('loginData')['User_Id'],
      );
      $result = $this->Common_Model->updateRecords('GAME_ITEM_REPORT', $updateArray, $where);
      //print_r($result); exit();

      redirect('Competence/itemReportCreation');
    }

    $content['subview'] = 'itemReportHeaderDisclaimer';
    $this->load->view('main_layout', $content);
  }

  public function itemReportTitleDefinition($ID=NULL, $EntID=NULL) {
    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    // setting titl for the page
    $content['reportType'] = 'Report Title and Definition';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    // Query to fetch all item report details
    $query = "SELECT gif.Items_Formula_Title, gif.Items_Formula_Report_Name_Definition, ge.Enterprise_Name FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id WHERE gif.Items_Formula_Id = $ID AND gif.Items_Formula_Enterprise_Id = $EntID";
    $reportDetails = $this->Common_Model->executeQuery($query);
    $content['reportDetails'] = $reportDetails;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'Items_Formula_Id'            => $ID,
        'Items_Formula_Enterprise_Id' => $EntID
      );
      $updateArray = array(
        'Items_Formula_Report_Name_Definition' => $this->input->post('details')
      );
      $result = $this->Common_Model->updateRecords('GAME_ITEMS_FORMULA', $updateArray, $where);
      //print_r($result); exit();

      redirect('Competence/itemFormula');
    }

    $content['subview'] = 'itemReportTitleDetailed';
    $this->load->view('main_layout', $content);
  }

  public function itemReportDetailedReport($ID=NULL, $EntID=NULL) {
    // only superadmin allow to access this page
    if ($this->session->userdata('loginData')['User_Role'] != 'superadmin') {
      $this->session->set_flashdata('er_msg', 'You are not allowed to visit <b>"' . $this->router->fetch_class() . '"</b> page');
      redirect('Dashboard');
    }

    // setting titl for the page
    $content['reportType'] = 'Detailed Report';

    // $ID will be formula ID
    $ID = base64_decode($ID);
    // $EntID will be Enterprize ID
    $EntID = base64_decode($EntID);

    // Query to fetch all item report details
    $query = "SELECT gif.Items_Formula_Title, gif.Items_Formula_Detailed_Report, ge.Enterprise_Name FROM GAME_ITEMS_FORMULA gif LEFT JOIN GAME_ENTERPRISE ge ON ge.Enterprise_ID = gif.Items_Formula_Enterprise_Id WHERE gif.Items_Formula_Id = $ID AND gif.Items_Formula_Enterprise_Id = $EntID";
    $reportDetails = $this->Common_Model->executeQuery($query);
    $content['reportDetails'] = $reportDetails;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // print_r($this->input->post()); exit();

      $where = array(
        'Items_Formula_Id'            => $ID,
        'Items_Formula_Enterprise_Id' => $EntID
      );
      $updateArray = array(
        'Items_Formula_Detailed_Report' => $this->input->post('details')
      );
      $result = $this->Common_Model->updateRecords('GAME_ITEMS_FORMULA', $updateArray, $where);
      //print_r($result); exit();

      redirect('Competence/itemFormula');
    }
    
    $content['subview'] = 'itemReportTitleDetailed';
    $this->load->view('main_layout', $content);
  }

}
