<?php
session_start();
include '../../classes/connection.php';
$v_procedure_id = $_GET['procedure_id'];
$units = $_GET['units'];
$amount = $_GET['amount'];

$sql ="UPDATE visit_charge SET visit_charge_units ='$units' WHERE visit_charge_id = '$v_procedure_id'";
//echo $sql;
$update = new Database;
$update->select($sql);



?>