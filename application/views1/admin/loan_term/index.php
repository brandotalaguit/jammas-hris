<table class="table table-hover table-bordered">
	<thead>
		<tr>			
			<th width='10%'>Terms</th>
			<th width='10%'>No. of Month(s)</th>
			<th width='10%'>Interest Rate</th>
			<th width='10%'>Service Charge</th>
			<th width='10%' data-title="Loan Protection Plan" title="Loan Protection Plan">Loan Protection Plan</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($loan_term)): ?>
			<?php foreach ($loan_term as $term): ?>
				<tr <?php echo $this->session->flashdata('id') == $term->loan_term_id ? "class='success'" : ''; ?> >
					<td><?php echo $term->remarks;?></td>
					<td><?php echo $term->nos_months;?> Month<?php echo $term->nos_months > 1 ? 's' : ''; ?></td>
					<td><?php echo $term->interest_rate;?></td>
					<td><?php echo $term->service_charge;?></td>
					<td><?php echo $term->loan_protection_plan;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('loan_term/'. $term->loan_term_id . '/edit');?>
							<?php echo btn_delete('loan_term/'. $term->loan_term_id . '/delete');?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
				<tr>
					<td colspan="6">
						<span class="label label-danger">No record found!.</span>
					</td>
				</tr>
		<?php endif ?>
	</tbody>
	
</table>