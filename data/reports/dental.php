<?php
session_start();
include '../../classes/Reports.php';
//$summary=$_GET['summary'];

if(isset($_GET['submit'])) {

	$date1=$_GET['date'];	
	$date2=$_GET['finishdate'];
	$type=$_GET['type'];
	
	if($type == "all"){
		$type = "";
		$date1 = "";
		$date2 = "";
		
		$get = new reports;
		$rs = $get->get_all_report();
		$num_rows = mysql_num_rows($rs);
	}
	
	else{
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
		else {
		
			$get = new reports;
			$rs = $get-> get_single_multiple_report($date1,$date2,$type);
			$num_rows = mysql_num_rows($rs);		
		}
	}
}
else{
	$type = "";
	$date1 = "";
	$date2 = "";
	
	$get = new reports;
	$rs = $get->get_all_report();
	$num_rows = mysql_num_rows($rs);
}
?><html>
<head>
	<title>Accounting</title>
	<link type="text/css" rel="stylesheet" href="../../css/bootstrap.css" />
 	<link type="text/css" rel="stylesheet" href="../../css/jquery-ui-1.8.18.custom.css" />
    <link type="text/css" rel="stylesheet" href="../../css/jquery.ui.timepicker.css"/>
	<link rel="stylesheet" href="../../css/head.css" type="text/css" media="screen" />
    <script type="text/javascript" src="../../js/script.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.timepicker.js"></script>
	<script type="text/javascript" charset="utf-8">

	$(function(){
				
				//date picker
				$( "#datepicker" ).datepicker();
				$( "#format" ).change(function() {
					$( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
				});
				
				$('#timepicker').timepicker();
			});
  $(document).ready(function() {
                $('#timepicker_start').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpStartOnHourShowCallback,
                    onMinuteShow: tpStartOnMinuteShowCallback
                });
                $('#timepicker_end').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpEndOnHourShowCallback,
                    onMinuteShow: tpEndOnMinuteShowCallback
                });
            });

            function tpStartOnHourShowCallback(hour) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                // all valid if no end time selected
                if ($('#timepicker_end').val() == '') { return true; }
                // Check if proposed hour is prior or equal to selected end time hour
                if (hour <= tpEndHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpStartOnMinuteShowCallback(hour, minute) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
                // all valid if no end time selected
                if ($('#timepicker_end').val() == '') { return true; }
                // Check if proposed hour is prior to selected end time hour
                if (hour < tpEndHour) { return true; }
                // Check if proposed hour is equal to selected end time hour and minutes is prior
                if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }

            function tpEndOnHourShowCallback(hour) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                // all valid if no start time selected
                if ($('#timepicker_start').val() == '') { return true; }
                // Check if proposed hour is after or equal to selected start time hour
                if (hour >= tpStartHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpEndOnMinuteShowCallback(hour, minute) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
                // all valid if no start time selected
                if ($('#timepicker_start').val() == '') { return true; }
                // Check if proposed hour is after selected start time hour
                if (hour > tpStartHour) { return true; }
                // Check if proposed hour is equal to selected start time hour and minutes is after
                if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
			}
		function closeit(val){
    		window.opener.document.forms['myform'].elements['passed_value'].value=val;
    		window.close(this);
		}
		function closeit(val){
    		window.opener.document.forms['myform'].elements['passed_value'].value=val;
    		window.close(this);
		}
        </script>
    
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">Accounting Summary</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    
    	<h3 class="page_title"> Accounting Summary Report  </h3>
    		<form action="dental.php" method="get" name="reports">
    			<table class="table table-striped">
    				<tr>
						<tH>FILTER BY: </tH>
 						<td>
                        	<select id="type" name="type" onChange="check_selection('type','insurance');">
    							<option value="all">All</option>  
								<?php
                                $getc =  new reports;
                                $rsc = $getc->get_visit_type();
                                $rowsc = mysql_num_rows($rsc);//echo "rows = ".$rows; 
                                for ($c=0; $c <$rowsc; $c++){	
                                    
                                $visit_type_name = mysql_result($rsc, $c, "visit_type_name");
                                $visit_type_id = mysql_result($rsc, $c, "visit_type_id");
                                ?>
                                <option value="<?php echo $visit_type_id;?>"> <?php echo $visit_type_name; ?></option>
                                <?php	
                                
                                }
                                ?>
							</select>
                            <div id="insurance" style="display:none;">
                                <select id="type1" name="type1" >
                                    <option value="">All</option>  
                                
										<?php

										$getd =  new reports;
										$rsd = $getd->get_insurances();
										$rowsd = mysql_num_rows($rsd);//echo "rows = ".$rows; 
                                        
                                        for ($d=0; $d < $rowsd; $d++){	
                                                    
											$company_insurance_id= mysql_result($rsd, $d, "company_insurance_id");
											$company_insurance_name= mysql_result($rsd, $d, "insurance_company_name");
                                                
											?>
											<option value="<?php echo $company_insurance_id;?>"> 
												<?php echo $company_insurance_name; ?>
											</option>  
											<?php  
                                		}
                                		?>
                                </select> 
                            </div>
						</td>
    					<td>Start Date:	<input type="text" id="datepicker" name="date"  autocomplete="off"/></td>
						<td>Finish Date:<input type="text" id="datepicker1" name="finishdate"  autocomplete="off" /></td>
 						<td><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Filter"/> <td>
 						<td><a href="../pdfs/dental.php?date1=<?php echo $date1?>&date2=<?php echo $date2?>&type=<?php echo $type?>" class="btn btn-success">Print</a> <td>
					</tr>
				</table>
   
    		</form>
    
            <table class="table table-striped table-condensed table-hover table-bordered">
                <tr>
                  	<th > <?php echo 'Type'; ?></th> 
                   	<th > <?php echo 'Name'; ?></th> 
                    <th > <?php echo 'Number'; ?></th> 
                    <th > <?php echo 'Insurance'; ?></th> 
                 	<th > <?php echo 'Date'; ?></th> 
<?php
                    $gets = new reports;
                    $rss = $gets->services_7_9(9,1);
                    $num_rowss = mysql_num_rows($rss);	
                     
                    for($s1=0; $s1<$num_rowss; $s1++){
						$service_id=mysql_result($rss,$s1, "service_id");
						$total_charges[$service_id] = 0;
					}
					$grand_total = 0;
					
                    for($s1=0; $s1<$num_rowss; $s1++){
                        //echo $s1;
						$service_name=mysql_result($rss,$s1, "abr");
						$service_id=mysql_result($rss,$s1, "service_id");
						?>
						<th ><?php echo  $service_name;?></th>     
                        <?php
                    }
                    ?>
   <th > <?php echo 'Total'; ?></th> 
    </tr>
<?php

for($a=0; $a<$num_rows; $a++){

	$patient_id=mysql_result($rs,$a, "patient_id");
	$visit_type=mysql_result($rs,$a, "visit_type");
	$visit_id=mysql_result($rs,$a, "visit_id");
	$visit_date=mysql_result($rs,$a, "visit_date");
	$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
	//$patient_insurance_number=mysql_result($rs,$a,"patient_insurance_number");
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
			$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !=0";
			//echo PP.$sqlq;
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

		$name = mysql_result($rs_pataient, 0, "patient_othernames");
		$secondname = mysql_result($rs_pataient, 0, "patient_surname");
		$patient_dob = mysql_result($rs_pataient, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs_pataient, 0, "gender_id");
	}

	?><tr><td><?php 
	if($dependant_id==0){
		echo $visit_name; 
	}
	else {
		echo $visit_name.'<strong>  DPND  </strong>';
	}
	?> </td><td><?php echo $name.'		'.$secondname;?></td> <td><?php 
	if($dependant_id==0){
	
		if(!empty($strath_no)){
			echo $strath_no;
		}
		else{
			if(empty($patient_insurance_number)){
				$patient_insurance_number = "-";
			}
			echo $patient_insurance_number ; 
		}
	}
	else {
		echo $dependant_id; '<br>';
	}
	?></td><td><?php 
	if($visit_name=="Insurance"){
		
		if($patient_insurance_id > 0){
			$getv = new reports;
			$rsv = $getv->get_patient_insurance($patient_insurance_id);
			$num_rowsv = mysql_num_rows($rsv);
			
			if($num_rowsv > 0){
				$patient_insurance_name=mysql_result($rsv,0,"insurance_company_name");
			}
			else{
				$patient_insurance_name = "";
			}
		}
		else{
			$patient_insurance_name = "";
		}
	}
		
	else{
		$patient_insurance_name = "-";
	}
	echo $patient_insurance_name;
	?> </td> <td><?php echo $visit_date;?></td><?php
	$get1 = new reports;
	$rs1 = $get1-> visit_charge_items($visit_id);
	$num_rows1 = mysql_num_rows($rs1);
	
	$get3 = new reports;
	$rs3 = $get3-> services();
	$num_rows3 = mysql_num_rows($rs3);

	$temp_inv="";
	$total_inv=""; 
	
	for($c=0; $c<$num_rows3; $c++){
		$service_id1=mysql_result($rs3,$c, 'service_id');
		$temp="";
		$total=""; 
			if(($service_id1==1)||($service_id1==9)){
		?><td><?php
		
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
			
							if($percentage==0){
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
					$sum; 
					$total=$sum+$temp;  
					$temp=$total;	
				}
			}
	
			else {
			
			}
		}
	
		if(empty($total)){
			$total = 0;
		}
		echo $total;
		$total_inv=$total+$temp_inv; 
		$temp_inv=$total_inv;

		?> </td><?php
 	}} 
	?> <td> <?php echo $total_inv.'<br>';  ?></td><?php 
}
}
?>	
</tr>
<tr> 
	<td > <?php echo '<strong>TOTAL</strong>'; ?></td> 
    <td ></td>  
    <td ></td>  
    <td > </td>   
    <td > </td> 
 	<?php
	$gets = new reports;
	$rss = $gets->services_7_9(9,1);
	$num_rowss = mysql_num_rows($rss);	
	$temp_inv1="";$total_inv1=""; 
	for($s1=0; $s1<$num_rowss; $s1++){

		$service_name=mysql_result($rss,$s1, "service_name");
		$service_id_e=mysql_result($rss,$s1, "service_id");
		
		?><td> <?php

		$temp1="";$total1="";
		$temp="";$total="";	
		for($a=0; $a<$num_rows; $a++){

			$patient_id=mysql_result($rs,$a, "patient_id");
			$visit_type=mysql_result($rs,$a, "visit_type");
			$visit_id=mysql_result($rs,$a, "visit_id");
			$visit_date=mysql_result($rs,$a, "visit_date");
			$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
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
				
				$get3 = new reports;
				$rs3 = $get3-> services();
				$num_rows3 = mysql_num_rows($rs3);

				for($c=0; $c<$num_rows3; $c++){
				$service_id1=mysql_result($rs3,$c, 'service_id');
				
				$y="";
				
					for($b=0; $b<$num_rows1; $b++){
						$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
						$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
						$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
						$visit_id1=mysql_result($rs1,$b, 'visit_id');
						$service_id=mysql_result($rs1,$b, 'service_id');
						$y++;
						
						if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 

							$sum1=($visit_charge_amount*$visit_charge_units);
						
							$total1=$sum1+$temp1;  $temp1=$total1;
							 
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
							
							else {
								
							}
						}
					}
					
				}
			}
	}		 
				$total_inv1=$total+$temp_inv1;  
				$temp_inv1=$total_inv1;
		echo '<strong>'.$total.'</strong>'; ?>
  		</td><?php 

}
	?> <td> <?php echo '<strong>'.$total_inv1.'</strong>';  ?></td></tr>
</table>
 </div>
  </div>
  </div>
  </div>
<!-- end wrapper -->
				<div id="footer">
					<p>Copyright &copy; 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">james brian studio</a>.</p>
				</div>
  </body>
</html>
 <script type="text/javascript" charset="utf-8">
	$(function(){
				$('#datepicker').datepicker({
					inline: true
				});
				
	});
	$(function(){
	$('#datepicker1').datepicker({
					inline: true
				});
	});
 </script>