<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_Model extends CI_Model {

  // public function __construct()
  // {
  //  parent::__construct();
  //  $this->load->model('Common_Model');
  // }

  // finding the count of num_rows
  public function findCount($tableName=NULL,$where=NULL)
  {
    $this->db->where($where);
    $result = $this->db->get($tableName);
    // echo "<pre>"; print_r($this->db->last_query()); exit();
    // echo "<pre>"; print_r($result->num_rows()); exit();
    return $result->num_rows();
  }

//fetch record of login Enterprise
  public function fetchRecords($tableName=NULL,$where=NULL,$columnName=NULL,$order=NULL,$limit=NULL,$printQuery=NULL)
  {
    // die('in modal');
    if($columnName)
    {
      $this->db->select($columnName);
    }
    if($order)
    {
      $this->db->order_by($order);
    }
    if($limit)
    {
      $limit = explode(',',$limit);
      $this->db->limit($limit[1],$limit[0]);
    }
    $this->db->from($tableName);
    if($where)
    {
      $this->db->where($where);
    }
    $query  = $this->db->get();
    $result = $query->result();
    if($printQuery)
    {
      print_r($this->db->last_query()); // exit();
    }
    return $result;
  }

//verify login details of Enterprise
  public function verifyLogin($User_email=NULL,$Auth_password=NULL)
  {
    // to check the user details and set the session, also check user for their registered domains
    $whereEmail = array(
      'User_email'    => $User_email,
      'User_username' => $User_email,
    );

    $this->db->or_where($whereEmail);
    $result = $this->db->get('GAME_SITE_USERS')->result();
    // print_r($result); exit();
    if(count($result) > 0)
    {
      // user email/username verified now verify the password
      $wherePassword = array(
        'Auth_password' => $Auth_password,
        'Auth_userid'   => $result[0]->User_id,
      );
      $this->db->where($wherePassword);
      $resultAuth = $this->db->get('GAME_USER_AUTHENTICATION')->result();
      // print_r($this->db->last_query()); exit();
      if(count($resultAuth) > 0)
      {
        // user verified
        $this->session->set_userdata('botUserData',$result[0]);
        return ["status" => "200"];
      }
      else
      {
        return ["status" => "201"];
      }
    }
    else
    {
      return ["status" => "201"];
    }
  }

  //insert users of Enterprise/SubEnterprise
  public  function insert($tableName=NULL,$data=NULL,$check=NULL,$printQuery=NULL)
  {
    $this->db->insert($tableName,$data);
    // print_r($this->db->last_query());exit();
    $userId = $this->db->insert_id();
    if($printQuery)
    {
      print_r($this->db->last_query()); // exit();
    }
    return $userId;
  }

//edit password
  public function editPassword($id)
  {   
    $this->db->select('*');
    $this->db->from('GAME_USER_AUTHENTICATION');
    $this->db->where('Auth_userid',$id);  
    $query=$this->db->get();
    $result = $query->result();
    return $result;
    /*print_r($this->db->last_query());
    die(' here');*/
  }

//Update Password
  public function updatePassword($id=NULL,$password=NULL)
  {
    $this->db->where('Auth_userid',$id);
    $this->db->update('GAME_USER_AUTHENTICATION',$password);
    //print_r($this->db->last_query());exit();
    return $this->db->last_query();
  }

  // pass query as an argument to execute
  public function executeQuery($query=NULL,$noReturn=NULL)
  {
    $query = $this->db->query($query);
    // echo "<pre>"; print_r($this->db->last_query()); print_r($query); exit();
    if($noReturn != 'noReturn')
    {
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
   for ($i = 0; $i < 8; $i++) 
   {
    $n = rand(0, $alpha_length);
    $password[] = $alphabet[$n];
  }
  return implode($password); 
}

 //Delete Records
public function deleteRecords($tableName=NULL,$where=NULL)
{
 $this->db->where($where);
 $this->db->delete($tableName);
    // print_r($this->db->last_query()); exit();
}

 //Update Records
public function updateRecords($tableName=NULL,$data=NULL,$where=NULL)
{
  $this->db->where($where);
  $affectedRows = $this->db->update($tableName,$data);
  // print_r($this->db->last_query()); exit();
  return $affectedRows;
}

public function softDelete($tableName=NULL,$data=NULL,$where=NULL)
{
  $this->db->where($where);
  $affectedRows = $this->db->update($tableName,$data);
  if($affectedRows>0)
  {
    $this->session->set_flashdata('tr_msg', 'Record Deleted Successfully');
  }
  else
  {
    $this->session->set_flashdata('er_msg', 'Data Error Occured. Please try later');
  }
  // print_r($this->db->last_query()); exit();
  return $affectedRows;
}

}
