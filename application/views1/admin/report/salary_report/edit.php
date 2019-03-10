
<?php echo validation_errors(); ?>
<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-7">
		
		<div class="form-group">			
			<label class="col-sm-4 control-label">Collection Period</label>
			<div class="col-sm-6 input-group input-daterange" id="application_period">
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="date_start" value="<?php echo set_value('date_start', $salary_period->date_start);?>"/>
			    <span class="input-group-addon">to</span>
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="date_end" value="<?php echo set_value('date_end', $salary_period->date_end);?>" />
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-4 control-label">Remarks</label>
			<div class="col-sm-6">
				<textarea class="form-control" rows="3" id="remarks" name="remarks"><?php echo set_value('remarks', $salary_period->remarks);?></textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-4"></label>
			<div class="col-sm-6">
			  <div class="btn-group">
				<button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
				<a href="<?php echo site_url('collection_summary')?>" class="btn btn-default btn-lg">Cancel</a>
			  </div>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

