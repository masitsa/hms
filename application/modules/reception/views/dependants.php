<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>All Dependants</h4>
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
                if($dependants_query->num_rows() > 0)
				{
					echo '
          		<table class="table table-hover table-bordered ">
				  <thead>
					<tr>
					  <th>#</th>
					  <th>Patient Type</th>
					  <th>Surname</th>
					  <th>Other Names</th>
					  <th>Date Created</th>
					  <th>Last Visit</th>
					  <th colspan="5">Actions</th>
					</tr>
				  </thead>
				  <tbody>';
				  
					$dependants = $dependants_query->result();
					
					foreach($dependants as $dep)
					{
						$patient_surname = $dep->Surname;
						$patient_othernames = $dep->Other_names;
						
						echo 
						'
						<tr>
							<td>'.$patient_surname.'</td>
							<td>'.$patient_othernames.'</td>
						</tr>
						';
					}
					
					echo '
                </tbody>
                </table>';
				}
				
				else
				{
					echo 'This patient has no dependants';
				}
                ?>
          </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>Add Dependant</h4>
          <div class="widget-icons pull-right">
            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
            <a href="#" class="wclose"><i class="icon-remove"></i></a>
          </div>
          <div class="clearfix"></div>
        </div>             

        <!-- Widget content -->
        <div class="widget-content">
          <div class="padd">
          <div class="center-align">
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
                echo $this->load->view("patients/dependants", '', TRUE);
                ?>
          </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>

