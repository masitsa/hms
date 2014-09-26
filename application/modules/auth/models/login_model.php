<?php

class Login_model extends CI_Model 
{
	/*
	*	Check if user has logged in
	*
	*/
	public function check_login()
	{
		if($this->session->userdata('login_status'))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Validate a user's login request
	*
	*/
	public function validate_user()
	{
		//select the user by email from the database
		$this->db->select('*');
		$this->db->where(array('personnel_username' => $this->input->post('username'), 'authorise' => 0, 'personnel_password' => md5($this->input->post('password'))));
		$query = $this->db->get('personnel');
		
		//if users exists
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			//create user's login session
			$newdata = array(
                   'login_status'     	=> TRUE,
                   'personnel_fname'  	=> $result[0]->personnel_fname,
                   'first_name'     	=> $result[0]->personnel_fname,
                   'personnel_email'	=> $result[0]->personnel_email,
                   'personnel_id'  		=> $result[0]->personnel_id
               );

			$this->session->set_userdata($newdata);
			
			//update user's last login date time
			$this->update_user_login($result[0]->personnel_id);
			return TRUE;
		}
		
		//if user doesn't exist
		else
		{
			return FALSE;
		}
	}
	
	/*
	*	Update user's last login date
	*
	*/
	private function update_user_login($personnel_id)
	{
		$session_log_insert = array(
			"personnel_id" => $personnel_id, 
			"session_name_id" => 1
		);
		$table = "session";
		$this->db->insert($table, $session_log_insert);
		
		return TRUE;
	}
	
	/*
	*	Reset a user's password
	*
	*/
	public function reset_password($user_id)
	{
		$new_password = substr(md5(date('Y-m-d H:i:s')), 0, 6);
		
		$data['password'] = md5($new_password);
		$this->db->where('user_id', $user_id);
		$this->db->update('users', $data); 
		
		return $new_password;
	}
	
	public function get_new_orders()
	{
		$this->db->select('COUNT(order_id) AS total_orders');
		$this->db->where('order_status = 1');
		$query = $this->db->get('orders');
		
		$result = $query->row();
		
		return $result->total_orders;
	}
	
	public function get_balance()
	{
		//select the user by email from the database
		$this->db->select('SUM(price*quantity) AS total_orders');
		$this->db->where('order_status = 2 AND orders.order_id = order_item.order_id');
		$this->db->from('orders, order_item');
		$query = $this->db->get();
		
		$result = $query->row();
		
		return $result->total_orders;
	}
}