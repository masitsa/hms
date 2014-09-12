<?php echo form_open("reception/register-other-patient", array("class" => "form-horizontal"));?>

<div class="row">
	<div class="col-md-12">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Symptoms</h4>
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
                                <div id="symptoms"></div>
                                <!-- end of vitals data -->
                        </div>

                     </div>
                
                </div>
            </div>
        </div>
    </div>
   
</div>
<div class="row">
 <div class="col-md-12">
       <div class="row">
        <div class="col-md-12">

          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Objective Findings</h4>
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
                                <div id="objective_findings"></div>
                             <!-- end of visit procedures -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div class="row">
 <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Assessment</h4>
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
                                <div id="assessment"></div>
                                <!-- end of vitals data -->
                        </div>

                     </div>
                
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
 
    <div class="col-md-12">
       <div class="row">
        <div class="col-md-12">

          <!-- Widget -->
          <div class="widget boxed">
                <!-- Widget head -->
                <div class="widget-head">
                  <h4 class="pull-left"><i class="icon-reorder"></i>Plan</h4>
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
                                <div id="plan"></div>
                             <!-- end of visit procedures -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Prescription</h4>
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
    
</div>

<div class="row">
  <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Doctor's Notes</h4>
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
                  <h4 class="pull-left"><i class="icon-reorder"></i>Nurse Notes</h4>
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

<script type="text/javascript">

  $(document).ready(function(){
      symptoms(<?php echo $visit_id;?>);
      objective_findings(<?php echo $visit_id;?>);
      assessment(<?php echo $visit_id;?>);
      plan(<?php echo $visit_id;?>);
      
  });
  
  function symptoms(visit_id){

  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
   var config_url = $('#config_url').val();

  var url = config_url+"/nurse/view_symptoms/"+visit_id;
 
  if(XMLHttpRequestObject) {
    
    var obj = document.getElementById("symptoms");
      
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        obj.innerHTML = XMLHttpRequestObject.responseText;
        
        // patient_details(visit_id);
        // objective_findings(visit_id);
        // assessment(visit_id);
        // plan(visit_id);
        // doctor_notes(visit_id);
        // nurse_notes(visit_id);
      }
    }
        
    XMLHttpRequestObject.send(null);
  }
}


function objective_findings(visit_id){
  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
   var config_url = $('#config_url').val();
  var url = config_url+"/nurse/view_objective_findings/"+visit_id;
  
  if(XMLHttpRequestObject) {
    
    var obj = document.getElementById("objective_findings");
        
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        obj.innerHTML = XMLHttpRequestObject.responseText;
      }
    }
        
    XMLHttpRequestObject.send(null);
  }
}

function assessment(visit_id){
  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
  var config_url = $('#config_url').val();
  var url = config_url+"/nurse/view_assessment/"+visit_id;
  
  if(XMLHttpRequestObject) {
    
    var obj = document.getElementById("assessment");
        
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        obj.innerHTML = XMLHttpRequestObject.responseText;
      }
    }
        
    XMLHttpRequestObject.send(null);
  }
}

function plan(visit_id){
  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
  var config_url = $('#config_url').val();
  var url = config_url+"/nurse/view_plan/"+visit_id;
  
  if(XMLHttpRequestObject) {
    
    var obj = document.getElementById("plan");
        
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        obj.innerHTML = XMLHttpRequestObject.responseText;
         get_test_results(100, visit_id);
         closeit(79, visit_id);
        // display_prescription(visit_id, 2);
      }
    }
        
    XMLHttpRequestObject.send(null);
  }
}

function get_test_results(page, visit_id){

  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
  var config_url = $('#config_url').val();
  if((page == 1) || (page == 65) || (page == 85)){
    
    url = config_url+"/lab/test/"+visit_id;
  }
  
  else if ((page == 75) || (page == 100)){
    url = config_url+"/lab/test1/"+visit_id;
  }
  if(XMLHttpRequestObject) {
    if((page == 75) || (page == 85)){
      var obj = window.opener.document.getElementById("test_results");
    }
    else{
      var obj = document.getElementById("test_results");
    }
    XMLHttpRequestObject.open("GET", url);
    
    XMLHttpRequestObject.onreadystatechange = function(){
    
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
  //window.alert(XMLHttpRequestObject.responseText);
        obj.innerHTML = XMLHttpRequestObject.responseText;
        if((page == 75) || (page == 85)){
          window.close(this);
        }
        
      }
    }
    XMLHttpRequestObject.send(null);
  }
}



function display_prescription(visit_id, page){
  
  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
   var config_url = $('#config_url').val();
  var url = config_url+"/pharmacy/display_prescription/"+visit_id;
  
  if(page == 1){
    var obj = window.opener.document.getElementById("prescription");
  }
  
  else{
    var obj = document.getElementById("prescription");
  }
      
  if(XMLHttpRequestObject) {
        
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
        obj.innerHTML = XMLHttpRequestObject.responseText;
        
        if(page == 1){
          window.close(this);
        }
      }
    }
    
    XMLHttpRequestObject.send(null);
  }
}

function open_window_lab(test, visit_id){
  var config_url = $('#config_url').val();
  window.open(config_url+"/lab/laboratory_list/"+test+"/"+visit_id,"Popup","height=1200, width=800, , scrollbars=yes, "+ "directories=yes,location=yes,menubar=yes," + "resizable=no status=no,history=no top = 50 left = 100");
}

function open_symptoms(visit_id){
  var config_url = $('#config_url').val();
  window.open(config_url+"/nurse/symptoms_list/"+visit_id,"Popup","height=1000,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100");
    
  
}

function open_objective_findings(visit_id){
  var config_url = $('#config_url').val();
  window.open(config_url+"/nurse/objective_finding/"+visit_id,"Popup","height=600,width=1000,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100");
    
  
}


function save_assessment(visit_id){
  var XMLHttpRequestObject = false;
    
  if (window.XMLHttpRequest) {
  
    XMLHttpRequestObject = new XMLHttpRequest();
  } 
    
  else if (window.ActiveXObject) {
    XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  var assessment = document.getElementById("visit_assessment").value;
  var config_url = $('#config_url').val();
  var url = config_url+"/nurse/save_assessment/"+assessment+"/"+visit_id;

  if(XMLHttpRequestObject) {
        
    XMLHttpRequestObject.open("GET", url);
        
    XMLHttpRequestObject.onreadystatechange = function(){
      
      if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
      }
    }
        
    XMLHttpRequestObject.send(null);
  }
}

function open_window(plan, visit_id){
    var config_url = $('#config_url').val();
  if(plan == 6){
  
    window.open(config_url+"/nurse/disease/"+visit_id,"Popup","height=1000,width=600,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100");
  }
  else if (plan == 1){
    
    window.open(config_url+"/pharmacy/prescription/"+visit_id,"Popup","height=1200,width=1300,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=yes status=yes,history=yes top = 50 left = 100");
  }
}






</script>