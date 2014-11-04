<?php
session_start();
include ('../../classes/acconts.php');
include ('../../fpdf16/fpdf.php');
//error_reporting(0);
$payment_id = $_GET['payment_id'];

$get2 = new accounts;
$rs2 = $get2->get_visit_id($payment_id);

$_SESSION['vid'] = mysql_result($rs2, 0, "visit_id");
//$personnel_id = 1;
$personnel_id=$_SESSION['personel_id'];
$get = new accounts();
$rs = $get->get_user_details($personnel_id);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_surname");
	$personnel_fname = mysql_result($rs, 0, "personnel_fname");
	//$personnel_mname = mysql_result($rs, 0, "personnel_mname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname." ".$personnel_mname;
}

Class PDF extends FPDF{
	
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
		$this->Cell(0, 5, 'RECEIPT', 'B', 1, 'C');
		//name
$get = new accounts;
	$rs = $get->get_patient2($_SESSION['vid']);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "visit_type_id");
		$personnel_id = mysql_result($rs, 0,  	"personnel_id");
	$patient_number = mysql_result($rs, 0, "patient_number");
	$rsx = $get->get_user_details($personnel_id);
$num_rowsx = mysql_num_rows($rsx);

if($num_rowsx > 0){
	$personnel_surname = mysql_result($rsx, 0, "personnel_onames");
	$personnel_fname = mysql_result($rsx, 0, "personnel_fname");
	$_SESSION['personnel_namex'] = $personnel_surname." ".$personnel_fname;
}
	$visit_date = $_SESSION['visit_date'];
	$name = "";
		$secondname = "";
		
	if($strath_type == 1){
							
		$get2 = new accounts;
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
		
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
						
	else if($strath_type == 2){
			
		$get2 = new accounts;
		$rs2 = $get2->get_patient_3($strath_no);
		//echo $strath_no;	
		$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error()); 
		$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !=0";
	//	echo PP.$sqlq;
		$rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		$num_rowsp=mysql_num_rows($rsq);
		
		//echo NUMP.$num_rowsp;
		if($num_rowsp>0){
		$get2 = new accounts;
		$rs2 = $get2->get_patient_4($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		//echo $rows;	
	if($rows > 0){
		$name = mysql_result($rs2, 0, "names");
		//$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
			
		}
		else{
		$get2 = new accounts;
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		}}
	}
	
	else{

		$name = mysql_result($rs, 0, "patient_othernames");
		$secondname = mysql_result($rs, 0, "patient_surname");
		$patient_dob = mysql_result($rs, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs, 0, "gender_id");
		if($patient_sex == 1){
			$patient_sex = "Male";
		}
		else{
			$patient_sex = "Female";
		}
		
		$_SESSION['patient_sex'] == $patient_sex;
	}
	
		$name2 = $secondname." ".$name;
		$get_patient_invoice = new accounts;
		$get_invoice = $get_patient_invoice->get_patient($_SESSION['vid']);
		
		/*$patien_surname = mysql_result($get_invoice, 0, "patient_surname");
		$patient_middlename = mysql_result($get_invoice, 0, "patient_middlename");
		$patient_firstname = mysql_result($get_invoice, 0, "patient_firstname");
		$patient_number = mysql_result($get_invoice, 0, "patient_number");
		$personnel_surname = mysql_result($get_invoice, 0, "personnel_surname");
		$personnel_fname = mysql_result($get_invoice, 0, "personnel_fname");*/
		
		$doctor = $personnel_fname." ".$personnel_surname;
		
		$this->Ln(3);
		$this->Cell(100,5,'Patient Name:	'.$name2, 0, 0, 'L');
		$this->Cell(0,5,'Invoice Number:	INV/00'.$_SESSION['vid'], 0, 1, 'L');
		$this->Cell(100,5,'Patient Number:	'.$patient_number, 0, 0, 'L');
		$this->Cell(0,5,'Att. Doctor:	'.$_SESSION['personnel_namex'], 0, 1, 'L');
		$this->Cell(0,5,'Invoice Date:	'.date("20y-m-d"), 'B', 1, 'L');
		$this->Ln(3);
	}
	
	//page footer
	function footer(){
		
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

//payments
$get = new accounts;
$amount_rs= $get->get_amount_paid2($payment_id);
$num_amount = mysql_num_rows($amount_rs);

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setFont('Times', '', 12);
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

//HEADER
$billTotal = 0;
$linespacing = 2;
$majorSpacing = 7;
$pageH = 4;
$width = 30;
$pdf->SetFont('Times','B',11);
$pdf->Cell(40,$pageH,'Date','B');
$pdf->Cell($width,$pageH,'Payment Method','B');
$pdf->Cell($width,$pageH,'Amount Paid','B',0,'C');
$pdf->SetFont('Times','',10);
$pdf->Ln(10);
$pageH = 5;
$pdf->SetFillColor(174, 255, 187); //226, 225, 225
$receipt_total = $consultationcharge + $prescriptiontotal + $laboratory_total + $proceduretotal;
$total_paid = 0;
$counter = 0;
for($r = 0; $r < $num_amount; $r++){
	
	$date = mysql_result($amount_rs, $r, "time");
	$amount_paid = mysql_result($amount_rs, $r, "amount_paid");
	$payment_method = mysql_result($amount_rs, $r, "payment_method");
	
	$pdf->Cell(40,$pageH,$date,'B',0,'C',$fill);
	$pdf->Cell($width,$pageH,$payment_method,'B',0,"L",$fill);
	$pdf->Cell($width,$pageH,$amount_paid,'B',0,"L",$fill);
	$pdf->Cell($width,$pageH,"",'B',0,"L",$fill);
	$pdf->Cell($width,$pageH,"",'B',0,"L",$fill);
	$pdf->Cell($width,$pageH,"",'B',1,"L",$fill);
}

$pdf->Output();
$_SESSION['vid'] = NULL;
$_SESSION['personnel_name'] = NULL;

?>