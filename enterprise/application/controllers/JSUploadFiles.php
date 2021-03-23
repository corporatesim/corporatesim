<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JSUploadFiles extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $query = "SELECT files.*
      FROM GAME_JS_FILES files 
      ORDER BY files.JS_F_ID DESC";
    $details = $this->Common_Model->executeQuery($query);
    // print_r($details); print_r($details[0]->JS_F_File_Name); exit();

    $content['details'] = $details;

    $content['subview']  = 'jsUploadFiles';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function addFiles() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {

      // settings for uploading file
      $config['upload_path'] = './../jsGame/jsGameFiles/';
      // $config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|html|xml';
      // $config['allowed_types'] = 'txt|html|js|php';
      $config['allowed_types'] = '*'; // All Types of files
      $config['overwrite'] = TRUE;
      // $config['max_size'] = 262144; //256 KB
      $config['file_name'] = $_FILES["fileUpload"]['name'];

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('fileUpload')) {
        $error = $this->upload->display_errors();
        //print_r($error); exit();
        $fileName = '';
      }
      else {
        $success = $this->upload->data();
        // var_dump($success); //to print all values
        $fileName = $this->upload->data('file_name');
        //print_r($fileName); exit();
        $error = '';
      }

      // checking form submitted according to rules set
      if (empty($fileName)) {
        $response = array(
          'status'  => 'error',
          'message' => array('fileUploadError' => $error)
        );
        // print_r($response); exit();

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
        // die(json_encode($response));
      }
      else if (!empty($fileName)) {
        // checking file name exist or not in database
        $where = array('JS_F_File_Name' => $fileName);
        $details = $this->Common_Model->fetchRecords('GAME_JS_FILES', $where, 'JS_F_ID', '');

        // if file exist then update else insert new record
        if (!empty($details[0]->JS_F_ID)) {
          // updating existing record
          $updateArray = array(
            'JS_F_File_Name'  => $fileName,
            'JS_F_Updated_On' => date('Y-m-d H:i:s', time()),
          );
          $where      = array('JS_F_ID' => $details[0]->JS_F_ID);
          $UpdateData = $this->Common_Model->updateRecords('GAME_JS_FILES', $updateArray, $where);
        }
        else {
          // inserting new file
          $insertArray = array(
            'JS_F_File_Name'   => $fileName,
            'JS_F_Uploaded_On' => date('Y-m-d H:i:s', time()),
            'JS_F_Updated_On'  => date('Y-m-d H:i:s', time()),
          );
          $result = $this->Common_Model->insert("GAME_JS_FILES", $insertArray, '');
        }

        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'File uploaded Successfully.', 'button' => 'btn btn-success']));
      }
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'File not uploaded.', 'button' => 'btn btn-danger']));
    }
  } // end of addFiles function
} // end of JSUploadFiles class 
