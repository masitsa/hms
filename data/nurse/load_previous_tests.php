<?php
session_start();
include '../../classes/class_nurse.php';
$patient_id = $_SESSION['patient_id'];

$get_tests = new nurse();
$get_tests_rs = $get_tests->get_previous_lab_test($patient_id);
$num_rows = mysql_num_rows($get_tests_rs);
//echo $num_rows;

echo"<table width='auto' border='0' align='center'>
<th>Test Name</th>
<th>Test Result</th>
<th>Units</th>
<th>Male L.Limit</th>
<th>Male U.Limit</th>
<th>Female L.Limit</th>
<th>Female U.Limit</th>


";
if ($num_rows >0 ){
for($s = 0; $s <$num_rows; $s++){
	$lab_test_name= mysql_result($get_tests_rs, $s, "lab_test_name");
	$lab_test_units =  mysql_result($get_tests_rs, $s, "lab_test_units");
	$lab_test_malelowerlimit =  mysql_result($get_tests_rs, $s, "lab_test_malelowerlimit");
	$lab_test_malelupperlimit =  mysql_result($get_tests_rs, $s, "lab_test_malelupperlimit");
	 $lab_test_femalelowerlimit = mysql_result($get_tests_rs, $s, "lab_test_femalelowerlimit");
	 $lab_test_femaleupperlimit =  mysql_result($get_tests_rs, $s, "lab_test_femaleupperlimit");
	 $lab_visit_result =  mysql_result($get_tests_rs, $s, "lab_visit_result");
	 $visit_time =  mysql_result($get_tests_rs, $s, "visit_time");
	if($s%2 == 0){
		$bgcolor="#5BA4BB";
	}
	else{
		$bgcolor="#FFFFFF";
	}
	   
echo "
  <tr  bgcolor=".$bgcolor.">
    <td>".$lab_test_name."</td>
    <td>".$lab_visit_result."</td>
    <td>".$lab_test_units."</td>
	<td>".$lab_test_malelowerlimit."</td>
    <td>".$lab_test_malelupperlimit."</td>
    <td>".$lab_test_femalelowerlimit."</td>
	<td>".$lab_test_femaleupperlimit."</td>
	<td>".$visit_time."</td>
 
  </tr>
  </tr>";
  $s = $s++;
	}
	  if ($s >= 4){
	  
	  echo"
	<tr>
    <td><input name='view_more' type='button' value='view_more' onclick='lab_previous(".$patient_id.")' /></td>
  </tr>
	";
 
	}
}
  echo"
</table>";
