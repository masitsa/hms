<?php
session_start();
include "../../classes/class_nurse.php";

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$description = $_GET['description'];
$date = $_GET['date'];
$month = $_GET['month'];

$save = new nurse();
$save->save_surgery($patient_id, $description, $date, $month);

?>