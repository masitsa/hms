<?php 

		 //connect to database
        $connect = mysql_connect("192.168.170.16", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("ohr_311", $connect)
                    or die("Could not select database".mysql_error());
		
			
			// $sql1 = "select `employee`.`Employee_ID` AS `E_ID`, `employee`.`Employee_Code` AS `Employee_Code`,`employee`.`ID_No` AS `ID_No`,`employee`.`Title` AS `Title`,`employee`.`Surname` AS `Surname`,`employee`.`Other_Name` AS `Other_Name`,`employee`.`Gender` AS `Gender`,`employee`.`DOB` AS `DOB`,`employee`.`Nationality` AS `Nationality`,`employee`.`Marital_Status` AS `Marital_Status`,`dept`.`Dept` AS `Dept`,`emp_post`.`Post` AS `Post`,`contact`.`Tel_1` AS `Tel_1`,`contact`.`Address_2` AS `Address_2`,`contact`.`Postal_Code` AS `Postal_Code`,`contact`.`Email` AS `Email`,`contact`.`City` AS `City` from (((`employee` join `emp_post` on((`employee`.`Employee_ID` = `emp_post`.`Employee_ID`))) join `contact` on((`employee`.`Contact_ID` = `contact`.`Contact_ID`))) join `dept` on((`employee`.`Dept_ID` = `dept`.`Dept_ID`))) ORDER BY Dept";
			$sql1 = "select 
			`hs_hr_employee`.`emp_number` AS `staff_system_id`,
			`hs_hr_employee`.`employee_id` AS `staff_no`,
			`hs_hr_employee`.`emp_lastname` AS `emp_lastname`,
			`hs_hr_employee`.`emp_firstname` AS `emp_firstname`,
			`hs_hr_employee`.`emp_middle_name` AS `emp_middle_name`,
			`hs_hr_employee`.`emp_birthday` AS `emp_birthday`,
			`hs_hr_employee`.`emp_gender` AS `emp_gender`,
			`hs_hr_employee`.`emp_marital_status` AS `marital_status`,
			`hs_hr_employee`.`emp_mobile` AS `emp_mobile`,
			`ohrm_subunit`.`name` AS `department`,
			`ohrm_nationality`.`name` AS `nationality`,
			`hs_hr_employee`.`emp_work_email` AS `emp_work_email`
			 from ((`hs_hr_employee` join `ohrm_subunit` on((`ohrm_subunit`.`id` = `hs_hr_employee`.`work_station`))) join `ohrm_nationality` on((`ohrm_nationality`.`id` = `hs_hr_employee`.`nation_code`))) where isnull(`hs_hr_employee`.`termination_id`) AND hs_hr_employee.employee_id = '1838' ORDER BY hs_hr_employee.emp_number ASC";
				//echo $sql1.'<br />';
       
		$result = mysql_query($sql1) or die ("unable to Select ".mysql_error());
		$row2 = mysql_num_rows($result);
		// Print the column names as the headers of a table
		echo "<table><tr>";
		for($i = 0; $i < mysql_num_fields($result); $i++) {
		    $field_info = mysql_fetch_field($result, $i);
		    echo "<th>{$field_info->name}</th>";
		}

		while($row = mysql_fetch_row($result)) {
		    echo "<tr>";
		    foreach($row as $_column) {
		        echo "<td>{$_column}</td>";
		    }
		    echo "</tr>";
		}

		echo "</table>";


?>