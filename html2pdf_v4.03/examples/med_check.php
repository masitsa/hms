<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
 
include '../../classes/acconts.php';
 $p_id=$_GET['pid'];

$vid = $_GET['pid'];

		
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
	function get_family_history($visit_id){
		$sql="SELECT family_disease.family_disease_name, family.family_relationship FROM `family_disease` , `family_history_disease` , family
WHERE patient_id = (SELECT patient_id FROM visit WHERE visit_id =$visit_id ) AND family_disease.family_disease_id = family_history_disease.disease_id
AND family.family_id = family_history_disease.family_id";

			$get = new Database();
		return $get->select($sql);
		
		}
	function get_lab_visit2($visit_id){
		
		$sql = "SELECT lab_visit FROM visit WHERE visit_id = $visit_id";
		
		$get = new Database();
		return $get->select($sql);
	}
		function get_lab_checkup($visit_id){
			$sql = "SELECT service.service_name, service.service_id,service_charge.service_charge_name,visit_charge.visit_charge_amount, visit_charge.visit_charge_units
			
			FROM visit_charge, service, service_charge
			
			WHERE visit_charge.visit_id = $visit_id
			AND visit_charge.service_charge_id = service_charge.service_charge_id
			AND service_charge.service_id = service.service_id
			AND service.service_id=5";
		
		$get = new Database();
		$rs = $get->select($sql);
		
		return $rs;
	}
	
	
	}
	$get = new accounts;
	$rs = $get->get_patient2($vid);
	$strath_no = mysql_result($rs, 0, "strath_no");
	$strath_type = mysql_result($rs, 0, "visit_type_id");
		$personnel_idx = mysql_result($rs, 0,  	"personnel_id");
	$patient_number = mysql_result($rs, 0, "patient_number");
	$patient_insurance_id = mysql_result($rs, 0, "patient_insurance_id");
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
		$connect = mysql_connect("localhost", "root", "")
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
			$name = mysql_result($rs2, 0, "names");
	//	$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
		else{
		$get2 = new accounts;
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


    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/res/med_check.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 10);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('med_check'.$name.'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
