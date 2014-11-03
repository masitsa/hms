<?php
session_start();

include '../../classes/Reports.php';
include ('../../fpdf16/fpdf.php');

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$type=$_GET['type'];
$personnel_id = $_SESSION['personnel_id'];

$get = new reports();
$rs = $get->get_user_details($personnel_id);
$num_rows = mysql_num_rows($rs);
                    
$gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	
 
for($s1=0; $s1<$num_rowss; $s1++){
	$service_id=mysql_result($rss,$s1, "service_id");
	$total_charges[$service_id] = 0;
}
$grand_total = 0;

if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_onames");
	$personnel_fname = mysql_result($rs, 0, "personnel_fname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname;
}

if(!empty($date1) && empty($date2)){

	$get = new reports;
	$rs = $get->get_single_day_report($date1,$type);
	$num_rows = mysql_num_rows($rs);
}
elseif(empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get->get_single_day_report($date2,$type);
	$num_rows = mysql_num_rows($rs);
}	
elseif(!empty($date1) && !empty($date2)){

	$get = new reports;
	$rs = $get-> get_single_multiple_report($date1,$date2,$type);
	$num_rows = mysql_num_rows($rs);
}
else{
	
	$get = new reports;
	$rs = $get->get_all_report();
	$num_rows = mysql_num_rows($rs);
}

class PDF extends FPDF{
	
	//page$$_SESSION[_SESSION[$_SERVER[ header
	function header(){
		
		
		$lineBreak = 20;
		//Colors of frames, background and Text
		$this->SetDrawColor(092, 123, 29);
		$this->SetFillColor(0, 232, 10);
		$this->SetTextColor(092, 123, 29);
		
		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		$this->Image('../../images/strathmore.gif',10,8,45,15);
		//font
		$this->SetFont('Arial', 'B', 10);
		//title
		$this->Cell(0, 5, 'Strathmore University Medical Center', 0, 1, 'C');
		$this->Cell(0, 5, 'P.O. Box 59857 00200, Nairobi, Kenya', 0, 1, 'C');
		$this->Cell(0, 5, 'info@strathmore.edu', 0, 1, 'C');
		$this->Cell(0, 5, 'Madaraka Estate', 'B', 1, 'C');
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(0, 5, 'Debtors Report', 'B', 1, 'C');
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
$pdf->setFont('Times', '', 10);
$pdf->SetFillColor(174, 255, 187); //226, 225, 225

$pageH = 4;
$width = 30;
$pdf->SetFont('Times','B',10);

$pdf->Cell($width/1.5,$pageH,'Type','B');
$pdf->Cell($width*1.3,$pageH,'Name','B');
$pdf->Cell($width/1.5,$pageH,'Number','B',0);
$pdf->Cell($width/1.5,$pageH,'Insurance','B',0);
$pdf->Cell($width/1.5,$pageH,'Date','B',0);

$gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
	$service_name=mysql_result($rss,$s1, "abr");
	$service_id=mysql_result($rss,$s1, "service_id");
	
	$pdf->Cell($width/2.4,$pageH,$service_name,'B',0);
}
$pdf->Cell($width/1.7,$pageH,'Total','B',0);
$pdf->Cell($width/1.7,$pageH,'Payment','B',0);
$pdf->Cell($width/1.7,$pageH,'Balance','B',1);
$pdf->SetFont('Times','',10);
$pdf->Ln(2);

$total_payments = 0;
$total_balance = 0;

for($a=0; $a<$num_rows; $a++){

	$patient_id=mysql_result($rs,$a, "patient_id");
	$visit_type=mysql_result($rs,$a, "visit_type");
	$visit_id=mysql_result($rs,$a, "visit_id");
	$visit_date=mysql_result($rs,$a, "visit_date");
	$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
	$patient_insurance_number = mysql_result($rs, $a, "patient_insurance_number");

	$get1 = new reports;
	$rs1 = $get1-> visit_charge_items($visit_id);
	$num_rows1 = mysql_num_rows($rs1);
	
	if ($num_rows1!=0){
		$temp1="";$total1="";
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
			$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id =0";
			//echo PP.$sqlq;
			$rsq = mysql_query($sqlq)
			or die ("unable to Select ".mysql_error());
			$num_rowsp=mysql_num_rows($rsq);
			
			//echo NUMP.$num_rowsp;
			if(($num_rowsp !=0)){
				$get2 =  new reports;
				$rs2 = $get2->get_patient_3($strath_no);
				$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
				//echo $rows;	
				$name = mysql_result($rs2, 0, "Surname");
				$secondname = mysql_result($rs2, 0, "Other_names");
				$patient_dob = mysql_result($rs2, 0, "DOB");
				$patient_sex = mysql_result($rs2, 0, "gender");
			}
			
			else{
				$get2 =  new reports;
				$rs2 = $get2->get_patient_4($strath_no);
				$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
				
				$name = mysql_result($rs2, 0, "names");
				$secondname = '';
				$patient_dob = mysql_result($rs2, 0, "DOB");
				$patient_sex = mysql_result($rs2, 0, "Gender");
			}
		}
		
		else{

			$name = mysql_result($rs_pataient, 0, "patient_othernames");
			$secondname = mysql_result($rs_pataient, 0, "patient_surname");
			$patient_dob = mysql_result($rs_pataient, 0, "patient_date_of_birth");
			$patient_sex = mysql_result($rs_pataient, 0, "gender_id");
		}

		$get1 = new reports;
		$rs1 = $get1-> visit_charge_items($visit_id);
		$num_rows1 = mysql_num_rows($rs1);
		$get3 = new reports;
		$rs3 = $get3-> services();
		$num_rows3 = mysql_num_rows($rs3);

		$temp_inv="";$total_inv=""; 
		$temp_amt1="";$total_amt1="";
		for($c=0; $c<$num_rows3; $c++){
			$service_id1=mysql_result($rs3,$c, 'service_id');
			$temp="";$total=""; 

			$y=""; 
			for($b=0; $b<$num_rows1; $b++){
				$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
				$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
				$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
				$visit_id1=mysql_result($rs1,$b, 'visit_id');
				$service_id=mysql_result($rs1,$b, 'service_id');
				$y++;

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
								
								if($percentage==""){
									$discounted_value=$amount;	
									$sum = $visit_charge_amount *$discounted_value*$visit_charge_units;			
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
						$sum; $total=$sum+$temp;  $temp=$total;	
					}

				}
	
				else {

				}
			}
			
			$total;
			$total_inv=$total+$temp_inv; $temp_inv=$total_inv;
			
		} 
		$total_inv;
		$gets_inv = new reports;
		$rss_inv = $gets_inv->get_visit_payment($visit_id);
		$num_rowss_inv = mysql_num_rows($rss_inv);
 
		$total_amt="";$temp_amt=""; 
		for($n=0; $n<$num_rowss_inv; $n++){
			$amount_paid =mysql_result($rss_inv,$n, "amount_paid");
 
			$total_amt=$amount_paid +$temp_amt;  $temp_amt=$total_amt;
		}  
		$temp_amt; 
		$temp_amt-$total_inv;
		$debtors=$temp_amt-$total_inv;
	}
	if($debtors < 0) { 
		
		if($dependant_id==0){
			$pdf->Cell($width/1.5,$pageH,$visit_name,'B');
		}
		else {
			$pdf->Cell($width/1.5,$pageH,$visit_name." DPND",'B');
		}
		$pdf->Cell($width*1.3,$pageH,$name.' '.$secondname,'B');
			
		if($dependant_id==0){
		
			if(!empty($strath_no)){
				$pdf->Cell($width/1.5,$pageH,$strath_no,'B',0);
			}
			else{
				if(empty($patient_insurance_number)){
					$patient_insurance_number = "-";
				}
				$pdf->Cell($width/1.5,$pageH,$patient_insurance_number,'B',0);
			}
		}
		else {
			$pdf->Cell($width/1.5,$pageH,$dependant_id,'B',0);
		}
		if($visit_name=="Insurance"){
			$getv = new reports;
			$rsv = $getv->get_patient_insurance($patient_insurance_id);
			$num_rowsv = mysql_num_rows($rsv);
			$patient_insurance_name=mysql_result($rsv,0,"insurance_company_name");	
		}
			
		else{
			$patient_insurance_name = "-";
		}
		$pdf->Cell($width/1.5,$pageH,$patient_insurance_name,'B',0);
		$pdf->Cell($width/1.5,$pageH,$visit_date,'B',0);
		
		$get1 = new reports;
		$rs1 = $get1-> visit_charge_items($visit_id);
		$num_rows1 = mysql_num_rows($rs1);
		
		$get3 = new reports;
		$rs3 = $get3-> services();
		$num_rows3 = mysql_num_rows($rs3);
		
		$temp_inv="";$total_inv=""; 

		for($c=0; $c<$num_rows3; $c++){
			$service_id1=mysql_result($rs3,$c, 'service_id');
			$temp="";
			$total=""; 
			$y=""; 
			
			for($b=0; $b<$num_rows1; $b++){
				$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
				$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
				$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
				$visit_id1=mysql_result($rs1,$b, 'visit_id');
				$service_id=mysql_result($rs1,$b, 'service_id');
				$y++;

				if($service_id==$service_id1){ 

					if($visit_name=="Insurance"){
						$get_insurnace = new reports;
						$rs_insurnace = $get_insurnace->get_visit_insurance($patient_insurance_id);
						$num_rows_insurnace = mysql_num_rows($rs_insurnace);
						$insurance_id=mysql_result($rs_insurnace,0,"company_insurance_id");

						$get_insurnace_discounts = new reports;
						$rs_insurnace_discounts = $get_insurnace_discounts->get_insurance_discounts($insurance_id,$service_id);
						$num_rows_insurnace_discounts = mysql_num_rows($rs_insurnace_discounts);

						for($disc=0; $disc<$num_rows_insurnace_discounts; $disc++){
							$percentage = mysql_result($rs_insurnace_discounts, $disc,"percentage");
							$amount = mysql_result($rs_insurnace_discounts,  $disc, "amount");
							$service_id_disc = mysql_result($rs_insurnace_discounts,  $disc, "service_id");
							$discounted_value="";	
							
							if($percentage==""){
								$discounted_value=$amount;	
								$sum = $visit_charge_amount *$discounted_value*$visit_charge_units;			
							}
							elseif($amount==""){
								$discounted_value=$percentage;
								$sum = $visit_charge_amount *((100-$discounted_value)/100)*$visit_charge_units;
							}				
							else{
								$sum=($visit_charge_amount * $visit_charge_units);
							}
						}

						$sum; $total=$sum+$temp;  $temp=$total;
					}


					else{
						$sum=($visit_charge_amount * $visit_charge_units);	
						$sum; $total=$sum+$temp;  $temp=$total;	
					}
					
				}

				else {
					$total = 0;
				}
			}
			$total_charges[$service_id] += $total;
			$pdf->Cell($width/2.4,$pageH,$total,'B',0);
			
			$total_inv=$total+$temp_inv; $temp_inv=$total_inv;
		} 
		$pdf->Cell($width/1.7,$pageH,$total_inv,'B',0);
		
		$gets_inv = new reports;
		$rss_inv = $gets_inv->get_visit_payment($visit_id);
		$num_rowss_inv = mysql_num_rows($rss_inv);

		$total_amt="";$temp_amt=""; 
		for($n=0; $n<$num_rowss_inv; $n++){
			$amount_paid =mysql_result($rss_inv,$n, "amount_paid");

			$total_amt=$amount_paid +$temp_amt;  $temp_amt=$total_amt;
			$inv=$temp_amt-$total_inv;
			$total_amt1=$inv +$temp_amt1;  $temp_amt1=$total_amt1;
		}
		
		if(empty($temp_amt)){
			$temp_amt = 0;
		}
		$total_payments += $temp_amt;
		$total_balance += ($temp_amt-$total_inv);
		$pdf->Cell($width/1.7,$pageH,$temp_amt,'B',0);
		$pdf->Cell($width/1.7,$pageH,$temp_amt-$total_inv,'B',1);
	}
}
$pdf->SetFont('Times','B',8);

$pdf->Cell($width/1.5,$pageH,'Total','B');
$pdf->Cell($width*1.3,$pageH,'','B');
$pdf->Cell($width/1.5,$pageH,'','B',0);
$pdf->Cell($width/1.5,$pageH,'','B',0);
$pdf->Cell($width/1.5,$pageH,'','B',0);

$gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
	$service_name=mysql_result($rss,$s1, "service_name");
	$service_id_e=mysql_result($rss,$s1, "service_id");
	$grand_total += $total_charges[$service_id_e];
	$pdf->Cell($width/2.4,$pageH,$total_charges[$service_id_e],'B',0);
}

$pdf->Cell($width/1.7,$pageH,$grand_total,'B',0);
$pdf->Cell($width/1.7,$pageH,$total_payments,'B',0);
$pdf->Cell($width/1.7,$pageH,$total_balance,'B',1);

$_SESSION['vid'] = NULL;
$_SESSION['personnel_name'] = NULL;
$pdf->Output();
?>