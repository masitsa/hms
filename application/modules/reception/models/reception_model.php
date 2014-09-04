<?php

class Reception_model extends CI_Model 
{
	/*
	*	Count all items from a table
	*	@param string $table
	* 	@param string $where
	*
	*/
	public function count_items($table, $where, $limit = NULL)
	{
		if($limit != NULL)
		{
			$this->db->limit($limit);
		}
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->count_all_results();
	}
	
	/*
	*	Retrieve all patients
	*	@param string $table
	* 	@param string $where
	*	@param int $per_page
	* 	@param int $page
	*
	*/
	public function get_all_patients($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('*');
		$this->db->where($where);
		$this->db->order_by('patient_date','desc');
		$query = $this->db->get('', $per_page, $page);
		
		return $query;
	}
	
	/*
	*	Retrieve a single dependant
	*	@param int $strath_no
	*
	*/
	public function get_dependant($strath_no)
	{
		$this->db->from('staff_dependants');
		$this->db->select('*');
		$this->db->where('staff_dependants_id = '.$strath_no);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_staff($strath_no)
	{
		$this->db->from('staff');
		$this->db->select('*');
		$this->db->where('Staff_Number = '.$strath_no);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve a single student
	*	@param int $strath_no
	*
	*/
	public function get_student($strath_no)
	{
		$this->db->from('student');
		$this->db->select('*');
		$this->db->where('student_Number = '.$strath_no);
		$query = $this->db->get();
		
		return $query;
	}
	
	public function calculate_age($dob)
	{
		
	}
	
	/*
	*	Retrieve gender
	*
	*/
	public function get_gender()
	{
		$this->db->order_by('gender_name');
		$query = $this->db->get('gender');
		
		return $query;
	}
	
	/*
	*	Retrieve title
	*
	*/
	public function get_title()
	{
		$this->db->order_by('title_name');
		$query = $this->db->get('title');
		
		return $query;
	}
	
	/*
	*	Retrieve civil_status
	*
	*/
	public function get_civil_status()
	{
		$this->db->order_by('civil_status_name');
		$query = $this->db->get('civil_status');
		
		return $query;
	}
	
	/*
	*	Retrieve religion
	*
	*/
	public function get_religion()
	{
		$this->db->order_by('religion_name');
		$query = $this->db->get('religion');
		
		return $query;
	}
	
	/*
	*	Retrieve relationship
	*
	*/
	public function get_relationship()
	{
		$this->db->order_by('relationship_name');
		$query = $this->db->get('relationship');
		
		return $query;
	}
	
	/*
	*	Save other patient
	*
	*/
	public function save_other_patient()
	{
		$data = array(
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'patient_email'=>$this->input->post('patient_email'),
			'patient_address'=>$this->input->post('patient_address'),
			'patient_postalcode'=>$this->input->post('patient_postalcode'),
			'patient_town'=>$this->input->post('patient_town'),
			'patient_phone1'=>$this->input->post('patient_phone1'),
			'patient_phone2'=>$this->input->post('patient_phone2'),
			'patient_kin_sname'=>$this->input->post('patient_kin_sname'),
			'patient_kin_othernames'=>$this->input->post('patient_kin_othernames'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'patient_national_id'=>$this->input->post('patient_national_id'),
			'patient_date'=>date('Y-m-d H:i:s'),
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('patients', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	
	/*
	*	Save dependant patient
	*
	*/
	public function save_dependant_patient($dependant_staff)
	{
		$data = array(
			'other_names'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'names'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'DOB'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'staff_id'=>$dependant_staff,
			'civil_status_id'=>$this->input->post('civil_status_id')
		);
		$this->db->insert('staff_dependants', $data);
		
		$data = array(
			'strath_no'=>$this->db->insert_id(),
			'dependant_id'=>$dependant_staff,
			'visit_type_id'=>2,
			'patient_date'=>date('Y-m-d H:i:s'),
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id')
		);
		
		if($this->db->insert('patients', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
}
?>