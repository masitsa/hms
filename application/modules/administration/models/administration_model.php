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
	public function deactivate_service_charge($service_charge_id)
	{
		$data = array(
				'service_charge_status' => 0
			);
		$this->db->where('service_charge_id', $service_charge_id);
		
		if($this->db->update('service_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function activate_service_charge($service_charge_id)
	{
		$data = array(
				'service_charge_status' => 1
			);
		$this->db->where('service_charge_id', $service_charge_id);
		
		if($this->db->update('service_charge', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function deactivate_service($service_id)
	{
		$data = array(
				'service_status' => 0
			);
		$this->db->where('service_id', $service_id);
		
		if($this->db->update('service', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function activate_service($service_id)
	{
		$data = array(
				'service_status' => 1
			);
		$this->db->where('service_id', $service_id);
		
		if($this->db->update('service', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	public function get_all_service_charges($table, $where, $per_page, $page, $order = NULL)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('visit_type.visit_type_name, service_charge.service_charge_name','ASC');
		$query = $this->db->get('', $per_page, $page);
		
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
			$visit_data = array('service_id'=>$service_id,'service_charge_status'=>1,'service_charge_name'=>$service_charge_name,'service_charge_amount'=>$charge,'visit_type_id'=>$patient_type);
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
	
	/*
	*	Export Charges
	*
	*/
	function export_charges()
	{
		$this->load->library('excel');
		
		//get all services
		$this->db->order_by('service_name', 'ASC');
		$services_query = $this->db->get('service');
		
		//get all visit types
		$this->db->order_by('visit_type_name', 'ASC');
		$visit_type_query = $this->db->get('visit_type');
		
		$title = 'Charges Export';
		
		if($services_query->num_rows() > 0)
		{
			$count = 0;
			/*
				-----------------------------------------------------------------------------------------
				Document Header
				-----------------------------------------------------------------------------------------
			*/
			$row_count = 0;
			$report[$row_count][0] = '#';
			$report[$row_count][1] = 'Service';
			$report[$row_count][2] = 'Patient Type';
			$report[$row_count][3] = 'Cost';
			/*$col_count = 4;
		
			if($visit_type_query->num_rows() > 0)
			{
				foreach($visit_type_query->result() as $res)
				{
					$visit_type_name = $res->visit_type_name;
					$report[$row_count][$col_count] = $visit_type_name;
					$col_count++;
				}
			}*/
			
			//display all services data in the leftmost columns
			foreach($services_query->result() as $row)
			{
				$row_count = $row_count+2;
				
				$service_name = $row->service_name;
				$service_id = $row->service_id;
				
				$report[$row_count][0] = $row_count;
				$report[$row_count][1] = $service_name;
				$row_count++;
				
				//get service charges
				$this->db->where('visit_type.visit_type_id = service_charge.visit_type_id AND service_charge.service_id = '.$service_id.' AND service_charge.service_charge_status = 1');
				$this->db->select('visit_type.visit_type_name, service_charge.*');
				$service_charge_query = $this->db->get('service_charge, visit_type');
						
				//display service charges for visit type
				if($service_charge_query->num_rows() > 0)
				{
					foreach($service_charge_query->result() as $res2)
					{
						$service_charge_name = $res2->service_charge_name;
						$service_charge_amount = $res2->service_charge_amount;
						//$visit_type_id2 = $res2->visit_type_id;
						$visit_type_name = $res2->visit_type_name;
						$report[$row_count][0] = $row_count;
						$report[$row_count][1] = $service_charge_name;
						$report[$row_count][2] = $visit_type_name;
						$report[$row_count][3] = $service_charge_amount;
						/*$col_count = 4;
						
						if($visit_type_query->num_rows() > 0)
						{
							foreach($visit_type_query->result() as $res)
							{
								$visit_type_id = $res->visit_type_id;
								
								if($visit_type_id == $visit_type_id2)
								{
									$report[$row_count][$col_count] = $service_charge_amount;
									$col_count++;
								}
							}
						}*/
						$row_count++;
					}
				}
				$row_count++;
			}
		}
		
		//create the excel document
		$this->excel->addArray ( $report );
		$this->excel->generateXML ($title);
	}
}
?>