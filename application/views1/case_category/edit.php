

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">
		<label for="case_category_code" class="col-sm-2 control-label">Category Code</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="case_category_code" id="case_category_code" class="form-control" placeholder="Category Code" value="<?php echo set_value('case_category_code', $case_categories->case_category_code);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="case_category" class="col-sm-2 control-label">Category Description</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="case_category" id="case_category" class="form-control" placeholder="Category Description" value="<?php echo set_value('case_category_code', $case_categories->case_category);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		
		
		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $case_categories->remarks);?></textarea>
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
		  <a href="<?php echo site_url('case_category')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>