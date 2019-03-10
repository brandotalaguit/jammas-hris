<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php echo form_open(NULL, 'class="form-horizontal"'); ?>
<label for="manning_id" class="col-sm-1 control-label">Employee</label>
<div class="form-group">
    <div class="col-sm-6">

        <?php echo form_dropdown(
                                    'manning_id[]',
                                    $employees,
                                    NULL,
                                    'id="manning_id" class="form-control multiple-select2" multiple="multiple"  style="width:100%" required="required"');
            ?>

    </div>
</div>

<label for="payroll_period" class="col-sm-1 control-label">Period</label>
<div class="form-group">
    <div class="col-sm-6">

        <?php echo form_dropdown(
                                    'payroll_period[]',
                                    array('1' => '1st Period', '2' => '2nd Period'),
                                    NULL,
                                    'id="payroll_period" class="form-control multiple-select2" multiple="multiple"  style="width:100%" required="required"');
            ?>

    </div>
</div>

<label for="payroll_year" class="col-sm-1 control-label">Payroll Year</label>
<div class="form-group">

    <div class="col-sm-2">
        <input type="numeric" name="payroll_year" id="payroll_year" class="form-control" required="required" title="Payroll Year">
    </div>

    <label for="payroll_month" class="col-sm-1 control-label">Month</label>
    <div class="col-sm-3">
    <?php
        echo form_dropdown(
                'payroll_month',
                $months,
                NULL,
                'id="select2_payroll_month" class="form-control" autofocus style="width:100%"'
            );
        ?>
    </div>

</div>
<div class="row">
<div class="col-sm-offset-1 col-sm-2">
    <button type="submit" id="btn_action" name="btn_action" value="Search" class="btn btn-primary btn-block">
    Search
    </button>
</div>
<div class="col-sm-2">
    <?php echo anchor('manning_payroll/employee_deduction', 'Reset Search', ['class' => 'btn btn-default btn-block']); ?>
</div>

</div>
<?php echo form_close(); ?>
<?php if (count($list)): ?>
<?php echo form_open('manning_payroll/recompute_employee_deduction', 'class="form-horizontal"', $hidden); ?>

<div class="box">
<div class="box-body table-responsive no-padding">

<table class="table table-hover table-condensed table-bordered">
	<thead>
		<tr>
			<th rowspan="2">&nbsp;</th>
			<th rowspan="2">Lastname</th>
			<th rowspan="2">Firstname</th>
			<th rowspan="2">Middlename</th>
			<th rowspan="2">Project</th>
			<th rowspan="2">Payroll</th>
			<th rowspan="2">Basic</th>
			<th colspan="3">PhilHealth</th>
			<th colspan="3">PAGIBIG</th>
			<th colspan="4">SSS</th>
		</tr>
		<tr>
			<th>EE</th>
			<th>ER</th>
			<th>Total</th>
			<th>EE</th>
			<th>ER</th>
			<th>Total</th>
			<th>EE</th>
			<th>ER</th>
			<th>EC</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($list as $row): ?>
			<tr>
				<td><?php echo form_checkbox('manning_payroll_deduction_id[]', $row->manning_payroll_deduction_id); ?></td>
				<td><?php echo $row->lastname ?></td>
				<td><?php echo $row->firstname ?></td>
				<td><?php echo $row->middlename ?></td>
				<td><?php echo $row->title ?></td>
				<td><?php echo $row->payroll_month . ' ' . $row->payroll_year . '<br>'
				 . ' (' . $row->payroll_period . ' cut-off' . ' ' . php_date($row->date_start, 'M. d') . ' to ' . php_date($row->date_end, 'M. d') . ')<br>' ;
				 echo anchor('manning_payroll/earning/' . $row->payroll_id , 'Earning', ['class' => 'btn-link', 'target' => '_blank']);
				 echo ' | ' . anchor('manning_payroll/print_payroll/' . $row->payroll_id , 'Payroll', ['class' => 'btn-link', 'target' => '_blank']);
				 ?></td>
				<td><?php echo nf($row->biweekly_basic); ?></td>
				<td><?php echo $row->employee_share_philhealth; ?></td>
				<td><?php echo $row->employer_share_philhealth; ?></td>
				<td><?php echo $row->total_monthly_premium_philhealth; ?></td>
				<td><?php echo $row->employee_share_pagibig; ?></td>
				<td><?php echo $row->employer_share_pagibig; ?></td>
				<td><?php echo $row->total_monthly_premium_pagibig; ?></td>
				<td><?php echo $row->employee_share_sss; ?></td>
				<td><?php echo $row->employer_share_sss; ?></td>
				<td><?php echo $row->employee_compensation_program_sss; ?></td>
				<td><?php echo $row->total_monthly_premium_sss; ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
</div>
<div class="box-footer clearfix">
<p>
<?php echo form_submit('submit', 'Update Selected Employee Deduction', 'class ="btn btn-info"'); ?>
</p>

</div>
<?php endif ?>
</div>
<?php echo form_close(); ?>
