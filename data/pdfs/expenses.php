<?php
session_start();
include '../../classes/Reports.php';
include ('../../fpdf16/fpdf.php');
//error_reporting(0);
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$personnel_id = $_SESSION['personnel_id'];

$get = new reports();
$rs = $get->get_user_details($personnel_id);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_onames");
	$personnel_fname = mysql_result($rs, 0, "personnel_fname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname;
}

if(!empty($date1) || !empty($date2)){

	$get1 = new reports;
	$rs_voucher = $get1->cash_expenses_report($date1, $date2);
	$num_rows_voucher = mysql_num_rows($rs_voucher);
}

else {

	$get1 = new reports;
	$rs_voucher = $get1->expense_single_report();
	$num_rows_voucher = mysql_num_rows($rs_voucher);
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
		$this->Cell(0, 5, 'Expenses Report', 'B', 1, 'C');
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
$width = 30;
$pdf->SetFont('Times','B',11);

$pdf->Cell($width*1.5,$pageH,'Date','B');
$pdf->Cell($width*2,$pageH,'Recepient','B');
$pdf->Cell($width,$pageH,'Reason','B',0);
$pdf->Cell($width,$pageH,'Amount','B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(2);
$total = 0;
 
for($x=0; $x<$num_rows_voucher; $x++){
	$id = mysql_result($rs_voucher, $x, "personnel_id");
	$amount = mysql_result($rs_voucher, $x, "amount");
	$recipient = mysql_result($rs_voucher, $x, "recipient");
	$reason = mysql_result($rs_voucher, $x, "reason");
	$date1 = mysql_result($rs_voucher, $x, "date");	
	$total += $amount;

	$pdf->Cell($width*1.5,$pageH,$date1,'B');
	$pdf->Cell($width*2,$pageH,$recipient,'B');
	$pdf->Cell($width,$pageH,$reason,'B',0);
	$pdf->Cell($width,$pageH,number_format($amount, 2, '.', ','),'B',1);
}

$pdf->Cell($width*1.5,$pageH,'','B');
$pdf->Cell($width*2,$pageH,'','B');
$pdf->Cell($width,$pageH,'','B',0);
$pdf->Cell($width,$pageH,number_format($total, 2, '.', ','),'B',1);

$_SESSION['personnel_name'] = NULL;
$pdf->Output();
?>