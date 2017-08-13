
<?php echo validation_errors(); ?>
<?php echo $form_url; ?>

<div class="row">
	<div class="col-sm-6">

		<div class="form-group">			
			<label class="col-sm-4 control-label">Period of Application</label>
			<div class="col-sm-6 input-group input-daterange" id="application_date">
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="application_start" value="<?php echo set_value('application_start', $payment_schedule->application_start);?>"/>
			    <span class="input-group-addon">to</span>
			    <input type="text" class="form-control dtpicker" placeholder="yyyy-mm-dd" name="application_end" value="<?php echo set_value('application_end', $payment_schedule->application_end);?>" />
			</div>
		</div>

		<div class="form-group">
			<label for="reconstruction" class="col-sm-4 control-label">Reconstruction</label>
			<div class="col-sm-6">
				<input type="text" name="reconstruction" id="reconstruction" class="form-control dtpicker" placeholder="yyyy-mm-dd" value="<?php echo set_value('reconstruction', $payment_schedule->reconstruction);?>">
			</div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-4 control-label" for="term_id">Loan Term</label>
		  <div class="col-sm-6">
		    <?php echo form_dropdown('loan_term_id', $loan_terms, $this->input->post('loan_term_id') ? $this->input->post('loan_term_id') : $payment_schedule->loan_term_id, 'id="term_id" class="form-control"' ) ?>
		  </div>
		</div>

		<div class="form-group">
			<label for="first_deduction" class="col-sm-4 control-label">First Deduction</label>
			<div class="col-sm-6">
				<input type="text" name="first_deduction" id="first_deduction" class="form-control dtpicker" placeholder="yyyy-mm-dd" value="<?php echo set_value('first_deduction', $payment_schedule->first_deduction);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="last_deduction" class="col-sm-4 control-label">Last Deduction</label>
			<div class="col-sm-6">
				<input type="text" name="last_deduction" id="last_deduction" class="form-control dtpicker" placeholder="yyyy-mm-dd" value="<?php echo set_value('last_deduction', $payment_schedule->last_deduction);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="remarks" class="col-sm-4 control-label">Remarks</label>
			<div class="col-sm-6">
				<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" value="<?php echo set_value('remarks', $payment_schedule->remarks);?>">
			</div>
		</div>

		<div class="form-group">
			<label for="" class="col-sm-4"></label>
			<div class="col-sm-6">
			  <div class="btn-group">
				<button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
				<a href="<?php echo site_url('payment_schedule')?>" class="btn btn-default btn-lg">Cancel</a>
			  </div>
			</div>			
		</div>

	</div>

</div>

<?php echo form_close(); ?>

<script>
	$('#first_deduction').on('change', function(ev){
		var first_deduction = $('#first_deduction').val();
		var no_months = $('#term_id').val();
		$.ajax({
			type: 'POST',
			cache: false,
			url: '<?php echo base_url()."payment_schedule/get_last_deduction/"; ?>' + first_deduction + '/' + no_months,
			success: function( data ) {
				console.log(data.deduction_date);
				$('#last_deduction').datepicker("update", data.deduction_date);
			},
			dataType: 'json'
		});
	});
</script>

