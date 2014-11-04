<?php

include 'connection2.php';

class Strathmore_population{
	
	function get_students($strath_no)
	{
		$sql= "SELECT Surname, Other_names FROM student WHERE student_Number = '".$strath_no."'";
		
		$get = new Database_connection();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_staff($strath_no)
	{
		$sql= "SELECT Surname, Other_names FROM staff WHERE Staff_Number = '".$strath_no."'";
		
		$get = new Database_connection();
		$rs = $get->select($sql);
		return $rs;
	}
}
?>