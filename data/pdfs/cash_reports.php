<?php
session_start();
include '../../classes/Reports.php';
include ('../../fpdf16/fpdf.php');
//error_reporting(0);
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$type=$_GET['type'];
$personnel_id = $_SESSION['personnel_id'];

$get = new reports();
$rs = $get->get_user_details($personnel_id);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_onames");
	$personnel_fname = mysql_result($rs, 0, "personnel_fname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname;
}

if(!empty($date1) && empty($date2)){

	$get = new reports;
	$rs = $get->cash_single_day_report($date1,$type);
	$num_rows = mysql_num_rows($rs);
	
	$get1 = new reports;
	$rs_voucher = $get1->cash_expenses_report($date1,$date2);
	$num_rows_voucher = mysql_num_rows($rs_voucher);
}

elseif(empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get->cash_single_day_report($date2,$type);
	$num_rows = mysql_num_rows($rs);
	
	$get1 = new reports;
	$rs_voucher = $get1->cash_expenses_report($date1,$date2);
	$num_rows_voucher = mysql_num_rows($rs_voucher);	
}	
elseif(!empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get-> cash_single_multiple_report($date1,$date2,$type);
	$num_rows = mysql_num_rows($rs);	
	
	$get1 = new reports;
	$rs_voucher = $get1->cash_expenses_report($date1,$date2);
	$num_rows_voucher = mysql_num_rows($rs_voucher);	
}
else {
	$get = new reports;
	$rs = $get->cash_single_report();
	$num_rows = mysql_num_rows($rs);	
}

class PDF extends FPDF{
	
	//page$$_SESSION[_SESSION[$_SERVER[ header
	function header(){
		
		
		$lineBreak = 20;
		//Colors of frames, background and Text
		$this->SetDrawColor(092, 123, 29);
		$this->SetFillColor(0, 232, 12);
		$this->SetTextColor(092, 123, 29);
		
		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		$this->Image('../../images/strathmore.gif',10,8,45,15);
		//font
		$this->SetFont('Arial', 'B', 12);
		//title
		$this->Cell(0, 5, 'Strathmore University Medical Center', 0, 1, 'C');
		$this->Cell(0, 5, 'P.O. Box 59857 00200, Nairobi, Kenya', 0, 1, 'C');
		$this->Cell(0, 5, 'info@strathmore.edu', 0, 1, 'C');
		$this->Cell(0, 5, 'Madaraka Estate', 'B', 1, 'C');
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(0, 5, 'Cash Report', 'B', 1, 'C');
		//name
	}
	
	//page footer
	function footer(){
		$fill = FALSE;
		//position 1.5cm from Bottom
		$this->SetY(-15);
		//set Text color to gray
		$this->SetTextColor(128);
		//font
		$this->SetFont('Arial', 'I', 8);
		//page number
		$this->Cell(0,5,'Served By:	'.$_SESSION['personnel_name'], 0, 0, 'L');
		$this->Cell(0, 5, 'Page '.$this->PageNo().'/{nb}',0,1,"C");
	}
}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setFont('Times', '', 12);
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

$pageH = 4;
$width = 20;
$pdf->SetFont('Times','B',11);

$pdf->Cell($width,$pageH,'Payment','B');
$pdf->Cell($width*2,$pageH,'Patient','B');
$pdf->Cell($width,$pageH,'Visit Date','B',0);
$pdf->Cell($width,$pageH,'Type','B',0);
$pdf->Cell($width,$pageH,'Number','B',0);
$pdf->Cell($width*2,$pageH,'Date','B',0);
$pdf->Cell($width,$pageH,'Amount','B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(2);
$total = 0;
for($a=0; $a<$num_rows; $a++){

	$amount_paid1 =mysql_result($rs,$a, "amount_paid");
	$visit_id=mysql_result($rs,$a, "visit_id");
	$time=mysql_result($rs,$a, "time");
	$payment_method_id=mysql_result($rs,$a,"payment_method_id");
	
	$get_patient_id= new reports;
	$rs_pataient_id= $get_patient_id->get_patient_id($visit_id);
	$patient_id=mysql_result($rs_pataient_id,0,'patient_id');
	$visit_type=mysql_result($rs_pataient_id,0,'visit_type');
	$visit_date=mysql_result($rs_pataient_id,0,'visit_date');
	$patient_insurance_number = mysql_result($rs_pataient_id, 0, "patient_insurance_number");
	
	$getd1 = new reports;
	$rsd1 = $getd1-> visit_type($visit_type);
	$num_rowsd1 = mysql_num_rows($rsd1);
	$visit_name= mysql_result($rsd1,0,'visit_type_name');
	
	$get_patience= new reports;
	$rs_pataient= $get_patience->get_patient($patient_id);
	$num_patient_rows= mysql_num_rows($rs_pataient);
	$patient_surname=mysql_result($rs_pataient,0,'patient_surname');
	$patient_othernames=mysql_result($rs_pataient,0,'patient_othernames');
	$strath_no=mysql_result($rs_pataient,0,'strath_no');
	$dependant_id=mysql_result($rs_pataient,0,'dependant_id');

	if($visit_type == 1){
								
		$get2 =  new reports;
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
		
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
							
	else if($visit_type == 2){
			
		$get2 =  new reports;
		$rs2 = $get2->get_patient_3($strath_no);
		//echo $strath_no;	
		$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
					or die("Unable to connect to MySQL".mysql_error());

		//selecting a database
		mysql_select_db("sumc", $connect)
					or die("Could not select database".mysql_error()); 
		$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !=0";
		$get2 =  new reports;
							$rs2 = $get2->get_patient_3($strath_no);
							//echo $strath_no;	
							$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
										or die("Unable to connect to MySQL".mysql_error());

							//selecting a database
							mysql_select_db("sumc", $connect)
										or die("Could not select database".mysql_error()); 
							$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !='0'";
							//echo $sqlq;
							$rsq = mysql_query($sqlq)
							or die ("unable to Select ".mysql_error());
							$num_rowsp=mysql_num_rows($rsq);
							
							//echo NUMP.$num_rowsp;
							if(($num_rowsp > 0)){
								$get2 =  new reports;
								$rs2 = $get2->get_patient_4($strath_no);
								$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
								
								$name = mysql_result($rs2, 0, "names");
								$secondname = '';
								$patient_dob = mysql_result($rs2, 0, "DOB");
								$patient_sex = mysql_result($rs2, 0, "Gender");
							}
							
							else{
						$get2 =  new reports;
								$rs2 = $get2->get_patient_3($strath_no);
								$rows = mysql_num_rows($rs2);
								//echo "rows = ".$rows;
								//echo $rows;	
								$name = mysql_result($rs2, 0, "Surname");
								$secondname = mysql_result($rs2, 0, "Other_names");
								$patient_dob = mysql_result($rs2, 0, "DOB");
								$patient_sex = mysql_result($rs2, 0, "gender");
							}
	}
	
	else{

		$name = mysql_result($rs_pataient, 0, "patient_othernames");
		$secondname = mysql_result($rs_pataient, 0, "patient_surname");
		$patient_dob = mysql_result($rs_pataient, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs_pataient, 0, "gender_id");
	}
	
	
	$get1 = new reports;
	$rs1 = $get1->cash_payment_type($payment_method_id);
	$num_rows1 = mysql_num_rows($rs1);
	$payment_method=mysql_result($rs1,0,"payment_method");
	
	$amount_paid=number_format($amount_paid1, 2, '.', ',');
	
	$pdf->Cell($width,$pageH,$payment_method,'B');
	$pdf->Cell($width*2,$pageH,$name.' '.$secondname,'B');
	$pdf->Cell($width,$pageH,$visit_date,'B',0);
	if($dependant_id==0){
		$visit_name = $visit_name; 
	}
	else {
		$visit_name = $visit_name.'<strong>  DPND  </strong>';
	}
	$pdf->Cell($width,$pageH,$visit_name,'B',0);
	if($dependant_id==0){
								
		if(!empty($strath_no)){
			$number = $strath_no;
		}
		else{
			if(empty($patient_insurance_number)){
				$patient_insurance_number = "-";
			}
			$number = $patient_insurance_number ; 
		}
	}
	else {
		$number = $dependant_id;
	}
	$pdf->Cell($width,$pageH, $number,'B',0);
	$pdf->Cell($width*2,$pageH, $time,'B',0);
	$pdf->Cell($width,$pageH, $amount_paid,'B',1);
	
	$total+=$amount_paid1;
}
$pdf->SetFont('Times','B',10);
$pdf->Cell($width,$pageH,'TOTAL','B');
$pdf->Cell($width*2,$pageH,'','B');
$pdf->Cell($width,$pageH,'','B',0);
$pdf->Cell($width,$pageH,'','B',0);
$pdf->Cell($width,$pageH, '','B',0);
$pdf->Cell($width*2,$pageH, '','B',0);
$pdf->Cell($width,$pageH, number_format($total, 2, '.', ','),'B',1);

$_SESSION['personnel_name'] = NULL;
$pdf->Output();
?>