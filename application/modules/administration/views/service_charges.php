<!-- search -->
<?php echo $this->load->view('search/service_charge_search', '', TRUE);?>
<!-- end search -->
<div class="row">
	<div class="col-md-12">
		<div class="pull-right">
		 <a href="<?php echo site_url()?>/administration/services" class="btn btn-sm btn-primary"> Back to services </a>
		 <a href="<?php echo site_url()?>/administration/add_service_charge/<?php echo $service_id;?>" class="btn btn-sm btn-success"> Add service Charge </a>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?> for <?php echo $service_name;?></h4>
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
		$search = $this->session->userdata('service_charge_search');
		
		if(!empty($search))
		{
			echo '<a href="'.site_url().'/administration/close_service_charge_search/'.$service_id.'" class="btn btn-warning">Close Search</a>';
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
						  <th>Visit Type</th>
						  <th>Service Charge Name</th>
						  <th>Service Charge Amount</th>
						  <th colspan="3">Actions</th>
						</tr>
					  </thead>
					  <tbody>
				';
			
			foreach ($query->result() as $row)
			{
				
				$service_charge_id = $row->service_charge_id;
				$service_charge_name = $row->service_charge_name;
				$visit_type_name = $row->visit_type_name;
				$service_charge_amount = $row->service_charge_amount;
				$service_charge_status = $row->service_charge_status;
				
				//create deactivated status display
				if($service_charge_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a href="'.site_url().'/administration/activate_service_charge/'.$service_id.'/'.$service_charge_id.'" class="btn btn-sm btn-info" onclick="return confirm(\'Do you want to activate '.$service_charge_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($service_charge_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-danger" href="'.site_url().'/administration/deactivate_service_charge/'.$service_id.'/'.$service_charge_id.'" onclick="return confirm(\'Do you want to deactivate '.$service_charge_name.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$visit_type_name.'</td>
							<td>'.$service_charge_name.'</td>
							<td>'.$service_charge_amount.'</td>
							<td>'.$status.'</td>
							<td><a href="'.site_url().'/administration/edit_service_charge/'.$service_id.'/'.$service_charge_id.'" class="btn btn-sm btn-info"> Edit </a></td>
							<td>'.$button.'</td>
						</tr> 
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