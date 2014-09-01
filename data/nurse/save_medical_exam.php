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

$cat_items_id=$_GET['cat_items_id'];
$format_id=$_GET['format_id'];
$visit_id=$_GET['visit_id'];

class save_med{
	function insert_med_check($cat_items_id,$format_id,$visit_id){
		$sql = "INSERT INTO medical_checkup_results (cat_id,format_id,visit_id) VALUES ($cat_items_id,$format_id,$visit_id)";
		//echo $sql;
		$save = new Database;
		$save->insert($sql);
		
		}
	
	}
$s = new save_med();
$s->insert_med_check($cat_items_id,$format_id,$visit_id);

?>