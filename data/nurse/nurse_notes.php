<?php
include '../../classes/class_nurse.php';

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$get_medical = new nurse();
$get_medical_rs = $get_medical->get_nurse_notes($patient_id);
$num_rows = mysql_num_rows($get_medical_rs);
//echo $num_rows;
echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Nurse's Notes</p></div>";
if($num_rows > 0){
	$nurse_notes = mysql_result($get_medical_rs, 0, "nurse_notes");
	
echo
'
	 <table align="center">
	 	<tr>
			<td><textarea id="nurse_notes_item" cols="200" rows="4" onkeyup="save_nurse_notes('.$visit_id.')">'.$nurse_notes.'</textarea></td>
         </tr>
	</table>
';
}

else{
echo
'
	 <table align="center">
	 	<tr>
			<td><textarea id="nurse_notes_item" cols="70" rows="4" onkeyup="save_nurse_notes('.$visit_id.')"></textarea></td>
         </tr>
	</table>
';
}
	
?>