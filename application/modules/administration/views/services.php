<?php echo $this->load->view('search/service_search', '', TRUE);?>
 <div class="row">
	<div class="col-md-12">
		<div class="pull-right">
		 <a href="<?php echo site_url()?>/administration/new_service" class="btn btn-sm btn-success">Add a New Service </a>

		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $title;?> </h4>
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
		$search = $this->session->userdata('service_search');
		
		if(!empty($search))
		{
			echo '<a href="'.site_url().'/administration/close_service_search" class="btn btn-warning">Close Search</a>';
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
						  <th>Service Name</th>
						  <th colspan="4">Actions</th>
						</tr>
					  </thead>
					  <tbody>
				';
			
			foreach ($query->result() as $row)
			{
				
				$service_id = $row->service_id;
				$service_name = $row->service_name;
				$service_status = $row->service_status;
				
				//create deactivated status display
				if($service_status == 0)
				{
					$status = '<span class="label label-important">Deactivated</span>';
					$button = '<a href="'.site_url().'/administration/activate_service/'.$service_id.'" class="btn btn-sm btn-info" onclick="return confirm(\'Do you want to activate '.$service_name.'?\');">Activate</a>';
				}
				//create activated status display
				else if($service_status == 1)
				{
					$status = '<span class="label label-success">Active</span>';
					$button = '<a class="btn btn-danger" href="'.site_url().'/administration/deactivate_service/'.$service_id.'" onclick="return confirm(\'Do you want to deactivate '.$service_name.'?\');">Deactivate</a>';
				}
				$count++;
				$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$service_name.'</td>
							<td><a href="'.site_url().'/administration/service_charges/'.$service_id.'" class="btn btn-sm btn-success">Service Charges</a></td>
							<td>'.$status.'</td>
							<td><a href="'.site_url().'/administration/edit_service/'.$service_id.'" class="btn btn-sm btn-warning"> Edit </a></td>
							
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