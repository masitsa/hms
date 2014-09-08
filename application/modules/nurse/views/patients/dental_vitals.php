<?php
$dental_vitals = $this->nurse_model->select_current_dental_vitals($visit_id);

if($dental_vitals->num_rows() > 0){
	
	$rs_dental = $dental_vitals->row();
	
	$dental_vitals_id = $rs_dental->dental_vitals_id;
	$visit_major_reason = $rs_dental->visit_major_reason;
	$serious_illness = $rs_dental->serious_illness;
	$serious_illness_xplain = $rs_dental->serious_illness_xplain;
	$treatment = $rs_dental->treatment;
	$treatment_hospital = $rs_dental->treatment_hospital;
	$treatment_doctor = $rs_dental->treatment_doctor;
	$Food_allergies = $rs_dental->Food_allergies;
	$Regular_treatment = $rs_dental->Regular_treatment;
	$Recent_medication = $rs_dental->Recent_medication;
	$Medicine_allergies = $rs_dental->Medicine_allergies;
	$chest_trouble = $rs_dental->chest_trouble;
	$heart_problems = $rs_dental->heart_problems;
	$diabetic = $rs_dental->diabetic;
	$epileptic = $rs_dental->epileptic;
	$rheumatic_fever = $rs_dental->rheumatic_fever;
	$elongated_bleeding = $rs_dental->elongated_bleeding;
	$explain_bleeding = $rs_dental->explain_bleeding;
	$jaundice = $rs_dental->jaundice;
	$hepatitis = $rs_dental->hepatitis;
	$asthma = $rs_dental->asthma;
	$eczema = $rs_dental->eczema;
	$cancer = $rs_dental->cancer;
	$women_pregnant = $rs_dental->women_pregnant;
	$pregnancy_month = $rs_dental->pregnancy_month;
	$additional_infor = $rs_dental->additional_infor;
	$prior_treatment = $rs_dental->prior_treatment;
	$alcohol = $rs_dental->alcohol;
	$smoke = $rs_dental->smoke;
}

else
{
}

	echo form_open("reception/register_other_patient", array("class" => "form-horizontal"));
	?>
    <div class="row">
        <div class="col-md-6">
        
            <!-- Widget -->
            <div class="widget">
                <!-- Widget head -->
                <div class="widget-head">
                    <h4 class="pull-left"><i class="icon-reorder"></i>Complaints</h4>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>             
                
                <!-- Widget content -->
                <div class="widget-content">
                	<div class="padd">
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Chief Complaint: </label>
                            
                            <div class="col-lg-8">
                                <textarea name="reason" id="reason" placeholder="Reason for Visit" required class="form-control"></textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Serious Illness or operation: </label>
                            
                            <div class="col-lg-8">
            					<textarea name="doctor" id="doctor" placeholder="Hospital" class="form-control"></textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label"> </label>
                            
                            <div class="col-lg-8">
                                <textarea name="hospital" id="hospital" placeholder="Complain" class="form-control"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
        
            <!-- Widget -->
            <div class="widget">
                <!-- Widget head -->
                <div class="widget-head">
                    <h4 class="pull-left"><i class="icon-reorder"></i>Allergies</h4>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>             
                
                <!-- Widget content -->
                <div class="widget-content">
                	<div class="padd">
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Food Allergies: </label>
                            
                            <div class="col-lg-8">
                                <textarea id='food_allergies' name='food_allergies' class="form-control"> </textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Medicine Allergies: </label>
                            
                            <div class="col-lg-8">
            					<textarea id='medicine_allergies' name='medicine_allergies' class="form-control"></textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Regular Treatment: </label>
                            
                            <div class="col-lg-8">
            					<textarea id='regular_treatment' name='regular_treatment' class="form-control"></textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Recent Medication: </label>
                            
                            <div class="col-lg-8">
            					<textarea id='medication_description' name='medication_description' class="form-control"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="row">
        <div class="col-md-6">
        
            <!-- Widget -->
            <div class="widget">
                <!-- Widget head -->
                <div class="widget-head">
                    <h4 class="pull-left"><i class="icon-reorder"></i>Family History</h4>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>             
                
                <!-- Widget content -->
                <div class="widget-content">
                	<div class="padd">
                    	
                    	<ol id="new-nav"></ol>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
        
            <!-- Widget -->
            <div class="widget">
                <!-- Widget head -->
                <div class="widget-head">
                    <h4 class="pull-left"><i class="icon-reorder"></i>Others</h4>
                    <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>             
                
                <!-- Widget content -->
                <div class="widget-content">
                	<div class="padd">
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Any Serious Illness? </label>
                            
                            <div class="col-lg-8">
            					<select name="illness" id="illness" onChange="toggleFieldh('myTFh','illness')"  class="form-control"> 
                                    <option value="NO">NO </option>
                                    <option value="YES">YES </option>
                                </select>
                            </div>
                        </div>
                        
                    	<div class="form-group" id="myTFh" name="myTFh" style='display:none;'>
                            <label class="col-lg-4 control-label">Explain Illness: </label>
                            
                            <div class="col-lg-8">
            					<textarea id="illness_exp" name="illness_exp" placeholder="Illness Name" class="form-control"> </textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Is patient pregnant? </label>
                            
                            <div class="col-lg-8">
            					<select name="preg" id="preg" onChange="toggleFieldX('myTFx','preg')" class="form-control"> 
                                    <option value="NA">NOT APPLICABLE </option>
                                    <option value="YES">YES </option>
                                    <option value="NO">NO </option>
                                </select>
                            </div>
                        </div>
                        
                    	<div class="form-group" id="myTFx" name="myTFx" style='display:none;'>
                            <label class="col-lg-4 control-label">How far Along (Months)? </label>
                            
                            <div class="col-lg-8">
            					<textarea id="months" name="months" placeholder="How far Along Months" class="form-control"> </textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Additional Information: </label>
                            
                            <div class="col-lg-8">
            					<textarea name="additional" class="form-control" placeholder="Additional Information"></textarea>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Have You been Dissatisfied With Previous Treatment? </label>
                            
                            <div class="col-lg-8">
            					<input name="prior_treatment" type="radio" value="YES" class="form-control"> <strong> Yes</strong>
                                <input name="prior_treatment" type="radio" value="NO" class="form-control"> <strong>No </strong>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Alcohol Consupmtion? </label>
                            
                            <div class="col-lg-8">
            					<input name="alcohol" type="radio" value="YES" class="form-control"> <strong> Yes</strong>
                                <input name="alcohol" type="radio" value="NO" class="form-control"> <strong>No </strong>
                            </div>
                        </div>
                        
                    	<div class="form-group">
                            <label class="col-lg-4 control-label">Smoke? </label>
                            
                            <div class="col-lg-8">
            					<input name="smoke" type="radio" value="YES" class="form-control"> <strong> Yes</strong>
                                <input name="smoke" type="radio" value="NO" class="form-control"> <strong>No </strong>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="alert alert-warning">Kindly Let your Dentist Know if you have any new illness, or if any of the above details change durring the course of treatment</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="center-align">
    	<input type="submit" name="submit" id="submit" class="btn btn-large btn-info" align="center" value="Save"/> 
           <input type="submit" name="submit1" id="submit1" align="center" class="btn btn-large btn-success"value="Save & Send To Dentist"/>
    </div>
<script>
	$(document).ready(function(){
		
		var config_url = $("#config_url").val();
		
	  	$.get( config_url+"/nurse/get_family_history/<?php echo $visit_id;?>", function( data ) {
			$("#new-nav").html(data);
		});
	});
	
</script>