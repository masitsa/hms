<?php
//session_start();

include("../../classes/class_nurse.php");

$visit_id = $_GET['visit_id'];
$vitals_id = $_GET['vitals_id'];

$get = new nurse;
$rs = $get->get_vitals($visit_id);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	
	for($r = 0; $r < $num_rows; $r++){
		$vital_id = mysql_result($rs, $r, "vital_id");
		
		if($vital_id == 3){
			$waist = mysql_result($rs, $r, "visit_vital_value");
		}
		if($vital_id == 4){
			$hip = mysql_result($rs, $r, "visit_vital_value");
		}
	}
	
	if(($waist != NULL) && ($hip != NULL))
	{
		$hwr = $hip / $waist;
	
		echo "<table style='width: 200px;'>
						<tr class='info'>
							<td>H / W: ".$hwr."</td>
						</tr>
					</table>";
	}
}
?>