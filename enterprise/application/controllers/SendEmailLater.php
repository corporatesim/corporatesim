<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendEmailLater extends CI_Controller
{

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

  public function index()
  {
    die('not allowed');
  }
  public function mail($timestamp = NULL)
  {
    if (empty($timestamp)) {
      die('no value given');
    }

    $findSql = "SELECT gsu.User_id, gsu.User_ParentId, gsu.User_username, gsu.User_email, gua.Auth_password AS 'password', gd.Domain_Name AS domain FROM GAME_SITE_USERS gsu LEFT JOIN GAME_USER_AUTHENTICATION gua ON gua.Auth_userid = gsu.User_id LEFT JOIN GAME_DOMAIN gd ON gd.Domain_EnterpriseId = gsu.User_ParentId WHERE gsu.User_UploadCsv =".$timestamp;

    $records = $this->Common_Model->executeQuery($findSql);

    if (isset($records) && count($records) < 1) {
      die('no record found');
    }
    
    // prd($records);
    
    foreach ($records as $row) {
      $message  = "Login and password for accessing our eLearning programs and/or assessments are provided below.<br><br>";
      $message .= "URL: $row->domain<br>";
      $message .= "Login: $row->User_username<br>";
      $message .= "Password: $row->password<br>";
      $message .= "<br>Please login and verify the credentials. In case of any issue and for any other details please contact your Program Administrator.<br>";
      $message .= "<br>Regards,<br>Admin<br>Humanlinks Learning";
      $addArray = array(
        //'ESD_Content'         => $message,
        'ESD_To'              => $row->User_email,
        'ESD_Email_Count'     => 1,
        'ESD_EnterprizeID'    => $row->User_ParentId,
        'ESD_DateTime'        => date('Y-m-d H:i:s', time()),
      );
      // ESD_Status => 0->Not Send, 1-> Send
      $this->Common_Model->send_mail($row->User_email, 'Access', $message, 'support@corpsim.in', $addArray);
      // $result = $this->Common_Model->insert("GAME_EMAIL_SEND_DETAILS", $addArray, 0, 0);
    }
    die(count($records).' mail sent');
  }
}
