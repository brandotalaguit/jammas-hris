<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='10%'>Id</th>
			<th width='20%'>Sundry</th>
			<th width='30%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($sundries)): ?>
			<?php foreach ($sundries as $sundry): ?>
				<tr <?php echo $this->session->flashdata('id') == $sundry->sundry_id ? "class='success'" : ''; ?> >
					<td><?php echo $sundry->sundry_id;?></td>
					<td><?php echo $sundry->sundry;?></td>
					<td><?php echo $sundry->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('sundries/'. $sundry->sundry_id . '/edit');?>
							<?php echo btn_delete('sundries/'. $sundry->sundry_id . '/delete');?>
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

<?php 
	if (isset($pagination)) 
	echo $pagination;
?>