<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JSUploadImages extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    // Setting folder List
    $queryFolderList = "SELECT folder.*
      FROM GAME_JS_FOLDER folder
      ORDER BY folder.JS_FD_ID DESC";
    $detailsFolderList = $this->Common_Model->executeQuery($queryFolderList);
    // print_r($detailsFolderList); print_r($detailsFolderList[0]->JS_FD_Name); exit();
    $content['detailsFolderList'] = $detailsFolderList;

    // Setting image Details
    $query = "SELECT img.*
      FROM GAME_JS_IMAGES img 
      ORDER BY img.JS_IMG_ID DESC";
    $details = $this->Common_Model->executeQuery($query);
    // print_r($details); print_r($details[0]->JS_IMG_FileName); exit();

    $content['details'] = $details;

    $content['subview']  = 'jsUploadImages';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function uploadImages() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      
      // Setting image file name
      $new_file_name = preg_replace('/[^a-zA-Z0-9-_.]/', '-', $_FILES["fileUpload"]['name']);

      // Setting folder name
      $folderName = $this->input->post('folderName');

      // =======================================
      // settings for uploading image 
      if (!empty($folderName)) 
        $config['upload_path'] = './../jsGame/gameData/'.$folderName.'/';
      else 
        $config['upload_path'] = './../jsGame/gameData/';

      // $config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|html|xml';
      $config['allowed_types']    = 'gif|jpg|jpeg|png|svg|dmg';
      // $config['max_size']         = 262144; //256 KB
      $config['max_size']         = 524288; //512 KB
      //$config['overwrite']        = TRUE;
      $config['file_name']        = $new_file_name;
      $config['file_ext_tolower'] = TRUE;
      $config['remove_spaces']    = TRUE;
      $config['detect_mime']      = TRUE;
      $config['mod_mime_fix']     = TRUE;

      $this->load->library('upload',$config);

      if (!$this->upload->do_upload('fileUpload')) {
        $error = $this->upload->display_errors();
        // print_r($error); exit();
        $fileName = '';
      }
      else {
        $success = $this->upload->data();
        // var_dump($success); // to print all values
        
        $fileName = $this->upload->data('file_name');
        $fileSize = $this->upload->data('file_size');
        // $filePath  = $this->upload->data('file_path');
        // $fullPath  = $this->upload->data('full_path');
        // $imageType = $this->upload->data('image_type');
        // print_r($fileName);  exit();
        $error = '';
      }
      // =======================================

      // sending error message if image is not uploaded on server
      if (!empty($error)) {
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
      else if (!empty($fileName) && !empty($fileSize)) {
        $insertArray = array(
          'JS_IMG_Folder'      => $folderName,
          'JS_IMG_FileName'    => $fileName,
          'JS_IMG_FileSize'    => $fileSize,
          'JS_IMG_Uploaded_On' => date('Y-m-d H:i:s', time()),
        );
        
        // inserting new Record
        $result = $this->Common_Model->insert("GAME_JS_IMAGES", $insertArray, '');

        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Image Uploaded Successfully.', 'button' => 'btn btn-success']));
      }     
    }
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Image can not Uploaded.', 'button' => 'btn btn-danger']));
    }
  } // end of uploadImages function
} // end of JSUploadImages class 
