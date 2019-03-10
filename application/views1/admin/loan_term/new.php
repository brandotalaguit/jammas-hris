<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('loan_term/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="nos_months" class="col-sm-4 control-label">No. of Months</label>
			<div class="col-sm-6">
				<input type="text" name="nos_months" id="nos_months" class="form-control" placeholder="No. of Months" value="<?php echo set_value('nos_months', $loan_term->nos_months);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="interest_rate" class="col-sm-4 control-label">Interest Rate</label>
			<div class="col-sm-6">
				<input type="text" name="interest_rate" id="interest_rate" class="form-control" placeholder="Interest Rate" value="<?php echo set_value('interest_rate', $loan_term->interest_rate);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="service_charge" class="col-sm-4 control-label">Service Charge</label>
			<div class="col-sm-6">
				<input type="text" name="service_charge" id="service_charge" class="form-control" placeholder="Service Charge" value="<?php echo set_value('service_charge', $loan_term->service_charge);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="loan_protection_plan" class="col-sm-4 control-label">Loan Protection Plan</label>
			<div class="col-sm-6">
				<input type="text" name="loan_protection_plan" id="loan_protection_plan" class="form-control" placeholder="Loan Protection Plan" value="<?php echo set_value('loan_protection_plan', $loan_term->loan_protection_plan);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-4 control-label">Remarks</label>
			<div class="col-sm-6">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $loan_term->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-4"></label>
			<div class="col-sm-6">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('loan_term')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>