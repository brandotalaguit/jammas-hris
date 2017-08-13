        <div class="box-header">

        	<div class="row">
        		<div class="col-sm-8">
        			<h3 class="box-title">
        				Project Personnels
    			        <?php echo anchor(base_url("project_employee/$project_id/new"), 
    			        '<i class="ion ion-person-add"></i> Add Personnel', 
    			        ['class' => 'btn btn-danger btn-sm']); ?>
    	    			
    	    			
        			</h3>
        		</div>
        		<div class="col-sm-4">
    		        <div class="box-tools" style="padding: 10px 10px 10px 0px">

    			            <?php $this->load->view('project_employee/employee_search_form'); ?>

    		        </div>
        		</div>
        	</div>

        </div><!-- /.box-header -->

        <div class="box-body table-responsive no-padding">

        	<table class="table table-condensed table-hover">
    			
    			
    			<tbody>
    				<tr>			
    					<th width='2%'>#</th>
    					<th width='15%'>Lastname</th>
    					<th width='15%'>Firstname</th>
    					<th width='10%'>Middlename</th>
                        <th width='10%'>Employee ID</th>
    					<th width='10%'>Position</th>
    					<th width='7%'>Action</th>
    				</tr>

    				<?php if (count($project_personnels)): ?>

    					<?php $counter = 0; ?>

    					<?php foreach ($project_personnels as $personnel): ?>
    						<tr <?php echo $this->session->flashdata('id') == $personnel->project_employee_id ? "class='success'" : ''; ?> >
    							<td><?php echo ++$counter;?>.</td>
    							<td><?php echo $personnel->lastname;?></td>
    							<td><?php echo $personnel->firstname;?></td>
    							<td><?php echo $personnel->middlename;?></td>
                                <td><?php echo $personnel->employee_id;?></td>
    							<td><?php echo $personnel->position;?></td>
    							<td>
    								<div class="btn-group btn-block">
    									<?php echo btn_edit("project_employee/$personnel->project_id/$personnel->project_employee_id/edit");?>
    									<?php echo btn_delete("project_employee/$personnel->project_employee_id/delete");?>
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

    	    <?php #echo anchor(base_url(), '<i class="fa fa-download"></i> Summary of Attendance Rendenred', ['class' => 'btn btn-success pull-right']); ?>
    	    <?php #echo anchor(base_url("projectBillingInfo/$project_id"), '<i class="fa fa-download"></i> Summary Billing', ['class' => 'btn btn-primary pull-right', 'style' => 'margin-right:5px;']); ?>
        </div><!-- /.box-footer -->