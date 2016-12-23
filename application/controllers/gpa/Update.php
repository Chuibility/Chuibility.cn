<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GPA_Model');
	}
	
	public function index()
	{
		$data = array(
			array('VG100', 4, 1),
			array('VG101', 4, 1),
			
			array('VV156', 4, 1),
			array('VV186', 4, 1),
			array('VV255', 4, 1),
			array('VV285', 4, 1),
			array('VV256', 4, 1),
			array('VV286', 4, 1),
			
			array('VC210', 4, 1),
			array('VC211', 1, 1),
			array('VP140', 4, 1),
			array('VP160', 4, 1),
			array('VP141', 1, 1),
			array('VP240', 4, 1),
			array('VP260', 4, 1),
			array('VP241', 1, 1),
			
			array('VE203', 4, 1),
			array('VE215', 4, 1),
			array('VE216', 4, 1),
			array('VE270', 4, 1),
			array('VE280', 4, 1),
			array('VE281', 4, 1),
			array('VE370', 4, 1),
			array('VE401', 4, 1),
			array('VE477', 4, 1),
			array('VE482', 4, 1),
			
			array('VM010', 1, 1),
			array('VM211', 4, 1),
			array('VM235', 3, 1),
			
			
			array('VY100', 4, 0),
			array('VY200', 4, 0),
			array('VR261', 3, 0),
			array('VR275', 3, 0),
			array('VR280', 3, 0),
			array('VR310', 3, 0),
			
			
			array('PE001', 1, 0),
			array('PE002', 1, 0),
			array('PE003', 1, 0),
			array('PE004', 1, 0),
			
			array('TH000', 3, 0),
			array('TH004', 1, 0),
			array('TH007', 3, 0),
			array('TH012', 6, 0),
			array('TH021', 2, 0),
			array('TH009-1', 1, 0),
			array('TH009-2', 1, 0),
			array('TH009-3', 1, 0),
			array('TH009-4', 1, 0),
		
		
		);
		print_r($this->GPA_Model->setAllCourse($data));
	}
	
}
