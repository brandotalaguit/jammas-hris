

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">

		<label for="salary_range_start" class="col-sm-2 control-label">Salary Range Start</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="salary_range_start" id="salary_range_start" class="form-control deci" placeholder="Salary Range Start" value="<?php echo set_value('salary_range_start', $philhealth_matrix->salary_range_start);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="salary_range_end" class="col-sm-2 control-label">Salary Range End</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="salary_range_end" id="salary_range_end" class="form-control deci" placeholder="Salary Range End" value="<?php echo set_value('salary_range_end', $philhealth_matrix->salary_range_end);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="salary_base" class="col-sm-2 control-label">Salary Base</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="salary_base" id="salary_base" class="form-control deci" placeholder="Salary Base" value="<?php echo set_value('salary_base', $philhealth_matrix->salary_base);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employee_share" class="col-sm-2 control-label">Employee Share</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employee_share" id="employee_share" class="form-control deci" placeholder="Employee Share" value="<?php echo set_value('employee_share', $philhealth_matrix->employee_share);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employer_share" class="col-sm-2 control-label">Employer Share</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employer_share" id="employer_share" class="form-control deci" placeholder="Employer Share" value="<?php echo set_value('employer_share', $philhealth_matrix->employer_share);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="total_monthly_premium" class="col-sm-2 control-label">Total Monthly Premium</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="total_monthly_premium" id="total_monthly_premium" class="form-control deci" placeholder="Total Monthly Premium" value="<?php echo set_value('total_monthly_premium', $philhealth_matrix->total_monthly_premium);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>
		
		
		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $philhealth_matrix->remarks);?></textarea>
			</div>
			<span class="help-block"></span>
		</div>


	</div>

</div>

<div class="row">
	<div class="col-sm-10">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('philhealth_premium_contribution_matrix')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>