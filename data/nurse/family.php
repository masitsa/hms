<?php
session_start();
include "../../classes/class_nurse.php";

$condition = $_GET['condition'];
$family = $_GET['family'];
$visit_id = $_GET['visit_id'];
$status = $_GET['status'];

$get2 = new nurse;
$rs2 = $get2->get_patient_id($visit_id);
$patient_id = mysql_result($rs2, 0, "patient_id");

if($status == "active"){
	
	$check = new nurse();
	$id_rs = $check->check_family_member($patient_id, $family);
	$num_check = mysql_num_rows($id_rs);

	if($num_check <= 0){
	
		$save = new nurse();
		$save->save_family_member($visit_id, $family);
	}
	
	$check2 = new nurse();
	$family_history_rs = $check2->check_history($patient_id, $family, $condition);
	$num_history = mysql_num_rows($family_history_rs);
	
	if($num_history == 0){
		
		$save2 = new nurse();
		$save2->save_family_history($visit_id, $family, $condition);
		echo "Saved";
	}
	
	else{
		
		echo "The history has already been registered";
	}
}

else{
	$history_id = $_GET['history'];
	$delete = new nurse();
	$delete->delete_history($history_id);
	echo "The history has been delete";
}
?>