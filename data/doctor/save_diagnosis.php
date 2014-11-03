<?php 
include ("../../classes/class_doctor.php");

$visit_id = $_GET['visit_id'];
$disease_id = $_GET['disease_id'];

$save = new doctor();
$save->save_diagnosis($disease_id, $visit_id);
?>