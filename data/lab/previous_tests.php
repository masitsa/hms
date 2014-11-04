<?php
include '../../classes/class_lab.php';

//previous visits
$previous_visits = new Lab;
$prev_rs = $previous_visits->previous_tests();
$num_prev = mysql_num_rows($prev_rs);

//paginate the items
$prev_pages1 = intval($num_prev/10);
$prev_pages2 = $num_prev%(2*10);

if($prev_pages2 == NULL){//if there is no remainder
	$prev_num_pages = $prev_pages1;
}

else{
	$prev_num_pages = $prev_pages1 + 1;
}

$prev_current_page = $_GET['id'];//if someone clicks a different page

if($prev_current_page < 1){//if different page is not clicked
	$prev_current_page = 1;
}

else if($prev_current_page > $prev_num_pages){//if the next page clicked is more than the number of pages
	$prev_current_page = $prev_num_pages;
}
	
if($prev_current_page == 1){
	$prev_current_item = 0;
}

else{
	$prev_current_item = ($prev_current_page-1) * 10;
}

$prev_next_page = $prev_current_page+1;

$prev_previous_page = $prev_current_page-1;

$prev_end_item = $prev_current_item + 10;

if($prev_end_item > $num_prev){
	$prev_end_item = $num_prev;
}

echo '
<div class="navbar-inner2"><p style="text-align:center; color:#0e0efe;">Previous Tests</p></div>
	<table class="table table-striped table-hover table-condensed">
		<tr>
			<th>Patient</th>
			<th>Date</th>
			<!--<th>Class</th>
			<th>Results</th>
			<th>Units</th>
			<th>Male Range</th>
			<th>Female Range</th>-->
		</tr>';
for($w = $prev_current_item; $w < $prev_end_item; $w++){
	
	$v_id = mysql_result($prev_rs, $w, "visit_id");
	$visit_date = mysql_result($prev_rs, $w, "visit_date");
	
	$get3 = new Lab;
	$prev_rs2 = $get3->previous_tests2($v_id);
	
	$lab_visit_id = mysql_result($prev_rs2, 0, "lab_visit_id");
	$lab_visit_status  = mysql_result($prev_rs2, 0, "lab_visit_status");
	$visit_id_lab = mysql_result($prev_rs2, 0, "visit_id");
	$lab_test_id  = mysql_result($prev_rs2, 0, "lab_test_id");
	$lab_visit_result = mysql_result($prev_rs2, 0, "lab_visit_result");
	
	$test = new Lab;
	$test_rs = $test->get_test($visit_id_lab);
	 $num_test = mysql_num_rows($test_rs);
	 
	 if($num_test >0 ){
		 $lab_test_name = mysql_result($test_rs, 0, "lab_test_name");
		 $lab_test_class_name = mysql_result($test_rs, 0, "lab_test_class_name");
		 $lab_test_units = mysql_result($test_rs, 0, "lab_test_units");
		 $lab_test_malelowerlimit = mysql_result($test_rs, 0, "lab_test_malelowerlimit");
		 $lab_test_malelupperlimit = mysql_result($test_rs, 0, "lab_test_malelupperlimit");
		 $lab_test_femalelowerlimit = mysql_result($test_rs, 0, "lab_test_femalelowerlimit");
		 $lab_test_femaleupperlimit = mysql_result($test_rs, 0, "lab_test_femaleupperlimit");
	}
		
	$visit = $visit_id_lab;

	$get = new Lab;
	$patient_id = mysql_result($get->get_patient_id($visit), 0, "patient_id");
	
	$get = new Lab();
	$rs = $get->get_patient2($patient_id);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "strath_type_id");
						
	if($strath_type == 2){
							
		$get2 = new Lab();
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
		while (OCIFetch($rs2)) {
			$name = ociresult($rs2, "OTHER_NAMES");
			$secondname = ociresult($rs2, "SURNAME");
			$patient_dob = ociresult($rs2, "DOB");
			$patient_sex = ociresult($rs2, "GENDER");
		}
	}
						
	else if($strath_type == 1){
			
		$get2 = new Lab();
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			
		$name = mysql_result($rs2, 0, "Other_Name");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
	
	else{

		$name = mysql_result($rs, 0, "patient_othernames");
		$secondname = mysql_result($rs, 0, "patient_surname");
		$patient_dob = mysql_result($rs, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs, 0, "gender_id");
		if($patient_sex == 1){
			$patient_sex = "Male";
		}
		else{
			$patient_sex = "Female";
		}
		
		$patient_name = $secondname." ".$name;
	}
	
	echo "
		<tr>
			<td>".$patient_name."</td>
			<td>".$visit_date."</td>
			<!--<td>".$lab_test_class_name."</td>
			<!--<td><?php //echo $lab_visit_result</td>
			<td>".$lab_test_units."</td>
			<td>".$lab_test_malelowerlimit." - ".$lab_test_malelupperlimit."</td>
			<td>".$lab_test_femalelowerlimit." - ".$lab_test_femaleupperlimit."</td>-->
			<td><input type='button' class='btn' id='report' onclick='print_previous_test(".$visit_id_lab.", ".$patient_id.")' value='Print'/></td>
         </tr>";
}
echo '
</table>

<div class="pagination" style="margin-left:20%;">
	<ul>
		<li><a onClick="get_previous_tests('.$previous_page.')" href="#">Prev</a></li>';
		
		for($t = 1; $t <= $prev_num_pages; $t++){
			echo '<li><a onClick="get_previous_tests('.$t.')" href="#">'.$t.'</a></li>';
		}
		
		echo '<li><a onClick="get_previous_tests('.$next_page.')" href="#">Next</a></li>
    </ul>
</div>';
?>