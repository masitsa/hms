<?php

class Accounts_model extends CI_Model 
{

	public function payments2($visit_id)
	{
		$table = "payments";
		$where = "payments.visit_id =". $visit_id;
		$items = "payments.amount_paid";
		$order = "amount_paid";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		$total = 0;
		
		if(count($result) > 0){
			foreach ($result as $row2):
				$amount_paid = $row2->amount_paid;
				$total = $total + $amount_paid;
			endforeach;
		}
		
		else{
			$total = 0;
		}
		
		$value = $total;
		
		return $value;
	}


	public function total($visit_id)
	{
	 	$total=""; 
	 	$temp="";
		
		//identify patient/visit type

		$visit_type_rs = $this->nurse_model->get_visit_type($visit_id);
		foreach ($visit_type_rs as $key):
			$visit_t = $key->visit_type;
		endforeach;

		//  get patient id 
		$patient_id = $this->nurse_model->get_patient_id($visit_id);

	
		//  get the visit type details
		$type_details_rs = $this->visit_type_details($visit_t);
		$num_type = count($type_details_rs);
		if($num_type > 0){
			foreach ($type_details_rs as $key_details):
				$visit_type_name = $key_details->visit_type_name;
			endforeach;
		}
		if ($visit_type_name=="Insurance")
		{
			//  get insuarance amounts 
			$insurance_rs = $this->get_service_charges_amounts($visit_id);
		    $num_rows = count($insurance_rs);
			foreach ($insurance_rs as $key_values):
				$service_id1  = $key_values->service_id;
				$visit_charge_amount  = $key_values->visit_charge_amount;
				$visit_charge_units  = $key_values->visit_charge_units;
				$discounted_value="";
				
				$dicount_rs = $this->get_dicountend_values($patient_id,$service_id1);
				foreach ($dicount_rs as $key_disounts):
					$percentage = $key_disounts->percentage;
					$amount = $key_disounts->amount;
				endforeach;
					$penn=((100-$percentage)/100);
					$discounted_value="";	
					if($percentage==0){
						$discounted_value=$amount;	
						$sum = $visit_charge_amount -$discounted_value;			
				
					}
					else if($amount==0){
						$discounted_value=$percentage;
						$sum = $visit_charge_amount *((100-$discounted_value)/100);
						$penn=((100-$discounted_value)/100);
					}
					else if(($amount==0)&&($percentage==0)){
						$sum=$visit_charge_amount;
					}
						
				$total=($sum*$visit_charge_units)+$temp;	$temp=$total;
						
			endforeach;

			return $total;
		}
		else
		{
			$amount_rs = $this->get_service_charges_amounts($visit_id);
		    $num_rows = count($amount_rs);
			foreach ($amount_rs as $key_values):

				$service_id1  = $key_values->service_id;
				$visit_charge_amount  = $key_values->visit_charge_amount;
				$visit_charge_units  = $key_values->visit_charge_units;
				$amount=$visit_charge_amount*$visit_charge_units;


				$total = $total + $amount;
						
			endforeach;

			return $total;
		}
	
	}

	function visit_type_details($visit_type_id){
		$table = "visit_type";
		$where = "visit_type.visit_type_id =". $visit_type_id;
		$items = "*";
		$order = "visit_type_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function get_service_charges_amounts($visit_id)
	{
		$table = "visit_charge, service_charge";
		$where = "service_charge.service_charge_id = visit_charge.service_charge_id
		AND visit_charge.visit_id =". $visit_id;
		$items = "visit_charge.visit_charge_amount,visit_charge.visit_charge_units,visit_charge.service_charge_id,service_charge.service_id";
		$order = "visit_charge.service_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
		
	}

	function get_dicountend_values($patient_id,$service_id)
	{
		$table = "insurance_discounts";
		$where = "insurance_id = (SELECT company_insurance_id FROM `patient_insurance` where patient_id = ". $patient_id .") and service_id = ". $service_id;
		$items = "*";
		$order = "insurance_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	function get_payment_methods()
	{
		$table = "payment_method";
		$where = "payment_method_id > 0";
		$items = "*";
		$order = "payment_method_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	public function balance($payments, $invoice_total)
	{
		
		$value = $payments - $invoice_total;
		if($value > 0){
			$value= '(-'.$value.')';
		}
		else{
			$value= -(1) * ($value);
		}
	
		return $value;
	}

	public function get_patient_visit_charge_items($visit_id)
	{
		$table = "visit_charge, service_charge,service";
		$where = "service_charge.service_id = service.service_id AND visit_charge.visit_charge_delete = 0 AND visit_charge.service_charge_id = service_charge.service_charge_id AND visit_charge.visit_id =". $visit_id;
		$items = "service.service_name,service_charge.service_charge_name,visit_charge.service_charge_id,visit_charge.visit_charge_units, visit_charge.visit_charge_amount, service_charge.service_id,visit_charge.visit_charge_timestamp,visit_charge.visit_charge_id,visit_charge.created_by";
		$order = "visit_charge.service_charge_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	public function get_patient_visit_charge($visit_id)
	{
		$table = "visit_charge, service_charge, service";
		$where = "service_charge.service_id = service.service_id AND visit_charge.service_charge_id = service_charge.service_charge_id AND visit_charge.visit_id =". $visit_id;
		$items = "DISTINCT(service_charge.service_id) AS service_id, service.service_name,";
		$order = "service_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;

	}

	public function payments($visit_id){
		$table = "payments,payment_method";
		$where = "payment_method.payment_method_id = payments.payment_method_id AND payments.visit_id =". $visit_id;
		$items = "*";
		$order = "payments.payment_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	public function get_sum_credit_notes($visit_id)
	{
		$table = "payments";
		$where = "payments.payment_type = 3 AND payments.visit_id =". $visit_id;
		$items = "SUM(payments.amount_paid) AS amount_paid";
		$order = "payments.payment_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{

			foreach ($result as $key):
				# code...
				$amount = $key->amount_paid;

				if(!is_numeric($amount))
				{
					return 0;
				}
				else
				{
					return $amount;
				}
			endforeach;
		}
		else
		{
			return 0;
		}

	}
	public function get_sum_debit_notes($visit_id)
	{
		$table = "payments";
		$where = "payments.payment_type = 2 AND payments.visit_id =". $visit_id;
		$items = "SUM(payments.amount_paid) AS amount_paid";
		$order = "payments.payment_id";
		
		$result = $this->database->select_entries_where($table, $where, $items, $order);
		
		if(count($result) > 0)
		{

			foreach ($result as $key):
				# code...
				$amount = $key->amount_paid;

				if(!is_numeric($amount))
				{
					return 0;
				}
				else
				{
					return $amount;
				}
			endforeach;
		}
		else
		{
			return 0;
		}

	}
	public function receipt_payment($visit_id){
		$amount = $this->input->post('amount_paid');
		$payment_method=$this->input->post('payment_method');
		$type_payment=$this->input->post('type_payment');
		$data = array('visit_id' => $visit_id,'payment_method_id'=>$payment_method,'amount_paid'=>$amount,'personnel_id'=>$this->session->userdata("personnel_id"),'payment_type'=>$type_payment);
		if($this->db->insert('payments', $data))
		{
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}

	}
	public function add_billing($visit_id)
	{
		$billing_method_id = $this->input->post('billing_method_id');
		$data = array('bill_to_id' => $billing_method_id);
		
		$this->db->where('visit_id', $visit_id);
		if($this->db->update('visit', $data))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}

	}
	
	public function receipt($visit_id, $invoice = NULL)
	{
		// if($invoice != NULL)
		// {
		// 	$title = 'INVOICE';
		// 	$heading = 'Invoice';
		// 	$number = 'INV/00'.$visit_id;
		// }
		// else
		// {
		// 	$title = 'RECEIPT';
		// 	$heading = 'Receipt';
		// 	$number = 'REC/00'.$visit_id;
		// }
		$title = 'INVOICE';
		$heading = 'Invoice';
		$number = 'INV/00'.$visit_id;
		$personnel_id = $this->session->userdata('personnel_id');
		/*
			-----------------------------------------------------------------------------------------
			Retrieve the details of the patient
			-----------------------------------------------------------------------------------------
		*/
		$patient = $this->reception_model->get_patient_data_from_visit($visit_id);
		$strath_no = $patient->strath_no;
		$visit_type = $patient->visit_type;
		$doctor_id = $patient->personnel_id;
		$patient_number = $patient->patient_number;
		$patient_insurance_id = $patient->patient_insurance_id;
		$visit_date = date('jS M Y H:i a',strtotime($patient->visit_time));
		$dependant_id = $patient->dependant_id;
		
		//patient names
		if($visit_type == 2)
		{
			//dependant
			if($dependant_id > 0)
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type, $dependant_id);
				
				$dependant_query = $this->reception_model->get_dependant($strath_no);
				
				if($dependant_query->num_rows() > 0)
				{
					$dependants_result = $dependant_query->row();
					
					$patient_othernames = $dependants_result->other_names;
					$patient_surname = $dependants_result->names;
					$patient_date_of_birth = $dependants_result->DOB;
					$relationship = $dependants_result->relation;
					$gender = $dependants_result->Gender;
				}
				
				else
				{
					$patient_othernames = '<span class="label label-important">Dependant not found</span>';
					$patient_surname = '';
					$patient_date_of_birth = '';
					$relationship = '';
					$gender = '';
				}
			}
			
			//staff
			else
			{
				$patient_type = $this->reception_model->get_patient_type($visit_type, $dependant_id);
				$staff_query = $this->reception_model->get_staff($strath_no);
				
				if($staff_query->num_rows() > 0)
				{
					$staff_result = $staff_query->row();
					
					$patient_surname = $staff_result->Surname;
					$patient_othernames = $staff_result->Other_names;
					$patient_date_of_birth = $staff_result->DOB;
					$patient_phone1 = $staff_result->contact;
					$gender = $staff_result->gender;
				}
				
				else
				{
					$patient_othernames = '<span class="label label-important">Staff not found</span>';
					$patient_surname = '';
					$patient_date_of_birth = '';
					$relationship = '';
					$gender = '';
					$patient_type = '';
				}
			}
		}
		
		//student
		else if($visit_type == 1)
		{
			$student_query = $this->reception_model->get_student($strath_no);
			$patient_type = $this->reception_model->get_patient_type($visit_type);
			
			if($student_query->num_rows() > 0)
			{
				$student_result = $student_query->row();
				
				$patient_surname = $student_result->Surname;
				$patient_othernames = $student_result->Other_names;
				$patient_date_of_birth = $student_result->DOB;
				$patient_phone1 = $student_result->contact;
				$gender = $student_result->gender;
			}
			
			else
			{
				$patient_othernames = '<span class="label label-important">Student not found</span>';
				$patient_surname = '';
				$patient_date_of_birth = '';
				$relationship = '';
				$gender = '';
			}
		}
		
		//other patient
		else
		{
			$patient_type = $this->reception_model->get_patient_type($visit_type);
			
			if($visit_type == 3)
			{
				$visit_type = 'Other';
			}
			else if($visit_type == 4)
			{
				$visit_type = 'Insurance';
			}
			else
			{
				$visit_type = 'General';
			}
			
			$patient_othernames = $patient->patient_othernames;
			$patient_surname = $patient->patient_surname;
			$patient_date_of_birth = $patient->patient_date_of_birth;
			$gender_id = $patient->gender_id;
			
			if($gender_id == 1)
			{
				$gender = 'Male';
			}
			else
			{
				$gender = 'Female';
			}
		}
		
		/*
			-----------------------------------------------------------------------------------------
			Get personnel data of the person who is printing the receipt
			-----------------------------------------------------------------------------------------
		*/
		$personnel = $this->personnel_model->get_single_personnel($personnel_id);
		$personnel_surname = $personnel->personnel_onames;
		$personnel_fname = $personnel->personnel_fname;
		
		//doctor
		if($doctor_id > 0)
		{
			$doctor_data = $this->personnel_model->get_single_personnel($doctor_id);
			$doctor_surname = $doctor_data->personnel_onames;
			$doctor_fname = $doctor_data->personnel_fname;
			$doctor = $doctor_surname." ".$doctor_fname;
		}
		
		else
		{
			$doctor = '-';
		}
		
		$totalxx = 0;
			
		/*
			-----------------------------------------------------------------------------------------
			Measurements of the page cells
			-----------------------------------------------------------------------------------------
		*/
		$pageH = 5;//height of an output cell
		$pageW = 0;//width of the output cell. Takes the entire width of the page
		$lineBreak = 20;//height between cells
		
		/*
			-----------------------------------------------------------------------------------------
			Begin creating the PDF in A4
			-----------------------------------------------------------------------------------------
		*/
		$this->load->library('fpdf');
		$this->fpdf->AliasNbPages();
		$this->fpdf->AddPage();
		
		/*
			-----------------------------------------------------------------------------------------
			Colors of frames, background and Text
			-----------------------------------------------------------------------------------------
		*/
		$this->fpdf->SetDrawColor(092, 123, 29);//color of borders
		$this->fpdf->SetFillColor(0, 232, 12);//color of shading
		//$this->fpdf->SetTextColor(092, 123, 29);//color of text
		$this->fpdf->SetFont('Times', 'B', 12);
		
		/*
			-----------------------------------------------------------------------------------------
			Title of the document.
			-----------------------------------------------------------------------------------------
		*/
		$lineBreak = 20;
		//Colors of frames, background and Text
		$this->fpdf->SetDrawColor(092, 123, 29);
		$this->fpdf->SetFillColor(0, 232, 12);
		$this->fpdf->SetTextColor(092, 123, 29);
		
		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		$this->fpdf->Image(base_url().'images/strathmore.gif',10,8,45,15);
		//font
		$this->fpdf->SetFont('Arial', 'B', 12);
		//title
		$this->fpdf->Cell(0, 5, 'Strathmore University Medical Center', 0, 1, 'C');
		$this->fpdf->Cell(0, 5, 'P.O. Box 59857 00200, Nairobi, Kenya', 0, 1, 'C');
		$this->fpdf->Cell(0, 5, 'info@strathmore.edu', 0, 1, 'C');
		$this->fpdf->Cell(0, 5, 'Madaraka Estate', 'B', 1, 'C');
		$this->fpdf->SetFont('Arial', 'B', 10);
		
		$this->fpdf->Cell(0, 5, $title, 'B', 1, 'C');
		
		$this->fpdf->Ln(3);
		$this->fpdf->Cell(100,5,'Patient Name:	'.$patient_surname.' '.$patient_othernames, 0, 0, 'L');
		$this->fpdf->Cell(0,5,$heading.' Number:	'.$number, 0, 1, 'L');
		$this->fpdf->Cell(100,5,'Patient Number:	'.$patient_number, 0, 0, 'L');
		$this->fpdf->Cell(0,5,'Att. Doctor:	'.$doctor, 0, 1, 'L');
		$this->fpdf->Cell(0,5,$heading.' Date:	'.$visit_date, 'B', 1, 'L');
		$this->fpdf->Ln(3);
		
		$this->fpdf->SetTextColor(0, 0, 0); //226, 225, 225
		$this->fpdf->SetDrawColor(0, 0, 0); //226, 225, 225
		$item_invoiced_rs = $this->accounts_model->get_patient_visit_charge_items($visit_id);
		$total = 0;
		$pageH = 6;
		$width = 22.5;
		
		$this->fpdf->Cell(0, 5, 'BILLED ITEMS', 'B', 1, 'C');
				
		$this->fpdf->SetFont('Times','B',11);
		$this->fpdf->Cell(10,$pageH,'#','B');
		$this->fpdf->Cell($width,$pageH,'Service','B',0,'C');
		$this->fpdf->Cell($width*3,$pageH,'Item Name','B',0);
		$this->fpdf->Cell($width,$pageH,'Units','B',0);
		$this->fpdf->Cell($width*2,$pageH,'Charge (KSH)','B',0);
		$this->fpdf->Cell($width,$pageH,'Total (KSH)','B',1);
		$this->fpdf->SetFont('Times','',10);
		$this->fpdf->Ln(2);
		
		if(count($item_invoiced_rs) > 0)
		{
			$s=0;
			
			foreach ($item_invoiced_rs as $key_items):
				$s++;
				$service_charge_name = $key_items->service_charge_name;
				$visit_charge_amount = $key_items->visit_charge_amount;
				$units = $key_items->visit_charge_units;
				$service_name = $key_items->service_name;
				$total_item = $visit_charge_amount * $units;
				
				$this->fpdf->Cell(10,$pageH,$s,0);
				$this->fpdf->Cell($width,$pageH,$service_name,0,0,'L');
				$this->fpdf->Cell($width*3,$pageH,$service_charge_name,0,0,'L');
				$this->fpdf->Cell($width,$pageH,$units,0,0,'L');
				$this->fpdf->Cell($width*2,$pageH,number_format($visit_charge_amount, 2),0,0,'L');
				$this->fpdf->Cell($width,$pageH,number_format($total_item, 2),0,1,'L');
				
				$total = $total + $total_item;
			endforeach;
				
			$this->fpdf->SetFont('Times','B',10);
			$this->fpdf->Cell(10,$pageH,'','B');
			$this->fpdf->Cell($width,$pageH,'','B',0,'C');
			$this->fpdf->Cell($width*3,$pageH,'','B',0);
			$this->fpdf->Cell($width,$pageH,'','B',0);
			$this->fpdf->Cell($width*2,$pageH,'','B',0);
			$this->fpdf->Cell($width,$pageH,number_format($total, 2),'B',1);
		}
		else
		{
			$this->fpdf->SetFont('Times','B',10);
			$this->fpdf->Cell(10,$pageH,'','B');
			$this->fpdf->Cell($width,$pageH,'','B',0,'C');
			$this->fpdf->Cell($width,$pageH,'No Charges','B',0);
			$this->fpdf->Cell($width,$pageH,number_format($total, 2),'B',1);
		}
		
		if($invoice == NULL)
		{
			$width = 60;
			
			$payments_rs = $this->accounts_model->payments($visit_id);
			$total_payments = 0;
			
			if(count($payments_rs) > 0)
			{
				$x=0;
				
				foreach ($payments_rs as $key_items):
					$x++;
					$payment_method = $key_items->payment_method;
					$amount_paid = $key_items->amount_paid;
					
					$total_payments = $total_payments + $amount_paid;
				endforeach;
			}
					
			$this->fpdf->SetFont('Times','B',10);
			$this->fpdf->Cell(170,$pageH,'Total Paid','B');
			$this->fpdf->Cell('20',$pageH,number_format($total_payments, 2),'B',1);
			$this->fpdf->Cell(170,$pageH,'Balance','B');
			$this->fpdf->Cell('20',$pageH,number_format(($total - $total_payments), 2),'B',1);
		}
		
		/*$this->fpdf->SetFont('Times','B',10);
		$this->fpdf->Cell(10,$pageH,'','B');
		$this->fpdf->Cell($width,$pageH,'BALANCE','B',0,'C');
		$this->fpdf->Cell($width,$pageH,'No Payments Made','B',0);
		$this->fpdf->Cell($width,$pageH,$total_payments - $total,'B',1);*/
		
		$this->fpdf->Cell(25,$pageH,'Served by: '.$personnel_surname.' '.$personnel_fname.'','0',0,'L');
		$this->fpdf->Cell(50,$pageH,'','B');
		$this->fpdf->Cell(25,$pageH,'Approved By:','0',0, 'L');
		$this->fpdf->Cell(50,$pageH,'','B');

		$this->fpdf->Output();
	}
	
	public function get_att_doctor($visit_id)
	{
		$this->db->select('personnel.personnel_fname, personnel.personnel_onames');
		$this->db->from('personnel, visit');
		$this->db->where('personnel.personnel_id = visit.personnel_id AND visit.visit_id = '.$visit_id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$doctor = $row->personnel_onames.' '.$row->personnel_fname;
		}
		
		else
		{
			$doctor = '-';
		}
		
		return $doctor;
	}
	
	public function get_personnel($personnel_id)
	{
		$this->db->select('personnel.personnel_fname, personnel.personnel_onames');
		$this->db->from('personnel');
		$this->db->where('personnel.personnel_id = '.$personnel_id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$personnel = $row->personnel_onames.' '.$row->personnel_fname;
		}
		
		else
		{
			$personnel = '-';
		}
		
		return $personnel;
	}
	
	public function get_visit_date($visit_id)
	{
		$this->db->select('visit_date');
		$this->db->from('visit');
		$this->db->where('visit_id = '.$visit_id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$row = $query->row();
			$visit_date = $row->visit_date;
		}
		
		else
		{
			$visit_date = '-';
		}
		
		return $visit_date;
	}
	
	public function end_visit($visit_id)
	{
		$data = array(
        	"close_card" => 1
    	);
		
		$this->db->where('visit_id', $visit_id);
		
		if($this->db->update('visit', $data))
		{
			return TRUE;
		}
		
		else
		{
			return FALSE;
		}
	}
	
	public function get_billing_methods()
	{
		$this->db->order_by('bill_to_name');
		$query = $this->db->get('bill_to');
		
		return $query;
	}
	
	public function get_bill_to($visit_id)
	{
		$this->db->where('visit_id', $visit_id);
		$query = $this->db->get('visit');
		$row = $query->row();
		return $row->bill_to_id;
	}
}