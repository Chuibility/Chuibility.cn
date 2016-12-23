<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GPA_Model extends CI_Model
{
	public function setAllCourse($data)
	{
		$this->db->truncate('course');
		foreach ($data as $key => $value)
		{
			$data[$key] = array(
				'courseid' => $data[$key][0],
				'credit'   => $data[$key][1],
				'core'     => $data[$key][2],
			);
		}
		$this->db->insert_batch('course', $data);
		$query = $this->db->get('user');
		foreach ($query->result() as $item)
		{
			$this->calculate($item->userid);
		}
		return $data;
	}
	
	public function getAllCourse()
	{
		$query = $this->db->select('*')->from('course')->order_by('courseid', 'ASC')->get();;
		$course = array();
		foreach ($query->result() as $value)
		{
			$course[] = $value->courseid;
		}
		return $course;
	}
	
	public function addData($courseid, $grade)
	{
		//print_r($courseid);
		$query = $this->db->get_where('gpalist', array('courseid' => $courseid, 'userid' => $_SESSION['userid']));
		if ($query->num_rows() > 0)
		{
			$this->db->update('gpalist', array('grade' => $grade),
			                  array('courseid' => $courseid, 'userid' => $_SESSION['userid']));
		}
		else
		{
			$this->db->insert('gpalist', array(
				'courseid' => $courseid,
				'userid'   => $_SESSION['userid'],
				'grade'    => $grade));
		}
	}
	
	public function removeData($courseid)
	{
		$this->db->delete('gpalist', array('courseid' => $courseid, 'userid' => $_SESSION['userid']));
	}
	
	public function calculate($userid = '')
	{
		if ($userid == '')
		{
			$userid = $_SESSION['userid'];
		}
		$data = array(
			'core_grade'   => 0,
			'total_grade'  => 0,
			'core_credit'  => 0,
			'total_credit' => 0,
			'core_gpa'     => '0.00',
			'total_gpa'    => '0.00'
		);
		
		$letter_list = array(
			'43' => 'A+',
			'40' => 'A',
			'37' => 'A-',
			'33' => 'B+',
			'30' => 'B',
			'27' => "B-",
			'23' => 'C+',
			'20' => 'C',
			'17' => 'C-',
			'10' => 'D',
			'0'  => 'F'
		);
		
		$query = $this->db->select('*')->from('gpalist')->where(array('userid' => $userid))
		                  ->order_by('courseid', 'ASC')->get();
		$result = $query->result();
		foreach ($result as $key => $item)
		{
			$query = $this->db->get_where('course', array('courseid' => $item->courseid));
			if ($query->num_rows() > 0)
			{
				$row = $query->row(0);
				
				$result[$key]->credit = $row->credit;
				$result[$key]->core = $row->core;
				$result[$key]->letter = $letter_list[$item->grade];
				
				$data['total_grade'] += min(40, $item->grade) * $row->credit;
				$data['total_credit'] += $row->credit;
				
				if ($row->core == '1')
				{
					$data['core_grade'] += min(40, $item->grade) * $row->credit;
					$data['core_credit'] += $row->credit;
				}
			}
		}
		
		if ($data['core_credit'] > 0)
		{
			$data['core_gpa'] = $data['core_grade'] / 10 / $data['core_credit'];
		}
		
		if ($data['total_credit'] > 0)
		{
			$data['total_gpa'] = $data['total_grade'] / 10 / $data['total_credit'];
		}
		
		$query = $this->db->update('user', array(
			'core_gpa'     => $data['core_gpa'],
			'core_credit'  => $data['core_credit'],
			'total_gpa'    => $data['total_gpa'],
			'total_credit' => $data['total_credit'],),
		                           array('userid' => $userid));
		
		
		return array('result' => $result, 'data' => $data);
		
	}
	
	public function getGPAList()
	{
		$query = $this->db->select('*')->from('user')->order_by('core_gpa', 'DESC')->get();
		return $query->result();
	}
	
	public function login($userid, $name, $psw)
	{
		$query = $this->db->get_where('user', array('userid' => $userid));
		if ($query->num_rows() > 0)
		{
			$user = $query->row(0);
			if ($user->psw == '' && $psw != '')
			{
				$this->db->update('user', array('psw' => md5($psw)), array('userid' => $userid));
			}
			else if ($user->psw != md5($psw))
			{
				$_SESSION['userid'] = '';
				return;
			}
			$_SESSION['userid'] = $userid;
			if ($name != '')
			{
				$this->db->update('user', array('name' => $name), array('userid' => $userid));
			}
		}
		else if ($this->db->insert('user', array(
			'userid'     => $userid,
			'name'       => $name,
			'psw'        => md5($psw),
			'open'       => '0',
			'chuibility' => '0'))
		)
		{
			$_SESSION['userid'] = $userid;
		}
	}
	
	public function open($flag)
	{
		$this->db->update('user', array('open' => $flag), array('userid' => $_SESSION['userid']));
	}
	
	public function getUser($userid)
	{
		$query = $this->db->get_where('user', array('userid' => $userid));
		if ($query->num_rows() > 0)
		{
			return $query->row(0);
		}
		return NULL;
	}
}