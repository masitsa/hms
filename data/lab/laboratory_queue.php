<?php
session_start();
include '../../classes/class_lab.php';

$get = new Lab();
$rs = $get->get_visits();
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
                        	<th></th>
                            <th width='200'>Entry Time</th>
                        </tr>
						";
				for($s = $current_item; $s < $end_item; $s++){
			
					$visitid = mysql_result($rs, $s, "visit_id");
					
					$get2 = new Lab();
					$rs2 = $get2->get_patient($visitid);
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
							$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
							$name = mysql_result($rs2, 0, "Other_Name");
							$secondname = mysql_result($rs2, 0, "Surname");
						}
						
						else{
							$name = mysql_result($rs2, 0, "patient_surname");
							$secondname = mysql_result($rs2, 0, "patient_firstname")." ".mysql_result($rs2, 0, "patient_middlename");
						}
					}
					
					$get_vitals_alert = new Lab();
					$rs3 = $get_vitals_alert->get_vitals_alert($visitid);
					$num_rs3 = mysql_num_rows($rs3);
					
					if($num_rs3 >0){
					$vitals_alert = mysql_result($rs3, 0, "vitals_alert");
					}
					if($vitals_alert == 0){
						
						$image = "green.png";
					}
					
					else if($vitals_alert == 1){
						
						$image = "level1.gif";
					}
					
					else if($vitals_alert == 2){
						
						$image = "level2.gif";
					}
					
					else if($vitals_alert == 3){
						
						$image = "level2.gif";
					}
					
					else if($vitals_alert == 4){
						
						$image = "level3.gif";
					}
			echo"
                        	<tr>
                            	<td align='left'><a href='#' onclick='set_patient_details_lab(".$id.", ".$visitid.",1)'>".$name." ".$secondname."</a>
                                </td>
                                <td></td><!--appointment-->
                                <td><img src='../administration/images/levels/".$image."'/></td><!--serverity-->
                                <td>".$vitals_time_doc."</td>
                            </tr>
           
                   ";
				    }echo"
                    </table>
                    
                    <table align='center'>
        				<tr>
						<td><a href='#' onclick='next_lab_queue(".$previous_page.")' class='modify2'><img src='../administration/images/back_alt.png'/></a></td>";
                        
							for($t = 1; $t <= $num_pages; $t++){
								echo "<td width='10' <a href='#' onclick='next_doctor_queue(".$t.")' class='modify'>".$t."</a></td>";
								
							}
							echo"<td><a href='#' onclick='next_lab_queue(".$next_page.")' class='modify2'><img src='../administration/images/forward_alt.png'/></a></td>
            		</table>
            		</table>
					";
?>