<?php
session_start();
include '../../classes/Reports.php';

$type="";
$payment_method="";
if(isset($_GET['submit'])) {

$date1=$_GET['date'];	
$date2=$_GET['finishdate'];
$type=$_GET['type'];
if($type == "all"){
	
		/*$type = "";
		$date1 = "";
		$date2 = "";
		
		$get = new reports;
		$rs = $get->get_all_report();
		$num_rows = mysql_num_rows($rs);*/
		
		if($date2==""){
		
	$get = new reports;
$rs = $get->cash_single_day_report($date1,$type);
$num_rows = mysql_num_rows($rs);

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);
		}
		elseif($date1==""){
		
	$get = new reports;
$rs = $get->cash_single_day_report($date2,$type);
$num_rows = mysql_num_rows($rs);

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);	
		}	
		else {
		
		$get = new reports;
$rs = $get-> cash_single_multiple_report($date1,$date2,$type);
$num_rows = mysql_num_rows($rs);	

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);		
		}	}
	
	else{

if($date2==""){

	$get = new reports;
$rs = $get->cash_single_day_report($date1,$type);
$num_rows = mysql_num_rows($rs);

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);
}
elseif($date1==""){

$get = new reports;
$rs = $get->cash_single_day_report($date2,$type);
$num_rows = mysql_num_rows($rs);

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);	
}	
else {

$get = new reports;
$rs = $get-> cash_single_multiple_report($date1,$date2,$type);
$num_rows = mysql_num_rows($rs);	

$get1 = new reports;
$rs_voucher = $get1->cash_expenses_report($date1,$date2);
$num_rows_voucher = mysql_num_rows($rs_voucher);	
}}}
else {
	$type = "";
	$date1 = "";
	$date2 = "";

$get = new reports;
$rs = $get->cash_single_report();
$num_rows = mysql_num_rows($rs);	
}

$get_payment= new reports;
$rs_payment=$get_payment->cash_payment();
$num_rows_payment=mysql_num_rows($rs_payment);
?><html>
<head>
	
	<title>Cash</title>
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
        </script>
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">Cash</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    
    	<h3 class="page_title"> Cash Report  </h3>
    		<form action="cash_reports.php" method="get" name="reports">
    			<table class="table table-striped">
    				<tr>
						<tH>FILTER BY: </tH>
 						<td>
                        	<select id="type" name="type" onChange="check_selection('type','insurance');">
    							<option value="all">All</option>  
								<?php
                                $getc =  new reports;
                                $rsc = $getc->cash_payment();
                                $rowsc = mysql_num_rows($rsc);//echo "rows = ".$rows; 
                                for ($c=0; $c <$rowsc; $c++){	
                                    
                                $payment_method = mysql_result($rsc, $c, "payment_method");
                                $payment_method_id = mysql_result($rsc, $c, "payment_method_id");
                                ?>
                                <option value="<?php echo $payment_method_id;?>"> <?php echo $payment_method; ?></option>
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
                        <td><a href="../pdfs/cash_reports.php?date1=<?php echo $date1?>&date2=<?php echo $date2?>&type=<?php echo $type?>" class="btn btn-success">Print</a> <td>
					</tr>
				</table>
   
    		</form>
            <table class="table table-striped table-condensed table-hover table-bordered">
 				<tr>
                  	<th > <?php echo 'Payment Type'; ?></th> 
                   	<th > <?php echo 'Patient'; ?></th>  
   					<th > <?php echo 'Visit Date'; ?></th> 
   					<th > <?php echo 'Patient Type'; ?></th>  
                    <th > <?php echo 'Number'; ?></th> 
                 	<th > <?php echo 'Payment Date'; ?></th> 
    				<th > <?php echo 'Amount'; ?></th> 
   				</tr>
 				<tr>
<?php
$temp="";
$total=0;	
if($num_rows==0){
$get1 = new reports;
$rs1 = $get1->cash_payment_type($type);
$num_rows1 = mysql_num_rows($rs1);
$payment_method=mysql_result($rs1,0,"payment_method");
?>
<tr  > No Search  Result  For <?php echo $payment_method;?>  </tr>
<?php	
}
for($a=0; $a<$num_rows; $a++){

$amount_paid1 =mysql_result($rs,$a, "amount_paid");
$visit_id=mysql_result($rs,$a, "visit_id");
$time=mysql_result($rs,$a, "time");
$payment_method_id=mysql_result($rs,$a,"payment_method_id");

$get_patient_id= new reports;
$rs_pataient_id= $get_patient_id->get_patient_id($visit_id);
$patient_id=mysql_result($rs_pataient_id,0,'patient_id');
$visit_type=mysql_result($rs_pataient_id,0,'visit_type');
$visit_date=mysql_result($rs_pataient_id,0,'visit_date');
$patient_insurance_number = mysql_result($rs_pataient_id, 0, "patient_insurance_number");

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
		$get2 =  new reports;
							$rs2 = $get2->get_patient_3($strath_no);
							//echo $strath_no;	
							$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
										or die("Unable to connect to MySQL".mysql_error());

							//selecting a database
							mysql_select_db("sumc", $connect)
										or die("Could not select database".mysql_error()); 
							$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id !='0'";
							//echo $sqlq;
							$rsq = mysql_query($sqlq)
							or die ("unable to Select ".mysql_error());
							$num_rowsp=mysql_num_rows($rsq);
							
							//echo NUMP.$num_rowsp;
							if(($num_rowsp > 0)){
								$get2 =  new reports;
								$rs2 = $get2->get_patient_4($strath_no);
								$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
								
								$name = mysql_result($rs2, 0, "names");
								$secondname = '';
								$patient_dob = mysql_result($rs2, 0, "DOB");
								$patient_sex = mysql_result($rs2, 0, "Gender");
							}
							
							else{
						$get2 =  new reports;
								$rs2 = $get2->get_patient_3($strath_no);
								$rows = mysql_num_rows($rs2);
								//echo "rows = ".$rows;
								//echo $rows;	
								$name = mysql_result($rs2, 0, "Surname");
								$secondname = mysql_result($rs2, 0, "Other_names");
								$patient_dob = mysql_result($rs2, 0, "DOB");
								$patient_sex = mysql_result($rs2, 0, "gender");
							}
	}
	
	else{

		$name = mysql_result($rs_pataient, 0, "patient_othernames");
		$secondname = mysql_result($rs_pataient, 0, "patient_surname");
		$patient_dob = mysql_result($rs_pataient, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs_pataient, 0, "gender_id");
	}
	
	


	$get1 = new reports;
$rs1 = $get1->cash_payment_type($payment_method_id);
$num_rows1 = mysql_num_rows($rs1);
$payment_method=mysql_result($rs1,0,"payment_method");

$amount_paid=number_format($amount_paid1, 2, '.', ',');



?>
<tr  >
  <td > <?php echo $payment_method; ?></td> 
<td><?php echo $name.'		'.$secondname;?></td>
<td><?php echo $visit_date;?></td>
<td><?php if($dependant_id==0){
	echo $visit_name; }
	 else {
	echo $visit_name.'<strong>  DPND  </strong>';
		 }
		  ?> </td>
    <td><?php  
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
							}?></td>
 <td > <?php echo $time; ?></td> 
  <td > <?php echo $amount_paid ; ?></td> 
   
    </tr>
<?php
 $total=$amount_paid1+$temp;  $temp=$total;	
}

?>
<tr>
<td> <strong> TOTAL CASH</strong></td>
<td> <strong> </strong></td>
<td> <strong> </strong></td>
<td> <strong> </strong></td>
<td> <strong> </strong></td>
<td> <strong> </strong></td>
<td> <strong> <?php  echo number_format($total, 2, '.', ',');?></strong></td>
</tr>
</table>

 </div>
  </div>
  </div>
  </div>
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