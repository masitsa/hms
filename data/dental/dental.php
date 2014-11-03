<?php
$visit_id=$_GET['visit_id'];
$procedure_id=$_GET['procedure_id'];

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

class dental{
	public function save_procedure($visit_id,$procedure_id){
		$sql="insert into visit_charge (visit_id,service_charge_id,visit_charge_amount) values ($visit_id,$procedure_id,(select service_charge_amount from service_charge where service_charge_id='$procedure_id'))";
		echo $sql;
		$save= new Database;
		$save->insert($sql);
		
		}
	
	}
	
	$save1= new dental;
$save1-> save_procedure($visit_id,$procedure_id);
?>