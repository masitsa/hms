<?php

		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
		
			$sql="SELECT * FROM service_charge where service_id=5 ";
		     $rs9 = mysql_query($sql)  or  die ("unable to Select ".mysql_error());
			 $end_item= mysql_num_rows($rs9);
			 	for($s =0; $s < $end_item; $s++){
		/*'(`drugs_id` ,`drugs_name` ,`drug_size` ,`drug_size_type` ,`drugs_packsize` ,`drugs_unitprice` ,
`batch_no` ,`brand_id` ,`generic_id` ,`class_id` ,`drug_type_id` ,`drugs_dose` ,`drug_administration_route_id` ,`drug_dose_unit_id` ,
`drug_consumption_id` ,`quantity`)';*/
		$service_charge_name = mysql_result($rs9, $s, "service_charge_name");
		$service_charge_amount= mysql_result($rs9, $s, "service_charge_amount");
    	$lab_test_id = mysql_result($rs9, $s, "lab_test_id");

   // $stud = mysql_result($rs9, $s, "service_charge_amount");
//	$cost=str_replace(",", "", $cost1) ;
	//$visit_Type=0;
	$dd=($service_charge_amount * 1.20);
	$sql2="INSERT INTO service_charge (service_charge_name,service_charge_amount,visit_type_id,service_id, lab_test_id) VALUES ('$service_charge_name','$dd',4,5,'$lab_test_id')";
echo $sql2.'<br />';
		     $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
				}

?>