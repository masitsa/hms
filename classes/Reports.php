<?php

include 'connection.php';

class reports{
	
	function get_patient_visits($visit_date)
	{
		$sql= "SELECT visit_type FROM visit WHERE visit_date = '".$visit_date."'";
		
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_patient_visit_summary($visit_date)
	{
		$sql= "SELECT visit_type.visit_type_name, visit.visit_type, visit.visit_date, patients.patient_surname, patients.patient_othernames, patients.strath_no FROM visit_type, visit, patients WHERE visit.patient_id = patients.patient_id AND visit_type.visit_type_id = visit.visit_type AND visit.visit_date = '".$visit_date."'";
		
		$get = new Database();
		$rs = $get->select($sql);
		return $rs;
	}
	
	function get_all_report(){
		
		$sql= "select * from visit order by visit_date";
		echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		
		
	}
	function get_all_report_by_month($month){
		
		$sql= "select * from visit order by visit_date where visit_date LIKE '%$month%'";
		echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		
		echo $sql;
	}
	function get_visit_type(){
		
		$sql= "SELECT * FROM visit_type ORDER BY visit_type_name";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
	
	function get_services_count(){
		
		$sql= "SELECT COUNT(service_id) AS total_services FROM service WHERE report_distinct = 1";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
		
function get_day_insurance_report($x,$date1){
		
		$sql= "SELECT visit.visit_id, visit.visit_date, visit.personnel_id, company_insuarance.insurance_company_name, visit.visit_type, visit.patient_insurance_number, visit.patient_insurance_id, visit.patient_id
FROM visit, patient_insurance, company_insuarance
WHERE visit.patient_id = patient_insurance.patient_id
AND company_insuarance.company_insurance_id = '$x'
AND patient_insurance.company_insurance_id = '$x'
AND visit.visit_date = '$date1'";
//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function many_days_insurance_report($x,$date1,$date2){
		
		$sql= "SELECT visit.visit_id, visit.visit_date, visit.personnel_id, company_insuarance.insurance_company_name, visit.visit_type, visit.patient_insurance_number, visit.patient_insurance_id, visit.patient_id
FROM visit, patient_insurance, company_insuarance
WHERE visit.patient_id = patient_insurance.patient_id
AND company_insuarance.company_insurance_id = '$x'
AND patient_insurance.company_insurance_id = '$x'
AND visit.visit_date between'$date1' AND '$date2'
ORDER BY visit.visit_date";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function get_single_day_report($date1){
		
		$sql= "select * from visit where visit_date='$date1' order by visit_date";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function get_single_multiple_report($date1,$date2,$type){
		if($type=="all"){
		$sql= "select * from visit where visit_date  between'$date1' AND '$date2' order by visit_date";
		}else{
		
		$sql= "select * from visit where visit_date  between'$date1' AND '$date2' AND visit_type='$type' order by visit_date";
			}
			//echo $sql;
		
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
		function cash_single_day_report($date1,$type){
		if($type=="all"){
			$sql= "select * from payments where time LIKE '%$date1%'";
		}else{
		$sql= "select * from payments where time LIKE '%$date1%'  AND payment_method_id='$type'";
			}
//echo 'PPPP'.$sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function cash_single_multiple_report($date1,$date2,$type){
		if($type=="all"){
			$sql= "select * from payments where time  between'$date1' AND '$date2'";	
			
		}else {
			
			$sql= "select * from payments where time  between'$date1' AND '$date2' and  payment_method_id=$type";
			}
		//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function cash_single_report(){
		$sql= "select * from payments";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
	function expense_single_report(){
		$sql= "select * from expenses";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
		
	function cash_expenses_report($date1,$date2){	
		if(empty($date1)){
		$sql= "select * from expenses  where date LIKE '$date2%'";
		}
		elseif(empty($date2))	{
		$sql= "select * from expenses  where date LIKE '$date1%'";	
			}
		else{
			$sql= "select * from expenses where date  between '$date1' AND '$date2'";	
			
			}	
		
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}

	function cash_payment_type($payment_id){
		
		$sql= "select * from payment_method where payment_method_id='$payment_id'";
		//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
		function cash_payment(){
		
		$sql= "select * from payment_method";
		//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	
	
	function visit_charge_items($x){		
		$sql= "SELECT visit_charge.service_charge_id, visit_charge.visit_id,visit_charge.visit_charge_amount,visit_charge.visit_charge_units,service_charge.service_id 
		
		FROM visit_charge, service_charge, service 
		
		WHERE visit_id='$x' 
		AND visit_charge.service_charge_id=service_charge.service_charge_id 
		AND service.service_id=service_charge.service_id
		
		ORDER BY service_id";
		// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function service_id($service_charge_id){		
		$sql= "select * from service_charge where service_charge_id='$service_charge_id'";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function services(){		
		$sql= "SELECT * FROM service WHERE report_distinct=1 ORDER BY service_id";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
		function services_7_9($id,$id1){		
		$sql= "SELECT * FROM service WHERE report_distinct=1 and service_id=$id OR service_id=$id1";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
				
		function services_report($id){		
		$sql= "SELECT * FROM service WHERE report_distinct=1 and service_id=$id ";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function visit_type($visit_type_id){		
		$sql= "select * from visit_type where visit_type_id='$visit_type_id'";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function get_visit_insurance($patient_insurance_id){		
		$sql= "select * from patient_insurance where patient_insurance_id='$patient_insurance_id'";
		//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function get_insurance_discounts($insurance_id,$service_id){		
		$sql= "select * from insurance_discounts where insurance_id='$insurance_id' and service_id='$service_id'";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
	function get_patient($patient_id){		
		$sql= "select * from patients where patient_id='$patient_id'";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
		}
		
	function get_insurances(){		
		$sql= "SELECT * FROM `company_insuarance`";
		//echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
		function get_visit_payment($visit_id){		
			$sql= "select * from payments where visit_id='$visit_id'";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
	function get_patient_id($visit_id){		
		$sql= "select patient_id,visit_type,visit_date,patient_insurance_number from visit where visit_id=$visit_id";
		//// echo $sql;
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
		function get_patient_insurance($patient_insurance_id){		
		$sql= "SELECT insurance_company_name FROM `company_insuarance` WHERE company_insurance_id = (SELECT company_insurance_id FROM patient_insurance
WHERE patient_insurance_id =$patient_insurance_id)";
		$get = new Database();
		$rs=$get->select($sql);
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
		//echo 'STF'.$sql;
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
	
	function get_user_details($id){
		$sql = "SELECT * FROM personnel WHERE personnel_id = $id";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;	
	}
	function get_single_day_report2($date1){
		
		$sql= "select * from visit where visit_date='$date1' order by visit_type";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
	
	function get_single_multiple_report2($date1,$date2,$type){
		
		if($type=="all"){
			$sql= "select * from visit where visit_date  between'$date1' AND '$date2' order by visit_type";
		}
		else{
			$sql= "select * from visit where visit_date  between'$date1' AND '$date2' AND visit_type='$type' order by visit_type";
		}
		
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
	
	function get_all_report2(){
		
		$sql= "select * from visit order by visit_type";
		$get = new Database();
		$rs=$get->select($sql);
		return $rs;
	}
}

?>