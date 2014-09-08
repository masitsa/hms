<?php

class Nurse_model extends CI_Model 
{

	function get_visit_vitals($visit_id, $vitals_id){
		
		$table = "visit_vital";
		$where = "visit_id = '$visit_id' and vital_id = '$vitals_id'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function vitals_range($vitals_id){
		
		$table = "vitals_range";
		$where = "vitals_id = '$vitals_id'";
		$items = "*";
		$order = "vitals_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_previous_vitals($visit_id){
		

		$table = "visit_vital, visit, patients, vitals";
		$where = "visit_vital.vital_id = vitals.vitals_id 
		AND visit_vital.visit_id = visit.visit_id 
		AND visit.visit_id = $visit_id 
		AND visit.patient_id = patients.patient_id
		AND patients.patient_id = (SELECT patients.patient_id FROM patients, visit WHERE visit.visit_id = $visit_id AND visit.patient_id = patients.patient_id)
		AND visit.close_card = 1";
		$items = "visit_vital.visit_vital_value, vitals.vitals_name, visit.visit_id, visit.visit_date";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_vitals($id){
		$table = "visit_vital";
		$where = "visit_id = '$id'";
		$items = "*";
		$order = "vital_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function check_visit_type($id){
		$table = "visit";
		$where = "visit_id = '$id'";
		$items = "visit_type, visit_id";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function visit_charge($visit_id){
		$table = "visit_charge";
		$where = "visit_charge.visit_id  = '$visit_id'";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_service_charge($procedure_id){
		$table = "service_charge";
		$where = "service_charge_id = '$procedure_id'";
		$items = "*";
		$order = "service_charge_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function search_procedures($order, $search,$visit_t){
		$table = "service_charge, service";
		$where = "service_charge_name LIKE '%$search%' AND service.service_id = 3 AND service_charge.service_id = service.service_id AND service_charge.visit_type_id = $visit_t";
		$items = "service_charge.service_charge_name, service_charge.visit_type_id,service_charge.service_charge_id , service_charge.service_charge_amount ";
		$order = "'$order'";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_procedures($order,$visit_t){
		$table = "service_charge";
		$where = "service_id = '3' AND visit_type_id = $visit_t";
		$items = "*";
		$order = "service_charge_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	
}
?>
