

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">

		<label for="salary_range_start" class="col-sm-2 control-label">Salary Range Start</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="salary_range_start" id="salary_range_start" class="form-control deci" placeholder="Salary Range Start" value="<?php echo set_value('salary_range_start', $sss_matrix->salary_range_start);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="salary_range_end" class="col-sm-2 control-label">Salary Range End</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="salary_range_end" id="salary_range_end" class="form-control deci" placeholder="Salary Range End" value="<?php echo set_value('salary_range_end', $sss_matrix->salary_range_end);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="monthly_salary_credit" class="col-sm-2 control-label">Monthly Salary Credit</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="monthly_salary_credit" id="monthly_salary_credit" class="form-control deci" placeholder="Monthly Salary Credit" value="<?php echo set_value('monthly_salary_credit', $sss_matrix->monthly_salary_credit);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employee_share" class="col-sm-2 control-label">Employee Share</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employee_share" id="employee_share" class="form-control deci" placeholder="Employee Share" value="<?php echo set_value('employee_share', $sss_matrix->employee_share);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employer_share" class="col-sm-2 control-label">Employer Share</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employer_share" id="employer_share" class="form-control deci" placeholder="Employer Share" value="<?php echo set_value('employer_share', $sss_matrix->employer_share);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employee_compensation_program" class="col-sm-2 control-label">Employee Compensation Program</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employee_compensation_program" id="employee_compensation_program" class="form-control deci" placeholder="Employee Compensation Program" value="<?php echo set_value('employee_compensation_program', $sss_matrix->employee_compensation_program);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>


		<label for="total_monthly_premium" class="col-sm-2 control-label">Total Monthly Premium</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="total_monthly_premium" id="total_monthly_premium" class="form-control deci" placeholder="Total Monthly Premium" value="<?php echo set_value('total_monthly_premium', $sss_matrix->total_monthly_premium);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>
		
		
		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $sss_matrix->remarks);?></textarea>
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
		  <a href="<?php echo site_url('sss_premium_contribution_matrix')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>