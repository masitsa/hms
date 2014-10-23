<?php
session_start();
$year= date('Y');
?>
  <a href="../xls/patients.php"> Excel Export</a>
<h3> Patients Reports <?php echo $year; ?></h3>
 <table>   <tr>
 <td width="90"> </td>
    <?php
for($i=2; $i<=13; $i++)  {
	
?> <td  align="right"> <?php

    echo  date("F", mktime(0, 0, 0, $i+11, 10));

?> </td> <?php
}
?>
</tr>
   <tr>
 <td width="70"  align="right">Actual<?php echo "\r\n"; ?> </td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td  align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
	$get = new reports;
	$rs = $get->sum_patients($date);
	$num_rows = mysql_num_rows($rs);
	$count=mysql_result($rs,0,"COUNT(visit_id)");
    echo  $count;

?> </td> <?php
}
?>
</tr>
   <tr>
 <td width="70"  align="right">Target <?php echo "\r\n"; ?></td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td  align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,1);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");
   echo $target_amount;

?> </td> <?php
}
?>
</tr>
   <tr>
 <td align="right">Variance <?php echo "\r\n"; ?></td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td width="70"  align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,1);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");
  
   
   $get = new reports;
	$rs = $get->sum_patients($date);
	$num_rows = mysql_num_rows($rs);
	$count=mysql_result($rs,0,"COUNT(visit_id)");
   
    echo  $count-$target_amount."\r\n";

?> </td> <?php
}
?>
</tr>
   <tr>
 <td  align="right">Variance (%)<?php echo "\r\n"; ?></td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td  align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
	$get_target = new reports;
	$rs_target = $get_target->get_setTarget($date,1);
	$num_rows_target = mysql_num_rows($rs_target);
$target_amount=mysql_result($rs_target,0,"target_amount");
  
   
   $get = new reports;
	$rs = $get->sum_patients($date);
	$num_rows = mysql_num_rows($rs);
	$count=mysql_result($rs,0,"COUNT(visit_id)");
   
    echo round((($count-$target_amount)/($target_amount)) * (100), 2);
?> </td> <?php
}

?>
</tr>
 <tr>
 <td width="120"  align="right">Avg. no of patients per day<?php echo "\r\n"; ?> </td>
    <?php
for($j=0; $j<=11; $j++)  {
	
?>	
 <td  align="right"> <?php
 $x=$j+1;
 if ($x<=9){
	 $x='0'.$x;
	 }

	$date=$year.'-'.$x;
	//echo $date;
	$get = new reports;
	$rs = $get->sum_patients($date);
	$num_rows = mysql_num_rows($rs);
	$count=mysql_result($rs,0,"COUNT(visit_id)");
  
$num = cal_days_in_month(CAL_GREGORIAN, $x, $year); // 31
  echo round(($count/$num), 2);

?> </td> <?php
}
?>
</tr>
</table>



