<?php

class Lab_charges_model extends CI_Model 
{


	public function get_all_test_list($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('lab_test.lab_test_class_id','ASC');
		$query = $this->db->get();
		
		return $query;
	}
}
?>