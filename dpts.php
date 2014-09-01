<?php 


		
		 //connect to database
        $connect1 = mysql_connect("192.168.170.16", "medical", "Med_centre890")
                    or die("Unable to connect to MySQL".mysql_error());
        //selecting a database
        mysql_select_db("hr", $connect1)
                    or die("Could not select database".mysql_error());
					
					$sql2= "select `emp_relation`.`Employee_ID` AS `Employee_ID`,`emp_relation`.`Names` AS `Names`,`emp_relation`.`Occupation` AS `Occupation`,`relation_type`.`Relation_Type` AS `Relation_Type` from (`emp_relation` join `relation_type` on((`relation_type`.`Relation_TypeID` = `emp_relation`.`Relation_TypeID`)))";
					echo $sql2.'<br>';
        $rs2 = mysql_query($sql2)
		
        or die ("unable to Select ".mysql_error());
		
		$row23 = mysql_num_rows($rs2); 	
		
		for($i=0; $i<$row23; $i++){
			$Employee_ID=mysql_result($rs2, $i, 'Employee_ID');
			$Names= mysql_result($rs2, $i, 'Names');;
			$Occupation= mysql_result($rs2, $i, 'Occupation');	;
			$Relation_Type=mysql_result($rs2, $i, 'Relation_Type');
			
			echo $Employee_ID.' ->'.$Names.' ->'.$Occupation.' ->'.$Relation_Type;
			
			$names1=str_replace("'", "", $Names);
			
		 //connect to database
        $connect = mysql_connect("localhost", "root", "root1234")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());
			
		
		$sqk="INSERT INTO `strathmore_population`.`staff_dependants` (`names` ,`occupation` ,`relation` ,
`staff_id`)  VALUES ('$names1', '$Occupation', '$Relation_Type', '$Employee_ID')";
echo $sqk;
 $rs2k = mysql_query($sqk)
		
        or die ("unable to Select ".mysql_error());
			}
?>