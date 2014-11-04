<?php
session_start();

$visitid = $_SESSION['visit_id'];
echo"
	<input name='to_lab' type='button' value='lab' onclick='open_window_lab(".$visitid.")'/>
";

?>