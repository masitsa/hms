<?php
session_start();

include("../../classes/class_nurse.php");

$patient_id = $_SESSION['patient_id'];

$get = new nurse();
$rs = $get->get_nurse_notes($patient_id);
$num_rows = mysql_num_rows($rs);
if($num_rows <= 0){
	}
else{ 

$nurse_notes = mysql_result($rs,0,"nurse_notes");

echo $nurse_notes;

}
?>