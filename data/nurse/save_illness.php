<?php
class Database{

    private $connect;

    function  __construct() {
         //connect to database
        $this->connect=mysql_connect("localhost", "sumc_hms", "Oreo2014#")
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

$illness=$_GET['illness'];
$mec_id=$_GET['mec_id'];
$visit_id=$_GET['visit_id'];

class nurse{
	function check_text_save($mec_id,$visit_id){
				
		$sql = "SELECT * FROM med_check_text_save  WHERE med_id='$mec_id' and visit_id=$visit_id";
		echo $sql;
		$get = new Database;
		$rs = $get->select($sql);
		
		return $rs;
		
		}
	function save_nurse_notes($mec_id,$illness,$visit_id){	
		$get = new nurse();
		$rs = $get->check_text_save($mec_id,$visit_id);
		$num_nurse_notes = mysql_num_rows($rs);
		$mcts_id= mysql_result($rs, 0, 'mcts_id');
		
		if($num_nurse_notes == 0){	
			$sql = "INSERT INTO med_check_text_save (med_id, infor, visit_id) VALUES ('$mec_id', '$illness', $visit_id)";
			echo $sql;
		}
		else {
		
			$sql = "UPDATE med_check_text_save SET infor = '$illness' WHERE mcts_id = $mcts_id";
			echo $sql;
		}
		$save = new Database();
		$save->insert($sql);
	}
	
}
$save = new nurse();
	$save->save_nurse_notes($mec_id,$illness,$visit_id);
?>