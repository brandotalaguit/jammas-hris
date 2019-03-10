<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='5%'>Bank Id</th>
			<th width='10%'>Bank Code</th>
			<th width='25%'>Bank Description</th>
			<th width='18%'>Remarks</th>
			<th width='7%'>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($banks)): ?>
			<?php foreach ($banks as $bank): ?>
				<tr <?php echo $this->session->flashdata('id') == $bank->bank_id ? "class='success'" : ''; ?> >
					<td><?php echo $bank->bank_id;?></td>
					<td><?php echo $bank->bank_code;?></td>
					<td><?php echo $bank->bank_description;?></td>
					<td><?php echo $bank->remarks;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('bank/'. $bank->bank_id . '/edit');?>
							<?php echo btn_delete('bank/'. $bank->bank_id . '/delete');?>
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