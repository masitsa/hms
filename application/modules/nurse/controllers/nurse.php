<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Nurse extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nurse_model');
		$this->load->model('database');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	
	public function nurse_queue()
	{

	}
	
	public function patient_card($visit_id=1)
	{
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'nurse_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
}
?>