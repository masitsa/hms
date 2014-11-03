<?php
$id=$_GET['id'];
$type=$_GET['type'];
$strath_no=$_GET['strath_no'];

//connect to SUMC
$connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error());
		
		$sql = "SELECT * FROM patients WHERE strath_no =$id and  dependant_id=$strath_no";
		//echo TT.$sql;
	    $rs = mysql_query($sql)
        or die ("unable to Select ".mysql_error());
		$num_rows=mysql_num_rows($rs);
		$patient_id=mysql_result($rs, 0, 'patient_id');
	//	echo $patient_id;
	if($num_rows==0){
		
		$sql2 = "INSERT INTO patients (visit_type_id,dependant_id,strath_no) VALUES (2,$strath_no,$id)";
	//	echo TTi.$sql;
	    $rs2 = mysql_query($sql2)
        or die ("unable to Select ".mysql_error()); 
		
		$sql = "SELECT * FROM patients WHERE strath_no =$id and  dependant_id=$strath_no";
		//echo TTo.$sql;
	    $rs = mysql_query($sql)
        or die ("unable to Select ".mysql_error());
		$num_rows=mysql_num_rows($rs);
		$patient_id=mysql_result($rs, 0, 'patient_id');
		
		
		if($type==1){
	?>
    <script>
		window.location.href="http://sagana/hms/index.php/welcome/initiate_lab/<?php echo $patient_id;?>"
	
	</script>
		<?php	}
		elseif($type==2){
			?>
    <script>
	window.location.href="http://sagana/hms/index.php/welcome/initiate_pharmacy/<?php echo $patient_id;?>"
	</script>
		<?php		
			
			
			}
		elseif($type==3){
			?>
    <script>
window.location.href="http://sagana/hms/index.php/welcome/initiate_visit/<?php echo $patient_id;?>"
	</script>
		<?php		
			
			
			}	}
			
			else{
				//echo fff;
				
				if($type==1){
							?>
    <script>
	window.location.href="http://sagana/hms/index.php/welcome/initiate_lab/<?php echo $patient_id;?>"
	</script>
		<?php
		}
		elseif($type==2){
			?>
    <script>
	window.location.href="http://sagana/hms/index.php/welcome/initiate_pharmacy/<?php echo $patient_id;?>"
	</script>
		<?php		
			
			
			}
		elseif($type==3){
			?>
    <script>
	window.location.href="http://sagana/hms/index.php/welcome/initiate_visit/<?php echo $patient_id;?>"
	</script>
		<?php
			
			
			}	
				}
		

        


?>