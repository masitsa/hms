<?php
include 'connection.php';
$id = $_SESSION['vid'];


class accounts{
	
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
	
		
	function get_patient_2($strath_no){
		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
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
        mysql_select_db("sumc", $connect)
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
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
					
	$sqlq = "select * from staff_dependants where staff_dependants_id='$strath_no'";
		
		//echo $sqlq;
	        $rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		
		return $rsq;
			}

	
	
	function get_personnel_type($id){
		$sql3= "SELECT personnel.personnel_type FROM personnel,schedule,visit WHERE visit.schedule_id = schedule.schedule_id AND visit.visit_id ='$id' AND schedule.personnel_id = personnel.personnel_id";
		
		$get = new Database();
		$rs = $get->select($sql3);
		
		return $rs;
	
		
		}
		function get_charge($id){
			
			$sql = "SELECT consultation_charge_2.charge FROM consultation_charge_2, visit, consultation_type WHERE visit.consultation_type_id = consultation_charge_2.consultation_type_id AND visit_id = '$id' AND consultation_charge_2.consultation_type_id = consultation_type.consultation_type_id AND consultation_charge_2.visit_type =visit.visit_type";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
				
			}
			
		function get_drug_charges(){
			$sql2="SELECT DISTINCT drugs.drugs_name,drugs.drugs_unitprice
	FROM visit, prescription, drugs, patients
	WHERE 
	prescription.drug_id=drugs.drugs_id
	AND prescription.prescription_visitid=visit.visit_id
	AND visit.visit_id='".$id."'";
	
	$get = new Database();
		$rs = $get->select($sql2);
		
		return $rs;
	
	$result2=mysql_query($sql2);
	$drug_presc="";
	while($cont1=mysql_fetch_array($result2)){
		$drug=$cont1["drugs_name"];
		$drug_price=$cont1["drugs_unitprice"];
		$total+=$drug_price;
		$drug_presc .='<h4> '.$drug.': Ksh. '.$drug_price.'</h4>';
		
		
	}
			}
			
			function get_patient_charges(){
				//get all the patients who have gone through the pharmacy
	$sql1="SELECT * FROM visit,patients WHERE visit.patient_id=patients.patient_id AND visit.close_card = 0 ";
	
	$get = new Database();
	$rs = $get->select($sql1);
		
	return $rs;
	
	$result1=mysql_query($sql1);
	$list="";
		while($row=mysql_fetch_array($result1)){
			$visit_id=$row["visit_id"];
			$fname=$row["patient_firstname"];
			$lname=$row["patient_surname"];
			$mname=$row["patient_middlename"];
			$list .='<tr>';
			$list .='<td><a href="http://sagana/sumc/modules/accounts/accounts.php?vid='.$visit_id.'">'.$fname.' '.$lname.' </a></td>';
			$list .='</tr>';
		}
				
				}
		function get_patient($id){
		
		$sql = "SELECT * FROM patients WHERE patient_id=$id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	function get_patient2($id){

		$sql = "SELECT * FROM patients, visit WHERE visit.patient_id = patients.patient_id AND visit.visit_id = $id";

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
		function get_visit_type($vid){
			$sql1 = "SELECT visit_type, visit_id FROM visit WHERE visit_id = $vid";
			//echo $sql1;
			$get = new Database();
			$rs = $get->select($sql1);
		
			return $rs;
			}
		function get_procedure_charge($vid){
			
				$v_type = new accounts();
				$rs2 =$v_type->get_visit_type($vid);
				$num_type= mysql_num_rows($rs2);
				
				$visit_t = mysql_result($rs2, 0 ,"visit_type");
				if($num_type == 0){}else{
					if ($visit_t == 0){
						
						$sql= "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '0' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
						}
				else if($visit_t == 1){
					$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '1' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
					//echo $sql;
					}else if ($visit_t ==2){
						$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.staff FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '2' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
						
					}else if ($visit_t == 3){
								$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.outsiders FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '3' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
							}
							
					$get = new Database();
					$rs = $get->select($sql);
					
					return $rs;

			}
		}
		function get_lab_charge($vid){
				
			$sql = "SELECT lab_test.lab_test_id,lab_test.lab_test_price,lab_visit.visit_id,lab_visit.lab_test_id, visit.visit_id FROM visit, lab_test, lab_visit WHERE lab_visit.visit_id = $vid AND visit.visit_id = $vid AND lab_test.lab_test_id=lab_visit.lab_test_id";
		
			$get = new Database();
			$rs = $get->select($sql);
		
			return $rs;
		}
		
		function get_amount_paid($vid){
		
			$sql = "SELECT a.visit_id,a.payment_method_id,a.time,a.amount_paid,a.payment_id,b.payment_method_id,b.payment_method FROM payments as a, payment_method as b WHERE a.visit_id='$vid' AND b.payment_method_id = a.payment_method_id";
			//echo $sql;
			$get = new Database();
			return $get->select($sql);
		}
		
		function get_amount_paid2($id){
		
			$sql = "SELECT a.time, a.amount_paid, b.payment_method FROM payments as a, payment_method as b WHERE a.payment_id='$id' AND b.payment_method_id = a.payment_method_id";
			//echo $sql;
			$get = new Database();
			return $get->select($sql);
		}
		
		function get_visit_id($payment_id){
			
			$sql = "SELECT visit_id FROM payments WHERE payment_id='$payment_id'";
			//echo $sql;
			$get = new Database();
			return $get->select($sql);
		}
		
		function save_amount_paid($vid, $amount, $personnel_id,$payment_method){
		
			$sql = "INSERT INTO payments (visit_id, personnel_id, amount_paid, payment_method_id) VALUES ('$vid', '$personnel_id', '$amount',(SELECT payment_method_id FROM payment_method WHERE payment_method = '$payment_method'))";
			//echo $sql;
			$save = new Database();
			$save->insert($sql);
		}

	function get_payment_method(){
		
		$sql = "SELECT * FROM payment_method";
		
		$get = new Database();
		return $get->select($sql);
		}
		function set_hold_visit($visit_id, $personnel_id){
		$sql ="INSERT INTO onhold (visit_id, personnel_id, status) VALUES ('$visit_id','$personnel_id', '1')";
		//echo $sql;
		$save = new Database();
		$save->insert($sql);
		}
	function check_hold($visit_id){
		$sql = "SELECT * FROM onhold WHERE visit_id = '$visit_id' AND status = '1'";
		//echo $sql;
		$check = new Database;
		$rs=$check->select($sql);
		
		return $rs;
		}
	function unset_hold_visit($visit_id, $personnel_id){
		$sql ="UPDATE onhold SET status='0' WHERE visit_id = '$visit_id' AND personnel_id = '$personnel_id'";
		//echo $sql;
		$save = new Database();
		$save->insert($sql);
		}
	function delete_amount($id){
		
		$sql = "DELETE FROM payments WHERE payment_id = $id";
		
		$save = new Database();
		$save->insert($sql);
	}
					
function get_invoice_consultation($id){
			
			$sql = "SELECT consultation_charge_2.charge FROM consultation_charge_2, visit, consultation_type WHERE visit.consultation_type_id = consultation_charge_2.consultation_type_id AND visit_id = '$id' AND consultation_charge_2.consultation_type_id = consultation_type.consultation_type_id AND consultation_charge_2.visit_type =visit.visit_type";
	//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		
				
			}
			function get_lab_charge_invoice($vid){
				
			$sql = "SELECT lab_test.lab_test_id,lab_test.lab_test_price,lab_visit.visit_id,lab_visit.lab_test_id, visit.visit_id, lab_test.lab_test_name FROM visit, lab_test, lab_visit WHERE lab_visit.visit_id = $vid AND visit.visit_id = $vid AND lab_test.lab_test_id=lab_visit.lab_test_id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		}
		function get_patient_prescription_invoice($visit_id){
			$sql = "SELECT drugs.drugs_id, drugs.drugs_unitprice, pres.visit_id,pres.drugs_id , drugs.drugs_name,drug_type_consumption.drug_type_consumption_units,drug_type_consumption.drug_quantity FROM drugs,pres,drug_type_consumption WHERE pres.visit_id = '$visit_id' AND drugs.drugs_id= pres.drugs_id AND drug_type_consumption.prescription_id  = pres.prescription_id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
		}
		function get_procedure_charge_invoice($vid){
			
				$v_type = new accounts();
				$rs2 =$v_type->get_visit_type($vid);
				$num_type= mysql_num_rows($rs2);
				
				$visit_t = mysql_result($rs2, 0 ,"visit_type");
				if($num_type == 0){}else{
					if ($visit_t == 0){
						
						$sql= "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '0' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
						}
				else if($visit_t == 1){
					$sql = "SELECT visit_procedure.procedure_id,visit_procedure.visit_id, visit_procedure.units, visit.visit_id, visit.visit_type,procedure.procedure_id,procedure.students,procedure.procedures FROM `procedure`, visit_procedure, visit WHERE visit.visit_type = '1' AND visit_procedure.visit_id =$vid AND visit.visit_id = $vid AND procedure.procedure_id= visit_procedure.procedure_id";
					//echo $sql;
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
	
	function get_user_details($id){
		$sql = "SELECT * FROM personnel WHERE personnel_id ='$id'";//
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;	
	}
		function expenses_details($id){
		$sql = "SELECT * FROM expenses WHERE expenses_id = $id";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;	
	}
	}
	
		

?>