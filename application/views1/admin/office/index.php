<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='10%'>Office Id</th>
			<th width='20%'>Office Code</th>
			<th width='30%'>Description</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($offices)): ?>
			<?php foreach ($offices as $office): ?>
				<tr <?php echo $this->session->flashdata('id') == $office->office_id ? "class='success'" : ''; ?> >
					<td><?php echo $office->office_id;?></td>
					<td><?php echo $office->office_code;?></td>
					<td><?php echo $office->office_description;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('office/'. $office->office_id . '/edit');?>
							<?php echo btn_delete('office/'. $office->office_id . '/delete');?>
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