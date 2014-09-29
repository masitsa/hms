<div class="row statistics">
  <div class="col-md-6 col-sm-6">
      <ul class="today-datas">
          <!-- List #1 -->
          <li class="overall-datas">
              <!-- Graph -->
              <div class="pull-left visual bred"><span id="patients_per_day" class="spark"></span></div>
              <!-- Text -->
              <div class="datas-text pull-right">Total Visits <span class="bold"><?php echo number_format($total_patients, 0);?></span></div>

              <div class="clearfix"></div>
          </li>
      </ul>
  </div>
  <div class="col-md-6 col-sm-6">
      <ul class="today-datas">
          <li class="overall-datas" style="height:64px;">
              <!-- Graph -->
              <!-- <div class="pull-left visual bgreen"><span id="payment_methods" class="spark"></span></div>-->
              <!-- Text -->
              <div class="datas-text pull-right">Total Revenue <span class="bold">KSH <?php echo number_format($total_revenue, 2);?></span></div>

              <div class="clearfix"></div>
          </li>
      </ul>
  </div>
</div>