<?php

$rs = $this->nurse_model->get_plan($visit_id);
$num_rows = count($rs);
	
echo "
	<div class='navbar-inner'>
		<p style='text-align:center; color:#0e0efe;'>
		
			<input type='button' class='btn btn-warning' value='Laboratory Test' onclick='open_window_lab(0, ".$visit_id.")'/>
			<input type='button' class='btn btn-info' value='Diagnose' onclick='open_window(6, ".$visit_id.")'/>
			<input type='button' class='btn btn-success' value='Prescribe' onclick='open_window(1, ".$visit_id.")'/>
		</p>
	</div>";

if($num_rows > 0){
	foreach ($rs as $key):
		$visit_plan = $key->visit_plan;
	endforeach;
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea  rows='10' cols='100' class='form-control col-md-6' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'>".$visit_plan."</textarea>
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
					<textarea  rows='10' cols='100' class='form-control col-md-6' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'></textarea>
				</td>
			</tr>
		</table>
	";
}

echo "
<div id='test_results'></div>
<div id='diagnosis'></div>
<div id='prescription'></div>";
?>