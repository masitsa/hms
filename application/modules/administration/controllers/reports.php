<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Reports extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reception/reception_model');
		$this->load->model('reports_model');
		$this->load->model('database');
	}
	
	public function cash_report()
	{
		$search = ' AND payments.visit_id = visit.visit_id';
		$table = ', payments';
		$this->session->set_userdata('all_transactions_search', $search);
		$this->session->set_userdata('all_transactions_tables', $table);
		
		$this->session->set_userdata('debtors', 'false');
		$this->session->set_userdata('page_title', 'Cash Report');
		
		$this->all_transactions();
	}
	
	public function all_reports()
	{
		$this->session->unset_userdata('all_transactions_search');
		$this->session->unset_userdata('all_transactions_tables');
		
		$this->session->set_userdata('debtors', 'false2');
		$this->session->set_userdata('page_title', 'All Transactions');
		
		$this->all_transactions();
	}
	
	public function debtors_report()
	{
		$this->session->unset_userdata('all_transactions_search');
		$this->session->unset_userdata('all_transactions_tables');
		$this->session->set_userdata('page_title', 'Debtors Report');
		
		$this->session->set_userdata('debtors', 'true');
		
		$this->all_transactions();
	}
	
	public function all_transactions()
	{
		$where = 'visit.patient_id = patients.patient_id';
		$table = 'visit, patients';
		$visit_search = $this->session->userdata('all_transactions_search');
		$table_search = $this->session->userdata('all_transactions_tables');
		
		if(!empty($visit_search))
		{
			$where .= $visit_search;
		
			if(!empty($table_search))
			{
				$table .= $table_search;
			}
		}
		$segment = 4;
		
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/administration/reports/all_transactions';
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
		$query = $this->reports_model->get_all_visits($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		$v_data['search'] = $visit_search;
		$v_data['total_patients'] = $config['total_rows'];
		$v_data['total_revenue'] = $this->reports_model->get_total_revenue($where, $table);
		
		$data['title'] = $this->session->userdata('page_title');
		$v_data['title'] = $this->session->userdata('page_title');
		$v_data['debtors'] = $this->session->userdata('debtors');
		
		$v_data['services_query'] = $this->reports_model->get_all_active_services();
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('reports/all_transactions', $v_data, true);
		
		
		$data['sidebar'] = 'admin_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
	}
	
	public function search_transactions()
	{
		$visit_type_id = $this->input->post('visit_type_id');
		$strath_no = $this->input->post('strath_no');
		$personnel_id = $this->input->post('personnel_id');
		$visit_date_from = $this->input->post('visit_date_from');
		$visit_date_to = $this->input->post('visit_date_to');
		
		if(!empty($visit_type_id))
		{
			$visit_type_id = ' AND visit.visit_type = '.$visit_type_id.' ';
		}
		
		if(!empty($strath_no))
		{
			$strath_no = ' AND patients.strath_no LIKE \'%'.$strath_no.'%\' ';
		}
		
		if(!empty($personnel_id))
		{
			$personnel_id = ' AND visit.personnel_id = '.$personnel_id.' ';
		}
		
		if(!empty($visit_date_from) && !empty($visit_date_to))
		{
			$visit_date = ' AND visit.visit_date BETWEEN \''.$visit_date_from.'\' AND \''.$visit_date_to.'\'';
		}
		
		else if(!empty($visit_date_from))
		{
			$visit_date = ' AND visit.visit_date = \''.$visit_date_from.'\'';
		}
		
		else if(!empty($visit_date_to))
		{
			$visit_date = ' AND visit.visit_date = \''.$visit_date_to.'\'';
		}
		
		else
		{
			$visit_date = '';
		}
		
		$search = $visit_type_id.$strath_no.$visit_date.$personnel_id;
		$visit_search = $this->session->userdata('all_transactions_search');
		
		if(!empty($visit_search))
		{
			$search .= $visit_search;
		}
		$this->session->set_userdata('all_transactions_search', $search);
		
		$this->all_transactions();
	}
	
	public function export_transactions()
	{
		$this->reports_model->export_transactions();
	}
	
	public function close_search()
	{
		$this->session->unset_userdata('all_transactions_search');
		$this->session->unset_userdata('all_transactions_tables');
		
		$debtors = $this->session->userdata('debtors');
		
		if($debtors == 'true')
		{
			$this->debtors_report();
		}
		
		else if($debtors == 'false')
		{
			$this->cash_report();
		}
		
		else
		{
			$this->all_reports();
		}
	}
}
?>