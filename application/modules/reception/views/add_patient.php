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
                <li><a href="#other" data-toggle="tab">Other</a></li>
              </ul>
              <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
                <div class="tab-pane" id="staff">
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
                  
                  	<hr>
                    <h3 class="center-align">Add SBS or Housekeeping Staff</h3>
                  	<?php echo form_open('reception/staff_sbs', array('class' => 'form-horizontal'));?>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Staff Number</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="strath_no" placeholder="Staff Number" value="<?php echo set_value('strath_no');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Surname</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="surname" placeholder="Surname" value="<?php echo set_value('surname');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Other Names</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="other_names" placeholder="Other Names" value="<?php echo set_value('other_names');?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Phone</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo set_value('phone');?>">
                                </div>
                            </div>
                    	</div>
                        
                    	<div class="col-md-6">
                            <!--<div class="form-group">
                                <label class="col-lg-4 control-label">Email</label>
                                <div class="col-lg-8">
                                    <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo set_value('email');?>">
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Date of Birth: </label>
                                
                                <div class="col-lg-8">
                                    <div id="datetimepicker1" class="input-append">
                                        <input data-format="yyyy-MM-dd" class="form-control" type="text" name="date_of_birth" placeholder="Date of Birth" value="<?php echo set_value('date_of_birth');?>">
                                        <span class="add-on">
                                            &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Gender</label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="gender">
                                        <option value="">----Select Gender---</option>
                                        <?php
                                        if(set_value('gender') == 'F')
										{
											$female = 'selected="selected"';
											$male = '';
										}
										
										else if(set_value('gender') == 'M')
										{
											$female = '';
											$male = 'selected="selected"';
										}
										
										else
										{
											$female = '';
											$male = '';
										}
										?>
                                        <option value="F" <?php echo $female;?>> Female </option>
                                        <option value="M" <?php echo $male;?>> Male </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Staff Type</label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="staff_type">
                                        <option value="">----Select Staff Type---</option>
                                        <?php
                                        if(set_value('staff_type') == 'sbs')
										{
											$sbs = 'selected="selected"';
											$housekeeping = '';
										}
										
										else if(set_value('staff_type') == 'housekeeping')
										{
											$sbs = '';
											$housekeeping = 'selected="selected"';
										}
										
										else
										{
											$sbs = '';
											$housekeeping = '';
										}
										?>
                                        <option value="sbs" <?php echo $sbs;?>>SBS</option>
                                        <option value="housekeeping" <?php echo $housekeeping;?>> HOUSEKEEPING </option>
                                    </select>
                                </div>
                            </div>
                    	</div>
                	</div>
                    
                    <div class="center-align">
                    	<button type="submit" class="btn btn-info btn-lg">Add New Staff</button>
                    </div>
                    <?php echo form_close();?>
                </div>
                
                <div class="tab-pane active" id="student">
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
                
               
                
                <div class="tab-pane" id="other">
                  
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