<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GPA_Model');
	}
	
	public function index()
	{
		$userid = $this->input->get('userid');
		$name = $this->input->get('name');
		$psw = $this->input->get('psw');
		
		if ((int)($userid) == $userid && strlen($userid) == 12 || strlen($userid) == 10)
		{
			$this->GPA_Model->login($userid, $name, $psw);
			if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '')
			{
				$this->load->view('gpa/login');
			}
			else
			{
				redirect(base_url('gpa/edit'));
			}
		}
		else
		{
			$this->load->view('gpa/login');
		}
	}
	
}
