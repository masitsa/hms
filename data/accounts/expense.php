<?php
include ('../../classes/expenses.php');

$get= new expenses;
$rs=$get->get_doctor();
$num_rows= mysql_num_rows($rs);



?>
<form action="../../classes/expenses.php" method="post">
<label> </label><input type="text" name="amount" id="amount">

<label> </label><select name="doc_name">
<option> ----Select Doctor---</option>
<?php
for ($a=0; $a<$num_rows; $a++){
	$personnel_id= mysql_result($rs, $a, 'personnel_id');
	$doc_f= mysql_result($rs, $a, 'personnel_fname');
	$doc_o= mysql_result($rs, $a, 'personnel_onames');
	echo 'PP'.$personnel_id;
	?>
    <option value="<?php echo $personnel_id ?>"><?php echo $doc_o.''.$doc_o; ?> </option>
    <?php
	}
?>

 </select>
 
<label> </label><select name="reason">

<option> </option>
<option> </option>
<option> </option>
 </select>

</form>