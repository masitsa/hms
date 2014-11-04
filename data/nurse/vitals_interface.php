<?php
$visit_id = $_GET['visit_id'];
echo '
	<div class="navbar-inner"><p style="text-align:center; color:#0e0efe;">Vitals</p></div>

	<table class="table table-striped table-hover table-condensed">
		<tr>
        	<td>Blood Pressure</td>
            <td>Systolic</td>
			<td><input type="text" id="vital5" onkeyup = "save_vital('.$visit_id.', 5)"/></td>
			<td id="display5"></td>
		</tr>
		<tr>
        	<td></td>
            <td>Diastolic</td>
			<td><input type="text" id="vital6" onkeyup = "save_vital('.$visit_id.', 6)"/></td>
			<td id="display6"></td>
		</tr>
		<tr>
        	<td>BMI</td>
            <td>Weight (Kg)</td>
			<td><input type="text" id="vital8" onkeyup = "save_vital('.$visit_id.', 8)"/></td>
			<td id="display8"></td>
		</tr>
		<tr>
        	<td></td>
            <td>Height (m)</td>
			<td><input type="text" id="vital9" onkeyup = "save_vital('.$visit_id.', 9)"/></td>
			<td id="display9"></td>
		</tr>
		<tr>
        	<td></td>
            <td></td>
			<td></td>
			<td id="bmi_out"></td>
		</tr>
		<tr>
        	<td>Hip / Waist</td>
            <td>Hip</td>
			<td><input type="text" id="vital4" onkeyup = "save_vital('.$visit_id.', 4)"/></td>
			<td id="display4"></td>
		</tr>
		<tr>
        	<td></td>
            <td>Waist</td>
			<td><input type="text" id="vital3" onkeyup = "save_vital('.$visit_id.', 3)"/></td>
			<td id="display3"></td>
		</tr>
		<tr>
        	<td></td>
            <td></td>
			<td></td>
			<td id="hwr_out"></td>
		</tr>
		<tr>
        	<td>Temperature</td>
            <td></td>
			<td><input type="text" id="vital1" onkeyup = "save_vital('.$visit_id.', 1)"/></td>
			<td id="display1"></td>
		</tr>
		<tr>
        	<td>Pulse</td>
            <td></td>
			<td><input type="text" id="vital7" onkeyup = "save_vital('.$visit_id.', 7)"/></td>
			<td id="display7"></td>
		</tr>
		<tr>
        	<td>Respiration</td>
            <td></td>
			<td><input type="text" id="vital2" onkeyup = "save_vital('.$visit_id.', 2)"/></td>
			<td id="display2"></td>
		</tr>
		<tr>
        	<td>Oxygen Saturation</td>
            <td></td>
			<td><input type="text" id="vital11" onkeyup = "save_vital('.$visit_id.', 11)"/></td>
			<td id="display11"></td>
		</tr>
		<tr>
        	<td>Pain</td>
            <td></td>
			<td><input type="text" id="vital10" onkeyup = "save_vital('.$visit_id.', 10)"/></td>
			<td id="display10"></td>
		</tr>
	</table>

';

?>