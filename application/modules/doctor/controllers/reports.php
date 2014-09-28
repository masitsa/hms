<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Doctor extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nurse/nurse_model');
		$this->load->model('reception/reception_model');
		$this->load->model('doctor_model');
		$this->load->model('database');
		$this->load->model('medical_admin/medical_admin_model');
		$this->load->model('pharmacy/pharmacy_model');
	}
	
	public function all_transactions()
	{
		$this->session->unset_userdata('visit_search');
		$this->session->unset_userdata('patient_search');
		
		$where = 'visit_department.visit_id = visit.visit_id AND visit_department.department_id = 2 AND visit_department.visit_department_status = 1 AND visit.patient_id = patients.patient_id AND visit.close_card = 0 AND visit.visit_date = \''.date('Y-m-d').'\' AND visit.personnel_id = '.$this->session->userdata('personnel_id');
		
		$table = 'visit_department, visit, patients';
		$query = $this->reception_model->get_all_ongoing_visits($table, $where, 6, 0);
		$v_data['query'] = $query;
		$v_data['page'] = 0;
		
		$v_data['visit'] = 0;
		$v_data['doctor_appointments'] = 1;
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('nurse/nurse_dashboard', $v_data, TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'doctor_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
}
?>