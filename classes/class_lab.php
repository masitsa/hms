<?php
include "connection.php";
/*SELECT family_disease.family_disease_name, family.family_relationship FROM `family_disease`, `family_history_disease`,family 
where patient_id=(select patient_id from visit where visit_id=$x)
AND family_disease.family_disease_id=family_history_disease.family_disease_id
AND */
class Lab{
	function get_family_history($visit_id){
		$sql="SELECT family_disease.family_disease_name, family.family_relationship FROM `family_disease` , `family_history_disease` , family
WHERE patient_id = (SELECT patient_id FROM visit WHERE visit_id =$visit_id ) AND family_disease.family_disease_id = family_history_disease.disease_id
AND family.family_id = family_history_disease.family_id";

			$get = new Database();
		return $get->select($sql);
		
		}
	function get_lab_visit2($visit_id){
		
		$sql = "SELECT lab_visit FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database();
		return $get->select($sql);
	}
		function get_lab_checkup($visit_id){
			$sql = "SELECT service.service_name, service.service_id,service_charge.service_charge_name,visit_charge.visit_charge_amount, visit_charge.visit_charge_units
			
			FROM visit_charge, service, service_charge
			
			WHERE visit_charge.visit_id = $visit_id
			AND visit_charge.service_charge_id = service_charge.service_charge_id
			AND service_charge.service_id = service.service_id
			AND service.service_id=5";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_comment($visit_id){
		
		$sql = "SELECT lab_visit_comment, visit_date FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
function get_test_comment($visit_charge_id){
		
		$sql = "SELECT lab_visit_format_comments FROM lab_visit_format_comment WHERE visit_charge_id= $visit_charge_id";
	//	//echo $sql;
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_comment($comment, $visit_charge_id){
		
		$sql = "UPDATE visit SET lab_visit_comment = '$comment' WHERE visit_id = (SELECT visit_id FROM visit_charge WHERE visit_charge_id = $visit_charge_id)";
		
		$update = new Database;
		$update->insert($sql);
	}
	
function get_patient_2($strath_no){
		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());
		
		$sql = "select * from student where student_Number=$strath_no";
		//////echo $sql;
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
		//////echo $sql;
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
			function get_insurance_name($patient_insurance_id){
			$sql="select insurance_company_name from insurance_company where insurance_company_id=(select insurance_company_id from patient_insurance where patient_insurance_id='$patient_insurance_id ')";
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
			}
	
	function get_visits(){
		
		$sql = "SELECT DISTINCT lab_visit.visit_id FROM lab_visit,visit WHERE lab_visit.lab_visit_status = 0 AND visit.lab_visit <> 2 AND lab_visit.visit_id = visit.visit_id";
		////echo "get".$sql;
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_patient($visit_id){
		
		$sql = "SELECT DISTINCT patients.patient_id, patients.patient_surname, patients.patient_othernames, patients.strath_no , patients.strath_type 
		FROM patients, visit, lab_visit 
		WHERE lab_visit.visit_id = $visit_id 
		AND visit.visit_id = lab_visit.visit_id 
		AND visit.patient_id = patients.patient_id ";
		////echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function update_visit($visit_id){
		
		$sql = "UPDATE lab_visit SET lab_visit_status = 1 WHERE visit_id = $visit_id";
		$save = new Database();
		$save->insert($sql);
	}
	function get_m_test($visit_charge_id){
		
		$_SESSION['test'] = 1;
		$sql = "SELECT service_charge.service_charge_name AS lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit, visit_charge.visit_charge_id AS lab_visit_id, visit_charge.visit_charge_results AS lab_visit_result, visit_charge.visit_charge_comment  
		
		FROM lab_test, visit_charge, lab_test_class, service_charge
		
		WHERE visit_charge.visit_charge_id = $visit_charge_id
		AND visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id
		AND visit_charge.visit_charge_id NOT IN (SELECT visit_charge_id FROM lab_visit_results)";
			
			//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
		
		
		}

	function get_test($visit_charge_id){
			
		$_SESSION['test'] = 0;
		
		$sql = "SELECT service_charge.service_charge_name AS lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit,lab_test_format.lab_test_format_id, visit_charge.visit_charge_id AS lab_visit_id,  visit_charge.visit_charge_results AS lab_visit_result, lab_test_format.lab_test_formatname, lab_test_format.lab_test_format_units, lab_test_format.lab_test_format_malelowerlimit, lab_test_format.lab_test_format_maleupperlimit, lab_test_format.lab_test_format_femalelowerlimit, lab_test_format.lab_test_format_femaleupperlimit, lab_visit_results.lab_visit_results_result, visit_charge.visit_charge_comment
		
		FROM lab_test, visit_charge, lab_test_class, lab_test_format, lab_visit_results, service_charge
		
		WHERE visit_charge.visit_charge_id = $visit_charge_id
		AND visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.lab_test_id = lab_test.lab_test_id 
		AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id 
		AND lab_test_format.lab_test_id = lab_test.lab_test_id 
		AND visit_charge.visit_charge_id = lab_visit_results.visit_charge_id 
		AND lab_visit_results.lab_visit_result_format = lab_test_format.lab_test_format_id";
		
			////echo $sql."<br/>";
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;		
		
	}
	
	function save_tests($res, $lab){
		
		$sql = "UPDATE visit_charge SET visit_charge_results = '$res' WHERE visit_charge_id = $lab";
		
		$save = new Database();
		$save->insert($sql);
	}
	
	function save_tests_format($res, $lab,$format){
		
		$sql = "SELECT * FROM lab_visit_result WHERE lab_visit_result_visit_id = $lab";
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;	
		
		$get_ = new Lab();
		$get_rs = $get_->save_tests_format($res, $lab,$format);
		$num_rows = mysql_num_rows($get_rs);
		
		if ($num_rows == 0){
			$sql ="INSERT INTO lab_visit_result (	lab_visit_results_result,lab_visit_result_visit_id,lab_visit_result_format) VALUES ($res,$lab,$format)";
				//echo 'INSERT'.$sql;	
		$save = new Database();
		$save->insert($sql);
			
			}else{
		
		$sql = "UPDATE lab_visit_result SET lab_visit_results_result = '$res', lab_visit_result_format = '$format' WHERE lab_visit_result_visit_id = $lab";
		//echo 'UPDATE'.$sql;
		$save = new Database();
		$save->insert($sql);
			}
	}
	
	function get_vitals_alert($visit_id){

		
		$sql = "SELECT vitals_alert FROM visit WHERE visit_id = $visit_id ";
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function previous_tests(){
		
		$sql = "SELECT visit_id, visit_date FROM visit WHERE lab_visit = 22 ORDER BY visit_id DESC";
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function previous_tests2($visit_id){
		
		$sql = "SELECT * FROM lab_visit WHERE visit_id = $visit_id";
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	function get_patient2($id){

		$sql = "SELECT patients.strath_no, visit.visit_type, patients.patient_number, patients.patient_othernames, patients.patient_surname, patients.patient_date_of_birth, patients.gender_id FROM patients, visit WHERE patients.patient_id=$id AND visit.patient_id = patients.patient_id";
		//echo $sql;
		//$sql ="SELECT patient_id FROM patients WHERE EXISTS ( SELECT patient_id FROM vitals WHERE patients.patient_id = vitals.patient_id)";

		$get = new Database();
		$rs = $get->select($sql);

		return $rs;
	}

        function get_previous_lab_test($visit_id){

		$sql = "SELECT lab_test.lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit, lab_visit.lab_visit_id, lab_visit.lab_visit_result FROM lab_test, lab_visit, lab_test_class WHERE lab_visit.visit_id = $visit_id AND lab_visit.lab_test_id = lab_test.lab_test_id AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id AND lab_visit_status = 1";
		////echo $sql."<br/>";
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
        }
		function get_general_visits(){
		
		$sql ="SELECT patient_id, visit_id, visit_time FROM visit WHERE close_card=0";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
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
		function get_visits_lab(){
			$sql = "SELECT * FROM visit WHERE nurse_visit ='1' AND doc_visit= '1' AND lab_visit='0'";
			$check = new Database;
		$rs=$check->select($sql);
		
		return $rs;
			}
			function get_patient_lab($visit_id){
		
		$sql = "SELECT DISTINCT patients.patient_id, patients.patient_surname, patients.patient_firstname, patients.patient_middlename FROM patients, visit WHERE  visit.visit_id= $visit_id AND visit.patient_id = patients.patient_id";
		
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_patient_general($id){
		
		$sql = "SELECT * FROM patients WHERE patient_id=$id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	function get_plan(){
		
		$sql = "SELECT * FROM plan WHERE plan_name=	'Laboratory Test'";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
		function get_lab_only(){
		
		$date = date('y-m-d');
		$sql = "SELECT DISTINCT visit.patient_id, visit.visit_id, visit.visit_time FROM visit, lab_visit WHERE visit.lab_visit = '2' AND lab_visit.lab_visit_status = 0 AND visit.visit_id = lab_visit.visit_id";
		
		//echo "s".$sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	function get_patient_lab_visit($visit_id){
		
		$sql = "SELECT DISTINCT patients.patient_id, patients.patient_surname, patients.patient_firstname, patients.patient_middlename, patients.strath_no , patients.strath_type FROM patients, visit, lab_visit WHERE lab_visit.visit_id = $visit_id AND visit.visit_id = lab_visit.visit_id AND visit.patient_id = patients.patient_id AND visit.lab_visit = 2";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	function get_lab_visit_test($visit_id ){
		$sql = "SELECT * FROM visit WHERE visit_id= '$visit_id'";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
		
		}
		
		function get_test2($visit_id){

		$sql = "SELECT lab_test.lab_test_name, lab_test_class.lab_test_class_name, lab_test.lab_test_units, lab_test.lab_test_malelowerlimit, lab_test.lab_test_malelupperlimit, lab_test.lab_test_femalelowerlimit, lab_test.lab_test_femaleupperlimit, lab_visit.lab_visit_id, lab_visit.lab_visit_result 
		FROM lab_test, lab_visit, lab_test_class 
		WHERE lab_visit.visit_id = $visit_id AND lab_visit.lab_test_id = lab_test.lab_test_id AND lab_test.lab_test_class_id = lab_test_class.lab_test_class_id";
		//echo $sql."<br/>";
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function save_tests_format2($result,$format,$visit_id){
		
		//$sql_check="select * from lab_visit_results where lab_visit_result_format ='$format' and visit_id='$visit_id'";
		$sql = "UPDATE lab_visit_results SET lab_visit_results_result = '$result' WHERE lab_visit_result_format ='$format' and visit_id='$visit_id'";
		//echo $sql;
		$save = new Database();
		$save->insert($sql);
	}
	
	function get_lab_visit($visit_id){
		
		$sql = "SELECT visit_charge.visit_charge_id 
		
		FROM visit_charge, service, service_charge 
		
		WHERE visit_charge.visit_id = $visit_id 
		AND service.service_id = 5 
		AND visit_charge.service_charge_id = service_charge.service_charge_id 
		AND service_charge.service_id = service.service_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_lab_visit_result($visit_charge_id){
		
		$sql = "SELECT * FROM lab_visit_results WHERE visit_charge_id = $visit_charge_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_lab_personnel($id){
		
		$sql = "SELECT personnel_fname, personnel_surname FROM personnel WHERE personnel_id = $id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_patient_id($visit_id){
		
		$sql = "SELECT patients.patient_id FROM patients, visit WHERE visit.visit_id = $visit_id AND visit.patient_id = patients.patient_id";
		//echo $sql;
		$get = new Database();
		return $get->select($sql);
	}
	
	function send_to_lab($visit_id){
		
		$sql = "UPDATE visit SET lab_visit = 12 WHERE visit_id = $visit_id";
		
		$update = new Database;
		$update->insert($sql);
	}
	
	function finish_lab_test($visit_id){
		
		$sql = "UPDATE visit SET lab_visit = 22 WHERE visit_id = $visit_id";
		
		$update = new Database;
		$update->insert($sql);
	}
	
	function save_lab_comments($res, $visit_charge_id){
		
		$sql = "SELECT * FROM lab_visit_format_comment WHERE  visit_charge_id = $visit_charge_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;	
		 }
}
class invoice{
	
	function get_invoice($visit_id){
			$sql = "SELECT service.service_name, service.service_id,service_charge.service_charge_name,visit_charge.visit_charge_amount, visit_charge.visit_charge_units
			
			FROM visit_charge, service, service_charge
			
			WHERE visit_charge.visit_id = $visit_id
			AND visit_charge.service_charge_id = service_charge.service_charge_id
			AND service_charge.service_id = service.service_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
		function get_invoice_pres($visit_id){
			$sql = "SELECT service.service_name, service.service_id,service_charge.service_charge_name,visit_charge.visit_charge_amount, visit_charge.visit_charge_units
			
			FROM visit_charge, service, service_charge
			
			WHERE visit_charge.visit_id = $visit_id
			AND visit_charge.service_charge_id = service_charge.service_charge_id
			AND service_charge.service_id = service.service_id
			AND service.service_id=4";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_patient_prescription($visit_id){
			$sql = "SELECT drugs.drugs_id, drugs.drugs_unitprice,pres.visit_id,pres.drugs_id , drugs.drugs_name, pres.prescription_quantity FROM drugs,pres WHERE pres.visit_id = '$visit_id' AND drugs.drugs_id= pres.drugs_id ";
		//echo $sql;
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
		//echo $sql;
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
		//echo $sql;
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
		
		//echo $sqlq;
	        $rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		
		return $rsq;
			}
	function get_patient2($id){

		$sql = "SELECT * FROM patients, visit WHERE visit.patient_id = patients.patient_id AND visit.visit_id = $id";
//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);

		return $rs;
	}
	
	function get_user_details($id){
		$sql = "SELECT * FROM personnel WHERE personnel_id = $id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;	
	}
	
	function get_patient($visit_id){
		$sql = "SELECT personnel.personnel_surname, personnel.personnel_fname FROM visit, personnel, schedule WHERE visit.visit_id ='$visit_id' AND visit.schedule_id = schedule.schedule_id AND schedule.personnel_id = personnel.personnel_id";
		//echo $sql;
		$select = new Database();
		$rs = $select->select($sql);
		
		return $rs;
		
		}function get_invoice_consultation($id){
			
			$sql = "SELECT consultation_charge_2.charge FROM consultation_charge_2, visit, consultation_type WHERE visit.consultation_type_id = consultation_charge_2.consultation_type_id AND visit_id = '$id' AND consultation_charge_2.consultation_type_id = consultation_type.consultation_type_id AND consultation_charge_2.visit_type =visit.visit_type";
	//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		
				
			}
			function get_lab_charge_invoice($vid){
				
			$sql = "SELECT lab_test.lab_test_id,lab_test.lab_test_price,lab_visit.visit_id,lab_visit.lab_test_id, visit.visit_id, lab_test.lab_test_name FROM visit, lab_test, lab_visit WHERE lab_visit.visit_id = $vid AND visit.visit_id = $vid AND lab_test.lab_test_id=lab_visit.lab_test_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		}
		function get_patient_prescription_invoice($visit_id){
			$sql = "SELECT drugs.drugs_id, drugs.drugs_unitprice,pres.prescription_dose_unit,pres.visit_id,pres.drugs_id , drugs.drugs_name,drug_type_consumption.drug_type_consumption_units FROM drugs,pres,drug_type_consumption WHERE pres.visit_id = '$visit_id' AND drugs.drugs_id= pres.drugs_id AND drug_type_consumption.prescription_id  = pres.prescription_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		}
		function get_visit_type($vid){
			$sql1 = "SELECT visit_type, visit_id FROM visit WHERE visit_id = $vid";
			//echo $sql1;
			$get = new Database();
			$rs = $get->select($sql1);
		
			return $rs;
			}
	
		function get_procedure_charge_invoice($vid){
			
				$v_type = new invoice();
				$rs2 =$v_type->get_visit_type($vid);
				$num_type= mysql_num_rows($rs2);
				
				$visit_t = mysql_result($rs2, 0 ,"visit_type");
				if($num_type == 0){}else{
					if ($visit_t == 0){
						
						$sql= "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '0' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
						}
				else if($visit_t == 1){
					$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students,procedure.procedures FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '1' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
					////echo $sql;
					}else if ($visit_t ==2){
						$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.staff,procedure.procedures FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '2' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
						
					}else if ($visit_t == 3){
								$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.outsiders,procedure.procedures FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '3' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
							}
							
					$get = new Database();
					$rs = $get->select($sql);
					
					return $rs;

			}
		}
		function get_insurance_name($patient_insurance_id){
			$sql="select insurance_company_name from insurance_company where insurance_company_id=(select insurance_company_id from patient_insurance where patient_insurance_id='$patient_insurance_id ')";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
			}
	}

?>