<?php
session_start();
include '../../classes/Reports.php';
include ('../../fpdf16/fpdf.php');
//error_reporting(0);
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$type=$_GET['type'];
$personnel_id = $_SESSION['personnel_id'];
$temp_jj = 0;

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
	$rs = $get->get_single_day_report2($date1,$type);
	$num_rows = mysql_num_rows($rs);
}
elseif(empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get->get_single_day_report2($date2,$type);
	$num_rows = mysql_num_rows($rs);	
}	
elseif(!empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get-> get_single_multiple_report2($date1,$date2,$type);
	$num_rows = mysql_num_rows($rs);		
}
else{
	
	$get = new reports;
	$rs = $get->get_all_report2();
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
		$this->Cell(0, 5, 'General Summary', 'B', 1, 'C');
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

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->setFont('Times', '', 12);
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

$pageH = 4;
$width = 30;
$pdf->SetFont('Times','B',11);

$pdf->Cell($width/1.5,$pageH,'Type','B');

$gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
	$service_name=mysql_result($rss,$s1, "service_name");
	$service_id=mysql_result($rss,$s1, "service_id");
	
	$pdf->Cell($width/1.1,$pageH,$service_name,'B',0);
	
	$service_total[$service_id] = 0;
}
$pdf->Cell($width/2,$pageH,"Total",'B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(2);

/*
	-----------------------------------------------------------------------------------------
	Get number of services
	-----------------------------------------------------------------------------------------
*/
$gets = new reports;
$rs_services = $gets->get_services_count();
$total_services = mysql_result($rs_services, 0, "total_services");

/*
	-----------------------------------------------------------------------------------------
	Get visit types
	-----------------------------------------------------------------------------------------
*/
$gets = new reports;
$rs_visit_type = $gets->get_visit_type();
$num_visit_type = mysql_num_rows($rs_visit_type);

$count = 0;
$total_cost = 0;
$prev_service = 0;
$grand_total = 0;

for($r = 0; $r < $num_visit_type; $r++){
	
	$visit_type_name = mysql_result($rs_visit_type, $r, "visit_type_name");
	$visit_type_id = mysql_result($rs_visit_type, $r, "visit_type_id");
	$pdf->Cell($width/1.5,$pageH, $visit_type_name, 'B');
	
	for($c = 0; $c < $num_rowss; $c++){
		$service_id1=mysql_result($rss, $c, 'service_id'); 
		$prev_service = $service_id1;
		$service_id_e = $service_id1;
		
		$temp_inv1="";
		$total_inv1=""; 
		$temp1="";
		$total1="";
		$temp="";
		$total="";	
		
		if($num_rows > 0){
			for($a=0; $a<$num_rows; $a++){
			
				$patient_id=mysql_result($rs,$a, "patient_id");
				$visit_type=mysql_result($rs,$a, "visit_type");
				$visit_id=mysql_result($rs,$a, "visit_id");
				$visit_date=mysql_result($rs,$a, "visit_date");
				$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
				
				if($visit_type == $visit_type_id){
					$get1 = new reports;
					$rs1 = $get1-> visit_charge_items($visit_id);
					$num_rows1 = mysql_num_rows($rs1);
					
					if ($num_rows1!=0){
						
						$getd1 = new reports;
						$rsd1 = $getd1-> visit_type($visit_type);
						$num_rowsd1 = mysql_num_rows($rsd1);
						$visit_name= mysql_result($rsd1,0,'visit_type_name');
						
						$get1 = new reports;
						$rs1 = $get1-> visit_charge_items($visit_id);
						$num_rows1 = mysql_num_rows($rs1);
							
						$y="";
						
						for($b=0; $b<$num_rows1; $b++){
							$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
							$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
							$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
							$visit_id1=mysql_result($rs1,$b, 'visit_id');
							$service_id=mysql_result($rs1,$b, 'service_id');
							$y++;
							
							if($service_id_e==$service_id){ 
								
								$sum1=($visit_charge_amount*$visit_charge_units);
								
								$total1=$sum1+$temp1;  
								$temp1=$total1;
								 
								if($service_id==$service_id1){ 
							
									if($visit_name=="Insurance"){
										$get_insurnace = new reports;
										$rs_insurnace = $get_insurnace-> get_visit_insurance($patient_insurance_id);
										$num_rows_insurnace = mysql_num_rows($rs_insurnace);
										
										if($num_rows_insurnace > 0){
											$insurance_id=mysql_result($rs_insurnace,0,"company_insurance_id");
											
											$get_insurnace_discounts = new reports;
											$rs_insurnace_discounts = $get_insurnace_discounts-> get_insurance_discounts($insurance_id,$service_id);
											$num_rows_insurnace_discounts = mysql_num_rows($rs_insurnace_discounts);
									
											for($disc=0; $disc<$num_rows_insurnace_discounts; $disc++){
												$percentage = mysql_result($rs_insurnace_discounts, $disc,"percentage");
												$amount = mysql_result($rs_insurnace_discounts,  $disc, "amount");
												$service_id_disc = mysql_result($rs_insurnace_discounts,  $disc, "service_id");
												$discounted_value="";	
												
												if($percentage==0){
													$discounted_value=$amount;	
													$sum = ($visit_charge_amount -$discounted_value)*$visit_charge_units;			
												}
												elseif($amount==""){
													$discounted_value=$percentage;
													$sum = $visit_charge_amount *((100-$discounted_value)/100)*$visit_charge_units;
												}				
												else{
													$sum=($visit_charge_amount * $visit_charge_units);
												}
											}
										}
										else{
											$sum = 0;
											$temp = 0;
										}
										$sum; 
										$total=$sum+$temp;  
										$temp=$total;
									}
									else{
										$sum=($visit_charge_amount * $visit_charge_units);	
										$sum; 
										$total=$sum+$temp;  
										$temp=$total;
									}
								}
							}
						}
					}
					else{
						$total = 0;
					}
				} 
				$temp_inv1=$total_cost;
			}
		}
		
		else{
			$total = 0;
		}
		
		if(empty($total)){
			$total = 0;
		}
		$total_cost=$total;
		
		/*
			-----------------------------------------------------------------------------------------
			When going to the next service, display the total of the previous service
			-----------------------------------------------------------------------------------------
		*/
		$pdf->Cell($width/1.1,$pageH, $total_cost, 'B',0);
		$service_total[$service_id1] += $total_cost;
		$prev_service = $service_id1;
		$grand_total += $total_cost;
		$total_cost = 0;
		$count++;
			
		/*
			-----------------------------------------------------------------------------------------
			When reaching the last service of the current visit type, display the visit type total
			-----------------------------------------------------------------------------------------
		*/
		if($total_services == $count){
			$pdf->Cell($width/2,$pageH,$grand_total,'B',1);
			$count = 0;
			$grand_total = 0;
		}
	}
}
$pdf->setFont('Times', 'B', 10);
$pdf->Cell($width/1.5,$pageH,'TOTAL','B');
$totals = 0;

for($s1=0; $s1<$num_rowss; $s1++){
	
	$service_id=mysql_result($rss,$s1, "service_id");
	
	$pdf->Cell($width/1.1,$pageH,$service_total[$service_id],'B',0);
	$totals += $service_total[$service_id];
}
$pdf->Cell($width/2,$pageH,$totals,'B',1);

$_SESSION['vid'] = NULL;
$_SESSION['personnel_name'] = NULL;
$pdf->Output();
?>