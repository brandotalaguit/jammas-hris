

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">
		<label for="employment_status_code" class="col-sm-2 control-label">Employment Status Code</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employment_status_code" id="employment_status_code" class="form-control" placeholder="Employment Status Code" value="<?php echo set_value('employment_status_code', $employment_statuses->employment_status_code);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="employment_status" class="col-sm-2 control-label">Employment Status Description</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="employment_status" id="employment_status" class="form-control" placeholder="Employment Status" value="<?php echo set_value('employment_status', $employment_statuses->employment_status);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		
		
		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $employment_statuses->remarks);?></textarea>
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
		  <a href="<?php echo site_url('employment_status')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>