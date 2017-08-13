

<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-10">
		
		<div class="form-group">
			<label for="position_code" class="col-sm-2 control-label">Code</label>
			<div class="col-sm-6">
				<input type="text" name="position_code" id="position_code" class="form-control" placeholder="Position Code" value="<?php echo set_value('position_code', $position->position_code);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="position" class="col-sm-2 control-label">Position</label>
			<div class="col-sm-6">
				<input type="text" name="position" id="position" class="form-control" placeholder="Position Title" value="<?php echo set_value('position', $position->position);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-2 control-label">Remarks</label>
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $position->remarks);?></textarea>
			</div>
		</div>

	</div>

</div>

<div class="row">
	<div class="col-sm-10">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('position')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

