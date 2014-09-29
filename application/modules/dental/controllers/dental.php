<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Dental extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('dental_model');
		$this->load->model('nurse/nurse_model');
		$this->load->model('reception/reception_model');
		$this->load->model('accounts/accounts_model');
		$this->load->model('database');
		$this->load->model('medical_admin/medical_admin_model');
		$this->load->model('pharmacy/pharmacy_model');
	}
	public function index()
	{
		$this->session->unset_userdata('visit_search');
		$this->session->unset_userdata('patient_search');
		
		$where = 'visit_department.visit_id = visit.visit_id AND visit_department.department_id = 2 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\' AND visit.personnel_id = '.$this->session->userdata('personnel_id');
		
		$table = 'visit_department, visit, patients';
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, 6, 0);
		$v_data['query'] = $query;
		$v_data['page'] = 0;
		
		$v_data['visit'] = 0;
		$v_data['doctor_appointments'] = 1;
		$v_data['department'] = 2;
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('nurse/nurse_dashboard', $v_data, TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'dental_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
	public function dental_queue($page_name = NULL)
	{
		// this is it
		
		$where = 'visit_department.visit_id = visit.visit_id AND visit_department.department_id = 2 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\' AND visit.personnel_id = '.$this->session->userdata('personnel_id');
		
		$table = 'visit_department, visit, patients';
		$visit_search = $this->session->userdata('visit_search');
		
		if(!empty($visit_search))
		{
			$where .= $visit_search;
		}
		
		if($page_name != NULL)
		{
			$segment = 4;
		}
		
		else
		{
			$segment = 3;
		}
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/doctor/doctor_queue/'.$page_name;
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = $segment;
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
		
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Dental Queue';
		$v_data['title'] = 'Dental Queue';
		$v_data['module'] = 1;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('dental_queue', $v_data, true);
		
		$data['sidebar'] = 'dental_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function patient_card($visit_id, $mike = NULL)
	{
		$patient = $this->reception_model->patient_names2(NULL, $visit_id);
		$visit_type = $patient['visit_type'];
		$patient_type = $patient['patient_type'];
		$patient_othernames = $patient['patient_othernames'];
		$patient_surname = $patient['patient_surname'];
		$patient_date_of_birth = $patient['patient_date_of_birth'];
		$age = $this->reception_model->calculate_age($patient_date_of_birth);
		$gender = $patient['gender'];
		
		$v_data['patient'] = 'Surname: <span style="font-weight: normal;">'.$patient_surname.'</span> Othernames: <span style="font-weight: normal;">'.$patient_othernames.'</span> Age: <span style="font-weight: normal;">'.$age.'</span> Gender: <span style="font-weight: normal;">'.$gender.'</span> Patient Type: <span style="font-weight: normal;">'.$visit_type.'</span>';

		$v_data['mike'] = $mike;
		$v_data['visit_id'] = $visit_id;
		
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		
		
		$data['sidebar'] = 'dental_sidebar';
		
		if(($mike != NULL) && ($mike != 'a')){
			$this->load->view('auth/template_no_sidebar', $data);	
		}else{
			$this->load->view('auth/template_sidebar', $data);	
		}
	}
	
	
}