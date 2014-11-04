<?php
session_start();
include '../../classes/Reports.php';

$type="";
$payment_method="";
if($_REQUEST['search']){

	$date1=$_POST['date'];	
	$date2=$_POST['finishdate'];
	
	$get1 = new reports;
	$rs_voucher = $get1->cash_expenses_report($date1, $date2);
	$num_rows_voucher = mysql_num_rows($rs_voucher);
}
else {
	$date1 = "";
	$date2 = "";

	$get1 = new reports;
	$rs_voucher = $get1->expense_single_report();
	$num_rows_voucher = mysql_num_rows($rs_voucher);
}
?><html>
<head>
	
	<title>Expenses</title>
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
</head>
<body>
 <div id="header" class="container">
    	<div id="logo">
	    <h1><a href="#">SUMC</a></h1>
			<p><a href="http://www.strathmore.edu">Cash</a></p>
		</div>
	</div>
	<!-- end #header -->
	<div class="row-fluid">
    
    	<h3 class="page_title"> Expenses Report  </h3>
    		<form action="expenses.php" method="post" name="reports">
    			<table class="table table-striped">
    				<tr>
						<tH>FILTER BY: </tH>
    					<td>Start Date:	<input type="text" id="datepicker" name="date"  autocomplete="off"/></td>
						<td>Finish Date:<input type="text" id="datepicker1" name="finishdate"  autocomplete="off" /></td>
 						<td><input type="submit" name="search" id="submit" class="btn btn-primary" value="Filter"/> <td>
                        <td><a href="../pdfs/expenses.php?date1=<?php echo $date1?>&date2=<?php echo $date2?>" class="btn btn-success">Print</a> <td>
					</tr>
				</table>
   
    		</form>
            <table class="table table-striped table-condensed table-hover table-bordered">
                <tr>
                    <th > <?php echo 'Date'; ?></th> 
                    <th > <?php echo 'Recipient'; ?></th> 
                    <th > <?php echo 'Reason'; ?></th> 
                    <th > <?php echo 'Amount'; ?></th> 
                </tr>
 <?php
$total = 0;
 
for($x=0; $x<$num_rows_voucher; $x++){
	$id = mysql_result($rs_voucher, $x, "personnel_id");
	$amount = mysql_result($rs_voucher, $x, "amount");
	$recipient = mysql_result($rs_voucher, $x, "recipient");
	$reason = mysql_result($rs_voucher, $x, "reason");
	$date1 = mysql_result($rs_voucher, $x, "date");	
?>

    <tr>
    
        <td > <?php echo $date1; ?></td> 
        <td > <?php echo $recipient; ?></td> 
        <td > <?php echo $reason; ?></td> 
        <td > <?php echo $amount; ?></td> 
    </tr>	 
<?php	
$total += $amount;
}
?> 
     <tr>
<td> <strong> TOTAL EXPENSES</strong></td> <td >  </td>  <td >  </td>  

  <td > <?php echo '<strong>'. $total.'</strong>'; ?></td> 
  
    </tr>
    </table>


 </div>
  </div>
  </div>
  </div>
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