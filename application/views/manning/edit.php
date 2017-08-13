

<?php echo $form_url; ?>
<div class="container">
	

<div class="row">
	<div class="col-sm-10">

		<ul class="nav nav-tabs">
		  <li class="active"><a data-toggle="tab" href="#ei">Personal Information</a></li>
		  <li><a data-toggle="tab" href="#cd">Contract Details</a></li>
		  <li><a data-toggle="tab" href="#bin">Government ID Nos.</a></li>
		  <li><a data-toggle="tab" href="#sd">Salary Details</a></li>
		  <li><a data-toggle="tab" href="#req">Requirements Date Submission</a></li>
		  <!-- <li><a data-toggle="tab" href="#cases">Cases</a></li> -->

		</ul>

		<div class="tab-content">
		  <div id="ei" class="tab-pane fade in active">
		  	<h3>Personal Information</h3>

		  	

		    <label for="firstname" class="col-sm-2 control-label">Firstname</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" value="<?php echo set_value('firstname', $employee->firstname);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="middlename" class="col-sm-2 control-label">Middlename</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="middlename" id="middlename" class="form-control" placeholder="Middlename" value="<?php echo set_value('middlename', $employee->middlename);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="lastname" class="col-sm-2 control-label">Lastname</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname" value="<?php echo set_value('lastname', $employee->lastname);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Gender</label>
				<div class="col-sm-8">
					<label class="radio-inline">
					  <input type="radio" name="gender" id="inlineradio1" value="Male" <?php $employee->gender == 'Male' ? $check = TRUE : $check = FALSE; echo set_radio('gender', 'Male', $check);?> > Male
					</label>
					<label class="radio-inline">
					  <input type="radio" name="gender" id="inlineradio2" value="Female" <?php $employee->gender == 'Female' ? $check = TRUE : $check = FALSE; echo set_radio('gender', 'Female', $check);?> > Female
					</label>
					
				</div>
			</div>		
			<label for="date_of_birth" class="col-sm-2 control-label">Date of Birth</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="date_of_birth" id="date_of_birth" class="form-control" placeholder="Date of Birth" value="<?php echo set_value('date_of_birth', $employee->date_of_birth);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="age" class="col-sm-2 control-label">Age</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="age" id="age" class="form-control deci" placeholder="Age" value="<?php echo set_value('age', $employee->age);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="address1" class="col-sm-2 control-label">Address Line 1</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="address1" id="address1" class="form-control" placeholder="Address Line 1" value="<?php echo set_value('address1', $employee->address1);?>" autofocus>
				</div>
				<span class="help-block">Unit Number + House/Building/Street Number, Street Name</span>
			</div>

			<label for="addres2" class="col-sm-2 control-label">Address Line 2</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="address2" id="address2" class="form-control" placeholder="Address Line 2" value="<?php echo set_value('address2', $employee->address2);?>" autofocus>
				</div>
				<span class="help-block">Barangay/District Name, City/Municipality</span>
			</div>

			<label for="mobile_no" class="col-sm-2 control-label">Mobile No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Mobile No." value="<?php echo set_value('mobile_no', $employee->mobile_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="telephone_no" class="col-sm-2 control-label">Telephone No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="telephone_no" id="telephone_no" class="form-control" placeholder="Telephone No." value="<?php echo set_value('telephone_no', $employee->telephone_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="email" class="col-sm-2 control-label">Email</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo set_value('email', $employee->email);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>
			




			<label for="remarks" class="col-sm-2 control-label">Remarks</label>
			<div class="form-group">
				<div class="col-sm-6">			
					<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Remarks"><?php echo set_value('remarks', $employee->remarks);?></textarea>
				</div>
				<span class="help-block"></span>
			</div>

		  </div>
		  <div id="cd" class="tab-pane fade">
		    <h3>Contract Details</h3>
		    <label for="employee_no" class="col-sm-2 control-label">Employee No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="employee_no" id="employee_no" class="form-control" placeholder="Employee No." value="<?php echo set_value('employee_no', $employee->employee_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

		    <label for="project_id" class="col-sm-2 control-label">Project</label>
			 <div class="form-group">
			 	<div class="col-sm-6">
					<?php echo form_dropdown('project_id', $projects, $this->input->post('project_id') ? $this->input->post('project_id') : $employee->project_id, 'id="project_id" class="form-control"' ) ?>
		        </div>
		        <span class="help-block"></span>
	    	</div>

	    	<label for="position_id" class="col-sm-2 control-label">Position</label>
	    	<div class="form-group">
	    		<div class="col-sm-6">
				    <?php echo form_dropdown('position_id', $positions, $this->input->post('position_id') ? $this->input->post('position_id') : $employee->position_id, 'id="position_id" class="form-control"' ) ?>
		        </div>
		        <span class="help-block"></span>
	    	</div>

	    	<label for="position_id" class="col-sm-2 control-label">Employment Status</label>
	    	<div class="form-group">
	    		<div class="col-sm-6">
				    <?php echo form_dropdown('employment_status_id', $employment_statuses, $this->input->post('employment_status_id') ? $this->input->post('employment_status_id') : $employee->employment_status_id, 'id="employment_status_id" class="form-control"' ) ?>
		        </div>
		        <span class="help-block"></span>
	    	</div>

	    	<label for="length_of_service" class="col-sm-2 control-label">Length of Service</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="length_of_service" id="length_of_service" class="form-control deci" placeholder="Length_of Service" value="<?php echo set_value('length_of_service', $employee->length_of_service);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="date_hired" class="col-sm-2 control-label">Date Hired</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="date_hired" id="date_hired" class="form-control" placeholder="Date Hired" value="<?php echo set_value('date_hired', $employee->date_hired);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="date_resigned" class="col-sm-2 control-label">Date Resigned</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="date_resigned" id="date_resigned" class="form-control" placeholder="Date Resigned" value="<?php echo set_value('date_resigned', $employee->date_resigned);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="date_renew" class="col-sm-2 control-label">Date Renewed</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="date_renew" id="date_renew" class="form-control" placeholder="Date Renewed" value="<?php echo set_value('date_renew', $employee->date_renew);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="contract_expiry_date" class="col-sm-2 control-label">Contract Expiry Date</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="contract_expiry_date" id="contract_expiry_date" class="form-control" placeholder="Contract Expiry Date" value="<?php echo set_value('contract_expiry_date', $employee->contract_expiry_date);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="contract_remarks" class="col-sm-2 control-label">Contract Remarks</label>
			<div class="form-group">
				<div class="col-sm-6">			
					<textarea id="contract_remarks" name="contract_remarks" class="form-control" rows="3" placeholder="Contract Remarks"><?php echo set_value('contract_remarks', $employee->contract_remarks);?></textarea>
				</div>
				<span class="help-block"></span>
			</div>

		  </div>
		  <div id="bin" class="tab-pane fade">
		    <h3>Government ID Nos.</h3>
		    <label for="sss_no" class="col-sm-2 control-label">SSS No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="sss_no" id="sss_no" class="form-control" placeholder="SSS No." value="<?php echo set_value('sss_no', $employee->sss_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="philhealth_no" class="col-sm-2 control-label">PhilHealth No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="philhealth_no" id="philhealth_no" class="form-control" placeholder="PhilHealth No." value="<?php echo set_value('philhealth_no', $employee->philhealth_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			 <label for="pagibig_no" class="col-sm-2 control-label">PAGIBIG No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="pagibig_no" id="pagibig_no" class="form-control" placeholder="PAGIBIG No." value="<?php echo set_value('pagibig_no', $employee->pagibig_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="tin_no" class="col-sm-2 control-label">TIN No.</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="tin_no" id="tin_no" class="form-control" placeholder="TIN No." value="<?php echo set_value('tin_no', $employee->tin_no);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>
		  </div>
		  <div id="sd" class="tab-pane fade">
		    <h3>Salary Details</h3>
		    
		    <div class="form-group">
				<label class="col-sm-2 control-label">Rate Type</label>
				<div class="col-sm-8">
					<label class="radio-inline">
					  <input type="radio" name="rate" id="inlineradio1" value="1" <?php $employee->rate == '1' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '1', $check);?> > Hourly
					</label>
					<label class="radio-inline">
					  <input type="radio" name="rate" id="inlineradio2" value="2" <?php $employee->rate == '2' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '2', $check);?> > Semi-Monthly
					</label>
					<label class="radio-inline">
					  <input type="radio" name="rate" id="inlineradio2" value="3" <?php $employee->rate == '3' ? $check = TRUE : $check = FALSE; echo set_radio('rate', '3', $check);?> > Monthly
					</label>
				</div>
			</div>	
		    <label for="daily_rate" class="col-sm-2 control-label">Daily Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="daily_rate" id="daily_rate" class="form-control deci" placeholder="Daily Rate" value="<?php echo set_value('daily_rate', $employee->daily_rate);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="semi_monthly_rate" class="col-sm-2 control-label">Semi-Monthly Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="semi_monthly_rate" id="semi_monthly_rate" class="form-control deci" placeholder="Semi-Monthly Rate" value="<?php echo set_value('semi_monthly_rate', $employee->semi_monthly_rate);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="monthly_rate" class="col-sm-2 control-label">Monthly Rate</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="monthly_rate" id="monthly_rate" class="form-control deci" placeholder="Monthly Rate" value="<?php echo set_value('monthly_rate', $employee->monthly_rate);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="e_cola" class="col-sm-2 control-label">E-Cola</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="e_cola" id="e_cola" class="form-control deci" placeholder="E-Cola" value="<?php echo set_value('e_cola', $employee->e_cola);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="allowance" class="col-sm-2 control-label">Allowance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" name="allowance" id="allowance" class="form-control deci" placeholder="Allowance" value="<?php echo set_value('allowance', $employee->allowance);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Allowance Mode of Payment</label>
				<div class="col-sm-8">
					<label class="radio-inline">
					  <input type="radio" name="allowance_mode_of_payment" id="inlineradio1" value="1" <?php $employee->allowance_mode_of_payment == '1' ? $check = TRUE : $check = FALSE; echo set_radio('allowance_mode_of_payment', '1', $check);?> > Daily
					</label>
					<label class="radio-inline">
					  <input type="radio" name="allowance_mode_of_payment" id="inlineradio2" value="2" <?php $employee->allowance_mode_of_payment == '2' ? $check = TRUE : $check = FALSE; echo set_radio('allowance_mode_of_payment', '2', $check);?> > Semi-Monthly
					</label>
					<label class="radio-inline">
					  <input type="radio" name="allowance_mode_of_payment" id="inlineradio2" value="3" <?php $employee->allowance_mode_of_payment == '3' ? $check = TRUE : $check = FALSE; echo set_radio('allowance_mode_of_payment', '3', $check);?> > Monthly
					</label>
				</div>
			</div>	

			<label for="allowance_remarks" class="col-sm-2 control-label">Allowance Remarks</label>
			<div class="form-group">
				<div class="col-sm-6">			
					<textarea id="allowance_remarks" name="allowance_remarks" class="form-control" rows="3" placeholder="Allowance Remarks"><?php echo set_value('allowance_remarks', $employee->allowance_remarks);?></textarea>
				</div>
				<span class="help-block"></span>
			</div>
		  </div>
		  <div id="req" class="tab-pane fade">
		    <h3>Requirements Date Submission</h3>
		    <label for="date_hired" class="col-sm-2 control-label">NBI Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="nbi_clearance_date_submitted" id="nbi_clearance_date_submitted" class="form-control" placeholder="NBI Clearance" value="<?php echo set_value('nbi_clearance_date_submitted', $employee->nbi_clearance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="police_clearance_date_submitted" class="col-sm-2 control-label">Police Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="police_clearance_date_submitted" id="police_clearance_date_submitted" class="form-control" placeholder="Police Clearance" value="<?php echo set_value('police_clearance_date_submitted', $employee->police_clearance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="brgy_clearance_date_submitted" class="col-sm-2 control-label">Barangay Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="brgy_clearance_date_submitted" id="brgy_clearance_date_submitted" class="form-control" placeholder="Barangay Clearance" value="<?php echo set_value('brgy_clearance_date_submitted', $employee->brgy_clearance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="medical_clearance_date_submitted" class="col-sm-2 control-label">Health Certificate Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="medical_clearance_date_submitted" id="medical_clearance_date_submitted" class="form-control" placeholder="Medical Clearance" value="<?php echo set_value('medical_clearance_date_submitted', $employee->medical_clearance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			

			<label for="mayors_permit_clerance_date_submitted" class="col-sm-2 control-label">Mayor's Permit Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="mayors_permit_clerance_date_submitted" id="mayors_permit_clerance_date_submitted" class="form-control" placeholder="Mayor Permit Clearance" value="<?php echo set_value('mayors_permit_clerance_date_submitted', $employee->mayors_permit_clerance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="drugtest_clearance_date_submitted" class="col-sm-2 control-label">Drug Test Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="drugtest_clearance_date_submitted" id="drugtest_clearance_date_submitted" class="form-control" placeholder="Drug Test Clearance" value="<?php echo set_value('drugtest_clearance_date_submitted', $employee->drugtest_clearance_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="fit_to_work_date_submitted" class="col-sm-2 control-label">Fit to Work Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="fit_to_work_date_submitted" id="fit_to_work_date_submitted" class="form-control" placeholder="Fit to Work Clearance" value="<?php echo set_value('fit_to_work_date_submitted', $employee->fit_to_work_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="xray_date_submitted" class="col-sm-2 control-label">X-Ray Clearance</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="xray_date_submitted" id="xray_date_submitted" class="form-control" placeholder="X-Ray Clearance" value="<?php echo set_value('xray_date_submitted', $employee->xray_date_submitted);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>


			<label for="date_filed_up" class="col-sm-2 control-label">Date Filed</label>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="date" name="date_filed_up" id="date_filed_up" class="form-control" placeholder="Date Filed" value="<?php echo set_value('date_filed_up', $employee->date_filed_up);?>" autofocus>
				</div>
				<span class="help-block"></span>
			</div>

			<label for="insurance_remarks" class="col-sm-2 control-label">Insurance Remarks</label>
			<div class="form-group">
				<div class="col-sm-6">			
					<textarea id="insurance_remarks" name="insurance_remarks" class="form-control" rows="3" placeholder="Insurance Remarks"><?php echo set_value('insurance_remarks', $employee->insurance_remarks);?></textarea>
				</div>
				<span class="help-block"></span>
			</div>

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
		  <a href="<?php echo site_url('manning_list')?>" class="btn btn-default btn-lg">CANCEL</a>
	  </div>
	  </div>
	</div>

	</div>
</div>

<?php echo form_close(); ?>

</div>