<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Administration extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reception/reception_model');
		$this->load->model('reception/strathmore_population');
		$this->load->model('reports_model');
		$this->load->model('administration_model');

	}
	
	public function index()
	{
		$this->session->unset_userdata('all_transactions_search');
		
		$data['content'] = $this->load->view('dashboard', '', TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);
	}

	public function services($page_name = NULL)
	{
		// this is it
		$where = 'service_id > 0';
		$service_search = $this->session->userdata('service_search');
		
		if(!empty($service_search))
		{
			$where .= $service_search;
		}
		
		if($page_name == NULL)
		{
			$segment = 3;
		}
		
		else
		{
			$segment = 4;
		}
		$table = 'service';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/administration/services/'.$page_name;
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
		$query = $this->administration_model->get_all_services($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Services';
		$v_data['title'] = 'Services';
		$v_data['module'] = 0;
		
		
		$data['content'] = $this->load->view('services', $v_data, true);
		
		
		$data['sidebar'] = 'admin_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function service_charges($service_id,$page_name = NULL)
	{
		// this is it
		$where = 'service_id = $service_id';
		$service_charge_search = $this->session->userdata('service_charge_search');
		
		if(!empty($service_charge_search))
		{
			$where .= $service_charge_search;
		}
		
		if($page_name == NULL)
		{
			$segment = 3;
		}
		
		else
		{
			$segment = 4;
		}
		$table = 'service';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/administration/service_charges/'.$page_name;
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
		$query = $this->administration_model->get_all_service_charges($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Services Charges';
		$v_data['title'] = 'Services Charges';
		$v_data['module'] = 0;
		
		
		$data['content'] = $this->load->view('services', $v_data, true);
		
		
		$data['sidebar'] = 'admin_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	
	public function import_data()
	{
		$data['content'] = $this->load->view('import_data', '', true);
		$data['sidebar'] = 'admin_sidebar';
		$data['title'] = 'Import';
		$this->load->view('auth/template_sidebar', $data);
	}
	
	public function bulk_add_all_staff()
	{
		if($this->strathmore_population->get_hr_staff())
		{
			$this->session->set_userdata("success_message", "Staff imported successfully");
		}
		
		else
		{
			$this->session->set_userdata("error_message", "Staff could not be imported. Please try again");
		}
		
		redirect('administration/import_data');
	}
	
	public function bulk_add_all_students()
	{
		if($this->strathmore_population->get_hr_staff())
		{
			$this->session->set_userdata("success_message", "Students imported successfully");
		}
		
		else
		{
			$this->session->set_userdata("error_message", "Students could not be imported. Please try again");
		}
		
		redirect('administration/import_data');
	}
}
?>