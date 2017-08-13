<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Combine Project Billing</h3>
			</div>

			
				<div class="box-body">
					<div class="row">
						<div class="col-xs-12">
							<h4 class="box-title">Billing Information</h4>
							
							<?php echo form_open(base_url('combine_billing/' . $this->uri->segment(2, 0) . '/update_cpb'), array('class' => 'form-horizontal', 'role' => 'form')); ?>
								<label for="cb_title" class="control-label">Title</label>
								<?php echo form_input('cb_title', set_value('cb_title', $combine_billings->cb_title), 'placeholder = "Billing Title" class = "form-control" style=\'width: 40%\''); ?>
								<label for="cb_address" class="control-label">Address</label>
								<?php echo form_input('cb_address', set_value('cb_address', $combine_billings->cb_address), 'placeholder = "Billing Address" class = "form-control" style=\'width: 80%\''); ?>
								<br>
								<?php echo form_hidden('user_id', $this->session->userdata('Id')); ?>
								<button type="submit" class="btn btn-primary"><i class="fa fa-disk"></i> Save Changes</button>
							<?php echo form_close(); ?>
		                </div>
							
					</div>
						
					<hr>
					<h4 class="box-title">Project Billing</h4>
					<?php echo $form_url; ?>
					<div class="row">
						<div class="col-xs-4">
			                <label for="inputproject">Project</label>
						    <?php echo form_dropdown('project_id', $projects, NULL, 'id="inputproject" class="form-control"' ) ?>
						</div>
						<div class="col-xs-6">
		                	<label for="inputemployee">Billing Period</label>
							
							<div class="input-group">
							    <?php echo form_dropdown('project_bill_id', array(0 => 'Select billing period'), $this->input->post('project_bill_id'), 'id="project_bill_id" class="form-control "' ) ?>
	                            <div class="input-group-btn">
	                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Billing Period</button>
	                            </div><!-- /btn-group -->
	                        </div>
						</div>
						
	                </div>
					<?php echo form_close(); ?>
					
	                <h4>List of project to merge</h4>
					<table class="table table-bordered">
						<thead>
	                    <tr>
	                        <th style="width: 15%">Project Title</th>
	                        <th style="width: 35%">Description</th>
	                        <th style="width: 15%">Period</th>
	                        <th style="width: 25%">Column</th>
	                        <th style="width: 15%">Label</th>
	                    </tr>
						</thead>

	                   	<?php if (! empty($combine_project_billings)): ?>
		                    <tbody>
		                    <?php foreach ($combine_project_billings as $project): ?>
		                    	<tr>
		                    		<td><?php echo $project->title ?></td>
		                    		<td><?php echo $project->description ?></td>
		                    		<td><?php echo date('M d, Y', strtotime($project->date_start)) ?> to <?php echo date('M d, Y', strtotime($project->date_end)) ?></td>
		                    		<td><?php echo $project->fields ?></td>
		                    		<td>
		                    			<div class="btn-group">
		                    			<?php echo btn_detail(base_url('projectBillingTrans/'.$project->project_id.'/'.$project->project_bill_id.'/summary'), NULL, array('target' => '_blank')) ?>
		                    			<?php echo btn_delete(base_url('combine_project_billing/'.$project->cb_pb_id.'/delete')) ?>
		                    			</div>
		                    		</td>
		                    	</tr>
		                    <?php endforeach ?>
			                </tbody>
			            <?php else: ?>
			            	<tfoot>
			            		<tr>
			            			<td colspan="5" class="danger text-center"><span class="label label-danger">No Record Found.</span></td>
			            		</tr>
			            	</tfoot>
	                   	<?php endif ?> 
	                </table>


				</div>

				<div class="box-footer">
					  <!-- <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE</strong></button> -->
						<?php 
							if ( ! empty($combine_project_billings)) 
							{
								echo anchor(base_url('combine_billing'.$project->cb_id.'/delete'), 'DELETE ALL', 
									array(
										'class' => 'btn btn-lg btn-danger',
										'onclick'=>"return confirm('You are about to delete a record. This is cannot be undone. Are you sure?');",
									)
								); 
							}

						?>
						<?php 
							echo anchor(base_url("combine_billing"), 'CLOSE', array('class' => 'btn btn-default btn-lg'));
						 ?>
				</div>


		</div>
	</div>

</div>

<div class="row">
	
	<div class="form-group">
	  <div class="col-sm-6">
	  
	  
	  </div>
	</div>

</div>

