<style>
.navbar-inner{
	padding:10px; 
	border-bottom:#000000; 
	border-bottom:thin; 
	/*font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;*/
	font-size:15px;">
	}
	
</style>

<?php session_start();
$personnel_id=$_SESSION['personel_id'];
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
?>
<page backtop="5mm" backbottom="7mm" backleft="10mm" backright="10mm"> 


 <div style=" text-align:center; font-size:18px;"><?php echo $name2; ?></div>
 <div style="text-align:; font-size:18px;"><img src="./res/strathmore.gif" width="" height="" alt=""  > 
</div>
<div style="text-align:right; font-size:10px;"> <?php echo date('d/m/Y - H:m:s') ?> </div> <hr>
<?php 	$mec_result="";
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
	?>
<div class="navbar-inner" ><p style="text-align:left; color:#0e0efe;">Family History</p></div>
 <div align="left" style="text-align:left;">      
    <?php						     
	$getf = new checkup;
	$rsf = $getf-> get_family_history($p_id);
	$rowsf = mysql_num_rows($rsf);
	//echo 'RSF'.$rowsf;
	for($f=0; $f < $rowsf; $f++){
	$family_disease_name= mysql_result($rsf, $f, 'family_disease_name');
	$family_relationship= mysql_result($rsf, $f, 'family_relationship');
	//$mec_id= mysql_result($rs2, $a, 'mec_id');	
			echo $family_relationship.' - -  '.$family_disease_name.'<br/>';
		//$pdf->Cell(0,5,,0,1,'C', $fill);
		}
		?>
        </div>
        <?php
		}
			else if(($mec_name=="Present Illness")||($mec_name=="Past Illness")) {	?>
                            
  <div class="navbar-inner"><p style="text-align:left; color:#0e0efe; "><?php echo $mec_name?></p></div>
					
  <div align="left" style="text-align:left;"> <?php echo $mec_result; ?></div>
<?php }
							else if(($mec_name=="Physiological History")||($mec_name=="General Physical Examination")||($mec_name=="Head Physical Examination")||($mec_name=="Neck Physical Examination")||($mec_name=="Cardiovascular System Physical Examination")||($mec_name=="Respiratory System Physical Examination")||($mec_name=="Abdomen Physical Examination")||($mec_name=="Nervous System Physical Examination")) {	?>
  <div class="navbar-inner"><p style="text-align:left; color:#0e0efe;"> <?php echo $mec_name ?></p> </div>
  <table width="325" height="69" style="text-align:left;"> 
  
			<?php		
					
  					$get4 = new checkup;
					$rs4 = $get4->mec_med($mec_id);
					$rows4 = mysql_num_rows($rs4);
					$ab=0;
					for($a4=0; $a4 < $rows4; $a4++){
						$item_format_id=mysql_result($rs4, $a4, 'item_format_id');
						$ab++;
						
					 $get6 = new checkup;
					$rs6 = $get6-> cat_items($item_format_id, $mec_id);
					$rows6 = mysql_num_rows($rs6);
						for($a6=0; $a6< $rows6; $a6++){
						$cat_item_name=mysql_result($rs6, $a6, 'cat_item_name');
						$cat_items_id1 =mysql_result($rs6, $a6, 'cat_items_id');
						
						?><tr> <td width="110" ><?php echo $cat_item_name; ?> </td>
                      <?php  
                        $get7 = new checkup;
					$rs7 = $get7-> get_cat_items($item_format_id, $mec_id);
					$rows7 = mysql_num_rows($rs7); 
					for($a7=0; $a7< $rows7; $a7++){
						$cat_item_name=mysql_result($rs7, $a7, 'cat_item_name');
						$cat_items_id =mysql_result($rs7, $a7, 'cat_items_id');
						$item_format_id1 =mysql_result($rs7, $a7, 'item_format_id');
						$format_name =mysql_result($rs7, $a7, 'format_name');
						$format_id =mysql_result($rs7, $a7, 'format_id');
						
						if($cat_items_id==$cat_items_id1)
						{
							if($item_format_id1== $item_format_id){
						   $get8 = new checkup;
					$rs8 = $get8-> cat_items2($cat_items_id,$format_id,$p_id);
					//echo $rows8;
					$rows8 = mysql_num_rows($rs8);
					if  ($rows8>0){	?>
                            <td width="99"> <?php echo '<strong>'.$format_name.'</strong>'; ?>  <br>
                            <img src="./res/checked_checkbox.gif" width="" height="" alt="" > 
                            </td>
                            <?php } else { ?>
                            <td width="100"> <?php echo '<strong>'.$format_name.'</strong>'; ?>  <br>
        <img src="./res/unchecked_checkbox.gif" width="" height="" alt="" >                   
                            </td>
							<?php	}
												
							}}}?></tr><?php } } ?>
            </table>   <?php } }?> 
<div class="navbar-inner" ><p style="text-align:left; color:#0e0efe;">Lab Tests Done </p></div>
      <div align="left">  <?php 
	$getd = new checkup;
	$rsd = $getd->  get_lab_checkup($p_id);
	$rowsd = mysql_num_rows($rsd);
	
	for($d=0; $d < $rowsd; $d++){
	$service_charge_name= mysql_result($rsd, $d, 'service_charge_name');
		echo '--'.$service_charge_name.'<br/>';
		
		} ?></div>
  <?php  
	  			$get21 = new checkup;
				$rs21 = $get21-> get_illness($p_id,"Further");
					$rows1 = mysql_fetch_array($rs21);
					$mec_result= $rows1['infor'];
	  ?>
      <div class="navbar-inner" ><p style="text-align:left; color:#0e0efe;">Further Details</p></div><br>
      <div align="left">  <?php echo $mec_result; ?></div>
      <div class="navbar-inner"><p style="text-align:left; color:#0e0efe;">Conclusions</p></div> 
      <p style="text-align:left;">
         <?php  
	  				$get21 = new checkup;
					$rs21 = $get21-> get_illness($p_id,"Medically");
					$rows1 = mysql_fetch_array($rs21);
					$mec_result= $rows1['infor'];
		?> Medically Fit : 
		<?php if($mec_result=='no'){
		 ?>
         NO:     <img src="./res/checked_checkbox.gif" width="" height="" alt="" >

        <?php }
		 else {
		 ?>
         NO:                            <img src="./res/unchecked_checkbox.gif" width="" height="" alt="" >

         <?php			 
			 }
			 
		if($mec_result=='yes'){
		 ?>
         YES:                            <img src="./res/checked_checkbox.gif" width="" height="" alt="" >
  
         <?php }
		 else {
		 ?>
         YES:                            <img src="./res/unchecked_checkbox.gif" width="" height="" alt="" >

         <?php			 
			 }
	  				$get21 = new checkup;
					$rs21 = $get21-> get_illness($p_id,"conclusion");
					$rows1 = mysql_fetch_array($rs21);
					$mec_result= $rows1['infor'];
?></p>
      <div align="left">  <?php echo $mec_result; ?></div>
      <page_footer>
		<table class="page_footer">
			<tr>
				<td style="text-align: right">
					page [[page_cu]]/[[page_nb]]
				</td>
			</tr>
		</table>
	</page_footer>
   </page>