NQ8KQ7YM
<h3>
	<?php echo $member->lastname . ', ' . $member->firstname . ' ' . $member->middlename; ?>
	<small>
		<?php echo $member->account_no; ?>
		(<?php echo t($member->office_description); ?>)
	</small>
</h3>

<table class="table table-hover table-bordered">
	<thead>
		<tr>			
			<th rowspan="2" width='8%'>TYPE</th>
			<th rowspan="2" width='5%'>CV NO.</th>
			<th rowspan="2" width='5%'>CHECK</th>
			<th colspan="2" class="text-center">SCHEDULE</th>
			<th rowspan="2" width='5%' class='text-right'>PRINCIPAL</th>
			<th colspan="2" class="text-center">AMORTIZATION</th>
			<th rowspan="2" width='3%' class='text-right'>LOAN</th>
			<th rowspan="2" width='3%' class='text-right'>PAYMENT</th>
			<th rowspan="2" width='3%' class='text-right'>BALANCE</th>
		</tr>
		<tr>
			<th rowspan="1" width='5%'>FROM</th>
			<th rowspan="1" width='5%'>TO</th>
			<th rowspan="1" width='3%' class='text-right'>15<sup>th</sup></th>
			<th rowspan="1" width='3%' class='text-right'>30<sup>th</sup></th>
		</tr>
	</thead>
	<tbody>

		<?php $counter = 0; ?>
		<?php $amortization15 = 0; ?>
		<?php $amortization30 = 0; ?>
		<?php $loan_amount = 0; ?>
		<?php $loan_payment = 0; ?>
		<?php $loan_balance = 0; ?>
		
		<?php if (count($loans)): ?>
			<?php foreach ($loans as $loan): ?>
				<tr>
					<td><?php echo $loan->loan_type;?></td>
					<td><?php echo $loan->cv_no;?></td>
					<td><?php echo $loan->bank_code . ' - ' . $loan->check_no;?></td>
					<td><?php echo date_convert_to_php($loan->schedule_from, "M d, y");?></td>
					<td><?php echo date_convert_to_php($loan->schedule_to, "M d, y");?></td>
					<td class='text-right'><?php echo nf($loan->principal_amount) ;?></td>
					<td class='text-right'><?php echo nf($loan->amortization_15);?></td>
					<td class='text-right'><?php echo nf($loan->amortization_30);?></td>
					<td class='text-right'><?php echo nf($loan->loan_amount) ;?></td>
					<td class='text-right numeric'>
					<?php 
						echo nf($loan->loan_payment);
					 ?>
					</td>
					<td class='text-right'>
					<?php echo nf($loan->loan_amount - $loan->loan_payment); ?>
					</td>
				</tr>
				<thead>
					
				<tr>
					<td colspan="9">
	                    <div class="progress progress-striped">
	                        <div class="progress-bar progress-bar" style="width: <?php echo nf(($loan->loan_payment / $loan->loan_amount) * 100, 2)  ?>%">
	                        <span>
		                        <?php echo nf(($loan->loan_payment / $loan->loan_amount) * 100, 2); ?>% Complete
		                        ( Php <?php echo nf($loan->loan_payment); ?> )
	                        </span>
	                        </div>
	                    </div>
	                </td>
	                <td class="text-right"><span class="badge bg-success">
	                <?php echo nf(($loan->loan_payment / $loan->loan_amount) * 100, 2)  ?>%</span></td>
	                <td class="text-right"><span class="badge bg-green"><?php echo nf(100 - (($loan->loan_payment / $loan->loan_amount) * 100) ,2)  ?>%</span></td>
				</tr>
				</thead>


			<?php $amortization15 += $loan->amortization_15 ?>
			<?php $amortization30 += $loan->amortization_30 ?>
			<?php $loan_amount += $loan->loan_amount ?>
			<?php $loan_balance += $loan->loan_amount - $loan->loan_payment ?>
			<?php $loan_payment += $loan->loan_payment ?>
			<?php $counter++; ?>
			<?php endforeach ?>

				</tbody>


				<tfoot>
					<tr>
						<th colspan='6' class='text-right lead'>
							Total
						</th>
						<th class='text-right numeric lead' id="th_amortization_15">
							<?php echo nf($amortization15); ?>
						</th>
						<th class='text-right numeric lead' id='th_amortization_30'>
							<?php echo nf($amortization30); ?>
						</th>
						<th class='text-right numeric lead'>
							<?php echo nf($loan_amount); ?>
						</th>
						<th class='text-right numeric lead'>
							<?php echo nf($loan_payment); ?>
						</th>
						<th class='text-right numeric lead'>
							<?php echo nf($loan_balance); ?>
						</th>
					</tr>
				</tfoot>


		<?php else: ?>
				<tr>
					<td colspan="9">
						<span class="label label-danger">No record found!.</span>
					</td>
				</tr>
		<?php endif ?>
	
</table>


</div>


<script>
	$(function(){

		$('.amortization15, .amortization30, #total_check_amount, #total_cash_amount, #total_amount').autoNumeric('init', {'mDec':<?php echo DECIMAL_PLACES ?>});

		$('input[type=text]').on('click', function(e){
			$(this).select();
		});
		
		$('input[type=text]').keydown(function(e){
			//get the next index of text input element
			var next_idx = $('input[type=text]').index(this) + 1;
		 
			//get number of text input element in a html document
			var tot_idx = $('body').find('input[type=text]').length;
		 
			//enter button in ASCII code
			if(e.keyCode == 13){
				if(tot_idx == next_idx)
				{	//go to the first text element if focused in the last text input element
					$('input[type=text]:eq(0)').focus();
					$('input[type=text]:eq(0)').select();
				}
				else
				{
					//go to the next text input element
					$('input[type=text]:eq(' + next_idx + ')').focus();
					$('input[type=text]:eq(' + next_idx + ')').select();
				}
			}
		});




	});
</script>