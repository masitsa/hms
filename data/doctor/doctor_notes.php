<?php
include '../../classes/class_doctor.php';

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$get_medical = new doctor();
$get_medical_rs = $get_medical->get_doctor_notes($patient_id);
$num_rows = mysql_num_rows($get_medical_rs);
//echo $num_rows;
echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Doctor's Notes</p></div>";
if($num_rows > 0){
	$doctor_notes = mysql_result($get_medical_rs, 0, "doctor_notes");
	
echo
'
	 <table align="center">
	 	<tr>
			<td><textarea id="doctor_notes_item" cols="200" rows="4" onkeyup="save_doctor_notes('.$visit_id.')">'.$doctor_notes.'</textarea></td>
         </tr>
	</table>
';
}

else{
echo
'
	 <table align="center">
	 	<tr>
			<td><textarea id="doctor_notes_item" cols="70" rows="4" onkeyup="save_doctor_notes('.$visit_id.')"></textarea></td>
         </tr>
	</table>
';
}
	
?>