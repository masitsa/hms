<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "./application/modules/auth/controllers/auth.php";

class Lab extends auth
{	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('lab_model');
		$this->load->model('reception/reception_model');
		$this->load->model('database');
		$this->load->model('reception/reception_model');
		$this->load->model('nurse/nurse_model');
	}
	
	public function index()
	{
		echo "no patient id";
	}
	public function lab_queue($page_name=NULL)
	{
		// this is it
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND lab_visit = 12 AND pharmarcy !=7 AND visit.visit_date = \''.date('Y-m-d').'\'';
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
		$config['base_url'] = site_url().'/lab/lab_queue/'.$page_name;
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
		
		$data['content'] = $this->load->view('lab_queue', $v_data, true);
		
		
		$data['sidebar'] = 'lab_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it
	}
	public function test($visit_id){

		$v_data = array('visit_id'=>$visit_id,'visit'=>1);
		$data['content'] = $this->load->view('tests/test', $v_data, true);
		$data['sidebar'] = 'lab_sidebar';
		$data['title'] = 'Laboratory Test List';
		$this->load->view('auth/template_sidebar', $data);
	}
	public function test1($visit_id)
	{
		$data = array('visit_id'=>$visit_id);
		$this->load->view('tests/test1',$data);
	}
	public function laboratory_list($lab,$visit_id){

		//check patient visit type
		$rs = $this->nurse_model->check_visit_type($visit_id);
		if(count($rs)>0){
		  foreach ($rs as $rs1) {
			# code...
			  $visit_t = $rs1->visit_type;
		  }
		}

		if ($lab ==2){
			$this->session->set_userdata('nurse_lab',$lab);
		}
		else {
			$this->session->set_userdata('nurse_lab',NULL);
		}

		
		$order = 'service_charge_name';
		
		$where = 'service_charge.service_charge_name = lab_test.lab_test_name
		AND lab_test_class.lab_test_class_id = lab_test.lab_test_class_id  AND service_charge.service_id = 5  AND  service_charge.visit_type_id = '.$visit_t;
		$test_search = $this->session->userdata('test_search');
		
		if(!empty($test_search))
		{
			$where .= $test_search;
		}
		
		$table = '`service_charge`, lab_test_class, lab_test';
		//pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url().'/lab/laboratory_list/'.$lab.'/'.$visit_id;
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
		$query = $this->lab_model->get_lab_tests($table, $where, $config["per_page"], $page, $order);
		
		$v_data['query'] = $query;
		$v_data['page'] = $page;
		
		$data['title'] = 'Laboratory Test List';
		$v_data['title'] = 'Laboratory Test List';
		
		$v_data['visit_id'] = $visit_id;
		$data['content'] = $this->load->view('laboratory_list', $v_data, true);
		
		$data['title'] = 'Laboratory Test List';
		$this->load->view('auth/template_no_sidebar', $data);	

	}

	

	public function test_lab($visit_id,$service_charge_id=NULL){
		$data = array('service_charge_id'=>$service_charge_id,'visit_id'=>$visit_id);
		$this->load->view('test_lab',$data);
	}

	public function save_result($id,$result,$visit_id)
	{
		$data = array('id'=>$id,'result'=>$result,'visit_id'=>$visit_id);
		$this->load->view('save_result',$data);

	}
	public function finish_lab_test($visit_id){
		redirect('lab/lab_queue');
	}

	public function save_comment($comment,$id){
		$comment = str_replace('%20', ' ',$comment);
		$this->lab_model->save_comment($comment, $id);
	}
	public function send_to_doctor($visit_id)
	{

		$visit_data = array('nurse_visit'=>1,'lab_visit'=>22,'doc_visit'=>1);
		$this->db->where('visit_id',$visit_id);
		if($this->db->update('visit', $visit_data))
		{
			redirect('lab/lab_queue');
		}
		else
		{
			FALSE;
		}
	}
	public function send_to_accounts($visit_id,$module= NULL)
	{
		redirect("nurse/send_to_accounts/".$visit_id."/2");
	}
	public function test_history($visit_id,$page_name = NULL)
	{
		// this is it
		$where = 'visit.patient_id = patients.patient_id AND visit.close_card = 0 AND lab_visit = 12 AND pharmarcy !=7 AND visit.visit_id = '.$visit_id.' AND  visit.visit_date = \''.date('Y-m-d').'\'';
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
		$config['base_url'] = site_url().'/lab/test_history/'.$page_name;
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
		
		$data['title'] = 'Test History';
		$v_data['title'] = 'Test History';
		$v_data['module'] = 0;
		
		$v_data['type'] = $this->reception_model->get_types();
		$v_data['doctors'] = $this->reception_model->get_doctor();
		
		$data['content'] = $this->load->view('test_history', $v_data, true);
		
		
		$data['sidebar'] = 'lab_sidebar';
		
		
		$this->load->view('auth/template_sidebar', $data);
		// end of it

	}

	function print_test($visit_id,$patient_id)
	{
		$this->load->library('fpdf');
		$lab_rs = $this->lab_model->get_lab_visit($visit_id);
		$num_lab_visit = count($lab_rs);

		$rs2 = $this->lab_model->get_comment($visit_id);
		$num_rows2 = count($rs2);

		if($num_rows2 > 0){
			foreach ($rs2 as $key2):
				$comment = $key2->lab_visit_comment;
				$visit_date = $key2->visit_date;
				$this->session->set_userdata('visit_date',$visit_date);
			endforeach;
			
		}

		$s = 0;

		
		if(empty($patient_id)){
			
			$patient_id = $this->lab_model->get_patient_id($visit_id);
			
		}
		$rs = $this->lab_model->get_patient2($patient_id);
		foreach ($rs as $key):
			$strath_no =$key->strath_no;
			$visit_type =$key->visit_type_id;
			$visit_date = $this->session->userdata('visit_date');
			$patient_number = $key->patient_number;
		endforeach;
		//echo $strath_type;
		if($visit_type == 1){
								
			$rs2 = $this->lab_model->get_patient_2($strath_no);
			$rows = count($rs2);//echo "rows = ".$rows; 
			
			foreach ($rs2 as $key2):
				$name = $key2->Other_names;
				$secondname = $key2->Surname;
				$patient_dob = $key2->DOB;
				$patient_sex = $key2->gender;
			endforeach;
			
		}
							
		else if($visit_type == 2){
				
			$rs2 = $this->lab_model->get_patient_3($strath_no);
			$rows = count($rs2);//echo "rows = ".$rows;
				
			foreach ($rs2 as $key2):
				$name = $key2->Other_names;
				$secondname = $key2->Surname;
				$patient_dob = $key2->DOB;
				$patient_sex = $key2->Gender;
			endforeach;
		}
		
		else{

			
			foreach ($rs as $key):
				$name = $key->patient_othernames;
				$secondname = $key->patient_surname;
				$patient_dob = $key->patient_date_of_birth;
				$patient_sex = $key->gender_id;
			endforeach;
			
		}
			$current_date = date("y-m-d");	
			//get the age
			$p_age = $this->lab_model->dateDiff($patient_dob." 00:00", $current_date." 00:00", "year");
			
			$lineBreak = 10;
			
			//Colors of frames, background and Text
			$this->fpdf->SetDrawColor(41, 22, 111);
			$this->fpdf->SetFillColor(190, 186, 211);
			$this->fpdf->SetTextColor(41, 22, 111);

			//thickness of frame (mm)
			//$this->fpdf->SetLineWidth(1);
			//Logo
			$this->fpdf->Image(base_url().'img/createslogo.jpg',20,0,140);
			//font
			$this->fpdf->SetFont('Arial', 'B', 12);
			//title

			$this->fpdf->Ln(25);
			$this->fpdf->Cell(100,5, 'DIAGNOSTIC LABORATORY SERVICES', 0, 0, 'L');
			$this->fpdf->Cell(50, 5, 'Laboratory Report Form', 0, 0, 'L');
			$this->fpdf->Cell(50, 5, 'Date: '.$visit_date, 'B', 1, 'L');

			$this->fpdf->Cell(100,5,'Name:	'.$secondname." ".$name, 0, 0, 'L');
			$this->fpdf->Cell(50,5,'Age:'.$p_age, 0, 0, 'L');
			if(($patient_sex == 1) ||($patient_sex =='M')){
				$patient_sex = "Male";
			}
			elseif(($patient_sex == 2) ||($patient_sex =='F')){
				$patient_sex = "Female";
			}
			
			$this->session->set_userdata('patient_sex',$patient_sex);
			$this->fpdf->Cell(50,5,'Sex:'.$patient_sex, 0, 1, 'L');
			//$this->fpdf->Cell(-30);//move left
			$this->fpdf->Cell(0,7,'Clinic Number:'.$patient_number, 'B', 1, 'L');
			//line break
			$pageH = 7;
			$this->fpdf->SetTextColor(0, 0, 0);
			$this->fpdf->SetDrawColor(0, 0, 0);
			$this->fpdf->SetFont('Times','B',10);
		

				
			$this->fpdf->SetDrawColor(41, 22, 111);
			$personnel_id = $this->session->userdata('personnel_id');
	
			$rs2 = $this->lab_model->get_lab_personnel($personnel_id);
			$num_rows = count($rs2);

			if($num_rows > 0){
				foreach($rs2 as $key):
					$personnel = $key->personnel_surname;
					$personnel = $personnel." ".$key->personnel_fname;
				endforeach;
				
			}
			
			else{
				$personnel = "";
			}
			//position 1.5cm from Bottom
			$this->fpdf->SetY(-15);
			//set Text color to gray
			$this->fpdf->SetTextColor(128);
			//font
			$this->fpdf->SetFont('Arial', 'I', 8);
			//time
			$this->fpdf->Cell(40, 10, "Time: ".date("h:i:s"),'T',0,"L");
			//page number
			$this->fpdf->Cell(0, 10, 'Page '.$this->fpdf->PageNo().'/{nb}','T',0,"C");
			//personnel
			$this->fpdf->Cell(0, 10, "Prepared By ".$personnel,'T',0,"R");
			
		

			//Instanciating the class
		
			$this->fpdf->AliasNbPages();
			$this->fpdf->AddPage();
			$this->fpdf->setFont('Times', '', 10);
			$this->fpdf->SetFillColor(190, 186, 211);

			//HEADER
			$billTotal = 0;
			$linespacing = 2;
			$majorSpacing = 7;
			$pageH = 5;
			$counter = 0;

			if($num_lab_visit > 0){
				foreach ($lab_rs as $key_lab):
					$visit_charge_id = $key_lab->visit_charge_id;
					
					
					
				endforeach;
					$rsy2 = $this->lab_model->get_test_comment($visit_charge_id);
					$num_rowsy2 = count($rsy2);
				if($num_rowsy2 >0){
					foreach ($rsy2 as $key2y):
							$comment4= $key2y->lab_visit_format_comments;
					endforeach;
				}	
			
			else {
				
			$comment4="";	
				}
			$format_rs = $this->lab_model->get_lab_visit_result($visit_charge_id);
			$num_format = count($format_rs);
			
		
			
			if($num_format > 0){
				$rs = $this->lab_model->get_test($visit_charge_id);
				$num_lab = count($rs);
				
			}
			
			else{
				$rs = $this->lab_model->get_m_test($visit_charge_id);
				$num_lab = count($rs);
				
						
			}
			

				if($num_lab > 0){
					$counts =0;
					foreach ($rs as $key_what):
					$counts++;
					$lab_test_name = $key_what->lab_test_name;
					$lab_test_class_name = $key_what->lab_test_class_name;
					$lab_test_units = $key_what->lab_test_units;
					$lab_test_lower_limit = $key_what->lab_test_malelowerlimit;
					$lab_test_upper_limit = $key_what->lab_test_malelupperlimit;
					$lab_test_lower_limit1 = $key_what->lab_test_femalelowerlimit;
					$lab_test_upper_limit1 = $key_what->lab_test_femaleupperlimit;
			    	$visit_charge_id = $key_what->lab_visit_id;
			   		$lab_results = $key_what->lab_visit_result;
					
					//results for formats
					if($this->session->userdata('test') ==0){
					
						$test_format = $key_what->lab_test_formatname;
						$lab_test_format_id = $key_what->lab_test_format_id;
						$lab_results = $key_what->lab_visit_results_result;
						$lab_test_units = $key_what->lab_test_format_units;
						$lab_test_lower_limit = $key_what->lab_test_format_malelowerlimit;
						$lab_test_upper_limit = $key_what->lab_test_format_maleupperlimit;
						$lab_test_lower_limit1 = $key_what->lab_test_format_femalelowerlimit;
						$lab_test_upper_limit1 = $key_what->lab_test_format_femaleupperlimit;
					}
					
					//if there are no formats
					else{
						$test_format ="-";
					}


					if(($counter % 2) == 0){
						$fill = TRUE;
					}

					else{
						$fill = FALSE;
					}
					$next_name ="";
					if ($counts<$num_lab-1){
						$next_name = $rs[$count]->lab_test_name;
					}
					
					if(($lab_test_name <> $next_name) || ($counts == 0)){ 
						
						$this->fpdf->Ln(5);
						
						$this->fpdf->SetFont('Times', 'B', 10);
						$this->fpdf->Cell(50,$pageH,"TEST: ".$lab_test_name, 'B',1,'L', FALSE);
						$this->fpdf->Cell(50,$pageH,"CLASS: ".$lab_test_class_name, 'B',1,'L', FALSE);
					
						$this->fpdf->Ln(2);
						
						$this->fpdf->Cell(50,$pageH,"Sub Test", 1,0,'L', FALSE);
						$this->fpdf->Cell(50,$pageH,"Results",1,0,'L', FALSE);
						$this->fpdf->Cell(50,$pageH,"Units",1,0,'L', FALSE);
						$this->fpdf->Cell(30,$pageH,"Normal Limits",1,1,'L', FALSE);
						$this->fpdf->SetFont('Times', '', 10);
					}
					
					$this->fpdf->Cell(50,$pageH,$test_format, 1,0,'L', $fill);
					$this->fpdf->Cell(50,$pageH,$lab_results,1,0,'L', $fill);
					$this->fpdf->Cell(50,$pageH,$lab_test_units,1,0,'L', $fill);
					
					if($this->session->userdata('patient_sex') == "Male"){
						$this->fpdf->Cell(30,$pageH,$lab_test_lower_limit." - ".$lab_test_upper_limit,1,1,'L', $fill);
					}
					
					else{
						$this->fpdf->Cell(30,$pageH,$lab_test_lower_limit1." - ".$lab_test_upper_limit1,1,1,'L', $fill);
					}
					$counter++;
				endforeach;
			}
			if($test_format !="-"){ 
			$this->fpdf->Ln(3);
					$this->fpdf->SetFont('Times', 'B', 10);
			$this->fpdf->Cell(0,10,"".$lab_test_name ."  Comment ",'B',1,'L', $fill);
			$this->fpdf->SetFont('Times', '', 10);
			$this->fpdf->Cell(0,10,$comment4,0,1,'L', $fill=true);
				}

			if(($counter % 2) == 0){
				$fill = TRUE;
			}

			else{
				$fill = FALSE;
			}

			$this->fpdf->Ln(5);
			$this->fpdf->SetFont('Times', 'B', 10);
			$this->fpdf->Cell(0,10,"Comments ",'B',1,'L', $fill);
			$this->fpdf->SetFont('Times', '', 10);
			$this->fpdf->Cell(0,10,$comment,0,1,'L', $fill);
			}

			$this->fpdf->Output();

	}
}
?>