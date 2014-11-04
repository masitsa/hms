<?php 
include '../../classes/class_doctor.php';
$visit_id = $_GET['visit_id'];
$symptoms_id =$_GET['symptoms_id'];
$status = $_GET['status'];
$description= $_GET['id'];

if ($status==0){
$get_name = new doctor();
$get_name->update_visit_sypmtom($symptoms_id,$visit_id,$description);
}else{

$get_name = new doctor();
$get_name->save_visit_sypmtom($symptoms_id,$visit_id,$status);
}

$get = new doctor;
$rs = $get->get_symptoms($visit_id);
$num_rows = mysql_num_rows($rs);

$get2 = new doctor;
$rs2 = $get2->get_visit_symptoms($visit_id);
$num_rows2 = mysql_num_rows($rs2);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Symptoms <br/><input type='button' class='btn btn-primary' value='Add Symptoms' onclick='open_symptoms(".$visit_id.")'/></p></div>";

if($num_rows2 > 0){
	echo"
		<table align='center' class='table table-striped table-hover table-condensed'>
		<tr>
			<th></th>
			<th>Symptom</th>
			<th>Description</th>
			<th></th>
		</tr>
	";	
	
	for($z = 0; $z < $num_rows2; $z++){
		
		$count=$z+1;
		$symptoms_name = mysql_result($rs2, $z, "symptoms_name");
		$status_name = mysql_result($rs2, $z, "status_name");
		$visit_symptoms_id = mysql_result($rs2, $z, "visit_symptoms_id");
		echo"
		<tr> 
			<td>".$count."</td>
 			<td align='center'>".$symptoms_name."</td>
 			<td align='center'>".$status_name."</td>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_symptom(".$visit_symptoms_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
		</tr>	
		";
	}
echo"
 </table>
";
}
	
if($num_rows > 0){
	$visit_symptoms = mysql_result($rs, 0, "visit_symptoms");
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms' onKeyUp='save_symptoms(".$visit_id.")'>".$visit_symptoms."</textarea>
				</td>
			</tr>
		</table>
	";
}

else{
	echo
	"
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms' onKeyUp='save_symptoms(".$visit_id.")'></textarea>
				</td>
			</tr>
		</table>
	";
}
?>
