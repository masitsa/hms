<?php
$mysql_hostname = "localhost";
$mysql_user = "kamakazi_user";
$mysql_password = "kazi@1001";
$mysql_database = "kamakazi_db";

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $bd) or die("Opps some thing went wrong");



//$user_check=$_SESSION['login_user'];
$user_check=$user["id"];
//echo $user_check;
$ses_sql=mysql_query("select username from users where id='$user_check' ");

$row=mysql_fetch_array($ses_sql);

$login_session=$row['username'];

$link = mysql_connect("localhost", "kamakazi_user", "kazi@1001");
mysql_select_db("kamakazi_db", $link);

$job=$_GET['name_job'];
$proff=$_GET['proff'];
/**$result = mysql_query("SELECT * FROM table1", $link);**/

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta https-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Grid Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="grid.css" rel="stylesheet">

  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="https://kamakazi.co.ke/fb/fbn/login/kamakazi10.gif">  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://www.kamakazi.co.ke/bootstrap-3.1.1/docs/dist/js/bootstrap.min.js"></script>
    <script src="https://www.kamakazi.co.ke/bootstrap-3.1.1/docs/assets/js/docs.min.js"></script>
     <link href="https://www.kamakazi.co.ke/bootstrap-3.1.1/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="www.kamakazi.co.ke/bootstrap-3.1.1/docs/dist/css/bootstrap-theme.min.css" rel="stylesheet" />

<title>Kamakazi Jobs Board</title>
<link rel="shortcut icon" href="https://kamakazi.co.ke/fb/fbn/login/kamakazi10.gif">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
    .comment {
	  
    height: auto;
 	width: 90%;
	
}
a.morelink {
	text-decoration:none;
	outline: none;
}
.morecontent span {
	display: none;

}		.black_overlay{
			display: none;
			position: fixed;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: fixed;
			top: 25%;
			left: 25%;
			width: 50%;
			height: 50%;
			padding: 16px;
			border: 16px solid gray;
			background-color: white;
			z-index:1002;
			overflow: auto;
		}
		.closed {
			top: 20%;
			left: 20%;
			padding: 16px;
			display: none;
			float:left;
			position: fixed;
			background-color: white;
			z-index:1002;
			overflow: auto;
		}
		.black_overlay_hints{
			display: block;
			position: fixed;
			float:right;
			margin-top:10%;
			top: 10%;
			margin-left: 70%;
			width: 30%;
			max-height: 70%;
			min-height: 40%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}   
		 </style>
    
    
  </head>

  <body>

    
    <div class="container" >     
   <div class="navbar navbar-inverse navbar-fixed-top" style="margin-left:2%;margin-right:2%; margin-bottom :2%; width:90%;">
 
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Use another Account</a></li>
              <li><a href="https://kamakazi.co.ke/employee/index">Update Profile</a></li>
              <li><a href="https://kamakazi.co.ke/user/signup">Create Account</a></li>
              <li><a href="https://podio.com/webforms/6917147/533221">Post a Job</a></li>
             <li><a  class="btn btn-lg btn-primary" href="https://kamakazi.co.ke/fb_app/fb/fbn/index5.php">Register Here To Recieve </br> Facebook Job Notification</a></li>
               </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
</br> </br></br> </br></br> </br>
<div id="close" class="closed"> <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';
document.getElementById('close').style.display='none';document.getElementById('fade').style.display='none'">Close</a></div>

		<div id="light" class="white_content navbar-fixed-top"> </div>
		<div id="fade" class="black_overlay navbar-fixed-top"></div>
     <div class="container">
<form action="columns.php" method="get" style="float:left; margin-left:3% ;">
  <label style="float:left; margin-left:3% font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size:16px;">Job Title  </label><input type="text" name="name_job" class="input"  id="name_job">

 <select id="proff" name="proff" class="drop" >
 <option value="0">---Search All Professions----</option>
<?php 
	$sql1= mysql_query("SELECT * FROM `professions`");
	while ($row = @ mysql_fetch_array($sql1)){				
	$title=$row['title'];				
	$title_id=$row['id'];
	?>
 <option  value="<?php echo $title_id; ?>"><?php echo $title; ?></option>
	
	 <?php
	 }   ?>
	 
 </select> 
	<input type="submit" class="btn btn-lg btn-primary" style="float:left" name="search" id="search" value="  Search  " >
  </form></br>
  <?php
if(($job=="")&&($proff=="")){
$date=date("20y-m-d");
$sql1="SELECT * FROM `vacancies` WHERE `vacancy_first_date` <= '$date' and `vacancy_last_date` >='$date' order by vacancies_id DESC";
//echo $sql1;
$rs=mysql_query($sql1,$link);
}
elseif(($job!="")&&($proff!=0)){ //job is not null proff is not null
$date=date("20y-m-d");
$sql1="SELECT * FROM `vacancies` WHERE `vacancy_description` LIKE '%$job%' and `id` = '$proff' and `vacancy_first_date` <= '$date' and `vacancy_last_date` >='$date' order by vacancies_id DESC";
//echo $sql1;
$rs=mysql_query($sql1,$link);
}
elseif(($job=="")&&($proff!=0)){ //job is null but proff is not
$date=date("20y-m-d");
$sql1="SELECT *
FROM `vacancies` WHERE `id` = '$proff' and `vacancy_first_date` <= '$date' and `vacancy_last_date` >='$date' order by vacancies_id DESC";
//echo $sql1;
$rs=mysql_query($sql1,$link);
}
elseif(($job!="")&&($proff==0)){ //job not null but proff is
$date=date("20y-m-d");
$sql1="SELECT *
FROM `vacancies` WHERE `vacancy_description` LIKE '%$job%' and `vacancy_first_date` <= '$date' and `vacancy_last_date` >='$date' order by vacancies_id DESC";
//echo $sql1;
$rs=mysql_query($sql1,$link);
}
else {
$date=date("20y-m-d");
$sql1="SELECT * FROM `vacancies` WHERE `vacancy_first_date` <= '$date' and `vacancy_last_date` >='$date' order by vacancies_id DESC";
//echo $sql1;
$rs=mysql_query($sql1,$link);
}
  $num_rows = mysql_num_rows($rs);
  if ($num_rows==0){
  ?>
  <div class="comment more">
  </br>
  </br>
  </br>
<?php 
 if ($job=="") {
  ?>
  <h2 style="font:175%;"> No results  <?php echo $job; ?> Found!! </h2>
  <?php
  }
   else{
  ?>
    <h2 style="font:175%;"> No results For  <?php echo $job; ?> Found!! </h2>
  <?php
  }
  ?>
  </div>
  
  <?php
  }
 
 ?>
  </br></br></br>
        <hr>
          <div class="black_overlay_hints" style="margin-top:10%;">
       <div style="background:linear-gradient(#F6D31B, #DBC040) repeat scroll 0 0 rgba(0, 0, 0, 0); color:#FFF; cursor:pointer;" onclick="create_pop('1');" class="btn btn-lg btn-primary">  Why you must apply now! </div> <br> <br>  
        <div style="background:linear-gradient(#F6D31B, #DBC040) repeat scroll 0 0 rgba(0, 0, 0, 0); color:#FFF; cursor:pointer;" onclick="create_pop('2');"class="btn btn-lg btn-primary"> Keep it Relevant </div>
       <br> <br>
          <div style="background:linear-gradient(#F6D31B, #DBC040) repeat scroll 0 0 rgba(0, 0, 0, 0); color:#FFF; cursor:pointer;" onclick="create_pop('3');" class="btn btn-lg btn-primary">   The One Page CV </div> 
   <br> <br>  
    <div style="background:linear-gradient(#F6D31B, #DBC040) repeat scroll 0 0 rgba(0, 0, 0, 0); color:#FFF; cursor:pointer;" onclick="create_pop('4');"class="btn btn-lg btn-primary">  Be in it to win it </div>
   <br> <br>
             
</div> 
  <?php
  for($u = 0; $u < $num_rows; $u++){
  
	$vacancy_description=  mysql_result($rs, $u, "vacancy_description");
	$vacancy_first_date =  mysql_result($rs, $u, "vacancy_first_date");
	$vacancy_last_date =  mysql_result($rs, $u, "vacancy_last_date");
	$vacancy_name =  mysql_result($rs, $u, "vacancy_name");
	$vacancies_id =  mysql_result($rs, $u, "vacancies_id");
$sql2="SELECT * FROM `vacancies_interest` WHERE `user_id` = $user_check and  vacancies_id =$vacancies_id ";
  $rs2=mysql_query($sql2,$link);
 //echo $sql2;
  ?>
<h3> <h2><?php echo $vacancy_name;?>  ...........<input type="button" href="#creation<?php echo $vacancies_id ?>" onclick="pops('<?php echo $vacancies_id ?>');"  class="btn btn-primary" name="submit" id="submit" value="Apply" > </h3>
 <div class="row">
        <div class="col-md-8">
        
	<div class="comment more" style="margin-left:2%;">
	<div class="fb-like" data-href="https://apps.facebook.com/kamakaziafrica/" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div></h2> 
<div id="creation<?php echo $vacancies_id ?>" class="col-sm-5" style="position:absolute; margin-left:40%; margin-top:-10%; display:none;">

          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><a href="#creation<?php echo $vacancies_id ?>" onclick="pops('<?php echo $vacancies_id ?>');"> <image src="https://kamakazi.co.ke/bootstrap-3.1.1/docs/examples/apply_popup/Button%20Close-01.png" title="Close" style="float:right; margin-top:-2%;"></a> </br></h3>
            </div>
            <div class="panel-body">
             <strong> <h3> You Are About Apply For <?php echo $vacancy_name;?></h3>
             <a href="https://podio.com/webforms/7728054/583640"> <input type="button"   class="btn btn-primary" name="submit" id="submit" value="Proceed" > </a>
             </strong>
            </div>
          </div>
        </div></br>
	<?php
	echo $vacancy_description ;
	?>
	 </div>

</div>
      
      </div>
        <hr>
 <?php
    }
    ?> </div>

<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script> 
    function create_pop(x){
    document.getElementById('light').style.display='block';
     document.getElementById('close').style.display='block';
    document.getElementById('fade').style.display='block'
     if (x==1){
       
      $('#light').html('<img src="http://kamakazi.co.ke/bootstrap-3.1.1/docs/examples/grid/gif-load.gif" />');
    
       setTimeout(function(){$('#light').load('https://kamakazi.co.ke/wp/first-hint/');}, 1000);
    }
    else if (x==2){
     $('#light').html('<img src="http://kamakazi.co.ke/bootstrap-3.1.1/docs/examples/grid/gif-load.gif" />');
    
       setTimeout(function(){$('#light').load('https://kamakazi.co.ke/wp/second-hint/');}, 1000);
    }
    
   else if (x==3){   
   
     $('#light').html('<img src="http://kamakazi.co.ke/bootstrap-3.1.1/docs/examples/grid/gif-load.gif" />');
    
       setTimeout(function(){ $('#light').load('https://kamakazi.co.ke/wp/third-hint/');}, 1000);
    }
      else if (x==4){   
   
   $('#light').html('<img src="http://kamakazi.co.ke/bootstrap-3.1.1/docs/examples/grid/gif-load.gif" />');
    
       setTimeout(function(){ $('#light').load('https://kamakazi.co.ke/wp/fourth-hint/');}, 1000);
    }
    }
    
    
function pops(c){
var xx=c;
var creation='creation';
var creations= creation.concat(c);
var myTarget = document.getElementById(creations);
if(myTarget.style.display == 'none'){
  myTarget.style.display = 'block';
    } else {
  myTarget.style.display = 'none';
  myTarget.value = '';
}

}  

$(document).ready(function() {

	var showChar =1000;  
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			var html = c + '<span class="moreelipses">'+ellipsestext+'</span>&nbsp;<span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">'+moretext+'</a> </span> ';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
});
 </script>
    

   
    </body>
</html>