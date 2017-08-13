<div class="modal-body">

<?php echo validation_errors(); ?>
<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">			
			<label class="col-sm-4 control-label">Period of Application</label>
			<div class="col-sm-6 input-group input-daterange" id="application_date">
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="application_start" value="<?php echo set_value('application_start', $payment_schedule->application_start);?>"/>
			    <span class="input-group-addon">to</span>
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="application_end" value="<?php echo set_value('application_end', $payment_schedule->application_end);?>" />
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-3 control-label">Remarks</label>
			<div class="col-sm-7">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $member_status->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-3"></label>
			<div class="col-sm-7">
				<button type="submit" class="btn btn-primary btn-lg">
					Save
				</button>
				<a href="<?php echo site_url('member_status')?>" class="btn btn-default btn-lg">Cancel</a>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

</div>