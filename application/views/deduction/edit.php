

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">

		 <label for="employee_id" class="col-sm-2 control-label">Employee</label>
		 <div class="form-group">
		 	<div class="col-sm-6">
			
				<?php echo form_dropdown('employee_id', $employees, $this->input->post('employee_id') ? $this->input->post('employee_id') : $deductions->employee_id, 'id="employee_id" class="form-control"' ) ?>
	        </div>
	        <span class="help-block"></span>
    	</div>

    	<label for="deduction_category_id" class="col-sm-2 control-label">Deduction Category</label>
    	<div class="form-group">
    		<div class="col-sm-6">
			    <?php echo form_dropdown('deduction_category_id', $deduction_categories, $this->input->post('deduction_category_id') ? $this->input->post('deduction_category_id') : $deductions->deduction_category_id, 'id="deduction_category_id" class="form-control"' ) ?>
	        </div>
	        <span class="help-block"></span>
    	</div>

		<label for="date_filed" class="col-sm-2 control-label">Date Filed</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="date" name="date_filed" id="date_filed" class="form-control" placeholder="Date Filed" value="<?php echo set_value('date_filed', $deductions->date_filed);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="coverage_date_start" class="col-sm-2 control-label">Coverage Date Start</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="date" name="coverage_date_start" id="coverage_date_start" class="form-control" placeholder="Coverage Date Start" value="<?php echo set_value('coverage_date_start', $deductions->coverage_date_start);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<label for="coverage_date_end" class="col-sm-2 control-label">Coverage Date End</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="date" name="coverage_date_end" id="coverage_date_end" class="form-control" placeholder="Coverage Date End" value="<?php echo set_value('coverage_date_end', $deductions->coverage_date_end);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		
		<div class="form-group">
			<label class="col-sm-2 control-label">Payment Type</label>
			<div class="col-sm-8">
				<label class="radio-inline">
				  <input type="radio" name="payment_type" id="inlineradio1" value="1" <?php $deductions->payment_type == '1' ? $check = TRUE : $check = FALSE; echo set_radio('payment_type', '1', $check);?> > Fixed Amount
				</label>
				<label class="radio-inline">
				  <input type="radio" name="payment_type" id="inlineradio2" value="2" <?php $deductions->payment_type == '2' ? $check = TRUE : $check = FALSE; echo set_radio('payment_type', '2', $check);?> > Percentage
				</label>
				
			</div>
		</div>

		<label for="percentage" class="col-sm-2 control-label">Percentage</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="percentage" id="percentage" class="form-control deci" placeholder="Percentage" value="<?php echo set_value('percentage', $deductions->percentage);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>


		<label for="fixed_amount" class="col-sm-2 control-label">Fixed Amount</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="text" name="fixed_amount" id="fixed_amount" class="form-control deci" placeholder="Fixed Amount" value="<?php echo set_value('fixed_amount', $deductions->fixed_amount);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Mode of Payment</label>
			<div class="col-sm-8">
				<label class="radio-inline">
				  <input type="radio" name="mode_of_payment" id="inlineradio1" value="1" <?php $deductions->mode_of_payment == '1' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment', '1', $check); ?> > Beginning of Month
				</label>
				<label class="radio-inline">
				  <input type="radio" name="mode_of_payment" id="inlineradio2" value="2" <?php $deductions->mode_of_payment == '2' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment', '2', $check); ?> > Every Pay
				</label>
				<label class="radio-inline">
				  <input type="radio" name="mode_of_payment" id="inlineradio3" value="3" <?php $deductions->mode_of_payment == '3' ? $check = TRUE : $check = FALSE; echo set_radio('mode_of_payment', '3', $check); ?> > End of Month
				</label>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Is Closed?</label>
			<div class="col-sm-8">
				<label class="radio-inline">
				  <input type="radio" name="is_closed" id="inlineradio1" value="1" <?php $deductions->is_closed == '1' ? $check = TRUE : $check = FALSE; echo set_radio('is_closed', '1', $check);?> > Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" name="is_closed" id="inlineradio2" value="2" <?php $deductions->is_closed == '0' ? $check = TRUE : $check = FALSE; echo set_radio('is_closed', '0', $check);?> > No
				</label>
				
			</div>
		</div>
		
		<label for="date_closed" class="col-sm-2 control-label">Date Closed</label>
		<div class="form-group">
			<div class="col-sm-6">
				<input type="date" name="date_closed" id="date_closed" class="form-control" placeholder="Date Closed" value="<?php echo set_value('date_closed', $deductions->date_closed);?>" autofocus>
			</div>
			<span class="help-block"></span>
		</div>

		
		

		<label for="remarks" class="col-sm-2 control-label">Remarks</label>
		<div class="form-group">
			<div class="col-sm-6">			
				<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $deductions->remarks);?></textarea>
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
		  <a href="<?php echo site_url('deduction')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>