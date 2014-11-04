<?php
session_start();
include "../../classes/class_lab.php";

$visit = $_SESSION['visit_id'];
$visit_charge_id = $_GET['id'];
$res = $_GET['result'];

		$get_ = new Lab();
		$get_rs = $get_->save_lab_comments($res, $visit_charge_id);
		$num_rows = mysql_num_rows($get_rs);
		
		
		if ($num_rows == 0){
		$sql ="INSERT INTO lab_visit_format_comment (lab_visit_format_comments,visit_charge_id) VALUES ('$res',$visit_charge_id)";
		echo $sql;		
		$save = new Database();
		$save->insert($sql);
			
			}else{
		
		$sql = "UPDATE lab_visit_format_comment SET lab_visit_format_comments = '$res' WHERE visit_charge_id = $visit_charge_id";
		echo $sql;
		$save = new Database();
		$save->insert($sql);
			} 


echo
		"
			<div style='width: 60px;'>
					<table style='width: 60px;'>
						<tr class='info'>
							<td>". T.$result."</td>
						</tr>
					</table></div>
		";
?>