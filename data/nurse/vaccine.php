<?php 
session_start();
include '../../classes/class_nurse.php';

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$vaccine_id =$_GET['vaccine_id'];
$status = $_GET['status'];

$save = new nurse;
$save->save_vaccines($vaccine_id, $patient_id, $status);

echo "saved";
?>


