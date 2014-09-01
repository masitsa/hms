<?php
session_start();
include "../../classes/class_lab.php";

$visit = $_GET['visit_id'];

$send = new Lab;
$send->send_to_lab($visit);

$get = new Lab;
$patient_id = mysql_result($get->get_patient_id($visit), 0, "patient_id");

$get = new Lab();
$get_test_rs = $get->get_lab_visit_test($visit);
$num_rows = mysql_num_rows($get_test_rs);

if ($num_rows >0 ){
	$lab_test = mysql_result($get_test_rs, 0, "lab_visit");
}

$get = new Lab;
$lab_rs = $get->get_lab_visit($visit);
$num_lab_visit = mysql_num_rows($lab_rs);

if($num_lab_visit > 0){
	
	echo"
	<div class='navbar-inner2'>
		<p style='text-align:center; color:#0e0efe;'>Laboratory Test</p>
	</div>
		<table class='table table-striped table-hover table-condensed'>
			<tr>
				<th>No.</th>
				<th>Test</th>
				<th>Class</th>
				<th>Format</th>
				<th>Result</th>
				<th>Units</th>
				<th>Level</th>
				<th>Male Range</th>
				<th>Female Range</th>
			<tr>
	";
	$count = 1;
	
	for($g = 0; $g < $num_lab_visit; $g++){
		
		$lab_visit_id = mysql_result($lab_rs, $g, "lab_visit_id");
		
		$format = new Lab();
		$format_rs = $format->get_lab_visit_result($lab_visit_id);
		$num_format = mysql_num_rows($format_rs);
		
		if($num_format > 0){
			$get = new Lab();
			$rs = $get->get_test($lab_visit_id);
			$num_lab = mysql_num_rows($rs);
			
		}
		else{
			$get = new Lab();
			$rs = $get->get_m_test($lab_visit_id);
			$num_lab = mysql_num_rows($rs);
		}
		//echo "num lab = ".$num_lab;
	for($r = 0; $r < $num_lab; $r++){
		
		$lab_test_name = mysql_result($rs, $r, "lab_test_name");
		$lab_test_class_name = mysql_result($rs, $r, "lab_test_class_name");
		$lab_test_units = mysql_result($rs, $r, "lab_test_units");
		$lab_test_upper_limit = mysql_result($rs, $r, "lab_test_malelowerlimit");
		$lab_test_lower_limit = mysql_result($rs, $r, "lab_test_malelupperlimit");
		$lab_test_upper_limit1 = mysql_result($rs, $r, "lab_test_femalelowerlimit");
		$lab_test_lower_limit1 = mysql_result($rs, $r, "lab_test_femaleupperlimit");
		$lab_visit_result = mysql_result($rs, $r, "lab_visit_result");
        $lab_visit_id = mysql_result($rs, $r, "lab_visit_id");
		
		if($_SESSION['test'] ==0){
			$test_format = mysql_result($rs, $r, "lab_test_formatname");
			$lab_test_format_id = mysql_result($rs, $r, "lab_test_format_id");
					
			$lab_visit_result = mysql_result($rs, $r, "lab_visit_results_result");
		}
		else{
			$test_format ="-";
		}
		
		if((($num_format > 0) && ($r == 0)) || ($num_format <= 0)){
			echo "
			<tr>
				<td>".$count."</td>
				<td>".$lab_test_name."</td>
				<td>".$lab_test_class_name."</td>";
			$count++;
		}
		else{
			echo "
			<tr>
				<td></td>
				<td></td>
				<td></td>";
		}
		
				echo"<td>".$test_format."</td>
				";
				if($_SESSION['test'] ==0){
					echo"
				<td>".$lab_visit_result."</td>";
				}else {
					echo"
				<td>".$lab_visit_result."</td>";
					
					}
				echo"
				<td>".$lab_test_units."</td>
				<td></td>
				<td>".$lab_test_lower_limit." - ".$lab_test_upper_limit."</td>
				<td>".$lab_test_lower_limit1." - ".$lab_test_upper_limit1."</td>
                        ";
				if($_SESSION['test'] ==0){   echo"    
				<td><div class='ui-widget' id='value2".$lab_test_format_id."'></div></td>";
				}else {
					echo"
					
				<td><div class='ui-widget' id='value".$lab_visit_id."'></div></td>";
				} 
				echo "
			</tr>
		";
		
	}
	}echo"
	
		</table>
		<table align='center'>
			<tr>
				<td><input type='button' class='btn btn-large' onClick='print_previous_test2(".$visit.",".$patient_id.")' value='Print'/></td>
			</tr>
		</table>
	";
}
?>