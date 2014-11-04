<?php
session_start();
include '../../classes/Reports.php';
$summary=$_GET['summary'];

  $temp_jj="";$total_jj=""; 
if(isset($_GET['submit'])) {

$date1=$_GET['date'];	
$date2=$_GET['finishdate'];
$type=$_GET['type'];
$type1=$_GET['type1'];

if($date2==""){
if($type1==""){
	$get = new reports;
$rs = $get->get_single_day_report($date1,$type);
$num_rows = mysql_num_rows($rs);
}
else{
	$get = new reports;
$rs = $get->get_day_insurance_report($type1,$date1);
$num_rows = mysql_num_rows($rs);	
	}
}
elseif($date1==""){

if($type1==""){
	$get = new reports;
$rs = $get->get_single_day_report($date2,$type);
$num_rows = mysql_num_rows($rs);
}
else{
	$get = new reports;
$rs = $get->get_day_insurance_report($type1,$date2);
$num_rows = mysql_num_rows($rs);	
	}	
}	
else {
if($type1==""){
	$get = new reports;
$rs = $get-> get_single_multiple_report($date1,$date2,$type);
$num_rows = mysql_num_rows($rs);
}
else{
	$get = new reports;
$rs = $get->many_days_insurance_report($x,$date1,$date2);
$num_rows = mysql_num_rows($rs);	
	}
		
}}
else{
	
$get = new reports;
$rs = $get->get_all_report();
$num_rows = mysql_num_rows($rs);
	}
?><html>
<head>

<style type='text/css'>

body
{
	margin: 0;
	padding: 0;
	background: #FFFFFF url(../../images/wrapper-bg.png) repeat-x;
	font-family: 'Abel', sans-serif;
	font-size: 16px;
	color: #414141;
}

.clear{
	clear:both;
}

.row-fluid {
  width: 100%;
  *zoom: 1;
}

.row-fluid:before,
.row-fluid:after {
  display: table;
  line-height: 0;
  content: "";
}

.row-fluid:after {
  clear: both;
}

.row-fluid [class*="span"] {
  display: block;
  float: left;
  width: 100%;
  min-height: 30px;
  margin-left: 2.127659574468085%;
  *margin-left: 2.074468085106383%;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
}

.row-fluid [class*="span"]:first-child {
  margin-left: 0;
}

.row-fluid .span12 {
  width: 100%;
  *width: 99.94680851063829%;
}

.row-fluid .span11 {
  width: 91.48936170212765%;
  *width: 91.43617021276594%;
}

.row-fluid .span10 {
  width: 82.97872340425532%;
  *width: 82.92553191489361%;
}

.row-fluid .span9 {
  width: 74.46808510638297%;
  *width: 74.41489361702126%;
}

.row-fluid .span8 {
  width: 65.95744680851064%;
  *width: 65.90425531914893%;
}

.row-fluid .span7 {
  width: 57.44680851063829%;
  *width: 57.39361702127659%;
}

.row-fluid .span6 {
  width: 48.93617021276595%;
  *width: 48.88297872340425%;
}

.row-fluid .span5 {
  width: 40.42553191489362%;
  *width: 40.37234042553192%;
}

.row-fluid .span4 {
  width: 31.914893617021278%;
  *width: 31.861702127659576%;
}

.row-fluid .span3 {
  width: 23.404255319148934%;
  *width: 23.351063829787233%;
}

.row-fluid .span2 {
  width: 14.893617021276595%;
  *width: 14.840425531914894%;
}

.row-fluid .span1 {
  width: 6.382978723404255%;
  *width: 6.329787234042553%;
}

.row-fluid .offset12 {
  margin-left: 104.25531914893617%;
  *margin-left: 104.14893617021275%;
}

.row-fluid .offset12:first-child {
  margin-left: 102.12765957446808%;
  *margin-left: 102.02127659574467%;
}

.row-fluid .offset11 {
  margin-left: 95.74468085106382%;
  *margin-left: 95.6382978723404%;
}

.row-fluid .offset11:first-child {
  margin-left: 93.61702127659574%;
  *margin-left: 93.51063829787232%;
}

.row-fluid .offset10 {
  margin-left: 87.23404255319149%;
  *margin-left: 87.12765957446807%;
}

.row-fluid .offset10:first-child {
  margin-left: 85.1063829787234%;
  *margin-left: 84.99999999999999%;
}

.row-fluid .offset9 {
  margin-left: 78.72340425531914%;
  *margin-left: 78.61702127659572%;
}

.row-fluid .offset9:first-child {
  margin-left: 76.59574468085106%;
  *margin-left: 76.48936170212764%;
}

.row-fluid .offset8 {
  margin-left: 70.2127659574468%;
  *margin-left: 70.10638297872339%;
}

.row-fluid .offset8:first-child {
  margin-left: 68.08510638297872%;
  *margin-left: 67.9787234042553%;
}

.row-fluid .offset7 {
  margin-left: 61.70212765957446%;
  *margin-left: 61.59574468085106%;
}

.row-fluid .offset7:first-child {
  margin-left: 59.574468085106375%;
  *margin-left: 59.46808510638297%;
}

.row-fluid .offset6 {
  margin-left: 53.191489361702125%;
  *margin-left: 53.085106382978715%;
}

.row-fluid .offset6:first-child {
  margin-left: 51.063829787234035%;
  *margin-left: 50.95744680851063%;
}

.row-fluid .offset5 {
  margin-left: 44.68085106382979%;
  *margin-left: 44.57446808510638%;
}

.row-fluid .offset5:first-child {
  margin-left: 42.5531914893617%;
  *margin-left: 42.4468085106383%;
}

.row-fluid .offset4 {
  margin-left: 36.170212765957444%;
  *margin-left: 36.06382978723405%;
}




.row-fluid .offset4:first-child {
  margin-left: 34.04255319148936%;
  *margin-left: 33.93617021276596%;
}

.row-fluid .offset3 {
  margin-left: 27.659574468085104%;
  *margin-left: 27.5531914893617%;
}

.row-fluid .offset3:first-child {
  margin-left: 25.53191489361702%;
  *margin-left: 25.425531914893618%;
}

.row-fluid .offset2 {
  margin-left: 19.148936170212764%;
  *margin-left: 19.04255319148936%;
}

.row-fluid .offset2:first-child {
  margin-left: 17.02127659574468%;
  *margin-left: 16.914893617021278%;
}

.row-fluid .offset1 {
  margin-left: 10.638297872340425%;
  *margin-left: 10.53191489361702%;
}

.row-fluid .offset1:first-child {
  margin-left: 8.51063829787234%;
  *margin-left: 8.404255319148938%;
}

[class*="span"].hide,
.row-fluid [class*="span"].hide {
  display: none;
}

[class*="span"].pull-right,
.row-fluid [class*="span"].pull-right {
  float: right;
}

.icon-white,
.nav-tabs > .active > a > [class^="icon-"],
.nav-tabs > .active > a > [class*=" icon-"],
.nav-pills > .active > a > [class^="icon-"],
.nav-pills > .active > a > [class*=" icon-"],
.nav-list > .active > a > [class^="icon-"],
.nav-list > .active > a > [class*=" icon-"],
.navbar-inverse .nav > .active > a > [class^="icon-"],
.navbar-inverse .nav > .active > a > [class*=" icon-"],
.dropdown-menu > li > a:hover > [class^="icon-"],
.dropdown-menu > li > a:hover > [class*=" icon-"],
.dropdown-menu > .active > a > [class^="icon-"],
.dropdown-menu > .active > a > [class*=" icon-"] {
  background-image: url(../../../img/glyphicons-halflings-white.png);
}

.nav {
  margin-bottom: 20px;
  margin-left: 0;
  list-style: none;
}

.nav > li > a {
  display: block;
}

.nav > li > a:hover {
  text-decoration: none;
  background-color: #5bbed8;
}

.nav > .pull-right {
  float: right;
}

.nav-header {
  display: block;
  padding: 3px 15px;
  font-size: 14px;
  font-weight: bold;
  line-height: 20px;
  color: #022e51;
  text-transform: uppercase;
}

.nav li + .nav-header {
  margin-top: 9px;
}

.nav-list {
  padding-right: 15px;
  padding-left: 15px;
  margin-bottom: 0;
}

.nav-list > li > a,
.nav-list {
  margin-right: -15px;
  margin-left: -15px;
}

.nav-list > li > a {
  padding: 3px 15px;
}

.nav-list > .active > a,
.nav-list > .active > a:hover {
  color: #0CF;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.2);
  background-color: #5bbed8;
}

.nav-list [class^="icon-"] {
  margin-right: 2px;
}

.nav-list .divider {
  *width: 100%;
  height: 1px;
  margin: 9px 1px;
  *margin: -5px 0 5px;
  overflow: hidden;
  background-color: #e5e5e5;
  border-bottom: 1px solid #ffffff;
}

.navbar-inner {
  min-height: 40px;
  padding-right: 20px;
  padding-left: 20px;
  background-color: #fafafa;
  background-image: -moz-linear-gradient(top, #f0f1ec, #d7d7d7);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f0f1ec), to(#d7d7d7));
  background-image: -webkit-linear-gradient(top, #f0f1ec, #d7d7d7);
  background-image: -o-linear-gradient(top, #f0f1ec, #d7d7d7);
  background-image: linear-gradient(to bottom, #f0f1ec, #d7d7d7);
  background-repeat: repeat-x;
  border: 1px solid #d4d4d4;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#f0f1ec', endColorstr='#d7d7d7', GradientType=0);
  *zoom: 1;
  -webkit-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
     -moz-box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
          box-shadow: 0 1px 4px rgba(0, 0, 0, 0.065);
}

.navbar-inner:before,
.navbar-inner:after {
  display: table;
  line-height: 0;
  content: "";
}

.navbar-inner:after {
  clear: both;
}

h1, h2, h3 {
	margin: 0;
	padding: 0;
	letter-spacing: -4px;
	text-transform: lowercase;
	font-family: 'Abel', sans-serif;
	font-weight: 400;
	color: #262626;
}

h1 {
	font-size: 2em;
}

h2 {
	padding-bottom: 20px;
	font-size: 2.8em;
}

h3 {
	font-size: 1.6em;
}

p, ol {
}

ul, ol {

}

a {
	color: #DC483E;
}

a:hover {
}

#wrapper {
	background: #FFFFFF;
}

.container {
	width: 1000px;
	margin: 0px auto;
}

/* Header */

#header {
	width: 960px;
	height: 210px;
	margin: 0px auto 20px auto;
	padding: 0px 20px;
}

/* Logo */

#logo {
	float: left;
	width: 270px;
	height: 210px;
	margin: 0px;
	padding: 0px;
	background:url(../../images/logo-bg.png) no-repeat left top;
	color: #FFFFFF;
}

#logo h1, #logo p {
}

#logo h1 {
	padding: 10px 0px 0px 0px;
	letter-spacing: -2px;
	text-align: center;
	font-size: 4.8em;
}

#logo h1 a {
	color: #FFFFFF;
}

#logo p {
	margin: 0;
	padding: 0px 0 0 0px;
	letter-spacing: -1px;
	text-align: center;
	text-transform: lowercase;
	font-size: 20px;
	color: #FFFFFF;
}

#logo p a {
	color: #FFFFFF;
}

#logo a {
	border: none;
	background: none;
	text-decoration: none;
	color: #000000;
}

#footer {
	overflow: hidden;
	height: 100px;
	background: #1E5148 url(../../images/wrapper-bg.png) repeat;
}

#footer p {
	margin: 0px;
	padding: 40px 0px 0px 0px;
	text-align: center;
	text-transform: lowercase;
	font-size: 16px;
	color: #45776E;
}

#footer a {
	text-decoration: none;
	color: #45776E;
}
</style>
	<link rel="stylesheet" href="../../css/bootstrap.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../../css/reports.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css" media="screen" />
	<title>Summary</title>
    <script type="text/javascript" src="../../js/script.js"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery.js'?>'></script>
	<script type="text/javascript" src="<?php echo '../../js/jquery-1.7.1.min.js'?>"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery-ui-1.8.18.custom.min.js'?>'></script>
       <script src="../../js/jquery.ui.datepicker.js" ></script>
    <script type="text/javascript">
		function closeit(val){
    		window.opener.document.forms['myform'].elements['passed_value'].value=val;
    		window.close(this);
		}
	</script>
    
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">ACCOUNTING</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    <form action="specific.php" method="get" name="reports">
    <table align="center" class="table table-striped">
    <tr  class= "success">
   <td > <h2> General With Summary Report  </h2></td> 
 <td><select id="type" name="type" onChange="check_selection('type','insurance');">
    <option value="all">All</option>  
<?php
$getc =  new reports;
$rsc = $getc->get_visit_type();
$rowsc = mysql_num_rows($rsc);//echo "rows = ".$rows; 
for ($c=0; $c <$rowsc; $c++){	
 	 		
		$visit_type_name = mysql_result($rsc, $c, "visit_type_name");
		$visit_type_id = mysql_result($rsc, $c, "visit_type_id");
?>
 <option value="<?php echo $visit_type_id;?>"> <?php echo $visit_type_name; ?></option>  

<?php	
		
}
?>

</select> 
<?php 
$getd =  new reports;
$rsd = $getd->get_insurances();
$rowsd = mysql_num_rows($rsd);//echo "rows = ".$rows; 

?>
<div id="insurance" style="display:none;">
<select id="type1" name="type1" >
    <option value="">All</option>  
<?php

for ($d=0; $d < $rowsd; $d++){	
 	 		
			$company_insurance_id= mysql_result($rsd, $d, "company_insurance_id");
		$company_insurance_name= mysql_result($rsd, $d, "insurance_company_name");
		
?>
 <option value="<?php echo $company_insurance_id;?>"> <?php echo $company_insurance_name; ?></option>  

<?php	
		
}
?>
</select> 
</div>
</td>
    </tr>
<tr class= "success">
<td>Start Date:
  <input type="text" id="datepicker" name="date"  autocomplete="off"/></td>
	<td>&nbsp;</td>
<td>Finish Date:<input type="text" id="datepicker1" name="finishdate"  autocomplete="off" /></td>
 <td><input type="submit" name="submit" id="submit" class="btn btn-primary" value="SUBMIT"/> <td></tr></table>
   
    </form>
    
<table class="table table-stripped" align="center">
 <tr  class= "success">
  <td > <?php echo 'Patient Type'; ?></td> 
   <td > <?php echo 'Patient Name'; ?></td> 
    <td > <?php echo 'Strath Number/ Insurance Number'; ?></td> 
        <td > <?php echo 'Insurance Name'; ?></td> 
 <td > <?php echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id=mysql_result($rss,$s1, "service_id");
	?>
<td > <?php echo $service_id.'<br>';
echo  $service_name;?></td>     
    <?php
}?>
  
    </tr>
<?php

for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$patient_insurance_number=mysql_result($rs,$a,"patient_insurance_number");


$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
if ($num_rows1!=0){
	$temp1="";$total1="";
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');

$get_patience= new reports;
$rs_pataient= $get_patience->get_patient($patient_id);
$num_patient_rows= mysql_num_rows($rs_pataient);
$patient_surname=mysql_result($rs_pataient,0,'patient_surname');
$patient_othernames=mysql_result($rs_pataient,0,'patient_othernames');
$strath_no=mysql_result($rs_pataient,0,'strath_no');
$dependant_id=mysql_result($rs_pataient,0,'dependant_id');


if($visit_type == 1){
							
		$get2 =  new reports;
		$rs2 = $get2->get_patient_2($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows; 
		
		$name = mysql_result($rs2, 0, "Other_names");
		$secondname = mysql_result($rs2, 0, "Surname");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
	}
						
	else if($visit_type == 2){
			
		$get2 =  new reports;
		$rs2 = $get2->get_patient_3($strath_no);
		//echo $strath_no;	
		$connect = mysql_connect("localhost", "root", "")
                    or die("Unable to connect to MySQL".mysql_error());

        //selecting a database
        mysql_select_db("sumc", $connect)
                    or die("Could not select database".mysql_error()); 
		$sqlq = "select * from patients where strath_no='$strath_no' and dependant_id =0";
		//echo PP.$sqlq;
		$rsq = mysql_query($sqlq)
        or die ("unable to Select ".mysql_error());
		$num_rowsp=mysql_num_rows($rsq);
		
		//echo NUMP.$num_rowsp;
		if(($num_rowsp ==1||$num_rowsp==0)&&($dependant_id==0)){
		$get2 =  new reports;
		$rs2 = $get2->get_patient_3($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		//echo $rows;	
	$name = mysql_result($rs2, 0, "Surname");
		$secondname = mysql_result($rs2, 0, "Other_names");
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "gender");

			
		}
		else{
		$get2 =  new reports;
		$rs2 = $get2->get_patient_4($strath_no);
		$rows = mysql_num_rows($rs2);//echo "rows = ".$rows;
		
		$name = mysql_result($rs2, 0, "names");
		$secondname = '';
		$patient_dob = mysql_result($rs2, 0, "DOB");
		$patient_sex = mysql_result($rs2, 0, "Gender");
		}
	}
	
	else{

		$name = mysql_result($rs_pataient, 0, "patient_othernames");
		$secondname = mysql_result($rs_pataient, 0, "patient_surname");
		$patient_dob = mysql_result($rs_pataient, 0, "patient_date_of_birth");
		$patient_sex = mysql_result($rs_pataient, 0, "gender_id");
	}
//$patient_othernames=mysql_result($rs_pataient,0,'patient_othernames');

?><tr><td class="table-bordered" ><?php if($dependant_id==0){
	echo $visit_name; }
	 else {
	echo $visit_name.'<strong>  DPND  </strong>';
		 }
		  ?> </td><td class="table-bordered"><?php echo $name.'		'.$secondname;?></td> <td class="table-bordered"><?php if($dependant_id==0){
	 echo $strath_no; '<br>';
	 echo $patient_insurance_number ;}
	 else {
		echo $dependant_id; '<br>';
		echo $patient_insurance_number ;
		 }?></td> <td class="table-bordered"><?php if($visit_name=="Insurance"){
$getv = new reports;
$rsv = $getv->get_patient_insurance($patient_insurance_id);
$num_rowsv = mysql_num_rows($rsv);
$patient_insurance_name=mysql_result($rsv,0,"insurance_company_name");	
echo $patient_insurance_name;
}?> </td> <td class="table-bordered"><?php echo $visit_date;?></td><?php
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
?>
<td class="table-bordered">
 <?php
// echo 'TEST'.$service_id1;$sl=0;
$temp="";$total="";
$y="";
for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if($service_id==$service_id1){ 

if($visit_name=="Insurance"){
$get_insurnace = new reports;
$rs_insurnace = $get_insurnace-> get_visit_insurance($patient_insurance_id);
$num_rows_insurnace = mysql_num_rows($rs_insurnace);
$insurance_id=mysql_result($rs_insurnace,0,"company_insurance_id");

$get_insurnace_discounts = new reports;
$rs_insurnace_discounts = $get_insurnace_discounts-> get_insurance_discounts($insurance_id,$service_id);
$num_rows_insurnace_discounts = mysql_num_rows($rs_insurnace_discounts);

for($disc=0; $disc<$num_rows_insurnace_discounts; $disc++){
$percentage = mysql_result($rs_insurnace_discounts, $disc,"percentage");
$amount = mysql_result($rs_insurnace_discounts,  $disc, "amount");
$service_id_disc = mysql_result($rs_insurnace_discounts,  $disc, "service_id");
$discounted_value="";	
		if($percentage==""){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount *$discounted_value*$visit_charge_units;			
	}
		elseif($amount==""){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100)*$visit_charge_units;
		}				
		else{
		$sum=($visit_charge_amount * $visit_charge_units);

		}
	}

	$sum; $total=$sum+$temp;  $temp=$total;
	}
	
	
	else{
	$sum=($visit_charge_amount * $visit_charge_units);	
	$sum; $total=$sum+$temp;  $temp=$total;	
		}

	}
	
else {

	}
}
	

	echo $total;
	//echo  'T'.$service_id;
	?> </td>

<?php
} 
?>	
</tr>
<?php }}
?>
<tr class="alert-info"> <td > <?php echo 'Summary'; ?></td> 
 <td > <?php echo ''; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> <td> </td> </tr>
 <tr> <td > <?php echo '<strong>Insurance</strong>'; ?></td> 
 <td > <?php echo ''; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id_e=mysql_result($rss,$s1, "service_id");
?>
<td class="table-bordered"> 
<?php
$temp1="";$total1="";
$temp="";$total="";	
for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);

if ($num_rows1!=0){
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
// echo 'TEST'.$service_id1;$sl=0;

$y="";

for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 
//get individual the quantity times the price
	$sum1=($visit_charge_amount*$visit_charge_units);
	 /////total up the individual results
	 $total1=$sum1+$temp1;  $temp1=$total1;
	 
	 if($service_id==$service_id1){ 

if($visit_name=="Insurance"){
 $sumx=1;
	 /////total up the individual results
	 $total_jj=$sumx+$temp_jj;  $temp_jj=$total_jj;
	 
$get_insurnace = new reports;
$rs_insurnace = $get_insurnace-> get_visit_insurance($patient_insurance_id);
$num_rows_insurnace = mysql_num_rows($rs_insurnace);
$insurance_id=mysql_result($rs_insurnace,0,"company_insurance_id");

$get_insurnace_discounts = new reports;
$rs_insurnace_discounts = $get_insurnace_discounts-> get_insurance_discounts($insurance_id,$service_id);
$num_rows_insurnace_discounts = mysql_num_rows($rs_insurnace_discounts);

for($disc=0; $disc<$num_rows_insurnace_discounts; $disc++){
$percentage = mysql_result($rs_insurnace_discounts, $disc,"percentage");
$amount = mysql_result($rs_insurnace_discounts,  $disc, "amount");
$service_id_disc = mysql_result($rs_insurnace_discounts,  $disc, "service_id");
$discounted_value="";	
		if($percentage==""){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount *$discounted_value*$visit_charge_units;			
	}

		elseif($amount==""){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100)*$visit_charge_units;
		}				
		else{
		$sum=($visit_charge_amount * $visit_charge_units);

		}
	}
$sum; $total=$sum+$temp;  $temp=$total;
}
	
}
	
	
else {
	 
	 }
}
	
	}

}
}} if($total==""){
	
	$total=0;} ?> <?php echo '<strong>'.$total.'</strong>'; ?>
  </td>

  
  
  <?php	 }?></tr>
   <tr> <td class="table-bordered"> <?php echo '<strong>Student</strong>'; ?></td> 
 <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> <td > <?php //echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id_e=mysql_result($rss,$s1, "service_id");
?>
<td class="table-bordered"> 
<?php
$temp1="";$total1="";
$temp="";$total="";	
for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$patient_insurance_number = mysql_result($rs, $a, "patient_insurance_number");

$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);

if ($num_rows1!=0){
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
// echo 'TEST'.$service_id1;$sl=0;

$y="";

for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 

	 
	 if($service_id==$service_id1){ 

if($visit_name=="Student"){

	$sum=($visit_charge_amount * $visit_charge_units);	
	$sum; $total=$sum+$temp;  $temp=$total; 
	 

}

}
	


}

	
	}

}}} if($total==""){
	
	$total=0;} ?> <?php echo '<strong>'.$total.'</strong>'; ?>
  </td>
  
  
  <?php }?></tr>
  <tr> <td > <?php echo '<strong>Staff</strong>'; ?></td> 
 <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> <td > <?php //echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id_e=mysql_result($rss,$s1, "service_id");
?>
<td class="table-bordered"> 
<?php
$temp1="";$total1="";
$temp="";$total="";	
for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);

if ($num_rows1!=0){
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
// echo 'TEST'.$service_id1;$sl=0;

$y="";

for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 

	 
	 if($service_id==$service_id1){ 

if($visit_name=="Staff"){

	$sum=($visit_charge_amount * $visit_charge_units);	
	$sum; $total=$sum+$temp;  $temp=$total; 
	 

}

}
	


}

	
	}

}}} if($total==""){
	
	$total=0;} ?> <?php echo '<strong>'.$total.'</strong>'; ?>
  </td>
  
  
  <?php }?></tr>
   <tr> <td > <?php echo '<strong>Other</strong>'; ?></td> 
 <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> <td > <?php //echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id_e=mysql_result($rss,$s1, "service_id");
?>
<td class="table-bordered"> 
<?php
$temp1="";$total1="";
$temp="";$total="";	
for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);

if ($num_rows1!=0){
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
// echo 'TEST'.$service_id1;$sl=0;

$y="";

for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 

	 
	 if($service_id==$service_id1){ 

if($visit_name=="Other"){

	$sum=($visit_charge_amount * $visit_charge_units);	
	$sum; $total=$sum+$temp;  $temp=$total; 
	 

}

}
	


}

	
	}

}}} if($total==""){
	
	$total=0;} ?> <?php echo '<strong>'.$total.'</strong>'; ?>
  </td>
  
  
  <?php }?></tr>
 <tr class="alert-info"> <td > <?php echo '<strong>TOTAL</strong>'; ?></td> 
 <td > <?php //echo 'Date'; ?></td>  <td  > <?php //echo 'Date'; ?></td>  <td > <?php //echo 'Date'; ?></td> <td > <?php //echo 'Date'; ?></td> 
 <?php
 $gets = new reports;
$rss = $gets->services();
$num_rowss = mysql_num_rows($rss);	

for($s1=0; $s1<$num_rowss; $s1++){
	//echo $s1;
$service_name=mysql_result($rss,$s1, "service_name");
$service_id_e=mysql_result($rss,$s1, "service_id");
?>
<td class="table-bordered"> 
<?php
$temp1="";$total1="";
$temp="";$total="";	
for($a=0; $a<$num_rows; $a++){

$patient_id=mysql_result($rs,$a, "patient_id");
$visit_type=mysql_result($rs,$a, "visit_type");
$visit_id=mysql_result($rs,$a, "visit_id");
$visit_date=mysql_result($rs,$a, "visit_date");
$patient_insurance_id=mysql_result($rs,$a,"patient_insurance_id");
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);

if ($num_rows1!=0){
$getd1 = new reports;
$rsd1 = $getd1-> visit_type($visit_type);
$num_rowsd1 = mysql_num_rows($rsd1);
$visit_name= mysql_result($rsd1,0,'visit_type_name');
$get1 = new reports;
$rs1 = $get1-> visit_charge_items($visit_id);
$num_rows1 = mysql_num_rows($rs1);
$get3 = new reports;
$rs3 = $get3-> services();
$num_rows3 = mysql_num_rows($rs3);


for($c=0; $c<$num_rows3; $c++){
$service_id1=mysql_result($rs3,$c, 'service_id');
// echo 'TEST'.$service_id1;$sl=0;

$y="";

for($b=0; $b<$num_rows1; $b++){
	$visit_charge_amount=mysql_result($rs1,$b, 'visit_charge_amount');
	$visit_charge_units=mysql_result($rs1,$b, 'visit_charge_units');
	$service_charge_id=mysql_result($rs1,$b, 'service_charge_id');
	$visit_id1=mysql_result($rs1,$b, 'visit_id');
	$service_id=mysql_result($rs1,$b, 'service_id');
 $y++;
if(($service_id_e==$service_id1)&&($service_id_e==$service_id)){ 
//get individual the quantity times the price
	$sum1=($visit_charge_amount*$visit_charge_units);
	 /////total up the individual results
	 $total1=$sum1+$temp1;  $temp1=$total1;
	 
	 if($service_id==$service_id1){ 

if($visit_name=="Insurance"){
$get_insurnace = new reports;
$rs_insurnace = $get_insurnace-> get_visit_insurance($patient_insurance_id);
$num_rows_insurnace = mysql_num_rows($rs_insurnace);
$insurance_id=mysql_result($rs_insurnace,0,"company_insurance_id");

$get_insurnace_discounts = new reports;
$rs_insurnace_discounts = $get_insurnace_discounts-> get_insurance_discounts($insurance_id,$service_id);
$num_rows_insurnace_discounts = mysql_num_rows($rs_insurnace_discounts);

for($disc=0; $disc<$num_rows_insurnace_discounts; $disc++){
$percentage = mysql_result($rs_insurnace_discounts, $disc,"percentage");
$amount = mysql_result($rs_insurnace_discounts,  $disc, "amount");
$service_id_disc = mysql_result($rs_insurnace_discounts,  $disc, "service_id");
$discounted_value="";	
		if($percentage==""){
			$discounted_value=$amount;	
		$sum = $visit_charge_amount *$discounted_value*$visit_charge_units;			
	}
		elseif($amount==""){
			$discounted_value=$percentage;
			$sum = $visit_charge_amount *((100-$discounted_value)/100)*$visit_charge_units;
		}				
		else{
		$sum=($visit_charge_amount * $visit_charge_units);

		}
	}
$sum; $total=$sum+$temp;  $temp=$total;
}
	else{
	$sum=($visit_charge_amount * $visit_charge_units);	
	$sum; $total=$sum+$temp;  $temp=$total;
		}
	
	
}
	
	
else {
	
	}
}
	

//	echo $total;
	
	}

}}}  echo '<strong>'.$total.'</strong>'; ?>
  </td><?php }?></tr>
</table>
 </div>
  </div>
  </div>
  </div>
  </body>
</html>
 <script type="text/javascript" charset="utf-8">
	$(function(){
				$('#datepicker').datepicker({
					inline: true
				});
				
	});
	$(function(){
	$('#datepicker1').datepicker({
					inline: true
				});
	});
 </script>