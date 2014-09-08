<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $patient;?> Patient Card</h4>
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
                <li class="active"><a href="#vitals-pane" data-toggle="tab">Vitals</a></li>
                <li ><a href="#dental-vitals" data-toggle="tab">Dental Vitals</a></li>
                <li><a href="#lifestyle" data-toggle="tab">Lifestyle</a></li>
                <li><a href="#patient-history" data-toggle="tab">Patient history</a></li>
                <li><a href="#soap" data-toggle="tab">SOAP</a></li>
                <li><a href="#medical-checkup" data-toggle="tab">Medical Checkup</a></li>
              </ul>
              <div class="tab-content" style="padding-bottom: 9px; border-bottom: 1px solid #ddd;">
                <div class="tab-pane active" id="vitals-pane">
                  <?php echo $this->load->view("patients/vitals", '', TRUE);?>
                </div>
                
                <div class="tab-pane" id="dental-vitals">
                  <?php echo $this->load->view("patients/dental_vitals", '', TRUE);?>
                 
                </div>
                
                <div class="tab-pane" id="life_style">
                	<?php echo $this->load->view("patients/lifestyle", '', TRUE); ?>
                </div>
                
                <div class="tab-pane" id="patient-history">
                  
                  <?php echo $this->load->view("patients/patient_history", '', TRUE);?>
                  
                </div>

                 <div class="tab-pane" id="soap">
                  
                  <?php echo $this->load->view("patients/soap", '', TRUE);?>
                  
                </div>

                 <div class="tab-pane" id="medical-checkup">
                  
                  <?php echo $this->load->view("patients/medical_checkup", '', TRUE);?>
                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <!-- Widget ends -->

      </div>
    </div>
  </div>