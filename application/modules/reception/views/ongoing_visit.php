                   
<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>Ongoing Visit</h4>
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
		
		$result = '<a href="'.site_url().'/reception/add-patient" class="btn btn-success pull-right">Add Patient</a>';
		
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
					  <th>Visit Type</th>
					  <th>Time In</th>
					  <th>Time Out</th>
					  <th>Doctor</th>
					  <th>Actions</th>
					</tr>
				  </thead>
				  <tbody>
			';
			
			$personnel_query = $this->personnel_model->get_all_personnel();
			
			foreach ($query->result() as $row)
			{
			


				$visit_time_out = $row->visit_time_out;
				$visit_time = $row->visit_time;
				
				$count++;
				$result .= 
				'
					<tr>
						<td>'.$count.'</td>
						<td>'.$visit_time_out.'</td>
						<td>'.$visit_time_out.'</td>
						<td>'.$visit_time_out.'</td>
						<td>'.$visit_time_out.'</td>
						<td>'.$visit_time_out.'</td>
						<td>'.$visit_time_out.'</td>
						<td><a href="'.site_url().'delete-brand/1" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you really want to delete ?\');">End Visit</a></td>
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