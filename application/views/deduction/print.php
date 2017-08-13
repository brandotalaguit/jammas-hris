<div class="box matrix">
	<table class="table table-condensed table-hover">

			<tbody>
				<tr>
					<th width='3%'>#</th>
					<th width='9%'>Date Filed</th>
					<th width='20%'>Employee Name</th>
					<th width='10%'>Position</th>
					<th width='10%'>Category</th>
					<th width='9%'>Coverage Start</th>
					<th width='9%'>Coverage End</th>
					
					<th width='10%'>Mode of Payment</th>
					<th width='10%'>Payment Type</th>
					<th width='10%'>Amount</th>
					
				</tr>

				<?php if (count($deductions)): ?>
					<?php foreach ($deductions as $deduction): ?>
						<tr <?php echo $this->session->flashdata('id') == $deduction->deduction_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo date_convert_to_php($deduction->date_filed, "M d, Y");?></td>
							<td><?php echo $deduction->lastname . ', ' . $deduction->firstname . ' ' . $deduction->middlename;?></td>
							<td><?php echo $deduction->position; ?></td>
							<td><?php echo $deduction->deduction_category;?></td>
							<td><?php echo date_convert_to_php($deduction->coverage_date_start, "M d, Y"); ?></td>
							<td><?php echo date_convert_to_php($deduction->coverage_date_end, "M d, Y");?></td>
							<td><?php
								if($deduction->mode_of_payment == 1)
									echo 'Beginning of Month';
								else if($deduction->mode_of_payment == 2)
									echo 'Every Pay';
								else  if($deduction->mode_of_payment == 3)								
									echo 'End of Month';
								?>	
							</td>
							<td><?php
								if($deduction->payment_type == 1)
									echo 'Fixed Amount';
								else if($deduction->payment_type == 2)
									echo 'Percentage';
								?>	
							</td>
							<td>
								<?php
								if($deduction->payment_type == 1)
									echo nf($deduction->fixed_amount);
								else if($deduction->payment_type == 2)
									echo nf($deduction->percentage) . '%';
								?>
							</td>
							
						</tr>
					<?php endforeach ?>
				<?php else: ?>
						<tr>
							<td colspan="7">
								<span class="label label-danger">No record found!.</span>
							</td>
						</tr>
				<?php endif ?>
			</tbody>
        </table>
</div>