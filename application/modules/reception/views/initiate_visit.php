<style type="text/css">
	#insured_company{display:none;}
</style>
<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
        <!-- Widget head -->
        <div class="widget-head">
          <h4 class="pull-left"><i class="icon-reorder"></i>Initiate Visit for <?php echo $patient;?></h4>
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
				$validation_error = validation_errors();
				
				if(!empty($validation_error))
				{
					echo '<div class="alert alert-danger center-align">'.$validation_error.'</div>';
				}
				?>
				<?php echo form_open("reception/save_visit/".$patient_id, array("class" => "form-horizontal"));?>
				<div class="row">
					<div class="col-md-6">
					 <div class="widget boxed">
				        <!-- Widget head -->
				        <div class="widget-head">
				          <h4 class="pull-left"><i class="icon-reorder"></i>Patient Visit</h4>
				          <div class="widget-icons pull-right">
				            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
				            <a href="#" class="wclose"><i class="icon-remove"></i></a>
				          </div>
				          <div class="clearfix"></div>
				        </div> 
				        <div class="widget-content">
         				  <div class="padd">
					        <div class="form-group">
						            <label class="col-lg-4 control-label">Department: </label>
                                    
						            <div class="col-lg-8">
						     			 <select name="department_id" id="department_id" class="form-control" onchange="check_department_type()">
                                         	<option value="">----Select a Department----</option>
				                        	<?php
									                            	
												if($visit_departments->num_rows() > 0){
				                            		foreach($visit_departments->result() as $row):
														$department_name = $row->departments_name;
														$department_id = $row->department_id;
														
														if($department_id == set_value('department_id'))
														{
															echo "<option value='".$department_id."' selected='selected'>".$department_name."</option>";
														}
														
														else
														{
															echo "<option value='".$department_id."'>".$department_name."</option>";
														}
													endforeach;
												}
											?>
			                            </select>
	                            	</div>
	                            </div>
	                        <!--<div  id="patient_type_div" style="display:none;">
	                        	<div class="form-group">
						            <label class="col-lg-4 control-label">Patient Type: </label>
						            
						            <div class="col-lg-8">
						            	 <select name="patient_type_id" id="patient_type_id"  onChange='insurance_company("patient_type","insured");getCity("<?php echo site_url();?>/reception/load_charges/"+this.value);' class="form-control">
						                    <option value="">--- Select Patient Type---</option>
						                	<?php
												if(count($type) > 0){
						                    		foreach($type as $row):
														$type_name = $row->visit_type_name;
														$type_id= $row->visit_type_id;
														
														if($type_id == set_value('patient_type'))
														{
															echo "<option value='".$type_id."' selected='selected'>".$type_name."</option>";
														}
														
														else
														{
															echo "<option value='".$type_id."'>".$type_name."</option>";
														}
													endforeach;
												}
											?>
						                    </select>
           								 
           							</div>
						        </div>
						        <div class="form-group">
						        	<div id="insured_company">
										<label class="col-lg-4 control-label">Insurance Name: </label>
										
										<div class="col-lg-8">
											<select name="patient_insurance_id" class="form-control">
													<option value="">--- Select Insurance Company---</option>
														<?php

														if(count($patient_insurance) > 0){	
														foreach($patient_insurance as $row):
																$company_name = $row->company_name;
																$insurance_company_name = $row->insurance_company_name;
																$patient_insurance_id = $row->patient_insurance_id;
														echo "<option value=".$patient_insurance_id.">".$company_name." - ".$insurance_company_name."</option>";
														endforeach;	} ?>
										  </select>
										  <br>
										</div>
									</div>
								</div>


	                        </div>-->
				        	<div  id="department_type" style="display:none;">
					        <div class="form-group">
						            <label class="col-lg-4 control-label">Doctor: </label>
                                    
						            <div class="col-lg-8">
						     			 <select name="personnel_id" class="form-control">
                                         	<option value="">----Select a Doctor----</option>
				                        	<?php
									                            	
												if(count($doctor) > 0){
				                            		foreach($doctor as $row):
														$fname = $row->personnel_fname;
														$onames = $row->personnel_onames;
														$personnel_id = $row->personnel_id;
														
														if($personnel_id == set_value('personnel_id'))
														{
															echo "<option value='".$personnel_id."' selected='selected'>".$onames." ".$fname."</option>";
														}
														
														else
														{
															echo "<option value='".$personnel_id."'>".$onames." ".$fname."</option>";
														}
													endforeach;
												}
											?>
			                            </select>
	                            	</div>
	                            </div>
						     	<div class="form-group">
						            <label class="col-lg-4 control-label">Patient Type: </label>
						            
						            <div class="col-lg-8">
						            	 <select name="patient_type" id="patient_type"  onChange='getCity("<?php echo site_url();?>/reception/load_charges/"+this.value);' class="form-control">
						                    <option value="">--- Select Patient Type---</option>
						                	<?php
												if(count($type) > 0){
						                    		foreach($type as $row):
														$type_name = $row->visit_type_name;
														$type_id= $row->visit_type_id;
														
														if($type_id == set_value('patient_type'))
														{
															echo "<option value='".$type_id."' selected='selected'>".$type_name."</option>";
														}
														
														else
														{
															echo "<option value='".$type_id."'>".$type_name."</option>";
														}
													endforeach;
												}
											?>
						                    </select>
           								 
           							</div>
						        </div>
						        <div  id="insured_company">
									<div class="form-group">
										<label class="col-lg-4 control-label">Insurance Company: </label>
										
										<div class="col-lg-8">
											<select name="patient_insurance_id" class="form-control">
													<option value="">--- Select Insurance Company---</option>
														<?php

														if(count($patient_insurance) > 0){	
														foreach($patient_insurance as $row):
																$insurance_company_name = $row->insurance_company_name;
																$patient_insurance_id = $row->insurance_company_id;
															echo "<option value=".$patient_insurance_id.">".$insurance_company_name."</option>";
														endforeach;	} ?>
										  </select>
										  <br>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-4 control-label">Insurance Number: </label>
										
										<div class="col-lg-8">
											<input type="text" name="insurance_id" value="<?php echo set_value('insurance_id')?>" class="form-control"/>
										</div>
									</div>
								</div>
						 	 <div class="form-group">
					            <label class="col-lg-4 control-label">Consultation Type: </label>
					            
					            <div class="col-lg-8">
					            	<div id="citydiv"> 
					            	<div id="checker"  onclick="checks('patient_type');" > 
					            		<select name="service_charge_name" class="form-control">
											<option value='0'>Loading..</option>
								        </select>
								     </div>
                            	</div>
					            </div>
					        </div>
					       </div>
				        </div>

				     </div>
				    </div>
				   </div>
				     <!--end left -->
				     <!-- start right -->
				     <div class="col-md-6">
				     <div class="widget boxed">
				        <!-- Widget head -->
				        <div class="widget-head">
				          <h4 class="pull-left"><i class="icon-reorder"></i>Appointments</h4>
				          <div class="widget-icons pull-right">
				            <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
				            <a href="#" class="wclose"><i class="icon-remove"></i></a>
				          </div>
				          <div class="clearfix"></div>
				        </div> 
				        <div class="widget-content">
         				  <div class="padd">
				     			
				        	<div class="form-group">
				            <label class="col-lg-4 control-label">Visit Date: </label>
				            
				            <div class="col-lg-8">
				            	<div id="datetimepicker1" class="input-append">
				                    <input data-format="yyyy-MM-dd" class="form-control" type="text" id="datepicker" name="visit_date" placeholder="Visit Date" value="<?php echo date('Y-m-d');?>">
				                    <span class="add-on" style="cursor:pointer;">
				                        &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                        </i>
				                    </span>
				                </div>
				            </div>
				        </div>

				       
				        
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Schedule: </label>
				            
				            <div class="col-lg-8">
				            	<a onclick="check_date()" style="cursor:pointer;">[Show Doctor's Schedule]</a><br>
				            	<!-- show the doctors -->
				            	<div id="show_doctor" style="display:none;"> 
				            		<select name="doctor" id="doctor" onChange="load_schedule()" class="form-control">
								    	<option >----Select Doctor to View Schedule---</option>
					                    	<?php
												if(count($doctor) > 0){
					                        		foreach($doctor as $row):
														$fname = $row->personnel_fname;
														$onames = $row->personnel_onames;
														$personnel_id = $row->personnel_id;
														echo "<option value=".$personnel_id.">".$onames."</option>";
													endforeach;
												}
											?>
					                </select>
				            	</div>
				            	<!-- the other one -->
				            	<div  id="doctors_schedule"> </div>
				            </div>
				        </div>
				        <div class="form-group">
				            	<label class="col-lg-4 control-label">Start time : </label>
				            
					            <div class="col-lg-8">
								    <div id="datetimepicker2" class="input-append">
				                       <input data-format="hh:mm" class="picker" id="timepicker_start" name="timepicker_start"  type="text" class="form-control">
				                       <span class="add-on" style="cursor:pointer;">
				                         &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                         </i>
				                       </span>
				                    </div>
					            </div>
					        </div>
					         <div class="form-group">
					            <label class="col-lg-4 control-label">End time : </label>
					            
					            <div class="col-lg-8">				            
									<div id="datetimepicker3" class="input-append">
				                       <input data-format="hh:mm" class="picker" id="timepicker_end" name="timepicker_end"  type="text" class="form-control">
				                       <span class="add-on" style="cursor:pointer;">
				                         &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                         </i>
				                       </span>
				                    </div>
								</div>
					        </div>
					       </div>
					    </div>
					 </div>
						 	
					</div>
				     <!-- end right -->
				 </div>
				 <!-- end of row -->
				 <div class="center-align">
				 <input type="submit" value="Initiate Visit" class="btn btn-info btn-lg"/>
				</div>
				<div class="center-align">
				 	<div class="alert alert-info center-align">Note: For Appointments ensure that you have filled in both sections on this page.</div>
				</div>

				
				<?php echo form_close();?>
				 <!-- end of form -->
			</div>
		</div>
	</div>
    </div>
</div>


         
 <script type="text/javascript" src="<?php echo base_url("js/script.js");?>"></script>
 <script type="text/javascript" charset="utf-8">
	 function check_date(){
	     var datess=document.getElementById("datepicker").value;
	     if(datess){
		  $('#show_doctor').fadeToggle(1000); return false;
		 }
		 else{
		  alert('Select Date First')
		 }
	}
	function load_schedule(){
		var config_url = $('#config_url').val();
		var datess=document.getElementById("datepicker").value;
		var doctor=document.getElementById("doctor").value;
		var url= config_url+"/reception/doc_schedule/"+doctor+"/"+datess;
		
		  $('#doctors_schedule').load(url);
		  $('#doctors_schedule').fadeIn(1000); return false;	
	}
 
	function getXMLHTTP() {
	 //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		 	
		return xmlhttp;
	}
	
	
	
	function getCity(strURL) {		
		
		var req = getXMLHTTP();
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('citydiv').innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}
				
	}
	function checks(patient_type){
		var patient_type=document.getElementById('patient_type').value;
		if(patient_type==0){
			alert('Ensure you have selected The patient type');
		}
		
	}

	function check_department_type(){

		var myTarget = document.getElementById("department_id").value;

		var myTarget2 = document.getElementById("department_type");

		var myTarget3 = document.getElementById("patient_type_div");

		if(myTarget==7)
		{
		 	myTarget2.style.display = 'block';

		}
		else{
	 	 	myTarget2.style.display = 'none';
	 	 	myTarget3.style.display = 'block';	
		}

	}
	
	$(document).on("change","select#patient_type",function(e){
		var patient_type_id = $(this).val();
		
		if(patient_type_id == '4')
		{
			$('#insured_company').css('display', 'block');
		}
		else
		{
			$('#insured_company').css('display', 'none');
		}
	});
</script>

