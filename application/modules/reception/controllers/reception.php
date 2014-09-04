<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Reception extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reception_model');
		$this->load->model('strathmore_population');
	}
	
	public function patients()
	{
		$where = 'patient_id > 0';
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
	public function add_patient()
	{
		$v_data['relationships'] = $this->reception_model->get_relationship();
		$v_data['religions'] = $this->reception_model->get_religion();
		$v_data['civil_statuses'] = $this->reception_model->get_civil_status();
		$v_data['titles'] = $this->reception_model->get_title();
		$v_data['genders'] = $this->reception_model->get_gender();
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
				echo 'SUCCESS :-)';
			}
			
			else
			{
				echo 'Failure';
			}
		}
	}
	public function search_staff()
	{
		$query = $this->reception_model->get_staff($this->input->post('staff_number'));
		
		if ($query->num_rows() > 0)
		{
			$v_data['query'] = $query;
			$v_data['page'] = $page;
			$data['content'] = $this->load->view('all_patients', $v_data, true);
		}
		
		else
		{
			$query = $this->strathmore_population->get_hr_staff($this->input->post('staff_number'));
		}
	}
	
	public function search_student()
	{	
		$query = $this->reception_model->get_student($this->input->post('student_number'));
		
		if ($query->num_rows() > 0)
		{
			
			echo 'SUCCESS :-)';
		}
		
		else
		{
			$query = $this->strathmore_population->get_ams_student($this->input->post('student_number'));
		}
	}
}