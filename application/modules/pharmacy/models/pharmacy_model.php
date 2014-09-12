<?php

class Pharmacy_model extends CI_Model 
{

	function get_drug($service_charge_id){
		
		
		$table = "drugs, service_charge";
		$where = "service_charge.drug_id = drugs.drugs_id AND service_charge.service_charge_id = ". $service_charge_id;
		$items = "service_charge.service_charge_name,drugs.drug_type_id, drugs.drug_size,drugs.drug_size_type,drugs.drug_administration_route_id, drugs.drugs_dose, drugs.drug_dose_unit_id";
		$order = "drugs.drugs_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_drug_type_name($id){
		
		$table = "drug_type";
		$where = "drug_type_id = ". $id;
		$items = "drug_type_name";
		$order = "drug_type_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

		
	}

	function get_dose_unit2($id){
		
		$table = "drug_dose_unit";
		$where = "drug_dose_unit_id = ". $id;
		$items = "drug_dose_unit_name";
		$order = "drug_dose_unit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

		
	}

	function get_admin_route2($id){
		
		$table = "drug_administration_route";
		$where = "drug_administration_route_id = ". $id;
		$items = "drug_administration_route_name";
		$order = "drug_administration_route_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}


	function select_prescription($visit_id){
			
			
		$table = "pres, drugs, drug_times, drug_duration, drug_consumption, visit_charge, service_charge";
		$where = "service_charge.service_charge_id = pres.service_charge_id 
						AND service_charge.drug_id = drugs.drugs_id
						AND pres.drug_times_id = drug_times.drug_times_id 
						AND pres.drug_duration_id = drug_duration.drug_duration_id
						AND pres.drug_consumption_id = drug_consumption.drug_consumption_id AND pres.visit_charge_id = ". $visit_id;
		$items = "service_charge.service_charge_name AS drugs_name,service_charge.service_charge_amount  AS drugs_charge , drug_duration.drug_duration_name, pres.prescription_substitution, pres.prescription_id,pres.units_given, pres.visit_charge_id,pres.prescription_startdate, pres.prescription_finishdate, drug_times.drug_times_name, pres.prescription_startdate, pres.prescription_finishdate, pres.service_charge_id AS drugs_id, pres.prescription_substitution, drug_duration.drug_duration_name, pres.prescription_quantity, drug_consumption.drug_consumption_name";
		$order = "`drugs`.drugs_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	function get_drug_forms(){
		$table = "drug_type";
		$where = "drug_type_id > 0 ";
		$items = "*";
		$order = "drug_type_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_drug_times(){
		$table = "drug_times";
		$where = "drug_times_id > 0 ";
		$items = "*";
		$order = "drug_times_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_consumption(){
		
		$table = "drug_consumption";
		$where = "drug_consumption_id > 0 ";
		$items = "*";
		$order = "drug_consumption_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_drug_duration(){
		
		$table = "drug_duration";
		$where = "drug_duration_id > 0 ";
		$items = "*";
		$order = "drug_duration_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}
	
	function get_warnings(){
		$table = "warnings";
		$where = "warnings_id > 0 ";
		$items = "*";
		$order = "warnings_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

		
	}

	function get_instructions(){
		$table = "instructions";
		$where = "instructions_id > 0 ";
		$items = "*";
		$order = "instructions_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	function get_admin_route(){
		$table = "drug_administration_route";
		$where = "drug_administration_route_id > 0 ";
		$items = "*";
		$order = "drug_administration_route_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	function get_dose_unit(){
		$table = "drug_dose_unit";
		$where = "drug_dose_unit_id > 0 ";
		$items = "*";
		$order = "drug_dose_unit_name";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	public function get_drugs($table, $where, $per_page, $page, $order)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('service_charge.service_charge_id, service_charge.visit_type_id,generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name');
		$this->db->where($where);
		$this->db->order_by($order,'asc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	
}
?>