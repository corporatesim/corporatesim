<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SelectSimulation extends My_Controller {

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


	private $botUserData;
	public function __construct()
	{
		parent::__construct();
		$this->botUserData = $this->session->userdata('botUserData');
	}

	public function phpinfo()
	{
		phpinfo();
		echo "<pre>"; print_r(ini_get_all());
	}

	public function index()
	{
		// check if user has bot-enabled game or not if yes then show, else redirect to registered domain 
		$gameSql = "SELECT * FROM GAME_USERGAMES gug JOIN GAME_GAME gg ON gg.Game_ID = gug.UG_GameID LEFT JOIN GAME_USERSTATUS gus ON gus.US_GameID = gug.UG_GameID AND gus.US_UserID =".$this->botUserData->User_id." WHERE gg.Game_Type = 1 AND gg.Game_Category IN ('Mobile Simulation', 'Mobile Assesment', 'Mobile eLearning') AND gug.UG_UserID =".$this->botUserData->User_id;
		$gameResult = $this->Common_Model->executeQuery($gameSql);
		// die($gameSql);
		// echo "<pre>"; print_r($this->botUserData); print_r($gameResult); echo "<a href='".base_url('PlaySimulation')."'>PlaySimulation</a><br>"; echo "<a href='".base_url('SelectSimulation/logOut')."'>Logout</a> ";

		$content['gameResult'] = $gameResult;
		$content['subview']    = 'selectSimulation';
		$this->load->view('main_layout',$content);
	}

	public function logOut()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('tr_msg', 'Logged out successfully');
		// echo "<pre>"; print_r($this->session); exit();
		redirect('Login');
	}
}
