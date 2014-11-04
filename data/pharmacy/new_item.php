<?php
include"../../classes/class_pharmacy.php";

// Process
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	
	
	// Send back the contact form HTML
	$output = "<div style='display:none'>
	<div class='contact-top'></div>
	<div class='contact-content'>
		<h1 class='contact-title'>Send us a message:</h1>
		<div class='contact-loading' style='display:none'></div>
		<div class='contact-message' style='display:none'></div>
		<form action='#' style='display:none'>
			<label for='contact-name'>Drug Name:</label>
			<input type='text' id='contact-name' class='contact-input' name='name' tabindex='1001'  autocomplete='off'/>
			<label for='contact-code'>Code:</label>
			<input type='text' id='contact-code' class='contact-input' name='code' tabindex='1001' autocomplete='off'/>
			<label for='contact-brand'>Brand:</label>
			<input type='text' id='contact-brand' class='contact-input' name='brand' tabindex='1001'  autocomplete='off'/>
			<label for='contact-generic'>Generic:</label>
			<input type='text' id='contact-generic' class='contact-input' name='generic' tabindex='1001' autocomplete='off'/>
			<label for='contact-class'>Class:</label>
			<input type='text' id='contact-class' class='contact-input' name='class' tabindex='1001' autocomplete='off'/>
			<label for='contact-packsize'>Pack Size:</label>
			<input type='text' id='contact-packsize' class='contact-input' name='packsize' tabindex='1001'  autocomplete='off'/>
			<label for='contact-unitprice'>Unit Price:</label>
			<input type='text' id='contact-unitprice' class='contact-input' name='unitprice' tabindex='1001'  autocomplete='off'/>";
			
			
			
	$output .= "
			<label>&nbsp;</label>
			<button type='submit' class='contact-send contact-button' tabindex='1006'>Save</button>
			<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>
			<br/></form>
	</div>
	<div class='contact-bottom'></div>
</div>";

	echo $output;
}

else if ($action == "send") {
	// Send the email
	$name = isset($_POST["name"]) ? $_POST["name"] : "";
	$code = isset($_POST["code"]) ? $_POST["code"] : "";
	$brand = isset($_POST["brand"]) ? $_POST["brand"] : "";
	$generic = isset($_POST["generic"]) ? $_POST["generic"] : "";
	$class = isset($_POST["class"]) ? $_POST["class"] : "";
	$packsize = isset($_POST["packsize"]) ? $_POST["packsize"] : "";
	$unitprice = isset($_POST["unitprice"]) ? $_POST["unitprice"] : "";
	$ten = isset($_POST["ten"]) ? $_POST["ten"] : "";
	$thirty_three = isset($_POST["thirty_three"]) ? $_POST["thirty_three"] : "";
	$batch_no = isset($_POST["batch_no"]) ? $_POST["batch_no"] : "";

	$save = new pharmacy();
	$save->save_drug($name, $code, $brand, $generic, $class, $packsize, $unitprice, $thirty_three, $ten,$batch_no);
}

exit;

?>