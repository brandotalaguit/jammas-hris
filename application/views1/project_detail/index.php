
<div class="box box-primary">
    
    <div class="box-header">

    	<div class="row">
    		<div class="col-sm-8">
    			<h3 class="box-title">
			        <?php echo anchor(base_url("project/$project_id/new"), '<i class="ion ion-person-add"></i> Add Personnel', ['class' => 'btn btn-danger']); ?>
    			</h3>
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

    	<table class="table table-condensed table-hover">
			
			
			<tbody>
				<tr>			
					<th width='2%'>#</th>
					<th width='10%'>Position</th>
					<th width='15%'>Lastname</th>
					<th width='15%'>Firstname</th>
					<th width='10%'>Middlename</th>
					<th width='10%'>Employee ID</th>
					<th width='7%'>Action</th>
				</tr>

				<?php if (count($project_personnels)): ?>

					<?php $counter = 0; ?>

					<?php foreach ($project_personnels as $personnel): ?>
						<tr <?php echo $this->session->flashdata('id') == $personnel->position_id ? "class='success'" : ''; ?> >
							<td><?php echo ++$counter;?>.</td>
							<td><?php echo $personnel->position;?></td>
							<td><?php echo $personnel->lastname;?></td>
							<td><?php echo $personnel->firstname;?></td>
							<td><?php echo $personnel->middlename;?></td>
							<td><?php echo $personnel->employee_id;?></td>
							<td>
								<div class="btn-group btn-block">
									<?php echo btn_edit("project/$personnel->project_id/$personnel->project_employee_id/edit");?>
									<?php echo btn_delete("project/$personnel->project_id/$personnel->project_employee_id/delete");?>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				<?php else: ?>
						<tr>
							<td colspan="7">
								<span class="label label-danger">No record found!.</span>
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


<?php $this->output->enable_profiler(TRUE); ?>