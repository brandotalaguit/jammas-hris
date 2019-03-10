
<?php echo validation_errors(); ?>
<?php echo form_open(site_url('office/'.$this->uri->segment(2,0).'/edit'), array('class' =>'form-horizontal', 'role' => 'form')); ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">
			<label for="office_code" class="col-sm-2 control-label">Office Code</label>
			<div class="col-sm-9">
				<input type="text" name="office_code" id="office_code" class="form-control" placeholder="Office Code" value="<?php echo set_value('office_code', $office->office_code);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="office_description" class="col-sm-2 control-label">Description</label>
			<div class="col-sm-9">
				<input type="text" name="office_description" id="office_description" class="form-control" placeholder="Description" value="<?php echo set_value('office_description', $office->office_description);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-2"></label>
			<div class="col-sm-9">
			  <div class="btn-group">
				<button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
				<a href="<?php echo site_url('office')?>" class="btn btn-default btn-lg">Cancel</a>
			  </div>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

