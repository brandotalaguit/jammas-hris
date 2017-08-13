

<?php echo $form_url; ?>
<div class="row">
	<div class="col-sm-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Employee</h3>
			</div>
			<div class="box-body">
				<div class="form-group">
	                <label for="inputemployee">Employee</label>
	                <!-- <div class="input-group"> -->
					    <?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id') ? $this->input->post('employee_id') : $project_employee->employee_id, 'id="inputemployee" class="form-control"' ) ?>
	                    <!-- <span class="input-group-btn">
	                        <button class="btn btn-info btn-flat" type="button">Go!</button>
	                    </span> -->
	                <!-- </div> -->
                </div>
                <div class="form-group">
	                <label for="inputemployee">Position</label>
				    <?php echo form_dropdown('ppr_id', $positions, $this->input->post('ppr_id') ? $this->input->post('ppr_id') : $project_employee->ppr_id, 'id="ppr_id" class="form-control"' ) ?>
                </div>
				<div class="form-group">
	                <label for="inputemployee">Regular Time-in</label>
					<div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
	                    <input type="text" class="form-control" placeholder="hh:mm:ss" name="regular_time_in" value="<?php echo set_value('regular_time_in', $project_employee->regular_time_in); ?>">
	                </div>
                </div>
    			<div class="form-group">
                    <label for="inputemployee">Regular Time-out</label>
	                <div class="input-group">
	                    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
	                    <input type="text" class="form-control" placeholder="hh:mm:ss" name="regular_time_out" value="<?php echo set_value('regular_time_out', $project_employee->regular_time_out); ?>">
	                </div>
                </div>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<!-- <div class="box box-danger">
			<div class="box-header">
				<h3 class="box-title">Rates</h3>
			</div>
			<div class="box-body">
			<?php #foreach ($rates as $rate): ?>
				<div class="form-group">
	                <label for="inputemployee"><?php #echo $rate->rate_title ?></label>
	                <input type="text" class="form-control" placeholder="<?php #echo $rate->remarks ?>" name="rate_id[<?php #echo $rate->rate_id; ?>]" value="<?php #echo set_value('rate[]'); ?>">
                </div>
			<?php #endforeach ?>
			</div>
		</div> -->
	</div>
</div>

<div class="row">
	<!-- <div class="col-sm-6"> -->
	
	<div class="form-group">
	  <div class="col-sm-6">
	  
		  <button type="submit" name="btnAdd" value="Save and Add" class="btn btn-info btn-lg"><strong>SAVE & ADD AGAIN</strong></button>
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE</strong></button>
		  <a href="<?php echo base_url("project_employee/$project_id/detail")?>" class="btn btn-default btn-lg">CANCEL</a>
	  
	  </div>
	</div>

	<!-- </div> -->
</div>

