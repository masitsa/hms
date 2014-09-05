<select name="service_charge_name" class="form-control">
<?php 
	if(count($service_charge) == 0) 
		{
			?>
			<option value='0'>Loading...</option>
<?php } 
	else { 
		?>
			<option value='0'>Select Consultaion Charge </option>
	<?php } ?>
<?php foreach($service_charge AS $key) { ?>
<option value="<?php echo  $key->service_charge_id;?>"><?php echo $key->service_charge_name;?></option>
<?php } ?>
</select>