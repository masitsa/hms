<?php


$rs = $this->nurse_model->get_symptoms($visit_id);
$num_rows = count($rs);

$rs2 = $this->nurse_model->get_visit_symptoms($visit_id);
$num_rows2 = count($rs2);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'><input type='button' class='btn btn-primary' value='Add Symptoms' onclick='open_symptoms(".$visit_id.")'/></p></div>";


	
if($num_rows > 0){
	foreach ($rs as $key1):
	$visit_symptoms = $key1->visit_symptoms;
	endforeach;
	echo
	"
	<table align='left'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' class='form-control' id='visit_symptoms1' disabled='disabled'>"; 
					$z=0;
					foreach ($rs2 as $key):	
						$count=$z+1;
						$symptoms_name = $key->symptoms_name;
						$status_name = $key->status_name;
						$visit_symptoms_id = $key->visit_symptoms_id;
						$description= $key->description;
						
						echo $symptoms_name." ->".$description."\n" ;
					endforeach;
					echo $visit_symptoms; echo "
					</textarea>
				</td>
			</tr>
		</table>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' placeholder='Type Additional Symptoms Here' id='visit_symptoms' onKeyUp='save_symptoms(".$visit_id.")'>".$visit_symptoms."</textarea>
				</td>
			</tr>
		</table>
	";
}

else{
	echo
	"<table align='left'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' id='visit_symptoms1' disabled='disabled'>"; 
					$z=0;
					foreach ($rs2 as $key):	
						$count=$z+1;
						$symptoms_name = $key->symptoms_name;
						$status_name = $key->status_name;
						$visit_symptoms_id = $key->visit_symptoms_id;
						$description= $key->description;
							
							echo $symptoms_name." ->".$description."\n" ;
					endforeach;
					 echo $visit_symptoms; echo "
		<table align='center'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' placeholder='Type Additional Symptoms Here' id='visit_symptoms' onKeyUp='save_symptoms(".$visit_id.")'></textarea>
				</td>
			</tr>
		</table>
	";
}
?>
