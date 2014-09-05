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
				<?php echo validation_errors(); ?>
				<?php echo form_open("welcome/save_visit/".$patient_id, array("class" => "form-horizontal"));?>
				<div class="row">
					<div class="col-md-6">
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Visit Date: </label>
				            
				            <div class="col-lg-8">
				            	<div id="datetimepicker1" class="input-append">
				                    <input data-format="yyyy-MM-dd" class="form-control" type="text" id="datepicker" name="visit_date" placeholder="Visit Date">
				                    <span class="add-on">
				                        &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                        </i>
				                    </span>
				                </div>
				            </div>
				        </div>

				        <div class="form-group">
				            <label class="col-lg-4 control-label">Doctor: </label>
				            
				            <div class="col-lg-8">
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
				        </div>
				        
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Schedule: </label>
				            
				            <div class="col-lg-8">
				            	<a onclick="check_date()">[Show Doctor's Schedule]</a><br>
				            	<!-- show the doctors -->
				            	<div id="show_doctor"> </div>
				            	<!-- the other one -->
				            	<div  id="doctors_schedule"> </div>
				            </div>
				        </div>
				        <div class="form-group">
				            	<label class="col-lg-4 control-label">Start time : </label>
				            
					            <div class="col-lg-8">
								    <div id="datetimepicker2" class="input-append">
				                       <input data-format="hh:mm" class="picker" id="timepicker_start" name="timepicker_start"  type="text" class="form-control">
				                       <span class="add-on">
				                         &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                         </i>
				                       </span>
				                    </div>
					            </div>
					        </div>
					         <div class="form-group">
					            <label class="col-lg-4 control-label">End time : </label>
					            
					            <div class="col-lg-8">				            
									<div id="datetimepicker2" class="input-append">
				                       <input data-format="hh:mm" class="picker" id="timepicker_end" name="timepicker_end"  type="text" class="form-control">
				                       <span class="add-on">
				                         &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
				                         </i>
				                       </span>
				                    </div>
								</div>
					        </div>

				        

				     </div>
				     <!--end left -->
				     <!-- start right -->
				     <div class="col-md-6">
						     	<div class="form-group">
						            <label class="col-lg-4 control-label">Patient Type: </label>
						            
						            <div class="col-lg-8">
						            	 <select name="patient_type" id="patient_type"  onChange='insurance_company("patient_type","insured");getCity("http://sagana/hms/data/load_charges.php?patient_type="+this.value);' class="form-control">
						                    <option value="0">--- Select Patient Type---</option>
						                	<?php
												if(count($type) > 0){
						                    		foreach($type as $row):
														$type_name = $row->visit_type_name;
														$type_id= $row->visit_type_id;
															?><option value="<?php echo $type_id; ?>" ><?php echo $type_name ?></option>
													<?php	
													endforeach;
												}
											?>
						                    </select>
           								<div  id="insured" style="display:none;"> </div>
           							</div>
						        </div>
						        <div class="form-group">
						            <label class="col-lg-4 control-label">Insurance Name: </label>
						            
						            <div class="col-lg-8">
						                <select name="patient_insurance_id" class="form-control">
						                        <option value="">--- Select Insurance Company---</option>
						                            <?PHP
						                            if(count($patient_insurance) > 0){	
													foreach($patient_insurance as $row):
															$company_name = $row->company_name;
															$insurance_company_name = $row->insurance_company_name;
															$patient_insurance_id = $row->patient_insurance_id;
													echo "<option value=".$patient_insurance_id.">".$company_name." - ".$insurance_company_name."</option>";
													endforeach;	} ?>
						              </select>
						              <br>
           							<div  id="insured" style="display:none;"></div>
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
				     <!-- end right -->
				 </div>
				 <!-- end of row -->
				 <div class="center-align">
				 <input type="submit" value="Initiate Visit" class="btn btn-info btn-lg"/>
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
</script>

