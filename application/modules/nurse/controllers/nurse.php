<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Nurse extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nurse_model');
		$this->load->model('database');
		$this->load->model('reception/reception_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	
	public function nurse_queue()
	{

	}
	
	public function patient_card()
	{
		$visit_id=1;
		$v_data['visit_id'] = $visit_id;
		$v_data['patient'] = $this->reception_model->patient_names2($visit_id);
		$data['content'] = $this->load->view('patient_card', $v_data, true);
		
		$data['title'] = 'Patient Card';
		$data['sidebar'] = 'nurse_sidebar';
		$this->load->view('auth/template_sidebar', $data);	
	}

	public function vitals_interface($visit_id)
	{
		$data = array('visit_id'=>$visit_id);
		$this->load->view('show_vitals',$data);	
	}

	public function load_vitals($vital_id,$visit_id)
	{
		$data = array('vitals_id'=>$vitals_id,'visit_id'=>$visit_id);
		$this->load->view('show_loaded_vitals',$data);	
	}

	public function save_vitals($vital,$vital_id,$visit_id)
	{
		//  check if the data exists in the table
		$table = "visit_vitals";
		$where ="visit_id = $visit_id and vital_id = $vital_id";
		$total_rows = $this->reception_model->count_items($table, $where);
		
		if($total_rows > 0){
			// do an update to the data there
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->where("visit_id",$visit_id);
			$this->db->update('visit_vital', $visit_data);
		}else{
			// do an insert
			$time = date('h:i:s');
			$visit_data = array('vital_id'=>$vital_id,'visit_vitals_time'=>'$time','visit_id'=>$visit_id,'visit_vital_value'=>$vital);
			$this->db->insert('visit_vital', $visit_data);
		}
		
	}

}
?>