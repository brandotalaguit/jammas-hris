<?php 

// display forn validation message
echo validation_errors(); 


if ( !$has_receipt )
{
	echo $form_url;
}
$rowspan = $period->amortization == 30 ? "2" : "1";
?>

<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th rowspan="<?php echo $rowspan; ?>" width='10%'>NAME</th>
			<th rowspan="<?php echo $rowspan; ?>" width='5%'>TYPE</th>
			<th rowspan="<?php echo $rowspan; ?>" width='5%'>CV NO.</th>
			<th rowspan="<?php echo $rowspan; ?>" width='8%'>CHECK</th>
			<th rowspan="<?php echo $rowspan; ?>" width='8%' class='text-center'>
				AMORTIZATION
			</th>
			
			<?php if ($period->amortization == 30): ?>
				
			<th rowspan="1" width='5%' class='text-center'>INTEREST</th>
			<th rowspan="1" width='5%' class='text-center'>SC</th>
			<th rowspan="1" width='5%' class='text-center'>LPP</th>

			<?php endif ?>

			<th rowspan="<?php echo $rowspan; ?>" width='8%' class='text-right'>LOAN</th>
			<th rowspan="<?php echo $rowspan; ?>" width='5%' class='text-right'>PAYMENT</th>
			<th rowspan="<?php echo $rowspan; ?>" width='5%' class='text-right'>BALANCE</th>
		</tr>
			<?php if ($period->amortization == 30): ?>
		<tr>
			<th colspan="3" class="text-center">R E C E I V A B L E</th>
		</tr>
			<?php endif ?>
	</thead>
	<tbody>

		<?php $counter = 0; ?>
		<?php $amortization15 = 0; ?>
		<?php $amortization30 = 0; ?>
		
		<?php if (count($loans)): ?>
			<?php foreach ($loans as $loan): ?>
				<tr>
					
					<td>
						<?php 
							
							echo $loan->lastname . ', ' . $loan->firstname . ' ' . $loan->middlename;
							echo '<br><span class="text-info">' .$loan->account_no . '</span>';
						
							if (isset($loan->salary_collection_detail_id))
							{
								echo form_hidden('salary_collection_detail_id['.$counter.']', $loan->salary_collection_detail_id);
							}

							echo form_hidden('loan_id['.$counter.']', $loan->loan_id);
							echo form_hidden('member_id['.$counter.']', $loan->member_id); 

						?>
					</td>

					<td><?php echo $loan->loan_type;?></td>
					<td><?php echo $loan->cv_no;?></td>
					<td><?php echo $loan->bank_code . ' - ' . $loan->check_no;?></td>
					
					<td>
						<!-- AMORTIZATION -->
						<?php if ($period->amortization == 15): ?>

	 						<?php 
								$init_amount = set_value('amortization['.$counter.']', isset($loan->salary_collection_detail_id) ? $loan->amortization : $loan->amortization_15);
								$balance = $loan->loan_amount - $loan->loan_payment;
								
								if (intval($init_amount) <= 0 && isset($loan->salary_collection_detail_id)) 
								{
									$init_amount = $loan->amortization;
								}

								if ($init_amount > $balance) 
								{
									$init_amount = $balance;
								}
								?>


								<?php if ( !$has_receipt ): ?>
								<div class="input-group">
								<span class="input-group-addon">Php</span>
								<input type="text" data-loan-id="<?php echo $loan->loan_id ?>" data-id="<?php echo $loan->salary_collection_detail_id; ?>" data-initamount="<?php echo $init_amount ?>" name="amortization[<?php echo $counter ?>]" class="form-control text-right amortization15 amortization" id="amortization<?php echo $counter?>" data-v-max='<?php echo to_decimal($balance) ?>' value="<?php echo $init_amount ?>">
								</div>
								<?php else: ?>
								<p class="form-control-static text-right"><?php echo $loan->amortization ?></p>
								<?php endif; ?>



						<?php else: ?>

							<?php
								$init_amount2 = set_value('amortization['.$counter.']', isset($loan->salary_collection_detail_id) ? $loan->amortization : $loan->amortization_30);
								$balance2 = $loan->loan_amount - $loan->loan_payment;
								if (intval($init_amount2) <= 0 && isset($loan->salary_collection_detail_id)) 
								{
									$init_amount2 = $loan->amortization;
								}

								if ($init_amount2 > $balance2) 
								{
									$init_amount2 = $balance2;
								}
							 ?>


								<?php if ( !$has_receipt ): ?>
								<div class="input-group">
									<span class="input-group-addon">Php</span>
									<input type="text" data-loan-id="<?php echo $loan->loan_id ?>" data-id="<?php echo $loan->salary_collection_detail_id; ?>" data-initamount="<?php echo $init_amount2 ?>" name="amortization[<?php echo $counter; ?>]" class="form-control text-right amortization30 amortization" id="amortization<?php echo $counter?>" data-v-max='<?php echo to_decimal($balance2) ?>' value="<?php echo $init_amount2 ?>">
								</div>
								<?php else: ?>
								<p class="form-control-static text-right"><?php echo $loan->amortization ?></p>
								<?php endif; ?>


						<?php endif ?>


					</td>

				<?php if ($period->amortization == 30 ): ?>

					<!-- INTEREST RECEIVABLE -->
					<td>
						<?php
							$init_amount3 = set_value('int_receivable['.$counter.']', $loan->int_receivable);

							if (intval($init_amount3) <= 0 && isset($loan->salary_collection_detail_id)) 
							{
								$init_amount3 = $loan->int_receivable;
							}
						 ?>


						<?php if ( !$has_receipt ): ?>
							<?php if ($loan->computation_id == 2): ?>
								<input type="text" data-initamount="<?php echo $init_amount3 ?>" name="int_receivable[<?php echo $counter; ?>]" class="form-control text-right numbers int_receivable" data-v-max='<?php echo to_decimal($loan->interest_receivable - $loan->interest_payment) ?>' data-v-min="0.00" value="<?php echo $init_amount3 ?>" title="Total interest payment <?php echo nf($loan->interest_payment) ?>, Interest receivable <?php echo nf($loan->interest_receivable) ?> ">
							<?php else: ?>
								<?php echo form_hidden("int_receivable[" . $counter . "]", $init_amount3) ?>
								<p class="form-control-static text-right"><?php echo nf($init_amount3) ?></p>
							<?php endif ?>
						<?php else: ?>
						<p class="form-control-static text-right"><?php echo nf($loan->int_receivable) ?></p>
						<?php endif; ?>
					</td>

					<!-- SERVICE CHARGE RECEIVABLE -->
					<td>
						<?php
							$init_amount4 = set_value('sc_receivable['.$counter.']', $loan->sc_receivable);

							if (intval($init_amount4) <= 0 && isset($loan->salary_collection_detail_id)) 
							{
								$init_amount4 = $loan->sc_receivable;
							}
						 ?>


						<?php if ( !$has_receipt ): ?>
							<?php if ($loan->computation_id == 2): ?>
								<input type="text" data-initamount="<?php echo $init_amount4 ?>" name="sc_receivable[<?php echo $counter; ?>]" class="form-control text-right numbers sc_receivable" data-v-max='<?php echo to_decimal($loan->service_charge_receivable - $loan->sc_payment) ?>' data-v-min="0.00" value="<?php echo $init_amount4 ?>">
							<?php else: ?>
								<?php echo form_hidden("sc_receivable[" . $counter . "]", $init_amount4) ?>
								<p class="form-control-static text-right"><?php echo nf($init_amount4) ?></p>
							<?php endif ?>
						<?php else: ?>
						<p class="form-control-static text-right"><?php echo nf($loan->sc_receivable) ?></p>
						<?php endif; ?>
					</td>

					<!-- LPP RECEIVABLE -->
					<td>
						<?php
							$init_amount5 = set_value('lpp_receivable['.$counter.']', $loan->lpp_receivable);								

							if (intval($init_amount5) <= 0 && isset($loan->salary_collection_detail_id)) 
							{
								$init_amount5 = $loan->lpp_receivable;
							}
						 ?>


						<?php if ( !$has_receipt ): ?>
							<?php if ($loan->computation_id == 2): ?>
								<input type="text" data-initamount="<?php echo $init_amount5 ?>" name="lpp_receivable[<?php echo $counter; ?>]" class="form-control text-right numbers lpp_receivable" data-v-max='<?php echo to_decimal($loan->loan_protection_plan_receivable - $loan->lpp_payment) ?>' data-v-min="0.00" value="<?php echo $init_amount5 ?>">
							<?php else: ?>
								<?php echo form_hidden("lpp_receivable[" . $counter . "]", $init_amount5) ?>
								<p class="form-control-static text-right"><?php echo nf($init_amount5) ?></p>
							<?php endif ?>
						<?php else: ?>
						<p class="form-control-static text-right"><?php echo nf($loan->lpp_receivable) ?></p>
						<?php endif; ?>
					</td>
				<?php endif ?>



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


			<?php $amortization15 += isset($loan->salary_collection_detail_id) ? $loan->amortization : $loan->amortization_15 ?>
			<?php $amortization30 += isset($loan->salary_collection_detail_id) ? $loan->amortization : $loan->amortization_30 ?>
			<?php $counter++; ?>
			<?php endforeach ?>

				</tbody>


				<tfoot>
					<tr>
						<th colspan='4' class='text-right lead'>
							Collection Total
						</th>
						<th class='text-right numeric lead' id="th_amortization_15">
						<?php if ($period->amortization == 15): ?>
							<?php echo nf($amortization15); ?>
						<?php else: ?>
							<?php echo nf($amortization30); ?>
						<?php endif; ?>
						</th>
						<th class='text-right numeric lead' id='th_amortization_30'>
						</th>
						<th class='text-right numeric lead' id='th_amortization_30'>
						</th>
						<th class='text-right numeric lead' id='th_amortization_30'>
						</th>
						<?php if ($period->amortization == 30): ?>
							
						<th colspan='3'>
							&nbsp;
						</th>
						<?php endif ?>
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

<?php echo form_hidden('counter', $counter) ?>
<?php echo form_hidden('salary_period_id', $id) ?>
<?php echo form_hidden('DECIMAL_PLACES', DECIMAL_PLACES) ?>
<?php echo form_hidden('base_url', base_url()) ?>

<div class="btn-group">
	
<?php if ( !$has_receipt ): ?>
<button type="submit" class='btn btn-primary btn-lg' name='btn_action' value='Print'><strong><i class="fa fa-save"></i> SAVE CHANGES</strong></button>
<?php endif; ?>

<a href="<?php echo site_url('collection_summary');?>" class="btn btn-default btn-lg"><strong>Cancel</strong></a>

</div>

<?php 

	if ( !$has_receipt )
	{
		echo form_close(); 
	}

?>



</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/collection_report_details.js"></script>