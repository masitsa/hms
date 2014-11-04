<?php
session_start();
include "../../classes/class_nurse.php";

$id = $_GET['id'];

$save = new nurse();
$save->delete_vaccine($id);

?>