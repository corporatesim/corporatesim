<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestVideo extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/TestVideo
	 *	- or -
	 * 		http://example.com/index.php/TestVideo/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/TestVideo/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		error_reporting(0);
		ini_set('display_errors', 0);
		$content['subview'] = 'testVideo';
		$this->load->view('main_layout',$content);
	}
}
