<?php session_start();
include "../../classes/class_client.php";

$id = $_GET['id'];

$get = new Client;
$rs = $get->get_client($id);
$num_rows = mysql_num_rows($rs);

if($num_rows > 0){
	
	$client_id 	= mysql_result($rs, 0, "client_id");
	$client_firstname = mysql_result($rs, 0, "client_firstname");
	$client_surname = mysql_result($rs, 0, "client_surname");
	$client_dob = mysql_result($rs, 0, "client_dob");
	$client_contact = mysql_result($rs, 0, "client_contact");
	$client_address = mysql_result($rs, 0, "client_address");
	$client_town_code = mysql_result($rs, 0, "client_town_code");
	$client_locality = mysql_result($rs, 0, "client_locality");
	$client_registrar = mysql_result($rs, 0, "client_registrar");
	$client_email = mysql_result($rs, 0, "client_email");
	$client_sex = mysql_result($rs, 0, "client_sex");
	$client_registration_date = mysql_result($rs, 0, "client_registration_date");
	$client_number = mysql_result($rs, 0, "client_number");
	$_SESSION['current_client'] = $client_id;
	$_SESSION['current_client_name'] = $client_firstname." ".$client_surname;
	
	if($client_sex == "Male"){
		
		$sex = "<option selected>Male</option><option>Female</option><option>Other</option>";
	}
	
	else if($client_sex == "Female"){
		
		$sex = "<option>Male</option><option selected>Female</option><option>Other</option>";
	}
	else if($client_sex == "Other"){
		
		$sex = "<option>Male</option><option>Female</option><option selected>Other</option>";
	}
	
	echo 
	"
		<ul>
                                    	<li>
                							<ul class='right'>
                                            	<li class='right_space'>Client Number: </li>
                                            	<li><input type='text' placeholder='Client Number' name='client_number' value='".$client_number."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                                            
   							  				<ul class='right'>
                                            	<li class='right_space'>First Name: </li>
                                            	<li><input type='text' placeholder='First Name' name='client_firstname' value='".$client_firstname."'/></li>
                                          	</ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Other Names: </li>
                                            	<li><input type='text' name='client_surname'  placeholder='Other Names' value='".$client_surname."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Email: </li>
                                            	<li><input type='text' name='client_email'  placeholder='Email' value='".$client_email."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Address: </li>
                                            	<li><input type='text' name='client_address'  placeholder='Address' value='".$client_address."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Town Code: </li>
                                            	<li><input type='text' name='client_town_code'  placeholder='Town Code' value='".$client_town_code."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Location Name: </li>
                                            	<li><input type='text' name='client_locality'  placeholder='Location' value='".$client_locality."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Date of Birth: </li>
                                            	<li><input type='text' id='datepicker' name='client_dob' size='15' autocomplete='off' placeholder='Date of Birth' value='".$client_dob."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Sex: </li>
                                            	<li>
                        							<select name='client_sex'>".$sex."</select>
                        						</li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Telephone: </li>
                                            	<li><input type='text' name='client_contact'  placeholder='Telephone' value='".$client_contact."'/></li>
                                            </ul>
                                            
                                			<div class='clear_div'></div>
                
                							<ul class='right'>
                                            	<li class='right_space'>Form Signed Date: </li>
                                            	<li><input type='text' name='client_registration_date' size='15' placeholder='Signed Date' id='datepicker2' autocomplete='off' value='".$client_registration_date."'/></li>
                                           	</ul>
                                   	  </li>
                               	  </ul>
	";
}
?>