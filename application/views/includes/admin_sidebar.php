<div class="sidebar sidebar-fixed">
        <div class="sidebar-dropdown"><a href="#">Navigation</a></div>

        <div class="sidebar-inner">
		
            <!--- Sidebar navigation -->
            <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
            <ul class="navi">

                <!-- Use the class nred, ngreen, nblue, nlightblue, nviolet or norange to add background color. You need to use this in <li> tag. -->
                <li class="current"><a href="<?php echo site_url();?>/administration"><i class="icon-list"></i> Dashboard</a></li>
                <li class="current"><a href="<?php echo site_url();?>/control-panel/<?php echo $this->session->userdata('personnel_id');?>"><i class="icon-home"></i> Control Panel</a></li>
                
                <!--<li class="current"><a href="<?php echo base_url();?>index.php/welcome/control_panel/<?php echo $this->session->userdata('personnel_id');?>"><i class="icon-list"></i> Appointments</a></li>-->
                
                <li class="current"><a href="<?php echo site_url();?>/administration/reports/all_transactions"><i class="icon-list"></i> Reports</a></li>

                <!-- Menu with sub menu -->
             <li class="has_submenu">
                    <a href="#">
                        <i class="icon-th"></i> Administration
                    </a>
                    <ul>
                        <li><a href="<?php echo site_url();?>/reception/appointment_list">Services</a></li>
                    </ul>
                </li>

            </ul>

        </div>
    </div>