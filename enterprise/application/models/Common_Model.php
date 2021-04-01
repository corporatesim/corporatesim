<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Common_Model extends CI_Model
{

  // public function __construct()
  // {
  //  parent::__construct();
  //  $this->load->model('Common_Model');
  // }

  // first delete record the insert new record
  public function deleteInsert($tableName = NULL, $where = NULL, $insertArray = NULL)
  {
    // Starting Transaction
    $this->db->trans_start();

    // deleting Data
    $this->db->where($where);
    $this->db->delete($tableName);
    // print_r($this->db->last_query()); exit();

    // inserting Data
    $result = $this->db->insert_batch($tableName, $insertArray);
    // print_r($this->db->last_query()); exit();

    $this->db->trans_complete();
    // Completing transaction

    if ($this->db->trans_status() === FALSE) {
      // Something went wrong.
      $this->db->trans_rollback();
      return FALSE;
    } else {
      // Everything is Perfect.
      // Committing data to the database.
      $this->db->trans_commit();
      return TRUE;
    }
  }

  // finding the count of num_rows
  public function findCount($tableName = NULL, $where = NULL)
  {
    $this->db->where($where);
    $result = $this->db->get($tableName);
    // echo "<pre>"; print_r($this->db->last_query()); exit();
    // echo "<pre>"; print_r($result->num_rows()); exit();
    return $result->num_rows();
  }

    // finding the count of num_rows
    public function findCountUsingOr($tableName = NULL, $where = NULL)
    {
      $this->db->or_where($where);
      $result = $this->db->get($tableName);
      // echo "<pre>"; print_r($this->db->last_query()); // exit();
      // echo "<pre>"; print_r($result->result()); exit();
    return $result->result();
    }

  //selecting all data that exist in table 
  function SelectData($fields, $tables, $where, $order = array(), $group = array(), $limit = '', $offset = '', $print_flag = 0)
  {
    if (is_array($fields)) {
      $fields = implode(",", $fields);
    }

    if (is_array($tables)) {
      $tables = implode(",", $tables);
    }

    if (!empty($where)) {
      if (is_array($where)) {
        $where = implode(" AND ", $where);
      }
    }

    if (!empty($order)) {
      if (is_array($order)) {
        $order = implode(",", $order);
      }
    }

    if (!empty($fields)) {
      $sql = "SELECT $fields FROM $tables ";
    } else {
      $sql = "SELECT * FROM $tables ";
    }

    if (!empty($where)) {
      $sql .= ' WHERE ' . $where;
    }

    if (!empty($group)) {
      if (is_array($group)) {
        $group = implode(",", $group);
      }
      $sql .= ' GROUP BY ' . $group;
    }

    if (!empty($order)) {
      $sql .= ' ORDER BY ' . $order;
    }

    if (!empty($limit)) {
      if (!empty($offset)) {
        $sql .= ' LIMIT ' . $offset . "," . $limit;
      } else {
        $sql .= ' LIMIT ' . $limit;
      }
    }

    if ($print_flag == 1) {
      echo ($sql);
    }

    $result = $this->ExecuteQuery($sql); //Execute sql statement
    //$result = $this->executeSqlStatementQuery($sql);
    return $result;
  }

  public function batchInsert($tableName = NULL, $insertArray = NULL)
  {
    // to insert multiple data at once
    // print_r($this->db->last_query()); prd($insertArray);
    $result = $this->db->insert_batch($tableName, $insertArray);
    return $result;
  }

  //fetch record of login Enterprise
  public function fetchRecords($tableName = NULL, $where = NULL, $columnName = NULL, $order = NULL, $limit = NULL, $groupBy = NULL, $printQuery = NULL)
  {
    // die('in modal');
    if ($columnName) {
      $this->db->select($columnName);
    }
    if ($groupBy) {
      $this->db->group_by($groupBy);
    }
    if ($order) {
      $this->db->order_by($order);
    }
    if ($limit) {
      $limit = explode(',', $limit);
      $this->db->limit($limit[1], $limit[0]);
    }
    $this->db->from($tableName);
    if ($where) {
      $this->db->where($where);
    }
    $query  = $this->db->get();
    $result = $query->result();
    if ($printQuery) {
      print_r($this->db->last_query()); // exit();
    }
    return $result;
  }

  //verify login details of Enterprise
  public function verifyLogin($Users_Email = NULL, $Users_Password = NULL)
  {
    // for admin users
    $whereAdmin = array(
      'username' => $Users_Email,
      'email'    => $Users_Email,
    );
    $whereAdminPass = array(
      'password' => md5($Users_Password),
      'status'   => 1,
    );
    $this->db->select('id as User_Id,concat(fname," ",lname) as User_FullName,username as User_Username,email as User_Email,contact as User_Mobile,usertype as User_Role');
    $this->db->group_start();
    $this->db->or_where($whereAdmin);
    $this->db->group_end();
    $this->db->where($whereAdminPass);
    $resultAdmin = $this->db->get_where('GAME_ADMINUSERS')->result();

    // echo count($resultAdmin)."<pre>"; print_r($this->db->last_query()); echo "<br>"; print_r($resultAdmin); exit;
    // for non admin users
    if (count($resultAdmin) < 1) {
      // for enterprise , user role will be 1
      $entWhere = array(
        'Enterprise_Email'    => $Users_Email,
        'Enterprise_Password' => $Users_Password,
      );
      $this->db->select();
      $this->db->where($entWhere);
      $resultEnt = $this->db->get('GAME_ENTERPRISE')->result();

      // for subEnterprise, user role will be 2
      $subEntWhere = array(
        'SubEnterprise_Email'    => $Users_Email,
        'SubEnterprise_Password' => $Users_Password,
      );
      $this->db->select();
      $this->db->where($subEntWhere);
      $resultSbuEnt = $this->db->get('GAME_SUBENTERPRISE')->result();

      // for Report Viewer, user role will be 3
      $reportViewerWhere = array(
        'RV_Email_ID' => $Users_Email,
        'RV_Password' => $Users_Password,
      );
      $this->db->select();
      $this->db->where($reportViewerWhere);
      $resultReportViewer = $this->db->get('GAME_REPORT_VIEWER')->result();


      // fetch and return result
      if (count($resultEnt) > 0) {
        $resultEnt[0]->User_Role = 'enterprise';
        return $resultEnt[0];
      } 
      else if (count($resultSbuEnt) > 0) {
        $resultSbuEnt[0]->User_Role = 'subenterprise';
        return $resultSbuEnt[0];
      }
      else if (count($resultReportViewer) > 0) {
        $resultReportViewer[0]->User_Role = 'reportviewer';
        return $resultReportViewer[0];
      } 
      else {
        return 'error';
      }


      //   $this->db->select('gsu.*,ge.Enterprise_Name,gs.SubEnterprise_Name');
      //   $this->db->join('GAME_ENTERPRISE ge','ge.Enterprise_ID=gsu.User_ParentId','left');
      //   $this->db->join('GAME_SUBENTERPRISE gs','gs.SubEnterprise_ID=gsu.User_SubParentId','left');
      //   $where = array(
      //     'User_username' => $Users_Email,
      //     'User_email'    => $Users_Email,
      //   );
      //   $this->db->group_start();
      //   $this->db->or_where($where);
      //   $this->db->group_end();
      //   $this->db->where('User_Role >',0);
      //   $this->db->where('User_Delete',0);
      //   $result = $this->db->get('GAME_SITE_USERS gsu')->result();
      //  // echo count($result)."<pre>"; print_r($this->db->last_query()); echo "<br>"; print_r($result); exit;
      // // if user exist then match the password other wise user not exist game_user_authentication
      //   if(count($result) > 0)
      //   {
      //    $where = array(
      //     'Auth_userid'   => $result[0]->User_id,
      //     'Auth_password' => $Users_Password,
      //   );
      //    $this->db->where($where);
      //    $resultPassword = $this->db->get('GAME_USER_AUTHENTICATION')->result();
      //    if(count($resultPassword) > 0)
      //    {
      //     // echo "<pre>"; print_r($result); exit;
      //     return $result[0];
      //   }
      //   else
      //   {
      //     return 'error';
      //   }
      // }
      // else
      // {
      //   return 'error';
      // }
    } else {
      return $resultAdmin[0];
    }
  }

  //insert users of Enterprise/SubEnterprise
  public  function insert($tableName = NULL, $data = NULL, $check = NULL)
  {
    if (!empty($check)) {
      $this->db->where($check);
      $userData = $this->db->get($tableName)->result();
      if (count($userData) > 0) {
        // duplicate record
        return 'duplicate';
      } else {
        $this->db->insert($tableName, $data);
        // print_r($this->db->last_query());exit();
        $userId = $this->db->insert_id();
        return $userId;
      }
    } else {
      $this->db->insert($tableName, $data);
      // print_r($this->db->last_query());exit();
      $userId = $this->db->insert_id();
      return $userId;
    }
  }

  //edit password
  public function editPassword($id)
  {
    $this->db->select('*');
    $this->db->from('GAME_USER_AUTHENTICATION');
    $this->db->where('Auth_userid', $id);
    $query = $this->db->get();
    $result = $query->result();
    return $result;
    /*print_r($this->db->last_query());
    die(' here');*/
  }

  //Update Password
  public function updatePassword($id = NULL, $password = NULL)
  {
    $this->db->where('Auth_userid', $id);
    $this->db->update('GAME_USER_AUTHENTICATION', $password);
    //print_r($this->db->last_query());exit();
    return $this->db->last_query();
  }

  //Update User Details
  public function update($tableName = NULL, $id = NULL, $data = NULL, $check = NULL, $checkCol = NULL)
  {
    if ($checkCol) {
      $this->db->where("$checkCol !=", $id);
    }
    $this->db->group_start();
    $this->db->or_where($check);
    $this->db->group_end();
    $result = $this->db->get($tableName)->result();
    // echo "$checkCol<pre>"; print_r($this->db->last_query()); print_r($result); exit();
    if (count($result) > 0) {
      $return = 'duplicate';
    } else {
      $this->db->where($checkCol, $id);
      $this->db->update($tableName, $data);
      $return = 'update';
    }
    //print_r($this->db->last_query());exit();
    return $return;
  }

  // pass query as an argument to execute
  public function executeQuery($query = NULL, $noReturn = NULL)
  {
    $query  = $this->db->query($query);
    // echo "<pre>"; print_r($this->db->last_query()); print_r($result); exit();
    if ($noReturn != 'noReturn') {
      $result = $query->result();
      return $result;
    }
  }

  //random password generate for user
  function random_password()
  {
    $alphabet     = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $password     = array();
    $alpha_length = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alpha_length);
      $password[] = $alphabet[$n];
    }
    return implode($password);
  }

  //Delete Records
  public function deleteRecords($tableName = NULL, $where = NULL)
  {
    $this->db->where($where);
    $this->db->delete($tableName);
    // print_r($this->db->last_query()); exit();
  }

  //Update Records
  public function updateRecords($tableName = NULL, $data = NULL, $where = NULL, $printQuery = NULL)
  {
    $this->db->where($where);
    $affectedRows = $this->db->update($tableName, $data);
    if ($printQuery) {
      print_r($this->db->last_query());
      echo '<br>' . $affectedRows;
    }
    return $affectedRows;
  }

  public function softDelete($tableName = NULL, $data = NULL, $where = NULL)
  {
    $this->db->where($where);
    $affectedRows = $this->db->update($tableName, $data);
    if ($affectedRows > 0) {
      $this->session->set_flashdata('tr_msg', 'Record Deleted Successfully');
    } else {
      $this->session->set_flashdata('er_msg', 'Data Error Occured. Please try later');
    }
    // print_r($this->db->last_query()); exit();
    return $affectedRows;
  }

  public function send_mail($to = NULL, $subject = NULL, $message = NULL, $from = NULL, $insertArray = NULL)
  {
    // $this->load->library('email');
    // $this->email->clear();
    // $config['protocol']    = 'smtp';
    // $config['smtp_host']    = 'smtpout.asia.secureserver.net';
    // $config['smtp_port']    = '25'; // 465 for ssl
    // $config['smtp_timeout'] = '7';
    // $config['wordWrap'] = true;
    // // $config['smtp_crypto'] = 'ssl';
    // $config['smtp_user']    = 'support@corpsim.in';
    // $config['smtp_pass']    = 'richie11**';
    // $config['charset']    = 'utf-8';
    // // $config['newline']    = "\r\n";
    // $config['crlf']    = "\r\n";
    // $config['mailtype'] = 'html'; // or html
    // $config['validate'] = TRUE; // bool whether to validate email or not      
    // $this->email->set_newline("\r\n");

    // $this->email->initialize($config);

    // $this->email->to($to);
    // $this->email->from($from);
    // // $this->email->cc('another@another-example.com');
    // // $this->email->bcc('them@their-example.com');

    // $this->email->subject($subject);
    // $this->email->message($message);

    // // ESD_Status => 0->Not Sent, 1-> Sent
    // if (!$this->email->send()) {
    //   // Generate error
    //   $errorlog = $this->email->print_debugger();
    //   $errorlog = $errorlog ? $errorlog : 'Email not Send.';
    //   $insertArray['ESD_Status']  = 0;
    //   $insertArray['ESD_Content'] = $message; // body of email
    //   $insertArray['ESD_Comment'] = $errorlog; // error message
    // } else {
    //   // $errorlog = $this->email->print_debugger();
    //   $insertArray['ESD_Status'] = 1;
    //   $insertArray['ESD_Content'] = $message; // body of email
    // }
    // $result = $this->db->insert("GAME_EMAIL_SEND_DETAILS", $insertArray);
    // // $this->Common_Model->send_mail('mksahu23506@gmail.com', 'testmail', 'hello ci', 'support@corpsim.in');
    // // prd($insertArray);
  }

  public function send_mail_pdf($to=NULL, $subject=NULL, $message=NULL, $from=NULL, $pdfdirectory=NULL)
  {
    $this->load->library('email');
    $this->email->clear();
    $config['protocol']    = 'smtp';
    $config['smtp_host']    = 'smtpout.asia.secureserver.net';
    $config['smtp_port']    = '25'; // 465 for ssl
    $config['smtp_timeout'] = '7';
    $config['wordWrap'] = true;
    // $config['smtp_crypto'] = 'ssl';
    $config['smtp_user']    = 'support@corpsim.in';
    $config['smtp_pass']    = 'richie11**';
    $config['charset']    = 'utf-8';
    // $config['newline']    = "\r\n";
    $config['crlf']    = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validate'] = TRUE; // bool whether to validate email or not      
    $this->email->set_newline("\r\n");

    $this->email->initialize($config);

    $this->email->to($to);
    $this->email->from($from, 'corpsim.in');
    // $this->email->cc('another@another-example.com');
    // $this->email->bcc('them@their-example.com');

    $this->email->subject($subject);
    $this->email->message($message);
    if(!empty($pdfdirectory))
    {
      $this->email->attach($pdfdirectory);
    }

    // ESD_Status => 0->Not Sent, 1-> Sent
    if (!$this->email->send()) {
      return 0;
    //   // Generate error
    //   $errorlog = $this->email->print_debugger();
    //   $errorlog = $errorlog ? $errorlog : 'Email not Send.';
    }
    else {
      return 1;
    //   // $errorlog = $this->email->print_debugger();
    }
  }

  public function sendMailWithRecord($to=NULL, $subject=NULL, $message=NULL, $from=NULL, $mailRecordArray=NULL, $successMsg=NULL, $fromName=NULL)
  {
    // print_r($mailRecordArray);
    $this->load->library('email');
    $this->email->clear();
    $config['protocol']    = 'smtp';
    $config['smtp_host']    = 'smtpout.asia.secureserver.net';
    $config['smtp_port']    = '25'; // 465 for ssl
    $config['smtp_timeout'] = '7';
    $config['wordWrap'] = true;
    // $config['smtp_crypto'] = 'ssl';
    $config['smtp_user']    = 'support@corpsim.in';
    $config['smtp_pass']    = 'richie11**';
    $config['charset']    = 'utf-8';
    // $config['newline']    = "\r\n";
    $config['crlf']    = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validate'] = TRUE; // bool whether to validate email or not      
    $this->email->set_newline("\r\n");

    $this->email->initialize($config);

    $this->email->to($to);
    $this->email->from($from, $fromName?$fromName:'corpsim.in');
    // $this->email->cc('another@another-example.com');
    // $this->email->bcc('them@their-example.com');

    $this->email->subject($subject);
    $this->email->message($message);
    
    // ESD_Status => 0->Not Sent, 1-> Sent
    if (!$this->email->send()) {
      //   // Generate error
        $errorlog = $this->email->print_debugger();
        $errorlog = $errorlog ? $errorlog : 'Email not Send.';
      if(!empty($mailRecordArray))
      {
        // insert record to table for mail not send
        $mailRecordArray['ESD_Comment'] = $errorlog;
        $mailRecordArray['ESD_Status'] = 0;
        $this->db->insert("GAME_EMAIL_SEND_DETAILS", $mailRecordArray);
      }
      return json_encode(array('code'=>201, 'msg'=>$errorlog));
    }
    else {
      if(!empty($mailRecordArray))
      {
        // insert record to table for mail send successfully
        $mailRecordArray['ESD_Comment'] = ($successMsg) ? $successMsg : 'Email Sent Successfully';
        $mailRecordArray['ESD_Status'] = 1;
        $this->db->insert("GAME_EMAIL_SEND_DETAILS", $mailRecordArray);
      }
      return json_encode(array('code'=>200, 'msg'=>'Email Sent Successfully'));
      // $errorlog = $this->email->print_debugger();
    }
  }

  public function sendDynamicEmails($to=NULL, $subject=NULL, $message=NULL, $from=NULL, $fromName=NULL, $smuser=NULL, $smpass=NULL, $successMsg=NULL )
  {
    // print_r($mailRecordArray);
    $this->load->library('email');
    $this->email->clear();
    $config['protocol']    = 'smtp';
    $config['smtp_host']    = 'smtpout.asia.secureserver.net';
    $config['smtp_port']    = '25'; // 465 for ssl
    $config['smtp_timeout'] = '7';
    $config['wordWrap'] = true;
    // $config['smtp_crypto'] = 'ssl';
    $config['smtp_user']    = "$smuser";
    $config['smtp_pass']    = "$smpass";
    $config['charset']    = 'utf-8';
    // $config['newline']    = "\r\n";
    $config['crlf']    = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validate'] = TRUE; // bool whether to validate email or not      
    $this->email->set_newline("\r\n");

    $this->email->initialize($config);

    $this->email->to($to);
    $this->email->from($from, $fromName?$fromName:'corpsim.in');
    // $this->email->cc('another@another-example.com');
    // $this->email->bcc('them@their-example.com');

    $this->email->subject($subject);
    $this->email->message($message);
    
    // ESD_Status => 0->Not Sent, 1-> Sent
    if (!$this->email->send()) {
      //   // Generate error
        $errorlog = $this->email->print_debugger();
        $errorlog = $errorlog ? $errorlog : 'Email not Sent.';
      if(!empty($mailRecordArray))
      {
        // insert record to table for mail not send
        $mailRecordArray['ESD_Comment'] = $errorlog;
        $mailRecordArray['ESD_Status'] = 0;
        $this->db->insert("GAME_EMAIL_SEND_DETAILS", $mailRecordArray);
      }
      return json_encode(array('code'=>201, 'msg'=>$errorlog));
    }
    else {
      if(!empty($mailRecordArray))
      {
        // insert record to table for mail send successfully
        $mailRecordArray['ESD_Comment'] = ($successMsg) ? $successMsg : 'Email Sent Successfully';
        $mailRecordArray['ESD_Status'] = 1;
        $this->db->insert("GAME_EMAIL_SEND_DETAILS", $mailRecordArray);
      }
      return json_encode(array('code'=>200, 'msg'=>'Email Sent Successfully'));
      // $errorlog = $this->email->print_debugger();
    }
  }
  
}
