<?php
session_start();
include("../../classes/class_pharmacy.php");

// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	
	$_SESSION['purchase_id'] = $_SESSION['purchase_id2'];
	
	$get_name = new pharmacy();
	$rs = $get_name->get_drugs_name($_SESSION['purchase_id']);
	
	$item = mysql_result($rs, 0, "drugs_name");
	$bp = mysql_result($rs, 0, "drugs_unitprice");
	
	$bp = (($bp *1.33)*0.9);
	
		
	// Send back the contact form HTML
	$output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Send us a message:</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-item'>Date:</label>
			<input type='text' id='contact-item' class='contact-input' name='item' tabindex='1001' value='".date("y-m-d")."' readonly='readonly' autocomplete='off'/>
			<label for='contact-item'>Drug Name:</label>
			<input type='text' id='contact-item' class='contact-input' name='item' tabindex='1001' value='".$item."' readonly='readonly' autocomplete='off'/>
			<label for='contact-bp'>Buying Price:</label>
			<input type='text' id='contact-bp' class='contact-input' name='bp' tabindex='1001' value='".$bp."' autocomplete='off'/>
			<label for='contact-quantity'>Quantity:</label>
			<input type='text' id='contact-quantity' class='contact-input' name='quantity' tabindex='1001' value='' autocomplete='off'/>
			<label for='contact-units'>Units:</label>
			<input type='text' id='contact-units' class='contact-input' name='units' tabindex='1001'  autocomplete='off'/>;
			<label for='contact-units'>Batch No:</label>
			<input type='text' id='contact-batch_no' class='contact-input' name='batch_no' tabindex='1001'  autocomplete='off'/>";
			
	$output .= "
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>Send</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>
			<br/></form>
	</div>
	<div class='contact-bottom'></div>
</div>";

	echo $output;
}
else if ($action == "send") {

	$quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
	$units = isset($_POST["units"]) ? $_POST["units"] : "";
	$bp = isset($_POST["bp"]) ? $_POST["bp"] : "";
	$batch_no = isset($_POST["batch_no"]) ? $_POST["batch_no"] : "";
	
	$id = $_SESSION['purchase_id'];
	$date = date("y-m-d");
	$employee_id = 0;
	
	$save = new pharmacy();
	$save->register_purchase($id, $quantity, $units, $bp, $employee_id,$batch_no);
}

exit;

?>