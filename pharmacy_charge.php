<?php

		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
		
			$sql="SELECT * FROM drugs ";
		     $rs9 = mysql_query($sql)  or  die ("unable to Select ".mysql_error());
			 $end_item= mysql_num_rows($rs9);
			 	for($s =0; $s < $end_item; $s++){
		/*'(`drugs_id` ,`drugs_name` ,`drug_size` ,`drug_size_type` ,`drugs_packsize` ,`drugs_unitprice` ,
`batch_no` ,`brand_id` ,`generic_id` ,`class_id` ,`drug_type_id` ,`drugs_dose` ,`drug_administration_route_id` ,`drug_dose_unit_id` ,
`drug_consumption_id` ,`quantity`)';*/
		$drugs_name= mysql_result($rs9, $s, "drugs_name");
		$drugs_id = mysql_result($rs9, $s, "drugs_id");
    	$drugs_unitprice = mysql_result($rs9, $s, "drugs_unitprice");

   // $stud = mysql_result($rs9, $s, "service_charge_amount");
//	$cost=str_replace(",", "", $cost1) ;
	$visit_Type=0;
	$dd1=($drugs_unitprice * 1.33);
	//$dd=round($dd1);
	$dd=round($dd1,0,PHP_ROUND_HALF_UP) ;
	$sql2="INSERT INTO service_charge (service_charge_name,service_charge_amount,visit_type_id,service_id, drug_id) VALUES ('$drugs_name','$dd', $visit_Type,4,'$drugs_id')";
echo $sql2.'<br />';
		     $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
				}

?>