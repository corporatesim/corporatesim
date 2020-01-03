<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Model extends CI_Model {

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

  public function fetchLogo($url=NULL)
  {
    // firstly check for its logo, if exist then show, other wise check for it's parent logo

    $where_logo = array(
      'Domain_Name' => $url,
    );

    $this->db->select('Domain_Logo');
    $this->db->from('GAME_DOMAIN');
    $this->db->where($where_logo);
    $result = $this->db->get()->result();
    
    // print_r($this->db->last_query());

    if(count($result) > 0)
    {
      return $result[0]->Domain_Logo;
    }

    else
    {
      return 'default_logo.png';
      // check that this is enterprise or not, add this functionality later after discussion, curently return default logo
    }

    
    // print_r($this->db->last_query());
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
      print_r($this->db->last_query());
    }
    return $result;
  }

  //insert users of Enterprise/SubEnterprise
  public  function insert($tableName=NULL,$data=NULL,$check=NULL,$printQuery=NULL)
  {
    if($check)
    {
      $result = $this->db->get_where($tableName,$check);
      // echo "<pre>"; print_r($this->db->last_query()); print_r($result);print_r($result->num_rows()); exit();
      if($result->num_rows() < 1)
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
    }
    else
    {
      $this->db->insert($tableName,$data);
      // print_r($this->db->last_query());exit();
      if($printQuery)
      {
        print_r($this->db->last_query());
      }
      $userId = $this->db->insert_id();
      return $userId;
    }
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
 public function random_password() 
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
public function updateRecords($tableName=NULL,$data=NULL,$where=NULL,$msg=NULL)
{
  $this->db->where($where);
  $affectedRows = $this->db->update($tableName,$data);
  // print_r($this->db->last_query()); exit();
  if(empty($msg))
  {
    if($affectedRows>0)
    {
      $this->session->set_flashdata('tr_msg', 'Record Updated Successfully');
    }
    else
    {
      $this->session->set_flashdata('er_msg', 'Data Error Occured. Please try later');
    }
  }
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
