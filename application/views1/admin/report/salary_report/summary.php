<table class="table table-bordered" border="1">
	<thead>
		<tr>
			<th colspan="7">
				University of Makati Employees Multi-Purpose Cooperative
				<br>Payroll Deduction
				<br>
				From <?php echo date('m/d/Y', strtotime($salary_report->date_start)); ?> 
				to <?php echo date('m/d/Y', strtotime($salary_report->date_end)); ?>
			</th>
		</tr>
		<tr>
			<th width='2%'>#</th>
			<th width='15%'>NAME</th>
			<th width='15%'>EMPLOYMENT STATUS</th>
			<th width='20%'>LOAN RECEIVABLE</th>
			<th width='20%'>ACCOUNT RECEIVABLE</th>
			<th width='8%'>TOTAL</th>
			<th width='10%'>CASH</th>
		</tr>
	</thead>
	<tbody>

		<?php $counter = 1; ?>
		<?php $amortizationtotal = 0; ?>
		<?php $accountReceivableTotal = 0; ?>
		
		<?php if (count($loans)): ?>
			<?php foreach ($loans as $loan): ?>
				<tr>
					<td><?php echo $counter ?></td>
					<td>
					<?php 
						echo t($loan->lastname) . ', ' . t($loan->firstname) . ' ' . t($loan->middlename);
					?>
					</td>
					<td><?php echo t($loan->employment_status); ?></td>
					<td>
						<?php echo nf($loan->amortization) ?>
					</td>
					<td>
						<?php echo nf($loan->account_receivable) ?>
					</td>
					<td style='font-weight:bold'>
						<?php echo nf($loan->account_receivable + $loan->amortization) ?>
					</td>
					<td>&nbsp;</td>
				</tr>


			<?php $amortizationtotal += $loan->amortization ?>			
			<?php $accountReceivableTotal += $loan->account_receivable ?>
			<?php $counter++; ?>
			<?php endforeach ?>

				</tbody>


				<tfoot>
					<tr>
						<th colspan='3'>Total Collection</th>
						<td style='font-weight:bold'><?php echo nf($amortizationtotal); ?></td>
						<td style='font-weight:bold'><?php echo nf($accountReceivableTotal); ?></td>
						<td style='font-weight:bold'><?php echo nf($amortizationtotal + $accountReceivableTotal); ?></td>
					</tr>
				</tfoot>


		<?php else: ?>
				<tr>
					<td colspan="6">
						<span class="label label-danger">No record found!.</span>
					</td>
				</tr>
		<?php endif ?>
	
</table>