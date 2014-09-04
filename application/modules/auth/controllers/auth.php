<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		$this->load->model('personnel/personnel_model');
		
		if(!$this->login_model->check_login())
		{
			redirect('login');
		}
	}
	
	public function index()
	{
		$this->control_panel($this->session->userdata('personnel_id'));
	}
	
	public function control_panel($personnel_id)
	{
		$data['personnel_id'] = $personnel_id;
		$data['personnel_departments'] = $this->personnel_model->get_personnel_department($personnel_id);
		
		$data2['content'] = $this->load->view('control_panel', $data, TRUE);
		$data2['title'] = 'Control Panel';
		
		$this->load->view("template_no_sidebar", $data2);
	}
}
?>