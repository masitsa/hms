<?php
include '../../classes/class_nurse.php';

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$medication = $_GET['medication'];
$food_allergies = $_GET['food_allergies'];
$medicine_allergies = $_GET['medicine_allergies'];
$regular_treatment = $_GET['regular_treatment'];
	
$s = new nurse();
$s->save_medication($medication,$patient_id,$food_allergies,$medicine_allergies,$regular_treatment);
		
?>