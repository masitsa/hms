<?php

$patient_id = $this->nurse_model->get_patient_id($visit);

$rs2 = $this->lab_model->get_lab_visit2($visit);
$num_rows2 = count($rs2);
if($num_rows2 > 0){
	foreach ($rs2 as $key):
		$lab_visit = $key->lab_visit;
	endforeach;
}

$get_test_rs = $this->lab_model->get_lab_visit_test($visit);
$num_rows = count($get_test_rs);

$rs2 = $this->lab_model->get_comment($visit);
$num_rows2 = count($rs2);

if($num_rows2 > 0){
	foreach ($rs2 as $key2):
		$comment = $key2->lab_visit_comment;
	endforeach;
}



if ($num_rows >0 ){
	foreach ($get_test_rs as $key22):
		$lab_test = $key22->lab_visit;
	endforeach;
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
$lab_rs = $this->lab_model->get_lab_visit($visit);
$num_lab_visit = count($lab_rs);

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
	foreach ($lab_rs as $key_lab):
		
		$visit_charge_id = $key_lab->visit_charge_id;
	
		$format_rs = $this->lab_model->get_lab_visit_result($visit_charge_id);
		$num_format = count($format_rs);
		
		if($num_format > 0){

			$rs = $this->lab_model->get_test($visit_charge_id);
			$num_lab = count($rs);
		}
		else{
			$rs = $this->lab_model->get_m_test($visit_charge_id);
			$num_lab = count($rs);
		}
		//echo "num lab = ".$num_lab;
			foreach ($rs as $key_rs): 
				
				$lab_test_name = $key_rs->lab_test_name;
				$lab_test_class_name = $key_rs->lab_test_class_name;
				$lab_test_units = $key_rs->lab_test_units;
				$lab_test_upper_limit = $key_rs->lab_test_malelowerlimit;
				$lab_test_lower_limit = $key_rs->lab_test_malelupperlimit;
				$lab_test_upper_limit1 = $key_rs->lab_test_femalelowerlimit;
				$lab_test_lower_limit1 = $key_rs->lab_test_femaleupperlimit;
				$lab_visit_result = $key_rs->lab_visit_result;
		        $visit_charge_id = $key_rs->lab_visit_id;
				
				//echo $_SESSION['test'];
				if($this->session->userdata('test') ==0){
					$test_format = $key_rs->lab_test_formatname;
					$lab_test_format_id = $key_rs->lab_test_format_id;
					$lab_test_format_units = $key_rs->lab_test_format_units;
					$lab_test_format_malelowerlimit = $key_rs->lab_test_format_malelowerlimit;
					$lab_test_format_maleupperlimit = $key_rs->lab_test_format_maleupperlimit;
					$lab_test_format_femalelowerlimit = $key_rs->lab_test_format_femalelowerlimit;
					$lab_test_format_femaleupperlimit = $key_rs->lab_test_format_femaleupperlimit;
					$lab_visit_result = $key_rs->lab_visit_results_result;
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
						
					if($this->session->userdata('test') ==0){
						echo"<td><input type='text' id='laboratory_result2".$lab_test_format_id."' size='10' onkeyup='save_result_format(".$visit_charge_id.",".$lab_test_format_id.", ".$visit.")' value='".$lab_visit_result."'/></td>";
						
						echo"
							<td>".$lab_test_format_units."</td>
							<td></td>
							<td>".$lab_test_format_malelowerlimit." - ".$lab_test_format_maleupperlimit ."</td>
							<td>".$lab_test_format_femalelowerlimit." - ".$lab_test_format_femaleupperlimit ."</td>
							<td id='result_space".$lab_test_format_id."'></td>";
					}
					else {
						echo"<td><input type='text' id='laboratory_result".$visit_charge_id."' size='10' onkeyup='save_result(".$visit_charge_id.", ".$visit.")' value='".$lab_visit_result."'/></td>";
										
						echo "
							<td>".$lab_test_units."</td>
							<td></td>
							<td>".$lab_test_upper_limit." - ".$lab_test_lower_limit."</td>
							<td>".$lab_test_upper_limit1." - ".$lab_test_lower_limit1."</td>
							<td id='result_space".$visit_charge_id."'></td>";
					}
					
					if($this->session->userdata('test') ==0){
						echo"<td><div class='ui-widget' id='value2".$lab_test_format_id."'></div></td>";
					}
					else {
						echo"<td><div class='ui-widget' id='value".$visit_charge_id."'></div></td>";
					} 
						
					echo "</tr>";
				endforeach;
		
				if((($num_format > 0) && ($r == 0)) || ($num_format <= 0))
				{

				}
			
				else{
				$rsy2 = $this->lab_model->get_test_comment($visit_charge_id);
				$num_rowsy2 = count($rsy2);

				if($num_rowsy2 > 0){
					foreach ($rsy2 as $key_comment):
					$comment4= $key_comment->lab_visit_format_comments;
					endforeach;
				}
				echo "<tr>
				<td> </td>
				
					<td></td>
					<td><textarea rows='5' cols='10' id='laboratory_comment".$visit_charge_id."'  onkeyup='save_lab_comment(".$visit_charge_id.", ".$visit.")'>".$comment4."</textarea> </td>
					<td> </td>
					<td ></td>			<td> </td>
				</tr>";
				}
	endforeach;
	
	echo //MM.$lab_test.
	"
	</table>";
	
	echo "
	<div class='navbar-inner2'><p style='text-align:center; color:#0e0efe;'>Comments</p></div>
	<table align='center'>
		<tr>
			<td><textarea rows='5' cols='10' id='test_comment' onkeyup='save_comment(".$visit_charge_id.")'>".$comment."</textarea></td>
		</tr>
	</table>
	";
	if ($lab_test == 12){
		echo"
		<table align='center'>
			<tr>
				<td><input type='button' value='Print' name='std' class='btn btn-large' onclick='print_previous_test(".$visit.",".$patient_id.")'/></td>
				<td><input type='button' value='Send to Doctor' name='std' class='btn btn-large' onClick='send_to_doc(".$visit.")'/></td>
				<td><input type='button' class='btn btn-large' value='Done' onclick='finish_lab_test(".$visit.")'/></td>
			</tr>
		</table>
	";
	}
	
	elseif ($lab_test == 22){
		echo"
		<table align='center'>
			<tr>
				<td><input type='button' value='Print' name='std' class='btn btn-large' onclick='print_previous_test(".$visit.",".$patient_id.")'/></td>
				<td><input type='button' value='Send to Doctor' name='std' class='btn btn-large' onClick='send_to_doc(".$visit.")'/></td>
				<td><input type='button' class='btn btn-large' value='Done' onclick='finish_lab_test(".$visit.")'/></td>
			</tr>
		</table>
	";
	}
	
	else if($lab_visit == 5){
	echo"
		<table align='center'>
			<tr>
				<td><input type='button' value='Print' name='std' class='btn btn-large' onclick='print_previous_test(".$visit.",".$patient_id.")'/></td>
				<td><input type='button' value='Send to Doctor' name='std' class='btn btn-large' onClick='send_to_doc(".$visit.")'/></td>
				<td><input type='button' class='btn btn-large' value='Done' onclick='finish_lab_test(".$visit.")'/></td>
			</tr>
		</table>
	";
	}
	
	else if($lab_visit == 0){
	echo"
		<table align='center'>
			<tr>
				<td><input type='button' value='Print' name='std' class='btn btn-large' onclick='print_previous_test(".$visit.",".$patient_id.")'/></td>
			</tr>
		</table>
	";
	}
	
	else{
		echo"
		<table align='center'>
			<tr>
				<td><input type='button' value='Print' name='std' class='btn btn-large' onclick='print_previous_test(".$visit.",".$patient_id.")'/></td>
				<td><input type='button' value='Send to Doctor' name='std' class='btn btn-large' onClick='send_to_doc(".$visit.")'/></td>
				<td><input type='button' class='btn btn-large' value='Done' onclick='finish_lab_test(".$visit.")'/></td>
				 
			</tr>
		</table>
	";
	}
}
?>