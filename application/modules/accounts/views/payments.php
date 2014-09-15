<?php echo form_open("accounts/make_payments/".$visit_id, array("class" => "form-horizontal"));?>

<div class="row">
	<div class="col-md-7">
        <div class="row">
            <div class="col-md-12">

              <!-- Widget -->
              <div class="widget boxed">
                    <!-- Widget head -->
                    <div class="widget-head">
                      <h4 class="pull-left"><i class="icon-reorder"></i>Payment Details</h4>
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
                               <p>Invoices Charges</p>
                                <table class="table table-hover table-bordered ">
                                  <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Charge</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $item_invoiced_rs = $this->accounts_model->get_patient_visit_charge_items($visit_id);
                                    if(count($item_invoiced_rs) > 0){
                                      $s=0;
                                      $total = 0;
                                      foreach ($item_invoiced_rs as $key_items):
                                        $s++;
                                        $service_charge_name = $key_items->service_charge_name;
                                        $visit_charge_amount = $key_items->visit_charge_amount;
                                        ?>
                                          <tr>
                                            <td><?php echo $s;?></td>
                                            <td><?php echo $service_charge_name;?></td>
                                            <td><?php echo $visit_charge_amount;?></td>
                                          </tr>
                                        <?php
                                          $total = $total + $visit_charge_amount;
                                      endforeach;
                                        ?>
                                        <tr>
                                          <td></td>
                                          <td>Total :</td>
                                          <td> <?php echo $total;?></td>
                                        </tr>
                                        <?php
                                    }else{
                                       ?>
                                        <tr>
                                          <td colspan="3"> No Charges</td>
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
                                <p>Payments</p>
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
                                    if(count($payments_rs) > 0){
                                      $x=0;
                                      $total_payments = 0;
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
                                          <td><?php echo $amount_paid;?></td>
                                        </tr>
                                        <?php
                                        $total_payments = $total_payments + $amount_paid;
                                      endforeach;
                                         ?>
                                        <tr>
                                          <td></td>
                                          <td></td>
                                          <td>Total :</td>
                                          <td> <?php echo $total_payments;?></td>
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


                        </div>

                     </div>
                
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">

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


    </div>
   
</div>

<?php echo form_close();?>