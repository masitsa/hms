<?php
session_start();
include '../../classes/class_lab.php';
$visit_id = $_SESSION['visit_id'];

$get = new Lab();
$get_rs = $get->get_test_done($visit_id);

?>