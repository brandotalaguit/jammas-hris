
<?php echo $form_url; ?>
<!-- <div class="container"> -->
	

<div class="row">
	<div class="col-sm-10">
		
		<label for="title" class="col-sm-2 control-label">Position</label>
		<div class="form-group">
			<div class="col-sm-6">

				<?php if ($this->uri->segment(3, 0) == 'new' ): ?>
					<?php echo form_dropdown('position_id', $positions, $this->input->post('position_id') ? $this->input->post('position_id') : $ppr->position_id, 'id="positionId" class="form-control"' ) ?>
				<?php else: ?>
					<label class="control-label"><?php echo t($job->position) ?></label> 
					<?php echo form_hidden('position_id', $ppr->position_id); ?>
				<?php endif ?>


			</div>
			<span class="help-block">Designated position in the Project (e.g. <em>Toll Collector</em>) </span>
		</div>

		<hr>

		<?php #if ($project->semi_monthly_rate == '1' || $project->monthly_rate == '1'): ?>

		    <label class="col-sm-2 control-label">Hourly Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
		        <input type="text" name="hourly_rate" class="form-control four_decimal" placeholder="Hourly Rate Amount" value="<?php echo set_value('hourly_rate', $ppr->hourly_rate) ?>">
				</div>
				<span class="help-block">Rate per Hour</span>
		    </div>
		<?php #endif ?>

		<?php #if ($project->semi_monthly_rate == '1' || $project->monthly_rate == '1'): ?>

		    <label class="col-sm-2 control-label">Daily Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
		        <input type="text" name="daily_rate" class="form-control four_decimal" placeholder="Daily Rate Amount" value="<?php echo set_value('daily_rate', $ppr->daily_rate) ?>">
				</div>
				<span class="help-block">Rate per Day</span>
		    </div>
		<?php #endif ?>

		<?php #if ($project->semi_monthly_rate == '1' || $project->monthly_rate == '1'): ?>

		    <label class="col-sm-2 control-label">Semi-Monthly Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
		        <input type="text" name="semi_monthly_rate" class="form-control four_decimal" placeholder="Semi-Monthly Rate Amount" value="<?php echo set_value('semi_monthly_rate', $ppr->semi_monthly_rate) ?>">
				</div>
				<span class="help-block">Rate per Semi-Monthly</span>
		    </div>
		<?php #endif ?>

		<?php #if ($project->semi_monthly_rate == '1' || $project->monthly_rate == '1'): ?>

		    <label class="col-sm-2 control-label">Monthly Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
		        <input type="text" name="monthly_rate" class="form-control four_decimal" placeholder="Monthly Rate Amount" value="<?php echo set_value('monthly_rate', $ppr->monthly_rate) ?>">
				</div>
				<span class="help-block">Rate per Monthly</span>
		    </div>
		<?php #endif ?>

		<hr>

        <label class="col-sm-2 control-label">Straight Duty</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="straight_duty" class="form-control four_decimal" placeholder="Straight Duty Amount" value="<?php echo set_value('straight_duty', $ppr->straight_duty) ?>">
			</div>
			<span class="help-block">Straight Duty Rate</span>
	    </div>

        <label class="col-sm-2 control-label">Night Differential</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="night_diff" class="form-control four_decimal" placeholder="Night Differential Amount" value="<?php echo set_value('night_diff', $ppr->night_diff) ?>">
			</div>
			<span class="help-block">Night Differential</span>
	    </div>

	    <label class="col-sm-2 control-label">Night Differential O.T.</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="night_ot_diff" class="form-control four_decimal" placeholder="Night Differential O.T. Amount" value="<?php echo set_value('night_ot_diff', $ppr->night_ot_diff) ?>">
			</div>
			<span class="help-block">Night Differential Over-time</span>
	    </div>

	    <label class="col-sm-2 control-label">Regular O.T.</label>
	    <div class="form-group">
	        <div class="col-sm-6">
	        	<input type="text" name="regular_ot_day" class="form-control four_decimal" placeholder="Regular O.T. Amount" value="<?php echo set_value('regular_ot_day', $ppr->regular_ot_day) ?>">
	        </div>
	        <span class="help-block">Rate per Regular Over-time</span>
	    </div>

	    <hr>

	    <label class="col-sm-2 control-label">Rest Day</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="rest_day_rate" class="form-control four_decimal" placeholder="Rest-day Rate Amount" value="<?php echo set_value('rest_day_rate', $ppr->rest_day_rate) ?>">
			</div>
			<span class="help-block">Rate per Rest Day</span>
	    </div>

	    <label class="col-sm-2 control-label">Rest Day O.T.</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="rest_day_ot_rate" class="form-control four_decimal" placeholder="Rest-day Rate Amount" value="<?php echo set_value('rest_day_ot_rate', $ppr->rest_day_ot_rate) ?>">
			</div>
			<span class="help-block">Rate per Rest Day Over-time</span>
	    </div>

        <label class="col-sm-2 control-label">Rest Day Special Holiday</label>
    	<div class="form-group">
    		<div class="col-sm-6">
            <input type="text" name="rest_day_special_holiday" class="form-control four_decimal" placeholder="Rest Day Special Holiday Amount" value="<?php echo set_value('rest_day_special_holiday', $ppr->rest_day_special_holiday) ?>">
    		</div>
    		<span class="help-block">Rate per Rest Day Special Holiday</span>
        </div>

	    <label class="col-sm-2 control-label" title="Rest Day Special Holiday Over Time">Rest Day Spcl. Hol. O.T.</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="rest_day_special_ot_holiday" class="form-control four_decimal" placeholder="Rest Day Special Holiday O.T. Amount" value="<?php echo set_value('rest_day_special_ot_holiday', $ppr->rest_day_special_ot_holiday) ?>">
			</div>
			<span class="help-block">Rate per Rest Day Special Holiday Over-time</span>
	    </div>

        <label class="col-sm-2 control-label">Rest Day Legal Holiday</label>
    	<div class="form-group">
    		<div class="col-sm-6">
            <input type="text" name="rest_day_legal_holiday" class="form-control four_decimal" placeholder="Rest Day Legal Holiday Amount" value="<?php echo set_value('rest_day_legal_holiday', $ppr->rest_day_legal_holiday) ?>">
    		</div>
    		<span class="help-block">Rate per Rest Day Legal Holiday</span>
        </div>

        <label class="col-sm-2 control-label">Rest Day Legal Holiday O.T.</label>
    	<div class="form-group">
    		<div class="col-sm-6">
            <input type="text" name="rest_day_legal_ot_holiday" class="form-control four_decimal" placeholder="Rest Day Legal Holiday O.T. Amount" value="<?php echo set_value('rest_day_legal_ot_holiday', $ppr->rest_day_legal_ot_holiday) ?>">
    		</div>
    		<span class="help-block">Rate per Rest Day Legal Holiday Over-time</span>
        </div>

        <hr>
            
        <label class="col-sm-2 control-label">Legal Holiday</label>
    	<div class="form-group">
    		<div class="col-sm-6">
            <input type="text" name="legal_holiday" class="form-control four_decimal" placeholder="Legal Holiday Amount" value="<?php echo set_value('legal_holiday', $ppr->legal_holiday) ?>">
    		</div>
    		<span class="help-block">Rate per Legal Holiday</span>
        </div>

        <label class="col-sm-2 control-label">Legal Holiday O.T.</label>
    	<div class="form-group">
    		<div class="col-sm-6">
            <input type="text" name="legal_ot_holiday" class="form-control four_decimal" placeholder="Legal Holiday O.T. Amount" value="<?php echo set_value('legal_ot_holiday', $ppr->legal_ot_holiday) ?>">
    		</div>
    		<span class="help-block">Rate per Legal Holiday Over-time</span>
        </div>

	    <label class="col-sm-2 control-label">Special Holiday</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="special_holiday" class="form-control four_decimal" placeholder="Special Holiday Amount" value="<?php echo set_value('special_holiday', $ppr->special_holiday) ?>">
			</div>
			<span class="help-block">Rate per Special Holiday</span>
	    </div>

	    <label class="col-sm-2 control-label">Special Holiday O.T.</label>
		<div class="form-group">
			<div class="col-sm-6">
	        <input type="text" name="special_ot_holiday" class="form-control four_decimal" placeholder="Special Holiday O.T. Amount" value="<?php echo set_value('special_ot_holiday', $ppr->special_ot_holiday) ?>">
			</div>
			<span class="help-block">Rate per Special Holiday Over-time</span>
	    </div>


	    <hr>

	    <label class="col-sm-2 control-label">Lates</label>
	    <div class="form-group">
	        <div class="col-sm-6">
	        	<input type="text" name="late_amount" class="form-control four_decimal" placeholder="Late Rate Amount" value="<?php echo set_value('late_amount', abs($ppr->late_amount)) ?>">
	        </div>
	        <span class="help-block">Rate per Late</span>
	    </div>


	    <label class="col-sm-2 control-label">Absent Rate/Hour</label>
	    <div class="form-group">
	        <div class="col-sm-6">
	        	<input type="text" name="absent_rate" class="form-control four_decimal" placeholder="Absent Amount / Hour" value="<?php echo set_value('absent_rate', abs($ppr->absent_rate)) ?>">
	        </div>
	        <span class="help-block">Rate per Absent</span>
	    </div>

	    <label class="col-sm-2 control-label">Absent Rate/Day</label>
	    <div class="form-group">
	        <div class="col-sm-6">
	        	<input type="text" name="absent_rate_per_day" class="form-control four_decimal" placeholder="Absent Amount / Day" value="<?php echo set_value('absent_rate_per_day', abs($ppr->absent_rate_per_day)) ?>">
	        </div>
	        <span class="help-block">Rate per Absent</span>


	    </div>
	    <?php if ($this->uri->segment(3, 0) != 'new'): ?>
		    <hr>

		    <label class="col-sm-2 control-label">Select Billing Period to Update Rate</label>
		    <div class="form-group">
		        <div class="col-sm-6">
		        	<?php echo form_dropdown('project_bill_id', $billing_periods, $this->input->post('project_bill_id') ? $this->input->post('project_bill_id') : 0, 'id="positionId" class="form-control"' ) ?>
		        </div>
		        <span class="help-block">Choose billing period to be affected by this changes</span>
		    </div>
	    <?php endif ?>

	</div>

</div>

<div class="row">
	<div class="col-sm-10">
	
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-6">
	  <div class="btn-group">
		  <button type="submit" name="btnAdd" value="submit" class="btn btn-primary btn-lg"><strong>SAVE CHANGES</strong></button>
		  <a href="<?php echo site_url('project_employee/'. $project->project_id . '/detail')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

<!-- </div> -->