
<p class="margin">
	<label>Project Payroll Setting </label>
	<?= anchor('manning_payroll_setting/index/' . $project->project_id . '/' . $payroll->payroll_id, 'Change Setting', ['class' => 'btn btn-primary btn-xs pull-right']); ?>
</p>
	
<div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead>
			<tr>
				<th rowspan="2" width="60%">Wage</th>
				<th colspan="3" width="40%">Pay Period</th>
			</tr>
			<tr>
				<th width="15%">
					1<sup>st</sup>
					<p><code>1 time deduction</code></p>
				</th>
				<th width="15%">
					2<sup>nd</sup>
					<p><code>1 time deduction</code></p>
				</th>
				<th width="15%">
					Every Pay
					<p><code>(Total amount/2)</code></p>
				</th>
			</tr>
		</thead>
		<tbody>
			<!-- <tr>
				<th>Allowance</th>
				<td class="text-center">
					<?php $project->mode_of_payment_allowance == '1' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_allowance == '2' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_allowance == '3' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
			</tr> -->
			<tr>
				<th>PAGIBIG</th>
				<td class="text-center">
					<?php $project->mode_of_payment_pagibig == '1' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_pagibig == '2' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_pagibig == '3' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<th>PHILHEALTH</th>
				<td class="text-center">
					<?php $project->mode_of_payment_philhealth == '1' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_philhealth == '2' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_philhealth == '3' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
			</tr>
			<tr>
				<th>SSS</th>
				<td class="text-center">
					<?php $project->mode_of_payment_sss == '1' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_sss == '2' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
				<td class="text-center">
					<?php $project->mode_of_payment_sss == '3' ? $check = TRUE : $check = FALSE;?> 
					<?php if ($check): ?>
						<i class="fa fa-check-square-o fa-2x"></i>
					<?php endif ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>