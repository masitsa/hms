<?php
session_start();

include("../../classes/class_nurse.php");

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

if(($patient_id < 0) || ($patient_id == NULL)){
	
	echo "Please select a patient";
}

else{
	$nurse_notes = $_GET['notes'];

	$save = new nurse();
	$save->save_nurse_notes($nurse_notes,$patient_id);

}
?>