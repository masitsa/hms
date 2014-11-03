<?php
include "../../classes/class_nurse.php";

$visit_id = $_GET['visit_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);
$patient_id = mysql_result($rs, 0, "patient_id");

$get = new nurse();
$surgery_rs = $get->get_surgeries($patient_id);
$num_surgeries = mysql_num_rows($surgery_rs);

echo
"
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Surgeries</p></div>
			<table align='center' class='table table-striped table-hover table-condensed'>
		<tr>
			<th>Year</th>
			<th>Month</th>
			<th>Description</th>
			<th></th>
		</tr>
";

for($r = 0; $r < $num_surgeries; $r++){
	
	$date = mysql_result($surgery_rs, $r, "surgery_year");
	$month = mysql_result($surgery_rs, $r, "month_name");
	$description = mysql_result($surgery_rs, $r, "surgery_description");
	$id = mysql_result($surgery_rs, $r, "surgery_id");
	echo
	"
			<tr>
				<td>".$date."</td>
				<td>".$month."</td>
				<td>".$description."</td>
				<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_surgery(".$id.", ".$visit_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
				</td>
			</tr>
	";
}

echo
"
	<tr>
		<td valign='top'><input type='text' id='datepicker' autocomplete='off' size='5'/></td>
		<td valign='top'>
			<select id='month'>
				<option>January</option>
				<option>February</option>
				<option>March</option>
				<option>April</option>
				<option>May</option>
				<option>June</option>
				<option>July</option>
				<option>August</option>
				<option>September</option>
				<option>October</option>
				<option>November</option>
				<option>December</option>
			</select>
		</td>
        <td><textarea id='surgery_description' rows='2' cols='30'></textarea></td>
        <td><input type='button' class='btn' value='Save' onclick='save_surgery(".$visit_id.")' /></td>
    </tr>
 </table>
";
?>