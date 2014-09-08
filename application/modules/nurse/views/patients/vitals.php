<?php echo form_open("reception/register-other-patient", array("class" => "form-horizontal"));?>

<div class="row">
	<div class="col-md-6">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Vitals</h4>
                      <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                      </div>
                      <div class="clearfix"></div>
                    </div>             

                <!-- Widget content -->
                    <div class="widget-content">
                        <div class="padd">
                              <!-- vitals from java script -->
                                <div id="vitals"></div>
                                <!-- end of vitals data -->
                        </div>

                     </div>
                
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
       <div class="row">
        <div class="col-md-12">

          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Procedures</h4>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>             

            <!-- Widget content -->
                <div class="widget-content">
                    <div class="padd">
                            <!-- visit Procedures from java script -->
                                <div id="procedures"></div>
                             <!-- end of visit procedures -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<?php echo form_close();?>

<script text="javascript">

$(document).ready(function(){
  vitals_interface(<?php echo $visit_id;?>);
});

 function vitals_interface(visit_id){
   
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
                    load_vitals(count, visit_id);
                }
                 previous_vitals(visit_id);
                // get_family_history(visit_id);
                 display_procedure(visit_id);
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

function previous_vitals(visit_id){
    
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var config_url = $('#config_url').val();
    var url = config_url+"/nurse/previous_vitals/"+visit_id;//window.alert(url);

    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("previous_vitals");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                obj.innerHTML = XMLHttpRequestObject.responseText;
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
        
        var XMLHttpRequestObject = false;
            
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
       
        var vital = document.getElementById("vital"+vital_id).value;
        var config_url = $('#config_url').val();
        var url = config_url+"/nurse/save_vitals/"+vital+"/"+vital_id+"/"+visit_id;
    

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

    function calculate_bmi(vitals_id, visit_id){
    
        var XMLHttpRequestObject = false;
            
        if (window.XMLHttpRequest) {
        
            XMLHttpRequestObject = new XMLHttpRequest();
        } 
            
        else if (window.ActiveXObject) {
            XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
        }
        var config_url = $('#config_url').val();
        var url = config_url+"/nurse/calculate_bmi/"+vitals_id+"/"+visit_id;//window.alert(url);

        if(XMLHttpRequestObject) {
            
            var obj = document.getElementById("bmi_out");
                    
            XMLHttpRequestObject.open("GET", url);
                    
            XMLHttpRequestObject.onreadystatechange = function(){
                
                if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                    obj.innerHTML = XMLHttpRequestObject.responseText;
                }
            }
                    
            XMLHttpRequestObject.send(null);
        }
    }

function calculate_hwr(vitals_id, visit_id){
    
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var config_url = $('#config_url').val();
    var url = config_url+"/nurse/calculate_hwr/"+vitals_id+"/"+visit_id;//window.alert(url);

    if(XMLHttpRequestObject) {
        
        var obj = document.getElementById("hwr_out");
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                obj.innerHTML = XMLHttpRequestObject.responseText;
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function display_procedure(visit_id){

    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    var config_url = $('#config_url').val();
    var url = config_url+"/nurse/view_procedure/"+visit_id;
    
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

                document.getElementById("procedures").innerHTML=XMLHttpRequestObject.responseText;
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}

function myPopup3(visit_id) {
    var config_url = $('#config_url').val();
    window.open( config_url+"/nurse/procedures/"+visit_id, "myWindow", "status = 1, height = auto, width = 600, resizable = 0" )
}

</script>