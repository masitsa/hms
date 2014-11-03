<?php 
include ("../../classes/class_doctor.php");

$visit_id = $_GET['visit_id'];

$get = new doctor();
$rs = $get->get_diagnosis($visit_id);
$num_rows = mysql_num_rows($rs);
//echo $num_rows;
		
if($num_rows > 0){

	echo
	"
	<div class='navbar-inner2'>
		<p style='text-align:center; color:#0e0efe;'>Diagnosis</p>
	</div>
			<table class='table table-striped table-hover table-condensed'>
				<tr>
					<th>No.</th>
					<th>Code</th>
					<th>Disease</th>
				</tr>";
	
	for($t = 0; $t < $num_rows; $t++){
		$diagnosis_id = mysql_result($rs, $t, "diagnosis_id");
		$name = mysql_result($rs, $t, "diseases_name");
		$code = mysql_result($rs, $t, "diseases_code");
		
		echo "<tr>
				<td>".($t+1)."</td>
				<td>".$code."</td>
				<td>".$name."</td></tr>";
	}
}
?>