<?php

$rs = $this->nurse_model->get_vitals($visit_id);


if(count($rs) > 0){
	
	foreach ($rs as $rs1):
		$vital_id = $rs1->vital_id;
		
		if($vital_id == 8){
			$weight = $rs1->visit_vital_value;
		}
		if($vital_id == 9){
			$height = $rs1->visit_vital_value;
		}
	endforeach;
	
	if(($weight != NULL) && ($height != NULL))
	{
		$bmi = $weight / ($height * $height);
	
		echo "<table style='width: 200px;'>
						<tr class='info'>
							<td>BMI: ".$bmi."</td>
						</tr>
					</table>";
	}
}
?>