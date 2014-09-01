<?php
include '../../classes/class_nurse.php';

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$get_medical = new nurse();
$get_medical_rs = $get_medical->get_medicals($patient_id);
$num_rows = mysql_num_rows($get_medical_rs);
//echo $num_rows;
echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Allergies</p></div>
			<table align='center' class='table table-striped table-hover table-condensed'>";
if($num_rows > 0){
	$food_allergies = mysql_result($get_medical_rs, 0, "food_allergies");
	$medicine_allergies = mysql_result($get_medical_rs, 0, "medicine_allergies");
	$regular_treatment = mysql_result($get_medical_rs, 0, "regular_treatment");
	$recent_medication = mysql_result($get_medical_rs, 0, "medication_name");
	
	echo "
	 <table align='center'>
	 	<tr>
			<td>Food Allergies</td><td><textarea id='food_allergies' cols='100' rows='3'>".$food_allergies."</textarea></td>
			<td>Medicine Allergies</td><td><textarea id='medicine_allergies' cols='100' rows='3'>".$medicine_allergies."</textarea></td>
		</tr>
		<tr>
			<td>Regular Treatment</td><td><textarea id='regular_treatment' cols='100' rows='3'>".$regular_treatment."</textarea></td>
			<td>Recent Medication</td><td><textarea id='medication_description' cols='100' rows='3'>".$recent_medication."</textarea></td>
         </tr>
	</table>
	<table align='center'>
		<tr>
			<td><input type='button' class='btn btn-large' value='Save' onclick='save_medication(".$visit_id.")' /></td>
		</tr>
    </table>
";
}

else{
echo
"
	 <table align='center'>
	 	<tr>
			<td>Food Allergies</td><td><textarea id='food_allergies' cols='100' rows='3'> </textarea></td>
			<td>Medicine Allergies</td><td><textarea id='medicine_allergies' cols='100' rows='3'></textarea></td>
		</tr>
		<tr>
			<td>Regular Treatment</td><td><textarea id='regular_treatment' cols='100' rows='3'></textarea></td>
			<td>Recent Medication</td><td><textarea id='medication_description' cols='100' rows='3'></textarea></td>
         </tr>
	</table>
	<table align='center'>
		<tr>
			<td><input type='button' class='btn btn-large' value='Save' onclick='save_medication(".$visit_id.")' /></td>
		</tr>
    </table>
";
}
	
?>