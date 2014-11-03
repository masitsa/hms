<?php
session_start();
include '../../classes/class_nurse.php';

$personnel_id = $_SESSION['personnel_id'];
$general = new nurse;
$general_rs = $general->get_general_visits();
$general_num_rows = mysql_num_rows($general_rs);

	//paginate the items
	$pages3 = intval($general_num_rows/10);
	$pages4 = $general_num_rows%(2*10);

	if($pages4 == NULL){//if there is no remainder
	
		$num_pages1 = $pages3;
	}

	else{
	
		$num_pages1 = $pages3 + 1;
	}

	$current_page1 = $_GET['id'];//if someone clicks a different page

	if($current_page1 < 1){//if different page is not clicked
	
		$current_page1 = 1;
	}

	else if($current_page1 > $num_pages1){//if the next page clicked is more than the number of pages
	
		$current_page1 = $num_pages1;
	}
	

	if($current_page1 == 1){
	
		$current_item1 = 0;
	}

	else{

		$current_item1 = ($current_page1-1) * 10;
	}

	$next_page3 = $current_page1+1;

	$previous_page1 = $current_page1-1;

	$end_item1 = $current_item1 + 10;

	if($end_item1 > $general_num_rows){
	
		$end_item1 = $general_num_rows;
	}
	
echo"
<table align='center'>
	<tr>
		<th width='130'>Name</th>
		<th>Code</th>
		<th>Hold</th>
		<th>Entry Time</th>
	</tr>";
	
	for($z = $current_item1; $z < $end_item1; $z++){
		
		$id = mysql_result($general_rs, $z, "patient_id");
		$visitid = mysql_result($general_rs, $z, "visit_id");
		$time = mysql_result($general_rs, $z, "visit_time");
		
		$get2 = new nurse();
		$rs2 = $get2->get_patient($id);
		$rows = mysql_num_rows($rs2);
		
		if($rows > 0){
						
			$strath_no = mysql_result($rs2, 0, "strath_no");
			$strath_type = mysql_result($rs2, 0, "strath_type");
			$id = mysql_result($rs2, 0, "patient_id");
					
			if($strath_type == 1){
							
				$get2 = new nurse;
				$rs2 = $get2->get_patient_2($strath_no);
				$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
				while (OCIFetch($rs2)) {
					$name = ociresult($rs2, "OTHER_NAMES");
					$secondname = ociresult($rs2, "SURNAME");
				}
			}
						
			else if($strath_type == 2){
			
				$get2 = new nurse;
				$rs2 = $get2->get_patient_3($strath_no);
				$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			
				$name = mysql_result($rs2, 0, "Other_Name");
				$secondname = mysql_result($rs2, 0, "Surname");
			}
				
			else{
				$name = mysql_result($rs2, 0, "patient_surname");
				$secondname = mysql_result($rs2, 0, "patient_firstname")." ".mysql_result($rs2, 0, "patient_middlename");
			}
		}
		
		$get_appointment = new nurse();
		$appointment_rs = $get_appointment->get_appointment_code($visitid);
		$num_appointments = mysql_num_rows($appointment_rs);
		
		if($num_appointments == 0){}
		
		else{
			$appointment_id = mysql_result($appointment_rs, 0, "appointment_id");
			
			if($appointment_id == 0){}
			
			else if ($appointment_id == 1){
				$appointment = "../administration/images/levels/blue.jpg";
			}
		}
		
		$check_hold = new  nurse();;
$check_hold_rs= $check_hold->check_hold($visitid,$personnel_id);
$num_check_hold= mysql_num_rows($check_hold_rs);

if ($num_check_hold >0){
	$h = "h";
	}else {
		$h = "";
		}
		
		echo"
		<tr>
		<td width='auto' align='left'><a href='#' onclick='set_patient_details(".$id.", ".$visitid .")'>".$name." ".$secondname." </a></td>
		<td><img src=".$appointment."/></td>
		<td align='center'>".$h."</td>
		<td>".$time."</td>
		
	</tr>";
	}

echo"
</table>
<table align='center'>
	<tr>
		<td><a href='#' onclick='next_general_queue(".$previous_page1.")' class='modify2'><img src='../administration/images/back_alt.png'/></a></td>";
		for($t = 1; $t <= $num_pages1; $t++){
			echo "<td width='10' <a href='#' onclick='next_general_queue(".$t.")' class='modify'>".$t."</a></td>";
		}
		echo"<td><a href='#' onclick='next_general_queue(".$next_page3.")' class='modify2'><img src='../administration/images/forward_alt.png'/></a></td>
	</tr>
</table>";