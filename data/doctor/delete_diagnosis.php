<?php 
include ("../../classes/class_doctor.php");

$diagnosis_id = $_GET['diagnosis_id'];

if(isset($diagnosis_id)){
	
	$save = new doctor();
	$save->delete_diagnosis_visit($diagnosis_id);
}
?>