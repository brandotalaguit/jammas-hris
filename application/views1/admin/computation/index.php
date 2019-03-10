<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='5%'>Computation Id</th>
			<th width='18%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($computations)): ?>
			<?php foreach ($computations as $computation): ?>
				<tr <?php echo $this->session->flashdata('id') == $computation->computation_id ? "class='success'" : ''; ?> >
					<td><?php echo $computation->computation;?></td>
					<td><?php echo $computation->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('computation/'. $computation->computation_id . '/edit');?>
							<?php echo btn_delete('computation/'. $computation->computation_id . '/delete');?>
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