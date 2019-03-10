<style type="text/css">
    .modal-dialog {
        width: 85%; /* respsonsive width */
    }
</style>
<div class="modal-dialog">
    <div class="modal-content">


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">
        <?php echo t($employee->lastname) . ', ' . t($employee->firstname) . ' ' . t($employee->middlename) . ' ' . t($employee->employee_no); ?>
    </h4>
</div>
<?php // echo $form_url; ?>

    <div class="modal-body">
        <?php if (count($payroll)): ?>
            <?php $total = 0.00; $cntr = 1; ?>
            <div class="table-responsive">
                <h5>Period</h5>
                <p>
                    <b>From</b> <?php echo date('M. d, Y', strtotime($_POST['date_start'])) ?>
                    <b>to</b> <?php echo date('M. d, Y', strtotime($_POST['date_end'])) ?>

                </p>
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Project</th>
                            <th rowspan="2">Date Printed</th>
                            <th rowspan="2">Cut-Off</th>
                            <th rowspan="2">Period</th>
                            <th rowspan="2">Position</th>
                            <th rowspan="2">Display<br>In Payroll</th>
                            <th colspan="4">Basic</th>
                            <th rowspan="2">13th Month</th>
                        </tr>
                        <tr>
                            <th>Hours</th>
                            <th>Day</th>
                            <th>Semi-Month</th>
                            <th>Month</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payroll['project_data'] as $row): ?>
                        <tr>
                            <td><?php echo $cntr++; ?></td>
                            <td><?php echo $row->title ?></td>
                            <td><?php echo date('M. d, Y', strtotime($row->payroll_date)); ?></td>
                            <td><?php echo $row->payroll_period ?></td>
                            <td><?php echo date('M. d, y', strtotime($row->date_start)) . '<br>' . date('M. d, y', strtotime($row->date_end)); ?></td>
                            <td>
                                <?php
                                    echo $row->position;
                                    if ($row->r_employment_status_id == RELIEVER)
                                    echo '<br><code>RELIEVER</code>';
                                    if ($row->r_employment_status_id == EXTRA_RELIEVER)
                                    echo '<br><code>EXTRA RELIEVER</code>';

                                ?>

                            </td>
                            <td class="text-center"><?php $row->r_13thmonth == 0 OR print "<i class='fa fa-check-circle'></i>"; ?></td>
                            <td class="text-right"><?php echo nf($row->r_hourly_rate1) ?></td>
                            <td class="text-right"><?php echo nf($row->r_daily_rate1) ?></td>
                            <td class="text-right"><?php echo nf($row->r_semi_monthly_rate1) ?></td>
                            <td class="text-right"><?php echo nf($row->r_monthly_rate1) ?></td>
                            <td class="text-right">
                                <?php
                                    $r_semi_monthly_rate = get_key($row, 'r_semi_monthly_rate', 0);
                                    $r_monthly_rate = get_key($row, 'r_monthly_rate', 0);
                                    $r_daily_rate = get_key($row, 'r_daily_rate', 0);
                                    $r_hourly_rate = get_key($row, 'r_hourly_rate', 0);
                                    $r_13thmonth = ($r_semi_monthly_rate + $r_monthly_rate + $r_daily_rate + $r_hourly_rate);
                                    // $amount = get_key($row,'r_13thmonth', 0);
                                    $total += $r_13thmonth;
                                    echo nf($r_13thmonth);
                                ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right lead" colspan="11">Total</th>
                            <th class="text-right lead" colspan="1"><?php echo nf($total) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong> <i class="fa fa-exclamation-circle"></i> No Record Found.</strong>
        </div>
        <?php endif ?>


    </div>


    <div class="modal-footer clearfix">

    <div class="row">
    <div class="col-md-offset-10 col-md-2">
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal"><b>CLOSE</b></button>
    </div>
    </div>
    </div>
<?php echo form_close(); ?>

    </div>
</div>
