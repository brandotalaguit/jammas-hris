<label>Project Information</label>
<div class="table-responsive pad">
	<table class="table table-hover table-bordered">
		<tbody>
			<tr>
				<th width="20%">Description</th>
				<td><?= $project->description ?></td>
			</tr>
			<tr>
				<th width="20%">Address</th>
				<td><?= $project->address ?></td>
			</tr>
			<tr>
				<th width="20%">P.O. No.</th>
				<td><?= $project->po ?></td>
			</tr>
			<tr>
				<th width="20%">TIN</th>
				<td><?= $project->tin ?></td>
			</tr>
		</tbody>
	</table>
</div>
<label>Payroll Information</label>
<div class="table-responsive pad">
	<table class="table table-hover table-bordered">
		<tbody>
			<tr>
				<th width="20%">Pay Period</th>
				<td><?= $payroll->payroll_period ?></td>
			</tr>
			<tr>
				<th width="20%">Coverage</th>
				<td><samp><?= proper_date($payroll->date_start) ?></samp> to <samp><?= proper_date($payroll->date_end) ?></samp></td>
			</tr>
		</tbody>
	</table>
</div>
