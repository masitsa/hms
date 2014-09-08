<?php


$rs = $this->nurse_model->get_previous_vitals($visit_id);


if(count($rs) > 0){
	echo '
		<div class="navbar-inner"><p style="text-align:center; color:#0e0efe;">Previous Vitals</p></div>

		<table class="table table-striped table-hover table-condensed">
			<tr>
				<th></th>
				<th>Systolic</th>
				<th>Diastolic</th>
				<th>Weight</th>
				<th>Height</th>
				<th>BMI</th>
				<th>Hip</th>
				<th>Waist</th>
				<th>H / W</th>
				<th>Temperature</th>
				<th>Pulse</th>
				<th>Respiration</th>
				<th>Oxygen Saturation</th>
				<th>Pain</th>
			</tr>
	';
	
		foreach ($rs as $rs1):
			$vital_id = $rs1->vital_id;
			$visit_date = $rs1->visit_date;

			if($vital_id == 1){
				$temperature = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 2){
				$respiration = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 3){
				$waist = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 4){
				$hip = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 5){
				$systolic = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 6){
				$diastolic = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 7){
				$pulse = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 8){
				$weight = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 9){
				$height = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 10){
				$pain = $rs1->visit_vital_value;
			}
			
			else if($vital_id == 11){
				$oxygen = $rs1->visit_vital_value;
			}
			$bmi = $weight / ($height * $height);
			$hwr = $hip / $waist;
		endforeach;
		
		
		
		
		echo '
			<tr>
				<td>'.$visit_date.'</td>
				<td>'.$systolic.'</td>
				<td>'.$diastolic.'</td>
				<td>'.$weight.'</td>
				<td>'.$height.'</td>
				<td>'.$bmi.'</td>
				<td>'.$hip.'</td>
				<td>'.$waist.'</td>
				<td>'.$hwr.'</td>
				<td>'.$temperature.'</td>
				<td>'.$pulse.'</td>
				<td>'.$respiration.'</td>
				<td>'.$oxygen.'</td>
				<td>'.$pain.'</td>
			</tr>

		';
	}
	
	echo "</table>";
}
?>