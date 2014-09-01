<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->load->view('includes/header');?>
</head>

<body>
	<input type="hidden" id="config_url" value="<?php echo site_url();?>"/>
	<?php echo $this->load->view('includes/navigation');?>

    <!-- Main content starts -->
    
    <div class="content">
    
        <!-- Sidebar -->
        <?php echo $this->load->view('includes/sidebar');?>
        <!-- Sidebar ends -->
        
        <!-- Main bar -->
        <div class="mainbar">
        
            <!-- Page heading -->
            <?php echo $this->load->view('includes/breadcrumbs');?>
            <!-- Page heading ends -->
            
            <!-- Matter -->
            
            <div class="matter">
                <div class="container">
                
                    <!-- Today status. jQuery Sparkline plugin used. -->
                    <?php echo $this->load->view('administration/summary');?>
                    <!-- Today status ends -->
                    
                    <div class="row">
                        <div class="col-md-12">
                        <?php echo $this->load->view('administration/line_graph');?>
                        </div>
                    </div>  
                    
                    <!-- Dashboard Graph starts -->
                    <?php echo $this->load->view('administration/bar_graph');?>
                    <!-- Dashboard graph ends -->
                    
                    <!-- Calendar and Logs -->
                    <div class="row">
                        <div class="col-md-6">
                        <?php echo $this->load->view('administration/calender');?>
                        </div>
                        <div class="col-md-6">
                        <?php echo $this->load->view('administration/logs');?>
                        </div>
                    </div>
                
                </div>
            </div>
            
            <!-- Matter ends -->
        
        </div>
        
        <!-- Mainbar ends -->	    	
        <div class="clearfix"></div>
    
    </div>
    <!-- Content ends -->

	<?php echo $this->load->view('includes/footer');?>
</body>
</html>