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
