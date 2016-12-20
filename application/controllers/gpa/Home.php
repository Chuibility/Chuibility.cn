<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GPA_Model');
	}
	
	public function index()
	{
		$list = $this->GPA_Model->getGPAList();
		
		$data = array('list' => $list);
		
		$this->load->view('gpa/index', $data);
	}
	
}
