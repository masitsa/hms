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
	
	public function add_patient()
	{
		$data['title'] = 'Add Patients';
		$data['sidebar'] = 'reception_sidebar';
		$data['content'] = $this->load->view('add_patient', '', true);
		
		$this->load->view('auth/template_sidebar', $data);	
	}
	public function search_student(){
		$query = $this->reception_model->get_student($this->input->post('student_number'));
		
		if ($query->num_rows() > 0)
		{
			
		}
		
		else
		{
			$query = $this->strathmore_population->get_ams_student($this->input->post('student_number'));
		}
	}
	public function search_staff(){
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
}