<?php

include '../../classes/class_doctor.php';

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_plan($visit_id);
$num_rows = mysql_num_rows($rs);
	
echo "
	<div class='navbar-inner'>
		<p style='text-align:center; color:#0e0efe;'>
			Plan<br/>
			<input type='button' class='btn btn-primary' value='Laboratory Test' onclick='open_window_lab(0, ".$visit_id.")'/>
			<input type='button' class='btn btn-primary' value='Diagnose' onclick='open_window(6, ".$visit_id.")'/>
			<input type='button' class='btn btn-primary' value='Prescribe' onclick='open_window(1, ".$visit_id.")'/>
		</p>
	</div>";

if($num_rows > 0){
	$visit_plan = mysql_result($rs, 0, "visit_plan");
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'>".$visit_plan."</textarea>
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
					<textarea rows='5' cols='100' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'></textarea>
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