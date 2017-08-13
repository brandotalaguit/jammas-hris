<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='10%'>Loan Type Id</th>
			<th width='20%'>Types of Loan</th>
			<th width='30%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($loan_type)): ?>
			<?php foreach ($loan_type as $type): ?>
				<tr <?php echo $this->session->flashdata('id') == $type->loan_type_id ? "class='success'" : ''; ?> >
					<td><?php echo $type->loan_type_id;?></td>
					<td><?php echo $type->loan_type;?></td>
					<td><?php echo $type->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('loan_type/'. $type->loan_type_id . '/edit');?>
							<?php echo btn_delete('loan_type/'. $type->loan_type_id . '/delete');?>
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