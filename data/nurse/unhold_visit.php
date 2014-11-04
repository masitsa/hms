<?php
session_start();
include '../../classes/class_nurse.php';

$personnel_id =  $_SESSION['personnel_id'];

$visit_id = $_GET['visit_id'];

$unhold_visit = new nurse();
$unhold_visit->unset_hold_visit($visit_id,$personnel_id);


?>

