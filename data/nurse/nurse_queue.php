<?php 
session_start();
include '../../classes/class_nurse.php';

$personnel_id = $_SESSION['personnel_id'];

$nurse = new nurse;
$rs = $nurse->get_visits();
$num_rows = mysql_num_rows($rs);
	//paginate the items
	$pages1 = intval($num_rows/10);
	$pages2 = $num_rows%(2*10);

	if($pages2 == NULL){//if there is no remainder
	
		$num_pages = $pages1;
	}

	else{
	
		$num_pages = $pages1 + 1;
	}

	$current_page = $_GET['id'];//if someone clicks a different page

	if($current_page < 1){//if different page is not clicked
	
		$current_page = 1;
	}

	else if($current_page > $num_pages){//if the next page clicked is more than the number of pages
	
		$current_page = $num_pages;
	}
	

	if($current_page == 1){
	
		$current_item = 0;
	}

	else{

		$current_item = ($current_page-1) * 10;
	}

	$next_page = $current_page+1;

	$previous_page = $current_page-1;

	$end_item = $current_item + 10;

	if($end_item > $num_rows){
	
		$end_item = $num_rows;
	}
	
echo"
<table align='center'>
	<tr>
		<th width='130'>Name</th>
		<th>Code</th>
		<th>Entry Time</th>
	</tr>";
	
for($s = $current_item; $s < $end_item; $s++){
	
	$visitid = mysql_result($rs, $s, "visit_id");
	$time = mysql_result($rs, $s, "visit_time");
	$id = mysql_result($rs, $s, "patient_id");
	
	$get2 = new nurse();
	$rs2 = $get2->get_patient($id);
	$rows = mysql_num_rows($rs2);
		
	$_SESSION['strath_no'] = NULL;
	$_SESSION['patient_id'] = $id;
	
	
	if(($rows > 0) && (!empty($id))){
		
		$strath_no = mysql_result($rs2, 0, "strath_no");
		$strath_type = mysql_result($rs2, 0, "strath_type");
		
		if(empty($strath_no)){
			$secondname = mysql_result($rs2, 0, "patient_surname");
			$othername = mysql_result($rs2, 0, "patient_firstname")." ".mysql_result($rs2, 0, "patient_middlename");
		}
		
		else if($strath_type == 1){
			$get2 = new nurse();
			$rs2 = $get2->get_patient_2($strath_no);
			$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
			while (OCIFetch($rs2)) {
				$othername = ociresult($rs2, "OTHER_NAMES");
				$secondname = ociresult($rs2, "SURNAME");
			}
		}
		
		else if($strath_type == 2){
			$get2 = new nurse();
			$rs2 = $get2->get_patient_3($strath_no);
			$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			
			$othername = mysql_result($rs2, 0, "Other_Name");
			$secondname = mysql_result($rs2, 0, "Surname");
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
	
	echo"
	<tr>
		<td width='100' align='left'><a href='#' onclick='set_patient_details(".$id.", ".$visitid.")'>".$othername." ".$secondname." </a></td>
		<td><img src=".$appointment."/></td>
		<td>".$time."</td>
		
	</tr>";
}

echo"
</table>
<table align='center'>
	<tr>
		<td><a href='#' onclick='next_nurse_queue(".$previous_page.")' class='modify2'><img src='../administration/images/back_alt.png'/></a></td>";
		for($t = 1; $t <= $num_pages; $t++){
			echo "<td width='10' <a href='#' onclick='next_nurse_queue(".$t.")' class='modify'>".$t."</a></td>";
		}
		echo"<td><a href='#' onclick='next_nurse_queue(".$next_page.")' class='modify2'><img src='../administration/images/forward_alt.png'/></a></td>
	</tr>
</table>";
?>