<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 0);
class Database{

    private $connect;

    function  __construct() {
         //connect to database
        //$this->connect=mysql_connect("localhost", "sumc_hms", "Oreo2014#")
		$this->connect=mysql_connect("localhost", "sungura", "123")
                    or die("Unable to connect to MySQL".mysql_error());
?>
<script>
window.alert('WACHA UJINGA!!!!');

</script>
<?php
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
?>