<?php

class Lab_model extends CI_Model 
{

	function get_lab_visit2($visit_id){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "lab_visit";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_lab_visit_test($visit_id ){
		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "*";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_comment($visit_id){

		$table = "visit";
		$where = "visit_id = ".$visit_id;
		$items = "lab_visit_comment, visit_date";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_lab_visit_result($visit_charge_id){
		$table = "lab_visit_results";
		$where = "visit_charge_id = ".$visit_charge_id;
		$items = "*";
		$order = "visit_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_test($visit_charge_id){
			
		// $_SESSION['test'] = 0;
		$this->session->set_userdata('test',0);

		$table = "lab_test, visit_charge, lab_test_class, lab_test_format, lab_visit_results, service_charge";
		$where = "visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id 
		AND lab_test_format.lab_test_id = lab_test.lab_test_id 
		AND visit_charge.visit_charge_id = lab_visit_results.visit_charge_id 
		AND lab_visit_results.lab_visit_result_format = lab_test_format.lab_test_format_id AND visit_charge_id = ".$visit_charge_id;
		$items = "service_charge.service_charge_name AS lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit,lab_test_format.lab_test_format_id, visit_charge.visit_charge_id AS lab_visit_id,  visit_charge.visit_charge_results AS lab_visit_result, lab_test_format.lab_test_formatname, lab_test_format.lab_test_format_units, lab_test_format.lab_test_format_malelowerlimit, lab_test_format.lab_test_format_maleupperlimit, lab_test_format.lab_test_format_femalelowerlimit, lab_test_format.lab_test_format_femaleupperlimit, lab_visit_results.lab_visit_results_result, visit_charge.visit_charge_comment";
		$order = "visit_charge.visit_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}


	function get_m_test($visit_charge_id){
		
		$this->session->set_userdata('test',1);

		$table = "lab_test, visit_charge, lab_test_class, lab_test_format, lab_visit_results, service_charge";
		$where = "AND visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id
		AND visit_charge.visit_charge_id NOT IN (SELECT visit_charge_id FROM lab_visit_results) AND visit_charge_id = ".$visit_charge_id;
		$items = "service_charge.service_charge_name AS lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit,lab_test_format.lab_test_format_id, visit_charge.visit_charge_id AS lab_visit_id,  visit_charge.visit_charge_results AS lab_visit_result, lab_test_format.lab_test_formatname, lab_test_format.lab_test_format_units, lab_test_format.lab_test_format_malelowerlimit, lab_test_format.lab_test_format_maleupperlimit, lab_test_format.lab_test_format_femalelowerlimit, lab_test_format.lab_test_format_femaleupperlimit, lab_visit_results.lab_visit_results_result, visit_charge.visit_charge_comment";
		$order = "visit_charge.visit_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	function get_test_comment($visit_charge_id){

		$table = "lab_visit_format_comment";
		$where = "visit_charge_id = ".$visit_charge_id;
		$items = "lab_visit_format_comments";
		$order = "visit_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	public function get_lab_tests($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('service_charge.service_charge_amount, service_charge.service_charge_id, service_charge.service_charge_name, lab_test_class.lab_test_class_name');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}

	function get_lab_test_id($service_charge_id){
		$table = "service_charge";
		$where = "service_charge_id = ".$service_charge_id;
		$items = "lab_test_id";
		$order = "lab_test_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	function get_visits_lab_result($visit_id, $lab_id){

		$table = "lab_test_format";
		$where = "lab_test_id = ".$lab_id;
		$items = "lab_test_format_id";
		$order = "lab_test_format_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_lab_visit($visit_id, $service_charge_id){
		$table = "visit_charge";
		$where = "visit_id = ". $visit_id ." AND service_charge_id = ". $service_charge_id;
		$items = "*";
		$order = "visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function save_lab_visit($visit_id, $service_charge_id){
		
		$table = "service_charge";
		$where = "service_charge_id = ". $service_charge_id;
		$items = "service_charge_amount";
		$order = "service_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		if(count($result) > 0){
			foreach ($result as $key): 
				# code...
				$service_charge_amount = $key->service_charge_amount;
			endforeach;
			
		}

		$visit_data = array('visit_id'=>$visit_id,'service_charge_id'=>$service_charge_id,'visit_charge_amount'=>$service_charge_amount);
		$this->db->insert('visit_charge', $visit_data);

		
	}

	function save_lab_visit_format($visit_id, $service_charge_id, $lab_test_format_id){

		$table = "visit_charge";
		$where = "visit_id = ". $visit_id. "service_charge_id = ". $service_charge_id;
		$items = "visit_charge_id";
		$order = "visit_charge_id";
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		if(count($result) > 0){
			foreach ($result as $key): 
				# code...
				$visit_charge_id = $key->visit_charge_id;
			endforeach;
			
		}
		$visit_data = array('visit_charge_id'=>$visit_charge_id,'lab_visit_result_format'=>$lab_test_format_id,'visit_id'=>$visit);
		$this->db->insert('lab_visit_results', $visit_data);

	}

	function get_lab_test($visit_id){
		
		$this->session->set_userdata('test',1);

		$table = "lab_test, visit_charge, service_charge, lab_test_class";
		$where = "visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id AND visit_charge.visit_id = ".$visit_id;
		$items = "service_charge.service_charge_name AS lab_test_name, lab_test_class.lab_test_class_name AS class_name, service_charge.service_charge_amount AS lab_test_price, visit_charge.visit_charge_id AS lab_visit_id";
		$order = "visit_charge.visit_id.visit_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;


		
	}
	
}
?>