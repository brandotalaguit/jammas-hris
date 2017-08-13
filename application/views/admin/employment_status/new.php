<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo form_open(site_url('employment_status/new'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="employment_status" class="col-sm-3 control-label">Employement Status</label>
			<div class="col-sm-7">
				<input type="text" name="employment_status" id="employment_status" class="form-control" placeholder="Employement Status" value="<?php echo set_value('employment_status', $employment_status->employment_status);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-3 control-label">Remarks</label>
			<div class="col-sm-7">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $employment_status->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-3"></label>
			<div class="col-sm-7">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('employment_status')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>