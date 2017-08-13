<table class="table table-condensed table-bordered table-hover">
	<thead>
		<tr>
			<th width='10%'>Account Id</th>
			<th width='15%'>Charge Code</th>
			<th width='20%'>Decription</th>
			<th width='15%'>Charge Type</th>
			<th width='15%'>Remarks</th>
			<th width='8%'>Action</th>
		</tr>		
	</thead>
	<tbody>
		<?php if (count($accounts)): ?>
			<?php foreach ($accounts as $account): ?>
				<tr <?php echo $this->session->flashdata('id') == $account->account_id ? "class='success'" : ''; ?>>
					<td><?php echo $account->account_id; ?></td>
					<td><?php echo $account->charge_code; ?></td>
					<td><?php echo $account->charge_description; ?></td>
					<td><?php echo $account->charge_type_id; ?></td>
					<td><?php echo $account->remarks; ?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('account/'. $account->account_id . '/edit');?>
							<?php echo btn_delete('account/'. $account->account_id . '/delete');?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
				<tr>
					<td colspan="10" class="text-center">
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