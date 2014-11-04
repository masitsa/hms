<?php

include '../../classes/class_doctor.php';

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_objective_findings($visit_id);
$num_rows = mysql_num_rows($rs);

$get2 = new doctor;
$rs2 = $get2->get_visit_objective_findings($visit_id);
$num_rows2 = mysql_num_rows($rs2);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Objective Findings <br/><input type='button' class='btn btn-primary' value='Add Objective Findings' onclick='open_objective_findings(".$visit_id.")'/></p></div>";


	
if($num_rows > 0){
	$visit_objective_findings = mysql_result($rs, 0, "visit_objective_findings");
	echo
	"	<table align='left'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms1' disabled='disabled'>"; for($z = 0; $z < $num_rows2; $z++){
		
		$objective_findings_name = mysql_result($rs2, $z, "objective_findings_name");
		$visit_objective_findings_id = mysql_result($rs2, $z, "visit_objective_findings_id");
		$objective_findings_class_name = mysql_result($rs2, $z, "objective_findings_class_name");
		$description= mysql_result($rs2, $z, "description");
		
		
		echo $objective_findings_class_name.":".$objective_findings_name." ->".$description."\n" ;
} echo $visit_objective_findings; echo "
</textarea>
				</td>
			</tr>
		</table>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_objective_findings' onKeyUp='save_objective_findings(".$visit_id.")'>".$visit_objective_findings."</textarea>
				</td>
			</tr>
		</table>
	";
}

else{
	echo
	"		<table align='left'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms' disabled='disabled'>"; for($z = 0; $z < $num_rows2; $z++){
		
		$objective_findings_name = mysql_result($rs2, $z, "objective_findings_name");
		$visit_objective_findings_id = mysql_result($rs2, $z, "visit_objective_findings_id");
		$objective_findings_class_name = mysql_result($rs2, $z, "objective_findings_class_name");
		
		echo $objective_findings_name.":".$objective_findings_class_name." ->".$description."\n" ;
} echo $visit_objective_findings; echo "
</textarea>
				</td>
			</tr>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100'id='visit_objective_findings' onKeyUp='save_objective_findings(".$visit_id.")'>12345</textarea>
				</td>
			</tr>
		</table>
	";
}
?>