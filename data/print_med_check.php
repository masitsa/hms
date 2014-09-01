<?php
session_start();
include ('../classes/class_lab.php');
include ('../fpdf16/fpdf.php');
include("../classes/dates.php");

$personnel_idxi=$_SESSION['personnel_id'];
$visit_id=$_GET['visit_id'];
//echo $visit_id;
$get5 = new checkup();
$rs5 = $get5->get_visit_pid($visit_id);
$num_rows= mysql_num_rows($rs5);

$vid = $_GET['visit_id'];
$_SESSION['vid'] = $vid;
$p_id= $vid;

$get = new invoice();
$rs = $get->get_user_details($personnel_idxi);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_onames");
	$personnel_fname = mysql_result($rs, 0, "personnel_fname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname;
}
	$get = new invoice();
	$rs = $get->get_patient2($_SESSION['vid']);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "visit_type");
		$personnel_id = mysql_result($rs, 0,  	"personnel_id");
	$patient_number = mysql_result($rs, 0, "patient_number");
	$patient_insurance_id = mysql_result($rs, 0, "patient_insurance_id");
//echo P.$p_id;	
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

	
	//page$$_SESSION[_SESSION[$_SERVER[ header
	function header(){
		
		
		//$lineBreak = 20;
		//Colors of frames, background and Text
		$this->SetDrawColor(092, 123, 29);
		$this->SetFillColor(0, 232, 12);
		$this->SetTextColor(092, 123, 29);
		
		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		//$this->Image('../../images/strathmore.gif',10,8,45,15);
		//font
		$this->SetFont('Arial', 'B', 15);
		//title
		$this->Cell(0, 5, 'Strathmore University Medical Center Medical Checkup Form', 0, 1, 'L');
			$this->SetFont('Arial', 'B', 12);
		//name
	$get = new invoice();
	$rs = $get->get_patient2($_SESSION['vid']);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "visit_type");
		$personnel_idx = mysql_result($rs, 0,  	"personnel_id");
	$patient_number = mysql_result($rs, 0, "patient_number");
	$patient_insurance_id = mysql_result($rs, 0, "patient_insurance_id");
		$patient_insurance_number = mysql_result($rs, 0, "patient_insurance_number");
	$rsx = $get->get_user_details($personnel_idx);
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
							
		$get2 = new invoice();
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
		
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
						
	else if($strath_type == 2){
			
		$get2 = new invoice();
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
	
			$get2 = new invoice();
		$rs2 = $get2->get_patient_4($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			$name = mysql_result($rs2, 0, "names");
	//	$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
		else{
		$get2 = new invoice();
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
		if($patient_sex == 1){
			$patient_sex = "Male";
		}
		else{
			$patient_sex = "Female";
		}
		
		$_SESSION['patient_sex'] == $patient_sex;
	}
	
		$name2 = $secondname." ".$name;
		$get_patient_invoice = new invoice;
		$get_invoice = $get_patient_invoice->get_patient($_SESSION['vid']);
	
		
		$doctor = $personnel_fname." ".$personnel_surname;
	//	$this->Ln(3);
		$this->Cell(100,5,'Patient Name:	'.$name2, 0, 0, 'L');
		$this->Cell(0,5,'Att. Doctor:	'.$_SESSION['personnel_namex'], 0, 0, 'R');
		$this->ln(3);
		if($patient_insurance_id!=0){
				$getf = new invoice();
$rsf = $getf->get_insurance_name($patient_insurance_id);
$num_rowsf = mysql_num_rows($rsf);
$insurance_name=mysql_result($rsf, 0, 'insurance_company_name');
	//echo IN.$insurance_name;	
	/*	$this->Cell(100,5,'Insurance Name:'.$insurance_name, 'B', 0, 'L');
		$this->Cell(0,5,'Insurance Number:'.$patient_insurance_number , 'B', 1, 'R');	*/
		$this->Cell(0,5,'', 'B', 1, 'L');
	}
	else{
			$this->Cell(0,5,'', 'B', 1, 'L');
		
		}
	
	}

	//page footer
	function footer(){
		
		$this->SetDrawColor(41, 22, 111);
		$personnel_idxi=$_SESSION['personnel_id'];
		$get2 = new Lab;
		$rs2 = $get2->get_lab_personnel($personnel_idxi);
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
$pdf->SetFont('Times','B', 13);
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
	$pdf->SetFont('Times','B', 13);
		$pdf->Cell(0,5,$mec_name,'B',1,'L', $fill);
	;$pdf->Ln(3);
		
	$getf = new Lab;
	$rsf = $getf-> get_family_history($visit_id);
	$rowsf = mysql_num_rows($rsf);
	//echo 'RSF'.$rowsf;
	for($f=0; $f < $rowsf; $f++){
	$family_disease_name= mysql_result($rsf, $f, 'family_disease_name');
	$family_relationship= mysql_result($rsf, $f, 'family_relationship');
	//$mec_id= mysql_result($rs2, $a, 'mec_id');	
			$pdf->Ln(2);
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0,5,$family_relationship.'        -             '.$family_disease_name,0,1,'C', $fill);
		//$pdf->Cell(0,5,,0,1,'C', $fill);
		}
		
	}
	
	else if(($mec_name=="Present Illness")||($mec_name=="Past Illness")) {
	$pdf->SetFont('Times','B', 13);
		$pdf->Cell(0,5,$mec_name,'B',1,'L', $fill);
		$pdf->Ln(2);
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0,5,$mec_result,0,1,'L', $fill);$pdf->Ln(3);
	}
	
	else if(($mec_name=="Physiological History")||($mec_name=="General Physical Examination")||($mec_name=="Head Physical Examination")||($mec_name=="Neck Physical Examination")||($mec_name=="Cardiovascular System Physical Examination")||($mec_name=="Respiratory System Physical Examination")||($mec_name=="Abdomen Physical Examination")||($mec_name=="Nervous System Physical Examination")) {
		$pdf->Ln(10);
		$pdf->SetFont('Times','B', 13);
		$pdf->Cell(0,5,$mec_name,'B',1,'C', $fill);
		
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
				
				$pdf->Ln(9);
				$pageH=6;
				$pdf->SetFont('Times', '', 12);
				$pdf->Cell(60,$pageH,$cat_item_name, 1,0,'L');
						
				$get7 = new checkup;
				$rs7 = $get7-> get_cat_items($item_format_id, $mec_id);
				$rows7 = mysql_num_rows($rs7); 
				
				for($a7=0; $a7< $rows7; $a7++){
					$cat_item_name=mysql_result($rs7, $a7, 'cat_item_name');
					$cat_items_id =mysql_result($rs7, $a7, 'cat_items_id');
					$item_format_id1 =mysql_result($rs7, $a7, 'item_format_id');
					$format_name =mysql_result($rs7, $a7, 'format_name');
					$format_id =mysql_result($rs7, $a7, 'format_id');
				
											
					if($cat_items_id==$cat_items_id1){
														
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
							///echo $rows8;	
							//$pdf->MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
							
							if  ($rows8>0){
								//echo $a6;
							//	$pdf->Cell(30,5,$format_name,0,0,'R',0,0);
								
							
						if($a6==0){
						$pdf->SetFont('Times','B', 9);
							$pdf->Cell(28,'',$format_name,0,0,'C',0,0);
							$pdf->SetFont('Times', '', 20);
							$pdf->Cell(5,10,'|_X_|',0,0,'R',0,0);
							$pdf->SetFont('Times', '', 12);	
							}
							else {
								$pdf->SetFont('Times','B', 9);
							$pdf->Cell(28,'','',0,0,'R',0,0);
							$pdf->SetFont('Times', '', 20);	
								$pdf->Cell(5,3,'|_X_|',0,0,'R',0,0);
								$pdf->SetFont('Times', '', 12);
								}
						
							}
			 				else { 	
						
								if($a6==0){
									$pdf->SetFont('Times','B', 9);
							$pdf->Cell(28,'',$format_name,0, 0,'R',0,0);
							$pdf->SetFont('Times', '', 20);
							$pdf->Cell(5,10,'|____|',0,0,'R',0,0);
							$pdf->SetFont('Times', '', 12);	
							}
							else {
								$pdf->SetFont('Times','B', 9);
							$pdf->Cell(28,'','',0, 0,'R',0,0);
							$pdf->SetFont('Times', '', 20);
							$pdf->Cell(5,3,'|____|',0,0,'R',0,0);	
								$pdf->SetFont('Times', '', 12);
								}		
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
$pdf->SetFont('Times','B', 13);
$pdf->Cell(0,10,'Lab Tests Carried Out','B',1,'L', $fill);
$pdf->SetFont('Times', '', 10);
	
	$getd = new Lab;
	$rsd = $getd->  get_lab_checkup($visit_id);
	$rowsd = mysql_num_rows($rsd);
	//echo 'RSF'.$rowsf;
	for($d=0; $d < $rowsd; $d++){
	$service_charge_name= mysql_result($rsd, $d, 'service_charge_name');
		$pdf->Ln(2);
		$pdf->SetFont('Times', '', 12);
		$pdf->Cell(0,5,'-'.$service_charge_name,0,1,'L', $fill);
		//$pdf->Cell(0,5,,0,1,'C', $fill);
		}

$pdf->Ln(2);
$pdf->SetFont('Times','B', 13);
$pdf->Cell(0,10,'Further Details','B',1,'L', $fill);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);


$pdf->Ln(2);
$pdf->SetFont('Times','B', 13);
$pdf->Cell(0,10,'Conclusion','B',1,'L', $fill);



$pdf->Ln(2);
$pdf->SetFont('Times','B', 13);
$pdf->Cell(12,3,'Medically Fit:',0,0,'L', FALSE);

$get21 = new checkup;
$rs21 = $get21-> get_illness($p_id,"Medically");
$rows1 = mysql_fetch_array($rs21);
$mec_result= $rows1['infor'];

if($mec_result=='no'){
			$pdf->SetFont('Times', '', 10);
$pdf->Cell(50,3,'NO',0,1,'C',0,0);	
}

elseif($mec_result=='yes') {
$pdf->SetFont('Times', '', 10);
			$pdf->Cell(50,3,'YES',0,1,'C',0,0);		 
}
else{
$pdf->SetFont('Times', '', 10);
			$pdf->Cell(50,3,'',0,1,'C',0,0);		 
}
$get21 = new checkup;
$rs21 = $get21-> get_illness($p_id,"conclusion");
$rows1 = mysql_fetch_array($rs21);
$mec_result= $rows1['infor'];

$pdf->SetFont('Times', '', 10);
$pdf->Cell(0,10,$mec_result,0,1,'L', $fill);

$pdf->Output();

?>   
			
			