<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='5%'>Id</th>
			<th width='5%'>Date Start</th>
			<th width='5%'>Date End</th>
			<th width='12%'>Amount</th>
			<th width='5%'>Validated By</th>
			<th width='10%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($salary_period)): ?>
			<?php foreach ($salary_period as $period): ?>
				<tr <?php echo $this->session->flashdata('id') == $period->salary_period_id ? "class='success'" : ''; ?> >
					<td><?php echo $period->salary_period_id;?></td>
					<td><?php echo $period->date_start;?></td>
					<td><?php echo $period->date_end;?></td>
					<td><?php echo "0.00";?></td>
					<td><?php echo $period->user_id;?></td>
					<td><?php echo $period->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('collection_summary/'. $period->salary_period_id . '/edit');?>
							<?php echo btn_detail('collection_report/'. $period->salary_period_id . '/details', 'Collection Details');?>
							<?php echo btn_delete('collection_summary/'. $period->salary_period_id . '/delete');?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>

				</tbody>


				<tfoot>
					<tr>
						<th colspan='3' class='text-right'>
							Collection Total
						</th>
						<th>
							Php <?php echo "0.00"; ?>
						</th>
						<th colspan='3'>&nbsp;</th>
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