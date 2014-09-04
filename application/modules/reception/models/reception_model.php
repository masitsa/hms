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
	*	Retrieve a single staff
	*	@param int $strath_no
	*
	*/
	public function get_patient_staff($strath_no)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('strath_no = '.$strath_no);
		$query = $this->db->get();
		
		return $query;
	}
	/*
	*	Retrieve a insert patient information
	*	@param int $strath_no
	*
	*/
	public function insert_into_patients($strath_no,$visit_type)
	{
		//  instert data into the patients table
		$date = date("Y-m-d H:i:s");
		$patient_data = array('patient_number'=>$this->strathmore_population->create_patient_number(),'patient_date'=>'$date','visit_type_id'=>$visit_type,'strath_no'=>$strath_no,'created_by'=>$this->session->userdata('personnel_id'),'modified_by'=>$this->session->userdata('personnel_id'));
		$this->db->insert('patients', $patient_data);
		return $this->db->insert_id();
		
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
	
	public function get_service_charges($patient_id)
	{
		$table = "service_charge";
		$where = "service_charge.service_id = 1 AND service_charge.visit_type_id = (SELECT visit_type_id FROM patients WHERE patient_id = $patient_id)";
		$items = "service_charge.service_charge_name, service_charge_id";
		$order = "service_charge_name";
		
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_doctor()
	{
		$table = "personnel, job_title";
		$where = "job_title.job_title_id = personnel.job_title_id AND job_title.job_title_id = 2";
		$items = "personnel.personnel_onames, personnel.personnel_fname, personnel.personnel_id";
		$order = "personnel_onames";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}	
	
	public function get_types()
	{
		$table = "visit_type";
		$where = "visit_type_id > 0";
		$items = "visit_type_name,visit_type_id";
		$order = "visit_type_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function patient_names2($patient_id)
	{
		$table = "patients";
		$where = "patient_id = $patient_id";
		$items = "*";
		$order = "patient_surname";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		foreach ($result as $row)
			{
				$patient_id = $row->patient_id;
				$dependant_id = $row->dependant_id;
				$strath_no = $row->strath_no;
				$created_by = $row->created_by;
				$modified_by = $row->modified_by;
				$visit_type_id = $row->visit_type_id;
				$created = $row->patient_date;
				$last_modified = $row->last_modified;
				$last_visit = $row->last_visit;
				
				//staff & dependant
				if($visit_type_id == 2)
				{
					//dependant
					if($dependant_id > 0)
					{
						$patient_type = 'Dependant';
						$dependant_query = $this->reception_model->get_dependant($strath_no);
						
						if($dependant_query->num_rows() > 0)
						{
							$dependants_result = $dependant_query->row();
							
							$patient_othernames = $dependants_result->other_names;
							$patient_surname = $dependants_result->names;
							$patient_date_of_birth = $dependants_result->DOB;
							$relationship = $dependants_result->relation;
							$gender = $dependants_result->Gender;
						}
						
						else
						{
							$patient_othernames = '<span class="label label-important">Dependant not found</span>';
							$patient_surname = '';
							$patient_date_of_birth = '';
							$relationship = '';
							$gender = '';
						}
					}
					
					//staff
					else
					{
						$patient_type = 'Staff';
						$staff_query = $this->reception_model->get_staff($strath_no);
						
						if($staff_query->num_rows() > 0)
						{
							$staff_result = $staff_query->row();
							
							$patient_surname = $staff_result->Surname;
							$patient_othernames = $staff_result->Other_names;
							$patient_date_of_birth = $staff_result->DOB;
							$patient_phone1 = $staff_result->contact;
							$gender = $staff_result->gender;
						}
						
						else
						{
							$patient_othernames = '<span class="label label-important">Staff not found</span>';
							$patient_surname = '';
							$patient_date_of_birth = '';
							$relationship = '';
							$gender = '';
							$patient_type = '';
						}
					}
				}
				
				//student
				else if($visit_type_id == 1)
				{
					$student_query = $this->reception_model->get_student($strath_no);
					$patient_type = 'Student';
					
					if($student_query->num_rows() > 0)
					{
						$student_result = $student_query->row();
						
						$patient_surname = $student_result->Surname;
						$patient_othernames = $student_result->Other_names;
						$patient_date_of_birth = $student_result->DOB;
						$patient_phone1 = $student_result->contact;
						$gender = $student_result->gender;
					}
					
					else
					{
						$patient_othernames = '<span class="label label-important">Student not found</span>';
						$patient_surname = '';
						$patient_date_of_birth = '';
						$relationship = '';
						$gender = '';
					}
				}
				
				//other patient
				else
				{
					$patient_type = 'Other';
					
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
					
				}
		}

		return $patient_surname." ".$patient_othernames;
	}
	
	public function get_patient_insurance($patient_id)
	{
		$table = "patient_insurance, company_insuarance";
		$where = "patient_insurance.patient_id = $patient_id AND company_insuarance.company_insurance_id = patient_insurance.company_insurance_id";
		$items = "patient_insurance_id, company_name, insurance_company_name";
		$order = "company_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
}
?>