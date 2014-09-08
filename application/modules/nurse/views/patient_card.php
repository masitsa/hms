<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>Patient Card</h4>
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
                <li class="active"><a href="#vitals" data-toggle="tab">Vitals</a></li>
                <li ><a href="#dental-vitals" data-toggle="tab">Dental Vitals</a></li>
                <li><a href="#lifestyle" data-toggle="tab">Lifestyle</a></li>
                <li><a href="#patient-history" data-toggle="tab">Patient history</a></li>
              </ul>
              <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
                <div class="tab-pane" id="vitals">
                  <p class="center-align">Enter a staff's number to search for them</p>
                  <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url().'/reception/search_staff'?>">
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
                
                <div class="tab-pane active" id="dental-vitals">
                  <p class="center-align">Enter a student's number to search for them</p>
                  <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url().'/reception/search_student'?>">
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
                
                <div class="tab-pane" id="life_style">
                	<?php
                    	if($visit_id != NULL)
						{
							echo $this->load->view("patients/dependants", '', TRUE);
						}
						
						else
						{
					?>
                        <p class="center-align">Enter the staff member's number</p>
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo site_url().'/reception/search_staff'?>">
                        	<input type="hidden" name="dependant" value="1" />
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Staff Number</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="staff_number" placeholder="Staff Number">
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-info btn-lg" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
                
                <div class="tab-pane" id="patient-history">
                  
                  <?php echo $this->load->view("patients/other", '', TRUE);?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>