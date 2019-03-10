<?php if (count($errors)): ?>
	<?php echo $errors; ?>
<?php else: ?>
	<table class="table table-condensed table-bordered table-hover">
	<thead>
		<tr>
			<th></th>
			<th>15 <sup>th</sup></th>
			<th>30 <sup>th</sup></th>
		</tr>
	</thead>
		<tr>
			<td class='col-lg-5 col-md-5 col-sm-5 text-right'><strong>Net Salary </strong></th>
			<td> <?php echo nf($member->salary_15);?> </td>
			<td> <?php echo nf($member->salary_30);?> </td>
		</tr>
		<tr>
			<td class='col-lg-5 col-md-5 col-sm-5 text-right'><strong>Amortization </strong></th>
			<td> <?php echo nf($member->total_amortization_15);?> </td>
			<td> <?php echo nf($member->total_amortization_30);?> </td>
		</tr>
		<tr>
			<td class='col-lg-5 col-md-5 col-sm-5 text-right'><strong>Total Loan</strong></th>
			<td colspan="2"> <?php echo nf($member->total_loans);?> </td>
		</tr>
		<tr>
			<td class='col-lg-5 col-md-5 col-sm-5 text-right'><strong>Payments </strong></th>
			<td colspan="2"> 
				<?php echo nf($member->total_loan_payments);?> 
                <div class="progress xs progress-stripped">
                    <div class="progress-bar progress-bar" style="width: <?php echo nf(($member->total_loan_payments / $member->total_loans) * 100, 2)  ?>%">
                    </div>
                </div>
			</td>
		</tr>
		<tr>
			<td class='col-lg-5 col-md-5 col-sm-5 text-right'><strong>Balance </strong></th>
			<td colspan="2">
				<?php echo nf($member->total_loans - $member->total_loan_payments) ?>
			</td>
		</tr>
		
		
	</table>
	<div class="btn-group">
	<?php echo btn_achor('member/'. $member->member_id . '/edit', '<i class="fa fa-user"></i> Edit Information', 'class="btn btn-default" target="_blank"');?>
	<?php echo btn_achor('loan_receivable/'. $member->member_id . '/member', '<i class="fa fa-bar-chart-o"></i> View Ledger', 'class="btn btn-primary" target="_blank"');?>
	</div>
<?php endif ?>