<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('bank/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="bank_code" class="col-sm-3 control-label">Bank Code</label>
			<div class="col-sm-7">
				<input type="text" name="bank_code" id="bank_code" class="form-control" placeholder="Bank Code" value="<?php echo set_value('bank_code', $bank->bank_code);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="bank_description" class="col-sm-3 control-label">Bank Description</label>
			<div class="col-sm-7">
				<input type="text" name="bank_description" id="bank_description" class="form-control" placeholder="Bank Description" value="<?php echo set_value('bank_description', $bank->bank_description);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-3 control-label">Remarks</label>
			<div class="col-sm-7">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $bank->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-3"></label>
			<div class="col-sm-7">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('bank')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>