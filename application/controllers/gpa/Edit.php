<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GPA_Model');
	}
	
	public function calculate()
	{
		if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '')
		{
			redirect(base_url('gpa'));
		}
		
		$result = $this->GPA_Model->calculate();
		
		print_r($result);
	}
	
	public function remove()
	{
		if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '')
		{
			redirect(base_url('gpa'));
		}
		
		$courseid = $this->input->get('courseid');
		
		$this->GPA_Model->removeData($courseid);
		
		$this->GPA_Model->calculate();
		
		redirect(base_url('gpa/edit'));
		
	}
	
	public function submit()
	{
		if (!isset($_SESSION['userid']) || $_SESSION['userid'] == '')
		{
			redirect(base_url('gpa'));
		}
		
		$courseid = $this->input->get('courseid');
		
		$grade = $this->input->get('grade');
		
		$course = $this->GPA_Model->getAllCourse();
		$grade_list = array(
			'A+' => 43,
			'A'  => 40,
			'A-' => 37,
			'B+' => 33,
			'B'  => 30,
			'B-' => 27,
			'C+' => 23,
			'C'  => 20,
			'C-' => 17,
			'D'  => 10,
			'F'  => 0
		);
		
		if (in_array($courseid, $course) && in_array($grade, $grade_list))
		{
			$this->GPA_Model->addData($courseid, $grade_list[$grade]);
		}
		
		$this->GPA_Model->calculate();
		redirect(base_url('gpa/edit'));
	}
	
	public function index()
	{
		//$_SESSION['userid'] = '515370910207';
		
		$cal = $this->GPA_Model->calculate();
		
		$gpa_list = $cal['result'];
		$gpa = $cal['data'];
		
		$course = $this->GPA_Model->getAllCourse();
		
		$gpa_course = array();
		
		//print_r($gpa_list);
		
		foreach ($gpa_list as $item)
		{
			$gpa_course[] = $item->courseid;
		}
		
		
		foreach ($course as $key => $value)
		{
			if (in_array($value, $gpa_course))
			{
				unset($course[$key]);
			}
		}
		
		//print_r($gpa_list);
		
		$data = array(
			'course'   => $course,
			'gpa_list' => $gpa_list,
			'gpa'      => $gpa
		);
		
		$this->load->view('gpa/edit', $data);
	}
	
}
