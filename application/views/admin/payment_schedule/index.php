<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='10%' colspan="2">PERIOD OF APPLICATION</th>
			<th width='5%'>DATE OF</th>
			<th width='10%' rowspan="2">LOAN TERM</th>
			<th colspan="2" class="text-center">D E D U C T I O N</th>
			<th width='3%' rowspan="2" class="text-center">ACTION</th>
		</tr>
		<tr>
			<th>FROM</th>
			<th>TO</th>
			<th>RECONSTRUCTION</th>
			<th width='5%'>FIRST</th>
			<th width='5%'>LAST</th>
		</tr>

	</thead>
	<tbody>
		<?php if (count($payment_schedule)): ?>
			<?php foreach ($payment_schedule as $term): ?>
				<tr <?php echo $this->session->flashdata('id') == $term->payment_schedule_id ? "class='success'" : ''; ?> >
					<td><?php echo date("m/d", strtotime($term->application_start));?></td>
					<td><?php echo date("m/d", strtotime($term->application_end));?></td>
					<td><?php echo date("m/d", strtotime($term->reconstruction));?></td>
					<td><?php echo $term->remarks;?></td>
					<td><?php echo date("m/d", strtotime($term->first_deduction));?></td>
					<td><?php echo date("m/d", strtotime($term->last_deduction));?></td>					
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('payment_schedule/'. $term->payment_schedule_id . '/edit');?>
							<?php echo btn_delete('payment_schedule/'. $term->payment_schedule_id . '/delete');?>
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