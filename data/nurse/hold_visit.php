<?php
session_start();
include '../../classes/class_nurse.php';

$personnel_id = $_SESSION['personnel_id'];

$visit_id = $_GET['visit_id'];

$hold_visit = new nurse();
$hold_visit->set_hold_visit($visit_id,$personnel_id);


?>