<?php
include("../../classes/class_doctor.php");

//echo $id;http://sagana/hms/data/doctor/save_prescript.php?id=293&date4=0000-00-00&datepicker3=30&quantity=2&units_given=99
$id=$_GET['id'];
$visit_charge_units=$_GET['date4'];
$datepicker3=$_GET['datepicker3'];
$quantity=$_GET['quantity'];
$units_given=$_GET['units_given'];
/*
echo $date4;
echo $date4;
echo $datepicker3;
echo $quantity;
echo $units_given;*/

$get= new doctor;
$rs=$get->select_scid($id);
$num_rows=mysql_num_rows($rs);
$service_charge_id= mysql_result($rs,0,'service_charge_id');
$visit_id= mysql_result($rs,0,'visit_charge_id');

$save= new doctor;
$save->save_visit_charge($service_charge_id,$visit_id,$units_given);

/*$update= new doctor;
$update->update_prescription($id,$service_charge_id,$prescription_substitution,$comment,$prescription_startdate,$prescription_finishdate,$drug_times_id,$prescription_date,$drug_duration_id,$quantity,$drug_consumption_id,$units_given);*/

//header('http://sagana/hms/index.php/pharmacy/prescription1/$visit_id')
?>
<script>
window.location.href="http://sagana/hms/index.php/pharmacy/prescription1/<?php echo $visit_id?>"
</script>
<?php
