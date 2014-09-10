<?php


$rs = $this->nurse_model->get_objective_findings($visit_id);
$num_rows = count($rs);

$rs2 = $this->nurse_model->get_visit_objective_findings($visit_id);
$num_rows2 = count($rs2);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'><input type='button' class='btn btn-primary' value='Add Objective Findings' onclick='open_objective_findings(".$visit_id.")'/></p></div>";

if($num_rows2 > 0){
	echo"
		<table align='center'  class='table table-striped table-hover table-condensed'>
		<tr>
			<th></th>
			<th>Class</th>
			<th>Objective Findings</th>
			<th></th>
		</tr>
	";	
	
	foreach ($rs2 as $key):
		
		$count=$z+1;
		$objective_findings_name = $key->objective_findings_name;
		$visit_objective_findings_id = $key->visit_objective_findings_id;
		$objective_findings_class_name = $key->objective_findings_class_name;
		echo"
		<tr> 
			<td>".$count."</td>
			<td>".$objective_findings_class_name."</td>
 			<td align='center'>".$objective_findings_name."</td>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_objective_findings(".$visit_objective_findings_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
		</tr>	
		";
	endforeach;
echo"
 </table>
";
}
	
if($num_rows > 0){
	foreach ($rs as $key1):
		$visit_objective_findings = $key1->visit_objective_findings;
	endforeach;
	echo
	"	<table align='left'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' id='visit_symptoms1' disabled='disabled'>"; 
					foreach ($rs2 as $key):
		
						$objective_findings_name = $key->objective_findings_name;
						$visit_objective_findings_id = $key->visit_objective_findings_id;
						$objective_findings_class_name = $key->objective_findings_class_name;
						$description= $key->description;
						
						
						echo $objective_findings_class_name.":".$objective_findings_name." ->".$description."\n" ;
					endforeach; 
				echo $visit_objective_findings; echo "
				</textarea>
				</td>
			</tr>
		</table>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' id='visit_objective_findings' onKeyUp='save_objective_findings(".$visit_id.")'>".$visit_objective_findings."</textarea>
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
					<textarea rows='10' cols='80' class='form-control col-md-6' id='visit_symptoms' disabled='disabled'>"; 
					foreach ($rs2 as $key):
		
						$objective_findings_name = $key->objective_findings_name;
						$visit_objective_findings_id = $key->visit_objective_findings_id;
						$objective_findings_class_name = $key->objective_findings_class_name;
						$description= $key->description;
						
						
						echo $objective_findings_class_name.":".$objective_findings_name." ->".$description."\n" ;
					endforeach; 
				echo $visit_objective_findings; echo "
</textarea>
				</td>
			</tr>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='10' cols='80' class='form-control col-md-6' id='visit_objective_findings' onKeyUp='save_objective_findings(".$visit_id.")'>12345</textarea>
				</td>
			</tr>
		</table>
	";
}
?>