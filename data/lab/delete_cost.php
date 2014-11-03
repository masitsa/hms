<?php
session_start();
include("../../classes/class_doctor.php");

$visit_charge_id = $_GET['visit_charge_id'];
$visit_id = $_GET['visit_id'];

if(isset($visit_charge_id)){
	
	$save = new doctor();
	$save->delete_lab_visit($visit_charge_id);
}
$get = new doctor();
$rs = $get->get_lab_test($visit_id);
$num_rows = mysql_num_rows($rs);

echo "
<table class='table table-striped table-hover table-condensed'>
	<thead>
		<th></th>
    	<th>Test</th>
		<th>Class</th>
		<th>Cost</th>
	</thead>
	<tbody>
";

$total = 0;

for($s = 0; $s < $num_rows; $s++){
	
	$visit_charge_id = mysql_result($rs, $s, "lab_visit_id");
	$test = mysql_result($rs, $s, "lab_test_name");
	$price = mysql_result($rs, $s, "lab_test_price");
	$class = mysql_result($rs, $s, "class_name");
	$total = $total + $price;
	
	echo "
		<tr>
        	<td>".($s+1)."</td>
			<td>".$test."</td>
			<td>".$class."</td>
			<td>".$price."</td>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_cost(".$visit_charge_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
		</tr>
	";
}

echo "
	<tr bgcolor='#0099FF'>
		<td></td>
		<td></td>
		<td></td>
		<td>".$total."</td>";
		
if(!empty($nurse_lab)){
	echo"	<td><input type='button' class='btn' onclick='update_doctor()' value='Send to Lab'/></td>
	</tr>
";
}
else{
	echo"	<td><input type='button' class='btn' onclick='send_to_lab()' value='Send to Lab'/></td>
	</tr>
";
}

echo "
</tbody>
</table>";

?>