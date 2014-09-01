<?
#### Roshan's Ajax dropdown code with php
#### Copyright reserved to Roshan Bhattarai - nepaliboy007@yahoo.com
#### if you have any problem contact me at http://roshanbh.com.np
#### fell free to visit my blog http://php-ajax-guru.blogspot.com
?>

<?php $patient_type=$_REQUEST['patient_type'];
$link = mysql_connect('localhost', 'sumc_hms', 'Oreo2014#'); //changet the configuration in required
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('sumc');
$querys="SELECT * FROM `service_charge` where visit_type_id=$patient_type and service_id=1";
$results=mysql_query($querys);
if($results==""){
	
	}else {
$rows=mysql_num_rows($results);
	}
?>
<select name="service_charge_name">
<?php if($rows=="") {?>
<option value='0'>Loading...</option>
<?php } else { ?>
<option value='0'>Select Consultaion Charge </option>
<?php } ?>
<?php for($j=0; $j<$rows; $j++) { ?>
<option value="<?php echo  mysql_result($results, $j, "service_charge_id"); ?>"><?php echo  mysql_result($results, $j, "service_charge_name");?></option>
<?php } ?>
</select>
