<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width='15%'>Lastname</th>
			<th width='15%'>Firstname</th>
			<th width='15%'>Middlename</th>
			<th width='10%'>Account Type</th>
			<th width='10%'>Username</th>
			<th width='18%'>Email</th>			
			<th width='10%'>Action</th>
		</tr>		
	</thead>
	<tbody>
		<?php if (count($users)): ?>
			<?php foreach ($users as $user): ?>
				<tr <?php echo $this->session->flashdata('id') == $user->Id ? "class='success'" : ''; ?> >
					<td><?php echo $user->LastName;?></td>
					<td><?php echo $user->FirstName;?></td>
					<td><?php echo $user->MiddleName;?></td>
					<td>
					<?php 
						if ($user->AccountType == 'S') 
						{
							echo "Super Admin";
						}
						elseif ($user->AccountType == 'A') 
						{
							echo "Admin";
						}
						else
						{
							echo $user->AccountType;							
						}
					?>
					</td>
					<td><?php echo $user->Username;?></td>
					<td><?php echo $user->EmailAddress;?></td>
					<td>
						<div class="btn-group btn-block">
							<?php echo btn_edit('user/'. $user->Id . '/edit');?>
							<?php echo btn_delete('user/'. $user->Id . '/delete');?>
						</div>
					</td>
				</tr>
			<?php endforeach ?>
		<?php else: ?>
				<tr>
					<td colspan="6">
						<p>No record found!. Please try again.</p>
					</td>
				</tr>
		<?php endif ?>
	</tbody>
	
</table>

<?php 
	if (isset($pagination)) 
	echo $pagination;	
?>