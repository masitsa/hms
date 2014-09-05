<?php echo validation_errors(); ?>
<?php echo form_open("welcome/save_initiate_pharmacy/".$patient_id, array("class" => "form-horizontal"));?>
            	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Initiate Visit for <?php echo $patient;?></p></div>
                <table class="table table-stripped table-condensed table-hover">
                	<tr>
                    	<th>Patient type</th>
                           <?php

                        	if(count($patient_insurance) > 0){
								
								?>	
                        <th>Patient Insurance Name<br>
& Insurance Number</th>
<?php } ?>
                    </tr>
                	<tr>
                                      
                    	               	<td>
                        	<select name="patient_type" id="patient_type"  onChange='insurance_company("patient_type","insured");' >
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
                        </td>
                        <div>
                        <td  id="insured" style="display:none;">
                        <?php
                        	
								
								?>	<select name="patient_insurance_id">
                        <option value="0">--- Select Insurance Company---</option>
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
				  <?php		
						?>
                        	
                          
                      </td>
                      </div>
                       
                  </tr>
                </table>
                <table align="center">
                	<tr>
                    	<td><input type="submit" value="Initiate Pharmacy Visit" class="btn btn-large btn-primary"/></td>
                    </tr>
                </table>
            </form>