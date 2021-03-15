<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JSCreateFolder extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $query = "SELECT folder.*
      FROM GAME_JS_FOLDER folder
      ORDER BY folder.JS_FD_ID DESC";
    $details = $this->Common_Model->executeQuery($query);
    // print_r($details); print_r($details[0]->JS_FD_Name); exit();

    $content['details'] = $details;

    $content['subview']  = 'jsCreateFolder';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function createFolder() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      // setting rules for checking submitted form
      $this->form_validation->set_rules('folderTitle', 'Folder', 'trim|required|alpha_numeric');
      
      // checking form submitted according to rules set
      if ($this->form_validation->run() == false) {
        $response = array(
          'status'  => 'error',
          'message' => array(
            'folderTitleError' => form_error('folderTitle'),
          )
        );
        // print_r($response); exit();

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
        // die(json_encode($response));
      }
      else {
        // Setting folder name
        $folderName = $this->input->post('folderTitle');

        // Convert each Characters in lower case.
        $folderName = strtolower($folderName);
        // Remove all spaces
        $folderName = str_replace(' ', '', $folderName);
        // Remove all /(back slash)
        $folderName = str_replace('/', '', $folderName);
        // Remove all special and numeric Characters.
        $folderName = preg_replace('/[^A-Za-z]/', '', $folderName);

        // Setting folder path
        $path = "./../jsGame/gameData/".$folderName;

        // create the folder if it's not already exists
        if (!is_dir($path)) {
          // 0755 is permission of the folder to be created. 
          // 755 means you can do anything with the file or directory
          mkdir($path, 0755, TRUE);

          // inserting new file
          $insertArray = array(
            'JS_FD_Name'       => $folderName,
            'JS_FD_Created_On' => date('Y-m-d H:i:s', time()),
          );
          $result = $this->Common_Model->insert("GAME_JS_FOLDER", $insertArray, '');

          die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Folder Created Successfully.', 'button' => 'btn btn-success']));
        }
        else {
          die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Folder already exists.', 'button' => 'btn btn-danger']));
        }
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Folder not Created.', 'button' => 'btn btn-danger']));
    }
  } // end of createFolder function
} // end of JSCreateFolder class 
