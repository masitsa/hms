<?php 
include '../../classes/class_prescription.php';

$visit_id = $_GET['v_id'];

$prescription = new prescription();
$rs = $prescription->select_prescription($visit_id);
$num_rows =mysql_num_rows($rs);

echo"
	<div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Prescription</p> <br />
<input type='button' class='btn btn-primary' value='Load Prescription' onclick='window.location.reload()'/></div>
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
			<th>Start Date</th>
			<th>Finish Date</th>
			<th>Allow Substitution</th>
		</tr>";

for($s = 0; $s < $num_rows; $s++){
	$service_charge_id = mysql_result($rs, $s, "drugs_id");
	$frequncy = mysql_result($rs, $s, "drug_times_name");
	$id = mysql_result($rs, $s, "prescription_id");
	$date1 = mysql_result($rs, $s, "prescription_startdate");
	$date2 = mysql_result($rs, $s, "prescription_finishdate");
	$sub = mysql_result($rs, $s, "prescription_substitution");
	$duration = mysql_result($rs, $s, "drug_duration_name");
	$consumption = mysql_result($rs, $s, "drug_consumption_name");
	$quantity = mysql_result($rs, $s, "prescription_quantity");
	$medicine = mysql_result($rs, $s, "drugs_name");
	
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
	echo"
		<tr>
			<td>".($s+1)."</td>
			<td>".$medicine."</td>
			<td>".$dose."</td>
			<td>".$doseunit."</td>
			<td>".$consumption."</td>
			<td>".$quantity."</td>
			<td>".$frequncy."</td>
			<td>".$duration."</td>
			<td>".$date1."</td>
			<td>".$date2."</td>
			<td>".$sub."</td>
		</tr>";
}
echo "</table>";
?>