<?php
session_start();
include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get_prescription = new nurse();
$get_prescription_rs = $get_prescription->get_previous_prescription($patient_id);
$num_rows = mysql_num_rows($get_prescription_rs);
//echo $num_rows;


if ($num_rows >0 ){
	echo"<table width='auto' border='0'>
<th>Medicine Name</th>
<th>Dose Units</th>
<th>Prescribed Dose</th>
<th>Start Date</th>
<th>Finish Date</th>
<th>Visit Date</th>

";
for($s = 0; $s <$num_rows; $s++){
	$drugs_name = mysql_result($get_prescription_rs, $s, "drugs_name");
	$dose_unit =  mysql_result($get_prescription_rs, $s, "prescription_dose_unit");
	$prescribed_dose =  mysql_result($get_prescription_rs, $s, "prescription_dose");
	$startdate =  mysql_result($get_prescription_rs, $s, "prescription_date");
	 $finishdate = mysql_result($get_prescription_rs, $s, "prescription_finishdate");
	 $visit_time =  mysql_result($get_prescription_rs, $s, "visit_time");
	 
	if($s%2 == 0){
		$bgcolor="#5BA4BB";
	}
	else{
		$bgcolor="#FFFFFF";
	}
	   
echo "
  <tr  bgcolor=".$bgcolor.">
    <td>".$drugs_name."</td>
    <td>".$dose_unit."</td>
    <td>".$prescribed_dose."</td>
	<td>".$startdate."</td>
    <td>".$finishdate."</td>
    <td>".$visit_time."</td>
 
  </tr>
  </tr>";
  $s = $s++;
	}
	  if ($s >= 4){
	  
	  echo"
	<tr>
    <td><input name='view_more' type='button' value='view_more' onclick='prescription_previous(".$patient_id.")' /></td>
  </tr>
	";
 
	}
}
  echo"
</table>";
