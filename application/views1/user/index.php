<div class="box">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
		        <h3 class="box-title"><?php echo isset($page_btn_add) ? $page_btn_add : ""; ?></h3>
    		</div>
    		<div class="col-sm-4">
		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

		            <?php if (isset($search_form)): ?>
			            <?php echo $search_form; ?>
		            <?php endif ?>

		        </div>
    		</div>
    	</div>

    </div><!-- /.box-header -->

    <div class="box-body table-responsive no-padding">
		
		<table class="table table-hover table-condensed">
			<tbody>

				<tr>
					<th width='2%'>#</th>
					<th width='15%'>Lastname</th>
					<th width='15%'>Firstname</th>
					<th width='15%'>Middlename</th>
					<th width='10%'>Account Type</th>
					<th width='10%'>Username</th>
					<th width='18%'>Email</th>			
					<th width='10%'>Action</th>
				</tr>

				<?php if (count($users)): ?>
					<?php foreach ($users as $user): ?>
						<tr <?php echo $this->session->flashdata('id') == $user->Id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
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
								}elseif ($user->AccountType == 'U') 
								{
									echo "User";
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

    </div><!-- /.box-body -->

    <div class="box-footer clearfix">
	    <?php 
	    	if (isset($pagination))
	    	echo $pagination;	
	    ?>
    </div><!-- /.box-footer -->

</div><!-- /.box -->