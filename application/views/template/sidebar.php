<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo site_url('public/img') ?>/avatar3.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, <?php echo $this->session->userdata('FirstName') ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="<?php echo $controller == 'dashboard' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('dashboard') ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'project' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('project'); ?>">
                    <i class="fa fa-laptop"></i> <span>Projects</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'combine_billing' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('combine_billing'); ?>">
                    <i class="fa fa-copy"></i> <span>Combine Project Billing</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'position' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('position'); ?>">
                    <i class="ion ion-android-star"></i> <span>Positions</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'manning_list' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('manning_list'); ?>">
                    <i class="ion ion-android-social"></i> <span>Manning List</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'case_emp' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('case_emp'); ?>">
                    <i class="ion ion-android-social"></i> <span>Employee Cases</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'deduction' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('deduction'); ?>">
                    <i class="ion ion-android-social"></i> <span>Deductions</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'manning_payroll' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('manning_payroll'); ?>">
                    <i class="ion ion-ios7-pricetag"></i> <span>Manning Payroll</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'sss_premium_contribution_matrix' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('sss_premium_contribution_matrix'); ?>">
                    <i class="ion ion-document-text"></i><span>SSS Contribution Matrix</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'pagibig_premium_contribution_matrix' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('pagIbig_premium_contribution_matrix'); ?>">
                    <i class="ion ion-document-text"></i><span>PAGIBIG Contribution Matrix</span>
                </a>
            </li>
            <li class="<?php echo $controller == 'philhealth_premium_contribution_matrix' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('philhealth_premium_contribution_matrix'); ?>">
                    <i class="ion ion-document-text"></i><span>PHILHEALTH Contribution Matrix</span>
                </a>
            </li>
             
            <!-- <li class="<?php echo $controller == 'employee' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('employee'); ?>">
                    <i class="ion ion-android-social"></i> <span>Employees</span>
                </a>
            </li> -->
            <?php if ($this->session->userdata('AccountType') === 'S') : ?>
            <li class="<?php echo $controller == 'user' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('user'); ?>">
                    <i class="ion-android-social-user"></i> <span>User Account</span>
                </a>
            </li>
            <?php endif; ?>
            
           <!--  <li class="<?php echo $controller == 'manning_list' ? 'active' : ''; ?>">
                <a href="<?php echo site_url('manning_list'); ?>">
                    <i class="fa fa-rub"></i> <span>Manning</span>
                </a>
            </li> -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span>Master Data</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo site_url('employment_status'); ?>"><i class="fa fa-angle-double-right"></i> <span>Employment Status </span></a></li>
                    <li><a href="<?php echo site_url('deduction_category') ?>"><i class="fa fa-angle-double-right"></i> Deduction Category</a></li>
                    <!-- <li><a href="<?php echo site_url('deduction') ?>"><i class="fa fa-angle-double-right"></i> Deduction</a></li> -->
                    <li><a href="<?php echo site_url('case_category') ?>"><i class="fa fa-angle-double-right"></i> Case Category</a></li>
                    <!-- <li><a href="charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li> -->
                </ul>
            </li>
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>