<?php
include 'connection.php';

class nurse{
	
	function save_vitals($vital, $visit_id, $vital_id){
		
		$get = new nurse();
		$rs = $get->get_vitals1234($visit_id, $vital_id);
		$num_vitals = mysql_num_rows($rs);
		$time = date('h:i:s');
		////echo "<br/> numv = ".$num_vitals."<br/>";
		if($num_vitals == 0){
			
			$sql = "INSERT INTO visit_vital (vital_id, visit_id, visit_vital_value, visit_vitals_time) VALUES($vital_id, $visit_id, '$vital', '$time')";
		}
		
		else{
			
			$sql = "UPDATE visit_vital SET visit_vital_value = '$vital', visit_vitals_time = '$time' WHERE visit_id = $visit_id AND vital_id = $vital_id";
		}
		
		////echo $sql."<br/>";
		$save = new Database;
		$save->insert($sql);
	}
	
	function get_visit_vitals($visit_id, $vitals_id){
		
		$sql = "SELECT * FROM visit_vital WHERE visit_id = $visit_id AND vital_id = $vitals_id";
		////echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_vitals1234($id, $vital_id){
		
		$sql = "SELECT * FROM visit_vital WHERE visit_id = $id AND vital_id = $vital_id";
		////echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function vitals_range($vitals_id){
		
		$sql = "SELECT * FROM vitals_range WHERE vitals_id = $vitals_id";
		////echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_vitals($id){
		
		$sql = "SELECT * FROM visit_vital WHERE visit_id = $id";
		////echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_previous_vitals($visit_id){
		
		$sql = "SELECT visit_vital.visit_vital_value, vitals.vitals_name, visit.visit_id, visit.visit_date
		
		FROM visit_vital, visit, patients, vitals 
		
		WHERE visit_vital.vital_id = vitals.vitals_id 
		AND visit_vital.visit_id = visit.visit_id 
		AND visit.visit_id = $visit_id 
		AND visit.patient_id = patients.patient_id
		AND patients.patient_id = (SELECT patients.patient_id FROM patients, visit WHERE visit.visit_id = $visit_id AND visit.patient_id = patients.patient_id)
		AND visit.close_card = 1
		
		ORDER BY visit_id
		";
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_family_disease(){
		
		$sql = "SELECT * FROM family_disease ORDER BY family_disease_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function check_family_member($patient_id, $family){
		
		$sql = "SELECT family_member.patient_id FROM family_member WHERE (family_member.patient_id = $patient_id AND family_member.family_id = $family)";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_family_member($visit_id, $family_id){
		
		$sql = "INSERT INTO family_member (family_id, patient_id) VALUES ($family_id, (SELECT patient_id FROM visit WHERE visit_id = $visit_id))";
		
		$save = new Database();
		$save->insert($sql);
	}
	function disease_family_member($family_id, $patient_id, $disease_id){
		
		$sql = "INSERT INTO family_history_disease (family_id, patient_id, disease_id) VALUES ($family_id, $patient_id, $disease_id)";
		////echo $sql;
		$save = new Database();
		$save->insert($sql);
	}
function delete_family_member($family_id, $patient_id, $disease_id){
		
		$sql = "DELETE FROM family_history_disease where family_id=$family_id and  patient_id=$patient_id and disease_id=$disease_id";
		//echo $sql;
		$save = new Database();
		$save->insert($sql);
	}
	function check_history($patient_id, $family_id, $condition){
		
		$sql = "SELECT family_history_id FROM family_history WHERE family_id = (SELECT family_member.family_id FROM family_member WHERE family_member.patient_id = $patient_id AND family_member.family_id = $family_id) AND family_disease_id = $condition";////echo $sql;
		$get = new Database();
		return $get->select($sql);
	}
	
	function delete_history($history){
		
		$sql = "DELETE FROM family_history WHERE family_history_id = $history";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_family(){
		
		$sql = "SELECT * FROM family ORDER BY family_id DESC";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_family_history($visit_id, $family_id, $condition){
		
		$sql = "INSERT INTO family_history (family_id, family_disease_id) VALUES ((SELECT family_member.family_id FROM family_member, visit, family WHERE visit.visit_id = $visit_id AND family_member.patient_id = visit.patient_id AND  family_member.family_id = $family_id AND family.family_id = $family_id), $condition)";
		
		$get = new Database();
		$get->insert($sql);
	}
	
	function get_family_history($family, $patient_id, $disease){
		
		$sql = "SELECT *  FROM family_history_disease WHERE patient_id= $patient_id AND family_id = $family AND disease_id = $disease";
//echo $sql;
		$get = new Database();
		return $get->select($sql);
	}
	
	function get_patient_id($visit_id){
		
		$sql = "select patient_id,visit_type,visit_date,visit_id,patient_insurance_number from visit where visit_id=$visit_id";
		
		$get = new Database();
		return $get->select($sql);
	}
	
	function get_procedures($order,$visit_t){
			
		// $sql9 = "SELECT service_charge.service_charge_name AS service, service_charge.service_charge_amount AS amount FROM service_charge, service WHERE service.service_id = 3 AND service_charge.service_id = service.service_id ORDER BY '$order'";
		$sql9 = "SELECT * FROM service_charge WHERE service_id='3' AND visit_type_id = $visit_t ORDER BY '$order'";
////echo $sql9;
		$procedures1 = new Database();
		$rs9 = $procedures1->select($sql9);
	
		return $rs9;
	}
	
	function search_procedures($order,$search,$visit_t){
			
		$sql9 = "SELECT service_charge.service_charge_name, service_charge.visit_type_id,service_charge.service_charge_id , service_charge.service_charge_amount FROM service_charge, service WHERE service_charge_name LIKE '%$search%' AND service.service_id = 3 AND service_charge.service_id = service.service_id AND service_charge.visit_type_id = $visit_t ORDER BY '$order'";
	//echo $sql9;
		$procedures1 = new Database();
		$rs9 = $procedures1->select($sql9);
	
		return $rs9;
	}
	
	function get_medicals($id){
		
		$sql = "SELECT * FROM medication WHERE patient_id = $id";
		
		$get= new Database;
        $rs=$get->select($sql);
		return $rs;
	}
	
	function save_medication($medication, $patient_id, $food_allergies, $medicine_allergies, $regular_treatment){
		$get = new nurse();
		$rs = $get->get_medicals($patient_id);
		$num_medication= mysql_num_rows($rs);
		
		if($num_medication ==0){
				$sql7 = "INSERT INTO medication (medication_name, patient_id, food_allergies, medicine_allergies, regular_treatment) VALUES ('$medication', '$patient_id','$food_allergies', '$medicine_allergies', '$regular_treatment')";
				////echo $sql7;
				
		}
		
		else {
			
			$sql7 = "UPDATE medication SET medication_name = '$medication', food_allergies = '$food_allergies', medicine_allergies = '$medicine_allergies', regular_treatment= '$regular_treatment' WHERE patient_id = '$patient_id'";
			////echo $sql7;
		}
		//echo $ssql7;
		$save = new Database();
		$save->insert($sql7);
	}
	
	function get_surgeries($patient_id){
		
		$sql = "SELECT * FROM surgery, month WHERE patient_id = $patient_id AND surgery.month_id = month.month_id";
		
		$get = new Database();
		return $get->select($sql);
	}
	
	function save_surgery($patient_id, $description, $date, $month){
		
		$sql = "INSERT INTO surgery (surgery_description, surgery_year, patient_id, month_id) VALUES ('$description', '$date', $patient_id, (SELECT month_id FROM month WHERE month_name = '$month'))";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function delete_surgery($id){
		
		$sql = "DELETE FROM surgery WHERE surgery_id = $id";
		
		$save = new Database();
		$save->insert($sql);
	}
		
	function get_vaccines(){
		
		$sql = "SELECT * FROM vaccine ORDER BY vaccine";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function check_vaccine($patient_id, $patient_vaccine){
		$sql= "SELECT patient_vaccine_id, status_id FROM patients_vaccine WHERE patient_id= '$patient_id' AND vaccine_id = '$patient_vaccine' ";
		
		$get = new Database();
		return $get->select($sql);
	}
	
	function delete_vaccine($id){
		$sql = "DELETE FROM patients_vaccine WHERE patient_vaccine_id = $id";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function save_vaccines($vaccine_id, $patient_id, $status){

		$sql = "INSERT INTO patients_vaccine (vaccine_id, patient_id, status_id) VALUES ('$vaccine_id', '$patient_id', $status)";

		$save = new Database();
		$save->insert($sql);
	}
	
	function save_nurse_notes($nurse_notes, $patient_id){	
		$get = new nurse();
		$rs = $get->get_nurse_notes($patient_id);
		$num_nurse_notes = mysql_num_rows($rs);
		
		if($num_nurse_notes == 0){	
			$sql = "INSERT INTO nurse_notes (patient_id, nurse_notes) VALUES ($patient_id, '$nurse_notes')";
			
		}
		else {
		
			$sql = "UPDATE nurse_notes SET nurse_notes = '$nurse_notes' WHERE patient_id = $patient_id";
		}
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_nurse_notes($patient_id){
		
		$sql = "SELECT * FROM nurse_notes WHERE patient_id = $patient_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_patient($id){
		
		$sql = "SELECT * FROM patients, gender, strath_type WHERE patient_id=$id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_patient_2($strath_no){
		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());
		
		$sql = "select * from student where student_Number=$strath_no";
		////echo $sql;
	        $rs4 = mysql_query($sql)
        or die ("unable to Select ".mysql_error());
		
		$rows = mysql_num_rows($rs4);
		return $rs4;
	}
	
	function get_patient_3($strath_no){
//connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());
		
		$sql = "select * from staff where Staff_Number='$strath_no'";
		////echo $sql;
	        $rs = mysql_query($sql)
        or die ("unable to Select ".mysql_error());
		

        return $rs;
	}
		function  get_patient_4($strath_no){
			
			//connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());
					
	$sqlq = "select * from staff_dependants where staff_dependants_id='$strath_no'";
		
		////echo $sqlq;
	        $rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		
		return $rsq;
			}
	
	function set_hold_visit($visit_id, $personnel_id){
		$sql ="INSERT INTO onhold (visit_id, personnel_id, status) VALUES ('$visit_id','$personnel_id', '1')";
		////echo $sql;
		$save = new Database();
		$save->insert($sql);
	}
	
	function check_hold($visit_id,$personnel_id){
		$sql = "SELECT * FROM onhold WHERE visit_id = '$visit_id' AND status = '1' AND personnel_id ='$personnel_id'";
		////echo $sql;
		$check = new Database;
		$rs=$check->select($sql);
		
		return $rs;
	}
	
	function unset_hold_visit($visit_id, $personnel_id){
		$sql ="UPDATE onhold SET status='0' WHERE visit_id = '$visit_id' AND personnel_id = '$personnel_id'";
		////echo $sql;
		$save = new Database();
		$save->insert($sql);
	}

}

?> 