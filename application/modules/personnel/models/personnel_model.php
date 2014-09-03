<?php

class Personnel_model extends CI_Model 
{
	/*
	*	Select all of a personnel's departments
	*	@param $personnel_id
	*
	*/
	public function get_personnel_department($personnel_id)
	{
		$this->db->select('departments.*');
		$this->db->where('personnel_department.personnel_id = '.$personnel_id.' 
		AND personnel_department.department_id = departments.department_id');
		$this->db->order_by('departments_name');
		$query = $this->db->get('personnel_department, departments');
		
		return $query;
	}
	/*
	*	Select all personnel
	*
	*/
	public function get_all_personnel()
	{
		$this->db->select('*');
		$query = $this->db->get('personnel');
		
		return $query;
	}
}
?>