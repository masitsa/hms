<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Accounts extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('accounts_model');
		$this->load->model('nurse/nurse_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
		$this->load->model('medical_admin/medical_admin_model');
		$this->load->model('pharmacy/pharmacy_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	
	public function accounts_queue()
	{
		$where = 'visit.visit_delete = 0 AND visit_department.visit_id = visit.visit_id AND visit_department.department_id = 6 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\'';
		$table = 'visit_department, visit, patients';
		
		$visit_search = $this->session->userdata('visit_search');
		
		if(!empty($visit_search))
		{
			$where .= $visit_search;
		}
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/accounts/accounts_queue/';
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
		
		$data['title'] = 'Accounts Queue';
		$v_data['title'] = 'Accounts Queue';
		$v_data['module'] = 0;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('accounts_queue', $v_data, true);
		$data['sidebar'] = 'accounts_sidebar';
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
		

	}

	public function invoice($visit_id)
	{
		?>
        	<script type="text/javascript">
        		var config_url = $('#config_url').val();
				window.open(config_url+"/accounts/print_invoice/<?php echo $visit_id;?>","Popup","height=900,width=1200,,scrollbars=yes,"+"directories=yes,location=yes,menubar=yes,"+"resizable=no status=no,history=no top = 50 left = 100");
				window.location.href="<?php echo base_url("index.php/accounts/accounts_queue")?>";
			</script>
        <?php
		
		$this->accounts_queue();
	}
	
	public function payments($visit_id){
		$v_data = array('visit_id'=>$visit_id);
		$v_data['patient'] = $this->reception_model->patient_names2(NULL, $visit_id);
		$data['content'] = $this->load->view('payments', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'accounts_sidebar';

		$this->load->view('auth/template_sidebar', $data);
	}
	
	public function make_payments($visit_id){
		$this->form_validation->set_rules('payment_method', 'Payment Method', 'trim|required|xss_clean');
		$this->form_validation->set_rules('amount_paid', 'Amount', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$this->accounts_model->receipt_payment($visit_id);
			redirect('accounts/payments/'.$visit_id);
		}
		else
		{
			$this->session->set_userdata("error_message","Fill in the fields");
			redirect('accounts/payments/'.$visit_id);
		}
	}
	
	public function print_receipt($visit_id)
	{
		$this->accounts_model->receipt($visit_id);
	}
	
	public function print_invoice($visit_id)
	{
		$this->accounts_model->receipt($visit_id, TRUE);
	}
}