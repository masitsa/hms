<?php session_start();

include '../../classes/class_nurse.php';

$patient_id = $_GET['patient_id'];

$get_diagnosis = new nurse();
$get_diagnosis_rs = $get_diagnosis->get_previous_diagnosis($patient_id);
$num_rows = mysql_num_rows($get_diagnosis_rs);

		
	//paginate the items
	$pages1 = intval($num_rows/40);
	$pages2 = $num_rows%(2*40);

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
	
	else if($current_page > $num_pages){
	
		$current_page = $num_rows-1;
	}

	if($current_page > $num_pages){//if the next page clicked is more than the number of pages
	
		$current_page = $num_pages;
	}

	if($current_page == 1){
	
		$current_item = 0;
	}

	else{

		$current_item = ($current_page-1) * 40;
	}

	$next_page = $current_page+1;

	$previous_page = $current_page-1;

	$end_item = $current_item + 40;

	if($end_item > $num_rows){
	
		$end_item = $num_rows;
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

	<link rel ="stylesheet" type ="text/css" href="../../administration/css/twoColLiqLtHdr.css"/>
	<link type="text/css" href="../../administration/css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
	<link type='text/css' href='../../administration/css/demo.css' rel='stylesheet' media='screen' />
	<link type='text/css' href='../../administration/css/contact.css' rel='stylesheet' media='screen' />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>SUMC | Rooms Management</title>
	<script type="text/javascript" src="../../administration/js/jquery.js"></script>
	<script type="text/javascript" src="../../administration/js/script.js"></script>
	<script type="text/javascript" src="../../administration/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="../../administration/js/jquery-ui-1.8.18.custom.min.js"></script>
	<script type='text/javascript' src='../../administration/js/jquery.simplemodal.js'></script>
	<script type='text/javascript' src='../../administration/js/contact.js'></script>
	<script type="text/javascript" charset="utf-8">

			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3" });

				//Autocomplete
				$("#autocomplete").autocomplete({
					source: [<?php echo $disease?>]
				});

				// Button
				$("#button").button();
				$("#radioset").buttonset();

				// Tabs
				$('#tabs').tabs();
	

				// Dialog			
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}, 
						"Cancel": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#dialog_link').click(function(){
					$('#dialog').dialog('open');
					return false;
				});

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});
				
				// Slider
				$('#slider').slider({
					range: true,
					values: [17, 67]
				});
				
				// Progressbar
				$("#progressbar").progressbar({
					value: 20 
				});
				
				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				
			});
	</script>

</head>

<body>
	<div class="wrap">
        <div class="content2">
			<div class="border">
            	<div class="itemsbar">
                <table align="center" border="0">
                	<tr>
                    <td>
                	<ul>
                    	<li class="gallery"><a href="print_rooms.php"><img src="../../administration/images/print.png" width="29" height="29" /> Print</a></li>
                    </ul>

                    </td>
                    </tr>
                    </table>
                </div>
                
        	<table border="0" align="center">
            	<thead>
                	<th>Disease</th>
					<th>Visit Date</th>
                </thead>
        <?php 
		
		for($s = 0; $s <$num_rows; $s++){
	$disease_name= mysql_result($get_diagnosis_rs, $s, "diseases_name");
	$visit_date =  mysql_result($get_diagnosis_rs , $s, "visit_time");

	if($s%2 == 0){
		$bgcolor="#5BA4BB";
	}
	else{
		$bgcolor="#FFFFFF";
	}
		?>
        <form action="diagnosis_previous.php" method="POST">
        <tr  bgcolor="<?php echo $bgcolor ?>">
 <tr  bgcolor="<?php echo $bgcolor ?>">
    <td><?php echo $disease_name ?></td>
	<td><?php echo $visit_date ?></td>
               
            
        </tr>
        </form>
       
        <?php } ?>
          </table>
           
          <table align="center">
        		<tr>
            		<td><a href="diagnosis_previous.php?id=<?php echo $previous_page; ?>" class="modify2"><img src="../../administration/images/back_alt.png"/></a></td>
            
            <?php
            
				for($t = 1; $t <= $num_pages; $t++){
					
					echo "<td width='10' ><a href='diagnosis_previous.php?id=".$t."' class='modify'>".$t."</a></td>";
				}
			
			?>
            		<td><a href="diagnosis_previous.php?id=<?php echo $next_page; ?>" class="modify2"><img src="../../administration/images/forward_alt.png"/></a></td>
           	  </tr>
            </table>
        
		</div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
</body>
</html>
