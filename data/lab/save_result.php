<?php
session_start();
include "../../classes/class_lab.php";

$visit = $_SESSION['visit_id'];
$visit_charge = $_GET["id"];
$result = $_GET['result'];

$save = new Lab();
$save->save_tests($result, $visit_charge);

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