<?php
session_start();
include "../../classes/class_pharmacy.php";
$visit_id = $_SESSION['visit_id'];
$drug_id = $_GET['drugs_id'];
$consumption = $_GET['consumption'];
$units = $_GET['units'];
$quantity = $_GET['quantity'];
$times = $_GET['times'];
$duration = $_GET['duration'];
$instructions = $_GET['instructions'];
$warnings = $_GET['warnings'];
$for = $_GET['for'];
$days = $_GET['days'];
$prescription_id = $_GET['prescription_id'];
$drug_qty = $_GET['drug_qty'];

//check for previous consumption methods
$prev_consumption = new pharmacy;
$prev_consumption_rs = $prev_consumption->get_prev_consumption($prescription_id);
$num_prev_consumption = mysql_num_rows($prev_consumption_rs);
//echo $num_prev_consumption;
if($num_prev_consumption > 0){
	
	$update = new pharmacy;
	$update->modify_drug_type_consumption($prescription_id, $consumption, $units, $quantity, $times, $duration, $instructions, $warnings, $for, $days,$drug_qty);
}

else{
	
	$save = new pharmacy;
	$save->save_drug_type_consumption($drug_id, $consumption, $units, $quantity, $times, $duration, $instructions, $warnings, $for, $days, $prescription_id,$drug_qty);
}
?>