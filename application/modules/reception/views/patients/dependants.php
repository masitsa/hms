<?php 
	$staff_query = $this->reception_model->get_staff($dependant_staff);
	
	if($staff_query->num_rows() > 0)
	{
		$staff_result = $staff_query->row();
		
		$patient_surname = $staff_result->Surname;
		$patient_othernames = $staff_result->Other_names;
	}
	echo form_open("reception/register-dependant-patient/".$dependant_staff, array("class" => "form-horizontal"));
?>
<div style="margin-bottom:20px;">
	<h3 class="center-align">Add Depandant for <?php echo $patient_surname;?> <?php echo $patient_othernames;?></h3>
</div>

<div class="row">
	<div class="col-md-6">
        <div class="form-group">
            <label class="col-lg-4 control-label">Title: </label>
            
            <div class="col-lg-8">
            	<select class="form-control" name="title_id">
                	<?php
                    	if($titles->num_rows() > 0)
						{
							$title = $titles->result();
							
							foreach($title as $res)
							{
								$title_id = $res->title_id;
								$title_name = $res->title_name;
								
								if($title_id == set_value("title_id"))
								{
									echo '<option value="'.$title_id.'" selected>'.$title_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$title_id.'">'.$title_name.'</option>';
								}
							}
						}
					?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Surname: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_surname" placeholder="Surname">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Other Names: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_othernames" placeholder="Other Names">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Date of Birth: </label>
            
            <div class="col-lg-8">
                <div id="datetimepicker1" class="input-append">
                    <input data-format="yyyy-MM-dd" class="form-control" type="text" name="patient_dob" placeholder="Date of Birth">
                    <span class="add-on">
                        &nbsp;<i data-time-icon="icon-time" data-date-icon="icon-calendar">
                        </i>
                    </span>
                </div>
            </div>
        </div>
	
    </div>
    <div class="col-md-6">
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Gender: </label>
            
            <div class="col-lg-8">
            	<select class="form-control" name="gender_id">
                	<?php
                    	if($genders->num_rows() > 0)
						{
							$gender = $genders->result();
							
							foreach($gender as $res)
							{
								$gender_id = $res->gender_id;
								$gender_name = $res->gender_name;
								
								if($gender_id == set_value("gender_id"))
								{
									echo '<option value="'.$gender_id.'" selected>'.$gender_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$gender_id.'">'.$gender_name.'</option>';
								}
							}
						}
					?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Religion: </label>
            
            <div class="col-lg-8">
            	<select class="form-control" name="religion_id">
                	<?php
                    	if($religions->num_rows() > 0)
						{
							$religion = $religions->result();
							
							foreach($religion as $res)
							{
								$religion_id = $res->religion_id;
								$religion_name = $res->religion_name;
								
								if($religion_id == set_value("religion_id"))
								{
									echo '<option value="'.$religion_id.'" selected>'.$religion_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$religion_id.'">'.$religion_name.'</option>';
								}
							}
						}
					?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Civil Status: </label>
            
            <div class="col-lg-8">
            	<select class="form-control" name="civil_status_id">
                	<?php
                    	if($civil_statuses->num_rows() > 0)
						{
							$status = $civil_statuses->result();
							
							foreach($status as $res)
							{
								$status_id = $res->civil_status_id;
								$status_name = $res->civil_status_name;
								
								if($status_id == set_value("civil_status_id"))
								{
									echo '<option value="'.$status_id.'" selected>'.$status_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$status_id.'">'.$status_name.'</option>';
								}
							}
						}
					?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Relationship To Staff: </label>
            
            <div class="col-lg-8">
            	<select class="form-control" name="relationship_id">
                	<?php
                    	if($relationships->num_rows() > 0)
						{
							$relationship = $relationships->result();
							
							foreach($relationship as $res)
							{
								$relationship_id = $res->relationship_id;
								$relationship_name = $res->relationship_name;
								
								if($relationship_id == set_value("relationship_id"))
								{
									echo '<option value="'.$relationship_id.'" selected>'.$relationship_name.'</option>';
								}
								
								else
								{
									echo '<option value="'.$relationship_id.'">'.$relationship_name.'</option>';
								}
							}
						}
					?>
                </select>
            </div>
        </div>
        
	</div>
</div>

<div class="center-align">
	<button class="btn btn-info btn-lg" type="submit">Add Patient</button>
</div>
<?php echo form_close();?>