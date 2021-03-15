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

  function SelectData($fields, $tables, $where, $order=array(), $group=array(),$limit='',$offset='',$print_flag=0){
    if(is_array($fields)){
      $fields = implode(",",$fields);
    }

    if(is_array($tables)){
      $tables = implode(",",$tables);
    }

    if(!empty($where)){
      if(is_array($where)){
        $where = implode(" AND ", $where);
      }
    }

    if(!empty($order)){
      if(is_array($order)){
        $order = implode(",",$order);
      }
    }

    if(!empty($fields)){
      $sql = "SELECT $fields FROM $tables ";
    }
    else{
      $sql = "SELECT * FROM $tables ";
    }

    if(!empty($where)){
      $sql .= ' WHERE '.$where;
    }

    if(!empty($group)){
      if(is_array($group)){
        $group = implode(",",$group);
      }
      $sql .= ' GROUP BY '.$group;
    }

    if(!empty($order)){
      $sql .= ' ORDER BY '.$order;
    }

    if(!empty($limit)){
      if(!empty($offset)){
        $sql .= ' LIMIT '.$offset.",".$limit;
      } 
      else{
        $sql .= ' LIMIT '.$limit;
      }
    }

    if($print_flag==1){
      echo($sql);
    }

    $result = $this->ExecuteQuery($sql); //Execute sql statement
    //$result = $this->executeSqlStatementQuery($sql);
    return $result;
  }

  public function batchInsert($tableName=NULL, $insertArray=NULL)
  {
    // to insert multiple data at once
    // print_r($this->db->last_query()); prd($insertArray);
    $result = $this->db->insert_batch($tableName, $insertArray);
    return $result;
  }

  //fetch record of login Enterprise
  public function fetchRecords($tableName=NULL,$where=NULL,$columnName=NULL,$order=NULL,$limit=NULL, $groupBy=NULL, $printQuery=NULL)
  {
    // die('in modal');
    if($columnName)
    {
      $this->db->select($columnName);
    }
    if($groupBy)
    {
      $this->db->group_by($groupBy);
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
  public function verifyLogin($Users_Email=NULL,$Users_Password=NULL)
  {
    // for admin users
    $whereAdmin = array (
      'username' => $Users_Email,
      'email'    => $Users_Email,
    );
    $whereAdminPass = array (
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
    if(count($resultAdmin) < 1)
    {
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
      // fetch and return result
      if(count($resultEnt) > 0)
      {
        $resultEnt[0]->User_Role = 'enterprise';
        return $resultEnt[0];
      }
      elseif(count($resultSbuEnt) > 0)
      {
        $resultSbuEnt[0]->User_Role = 'subenterprise';
        return $resultSbuEnt[0];
      }
      else
      {
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
    }
    else
    {
      return $resultAdmin[0];
    }
  }

  //insert users of Enterprise/SubEnterprise
  public  function insert($tableName=NULL,$data=NULL,$check=NULL)
  {
    if(!empty($check))
    {
      $this->db->where($check);
      $userData = $this->db->get($tableName)->result();
      if(count($userData) > 0)
      {
        // duplicate record
        return 'duplicate';
      }
      else
      {
        $this->db->insert($tableName,$data);
        // print_r($this->db->last_query());exit();
        $userId = $this->db->insert_id();
        return $userId;
      }
    }
    else
    {
      $this->db->insert($tableName,$data);
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

//Update User Details
  public function update($tableName=NULL,$id=NULL,$data=NULL,$check=NULL,$checkCol=NULL)
  {
    if($checkCol)
    {
      $this->db->where("$checkCol !=", $id);
    }
    $this->db->group_start();
    $this->db->or_where($check);
    $this->db->group_end();
    $result = $this->db->get($tableName)->result();
    // echo "$checkCol<pre>"; print_r($this->db->last_query()); print_r($result); exit();
    if(count($result) > 0)
    {
      $return = 'duplicate';
    }
    else
    {
      $this->db->where($checkCol,$id);
      $this->db->update($tableName,$data);
      $return = 'update';
    }
    //print_r($this->db->last_query());exit();
    return $return;
  }

  // pass query as an argument to execute
  public function executeQuery($query=NULL,$noReturn=NULL)
  {
    $query  = $this->db->query($query);
    // echo "<pre>"; print_r($this->db->last_query()); print_r($result); exit();
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
public function updateRecords($tableName=NULL,$data=NULL,$where=NULL,$printQuery=NULL)
{
  $this->db->where($where);
  $affectedRows = $this->db->update($tableName,$data);
  if($printQuery)
  {
    print_r($this->db->last_query());
    echo '<br>'.$affectedRows;
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
