<?php 
session_start();
include '../../classes/connection.php';

$procedure_id =$_GET['procedure_id'];

$sql1 = "DELETE FROM visit_charge WHERE visit_charge_id = $procedure_id";
$save = new Database();
$save->insert($sql1);


?>