<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Administration extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('reception/reception_model');
		$this->load->model('reception/strathmore_population');
		$this->load->model('reports_model');
		$this->load->model('administration_model');
		$this->load->model('database');
	}
	
	public function index()
	{
		$this->session->unset_userdata('all_transactions_search');
		
		$data['content'] = $this->load->view('dashboard', '', TRUE);
		
		$data['title'] = 'Dashboard';
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);
	}

	public function services($page_name = NULL)
	{
		// this is it
		$where = 'service_id > 0';
		$service_search = $this->session->userdata('service_search');
		
		if(!empty($service_search))
		{
			$where .= $service_search;
		}
		
		if($page_name == NULL)
		{
			$segment = 3;
		}
		
		else
		{
			$segment = 4;
		}
		$table = 'service';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/administration/services/'.$page_name;
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
		$query = $this->administration_model->get_all_services($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Services';
		$v_data['title'] = 'Services';
		$v_data['module'] = 0;
		
		
		$data['content'] = $this->load->view('services', $v_data, true);
		
		
		$data['sidebar'] = 'admin_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function service_charges($service_id,$page_name = NULL)
	{
		// this is it
		$where = 'service.service_id = service_charge.service_id AND service_charge.service_charge_status = 1 AND service_charge.visit_type_id = visit_type.visit_type_id AND service_charge.service_id = '.$service_id;
		$service_charge_search = $this->session->userdata('service_charge_search');
		
		if(!empty($service_charge_search))
		{
			$where .= $service_charge_search;
		}
		
		if($page_name == NULL)
		{
			$segment = 3;
		}
		
		else
		{
			$segment = 4;
		}
		$table = 'service,service_charge,visit_type';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/administration/service_charges/'.$service_id.'/'.$page_name;
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
		$query = $this->administration_model->get_all_service_charges($table, $where, $config["per_page"], $page, 'ASC');
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Services Charges';
		$v_data['title'] = 'Services Charges';
		$v_data['module'] = 0;
		$v_data['service_id'] = $service_id;
		$v_data['service_name'] = $this->administration_model->get_service_names($service_id);
		$data['content'] = $this->load->view('service_charges', $v_data, true);
		
		
		$data['sidebar'] = 'admin_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	
	public function import_data()
	{
		$data['content'] = $this->load->view('import_data', '', true);
		$data['sidebar'] = 'admin_sidebar';
		$data['title'] = 'Import';
		$this->load->view('auth/template_sidebar', $data);
	}
	
	public function bulk_add_all_staff()
	{
		if($this->strathmore_population->get_hr_staff())
		{
			$this->session->set_userdata("success_message", "Staff imported successfully");
		}
		
		else
		{
			$this->session->set_userdata("error_message", "Staff could not be imported. Please try again");
		}
		
		redirect('administration/import_data');
	}
	
	public function bulk_add_all_students()
	{
		if($this->strathmore_population->get_ams_student())
		{
			$this->session->set_userdata("success_message", "Students imported successfully");
		}
		
		else
		{
			$this->session->set_userdata("error_message", "Students could not be imported. Please try again");
		}
		
		redirect('administration/import_data');
	}
	
	public function add_service_charge($service_id)
	{
		$v_data = array('service_id'=>$service_id);
		$v_data['service_id'] = $service_id;

		$data['title'] = 'Add Service Charge';
		$v_data['title'] = 'Add Service Charge';
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['service_charge_id'] = $service_charge_id;
		$v_data['service_name'] = $this->administration_model->get_service_names($service_id);
		$data['content'] = $this->load->view('add_service_charge',$v_data,TRUE);
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}

	public function service_charge_add($service_id)
	{
		$this->form_validation->set_rules('service_charge_name', 'Service Charge name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('patient_type', 'Patient Type', 'trim|required|xss_clean');
		$this->form_validation->set_rules('charge', 'charge', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_userdata("error_message","Fill in the fields");
				$this->add_service_charge($service_id);
		}
		else
		{
				$result = $this->administration_model->submit_service_charges($service_id);
				if($result == FALSE)
				{
					$this->session->set_userdata("error_message","Seems like there is a duplicate of this service charge. Please try again");
					$this->add_service_charge($service_id);
				}
				else
				{
					$this->session->set_userdata("success_message","Successfully created a service charge");
					$this->add_service_charge($service_id);
				}
		}

	}
	public function new_service()
	{

		$data['title'] = 'Add Service ';
		$v_data['title'] = 'Add Service ';
		$v_data['service_id'] = 0;
		$data['content'] = $this->load->view('add_service',$v_data,TRUE);
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}

	public function service_add()
	{
		$this->form_validation->set_rules('service_name', 'Service Charge name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
				$this->session->set_userdata("error_message","Fill in the fields");
				$this->new_service();
		}
		else
		{
				$result = $this->administration_model->submit_service();
				if($result == FALSE)
				{
					$this->session->set_userdata("error_message","Seems like there is a duplicate of this service . Please try again");
					$this->new_service();
				}
				else
				{
					$this->session->set_userdata("success_message","Successfully created a service ");
					$this->new_service();
				}
		}

	}
	public function edit_service($service_id)
	{
		$data['title'] = 'Edit  Service ';
		$v_data['title'] = 'Edit Service ';
		$v_data['service_id'] = $service_id;
		$v_data['service_name'] = $this->administration_model->get_service_names($service_id);
		$data['content'] = $this->load->view('add_service',$v_data,TRUE);
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);
	}

	public function update_service($service_id)
	{
		$this->form_validation->set_rules('service_name', 'Service Charge name', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata("error_message","Fill in the fields");
			$this->edit_service($service_id);
		}
		else
		{
			$service_name = $this->input->post('service_name');
			$visit_data = array('service_name'=>$service_name);
			$this->db->where('service_id',$service_id);
			$this->db->update('service', $visit_data);
			$this->edit_service($service_id);
		}
		
	}
	public function edit_service_charge($service_id,$service_charge_id)
	{
		$v_data = array('service_id'=>$service_id);
		$v_data['service_id'] = $service_id;

		$data['title'] = 'Add Service Charge';
		$v_data['title'] = 'Add Service Charge';
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['service_charge_id'] = $service_charge_id;
		$v_data['service_name'] = $this->administration_model->get_service_names($service_id);
		$data['content'] = $this->load->view('add_service_charge',$v_data,TRUE);
		$data['sidebar'] = 'admin_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}
	public function update_service_charge($service_id,$service_charge_id)
	{
		$this->form_validation->set_rules('service_charge_name', 'Service Charge name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('charge', 'Charge', 'trim|required|xss_clean');
		$this->form_validation->set_rules('patient_type', 'Patient Type', 'trim|required|xss_clean');

		if ($this->form_validation->run() == FALSE)
		{
			$this->session->set_userdata("error_message","Fill in the fields");
			$this->edit_service_charge($service_id,$service_charge_id);
		}
		else
		{
			$service_charge_name = $this->input->post('service_charge_name');
			$patient_type = $this->input->post('patient_type');
			$charge = $this->input->post('charge');

			$visit_data = array('service_charge_name'=>$service_charge_name,'visit_type_id'=>$patient_type,'service_charge_amount'=>$charge);
			$this->db->where('service_charge_id',$service_charge_id);
			$this->db->update('service_charge', $visit_data);
			$this->edit_service_charge($service_id,$service_charge_id);
		}
		
	}
	public function delete_visit_charge($visit_charge_id)
	{

		$visit_data = array('visit_charge_delete'=>1);
		$this->db->where(array("visit_charge_id"=>$visit_charge_id));
		$this->db->update('visit_charge', $visit_data);
		redirect('reception/general_queue/administration');
	}
	public function update_visit_charge($visit_charge_id)
	{
		
		$consultation_id = $this->input->post('consultation');

		$table = "visit_charge";
		$where = "visit_charge_delete = 0 AND visit_charge_id = ".$visit_charge_id;
		$items = "*";
		$order = "visit_charge_id";
		
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{
			foreach ($result as $key):
				# code...
				$visit_id = $key->visit_id;
				$visit_charge_units = $key->visit_charge_units;

			endforeach;
			$date = date('Y-m-d');
			//  need to update this to one then
			$visit_data = array('visit_charge_delete'=>1,'deleted_by'=>$this->session->userdata("personnel_id"),'deleted_on'=>$date);
		
			$this->db->where(array("visit_charge_id"=>$visit_charge_id));
			$this->db->update('visit_charge', $visit_data);
			// end of updating the charge to 1

			// start to insert a new charge 
			$service_charge = $this->reception_model->get_service_charge($consultation_id);		
		
			$visit_charge_data = array(
				"visit_id" => $visit_id,
				"service_charge_id" => $consultation_id,
				"date" => $date,
				"visit_charge_units" => $visit_charge_units,
				"created_by" => $this->session->userdata("personnel_id"),
				"visit_charge_amount" => $service_charge
			);
			if($this->db->insert('visit_charge', $visit_charge_data))
			{
				return TRUE;
			}
			
			else
			{
				return FALSE;
			}
			// end of inserting a new charge
		}
		else
		{
			return FALSE;
		}
		
	}
}
?>