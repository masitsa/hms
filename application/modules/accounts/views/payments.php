

  <div class="row">
      <div class="col-md-12">


        <!-- Widget -->
        <div class="widget boxed">
              <!-- Widget head -->
              <div class="widget-head">
                <h4 class="pull-left"><i class="icon-reorder"></i><?php echo $patient;?></h4>
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
                      <?php
                          $error = $this->session->userdata('error_message');
                          $success = $this->session->userdata('success_message');
                          
                          if(!empty($error))
                          {
                            echo '<div class="alert alert-danger">'.$error.'</div>';
                            $this->session->unset_userdata('error_message');
                          }
                          
                          if(!empty($success))
                          {
                            echo '<div class="alert alert-success">'.$success.'</div>';
                            $this->session->unset_userdata('success_message');
                          }
                       ?>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-7">
                                <div class="row">
                                 <div class="col-md-12">
                  							   <div class="widget-head">
                  								  <h4 class="pull-left"><i class="icon-reorder"></i>Invoices Charges</h4>
                  								  <div class=" pull-right">
                  									 <a href="<?php echo site_url();?>/accounts/print_invoice/<?php echo $visit_id;?>" target="_blank" class="btn btn-sm btn-success pull-right" >Print Invoice</a>

                  								  </div>
                  								  <div class="clearfix"></div>
                  								</div> 
                                  <table class="table table-hover table-bordered col-md-12">
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
                                      $credit_note_amount = $this->accounts_model->get_sum_credit_notes($visit_id);
                                      $debit_note_amount = $this->accounts_model->get_sum_debit_notes($visit_id);
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
                                          $total_amount = $total ;
                                          ?>
                                          <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total :</td>
                                            <td> <?php echo number_format($total_amount,2);?></td>
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

                                <!-- END OF FIRST ROW -->

                                 <div class="row" style= "margin-top:2em">
                                  <div class="col-md-12">
                                  <div class="widget-head">
                                    <h4 class="pull-left"><i class="icon-reorder"></i>Debit / Credit Notes</h4>
                                    <div class=" pull-right">
                                    </div>
                                    <div class="clearfix"></div>
                                  </div> 
                                  <table class="table table-hover table-bordered col-md-12">
                                    <thead>
                                    <tr>
                                      <th>Time</th>
                                      <th>Debit</th>
                                      <th>Credit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     <?php
                                      $payments_rs = $this->accounts_model->payments($visit_id);
                                      $total_payments = 0;
                                      $total_amount = ($total + $debit_note_amount) - $credit_note_amount;
                                      if(count($payments_rs) > 0){
                                        $x=0;
                                        
                                        foreach ($payments_rs as $key_items):
                                          $x++;
                                          $payment_method = $key_items->payment_method;
                                          $amount_paid = $key_items->amount_paid;
                                          $time = $key_items->time;
                                          $payment_type = $key_items->payment_type;
                                          $amount_paidd = number_format($amount_paid,2);
                                         
                                          if($payment_type == 2)
                                          {
                                              $type = "Debit Note";
                                              $amount_paidd = $amount_paidd;
                                          
                                              ?>
                                              <tr>
                                                <td><?php echo $time;?></td>
                                                <td><?php echo $amount_paidd;?></td>
                                                <td></td>
                                              </tr>
                                              <?php
                                          }
                                          else if($payment_type == 3)
                                          {
                                               $type = "Credit Note";
                                               $amount_paidd = "($amount_paidd)";
                                          
                                              ?>
                                              <tr>
                                                <td><?php echo $time;?></td>
                                                <td></td>
                                                <td><?php echo $amount_paidd;?></td>
                                              </tr>
                                              <?php
                                          }
                                          

                                        endforeach;
                                           ?>
                                            <tr>
                                              <td>Totals</td>
                                              <td><?php echo number_format($debit_note_amount,2);?></td>
                                              <td><?php echo number_format($credit_note_amount,2);?></td>
                                            </tr>
                                            <tr>
                                              <td colspan="2">Difference </td>
                                              <td><?php echo number_format($debit_note_amount - $credit_note_amount,2);?></td>
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
                                <!-- END OF SECON ROW -->
                                 <div class="row" style= "margin-top:2em">
                                  <div class="col-md-12">
                  								<div class="widget-head">
                  								  <h4 class="pull-left"><i class="icon-reorder"></i>Receipts</h4>
                  								  <div class=" pull-right">
                  									<!-- <a href="<?php echo site_url();?>/accounts/print_receipt/<?php echo $visit_id;?>" target="_blank" class="btn btn-sm btn-primary pull-right" >Print Receipt A5</a> -->
                  									<a href="<?php echo site_url();?>/accounts/print_receipt_new/<?php echo $visit_id;?>" target="_blank" class="btn btn-sm btn-primary pull-right" style="margin-right:10px;" >Print Receipt</a>
                  								  </div>
                  								  <div class="clearfix"></div>
                  								</div> 
                                  <table class="table table-hover table-bordered col-md-12">
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
                                      $total_amount = ($total + $debit_note_amount) - $credit_note_amount;
                                      if(count($payments_rs) > 0){
                                        $x=0;
                                        
                                        foreach ($payments_rs as $key_items):
                                          $x++;
                                          $payment_method = $key_items->payment_method;
                                          
                                          $time = $key_items->time;
                                          $payment_type = $key_items->payment_type;
                                          
                                          if($payment_type == 1)
                                          {
                                            $amount_paid = $key_items->amount_paid;
                                            $amount_paidd = number_format($amount_paid,2);
                                            ?>
                                            <tr>
                                              <td><?php echo $x;?></td>
                                              <td><?php echo $time;?></td>
                                              <td><?php echo $payment_method;?></td>
                                              <td><?php echo $amount_paidd;?></td>
                                            </tr>
                                            <?php
                                            $total_payments =  $total_payments + $amount_paid;
                                          }
                                         

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
                                <!-- END OF THIRD ROW -->
                                <div class="row" style= "margin-top:2em">
                                 <div class="col-md-12">
                                   <table class="table table-hover table-bordered">
                                    <tbody>
                                        <tr>
                                          <td colspan="3">Balance :</td>
                                          <td> <?php echo number_format(($total_amount - $total_payments),2) ;?></td>

                                        </tr>
                                    </tbody>
                                  </table>
                                    </div>
                                </div>
                                <!-- END OF FOURTH ROW -->
                              </div>
                              <!-- END OF THE SPAN 7 -->
                              <!-- START OF THE SPAN 5 -->
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
                                                <?php echo form_open("accounts/make_payments/".$visit_id.'/'.$close_page, array("class" => "form-horizontal"));?>

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
                                                  <div class="form-group">
                                                    <div class="center-align">
                                                      <input type="radio" name="type_payment" value="1" checked="checked">Normal
                                                      <input type="radio" name="type_payment" value="2"> Debit Note
                                                      <input type="radio" name="type_payment" value="3"> Credit Note
                                                      </div>
                                                  </div>
                                                 
                                                    <div class="center-align">
                                                      <button class="btn btn-info btn-lg" type="submit">Add Payment Information</button>
                                                    </div>
                                                    <?php echo form_close();?>
                                                </div>

                                             </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- Bill Methods -->
                                <div class="row">
                                    <div class="col-md-12">

                                      <!-- Widget -->
                                      <div class="widget boxed">
                                            <!-- Widget head -->
                                            <div class="widget-head">
                                              <h4 class="pull-left"><i class="icon-reorder"></i>Billing Method</h4>
                                              <div class="widget-icons pull-right">
                                                <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a>
                                              </div>
                                              <div class="clearfix"></div>
                                            </div>             

                                        <!-- Widget content -->
                                            <div class="widget-content">
                                                <div class="padd">
                                                <?php echo form_open("accounts/add_billing/".$visit_id.'/'.$close_page, array("class" => "form-horizontal"));?>

                                                  <div class="form-group">
                                                      <label class="col-lg-4 control-label">Select Method: </label>
                                                      
                                                      <div class="col-lg-8">
                                                        <select class="form-control" name="billing_method_id">
                                                          <option value="Select Billing Method">--- Select Billing Method ---</option>
                                                                  <?php
                                                             if($billing_methods->num_rows > 0)
                                                             {
                                                                $methods = $billing_methods->result();
                                                                foreach($methods as $res)
                                                                {
                                                                  $bill_to_id = $res->bill_to_id;
                                                                  $bill_to_name = $res->bill_to_name;
                                                                  
                                              if($bill_to == $bill_to_id)
                                              {
                                                                    echo '<option value="'.$bill_to_id.'" selected="selected">'.$bill_to_name.'</option>';
                                              }
                                              
                                              else
                                                                  {
                                                                    echo '<option value="'.$bill_to_id.'">'.$bill_to_name.'</option>';
                                              }
                                                                }
                                                              }
                                                          ?>
                                                            </select>
                                                      </div>
                                                  </div>
                                                    <div class="center-align">
                                                      <button class="btn btn-info btn-lg" type="submit">Add Billing Information</button>
                                                    </div>
                                                    <?php echo form_close();?>
                                                </div>

                                             </div>
                                        
                                        </div>
                                    </div>
                                </div>
                                <!-- End Bill Methods -->

                            </div>
                              <!-- END OF THE SPAN 5 -->
                          </div>
                        </div>
                        <div class="row " style= "margin-top:2em">
                        <div class="center-align">
                          <!-- redirect to unclosed accounts queue -->
                          <?php
                            if(isset($close_page))
                          {
                            ?>
                            <a href= "<?php echo site_url();?>/reception/end_visit/<?php echo $visit_id;?>/<?php echo $close_page;?>" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you want to end visit?\');">End Visit</a>
                              <?php
                          }
                          
                          else
                          {
                            ?>
                            <a href= "<?php echo site_url();?>/reception/end_visit/<?php echo $visit_id?>/1" class="btn btn-sm btn-danger" onclick="return confirm(\'Do you want to end visit?\');">End Visit</a>
                              <?php
                          }
                         ?>
                        </div>
                    </div>
                    <!-- END OF PADD -->
               </div>
          
          </div>

      </div>
      <!-- END OF DIV 12 -->

  </div>
  <!-- END OF ROW -->
