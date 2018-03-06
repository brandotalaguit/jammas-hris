<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<h4>Update Result: </h4>
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
		<?php $ctr = 1; ?>
		<?php foreach ($list as $row): ?>
			<tr>
				<td><?php echo $ctr++; ?></td>
				<td><?php echo $row->lastname ?></td>
				<td><?php echo $row->firstname ?></td>
				<td><?php echo $row->middlename ?></td>
				<td><?php echo $row->title ?></td>
				<td><?php echo $row->payroll_month . ' ' . $row->payroll_year . '<br>'
				 . ' (' . $row->payroll_period . ' cut-off' . ' ' . php_date($row->date_start, 'M. d') . ' to ' . php_date($row->date_end, 'M. d') . ')' ;
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
<?php echo anchor('manning_payroll/employee_deduction', 'Back', ['class' => 'btn btn-primary btn-lg btn-block']); ?>