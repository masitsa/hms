<?php

include '../../classes/class_doctor.php';

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_assessment($visit_id);
$num_rows = mysql_num_rows($rs);
	
echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Assessment</p></div>";

if($num_rows > 0){
	$visit_assessment = mysql_result($rs, 0, "visit_assessment");
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_assessment' onKeyUp='save_assessment(".$visit_id.")'>".$visit_assessment."</textarea>
				</td>
			</tr>
		</table>
	";
}

else{
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_assessment' onKeyUp='save_assessment(".$visit_id.")'></textarea>
				</td>
			</tr>
		</table>
	";
}
?>