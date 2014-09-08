<?php echo form_open("reception/register-other-patient", array("class" => "form-horizontal"));?>
<div class="row">
	<div class="col-md-6">
      <p style="margin-bottom:1em;">Vitals</p>
      <!-- vitals from java script -->
        <div id="vitals"></div>
        <!-- end of vitals data -->
	</div>
    
    <div class="col-md-6">
        <p style="margin-bottom:1em;">Procedures</p>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Post Code: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_postalcode" placeholder="Post Code">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Town: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_town" placeholder="Town">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Primary Phone: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_phone1" placeholder="Primary Phone">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Other Phone: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_phone2" placeholder="Other Phone">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Next of Kin Surname: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_kin_sname" placeholder="Kin Surname">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Next of Kin Other Names: </label>
            
            <div class="col-lg-8">
            	<input type="text" class="form-control" name="patient_kin_othernames" placeholder="Kin Other Names">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-4 control-label">Relationship To Kin: </label>
            
            <div class="col-lg-8">
            	
            </div>
        </div>
        
    </div>
</div>

<div class="center-align">
	<button class="btn btn-info btn-lg" type="submit">Add Patient</button>
</div>
<?php echo form_close();?>

<script text="javascript">

$(document).ready(function(){
  vitals_interface(<?php echo $visit_id;?>);
});

 function vitals_interface(visit_id){
    window.alert
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

    var config_url = $('#config_url').val();
    var url = config_url+"/nurse/vitals_interface/"+visit_id;

            
    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("vitals");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                obj.innerHTML = XMLHttpRequestObject.responseText;
                
                var count;
                for(count = 1; count < 12; count++){
                    //load_vitals(count, visit_id);
                }
                // previous_vitals(visit_id);
                // get_family_history(visit_id);
                // display_procedure(visit_id);
                // get_medication(visit_id);
                // get_surgeries(visit_id);
                // get_vaccines(visit_id);
                // nurse_notes(visit_id);
                // patient_details(visit_id);
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}


function load_vitals(vitals_id, visit_id){
    
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var config_url = $('#config_url').val();
    var url = config_url+"/nurse/load_vitals/"+vitals_id+"/"+visit_id;//window.alert(url);

    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("display"+vitals_id);
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                obj.innerHTML = XMLHttpRequestObject.responseText;
                
                if((vitals_id == 8) || (vitals_id == 9)){
                    calculate_bmi(vitals_id, visit_id);
                }
                
                if((vitals_id == 3) || (vitals_id == 4)){
                    calculate_hwr(vitals_id, visit_id);
                }
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function getXMLHTTP() {
     //fuction to return the xml http object
        var xmlhttp=false;  
        try{
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)    {       
            try{            
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e){
                try{
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e1){
                    xmlhttp=false;
                }
            }
        }
            
        return xmlhttp;
    }
    function save_vital(visit_id, vital_id){
        window.alert(visit_id+"here"+vital_id);
        
        var XMLHttpRequestObject = false;
            
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var config_url = $('#config_url').val();
        var vital = document.getElementById("vital"+vital_id).value;
        
        var url = config_url+"/nurse/save_vitals/"+vital+"/"+vital_id+"/"+visit_id;
        window.alert(url);

        if(XMLHttpRequestObject) {
            
            var obj = document.getElementById("display"+vital_id);
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                    load_vitals(vital_id, visit_id);
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }
    }

</script>