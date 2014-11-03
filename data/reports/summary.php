<?php
session_start();
include '../../classes/Reports.php';

$temp_jj="";
$total_jj=""; 
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
		}	}
	
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
	
	$get = new reports;
	$rs = $get->get_all_report();
	$num_rows = mysql_num_rows($rs);
}

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

?><html>
<head>
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
	<title>Summary</title>
    
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">General Summary</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    	<h3 class="page_title"> General Summary Report  </h3>
    		<form action="summary.php" method="get" name="reports">
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
 						<td><a href="../pdfs/summary.php?date1=<?php echo $date1?>&date2=<?php echo $date2?>&type=<?php echo $type?>" class="btn btn-success">Print</a> <td>
					</tr>
				</table>
   
    		</form>
    
            <table class="table table-striped table-condensed table-hover table-bordered">
                <tr>
                    <th> <?php echo 'Type'; ?></th> 
					
					<?php
                    $gets = new reports;
                    $rss = $gets->services();
                    $num_rowss = mysql_num_rows($rss);	
                    
                    for($s1=0; $s1<$num_rowss; $s1++){
                    
						$service_name=mysql_result($rss,$s1, "service_name");
						$service_id=mysql_result($rss,$s1, "service_id");
						$service_total[$service_id] = 0;
						?>
						<th> <?php echo  $service_name;?></th>     
						<?php
                    }
                    ?>
                    <th>Total</th>
				</tr>
				<?php

				for($r = 0; $r < $num_visit_type; $r++){
	
					$visit_type_name = mysql_result($rs_visit_type, $r, "visit_type_name");
					$visit_type_id = mysql_result($rs_visit_type, $r, "visit_type_id");
					?>
                    <tr>
                    	<th> <?php echo $visit_type_name; ?></th> 
					
					<?php
					
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
						?>
                        	<td><?php echo $total_cost;?></td>
                        <?php
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
							?>
								<td><?php echo $grand_total;?></td>
                            <tr>
							<?php
							$count = 0;
							$grand_total = 0;
						}
					}
				}
				?>
					<th>Total</th>
				<?php
				$totals = 0;
				
				for($s1=0; $s1<$num_rowss; $s1++){
					
					$service_id=mysql_result($rss,$s1, "service_id");
					?>
						<th><?php echo $service_total[$service_id];?></th>
					<?php
					$totals += $service_total[$service_id];
				}
				?>
                    <th><?php echo $totals;?></th>
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