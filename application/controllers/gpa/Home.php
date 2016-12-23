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
		
		if (!isset($_SESSION['userid']))
		{
			$_SESSION['userid'] = '';
		}
		
		$user = $this->GPA_Model->getUser($_SESSION['userid']);
		
		if ($user == NULL)
		{
			$user = new stdClass();
			$user->open = '0';
		}
		
		$data = array('list' => $list, 'user' => $user);
		
		
		$this->load->view('gpa/index', $data);
	}
	
}
