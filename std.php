<?php 
$conn = oci_connect('AMS_QUERIES','MuYaibu1','//192.168.170.52:1521/orcl');
if (!$conn) 
{
	$e = oci_error();
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);

}

else{
	$sql = "SELECT * FROM GAOWNER.VIEW_STUDENT_DETAILS";echo $sql;

	$rs4 = oci_parse($conn, $sql);
	oci_execute($rs4);
	$rows = oci_num_rows($rs4);	

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

				//  details to be saved 

				$name=str_replace("'", "", "$name1");
				$oname=str_replace("'", "", "$oname1");
				$GUARDIAN_NAME=str_replace("'", "", "$GUARDIAN_NAME1");

				echo '<br/>'. $EMAIL.'     '.$MOBILE_NO.'      '.$GUARDIAN_NAME1.'      '.$name1.'      '.$dob.'      '.$gender.'      '.$oname1.'      '.$STUDENT_NO.'      '.$COURSES.'    '.$FACULTIES;

		}
}
?>