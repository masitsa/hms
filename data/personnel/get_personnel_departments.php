<?php
session_start();
include '../../classes/class_personnel.php';

$personnel_id = $_GET['id'];

$get = new Personnel;
$rs = $get->get_personnel_departments($personnel_id);
$num_rows = mysql_num_rows($rs);
//echo $num_rows;

if ($num_rows >0 ){
	
	for($r = 0; $r < $num_rows; $r++){
		
		$dept = mysql_result($rs, $r, "departments_name");
		$url = mysql_result($rs, $r, "departments_url");
		$image = mysql_result($rs, $r, "departments_image");
		
		echo'
			<div class="span1" style="margin-left:10%;">
						<p>
                    		<h6>'.$dept.'</h6>
                        	<a href="http://localhost/hms/index.php/'.$url.'">
                        		<img src="http://localhost/hms/images/icons/'.$image.'" width="100" height="100" alt="'.$dept.'"/>
                       		</a>
                    	</p>   
						</div>  
		';
			
	}
	?>
			<div class="span1" style="margin-left:10%;"  onclick='password("overlay_form");'>
						<p>
                    		<h6>Change Password</h6>
                        	<a href="#">
                        		<img src='http://localhost/hms/images/icons/password.png' width="100" height="100" alt='Change Password'/>
                       		</a>
                    	</p>   
						</div>  
		
<?php }
?>


     <div id="overlay_form" style="display:none;">

</div>
