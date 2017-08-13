<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('loan_type/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="loan_type" class="col-sm-3 control-label">Types of Loan</label>
			<div class="col-sm-7">
				<input type="text" name="loan_type" id="loan_type" class="form-control" placeholder="Types of Loan" value="<?php echo set_value('loan_type', $loan_type->loan_type);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-3 control-label">Remarks</label>
			<div class="col-sm-7">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $loan_type->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-3"></label>
			<div class="col-sm-7">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('loan_type')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>