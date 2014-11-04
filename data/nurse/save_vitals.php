<?php
session_start();

include("../../classes/class_nurse.php");

$visit_id = $_GET['visit_id'];
$vital = $_GET['vital'];
$vital_id = $_GET['vital_id'];

$save = new nurse;
$save->save_vitals($vital, $visit_id, $vital_id);

?>