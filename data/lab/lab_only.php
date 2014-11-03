<?php
session_start();
include '../../classes/class_lab.php';

$laboratory_visit = new Lab();
$laboratory_rs =$laboratory_visit->get_lab_only();
$num_rows_laboratory = mysql_num_rows($laboratory_rs);
	
	//paginate the items
	$pages1_laboratory = intval($num_rows_laboratory/10);
	$pages2_laboratory = $num_rows_laboratory%(2*10);

	if($pages2_laboratory == NULL){//if there is no remainder
	
		$num_pages_laboratory = $pages1_laboratory;
	}

	else{
	
		$num_pages_laboratory = $pages1_laboratory + 1;
	}

	$current_page_laboratory = $_GET['id'];//if someone clicks a different page

	if($current_page_laboratory < 1){//if different page is not clicked
	
		$current_page_laboratory = 1;
	}

	else if($current_page_laboratory > $num_pages_laboratory){//if the next page clicked is more than the number of pages
	
		$current_page_laboratory = $num_pages_laboratory;
	}
	

	if($current_page_laboratory == 1){
	
		$current_item_laboratory = 0;
	}

	else{

		$current_item_laboratory = ($current_page_laboratory-1) * 10;
	}

	$next_page_laboratory = $current_page_laboratory+1;

	$previous_page_laboratory = $current_page_laboratory-1;

	$end_item_laboratory = $current_item_laboratory + 10;

	if($end_item_laboratory > $num_rows_laboratory){
	
		$end_item_laboratory = $num_rows_laboratory;
	}
echo"	
	<table align='center'>
                    	<tr>
                        	<th width='130'>Name</th>
                            <th width='200'>Entry Time</th>
                        </tr>
               ";
				for($s = $current_item_laboratory; $s < $end_item_laboratory; $s++){
			
					$visit_id = mysql_result($laboratory_rs, $s, "visit_id");
					$visit_time_lab = mysql_result($laboratory_rs, $s, "visit_time");
					
					$get2 = new Lab();
					$rs2 = $get2->get_patient_lab_visit($visit_id);
					$rows = mysql_num_rows($rs2);
					
					if($rows > 0){
						
						$strath_no = mysql_result($rs2, 0, "strath_no");
						$strath_type = mysql_result($rs2, 0, "strath_type");
						$id = mysql_result($rs2, 0, "patient_id");
						
						if($strath_type == 1){
							
							$get2 = new Lab;
							$rs2 = $get2->get_patient_2($strath_no);
							$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
							while (OCIFetch($rs2)) {
								$name = ociresult($rs2, "OTHER_NAMES");
								$secondname = ociresult($rs2, "SURNAME");
							}
						}
						
						else if($strath_type == 2){
			
							$get2 = new Lab;
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
				echo"
                        	<tr>
                            	<td align='left'><a href='#' onclick='set_patient_details_lab(".$id.", ".$visit_id.",1)'>".$name." ".$secondname."</a>
                                </td>
                                <!--appointment-->
                                <!--serverity-->
                                <td>".$visit_time_lab."</td>
                            </tr>
           
                   "; 
				   
				   }
				   echo"
                    </table>
                    
                   <table align='center'>
        				<tr>
						<td><a href='#' onclick='next_lab_only(".$previous_page_laboratory.")' class='modify2'><img src='../administration/images/back_alt.png'/></a></td>";
                        
							for($t = 1; $t <= $num_pages_laboratory; $t++){
								echo "<td width='10' <a href='#' onclick='next_doctor_queue(".$t.")' class='modify'>".$t."</a></td>";
								
							}
							echo"<td><a href='#' onclick='next_lab_only(".$next_page_laboratory.")' class='modify2'><img src='../administration/images/forward_alt.png'/></a></td>
            		</table>
            	";
				?>
