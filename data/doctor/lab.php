<?php
session_start();
include("../../classes/class_doctor.php");

$service_charge_id = $_GET['service_charge_id'];
if ($_SESSION['nurse_lab'] <> NULL){
	$nurse_lab = $_SESSION['nurse_lab'];
}
$visit_id = $_GET['visit_id'];

$get2 = new doctor;
$rs2 = $get2->get_lab_visit2($visit_id);
$num_rows2 = mysql_num_rows($rs2);
if($num_rows2 > 0){
	$lab_visit = mysql_result($rs2, 0, "lab_visit");
}
if(!empty($service_charge_id)){
	
	$get = new doctor;
	$lab_test_id = $get->get_lab_test_id($service_charge_id);
}

if(!empty($service_charge_id)){
	
	$get_lab_visit = new doctor();
	$get_lab_visit_rs = $get_lab_visit->get_visits_lab_result($visit_id, $lab_test_id);
	$num_rows = mysql_num_rows($get_lab_visit_rs);
	
	if ($num_rows == 0 ){//if no formats
		$get = new doctor;
		$rs = $get->get_lab_visit($visit_id, $service_charge_id);
		$num_visit = mysql_num_rows($rs);
		
		if($num_visit > 0){//if visit charge has been saved
			/*$save= new doctor();
			$save->update_lab_visit($visit_id,$service_charge_id);*/
		}
		else{
			$save= new doctor();
			$save->save_lab_visit($visit_id, $service_charge_id);
		}
	}
	
	else{//if there are formats
		$get = new doctor;
		$rs = $get->get_lab_visit($visit_id, $service_charge_id);
		$num_visit = mysql_num_rows($rs);
		//echo $num_visit;
		if($num_visit > 0){//if visit charge has been saved
			/*$save= new doctor();
			$save->update_lab_visit($visit_id,$service_charge_id);*/
		}
		else{
			$save= new doctor();
			$save->save_lab_visit($visit_id, $service_charge_id);
		}
		
		for ($s = 0; $s < $num_rows; $s++){
					
			$lab_format_id = mysql_result($get_lab_visit_rs, $s, "lab_test_format_id");
			$save = new doctor();
			$save->save_lab_visit_format($visit_id, $service_charge_id, $lab_format_id);
		}
	}
}

$get = new doctor();
$rs = $get->get_lab_test($visit_id);
$num_rows = mysql_num_rows($rs);

echo "
<table class='table table-striped table-hover table-condensed'>
	<thead>
		<th>No.</th>
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
						<a class='btn' href='#' onclick='delete_cost(".$visit_charge_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
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
	echo"	<td><input type='button' class='btn' onclick='update_doctor(".$visit_id.")' value='Send to Lab'/></td>
	</tr>
";
}
else if($lab_visit == 5){
	echo"	<td><input type='button' class='btn' onclick='send_to_lab3(".$visit_id.")' value='Done'/></td>
	</tr>
";
}
else{
	echo"	<td><input type='button' class='btn' onclick='send_to_lab2(".$visit_id.")' value='Done'/></td>
	</tr>
";
}

echo "
</tbody>
</table>";

?>