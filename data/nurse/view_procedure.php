	<link rel="stylesheet" href="../../css/bootstrap.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css" media="screen" />
	<title>Vitals</title>
    <script type="text/javascript" src="../../js/script.js"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery.js'?>'></script>
	<script type="text/javascript" src="<?php echo '../../js/jquery-1.7.1.min.js'?>"></script>
	<script type='text/javascript' src='<?php echo '../../js/jquery-ui-1.8.18.custom.min.js'?>'></script>
	<?php 
//session_start();
include '../../classes/connection.php';

//$v_id = $_GET['visit_id'];
$v_id = $_GET['visit_id'];
$sql1 = "SELECT visit_type, visit_id FROM visit WHERE visit_id = '$v_id'";

$v_type = new Database();
$rs2 =$v_type->select($sql1);
$num_type= mysql_num_rows($rs2);
$visit_t = mysql_result($rs2, 0 ,"visit_type");

 $sql3 = "SELECT * FROM visit_charge WHERE visit_charge.visit_id = ".$v_id."";
  //echo $sql3;
  
  $visit__procedure = new Database();
$visit__rs1 = $visit__procedure->select($sql3);		
$visit__procedures= mysql_num_rows($visit__rs1);



echo "
	<div class='navbar-inner'><p style='text-align:center; color:#0e0efe;'>Procedures <br/><input type='button' class='btn btn-primary' value='Add Procedure' onclick='myPopup3(".$v_id.")'/></p></div>
<table align='center' class='table table-striped table-hover table-condensed'>
	<tr>
		<th></th>
		<th>Procedure</th>
		<th>Units</th>
		<th>Unit Cost</th>
		<th>Total</th>
	
	</tr>		
";                     $total= 0;  for($z1 = 0; $z1 < $visit__procedures; $z1++){
							$v_procedure_id = mysql_result($visit__rs1, $z1, "visit_charge_id");
							$procedure_id = mysql_result($visit__rs1, $z1, "service_charge_id");
							$visit_charge_amount = mysql_result($visit__rs1, $z1, "visit_charge_amount");
							$units = mysql_result($visit__rs1, $z1, "visit_charge_units");
	 
				
						//echo $visit_charge_amount ;
						 $sql2 = "SELECT * FROM service_charge WHERE service_charge_id = ".$procedure_id."";
  						//	echo $sql2;
						$v_procedure = new Database();
						$rs1 = $v_procedure->select($sql2);		
						$num_procedures= mysql_num_rows($rs1);

						for($z = 0; $z < $num_procedures; $z++){
							//$_SESSION["num_procedure"]=$z+1;
							//$v_procedure_id = mysql_result($rs1, $z, "visit_charge_id");
							//$procedure_id = mysql_result($rs1, $z, "service_charge_id");
							$procedure_name = mysql_result($rs1, $z, "service_charge_name");
							$service_id = mysql_result($rs1, $z, "service_id");
							//$visit_id = mysql_result($rs1, $z, "visit_id");			
												
							//$units = mysql_result($rs1, $z, "visit_charge_units");		
							
							
							//echo sc.$service_charge_id;
							if($service_id==3){
								$total= $total +($units * $visit_charge_amount);
echo"
		<tr> 
			<td></td>
 			<td align='center'>".$procedure_name."</td>
			<td align='center'><input type='text' id='units".$v_procedure_id."' value='".$units."' size='3' onkeyup='calculatetotal(".$visit_charge_amount.",".$v_procedure_id.", ".$procedure_id.",".$v_id.")'/></td>
			<td align='center'>".$visit_charge_amount."</td>
			<td align='center'><input type='text' readonly='readonly' size='5' value='".$units * $visit_charge_amount."' id='total".$v_procedure_id."'></div></td>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_procedure(".$v_procedure_id.", ".$v_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
		</tr>	
";					
} }
}
echo"
<tr bgcolor='#59B3D5'>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td align='center'><div id='grand_total'>".$total."</div></td>
</tr>
 </table>
";
?>