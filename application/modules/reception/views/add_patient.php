<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>Add Patient</h4>
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
          </div>
			<div class="tabbable" style="margin-bottom: 18px;">
              <ul class="nav nav-tabs">
                <li><a href="#staff" data-toggle="tab">Staff</a></li>
                <li class="active"><a href="#student" data-toggle="tab">Student</a></li>
                <li><a href="#dependant" data-toggle="tab">Dependant</a></li>
                <li><a href="#other" data-toggle="tab">Other</a></li>
              </ul>
              <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
                <div class="tab-pane" id="staff">
                  <p class="center-align">Enter a staff's number to search for them</p>
                  <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url().'reception/search_staff'?>">
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Staff Number</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" name="staff_number" placeholder="">
                      </div>
                      <div class="col-lg-2">
                      	<button class="btn btn-info btn-lg" type="submit">Search</button>
                      </div>
                    </div>
                  </form>
                </div>
                
                <div class="tab-pane active" id="student">
                  <p class="center-align">Enter a student's number to search for them</p>
                  <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url().'reception/search_student'?>">
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Student Number</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" name="student_number" placeholder="">
                      </div>
                      <div class="col-lg-2">
                      	<button class="btn btn-info btn-lg" type="submit">Search</button>
                      </div>
                    </div>
                  </form>
                </div>
                
                <div class="tab-pane" id="dependant">
                  <p class="center-align">Enter the details of a staff member's dependant</p>
                  <form class="form-horizontal" role="form" method="POST">
                    <div class="form-group">
                      <label class="col-lg-2 control-label">Student Number</label>
                      <div class="col-lg-8">
                        <input type="text" class="form-control" name="student_number" placeholder="">
                      </div>
                      <div class="col-lg-2">
                      	<button class="btn btn-info btn-lg" type="button">Search</button>
                      </div>
                    </div>
                  </form>
                </div>
                
                <div class="tab-pane" id="other">
                  
                  <?php echo $this->load->view("patients/other");?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>