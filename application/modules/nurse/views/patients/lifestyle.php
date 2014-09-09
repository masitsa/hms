
<?php echo form_open("reception/register_other_patient", array("class" => "form-horizontal"));?>
<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            <label class="col-lg-4 control-label">Title: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_address" placeholder="Address">
            </div>
        </div>
        
        
	</div>
    
    <div class="col-md-6">
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Postal Address: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_address" placeholder="Address">
            </div>
        </div>
        
       
        
    </div>
</div>
</br>
<div class="row">
	<div class="center-align ">
		<button class="btn btn-info btn-lg" type="submit">Add Patient</button>
	</div>
</div>
<?php echo form_close();?>
