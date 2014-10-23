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
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	public function get_all_test_classes($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('lab_test_class.lab_test_class_id','ASC');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	public function add_classes()
	{
		
		$class_name = $this->input->post('class_name');
		
		//  check if this class name exisit
		$check_rs = $this->check_class($class_name);
		if(count($check_rs) > 0)
		{
			return FALSE;

		}
		else
		{

			$insert = array(
					"lab_test_class_name" => $class_name
				);
			$this->database->insert_entry('lab_test_class', $insert);

			return TRUE;
		}
		// end of checking
		
	}

	public function check_class($class_name)
	{
		$table = "lab_test_class";
		$where = "lab_test_class_name = '$class_name'";
		$items = "*";
		$order = "lab_test_class_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

}
?>