<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='10%'>Status Id</th>
			<th width='20%'>Status</th>
			<th width='30%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($employment_status)): ?>
			<?php foreach ($employment_status as $status): ?>
				<tr <?php echo $this->session->flashdata('id') == $status->employment_status_id ? "class='success'" : ''; ?> >
					<td><?php echo $status->employment_status_id;?></td>
					<td><?php echo $status->employment_status;?></td>
					<td><?php echo $status->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('employment_status/'. $status->employment_status_id . '/edit');?>
							<?php echo btn_delete('employment_status/'. $status->employment_status_id . '/delete');?>
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