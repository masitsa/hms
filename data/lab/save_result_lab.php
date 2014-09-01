<?php
include "../../classes/class_lab.php";

$visit_charge_id = $_GET['id'];
$result = $_GET['result'];
$format = $_GET['format'];
$visit_id = $_GET['visit_id'];


$save = new Lab();
$save->save_tests_format2($result,$format,$visit_id);

echo
		"
			<div style='width: 60px;'>
					<table style='width: 60px;'>
						<tr class='info'>
							<td>".$result."</td>
						</tr>
					</table></div>
		";
?>