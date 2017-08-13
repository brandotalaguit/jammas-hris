
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
			<label class="col-sm-4 control-label">Amortization Day</label>
			<div class="col-sm-8">
				<label class="radio-inline">
				  <input type="radio" name="amortization" id="inlineradio1" value="15" <?php $salary_period->amortization == '15' ? $check = TRUE : $check = FALSE; echo set_radio('amortization', '15', $check);?> > 15<sup>th</sup>
				</label>
				<label class="radio-inline">
				  <input type="radio" name="amortization" id="inlineradio2" value="30" <?php $salary_period->amortization == '30' ? $check = TRUE : $check = FALSE; echo set_radio('amortization', '30', $check);?> > 30<sup>th</sup>
				</label>
			</div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label">Loan Type</label>
		  <div class="col-sm-6">
		  	<?php $attrb = "id='loan_type_id' class='form-control'"; ?>
		    <?php echo form_dropdown('loan_type_id', $loan_type, $this->input->post('loan_type_id') ? $this->input->post('loan_type_id') : $salary_period->loan_type_id, $attrb) ?>
		  </div>
		</div>
		<div class="form-group">
		  <label class="col-sm-4 control-label">Employment Status</label>
		  <div class="col-sm-6">
		  	<?php $attrb = "id='employment_status_id' class='form-control'"; ?>
		    <?php echo form_dropdown('employment_status_id', $employment_status, $this->input->post('employment_status_id') ? $this->input->post('employment_status_id') : $salary_period->employment_status_id, $attrb) ?>
		  </div>
		</div>
		<div class="form-group">
			<label for="remarks" class="col-sm-4 control-label">Explanations</label>
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

