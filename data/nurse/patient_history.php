<?php
session_start();
include "../../classes/class_nurse.php";
	
$get = new nurse();
$disease_rs = $get->get_family_disease();
$num_disease = mysql_num_rows($disease_rs);

$get3 = new nurse();
$family_rs = $get->get_family();
$num_family = mysql_num_rows($family_rs);

$history =  "<table align='center'> <td></td>";

for ($a = 0; $a < $num_disease; $a++){
	
	for($b = 0; $b < $num_family; $b++){
		
		if($b==0){
			$disease = mysql_result($disease_rs, $a, "fd_disease_name");
			$fd_id = mysql_result($disease_rs, $a, "fd_id");
			if($a==0){
				
				$history =  $history."<tr> <td> </td>";
			}
			
			else{
				$history =  $history."<tr> <td>".$disease."</td>";
			}
		}
		
		else if($a==0){
			
			$family = mysql_result($family_rs, $b, "family_relationship");
			$family_id = mysql_result($family_rs, $b, "family_id");
			$history =  $history."<td>".$family."</td>";
		}
		
		else{
			
			$fd_id = mysql_result($disease_rs, $a, "fd_id");
			$family_id = mysql_result($family_rs, $b, "family_id");
			
			$get4 = new nurse();
			$rs_history = $get4->get_family_history($family_id, $_SESSION['patient_id'],$fd_id);
			$num_history = mysql_num_rows($rs_history);
			
			if($num_history == 0){
				$fh_id = 0;
				$checked = "";
			}
			
			else{
				$fh_id = mysql_result($rs_history, 0, "fh_id");
				$checked = "checked='checked'";
			}

			$history =  $history."<td><input type='checkbox' id='checkbox".$fd_id.$family_id."' onclick='save_condition(".$fd_id.",".$family_id.", ".$fh_id.")' ".$checked."></td>  ";
		}
	}
}

$history =  $history."</table>";

echo $history;