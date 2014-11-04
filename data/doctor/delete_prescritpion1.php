<?php session_start();
include '../../classes/class_prescription.php';
 
  $id=$_GET['prescription_id'];
  $visit_id=$_GET['visit_id'];
  $visit_charge_id=$_GET['visit_charge_id'];
  
		$get = new prescription;
		$visit_charge_id = $get->get_visit_charge_id1($id);
		
	$get3 = new prescription;
	$rs3 = $get3->delete_visit_charge($visit_charge_id);
	
	$prescription = new prescription();
$rs = $prescription->check_deleted_visitcharge($visit_charge_id );
$num_rows =mysql_num_rows($rs);

		//echo BB.$visit_charge_id;
		if($num_rows==0){
	$get2 = new prescription;
	$rs3 = $get2-> delete_prescription($id);
	
	?>
	<script>
	window.location.href = "http://sagana/hms/index.php/pharmacy/prescription1/<?php echo  $visit_id?>";
	</script>
    <?php
	
		}
	

	