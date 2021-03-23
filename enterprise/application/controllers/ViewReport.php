<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ViewReport extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('loginData') == NULL)
		{
			$this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
			redirect('Login/login');
		}
		$this->load->library('PHPExcel');
	}

	public function index($reportData=NULL)
	{	
		if(empty($reportData))
		{
			$this->session->set_flashdata('er_msg', 'Please choose filter to get report');
			redirect(base_url('AnalyseReport'));
		}
		echo $reportData.'<br><pre>'.base64_decode($reportData);
		echo "<pre>"; print_r($this->input->post()); exit();
		$filtertype    = $this->input->post('filtertype');
		$Enterprise    = $this->input->post('Enterprise');
		$SubEnterprise = $this->input->post('SubEnterprise');
		$selectedGame  = $this->input->post('selectGame');
		$gameenddate   = $this->input->post('gameenddate');
		$gamestartdate = $this->input->post('gamestartdate');
			$siteUsers     = $this->input->post('siteUsers'); // this will be of array type
			$userId        = array();
			// if no user is selected then show error
			if(count($siteUsers)<1)
			{
				$this->session->set_flashdata('er_msg', 'Please select at least one user');
				redirect(current_url());
			}
			else
			{
				for($i=0; $i<count($siteUsers); $i++)
				{
					$userId[] = $siteUsers[$i];
				}
			}
			$userId    = implode(',',$userId);
			$reportSql = 'SELECT gi.input_current, CONCAT( gc.Comp_Name, "/", IF( gs.SubComp_Name, gs.SubComp_Name, "" ) ) AS Comp_SubComp, CONCAT( gu.User_fname, " ", gu.User_lname) AS fullName, gu.User_username AS userName, gu.User_email AS userEmail FROM GAME_INPUT gi INNER JOIN GAME_SITE_USERS gu ON gu.User_id = gi.input_user INNER JOIN GAME_LINKAGE_SUB gls ON gi.input_sublinkid = gls.SubLink_ID LEFT JOIN GAME_COMPONENT gc ON gc.Comp_ID = gls.SubLink_CompID LEFT JOIN GAME_SUBCOMPONENT gs ON gs.SubComp_ID = gls.SubLink_SubCompID WHERE ( gls.SubLink_LinkID IN( SELECT Link_ID FROM GAME_LINKAGE WHERE Link_GameID = '.$selectedGame.' ) AND gls.SubLink_Type = 1 ) AND gi.input_user IN('.$userId.')';
			$reportData = $this->Common_Model->executeQuery($reportSql);

			$gameRes = $this->Common_Model->fetchRecords('GAME_GAME',array('Game_ID' => $selectedGame),'Game_Name');
			if(count($gameRes)>0)
			{
				$gameName = $gameRes[0]->Game_Name;
			}
			else
			{
				$gameName = 'No Game';
			}
			$objPHPExcel = new PHPExcel;
			$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
			$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
			$objWriter      = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
			// ob_end_clean();
			$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';
			$numberFormat   = '#,#0.##;[Red]-#,#0.##';	
			$objSheet       = $objPHPExcel->getActiveSheet();

			$objSheet->setTitle('Simulation Report');
			$objSheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);
			$objSheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(16);

			$objSheet->getCell('A1')->setValue('Game:'.$gameName);
			$objSheet->getCell('A2')->setValue('Name');
			$objSheet->getCell('B2')->setValue('UserName');
			$objSheet->getCell('C2')->setValue('UserEmail');

			$putUser      = 'A';
			$putUserName  = 'B';
			$putUserEmail = 'C';
			$numUserData  = 3;
			$putComp      = 'D';
			$numComp      = '2';
			$tempUser     = array();
			$compSubComp  = array();
			$filename     = 'UserReport_'.date('d-m-Y').'.xlsx';

			// echo "<pre>"; print_r($reportData); exit();
			// colName will be like B2,C2,D2,E2 like this, and fullName will be like A3, A4, A5, A6 like this
			foreach ($reportData as $userGameData)
			{
				if(!in_array($userGameData->fullName, $tempUser))
				{
					$tempUser[] = $userGameData->fullName;
					$objSheet->getCell($putUser.$numUserData)->setValue($userGameData->fullName);
					$objSheet->getCell($putUserName.$numUserData)->setValue($userGameData->userName);
					$objSheet->getCell($putUserEmail.$numUserData)->setValue($userGameData->userEmail);
					$numUserData++;
				}
				if(!in_array($userGameData->Comp_SubComp, $compSubComp))
				{
					$compSubComp[$putComp] = $userGameData->Comp_SubComp;
					$objSheet->getCell($putComp.$numComp)->setValue($userGameData->Comp_SubComp);
					$putComp++;
				}
			}

			foreach ($reportData as $row)
			{
				$col = array_search($row->Comp_SubComp,$compSubComp);
				$val = array_search($row->fullName,$tempUser)+3; // so that we can start from the *3, where * is A,B,C...
				$objSheet->getCell($col.$val)->setValue($row->input_current);
				// echo $col.$val.' : '.$row->input_current.'<br>';
			}


			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename='.$filename);
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
			// exit();
			$content['subview']        = 'viewReport';
			$this->load->view('main_layout',$content);
		}

	}
