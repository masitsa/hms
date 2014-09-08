<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Nurse extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nurse_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	
	public function nurse_queue()
	{
		// this is it
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND nurse_visit = 0';
		$visit_search = $this->session->userdata('visit_search');
		
		if(!empty($visit_search))
		{
			$where .= $visit_search;
		}
		
		$table = 'visit, patients';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/nurse/visit_list/';
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
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Nurse Queue';
		$v_data['title'] = 'Nurse Queue';
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('nurse_queue', $v_data, true);
		$data['sidebar'] = 'nurse_sidebar';
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	
	public function patient_card($visit_id=1)
	{
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'nurse_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
	public function close_queue_search()
	{
	}
}
?>