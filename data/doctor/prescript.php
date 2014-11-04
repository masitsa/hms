<?php session_start();
include '../../classes/class_prescription.php';

$visit_id = $_GET['visit_id'];
$delete = $_GET['prescription_id'];
$passed_value = $_GET['passed_value'];
$service_charge_id = $_GET['service_charge_id'];

	$temp_visit_charge_amount="";
	$total_visit_charge_amount="";
if(!empty($service_charge_id)){
	$get = new prescription;
	$rs2 = $get->get_drug($service_charge_id);
	
	$s = 0;
	$drug_type_id = mysql_result($rs2, $s, "drug_type_id");
	$admin_route_id = mysql_result($rs2, $s, "drug_administration_route_id");
	$drug_dose = mysql_result($rs2, $s, "drugs_dose");
	$dose_unit_id = mysql_result($rs2, $s, "drug_dose_unit_id");
	
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
			$dose_unit = mysql_result($rs3, 0, "drug_dose_unit_name");
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
}

if(!empty($delete)){
	
	$visit_charge_id = $_GET['visit_charge_id'];
	$del = new prescription();
	$del->delete_visit_charge($visit_charge_id);
	
	$del = new prescription();
	$del->delete_prescription($delete);
	
	?>
    <script type="text/javascript">
		window.location.href = "prescription.php?visit_id=<?php echo $visit_id?>";
	</script>
    <?php
}
if($_REQUEST['submit']){
        $varpassed_value = $_POST['passed_value'];
		$varsubstitution = $_POST['substitution'];
		$varform = $_POST['form'];
		$varadminroute = $_POST['adminroute'];
		$vardate = $_POST['date'];
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
		
		if(empty($varsubstitution)){
			$varsubstitution = "No";
		}
		$date = date("Y-m-d"); 
		$time = date("H:i:s");
	
		$times = new prescription;
$times_rs11 = $times->get_drug_time($varx);
$num_times11 = mysql_num_rows($times_rs11);
$numerical_value11 = mysql_result($times_rs11, 0, "numerical_value");

     $your_date = strtotime($varfinishdate);
	 $your_date1 = strtotime($vardate);
     $datediff = $your_date - $your_date1;
    $qtty= floor($datediff/(60*60*24));
	
	$quantity_fin=$qtty*$numerical_value11*$quantity;
	
	$sql1 = "SELECT visit_type, visit_id FROM visit WHERE visit_id = '$visit_id'";
//echo $sql1;
$v_type = new Database();
$rs21 =$v_type->select($sql1);
$num_type= mysql_num_rows($rs21);
$visit_t = mysql_result($rs21, 0 ,"visit_type");

		$prescription = new prescription;
		$prescription->save_visit_charge($varpassed_value,$v_id, $date, $time, $quantity_fin,$visit_t);
		
		$get = new prescription;
		$visit_charge_id = $get->get_visit_charge_id($v_id, $date, $time);
		
		$prescription = new prescription;
		$prescription->save_prescription($varsubstitution, $vardate, $varfinishdate, $varx, $visit_charge_id, $duration, $consumption,$quantity_fin);
		
		?>
        <script type="text/javascript">
			window.location.href = "prescription.php?visit_id=<?php echo $v_id;?>";
		</script>
        <?php
	}
	
//if the update button is clicked
if($_REQUEST['update']){
	
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
$prescription = new prescription();
$rs = $prescription->select_prescription($visit_id);
$num_rows =mysql_num_rows($rs);

$forms = new prescription;
$rs_forms = $forms->get_drug_forms();
$num_forms = mysql_num_rows($rs_forms);

if($num_forms > 0){
	
	$xray = "'";
	for($i = 0; $i < $num_forms; $i++){

		if($i == ($num_forms-1)){
	
			$xray = $xray.mysql_result($rs_forms, $i, "drug_type_name")."'";
		}

		else{
	
			$xray = $xray.mysql_result($rs_forms, $i, "drug_type_name")."','";
		}
	}
}

$admin = new prescription;
$rs_admin = $admin->get_admin_route();
$num_admin = mysql_num_rows($rs_admin);

if($num_admin > 0){
	
	$xray2 = "'";
	for($i = 0; $i < $num_admin; $i++){

		if($i == ($num_admin-1)){
	
			$xray2 = $xray2.mysql_result($rs_admin, $i, "drug_administration_route_name")."'";
		}

		else{
	
			$xray2 = $xray2.mysql_result($rs_admin, $i, "drug_administration_route_name")."','";
		}
	}
}

$units = new prescription;
$rs_units = $units->get_dose_unit();
$num_units = mysql_num_rows($rs_units);

if($num_units > 0){
	
	$xray3 = "'";
	for($i = 0; $i < $num_units; $i++){

		if($i == ($num_units-1)){
	
			$xray3 = $xray3.mysql_result($rs_units, $i, "drug_dose_unit_name")."'";
		}

		else{
	
			$xray3 = $xray3.mysql_result($rs_units, $i, "drug_dose_unit_name")."','";
		}
	}
}

//get drug times
$times = new prescription;
$times_rs = $times->get_drug_times();
$num_times = mysql_num_rows($times_rs);
$time_list = "<select name = 'x'>";

for($t = 0; $t < $num_times; $t++){
	$time = mysql_result($times_rs, $t, "drug_times_name");
	$time_list = $time_list."<option>".$time."</option>";
}
$time_list = $time_list."</select>";

//get consumption
$forms = new prescription;
$rs_cons = $forms->get_consumption();
$num_cons = mysql_num_rows($rs_cons);
$cons_list = "<select name = 'consumption'>";

for($t = 0; $t < $num_cons; $t++){
	$con = mysql_result($rs_cons, $t, "drug_consumption_name");
	$cons_list = $cons_list."<option>".$con."</option>";
}
$cons_list = $cons_list."</select>";

//get durations
$duration = new prescription;
$duration_rs = $duration->get_drug_duration();
$num_duration = mysql_num_rows($duration_rs);
$duration_list = "<select name = 'duration'>";
for($t = 0; $t < $num_duration; $t++){
	$durations = mysql_result($duration_rs, $t, "drug_duration_name");
	$duration_list = $duration_list."<option>".$durations."</option>";
}
$duration_list = $duration_list."</select>";

//warnings
$warnings = new prescription;
$warnings_rs = $warnings->get_warnings();
$num_warnings = mysql_num_rows($warnings_rs);

$warning = "'";
for($i = 0; $i < $num_warnings; $i++){

	if($i == ($num_warnings-1)){
	
		$warning = $warning.mysql_result($warnings_rs, $i, "warnings_name")."'";
	}

	else{
	
		$warning = $warning.mysql_result($warnings_rs, $i, "warnings_name")."','";
	}
}

//instructions
$instructions = new prescription;
$instructions_rs = $warnings->get_instructions();
$num_instructions = mysql_num_rows($instructions_rs);

$inst = "'";
for($i = 0; $i < $num_instructions; $i++){

	if($i == ($num_instructions-1)){
	
		$inst = $inst.mysql_result($instructions_rs, $i, "instructions_name")."'";
	}

	else{
	
		$inst = $inst.mysql_result($instructions_rs, $i, "instructions_name")."','";
	}
}

if(isset($_POST['dispense'])){
?>
	<!--<script> alert('1234');</script>-->
<?php	}
?><div id=""> </div>
	<div class='navbar-inner2'>
		<p style='text-align:center; color:#0e0efe;'>Medication List</p>
	</div>
                                       <table class='table table-striped table-hover table-condensed'>
 											 <tr>
                                            
   												<th>No.</th>
                                                <th></th>
                                                  <th></th>
    											<th>Medicine:</th>
                                                <th>Unit Price </th>
                                                <th>Total Price </th>
    											<th>Dose</th>
   											 	<th>Units Given</th>
    											<th>Method</th>
    											<th>Quantity to take</th>
    											<th>Times</th>
    											<th>Duration</th>
   											 	<th>Number of Days</th>
    											<th>Finish Date</th>
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
												$quantityxx = mysql_result($rs, $s, "prescription_quantity");
												$medicine = mysql_result($rs, $s, "drugs_name");
												$charge = mysql_result($rs, $s, "drugs_charge");
												$visit_charge_id=mysql_result($rs, $s, "visit_charge_id");
												$units_given=mysql_result($rs, $s, "units_given");
												
									
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
										
													
													$getf = new prescription;
													$rsf = $getf->select_invoice_drugs($visit_id,$service_charge_id);
													$num_rowsf = mysql_num_rows($rsf);
													$sum_units = mysql_result($rsf, 0, "sum(visit_charge_units)");
													
										$amoun=$charge* $sum_units ;
											
										$total_visit_charge_amount=$amoun+$temp_visit_charge_amount;
	$temp_visit_charge_amount=$total_visit_charge_amount; 
	?>								<form action="prescript.php" method="post">
									  		<tr>
                                           
    											<td><?php echo $s+1; ?></td>
                                                <td>
                                                	<div class='btn-toolbar'>
                                                    	<div class='btn-group'>
                                                        	<a href="http://sagana/hms/data/doctor/delete_prescritpion1.php?prescription_id=<?php echo $id;?>&visit_id=<?php echo $visit_id?>&visit_charge_id=<?php echo $visit_charge_id?>"><i class='icon-remove'></i></a>
                                                       	</div>
                                                  </div>
                                              </td>
                                                 <td><?php
												 $date='date4'.$id; $datepicker3='datepicker3'.$id; $quantity='quantity'.$id; $units_given='units_given'.$id;											 
												 ?>
                                                 	<input name="update" type="submit" value="Update" />
                                                    <input name="dispense" id="dispense" type="submit" value="Dispense" 
                                                    onclick="dispense(<?php echo $id;?>,<?php echo $visit_id;?>,'<?php echo $date?>','<?php echo $datepicker3?>','<?php echo $quantity?>','<?php echo $units_given?>');"  />
                                                 	<input type="hidden" name="hidden_id" value="<?php echo $id?>" />
                                                    <input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
                                                 </td>
    											<td width="200px"><a href="#" onclick=""><?php echo $medicine;?> </a></td>
                                                 <td width="150px"> <?php echo $charge ; ?></td>
                                                <td width="150px"> <?php echo $amoun ; ?></td>
    											<td><?php echo '';?></td>
                                                <td><input type="text" name="units_given<?php echo $id?>" id="units_given<?php echo $id?>" required="required" placeholder="units given" value="<?php echo $sum_units; ?>"  /></td>
    											<td><?php echo $cons_list2; ?></td>
                                                <td><input type="text" id="quantity<?php echo $id?>" name="quantity<?php echo $id?>"  autocomplete="off" value="<?php echo $quantityxx?>"/></td>
    											<td><?php echo $time_list2; ?></td>
    											<td><?php echo $duration_list2; ?></td>
                                        		<td><input type="text" id="datepicker3<?php echo $id?>" name="date3<?php echo $id?>"  autocomplete="off" value="<?php echo $date1?>"/></td>
                                        		<td><input type="text" id="date4<?php echo $id?>" name="date4<?php echo $id?>"  autocomplete="off" value="<?php echo $date2?>"/></td>
                                                <td><?php echo $substitution?></td>
                                                
				</tr>
                <tr>
                
                
                </form>
                                           <?php }?>
                                           
                                           					<th> </th>
    											<th> </th>
                                                <th><?php echo $total_visit_charge_amount;?>  </th>
    											<th> </th>
   											 	<th> </th>
    											<th> </th>
    											<th> </th>
    											<th> </th>
    											<th> </th>
   											 	<th> </th>
    											<th> </th>
                                                <th> </th>
                </tr>
</table>
                                        
                                        
                                        <form action="prescription.php" method="post">
                                        	<table align="center">
                                            	<tr>
                                                	<td>
                                                    <input type="hidden" name="v_id" value="<?php echo $visit_id;?>"/>
                                                    <input name="pharmacy_doctor" onClick="send_to_pharmacy21(<?php echo $visit_id;?>);unload()" type="button" class="btn btn-large" value="Done/Send To Accounts" /> </td></tr>
                                            </table>
</form>
                                        </div>
                                        </div>
                                        
                                        </div>
                                        </div>
                                        </div>
                                        
</body>
<style type='text/css'>

.clear{
	clear:both;
}

.row-fluid {
  width: 100%;
  *zoom: 1;
}

.row-fluid:before,
.row-fluid:after {
  display: table;
  line-height: 0;
  content: "";
}

.row-fluid:after {
  clear: both;
}

.row-fluid [class*="span"] {
  display: block;
  float: left;
  width: 100%;
  min-height: 30px;
  margin-left: 2.127659574468085%;
  *margin-left: 2.074468085106383%;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}

.row-fluid [class*="span"]:first-child {
  margin-left: 0;
}

.row-fluid .span12 {
  width: 100%;
  *width: 99.94680851063829%;
}

.row-fluid .span11 {
  width: 91.48936170212765%;
  *width: 91.43617021276594%;
}

.row-fluid .span10 {
  width: 82.97872340425532%;
  *width: 82.92553191489361%;
}

.row-fluid .span9 {
  width: 74.46808510638297%;
  *width: 74.41489361702126%;
}

.row-fluid .span8 {
  width: 65.95744680851064%;
  *width: 65.90425531914893%;
}

.row-fluid .span7 {
  width: 57.44680851063829%;
  *width: 57.39361702127659%;
}

.row-fluid .span6 {
  width: 48.93617021276595%;
  *width: 48.88297872340425%;
}

.row-fluid .span5 {
  width: 40.42553191489362%;
  *width: 40.37234042553192%;
}

.row-fluid .span4 {
  width: 31.914893617021278%;
  *width: 31.861702127659576%;
}

.row-fluid .span3 {
  width: 23.404255319148934%;
  *width: 23.351063829787233%;
}

.row-fluid .span2 {
  width: 14.893617021276595%;
  *width: 14.840425531914894%;
}

.row-fluid .span1 {
  width: 6.382978723404255%;
  *width: 6.329787234042553%;
}

.row-fluid .offset12 {
  margin-left: 104.25531914893617%;
  *margin-left: 104.14893617021275%;
}

.row-fluid .offset12:first-child {
  margin-left: 102.12765957446808%;
  *margin-left: 102.02127659574467%;
}

.row-fluid .offset11 {
  margin-left: 95.74468085106382%;
  *margin-left: 95.6382978723404%;
}

.row-fluid .offset11:first-child {
  margin-left: 93.61702127659574%;
  *margin-left: 93.51063829787232%;
}

.row-fluid .offset10 {
  margin-left: 87.23404255319149%;
  *margin-left: 87.12765957446807%;
}

.row-fluid .offset10:first-child {
  margin-left: 85.1063829787234%;
  *margin-left: 84.99999999999999%;
}

.row-fluid .offset9 {
  margin-left: 78.72340425531914%;
  *margin-left: 78.61702127659572%;
}

.row-fluid .offset9:first-child {
  margin-left: 76.59574468085106%;
  *margin-left: 76.48936170212764%;
}

.row-fluid .offset8 {
  margin-left: 70.2127659574468%;
  *margin-left: 70.10638297872339%;
}

.row-fluid .offset8:first-child {
  margin-left: 68.08510638297872%;
  *margin-left: 67.9787234042553%;
}

.row-fluid .offset7 {
  margin-left: 61.70212765957446%;
  *margin-left: 61.59574468085106%;
}

.row-fluid .offset7:first-child {
  margin-left: 59.574468085106375%;
  *margin-left: 59.46808510638297%;
}

.row-fluid .offset6 {
  margin-left: 53.191489361702125%;
  *margin-left: 53.085106382978715%;
}

.row-fluid .offset6:first-child {
  margin-left: 51.063829787234035%;
  *margin-left: 50.95744680851063%;
}

.row-fluid .offset5 {
  margin-left: 44.68085106382979%;
  *margin-left: 44.57446808510638%;
}

.row-fluid .offset5:first-child {
  margin-left: 42.5531914893617%;
  *margin-left: 42.4468085106383%;
}

.row-fluid .offset4 {
  margin-left: 36.170212765957444%;
  *margin-left: 36.06382978723405%;
}




.row-fluid .offset4:first-child {
  margin-left: 34.04255319148936%;
  *margin-left: 33.93617021276596%;
}

.row-fluid .offset3 {
  margin-left: 27.659574468085104%;
  *margin-left: 27.5531914893617%;
}

.row-fluid .offset3:first-child {
  margin-left: 25.53191489361702%;
  *margin-left: 25.425531914893618%;
}

.row-fluid .offset2 {
  margin-left: 19.148936170212764%;
  *margin-left: 19.04255319148936%;
}

.row-fluid .offset2:first-child {
  margin-left: 17.02127659574468%;
  *margin-left: 16.914893617021278%;
}

.row-fluid .offset1 {
  margin-left: 10.638297872340425%;
  *margin-left: 10.53191489361702%;
}

.row-fluid .offset1:first-child {
  margin-left: 8.51063829787234%;
  *margin-left: 8.404255319148938%;
}

[class*="span"].hide,
.row-fluid [class*="span"].hide {
  display: none;
}

[class*="span"].pull-right,
.row-fluid [class*="span"].pull-right {
  float: right;
}

.icon-white,
.nav-tabs > .active > a > [class^="icon-"],
.nav-tabs > .active > a > [class*=" icon-"],
.nav-pills > .active > a > [class^="icon-"],
.nav-pills > .active > a > [class*=" icon-"],
.nav-list > .active > a > [class^="icon-"],
.nav-list > .active > a > [class*=" icon-"],
.navbar-inverse .nav > .active > a > [class^="icon-"],
.navbar-inverse .nav > .active > a > [class*=" icon-"],
.dropdown-menu > li > a:hover > [class^="icon-"],
.dropdown-menu > li > a:hover > [class*=" icon-"],
.dropdown-menu > .active > a > [class^="icon-"],
.dropdown-menu > .active > a > [class*=" icon-"] {
  background-image: url(../../../img/glyphicons-halflings-white.png);
}

.nav {
  margin-bottom: 20px;
  margin-left: 0;
  list-style: none;
}

.nav > li > a {
  display: block;
}

.nav > li > a:hover {
  text-decoration: none;
  background-color: #5bbed8;
}

.nav > .pull-right {
  float: right;
}

.nav-header {
  display: block;
  padding: 3px 15px;
  font-size: 14px;
  font-weight: bold;
  line-height: 20px;
  color: #022e51;
  text-transform: uppercase;
}

.nav li + .nav-header {
  margin-top: 9px;
}

.nav-list {
  padding-right: 15px;
  padding-left: 15px;
  margin-bottom: 0;
}

.nav-list > li > a,
.nav-list {
  margin-right: -15px;
  margin-left: -15px;
}

.nav-list > li > a {
  padding: 3px 15px;
}

.nav-list > .active > a,
.nav-list > .active > a:hover {
  color: #0CF;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
  background-color: #5bbed8;
}

.nav-list [class^="icon-"] {
  margin-right: 2px;
}

.nav-list .divider {
  *width: 100%;
  height: 1px;
  margin: 9px 1px;
  *margin: -5px 0 5px;
  overflow: hidden;
  background-color: #e5e5e5;
  border-bottom: 1px solid #ffffff;
}

.navbar-inner2 {
  min-height: 40px;
  padding-right: 20px;
  padding-left: 20px;
  background-color: #fafafa;
  background-image: -moz-linear-gradient(top, #5696ff, #2474f8);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5696ff), to(#2474f8));
  background-image: -webkit-linear-gradient(top, #5696ff, #2474f8);
  background-image: -o-linear-gradient(top, #5696ff, #2474f8);
  background-image: linear-gradient(to bottom, #5696ff, #2474f8);
  background-repeat: repeat-x;
  border: 1px solid #d4d4d4;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#5696ff', endColorstr='#2474f8', GradientType=0);
  *zoom: 1;
  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
     -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
          box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
}

.navbar-inner:before,
.navbar-inner:after {
  display: table;
  line-height: 0;
  content: "";
}

.navbar-inner:after {
  clear: both;
}

h1, h2, h3 {
	margin: 0;
	padding: 0;
	letter-spacing: -4px;
	text-transform: lowercase;
	font-family: 'Abel', sans-serif;
	font-weight: 400;
	color: #262626;
}

h1 {
	font-size: 2em;
}

h2 {
	padding-bottom: 20px;
	font-size: 2.8em;
}

h3 {
	font-size: 1.6em;
}

p, ol {
}

ul, ol {

}

a {
	color: #DC483E;
}

a:hover {
}

#wrapper {
	background: #FFFFFF;
}

.container {
	width: 1000px;
	margin: 0px auto;
}

/* Header */

#header {
	width: 960px;
	height: 210px;
	margin: 0px auto 20px auto;
	padding: 0px 20px;
}

/* Logo */

#logo {
	float: left;
	width: 270px;
	height: 210px;
	margin: 0px;
	padding: 0px;
	background:url(../../images/logo-bg.png) no-repeat left top;
	color: #FFFFFF;
}

#logo h1, #logo p {
}

#logo h1 {
	padding: 10px 0px 0px 0px;
	letter-spacing: -2px;
	text-align: center;
	font-size: 4.8em;
}

#logo h1 a {
	color: #FFFFFF;
}

#logo p {
	margin: 0;
	padding: 0px 0 0 0px;
	letter-spacing: -1px;
	text-align: center;
	text-transform: lowercase;
	font-size: 20px;
	color: #FFFFFF;
}

#logo p a {
	color: #FFFFFF;
}

#logo a {
	border: none;
	background: none;
	text-decoration: none;
	color: #000000;
}

#footer {
	overflow: hidden;
	height: 100px;
	background: #1E5148 url(../../images/wrapper-bg.png) repeat;
}

#footer p {
	margin: 0px;
	padding: 40px 0px 0px 0px;
	text-align: center;
	text-transform: lowercase;
	font-size: 16px;
	color: #45776E;
}

#footer a {
	text-decoration: none;
	color: #45776E;
}
</style>
</html>