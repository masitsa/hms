<?php
include 'connection.php';

class doctor{
	
	function get_lab_test_id($service_charge_id){
		
		$sql = "SELECT lab_test_id FROM service_charge WHERE  service_charge_id = '$service_charge_id'";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return mysql_result($rs, 0, "lab_test_id");
	}
	
	function get_lab_visit2($visit_id){
		
		$sql = "SELECT lab_visit FROM visit WHERE visit_id = $visit_id";
		//echo $sql;
		$get = new Database();
		return $get->select($sql);
	}
	
	function get_patient_id($visit_id){
		
		$sql = "SELECT patients.patient_id FROM patients, visit WHERE visit.visit_id = $visit_id AND visit.patient_id = patients.patient_id";
		
		$get = new Database();
		return $get->select($sql);
	}
	
	function get_doctor_notes($patient_id){
		
		$sql = "SELECT * FROM doctor_notes WHERE patient_id = $patient_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_doctor_notes($doctor_notes, $patient_id){	
		$get = new doctor();
		$rs = $get->get_doctor_notes($patient_id);
		$num_doc_notes = mysql_num_rows($rs);
		
		if($num_doc_notes == 0){	
			$sql = "INSERT INTO doctor_notes (patient_id, doctor_notes) VALUES ($patient_id, '$doctor_notes')";
			
		}
		else {
		
			$sql = "UPDATE doctor_notes SET doctor_notes = '$doctor_notes' WHERE patient_id = $patient_id";
		}
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_symptoms($visit_id){
		
		$sql = "SELECT visit_symptoms FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_visit_symptoms($visit_id){
		
		$sql = "SELECT  visit_symptoms.description, symptoms.symptoms_name, status.status_name, visit_symptoms.visit_symptoms_id FROM status, visit_symptoms, symptoms WHERE visit_symptoms.visit_id = $visit_id AND visit_symptoms.symptoms_id = symptoms.symptoms_id AND visit_symptoms.status_id = status.status_id ";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	
	function get_symptom_list(){
		
		$sql = "SELECT * FROM symptoms ORDER BY symptoms_name";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function search_symptom_list($search){
		
		$sql = "SELECT * FROM symptoms WHERE symptoms_name LIKE '%$search%' ORDER BY symptoms_name";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
function save_visit_sypmtom($symptoms_id,$visit_id,$status){
		
		$sql = "INSERT INTO visit_symptoms (visit_id,symptoms_id,status_id) VALUES ($visit_id,$symptoms_id,$status)";
		
		
		$save = new Database;
		$save->insert($sql);
	}
function update_visit_sypmtom($symptoms_id,$visit_id,$description){
		
		$sql = "UPDATE  `sumc`.`visit_symptoms` SET  `description` = '$description' WHERE  `visit_symptoms`.`symptoms_id` ='$symptoms_id' AND `visit_symptoms`.`visit_id` ='$visit_id'";
		
		
		$save = new Database;
		$save->insert($sql);
	}
	
	
function delete_visit_symptom($visit_symptom_id){
		
		$sql = "DELETE FROM visit_symptoms WHERE visit_symptoms_id = $visit_symptom_id";
		
		$delete = new Database;
		$delete->insert($sql);
	}
	
	function save_symptoms($symptoms, $visit_id){
		
		$sql = "UPDATE visit SET visit_symptoms = '$symptoms' WHERE visit_id = $visit_id";
		////echo$sql;
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_objective_findings($visit_id){
		
		$sql = "SELECT visit_objective_findings FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_visit_objective_findings($visit_id){
		
		$sql = "SELECT objective_findings.objective_findings_name, objective_findings_class.objective_findings_class_name, objective_findings.objective_findings_id, visit_objective_findings.visit_objective_findings_id,visit_objective_findings.description
		
		FROM objective_findings, objective_findings_class, visit_objective_findings
		
		WHERE objective_findings_class.objective_findings_class_id = objective_findings.objective_findings_class_id 
		AND visit_objective_findings.`objective_findings_id` = objective_findings.objective_findings_id
		AND visit_objective_findings.visit_id = $visit_id
		
		ORDER BY objective_findings_class_name, objective_findings_name";
	
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_objective_finding($objective_finding_id, $visit_id){
	$sql = "INSERT INTO  `sumc`.`visit_objective_findings` (`visit_id` ,`objective_findings_id`)
VALUES ('$visit_id','$objective_finding_id')";
		
		$save = new Database;
		$save->insert($sql);
	}
	function update_objective_finding($objective_finding_id, $visit_id, $description){
		
		$sql = "UPDATE visit_objective_findings  SET description='$description' WHERE objective_findings_id = '$objective_finding_id' AND visit_id = '$visit_id'";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function delete_visit_objective_findings($visit_objective_findings_id){
		
		$sql = "DELETE FROM visit_objective_findings WHERE visit_objective_findings_id = '$visit_objective_findings_id'";	
		$save = new Database;
		$save->insert($sql);
	}
	
	function save_objective_findings($objective_findings, $visit_id){
		
		$sql = "UPDATE visit SET visit_objective_findings = '$objective_findings' WHERE visit_id = $visit_id";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	
	function get_assessment($visit_id){
		
		$sql = "SELECT visit_assessment FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_assessment($assessment, $visit_id){
		
		$sql = "UPDATE visit SET visit_assessment = '$assessment' WHERE visit_id = $visit_id";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_plan($visit_id){
		
		$sql = "SELECT visit_plan FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_plan($plan, $visit_id){
		
		$sql = "UPDATE visit SET visit_plan = '$plan' WHERE visit_id = $visit_id";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_labtests($order, $visit_id,$visit_t ){
		
		$sql = "SELECT service_charge.service_charge_amount, service_charge.service_charge_id, service_charge.service_charge_name, lab_test_class.lab_test_class_name
		
		FROM `service_charge`, lab_test_class, lab_test
		
		WHERE service_charge.service_charge_name = lab_test.lab_test_name
		AND lab_test_class.lab_test_class_id = lab_test.lab_test_class_id
		AND service_charge.visit_type_id = $visit_t
		AND service_charge.service_id = 5 
		
		ORDER BY '$order'";////echo$sql;
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function search_lab_test($search, $order, $visit_id,$visit_t ){
		
		$sql5= "SELECT service_charge.service_charge_amount, service_charge.service_charge_id, service_charge.service_charge_name, lab_test_class.lab_test_class_name
		
		FROM `service_charge`, lab_test_class, lab_test
		
		WHERE service_charge.service_charge_name = lab_test.lab_test_name
		AND service_charge.visit_type_id = $visit_t
		AND lab_test_class.lab_test_class_id = lab_test.lab_test_class_id
		AND service_charge.service_id = 5  
		AND service_charge_name LIKE '%$search%' 
		
		ORDER BY '$order'";
			
		$get5= new Database;
		$rs5=$get5->select($sql5);
		return $rs5;
	}

	function get_visits_lab_result($visit_id, $lab_id){
		$sql = "SELECT lab_test_format_id FROM lab_test_format WHERE  lab_test_id = $lab_id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		
	}
	
	function save_lab_visit($visit_id, $service_charge_id){
		
		$sql = "INSERT INTO visit_charge (visit_id, service_charge_id,visit_charge_amount) VALUES ($visit_id, $service_charge_id, (select service_charge_amount from service_charge where service_charge_id=$service_charge_id))";
		//echo $sql;
		$save = new Database();
		$save->insert($sql);
	}
	
	function save_lab_visit_format($visit_id, $service_charge_id, $lab_test_format_id){
		
		$sql = "INSERT INTO lab_visit_results (visit_charge_id, lab_visit_result_format, visit_id) VALUES ((SELECT visit_charge_id FROM visit_charge WHERE visit_id = '$visit_id' AND service_charge_id = $service_charge_id),'$lab_test_format_id', $visit_id)";
				
	//	echo $sql."</br>";
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_lab_test($visit_id){
		
		$sql = "SELECT service_charge.service_charge_name AS lab_test_name, (SELECT lab_test_class.lab_test_class_name FROM lab_test_class WHERE lab_test.lab_test_class_id = lab_test_class.lab_test_class_id ) AS class_name, service_charge.service_charge_amount AS lab_test_price, visit_charge.visit_charge_id AS lab_visit_id
		
		FROM lab_test, visit_charge, service_charge, lab_test_class
		
		WHERE visit_charge.visit_id = '$visit_id' 
		AND visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id";
	//	//echo$sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_lab_visit($visit_id, $service_charge_id){
		
		$sql = "SELECT * FROM visit_charge WHERE visit_id = $visit_id AND service_charge_id = $service_charge_id";
	//	//echo$sql;
		$get5= new Database;
		$rs5=$get5->select($sql);
		return $rs5;
	}
	
	function update_lab_visit($visit_id,$lab_id){
		
		$sql = "UPDATE visit_charge SET lab_test_id = $lab_id WHERE visit_id = $visit_id";
		////echo$sql;
		$save = new Database();
		$save->insert($sql);
	}
	
	function delete_lab_visit($id){
		
		$sql = "DELETE FROM visit_charge WHERE visit_charge_id = $id";
		
		$delete = new Database();
		$delete->insert($sql);
	}
	
	function get_diseases($code){
		
		$sql = "SELECT * FROM diseases ORDER BY $code";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function search_disease($search, $code){
		
		$sql = "SELECT * FROM diseases WHERE diseases_name LIKE '%$search%' OR diseases_code LIKE '%$search%' ORDER BY $code";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_diagnosis($disease_id, $visit_id){
		
		$sql = "INSERT INTO diagnosis (visit_id, disease_id) VALUES ($visit_id, $disease_id)";
		////echo$sql."<br>";
		$send = new Database();
		$send->insert($sql);
	}
	
	function get_diagnosis($visit_id){
		
		$sql = "SELECT diagnosis.diagnosis_id, diseases.diseases_name, diseases.diseases_code 
			FROM diagnosis, diseases 
			WHERE diagnosis.visit_id = $visit_id
			AND diagnosis.disease_id = diseases.diseases_id";////echo$sql;
			
		$get5= new Database;
		$rs5=$get5->select($sql);
		return $rs5;
	}
	
	function get_disease($id){
		
		$sql = "SELECT * FROM diseases WHERE diseases_id = $id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function delete_diagnosis_visit($id){
		
		$sql ="DELETE FROM diagnosis WHERE diagnosis_id = $id";
		$delete = new Database();
						
		$delete = new Database();
		$delete->insert($sql);
	}
	
	function get_drugs($code,$visit_t){
	if(($visit_t=1)||($visit_t=2)){
				$sql = "SELECT service_charge.service_charge_id, service_charge.visit_type_id,generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name FROM drugs, service_charge, generic, brand,class WHERE drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 0 ORDER BY $code";
				
		}
		elseif ($visit_t=4){
		$sql = "SELECT service_charge.service_charge_id,service_charge.visit_type_id, generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name FROM drugs, service_charge, generic, brand,class WHERE drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 4 ORDER BY $code";			
			}
else{
		$sql = "SELECT service_charge.service_charge_id,service_charge.visit_type_id, generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name FROM drugs, service_charge, generic, brand,class WHERE drugs.drugs_id = service_charge.drug_id AND drugs.generic_id = generic.generic_id AND drugs.brand_id = brand.brand_id AND class.class_id  = drugs.class_id AND service_charge.visit_type_id = 0 ORDER BY $code";			
			}


		$get =new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function search_drugs($search,$code,$visit_t){
	if(($visit_t=1)||($visit_t=2)){	
		$sql ="SELECT service_charge.service_charge_id, service_charge.visit_type_id,generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name
		FROM drugs, service_charge, generic, brand,class
		WHERE  drugs.drugs_id = service_charge.drug_id 
		AND drugs.generic_id = generic.generic_id
		 AND drugs.brand_id = brand.brand_id 
		 AND class.class_id  = drugs.class_id 
		AND service_charge.visit_type_id=0
		AND (service_charge.service_charge_name LIKE '%$search%' 
		OR generic.generic_name LIKE '%$search%' 
		OR brand.brand_name LIKE '%$search%'
		OR class.class_name LIKE '%$search%'
			OR generic.generic_name LIKE '%$search%')
		
		ORDER BY $code";
	}else {
		$sql ="SELECT service_charge.service_charge_id, service_charge.visit_type_id, generic.generic_name, brand.brand_name, service_charge.service_charge_amount, service_charge.drug_id , service_charge.service_charge_name, class.class_name
		FROM drugs, service_charge, generic, brand,class
		WHERE  drugs.drugs_id = service_charge.drug_id 
		AND drugs.generic_id = generic.generic_id
		 AND drugs.brand_id = brand.brand_id 
		 AND class.class_id  = drugs.class_id 
		AND service_charge.visit_type_id=0
		AND (service_charge.service_charge_name LIKE '%$search%' 
		OR generic.generic_name LIKE '%$search%' 
		OR brand.brand_name LIKE '%$search%'
		OR class.class_name LIKE '%$search%'
		OR generic.generic_name LIKE '%$search%')
		
		ORDER BY $code";	
		}
	//echo $sql;
		$get =new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_drugz($item){
		
		$sql5= "SELECT drugs.drugs_name, drugs.drugs_id, class.class_name, drugs.drugs_code, drugs.drugs_unitprice, drug_type.drug_type_name, drug_administration_route.drug_administration_route_name, drugs.drugs_dose, drug_dose_unit.drug_dose_unit_name
		
		FROM drugs, class, drug_administration_route, drug_type, drug_dose_unit
		
		WHERE drugs.class_id = class.class_id 
		AND drugs.drug_administration_route_id = drug_administration_route.drug_administration_route_id
		AND drugs.drug_type_id = drug_type.drug_type_id
		AND drugs.drug_dose_unit_id = drug_dose_unit.drug_dose_unit_id 
		AND (drugs_name LIKE '%$item%' 
                       OR drugs_code LIKE '%$item%' 
                       OR drugs_unitprice LIKE '%$item%' 
                       OR drugs_class LIKE '%$item%' 
                       OR drugs_id LIKE '%$item%' )";
                       
        $get5= new Database;
		$rs5=$get5->select($sql5);
		return $rs5;
	}
	function select_scid($id){
		$sql5="select * from pres where prescription_id='$id'";
		$get5= new Database;
		$rs5=$get5->select($sql5);
		return $rs5;
		}
	function save_visit_charge($service_charge_id,$visit_id,$visit_charge_units){
		$sql ="insert into visit_charge (visit_charge_amount,visit_charge_units,visit_id,service_charge_id)	values ((select service_charge_amount from service_charge where service_charge_id='$service_charge_id'),$visit_charge_units,$visit_id,$service_charge_id)";
		//echo$sql;
		$save = new Database();
		$save->insert($sql);
	}
	function update_prescription($prescription_id,$service_charge_id,$prescription_substitution,$comment,$prescription_startdate,$prescription_finishdate,$drug_times_id,$prescription_date,$drug_duration_id,$prescription_quantity,$drug_consumption_id,$units_given){
		$sql="UPDATE `sumc`.`pres` SET `visit_charge_id` = '13 ',`service_charge_id` = '$service_charge_id',`prescription_quantity` = '$prescription_quantity ',`prescription_substitution` = '$prescription_substitution',`prescription_startdate` = '$prescription_startdate',`prescription_finishdate` = '$prescription_finishdate',`drug_times_id` = '$drug_times_id',`prescription_date` = '$prescription_date',`drug_duration_id` = '$drug_duration_id',`drug_consumption_id` = '$drug_consumption_id', units_given='$units_given' WHERE `pres`.`prescription_id` ='$prescription_id'";
		//echo$sql;
		$save = new Database();
		$save->insert($sql);
		}
}
?>