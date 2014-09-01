<?php 
include 'connection.php';
session_start();

if($_REQUEST['phamarcy']){
	
	$visit_id = $_SESSION['visit_id'];
	$sql="Update visit set doc_visit='1',pharmarcy = 2 WHERE visit_id ='$visit_id'";
	$save = new Database();
	$save->insert($sql);
			

?>
<script type="text/javascript">
	window.alert("The patient has been sent");
	window.close(this);	
</script>
<?php
}

if ($_REQUEST['pharmacy_doctor']){
	$visit_id = $_SESSION['visit_id'];
	$sql="Update visit set doc_visit='1',pharmarcy = 6 WHERE visit_id ='$visit_id'";
	$save = new Database();
	$save->insert($sql);
			

?>
<script type="text/javascript">
	window.alert("The patient has been sent");
	window.close(this);	
</script>
<?php
	}
	if ($_REQUEST['pharmacy_nurse']){
		$visit_id = $_SESSION['visit_id'];
	$sql="Update visit set nurse_visit = 1, doc_visit=1 , pharmarcy = 6 WHERE visit_id ='$visit_id'";
	$save = new Database();
	$save->insert($sql);
			

?>
<script type="text/javascript">
	window.alert("The patient has been sent");
	window.close(this);	
</script>
<?php
	}
		
		?>