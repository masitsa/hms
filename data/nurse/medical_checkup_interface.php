<?php
 $visit_id = $_GET['visit_id'];

echo '<div class="navbar-inner"><p style="text-align:center; color:#0e0efe;">Medical Check Up</p></div>

	<table class="table table-striped table-hover table-condensed">
		
		<tr>
            <td>Present Illnesses</td>
			<td><textarea  id="present_illness" onkeyup = "save_checkup('.$visit_id.', 5)"></textarea></td>
			<td id="display5"></td>
		</tr>
		<tr>
            <td>Past Illnesses</td>
			<td><textarea  id="present_illness" onkeyup = "save_checkup('.$visit_id.', 5)"></textarea></td>
			<td id="display5"></td>
		</tr>
		<tr>
            <td>Family History</td>
			<td> <div id="history"></div></td>
			<td id="display5"></td>
		</tr>
	</table>
	</div>
	<div class="navbar-inner"><p style="text-align:center; color:#0e0efe;">Physiological History</p></div>
	<table>
	<tr>
            <td>Family History</td>
			<td> <div id="history"></div></td>
			<td id="display5"></td>
		</tr>


	</table>


		</div>
';





?>