      <div class="row">
        <div class="col-md-12">
              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Procedure List</h4>
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
                                <div class="col-md-12">
                                	<?php 
									$validation_error = validation_errors();
									
									if(!empty($validation_error))
									{
										echo '<div class="alert alert-danger">'.$validation_error.'</div>';
									}
									echo form_open('nurse/search_procedures/'.$visit_id, array('class'=>'form-inline'));
									?>
                                    <div class="form-group">
                                            <?php
											$search = $this->session->userdata('procedure_search');
                                            if(!empty($search))
											{
											?>
                                            <a href="<?php echo site_url().'/nurse/close_procedure_search/'.$visit_id;?>" class="btn btn-warning pull-right">Close Search</a>
                                            <?php }?>
                                        	<input type="submit" class="btn btn-info pull-right" value="Search" name="search"/>
                                            
                                        <div class="input-group">
                                            <input type="text" class="form-control col-md-6" name="search_item" placeholder="Search for a procedure">
                                        </div>
                                    </div>
                                        
                                        <input type="hidden" value="<?php echo $visit_id?>" name="visit_id">
                                        
                                    <?php echo form_close();?>
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-md-12">
                                    <table border="0" class="table table-hover table-condensed">
                                        <thead> 
                                            <th> Name</th>
                                            <th>Class</th>
                                            <th>Generic</th>
                                            <th>Brand</th>
                                        </thead>
                            
                                        <?php 
                                        //echo "current - ".$current_item."end - ".$end_item;
                                        
                                        $rs9 = $query->result();
                                        foreach ($rs9 as $rs10) :
                                        
                                        
	                                       	$service_charge_id = $rs10->service_charge_id;
											$drugname = $rs10->service_charge_name;
											$drugsclass = $rs10->class_name;
											$drugscost = $rs10->service_charge_amount;
											$generic_name = $rs10->generic_name;
											$brand_name = $rs10->brand_name;
											$visit_type_idv = $rs10->visit_type_id;
                                        
                                        ?>
                                       <tr>
							            <tr> </tr>
							        		<td><a onClick="close_drug('<?php echo $drugname;?>', <?php echo $visit_id?>, <?php echo $service_charge_id;?>)" href="#"><?php echo $drugname?></a></td>
							                <td><?php echo $drugsclass;?></td>
							         
							                <td><?php echo $generic_name;?></td>
							                <td><?php echo $brand_name;?></td>
							                <td><?php echo $drugscost;?></td>
							        	</tr>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                        
                    <div class="widget-foot">
                    <?php
                    if(isset($links)){echo $links;}
                    ?>
                    </div>
                 </div>
            </div>
        </div>
<script type="text/javascript">
  
function close_drug(val, visit_id, service_charge_id){


	var config_url = $('#config_url').val();
	window.open(config_url+"/pharmacy/prescription/"+visit_id+"/"+service_charge_id,"Popup","height=1200,width=1300,,scrollbars=yes,"+ 
                        "directories=yes,location=yes,menubar=yes," + 
                         "resizable=no status=no,history=no top = 50 left = 100"); 
}
</script>
