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
		$this->load->model('reception/reception_model');
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
	
	public function patient_card($visit_id)
	{
		$v_data['visit_id'] = $visit_id;
		$v_data['patient'] = $this->reception_model->patient_names2($visit_id);
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'nurse_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}

	
	public function close_queue_search()
	{
	}

	public function vitals_interface($visit_id)
	{
		$data = array('visit_id'=>$visit_id);
		$this->load->view('show_vitals',$data);	
	}

	public function load_vitals($vital_id,$visit_id)
	{
		$data = array('vitals_id'=>$vital_id,'visit_id'=>$visit_id);
		$this->load->view('show_loaded_vitals',$data);	
	}

	public function save_vitals($vital,$vital_id,$visit_id)
	{
		//  check if the data exists in the table
		$table = "visit_vital";
		$where ="visit_id = $visit_id and vital_id = $vital_id";
		$total_rows = $this->reception_model->count_items($table, $where);
		
		if($total_rows > 0){
			// do an update to the data there
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->where("visit_id",$visit_id);
			$this->db->update('visit_vital', $visit_data);
		}else{
			// do an insert
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->insert('visit_vital', $visit_data);
		}
		
	}
}
?>