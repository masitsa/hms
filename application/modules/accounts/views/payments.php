<?php echo form_open("accounts/make_payments/".$visit_id, array("class" => "form-horizontal"));?>

<div class="row">
	<div class="col-md-7">
              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Payment details for <?php echo $patient;?></h4>
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
                               <h4 class="pull-left">Invoices Charges</h4>
                               <a href="<?php echo site_url();?>/accounts/print_invoice/<?php echo $visit_id;?>" target="_blank" class="btn btn-sm btn-success pull-right" >Print Invoice</a>
                                <table class="table table-hover table-bordered ">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Service</th>
                                    <th>Item Name</th>
                                    <th>Charge</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $item_invoiced_rs = $this->accounts_model->get_patient_visit_charge_items($visit_id);
                                    $total = 0;
                                    if(count($item_invoiced_rs) > 0){
                                      $s=0;
                                      
                                      foreach ($item_invoiced_rs as $key_items):
                                        $s++;
                                        $service_charge_name = $key_items->service_charge_name;
                                        $visit_charge_amount = $key_items->visit_charge_amount;
                                        $service_name = $key_items->service_name;
                                         $units = $key_items->visit_charge_units;

                                         $visit_total = $visit_charge_amount * $units;

                                        ?>
                                          <tr>
                                            <td><?php echo $s;?></td>
                                            <td><?php echo $service_name;?></td>
                                            <td><?php echo $service_charge_name;?></td>
                                            <td><?php echo number_format($visit_total,2);?></td>
                                          </tr>
                                        <?php
                                          $total = $total + $visit_total;
                                      endforeach;
                                        ?>
                                        <tr>
                                          <td></td>
                                          <td></td>
                                          <td>Total :</td>
                                          <td> <?php echo number_format($total,2);?></td>
                                        </tr>
                                        <?php
                                    }else{
                                       ?>
                                        <tr>
                                          <td colspan="4"> No Charges</td>
                                        </tr>
                                        <?php
                                    }

                                    ?>
                                      
                                  </tbody>
                                </table>
                                </div>
                              </div>
                              <br>
                               <div class="row">
                                <div class="col-md-12">
                                  <h4 class="pull-left">Receipts</h4>
                                    <a href="<?php echo site_url();?>/accounts/print_receipt/<?php echo $visit_id;?>" target="_blank" class="btn btn-sm btn-primary pull-right" >Print Receipt</a>
                                <table class="table table-hover table-bordered ">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Time</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                   <?php
                                    $payments_rs = $this->accounts_model->payments($visit_id);
                                    $total_payments = 0;
                                    if(count($payments_rs) > 0){
                                      $x=0;
                                      
                                      foreach ($payments_rs as $key_items):
                                        $x++;
                                        $payment_method = $key_items->payment_method;
                                        $amount_paid = $key_items->amount_paid;
                                        $time = $key_items->time;
                                        ?>
                                        <tr>
                                          <td><?php echo $x;?></td>
                                          <td><?php echo $time;?></td>
                                          <td><?php echo $payment_method;?></td>
                                          <td><?php echo number_format($amount_paid,2);?></td>
                                        </tr>
                                        <?php
                                        $total_payments = $total_payments + $amount_paid;

                                      endforeach;
                                         ?>
                                        <tr>
                                          <td></td>
                                          <td></td>
                                          <td>Total :</td>
                                          <td> <?php echo number_format($total_payments,2);?></td>
                                        </tr>
                                        <?php
                                      }else{
                                        ?>
                                        <tr>
                                          <td colspan="4"> No payments made yet</td>
                                        </tr>
                                        <?php
                                      }
                                      ?>
                                  </tbody>
                                </table>
                               
                                </div>

                              </div>
                              <br>
                              <div class="row">
                               <div class="col-md-12">
                                 <table class="table table-hover table-bordered">
                                  <tbody>
                                      <tr>
                                        <td colspan="3">Balance :</td>
                                        <td> <?php echo number_format(($total - $total_payments),2) ;?></td>

                                      </tr>
                                  </tbody>
                                </table>
                                  </div>
                              </div>


                        </div>

                     </div>
                
                </div>
                
    </div>
    <div class="col-md-5">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Add Payment</h4>
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
                              <label class="col-lg-4 control-label">Amount: </label>
                              
                              <div class="col-lg-8">
                                <input type="text" class="form-control" name="amount_paid" placeholder="">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-4 control-label">Payment Method: </label>
                              
                              <div class="col-lg-8">
                                <select class="form-control" name="payment_method">
                                          <?php
                                      $method_rs = $this->accounts_model->get_payment_methods();
                                      $num_rows = count($method_rs);
                                     if($num_rows > 0)
                                      {
                                        
                                        foreach($method_rs as $res)
                                        {
                                          $payment_method_id = $res->payment_method_id;
                                          $payment_method = $res->payment_method;
                                          
                                            echo '<option value="'.$payment_method_id.'">'.$payment_method.'</option>';
                                          
                                        }
                                      }
                                  ?>
                                    </select>
                              </div>
                          </div>
                            <div class="center-align">
                              <button class="btn btn-info btn-lg" type="submit">Add Payment Information</button>
                            </div>
                        </div>

                     </div>
                
                </div>


    </div>
   
</div>
<div class="row">
  <div class="center-align">
    <a href= "<?php echo site_url();?>/reception/end_visit/<?php echo $visit_id?>/1" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you want to end visit?\');">End Visit</a>
  </div>
</div>

<?php echo form_close();?>