<form class="form-inline deduction_employee_filter" role="form" method="post" action="<?php echo site_url('deduction') ?>" >
			<div class="input-group">
				<div class="col-sm-3">
	            <label for="employee_filter" class="control-label pull-right" style="margin-top:7px">Employee</label>
	          	</div>
	          	<?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id'), 'id="employee_id" class="form-control"' ) ?>
	       
	            <span class="input-group-btn">
	                <button class="btn btn-default" name="btn_employee_filter" type="submit" value="Search"><span class="fa fa-search"></span></button>
	            </span>
	        </div>
	     
</form>
