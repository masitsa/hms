<?php 

$rs = $this->nurse_model->get_diagnosis($visit_id);
$num_rows = count($rs);
//echo $num_rows;
		
if($num_rows > 0){

	echo
	"

			<table class='table table-striped table-hover table-condensed'>
				<tr>
					<th></th>
					<th>Code</th>
					<th>Disease</th>
				</tr>";
	
	foreach ($rs as $key):
		$diagnosis_id = $key->diagnosis_id;
		$name = $key->diseases_name;
		$code = $key->diseases_code;
		
		echo "<tr>
			<td>
				<div class='btn-toolbar'>
					<div class='btn-group'>
						<a class='btn' href='#' onclick='delete_diagnosis(".$diagnosis_id.", ".$visit_id.")'><i class='icon-remove'></i></a>
					</div>
				</div>
			</td>
				<td>".$code."</td>
				<td>".$name."</td></tr>";
	endforeach;
}
echo"</table>
<table align='center'><tr align='center'><td><input type='button' class='btn btn-large' onClick='closeit(1, ".$visit_id.")' value='Done'/></td></tr></table>";
?>
<script type="text/javascript">
	
</script>