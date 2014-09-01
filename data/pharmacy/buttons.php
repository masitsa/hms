<?php
include"../../classes/class_pharmacy.php";

if($_REQUEST['update_stock']){
	
	$id = $_POST['hidden_id'];
	$name = addslashes($_POST['name'.$id]);
	$code = addslashes($_POST['code'.$id]);
	$brand = addslashes($_POST['brand'.$id]);
	$generic = addslashes($_POST['generic'.$id]);
	$class = addslashes($_POST['class'.$id]);
	$packsize = addslashes($_POST['packsize'.$id]);
	$unitprice = addslashes($_POST['unitprice'.$id]);
	$thirty_three = addslashes($_POST['thirty_three'.$id]);
	$twenty = addslashes($_POST['twenty'.$id]);
	$current_page = $_POST['current_page'];
	$batch_no = addslashes($_POST['batch_no'.$id]);
	$expiry_date = addslashes($_POST['expiry_date'.$id]);
	
	$update = new pharmacy();
	$update->update_drugs($name, $code, $brand, $generic, $class, $packsize, $unitprice, $thirty_three, $twenty, $id,$batch_no,$expiry_date);
	
	?>
	<script type="text/javascript">
		window.alert("Update Successfull");
		window.location.href = "../../pharmacy/stock.php?id=<?php echo $current_page?>";
	</script>
	<?php
}
?>