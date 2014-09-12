<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Lab extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('lab_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
		$this->load->model('reception/reception_model');
		$this->load->model('nurse/nurse_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	public function test($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('tests/test',$data);
	}
	public function test1($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('tests/test1',$data);
	}
	public function laboratory_list($lab,$visit_id){

		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}

		if ($lab ==2){
			$this->session->set_userdata('nurse_lab',$lab);
		}
		else {
			$this->session->set_userdata('nurse_lab',NULL);
		}

		
		$order = 'service_charge_name';
		
		$where = 'service_charge.service_charge_name = lab_test.lab_test_name
		AND lab_test_class.lab_test_class_id = lab_test.lab_test_class_id  AND service_charge.service_id = 5  AND  service_charge.visit_type_id = '.$visit_t;
		$test_search = $this->session->userdata('test_search');
		
		if(!empty($test_search))
		{
			$where .= $test_search;
		}
		
		$table = '`service_charge`, lab_test_class, lab_test';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/lab/laboratory_list/'.$lab.'/'.$visit_id;
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = 5;
		$config['per_page'] = 15;
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
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->lab_model->get_lab_tests($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Laboratory Test List';
		$v_data['title'] = 'Laboratory Test List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('laboratory_list', $v_data, true);
		
		$data['title'] = 'Laboratory Test List';
		$this->load->view('auth/template_no_sidebar', $data);	

	}

	

	public function test_lab($visit_id,$service_charge_id=NULL){
		$data = array('service_charge_id'=>$service_charge_id,'visit_id'=>$visit_id);
		$this->load->view('test_lab',$data);
	}
}
?>