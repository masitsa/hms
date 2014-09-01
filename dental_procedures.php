<?php

		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("test", $connect)
                    or die("Could not select database".mysql_error());
		
			$sql="SELECT * FROM drugs ";
		     $rs9 = mysql_query($sql)  or  die ("unable to Select ".mysql_error());
			 $end_item= mysql_num_rows($rs9);
			 	for($s =0; $s < $end_item; $s++){
		
		$procedure= mysql_result($rs9, $s, "procedure");
		$cost1 = mysql_result($rs9, $s, "cost");
    $visit_Type = mysql_result($rs9, $s, "visit_Type");
    
   // $stud = mysql_result($rs9, $s, "service_charge_amount");
	$cost=str_replace(",", "", $cost1) ;
	' StockDescription 	Brand_Name 	Generic_Name Ascending 	Drug_class 	Unit_price 	Unit_Cost 	Quantity ';
	
	$sql2="INSERT INTO service_charge (service_charge_name,service_charge_amount,visit_type_id,service_id) VALUES ('$procedure','$cost', $visit_Type,9)";
echo $sql2.'<br />';
		     $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
				}

?>