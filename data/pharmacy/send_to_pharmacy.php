<?php 
include '../../classes/class_prescription.php';

$visit_id = $_GET['visit_id'];
$page = $_GET['page'];

$save = new prescription;
$save->send_to_pharmacy($visit_id, $page);
		
		?>