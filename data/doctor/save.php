<?php
session_start();

include("../../classes/class_doctor.php");
$visit_id = $_GET['visit_id'];
$item = $_GET['item'];

if($item == "sypmtoms"){
	
	$symptoms = $_GET['symptoms'];
	
	$save = new doctor();
	$save->save_symptoms($symptoms, $visit_id);
}

else if($item == "objective_findings"){
	
	$objective_findings = $_GET['objective_findings'];
	
	$save = new doctor();
	$save->save_objective_findings($objective_findings, $visit_id);
}

else if($item == "assessment"){
	
	$assessment = $_GET['assessment'];
	
	$save = new doctor();
	$save->save_assessment($assessment, $visit_id);
}

else if($item == "plan"){
	
	$plan = $_GET['plan'];
	
	$save = new doctor();
	$save->save_plan($plan, $visit_id);
}

?>