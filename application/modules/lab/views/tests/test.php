<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="center-align">
				<?php
		        	if(($visit == 2)||(($visit == 3))||(($visit == 1))||(($visit == 4))){
						echo "<input type='button' onClick='open_window_lab(8, ".$visit_id.")' value='Add Test' class='btn btn-large btn-primary'>";
					}
				
				?>
			</div>
		</div>
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Tests for <?php echo $patient;?></h4>
                      <div class="widget-icons pull-right">
                        <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                        <a href="#" class="wclose"><i class="icon-remove"></i></a>
                      </div>
                      <div class="clearfix"></div>
                    </div>             

                <!-- Widget content -->
                    <div class="widget-content">
                        <div class="padd">
							<div id="test_results"></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
		
</div>
   

  <script type="text/javascript">
	  $(document).ready(function(){
	       get_test_results(100, <?php echo $visit_id?>);
	  });
  	function open_window_lab(test, visit_id){
	  var config_url = $('#config_url').val();
	  window.open(config_url+"/lab/laboratory_list/"+test+"/"+visit_id,"Popup","height=1200, width=800, , scrollbars=yes, "+ "directories=yes,location=yes,menubar=yes," + "resizable=no status=no,history=no top = 50 left = 100");
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
	 // alert(url);
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

	function save_result_format(id, format, visit_id){
		var config_url = $('#config_url').val();
		
		var res = document.getElementById("laboratory_result2"+format).value;
		var data_url = config_url+"/lab/save_result_lab";
         	
        $.ajax({
			type:'POST',
			url: data_url,
			data:{id: id, res: res, format: format, visit_id: visit_id},
			dataType: 'text',
			success:function(data){
				//$("#result_space"+format).val(data);
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
	}

	function save_lab_comment(id, visit_id)
	{
		var config_url = $('#config_url').val();
		
		var res = document.getElementById("laboratory_comment"+id).value;
		
		var data_url = config_url+"/lab/save_lab_comment";
			
		$.ajax({
			type:'POST',
			url: data_url,
			data:{visit_charge_id: id, lab_visit_format_comments: res, visit_id: visit_id},
			dataType: 'text',
			success:function(data){
				//$("#result_space"+format).val(data);
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}
	
		});
	}

	function save_result(id, visit_id){
		
		var config_url = $('#config_url').val();
		var res = document.getElementById("laboratory_result"+id).value;
        var data_url = config_url+"/lab/save_result/"+id+"/"+res;
   
         var result_space = $('#result_space'+id).val();//document.getElementById("vital"+vital_id).value;
         	
        $.ajax({
			type:'POST',
			url: data_url,
			data:{result: result_space},
			dataType: 'text',
			success:function(data){
				//$("#result_space"+id).val(data);
			},
			error: function(xhr, status, error) {
				//alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
				alert(error);
			}

        });
	
		
	}
	function send_to_doc(visit_id){
	

		var XMLHttpRequestObject = false;
			
		if (window.XMLHttpRequest) {
		
			XMLHttpRequestObject = new XMLHttpRequest();
		} 
			
		else if (window.ActiveXObject) {
			XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var config_url = $('#config_url').val();

		var url = config_url+"/lab/send_to_doctor/"+visit_id;
					window.alert("what"+url);
		if(XMLHttpRequestObject) {
					
			XMLHttpRequestObject.open("GET", url);
					
			XMLHttpRequestObject.onreadystatechange = function(){
				
				if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
					
					//window.location.href = host+"index.php/laboratory/lab_queue";
				}
			}
					
			XMLHttpRequestObject.send(null);
		}
	}
	function finish_lab_test(visit_id){

		var XMLHttpRequestObject = false;
			
		if (window.XMLHttpRequest) {
		
			XMLHttpRequestObject = new XMLHttpRequest();
		} 
			
		else if (window.ActiveXObject) {
			XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var config_url = $('#config_url').val();
		var url = config_url+"/lab/finish_lab_test/"+visit_id;
				
		if(XMLHttpRequestObject) {
					
			XMLHttpRequestObject.open("GET", url);
					
			XMLHttpRequestObject.onreadystatechange = function(){
				
				if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
					
					//window.location.href = host+"index.php/laboratory/lab_queue";
				}
			}
					
			XMLHttpRequestObject.send(null);
		}
	}

	function save_comment(visit_charge_id){
		var config_url = $('#config_url').val();
		var comment = document.getElementById("test_comment").value;
        var data_url = config_url+"/lab/save_comment/"+comment+"/"+visit_charge_id;
     
        // var comment_tab = $('#comment').val();//document.getElementById("vital"+vital_id).value;
         	
        $.ajax({
        type:'POST',
        url: data_url,
       // data:{comment: comment_tab},
        dataType: 'text',
        success:function(data){
        //obj.innerHTML = XMLHttpRequestObject.responseText;
        },
        error: function(xhr, status, error) {
        //alert("XMLHttpRequest=" + xhr.responseText + "\ntextStatus=" + status + "\nerrorThrown=" + error);
       // alert(error);
        }

        });
	

		
	}
	function print_previous_test(visit_id, patient_id){
		var config_url = $('#config_url').val();
    	window.open(config_url+"/lab/print_test/"+visit_id+"/"+patient_id,"Popup","height=900,width=1200,,scrollbars=yes,"+
                        "directories=yes,location=yes,menubar=yes," +
                         "resizable=no status=no,history=no top = 50 left = 100");
	}

  </script>