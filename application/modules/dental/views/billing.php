<div class="row">
    <div class="col-md-12">

      <!-- Widget -->
      <div class="widget boxed">
                        

        <!-- Widget content -->
            <div class="widget-content">
                <div class="padd">
		              
	                <div class="row">
						<div class="center-align">
							<?php
								echo "<input type='button' onClick='open_window_billing(".$visit_id.")' value='Add Billing Info2' class='btn btn-large btn-primary'>";
							
							
							?>
						</div>
					</div>
                  <div id="billing"></div>
					
				</div>
			</div>
		</div>
	</div>
</div>


   

  <script type="text/javascript">
	  $(document).ready(function(){
	       display_billing(<?php echo $visit_id?>);
	  });
  	function open_window_billing(visit_id){
	  var config_url = $('#config_url').val();
	  window.alert("sda");
	  window.open(config_url+"/dental/dental_services/"+visit_id,"Popup","height=1200, width=800, , scrollbars=yes, "+ "directories=yes,location=yes,menubar=yes," + "resizable=no status=no,history=no top = 50 left = 100");
	}
	
	function display_billing(visit_id){

	    var XMLHttpRequestObject = false;
	        
	    if (window.XMLHttpRequest) {
	    
	        XMLHttpRequestObject = new XMLHttpRequest();
	    } 
	        
	    else if (window.ActiveXObject) {
	        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    
	    var config_url = $('#config_url').val();
	    var url = config_url+"/dental/view_billing/"+visit_id;
	
	    if(XMLHttpRequestObject) {
	                
	        XMLHttpRequestObject.open("GET", url);
	                
	        XMLHttpRequestObject.onreadystatechange = function(){
	            
	            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {

	                document.getElementById("billing").innerHTML=XMLHttpRequestObject.responseText;
	            }
	        }
	                
	        XMLHttpRequestObject.send(null);
	    }
	}


  </script>