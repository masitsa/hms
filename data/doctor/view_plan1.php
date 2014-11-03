<?php

include '../../classes/class_doctor.php';

$visit_id = $_GET['visit_id'];

$get = new doctor;
$rs = $get->get_plan($visit_id);
$num_rows = mysql_num_rows($rs);
	
echo "
	<div class='navbar-inner'>
		<p style='text-align:center; color:#0e0efe;'>
			Investigations<br/>
			<input type='button' class='btn btn-primary' value='Laboratory Test' onclick='open_window_lab(0, ".$visit_id.")'/>
		</p>
	</div>
<div id='test_results'></div>";
?>