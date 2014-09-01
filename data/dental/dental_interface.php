<?php

$visit_id=$_GET['visit_id'];
$good_poor_fair=$_GET['oral']; 
$calculus=$_GET['calculus']; 
$oral_exam=$_GET['oral_exam'];
$tongue=$_GET['tongue'];
$palate=$_GET['palate'];
$gingivae=$_GET['gingivae'];
$teeth=$_GET['teeth'];
$other_findings=$_GET['other_finding'];
$xray_exam=$_GET['xray_exam'];
$radiography=$_GET['radio_graphy'];
$aesthetic_observation=$_GET['aesthetic_observation'];
$diagnosis=$_GET['diagnosis'];


	


//css files
class Database{

    private $connect;

    function  __construct() {
         //connect to database
        $this->connect = mysql_connect("localhost", "sumc_hms", "Oreo2014#")

                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        $selected = mysql_select_db("sumc", $this->connect)
                    or die("Could not select database".mysql_error());
    }

    function insert($sqlstatement){

        mysql_query($sqlstatement)
        or die ("unable to save ".mysql_error());

          mysql_close($this->connect);
    }

    function select($sql){

        $rs = mysql_query($sql)
        or die ("unable to Select ".mysql_error());

        return $rs;
    }
}
class dental_interface{
		function save_dental_stuff($visit_id,$good_poor_fair,$calculus,$oral_exam,$tongue,$palate,$gingivae,$teeth,$other_findings,$xray_exam,$radiography,$aesthetic_observation,$diagnosis){
			$sql="INSERT INTO `sumc`.`dental_doctor_visit` (`visit_id`, `good_poor_fair`, `calculus`, `oral_exam`, `tongue`, `palate`, `gingivae`, `teeth`, `other_findings`, `xray_exam`, `radiography`, `aesthetic_observation`, `diagnosis`) VALUES ('$visit_id', '$good_poor_fair', '$calculus', '$oral_exam', '$tongue', '$palate', '$gingivae', '$teeth', '$other_findings', '$xray_exam', '$radiography', '$aesthetic_observation', '$diagnosis')";
		//	echo $sql;
			$save= new Database;
			$save->insert($sql);
	
			}	
	function select_dental_staff($visit_id){
		$sql="select * from dental_doctor_visit where visit_id='$visit_id'";
	//	echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;
		}
	function update_dental_stuff($visit_id,$good_poor_fair,$calculus,$oral_exam,$tongue,$palate,$gingivae,$teeth,$other_findings,$xray_exam,$radiography,$aesthetic_observation,$diagnosis){
			$sql="update dental_doctor_visit SET `good_poor_fair`='$good_poor_fair', `calculus`='$calculus', `oral_exam`='$oral_exam', `tongue`='$tongue', `palate`='$palate', `gingivae`='$gingivae', `teeth`='$teeth', `other_findings`='$other_findings', `xray_exam`='$xray_exam', `radiography`='$radiography', `aesthetic_observation`='$aesthetic_observation', `diagnosis`='$diagnosis' where visit_id='$visit_id'";
			echo $sql;
			$save= new Database;
			$save->insert($sql);
		}
}

$get1= new dental_interface;
$rs1=$get1->select_dental_staff($visit_id);
$num_rows1=mysql_num_rows($rs1);
echo YY.$num_rows1;

if ($num_rows1==0){
	
$save= new dental_interface;
$save->save_dental_stuff($visit_id,$good_poor_fair,$calculus,$oral_exam,$tongue,$palate,$gingivae,$teeth,$other_findings,$xray_exam,$radiography,$aesthetic_observation,$diagnosis);
	
}
else{
	
$save1= new dental_interface;
$save1->update_dental_stuff($visit_id,$good_poor_fair,$calculus,$oral_exam,$tongue,$palate,$gingivae,$teeth,$other_findings,$xray_exam,$radiography,$aesthetic_observation,$diagnosis);
}

?>