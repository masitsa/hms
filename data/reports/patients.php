<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../../classes/Reports.php';
include '../../classes/strathmore_population.php';

/*
	-----------------------------------------------------------------------------------------
	Set the visit date. If not set assign to the current day
	-----------------------------------------------------------------------------------------
*/
if(!isset($_POST['visit_date'])){
	$visit_date = '2013-10-14';//date('Y-m-d');
}

/*
	-----------------------------------------------------------------------------------------
	Select patient totals
	@param visit_date
	-----------------------------------------------------------------------------------------
*/
$gets = new reports;
$rs = $gets->get_patient_visit_summary($visit_date);
$num_visits = mysql_num_rows($rs);

/*
	-----------------------------------------------------------------------------------------
	Initialize all patient visits to 0
	-----------------------------------------------------------------------------------------
*/
$staff = 0;
$students = 0;
$insurance = 0;
$cash = 0;
$other = 0;

if($num_visits > 0)
{
	for($r = 0; $r < $num_visits; $r++)
	{
		$patient = mysql_result($rs, $r, "visit_type");
		/*
			-----------------------------------------------------------------------------------------
			count the number of a particular patient type
			1 student
			2 staff
			3 cash
			4 insurance
			-----------------------------------------------------------------------------------------
		*/
		if($patient == 1)
		{
			$student++;
		}
		
		else if($patient == 2)
		{
			$staff++;
		}
		
		else if($patient == 3)
		{
			$cash++;
		}
		
		else if($patient == 4)
		{
			$insurance++;
		}
		else
		{
			$other++;
		}
	}
}

$patients = '
<table class="table table-striped table-condensed table-hover table-bordered">
	<tr>
		<th>Visit Date</th>
		<th>Patient Type</th>
		<th>Surname</th>
		<th>Other Names</th>
		<th>Strath No.</th>
	</tr>';

if($num_visits > 0)
{
	/*
		-----------------------------------------------------------------------------------------
		Create patients array
		-----------------------------------------------------------------------------------------
	*/
	for($r = 0; $r < $num_visits; $r++)
	{
		$visit_date = mysql_result($rs, $r, "visit_date");
		$patient_surname = mysql_result($rs, $r, "patient_surname");
		$patient_othernames = mysql_result($rs, $r, "patient_othernames");
		$visit_type_id = mysql_result($rs, $r, "visit_type");
		$strath_no = mysql_result($rs, $r, "strath_no");
		$visit_type_name = mysql_result($rs, $r, "visit_type_name");
		
		if($visit_type_id < 3){
			
			//student
			if($visit_type_id == 1)
			{
				$get = new Strathmore_population;
				$student_ = $get->get_students($strath_no);
				$num_student = mysql_num_rows($student_);
				
				if($num_student > 0)
				{
					$patient_surname = mysql_result($student_, 0, "Surname");
					$patient_othernames = mysql_result($student_, 0, "Other_names");
				}
				
				else
				{
					$patient_surname = '-';
					$patient_othernames = '-';
				}
			}
			
			//staff
			else if($visit_type_id == 2)
			{
				$get = new Strathmore_population;
				$staff_ = $get->get_staff($strath_no);
				$num_staff = mysql_num_rows($staff_);
				
				if($num_staff > 0)
				{
					$patient_surname = mysql_result($staff_, 0, "Surname");
					$patient_othernames = mysql_result($staff_, 0, "Other_names");
				}
				
				else
				{
					$patient_surname = '-';
					$patient_othernames = '-';
				}
			}
		}
		else{
			$strath_no = '-';
		}
		
		$patients .= 
		'
			<tr>
				<td>'.$visit_date.'</td>
				<td>'.$visit_type_name.'</td>
				<td>'.$patient_surname.'</td>
				<td>'.$patient_othernames.'</td>
				<td>'.$strath_no.'</td>
			</tr>
		';
	}
	
	$patients .= '</table>';
}

else
{
	$patients = "There are no patients";
}


?>
<html>
<head>
	<link type="text/css" rel="stylesheet" href="../../css/bootstrap.css" />
 	<link type="text/css" rel="stylesheet" href="../../css/jquery-ui-1.8.18.custom.css" />
    <link type="text/css" rel="stylesheet" href="../../css/jquery.ui.timepicker.css"/>
	<link rel="stylesheet" href="../../css/head.css" type="text/css" media="screen" />
    <script type="text/javascript" src="../../js/script.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.timepicker.js"></script>
	<script type="text/javascript" charset="utf-8">

	$(function(){
				
				//date picker
				$( "#datepicker" ).datepicker();
				$( "#format" ).change(function() {
					$( "#datepicker" ).datepicker( "option", "dateFormat", $( this ).val() );
				});
				
				$('#timepicker').timepicker();
			});
  $(document).ready(function() {
                $('#timepicker_start').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpStartOnHourShowCallback,
                    onMinuteShow: tpStartOnMinuteShowCallback
                });
                $('#timepicker_end').timepicker({
                    showLeadingZero: false,
                    onHourShow: tpEndOnHourShowCallback,
                    onMinuteShow: tpEndOnMinuteShowCallback
                });
            });

            function tpStartOnHourShowCallback(hour) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                // all valid if no end time selected
                if ($('#timepicker_end').val() == '') { return true; }
                // Check if proposed hour is prior or equal to selected end time hour
                if (hour <= tpEndHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpStartOnMinuteShowCallback(hour, minute) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
                // all valid if no end time selected
                if ($('#timepicker_end').val() == '') { return true; }
                // Check if proposed hour is prior to selected end time hour
                if (hour < tpEndHour) { return true; }
                // Check if proposed hour is equal to selected end time hour and minutes is prior
                if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }

            function tpEndOnHourShowCallback(hour) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                // all valid if no start time selected
                if ($('#timepicker_start').val() == '') { return true; }
                // Check if proposed hour is after or equal to selected start time hour
                if (hour >= tpStartHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpEndOnMinuteShowCallback(hour, minute) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
                // all valid if no start time selected
                if ($('#timepicker_start').val() == '') { return true; }
                // Check if proposed hour is after selected start time hour
                if (hour > tpStartHour) { return true; }
                // Check if proposed hour is equal to selected start time hour and minutes is after
                if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
			}
		function closeit(val){
    		window.opener.document.forms['myform'].elements['passed_value'].value=val;
    		window.close(this);
		}
        </script>
	<title>Patients</title>
    <style type="text/css">
		.span3 a.thumbnail{text-align: center;}
		.span3 a.thumbnail:hover{text-decoration:none;}
	</style>
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">Patients Report</a></p>
		</div>
	</div>
	<!-- end #header -->
    <h3 class="page_title"> Patients Report  </h3>
    <div class="row-fluid">
        <div class="span3">
            <a href="#" class="thumbnail">
                <h4>Staff</h4>
                <?php echo $staff;?>
            </a>
        </div>
        <div class="span3">
            <a href="#" class="thumbnail">
                <h4>Students</h4>
                <?php echo $student;?>
            </a>
        </div>
        <div class="span3">
            <a href="#" class="thumbnail">
                <h4>Insurance</h4>
                <?php echo $insurance;?>
            </a>
        </div>
        <div class="span3">
            <a href="#" class="thumbnail">
                <h4>Cash</h4>
                <?php echo $cash;?>
            </a>
        </div>
    </div>
        
	<div class="row-fluid">
        <div class="span12">
             <?php echo $patients;?>
        </div>
	</div>
 </div>
</div>
<!-- end wrapper -->
				<div id="footer">
					<p>Copyright &copy; 2012 Sitename.com. All rights reserved. Design by <a href="http://www.freecsstemplates.org">james brian studio</a>.</p>
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