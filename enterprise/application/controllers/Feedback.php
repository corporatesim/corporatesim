<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $gameFeedback = $this->Common_Model->fetchRecords('GAME_FEEDBACK', NULL, NULL, 'Feedback_id DESC', NULL);

    $content['details'] = $gameFeedback;
    $content['subview'] = 'feedback';
    $this->load->view('main_layout', $content);
  } // end of index function

  public function getFeedbackGraph() {
      // query to get data
      $query5 = "SELECT COUNT(*) as count FROM GAME_FEEDBACK gf WHERE gf.Feedback_rating = 5";
      $star5 = $this->Common_Model->executeQuery($query5);

      $query4 = "SELECT COUNT(*) as count FROM GAME_FEEDBACK gf WHERE gf.Feedback_rating = 4";
      $star4 = $this->Common_Model->executeQuery($query4);

      $query3 = "SELECT COUNT(*) as count FROM GAME_FEEDBACK gf WHERE gf.Feedback_rating = 3";
      $star3 = $this->Common_Model->executeQuery($query3);

      $query2 = "SELECT COUNT(*) as count FROM GAME_FEEDBACK gf WHERE gf.Feedback_rating = 2";
      $star2 = $this->Common_Model->executeQuery($query2);

      $query1 = "SELECT COUNT(*) as count FROM GAME_FEEDBACK gf WHERE gf.Feedback_rating = 1";
      $star1 = $this->Common_Model->executeQuery($query1);
      // print_r($this->db->last_query()); exit();
      // print_r($star3[0]->count); exit();
      

    // sending result
    die(json_encode(["status" => "200", 'star1' => $star1[0]->count, 'star2' => $star2[0]->count, 'star3' => $star3[0]->count, 'star4' => $star4[0]->count, 'star5' => $star5[0]->count]));
  } // end of getFeedbackGraph function

  // adding new Feedback
  public function addFeedback() {
    $content['subview']  = 'feedbackAdd';
    $this->load->view('main_layout',$content);
  } // end of addFeedback function

  // Updating Feedback
  public function updateFeedback($ID=NULL) {
    // decoding ID
    $ID = base64_decode($ID);

    $query = "SELECT *
      FROM GAME_FEEDBACK gf
      WHERE gf.Feedback_id = ".$ID." LIMIT 1";
    $details = $this->Common_Model->executeQuery($query);
    // print_r($this->db->last_query()); exit();

    $content['details'] = $details;
    $content['subview'] = 'feedbackUpdate';
    $this->load->view('main_layout',$content);
  } // end of updateFeedback function

  // Adding and Updating Feedback
  public function addUpdateFeedback() {
    // print_r($this->input->post()); exit();

    // checking Which type of request user send
    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // setting rules for checking submitted form
      $this->form_validation->set_rules('feedbackUserID', 'User ID', 'trim');
      $this->form_validation->set_rules('feedbackName', 'Name', 'required|trim');
      $this->form_validation->set_rules('feedbackEmailID', 'Email ID', 'required|trim|valid_email|valid_emails');
      $this->form_validation->set_rules('feedbackMobileNo', 'Mobile No.', 'trim|exact_length[10]|regex_match[/^[0-9]{10}$/]');
      $this->form_validation->set_rules('feedbackRating', 'Rating', 'trim|exact_length[1]|regex_match[/^[0-5]{1}$/]');
      $this->form_validation->set_rules('feedbackTitle', 'Title', 'required|trim');
      $this->form_validation->set_rules('feedbackMessage', 'Message', 'required|trim');

      // checking form submitted according to rules set
      if ($this->form_validation->run() == false) {
        $response = array(
          'status'  => 'error',
          'message' => array(
            'feedbackUserIDError'   => form_error('feedbackUserID'),
            'feedbackNameError'     => form_error('feedbackName'),
            'feedbackEmailIDError'  => form_error('feedbackEmailID'),
            'feedbackMobileNoError' => form_error('feedbackMobileNo'),
            'feedbackRatingError'   => form_error('feedbackRating'),
            'feedbackTitleError'    => form_error('feedbackTitle'),
            'feedbackMessageError'  => form_error('feedbackMessage'),
          )
        );
        // print_r($response); exit();

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
        // die(json_encode($response));
      }
      else {

        // Setting User Data
        $userData = array(
          "fullName"   => $this->input->post('feedbackName'),
          "Email"      => $this->input->post('feedbackEmailID'),
          "ProfilePic" => '',
          "Mobile"     => $this->input->post('feedbackMobileNo'),
        );
        $userDataJSON = json_encode($userData);

        // Setting to inserting new records
        $addUpdateArray = array(
          'Feedback_userid'    => $this->input->post('feedbackUserID'),
          'Feedback_userData'  => $userDataJSON,
          'Feedback_rating'    => $this->input->post('feedbackRating'),
          'Feedback_title'     => $this->input->post('feedbackTitle'),
          'Feedback_message'   => $this->input->post('feedbackMessage'),
        );

        // checking feedback id is set or not 
        // if set then update else Insert new record
        if (empty($this->input->post('feedbackID'))) {
          $addUpdateArray['Feedback_createdOn'] = date('Y-m-d H:i:s', time());
          // adding new Feedback Details
          $result = $this->Common_Model->insert("GAME_FEEDBACK", $addUpdateArray, '');
          $successMessage = 'Saved Successfully.';
        }
        else {
          // updating Feedback Details
          $where  = array('Feedback_id' => $this->input->post('feedbackID'));
          $result = $this->Common_Model->updateRecords('GAME_FEEDBACK', $addUpdateArray, $where);
          $successMessage = 'Updated Successfully.';
        }

        // Sending success message
        die(json_encode(["status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => $successMessage, 'button' => 'btn btn-success']));
      }
    } // end of if RequestMethod is POST
    else {
      die(json_encode(["status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Not Saved.', 'button' => 'btn btn-danger']));
    }
  } // end of addUpdateFeedback function

  public function getFeedbackDetails($ID=NULL) {
    // checking ID is set or not
    if ($ID) {
      // query to get data
      $query = "SELECT *
      FROM GAME_FEEDBACK gf
      WHERE gf.Feedback_id = ".$ID." LIMIT 1";
      $details = $this->Common_Model->executeQuery($query);
      // print_r($this->db->last_query()); exit();

      $data = json_decode($details[0]->Feedback_userData);
      $pic = ($data->ProfilePic) ? $data->ProfilePic : 'avatar.png';

      // <img src="base_url('../images/userProfile/'.$pic)" alt="User Profile Pic">

      // making View
      // $description = '<strong>User ID :</strong> '.$details[0]->Feedback_userid.'<br />';
      // $description .= '<strong>Name :</strong> '.$data->fullName.'<br />';
      // $description .= '<strong>Email ID :</strong> '.$data->Email.'<br />';
      // $description .= '<strong>Mobile No. :</strong> '.$data->Mobile.'<br />';
      // $description .= '<strong>Rating :</strong> '.$details[0]->Feedback_rating.' Star<br />';
      // $description .= '<strong>Time :</strong> '.date('d-M-y, H:i', strtotime($details[0]->Feedback_createdOn)).'<br /><br />';
      // $description .= '<strong>Title :</strong> '.$details[0]->Feedback_title.'<br />';
      // $description .= '<strong>Message :</strong> '.$details[0]->Feedback_message;

      $description = '<span class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="contact-directory-box">
          <div class="contact-dire-info text-center">
            <div class="contact-avatar">
              <span>
                <img src="'.base_url('../images/userProfile/'.$pic).'" alt="image">
              </span>
            </div>
            <div class="contact-name">
              <h4>'.$data->fullName.'</h4>
              <p>'.$data->Email.'</p>
            </div>
            <div class="contact-skill">
              <span class="badge badge-pill badge-primary">'.$details[0]->Feedback_rating.' <i class="fa fa-star" aria-hidden="true"></i></span>
            </div>
            <div class="work text-success">'.$details[0]->Feedback_title.'</div>
            <div class="profile-sort-desc">'.$details[0]->Feedback_message.'</div>
          </div>
        </div>
      </span>';
    }
    else {
      // ID is not set
      $description = 'No Record Selected.';
    }

    // sending result
    die(json_encode(["status" => "200", 'description' => $description]));
  } // end of getFeedbackDetails function

  // Downloading Feedback list in csv file
  public function downloadFeedbackCsvFile() {
    $csv_file = fopen('php://output', 'w');
    header('Content-type: application/csv');
    // it(ob_clean()) using downloade time remove empty row on excelsheet
    // ob_clean();

    $gameFeedback = $this->Common_Model->fetchRecords('GAME_FEEDBACK', NULL, NULL, 'Feedback_id DESC', NULL);
    // print_r($gameFeedback); exit();

    if (count($gameFeedback) > 0) {
      $header_row = array("User ID", "Name", "Email ID", "Mobile", "Rating", "Time", "Title", "Message");
      fputcsv($csv_file, $header_row, ',', '"');

      foreach ($gameFeedback as $gameFeedbackRow) {
        $Feedback_userData = json_decode($gameFeedbackRow->Feedback_userData);

        // setting data
        $userID       = $gameFeedbackRow->Feedback_userid;
        $name         = $Feedback_userData->fullName;
        $emailID      = $Feedback_userData->Email;
        $mobileNo     = $Feedback_userData->Mobile;
        $rating       = $gameFeedbackRow->Feedback_rating;
        $feedbackTime = date('d-M-y, H:i',strtotime($gameFeedbackRow->Feedback_createdOn));
        $title        = $gameFeedbackRow->Feedback_title;
        $message      = $gameFeedbackRow->Feedback_message;

        $rowData = array($userID, $name, $emailID, $mobileNo, $rating, $feedbackTime, $title, $message);
        fputcsv($csv_file, $rowData, ',', '"');
      }
    }
    else {
      $noFeedbacks = array('No Feedbacks Available');
      fputcsv($csv_file, $noFeedbacks, ',', '"');
    }
    fclose($csv_file);
  } // end of downloadind feedback

  public function deleteRecord($ID=NULL, $redirect=NULL) {
    // decoding ID
    $ID = base64_decode($ID);
    // print_r($ID); exit();

    // checking ID is set or not
    if (empty($ID)) {
      // setting flash data with error message
      $this->session->set_flashdata('er_msg', 'No Record Selected To Delete');
    }
    else {
      // deleting selected record as a hard delete
      $where = array('Feedback_id' => $ID);
      $hardDelete = $this->Common_Model->deleteRecords('GAME_FEEDBACK', $where);
      // print_r($hardDelete); exit();

      // setting flash data with success message
      $this->session->set_flashdata('tr_msg', "Record Deleted Successfully");
    }

    // refreshing page
    redirect("feedback", "refresh");
  } // end of deleteRecord

  // Bulk Uploading feedback
  public function ajax_bulk_upload_feedback() {
    // $maxFileSize    = 1000000; // Set max upload file size [1MB]
    $maxFileSize    = 2097152; // Set max upload file size [2MB]
    $validext       = array('xls', 'xlsx', 'csv');  // Allowed Extensions
    $Upload_CSV_ID  = time(); // ID as Current time

    // checking user is inserted any file or not
    if (isset($_FILES['upload_csv']['name']) && !empty($_FILES['upload_csv']['name'])) {

      $fileSize = filesize($_FILES['upload_csv']['tmp_name']); // uploaded file size
      // echo print_r($fileSize); exit();

      // checking inserted file size in not greater then declared ($maxFileSize) size 
      if ($fileSize < $maxFileSize) {
        $explode_filename = explode(".", $_FILES['upload_csv']['name']); // uploaded file extension
        $ext = strtolower(end($explode_filename));
        // echo $ext."\n";

        // checking user is uploading valid file extension and size or not 
        if (in_array($ext, $validext)) {
          try {
            $file                  = $_FILES['upload_csv']['tmp_name'];
            $handle                = fopen($file, "r");
            $not_Inserted_Name     = array(); // array of not imported data
            $c                     = 0; // count of all imported data
            $flag                  = true;

            // setting file data to read mode
            $fileStructure = fgetcsv($handle, 1000, ",");
            if (!empty($fileStructure[0])) {

              while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
                if ($flag) {
                  $flag = false;
                  continue;
                }

                // echo print_r($filesop); exit();

                if (!empty($filesop)) {
                  // Setting User Data
                  $userData = array(
                    "fullName"   => $filesop[1],
                    "Email"      => $filesop[2],
                    "ProfilePic" => '',
                    "Mobile"     => $filesop[3]
                  );
                  $userDataJSON = json_encode($userData);

                  // Setting to inserting new records
                  $arrayRecord = array(
                    'Feedback_userid'    => $filesop[0],
                    'Feedback_userData'  => $userDataJSON,
                    'Feedback_rating'    => $filesop[4],
                    'Feedback_title'     => $filesop[5],
                    'Feedback_message'   => $filesop[6],
                    'Feedback_createdOn' => date('Y-m-d H:i:s', time()),
                  );

                  // adding new Feedback Details
                  $result = $this->Common_Model->insert("GAME_FEEDBACK", $arrayRecord, '');
                  $c++;
                }
              }

              // echo $c;
              if (!empty($not_Inserted_Name)) {
                // showing all Not imported Campus Name as msg
                $msg = "</br><p class='text-danger'><br />Not imported Records:- " . count($not_Inserted_Name) . " <br /> Records Name:-<br />" . implode(" , ", $not_Inserted_Name) . "</p>";
              }
              else {
                $msg = "";
              }

              $result = array(
                //"msg"    => "Import successful. You have imported ".$c." Records.".$msg,
                "msg"    => "You have imported " . $c . " Records." . $msg,
                "status" => 1
              );
            }
            else {
              $result = array(
                "msg"    => "Please select a file with given format to import",
                "status" => 0
              );
            }
          }
          catch (Exception $e) {
            $result = array(
              "msg"    => "Error: " . $e,
              "status" => 0
            );
          }
        }
        else {
          $result = array(
            "msg"    => "Please select a valid file with extension(xls, xlsx, csv) to import",
            "status" => 0
          );
        }
      }
      else {
        $result = array(
          "msg"    => "File size is longer then 2 MB",
          "status" => 0
        );
      }
    }
    else {
      $result = array(
        "msg"    => "Please select a file to import",
        "status" => 0
      );
    }

    echo json_encode($result);
  } // end of ajax_bulk_upload_feedback feedback

} // end of Feedback class 
