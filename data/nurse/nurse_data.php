<?php
session_start();

include("../../classes/class_nurse.php");
include("../../classes/dates.php");

$visit_id = $_GET['visit_id'];
$personnel_id = $_SESSION['personnelle_id'];

$get = new nurse;
$rs = $get->get_patient_id($visit_id);

$patient_id=mysql_result($rs,0, "patient_id");
$visit_type=mysql_result($rs,0, "visit_type");
$visit_id=mysql_result($rs,0, "visit_id");
$visit_date=mysql_result($rs,0, "visit_date");
//$patient_insurance_id=mysql_result($rs,0,"patient_insurance_id");
//$patient_insurance_number=mysql_result($rs,$a,"patient_insurance_number");
$patient_insurance_number = mysql_result($rs, $a, "patient_insurance_number");


//if($_SESSION['strath_no'] == NULL){
	$get = new nurse();
	$rs = $get->get_patient($patient_id);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$visit_type = mysql_result($rs, 0, "visit_type_id");
	
	$num_patient_rows= mysql_num_rows($rs);
$patient_surname=mysql_result($rs,0,'patient_surname');
$patient_othernames=mysql_result($rs,0,'patient_othernames');
$strath_no=mysql_result($rs,0,'strath_no');
$dependant_id=mysql_result($rs,0,'dependant_id');
						
	if($visit_type == 1){
							
		$get2 = new nurse();
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
			//echo $strath_no;
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
		else if($visit_type == 2){
			
		$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error()); 
		$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !=0";
		//echo PP.$sqlq;
		$rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		$num_rowsp=mysql_num_rows($rsq);
		
		if($num_rowsp >0){

			$get2 = new nurse();
		$rs2 = $get2->get_patient_4($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			$name = mysql_result($rs2, 0, "names");
	//	$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");		
	
	}
		else{
					$get2 = new nurse();
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		//echo $rows;	
	
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");

		}
	}
	
	else{

		$name = mysql_result($rs, 0, "patient_othernames");
		$secondname = mysql_result($rs, 0, "patient_surname");
		$patient_dob = mysql_result($rs, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs, 0, "gender_id");
	}
	

		$current_date = date("y-m-d");
//get the age
if($patient_dob !="0000-00-00"){
$date = new dates;
$p_age = $date->dateDiff($patient_dob." 00:00", $current_date." 00:00", "year");
}
$get_hold = new nurse();
$get_hold_rs = $get_hold->check_hold($visit_id,$personnel_id);
$hold_rows = mysql_num_rows($get_hold_rs);

echo
"<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>
	<table border='0'>
		<tr>
			<td ><strong>Surname: </strong></td>
			<td >".$secondname."</td>
			<td><strong>   Other Names: </strong></td>
			<td >".$name."</td>
			<td ><strong>   Age: </strong></td>
			<td>".$p_age."</td>
			<td><strong>   Sex: </strong></td>
			<td>".$patient_sex."</td>
			<td>";
			if($hold_rows >0){echo"
			<input type='button' class='btn btn-primary' value='unhold' onclick='unhold_visit(".$visit_id.")'/>
			";}else{
			echo"
			<input type='button' class='btn btn-primary' value='hold' onclick='hold_visit(".$visit_id.")'/>
			";}
			
			for ($a= 0; $a < $_SESSION['department_array_length']; $a++){
			$department = $_SESSION['department'][$a];
		
			if ($department == "Nurse"){
			
			echo"
			</td>
			<td><input name='to_lab' type='button' value='laboratory' onclick='open_window_lab(2)'/></td>
			";
			for($g = 0; $g < $num_plan; $g++){
											
											$plan = mysql_result($plan_rs, $g, "plan_name");
											$plan_id=mysql_result($plan_rs, $g, "plan_id");
											if($plan != "Prescribe Drugs"){}
											else{
												echo"
			<td><input type='button' onclick='open_window(".$plan_id.")' value=".$plan."/></td>";
											}
											}
			}
			}
			echo"
		</tr>
	</table></p></div>
";
?>