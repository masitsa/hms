<?php
include "connection.php";

$sql = "SELECT drugs_id, quantity FROM drugs";
$get = new Database;
$rs = $get->select($sql);
$num_rows = mysql_num_rows($rs);

for($r = 0; $r < $num_rows; $r++){
	$drugs_id = mysql_result($rs, $r, "drugs_id");
	$quantity = mysql_result($rs, $r, "quantity");
	//$id = mysql_result($rs, $r, "lab_test_format_id");
	$class = addslashes(ucwords(strtolower($item)));
	$number = intval($item);
	/*$sql2 = "SELECT * FROM generic WHERE generic_name = '$class'";
	$get2 = new Database;
	$rs2 = $get2->select($sql2);
	$num_rows2 = mysql_num_rows($rs2);
	
	if($num_rows2 == 0){
		$sql3 = "INSERT INTO generic (generic_name) VALUES ('$class')";
		echo $sql3."<br/>";
		$save = new Database;
		$save->insert($sql3);
	}*/
	if($quantity > 0){
		$sql2 = "INSERT INTO purchase (drugs_id, container_type_id, purchase_pack_size, purchase_quantity) VALUES ($drugs_id, 1, $quantity, 1)";
		echo $sql2."<br/>";
		$save = new Database;
		$save->insert($sql2);
	}
}
/*$sql = "SELECT * FROM drugs2";
$get = new Database;
$rs = $get->select($sql);
$num_rows = mysql_num_rows($rs);

for($r = 0; $r < $num_rows; $r++){
	
	$generic = addslashes(ucwords(strtolower(mysql_result($rs, $r, "drugs_generic"))));
	$generic = addslashes(ucwords(strtolower(mysql_result($rs, $r, "drugs_generic"))));
	$drugs_class = addslashes(ucwords(strtolower(mysql_result($rs, $r, "drugs_class"))));
	$type = addslashes(ucwords(strtolower(mysql_result($rs, $r, "drugs_type"))));
	$id = addslashes(ucwords(strtolower(mysql_result($rs, $r, "drugs_id"))));
	$class = addslashes(ucwords(strtolower($item)));
	
	$sql2 = "UPDATE drugs2 SET 
		generic_id = (SELECT generic_id FROM generic WHERE generic_name = '$generic'),
		generic_id = (SELECT generic_id FROM generic WHERE generic_name = '$generic'),
		class_id = (SELECT class_id FROM class WHERE class_name = '$drugs_class'),
		drug_type_id = (SELECT drug_type_id FROM drug_type WHERE drug_type_name = '$type')
		
		WHERE drugs_id = $id";
	echo $sql2."<br/>";
	$save = new Database;
	$save->insert($sql2);
}*/

?>