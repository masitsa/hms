<?php 
	$visit_trail = $this->reception_model->get_visit_trail($visit_id);
	
	if($visit_trail->num_rows() > 0)
	{
		$trail = 
		'
			<table class="table table-responsive table-condensed table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Department</th>
						<th>Sent At</th>
						<th>Sent By</th>
						<th>Released At</th>
						<th>Released By</th>
					</tr>
				</thead>
		';
		$count = 0;
		foreach($visit_trail->result() as $res)
		{
			$count++;
			$department_name = $res->departments_name;
			$created = date('H:i a',strtotime($res->created));
			$created_by = $res->personnel_fname;
			$status = $res->visit_department_status;
			
			if($status == 0)
			{
				$last_modified = date('H:i a',strtotime($res->last_modified));
				$modified_by = $res->modified_by;
			}
			
			else
			{
				$last_modified = '-';
				$modified_by = '-';
			}
			$personnel_query = $this->personnel_model->get_all_personnel();
			if($personnel_query->num_rows() > 0)
			{
				$personnel_result = $personnel_query->result();
				
				foreach($personnel_result as $adm)
				{
					$personnel_id = $adm->personnel_id;
					
					if($personnel_id == $modified_by)
					{
						$modified_by = $adm->personnel_fname;
					}
				}
			}
			
			else
			{
				$modified_by = '-';
			}
			
			$trail .=
			'
				<tr>
					<td>'.$count.'</td>
					<td>'.$department_name.'</td>
					<td>'.$created.'</td>
					<td>'.$created_by.'</td>
					<td>'.$last_modified.'</td>
					<td>'.$modified_by.'</td>
				</tr>
			';
		}
		
		$trail .= '</table>';
	}
	
	else
	{
		$trail = 'Trail not found';
	}
?>
<div class="row">
	<div class="col-md-12">
		<!-- Widget -->
		<div class="widget">
			<!-- Widget head -->
			<div class="widget-head">
				<h4 class="pull-left"><i class="icon-reorder"></i>Visit Trail</h4>
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
					<a href="#" class="wclose"><i class="icon-remove"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>             
			
			<!-- Widget content -->
			<div class="widget-content">
				<div class="padd">
					<?php echo $trail;?>
					
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<!-- Widget -->
		<div class="widget">
			<!-- Widget head -->
			<div class="widget-head">
				<h4 class="pull-left"><i class="icon-reorder"></i>Visit Charges</h4>
				<div class="widget-icons pull-right">
					<a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
					<a href="#" class="wclose"><i class="icon-remove"></i></a>
				</div>
				<div class="clearfix"></div>
			</div>             
			
			<!-- Widget content -->
			<div class="widget-content">
				<div class="padd">

				<table class="table table-hover table-bordered col-md-12">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Item Name</th>
                        <th>Time Charged</th>
                        <th>Charge</th>
                        <?php
                        if($page_name == 'administration')
                        {
                        	echo "<th></th>";
                        }
                        else
                        {

                        }
                        ?>
                        
                      </tr>
                      </thead>
                      <tbody>

                        <?php
                        $item_invoiced_rs = $this->accounts_model->get_patient_visit_charge_items($visit_id);
                        $total = 0;
                        if(count($item_invoiced_rs) > 0){
                          $s=0;
                          
                          foreach ($item_invoiced_rs as $key_items):
                            $s++;
                            $service_charge_name = $key_items->service_charge_name;
                            $visit_charge_amount = $key_items->visit_charge_amount;
                            $service_name = $key_items->service_name;
                            $service_id = $key_items->service_id;
                             $units = $key_items->visit_charge_units;
                              $service_charge_idd = $key_items->service_charge_id;
                             $visit_charge_timestamp = $key_items->visit_charge_timestamp;
                              $visit_charge_id = $key_items->visit_charge_id;
                             $visit_total = $visit_charge_amount * $units;
                             $item_rs = $this->reception_model->get_service_charges_per_type($patient_type);
                            ?>
                              <tr>
                                <td><?php echo $s;?></td>
                                <td><?php echo $service_name;?></td>
                                <td> 
                                <?php 
                                	if($page_name == 'administration' && $service_id == 1)
                                	{
                                		?>
                                		<select name="consultation_id" id="consultation_id<?php echo $visit_id;?>"   class="form-control">
						                    <?php
												if(count($item_rs) > 0){
						                    		foreach($item_rs as $row):
														$service_charge_id = $row->service_charge_id;
														$service_charge_name= $row->service_charge_name;
														
														if($service_charge_id == $service_charge_idd)
														{
															echo "<option value='".$service_charge_id."' selected='selected'>".$service_charge_id."".$service_charge_name."</option>";
														}
														
														else
														{
															echo "<option value='".$service_charge_id."'>".$service_charge_name."</option>";
														}
													endforeach;
												}
											?>
						                    </select>
                                		<?php
                                	}
                                	else
                                	{
                                		echo $service_charge_name;
                                	}
                                	?>
                                	

                                </td>
                                <td><?php echo $visit_charge_timestamp;?></td>
                               	<td><?php echo number_format($visit_total,2);?></td>
                               	<?php
			                        if(($page_name == 'administration') && $service_id != 1)
			                        {
			                        	echo '<td><a href="'.site_url().'/administration/delete_visit_charge/'.$visit_id.'/'.$service_charge_idd.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you want to delete this service charge ?\');">Delete Service Charge</a></td>';
			                        }
			                        else if(($page_name == 'administration') && $service_id == 1)
			                        {
			                        	echo '<td><a onclick="update_service_charge('.$visit_charge_id.','.$visit_id.')" class="btn btn-sm btn-success">Update Consultation</a></td>';

			                        }
			                        else
			                        {}


                               		
                                ?>

                              </tr>
                            <?php
                              $total = $total + $visit_total;
                          endforeach;
                           $payments_rs = $this->accounts_model->payments($visit_id);
                           $total_payments = 0;
                            if(count($payments_rs) > 0){
                              $r=0;
                              
                              foreach ($payments_rs as $key_items):
                                $r++;
                                $payment_method = $key_items->payment_method;
                                $amount_paid = $key_items->amount_paid;
                                $time = $key_items->time;
                               
                                $total_payments = $total_payments + $amount_paid;

                              endforeach;
                          	}
                            ?>
                            <tr>
                             <td colspan="3"></td>
                              <td><span>Total Invoice :</span></td>
                              <td> <?php echo number_format($total,2);?></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Total Amount Paid :</td>
                              <td> <?php echo number_format($total_payments,2);?></td>
                            </tr>
                            <tr>
                              <td colspan="3"></td>
                              <td>Balance :</td>
                              <td> <?php echo number_format(($total - $total_payments),2);?></td>
                            </tr>
                            <?php
                        }else{
                           ?>
                            <tr>
                              <td colspan="4"> No Charges</td>
                            </tr>
                            <?php
                        }

                        ?>
                        
                      </tbody>
                    </table>
	              
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	

	function update_service_charge(visit_charge_id,visit_id){
         
        var config_url = $('#config_url').val();
        var data_url = config_url+"/administration/update_visit_charge/"+visit_charge_id;
        
        var consultation_id = $('#consultation_id'+visit_id).val();
        
        $.ajax({
        type:'POST',
        url: data_url,
        data:{consultation: consultation_id},
        dataType: 'text',
        success:function(data){
       	window.alert("You have successfully updated the charge");
        //obj.innerHTML = XMLHttpRequestObject.responseText;
        },
        error: function(xhr, status, error) {
        //alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
        alert(error);
        }

        });
        
    }
</script>