<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller 
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('login_model');
		$this->load->model('personnel/personnel_model');
		$this->load->model('reception/reception_model');
		$this->load->model('administration/reports_model');
		
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
	public function change_password($personnel_id)
	{
		 $data['personnel_id'] = $this->session->userdata('personnel_id');
		
		$data2['content'] = $this->load->view('change_password', $data, TRUE);
		$data2['title'] = 'Change Password';
		
		$this->load->view("template_no_sidebar", $data2);
	}
	public function change_user_password($personnel_id)	
	{
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('new_password', 'New password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_new_password', 'New password', 'trim|required|xss_clean');

		//if form conatins invalid data
		if ($this->form_validation->run() == FALSE)
		{
			
			$this->session->set_userdata('error_message', 'Unable to update personnel password. Please try again');
			$this->change_password($personnel_id);
		}
		
		else
		{
			 $response = $this->login_model->change_user_password($personnel_id);
			if($response == TRUE)
			{
				$this->session->set_userdata('success_message', 'Personnel password was successfully updated');
				$this->change_password($personnel_id);
			}
			
			else
			{
				$this->session->set_userdata('error_message', 'Unable to update personnel password. Please try again');
				$this->change_password($personnel_id);
			}
		}

	}
}
?>