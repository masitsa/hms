<?php
session_start();
include '../../classes/class_nurse.php';

$personnel_id = $_SESSION['personnel_id'];
$page = $_GET['page'];
$date = date("y-m-d");

if($page == 1){
	$get = new nurse;
	$rs_queue = $get->get_queue($date);
	$num_queue = mysql_num_rows($rs_queue);
	$session = "nurse_queue";
}

else if ($page == 2){
	$get = new nurse;
	$rs_queue = $get->get_doc_queue($date,$personnel_id);
	$num_queue = mysql_num_rows($rs_queue);
	$session = "doctor_queue";
}

else if ($page == 3){
	$get = new nurse;
	$rs_queue = $get->get_lab_queue($date);
	$num_queue = mysql_num_rows($rs_queue);
	$session = "lab_queue";
}

else if ($page == 4){
	$get = new nurse;
	$rs_queue = $get->get_pharmacy_queue($date);
	$num_queue = mysql_num_rows($rs_queue);
	$session = "pharmacy_queue";
			
}
else if($page ==5){
$get = new nurse;
$accounts_que_rs = $get->get_patient_charges();
$num_accounts_rows = mysql_num_rows($accounts_que_rs);
$session = "accounts_queue";
	}
//echo $num_queue."<br>";
if((empty($_SESSION[$session])) && ($num_queue > 0)){
	
	$_SESSION[$session] = $num_queue;
	
	$response = "increase";
}

else if($_SESSION[$session] < $num_queue){
	
	$_SESSION[$session] = $num_queue;
	
	$response = "increase";
}

/*else{
	
	$response = "normal";
}*/

echo $response;
?>