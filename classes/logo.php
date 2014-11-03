<?php
include "connection.php";

header("Content-type: image/jpeg");

class Logo{
	
	function get_logo(){
		
		$sql = "SELECT agency_logo FROM agency";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
}

$get = new Logo;
$rs = $get->get_logo();
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	
	echo mysql_result($rs, 0, "agency_logo");
}