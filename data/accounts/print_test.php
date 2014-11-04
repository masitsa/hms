<?php
session_start();
include ('../../classes/class_lab.php');
include ('../../fpdf16/fpdf.php');
include("../../classes/dates.php");

$visit_id = $_GET['visit_id'];

$get = new Lab;
$lab_rs = $get->get_lab_visit($visit_id);
$num_lab_visit = mysql_num_rows($lab_rs);

$get2 = new Lab;
$rs2 = $get2->get_comment($visit_id);
$num_rows2 = mysql_num_rows($rs2);

if($num_rows2 > 0){
	$comment = mysql_result($rs2, 0, "lab_visit_comment");
	$_SESSION['visit_date'] = mysql_result($rs2, 0, "visit_date");
}

$s = 0;

Class PDF extends FPDF{

	//page header
	function header(){
	
	$patient_id = $_GET['patient_id'];
	
	if(empty($patient_id)){
		
		$visit_id = $_GET['visit_id'];
		$get3 = new Lab;
		$rs3 = $get3->get_patient_id($visit_id);
		$num_rs3 = mysql_num_rows($rs3);
		
		if($num_rs3 > 0){
			$patient_id = mysql_result($rs3, 0, "patient_id");
		}
	}
	$get = new Lab();
	$rs = $get->get_patient2($patient_id);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$visit_type = mysql_result($rs, 0, "visit_type_id");
	$visit_date = $_SESSION['visit_date'];
	$patient_number =  mysql_result($rs, 0, "patient_number");
	//echo $strath_type;
	if($visit_type == 1){
							
			$get2 = new Lab();
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
		
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
						
	else if($visit_type == 2){
			
		$get2 = new Lab();
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
	
	else{

		$name = mysql_result($rs, 0, "patient_othernames");
		$secondname = mysql_result($rs, 0, "patient_surname");
		$patient_dob = mysql_result($rs, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs, 0, "gender_id");
		
	}
		$current_date = date("y-m-d");	
		//get the age
		$date = new dates;
		$p_age = $date->dateDiff($patient_dob." 00:00", $current_date." 00:00", "year");
		
		$lineBreak = 10;
		
		//Colors of frames, background and Text
		$this->SetDrawColor(41, 22, 111);
		$this->SetFillColor(190, 186, 211);
		$this->SetTextColor(41, 22, 111);

		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		$this->Image('../../img/createslogo.jpg',20,0,140);
		//font
		$this->SetFont('Arial', 'B', 12);
		//title

		$this->Ln(25);
		$this->Cell(100,5, 'DIAGNOSTIC LABORATORY SERVICES', 0, 0, 'L');
		$this->Cell(50, 5, 'Laboratory Report Form', 0, 0, 'L');
		$this->Cell(50, 5, 'Date: '.$visit_date, 'B', 1, 'L');

		$this->Cell(100,5,'Name:	'.$secondname." ".$name, 0, 0, 'L');
		$this->Cell(50,5,'Age:'.$p_age, 0, 0, 'L');
		if(($patient_sex == 1) ||($patient_sex =='M')){
			$patient_sex = "Male";
		}
		elseif(($patient_sex == 2) ||($patient_sex =='F')){
			$patient_sex = "Female";
		}
		
		$_SESSION['patient_sex'] == $patient_sex;
		$this->Cell(50,5,'Sex:'.$patient_sex, 0, 1, 'L');
		//$this->Cell(-30);//move left
		$this->Cell(0,7,'Clinic Number:'.$patient_number, 'B', 1, 'L');
		//line break
		$pageH = 7;
		$this->SetTextColor(0, 0, 0);
		$this->SetDrawColor(0, 0, 0);
		$this->SetFont('Times','B',10);
	}

	//page footer
	function footer(){
		
		$this->SetDrawColor(41, 22, 111);
		$personnel_id = $_SESSION['personnel_id'];
		$get2 = new Lab;
		$rs2 = $get2->get_lab_personnel($personnel_id);
		$num_rows = mysql_num_rows($rs2);

		if($num_rows > 0){
	
			$personnel = mysql_result($rs2, 0, "personnel_surname");
			$personnel = $personnel." ".mysql_result($rs2, 0, "personnel_fname");
		}
		
		else{
			$personnel = "";
		}
		//position 1.5cm from Bottom
		$this->SetY(-15);
		//set Text color to gray
		$this->SetTextColor(128);
		//font
		$this->SetFont('Arial', 'I', 8);
		//time
		$this->Cell(40, 10, "Time: ".date("h:i:s"),'T',0,"L");
		//page number
		$this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}','T',0,"C");
		//personnel
		$this->Cell(0, 10, "Prepared By ".$personnel,'T',0,"R");
	}
}

//Instanciating the class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setFont('Times', '', 10);
$pdf->SetFillColor(190, 186, 211);

//HEADER
$billTotal = 0;
$linespacing = 2;
$majorSpacing = 7;
$pageH = 5;
$counter = 0;

if($num_lab_visit > 0){
	for($g = 0; $g < $num_lab_visit; $g++){
		
		$visit_charge_id = mysql_result($lab_rs, $g, "visit_charge_id");
		
				$gety2 = new Lab;
$rsy2 = $gety2->get_test_comment($visit_charge_id);
$num_rowsy2 = mysql_num_rows($rsy2);
if($num_rowsy2 >0){
$comment4= mysql_result($rsy2, 0, "lab_visit_format_comments");
}
else {
	
$comment4="";	
	}
		$format = new Lab;
		$format_rs = $format->get_lab_visit_result($visit_charge_id);
		$num_format = mysql_num_rows($format_rs);
		
	
		
		if($num_format > 0){
			$get = new Lab();
			$rs = $get->get_test($visit_charge_id);
			$num_lab = mysql_num_rows($rs);
			
		}
		
		else{
			$get = new Lab();
			$rs = $get->get_m_test($visit_charge_id);
			$num_lab = mysql_num_rows($rs);
			
					
		}
		

		if($num_lab > 0){

			for($r = 0; $r < $num_lab; $r++){

			$lab_test_name = mysql_result($rs, $r, "lab_test_name");
			$lab_test_class_name = mysql_result($rs, $r, "lab_test_class_name");
			$lab_test_units = mysql_result($rs, $r, "lab_test_units");
			$lab_test_lower_limit = mysql_result($rs, $r, "lab_test_malelowerlimit");
			$lab_test_upper_limit = mysql_result($rs, $r, "lab_test_malelupperlimit");
			$lab_test_lower_limit1 = mysql_result($rs, $r, "lab_test_femalelowerlimit");
			$lab_test_upper_limit1 = mysql_result($rs, $r, "lab_test_femaleupperlimit");
        	$visit_charge_id = mysql_result($rs, $r, "lab_visit_id");
       		$lab_results = mysql_result($rs, $r, "lab_visit_result");
			
			//results for formats
			if($_SESSION['test'] ==0){
			
				$test_format = mysql_result($rs, $r, "lab_test_formatname");
				$lab_test_format_id = mysql_result($rs, $r, "lab_test_format_id");
				$lab_results = mysql_result($rs, $r, "lab_visit_results_result");
				$lab_test_units = mysql_result($rs, $r, "lab_test_format_units");
				$lab_test_lower_limit = mysql_result($rs, $r, "lab_test_format_malelowerlimit");
				$lab_test_upper_limit = mysql_result($rs, $r, "lab_test_format_maleupperlimit");
				$lab_test_lower_limit1 = mysql_result($rs, $r, "lab_test_format_femalelowerlimit");
				$lab_test_upper_limit1 = mysql_result($rs, $r, "lab_test_format_femaleupperlimit");
			}
			
			//if there are no formats
			else{
				$test_format ="-";
			}


			if(($counter % 2) == 0){
				$fill = TRUE;
			}

			else{
				$fill = FALSE;
			}
			
			if ($r<$num_lab-1){
				$next_name = mysql_result($rs, $r+1, "lab_test_name");
			}
			
			if(($lab_test_name <> $next_name) || ($r == 0)){ 
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Times', 'B', 10);
				$pdf->Cell(50,$pageH,"TEST: ".$lab_test_name, 'B',1,'L', FALSE);
				$pdf->Cell(50,$pageH,"CLASS: ".$lab_test_class_name, 'B',1,'L', FALSE);
			
				$pdf->Ln(2);
				
				$pdf->Cell(50,$pageH,"Sub Test", 1,0,'L', FALSE);
				$pdf->Cell(50,$pageH,"Results",1,0,'L', FALSE);
				$pdf->Cell(50,$pageH,"Units",1,0,'L', FALSE);
				$pdf->Cell(30,$pageH,"Normal Limits",1,1,'L', FALSE);
				$pdf->SetFont('Times', '', 10);
			}
			
			$pdf->Cell(50,$pageH,$test_format, 1,0,'L', $fill);
			$pdf->Cell(50,$pageH,$lab_results,1,0,'L', $fill);
			$pdf->Cell(50,$pageH,$lab_test_units,1,0,'L', $fill);
			
			if($_SESSION['patient_sex'] == "Male"){
				$pdf->Cell(30,$pageH,$lab_test_lower_limit." - ".$lab_test_upper_limit,1,1,'L', $fill);
			}
			
			else{
				$pdf->Cell(30,$pageH,$lab_test_lower_limit1." - ".$lab_test_upper_limit1,1,1,'L', $fill);
			}
			$counter++;
		}
	}
			if($test_format !="-"){ 
			$pdf->Ln(3);
		$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0,10,"".$lab_test_name ."  Comment ",'B',1,'L', $fill);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$comment4,0,1,'L', $fill=true);
			}}
if(($counter % 2) == 0){
	$fill = TRUE;
}

else{
	$fill = FALSE;
}

$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0,10,"Comments ",'B',1,'L', $fill);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$comment,0,1,'L', $fill);
}

$pdf->Output();

?>