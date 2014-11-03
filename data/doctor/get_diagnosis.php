<?php 
include ("../../classes/class_doctor.php");

$visit_id = $_GET['visit_id'];

$get = new doctor();
$rs = $get->get_diagnosis($visit_id);
$num_rows = mysql_num_rows($rs);
//echo $num_rows;
		
if($num_rows > 0){

	echo
	"
			<table class='table table-striped table-hover table-condensed'>
				<tr>
					<th></th>
					<th>Code</th>
					<th>Disease</th>
				</tr>";
	
	for($t = 0; $t < $num_rows; $t++){
		$diagnosis_id = mysql_result($rs, $t, "diagnosis_id");
		$name = mysql_result($rs, $t, "diseases_name");
		$code = mysql_result($rs, $t, "diseases_code");
		
		echo "<tr>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_diagnosis(".$diagnosis_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
				<td>".$code."</td>
				<td>".$name."</td></tr>";
	}
}
echo"</table><table align='center'><tr align='center'><td><input type='button' class='btn btn-large' onClick='closeit(1, ".$visit_id.")' value='Done'/></td></tr></table>";
?>