<?php
session_start();
include ('../classes/class_lab.php');
include ('../fpdf16/fpdf.php');
include("../classes/dates.php");

//$p_id = 
//$p_id = 1;
$visit_id=$_GET['visit_id'];
echo V.$visit_id;
$get5 = new checkup();
$rs5 = $get5->get_visit_pid($visit_id);
$num_rows= mysql_num_rows($rs5);
$p_id=mysql_result($rs5, 0, 'patient_id');
echo P.$p_id;	
class checkup{
	function medical_exam_categories(){
			$sql= "SELECT * FROM `medical_exam_categories`";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
	}
	function get_visit_charge($visit_id){
			$sql= "select visit_charge_amount, visit_charge_timestamp  from visit_charge where visit_id='$visit_id'";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
	}
	function get_credit_amount($visit_type_id){
			$sql= "select  account_credit, Amount, efect_date from account_credit where visit_type_id='$visit_type_id'";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
	}
		function get_visit_type_name($visit_type_id){
			$sql= "select  	visit_type_id,visit_type_name from visit_type where visit_type_id='$visit_type_id'";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
	}
			function get_visit_payment($visit_id){
			$sql= "select amount_paid from payments where visit_id='$visit_id'";
			//echo $sql;
			$get = new Database();
			$rs = $get->select($sql);
			return $rs;
	}
			function max_visit($p_id){
		$sql= "SELECT MAX(visit_id) FROM visit WHERE patient_id =$p_id";	
		//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;			
		}
		

				function min_visit($visit_id,$payment_method_id,$amount_paid){
		$sql= "SELECT MIN(time),payment_id FROM payments WHERE payment_method_id=$payment_method_id and visit_id=$visit_id and amount_paid=$amount_paid";	
		//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;			
		}
		
	function mec_med($mec_id){
		$sql= "select distinct item_format_id from  cat_items where mec_id=$mec_id";	
		//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;			
		}
		
	function format_id($item_format_id){
		$sql= "select * from  format where item_format_id=$item_format_id";	
	//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;			
		}
		
function get_cat_items($item_format_id, $mec_id){
	$sql="SELECT cat_items.cat_item_name, cat_items.cat_items_id, cat_items.item_format_id, format.format_name, format.format_id FROM cat_items, format WHERE cat_items.item_format_id = format.item_format_id 
	AND cat_items.item_format_id =$item_format_id AND mec_id =$mec_id";
		//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
	function cat_items($item_format_id, $mec_id){
	$sql="SELECT cat_items.cat_item_name, cat_items.cat_items_id FROM cat_items WHERE cat_items.item_format_id =$item_format_id AND mec_id =$mec_id";
	//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
		function cat_items2($cat_items_id,$format_id,$visit_id){
	$sql="SELECT *  FROM medical_checkup_results WHERE cat_id=$cat_items_id and format_id =$format_id and visit_id=$visit_id ";
	//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
			function get_illness($p_id,$mec_id){
	$sql="SELECT *  FROM med_check_text_save where med_id='$mec_id' and visit_id=$p_id";
//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
			function number_of_formats($item_format_id){
	$sql="SELECT * FROM `format` where item_format_id=$item_format_id";
//echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
	function get_visit_pid($visit_id){
	$sql="SELECT patient_id from visit where visit_id='$visit_id'";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;	
	
	}
	
	}
Class PDF extends FPDF{

	//page header
	function header(){
	$patient_id ="";
	//$patient_id = $_GET['patient_id'];
	
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
	$visit_type = mysql_result($rs, 0, "visit_type");
	$visit_date = $_SESSION['visit_date'];
	$patient_number =  mysql_result($rs, 0, "patient_number");
	//echo $strath_type;
	if($visit_type == 1){
							
		$get2 = new Lab();
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = oci_num_rows($rs2);//echo "rows = ".$rows;
			
		while (OCIFetch($rs2)) {
			$name = ociresult($rs2, "OTHER_NAMES");
			$secondname = ociresult($rs2, "SURNAME");
			$patient_dob = ociresult($rs2, "DOB");
			$patient_sex = ociresult($rs2, "GENDER");
			
		}
	}
						
	else if($visit_type == 2){
			
		$get2 = new Lab();
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			
		$name = mysql_result($rs2, 0, "Other_Name");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
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
		$current_date = date("y-m-d");	
		//get the age
		$date = new dates;
		$p_age = $date->dateDiff($patient_dob." 00:00", $current_date." 00:00", "year");
		
		//Colors of frames, background and Text
		$this->SetDrawColor(41, 22, 111);
		$this->SetFillColor(190, 186, 211);
		$this->SetTextColor(41, 22, 111);

		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
	//	$this->Image('../../img/createslogo.jpg',20,0,140);
		//font
		$this->SetFont('Arial', 'B', 12);
		//title

		$this->Ln(5);
		$this->Cell(100,5, 'MEDICAL CHECKUP RESULTS ', 0, 0, 'L');
		//$this->Cell(50, 5, 'Laboratory Report Form', 0, 0, 'L');
		$this->Cell(50, 5, 'Date: '.$visit_date, 'B', 1, 'L');

		$this->Cell(100,5,'Name:	'.$secondname." ".$name, 0, 0, 'L');
		$this->Cell(50,5,'Age:'.$p_age, 0, 0, 'L');
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
		//$personnel_id = 0;
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

$get2 = new checkup;
$rs2 = $get2->medical_exam_categories();
$rows = mysql_num_rows($rs2);

for ($a=0; $a < $rows; $a++){
	$mec_name= mysql_result($rs2, $a, 'mec_name');
	$mec_id= mysql_result($rs2, $a, 'mec_id');
	
	$get21 = new checkup;
	$rs21 = $get21-> get_illness($p_id,$mec_id);
	$rows1 = mysql_fetch_array($rs21);
	$mec_result= $rows1['infor'];
	
	if($mec_name=="Family History"){
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(0,10,$mec_name,'B',1,'L', $fill);
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);
	}
	
	else if(($mec_name=="Present Illness")||($mec_name=="Past Illness")) {
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(0,10,$mec_name,'B',1,'L', $fill);
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);
	}
	
	else if(($mec_name=="Physiological History")||($mec_name=="General Physical Examination")||($mec_name=="Head Physical Examination")||($mec_name=="Neck Physical Examination")||($mec_name=="Cardiovascular System Physical Examination")||($mec_name=="Respiratory System Physical Examination")||($mec_name=="Abdomen Physical Examination")||($mec_name=="Nervous System Physical Examination")) {
		$pdf->Ln(2);
		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(0,10,$mec_name,'B',1,'C', $fill);
		
		$get4 = new checkup;
		$rs4 = $get4->mec_med($mec_id);
		$rows4 = mysql_num_rows($rs4);
		$ab=0;
		$format_name="";
		for($a4=0; $a4 < $rows4; $a4++){
			
			$item_format_id=mysql_result($rs4, $a4, 'item_format_id');
			$ab++;
			
			$get6 = new checkup;
			$rs6 = $get6-> cat_items($item_format_id, $mec_id);
			$rows6 = mysql_num_rows($rs6);
			
			for($a6=0; $a6< $rows6; $a6++){
				
				$cat_item_name=mysql_result($rs6, $a6, 'cat_item_name');
				$cat_items_id1 =mysql_result($rs6, $a6, 'cat_items_id');
				
				$pdf->Ln(10);
				$pageH=5;
				$pdf->Cell(60,$pageH,$cat_item_name, 1,0,'L');
						
				$get7 = new checkup;
				$rs7 = $get7-> get_cat_items($item_format_id, $mec_id);
				$rows7 = mysql_num_rows($rs7); 
				
				
				//x & y position of the image
				
				for($a7=0; $a7< $rows7; $a7++){
					$cat_item_name=mysql_result($rs7, $a7, 'cat_item_name');
					$cat_items_id =mysql_result($rs7, $a7, 'cat_items_id');
					$item_format_id1 =mysql_result($rs7, $a7, 'item_format_id');
					$format_name =mysql_result($rs7, $a7, 'format_name');
					$format_id =mysql_result($rs7, $a7, 'format_id');
				
											
					if($cat_items_id==$cat_items_id1){
							$pdf->Cell(30,5,$format_name,0,0,'L',0,0);	
						if($item_format_id1== $item_format_id){
							
							$get8p = new checkup;
							$rs8p = $get8p->number_of_formats($item_format_id);
							$rows8p = mysql_num_rows($rs8p);
							
							$get8 = new checkup;
							$rs8 = $get8->cat_items2($cat_items_id,$format_id,$p_id);
							$rows8 = mysql_num_rows($rs8);
					//echo $rows8p;
					//echo K.$rows7.K;
							$mode_answer=($rows7%$rows8p);
					//echo $mode_answer;
								
							if  ($rows8>0){
							$pdf->Cell(10,5,'|\/|',0,0,'R',0,0);	
					
						//$pdf->Image('../img/checked.gif','','','','','');
						//$pdf->SetLeftMargin(45);
							}
			 				else { 		
								$pdf->Cell(10,5,'|__|',0,0,'R',0,0);	
						 	}
						}
					}
				}
			}
		}
	}
}

$get21 = new checkup;
$rs21 = $get21-> get_illness($p_id,"Further");
$rows1 = mysql_fetch_array($rs21);
$mec_result= $rows1['infor'];

$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0,10,'Further Details','B',1,'L', $fill);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);


$pdf->Ln(2);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(0,10,'Conclusion','B',1,'L', $fill);

$get21 = new checkup;
$rs21 = $get21-> get_illness($p_id,"conclusion");
$rows1 = mysql_fetch_array($rs21);
$mec_result= $rows1['infor'];

$pdf->Ln(2);
$pdf->Cell(10,0,'medically Fit',0,0, FALSE);
$pdf->Ln(2);

if($mec_result=='no'){
	$pdf->Cell(10,0,'YES:'.$pdf->Image('../img/unchecked.gif'),0,0,10, FALSE);
	$pdf->Cell(10,0,'NO:'.$pdf->Image('../img/checked.gif'),0,0,20, FALSE);	  
}

else {
	$pdf->Cell(10,0,'YES:'.$pdf->Image('../img/checked.gif'),0,0,10, FALSE);
	$pdf->Cell(10,0,'NO:'.$pdf->Image('../img/unchecked.gif'),0,0,20,  FALSE);	 
}
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);

$pdf->Output();

?>   
			
			