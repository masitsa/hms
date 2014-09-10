<?php


$rs = $this->nurse_model->get_assessment($visit_id);
$num_rows = count($rs);
	
echo "
	<div class='navbar-inner'></div>";

if($num_rows > 0){
	foreach ($rs as $key):
	$visit_assessment = $key->visit_assessment;
	endforeach;
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='10' cols='100' class='form-control col-md-6' id='visit_assessment' onKeyUp='save_assessment(".$visit_id.")'>".$visit_assessment."</textarea>
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
					<textarea rows='10' cols='100' class='form-control col-md-6' id='visit_assessment' onKeyUp='save_assessment(".$visit_id.")'></textarea>
				</td>
			</tr>
		</table>
	";
}
?>
