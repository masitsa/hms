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
	
	public function patient_card($visit_id,$mike=NULL)
	{
		$v_data['visit_id'] = $visit_id;
		$v_data['patient'] = $this->reception_model->patient_names2(NULL, $visit_id);
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'nurse_sidebar';
		if($mike !=NULL){
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
			$this->db->where(array("visit_id"=>$visit_id,"vital_id"=>$vital_id));
			$this->db->update('visit_vital', $visit_data);
		}else{
			// do an insert
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->insert('visit_vital', $visit_data);
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
		
		$this->patient_card($visit_id);
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
		
		$this->patient_card($visit_id);
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

	function procedures($visit_id){
		$data = array('visit_id'=>$visit_id);
		$this->load->view('procedures_list',$data);	
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

	
	
}
?>