<?php
session_start();
include '../../classes/class_nurse.php';

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$get4 = new nurse();
$vaccine_rs = $get4->get_vaccines();
$num_vaccines = mysql_num_rows($vaccine_rs);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Vaccines</p></div>
			<table align='center' class='table table-striped table-hover table-condensed'>
				<tr>
                        <th>Vaccine</th>
                        <th>Yes</th>  
                        <th>No</th> 
						</tr>
					";
						for($z = 0; $z < $num_vaccines; $z++){
							
							$vaccine_id = mysql_result($vaccine_rs, $z, "vaccine_id");
							$vaccine_name = mysql_result($vaccine_rs, $z, "vaccine");
							
	$get_vaccinne = new nurse;
	$rs = $get_vaccinne->check_vaccine($patient_id, $vaccine_id);
	$num_patient_vaccine = mysql_num_rows($rs);
	
	if($num_patient_vaccine ==0 ){
	
		echo "	
                             <tr>  
                                <td align='left'>".$vaccine_name."</td>
                                <td ><input id='yes".$vaccine_id."' type='checkbox' value='".$vaccine_id."'onclick='save_vaccine(".$vaccine_id.", 1, ".$visit_id.")'/></td>
								<td align='right'><input id='no".$vaccine_id."' type='checkbox' value='".$vaccine_id."' onclick='save_vaccine(".$vaccine_id.", 0, ".$visit_id.")'/></td>
                              </tr>
								";
	}
		
	else {
			$status = mysql_result($rs, 0, "status_id");
			$patient_vaccine_id = mysql_result($rs, 0, "patient_vaccine_id");
			if ($status == 1){
				
				echo "	
                             <tr>  
                                <td align='left'>".$vaccine_name."</td>
                                <td ><input id='yes".$vaccine_id."' type='checkbox' value='".$vaccine_id."'onclick='delete_vaccine(".$patient_vaccine_id.", ".$visit_id.")' checked='checked'/></td>
								<td align='right'><input id='no".$vaccine_id."' type='checkbox' value='".$vaccine_id."' onclick='save_vaccine(".$vaccine_id.", 0, ".$visit_id.")'/></td>
                              </tr>
								";
			}
				
			else{
						echo "	
                             <tr>  
                                <td align='left'>".$vaccine_name."</td>
                                <td ><input id='yes".$vaccine_id."' type='checkbox' value='".$vaccine_id."'onclick='save_vaccine(".$vaccine_id.", 1, ".$visit_id.")' /></td>
								<td align='right'><input id='no".$vaccine_id."' type='checkbox' value='".$vaccine_id."' onclick='delete_vaccine(".$patient_vaccine_id.", ".$visit_id.")' checked='checked'/></td>
                              </tr>
								";
					}
			}
			
		}
                      echo "
                        </table>";
						
                     