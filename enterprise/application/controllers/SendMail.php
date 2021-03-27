<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendMail extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    die('You are not allowed to visit this page.');
  }

  public function sendMailToUser($to=NULL, $subject=NULL, $message=NULL, $from=NULL, $mailRecordArray=NULL)
  {
    $User_email = $this->input->post('User_email');
    if(empty($User_email))
    {
      die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 2500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'Email ID / username can not be left blank.']));
    }
    else
    {
      // $where = array('User_email' => $User_email, 'User_username' => $User_email);
      // $checkRecord = $this->Common_Model->fetchRecords('GAME_SITE_USERS', "User_email='".$User_email."' OR User_username='".$User_email."'", '', '', '', '', 0);
      $userSql = "SELECT gsu.User_id, gsu.User_fname, gsu.User_username, gsu.User_email, gsu.User_ParentId, gsu.User_SubParentId, gua.Auth_username, gua.Auth_password, gd.Domain_Name FROM `GAME_SITE_USERS` gsu LEFT JOIN GAME_DOMAIN gd ON gd.Domain_EnterpriseId = gsu.User_ParentId LEFT JOIN GAME_USER_AUTHENTICATION gua ON gua.Auth_userid = gsu.User_id WHERE gsu.`User_email` = '".$User_email."' OR gsu.`User_username` = '".$User_email."'";

      $checkRecord = $this->Common_Model->executeQuery($userSql);
      // echo "$userSql<br>"; print_r($checkRecord);
      if(count($checkRecord) < 1)
      {
        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 2500, "status" => "201", 'title' => "Error", 'icon' => 'error', 'message' => 'No record found. Please try with different details.']));
      }
      else
      {
        $from = 'support@corpsim.in';
        foreach($checkRecord as $checkRecordRow)
        {
          $message = "Hi ".ucfirst($checkRecordRow->User_fname).",<br><br> You can login to your account using the below details.<br><br> <b>URL: </b>".$checkRecordRow->Domain_Name." <br> <b>Username: </b>".$checkRecordRow->User_username." <br> <b>Password: </b>".$checkRecordRow->Auth_password." <br>";
          $mailRecordArray = array(
            'ESD_To'           => $checkRecordRow->User_email,
            'ESD_Email_Count'  => 1,
            'ESD_EnterprizeID' => $checkRecordRow->User_ParentId,
            'ESD_SubEnterprizeID' => $checkRecordRow->User_SubParentId,
            'ESD_From'     => $from,
            'ESD_Content' => $message,
          );
          $sendMail = $this->Common_Model->sendMailWithRecord($checkRecordRow->User_email, 'Password Requested', $message, $from, $mailRecordArray, 'Password sent via email successfully');
        }

        die(json_encode(["position" => "top-end", "showConfirmButton" => false, "timer" => 2500, "status" => "200", 'title' => "Success", 'icon' => 'success', 'message' => 'Password sent to your registered email id .']));
      }
    }
    // print_r($this->input->post()); print_r($sendMail); die(' here '); // echo json_encode(array('code'=> 200, 'postData'=> $this->input->post('User_email'), 'mailData'=> $sendMail));
  }

}