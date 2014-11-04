<?php
session_start();
include "../../classes/class_nurse.php";

$id = $_GET['id'];
$sql="delete from surgery where surgery_id=".$id."";
$save = new Database();
$save->insert($sql);
?>