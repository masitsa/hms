<!-- search -->
<?php echo $this->load->view('search/patient_search', '', TRUE);?>
<!-- end search -->

<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
        	<?php
        	if($type_links == 1){
        		?>
        		 <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?> for <?php echo date('jS M Y',strtotime(date('Y-m-d')));?></h4>

        		<?php
        	}else{
        		?>
        		<h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?> </h4>

        		<?php
        	}
        	?>
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
		$search = $this->session->userdata('visit_accounts_search');
		
		if(!empty($search))
		{
			echo '<a href="'.site_url().'/accounts/close_queue_search/'.$type_links.'" class="btn btn-warning">Close Search</a>';
		}
		$result = '';
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
			$count = $page;
			
			$result .= 
				'
					<table class="table table-hover table-bordered ">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Visit Date</th>
						  <th>Patient</th>
						  <th>Doctor</th>
						  <th>Coming From</th>
						  <th>Invoice</th>
						  <th>Payments</th>
						  <th>Balance</th>';

						  	if($type_links == 3){
						  		$result .=  '<th colspan="2">Actions</th>';
						  	}else{
						  		$result .= '<th colspan="5">Actions</th>';
						  	}
				$result .= 	'</tr>
					  </thead>
					  <tbody>
				';
			
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
				$coming_from = $this->reception_model->coming_from($visit_id);
				
				$patient = $this->reception_model->patient_names2($patient_id, $visit_id);
				$visit_type = $patient['visit_type'];
				$patient_type = $patient['patient_type'];
				$patient_othernames = $patient['patient_othernames'];
				$patient_surname = $patient['patient_surname'];
				$patient_date_of_birth = $patient['patient_date_of_birth'];
				$gender = $patient['gender'];
				
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
				
				if($module != 1)
				{
					$to_doctor = '<td><a href="'.site_url().'/nurse/send_to_doctor/'.$visit_id.'" class="btn btn-sm btn-warning" onclick="return confirm(\'Send to doctor?\');">To Doctor</a></td>';
				}
				
				else
				{
					$to_doctor = '';
				}
				
				$payments_value = $this->accounts_model->payments2($visit_id);

				$invoice_total = $this->accounts_model->total($visit_id);

				$balance = $this->accounts_model->balance($payments_value,$invoice_total);

				$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$visit_date.'</td>
							<td>'.$patient_surname.' '.$patient_othernames.'</td>
							<td>'.$doctor.'</td>
							<td>'.$coming_from.'</td>
							<td>'.$invoice_total.'</td>
							<td>'.$payments_value.'</td>
							<td>'.$balance.'</td>
							
							<td><a href="'.site_url().'/accounts/print_receipt_new/'.$visit_id.'" target="_blank" class="btn btn-sm btn-info">Receipt</a></td>
							<td><a href="'.site_url().'/accounts/print_invoice/'.$visit_id.'" target="_blank" class="btn btn-sm btn-success">Invoice </a></td>';
							if($type_links == 3){

							}else{
							$result .='<td><a href="'.site_url().'/accounts/payments/'.$visit_id.'/'.$close_page.'" class="btn btn-sm btn-primary" >Payments</a></td>
							<td><a href="'.site_url().'/reception/end_visit/'.$visit_id.'/1" class="btn btn-sm btn-danger" onclick="return confirm(\'End this visit?\');">End Visit</a></td>';
							}

						$result .='</tr> 
					';
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