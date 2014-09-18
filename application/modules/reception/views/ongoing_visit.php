<!-- search -->
<?php echo $this->load->view('patients/search_visit', '', TRUE);?>
<!-- end search -->
 
<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?></h4>
          <div class="widget-icons pull-right">
            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
            <a href="#" class="wclose"><i class="icon-remove"></i></a>
          </div>
          <div class="clearfix"></div>
        </div>             

        <!-- Widget content -->
        <div class="widget-content">
          <div class="padd">
          <?php
            	$error = $this->session->userdata('error_message');
            	$validation_error = validation_errors();
				$success = $this->session->userdata('success_message');
				
				if(!empty($error))
				{
					echo '<div class="alert alert-danger">'.$error.'</div>';
					$this->session->unset_userdata('error_message');
				}
				
				if(!empty($validation_error))
				{
					echo '<div class="alert alert-danger">'.$validation_error.'</div>';
				}
				
				if(!empty($success))
				{
					echo '<div class="alert alert-success">'.$success.'</div>';
					$this->session->unset_userdata('success_message');
				}
			?>
<?php
		$search = $this->session->userdata('visit_search');
		
		if(!empty($search))
		{
			echo '<a href="'.site_url().'/reception/close_visit_search/'.$visit.'/'.$page_name.'" class="btn btn-warning">Close Search</a>';
		}
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			//deleted patients
			if($delete == 1)
			{
				$result .= 
				'
					<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Visit Date</th>
						  <th>Patient</th>
						  <th>Patient Type</th>
						  <th>Visit Type</th>
						  <th>Time In</th>
						  <th>Doctor</th>
						  <th>Date Deleted</th>
						  <th>Deleted By</th>
						</tr>
					  </thead>
					  <tbody>
				';
			}
			
			else
			{
				if(($visit == 0) || ($visit == 3))
				{
					$result .= 
					'
						<table class="table table-hover table-bordered ">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Visit Date</th>
							  <th>Patient</th>
							  <th>Patient Type</th>
							  <th>Visit Type</th>
							  <th>Time In</th>
							  <th>Doctor</th>
							  <th colspan="5">Actions</th>
							</tr>
						  </thead>
						  <tbody>
					';
				}
				
				else
				{
					$result .= 
					'
						<table class="table table-hover table-bordered ">
						  <thead>
							<tr>
							  <th>#</th>
							  <th>Visit Date</th>
							  <th>Patient</th>
							  <th>Patient Type</th>
							  <th>Visit Type</th>
							  <th>Time In</th>
							  <th>Time Out</th>
							  <th>Doctor</th>
							  <th>Actions</th>
							</tr>
						  </thead>
						  <tbody>
					';
				}
			}
			
			$personnel_query = $this->personnel_model->get_all_personnel();
			
			foreach ($query->result() as $row)
			{
				$visit_date = date('jS M Y',strtotime($row->visit_date));
				$visit_time = date('H:i a',strtotime($row->visit_time));
				if($row->visit_time_out != '0000-00-00 00:00:00')
				{
					$visit_time_out = date('H:i a',strtotime($row->visit_time_out));
				}
				else
				{
					$visit_time_out = '-';
				}
				$visit_id = $row->visit_id;
				$patient_id = $row->patient_id;
				$personnel_id = $row->personnel_id;
				$dependant_id = $row->dependant_id;
				$strath_no = $row->strath_no;
				$visit_type_id = $row->visit_type_id;
				$visit_type = $row->visit_type;
				$visit_table_visit_type = $visit_type;
				$patient_table_visit_type = $visit_type_id;
				$patient_national_id = $row->patient_national_id;
				
				//staff & dependant
				if($visit_type == 2 && empty($patient_national_id))
				{
					//dependant
					if($dependant_id > 0)
					{
						$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
						$visit_type = 'Dependant';
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
						$patient_type = $this->reception_model->get_patient_type($visit_type_id, $dependant_id);
						$staff_query = $this->reception_model->get_staff($strath_no);
						$visit_type = 'Staff';
						
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
				}else if($visit_type == 2 && !empty($patient_national_id))
				{
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
					$visit_type = 'staff';
					
				}
				
				//student
				else if($visit_type == 1)
				{
					$student_query = $this->reception_model->get_student($strath_no);
					$patient_type = $this->reception_model->get_patient_type($visit_type_id);
					$visit_type = 'Student';
					
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
					$patient_type = $this->reception_model->get_patient_type($visit_type_id);
					
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
					
					$patient_othernames = $row->patient_othernames;
					$patient_surname = $row->patient_surname;
				}
				
				//creators and editors
				if($personnel_query->num_rows() > 0)
				{
					$personnel_result = $personnel_query->result();
					
					foreach($personnel_result as $adm)
					{
						$personnel_id2 = $adm->personnel_id;
						
						if($personnel_id == $personnel_id2)
						{
							$doctor = $adm->personnel_fname;
							break;
						}
						
						else
						{
							$doctor = '-';
						}
					}
				}
				
				else
				{
					$doctor = '-';
				}
				
				$count++;
				
				if($delete == 0)
				{
					if(($visit == 0) || ($visit == 3))
					{
						if($page_name == 'doctor')
						{
							$button = '
							<td><a href="'.site_url().'/nurse/patient_card/'.$visit_id.'/a/1" class="btn btn-sm btn-info">Patient Card</a></td>
							<td><a href="'.site_url().'/nurse/dental_visit/'.$visit_id.'/a/1" class="btn btn-sm btn-danger">Dental Vitals</a></td>
							<td><a href="'.site_url().'/nurse/send_to_labs/'.$visit_id.'" class="btn btn-sm btn-success" onclick="return confirm(\'Send to lab?\');">To Lab</a></td>
							<td><a href="'.site_url().'/nurse/send_to_pharmacy/'.$visit_id.'" class="btn btn-sm btn-primary" onclick="return confirm(\'Send to pharmacy?\');">To Pharmacy</a></td>
							';
						}
						
						else if($page_name == 'nurse')
						{
							$button = '
							<td><a href="'.site_url().'/nurse/patient_card/'.$visit_id.'/a/0" class="btn btn-sm btn-info">Patient Card</a></td>
							<td><a href="'.site_url().'/nurse/dental_visit/'.$visit_id.'/a/0" class="btn btn-sm btn-danger">Dental Vitals</a></td>

							<td><a href="'.site_url().'/nurse/send_to_doctor/'.$visit_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Send to doctor?\');">To Doctor</a></td>
							<td><a href="'.site_url().'/nurse/send_to_labs/'.$visit_id.'" class="btn btn-sm btn-success" onclick="return confirm(\'Send to lab?\');">To Lab</a></td>
							<td><a href="'.site_url().'/nurse/send_to_pharmacy/'.$visit_id.'" class="btn btn-sm btn-primary" onclick="return confirm(\'Send to pharmacy?\');">To Pharmacy</a></td>
							';
						}
						
						else
						{
							$button = '<td><a href="'.site_url().'/reception/end_visit/'.$visit_id.'/'.$visit.'" class="btn btn-sm btn-info" onclick="return confirm(\'Do you really want to end this visit ?\');">End Visit</a></td>
								<td><a href="'.site_url().'/reception/delete_visit/'.$visit_id.'/'.$visit.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this visit?\');">Delete</a></td>';
								
							//if staff was registered as other
							if(($visit_table_visit_type == 2) && ($patient_table_visit_type != $visit_table_visit_type))
							{
								$button .= '<td><a href="'.site_url().'/reception/change_patient_type/'.$patient_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Do you really want to change this patient type?\');">Change Patient Type</a></td>';
							}
							//if student was registered as other
							else if(($visit_table_visit_type == 1) && ($patient_table_visit_type != $visit_table_visit_type))
							{
								$button .= '<td><a href="'.site_url().'/reception/change_patient_type/'.$patient_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Do you really want to change this patient type?\');">Change Patient Type</a></td>';
							}
							
							else
							{
								$button .= '<td></td>';
							}
						}
						
						$result .= 
						'
							<tr>
								<td>'.$count.'</td>
								<td>'.$visit_date.'</td>
								<td>'.$patient_surname.' '.$patient_othernames.'</td>
								<td>'.$patient_type.'</td>
								<td>'.$visit_type.'</td>
								<td>'.$visit_time.'</td>
								<td>'.$doctor.'</td>
								'.$button.'
							</tr> 
						';
					}
					
					else
					{
						$result .= 
						'
							<tr>
								<td>'.$count.'</td>
								<td>'.$visit_date.'</td>
								<td>'.$patient_surname.' '.$patient_othernames.'</td>
								<td>'.$patient_type.'</td>
								<td>'.$visit_type.'</td>
								<td>'.$visit_time.'</td>
								<td>'.$visit_time_out.'</td>
								<td>'.$doctor.'</td>
								<td><a href="'.site_url().'/reception/delete_visit/'.$visit_id.'/'.$visit.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete this visit?\');">Delete</a></td>
							</tr> 
						';
					}
				}
				
				else
				{
					//deleted by
					$deleted_by = $row->deleted_by;
					
					if($personnel_query->num_rows() > 0)
					{
						$personnel_result = $personnel_query->result();
						
						foreach($personnel_result as $adm)
						{	
							$personnel_id2 = $adm->personnel_id;
							if($deleted_by == $personnel_id2)
							{
								$deleted_by = $adm->personnel_fname;
								break;
							}
						}
					}
					
					$deleted = $row->date_deleted;
					
					$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$visit_date.'</td>
							<td>'.$patient_surname.' '.$patient_othernames.'</td>
							<td>'.$patient_type.'</td>
							<td>'.$visit_type.'</td>
							<td>'.$visit_time.'</td>
							<td>'.$doctor.'</td>
							<td>'.date('jS M Y H:i a',strtotime($deleted)).'</td>
							<td>'.$deleted_by.'</td>
						</tr> 
					';
				}
			}
			
			$result .= 
			'
						  </tbody>
						</table>
			';
		}
		
		else
		{
			$result .= "There are no patients";
		}
		
		echo $result;
?>
          </div>
          
          <div class="widget-foot">
                                
				<?php if(isset($links)){echo $links;}?>
            
                <div class="clearfix"></div> 
            
            </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>