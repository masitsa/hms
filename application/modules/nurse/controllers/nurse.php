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
		$this->load->model('medical_admin/medical_admin_model');
		$this->load->model('pharmacy/pharmacy_model');
	}
	
	public function index()
	{
		$this->session->unset_userdata('visit_search');
		$this->session->unset_userdata('patient_search');
		
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND nurse_visit = 0 AND pharmarcy !=7 AND visit.visit_date = \''.date('Y-m-d').'\'';
		$table = 'visit, patients';
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, 6, 0);
		$v_data['query'] = $query;
		$v_data['page'] = 0;
		
		$v_data['visit'] = 0;
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('nurse_dashboard', $v_data, TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'nurse_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	
	public function nurse_queue($page_name = NULL)
	{
		// this is it
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND nurse_visit = 0 AND pharmarcy !=7 AND visit.visit_date = \''.date('Y-m-d').'\'';
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
		$config['base_url'] = site_url().'/nurse/nurse_queue/'.$page_name;
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
		
		$data['content'] = $this->load->view('nurse_queue', $v_data, true);
		
		if($page_name == 'doctor')
		{
			$data['sidebar'] = 'doctor_sidebar';
		}
		
		else
		{
			$data['sidebar'] = 'nurse_sidebar';
		}
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	
	public function patient_card($visit_id, $mike = NULL, $module = NULL)
	{
		$v_data['module'] = $module;
		$v_data['visit_id'] = $visit_id;
		$v_data['patient'] = $this->reception_model->patient_names2(NULL, $visit_id);
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		
		if($module == 0)
		{
			$data['sidebar'] = 'nurse_sidebar';
		}
		
		else
		{
			$data['sidebar'] = 'doctor_sidebar';
		}
		if(($mike != NULL) && ($mike != 'a')){
			$this->load->view('auth/template_no_sidebar', $data);	
		}else{
			$this->load->view('auth/template_sidebar', $data);	
		}
	}
	
	public function dental_visit($visit_id, $mike = NULL, $module = NULL){
		$v_data['module'] = $module;
		$v_data['visit_id'] = $visit_id;
		$v_data['patient'] = $this->reception_model->patient_names2(NULL, $visit_id);
		$data['content'] = $this->load->view('dental_visit', $v_data, true);
		
		$data['title'] = "Dental Visit";
		
		if($module == 0)
		{
			$data['sidebar'] = 'nurse_sidebar';
		}
		
		else
		{
			$data['sidebar'] = 'doctor_sidebar';
		}
		if(($mike != NULL) && ($mike != 'a')){
			$this->load->view('auth/template_no_sidebar', $data);	
		}else{
			$this->load->view('auth/template_sidebar', $data);	
		}
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

	public function save_vitals($vital_id,$visit_id)
	{
		$vital=$this->input->post('vital');
		//  check if the data exists in the table
		$table = "visit_vital";
		$where ="visit_id = $visit_id and vital_id = $vital_id";
		$total_rows = $this->reception_model->count_items($table, $where);
		
		if($total_rows > 0){
			// do an update to the data there
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->where(array("visit_id"=>$visit_id,"vital_id"=>$vital_id));
			$this->db->update('visit_vital', $visit_data);
		}else{
			// do an insert
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->insert('visit_vital', $visit_data);
		}
	}
	
	public function dental_vitals($visit_id)
	{
		//saving vitals
		if (isset($_POST['submit']))
		{
			$this->save_dental_vitals($visit_id);
			$this->patient_card($visit_id);
		}
		
		//saving & going to dentist
		else if (isset($_POST['submit']))
		{
			$this->save_dental_vitals($visit_id);
			$this->end_dental_vitals($visit_id);
		}
		
		//updating & going to dentist
		else if (isset($_POST['update']))
		{
			$dental_vitals_id = $this->input->post('dental_vitals_id');
			
			$this->update_dental_vitals($visit_id, $dental_vitals_id);
			$this->patient_card($visit_id);
		}
		
		//updating & going to dentist
		else if (isset($_POST['update1']))
		{
			$dental_vitals_id = $this->input->post('dental_vitals_id');
			
			$this->update_dental_vitals($visit_id, $dental_vitals_id);
			$this->end_dental_vitals($visit_id);
		}
		
		else
		{
			$this->patient_card($visit_id);
		}
	}
	
	public function save_dental_vitals($visit_id)
	{
		$save = $this->nurse_model->save_dental_vitals($visit_id);
		
		if($save != FALSE)
		{
			$this->session->set_userdata('success_message', 'Dental vitals saved successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Error saving dental vitals. Please try again');
		}
		
		return TRUE;
	}
	
	public function end_dental_vitals($visit_id)
	{
		$save = $this->nurse_model->save_dental_vitals($visit_id);	
		
		if($save != FALSE)
		{
			$update = $this->nurse_model->update_dental_visit($visit_id);
			
			if($update)
			{
				$this->session->set_userdata('success_message', 'Dental vitals saved successfully');
				
				redirect('nurse/nurse_queue');
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Error updating visit. Please try again');
				$this->patient_card($visit_id);
			}
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Error saving dental vitals. Please try again');
			$this->patient_card($visit_id);
		}
	}
	
	public function update_dental_vitals($visit_id, $dental_vitals_id)
	{	
		$update = $this->nurse_model->update_dental_vitals($dental_vitals_id);
		
		if($update != FALSE)
		{
			$this->session->set_userdata('success_message', 'Dental vitals updated successfully');
		}
		
		else
		{
			$this->session->set_userdata('error_message', 'Error updating dental vitals. Please try again');
		}
		
		return TRUE;
	}
	
	public function get_family_history($visit_id)
	{
		$v_data['patient_id'] = $this->reception_model->get_patient_id_from_visit($visit_id);
		$v_data['patient'] = $this->reception_model->patient_names2(NULL, $visit_id);
		$v_data['family_disease_query'] = $this->nurse_model->get_family_disease();
		$v_data['family_query'] = $this->nurse_model->get_family();
		
		echo $this->load->view('patients/family_history', $v_data, TRUE);
	}
	function previous_vitals($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('show_previous_vitals',$data);	
	}

	function calculate_bmi($vitals_id,$visit_id){
		$data = array('vitals_id'=>$vitals_id,'visit_id'=>$visit_id);
		$this->load->view('calculate_bmi',$data);
	}
	function calculate_hwr($vitals_id,$visit_id){
		$data = array('vitals_id'=>$vitals_id,'visit_id'=>$visit_id);
		$this->load->view('calculate_hwr',$data);
	}
	function view_procedure($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('view_procedure',$data);
	}
	
	public function search_procedures($visit_id)
	{
		$this->form_validation->set_rules('search_item', 'Search', 'trim|required|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run())
		{
			$search = ' AND service_charge_name LIKE \'%'.$this->input->post('search_item').'%\'';
			$this->session->set_userdata('procedure_search', $search);
		}
		
		$this->procedures($visit_id);
	}
	
	public function close_procedure_search($visit_id)
	{
		$this->session->unset_userdata('procedure_search');
		$this->procedures($visit_id);
	}

	function procedures($visit_id)
	{
		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}
		
		$order = 'service_charge_name';
		
		$where = 'service_id = 3 AND visit_type_id = '.$visit_t;
		$procedure_search = $this->session->userdata('procedure_search');
		
		if(!empty($procedure_search))
		{
			$where .= $procedure_search;
		}
		
		$table = 'service_charge';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/nurse/procedures/'.$visit_id;
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
		$query = $this->nurse_model->get_procedures($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Procedure List';
		$v_data['title'] = 'Procedure List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('procedures_list', $v_data, true);
		
		$data['title'] = 'Procedure List';
		$this->load->view('auth/template_no_sidebar', $data);	
	}

	function procedure($procedure_id,$visit_id,$suck){
		$data = array('procedure_id'=>$procedure_id,'visit_id'=>$visit_id,'suck'=>$suck);
		$this->load->view('procedure',$data);	
	}
	function delete_procedure($procedure_id)
	{
		$this->db->where(array("visit_charge_id"=>$procedure_id));
		$this->db->delete('visit_charge', $visit_data);
	}

	function add_lifestyle($patient_id){

	}
	
	public function save_family_disease($disease_id, $family_id, $patient_id)
	{
		$this->nurse_model->save_family_disease($family_id, $patient_id, $disease_id);
	}
	
	public function delete_family_disease($disease_id, $family_id, $patient_id)
	{
		$this->nurse_model->delete_family_disease($family_id, $patient_id, $disease_id);
	}


	public function save_lifestyle($visit_id){
		$this->form_validation->set_rules('diet', 'Diet', 'trim|xss_clean');
		$this->form_validation->set_rules('drugs', 'Drugs', 'trim|xss_clean');
		$this->form_validation->set_rules('alcohol_percentage', 'Alcohol %', 'trim|xss_clean');
		$this->form_validation->set_rules('alcohol_qty', 'Alcohol Qty', 'trim|xss_clean');
		
		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata("error_message","Fill in the fields");
			$this->patient_card($visit_id);
		}
		
		else
		{
			$patient_id = $this->nurse_model->get_patient_id($patient_id);
			
			if($patient_id != FALSE)
			{
				$this->nurse_model->submit_lifestyle_values($patient_id);
			}
			
			else
			{
				$this->session->set_userdata("error_message","Could not find patient. Please try again");
				$this->patient_card($visit_id);	
			}
		}
		
	}
	public function procedure_total($procedure_id,$units,$amount){
		

		$visit_data = array('visit_charge_units'=>$units);
		$this->db->where(array("visit_charge_id"=>$procedure_id));
		$this->db->update('visit_charge', $visit_data);
	}

	public function view_symptoms($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('soap/view_symptoms',$data);	
	}
	public function view_objective_findings($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('soap/view_objective_findings',$data);
	}
	public function view_assessment($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('soap/view_assessment',$data);
	}
	public function view_plan($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('soap/view_plan',$data);
	}
	public function symptoms_list($visit_id){

		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}
		
		$order = 'symptoms_id';
		
		$where = 'symptoms_id > 0 ';
		$symptoms_search = $this->session->userdata('symptoms_search');
		
		if(!empty($symptoms_search))
		{
			$where .= $symptoms_search;
		}
		
		$table = 'symptoms';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/nurse/symptoms_list/'.$visit_id;
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
		$query = $this->nurse_model->get_symptom_list($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Symptoms List';
		$v_data['title'] = 'Symptoms List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('symptoms_list', $v_data, true);
		
		$data['title'] = 'Symptoms List';
		$this->load->view('auth/template_no_sidebar', $data);

	}
	function symptoms($symptoms_id,$status,$visit_id,$description=NULL){
		$data = array('symptoms_id'=>$symptoms_id,'status'=>$status,'visit_id'=>$visit_id,'description'=>$description);
		$this->load->view('soap/symptoms',$data);
	}
	function objective_finding($visit_id){
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('soap/objective_finding', $v_data, true);
		
		$data['title'] = 'Symptoms List';
		$this->load->view('auth/template_no_sidebar', $data);
	}
	function add_objective_findings($objective_finding_id,$visit_id,$status,$description=NULL){
		$data = array('objective_finding_id'=>$objective_finding_id,'visit_id'=>$visit_id,'update_id'=>$status,'description'=>$description);
		$this->load->view('soap/add_objective_findings',$data);
	}

	function save_assessment($assessment,$visit_id){
		$assessment = str_replace('%20', ' ',$assessment);
		$visit_data = array('visit_assessment'=>$assessment);

		$this->db->where(array("visit_id"=>$visit_id));
		$this->db->update('visit', $visit_data);
	}
	function save_plan($plan,$visit_id){
		$plan = str_replace('%20', ' ',$plan);
		$visit_data = array('visit_plan'=>$plan);

		$this->db->where(array("visit_id"=>$visit_id));
		$this->db->update('visit', $visit_data);
	}
	

	function save_objective_findings($objective_finding,$visit_id){
		$objective_finding = str_replace('%20', ' ',$objective_finding);
		$visit_data = array('visit_objective_findings'=>$objective_finding);

		$this->db->where(array("visit_id"=>$visit_id));
		$this->db->update('visit', $visit_data);
	}
	function save_symptoms($symptoms,$visit_id){
		$symptoms = str_replace('%20', ' ',$symptoms);
		$visit_data = array('visit_symptoms'=>$symptoms);

		$this->db->where(array("visit_id"=>$visit_id));
		$this->db->update('visit', $visit_data);
	}


	public function disease($visit_id){




		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}
		
		$order = 'diseases_id';
		
		$where = 'diseases_id > 0 ';
		$desease_search = $this->session->userdata('desease_search');
		
		if(!empty($desease_search))
		{
			$where .= $desease_search;
		}
		
		$table = 'diseases';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/nurse/disease/'.$visit_id;
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
		$query = $this->nurse_model->get_diseases($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Disease List';
		$v_data['title'] = 'Disease List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('soap/disease', $v_data, true);
		
		$data['title'] = 'Disease List';
		$this->load->view('auth/template_no_sidebar', $data);	

	}

	function get_diagnosis($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('soap/get_diagnosis',$data);
	}
	function save_diagnosis($disease_id,$visit_id){

		$visit_data = array('visit_id'=>$visit_id,'disease_id'=>$disease_id);
		$this->db->insert('diagnosis', $visit_data);
	}
	function diagnose($visit_id){
		$visit_data = array('visit_id'=>$visit_id);
		$this->load->view('soap/diagnose',$visit_data);
	}

	public function doctor_notes($visit_id)
	{
		$visit_data = array('visit_id'=>$visit_id);
		$this->load->view('soap/doctor_notes',$visit_data);
	}
	public function save_doctor_notes($notes,$visit_id){
		$notes = str_replace('%20', ' ',$notes);
		$patient_id = $this->nurse_model->get_patient_id($visit_id);
		
		$this->nurse_model->save_doctor_notes($notes,$patient_id);

	}
	public function nurse_notes($visit_id){
		$visit_data = array('visit_id'=>$visit_id);
		$this->load->view('soap/nurse_notes',$visit_data);
	}
	public function save_nurse_notes($notes,$visit_id){
		$notes = str_replace('%20', ' ',$notes);
		$patient_id = $this->nurse_model->get_patient_id($visit_id);
		
		$this->nurse_model->save_nurse_notes($notes,$patient_id);

	}

	public function send_to_doctor($visit_id)
	{
		$visit_data = array('nurse_visit'=>1);
		$this->db->where('visit_id',$visit_id);
		if($this->db->update('visit', $visit_data))
		{
			redirect('nurse/nurse_queue');
		}
		else
		{
			FALSE;
		}
	}
	public function send_to_labs($visit_id)
	{
		$visit_data = array('nurse_visit'=>1,'lab_visit'=>12,'doc_visit'=>1);
		$this->db->where('visit_id',$visit_id);
		if($this->db->update('visit', $visit_data))
		{
			redirect('nurse/nurse_queue');
		}
		else
		{
			FALSE;
		}
	}
	public function send_to_pharmacy($visit_id)
	{
		$visit_data = array('nurse_visit'=>1,'pharmarcy'=>6,'doc_visit'=>1);
		$this->db->where('visit_id',$visit_id);
		if($this->db->update('visit', $visit_data))
		{
			redirect('nurse/nurse_queue');
		}
		else
		{
			FALSE;
		}
	}
	
	public function save_illness($mec_id, $visit_id)
	{
		$illness = $this->input->post('illness');
		//$illness = str_replace('%20', ' ', $illness);
		
		//check if illness has been saved
		$query = $this->nurse_model->check_text_save($mec_id,$visit_id);
		
		//update if it exists
		if($query->num_rows() > 0)
		{
			if($this->nurse_model->update_illness($illness, $query->row()))
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
		
		//otherwise insert new row
		else
		{
			if($this->nurse_model->save_illness($illness, $mec_id, $visit_id))
			{
				echo 'true';
			}
			else
			{
				echo 'false';
			}
		}
	}
	
	public function save_medical_exam($cat_items_id, $format_id, $visit_id)
	{
		if($this->nurse_model->save_medical_exam($cat_items_id, $format_id, $visit_id))
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
	
	public function delete_medical_exam($cat_items_id, $format_id, $visit_id)
	{
		if($this->nurse_model->delete_medical_exam($cat_items_id, $format_id, $visit_id))
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	
	function queue_totals()
	{
		//initialize required variables
		$totals = '';
		$names = '';
		$highest_bar = 0;
		$r = 1;
		$date = date('Y-m-d');
		
		//get nurse total
		$table = 'patients, visit';
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND nurse_visit = 0 AND visit.visit_date = \''.$date.'\'';
		$nurse_total = $this->nurse_model->get_queue_total($table, $where);
		
		if($nurse_total > $highest_bar)
		{
			$highest_bar = $nurse_total;
		}
		
		//get doctor total
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND nurse_visit = 1 AND doc_visit = 0 AND visit.visit_date = \''.$date.'\'';
		$doctor_total = $this->nurse_model->get_queue_total($table, $where);
		
		if($doctor_total > $highest_bar)
		{
			$highest_bar = $doctor_total;
		}
		
		//get lab total
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.lab_visit = 12 AND visit.visit_date = \''.$date.'\'';
		$lab_total = $this->nurse_model->get_queue_total($table, $where);
		
		if($lab_total > $highest_bar)
		{
			$highest_bar = $lab_total;
		}
		
		//get pharnacy total
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.pharmarcy = 6 AND visit.visit_date = \''.$date.'\'';
		$pharmacy_total = $this->nurse_model->get_queue_total($table, $where);
		
		if($pharmacy_total > $highest_bar)
		{
			$highest_bar = $pharmacy_total;
		}
		
		$result['total_services'] = 4;
		$result['names'] = 'nurse, doctor, laboratory, pharmacy';
		$result['bars'] = $nurse_total.', '.$doctor_total.', '.$lab_total.', '.$pharmacy_total;
		$result['highest_bar'] = $highest_bar;
		echo json_encode($result);
	}
	public function send_to_accounts($primary_key,$module)
	{
		
		if($module == 2){
			$visit_data = array('pharmarcy'=>7,'nurse_visit'=>1,'lab_visit'=>1);
		}else if($module == 1){
			$visit_data = array('pharmarcy'=>7);
		}else{
			$visit_data = array('pharmarcy'=>7,'nurse_visit'=>1);
		}
		
		$this->db->where(array("visit_id"=>$primary_key));
		$this->db->update('visit', $visit_data);
		if($module == 0){
			redirect("nurse/nurse_queue");
		}else if($module == 2){
			redirect("lab/lab_queue");
		}else if($module == 1){
			redirect("pharmacy/pharmacy_queue");
		}else{
			redirect("doctor/doctor_queue");
		}
		

	}
	function from_lab_queue($page_name = NULL){
		// this is it

		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND doc_visit=1 AND lab_visit=22 AND visit.nurse_visit = 1 AND visit.pharmarcy !=7 AND visit.visit_date = \''.date('Y-m-d').'\'';
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
		$config['base_url'] = site_url().'/nurse/from_lab_queue/'.$page_name;
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
		
		$data['title'] = 'From Lab Queue';
		$v_data['title'] = 'From Lab Queue';
		$v_data['module'] = 0;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('from_lab_queue', $v_data, true);
		
		if($page_name == 'doctor')
		{
			$data['sidebar'] = 'doctor_sidebar';
		}
		
		else
		{
			$data['sidebar'] = 'nurse_sidebar';
		}
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	
}
?>