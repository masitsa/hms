<?php 
session_start();


$year= date('Y');

?>

<h3> Revenue Reports <?php echo $year; ?></h3>
 <table border=".5"> 
  <tr>
 <td width="90">REVENUE <br />
 PER DEPARTMENT
 </td>
    <?php
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

    echo  date("F", mktime(0, 0, 0, $i+11, 10));

?> </td> <?php
}
?>
</tr>
  
   <tr> <td>  Consultation <br />
and Nursing</td>
     <?php
	
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_nurse_consult($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo  number_format($total_con);
?> </td> <?php
}
?> 
   </tr> 
   <tr><td>  Pharmacy </td>   <?php

for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_revenue = new reports;
	$rs_revenue = $get_revenue->revenue_($date, 4);
	$num_rows_revenue = mysql_num_rows($rs_revenue);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_revenue; $as++){

$visit_charge_amount = mysql_result($rs_revenue,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_revenue,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_revenue,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_revenue,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_revenue,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_revenue,$as,"visit_id");
$patient_id=mysql_result($rs_revenue,$as,"patient_id");
$service_charge_id=mysql_result($rs_revenue,$as,"service_charge_id");
$service_id=mysql_result($rs_revenue,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo  number_format($total_con);
?> </td> <?php
}
?> </tr> 
   <tr> <td>  Laboratory </td>     <?php

for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_revenue = new reports;
	$rs_revenue = $get_revenue->revenue_($date, 5);
	$num_rows_revenue = mysql_num_rows($rs_revenue);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_revenue; $as++){

$visit_charge_amount = mysql_result($rs_revenue,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_revenue,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_revenue,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_revenue,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_revenue,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_revenue,$as,"visit_id");
$patient_id=mysql_result($rs_revenue,$as,"patient_id");
$service_charge_id=mysql_result($rs_revenue,$as,"service_charge_id");
$service_id=mysql_result($rs_revenue,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo number_format(  $total_con);
?> </td> <?php
}

?></tr> 
   <tr> <td>  Dental </td>      <?php
	
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_dental_consult($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo number_format( $total_con);
?> </td> <?php
}
?></tr> 
  <tr> <td> Ultrasound</td>   <?php
	
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_ultrasound_consult($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}

	echo  number_format( $total_con);
?> </td> <?php
}
?> </tr> 
   <tr> <td> Counselling </td>   <?php
	
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_counsel_consult($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo  number_format( $total_con);
?> </td> <?php
}
?> </tr> 
<tr>
<td> Total Revenue</td>

 <?php
	
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php

   // echo  date("F", mktime(0, 0, 0, $i+11, 10));
		 $x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_clinic($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	echo number_format(  $total_con);
?> </td> <?php
}
?>
</tr>
<tr>
<td> TARGET</td>
<?php
for($i=2; $i<=13; $i++)  {
	
?> <td  width="74"  align="right"> <?php
  // echo  date("F", mktime(0, 0, 0, $i+11, 10));
	$x=$i-1;
 if ($x<=9){
	 $x='0'.$x;
	 }
$date=$year.'-'.$x;
	//echo $date;
	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,2);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");

   echo  $target_amount;

	$date=$year.'-'.$x;
	?></td>
    
    <?php } ?>
    </tr>
     <tr>
<td>Variance <?php echo "\r\n"; ?></td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td width="74"   align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }
	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_clinic($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=""; $total=""; $temp_con=""; $total_con="";
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value="";	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}


	
	
	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,2);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");
$target_amount = str_replace(",", "",$target_amount);

 $var=  $target_amount-$total_con;
 if($var<0){
	 echo '('.$var*(-1).')';
	 }
else {
	echo number_format($var);
	}
?>
</td>
<?php } ?>
</tr>
<tr>
<td>Variance % <?php echo "\r\n"; ?></td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td width="74"   align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }
	$date=$year.'-'.$x;
	//echo $date;
		$get_nurse_consult = new reports;
	$rs_nurse_consult = $get_nurse_consult->revenue_clinic($date);
	$num_rows_nurse_consult = mysql_num_rows($rs_nurse_consult);
	 $temp=0; $total=0; $temp_con=0; $total_con=0;
	for($as=0; $as<$num_rows_nurse_consult; $as++){

$visit_charge_amount = mysql_result($rs_nurse_consult,$as,"visit_charge_amount");
$visit_charge_units  = mysql_result($rs_nurse_consult,$as,"visit_charge_units");
$Visit_type  = mysql_result($rs_nurse_consult,$as,"Visit_type");
$patient_insurance_id = mysql_result($rs_nurse_consult,$as,"patient_insurance_id");
$patient_insurance_number  = mysql_result($rs_nurse_consult,$as,"patient_insurance_number");
$visit_id= mysql_result($rs_nurse_consult,$as,"visit_id");
$patient_id=mysql_result($rs_nurse_consult,$as,"patient_id");
$service_charge_id=mysql_result($rs_nurse_consult,$as,"service_charge_id");
$service_id=mysql_result($rs_nurse_consult,$as,"service_id");

if ($Visit_type ==4)
{
			$sql1= "SELECT * FROM insurance_discounts WHERE insurance_id = (SELECT company_insurance_id FROM 	 `patient_insurance` where patient_insurance_id =$patient_insurance_id) and service_id=$service_id";
							//echo $sql1;
								$rs1 = mysql_query($sql1)
					or die ("unable to Select ".mysql_error());
				$num_type1= mysql_num_rows($rs1);
				
				$percentage = mysql_result($rs1,0, "percentage");
				$amount = mysql_result($rs1, 0, "amount");
				//echo Percent.$percentage .'			'.VCU.$visit_charge_units.'			'.PAT.$patient_id;
				$penn=((100-$percentage)/100);
				//echo 'yyy'.$penn;
				//echo 'PENN'.$penn*$visit_charge_amount;
				$discounted_value=0;	
		if($percentage==0){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount -$discounted_value;			
	
		}
		elseif($amount==0){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100);
			$penn=((100-$discounted_value)/100);
			//echo 'PENN'.$penn*$visit_charge_amount;
		//echo AMTf.$sum.'		'.$discounted_value;
		}
		elseif(($amount==0)&&($percentage==0)){
			
			$sum=$visit_charge_amount;
			
			}
		//echo AMT.$sum .'			'.VCU.$visit_charge_units;
		//$total = $total + ($amount*$visit_charge_units);
		
		$total=($sum*$visit_charge_units);
				
	}
	else {
		$total=$visit_charge_amount*$visit_charge_units;
		} 

$total_con=$total+$temp_con;	$temp_con=$total_con; 
}

	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,2);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");
$target_amount = str_replace(",", "",$target_amount);

 $var=  ((($total_con-$target_amount)/$target_amount)*100);
 
	echo round(number_format($var),2);
	
?>
</td>
<?php } ?>
</tr>
   </table>