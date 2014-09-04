	<?php echo validation_errors(); ?>
        	<?php echo form_open("reception/save_visit/".$patient_id);?>
            	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Initiate Visit for <?php echo $patient;?></p></div>
                <table class="table table-stripped table-condensed table-hover">
                	<tr>
                    	<th>Visit Date</th>
                    	<th>Doctor</th>
                    	<th>Patient type</th>
                        <th>Consultation type</th>
                    	  
                    </tr>
                	<tr>
                    	 <td><input type="text" id="datepicker"  name="visit_date" size="15" autocomplete="off" placeholder="Visit Date" />    <strong>Appointment Details</strong><br>
					     <a onclick="check_date()">[Show Doctor's Schedule]</a>
						<div id="show_doctor">  
					    <select name="doctor" id="doctor" onChange="load_schedule()" >
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
      <div  id="doctors_schedule"> 
      
      </div>
     </div>
          <label for="timepicker_start">Start time :</label>
        <input type="text" style="width: 70px" id="timepicker_start" name="timepicker_start" value="" />
        <label for="timepicker_end">end time :</label>
        <input type="text" style="width: 70px" id="timepicker_end" name="timepicker_end" value="" />

   
</td>
                    	<td>
                        	<select name="doctor">
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
                       </td>                 
                    	<td>
                       <select name="patient_type" id="patient_type"  onChange='insurance_company("patient_type","insured");getCity("http://sagana/hms/data/load_charges.php?patient_type="+this.value);' >
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
                            </select> <br>
           <div  id="insured" style="display:none;">
                       
               <strong>Insurance Name<br>
&   </strong>	<select name="patient_insurance_id">
                        <option value="">--- Select Insurance Company---</option>
                            <?PHP
                            if(count($patient_insurance) > 0){	
							foreach($patient_insurance as $row):
									$company_name = $row->company_name;
									$insurance_company_name = $row->insurance_company_name;
									$patient_insurance_id = $row->patient_insurance_id;
									echo "<option value=".$patient_insurance_id.">".$company_name." - ".$insurance_company_name."</option>";						endforeach;	} ?>
                                    </select>
			  <br>
			
			  <input name="insurance_id" id="insurance_id"  type="text" placeholder="Input Insurance Number">
				 
                      </div>
                        </td>
             <td>
                       <div id="citydiv"> <div id="checker"  onclick="checks('patient_type');" > <select name="service_charge_name">
	<option value='0'>Loading..</option>
        </select></div>
                             </div> </td>
                  </tr>
                </table>
                <table align="center">
                	<tr>
                    	<td><input type="submit" value="Initiate Visit" class="btn btn-large btn-primary"/></td>
                    </tr>
                </table>
                </form>