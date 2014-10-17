<!-- search -->
<?php //echo $this->load->view('patients/search_visit', '', TRUE);?>
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
		$search = $this->session->userdata('visit_search');
		
		if(!empty($search))
		{
			echo '<a href="'.site_url().'/nurse/close_queue_search" class="btn btn-warning">Close Search</a>';
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
						  <th>Class</th>
						  <th>Test</th>
						  <th>Units</th>
						  <th>Price</th>
						  <th>Male Lower Limit</th>
						  <th>Male Upper Limit</th>
						  <th>Female Lower Limit</th>
						  <th>Female Upper Limit</th>
						  <th colspan="4">Actions</th>
						</tr>
					  </thead>
					  <tbody>
				';
			$count = 0;
			
			foreach ($query->result() as $row)
			{
				
				$lab_test_class_id = $row->lab_test_class_id;
				$lab_test_class = $row->lab_test_class_name;
				$lab_test_name = $row->lab_test_name;
				$lab_test_units = $row->lab_test_units;
				$lab_test_price = $row->lab_test_price;
				$lab_test_malelowerlimit = $row->lab_test_malelowerlimit;
				$lab_test_malelupperlimit = $row->lab_test_malelupperlimit;
				$lab_test_femalelowerlimit = $row->lab_test_femalelowerlimit;
				$lab_test_femaleupperlimit = $row->lab_test_femaleupperlimit;
				$count++;
				
				
				$result .= 
					'
						<tr>
							<td>'.$count.'</td>
							<td>'.$lab_test_class.'</td>
							<td>'.$lab_test_name.'</td>
							<td>'.$lab_test_units.'</td>
							<td>'.$lab_test_price.'</td>
							<td>'.$lab_test_malelowerlimit.'</td>
							<td>'.$lab_test_malelupperlimit.'</td>
							<td>'.$lab_test_femalelowerlimit.'</td>
							<td>'.$lab_test_femaleupperlimit.'</td>
							<td><a href="'.site_url().'/laboratory/test/'.$lab_test_class_id.'" class="btn btn-sm btn-info">Formats</a></td>
							<td><a href="'.site_url().'/laboratory/test_history/'.$lab_test_class_id.'" class="btn btn-sm btn-danger">Edit</a></td>
							<td><a href="'.site_url().'/laboratory/test_history/'.$lab_test_class_id.'" class="btn btn-sm btn-danger">Delete</a></td>
							
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