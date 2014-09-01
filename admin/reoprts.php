<?php
class Database{

    private $connect;

    function  __construct() {
         //connect to database
        $this->connect=mysql_connect("localhost", "sumc_hms", "Oreo2014#")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        $selected = mysql_select_db("pos1", $this->connect)
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

};
class reports{
function select_tills(){
	$sql="SELECT * FROM `till`";
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
}
function select_till_name($till_id){
	$sql="SELECT till_name FROM `till` where till_id='$till_id'";
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_till($till_id){
	$sql="SELECT user_till_id FROM user_till where till_id=$till_id";
	//echo $sql;
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}	
function get_till_sales($user_till_id){
	$sql="SELECT sales.sales_id, sales.time  FROM sales where sales.user_till_id=$user_till_id";
	//echo $sql;
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function till_id($user_till_id){
	$sql="SELECT till_id FROM user_till where user_till_id=$user_till_id";
	//echo $sql;
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_product_sale($sales_id){
	$sql="SELECT  * FROM  sale_product where sale_product.sales_id=$sales_id";
	//echo $sql;
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_product_cost($product_id){
	$sql="SELECT * FROM `product` where product_id='$product_id'";
	//echo $sql; 
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_vat($vat_id){
	$sql="SELECT * FROM vat_types where vat_types_id='$vat_id'";
	//echo $sql; 
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_sales_date($date1){
	$sql="SELECT * FROM sales where time LIKE '%$date1%'";
	//echo $sql; 
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}
function get_sales_btn_date($date1,$date2){
	$sql="SELECT * FROM sales WHERE time >= '$date1' AND time <= '$date2'";
	//echo $sql; 
	$get= new Database;
	$rs=$get->select($sql);
	return $rs;
	}

}
?>
<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>Till Reports</title>
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
		

		
		$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			buttons: [
				{
					text: "Ok",
					click: function() {
						$( this ).dialog( "close" );
					}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		});

		// Link to open the dialog
		$( "#dialog-link" ).click(function( event ) {
			$( "#dialog" ).dialog( "open" );
			event.preventDefault();
		});
		

		
		$( "#datepicker" ).datepicker({
			inline: true
		});
		

		
		$( "#slider" ).slider({
			range: true,
			values: [ 17, 67 ]
		});
		

		
		$( "#progressbar" ).progressbar({
			value: 20
		});
		

		// Hover states on the static widgets
		$( "#dialog-link, #icons li" ).hover(
			function() {
				$( this ).addClass( "ui-state-hover" );
			},
			function() {
				$( this ).removeClass( "ui-state-hover" );
			}
		);
		$( "#from" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		});
		
		function toggleField(field1) {
var myTarget = document.getElementById(field1);

if(myTarget.style.display == 'none'){
  myTarget.style.display = 'block';
    }}
	</script>
<style type='text/css'>
body
{	background:#09F;
	font-family: Arial;
	font-size: 11px;
}
#wrapper { min-height:600px; width:auto; margin: 0px 0px 0px 0px; background: #fff; border-radius:4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; padding: 0px 50px; border: 10px solid #C0C0C0;border-radius: 15px 15px 15px }
a {
    color: blue;
    text-decoration: none;
    font-size: 11px;
}
a:hover
{
	text-decoration: underline;
}
.prices {
    border: 1px solid #DADADA;
    border-radius: 7px 40px 7px 40px;
    font-size: 12px;
    margin-top: 0;
    width: 100px;
    padding: 4px;
}
.prices:focus { 
    outline:none;
    border-color:#9ecaed;
    box-shadow:0 0 10px #9ecaed;
}
</style>
</head>
<body>
<div id="wrapper">
<form action="http://sagana/pos_online/reports/reports/reoprts.php" method="post">
<h2 class="demoHeaders">Pick Date &nbsp&nbsp&nbsp&nbsp <input type="text" id="from" name="from" value="<?php echo date("20y-m-d");?>"></h2>

<h2 class="demoHeaders">Pick Mode of Compiling <select onChange="toggleField('ggg');" name="compile">
 <option value="CM">Compute Sales for One Date  </option>
 <option value="to2"> TO  		(This Adds the sales of the of all the days between the dates provided)</option>
 </select></h2>
 <div id="ggg"  style="display:none;">
<h2 class="demoHeaders">Pick Date &nbsp&nbsp&nbsp&nbsp <input type="text" id="to" name="to"></h2> </div>

<input type="submit" class="prices" name="submit" id="submit">
</form>


<div id="tabs">
	<ul>
    <?php
	
	$get= new reports;
		$rs=$get->select_tills();
		$num_rowsz=mysql_num_rows($rs);	
		for($z=0; $z< $num_rowsz; $z++){
		$till_name= mysql_result($rs, $z, 'till_name');
		$till_id= mysql_result($rs, $z, 'till_id');
	?>
		<li><a href="#tabs-<?php echo $till_id; ?>"><?php echo $till_name; ?></a></li>        
       <?php
		} ?>
	</ul>
    
        <?php

if (isset($_POST['submit'])){
	$from=$_POST['from'];
	//echo T.$from;
	$to=$_POST['to'];
	$compile=$_POST['compile'];
	
	//echo COMP.$compile;
			if(($from!="")&&($compile=="CM")){
			$gets2= new reports;
			$rss2=$gets2->select_tills();
			$num_rowss2=mysql_num_rows($rss2);
			
			for($as2=0; $as2< $num_rowss2; $as2++){
				$trrv2="";  $tempvx=""; $totalv=""; $tempt1x="";$totatl=""; 
			$till_idss1= mysql_result($rss2, $as2, 'till_id');
			?>		
			<div id="tabs-<?php echo $till_idss1;?>">
       		<?php
			$gets1= new reports;
			$rss1=$gets1-> get_sales_date($from);
			$num_rowss1=mysql_num_rows($rss1);
			
			for($as1=0; $as1< $num_rowss1; $as1++){
			$sales_id= mysql_result($rss1, $as1, 'sales_id');
			$user_till_id= mysql_result($rss1, $as1, 'user_till_id');
			//echo SID.$sales_id.'<br>';
			//echo UTID.$user_till_id.'<br>';
			$gets3= new reports;
			$rss3=$gets3-> till_id($user_till_id);
			$num_rowss3=mysql_num_rows($rss3);
			
			for($as3=0; $as3< $num_rowss3; $as3++){		
	$till_idss= mysql_result($rss3, $as3, 'till_id');
			if($till_idss==$till_idss1){
			//echo $sales_id;
			$gets4= new reports;
			$rss4=$gets4-> get_product_sale($sales_id);
			$num_rowss4=mysql_num_rows($rss4);
			for($as4=0; $as4< $num_rowss4; $as4++){	
			$product_id= mysql_result($rss4, $as4, 'product_id');
			$price= mysql_result($rss4, $as4, 'price');
			$sale_product_quantity= mysql_result($rss4, $as4, 'sale_product_quantity');

 $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trrv2=$sale_product_quantity*$price.'     '.'<strong>'.$trrv2+$trrv2 .'</strong><br>';

$get6= new reports; 
         $rs6=$get6->get_product_cost($product_id);
		 $num_rows6=mysql_num_rows($rs6);
		 for($g=0; $g< $num_rows6; $g++){
	$product_cost= mysql_result($rs6, $g, 'product_cost');
	$VAT_types_id= mysql_result($rs6, $g, 'VAT_types_id');
		 $get7= new reports; 
         $rs7=$get7->get_vat($VAT_types_id);
		 $num_rows7=mysql_num_rows($rs7);
		 
$cost=($product_cost*$sale_product_quantity);
$totalv=$cost+$tempvx;  $tempvx=$totalv;
//echo $totalv;
		 $get7= new reports; 
         $rs7=$get7->get_vat($VAT_types_id);
		 $num_rows7=mysql_num_rows($rs7);
for($h=0; $h< $num_rows7; $h++){
		$VAT_types_description= mysql_result($rs7, $h, 'VAT_types_description');
		if($VAT_types_description!=0){
			$tax=($price*$sale_product_quantity*$VAT_types_description/100);
$totatl=$tax+$tempt1x;  $tempt1x=$totatl;  
} else {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
$totatl=$tax+$tempt1x;  $tempt1x=$totatl; 
}}
		 }}}}}
		 if($trrv2!=""){
			 ?>
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif;  text-decoration:underline; font-size:15px; width:auto;"> <?php echo ' Total Sales Made on '. $from.'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Sales'.$trrv2.'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo 'Total Cost Made:'.$totalv.'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Profit Made:'.($trrv2-$totalv).'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax Made:'.$totatl.'<br>'; ?></strong><?php
			}
		
		 else{
			?>
			<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF;width:auto;"> No sales Made In This Till</strong>
			<?php }
	
		echo '</div>';}}
		else if(($from!="")&&($compile=="to2")){
			$gets2= new reports;
			$rss2=$gets2->select_tills();
			$num_rowss2=mysql_num_rows($rss2);
			
			for($as2=0; $as2< $num_rowss2; $as2++){
				$trrv2="";  $tempvx=""; $totalv=""; $tempt1x="";$totatl=""; 
			$till_idss1= mysql_result($rss2, $as2, 'till_id');
			?>		
			<div id="tabs-<?php echo $till_idss1;?>">
       		<?php
			$gets1= new reports;
			$rss1=$gets1-> get_sales_btn_date($from,$to);
			$num_rowss1=mysql_num_rows($rss1);
			
			for($as1=0; $as1< $num_rowss1; $as1++){
		$sales_id= mysql_result($rss1, $as1, 'sales_id');
		$user_till_id= mysql_result($rss1, $as1, 'user_till_id');
			//echo SID.$sales_id.'<br>';
			//echo UTID.$user_till_id.'<br>';
			$gets3= new reports;
			$rss3=$gets3-> till_id($user_till_id);
			$num_rowss3=mysql_num_rows($rss3);
			
			for($as3=0; $as3< $num_rowss3; $as3++){		
	$till_idss= mysql_result($rss3, $as3, 'till_id');
			if($till_idss==$till_idss1){
			//echo $sales_id;
			$gets4= new reports;
			$rss4=$gets4-> get_product_sale($sales_id);
			$num_rowss4=mysql_num_rows($rss4);
			for($as4=0; $as4< $num_rowss4; $as4++){	
			$product_id= mysql_result($rss4, $as4, 'product_id');
			$price= mysql_result($rss4, $as4, 'price');
			$sale_product_quantity= mysql_result($rss4, $as4, 'sale_product_quantity');
//echo PRI.$price.'<br>';
 $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trrv2=$sale_product_quantity*$price.'     '.'<strong>'.$trrv2+$trrv2 .'</strong><br>';

$get6= new reports; 
         $rs6=$get6->get_product_cost($product_id);
		 $num_rows6=mysql_num_rows($rs6);
		 for($g=0; $g< $num_rows6; $g++){
	$product_cost= mysql_result($rs6, $g, 'product_cost');
	$VAT_types_id= mysql_result($rs6, $g, 'VAT_types_id');
		 $get7= new reports; 
         $rs7=$get7->get_vat($VAT_types_id);
		 $num_rows7=mysql_num_rows($rs7);
		 
$cost=($product_cost*$sale_product_quantity);
$totalv=$cost+$tempvx;  $tempvx=$totalv;
//echo $totalv;
		 $get7= new reports; 
         $rs7=$get7->get_vat($VAT_types_id);
		 $num_rows7=mysql_num_rows($rs7);
for($h=0; $h< $num_rows7; $h++){
		$VAT_types_description= mysql_result($rs7, $h, 'VAT_types_description');
		if($VAT_types_description!=0){
			$tax=($price*$sale_product_quantity*$VAT_types_description/100);
$totatl=$tax+$tempt1x;  $tempt1x=$totatl;  
} else {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
$totatl=$tax+$tempt1x;  $tempt1x=$totatl; 
}}
		 }}}}}
		 if($trrv2!=""){
			 ?>
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; text-decoration:underline; font-size:15px; width:auto;"> <?php echo 'Reports for Sales Made from '. $from .'----   TO   ----'.$to.'<br>'; ?></strong>
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Sales Made on :  '.$trrv2.'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo 'Total Cost Made:'.$totalv.'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Profit Made:'.($trrv2-$totalv).'<br>'; ?></strong>

<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax Made:'.$totatl.'<br>'; ?></strong><?php
			}
		
		 else{
			?>
			<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF;width:auto;"> No sales Made In This Till</strong>
			<?php }
	
		echo '</div>';}}
			else {
			?>
			<script>
			window.alert('ENSURE YOU HAVE SELECTED A DATE');
			</script>	<?php }
}
	else{
	$get= new reports;
		$rs=$get->select_tills();
		$num_rowsz=mysql_num_rows($rs);	
		for($z=0; $z< $num_rowsz; $z++){
		$till_name= mysql_result($rs, $z, 'till_name');
		$till_id= mysql_result($rs, $z, 'till_id');
  ?>
    	<div id="tabs-<?php echo $till_id; ?>"> 
        
     <?php 
	
	  $get1= new reports; 
      $rs1=$get->get_till($till_id);
      $num_rows=mysql_num_rows($rs1);	
	  $trr="";  
$temp1x="";$total="";   $temp1x2="";	$total2="";   $temp1x3="";	$total3="";   $temp1x4="";	$total4="";   $temp1x5="";	$total5="";   $temp1x6="";	$total6="";   $temp1x7="";	$total7="";   $temp1x8="";	$total8="";   $temp1x9="";	$total9="";   $temp1x10="";	$total10=""; 
	   $temp1x11="";	$total11="";   $temp1x12="";	$total12=""; 
	   $till_id_compare="";
	   $time="";
$trr1="";$trr2=""; $trr3="";$trr4=""; $trr5="";$trr6=""; $trr7="";$trr8=""; $trr9="";$trr10=""; $trr11="";$trr12="";

	$temp211x="";$total211=""; $temp22x="";$total22="";  $temp23x="";$total23=""; $temp24x="";$total24=""; $temp25x="";$total25="";  $temp26x="";$total26=""; $temp27x="";$total27="";  $temp28x="";$total28="";  $temp29x="";$total29=""; $temp210x="";$total210=""; $temp211x="";$total211=""; $temp21x="";$total212="";
	   $items1="";$temp1x11="";$items2="";$temp1x22="";$items3="";$temp1x33="";$items4="";$temp1x44="";$items5="";$temp1x55="";$items6="";$temp1x66="";$items7="";$temp1x77="";$items8="";$temp1x88="";$items9="";$temp1x99="";$items10="";$temp1x1010="";$items11="";$temp1x1111="";$items12="";$temp1x1212="";
	$a="";   
	
for($c=0; $c< $num_rows; $c++){
		$user_till_id= mysql_result($rs1, $c, 'user_till_id');
		$get4= new reports;
		$rs4=$get4->till_id($user_till_id);	
		$num_rows4=mysql_num_rows($rs4);
	for($f=0; $f< $num_rows4; $f++){
		
		$till_id_compare= mysql_result($rs4, $f, 'till_id');
if($till_id==$till_id_compare){

	$get2= new reports;
		$rs2=$get2->get_till_sales($user_till_id);
		$num_rows2=mysql_num_rows($rs2);
	for($d=0; $d< $num_rows2; $d++){
	$a++;
	$sales_id= mysql_result($rs2, $d, 'sales_id');
		 $time= mysql_result($rs2, $d,'time');		 
		// echo 	$sales_id.'		'.$time.'<br>';
		 $get3= new reports; 
         $rs3=$get3->get_product_sale($sales_id);
		 $num_rows3=mysql_num_rows($rs3);
		 for($e=0; $e< $num_rows3; $e++){
			$product_id= mysql_result($rs3, $e, 'product_id');
			$price= mysql_result($rs3, $e, 'price');
			$sale_product_quantity= mysql_result($rs3, $e, 'sale_product_quantity');
	
$tttt=(date_parse($time));
$da=0;
$year=date('20y');
while($da<12){
{ $da++;
$key = array_search($da, $tttt);
$key2 = array_search($year, $tttt);
if (($key=='month')&&($key2=='year')) {
     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr=$sale_product_quantity*$price.'     '.'<strong>'.$trr+$trr .'</strong><br>';

if($da==1){
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr1=$sale_product_quantity*$price.'     '.'<strong>'.$trr1+$trr1 .'</strong><br>';
$items1=$sale_product_quantity+$temp1x11;	
$temp1x11=$items1;
}
elseif ($da==2) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr2=$sale_product_quantity*$price.'     '.'<strong>'.$trr2+$trr2 .'</strong><br>';
$items2=$sale_product_quantity+$temp1x22;
$temp1x22=$items2;}
elseif ($da==3) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr3=$sale_product_quantity*$price.'     '.'<strong>'.$trr3+$trr3 .'</strong><br>';
$items3=$sale_product_quantity+$temp1x33;
$temp1x33=$items3;}
elseif ($da==4) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr4=$sale_product_quantity*$price.'     '.'<strong>'.$trr4+$trr4 .'</strong><br>'; 
$items4=$sale_product_quantity+$temp1x44;
$temp1x44=$items4;}
elseif ($da==5) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr5=$sale_product_quantity*$price.'     '.'<strong>'.$trr5+$trr5 .'</strong><br>';
$items5=$sale_product_quantity+$temp1x55;
$temp1x55=$items5;}
elseif ($da==6) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr6=$sale_product_quantity*$price.'     '.'<strong>'.$trr6+$trr6 .'</strong><br>';
$items6=$sale_product_quantity+$temp1x66;
$temp1x66=$items6;}
elseif ($da==7) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr7=$sale_product_quantity*$price.'     '.'<strong>'.$trr7+$trr7 .'</strong><br>';
$items7=$sale_product_quantity+$temp1x77;
 $temp1x77=$items7;}
elseif ($da==8) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr8=$sale_product_quantity*$price.'     '.'<strong>'.$trr8+$trr8 .'</strong><br>';
$items8=$sale_product_quantity+$temp1x88;
$temp1x88=$items8;}
elseif ($da==9) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr9=$sale_product_quantity*$price.'     '.'<strong>'.$trr9+$trr9 .'</strong><br>';
$items9=$sale_product_quantity+$temp1x99;
$temp1x99=$items9;}
elseif ($da==10) {     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr10=$sale_product_quantity*$price.'     '.'<strong>'.$trr10+$trr10.'</strong><br>';
$items10=$sale_product_quantity+$temp1x1010;
$temp1x1010=$items10;}
elseif ($da==11) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr11=$sale_product_quantity*$price.'     '.'<strong>'.$trr11+$trr11.'</strong><br>';
$items11=$sale_product_quantity+$temp1x1010;
$temp1x1111=$items11;}
elseif ($da==12) {
	     $sales_id.'   '.$price.'     '.	$sale_product_quantity.'<br>'; 
$trr12=$sale_product_quantity*$price.'     '.'<strong>'.$trr12+$trr12.'</strong><br>';
$items12=$sale_product_quantity+$temp1x1212;
$temp1x1212=$items12;}}
else {
	//echo $da;
}}}
	$total_sales= $sale_product_quantity*$price; 
	$total_sales1=$total_sales+$total_sales_temp;
	$total_sales_temp=$total_sales1;
		//echo $total_sales_temp.'<br>';
		 
		$get6= new reports; 
         $rs6=$get6->get_product_cost($product_id);
		 $num_rows6=mysql_num_rows($rs6);
		 for($g=0; $g< $num_rows6; $g++){
	$product_cost= mysql_result($rs6, $g, 'product_cost');
	$VAT_types_id= mysql_result($rs6, $g, 'VAT_types_id');
		 $get7= new reports; 
         $rs7=$get7->get_vat($VAT_types_id);
		 $num_rows7=mysql_num_rows($rs7);
	$cost=($product_cost*$sale_product_quantity);
	$total21=$cost+$temp21x;  $temp21x=$total21;
	////////////////////////////////////////////////////////////////////
	$tttt=(date_parse($time));
$da=0;
$year=date('20y');
while($da<12){
{ $da++;
$key = array_search($da, $tttt);
$key2 = array_search($year, $tttt);
if (($key=='month')&&($key2=='year')) {
$cost=($product_cost*$sale_product_quantity);
	$total21=$cost+$temp21x;  $temp21x=$total21;
if($da==1){
	 		$cost=($product_cost*$sale_product_quantity);
	$total211=$cost+$temp211x;  $temp211x=$total211;
	
	}
elseif ($da==2) {
		$cost=($product_cost*$sale_product_quantity);
	$total22=$cost+$temp22x;  $temp22x=$total22;
}
elseif ($da==3) {
	$cost=($product_cost*$sale_product_quantity);
	$total23=$cost+$temp23x;  $temp23x=$total23;
}
elseif ($da==4) {
	$cost=($product_cost*$sale_product_quantity);
	$total24=$cost+$temp24x;  $temp24x=$total24;
}
elseif ($da==5) {
	$cost=($product_cost*$sale_product_quantity);
	$total25=$cost+$temp25x;  $temp25x=$total25;
}
elseif ($da==6) {
	$cost=($product_cost*$sale_product_quantity);
	$total26=$cost+$temp26x;  $temp26x=$total26;
}
elseif ($da==7) {
	$cost=($product_cost*$sale_product_quantity);
	$total27=$cost+$temp27x;  $temp27x=$total27;
}
elseif ($da==8) {
	$cost=($product_cost*$sale_product_quantity);
	$total28=$cost+$temp28x;  $temp28x=$total28;
}
elseif ($da==9) {
	$cost=($product_cost*$sale_product_quantity);
	$total29=$cost+$temp29x;  $temp29x=$total29;
}
elseif ($da==10) {     
	$cost=($product_cost*$sale_product_quantity);
	$total210=$cost+$temp210x;  $temp210x=$total210;
}
elseif ($da==11) {
	$cost=($product_cost*$sale_product_quantity);
	$total211=$cost+$temp211x;  $temp211x=$total211;
}
elseif ($da==12) {
	$cost=($product_cost*$sale_product_quantity);
	$total212=$cost+$temp212x;  $temp21x=$total212;
}}}}
	///////////////////////////////////////////////////////////////////
for($h=0; $h< $num_rows7; $h++){
		$VAT_types_description= mysql_result($rs7, $h, 'VAT_types_description');
		if($VAT_types_description!=0){
			$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total=$tax+$temp1x;  $temp1x=$total; 	
$tttt=(date_parse($time));
$da=0;
$year=date('20y');
while($da<12){
{ $da++;
$key = array_search($da, $tttt);
$key2 = array_search($year, $tttt);
if (($key=='month')&&($key2=='year')) {
 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total=$tax+$temp1x;  $temp1x1=$total; 	
if($da==1){
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total1=$tax+$temp1x1;  $temp1x1=$total1; 
	}
elseif ($da==2) {
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total2=$tax+$temp1x2;  $temp1x2=$total2;
}
elseif ($da==3) {
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total3=$tax+$temp1x3;  $temp1x3=$total3;
}
elseif ($da==4) {
 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total4=$tax+$temp1x4;  $temp1x4=$total4;
}
elseif ($da==5) {
		$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total5=$tax+$temp1x5;  $temp1x5=$total5;
}
elseif ($da==6) {
	    	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total6=$tax+$temp1x6;  $temp1x6=$total6;
}
elseif ($da==7) {
	     	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total7=$tax+$temp1x7;  $temp1x7=$total7;
}
elseif ($da==8) {
	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total8=$tax+$temp1x8;  $temp1x8=$total8;
}
elseif ($da==9) {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total9=$tax+$temp1x9;  $temp1x9=$total9;
}
elseif ($da==10) {     
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total10=$tax+$temp1x10;  $temp1x10=$total10;
}
elseif ($da==11) {
	    $tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total11=$tax+$temp1x11;  $temp1x11=$total11;
}
elseif ($da==12) {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total12=$tax+$temp1x12;  $temp1x12=$total12;
}}}}
			}
		else{
		$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total=$tax+$temp1x;  $temp1x=$total; 	
			$tttt=(date_parse($time));
$da=0;
$year=date('20y');
while($da<12){
{ $da++;
$key = array_search($da, $tttt);
$key2 = array_search($year, $tttt);
if (($key=='month')&&($key2=='year')) {
 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total=$tax+$temp1x;  $temp1x1=$total; 	
if($da==1){
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total1=$tax+$temp1x1;  $temp1x1=$total1; 
	}
elseif ($da==2) {
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total2=$tax+$temp1x2;  $temp1x2=$total2;
}
elseif ($da==3) {
	 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total3=$tax+$temp1x3;  $temp1x3=$total3;
}
elseif ($da==4) {
 	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total4=$tax+$temp1x4;  $temp1x4=$total4;
}
elseif ($da==5) {
		$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total5=$tax+$temp1x5;  $temp1x5=$total5;
}
elseif ($da==6) {
	    	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total6=$tax+$temp1x6;  $temp1x6=$total6;
}
elseif ($da==7) {
	     	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total7=$tax+$temp1x7;  $temp1x7=$total7;
}
elseif ($da==8) {
	$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total8=$tax+$temp1x8;  $temp1x8=$total8;
}
elseif ($da==9) {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total9=$tax+$temp1x9;  $temp1x9=$total9;
}
elseif ($da==10) {     
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total10=$tax+$temp1x10;  $temp1x10=$total10;
}
elseif ($da==11) {
	    $tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total11=$tax+$temp1x11;  $temp1x11=$total11;
}
elseif ($da==12) {
$tax=($price*$sale_product_quantity*$VAT_types_description/100);
			$total12=$tax+$temp1x12;  $temp1x12=$total12;
}}}}			
			}	
	}}}} 
		}
		else{
	
	
		} } } ?><br>
        <?php
		if ($trr1!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' January Total Sales Made:'.$trr1.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items1.'<br>'; ?></strong>
         <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total211.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total1.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr1-$total211).'<br>'; ?> </strong>
         
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr2!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' February Total Sales Made:'.$trr2.'<br>'; ?></strong>
                <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items2.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total2.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total22.'<br>'; ?></strong>
       <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr2-$total22).'<br>'; ?> </strong>      
	<?php 	 echo'----------------------------------------------------------------------------------------------------------------------------<br>
';}
		?>
          <?php
		if ($trr3!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' March Total Sales Made:'.$trr3.'<br>'; ?></strong>
              <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items3.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total3.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total23.'<br>'; ?></strong>
            <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr3-$total23).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr4!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' April Total Sales Made:'.$trr4.'<br>'; ?></strong>
              <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items4.'<br>'; ?></strong>
         <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total4.'<br>'; ?></strong>
         <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total24.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr4-$total24).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr5!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' May Total Sales Made:'.$trr5.'<br>'; ?></strong>
              <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items5.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total5.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total25.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr5-$total25).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr6!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' June Total Sales Made:'.$trr6.'<br>'; ?></strong>
             <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items6.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total6.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total26.'<br>'; ?></strong>
            <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr6-$total26).'<br>'; ?> </strong>
	<?php echo'----------------------------------------------------------------------------------------------------------------------------<br>
';}
		?>
          <?php
		if ($trr7!=""){
	echo '<strong>CC'.$items7.'</strong>';	?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' July Total Sales Made:'.$trr7.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items7.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total7.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total27.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr7-$total27).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr8!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' August Total Sales Made:'.$trr8.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items8.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total8.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total28.'<br>'; ?></strong>
         <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr8-$total28).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr9!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' September Total Sales Made:'.$trr9.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items9.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total9.'<br>'; ?></strong>
            <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total29.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr9-$total29).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr10!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' October Total Sales Made:'.$trr10.'<br>'; ?></strong>
             <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items10.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total10.'<br>'; ?></strong>
          <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total210.'<br>'; ?></strong>
         <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr10-$total210).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
          <?php
		if ($trr11!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' November Total Sales Made:'.$trr11.'<br>'; ?></strong>
            <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items11.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total11.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total211.'<br>'; ?></strong>
           <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr11-$total211).'<br>'; ?> </strong>
	<?php 	 echo'----------------------------------------------------------------------------------------------------------------------------<br>
';}
		?>
          <?php
		if ($trr12!=""){
		?>
		 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' December Total Sales Made:'.$trr12.'<br>'; ?></strong>
              <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Items Sold:'.$items12.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;"> <?php echo ' Total Tax 16%:'.$total12.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total212.'<br>'; ?></strong>
        <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:15px; width:auto;">  <?php echo 'Total Profit:'.($trr12-$total212).'<br>'; ?> </strong>
	<?php  echo'----------------------------------------------------------------------------------------------------------------------------<br>
';	}
		?>
 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px;  color:#0099FF; width:auto;"> <?php if($trr!=""){echo 'Sales Made For the Year '. date('20y').' for '.$till_name.'<br>
Total Sales'.$trr.'<br>'; ?>
 <strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF; width:auto;">  <?php echo 'Total Cost of Sold Items:'.$total21.'<br>'; ?>
 
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF; width:auto;">  <?php echo 'Total Profit:'.($trr-$total21).'<br>'; 
 ?>
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF; width:auto;">  <?php echo 'Total Tax 16%:'.$total.'<br>';
 ?>
<strong style="font-family:'Lucida Sans Unicode', 'Lucida Grande', sans-serif; font-size:20px; color:#0099FF;width:auto;">  <?php echo 'Total Net Profit:'.(($trr-$total2)-$total).'(profit after tax deduction)<br>';
 }
else{ 
echo 'No Sale Made on This Till'; }?> </strong></strong></strong></strong> </strong></div> <?php }
 
		}?>
</div>
</div>
</div>
</div>
</body>
</html>
