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
	*	Retrieve ongoing visits
	*	@param string $table
	* 	@param string $where
	*	@param int $per_page
	* 	@param int $page
	*
	*/
	public function get_all_ongoing_visits($table, $where, $per_page, $page)
	{
		//retrieve all users
		$this->db->from($table);
		$this->db->select('visit.*, patients.*');
		$this->db->where($where);
		$this->db->order_by('visit_time','desc');
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
		$this->db->where('staff_dependants_id = \''.$strath_no.'\'');
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
		$this->db->where('Staff_Number = \''.$strath_no.'\'');
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
		$this->db->where('strath_no = \''.$strath_no.'\'');
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
		$this->db->where('student_Number = \''.$strath_no.'\'');
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
		$this->db->select('staff_system_id');
		$this->db->where('Staff_Number', $dependant_staff);
		$query = $this->db->get('staff');
		
		if($query->num_rows() > 0)
		{
			$res = $query->row();
			$staff_system_id = $res->staff_system_id;
			$data = array(
				'other_names'=>ucwords(strtolower($this->input->post('patient_surname'))),
				'names'=>ucwords(strtolower($this->input->post('patient_othernames'))),
				'title_id'=>$this->input->post('title_id'),
				'DOB'=>$this->input->post('patient_dob'),
				'gender_id'=>$this->input->post('gender_id'),
				'religion_id'=>$this->input->post('religion_id'),
				'staff_id'=>$staff_system_id,
				'civil_status_id'=>$this->input->post('civil_status_id')
			);
			$this->db->insert('staff_dependants', $data);
			
			$data2 = array(
				'strath_no'=>$this->db->insert_id(),
				'dependant_id'=>$dependant_staff,
				'visit_type_id'=>2,
				'relationship_id'=>$this->input->post('relationship_id'),
				'patient_date'=>date('Y-m-d H:i:s'),
				'patient_number'=>$this->strathmore_population->create_patient_number(),
				'created_by'=>$this->session->userdata('personnel_id'),
				'modified_by'=>$this->session->userdata('personnel_id')
			);
			
			if($this->db->insert('patients', $data2))
			{
				return $this->db->insert_id();
			}
			else{
				return FALSE;
			}
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Save dependant patient
	*
	*/
	public function save_other_dependant_patient($patient_id)
	{
		$data = array(
			'visit_type_id'=>3,
			'patient_surname'=>ucwords(strtolower($this->input->post('patient_surname'))),
			'patient_othernames'=>ucwords(strtolower($this->input->post('patient_othernames'))),
			'title_id'=>$this->input->post('title_id'),
			'patient_date_of_birth'=>$this->input->post('patient_dob'),
			'gender_id'=>$this->input->post('gender_id'),
			'religion_id'=>$this->input->post('religion_id'),
			'civil_status_id'=>$this->input->post('civil_status_id'),
			'relationship_id'=>$this->input->post('relationship_id'),
			'patient_date'=>date('Y-m-d H:i:s'),
			'patient_number'=>$this->strathmore_population->create_patient_number(),
			'created_by'=>$this->session->userdata('personnel_id'),
			'modified_by'=>$this->session->userdata('personnel_id'),
			'dependant_id'=>$patient_id
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
	public function get_service_charge($id)
	{
		$table = "service_charge";
		$where = "service_charge_id = $id";
		$items = "service_charge_amount AS number";
		$order = "service_charge_amount";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		foreach ($result as $rs1):
			$visit_type2 = $rs1->number;
		endforeach;
		return $visit_type2;
	}
	public function save_consultation_charge($visit_id, $service_charge_id, $service_charge)
	{
		$insert = array(
        	"visit_id" => $visit_id,
        	"service_charge_id" => $service_charge_id,
        	"visit_charge_amount" => $service_charge
    	);
		$table = "visit_charge";
		$this->load->model('database', '',TRUE);
		$this->database->insert_entry($table, $insert);
		
		return TRUE;
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
		$items = "visit_type_name, visit_type_id";
		$order = "visit_type_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function patient_names2($patient_id, $visit_id = NULL)
	{
		if($patient_id != NULL)
		{
			$table = "patients";
			$where = "patient_id = $patient_id";
			$items = "*";
			$order = "patient_surname";
		}
		
		else
		{
			$table = "patients, visit";
			$where = "patients.patient_id = visit.patient_id AND visit.visit_id = ".$visit_id;
			$items = "patients.*";
			$order = "patient_surname";
		}
		
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
		$table = "company_insuarance";
		$where = "company_insurance_id > 0";
		$items = "*";
		$order = "company_name";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function doctors_schedule($personelle_id,$date){
		$table = "visit";
		$where = "personnel_id = '$personelle_id' and visit_date >= '$date' and time_start <> 0 and time_end <> 0";
		$items = "*";
		$order = "visit_id";

		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function doctors_names($personelle_id){
		$table = "personnel";
		$where = "personnel_id = '$personelle_id'";
		$items = "*";
		$order = "personnel_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}

	public function get_service_charges_per_type($patient_type){
		$table = "service_charge";
		$where = "visit_type_id = $patient_type and service_id = 1";
		$items = "*";
		$order = "visit_type_id";
			//echo $sql;
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_doctor2($doc_name)
	{
		$table = "personnel, job_title";
		$where = "job_title.job_title_id = personnel.job_title_id AND job_title.job_title_id = 2 AND personnel.personnel_onames = '$doc_name'";
		$items = "personnel.personnel_onames, personnel.personnel_fname, personnel.personnel_id";
		$order = "personnel_onames";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	public function get_patient_id_from_visit($visit_id)
	{
		$this->db->where("visit_id = ".$visit_id);
		$this->db->select("patient_id");
		$query = $this->db->get('visit');
		
		$row = $query->row();
		
		return $row->patient_id;
	}

	
	public function get_patient_type($visit_type_id, $dependant_id = NULL)
	{
		if($visit_type_id == 1)
		{
			return 'Patient';
		}
		
		else if(($visit_type_id == 2) && ($dependant_id > 0))
		{
			return 'Dependant';
		}
		
		else if(($visit_type_id == 2) && ($dependant_id <= 0))
		{
			return 'Staff';
		}
		
		else if(($visit_type_id == 3))
		{
			return 'Other';
		}
		
		else if(($visit_type_id == 4))
		{
			return 'Insurance';
		}
		
		else if(($visit_type_id == 5))
		{
			return 'General';
		}
		
		else
		{
			return 'N/A';
		}
		
	}
	
	/*
	*	Retrieve a single patient's details
	*	@param int $patient_id
	*
	*/
	public function get_patient_data($patient_id)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('patient_id = '.$patient_id);
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all staff dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_staff_dependant($strath_no)
	{
		$this->db->from('staff_dependants');
		$this->db->select('*');
		$this->db->where('staff_dependants_id = \''.$strath_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all patient dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_patient_dependant($patient_id)
	{
		$this->db->from('patients');
		$this->db->select('*');
		$this->db->where('dependant_id = \''.$patient_id.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	*	Retrieve all patient dependants
	*	@param int $strath_no
	*
	*/
	public function get_all_staff_dependants($patient_id)
	{
		$this->db->from('patients, staff_dependants, staff');
		$this->db->select('staff_dependants.*, staff.Staff_Number');
		$this->db->where('patients.strath_no = staff.Staff_Number AND staff.staff_system_id = staff_dependants.staff_id AND patients.patient_id = \''.$patient_id.'\'');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_staff_dependant_patient($staff_dependant_id, $staff_no)
	{
		$this->db->from('patients');
		$this->db->select('patients.*');
		$this->db->where('patients.strath_no = \''.$staff_dependant_id.'\' AND patients.dependant_id = \''.$staff_no.'\'');
		$query = $this->db->get();
		
		return $query;
	}
}
?>