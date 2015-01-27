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
		$this->db->order_by('service.service_id','ASC');
		$query = $this->db->get('');
		
		return $query;
	}
	public function get_service_names($service_id)
	{
		$table = "service";
		$where = "service_id =". $service_id;
		$items = "service_name";
		$order = "service_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			foreach ($result as $key):
				$service_name = $key->service_name;
			endforeach;
		}
		return $service_name;
	}

	public function submit_service_charges($service_id)
	{
		$service_charge_name = $this->input->post('service_charge_name');
		$charge = $this->input->post('charge');
		$patient_type = $this->input->post('patient_type');

		//  check if the value exisit
		$result = $this->check_service_charge_exist($service_id,$patient_type,$service_charge_name);

		if($result == TRUE)
		{
			return FALSE;
		}
		else
		{
			$visit_data = array('service_id'=>$service_id,'service_charge_name'=>$service_charge_name,'service_charge_amount'=>$charge,'visit_type_id'=>$patient_type);
			$this->db->insert('service_charge', $visit_data);

			return TRUE;
		}

	}

	public function check_service_charge_exist($service_id,$patient_type,$service_charge_name)
	{
		$table = "service_charge";
		$where = "service_charge_name = '$service_charge_name' AND service_id = ".$service_id." AND visit_type_id = ".$patient_type;
		$items = "*";
		$order = "service_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
		
	}
	public function get_service_charge_data($service_charge_id)
	{
		$table = "service_charge";
		$where = "service_charge_id = ".$service_charge_id;
		$items = "*";
		$order = "service_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);

		return $result;

	}
	public function submit_service()
	{
		$service_name = $this->input->post('service_name');

		//  check if the value exisit
		$result = $this->check_service_exist($service_name);

		if($result == TRUE)
		{
			return FALSE;
		}
		else
		{
			$visit_data = array('service_name'=>$service_name);
			$this->db->insert('service', $visit_data);

			return TRUE;
		}

	}
	public function check_service_exist($service_name)
	{
		$table = "service";
		$where = "service_name = '$service_name'";
		$items = "*";
		$order = "service_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
		

	}
	public function get_all_patient_visit($table, $where, $per_page, $page, $items = '*')
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select($items);
		$this->db->where($where);
		$this->db->order_by('visit_date','desc');
		$query = $this->db->get();
		
		return $query;
	}
}
?>