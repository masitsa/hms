<?php 
include '../../classes/class_doctor.php';
$visit_symptoms_id =$_GET['visit_symptoms_id'];

$get_name = new doctor();
$get_namez= $get_name->delete_visit_symptom($visit_symptoms_id);
?>
