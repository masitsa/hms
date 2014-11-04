<?php
include 'connection.php';

class medicaladmin{
	
function update_procedure( $students, $staff, $outsiders, $procedure_id){
			$sql="UPDATE `procedure` SET students='$students',staff='$staff', outsiders='$outsiders' WHERE procedure_id='$procedure_id'";
			//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
			
		}
		
function delete_procedures($procedure_id1){
			$sql="DELETE FROM `procedure` WHERE procedure_id='$procedure_id1'";
			//echo $sql;
			$delete1= new Database;
			$delete1->insert($sql);			
}
function search_procedures($input){
		
		$sql="SELECT * FROM `procedure` WHERE
			procedures  LIKE '%$input%' 
			OR students  LIKE '%$input%' 
			OR staff LIKE '%$input%' 
			OR outsiders LIKE '%$input%' ";
			
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_procedures($order){
			
		$sql9 = "SELECT * FROM `procedure` ORDER BY $order";
	
		$procedures1 = new Database();
		$rs9 = $procedures1->select($sql9);
	
		return $rs9;
	}
		function save_procedure($procedure_name,$students ,$staff,$other){
		$sql = "INSERT INTO `procedure` (procedures,students,staff,outsiders) VALUE ('$procedure_name', $students, $staff, $other)";
		//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
		}
	function update_disease($code, $dieasename, $disease_id){
		$sql1= " UPDATE diseases SET diseases_code='$code', diseases_name='$dieasename' WHERE diseases_id='$disease_id'";
		//echo $sql1;
		$save1=new Database;
		$save1->insert($sql1);
			
			}
		function delete_disease($disease_id){
		$sql="DELETE FROM diseases WHERE diseases_id='$disease_id'";
		$delete = new Database();
		$delete->insert($sql);
		}
		
		function search_diseases($input){
			$sql="SELECT * FROM `diseases` WHERE 
				 diseases_code LIKE '%$input%'
				 OR	diseases_name LIKE '%$input%'";
		//echo $sql;
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
function get_diseases($code){
		
		$sql = "SELECT * FROM diseases ORDER by diseases_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	function update_symptoms($symptoms_name,$symptoms_id){
			$sql="UPDATE symptoms SET symptoms_name = '$symptoms_name' WHERE symptoms_id='$symptoms_id'";
			//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
			
		}
		
function delete_symptoms($symptoms_id){
			$sql="DELETE FROM symptoms WHERE symptoms_id='$symptoms_id'";
			//echo $sql;
			$delete1= new Database;
			$delete1->insert($sql);			
			}
function search_symptoms($input){
		
		$sql="SELECT * FROM symptoms WHERE
			symptoms_id  LIKE '%$input%' 
			OR symptoms_name LIKE '%$input%'";
			
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_symptoms($order){
			
		$sql9 = "SELECT * FROM symptoms ORDER BY $order";
	//echo $sql9;
		$procedures1 = new Database();
		$rs9 = $procedures1->select($sql9);
	
		return $rs9;
	}
	function save_symptoms($symptoms_name){
		$sql = "INSERT INTO symptoms (symptoms_name) VALUE ('$symptoms_name')";
		//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
		}
		
function update_vaccines($vaccine_name,$vaccine_id){
			$sql="UPDATE vaccine SET vaccine = '$vaccine_name' WHERE vaccine_id='$vaccine_id'";
			//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
			
		}
		
function delete_vaccines($vaccine_id){
			$sql="DELETE FROM vaccine WHERE vaccine_id='$vaccine_id'";
			//echo $sql;
			$delete1= new Database;
			$delete1->insert($sql);			
			}
function search_vaccines($input){
		
		$sql="SELECT * FROM vaccine WHERE
			vaccine_id  LIKE '%$input%' 
			OR vaccine LIKE '%$input%'";
			
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_vaccines($order){
			
		$sql9 = "SELECT * FROM vaccine ORDER BY $order";
	//echo $sql9;
		$vaccine = new Database();
		$rs9 = $vaccine->select($sql9);
	
		return $rs9;
	}
	function save_vaccines($vaccine_name){
		$sql = "INSERT INTO vaccine (vaccine) VALUE ('$vaccine_name')";
		//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
		}
		function update_lab_test($lab_test_id1,$lab_test_price ,$lab_test_class_id,$lab_test_units ,$lab_test_malelowerlimit ,$lab_test_malelupperlimit,$lab_test_femalelowerlimit, $lab_test_femaleupperlimit){
            $sql="UPDATE lab_test SET lab_test_price='$lab_test_price',lab_test_class_id='$lab_test_class_id', lab_test_units ='$lab_test_units', lab_test_malelowerlimit = '$lab_test_malelowerlimit' , lab_test_malelupperlimit= '$lab_test_malelupperlimit' ,lab_test_femalelowerlimit = '$lab_test_femalelowerlimit', lab_test_femaleupperlimit = '$lab_test_femaleupperlimit'  WHERE lab_test_id = '$lab_test_id1'";
            //echo $sql;
            $get=new Database;
            $rs=$get->insert($sql);
           
        }

function delete_lab_test($lab_test_id){
			$sql="DELETE FROM lab_test WHERE lab_test_id='$lab_test_id'";
			//echo $sql;
			$delete1= new Database;
			$delete1->insert($sql);			
			}
			
function search_lab_test($input){
		
		$sql="SELECT * FROM lab_test WHERE
			lab_test_name  LIKE '%$input%' 
			OR lab_test_price  LIKE '%$input%' 
			OR lab_test_class_id  LIKE'%$input%' 
			OR lab_test_units LIKE '%$input%'
			OR lab_test_malelowerlimit  LIKE '%$input%' 
			OR lab_test_malelupperlimit LIKE '%$input%' 
			OR lab_test_femalelowerlimit  LIKE '%$input%' 
			OR lab_test_femaleupperlimit LIKE '%$input%'";
			
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_lab_test($order){
			
		$sql9 = "SELECT * FROM lab_test ORDER BY $order";
	
		$lab_test = new Database();
		$rs9 = $lab_test->select($sql9);
	
		return $rs9;
	}
		function save_lab_test($lab_test_name,$lab_test_price ,$lab_test_class_name,$lab_test_units ,$lab_test_malelowerlimit ,$lab_test_malelupperlimit,$lab_test_femalelowerlimit, $lab_test_femaleupperlimit){
		$sql = "INSERT INTO lab_test (lab_test_name,lab_test_price ,lab_test_class_id,lab_test_units ,lab_test_malelowerlimit ,lab_test_malelupperlimit,lab_test_femalelowerlimit, lab_test_femaleupperlimit) VALUE ('$lab_test_name', '$lab_test_price', (SELECT `lab_test_class_id` FROM `sumc`.`lab_test_class` WHERE `lab_test_class_name` ='$lab_test_class_name'), '$lab_test_units', '$lab_test_malelowerlimit' , '$lab_test_malelupperlimit', '$lab_test_femalelowerlimit', '$lab_test_femaleupperlimit')";
		//echo $sql;
			$get=new Database;
			$get->insert($sql);
		}
		function search_new_labtest($lab_test_name,$lab_test_price ,$lab_test_units ,$lab_test_malelowerlimit ,$lab_test_malelupperlimit,$lab_test_femalelowerlimit, $lab_test_femaleupperlimit,$lab_test_class_name){
			$sql= "select * from `lab_test` WHERE
	lab_test_name LIKE '$lab_test_name' AND
	lab_test_price LIKE '$lab_test_price' AND 
	lab_test_units LIKE '$lab_test_units' AND
	lab_test_malelowerlimit LIKE '$lab_test_malelowerlimit' AND
	lab_test_malelupperlimit LIKE '$lab_test_malelupperlimit' AND  
	lab_test_femalelowerlimit LIKE '$lab_test_femalelowerlimit' AND
	lab_test_femaleupperlimit  LIKE '$lab_test_femaleupperlimit' AND
	lab_test_class_id LIKE '$lab_test_class_name'";
	//echo $sql;
	$get= new Database;
	$rs= $get->select($sql);
	return $rs;
		}
		function lab_test_id($lab_test_class_name){
			$sql="select lab_test_class_name from lab_test_class where lab_test_class_id='$lab_test_class_name'";
			$get= new Database;
			$rs=$get->select($sql);
			return $rs;	
			
			}
function save_format($id,$lab_test_formatname,$lab_test_format_units,$lab_test_format_malelowerlimit,$lab_test_format_maleupperlimit,$lab_test_format_femalelowerlimit,$lab_test_format_femaleupperlimit){
$sql="insert into lab_test_format (lab_test_id, lab_test_formatname,lab_test_format_units,lab_test_format_malelowerlimit,lab_test_format_maleupperlimit,lab_test_format_femalelowerlimit,lab_test_format_femaleupperlimit) VALUES ('$id','$lab_test_formatname','$lab_test_format_units','$lab_test_format_malelowerlimit','$lab_test_format_maleupperlimit','$lab_test_format_femalelowerlimit','$lab_test_format_femaleupperlimit')";
//echo $sql;
$save= new Database;
$save->insert($sql);
				}
	function select_formats($id){
		$sql="select * from lab_test_format where lab_test_id= '$id'";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_formats($id){
		$sql="SELECT * from  lab_test where lab_test_id= '$id'";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;				
		}
		
		function get_lab_id($lab_test_name){
			$sql="SELECT lab_test_id from lab_test where lab_test_name='$lab_test_name'";
			//echo $sql,$lab_test_id;
			$get= new Database;
			$rs=$get->select($sql);
			return $rs;
			
			}
			function lab_class(){
				$sql="select * from lab_test_class";
				$get=new Database;
				$rs=$get->select($sql);
				return $rs;
			}
		function update_fdisease($fd_disease_name,$fd_id){
			$sql="UPDATE family_disease SET fd_disease_name = '$fd_disease_name' WHERE fd_id='$fd_id'";
			//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
			
		}
		
function delete_fdisease($fd_id){
			$sql="DELETE FROM family_disease WHERE fd_id='$fd_id'";
			//echo $sql;
			$delete1= new Database;
			$delete1->insert($sql);			
			}
function search_fdisease($input){
		
		$sql="SELECT * FROM family_disease WHERE
			fd_id  LIKE '%$input%' 
			OR fd_disease_name LIKE '%$input%'";
			
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function get_fdisease($order){
			
		$sql9 = "SELECT * FROM family_disease ORDER BY $order";
	//echo $sql9;
		$procedures1 = new Database();
		$rs9 = $procedures1->select($sql9);
	
		return $rs9;
	}
	function save_fdisease($fdisease_name){
		$sql = "INSERT INTO family_disease (fd_disease_name) VALUE ('$fdisease_name')";
		//echo $sql;
			$get=new Database;
			$rs=$get->insert($sql);
	}
	
	function save_vital($name, $group){
		
		$sql = "INSERT INTO vitals (vitals_name, vitals_group_id) VALUES ('$name', (SELECT vitals_group_id  FROM vitals_group WHERE vitals_group_name = '$group'))";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function get_vitals(){
		
		$sql = "SELECT vitals.vitals_name, vitals_group.vitals_group_name, vitals.vitals_id FROM vitals, vitals_group WHERE vitals.vitals_group_id = vitals_group.vitals_group_id ORDER BY vitals_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_vitals_class(){
		
		$sql = "SELECT * FROM vitals_class ORDER BY vitals_class_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function get_vitals_range($vitals_id){
		
		$sql = "SELECT vitals_class.vitals_class_name, vitals_range.vitals_range_name, vitals_range.vitals_range_id, vitals_range.vitals_range_range
		FROM vitals_range, vitals_class
		WHERE vitals_range.vitals_id = $vitals_id 
		AND vitals_range.vitals_class_id = vitals_class.vitals_class_id
		ORDER BY vitals_class_name, vitals_range_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	function save_patient_type($type){
		
		$sql = "INSERT INTO vitals_class (vitals_class_name) VALUES ('$type')";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function save_ranges($class, $range_name, $range, $vital_id){
		
		$sql = "INSERT INTO vitals_range (vitals_range_name, vitals_class_id, vitals_id, vitals_range_range) VALUES ('$range_name', (SELECT vitals_class_id FROM vitals_class WHERE vitals_class_name = '$class'), $vital_id, '$range')";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function delete_range($range_id){
		
		$sql = "DELETE FROM vitals_range WHERE vitals_range_id = $range_id";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function save_group($type){
		
		$sql = "INSERT INTO vitals_group (vitals_group_name) VALUES ('$type')";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function get_groups(){
		
		$sql = "SELECT * FROM vitals_group ORDER BY vitals_group_name";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
			
	function consultation_type(){
	$sql="SELECT * from consultation_type";
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
	
	function visit_type(){
	$sql="SELECT * from visit_type";
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
	
	function consultation_charges($visit_type,$consultation_type_id){
		$sql="SELECT * FROM `consultation_charge_2` WHERE visit_type='$visit_type' AND consultation_type_id='$consultation_type_id'";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;
		}
	
	function update_consultation_charges($charge, $id){
		$sql="UPDATE `consultation_charge_2` SET charge='$charge' WHERE id=$id";
		//echo $sql;
		$get= new Database;
		$rs=$get->insert($sql);
				
		}
		
		function get_drug_type(){
			$sql="SELECT * from drug_type";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			
			}
			
		function update_drug_type($name,$code){
			$sql="UPDATE drug_type SET drug_type_name='$name' where drug_type_id='$code'";
			$get=new Database;
			$rs=$get->insert($sql);
			
			} 
			
		function delete_drug_type($code){
			$sql="DELETE from drug_type WHERE drug_type_id='$code'";
			$get= new Database;
			$rs=$get->insert($sql);
			}
			
		function save_drug_type($name){
			$sql="INSERT into drug_type (drug_type_name) VALUES('$name')";
			$get= new Database;
			$rs=$get->insert($sql);
			}
		function get_drug_consumption(){
			$sql="SELECT * from drug_consumption ORDER by drug_consumption_name ";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
			
		function update_drug_consumption($name,$code){
			$sql="UPDATE drug_consumption SET drug_consumption_name='$name' where drug_consumption_id='$code'";
			$get=new Database;
			$rs=$get->insert($sql);
			} 
			
		function delete_drug_consumption($code){
			$sql="DELETE from drug_consumption WHERE drug_consumption_id='$code'";
			$get= new Database;
			$rs=$get->insert($sql);
			}
		function save_drug_consumption($name){
			$sql="INSERT into drug_consumption (drug_consumption_name) VALUES('$name')";
			$get= new Database;
			$rs=$get->insert($sql);
			}
		function get_drug_dose_unit(){
			$sql="SELECT * from drug_dose_unit";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
		function update_drug_dose_unit($name,$code){
			$sql="UPDATE drug_dose_unit SET drug_dose_unit_name='$name' where drug_dose_unit_id='$code'";
			$get=new Database;
			$rs=$get->insert($sql);
			} 
		function delete_drug_dose_unit($code){
		$sql="DELETE from drug_dose_unit WHERE drug_dose_unit_id='$code'";
		$get= new Database;
		$rs=$get->insert($sql);
			}
			
		function save_drug_dose_unit($name){
		$sql="INSERT into drug_dose_unit (drug_dose_unit_name) VALUES('$name')";
		$get= new Database;
		$rs=$get->insert($sql);
		}
		function get_drug_duration(){
			$sql="SELECT * from drug_duration";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
		function update_drug_duration($name,$code){
			$sql="UPDATE drug_duration SET drug_duration_name='$name' where drug_duration_id='$code'";
			$get=new Database;
			$rs=$get->insert($sql);
			} 
		function delete_drug_duration($code){
		$sql="DELETE from drug_duration WHERE drug_duration_id='$code'";
		$get= new Database;
		$rs=$get->insert($sql);
			}
			
		function save_drug_duration($name){
		$sql="INSERT into drug_duration (drug_duration_name) VALUES('$name')";
		$get= new Database;
		$rs=$get->insert($sql);
		}
		function get_drug_times(){
		$sql="SELECT * from drug_times";
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
		function update_drug_times($name,$code){
			$sql="UPDATE drug_times SET drug_times_name='$name' where drug_times_id='$code'";
			$get=new Database;
			$rs=$get->insert($sql);
			} 
		function delete_drug_times($code){
		$sql="DELETE from drug_times WHERE drug_times_id='$code'";
		$get= new Database;
		$rs=$get->insert($sql);
			}
			
		function save_drug_times($name){
		$sql="INSERT into drug_times (drug_times_name) VALUES('$name')";
		$get= new Database;
		$rs=$get->insert($sql);
		}
		
		function get_objective_findings($code){
		
		$sql = "SELECT objective_findings.objective_findings_name,objective_findings_class.objective_findings_class_name,objective_findings.objective_findings_id FROM objective_findings,objective_findings_class  WHERE objective_findings_class.objective_findings_class_id = objective_findings.objective_findings_class_id ORDER BY $code";
		//echo $sql;
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
		function update_objective_findings($code, $objective_finding, $finding_id){
		$sql1= " UPDATE objective_findings SET objective_findings_class_id=(SELECT objective_findings_class_id FROM  objective_findings_class WHERE objective_findings_class.objective_findings_class_name = '$code') ,objective_findings_name='$objective_finding'  WHERE objective_findings_id='$finding_id'";
		//echo $sql1;
		$save1=new Database;
		$save1->insert($sql1);
			
			}
			function delete_objective_finding($finding_id){
		$sql="DELETE FROM objective_findings WHERE objective_findings_id='$finding_id'";
		$delete = new Database();
		$delete->insert($sql);
		}
		function search_obective_finding($input, $code){
			
			$sql = "SELECT objective_findings.objective_findings_name, objective_findings_class.objective_findings_class_name, objective_findings.objective_findings_id 
			FROM objective_findings,objective_findings_class  
			
			WHERE objective_findings_class.objective_findings_class_id = objective_findings.objective_findings_class_id 
			AND (objective_findings.objective_findings_name LIKE '%$input%' OR objective_findings_class.objective_findings_class_name LIKE '%$input%')
			
			ORDER BY objective_findings_class_name";
		//echo $sql;
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
			function get_objective_findings_class(){
				$sql = "SELECT objective_findings_class_name FROM objective_findings_class ORDER BY objective_findings_class_name";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
				
				}
				function get_class_id($class_name){
					$sql ="SELECT objective_findings_class_id FROM objective_findings_class WHERE objective_findings_class_name ='$class_name'";
			
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
					
					}
					function save_finding($finding_name,$class_id){
						$sql = "INSERT INTO objective_findings (objective_findings_name,objective_findings_class_id) VALUES ('$finding_name',$class_id)";
						
						$save = new Database();
						$save->insert($sql);
						}
						function objective_findings(){
							$sql ="SELECT objective_findings.objective_findings_id, objective_findings.objective_findings_name,objective_findings_class.objective_findings_class_name FROM objective_findings,objective_findings_class WHERE objective_findings_class.objective_findings_class_id=objective_findings.objective_findings_class_id ORDER BY objective_findings_class.objective_findings_class_name";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
							}
							function visit_objective($visit_id){
								$sql="SELECT visit_objective_findings FROM visit WHERE visit_id = '$visit_id'";
								
								$get=new Database;
			$rs=$get->select($sql);
			return $rs;
								}
	function save_consultation_type($type){
		
		$sql = "INSERT INTO consultation_type(consultation_type_name) VALUES ('$type')";
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function save_consultation_charge($sql){
		
		$save = new Database;
		$save->insert($sql);
	}
	
	function search_consultation_type($search){
		
		$sql = "SELECT * FROM consultation_type WHERE consultation_type_name LIKE '%$search%'";
		
		$get = new Database;
		$rs=$get->select($sql);
		return $rs;
	}
	
	function search_drug_consumption($input){
			$sql="SELECT * FROM `drug_consumption` WHERE 
				 drug_consumption_id LIKE '%$input%'
				 OR	drug_consumption_name LIKE '%$input%'";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
			
	function save_disease($diseases_code, $diseases_name){
		$sql="INSERT into diseases (diseases_code, diseases_name) values ( '$diseases_code', '$diseases_name')";
		//echo $sql;
		$save= new Database;
		$save->insert($sql);		
		}
	function search_drug_dose($input){
			$sql="SELECT * FROM `drug_dose_unit` WHERE 
				drug_dose_unit_id LIKE '%$input%'
				 OR	drug_dose_unit_name LIKE '%$input%'";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}

	function search_drug_duration($input){
			$sql="SELECT * FROM `drug_duration` WHERE 
				drug_duration_id LIKE '%$input%'
				OR	drug_duration_name LIKE '%$input%'";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
	function search_drug_times($input){
			$sql="SELECT * FROM `drug_times` WHERE 
				drug_times_id LIKE '%$input%'
				OR	drug_times_name LIKE '%$input%'";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
	function search_drug_type($input){
			$sql="SELECT * FROM `drug_type` WHERE 
				drug_type_id LIKE '%$input%'
				OR	drug_type_name LIKE '%$input%'";
			$get=new Database;
			$rs=$get->select($sql);
			return $rs;
			}
			
			
}


?>