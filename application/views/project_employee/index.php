<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
                    &nbsp;
                </h3>
                <p>
                    Project Billing
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-ios7-briefcase-outline"></i>
            </div>
            <a href="<?php echo base_url("projectBillingInfo/$project_id") ?>" class="small-box-footer">
                Show Billing Period <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    &nbsp;
                </h3>
                <p>
                    New Billing Period
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-android-star"></i>
            </div>
            <a href="<?php echo base_url('projectBillingInfo/'.$project_id.'/new') ?>" class="small-box-footer">
                Create Billing Period <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
                    &nbsp;
                </h3>
                <p>
                    Employees
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-android-social"></i>
            </div>
            <a href="<?php echo base_url('employee/new') ?>" class="small-box-footer">
                New Employee <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>
                    &nbsp;
                </h3>
                <p>
                    Positions
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url('position') ?>" class="small-box-footer">
                Show List of Positions <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div>


<div class="content">
	
<div class="row">
	<div class="box box-primary">
	    
		<?php $this->load->view('project_employee\positions'); ?>

	</div><!-- /.box -->
</div>
<div class="row">
	<div class="box box-primary">

	    <?php $this->load->view('project_employee\employees'); ?>

	</div><!-- /.box -->
</div>
</div>



