<?php 
include '../../classes/class_doctor.php';
$visit_objective_findings_id =$_GET['visit_objective_findings_id'];

$get_name = new doctor();
$get_namez= $get_name->delete_visit_objective_findings($visit_objective_findings_id);
?>
