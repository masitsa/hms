<?php

$patient_id = $this->nurse_model->get_patient_id($visit_id);


$get_medical_rs = $this->nurse_model->get_doctor_notes($patient_id);
$num_rows = count($get_medical_rs);
//echo $num_rows;

if($num_rows > 0){
	foreach ($get_medical_rs as $key2) :
		$doctor_notes = $key2->doctor_notes;
	endforeach;
	
echo
'
	 <table align="center">
	 	<tr>
			<td><textarea id="doctor_notes_item" rows="10" cols="100" class="form-control col-md-6" onkeyup="save_doctor_notes('.$visit_id.')">'.$doctor_notes.'</textarea></td>
         </tr>
	</table>
';
}

else{
echo

'
	 <table align="center">
	 	<tr>
			<td><textarea id="doctor_notes_item" rows="10" cols="100" class="form-control col-md-6" onkeyup="save_doctor_notes('.$visit_id.')"></textarea></td>
         </tr>
	</table>
';
}
	
?>
