<?php
include("../../classes/class_doctor.php");

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

if(($patient_id < 0) || ($patient_id == NULL)){
	
	echo "Please select a patient";
}

else{
	$doc_notes = $_GET['notes'];

	$save = new doctor;
	$save->save_doctor_notes($doc_notes, $patient_id);
}
?>