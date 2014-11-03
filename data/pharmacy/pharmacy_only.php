<?php
session_start();
include '../../classes/class_pharmacy.php';

$personnel_id = $_SESSION['personnel_id'];

$pharmacy_visit = new pharmacy();
$pharmacy_rs =$pharmacy_visit->get_pharmacy_only();
$num_rows_pharmacy = mysql_num_rows($pharmacy_rs);
	
	//paginate the items
	$pages1_pharmacy = intval($num_rows_pharmacy/10);
	$pages2_pharmacy = $num_rows_pharmacy%(2*10);

	if($pages2_pharmacy == NULL){//if there is no remainder
	
		$num_pages_pharmacy = $pages1_pharmacy;
	}

	else{
	
		$num_pages_pharmacy = $pages1_pharmacy + 1;
	}

	$current_page_pharmacy = $_GET['id'];//if someone clicks a different page

	if($current_page_pharmacy < 1){//if different page is not clicked
	
		$current_page_pharmacy = 1;
	}

	else if($current_page_pharmacy > $num_pages_pharmacy){//if the next page clicked is more than the number of pages
	
		$current_page_pharmacy = $num_pages_pharmacy;
	}
	

	if($current_page_pharmacy == 1){
	
		$current_item_pharmacy = 0;
	}

	else{

		$current_item_pharmacy = ($current_page_pharmacy-1) * 10;
	}

	$next_page_pharmacy = $current_page_pharmacy+1;

	$previous_page_pharmacy = $current_page_pharmacy-1;

	$end_item_pharmacy = $current_item_pharmacy + 10;

	if($end_item_pharmacy > $num_rows_pharmacy){
	
		$end_item_pharmacy = $num_rows_pharmacy;
	}
	echo "
		<table align='center'>
                    	<tr>
                        	<th width='130'>Name</th>
                        	<th>Code</th>
                            <th>Entry Time</th>
                        </tr>
             ";
				for($s = $current_item_pharmacy; $s < $end_item_pharmacy; $s++){
			
					$id = mysql_result($pharmacy_rs, $s, "patient_id");
					$visitid = mysql_result($pharmacy_rs, $s, "visit_id");
					$time = mysql_result($pharmacy_rs, $s, "visit_time");
					
					$get2 = new pharmacy();
					$rs2 = $get2->get_patient($id);
					$rows = mysql_num_rows($rs2);
					
					if($rows > 0){
						
						$strath_no = mysql_result($rs2, 0, "strath_no");
						$strath_type = mysql_result($rs2, 0, "strath_type");
						$id = mysql_result($rs2, 0, "patient_id");
						
						if($strath_type == 1){
							
							$get2 = new pharmacy;
							$rs2 = $get2->get_patient_2($strath_no);
							$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
							while (OCIFetch($rs2)) {
								$name = ociresult($rs2, "OTHER_NAMES");
								$secondname = ociresult($rs2, "SURNAME");
							}
						}
						
						else if($strath_type == 2){
			
							$get2 = new pharmacy;
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
					
					$get_appointment = new pharmacy();
					$appointment_rs = $get_appointment->get_appointment_code($visitid);
					$num_appointments = mysql_num_rows($appointment_rs);
					
					if($num_appointments == 0){
					}
					
					else{
						$appointment_id = mysql_result($appointment_rs, 0, "appointment_id");
						
						if($appointment_id == 0){
						}
						
						else if ($appointment_id == 1){
							$appointment = "blue.jpg";
						}
					}
	echo"
                        
                        	<tr>
                            	<td width='100' align='left'><a href='#' onclick='set_pharmacy_details(".$id.",".$visitid.")'>".$name." ".$secondname."</a>
                                </td>
                                <td><img src='../administration/images/levels/".$appointment."/></td>
                                <td><img src='../administration/images/levels/green.png'/></td>
                                <td><img src='../administration/images/levels/level2.gif' width='40' height='15' /></td>
                                <td>".$time."</td>
                            </tr>
                  "; 
                  
                  }
				  echo"
                    </table>
                     </table>
                    
                    <table align='center'>
        				<tr>
						<td><a href='#' onclick='next_pharmacy_queue_only(".$previous_page_pharmacy.")' class='modify2'><img src='../administration/images/back_alt.png'/></a></td>";
                        
							for($t = 1; $t <= $num_pages_pharmacy; $t++){
								echo "<td width='10' <a href='#' onclick='next_pharmacy_queue_only(".$t.")' class='modify'>".$t."</a></td>";
								
							}
							echo"<td><a href='#' onclick='next_pharmacy_queue_only(".$next_page_pharmacy.")' class='modify2'><img src='../administration/images/forward_alt.png'/></a></td>
            		</table>
			";

?>