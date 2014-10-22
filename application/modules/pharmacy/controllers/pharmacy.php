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
		$this->load->model('accounts/accounts_model');
	}
	
	public function index()
	{
		$this->session->unset_userdata('visit_search');
		$this->session->unset_userdata('patient_search');
		
		$where = 'visit_department.visit_id = visit.visit_id AND visit_department.department_id = 5 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\'';
		
		$table = 'visit_department, visit, patients';
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, 6, 0);
		$v_data['query'] = $query;
		$v_data['page'] = 0;
		$v_data['visit'] = 5;
		$v_data['department'] = 5;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('laboratory/dashboard', $v_data, TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'pharmacy_sidebar';
		$this->load->view('auth/template_sidebar', $data);
	}

	public function prescription($visit_id,$service_charge_id=NULL,$module=NULL,$prescription_id=NULL)
	{
		//$this->form_validation->set_rules('substitution', 'Substitution', 'xss_clean');
		// $this->form_validation->set_rules('prescription_finishdate', 'Finish Date', 'trim|required|xss_clean');
		$this->form_validation->set_rules('x', 'Times Per Day', 'trim|required|xss_clean');
		$this->form_validation->set_rules('number_of_days', 'Number of Day', 'required|xss_clean');
		//$this->form_validation->set_rules('visit_charge_id', 'Cost', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration', 'Duration', 'trim|required|xss_clean');
		$this->form_validation->set_rules('consumption', 'Consumption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('quantity', 'Quantity', 'trim|required|xss_clean');
		$this->form_validation->set_rules('service_charge_id', 'Drug', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$this->pharmacy_model->save_prescription($visit_id);
			if($module == 1){
				redirect('pharmacy/prescription1/'.$visit_id."/1");
			}else{
				redirect('pharmacy/prescription/'.$visit_id);
			}
			
		}
		$patient = $this->reception_model->patient_names2(NULL, $visit_id);
		$visit_type = $patient['visit_type'];
		$patient_type = $patient['patient_type'];
		$patient_othernames = $patient['patient_othernames'];
		$patient_surname = $patient['patient_surname'];
		$patient_date_of_birth = $patient['patient_date_of_birth'];
		$age = $this->reception_model->calculate_age($patient_date_of_birth);
		$gender = $patient['gender'];
		
		$patient = 'Surname: <span style="font-weight: normal;">'.$patient_surname.'</span> Othernames: <span style="font-weight: normal;">'.$patient_othernames.'</span> Age: <span style="font-weight: normal;">'.$age.'</span> Gender: <span style="font-weight: normal;">'.$gender.'</span> Patient Type: <span style="font-weight: normal;">'.$visit_type.'</span>';
		
		$v_data = array('visit_id'=>$visit_id,'service_charge_id'=>$service_charge_id,'prescription_id'=>$prescription_id,'module'=>$module,'patient'=>$patient);
		$data['content'] = $this->load->view('prescription', $v_data, true);
		
		if($module == 1){
			$data['title'] = 'Prescription';
			$data['sidebar'] = 'pharmacy_sidebar';
			$this->load->view('auth/template_sidebar', $data);

		}else{
			$data['title'] = 'Pharmacy medicine ';
			$this->load->view('auth/template_no_sidebar', $data);	
		}
		
	}

	public function update_prescription($visit_id, $visit_charge_id, $prescription_id,$module = NULL){
		$this->form_validation->set_rules('substitution'.$prescription_id, 'Substitution', 'trim|required|xss_clean');
		$this->form_validation->set_rules('x'.$prescription_id, 'Times Per Day', 'trim|required|xss_clean');
		$this->form_validation->set_rules('duration'.$prescription_id, 'Duration', 'trim|required|xss_clean');
		$this->form_validation->set_rules('consumption'.$prescription_id, 'Consumption', 'trim|required|xss_clean');
		$this->form_validation->set_rules('quantity'.$prescription_id, 'Quantity', 'trim|required|xss_clean');

		if($module == 1)
		{
			$this->form_validation->set_rules('units_given'.$prescription_id, 'Units Given', 'trim|required|xss_clean');	
		}
		
		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata('error_message', validation_errors());
		}

		else
		{
			if($this->pharmacy_model->update_prescription($visit_id, $visit_charge_id, $prescription_id))
			{
				$this->session->set_userdata('success_message', 'Prescription updated successfully');
			}

			else
			{
				$this->session->set_userdata('error_message', 'Could not update the prescription. Please try again');
			}
		
		}
		if($module == 1){
			redirect('pharmacy/prescription1/'.$visit_id.'/1');
			
		}else{
			redirect('pharmacy/prescription/'.$visit_id);
		}
	}
	public function search_drugs($visit_id)
	{
		$this->form_validation->set_rules('search_item', 'Search', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$search = ' AND drugs_name LIKE \'%'.$this->input->post('search_item').'%\'';
			$this->session->set_userdata('drugs_search', $search);
		}
		
		$this->drugs($visit_id,0);
	}
	
	public function close_drugs_search($visit_id)
	{
		$this->session->unset_userdata('drugs_search');
		$this->drugs($visit_id,0);
	}
	public function drugs($visit_id,$module= NULL){

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
		$config['base_url'] = site_url().'/pharmacy/drugs/'.$visit_id.'/'.$module;
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
		$query = $this->pharmacy_model->get_drugs($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Drugs List';
		$v_data['title'] = 'Drugs List';
		
		$v_data['visit_id'] = $visit_id;
		$v_data['module'] = $module;
		$data['content'] = $this->load->view('drugs', $v_data, true);
		
		$data['title'] = 'Drugs List';
		$this->load->view('auth/template_no_sidebar', $data);
	}
	public function display_prescription($visit_id){
		$visit_data = array('visit_id'=>$visit_id);
		$this->load->view('display_prescription',$visit_data);
	}
	public function pharmacy_queue($page_name = NULL)
	{
		$where = 'visit_department.visit_id = visit.visit_id AND visit_department.department_id = 5 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\'';
		$table = 'visit_department, visit, patients';
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
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/pharmacy/pharmacy_queue/'.$page_name;
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
		
		$data['title'] = 'Pharmacy Queue';
		$v_data['title'] = 'Pharmacy Queue';
		$v_data['module'] = 0;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('pharmacy_queue', $v_data, true);
		
		
		$data['sidebar'] = 'pharmacy_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function prescription1($visit_id,$module=NULL)
	{	
		$v_data['visit_id'] = $visit_id;
		$patient = $this->reception_model->patient_names2(NULL, $visit_id);
		$visit_type = $patient['visit_type'];
		$patient_type = $patient['patient_type'];
		$patient_othernames = $patient['patient_othernames'];
		$patient_surname = $patient['patient_surname'];
		$patient_date_of_birth = $patient['patient_date_of_birth'];
		$age = $this->reception_model->calculate_age($patient_date_of_birth);
		$gender = $patient['gender'];
		
		$v_data['patient'] = 'Surname: <span style="font-weight: normal;">'.$patient_surname.'</span> Othernames: <span style="font-weight: normal;">'.$patient_othernames.'</span> Age: <span style="font-weight: normal;">'.$age.'</span> Gender: <span style="font-weight: normal;">'.$gender.'</span> Patient Type: <span style="font-weight: normal;">'.$visit_type.'</span>';
		
		$v_data['module'] = $module;
		
		$data['content'] = $this->load->view('prescription', $v_data, TRUE);
		
		$data['title'] = 'Prescription';
		$data['sidebar'] = 'pharmacy_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	public function send_to_accounts($primary_key)
	{
		redirect('nurse/send_to_accounts/'.$primary_key.'/3');
	}
	public function delete_prescription($prescription_id,$visit_id,$visit_charge_id,$module)
	{
		//  delete the visit charge

		$this->db->where(array("visit_charge_id"=>$visit_charge_id));
		$this->db->delete('visit_charge');
		
		//  check if the visit charge has been deleted

		$rs = $this->pharmacy_model->check_deleted_visitcharge($visit_charge_id);
		$num_rows =count($rs);

		//echo BB.$visit_charge_id;
		if($num_rows==0){
			$this->db->where(array("prescription_id"=>$prescription_id));
			$this->db->delete('pres');
		}
		if($module == 1)
		{
			redirect('pharmacy/prescription1/'.$visit_id."/1");
		}
		else
		{
			redirect('pharmacy/prescription/'.$visit_id);
		}
	}
}
?>