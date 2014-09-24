<?php

$rs = $this->nurse_model->get_plan($visit_id);
$num_rows = count($rs);
	
echo "
	<div class='navbar-inner'>
		<p style='text-align:center; color:#0e0efe;'>
		
			<input type='button' class='btn btn-warning' value='Laboratory Test' onclick='open_window_lab(0, ".$visit_id.")'/>
			<input type='button' class='btn btn-info' value='Diagnose' onclick='open_window(6, ".$visit_id.")'/>
			<input type='button' class='btn btn-success' value='Prescribe' onclick='open_window(1, ".$visit_id.")'/>
			<!-- 
			<a href='".site_url()."pharmacy/prescription/".$visit_id."' target='_blank' class='btn btn-success'>Prescribe</a>
			-->
		</p>
	</div>";

if($num_rows > 0){
	foreach ($rs as $key):
		$visit_plan = $key->visit_plan;
	endforeach;
	echo
	"
	<div class='row'>
		<div class='col-md-12'>
			<textarea class='form-control' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'>".$visit_plan."</textarea>
		</div>
	</div>
	";
}

else{
	echo
	"
	<div class='row'>
		<div class='col-md-12'>
			<textarea class='form-control' id='visit_plan' onKeyUp='save_plan(".$visit_id.")'></textarea>
		</div>
	</div>
	";
}

echo "
<div id='test_results'></div>
<div id='disease_list'></div>
<div id='prescription'></div>";


?>