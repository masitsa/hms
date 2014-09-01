<?php
class Database{

    private $connect;

    function  __construct() {
         //connect to database
        $this->mysql_connect("localhost", "sumc_hms", "Oreo2014#")
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
class set_credit{
	function get_visit_type(){
		$sql="SELECT * FROM `visit_type";
		//echo $sql;
		$get=new Database;
		$rs=$get->select($sql);
		return $rs;
		}
	
		
	}

?>
<link href="css/cupertino/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<script src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-ui-1.10.3.custom.js"></script>
	<script>
	$(function() {
		
		$( "#accordion" ).accordion();
		

		
		var availableTags = [
			"ActionScript",
			"AppleScript",
			"Asp",
			"BASIC",
			"C",
			"C++",
			"Clojure",
			"COBOL",
			"ColdFusion",
			"Erlang",
			"Fortran",
			"Groovy",
			"Haskell",
			"Java",
			"JavaScript",
			"Lisp",
			"Perl",
			"PHP",
			"Python",
			"Ruby",
			"Scala",
			"Scheme"
		];
		$( "#autocomplete" ).autocomplete({
			source: availableTags
		});
		

		
		$( "#button" ).button();
		$( "#radioset" ).buttonset();
		

		
		$( "#tabs" ).tabs();
		

		
	
		$( "#datepicker" ).datepicker({
			inline: true
		});
		

	});
	</script>
<form action="" method="post" >
<input type="text" name="amt" id="amt">
<select>
<?php 
$get = new set_credit;
$rs = $get->get_visit_type();
$num_rows = mysql_num_rows($rs);

for ($a=0; $a< $num_rows; $a++){
	$visit_type_name= mysql_result($rs, $a, 'visit_type_name');
	$visit_type_id 	= mysql_result($rs, $a, 'visit_type_id');
?>	
	<option value="<?php echo $visit_type_id; ?>"> <?php echo $visit_type_name  ?></option>
	<?php }

?>
</select>
</form>

