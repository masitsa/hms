<?php

session_start();

include 'connection.php';

class expenses{
	function get_doctor(){
		$sql="select * from personnel where authorise!=0 ";
		//echo $sql;
		$get= new Database;
		$rs= $get->select($sql);
		return $rs;
		
		}
	function get_doctor_consults(){
		$sql="select * from visit where personelle_id=$personnel_id";
		//echo $sql;
		$get= new Database;
		$rs= $get->select($sql);
		return $rs;
		
		}
	
	
	
}
?>