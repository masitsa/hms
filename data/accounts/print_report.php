<?php
session_start();
include '../../classes/Reports.php';
include ('../../fpdf16/fpdf.php');

$summary=$_GET['summary'];
$date1=$_GET['date1'];
$date2=$_GET['date2'];
$type=$_GET['type'];


if($date2==""){

	$get = new reports;
$rs = $get->get_single_day_report($date1,$type);
$num_rows = mysql_num_rows($rs);
}
elseif($date1==""){

$get = new reports;
$rs = $get->get_single_day_report($date2,$type);
$num_rows = mysql_num_rows($rs);	
}	
else if(($date1!="")&&($date2!="")&&($type!="")) {

$get = new reports;
$rs = $get-> get_single_multiple_report($date1,$date2,$type);
$num_rows = mysql_num_rows($rs);		
}
else{
	
		$get = new reports;
$rs = $get->get_all_report();
$num_rows = mysql_num_rows($rs);
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
}
	
	//page footer
	function footer(){
		
		//position 1.5cm from Bottom
		$this->SetY(-10);
		//set Text color to gray
		$this->SetTextColor(128);
		//font
		$this->SetFont('Arial', 'I', 8);
		//page number
		$this->Cell(0, 5, 'Page '.$this->PageNo().'/{nb}',0,1,"C");
	
	}
}


//$pdf = new FPDF('Landscape','mm','A4');
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setFont('Times', '', 12);
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

 
//HEADER
$billTotal = 0;
$linespacing = 2;
$majorSpacing = 7;
$pageH = 4;
$width = 25;
$units23 = 15;
$pdf->SetFont('Times','B',11);
$gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	
 	 	 	

$pdf->Cell(20,$pageH,'Type','B','','C');
$pdf->Cell(20,$pageH,'Name','B','','C');
$pdf->Cell(20,$pageH,'Date','B','','C');
for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id=mysql_result($rss,$s1, "service_id");

$pdf->Cell(24,$pageH,$service_name,'B','','C');
}
$width = 15;
//$pdf->Cell($width,$pageH,'Total','B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(2);
$pageH = 5;
$total = 0;
$width = 25;
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

$pdf->Output();

/***/
?>