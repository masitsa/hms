<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Pharmacy extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('pharmacy_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
		$this->load->model('reception/reception_model');
		$this->load->model('nurse/nurse_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}

	public function prescription($visit_id,$service_charge_id=NULL,$prescription_id=NULL)
	{
		$this->form_validation->set_rules('substitution', 'Substitution', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('prescription_finishdate', 'Finish Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('x', 'Times Per Day', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('visit_charge_id', 'Cost', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('service_charge_id', 'Drug', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{

			$this->pharmacy_model->save_prescription($visit_id);

			redirect('pharmacy/prescription/'.$visit_id);
		}

		$v_data = array('visit_id'=>$visit_id,'service_charge_id'=>$service_charge_id,'prescription_id'=>$prescription_id);
		$data['content'] = $this->load->view('prescription', $v_data, true);
		
		$data['title'] = 'Pharmacy medicine ';
		$this->load->view('auth/template_no_sidebar', $data);	
	}

	public function update_prescription($visit_id){
		$this->form_validation->set_rules('substitution', 'Substitution', 'trim|required|xss_clean');
		// $this->form_validation->set_rules('prescription_finishdate', 'Finish Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('x', 'Times Per Day', 'trim|required|xss_clean');
		//$this->form_validation->set_rules('visit_charge_id', 'Cost', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('service_charge_id', 'Drug', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{

			$this->pharmacy_model->update_prescription($visit_id);

			redirect('pharmacy/prescription/'.$visit_id);
		}

		$v_data = array('visit_id'=>$visit_id,'service_charge_id'=>$service_charge_id,'prescription_id'=>$prescription_id);
		$data['content'] = $this->load->view('prescription', $v_data, true);
		
		$data['title'] = 'Pharmacy medicine ';
		$this->load->view('auth/template_no_sidebar', $data);	
	}

	public function drugs($visit_id){
		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}


		
		$order = 'drugs.drugs_id';
		
		if(($visit_t =1) || ($visit_t = 2)){
				$where = 'drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 0';
		}else if($visit_t == 4){
				$where = 'drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 4 ';
		}else{
				$where = 'drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 0 ';
		}
		
		$drugs_search = $this->session->userdata('drugs_search');
		
		if(!empty($drugs_search))
		{
			$where .= $drugs_search;
		}
		
		$table = 'drugs, service_charge, generic, brand,class';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/pharmacy/drugs/'.$visit_id;
		$config['total_rows'] = $this->reception_model->count_items($table, $where);
		$config['uri_segment'] = 4;
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
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $v_data["links"] = $this->pagination->create_links();
		$query = $this->pharmacy_model->get_drugs($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Drugs List';
		$v_data['title'] = 'Drugs List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('drugs', $v_data, true);
		
		$data['title'] = 'Drugs List';
		$this->load->view('auth/template_no_sidebar', $data);
	}
}
?>