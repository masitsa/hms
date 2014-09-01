<?php
session_start();
include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get_procedures = new nurse();
$get_procedures_rs = $get_procedures->get_previous_procedures($patient_id);
$num_rows = mysql_num_rows($get_procedures_rs);
//echo $num_rows;


if ($num_rows >0 ){
	echo"<table width='auto' border='0' align='center'>

<th>Procedure</th>
<th>Units Done</th>
<th>Visit Date</th>

";
for($s = 0; $s < $num_rows; $s++){
	$procedure_name= mysql_result($get_procedures_rs , $s, "procedures");
	$units =  mysql_result($get_procedures_rs , $s, "units");
	$visit_date =  mysql_result($get_procedures_rs , $s, "visit_time");

	if($s%2 == 0){
		$bgcolor="#5BA4BB";
	}
	else{
		$bgcolor="#FFFFFF";
	}
	   
echo "
  <tr  bgcolor=".$bgcolor.">
    <td>".$procedure_name."</td>
    <td>".$units."</td>
	<td>".$visit_date."</td>
 
  </tr>";

 $s = $s++;
	}
	  if ($s >= 4){
	  
	  echo"
	<tr>
    <td><input name='view_more' type='button' value='view_more' onclick='procedures_previous(".$patient_id.")' /></td>
  </tr>
	";
	  }
}
  echo"
</table>";
