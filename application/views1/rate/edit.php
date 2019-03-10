
<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-10">
		
		<div class="form-group">
			<label for="rate_title" class="col-sm-2 control-label">Rate</label>
			<div class="col-sm-6">
				<input type="text" name="rate_title" id="rate_title" class="form-control" placeholder="Rate" value="<?php echo set_value('rate_title', $rate->rate_title);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-2 control-label">Remarks</label>
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $rate->remarks);?></textarea>
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
		  <a href="<?php echo site_url('rate')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

