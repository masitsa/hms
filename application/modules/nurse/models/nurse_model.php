<?php

class Nurse_model extends CI_Model 
{
	public function save_dental_vitals($visit_id)
	{
		$visit_major_reason= $this->input->post('reason');
		//$treatment= $this->input->post('treatment');
		$treatment_hospital= $this->input->post('hospital');
		$treatment_doctor=$this->input->post('doctor');
		$Food_allergies=$this->input->post('food_allergies');
		$Regular_treatment=$this->input->post('regular_treatment');
		$Recent_medication=$this->input->post('medication_description');
		$Medicine_allergies=$this->input->post('medicine_allergies');
		$prior_treatment=$this->input->post('prior_treatment');
		$alcohol=$this->input->post('alcohol');
		$smoke=$this->input->post('smoke');
	
		
		$women_pregnant=$this->input->post('preg');
		$pregnancy_month=$this->input->post('months');
		$serious_illness=$this->input->post('illness');
		$serious_illness_xplain=$this->input->post('illness_exp');
		$additional_infor=$this->input->post('additional');
		
		$data = array(
			'visit_id'=>$visit_id,
			'visit_major_reason'=>$visit_major_reason,
			'serious_illness'=>$serious_illness,
			'serious_illness_xplain'=>$serious_illness_xplain,
			//'treatment'=>$treatment,
			'treatment_hospital'=>$treatment_hospital,
			'treatment_doctor'=>$treatment_doctor,
			'Food_allergies'=>$Food_allergies,
			'Regular_treatment'=>$Regular_treatment,
			'Recent_medication'=>$Recent_medication,
			'Medicine_allergies'=>$Medicine_allergies,
			/*'chest_trouble'=>$chest_trouble,
			'heart_problems'=>$heart_problems,
			'diabetic'=>$diabetic,
			'epileptic'=>$epileptic,
			'rheumatic_fever'=>$rheumatic_fever,
			'elongated_bleeding'=>$elongated_bleeding,
			'jaundice'=>$jaundice,
			'hepatitis'=>$hepatitis,
			'asthma'=>$asthma,
			'eczema'=>$eczema,
			'cancer'=>$cancer,*/
			'women_pregnant'=>$women_pregnant,
			'pregnancy_month'=>$pregnancy_month,
			'additional_infor'=>$additional_infor,
			'prior_treatment'=>$prior_treatment,
			'smoke'=>$smoke,
			'alcohol'=>$alcohol
		);
		
		if($this->db->insert('dental_vitals', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

	public function select_current_dental_vitals($visit_id)
	{	
		$this->db->select('*');
		$this->db->where('visit_id', $visit_id);
		$query = $this->db->get('dental_vitals');
		
		return $query;	
	}
	
	public function update_dental_vitals($dental_vitals_id)
	{	
		$visit_major_reason= $this->input->post('reason');
		$treatment_hospital= $this->input->post('hospital');
		$treatment_doctor=$this->input->post('doctor');
		$Food_allergies=$this->input->post('food_allergies');
		$Regular_treatment=$this->input->post('regular_treatment');
		$Recent_medication=$this->input->post('medication_description');
		$Medicine_allergies=$this->input->post('medicine_allergies');
		$prior_treatment=$this->input->post('prior_treatment');
		$alcohol=$this->input->post('alcohol');
		$smoke=$this->input->post('smoke');
		$women_pregnant=$this->input->post('preg');
		$pregnancy_month=$this->input->post('months');
		$serious_illness=$this->input->post('illness');
		$serious_illness_xplain=$this->input->post('illness_exp');
		$additional_infor=$this->input->post('additional');
		
		$data = array(
			'visit_major_reason'=>$visit_major_reason,
			'serious_illness'=>$serious_illness,
			'serious_illness_xplain'=>$serious_illness_xplain,
			//'treatment'=>$treatment,
			'treatment_hospital'=>$treatment_hospital,
			'treatment_doctor'=>$treatment_doctor,
			'Food_allergies'=>$Food_allergies,
			'Regular_treatment'=>$Regular_treatment,
			'Recent_medication'=>$Recent_medication,
			'Medicine_allergies'=>$Medicine_allergies,
			/*'chest_trouble'=>$chest_trouble,
			'heart_problems'=>$heart_problems,
			'diabetic'=>$diabetic,
			'epileptic'=>$epileptic,
			'rheumatic_fever'=>$rheumatic_fever,
			'elongated_bleeding'=>$elongated_bleeding,
			'jaundice'=>$jaundice,
			'hepatitis'=>$hepatitis,
			'asthma'=>$asthma,
			'eczema'=>$eczema,
			'cancer'=>$cancer,*/
			'women_pregnant'=>$women_pregnant,
			'pregnancy_month'=>$pregnancy_month,
			'additional_infor'=>$additional_infor,
			'prior_treatment'=>$prior_treatment,
			'smoke'=>$smoke,
			'alcohol'=>$alcohol
		);
		
		$this->db->where('dental_vitals_id', $dental_vitals_id);
		if($this->db->update('dental_vitals', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function update_dental_visit($visit_id)
	{
		$data['dental_visit'] = 1;
		$data['nurse_visit'] = 1;
		
		$this->db->where('visit_id', $visit_id);
		if($this->db->update('visit', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_family_disease()
	{
		$this->db->select('*');
		$this->db->order_by('family_disease_name', 'ASC');
		$query = $this->db->get('family_disease');
		
		return $query;
	}
	
	public function get_family()
	{
		$this->db->select('*');
		$this->db->order_by('family_id', 'DESC');
		$query = $this->db->get('family');
		
		return $query;
	}
	
	public function get_family_history($family, $patient_id, $disease)
	{
		$this->db->select('*');
		$this->db->where(array('patient_id' => $patient_id, 'family_id' => $family, 'disease_id' => $disease));
		$query = $this->db->get('family_history_disease');
		
		return $query;
	}

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
	public function save_family_disease($family_id, $patient_id, $disease_id)
	{
		$data = array(
			'family_id'=>$family_id,
			'patient_id'=>$patient_id,
			'disease_id'=>$disease_id
		);
		
		if($this->db->insert('family_history_disease', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
}
?>
