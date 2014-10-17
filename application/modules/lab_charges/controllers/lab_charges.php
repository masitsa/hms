<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Lab_charges extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('lab_charges_model');
		$this->load->model('pharmacy/pharmacy_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	public function test_list($page_name = NULL)
	{
		// this is it
		$where = 'lab_test_class.lab_test_class_id = lab_test.lab_test_class_id';
		$visit_search = $this->session->userdata('visit_search');
		
		if(!empty($visit_search))
		{
			$where .= $visit_search;
		}
		
		if($page_name == NULL)
		{
			$segment = 3;
		}
		
		else
		{
			$segment = 4;
		}
		$table = 'lab_test,lab_test_class';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/lab_charges/test_list/'.$page_name;
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
		$query = $this->lab_charges_model->get_all_test_list($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Test List';
		$v_data['title'] = 'Test List';
		$v_data['module'] = 0;
		
		
		$data['content'] = $this->load->view('test_list', $v_data, true);
		
		
		$data['sidebar'] = 'lab_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it

	}
}
?>