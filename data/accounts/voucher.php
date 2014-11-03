<?php
session_start();
include ('../../classes/acconts.php');
include ('../../fpdf16/fpdf.php');
//error_reporting(0);
$voucher_id = $_GET['voucher_id'];

$get_voucher = new accounts();
$rs_voucher = $get_voucher->expenses_details($voucher_id);
$num_rows_voucher = mysql_num_rows($rs_voucher);
$id = mysql_result($rs_voucher, 0, "personnel_id");
$amount = mysql_result($rs_voucher, 0, "amount");
$recipient = mysql_result($rs_voucher, 0, "recipient");
$reason = mysql_result($rs_voucher, 0, "reason");
$date1 = mysql_result($rs_voucher, 0, "date");
 $_SESSION['time']=$date1 ;//echo $date;
$get = new accounts();
$rs = $get->get_user_details($id);
$num_rows = mysql_num_rows($rs);
if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_fname");
	$personnel_fname = mysql_result($rs, 0, "personnel_onames");
	//$personnel_mname = mysql_result($rs, 0, "personnel_mname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname." ";
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
		$this->Cell(0, 8, 'Cash Voucher', 'B', 0, 'L');
		

//echo $date;
		$this->Cell(0, 8, $_SESSION['time'] , 'B', 1, 'R');
		//name
}
	
	//page footer
	function footer(){
		

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
$pageH = 8;
$counter = 0;
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 15);
			
$pdf->Cell(70,$pageH,"Reason", 1,0,'C', FALSE);
$pdf->Cell(70,$pageH,"Amount",1,0,'C', FALSE);
$pdf->Ln(8);

$pdf->SetFont('Arial', '', 13);
$pdf->Cell(70,$pageH,$reason, 1,0,'C', $fill);
$pdf->Cell(70,$pageH,number_format($amount, 2, '.', ','),1,0,'C', $fill);

//$pdf->Cell(50,$pageH,$lab_test_units,1,0,'L', $fill);
$pdf->Ln(13);			
			
$pdf->Cell(150,$pageH,"Received by : ".$recipient."Signature: ", 'B',1,'L', FALSE);

$pdf->Ln(10);
$pdf->Cell(150,$pageH,"Issued by: ".$_SESSION['personnel_name']."				Signature: ", 'B',1,'L', FALSE);


//HEADER
$billTotal = 0;
$linespacing = 2;
$majorSpacing = 7;
$pageH = 4;
$width = 30;


$pdf->Output();
$_SESSION['personnel_name'] = NULL;

?>