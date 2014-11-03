<?php
session_start();
$visit_id = $_SESSION['visit_id'];
include "../../classes/class_nurse.php";
$get = new nurse;
$rs_vitals = $get->get_groups();
$num_vitals = mysql_num_rows($rs_vitals);

for($i = 0; $i < $num_vitals; $i++){
	$group_name = mysql_result($rs_vitals, $i, "vitals_group_name");
	$group_id = mysql_result($rs_vitals, $i, "vitals_group_id");
	
	if($group_name != "---none---"){
		echo "<div class='patients_history_head_inner'>".$group_name."</div>";
	}
	
	if($group_name == "Blood Pressure"){
	
		$get4 = new nurse;
		$rs3 = $get4->get_vitals4($group_id);
		$num_rows2 = mysql_num_rows($rs3);
	}
	
	else{
	
		$get4 = new nurse;
		$rs3 = $get4->get_vitals2($group_id);
		$num_rows2 = mysql_num_rows($rs3);
	}
	
	if($num_rows2 > 0){
		
		for($l = 0; $l < $num_rows2; $l++){
			
			$vitals_name = mysql_result($rs3, $l, "vitals_name");
			$vitals_id = mysql_result($rs3, $l, "vitals_id");
			
			if($group_name == "---none---"){
				echo "<div class='patients_history_head_inner'>".$vitals_name."</div>";
			}
			
			echo "
				<table align = 'center'>
					<tr>
						<td>".$vitals_name.": <input type='text' id='vital".$vitals_id."' onkeyup = 'save_vital(".$vitals_id.")'/></td>";
		
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
					"
					<td><div class='ui-widget' id='display".$vitals_id."'><div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'> 
						<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
						<strong>Normal</strong> ".$visit_vital_value."</p>
						</div></div></td>
					</tr>
					</table>
					";
			}
			
			else{
					if(($visit_vital_value < $lower_limit) || ($visit_vital_value > $upper_limit)){
						echo
						"
							<td><div class='ui-widget' id='display".$vitals_id."'><div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'> 
								<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> 
								<strong>Alert!</strong> ".$visit_vital_value."</p>
							</div></div></td>
						</tr>
						</table>
						";
					}
			
					else{
						echo
						"
							<td><div class='ui-widget' id='display".$vitals_id."'><div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'> 
							<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
							<strong>Normal</strong> ".$visit_vital_value."</p>
							</div></div></td>
						</tr>
						</table>
						";
					}
				}
		}
			else{							
				echo"
						<td><div class='ui-widget' id='display".$vitals_id."'></div></td>
					</tr>
				</table>";
			}
		}
	}
	
}


?>