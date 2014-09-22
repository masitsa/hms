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
	public function lab_queue($page_name=NULL)
	{
		// this is it
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND lab_visit = 12 AND pharmarcy !=7 AND visit.visit_date = \''.date('Y-m-d').'\'';
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
		$table = 'visit, patients';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/lab/lab_queue/'.$page_name;
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
		
		$data['title'] = 'Nurse Queue';
		$v_data['title'] = 'Nurse Queue';
		$v_data['module'] = 0;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('lab_queue', $v_data, true);
		
		
		$data['sidebar'] = 'lab_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function test($visit_id){

		$v_data = array('visit_id'=>$visit_id,'visit'=>1);
		$data['content'] = $this->load->view('tests/test', $v_data, true);
		$data['sidebar'] = 'lab_sidebar';
		$data['title'] = 'Laboratory Test List';
		$this->load->view('auth/template_sidebar', $data);
	}
	public function test1($visit_id)
	{
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

	public function save_result($id,$result,$visit_id)
	{
		$data = array('id'=>$id,'result'=>$result,'visit_id'=>$visit_id);
		$this->load->view('save_result',$data);

	}
	public function finish_lab_test($visit_id){
		redirect('lab/lab_queue');
	}

	public function save_comment($comment,$id){
		$comment = str_replace('%20', ' ',$comment);
		$this->lab_model->save_comment($comment, $id);
	}
	public function send_to_doctor($visit_id)
	{

		$visit_data = array('nurse_visit'=>1,'lab_visit'=>22,'doc_visit'=>1);
		$this->db->where('visit_id',$visit_id);
		if($this->db->update('visit', $visit_data))
		{
			redirect('lab/lab_queue');
		}
		else
		{
			FALSE;
		}
	}
}
?>