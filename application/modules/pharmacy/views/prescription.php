<?php



$drug_size ="";
$drug_size_type ="";

$rs21 = $this->nurse_model->get_visit_type($visit_id);

$num_type= count($rs21);
foreach ($rs21 as $key):
	$visit_t = $key->visit_type;
endforeach;

$drug_dose ="";
$dose_unit_id ="";
$drug_type_name ="";
$admin_route ="";
$dose_unit ="";
$service_charge_name ="";
if(!empty($service_charge_id)){

	$rs2 = $this->pharmacy_model->get_drug($service_charge_id);
	
	$s = 0;
	foreach ($rs2 as $key2):
		$drug_type_id = $key2->drug_type_id;
		$admin_route_id = $key2->drug_administration_route_id;
		$drug_dose = $key2->drugs_dose;
		$dose_unit_id = $key2->drug_dose_unit_id;
		$drug_size = $key2->drug_size;
		$drug_size_type = $key2->drug_size_type;
		$service_charge_name = $key2->service_charge_name;
	endforeach;
		
		if(!empty($drug_type_id)){
			$rs3 = $this->pharmacy_model->get_drug_type_name($drug_type_id);
			$num_rows3 = count($rs3);
			if($num_rows3 > 0){
				foreach ($rs3 as $key3):
					$drug_type_name = $key3->drug_type_name;
				endforeach;
			}
		}
		if(!empty($dose_unit_id)){
			$rs3 = $this->pharmacy_model->get_dose_unit2($dose_unit_id);
			$num_rows3 = count($rs3);
			if($num_rows3 > 0){
				foreach ($rs3 as $key3):
					$dose_unit = $key3->drug_dose_unit_name;
				endforeach;
			}
		}
		if(!empty($admin_route_id)){
			$rs3 = $this->pharmacy_model->get_admin_route2($admin_route_id);
			$num_rows3 = count($rs3);
			if($num_rows3 > 0){
				foreach ($rs3 as $key3):
					$admin_route = $key3->drug_administration_route_name;
				endforeach;
			}
		}
}

if(!empty($delete)){
	
	$visit_charge_id = $_GET['visit_charge_id'];
	$del = new prescription();
	$del->delete_visit_charge($visit_charge_id);
	
	$del = new prescription();
	$del->delete_prescription($delete);
	
	?>
    <!--<script type="text/javascript">
		window.location.href = "prescription.php?visit_id=<?php //echo $visit_id?>";
	</script>-->
    <?php
}
//if the update button is clicked
if(isset($_REQUEST['update'])){
	
		$id = $_POST['hidden_id'];//echo $id."<br/>";
		$start_date= addslashes($_POST['date3'.$id]);
		$finish_date = addslashes($_POST['date4'.$id]);
		$frequncy = addslashes($_POST['frequency'.$id]);
		$sub = addslashes($_POST['substitution'.$id]);
		$duration = addslashes($_POST['duration'.$id]);
		$consumption = addslashes($_POST['consumption'.$id]);
		$quantity = addslashes($_POST['quantity'.$id]);
		
		
		$times = new prescription;
$times_rs11 = $times->get_drug_time($time);
$num_times11 = mysql_num_rows($times_rs11);
$numerical_value11 = mysql_result($rs3, 0, "numerical_value");

     $your_date = strtotime($varfinishdate);
	 $your_date1 = strtotime($vardate);
     $datediff = $your_date - $your_date1;
    $qtty= floor($datediff/(60*60*24));
	
	$quantity_fin=$qtty*$numerical_value11*$quantity;
		$update = new prescription;
		$update->update_drug_list($start_date, $finish_date, $frequncy, $id, $sub, $duration, $consumption, $quantity_fin);	
		$v_id = $_POST['v_id'];
		
		$get = new prescription;
		$visit_charge_id = $get->get_visit_charge_id1($id);
		$prescription = new prescription;
		$prescription->update_visit_charge($visit_charge_id,$quantity_fin);
		?>
        <script type="text/javascript">
			window.alert("Update Successfull");
			window.location.href = "prescription.php?visit_id="+<?php echo $v_id;?>;
		</script>
		<?php
	}



$rs_forms = $this->pharmacy_model->get_drug_forms();
$num_forms = count($rs_forms);

if($num_forms > 0){
	
	$xray = "'";
	$t = 0;
	foreach ($rs_forms as $key_forms):
		if($t == ($num_forms-1)){
	
			$xray = $xray."".$key_forms->drug_type_name."'";
		}

		else{
			$xray = $xray."".$key_forms->drug_type_name."','";
		}
		$t++;
	endforeach;
}

$rs_admin = $this->pharmacy_model->get_admin_route();
$num_admin = count($rs_admin);

if($num_admin > 0){
	
	$xray2 = "'";
	$k = 0;
	foreach ($rs_admin as $key_admin):

		if($k == ($num_admin-1)){
	
			$xray2 = $xray2."".$key_admin->drug_administration_route_name."'";
		}

		else{
	
			$xray2 = $xray2."".$key_admin->drug_administration_route_name.",";
		}
		$k++;
	endforeach;
}

$rs_units = $this->pharmacy_model->get_dose_unit();
$num_units = count($rs_units);

if($num_units > 0){
	
	$xray3 = "'";
	$l=0;
	foreach ($rs_units as $key_units):

		if($l == ($num_units-1)){
	
			$xray3 = $xray3.$key_units->drug_dose_unit_name."'";
		}

		else{
	
			$xray3 = $xray3.$key_units->drug_dose_unit_name."','";
		}
	endforeach;
}

//get drug times
$times_rs = $this->pharmacy_model->get_drug_times();
$num_times = count($times_rs);
$time_list = "<select name = 'x' class='form-control'>";

	foreach ($times_rs as $key_items):

		$time = $key_items->drug_times_name;
		$drug_times_id = $key_items->drug_times_id;
		$time_list = $time_list."<option value='".$drug_times_id."'>".$time."</option>";
	endforeach;
$time_list = $time_list."</select>";

//get consumption
$rs_cons = $this->pharmacy_model->get_consumption();
$num_cons = count($rs_cons);
$cons_list = "<select name = 'consumption' class='form-control'>";
	foreach ($rs_cons as $key_cons):

	$con = $key_cons->drug_consumption_name;
	$drug_consumption_id = $key_cons->drug_consumption_id;
	$cons_list = $cons_list."<option value='".$drug_consumption_id."'>".$con."</option>";
	endforeach;
$cons_list = $cons_list."</select>";

//get durations
$duration_rs = $this->pharmacy_model->get_drug_duration();
$num_duration = count($duration_rs);
$duration_list = "<select name = 'duration' class='form-control'>";
	foreach ($duration_rs as $key_duration):
	$durations = $key_duration->drug_duration_name;
	$drug_duration_id = $key_duration->drug_duration_id;
	$duration_list = $duration_list."<option value='".$drug_duration_id."'>".$durations."</option>";
	endforeach;
$duration_list = $duration_list."</select>";

//warnings
$warnings_rs = $this->pharmacy_model->get_warnings();
$num_warnings = count($warnings_rs);

$warning = "'";
$i = 0;
	foreach ($warnings_rs as $key_warning):

		if($i == ($num_warnings-1)){
		
			$warning = $warning."".$key_warning->warnings_name."'";
		}

		else{
		
			$warning = $warning."".$key_warning->warnings_name."','";
		}
		$i++;
	endforeach;

//instructions
$instructions_rs = $this->pharmacy_model->get_instructions();
$num_instructions = count($instructions_rs);

$inst = "'";
$p = 0;

	foreach ($instructions_rs as $key_instructions):
		if($p == ($num_instructions-1)){
		
			$inst = $inst."".$key_instructions->instructions_name."'";
		}

		else{
			$inst = $inst."".$key_instructions->instructions_name."','";
		}
	$p++;
	endforeach;
?>



    
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
	<!-- end #header -->
<div class="row">
<?php echo form_open($this->uri->uri_string, array("class" => "form-horizontal"));?>
<div class="row col-md-12">
	<div class="col-md-4">
          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Drugs</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

            <!-- Widget content -->
                <div class="widget-content">
                    <div class="padd">
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Medicine: </label>
				            
				            <div class="col-lg-8">
				            		<input type="text" name="passed_value" id="passed_value"  class="form-control" onClick="myPopup2(<?php echo $visit_id;?>)" value="<?php echo $service_charge_name;?>"/> <a href="#" onClick="myPopup2(<?php echo $visit_id;?>)">Get Drug</a>
				            </div>
				        </div>

				        <div class="form-group">
				            <label class="col-lg-4 control-label">Allow substitution: </label>
				            
				            <div class="col-lg-8">
				            	<input name="substitution" type="checkbox" value="Yes" />
				            </div>
				        </div>
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Dose: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $drug_dose?>
				            </div>
				        </div>
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Dose Unit: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $dose_unit;?>
				            </div>
				        </div>

					</div>
				</div>
			</div>
		</div>
		<!-- end of drugs -->
		<!-- start of admission -->
		<div class="col-md-4">
          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Admission</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

            <!-- Widget content -->
                <div class="widget-content">
                    <div class="padd">
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Form: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $drug_type_name?>
				            </div>
				        </div>
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Admin Route: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $admin_route?>
				            </div>
				        </div>

				        <div class="form-group">
				            <label class="col-lg-4 control-label">Number of Days: </label>
				            
				            <div class="col-lg-8">
				            	<input type="text" id="days" class='form-control' name="days"  autocomplete="off"/>
				            </div>
				        </div>
				        <?php if($drug_size_type!=""){
				         ?>
					        <div class="form-group">
					            <label class="col-lg-4 control-label">Amount contained in One Pack: </label>
					            
					            <div class="col-lg-8">
					            	<?php echo $drug_size.'  '.$drug_size_type ?>
					            </div>
					        </div>
					      <?php
					      }
					      ?>

					</div>
				</div>
			</div>
		</div>
		<!-- end of admission -->
		<!-- start of usage -->
		<div class="col-md-4">
          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Usage</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

            <!-- Widget content -->
                <div class="widget-content">
                    <div class="padd">
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Method: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $cons_list?>
				            </div>
				        </div>
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Quantity: </label>
				            
				            <div class="col-lg-8">
				            	<input type="text" name="quantity" class='form-control' autocomplete="off" /> <?php echo $drug_size_type?> <input name="service_charge_id" id="service_charge_id" value="<?php echo $service_charge_id ?>" type="hidden">
				            </div>
				        </div>
				        <div class="form-group">
				            <label class="col-lg-4 control-label">Times: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $time_list;?>
				            </div>
				        </div>

				        <div class="form-group">
				            <label class="col-lg-4 control-label">Duration: </label>
				            
				            <div class="col-lg-8">
				            	<?php echo $duration_list;?>
				            </div>
				        </div>
					</div>
				</div>
			</div>
		</div>
		<!-- end of usage -->
		

	</div>
		<!-- end of drugs tab -->
	<div class="row col-md-12">
 		<div class="center-align">
			<input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
			<input name="submit" type="submit" class="btn btn-large" value="Prescribe" />
		</div>
	</div>
<div class="row col-md-12">
	<div class="col-md-12">
		<!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Usage</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

            <!-- Widget content -->
                <div class="widget-content">
                    <div class="padd">
                    	<table class='table table-striped table-hover table-condensed'>
 											 <tr>
   												<th>No.</th>
    											<th>Medicine:</th>
    											<th>Dose</th>
   											 	<th>Dose Unit</th>
    											<th>Method</th>
    											<th>Quantity</th>
    											<th>Times</th>
    											<th>Duration</th>
   											 	<th>Number of Days</th>
    											<th> </th>
                                                <th>Allow Substitution</th>
                                                <th></th>
  											</tr>
                                           <?php 
                                           $rs = $this->pharmacy_model->select_prescription($visit_id);
											$num_rows =count($rs);
											$s=0;
											if($num_rows > 0){
                                        	foreach ($rs as $key_rs):
                                        	
											   	$service_charge_id =$key_rs->drugs_id;
											   	$frequncy = $key_rs->drug_times_name;
												$id = $key_rs->prescription_id;
												$date1 = $key_rs->prescription_startdate;
												$date2 = $key_rs->prescription_finishdate;
												$sub = $key_rs->prescription_substitution;
												$duration = $key_rs->drug_duration_name;
												$sub = $key_rs->prescription_substitution;
												$duration = $key_rs->drug_duration_name;
												$consumption = $key_rs->drug_consumption_name;
												$quantity = $key_rs->prescription_quantity;
												$medicine = $key_rs->drugs_name;
												
												$substitution = "<select name='substitution".$id."'>";
												if($sub == "No"){
													$substitution = $substitution."<option selected>No</option><option>Yes</option>";
												}
												else{
													$substitution = $substitution."<option>No</option><option selected>Yes</option>";
												}
												$substitution = $substitution."</select>";
												
												//$drugs = new prescription();
												//$medicine = $drugs->get_drugs_name($service_charge_id);
												
												$rs2 = $this->pharmacy_model->get_drug($service_charge_id);
												
												foreach ($rs2 as $key_rs2 ):
												$drug_type_id = $key_rs2->drug_type_id;
												$admin_route_id = $key_rs2->drug_administration_route_id;
												$dose = $key_rs2->drugs_dose;
												$dose_unit_id = $key_rs2->drug_dose_unit_id;
												
												endforeach;

												if(!empty($drug_type_id)){
													$rs3 = $this->pharmacy_model->get_drug_type_name($drug_type_id);
													$num_rows3 = count($rs3);
													if($num_rows3 > 0){
														foreach ($rs3 as $key_rs3):
															$drug_type_name = $key_rs3->drug_type_name;
														endforeach;
													}
												}
												
												if(!empty($dose_unit_id)){

													$rs3 = $this->pharmacy_model->get_dose_unit2($dose_unit_id);
													$num_rows3 = count($rs3);
													if($num_rows3 > 0){
														foreach ($rs3 as $key_rs3):
															$doseunit = $key_rs3->drug_dose_unit_name;
														endforeach;
													}
												}
												
												
												if(!empty($admin_route_id)){
													$rs3 = $this->pharmacy_model->get_admin_route2($admin_route_id);
													$num_rows3 = count($rs3);
													if($num_rows3 > 0){
														foreach ($rs3 as $key_rs3):
															$admin_route = $key_rs3->drug_administration_route_name;
														endforeach;
													}
												}
												
												$time_list2 = "<select name = 'x".$id."'>";
												
													foreach ($times_rs as $key_items):

														$time = $key_items->drug_times_name;
														$drug_times_id = $key_items->drug_times_id;
														$time_list2 = $time_list2."<option value='".$drug_times_id."'>".$time."</option>";
													endforeach;
												$time_list2 = $time_list2."</select>";
												
												$duration_list2 = "<select name = 'duration".$id."'>";
												
												foreach ($duration_rs as $key_duration):
													$durations = $key_duration->drug_duration_name;
													$drug_duration_id = $key_duration->drug_duration_id;
													$duration_list2 = $duration_list2."<option value='".$drug_duration_id."'>".$durations."</option>";
												endforeach;
												$duration_list2 = $duration_list2."</select>";
												
												$cons_list2 = "<select name = 'consumption".$id."'>";
												
												foreach ($rs_cons as $key_cons):
													$con = $key_cons->drug_consumption_name;
													$drug_consumption_id = $key_cons->drug_consumption_id;
													$cons_list2 = $cons_list2."<option value='".$drug_consumption_id."'>".$con."</option>";
												endforeach;
												$cons_list2 = $cons_list2."</select>";
												$s++;
											?>
                                           	<?php echo form_open($this->uri->uri_string, array("class" => "form-horizontal"));?>
									  		<tr>
    											<td><?php echo $s; ?></td>
    											<td width="200px"><?php echo $medicine;?></td>
    											<td><?php echo $dose;?></td>
                                                <td><?php echo $doseunit?></td>
    											<td><?php echo $cons_list2; ?></td>
                                                <td><input type="text" name="quantity<?php echo $id?>"  autocomplete="off" value="<?php echo $quantity?>"/></td>
    											<td><?php echo $time_list2; ?></td>
    											<td><?php echo $duration_list2; ?></td>
                                        		<td><input type="text" id="datepicker3" name="days"  autocomplete="off" value="<?php echo  $date1?>"/></td>
                       
                                                <td><?php echo $substitution?></td>
                                                <td>
                                                	<div class='btn-toolbar'>
                                                    	<div class='btn-group'>
                                                        	<a class='btn' href='delete_prescritpion.php?prescription_id=<?php echo $id;?>&visit_id=<?php echo $visit_id?>&visit_charge_id=<?php echo $visit_charge_id?>'><i class='icon-remove'></i></a>
                                                       	</div>
                                                     </div>
                                                 </td>
                                                 <td>
                                                 	<input name="update" type="submit" value="Update" />
                                                 	<input type="hidden" name="hidden_id" value="<?php echo $id?>" />
                                                    <input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
                                                 </td>
											</tr>
											<?php echo form_close();?>
							          <?php
							          endforeach;
							          	}

							          ?>
							</table>
                    </div>
                </div>
           </div>
	</div>
</div>
<div class="row col-md-12">
 	<div class="center-align">
 	 <input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
            <input name="pharmacy_doctor"   onClick="send_to_pharmacy2(<?php echo $visit_id;?>);unload()" type="button" class="btn btn-large" value="Done" />
    </div>
 </div>  
                         
<?php echo form_close();?>

                                        
  

</div>

   <script type="text/javascript" charset="utf-8">

			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });

				//Autocomplete
				$("#autocomplete").autocomplete({
					source: [<?php echo $xray?>]
				});
				//Autocomplete
				$("#autocomplete2").autocomplete({
					source: [<?php echo $xray2?>]
				});
				//Autocomplete
				$("#autocomplete3").autocomplete({
					source: [<?php echo $xray3?>]
				});
				//Autocomplete
				$("#autocomplete6").autocomplete({
					source: [<?php echo $inst?>]
				});
				//Autocomplete
				$("#autocomplete7").autocomplete({
					source: [<?php echo $warning?>]
				});
				//Autocomplete
				$("#autocomplete8").autocomplete({
					source: [<?php echo $xray3?>]
				});

				// Button
				$("#button").button();
				$("#radioset").buttonset();

				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				$('#datepicker2').datepicker({
					inline: true
				});

				// Datepicker
				$('#datepicker3').datepicker({
					inline: true
				});
				$('#datepicker4').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
		
		function drug_dose(id){
			$(function(){
				//Autocomplete
				$("#drug_dose"+id).autocomplete({
					source: [<?php echo $xray3?>]
				});
				
			});
		}
		
		function consumption_instructions(id){
			$(function(){
				//Autocomplete
				$("#instructions"+id).autocomplete({
					source: [<?php echo $inst?>]
				});
				
			});
		}
		
		function consumption_warnings(id){
			$(function(){
				//Autocomplete
				$("#warnings"+id).autocomplete({
					source: [<?php echo $warning?>]
				});
				
			});
		}
	</script>
<script type="text/javascript" charset="utf-8">

			$(function(){
				
				//date picker
				$( "#datepicker" ).datepicker();
				$( "#format" ).change(function() {
					$( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
		});});
	
    function setImage(file) {
        if(document.all){
            document.getElementById('prevImage').src = file.value;
		}
        else{
            document.getElementById('prevImage').src = file.files.item(0).getAsDataURL();
		}
        if(document.getElementById('prevImage').src.length > 0) {
            document.getElementById('prevImage').style.display = 'block';
		}
    }
	function unload(){
		window.opener.location.reload(true);
		}





	</script>
	<script type="text/javascript">

function myPopup2(visit_id) {
	var config_url = $('#config_url').val();
	window.open(config_url+"/pharmacy/drugs/"+visit_id,"Popup","height=1200,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100"); 
}


	</script>


                                        