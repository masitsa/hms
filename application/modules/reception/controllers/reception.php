<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Reception extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reception_model');
		$this->load->model('strathmore_population');
		$this->load->model('database');
	}
	
	public function patients()
	{
		$patient_search = $this->session->userdata('patient_search');
		$where = 'patient_id > 0';
		
		if(!empty($patient_search))
		{
			$where .= $patient_search;
		}
		
		$table = 'patients';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'reception/all-patients';
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->reception_model->get_all_patients($table, $where, $config["per_page"], $page);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['type'] = $this->reception_model->get_types();
		$data['content'] = $this->load->view('all_patients', $v_data, true);
		
		
		$data['title'] = 'All Patients';
		$data['sidebar'] = 'reception_sidebar';
		
		$this->load->view('auth/template_sidebar', $data);
	}
	

	public function visit_list()
	{
		
		// this is it
		$where = 'close_card = 0';
		$table = 'visit';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'reception/visit_list';
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('ongoing_visit', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'visit_list" class="btn btn-success pull-right">Add Patient</a> There are no patients';
		}
		$data['title'] = 'All Patients';
		$data['sidebar'] = 'reception_sidebar';
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}

	public function get_found_patients($patient_id)
	{
		$where = 'patient_id ='.$patient_id;
		$table = 'patients';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = base_url().'reception/all-patients';
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		$config['num_links'] = 5;
		
		
		$config['full_tag_open'] = '<ul class="pagination pull-right">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = 'Next';
		$config['next_tag_close'] = '</span>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = 'Prev';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->reception_model->get_all_patients($table, $where, $config["per_page"], $page);
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('all_patients', $v_data, true);
		}
		
		else
		{
			$data['content'] = '<a href="'.site_url().'add-patient" class="btn btn-success pull-right">Add Patient</a> There are no patients';
		}
		$data['title'] = 'All Patients';
		$data['sidebar'] = 'reception_sidebar';
		
		$this->load->view('auth/template_sidebar', $data);
	}
	/*
	*	Add a new patient
	*
	*/
	public function add_patient($dependant_staff = NULL)
	{
		$v_data['relationships'] = $this->reception_model->get_relationship();
		$v_data['religions'] = $this->reception_model->get_religion();
		$v_data['civil_statuses'] = $this->reception_model->get_civil_status();
		$v_data['titles'] = $this->reception_model->get_title();
		$v_data['genders'] = $this->reception_model->get_gender();
		$v_data['dependant_staff'] = $dependant_staff;
		$data['content'] = $this->load->view('add_patient', $v_data, true);
		
		$data['title'] = 'Add Patients';
		$data['sidebar'] = 'reception_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
	/*
	*	Register other patient
	*
	*/
	public function register_other_patient()
	{
		//form validation rules
		$this->form_validation->set_rules('title_id', 'Title', 'is_numeric|xss_clean');
		$this->form_validation->set_rules('patient_surname', 'Surname', 'required|xss_clean');
		$this->form_validation->set_rules('patient_othernames', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('patient_dob', 'Date of Birth', 'trim|xss_clean');
		$this->form_validation->set_rules('gender_id', 'Gender', 'trim|xss_clean');
		$this->form_validation->set_rules('religion_id', 'Religion', 'trim|xss_clean');
		$this->form_validation->set_rules('civil_status_id', 'Civil Status', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_email', 'Email Address', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_address', 'Postal Address', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_postalcode', 'Postal Code', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_town', 'Town', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_phone1', 'Primary Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_phone2', 'Other Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_kin_sname', 'Next of Kin Surname', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_kin_othernames', 'Next of Kin Other Names', 'trim|xss_clean');
		$this->form_validation->set_rules('relationship_id', 'Relationship With Kin', 'trim|xss_clean');
		$this->form_validation->set_rules('patient_national_id', 'National ID', 'trim|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{

			$this->add_patient();
		}
		
		else
		{
			$patient_id = $this->reception_model->save_other_patient();
			
			if($patient_id != FALSE)
			{
				$this->set_visit($patient_id);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not add patient. Please try again");
				$this->add_patient();	
			}
		}
	}
	
	public function search_staff()
	{
		$query = $this->reception_model->get_staff($this->input->post('staff_number'));
		
		if (($query->num_rows() > 0) && (!isset($_POST['dependant'])))
		{
			$query_staff = $this->reception_model->get_patient_staff($this->input->post('staff_number'));
			
			if ($query_staff->num_rows() > 0)
			{
				$result_patient = $query_staff->row();
				$patient_id = $result_patient->patient_id;

				
			}
			else
			{
				$patient_id = $this->reception_model->insert_into_patients($this->input->post('staff_number'),2);
				
			}
			$this->set_visit($patient_id);
			
		}
		
		else if (!isset($_POST['dependant']))
		{
			$patient_id = $this->strathmore_population->get_hr_staff($this->input->post('staff_number'));
			if($patient_id != FALSE){
				$this->set_visit($patient_id);
			}else{
				$this->session->set_userdata("error_message","Could not add patient. Please try again");
				$this->add_patient();
			}

		}
		
		//case of a dependant
		else
		{
			$this->add_patient($this->input->post('staff_number'));
		}
	}
	
	public function search_student()
	{	
		$query = $this->reception_model->get_student($this->input->post('student_number'));
		
		if ($query->num_rows() > 0)
		{
			
			$query_staff = $this->reception_model->get_patient_staff($this->input->post('student_number'));
			
			if ($query_staff->num_rows() > 0)
			{
				$result_patient = $query_staff->row();
				$patient_id = $result_patient->patient_id;

				
			}
			else
			{
				$patient_id = $this->reception_model->insert_into_patients($this->input->post('student_number'),1);	
			}
			//$this->set_visit($patient_id);
			$this->get_found_patients($patient_id);
		}
		
		else
		{
			$patient_id = $this->strathmore_population->get_ams_student($this->input->post('student_number'));
			if($patient_id != FALSE){
				// $this->set_visit($patient_id);
				$this->get_found_patients($patient_id);
			}else{
				$this->session->set_userdata("error_message","Could not add patient. Please try again");
				$this->add_patient();
			}

		}
	}
	/*
	*	Add a visit
	*
	*/
	public function set_visit($primary_key)
	{

		$v_data["patient_id"] = $primary_key;
		$v_data['charge'] = $this->reception_model->get_service_charges($primary_key);
		$v_data['doctor'] = $this->reception_model->get_doctor();
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['patient'] = $this->reception_model->patient_names2($primary_key);
		$v_data['patient_insurance'] = $this->reception_model->get_patient_insurance($primary_key);

		$data['content'] = $this->load->view('initiate_visit', $v_data, true);
		
		$data['title'] = 'Add Patients';
		$data['sidebar'] = 'reception_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	public function lab_visit($primary_key)
	{		
		$v_data["patient_id"] = $primary_key;
		$v_data['patient'] = $this->reception_model->patient_names2($primary_key);
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['patient_insurance'] = $this->reception_model->get_patient_insurance($primary_key);
		$data['content'] = $this->load->view('initiate_lab',$v_data);	

		$data['title'] = 'Add Patients';
		$data['sidebar'] = 'reception_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
		public function initiate_pharmacy($primary_key)
	{		
		$v_data["patient_id"] = $primary_key;
		$v_data['patient'] = $this->reception_model->patient_names2($primary_key);
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['patient_insurance'] = $this->reception_model->get_patient_insurance($primary_key);

		$data['content'] = $this->load->view('initiate_pharmacy.php',$v_data);	

		$data['title'] = 'Add Patients';
		$data['sidebar'] = 'reception_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
	
	public function save_visit($patient_id)
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('visit_date', 'Visit Date', 'required');
		
		$this->form_validation->set_rules('doctor', 'Doctor', 'required');
		
		$this->form_validation->set_rules('service_charge_name', 'Consultation Type', 'required');
		
		$patient_insurance_id = $this->input->post("patient_insurance_id");
			$patient_insurance_number = $this->input->post("insurance_id");
						$patient_type = $this->input->post("patient_type"); 
		if($patient_type==4){
		
				$this->form_validation->set_rules('patient_insurance_id', 'Patients Insurance', 'required');
				
					$this->form_validation->set_rules('insurance_id', 'Input Insurance Number', 'required');
				//$this->set_visit($patient_id);
			}
		if ($this->form_validation->run() == FALSE)
		{
			$this->set_visit($patient_id);
		}
		else
		{
			$doc_name = $this->input->post("doctor");

			$service_charge_id = $this->input->post("service_charge_name");
		
			$doc_rs = $this->get_doctor2($doc_name);
			foreach ($doc_rs as $rs1):
				$doctor_id = $rs1->personnel_id;
			endforeach;
			//$visit_type = $this->get_visit_type($type_name);
			$visit_date = $this->input->post("visit_date");
			$timepicker_start = $this->input->post("timepicker_start");
			$timepicker_end = $this->input->post("timepicker_end");
			
			$appointment_id;
			$close_card;	
			if(($timepicker_end=="")||($timepicker_start=="")){
			$appointment_id=0;	
			$close_card=0;
			}else{
			$appointment_id=1;
			$close_card=2;		
				}
	
			$this->save_visit_table($patient_id, $visit_date, $doc_name , $timepicker_start,$timepicker_end,$appointment_id, $patient_type, $patient_insurance_id,$patient_insurance_number,$close_card);
			$visit_id = $this->select_max("visit", "visit_id");
			///$service_charge_id = $this->get_service_charge_id(1, $visit_type, $service_charge_name);
			$service_charge = $this->get_service_charge($service_charge_id);
			$this->save_consultation_charge($visit_id, $service_charge_id, $service_charge);
			$this->visit_list();
		}
	}
	
	/*
	*	Register dependant patient
	*
	*/
	public function register_dependant_patient($dependant_staff)
	{
		//form validation rules
		$this->form_validation->set_rules('title_id', 'Title', 'is_numeric|xss_clean');
		$this->form_validation->set_rules('patient_surname', 'Surname', 'required|xss_clean');
		$this->form_validation->set_rules('patient_othernames', 'Other Names', 'required|xss_clean');
		$this->form_validation->set_rules('patient_dob', 'Date of Birth', 'trim|xss_clean');
		$this->form_validation->set_rules('gender_id', 'Gender', 'trim|xss_clean');
		$this->form_validation->set_rules('religion_id', 'Religion', 'trim|xss_clean');
		$this->form_validation->set_rules('civil_status_id', 'Civil Status', 'trim|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{

			$this->add_patient($dependant_staff);
		}
		
		else
		{
			$patient_id = $this->reception_model->save_dependant_patient($dependant_staff);
			
			if($patient_id != FALSE)
			{
				echo 'SUCCESS :-)';
			}
			
			else
			{
				echo 'Failure';
			}
		}
	}
	
	public function update_patient_number()
	{
		if($this->strathmore_population->update_patient_numbers())
		{
			echo 'SUCCESS :-)';
		}
		
		else
		{
			echo 'Failure';
		}
	}
	
	public function search_patients()
	{
		$visit_type_id = $this->input->post('visit_type_id');
		$strath_no = $this->input->post('strath_no');
		
		if(!empty($visit_type_id))
		{
			$visit_type_id = ' AND patients.visit_type_id = '.$visit_type_id.' ';
		}
		
		if(!empty($strath_no))
		{
			$strath_no = ' AND patients.strath_no LIKE \'%'.$strath_no.'%\' ';
		}
		
		//search surname
		$surnames = explode(" ",$_POST['surname']);
		$total = count($surnames);
		
		$count = 1;
		$surname = ' AND (';
		for($r = 0; $r < $total; $r++)
		{
			if($count == $total)
			{
				$surname .= ' patients.patient_surname LIKE \'%'.mysql_real_escape_string($surnames[$r]).'%\'';
			}
			
			else
			{
				$surname .= ' patients.patient_surname LIKE \'%'.mysql_real_escape_string($surnames[$r]).'%\' AND ';
			}
			$count++;
		}
		$surname .= ') ';
		
		//search other_names
		$other_names = explode(" ",$_POST['othernames']);
		$total = count($other_names);
		
		$count = 1;
		$other_name = ' AND (';
		for($r = 0; $r < $total; $r++)
		{
			if($count == $total)
			{
				$other_name .= ' patients.patient_othernames LIKE \'%'.mysql_real_escape_string($other_names[$r]).'%\'';
			}
			
			else
			{
				$other_name .= ' patients.patient_othernames LIKE \'%'.mysql_real_escape_string($other_names[$r]).'%\' AND ';
			}
			$count++;
		}
		$other_name .= ') ';
		
		$search = $visit_type_id.$strath_no.$surname.$other_name;
		$this->session->set_userdata('patient_search', $search);
		
		$this->patients();
	}
	
	function doc_schedule($personnel_id,$date)
	{
		$data = array('personnel_id'=>$personnel_id,'date'=>$date);
		$this->load->view('show_schedule',$data);	
	}
}