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
	$StockDescription1= mysql_result($rs9, $s, "StockDescription");
	$Brand_Name = mysql_result($rs9, $s, "Brand_Name");
    $Generic_Name1= mysql_result($rs9, $s, "Generic_Name");
    $Drug_class= mysql_result($rs9, $s, "Drug_class");
    $Unit_price = mysql_result($rs9, $s, "Unit_price");
    $Unit_Cost= mysql_result($rs9, $s, "Unit_Cost");
	
		$StockDescription=str_replace("'", "", $StockDescription1) ;
	
	//connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
	
			$sqla="select brand_id from brand where brand_name='$Brand_Name'";
		     $rs9a = mysql_query($sqla)  or  die ("unable to Select ".mysql_error());
			 echo $sqla;
			 $end_itema= mysql_num_rows($rs9a);
			 if( $end_itema> 0){
				 	$brand_id=mysql_result($rs9a, 0, 'brand_id');
			 }
			 else{
				 $brand_id="";
				 }
				 
			$sqlb="select class_id from class where class_name='$Drug_class'";
		     $rs9b = mysql_query($sqlb)  or  die ("unable to Select ".mysql_error());
			 $end_itemb= mysql_num_rows($rs9b);
			 if( $end_itemb> 0){
				 	$class_id =mysql_result($rs9b, 0, 'class_id');
			 }
			 else{
				 $class_id ="";
				 }	 
				$sqlc="select generic_id from generic where generic_name  LIKE '$Generic_Name'";
				echo $sqlc;
		     $rs9c = mysql_query($sqlc)  or  die ("unable to Select ".mysql_error());
			 $end_itemc= mysql_num_rows($rs9c);
			 if( $end_itemc> 0){
				 	$generic_id =mysql_result($rs9c, 0, 'generic_id');
			 }
			 else{
				 $generic_id ="";
				 }	
		
	$sql2="INSERT INTO `sumc`.`drugs` (`drugs_id` ,`drugs_name` ,`drug_size` ,`drug_size_type` ,`drugs_packsize` ,`drugs_unitprice` ,
`batch_no` ,`brand_id` ,`generic_id` ,`class_id` ,`drug_type_id` ,`drugs_dose` ,`drug_administration_route_id` ,`drug_dose_unit_id` ,
`drug_consumption_id` ,`quantity`)
VALUES (NULL , '$StockDescription', '', '', '', '$Unit_Cost', '', '$brand_id', '$generic_id', '$class_id ', '', '', NULL , NULL , NULL , '')";

echo $sql2.'<br />';
		     $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
				}

?>