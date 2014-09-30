<?php

class Administration_model extends CI_Model 
{

	public function get_all_services($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('service_id','ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_all_service_charges($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('service_id','ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_service_names($service_id)
	{
		$table = "service";
		$where = "service_id > 0";
		$items = "service__name";
		$order = "service_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
}
?>