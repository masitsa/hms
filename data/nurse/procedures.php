<?php 
session_start();

include '../../classes/class_nurse.php';

//$search = $_GET['search'];//the user is has requested to search
$order = $_GET["order"];
$v_id = $_GET['visit_id'];
$sql1 = "SELECT visit_type, visit_id FROM visit WHERE visit_id = '$v_id'";
//echo $sql1;
$v_type = new Database();
$rs21 =$v_type->select($sql1);
$num_type= mysql_num_rows($rs21);
$visit_t = mysql_result($rs21, 0 ,"visit_type");

if($_REQUEST['search']){
	$search = $_POST['item'];
	$v_id = $_POST['visit_id'];
if(!isset($order)){
	$order = "service_charge_name";
}
$procedures1 = new nurse;
	$rs9 = $procedures1->search_procedures($order, $search,$visit_t );
	$num_rows9 = mysql_num_rows($rs9);
}
else{
	if(!isset($order)){
	$order = "service_charge_name";
}
	$procedures1 = new nurse;
	$rs9 = $procedures1->get_procedures($order,$visit_t );
	$num_rows9 = mysql_num_rows($rs9);
	//echo "HERE";
}
	//paginate the items
	$pages1 = intval($num_rows9/10);
	$pages2 = $num_rows9%(2*10);
	
	if($pages2 == NULL){//if there is no remainder
	
		$num_pages = $pages1;
	}

	else{
	
		$num_pages = $pages1 + 1;
	}

	$current_page = $_GET['id'];//if someone clicks a different page

	if($current_page < 1){//if different page is not clicked
	
		$current_page = 1;
	}

	else if($current_page > $num_pages){//if the next page clicked is more than the number of pages
	
		$current_page = $num_pages;
	}

	if($current_page == 1){
	
		$current_item = 0;
	}

	else{

		$current_item = ($current_page-1) * 10;
	}

	$next_page = $current_page+1;

	$previous_page = $current_page-1;

	$end_item = $current_item + 10;

	if($end_item > $num_rows9){
	
		$end_item = $num_rows9;
	}
	
	//$first_id = mysql_result($rs9, $current_item, "procedure_id");	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
 
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
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css" media="screen" />
	<title>Vitals</title>
    <script type="text/javascript" src="../../js/script.js"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery.js'?>'></script>
	<script type="text/javascript" src="<?php echo '../../js/jquery-1.7.1.min.js'?>"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery-ui-1.8.18.custom.min.js'?>'></script>
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
			<p><a href="http://www.strathmore.edu">procedures</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    	<table align="center" border="0">
        	<tr>
                    <td>
                        <form class="form-search" action="procedures.php?visit_id=<?php echo $v_id?>"  method="post" >
                        	<input type="text" class="input-medium search-query" id="item_name" name="item">
                        	<input type="hidden" value="<?php echo $v_id?>" name="visit_id">
                            <input type="submit" class="btn" value="Search" name="search"/>
    					</form>
                    </td>
            </tr>
        </table>
    </div>
       <div>
        <table>
<?php if(!empty($search)){	?>   
<table border="0" class="table table-hover table-condensed">
            	<thead>
                	<th><a href="procedures.php?order=procedures&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Procedure</a></th>
                	<th><a href="procedures.php?order=students&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Cost</a></th>
                	
                </thead>
                
             <?php 
		 //echo "current - ".$current_item."end - ".$end_item;
			
		for($s = $current_item; $s < $end_item; $s++){
		
		$procedure_id = mysql_result($rs9, $s, "service_charge_id");
		$proced = mysql_result($rs9, $s, "service_charge_name");
    $visit_type = mysql_result($rs9, $s, "visit_type_id");
    
    $stud = mysql_result($rs9, $s, "service_charge_amount");

	?>
        	<tr>
       <td></td>
        		
                <td>
           
                <?php $suck=1; ?>
               <a href="#" onClick="procedures(<?php echo $procedure_id?>,<?php echo $v_id?>,<?php echo $suck; ?>)"><?php echo $proced?> </a></td>
              
                <td><?php echo $stud?></td>

                
                 
        	</tr>
         <?php }?>
        </table>
    <?php }
	
	else { ?>
    
    
<table border="0" class="table table-hover table-condensed">
            	<thead> 
                <th> </th>
                	<th><a href="procedures.php?order=procedures&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Procedure</a></th>
                	<th><a href="procedures.php?order=students&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Cost</a></th>
                	
                </thead>
                
             <?php 
		 //echo "current - ".$current_item."end - ".$end_item;
			
		for($s = $current_item; $s < $end_item; $s++){
		
		$procedure_id = mysql_result($rs9, $s, "service_charge_id");
		$proced = mysql_result($rs9, $s, "service_charge_name");
    $visit_type = mysql_result($rs9, $s, "visit_type_id");
    
    $stud = mysql_result($rs9, $s, "service_charge_amount");

	?>
        	<tr>
       <td></td>
        		
                <td> <?php $suck=1; ?>                
				<a href="#" onClick="procedures(<?php echo $procedure_id?>,<?php echo $v_id?>,<?php echo $suck; ?>)"><?php echo $proced?> </a></td><td><?php echo $stud?></td>
	</tr>
         <?php }?>
        </table>
    <?php 
      }?>
        <div class="pagination" style="margin-left:20%;">
    		<ul>
   				<li><a href="procedures.php?id=<?php echo $previous_page; ?>&search=<?php echo $search?>&order=<?php echo $order?>&visit_id=<?php echo $v_id?>">Prev</a></li>
            <?php
            
				for($t = 1; $t <= $num_pages; $t++){
					echo '<li><a href="procedures.php?id='.$t.'&order='.$order.'&search='.$search.'&visit_id='.$v_id.'">'.$t.'</a></li>';
				}
			
			?>
    			
                <li><a href="procedures.php?id=<?php echo $previous_page; ?>&search=<?php echo $search?>&order=<?php echo $order?>&visit_id=<?php echo $v_id?>">Next</a></li>
    		</ul>
    	</div>
</body>
</html>
