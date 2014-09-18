
<p>Blood Pressure :</p>
<div class="form-group">
    <label class="col-lg-4 control-label">Systolic: </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital5" onkeyup = "save_vital('<?php echo $visit_id;?>', 5)" class="form-control"/>
    	<div id="display5"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label">Diastolic: </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital6" onkeyup = "save_vital(<?php echo $visit_id;?>, 6)" class="form-control"/>
    	<div id="display6"></div>
    </div>
</div>



<!-- Body mass index  -->

<p>BMI :</p>
<div class="form-group">
    <label class="col-lg-4 control-label">Weight (kg): </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital8" onkeyup = "save_vital(<?php echo $visit_id;?>, 8)" class="form-control"/>
    	<div id="display8"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label">Height (m) : </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital9" onkeyup = "save_vital(<?php echo $visit_id;?>, 9)" class="form-control"/>
    	<div id="display9"></div>
    	
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
    	<div id="bmi_out"></div>
    </div>
</div>

<!-- hip/ Weist -->

<p>Hip / Waist :</p>
<div class="form-group">
    <label class="col-lg-4 control-label">Hip : </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital4" onkeyup = "save_vital(<?php echo $visit_id;?>, 4)" class="form-control"/>

    	<div id="display4"></div>
    </div>

</div>
<div class="form-group">
    <label class="col-lg-4 control-label">Waist : </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital3" onkeyup = "save_vital(<?php echo $visit_id;?>, 3)" class="form-control"/>
    	<div id="display3"></div>
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
    	<div id="hwr_out"></div>
    </div>
</div>


<!-- temparature -->

<div class="form-group">
    <label class="col-lg-4 control-label">Temperature: </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital1" onfocusout = "save_vital(<?php echo $visit_id;?>, 1)" class="form-control"/>
        <div id="display1"></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-4 control-label">Pulse: </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital7" onfocusout = "save_vital(<?php echo $visit_id;?>, 7)" class="form-control"/>
        <div id="display7"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-4 control-label">Respiration: </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital2" onfocusout = "save_vital(<?php echo $visit_id;?>, 2)" class="form-control"/>
        <div id="display2"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-4 control-label">Oxygen Saturation : </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital11" onfocusout = "save_vital(<?php echo $visit_id;?>, 11)" class="form-control"/>
    	<div id="display11"></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg-4 control-label">Pain : </label>
    
    <div class="col-lg-8">
    	<input type="text" id="vital10" onfocusout = "save_vital(<?php echo $visit_id;?>, 10)" class="form-control"/>
    	<div id="display10"></div>
    </div>
</div>





		
		
		
	