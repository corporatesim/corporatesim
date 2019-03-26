<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Model extends CI_Model {

  // public function __construct()
  // {
  //  parent::__construct();
  //  $this->load->model('Common_Model');
  // }

//fetch record of login Enterprise
	public function fetchRecords($tableName=NULL,$where=NULL,$columnName=NULL,$order=NULL,$limit=NULL)
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
		$this->db->where($where);
		$query  = $this->db->get();
		$result = $query->result();
    //print_r($this->db->last_query()); exit();
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
      $this->db->select('gsu.*,ge.Enterprise_Name,gs.SubEnterprise_Name');
      $this->db->join('GAME_ENTERPRISE ge','ge.Enterprise_ID=gsu.User_ParentId','left');
      $this->db->join('GAME_SUBENTERPRISE gs','gs.SubEnterprise_ID=gsu.User_SubParentId','left');
      $where = array(
        'User_username' => $Users_Email,
        'User_email'    => $Users_Email,
      );
      $this->db->group_start();
      $this->db->or_where($where);
      $this->db->group_end();
      $this->db->where('User_Role >',0);
      $this->db->where('User_Delete',0);
      $result = $this->db->get('GAME_SITE_USERS gsu')->result();
     // echo count($result)."<pre>"; print_r($this->db->last_query()); echo "<br>"; print_r($result); exit;
    // if user exist then match the password other wise user not exist game_user_authentication
      if(count($result) > 0)
      {
       $where = array(
        'Auth_userid'   => $result[0]->User_id,
        'Auth_password' => $Users_Password,
      );
       $this->db->where($where);
       $resultPassword = $this->db->get('GAME_USER_AUTHENTICATION')->result();
       if(count($resultPassword) > 0)
       {
        // echo "<pre>"; print_r($result); exit;
        return $result[0];
      }
      else
      {
        return 'error';
      }
    }
    else
    {
      return 'error';
    }
  }
  else
  {
    return $resultAdmin[0];
  }
}

  //insert users of Enterprise/SubEnterprise
public  function insert($tableName=NULL,$data=NULL,$check=NULL)
{
  $this->db->insert($tableName,$data);
		// print_r($this->db->last_query());exit();
  $userId = $this->db->insert_id();
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
  		$this->db->where('User_Id',$id);
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
   $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
   $password = array(); 
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
  $this->db->update($tableName,$data);
  return $this->db->last_query();
}

}