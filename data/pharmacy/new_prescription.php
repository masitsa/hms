<?php
session_start();
include '../../classes/class_pharmacy.php';

$visit_id = $_GET['visit_id'];

$get_pharmacy = new pharmacy();
$get_rs = $get_pharmacy->get_pharmacy_visit($visit_id);
$num_visit = mysql_num_rows($get_rs);

if ($num_visit >0 ){
$pharmacy_visit = mysql_result($get_rs, 0, "pharmarcy");

}
if ($pharmacy_visit ==2){
echo "
	<table width='auto' border='0' align='center'>
  <tr>
    <td><input name='prescribe' type='button' value='prescribe' onclick='open_window_pharmacy(".$visit_id.")'/></td>
  </tr>
 
</table>
";
}
?>