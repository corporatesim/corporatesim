<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('includes/header');
$this->load->view('includes/navigation');
$this->load->view('components/'.$subview);
$this->load->view('includes/footer');
