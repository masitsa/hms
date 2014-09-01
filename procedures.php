<?php

		
		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
		
			$sql="SELECT *
FROM service_charge
WHERE service_id = '1'
AND visit_type_id =3";
echo $sql.'<br />';
		     $rs9 = mysql_query($sql)  or  die ("unable to Select ".mysql_error());
			 $end_item= mysql_num_rows($rs9);
			 	for($s =0; $s < $end_item; $s++){
		
		$labe= mysql_result($rs9, $s, "lab_test_id");
		$proced = mysql_result($rs9, $s, "service_charge_name");
    $visit_type = mysql_result($rs9, $s, "visit_type_id");
    
    $stud = mysql_result($rs9, $s, "service_charge_amount");
	echo L.$proced;
	
	$sql2="INSERT INTO service_charge (service_charge_name,service_charge_amount,visit_type_id,service_id,lab_test_id) VALUES ('$proced','$stud',4,1,$labe)";
echo $sql2.'<br />';
		     $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
				}
?>