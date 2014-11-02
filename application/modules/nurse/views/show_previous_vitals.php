<?php


$rs = $this->nurse_model->get_previous_vitals($visit_id);
$counter = count($rs);
if(count($rs) > 0){
	echo '

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
			$height = 0;
			$weight = 0;
			$waist = 0;
			$hip = 0;
			$temperature =0;
			$respiration =0;
			$systolic = 0;
			$diastolic =0;
			$oxygen = 0;
			$pulse =0;
			$pain = 0;
			$recNew = $rs1;
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
			if($height > 0)
			{
				$bmi = $weight / ($height * $height);
			}
			else
			{
				$bmi = 0;
			}
			
			if($waist > 0)
			{
				$hwr = $hip / $waist;
			}
			else
			{
				$hwr = 0;
			}
			
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
	
	
	
	echo "</table>";
}
?>