<?php 


//$search = $_GET['search'];//the user is has requested to search

if(isset($_GET['order'])){
  $order = $_GET["order"];
}else{
  $order = "service_charge_name";
}


//  get the visit type 

$rs = $this->nurse_model->check_visit_type($visit_id);

if(count($rs)>0){
  foreach ($rs as $rs1) {
    # code...
      $visit_t = $rs1->visit_type;
  }

}



if(isset($_REQUEST['search'])){
	$search = $_POST['item'];
	$visit_id = $_POST['visit_id'];
if(!isset($order)){
	$order = "service_charge_name";
}
	$rs9 = $this->nurse_model->search_procedures($order, $search,$visit_t );
	$num_rows9 = count($rs9);
}
else{
  $search ="";
	if(!isset($order)){
	$order = "service_charge_name";
}

	$rs9 = $this->nurse_model->get_procedures($order,$visit_t);
	$num_rows9 = count($rs9);
	//echo "HERE";
}
	//paginate the items
	$pages1 = intval($num_rows9/10);
	$pages2 = $num_rows9%(2*10);
	
	if($pages2 == NULL){//if there is no remainder
	
		$num_pages = $pages1;
	}

	else{
	
		$num_pages = $pages1 + 1;
	}
  if(isset($_GET['id'])){
	$current_page = $_GET['id'];//if someone clicks a different page
  }else{
    $current_page =0;
  }


	if($current_page < 1){//if different page is not clicked
	
		$current_page = 1;
	}

	else if($current_page > $num_pages){//if the next page clicked is more than the number of pages
	
		$current_page = $num_pages;
	}

	if($current_page == 1){
	
		$current_item = 0;
	}

	else{

		$current_item = ($current_page-1) * 10;
	}

	$next_page = $current_page+1;

	$previous_page = $current_page-1;

	$end_item = $current_item + 10;

	if($end_item > $num_rows9){
	
		$end_item = $num_rows9;
	}
	
	//$first_id = mysql_result($rs9, $current_item, "procedure_id");	

?>
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
                          <div class="row">
                      	   <table align="center" border="0">
                          	<tr>
                                      <td>
                                          <form class="form-search" action="procedures.php?visit_id=<?php echo $visit_id?>"  method="post" >
                                          	<input type="text" class="input-medium search-query" id="item_name" name="item">
                                          	<input type="hidden" value="<?php echo $visit_id?>" name="visit_id">
                                              <input type="submit" class="btn" value="Search" name="search"/>
                      					</form>
                                      </td>
                              </tr>
                          </table>
                          </div>
   
                          <?php if(!empty($search)){	?>  
                          <div class="row"> 
                          <table border="0" class="table table-hover table-condensed">
                                      	<thead>
                                          	<th><a href="procedures.php?order=procedures&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Procedure</a></th>
                                          	<th><a href="procedures.php?order=students&id=<?php echo $current_page?>&search=<?php echo $search?>&order=<?php echo $order?>">Cost</a></th>
                                          	
                                          </thead>
                                          
                                       <?php 
                          		      foreach ($rs9 as $rs10 ):
                          		
                                      		$procedure_id = $rs10->service_charge_id;
                                      		$proced = $rs10->service_charge_name;
                                          $visit_type = $rs10->visit_type_id;
                                          
                                          $stud = $rs10->service_charge_amount;

                                      	?>
                                  	<tr>
                                          <td></td>
                                  		
                                          <td>
                                     
                                          <?php $suck=1; ?>
                                         <a href="#" onClick="procedures(<?php echo $procedure_id?>,<?php echo $visit_id?>,<?php echo $suck; ?>)"><?php echo $proced?> </a></td>
                                        
                                          <td><?php echo $stud?></td>

                                          
                                           
                                  	</tr>
                                   <?php 

                                   endforeach;
                                   ?>
                                  </table>
                                  </div>
                              <?php }
                              else { ?>
    
                                <div class="row">
                                  <table border="0" class="table table-hover table-condensed">
                                              	<thead> 
                                                  <th> </th>
                                                  	<th>Procedure</th>
                                                  	<th>Cost</th>
                                                  	
                                                  </thead>
                                                  
                                               <?php 
                                  		 //echo "current - ".$current_item."end - ".$end_item;
                                  			
                                  	 foreach ($rs9 as $rs10) :
                                      
                                  		
                                  		$procedure_id = $rs10->service_charge_id;
                                  		$proced = $rs10->service_charge_name;
                                      $visit_type = $rs10->visit_type_id;
                                      
                                      $stud = $rs10->service_charge_amount;

                                  	?>
                                          	<tr>
                                         <td></td>
                                          		
                                                  <td> <?php $suck=1; ?>                
                                  				<a href="#" onClick="procedures(<?php echo $procedure_id?>,<?php echo $visit_id?>,<?php echo $suck; ?>)"><?php echo $proced?> </a></td><td><?php echo $stud?></td>
                                  	</tr>
                                           <?php 
                                           endforeach;?>
                                          </table>
                                    </div>
    
                                  <?php 
                                    }?>
                                      <div class="pagination" style="margin-left:20%;">
                                  		<ul>
                                 				<li><a href="procedures.php?id=<?php echo $previous_page; ?>&search=<?php echo $search?>&order=<?php echo $order?>&visit_id=<?php echo $visit_id?>">Prev</a></li>
                                          <?php
                                          
                              				for($t = 1; $t <= $num_pages; $t++){
                              					echo '<li><a href="procedures.php?id='.$t.'&order='.$order.'&search='.$search.'&visit_id='.$visit_id.'">'.$t.'</a></li>';
                              				}
                              			
                              			?>
                                  			
                                              <li><a href="procedures.php?id=<?php echo $previous_page; ?>&search=<?php echo $search?>&order=<?php echo $order?>&visit_id=<?php echo $visit_id?>">Next</a></li>
                                  		</ul>
                                  	</div>

                                  </div>
                          </div>
                    </div>
              </div>
            </div>
<script type="text/javascript">
  
  function procedures(id, v_id, suck){
   
    var XMLHttpRequestObject = false;
        
    if (window.XMLHttpRequest) {
    
        XMLHttpRequestObject = new XMLHttpRequest();
    } 
        
    else if (window.ActiveXObject) {
        XMLHttpRequestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }

   

    var url = "http://localhost/sumc/index.php/nurse/procedure/"+id+"/"+v_id+"/"+suck;
   
    if(XMLHttpRequestObject) {
                
        XMLHttpRequestObject.open("GET", url);
                
        XMLHttpRequestObject.onreadystatechange = function(){
            
            if (XMLHttpRequestObject.readyState == 4 && XMLHttpRequestObject.status == 200) {
                window.close(this);
                
                window.opener.document.getElementById("procedures").innerHTML=XMLHttpRequestObject.responseText;
            }
        }
                
        XMLHttpRequestObject.send(null);
    }
}
</script>
