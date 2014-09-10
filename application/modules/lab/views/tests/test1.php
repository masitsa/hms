<?php

$visit = $_GET['visit_id'];

$get3 = new Lab;
$patient_id = mysql_result($get3->get_patient_id($visit), 0, "patient_id");

$get2 = new Lab;
$rs2 = $get2->get_lab_visit2($visit);
$num_rows2 = mysql_num_rows($rs2);
if($num_rows2 > 0){
	$lab_visit = mysql_result($rs2, 0, "lab_visit");
}

$get_test = new Lab();
$get_test_rs = $get_test->get_lab_visit_test($visit);
$num_rows = mysql_num_rows($get_test_rs);

$get2 = new Lab;
$rs2 = $get2->get_comment($visit);
$num_rows2 = mysql_num_rows($rs2);

if($num_rows2 > 0){
	$comment = mysql_result($rs2, 0, "lab_visit_comment");
}



if ($num_rows >0 ){
	$lab_test = mysql_result($get_test_rs, 0, "lab_visit");
	//echo $lab_test;
	
	if ($lab_test == 2){
		echo "
		<table align='center'>
		<tr><td>
		<input name='test' type='button' value='check test' onclick='open_window_laboratory(".$visit.",552)' />
		
		</td></tr>
		
		</table>
		
		
		";
		
	}else {}
	
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
				<th>Test</th>
				<th>Class</th>
				<th>Format</th>
				<th>Result</th>
				<th>Units</th>
				<th>Level</th>
				<th>Male Range</th>
				<th>Female Range</th>
				<th></th>
			<tr>
	";
	for($g = 0; $g < $num_lab_visit; $g++){
		
		$visit_charge_id = mysql_result($lab_rs, $g, "visit_charge_id");
	
		$format = new Lab;
		$format_rs = $format->get_lab_visit_result($visit_charge_id);
		$num_format = mysql_num_rows($format_rs);
		
		if($num_format > 0){
			$get = new Lab();
			$rs = $get->get_test($visit_charge_id);
			$num_lab = mysql_num_rows($rs);
		}
		else{
			$get = new Lab();
			$rs = $get->get_m_test($visit_charge_id);
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
        $visit_charge_id = mysql_result($rs, $r, "lab_visit_id");
		
		//echo $_SESSION['test'];
		if($_SESSION['test'] ==0){
			$test_format = mysql_result($rs, $r, "lab_test_formatname");
			$lab_test_format_id = mysql_result($rs, $r, "lab_test_format_id");
			$lab_test_format_units = mysql_result($rs, $r, "lab_test_format_units");
			$lab_test_format_malelowerlimit = mysql_result($rs, $r, "lab_test_format_malelowerlimit");
			$lab_test_format_maleupperlimit = mysql_result($rs, $r, "lab_test_format_maleupperlimit");
			$lab_test_format_femalelowerlimit = mysql_result($rs, $r, "lab_test_format_femalelowerlimit");
			$lab_test_format_femaleupperlimit = mysql_result($rs, $r, "lab_test_format_femaleupperlimit");
			$lab_visit_result = mysql_result($rs, $r, "lab_visit_results_result");
		}
		else{
			$test_format ="-";
		}
					
		if(!empty($lab_visit_result)){
			$class = "class='success'";
		}
		else{
			$class = "class=''";
		}

		if((($num_format > 0) && ($r == 0)) || ($num_format <= 0)){
			echo "
			<tr ".$class.">
				<td>".$lab_test_name."</td>
				<td>".$lab_test_class_name."</td>";
		}
		else{
			echo "
			<tr ".$class.">
				<td></td>
				<td></td>";
		}
		
		echo"
			<td>".$test_format."</td>";
				
			if($_SESSION['test'] ==0){
				echo"<td><input type='text'  disabled id='laboratory_result2".$lab_test_format_id."' size='10' onkeyup='save_result_format(".$visit_charge_id.",".$lab_test_format_id.", ".$visit.")' value='".$lab_visit_result."'/></td>";
				
				echo"
					<td>".$lab_test_format_units."</td>
					<td></td>
					<td>".$lab_test_format_malelowerlimit." - ".$lab_test_format_maleupperlimit ."</td>
					<td>".$lab_test_format_femalelowerlimit." - ".$lab_test_format_femaleupperlimit ."</td>
					<td id='result_space".$lab_test_format_id."'></td>";
			}
			else {
				echo"<td><input  disabled type='text' id='laboratory_result".$visit_charge_id."' size='10' onkeyup='save_result(".$visit_charge_id.", ".$visit.")' value='".$lab_visit_result."'/></td>";
								
				echo "
					<td>".$lab_test_units."</td>
					<td></td>
					<td>".$lab_test_upper_limit." - ".$lab_test_lower_limit."</td>
					<td>".$lab_test_upper_limit1." - ".$lab_test_lower_limit1."</td>
					<td id='result_space".$visit_charge_id."'></td>";
			}
			
			if($_SESSION['test'] ==0){
				echo"<td><div class='ui-widget' id='value2".$lab_test_format_id."'></div></td>";
			}
			else {
				echo"<td><div class='ui-widget' id='value".$visit_charge_id."'></div></td>";
			} 
				
			echo "</tr>";
		}
		
				if((($num_format > 0) && ($r == 0)) || ($num_format <= 0)){

			}
			
			else{
				$gety2 = new Lab;
$rsy2 = $gety2->get_test_comment($visit_charge_id);
$num_rowsy2 = mysql_num_rows($rsy2);

if($num_rowsy2 > 0){
	$comment4= mysql_result($rsy2, 0, "lab_visit_format_comments");
}
				echo "<tr>
				<td> </td>
				
					<td></td>
					<td><textarea disabled rows='5' cols='10' id='laboratory_comment".$visit_charge_id."'  onkeyup='save_lab_comment(".$visit_charge_id.", ".$visit.")'>".$comment4."</textarea> </td>
					<td> </td>
					<td ></td>			<td> </td>
			</tr>";
				}
	}
	
	echo //MM.$lab_test.
	"
	</table>
	
	<div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Comments</p></div>
	<table align='center'>
		<tr>
			<td><textarea disabled rows='5' cols='10' id='test_comment' onkeyup='save_comment(".$visit_charge_id.")'>".$comment."</textarea></td>
		</tr>
	</table>
	";}
?>