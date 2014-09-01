<?php 
$conn = oci_connect('AMS_QUERIES',' MuYaibu1','192.168.170.228:1521/STRATHMO');
	
		if (!$conn) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
		else{
		
		$sql = "SELECT * FROM   GAOWNER.VIEW_STUDENT_DETAILS WHERE STUDENT_NO='083041'  ";
		
	
		$rs4 = OCIParse($conn, $sql);
   		OCIExecute($rs4, OCI_DEFAULT);
		$rows = oci_num_rows($rs4);	
		//echo 'ROWS'.$rows;
		$t=0;
				while (OCIFetch($rs4)) {
					$t++;
			$name1=ociresult($rs4, "SURNAME");
			$dob=ociresult($rs4, "DOB");
			$gender=ociresult($rs4, "GENDER");		
			$oname1=ociresult($rs4, "OTHER_NAMES");
				$STUDENT_NO=ociresult($rs4, "STUDENT_NO");
			$COURSES=ociresult($rs4, "COURSES");
			$GUARDIAN_NAME1=ociresult($rs4, "GUARDIAN_NAME");
	$MOBILE_NO=ociresult($rs4, "MOBILE_NO");
		$EMAIL=ociresult($rs4, "EMAIL");
		$FACULTIES=ociresult($rs4, "FACULTIES");
		
		echo 'KKKK'. $EMAIL.'     '.$MOBILE_NO.'      '.$GUARDIAN_NAME1.'      '.$name1.'      '.$dob.'      '.$gender.'      '.$oname1.'      '.$STUDENT_NO.'      '.$COURSES.'    '.$FACULTIES;
		 //connect to database
        $connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("strathmore_population", $connect)
                    or die("Could not select database".mysql_error());

			$name=str_replace("'", "", "$name1");
			$oname=str_replace("'", "", "$oname1");
			$GUARDIAN_NAME=str_replace("'", "", "$GUARDIAN_NAME1");
			$sql2 = "INSERT INTO `strathmore_population`.`student` (`title`, `Surname`, `Other_names`, `DOB`, `contact`, `gender`, `student_Number`, `courses`, `GUARDIAN_NAME`)
			
 VALUES ('', '$name', '$oname', '$dob', '$MOBILE_NO', '$gender', '$STUDENT_NO', '$COURSES', '$GUARDIAN_NAME')";
				echo $sql2.'<br />';
		  $rs2 = mysql_query($sql2)  or  die ("unable to Select ".mysql_error());
  //echo 'TT'.$t;    
}
//echo $t;

}

?>