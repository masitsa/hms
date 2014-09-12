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
if(isset($_REQUEST['submit'])){
        $varpassed_value = $_POST['passed_value'];
		$varsubstitution = $_POST['substitution'];
		$varform = $_POST['form'];
		$varadminroute = $_POST['adminroute'];
		$vardate = $_POST['days'];
		$varfinishdate = $_POST['finishdate'];
		$vardose = $_POST['dose'];
		$vardoseunit= $_POST['doseunit'];
		$instructions = $_POST['instructions'];
		$warnings = $_POST['warnings'];
		$varx = $_POST['x'];
		$duration = $_POST['duration'];
		$v_id = $_POST['v_id'];
		$consumption = addslashes($_POST['consumption']);
		$quantity = addslashes($_POST['quantity']);
		
		$scid = addslashes($_POST['service_charge_id']);
		
		if(empty($varsubstitution)){
			$varsubstitution = "No";
		}
		$date = date("Y-m-d"); 
		$time = date("H:i:s");
	
		
	

		//$prescription = new prescription;
		//$prescription->save_visit_charge($varpassed_value,$v_id, $date, $time, 10,$visit_t);
		
		//$get = new prescription;
		//$visit_charge_id = $get->get_visit_charge_id($v_id, $date, $time);
		
		$prescription = new prescription;
		$prescription->save_prescription($varsubstitution, $vardate, $varfinishdate, $varx, $v_id, $duration, $consumption,$quantity,$scid);
		
		?>
        <script type="text/javascript">
			window.location.href = "prescription.php?visit_id=<?php echo $v_id;?>";
		</script>
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

$rs = $this->pharmacy_model->select_prescription($visit_id);
$num_rows =count($rs);

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
$time_list = "<select name = 'x'>";

	foreach ($times_rs as $key_items):

		$time = $key_items->drug_times_name;
		$time_list = $time_list."<option>".$time."</option>";
	endforeach;
$time_list = $time_list."</select>";

//get consumption
$rs_cons = $this->pharmacy_model->get_consumption();
$num_cons = count($rs_cons);
$cons_list = "<select name = 'consumption'>";
	foreach ($rs_cons as $key_cons):

	$con = $key_cons->drug_consumption_name;
	$cons_list = $cons_list."<option>".$con."</option>";
	endforeach;
$cons_list = $cons_list."</select>";

//get durations
$duration_rs = $this->pharmacy_model->get_drug_duration();
$num_duration = count($duration_rs);
$duration_list = "<select name = 'duration'>";
	foreach ($duration_rs as $key_duration):
	$durations = $key_duration->drug_duration_name;
	$duration_list = $duration_list."<option>".$durations."</option>";
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



    

	<!-- end #header -->
	<div class="row-fluid">
<form name="myform" action="prescription.php?visit_id=<?php echo $visit_id?>" method="post">
                                        <div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Drug</p></div>
                                    <table class='table table-striped table-hover table-condensed'>
                                        <tr>
                                        	<td>Medicine: </td>
                                        	<td><input type="text" name="passed_value" id="passed_value" size="60" onClick="myPopup2(<?php echo $visit_id;?>)" value="<?php echo $service_charge_name;?>"/> <a href="#" onClick="myPopup2(<?php echo $visit_id;?>)">Get Drug</a></td>
                                       	 	<td>Allow Subtitution: </td><td><input name="substitution" type="checkbox" value="Yes" /></td>
                                        		<th>Dose: </th>
                                            	<td><?php echo $drug_dose?></td>
                                           		<th>Dose Unit: </th>
                                                <td><?php echo $dose_unit?></td>
                                        </tr>
                                     </table>	
                                        <div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Admission</p></div>
                                    <table class='table table-striped table-hover table-condensed'>
                                        <tr>
                                        	<th>Form: </th>
                                            <td><?php echo $drug_type_name?></td>
                                            <th>Admin route: </th>
                                            <td><?php echo $admin_route?></td>
                                        	<th>Number of Days</th>
                                        	<td><input type="text" id="days" name="days"  autocomplete="off"/></td>
                                            <?php if($drug_size_type!=""){ ?>
                                        	 	<th>Amount contained in One Pack</th>
                                        	<td><?php echo $drug_size.'  '.$drug_size_type ?></td>
                                            <?php } 
											else {
												
												}?>
                                        </tr>
                                        </table>
                                        <div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Usage</p></div>
                                        <table class='table table-striped table-hover table-condensed'>
                                        	<tr>
                                           		<th>Method: </th>
                                                <td><?php echo $cons_list?></td>
                                           		<th>Quantity: </th>
                                                <td><input type="text" name="quantity"  autocomplete="off" /> <?php echo $drug_size_type?> <input name="service_charge_id" id="service_charge_id" value="<?php echo $service_charge_id ?>" type="hidden"></td>
                                            	<th>Times: </th>
                                            	<td><?php echo $time_list;?></td>
                                            	<th>Duration: </th>
                                            	<td><?php echo $duration_list;?></td>
                                         	</tr>
                                        </table>
                                    
                                        <table align="center">
                                        	<tr>
                                        		<td></td>
                                                <td><input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/></td>
                                                 <td><input name="submit" type="submit" class="btn btn-large" value="Prescribe" /></td>
                                         	</tr>
                                        </table>
                                        </form>
	<div class='navbar-inner2'>
		<p style='text-align:center; color:#0e0efe;'>Medication List</p>
	</div>
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
  											</tr>
                                           <?php for($s = 0; $s < $num_rows; $s++){
											   
											   	$service_charge_id =mysql_result($rs, $s, "drugs_id");
											   	$frequncy = mysql_result($rs, $s, "drug_times_name");
												$id = mysql_result($rs, $s, "prescription_id");
												$date1 = mysql_result($rs, $s, "prescription_startdate");
												$date2 = mysql_result($rs, $s, "prescription_finishdate");
												$sub = mysql_result($rs, $s, "prescription_substitution");
												$duration = mysql_result($rs, $s, "drug_duration_name");
												$sub = mysql_result($rs, $s, "prescription_substitution");
												$duration = mysql_result($rs, $s, "drug_duration_name");
												$consumption = mysql_result($rs, $s, "drug_consumption_name");
												$quantity = mysql_result($rs, $s, "prescription_quantity");
												echo 'LAYLAY'.$quantity;
												$medicine = mysql_result($rs, $s, "drugs_name");
												
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
												
												$get = new prescription;
												$rs2 = $get->get_drug($service_charge_id);
												
												$drug_type_id = mysql_result($rs2, 0, "drug_type_id");
												$admin_route_id = mysql_result($rs2, 0, "drug_administration_route_id");
												$dose = mysql_result($rs2, 0, "drugs_dose");
												$dose_unit_id = mysql_result($rs2, 0, "drug_dose_unit_id");
												
												
				if(!empty($drug_type_id)){
													$get2 = new prescription;
													$rs3 = $get2->get_drug_type_name($drug_type_id);
													$num_rows3 = mysql_num_rows($rs3);
													if($num_rows3 > 0){
														$drug_type_name = mysql_result($rs3, 0, "drug_type_name");
													}
												}
												
												if(!empty($dose_unit_id)){
													$get2 = new prescription;
													$rs3 = $get2->get_dose_unit2($dose_unit_id);
													$num_rows3 = mysql_num_rows($rs3);
													if($num_rows3 > 0){
														$doseunit = mysql_result($rs3, 0, "drug_dose_unit_name");
													}
												}
												
												
												if(!empty($admin_route_id)){
													$get2 = new prescription;
													$rs3 = $get2->get_admin_route2($admin_route_id);
													$num_rows3 = mysql_num_rows($rs3);
													if($num_rows3 > 0){
														$admin_route = mysql_result($rs3, 0, "drug_administration_route_name");
													}
												}
												
												$time_list2 = "<select name = 'frequency".$id."'>";
												
												for($t = 0; $t < $num_times; $t++){
													$time = mysql_result($times_rs, $t, "drug_times_name");
													
													if($time == $frequncy){
														$time_list2 = $time_list2."<option selected>".$time."</option>";
													}
													else{
														$time_list2 = $time_list2."<option>".$time."</option>";
													}
												}
												$time_list2 = $time_list2."</select>";
												
												$duration_list2 = "<select name = 'duration".$id."'>";
												
												for($t = 0; $t < $num_duration; $t++){
													$dur = mysql_result($duration_rs, $t, "drug_duration_name");
													
													if($dur == $duration){
														$duration_list2 = $duration_list2."<option selected>".$dur."</option>";
													}
													else{
														$duration_list2 = $duration_list2."<option>".$dur."</option>";
													}
												}
												$duration_list2 = $duration_list2."</select>";
												
												$cons_list2 = "<select name = 'consumption".$id."'>";
												
												for($t = 0; $t < $num_cons; $t++){
													$con = mysql_result($rs_cons, $t, "drug_consumption_name");
													
													if($con == $consumption){
														$cons_list2 = $cons_list2."<option selected>".$con."</option>";
													}
													else{
														$cons_list2 = $cons_list2."<option>".$con."</option>";
													}
												}
												$cons_list2 = $cons_list2."</select>";
											?>
                                           	
										<form action="prescription.php?visit_id=<?php echo $visit_id?>" method="post">
									  		<tr>
    											<td><?php echo $s+1; ?></td>
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
				</tr></form>
                                           <?php }?>
</table>
                                        
                                        
                                        <form action="prescription.php" method="post">
                                        	<table align="center">
                                            	<tr>
                                                	<td>
                                                    <input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
                                                    <input name="pharmacy_doctor" onClick="send_to_pharmacy2(<?php echo $visit_id;?>);unload()" type="button" class="btn btn-large" value="Done" /> </td></tr>
                                            </table>
</form>

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
	window.alert("here");
	var config_url = $('#config_url').val();
	window.open(config_url+"/pharmacy/drugs/"+visit_id,"Popup","height=1200,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100"); 
}


	</script>


                                        