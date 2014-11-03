<?php
include "../../classes/class_lab.php";

$visit_id = $_GET['visit_id'];

$update = new Lab;
$update->finish_lab_test($visit_id);
?>