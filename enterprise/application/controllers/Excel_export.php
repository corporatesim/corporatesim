<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_export extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    if($this->session->userdata('loginData') == NULL)
    {
      $this->session->set_flashdata('er_msg', 'You need to login to see the dashboard');
      redirect('Login/login');
    }
  }
  //Download SubEnterprise user details
  function downloadExcel($filterID=NULL)
  {
    // if $filterID>0 then apply filter to download
    $this->load->library("excel");
    $object = new PHPExcel();

    $object->setActiveSheetIndex(0);

    $table_columns = array("User ID", "User First Name", "User Last Name", "Username","User_mobile","User_email","Enterprise Name","SubEnterprise Name");

    $column = 0;

    foreach($table_columns as $field)
    {
     $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
     $column++;
   }
   $User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
   $User_SubParentId = $this->session->userdata('loginData')['User_SubParentId'];
    //print_r($User_ParentId);exit();
   if($this->session->userdata('loginData')['User_Role']==1)
   {
    
    if($filterID > 0)
    {
      //$where['User_SubParentId'] = $filterID;
      $query = "SELECT gu.*, gs.*, ge.* FROM GAME_SITE_USERS AS gu LEFT JOIN GAME_SUBENTERPRISE AS gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE AS ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_ParentId = $User_ParentId AND User_SubParentId = $filterID AND User_Role = 2 AND User_Delete = 0";
    }
    else
    {
      $query = "SELECT gu.*, gs.*, ge.* FROM GAME_SITE_USERS AS gu LEFT JOIN GAME_SUBENTERPRISE AS gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE AS ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_ParentId = $User_ParentId  AND User_Role = 2 AND User_Delete = 0 ";
    }
  }
  else
  {
   $query = "SELECT gu.*, gs.*, ge.* FROM GAME_SITE_USERS AS gu LEFT JOIN GAME_SUBENTERPRISE AS gs ON gu.User_SubParentId = gs.SubEnterprise_ID LEFT JOIN GAME_ENTERPRISE AS ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_SubParentId = $User_SubParentId AND User_Role = 2 AND User_Delete = 0";
  }
  $userDetails = $this->Common_Model->executeQuery($query);
  
  $excel_row = 2;

  foreach($userDetails as $row)
  {
   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->User_id);
   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->User_fname);
   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->User_lname);
   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->User_username);
   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->User_mobile);
   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->User_email);
   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->Enterprise_Name);
   $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->SubEnterprise_Name);
   $excel_row++;
 }

 $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="SubEnterpriseUserData.xls"');
 $object_writer->save('php://output');
}

//Download Enterprise User Details
function downloadEnterpriseUser()
{
  $this->load->library("excel");
  $object = new PHPExcel();

  $object->setActiveSheetIndex(0);

  $table_columns = array("User ID", "User First Name", "User Last Name", "Username","User_mobile","User_email","Enterprise Name","Created On","Created By");

  $column = 0;

  foreach($table_columns as $field)
  {
    $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
    $column++;
  }

  //select Enteprise User detail for download
  $User_ParentId = $this->session->userdata('loginData')['User_ParentId'];
  $query = "SELECT gu.*, ge.* FROM GAME_SITE_USERS gu LEFT JOIN GAME_ENTERPRISE ge ON gu.User_ParentId = ge.Enterprise_ID WHERE User_ParentId = $User_ParentId AND User_Role = 1 AND User_Delete = 0";
  $userDetails = $this->Common_Model->executeQuery($query);
  $excel_row = 2;

  foreach($userDetails as $row)
  {
    $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->User_id);
    $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->User_fname);
    $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->User_lname);
    $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->User_username);
    $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->User_mobile);
    $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->User_email);
    $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->Enterprise_Name);
    $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->Enterprise_CreatedOn);
    $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->Enterprise_CreatedBy);
    $excel_row++;
  }

  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header('Content-Disposition: attachment;filename="EnterpriseUserData.xls"');
  $object_writer->save('php://output');
}

//Download SubEnterprise details
function downloadSubEnterprise($filterID=NULL)
{
    // if $filterID>0 then apply filter to download
  $this->load->library("excel");
  $object = new PHPExcel();

  $object->setActiveSheetIndex(0);

  $table_columns = array("SubEnterprise ID","Enterprise Name","SubEnterprise Name","Created On","Created By");

  $column = 0;

  foreach($table_columns as $field)
  {
   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
   $column++;
 }
 $SubEnterprise_EnterpriseID = $this->session->userdata('loginData')['User_ParentId'];
 if($filterID > 0)
 {
  $query = "SELECT * FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID LEFT JOIN GAME_ADMINUSERS ga ON ga.id=gs.SubEnterprise_CreatedBy OR ga.id=gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_SITE_USERS gu ON gu.User_id =gs.SubEnterprise_CreatedBy OR gu.User_id = gs.SubEnterprise_UpdatedBy  WHERE SubEnterprise_EnterpriseID = $SubEnterprise_EnterpriseID AND SubEnterprise_ID=$filterID AND SubEnterprise_Status = 0 ";
}
else
{
  $query = "SELECT * FROM GAME_SUBENTERPRISE gs LEFT JOIN GAME_ENTERPRISE ge ON gs.SubEnterprise_EnterpriseID = ge.Enterprise_ID LEFT JOIN GAME_ADMINUSERS ga ON ga.id = gs.SubEnterprise_CreatedBy OR ga.id = gs.SubEnterprise_UpdatedBy LEFT JOIN GAME_SITE_USERS gu ON gu.User_id =gs.SubEnterprise_CreatedBy OR gu.User_id =gs.SubEnterprise_UpdatedBy  WHERE SubEnterprise_EnterpriseID = $SubEnterprise_EnterpriseID AND SubEnterprise_Status = 0 ";
}
$subEnterpriseDetails  = $this->Common_Model->executeQuery($query);
$excel_row = 2;

foreach($subEnterpriseDetails as $row)
{
 $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->SubEnterprise_ID);
 $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->Enterprise_Name);
 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->SubEnterprise_Name);
 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->SubEnterprise_CreatedOn);
 $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->SubEnterprise_CreatedBy);
 $excel_row++;
}

$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SubEnterpriseDetails.xls"');
$object_writer->save('php://output');
}

}
