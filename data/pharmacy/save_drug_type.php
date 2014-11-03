<?php
include "../../classes/class_pharmacy.php";

$type = $_GET['type'];
$drug_id = $_GET['drug_id'];

$update = new pharmacy;
$update->save_drug_type($type, $drug_id);
?>