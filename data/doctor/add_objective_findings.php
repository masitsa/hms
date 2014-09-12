<?php 
include '../../classes/class_doctor.php';
$visit_id = $_GET['visit_id'];
$objective_finding_id =$_GET['objective_findings_id'];
$description= $_GET['id'];
$update_id=$_GET['update_id'];
 if($update_id==1){
$update_obj= new doctor();
$update_objz= $update_obj->update_objective_finding($objective_finding_id, $visit_id, $description);

 }else{
	 $get_name = new doctor();
$get_namez= $get_name->save_objective_finding($objective_finding_id, $visit_id);
 }
$get = new doctor;
$rs = $get->get_objective_findings($visit_id);
$num_rows = mysql_num_rows($rs);

$get2 = new doctor;
$rs2 = $get2->get_visit_objective_findings($visit_id);
$num_rows2 = mysql_num_rows($rs2);

echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Objective Findings <br/><input type='button' class='btn btn-primary' value='Add Objective Findings' onclick='open_objective_findings(".$visit_id.")'/></p></div>";

if($num_rows2 > 0){
	echo"
		<table align='center' class='table table-striped table-hover table-condensed'>
		<tr>
			<th></th>
			<th>Class</th>
			<th>Objective Findings</th>
			<th></th>
		</tr>
	";	
	
	for($z = 0; $z < $num_rows2; $z++){
		
		$count=$z+1;
		$objective_findings_name = mysql_result($rs2, $z, "objective_findings_name");
		$visit_objective_findings_id = mysql_result($rs2, $z, "visit_objective_findings_id");
		$objective_findings_class_name = mysql_result($rs2, $z, "objective_findings_class_name");
		echo"
		<tr> 
			<td>".$count."</td>
			<td>".$objective_findings_class_name."</td>
 			<td align='center'>".$objective_findings_name."</td>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_objective_findings(".$visit_objective_findings_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
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
	$visit_objective_findings = mysql_result($rs, 0, "visit_objective_findings");
	echo
	"	<table align='left'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms1' disabled='disabled'>"; for($z = 0; $z < $num_rows2; $z++){
		
		$count=$z+1;
		$objective_findings_name = mysql_result($rs2, $z, "objective_findings_name");
		$visit_objective_findings_id = mysql_result($rs2, $z, "visit_objective_findings_id");
		$objective_findings_class_name = mysql_result($rs2, $z, "objective_findings_class_name");
		$description= mysql_result($rs2, $z, "description");
		
		
		echo $objective_findings_class_name.":".$objective_findings_name." ->".$description."\n" ;
} echo $visit_objective_findings; echo "
</textarea>
				</td>
			</tr>
		</table>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='objective_findings' onKeyUp='save_symptoms(".$visit_id.")'>".$visit_objective_findings."asasas</textarea>
				</td>
			</tr>
		</table>
	";
}

else{
	echo
	"		<table align='left'>
			<tr>
				<td>
					<textarea rows='5' cols='100' id='visit_symptoms' disabled='disabled'>"; for($z = 0; $z < $num_rows2; $z++){
		
		$count=$z+1;
		$objective_findings_name = mysql_result($rs2, $z, "objective_findings_name");
		$visit_objective_findings_id = mysql_result($rs2, $z, "visit_objective_findings_id");
		$objective_findings_class_name = mysql_result($rs2, $z, "objective_findings_class_name");
		
		echo $objective_findings_name.":".$objective_findings_class_name." ->".$description."\n" ;
} echo $visit_objective_findings; echo "
</textarea>
				</td>
			</tr>
		<table align='center'>
			<tr>
				<td>
					<textarea rows='5' cols='100'id='objective_findings' onKeyUp='save_symptoms(".$visit_id.")'>1234</textarea>
				</td>
			</tr>
		</table>
	";
}
?>

<script type="text/javascript">
	
	function save_symptoms(visit_id){
	//alert('jhjh');
		var XMLHttpRequestObject = false;
		
	if (window.XMLHttpRequest) {
	
		XMLHttpRequestObject = new XMLHttpRequest();
	} 
		
	else if (window.ActiveXObject) {
		XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var objective_findings = document.getElementById("objective_findings").value;
	window.alert("what the hell");
	
	var url = host+"data/nurse/save_objective_finding/symptoms="+symptoms+"&item=sypmtoms&visit_id="+visit_id;
	
	if(XMLHttpRequestObject) {
		
		//var obj = window.opener.document.getElementById("symptoms_");
				
		XMLHttpRequestObject.open("GET", url);
				
		XMLHttpRequestObject.onreadystatechange = function(){
			
			if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

				//obj.innerHTML = XMLHttpRequestObject.responseText;
			}
		}
				
		XMLHttpRequestObject.send(null);
	}
}
</script>