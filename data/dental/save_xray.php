<?php
$visit_id=$_GET['visit_id'];
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

class dental{
	public function procedure($visit_type){
		
		$sql="select * from service_charge where service_id=9 and visit_type_id=$visit_type";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;		
		}
	public function get_visit($visit_id){
		
		$sql="select visit_type,patient_insurance_id from visit where visit_id=$visit_id";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;		
	}

		public function get_dental_charges($visit_id){
		
		$sql="select service_charge.service_charge_name,service_charge.service_charge_id,visit_charge.visit_charge_id, visit_charge.visit_charge_amount from visit_charge,service_charge where visit_id=$visit_id and visit_charge.service_charge_id=service_charge.service_charge_id";
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;		
		
		}
		
		public function remove_from_dental_queue($visit_id){
		
		$sql="UPDATE `sumc`.`visit` SET `dental_visit` = '0' WHERE `visit`.`visit_id` =$visit_id";
//	echo $sql;
$save= new Database;
	$save->insert($sql);	
		
		}
			public function get_service_id($service_charge_id){
		
		$sql="select service_id from service_charge where service_charge_id=$service_charge_id";
		//echo $sql;
$get= new Database;
		$rs=$get->select($sql);
		return $rs;		
		
		}
	public function delete_procedure($vcid){
		$sql="delete from visit_charge where visit_charge_id=$vcid";
		//echo $sql;
$save= new Database;
	$save->insert($sql);			
		}
		public function select_dental($visit_id){
		
		$sql="select * from dental_doctor_visit where visit_id=$visit_id ";
	//	echo $sql;
		$get= new Database;
		$rs=$get->select($sql);
		return $rs;			
		
		}
	
		public function save_dental_xray($visit_id,$pic){
		
		$sql="INSERT INTO `sumc`.`denta_xray` (`denta_xray_name` ,`denta_xray_visit_id`) VALUES ('$pic', '$visit_id'); ";
	//echo $sql;
$save= new Database;
	$save->insert($sql);			
		
		}
	}
	
if (isset($_POST['post_xray'])){
$file = $_FILES['file']['name'];
$a = pathinfo($file);
$basename = $a['basename'];
$filename = $a['filename'];
$extension = $a['extension'];
$path = $_SERVER['DOCUMENT_ROOT'].'/hms/dental/'; # set upload directory


$dest = $path.$basename;
if(file_exists($dest))
{
$b = count(glob($path.$filename.'*.'.$extension))+1; # all matches + 1

if(!file_exists($path.$filename.date('d_m_y_H_m_s').'.'.$extension))
{
move_uploaded_file($_FILES['file']['tmp_name'],$path.$filename.date('d_m_y_H_m_s').'.'.$extension);
$save= new dental;
$save->save_dental_xray($visit_id,$filename.date('d_m_y_H_m_s').'.'.$extension);
}
}
else
{
move_uploaded_file($_FILES['file']['tmp_name'],$dest);
$save= new dental;
$save->save_dental_xray($visit_id,$basename);
}
}
header('Location: http://sagana/hms/index.php/doctor/dental_interface/'.$visit_id);
?>