<?php
include "../../classes/class_nurse.php";

$patient_id=$_GET['patient_id'];
$family_id=$_GET['family_id'];
$disease_id=$_GET['disease_id'];

		$save2 = new nurse();
		$save2->disease_family_member($family_id, $patient_id, $disease_id);

?>