<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends MY_Controller {

  public function __construct() {
    parent::__construct();
    if ($this->session->userdata('loginData') == NULL) {
      $this->session->set_flashdata('er_msg', 'Session Expired. Please Login');
      redirect('Login/login');
    }
  }

  public function index() {
    $ID = $this->session->userdata('loginData')['User_ParentId'];

    $query = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Category, gg.Game_Header, gg.Game_Image, gg.Game_Comments, gec.EC_ID, gec.EC_GameID, gec.EC_Enterprise_Selected 
    FROM GAME_ENTERPRISE_CARD gec 
    LEFT JOIN GAME_GAME gg ON gec.EC_GameID = gg.Game_ID AND gec.EC_EnterpriseID = $ID 
    WHERE gg.Game_Delete = 0 
    ORDER BY gec.EC_Enterprise_Selected DESC, gec.EC_ID DESC , gg.Game_Name ASC";
    $assignCards = $this->Common_Model->executeQuery($query);

    $content['assignCards'] = $assignCards;

    $content['subview'] = 'associatedCard';
    $this->load->view('main_layout',$content);
  }

  public function myAssociatedCard() {
    $ID = $this->session->userdata('loginData')['User_ParentId'];

    $query = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Category, gg.Game_Header, gg.Game_Image, gec.EC_ID, gec.EC_GameID, gec.EC_Enterprise_Selected 
    FROM GAME_ENTERPRISE_CARD gec 
    LEFT JOIN GAME_GAME gg ON gec.EC_GameID = gg.Game_ID AND gec.EC_EnterpriseID = $ID 
    WHERE gg.Game_Delete = 0 AND gec.EC_Enterprise_Selected = 1 
    ORDER BY gec.EC_Enterprise_Selected DESC, gec.EC_ID DESC , gg.Game_Name ASC";
    $assignCards = $this->Common_Model->executeQuery($query);

    $content['assignCards'] = $assignCards;

    $content['subview'] = 'myAssociatedCard';
    $this->load->view('main_layout',$content);
  }

  public function associateCardsWithEnterprise() {
    $ID = $this->session->userdata('loginData')['User_ParentId'];

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // echo "<pre>"; print_r($this->input->post()); exit();

      $assignCards = $this->input->post('assigncards');
      $cardcount   = count($assignCards);
      // $cardEnterpriseSelectedID  = $this->input->post('cardEnterpriseSelectedID');
      // print_r($cardEnterpriseSelectedID); exit();
      // echo "<pre>"; print_r($assignCards); print_r($cardcount); exit();
      
      // removing all cards from selected
      $removeWhere   = array('EC_EnterpriseID' => $ID);
      $removeArray   = array('EC_Enterprise_Selected' => 0);
      $removedResult = $this->Common_Model->updateRecords('GAME_ENTERPRISE_CARD', $removeArray, $removeWhere);

      if ($cardcount > 0) {
        // update selected Card
        for ($j=0; $j<$cardcount; $j++) {
          $updateWhere = array('EC_GameID' => $assignCards[$j]);
          $updateArray = array('EC_Enterprise_Selected' => 1);

          $result = $this->Common_Model->updateRecords('GAME_ENTERPRISE_CARD', $updateArray, $updateWhere);
        }
        // Updated Enterprise Card 
        if ($result) {
          // query to fetch all selected cards by enterprise
          $querySelectedCards = "SELECT gg.Game_Name, gg.Game_Category 
          FROM GAME_ENTERPRISE_CARD gec 
          LEFT JOIN GAME_GAME gg ON gec.EC_GameID = gg.Game_ID AND gec.EC_EnterpriseID = $ID 
          WHERE gg.Game_Delete = 0 AND gec.EC_Enterprise_Selected = 1 
          ORDER BY gg.Game_Name ASC";
          $selectedCards = $this->Common_Model->executeQuery($querySelectedCards);
          // print_r($selectedCards); exit();

          $selectedCards = '';
          $noOfCads = 0;
          foreach ($selectedCards AS $detailsRow) {
            $noOfCads++;
            // $noOfCads = $noOfCads+1;
            $selectedCards .="<br>".$noOfCads."- ".$detailsRow->Game_Name." (".$detailsRow->Game_Category.")";
          }
          // print_r($selectedCards); exit();

          $queryEnterpriseDetails = "SELECT ge.Enterprise_Name, ge.Enterprise_Email 
          FROM GAME_ENTERPRISE ge 
          WHERE ge.Enterprise_ID = $ID";
          $enterpriseDetails = $this->Common_Model->executeQuery($queryEnterpriseDetails);
          // print_r($enterpriseDetails[0]->Enterprise_Email); exit();
          //===========================================

          if (!empty($enterpriseDetails[0]->Enterprise_Email)) {
            try {
              $from = $enterpriseDetails[0]->Enterprise_Email;
              $to   = "support@corpsim.in";

              $subject = 'Card Selection  '. $enterpriseDetails[0]->Enterprise_Name;
              $message = "Enterprize- ". $enterpriseDetails[0]->Enterprise_Name ."<br>Details of Cards selected:<br><br>Total number of selected Cards- ". $noOfCads ."<br>Titles of selected Cards-<br>". $selectedCards ."";

              $addArray = array(
                'ESD_To'           => $to,
                'ESD_Email_Count'  => 1,
                'ESD_EnterprizeID' => $ID,
                'ESD_DateTime'     => date('Y-m-d H:i:s', time()),
              );

              // ESD_Status => 0->Not Send, 1-> Send
              $this->Common_Model->send_mail($to, $subject, $message, $from, $addArray);
            }
            catch (Exception $e) {
              // var_dump($this->email);
              log_message('error', $e->getMessage());
              // echo "Message could not be sent.$e";
              // show_error($this->email->print_debugger());
            }
            $this->session->set_flashdata("tr_msg", "Card Choosen Successfully");
            redirect('Card/myAssociatedCard');
          }
          else {
            // email not set for this enterprise
            // $result = 'emailNotSet';
            // echo json_encode($result);
            $this->session->set_flashdata("er_msg", "Please set email in your profile.");
            redirect('Card/myAssociatedCard');
          }
          // echo $this->email->print_debugger();
          //===========================================
          // $this->session->set_flashdata("tr_msg", "Card Choosen Successfully.");
          // redirect('Card/myAssociatedCard');
        }
      }
      else {
        $this->session->set_flashdata('tr_msg', 'Card De-allocated Successfully');
        redirect('Card/myAssociatedCard');
      }
    }
  }

  // assign Card to Enterprise
  public function assignCards($ID=NULL, $userType=NULL) {
    // ID will be EnterpriseID
    $ID       = base64_decode($ID);
    $userType = base64_decode($userType);
    $type     = '';

    // Showing Card for Enterprise
    if ($userType == 'Enterprise') {
      $type  = 'Enterprise';

      // $query = "SELECT gg.Game_ID, ge.Enterprise_ID, ge.Enterprise_Name, gg.Game_Name, gec.EC_GameID 
      // FROM GAME_ENTERPRISE_GAME geg 
      // LEFT JOIN GAME_ENTERPRISE ge ON geg.EG_EnterpriseID = ge.Enterprise_ID 
      // LEFT JOIN GAME_GAME gg ON geg.EG_GameID = gg.Game_ID 
      // LEFT JOIN GAME_ENTERPRISE_CARD gec ON gg.Game_ID = gec.EC_GameID 
      // WHERE ge.Enterprise_ID = $ID 
      // ORDER BY gg.Game_Name ASC";

      $query = "SELECT gg.Game_ID, gg.Game_Name, gg.Game_Category, gg.Game_Header, gg.Game_Image, gec.EC_ID, gec.EC_GameID, gec.EC_Enterprise_Selected 
      FROM GAME_GAME gg 
      LEFT JOIN GAME_ENTERPRISE_CARD gec ON gec.EC_GameID = gg.Game_ID AND gec.EC_EnterpriseID = $ID 
      WHERE gg.Game_Delete = 0 
      ORDER BY gec.EC_Enterprise_Selected DESC, gec.EC_ID DESC , gg.Game_Name ASC";

      //query to select enterprise name
      $queryEnterprise = "SELECT ge.Enterprise_Name 
      FROM GAME_ENTERPRISE ge 
      WHERE ge.Enterprise_ID = $ID";
    }
    $assignCards = $this->Common_Model->executeQuery($query);
    $assignCardsEnterprise = $this->Common_Model->executeQuery($queryEnterprise);
    // print_r($query); exit();
    // print_r($assignCards); exit();
    // print_r($assignCardsEnterprise[0]->Enterprise_Name); exit();

    $content['assignCards'] = $assignCards;
    $content['assignCardsEnterprise'] = $assignCardsEnterprise[0]->Enterprise_Name;

    $content['type'] = $type;

    $RequestMethod = $this->input->server('REQUEST_METHOD');
    if ($RequestMethod == 'POST') {
      // echo "<pre>"; print_r($this->input->post()); exit();

      $assignCards               = $this->input->post('assigncards');
      $cardEnterpriseSelectedID  = $this->input->post('cardEnterpriseSelectedID');
      $enterpriseID              =  $ID;
      $cardcount                 = count($assignCards);
      // print_r($cardEnterpriseSelectedID); exit();
      // echo "<pre>"; print_r($assignCards); print_r($enterpriseID); print_r($cardcount); exit();

      // insert Card
      if ($userType=='Enterprise') {
        // delete Old Assigned Card for enterprise
        $where['EC_EnterpriseID'] = $enterpriseID;
        $this->Common_Model->deleteRecords('GAME_ENTERPRISE_CARD', $where);
        
        // manage array for Card
        if ($cardcount > 0) {

          // Insert New Assigned Card for enterprise
          for ($j=0; $j<$cardcount; $j++) {
            $insertEnterpriseCard = array(
              'EC_EnterpriseID'        => $enterpriseID,
              'EC_GameID'              => $assignCards[$j],
              'EC_CreatedOn'           => date('Y-m-d H:i:s'),
              'EC_CreatedBy'           => $this->session->userdata('loginData')['User_Id'],
              'EC_Enterprise_Selected' => $cardEnterpriseSelectedID[$j],
            );
            // print_r($insertEnterpriseCard);exit();
            $result = $this->Common_Model->insert('GAME_ENTERPRISE_CARD', $insertEnterpriseCard);
          }
          // Update Enterprise Card 
          if ($result) {
            usleep(1000000); //1 Sec sleep

            // query to fetch all assigned cards to enterprise
            $queryAssignedCards = "SELECT gg.Game_Name, gg.Game_Category 
            FROM GAME_ENTERPRISE_CARD gec 
            LEFT JOIN GAME_GAME gg ON gec.EC_GameID = gg.Game_ID AND gec.EC_EnterpriseID = $ID
            WHERE gg.Game_Delete = 0 
            ORDER BY gg.Game_Name ASC";
            $assignedCards = $this->Common_Model->executeQuery($queryAssignedCards);
            // print_r($assignedCards); exit();

            $emailAssignedCard = '';
            $noOfCads = 0;
            foreach ($assignedCards AS $detailsRow) {
              $noOfCads++;
              // $noOfCads = $noOfCads+1;
              $emailAssignedCard .= "<br>".$noOfCads."- ".$detailsRow->Game_Name." (".$detailsRow->Game_Category.")";
            }
            // print_r($emailAssignedCard); exit();

            $queryEnterpriseDetails = "SELECT ge.Enterprise_Name, ge.Enterprise_Email, gd.Domain_Name 
            FROM GAME_ENTERPRISE ge 
            LEFT JOIN GAME_DOMAIN gd ON ge.Enterprise_ID = gd.Domain_EnterpriseId 
            WHERE ge.Enterprise_ID = $ID AND gd.Domain_SubEnterpriseId IS NULL";
            $enterpriseDetails = $this->Common_Model->executeQuery($queryEnterpriseDetails);
            // print_r($enterpriseDetails[0]->Enterprise_Email); exit();
            //===========================================

            if (!empty($enterpriseDetails[0]->Enterprise_Email)) {
              try {
                // $from_email = "support@corporatesim.com";
                $to = $enterpriseDetails[0]->Enterprise_Email;

                // $subject = 'Assigned Cards';
                $message = "Dear Process Owner, <br>Details of Cards assigned to you are provided below: <br><br>Total no of Assigned Cards- ". $noOfCads ."<br>Title of the Cards are: <br>". $emailAssignedCard ."<br>Please login to your account, click on Card Box and choose Select Cards.<br>You can select your Cards from here.<br>Your login details are same as those sent to you before.<br><br>In case of any query please feel free to contact us.<br>Admin<br>Humanlinks Learning";

                $addArray = array(
                  'ESD_To'           => $to,
                  'ESD_Email_Count'  => 1,
                  'ESD_EnterprizeID' => $enterpriseID,
                  'ESD_DateTime'     => date('Y-m-d H:i:s', time()),
                );

                // ESD_Status => 0->Not Send, 1-> Send
                $this->Common_Model->send_mail($to, 'Assigned Cards', $message, 'support@corpsim.in', $addArray);
              }
              catch (Exception $e) {
                // var_dump($this->email);
                log_message('error', $e->getMessage());
                // echo "Message could not be sent.$e";
                // show_error($this->email->print_debugger());
              }
              $this->session->set_flashdata("tr_msg", "Card Assigned Successfully");
              redirect('Enterprise/');
            } 
            else {
              // email not set for this enterprise
              // $result = 'emailNotSet';
              // echo json_encode($result);
              $this->session->set_flashdata("er_msg", "Email ID is not set in enterprize profile.");
              redirect('Enterprise/');
            }
            // echo $this->email->print_debugger();
            //===========================================
            $this->session->set_flashdata("tr_msg", "Card Assigned Successfully");
            redirect('Enterprise');
          }
        }
        else {
          $this->session->set_flashdata('tr_msg', 'Card De-allocated Successfully');
          redirect('Enterprise');
        }
      }
    }
    $content['subview'] = 'assignCards';
    $this->load->view('main_layout', $content);
  }

}
