<?php
//session_start();

include("../../classes/class_nurse.php");

$visit_id = $_GET['visit_id'];
$vitals_id = $_GET['vitals_id'];
	
	//visit_vital
	$visit_vitals = new nurse;
	$visit_vitals_rs = $visit_vitals->get_visit_vitals($visit_id, $vitals_id);
	$num_visit_vitals = mysql_num_rows($visit_vitals_rs);

	if($num_visit_vitals > 0){
	
		//visit_range
		$visit_range = new nurse;
		$visit_range_rs = $visit_range->vitals_range($vitals_id);
		$num_range = mysql_num_rows($visit_range_rs);
		
		$visit_vital_value = mysql_result($visit_vitals_rs, 0, "visit_vital_value");
		
		if($num_range > 0){
				for($k = 0; $k < $num_range; $k++){
			
					$vitals_range_range = mysql_result($visit_range_rs, $k, "vitals_range_range");
					$vitals_range_name = mysql_result($visit_range_rs, $k, "vitals_range_name");
					//echo $vitals_range_range.", ";
					if($vitals_range_name == "Upper Limit"){
					
						if(!empty($vitals_range_range)){
							$upper_limit = $vitals_range_range;
						}
					}
			
					else if($vitals_range_name == "Lower Limit"){
				
						if(!empty($vitals_range_range)){
							$lower_limit = $vitals_range_range;
						}
					}
				}
			}
			else{
				$upper_limit = NULL;
				$lower_limit = NULL;
			}
			
			if(($lower_limit == NULL) || ($upper_limit == NULL)){
					echo
					"<div style='width: 60px;'>
					<table style='width: 60px;'>
						<tr class='info'>
							<td>".$visit_vital_value."</td>
						</tr>
					</table></div>
					";
			}
			
			else{
				if(($visit_vital_value < $lower_limit) || ($visit_vital_value > $upper_limit)){
					echo
					"<div style='width: 60px;'>
					<table style='width: 60px;'>
						<tr class='error'>
							<td>".$visit_vital_value."</td>
						</tr>
					</table></div>
					";
				}
			
				else{
					echo
					"<div style='width: 60px;'>
					<table style='width: 60px;'>
						<tr class='info'>
							<td>".$visit_vital_value."</td>
						</tr>
					</table></div>
					";
				}
			}
	}
?>