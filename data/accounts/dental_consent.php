<?php
session_start();
include ('../../classes/acconts.php');
include ('../../fpdf16/draw.php');

$vid = $_GET['visit_id'];
$_SESSION['vid'] = $vid;
$personnel_id=$_SESSION['personel_id'];
	$get = new accounts;
	$rs = $get->get_patient2($_SESSION['vid']);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "visit_type_id");
		$personnel_idx = mysql_result($rs, 0,  	"personnel_id");
	$patient_number = mysql_result($rs, 0, "patient_number");
	$patient_insurance_id = mysql_result($rs, 0, "patient_insurance_id");
$get = new accounts();
$rs = $get->get_user_details($personnel_id);
$num_rows = mysql_num_rows($rs);
if($num_rows > 0){
	$personnel_surname = mysql_result($rs, 0, "personnel_fname");
	$personnel_fname = mysql_result($rs, 0, "personnel_onames");
	//$personnel_mname = mysql_result($rs, 0, "personnel_mname");
	$_SESSION['personnel_name'] = $personnel_surname." ".$personnel_fname." ";
}

class PDF extends PDF_Draw {
	
	//page$$_SESSION[_SESSION[$_SERVER[ header
	function header(){
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
		
	if($num_rowsp>0){
		$get2 = new accounts();
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		//echo $rows;	
	if($rows > 0){
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
			
		}
	}
		else{
		$get2 = new accounts();
		$rs2 = $get2->get_patient_4($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
			$name = mysql_result($rs2, 0, "names");
	//	$secondname = mysql_result($rs2, 0, "Surname");
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
		$lineBreak = 20;
		//Colors of frames, background and Text
		$this->SetDrawColor(092, 123, 29);
		$this->SetFillColor(0, 232, 12);
		$this->SetTextColor(092, 123, 29);
		
		//thickness of frame (mm)
		//$this->SetLineWidth(1);
		//Logo
		//$this->Image('../../images/strathmore.gif',10,8,45,15);
		//font
		$this->SetFont('Arial', 'B', 12);
		//title
		$this->Cell(0, 5, 'Strathmore University Medical Center Dental Consent Form', 0, 1, 'C');
		$this->Cell(0, 5, 'Patient :  '.$name2.'', 0, 0, 'L'); $this->Cell(0, 5, 'P.O. Box 59857 00200, Nairobi, Kenya', 0, 1, 'R');
		$this->Cell(0, 5, 'Date :'.date('d/m/20y').'', 0, 0, 'L'); $this->Cell(0, 5, 'info@strathmore.edu,   Madaraka Estate', 0, 1, 'R');
		
		$this->SetFont('Arial', 'B', 10);
		$this->Ln(2);
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
		$this->Cell(0,5,'Prepared By:	'.$_SESSION['personnel_name'], 0, 0, 'L');
		$this->Cell(0, 5, 'Page '.$this->PageNo().'/{nb}',0,1,"C");
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

$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(185,5,"To be completed by clinician confirming patient's consent: ",0,'',FALSE); 
$pdf->Cell('','','', 0, 1, 'L', FALSE);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(185,5,'On behalf of the team treating the patient, I have confirmed with the patient that s/he wants the procedure to go ahead. I have also checked that any further questions that the patient has have been answered. ',0);
$pdf->Cell('', 6, 'Name:_______________________', 0, 0, 'L', FALSE);
$pdf->Cell('', 6, 'Signature:________________________', 0, 1, 'R', FALSE);  $pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 10); 
$pdf->MultiCell(185,5,'To be filled in by the clinician(s) providing the information to the patient',0,'',FALSE); 
$pdf->Cell('','','', 0, 1, 'L', FALSE);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(185,5,'I confirm that I have explained the treatment to the patient, along with the significant risks and the possible
alternatives. I also confirm that I have the necessary competence to provide this information.',0);
$pdf->Cell('', 6, 'Name:_______________________', 0, 0, 'L', FALSE);
$pdf->Cell('', 6, 'Date:________________________', 0, 1, 'R', FALSE); 
 
$pdf->Cell('', 6, 'Signature:________________________', 0, 0, 'L', FALSE);
 $pdf->Cell('', 6, 'Position:_________________________', 0, 1, 'R', FALSE);
 $pdf->Ln(5);	
 $pdf->MultiCell(185,5,'(If a second Clinician is involved in providing Information)',0);
  $pdf->MultiCell(185,5,'Name:_______________________      Signature:_____________________      Date:_________________',0);

 $pdf->SetFont('Arial', 'B', 9);	
 $pdf->Cell(40, 6, 'If Interpreter Present:',0, 0, 'L', FALSE);
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(150,6,'I have interpreted the information regarding diagnosis and treatment to the patient to the best of my ability and in terms which I believe he/she can understand.',0,'L',FALSE);
  $pdf->MultiCell(185,5,'Name:_______________________      Signature:_____________________      Date:_________________',0); $pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(185,5,'To be filled in by the patient or (in the case of children unable to consent for themselves) by a person with parental responsibility.',0,'',FALSE); 
$pdf->Cell('','','', 0, 1, 'L', FALSE);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(185,5,'Please read this form carefully. If your treatment has been planned in advance, you should already have been
explained to, or given your own copy of the proposed treatment plan. If you have any further questions do ask the person who is asking you to sign this form. You have the right to change your mind at any time, including after you have signed this form.',0,'');  $pdf->Ln(5);

  $pdf->SetFont('Arial', 'B', 9);	
 $pdf->Cell(40, 6, 'I Agree:',0, 0, 'L', FALSE);
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(150,6,'to what has been explained to me by the person(s) named on this form;',0,'L',FALSE);
 
 $pdf->SetFont('Arial', 'B', 9);	
 $pdf->Cell(40, 6, 'I Understand:',0, 0, 'L', FALSE);
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(150,6,'that the procedure may not be done by the person who has been treating me or my child so far:',0,'L',FALSE);
 
 $pdf->SetFont('Arial', 'B', 9);	
 $pdf->Cell(40, 6, 'I have been advised:',0, 0, 'L', FALSE);
 $pdf->SetFont('Arial', '', 9);
 $pdf->MultiCell(150,6,'of additional procedures which may become necessary. I have listed below those which I do not wish to be carried out without further consultation and consent.
',0,'L',FALSE);
 
  $pdf->MultiCell(185,6,'_____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________',0,'C',FALSE);

    $pdf->SetFont('Arial', 'B', 9);
 $pdf->MultiCell(185,5,"To be completed by the patient (children who are unable to give a valid consent may still be invited to sign here to show they agree with their parent's decision)",0);
 $pdf->SetFont('Arial', '', 9);
  $pdf->MultiCell(185,5,'Name:_______________________      Signature:_____________________      Date:_________________',0);
  	
    $pdf->SetFont('Arial', 'B', 9);
 $pdf->MultiCell(185,5,'To be completed by person with parental responsibility if the patient is a child unable to give a valid consent (or if a competent child wishes their parent to sign as well)',0);
 $pdf->SetFont('Arial', '', 9);
$pdf->Cell('', 6, 'Name:_______________________', 0, 0, 'L', FALSE);
$pdf->Cell('', 6, 'Relationship to Child:________________________', 0, 1, 'R', FALSE); 
 
$pdf->Cell('', 6, 'Signature:________________________', 0, 0, 'L', FALSE);
 $pdf->Cell('', 6, 'Date:_________________________', 0, 1, 'R', FALSE);
  
//HEADER
$billTotal = 0;
$linespacing = 2;
$majorSpacing = 7;
$pageH = 4;
$width = 30;

// Rounded rectangle 
/*
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10, 10', 'color' => array(0, 255, 0));
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));

$pdf->RoundedRect(10, 248, 190,31, '', '1000');

$pdf->RoundedRect(10, 95, 190,145, '', '1000');

$pdf->RoundedRect(10, 28, 190,62, '', '1000');*/

$pdf->Output();
$_SESSION['personnel_name'] = NULL;

?>