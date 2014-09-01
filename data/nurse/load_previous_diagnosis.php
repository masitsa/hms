<?php
session_start();
include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get_diagnosis = new nurse();
$get_diagnosis_rs = $get_diagnosis->get_previous_diagnosis($patient_id);
$num_rows = mysql_num_rows($get_diagnosis_rs);
//echo $num_rows;


if ($num_rows > 0  ){
echo"<table width='auto' border='0' align='center'>

<th>Diagnoised Disease</th>
<th>Visit Date</th>

";
for($s = 0; $s <$num_rows; $s++){
	$disease_name= mysql_result($get_diagnosis_rs , $s, "diseases_name");
	$visit_date =  mysql_result($get_diagnosis_rs , $s, "visit_time");

	if($s%2 == 0){
		$bgcolor="#5BA4BB";
	}
	else{
		$bgcolor="#FFFFFF";
	}
	   
echo "
  <tr  bgcolor=".$bgcolor.">
    <td>".$disease_name."</td>
    <td>".$visit_date."</td>
	
 
  </tr>
  "; 
  $s = $s++;
	}
	  if ($s >= 4){
	  
	  echo"
	<tr>
    <td><input name='view_more' type='button' value='view_more' onclick='diagnosis_previous(".$patient_id.")' /></td>
  </tr>
	";
	}
}
  echo"
</table>";
